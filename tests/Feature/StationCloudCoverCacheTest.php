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
        Http::assertSentCount(3);

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);
        Http::assertSentCount(3);
    }

    public function test_timeout_does_not_create_cache(): void
    {
        Station::factory()->create();
        Http::fake(Http::failedConnection('Open-Meteo timed out'));

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
        Http::assertSentCount(3);

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);
        Http::assertSentCount(3);

        $this->travel(61)->seconds();
        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);
        Http::assertSentCount(3);

        $this->travel(240)->seconds();
        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);
        Http::assertSentCount(6);
    }

    public function test_rate_limit_response_does_not_create_cache(): void
    {
        Station::factory()->create();
        Http::fake(fn () => Http::response(['error' => true], 429, ['Retry-After' => '120']));

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
        $this->assertTrue(Cache::has('stations_cloud_cover_cooldown'));
        Http::assertSentCount(3);

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);
        Http::assertSentCount(3);

        $this->travel(61)->seconds();
        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);
        Http::assertSentCount(3);

        $this->travel(240)->seconds();
        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);
        Http::assertSentCount(6);
    }

    public function test_retry_after_is_capped_at_fifteen_minutes(): void
    {
        Station::factory()->create();
        Http::fake(fn () => Http::response(['error' => true], 429, ['Retry-After' => '99999']));

        $this->getJson('/api/stations/cloud-cover')->assertOk();
        $this->travel(901)->seconds();
        $this->getJson('/api/stations/cloud-cover')->assertOk();

        Http::assertSentCount(6);
    }

    public function test_refresh_lock_contention_does_not_start_another_open_meteo_request(): void
    {
        Station::factory()->create();
        Http::fake();
        $lock = Cache::lock('stations_cloud_cover_refresh_lock', 360);
        $this->assertTrue($lock->get());

        try {
            $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);
            Http::assertNothingSent();
        } finally {
            $lock->release();
        }
    }

    public function test_partial_chunk_failure_does_not_cache_partial_results(): void
    {
        Station::factory()->count(51)->create();
        $requestCount = 0;
        Http::fake(function ($request) use (&$requestCount) {
            $requestCount++;

            if ($requestCount > 1) {
                return Http::response(['error' => true], 502);
            }

            return Http::response($this->locations(array_fill(0, 50, 37)), 200);
        });

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
        $this->assertSame(4, $requestCount);
    }

    public function test_transient_chunk_timeout_retries_and_success_does_not_create_cooldown(): void
    {
        $stations = [];
        for ($index = 0; $index < 51; $index++) {
            $stations[] = Station::factory()->create(['name' => sprintf('Station %03d', $index)]);
        }

        $requestCount = 0;
        Http::fake(function ($request) use (&$requestCount) {
            $requestCount++;

            if ($requestCount === 1) {
                return Http::response($this->locations(array_fill(0, 50, 37)), 200);
            }

            if ($requestCount === 2) {
                return Http::failedConnection('Temporary timeout')($request);
            }

            return Http::response(['current' => ['cloud_cover' => 0]], 200);
        });

        $this->getJson('/api/stations/cloud-cover')
            ->assertOk()
            ->assertJsonPath((string) $stations[50]->id, 0);

        $this->assertSame(3, $requestCount);
        $this->assertCount(51, Cache::get('stations_cloud_cover'));
        $this->assertFalse(Cache::has('stations_cloud_cover_cooldown'));
    }

    public function test_incomplete_or_invalid_response_does_not_create_cache(): void
    {
        Station::factory()->count(2)->create();
        Http::fake(fn () => Http::response($this->locations([12]), 200));

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
    }

    public function test_out_of_range_cloud_cover_does_not_create_cache(): void
    {
        Station::factory()->create();
        Http::fake(fn () => Http::response($this->locations([101]), 200));

        $this->getJson('/api/stations/cloud-cover')->assertOk()->assertExactJson([]);

        $this->assertFalse(Cache::has('stations_cloud_cover'));
    }

    public function test_coordinate_pairs_and_response_values_stay_mapped_to_station_ids(): void
    {
        $stationA = Station::factory()->create(['name' => 'Station A', 'latitude' => 0, 'longitude' => 103.2]);
        $stationB = Station::factory()->create(['name' => 'Station B', 'latitude' => -6.5, 'longitude' => 0]);
        Http::fake(fn () => Http::response($this->locations([0, 77]), 200));

        $this->getJson('/api/stations/cloud-cover')
            ->assertOk()
            ->assertJsonPath((string) $stationA->id, 0)
            ->assertJsonPath((string) $stationB->id, 77);

        Http::assertSent(function ($request): bool {
            parse_str((string) parse_url($request->url(), PHP_URL_QUERY), $query);

            return ($query['latitude'] ?? null) === '0,-6.5'
                && ($query['longitude'] ?? null) === '103.2,0';
        });
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
