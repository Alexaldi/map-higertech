<?php

namespace Tests\Feature;

use App\Models\Station;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_the_public_contract_and_excludes_incomplete_coordinates(): void
    {
        Station::factory()->create([
            'name' => 'PCH Bukit Raya',
            'slug' => 'pch-bukit-raya',
            'station_type' => 'ARR',
            'latitude' => -6.2,
            'longitude' => 106.8166667,
            'balai_name' => 'Balai Telemetri Barat',
            'organization_code' => 'BTN-BARAT',
            'province_name' => 'Jawa Barat',
            'regency_name' => null,
            'district_name' => null,
            'village_name' => null,
            'river_area_name' => null,
            'watershed_name' => null,
            'device_id' => 'ARR-DUMMY-001',
            'device_status' => 'online',
            'latest_reading' => null,
        ]);
        Station::factory()->create(['latitude' => null, 'organization_code' => 'BTN-BARAT']);
        Station::factory()->create(['longitude' => null, 'organization_code' => 'BTN-BARAT']);

        $response = $this->getJson('/api/stations')
            ->assertOk()
            ->assertJsonPath('meta.count', 1)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'PCH Bukit Raya')
            ->assertJsonPath('data.0.station_type', 'ARR')
            ->assertJsonPath('data.0.latitude', -6.2)
            ->assertJsonPath('data.0.longitude', 106.8166667)
            ->assertJsonPath('data.0.regency_name', null)
            ->assertJsonPath('data.0.device_id', 'DEVICE-***-001')
            ->assertJsonPath('data.0.latest_reading', null)
            ->assertJsonPath('meta.organizations.0.code', 'BTN-BARAT')
            ->assertJsonPath('meta.organizations.0.name', 'Balai Telemetri Barat');

        $this->assertEqualsCanonicalizing([
            'id',
            'name',
            'station_type',
            'latitude',
            'longitude',
            'balai_name',
            'province_name',
            'regency_name',
            'device_id',
            'device_status',
            'reading_at',
            'latest_reading',
        ], array_keys($response->json('data.0')));
    }

    public function test_search_is_case_insensitive_across_station_context_fields(): void
    {
        Station::factory()->create([
            'name' => 'PDA Arunika',
            'balai_name' => 'Balai Samudra',
            'organization_code' => 'BTN-SAMUDRA',
            'province_name' => 'Sulawesi Selatan',
            'regency_name' => 'Makassar',
            'district_name' => 'Panakkukang',
            'village_name' => 'Karampuang',
            'device_id' => 'DEVICE-UNIK-77',
        ]);
        Station::factory()->create([
            'name' => 'PCH Pembanding',
            'balai_name' => 'Balai Pembanding',
            'organization_code' => 'BTN-PEMBANDING',
            'province_name' => 'Jawa Tengah',
            'regency_name' => 'Semarang',
            'district_name' => 'Tembalang',
            'village_name' => 'Bulusan',
            'device_id' => 'DEVICE-PEMBANDING-01',
        ]);

        foreach (['arunika', 'SAMUDRA', 'sulawesi', 'MAKASSAR'] as $term) {
            $this->getJson('/api/stations?search='.urlencode($term))
                ->assertOk()
                ->assertJsonPath('meta.count', 1)
                ->assertJsonPath('data.0.name', 'PDA Arunika');
        }

        foreach (['panakkukang', 'KARAMPUANG', 'unik-77'] as $privateTerm) {
            $this->getJson('/api/stations?search='.urlencode($privateTerm))
                ->assertOk()
                ->assertJsonPath('meta.count', 0);
        }
    }

    public function test_type_filter_distinguishes_exact_primary_types_and_other(): void
    {
        Station::factory()->create(['name' => 'ARR Satu', 'station_type' => 'ARR']);
        Station::factory()->create(['name' => 'Gabungan Satu', 'station_type' => 'AWLR_ARR']);
        Station::factory()->create(['name' => 'Flow Satu', 'station_type' => 'FM']);

        $this->getJson('/api/stations?type=ARR')
            ->assertOk()
            ->assertJsonPath('meta.count', 1)
            ->assertJsonPath('data.0.name', 'ARR Satu');

        $this->getJson('/api/stations?type=AWLR_ARR')
            ->assertOk()
            ->assertJsonPath('meta.count', 1)
            ->assertJsonPath('data.0.name', 'Gabungan Satu');

        $this->getJson('/api/stations?type=OTHER')
            ->assertOk()
            ->assertJsonPath('meta.count', 1)
            ->assertJsonPath('data.0.name', 'Flow Satu');
    }

    public function test_status_and_organization_filters_can_be_combined(): void
    {
        Station::factory()->create([
            'name' => 'Target Online',
            'device_status' => 'online',
            'organization_code' => 'BTN-TARGET',
        ]);
        Station::factory()->create([
            'name' => 'Target Offline',
            'device_status' => 'offline',
            'organization_code' => 'BTN-TARGET',
        ]);
        Station::factory()->create([
            'name' => 'Organisasi Lain',
            'device_status' => 'online',
            'organization_code' => 'BTN-LAIN',
        ]);

        $this->getJson('/api/stations?status=online&organization=BTN-TARGET')
            ->assertOk()
            ->assertJsonPath('meta.count', 1)
            ->assertJsonPath('data.0.name', 'Target Online');
    }

    public function test_results_are_alphabetical_and_unknown_filters_are_ignored(): void
    {
        Station::factory()->create(['name' => 'Zulu Station']);
        Station::factory()->create(['name' => 'Alpha Station']);

        $this->getJson('/api/stations?type=UNKNOWN&status=UNKNOWN')
            ->assertOk()
            ->assertJsonPath('meta.count', 2)
            ->assertJsonPath('data.0.name', 'Alpha Station')
            ->assertJsonPath('data.1.name', 'Zulu Station');
    }

    public function test_station_endpoints_are_rate_limited_per_client(): void
    {
        for ($attempt = 1; $attempt <= 60; $attempt++) {
            $this->getJson('/api/stations')->assertOk();
        }

        $this->getJson('/api/stations')->assertTooManyRequests();
    }
}
