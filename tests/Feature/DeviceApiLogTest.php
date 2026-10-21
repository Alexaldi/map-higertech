<?php

namespace Tests\Feature;

use App\Models\DeviceApiLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DeviceApiLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_forwarder_creates_device_api_log_on_successful_request(): void
    {
        Http::fake([
            'http://hkabbwscitarum.higertech.com/api/device/store*' => Http::response([
                'status'  => 'success',
                'message' => 'Sensor reading saved',
            ], 200, ['Content-Type' => 'application/json']),
        ]);

        $response = $this->get('/hkabbwscitarum/api/device/store?ch=15.2&batt=12.4&tma=1.85');

        $response->assertStatus(200);

        $this->assertDatabaseHas('device_api_logs', [
            'sub_domain'  => 'hkabbwscitarum',
            'endpoint'    => '/api/device/store',
            'method'      => 'GET',
            'status'      => 'success',
            'status_code' => 200,
        ]);

        $log = DeviceApiLog::where('sub_domain', 'hkabbwscitarum')->first();
        $this->assertNotNull($log);
        $this->assertEquals('15.2', $log->payload['ch'] ?? null);
        $this->assertEquals('12.4', $log->payload['batt'] ?? null);
        $this->assertEquals('1.85', $log->payload['tma'] ?? null);
        $this->assertNotNull($log->duration_ms);
    }

    public function test_forwarder_creates_device_api_log_on_upstream_failure(): void
    {
        Http::fake([
            'http://hkabbwscitarum.higertech.com/api/device/store*' => function () {
                throw new \Exception('Connection to balai server timed out');
            },
        ]);

        $response = $this->get('/hkabbwscitarum/api/device/store?ch=20');

        $response->assertStatus(500);

        $this->assertDatabaseHas('device_api_logs', [
            'sub_domain'  => 'hkabbwscitarum',
            'status'      => 'failed',
            'status_code' => 500,
        ]);

        $log = DeviceApiLog::where('sub_domain', 'hkabbwscitarum')->first();
        $this->assertNotNull($log);
        $this->assertStringContainsString('Connection to balai server timed out', $log->response_body);
    }

    public function test_admin_can_view_device_api_logs_dashboard(): void
    {
        $admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@higertech.test',
            'password' => bcrypt('password'),
        ]);

        DeviceApiLog::create([
            'sub_domain'    => 'hkabbwscitarum',
            'endpoint'      => '/api/device/store',
            'method'        => 'GET',
            'payload'       => ['ch' => 10, 'batt' => 12.1],
            'ip_address'    => '127.0.0.1',
            'status_code'   => 200,
            'status'        => 'success',
            'response_body' => 'OK',
            'duration_ms'   => 120,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.device-logs.index'));

        $response->assertStatus(200);
        $response->assertSee('hkabbwscitarum');
        $response->assertSee('Log API Device');
        $response->assertSee('200 OK');
    }

    public function test_admin_can_delete_single_log_and_clear_all_logs(): void
    {
        $admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@higertech.test',
            'password' => bcrypt('password'),
        ]);

        $log1 = DeviceApiLog::create([
            'sub_domain'    => 'hkabbwscitarum',
            'status_code'   => 200,
            'status'        => 'success',
        ]);

        $log2 = DeviceApiLog::create([
            'sub_domain'    => 'bengawansolo',
            'status_code'   => 400,
            'status'        => 'failed',
        ]);

        $this->assertDatabaseCount('device_api_logs', 2);

        // Hapus single log
        $response = $this->actingAs($admin)->delete(route('admin.device-logs.destroy', $log1->id));
        $response->assertRedirect(route('admin.device-logs.index'));
        $this->assertDatabaseMissing('device_api_logs', ['id' => $log1->id]);
        $this->assertDatabaseCount('device_api_logs', 1);

        // Kosongkan semua log
        $responseClear = $this->actingAs($admin)->delete(route('admin.device-logs.clear'));
        $responseClear->assertRedirect(route('admin.device-logs.index'));
        $this->assertDatabaseCount('device_api_logs', 0);
    }
}
