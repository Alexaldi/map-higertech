<?php

namespace Tests\Feature;

use App\Models\Station;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class StationCloudCoverCacheTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_open_meteo_response_is_cached_for_7200_seconds(): void
    {
        $stations = collect([
            Station::factory()->create(['name' => 'Station A']),
            Station::factory()->create(['name' => 'Station B']),
        ]);
        Http::fake(fn () => Http::response($this->locations([42, 68]), 200));

        $response = $this->getJson('/api/stations/cloud-cover')->assertOk();
        $response->assertJsonPath((string) $stations[0]->id, 42);
        $response->assertJsonPath((string) $stations[1]->id, 68);
        $this->assertSame(42, Cache::get('stations_cloud_cover')[$stations[0]->id]);
        Http::assertSentCount(1);

        $this->getJson('/api/stations/cloud-cover')->assertOk();
        Http::assertSentCount(1);

        $this->travel(7199)->seconds();
        $this->getJson('/api/stations/cloud-cover')->assertOk();
        Http::assertSentCount(1);

        $this->travel(2)->seconds();
        $this->getJson('/api/stations/cloud-cover')->assertOk();
        Http::assertSentCount(2);
    }

    public function test_http_failure_returns_empty_cloud_cover_without_caching_while_station_endpoint_is_independent(): void
    {
        Station::factory()->create(['name' => 'Station One']);
        Http::fake(fn () => Http::response(['error' => true], 503));

        $this->getJson('/api/stations')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Station One')
            ->assertJsonMissingPath('data.0.cloud_cover');

        Http::assertNothingSent();

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
        Http::assertSentCount(1);
    }

    public function test_timeout_does_not_create_cache(): void
    {
        Station::factory()->create();
        Http::fake(Http::failedConnection('Open-Meteo timed out'));

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
        Http::assertSentCount(1);
    }

    public function test_rate_limit_response_does_not_create_cache(): void
    {
        Station::factory()->create();
        Http::fake(fn () => Http::response(['error' => true], 429));

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
        Http::assertSentCount(1);
    }

    public function test_partial_chunk_failure_does_not_cache_partial_results(): void
    {
        Station::factory()->count(51)->create();
        $requestCount = 0;
        Http::fake(function ($request) use (&$requestCount) {
            $requestCount++;

            if ($requestCount === 2) {
                return Http::response(['error' => true], 502);
            }

            return Http::response($this->locations(array_fill(0, 50, 37)), 200);
        });

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
        $this->assertSame(2, $requestCount);
    }

    public function test_incomplete_or_invalid_response_does_not_create_cache(): void
    {
        Station::factory()->count(2)->create();
        Http::fake(fn () => Http::response($this->locations([12]), 200));

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
    }

    public function test_invalid_json_response_does_not_create_cache(): void
    {
        Station::factory()->create();
        Http::fake(fn () => Http::response('not-json', 200));

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
    }

    public function test_valid_zero_cloud_cover_is_cached_and_returned(): void
    {
        $station = Station::factory()->create();
        Http::fake(fn () => Http::response(['current' => ['cloud_cover' => 0]], 200));

        $this->getJson('/api/stations/cloud-cover')
            ->assertOk()
            ->assertJsonPath((string) $station->id, 0);

        $this->assertSame(0, Cache::get('stations_cloud_cover')[$station->id]);
    }

    public function test_valid_existing_cache_is_preserved_and_used_without_refresh(): void
    {
        $station = Station::factory()->create();
        Cache::put('stations_cloud_cover', [$station->id => 54], 7200);
        Http::fake();

        $this->getJson('/api/stations/cloud-cover')
            ->assertOk()
            ->assertJsonPath((string) $station->id, 54);

        $this->assertSame([$station->id => 54], Cache::get('stations_cloud_cover'));
        Http::assertNothingSent();
    }

    /** @param array<int, int> $values
     *  @return array<int, array{current: array{cloud_cover: int}}> */
    private function locations(array $values): array
    {
        return array_map(fn (int $value): array => ['current' => ['cloud_cover' => $value]], $values);
    }
}
