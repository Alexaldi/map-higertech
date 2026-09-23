<?php

namespace Tests\Feature;

use App\Models\Station;
use Carbon\Carbon;
use Database\Seeders\StationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StationDatasetTest extends TestCase
{
    use RefreshDatabase;

    public function test_station_casts_coordinates_reading_time_and_telemetry(): void
    {
        $station = new Station;
        $station->setRawAttributes([
            'latitude' => '-6.2000000',
            'longitude' => '106.8166667',
            'reading_at' => '2026-08-20 12:00:00',
            'latest_reading' => '{"rainfall":0}',
        ]);

        $this->assertIsFloat($station->latitude);
        $this->assertIsFloat($station->longitude);
        $this->assertInstanceOf(Carbon::class, $station->reading_at);
        $this->assertSame(['rainfall' => 0], $station->latest_reading);
    }

    public function test_station_seeder_creates_two_hundred_records_covering_every_type(): void
    {
        $this->seed(StationSeeder::class);

        $this->assertDatabaseCount('stations', 200);
        $this->assertSame(
            ['AGWLR', 'ARR', 'AVWR', 'AWLR', 'AWLR_ARR', 'AWS', 'EWS', 'FM', 'OSP', 'OW', 'VNOTCH', 'WQ'],
            Station::query()->distinct()->orderBy('station_type')->pluck('station_type')->all(),
        );
        $this->assertSame(0, Station::query()->whereNull('latitude')->orWhereNull('longitude')->count());
        $this->assertGreaterThan(1, Station::query()->distinct()->count('organization_code'));
        $this->assertTrue(Station::query()->where('device_status', 'online')->exists());
        $this->assertTrue(Station::query()->whereNull('latest_reading')->exists());
    }
}
