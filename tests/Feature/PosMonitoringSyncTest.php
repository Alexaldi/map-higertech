<?php

namespace Tests\Feature;

use App\Models\Station;
use App\Services\PosMonitoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PosMonitoringSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_pos_monitoring_service_syncs_stations_correctly(): void
    {
        Http::fake([
            '*/LastReading/all' => Http::response([
                'data' => [
                    [
                        'id' => '11111111-2222-3333-4444-555555555555',
                        'deviceId' => 'HGT-TEST-001',
                        'name' => 'Stasiun Pos Citarum Hulu',
                        'slug' => 'stasiun-pos-citarum-hulu',
                        'stationType' => 'AWLR',
                        'latitude' => -6.9175,
                        'longitude' => 107.6191,
                        'balaiName' => 'BBWS Citarum',
                        'organizationCode' => 'ORG-CITARUM',
                        'provinceName' => 'JAWA BARAT',
                        'regencyName' => 'BANDUNG',
                        'deviceStatus' => 'Online',
                        'timeZone' => 'WIB',
                        'awlrLastReading' => [
                            'deviceId' => 'HGT-TEST-001',
                            'readingAt' => '2026-09-23T11:00:00Z',
                            'waterLevel' => 4.25,
                            'warningStatus' => 'Normal',
                        ],
                    ],
                    [
                        'id' => '22222222-3333-4444-5555-666666666666',
                        'deviceId' => 'HGT-TEST-002',
                        'name' => 'Stasiun Curah Hujan Bogor',
                        'slug' => 'stasiun-curah-hujan-bogor',
                        'stationType' => 'ARR',
                        'latitude' => -6.5971,
                        'longitude' => 106.8060,
                        'balaiName' => 'BBWS Ciliwung Cisadane',
                        'organizationCode' => 'ORG-CILICIS',
                        'provinceName' => 'JAWA BARAT',
                        'regencyName' => 'BOGOR',
                        'deviceStatus' => true,
                        'timeZone' => 'WIB',
                        'arrLastReading' => [
                            'deviceId' => 'HGT-TEST-002',
                            'readingAt' => '2026-09-23T11:00:00Z',
                            'rainfall' => 12.5,
                            'rainfallLastHour' => 4.2,
                            'intensity' => 'Hujan Sedang',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $service = app(PosMonitoringService::class);
        $result = $service->syncAll();

        $this->assertSame(2, $result['total']);
        $this->assertSame(2, $result['created']);
        $this->assertSame(0, $result['failed']);
        $this->assertDatabaseCount('stations', 2);

        $station = Station::where('device_id', 'HGT-TEST-001')->firstOrFail();
        $this->assertSame('Stasiun Pos Citarum Hulu', $station->name);
        $this->assertSame('AWLR', $station->station_type);
        $this->assertSame('online', $station->device_status);
        $this->assertSame('BBWS Citarum', $station->balai_name);
        $this->assertEquals(-6.9175, $station->latitude);
        $this->assertEquals(107.6191, $station->longitude);
        $this->assertSame(4.25, $station->latest_reading['water_level']);
        $this->assertSame('Normal', $station->latest_reading['warning_status']);
    }

    public function test_artisan_stations_sync_command_executes_successfully(): void
    {
        Http::fake([
            '*/LastReading/all' => Http::response(['data' => []], 200),
        ]);

        $this->artisan('stations:sync')
            ->expectsOutputToContain('Memulai sinkronisasi stasiun dari Pos Monitoring API')
            ->expectsOutputToContain('Sinkronisasi stasiun selesai dengan sukses!')
            ->assertExitCode(0);
    }
}

