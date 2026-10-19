<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DeviceStoreForwarderTest extends TestCase
{
    public function test_successfully_forwards_device_telemetry_reading(): void
    {
        Http::fake([
            'http://hkabbwscitarum.higertech.com/api/device/store*' => Http::response([
                'status'  => 'success',
                'message' => 'Data recorded',
            ], 200, ['Content-Type' => 'application/json']),
        ]);

        $response = $this->get('/hkabbwscitarum/api/device/store?ch=12.5&tma=1.85&batt=12.4');

        $response->assertStatus(200);
        $this->assertStringContainsString('Data recorded', $response->getContent());

        Http::assertSent(function ($request) {
            return str_starts_with($request->url(), 'http://hkabbwscitarum.higertech.com/api/device/store')
                && $request['ch'] === '12.5'
                && $request['tma'] === '1.85'
                && $request['batt'] === '12.4';
        });
    }

    public function test_rejects_invalid_subdomain_format(): void
    {
        $response = $this->get('/sub%20domain%20evil/api/device/store');

        $response->assertStatus(404); // Route regex constraint prevents matching
    }

    public function test_handles_upstream_server_failure_gracefully(): void
    {
        Http::fake([
            'http://hkabbwscitarum.higertech.com/api/device/store*' => function () {
                throw new \Exception('Connection to balai server timed out');
            },
        ]);

        $response = $this->get('/hkabbwscitarum/api/device/store?ch=10');

        $response->assertStatus(500);
        $response->assertJson([
            'error' => 'Connection to balai server timed out',
        ]);
    }
}

