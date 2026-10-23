<?php

namespace Tests\Feature;

use App\Models\DeviceApiLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceApiLogRecapTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@higertech.test',
            'password' => bcrypt('password'),
        ]);

        // 23 Okt 2026 (WIB): HGT144 = 2 berhasil + 1 gagal 500, HGT32 = 1 gagal 400
        $this->log('HGT144', 'hkabbwscitarum', 200, '2026-10-23 08:00:00');
        $this->log('HGT144', 'hkabbwscitarum', 200, '2026-10-23 09:00:00');
        $this->log('HGT144', 'hkabbwscitarum', 500, '2026-10-23 10:00:00');
        $this->log('HGT32', 'bwssumatera4', 400, '2026-10-23 11:00:00');

        // 01:00 WIB tanggal 23 = 18:00 UTC tanggal 22, harus ikut rekap tanggal 23
        $this->log('HGT144', 'hkabbwscitarum', 200, '2026-10-23 01:00:00');

        // Hari lain, tidak boleh ikut rekap tanggal 23
        $this->log('HGT144', 'hkabbwscitarum', 200, '2026-10-22 12:00:00');
    }

    private function log(string $deviceId, string $subDomain, int $statusCode, string $wibTime): void
    {
        $log = new DeviceApiLog([
            'sub_domain'  => $subDomain,
            'payload'     => ['id' => $deviceId, 'rain' => '0.00'],
            'status_code' => $statusCode,
            'status'      => $statusCode < 400 ? 'success' : 'failed',
        ]);
        $log->created_at = Carbon::parse($wibTime, 'Asia/Jakarta')->timezone(config('app.timezone'));
        $log->save();
    }

    public function test_recap_groups_logs_per_device_per_wib_day(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.device-logs.recap', [
            'from' => '2026-10-23',
            'to'   => '2026-10-23',
            'sort' => 'device',
        ]));

        $response->assertOk();

        $rows = collect($response->viewData('rows')->items())->keyBy('device_id');
        $this->assertCount(2, $rows);

        $this->assertSame('2026-10-23', $rows['HGT144']->recap_date);
        $this->assertSame(4, (int) $rows['HGT144']->total);
        $this->assertSame(3, (int) $rows['HGT144']->success);
        $this->assertSame(1, (int) $rows['HGT144']->failed);

        $this->assertSame(1, (int) $rows['HGT32']->total);
        $this->assertSame(1, (int) $rows['HGT32']->failed);

        $summary = $response->viewData('summary');
        $this->assertSame(2, $summary['devices']);
        $this->assertSame(5, $summary['total']);
        $this->assertSame(3, $summary['success']);
        $this->assertSame(2, $summary['failed']);

        $breakdown = $response->viewData('breakdown');
        $this->assertSame([500 => 1], $breakdown['2026-10-23|HGT144|hkabbwscitarum']);
        $this->assertSame([400 => 1], $breakdown['2026-10-23|HGT32|bwssumatera4']);

        $response->assertSee('Rekap Laporan per Alat');
        $response->assertSee('500: 1');
    }

    public function test_recap_splits_rows_per_day_for_date_range(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.device-logs.recap', [
            'from' => '2026-10-22',
            'to'   => '2026-10-23',
            'q'    => 'HGT144',
        ]));

        $rows = collect($response->viewData('rows')->items());

        $this->assertSame(['2026-10-23', '2026-10-22'], $rows->pluck('recap_date')->all());
        $this->assertSame([4, 1], $rows->pluck('total')->map(fn ($v) => (int) $v)->all());
        $this->assertSame(1, $response->viewData('summary')['devices']);
    }

    public function test_recap_defaults_to_today_and_clamps_long_ranges(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.device-logs.recap'));
        $today = now('Asia/Jakarta')->toDateString();
        $this->assertSame($today, $response->viewData('filters')['from']);
        $this->assertSame($today, $response->viewData('filters')['to']);

        $response = $this->actingAs($this->admin)->get(route('admin.device-logs.recap', [
            'from' => '2026-01-01',
            'to'   => '2026-12-31',
        ]));
        $this->assertSame('2026-01-31', $response->viewData('filters')['to']);
        $this->assertTrue($response->viewData('filters')['clamped']);
    }

    public function test_admin_can_export_recap_to_csv_and_pdf(): void
    {
        $params = ['from' => '2026-10-23', 'to' => '2026-10-23', 'sort' => 'device'];

        $csv = $this->actingAs($this->admin)->get(route('admin.device-logs.recap.export.csv', $params));
        $csv->assertOk();
        $this->assertStringContainsString('rekap-log-api-telemetri_2026-10-23.csv', $csv->headers->get('Content-Disposition'));

        $content = $csv->streamedContent();
        $this->assertStringContainsString('2026-10-23,HGT144,hkabbwscitarum,4,3,1,"500: 1",75.0', $content);
        $this->assertStringContainsString('2026-10-23,HGT32,bwssumatera4,1,0,1,"400: 1",0.0', $content);
        $this->assertStringContainsString(',TOTAL,"2 alat",,5,3,2,,60.0', $content);

        $pdf = $this->actingAs($this->admin)->get(route('admin.device-logs.recap.export.pdf', $params));
        $pdf->assertOk();
        $this->assertSame('application/pdf', $pdf->headers->get('Content-Type'));
        $this->assertStringStartsWith('%PDF', $pdf->getContent());
    }

    public function test_recap_pdf_mentions_when_rows_are_truncated(): void
    {
        $recap = app(\App\Services\Admin\DeviceLogRecapService::class);
        $filters = $recap->filters(['from' => '2026-10-23', 'to' => '2026-10-23', 'sort' => 'device']);
        $rows = $recap->recapQuery($filters)->limit(1)->get();

        $html = view('pdf.device-api-log-recap', [
            'rows'        => $rows,
            'totalRows'   => 2,
            'breakdown'   => [],
            'summary'     => $recap->summary($filters),
            'filters'     => $filters,
            'recap'       => $recap,
            'logoBase64'  => null,
            'generatedAt' => now('Asia/Jakarta'),
        ])->render();

        $this->assertStringContainsString('Menampilkan 1 dari 2 baris rekap', $html);
        $this->assertStringContainsString('TOTAL SELURUH DATA', $html);

        $fullHtml = view('pdf.device-api-log-recap', [
            'rows'        => $recap->recapQuery($filters)->get(),
            'totalRows'   => 2,
            'breakdown'   => [],
            'summary'     => $recap->summary($filters),
            'filters'     => $filters,
            'recap'       => $recap,
            'logoBase64'  => null,
            'generatedAt' => now('Asia/Jakarta'),
        ])->render();

        $this->assertStringNotContainsString('baris rekap. Baris TOTAL', $fullHtml);
    }

    public function test_recap_requires_authentication(): void
    {
        $this->get(route('admin.device-logs.recap'))->assertRedirect();
        $this->get(route('admin.device-logs.recap.export.csv'))->assertRedirect();
        $this->get(route('admin.device-logs.recap.export.pdf'))->assertRedirect();
    }
}
