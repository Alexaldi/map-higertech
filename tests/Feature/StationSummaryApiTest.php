<?php

namespace Tests\Feature;

use App\Models\Station;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StationSummaryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_summary_returns_global_status_organization_and_type_counts(): void
    {
        $fixtures = [
            ['station_type' => 'ARR', 'device_status' => 'online', 'organization_code' => 'ORG-A'],
            ['station_type' => 'ARR', 'device_status' => 'offline', 'organization_code' => 'ORG-A'],
            ['station_type' => 'AWLR', 'device_status' => 'online', 'organization_code' => 'ORG-B'],
            ['station_type' => 'AWS', 'device_status' => 'online', 'organization_code' => 'ORG-B'],
            ['station_type' => 'AWLR_ARR', 'device_status' => 'offline', 'organization_code' => 'ORG-C'],
            ['station_type' => 'FM', 'device_status' => 'online', 'organization_code' => 'ORG-C'],
            ['station_type' => 'WQ', 'device_status' => 'online', 'organization_code' => 'ORG-C'],
        ];

        foreach ($fixtures as $fixture) {
            Station::factory()->create($fixture);
        }

        $this->getJson('/api/stations/summary')
            ->assertOk()
            ->assertExactJson([
                'total' => 7,
                'online' => 5,
                'offline' => 2,
                'organizations' => 3,
                'types' => [
                    'ARR' => 2,
                    'AWLR' => 1,
                    'AWS' => 1,
                    'AWLR_ARR' => 1,
                    'AGWLR' => 0,
                    'FM' => 1,
                    'EWS' => 0,
                    'AVWR' => 0,
                    'WQ' => 1,
                    'VNOTCH' => 0,
                    'OW' => 0,
                    'OSP' => 0,
                ],
            ]);
    }
}
