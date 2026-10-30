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

    public function test_admin_can_export_filtered_logs_to_csv(): void
    {
        $admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@higertech.test',
            'password' => bcrypt('password'),
        ]);

        DeviceApiLog::create([
            'sub_domain'  => 'hkabbwscitarum',
            'payload'     => ['id' => 'HGT144', 'rain' => '0.00'],
            'ip_address'  => '114.122.102.65',
            'status_code' => 200,
            'status'      => 'success',
            'duration_ms' => 49,
        ]);

        DeviceApiLog::create([
            'sub_domain'    => 'bwssumatera4',
            'payload'       => ['id' => 'HGT32'],
            'status_code'   => 500,
            'status'        => 'failed',
            'response_body' => '=HYPERLINK("http://evil.test")',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.device-logs.export.csv', ['status' => 'success']));

        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment; filename=log-api-telemetri_', $response->headers->get('Content-Disposition'));

        $csv = $response->streamedContent();
        $this->assertStringStartsWith("\xEF\xBB\xBF", $csv);
        $this->assertStringContainsString('hkabbwscitarum', $csv);
        $this->assertStringContainsString('HGT144', $csv);
        $this->assertStringNotContainsString('bwssumatera4', $csv);

        // Respon berbahaya tidak boleh dieksekusi sebagai formula di Excel
        $allCsv = $this->actingAs($admin)->get(route('admin.device-logs.export.csv'))->streamedContent();
        $this->assertStringContainsString("'=HYPERLINK", $allCsv);
    }

    public function test_csv_export_is_a_snapshot_without_duplicates(): void
    {
        $admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@higertech.test',
            'password' => bcrypt('password'),
        ]);

        foreach (range(1, 1205) as $i) {
            DeviceApiLog::create([
                'sub_domain'  => 'hkabbwscitarum',
                'payload'     => ['id' => 'HGT' . $i],
                'status_code' => 200,
                'status'      => 'success',
            ]);
        }

        $response = $this->actingAs($admin)->get(route('admin.device-logs.export.csv'));

        // Log baru yang masuk setelah ekspor dimulai tidak boleh ikut / menggeser hasil
        DeviceApiLog::create([
            'sub_domain'  => 'masuk-saat-ekspor',
            'payload'     => ['id' => 'HGT9999'],
            'status_code' => 200,
            'status'      => 'success',
        ]);

        $lines = array_values(array_filter(explode("\n", trim($response->streamedContent()))));
        $dataLines = array_slice($lines, 1);

        $this->assertCount(1205, $dataLines);
        $this->assertCount(1205, array_unique(array_map(fn ($line) => explode(',', $line)[4], $dataLines)));
        $this->assertStringNotContainsString('masuk-saat-ekspor', implode("\n", $lines));
        $this->assertSame('HGT1205', explode(',', $dataLines[0])[4]);
    }

    public function test_export_is_rate_limited_per_admin(): void
    {
        $admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@higertech.test',
            'password' => bcrypt('password'),
        ]);

        DeviceApiLog::create([
            'sub_domain'  => 'hkabbwscitarum',
            'status_code' => 200,
            'status'      => 'success',
        ]);

        foreach (range(1, 5) as $i) {
            $this->actingAs($admin)->get(route('admin.device-logs.export.csv'))->assertOk();
        }

        $this->actingAs($admin)
            ->from(route('admin.device-logs.index'))
            ->get(route('admin.device-logs.recap.export.csv'))
            ->assertRedirect(route('admin.device-logs.index'))
            ->assertSessionHas('error', fn ($message) => str_contains($message, 'Terlalu banyak permintaan ekspor'));
    }

    public function test_admin_can_export_logs_to_pdf(): void
    {
        $admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@higertech.test',
            'password' => bcrypt('password'),
        ]);

        DeviceApiLog::create([
            'sub_domain'  => 'hkabbwscitarum',
            'payload'     => ['id' => 'HGT144', 'rain' => '0.00'],
            'status_code' => 200,
            'status'      => 'success',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.device-logs.export.pdf', [
            'from' => '2026-01-01',
            'to'   => '2026-12-31',
        ]));

        $response->assertOk();
        $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('log-api-telemetri_2026-01-01_sd_2026-12-31.pdf', $response->headers->get('Content-Disposition'));
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function test_export_requires_authentication(): void
    {
        $this->get(route('admin.device-logs.export.csv'))->assertRedirect();
        $this->get(route('admin.device-logs.export.pdf'))->assertRedirect();
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

    public function test_admin_dashboard_shows_subdomain_stats_and_total_device_counts(): void
    {
        $admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@higertech.test',
            'password' => bcrypt('password'),
        ]);

        DeviceApiLog::create([
            'sub_domain'  => 'hkabbwscitarum',
            'payload'     => ['id' => 'HGT101'],
            'status_code' => 200,
            'status'      => 'success',
        ]);

        DeviceApiLog::create([
            'sub_domain'  => 'hkabbwscitarum',
            'payload'     => ['id' => 'HGT102'],
            'status_code' => 500,
            'status'      => 'failed',
        ]);

        DeviceApiLog::create([
            'sub_domain'  => 'hkabwspapuabarat',
            'payload'     => ['id' => 'HGT103'],
            'status_code' => 200,
            'status'      => 'success',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.device-logs.index'));

        $response->assertOk();
        $response->assertSee('Statistik Per Subdomain Balai');
        $response->assertSee('Total ID Terdaftar');
        $response->assertSee('hkabbwscitarum');
        $response->assertSee('hkabwspapuabarat');
    }

    public function test_search_device_by_partial_or_case_insensitive_keyword(): void
    {
        $admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@higertech.test',
            'password' => bcrypt('password'),
        ]);

        // Alat yang dicari (ID HGT177, IP tidak ada 177)
        DeviceApiLog::create([
            'sub_domain'  => 'hkabbwscitarum',
            'payload'     => ['id' => 'HGT177', 'rain' => 0.0],
            'ip_address'  => '10.0.0.1',
            'status_code' => 200,
            'status'      => 'success',
        ]);

        // Alat lain yang kebetulan IP-nya ada 177
        DeviceApiLog::create([
            'sub_domain'  => 'hkabwsmalut',
            'payload'     => ['id' => 'HGT111', 'rain' => 0.0],
            'ip_address'  => '182.1.177.55',
            'status_code' => 200,
            'status'      => 'success',
        ]);

        // 1. Pencarian 'Hgt177' (huruf kecil dari HP) harus menemukan HGT177
        $res1 = $this->actingAs($admin)->get(route('admin.device-logs.index', ['q' => 'Hgt177']));
        $res1->assertOk();
        $res1->assertSee('HGT177');
        $res1->assertDontSee('HGT111');

        // 2. Pencarian angka '177' harus menemukan HGT177 dan TIDAK mencocokkan IP HGT111
        $res2 = $this->actingAs($admin)->get(route('admin.device-logs.index', ['q' => '177']));
        $res2->assertOk();
        $res2->assertSee('HGT177');
        $res2->assertDontSee('HGT111');

        // 3. Pencarian IP dengan titik '177.55' harus menemukan log berdasarkan IP
        $res3 = $this->actingAs($admin)->get(route('admin.device-logs.index', ['q' => '177.55']));
        $res3->assertOk();
        $res3->assertSee('HGT111');
        $res3->assertDontSee('HGT177');
    }
}
