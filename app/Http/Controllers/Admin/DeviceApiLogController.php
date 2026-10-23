<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesExports;
use App\Http\Controllers\Controller;
use App\Models\DeviceApiLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DeviceApiLogController extends Controller
{
    use HandlesExports;

    protected const PER_PAGE_OPTIONS = [10, 25, 50, 100];

    protected const DISPLAY_TIMEZONE = 'Asia/Jakarta';

    // dompdf berat untuk tabel panjang (±125 MB untuk 500 baris), jadi PDF dibatasi; CSV tidak dibatasi
    public const PDF_MAX_ROWS = 500;

    /**
     * Tampilkan riwayat log penangkapan request API telemetri perangkat
     */
    public function index(Request $request): View
    {
        $perPage = (int) $request->query('per_page', 10);
        if (! in_array($perPage, self::PER_PAGE_OPTIONS, true)) {
            $perPage = 10;
        }

        $filters = $this->filters($request);

        // Paginasi di database agar halaman tetap ringan walau log sudah puluhan ribu baris
        $logs = $this->filteredQuery($filters)
            ->paginate($perPage)
            ->withQueryString();

        $counts = DeviceApiLog::query()
            ->selectRaw(
                "COUNT(*) AS total,
                SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) AS success,
                SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) AS failed,
                COUNT(DISTINCT sub_domain) AS subdomains"
            )
            ->first();

        $stats = [
            'total'      => (int) $counts->total,
            'success'    => (int) $counts->success,
            'failed'     => (int) $counts->failed,
            'subdomains' => (int) $counts->subdomains,
        ];

        $search = $filters['q'];
        $perPageOptions = self::PER_PAGE_OPTIONS;
        $hasFilters = $this->hasFilters($filters);
        $pdfMaxRows = self::PDF_MAX_ROWS;

        return view('admin.device-logs.index', compact(
            'logs', 'stats', 'search', 'filters', 'hasFilters', 'perPage', 'perPageOptions', 'pdfMaxRows'
        ));
    }

    /**
     * Ekspor log (sesuai filter aktif) ke CSV, di-stream per batch agar hemat memori
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $filters = $this->filters($request);

        // Snapshot id terakhir: log yang masuk selama ekspor tidak ikut / tidak menggeser hasil.
        // Iterasi keyset per id (bukan OFFSET) agar tidak ada baris dobel dan tetap cepat di tabel besar.
        $maxId = (int) DeviceApiLog::max('id');
        $query = $this->filteredQuery($filters)
            ->reorder()
            ->where('id', '<=', $maxId);

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // BOM agar Excel membaca UTF-8 dengan benar
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No', 'Waktu Masuk (WIB)', 'Subdomain Balai', 'URL Tujuan', 'ID Alat', 'Parameter Sensor (Payload)',
                'Status', 'Kode HTTP', 'Durasi (ms)', 'IP Device', 'Respon Server Balai',
            ], ',', '"', '');

            $number = 0;
            foreach ($query->lazyByIdDesc(1000) as $log) {
                $payload = is_array($log->payload) ? $log->payload : [];

                fputcsv($handle, [
                    ++$number,
                    $log->created_at?->timezone(self::DISPLAY_TIMEZONE)->format('Y-m-d H:i:s') ?? '',
                    $log->sub_domain,
                    $log->sub_domain . '.higertech.com' . $log->endpoint,
                    $this->sanitizeCsvCell(is_scalar($payload['id'] ?? null) ? (string) $payload['id'] : ''),
                    $payload ? json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '',
                    $log->status === 'success' ? 'Berhasil' : 'Gagal',
                    $log->status_code,
                    $log->duration_ms ?? '',
                    $log->ip_address ?? '',
                    $this->sanitizeCsvCell($log->response_body),
                ], ',', '"', '');
            }

            fclose($handle);
        }, $this->exportFilename($filters, 'csv'), [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Ekspor log (sesuai filter aktif) ke PDF, maksimal PDF_MAX_ROWS baris terbaru
     */
    public function exportPdf(Request $request): Response
    {
        $this->raiseMemoryLimit();

        $filters = $this->filters($request);
        $logs = $this->filteredQuery($filters)->limit(self::PDF_MAX_ROWS)->get();

        $logoPath = public_path('images/brand/higertech-logo.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        return Pdf::loadView('pdf.device-api-logs', [
            'logs'        => $logs,
            'logoBase64'  => $logoBase64,
            'generatedAt' => now()->timezone(self::DISPLAY_TIMEZONE),
            'timezone'    => self::DISPLAY_TIMEZONE,
        ])
            ->setPaper('a4', 'landscape')
            ->setOption('isFontSubsettingEnabled', true)
            ->download($this->exportFilename($filters, 'pdf'));
    }

    /**
     * Hapus satu baris log
     */
    public function destroy(DeviceApiLog $deviceLog): RedirectResponse
    {
        $deviceLog->delete();

        return redirect()
            ->route('admin.device-logs.index')
            ->with('success', 'Data log API telemetri berhasil dihapus.');
    }

    /**
     * Kosongkan seluruh log telemetri
     */
    public function clear(): RedirectResponse
    {
        DeviceApiLog::truncate();

        return redirect()
            ->route('admin.device-logs.index')
            ->with('success', 'Seluruh riwayat log API telemetri berhasil dibersihkan.');
    }

    /**
     * Ambil & normalisasi filter dari query string (dipakai halaman dan ekspor)
     *
     * @return array{q: string, status: string, from: ?string, to: ?string}
     */
    protected function filters(Request $request): array
    {
        $status = (string) $request->query('status', '');

        return [
            'q'      => trim((string) $request->query('q', '')),
            'status' => in_array($status, ['success', 'failed'], true) ? $status : '',
            'from'   => $this->validDate($request->query('from')),
            'to'     => $this->validDate($request->query('to')),
        ];
    }

    protected function hasFilters(array $filters): bool
    {
        return $filters['q'] !== '' || $filters['status'] !== '' || $filters['from'] || $filters['to'];
    }

    protected function filteredQuery(array $filters): Builder
    {
        return DeviceApiLog::query()
            ->when($filters['q'] !== '', function (Builder $query) use ($filters) {
                $like = '%' . $filters['q'] . '%';
                $query->where(function (Builder $q) use ($like) {
                    $q->where('sub_domain', 'like', $like)
                        ->orWhere('ip_address', 'like', $like)
                        ->orWhere('status_code', 'like', $like)
                        ->orWhere('payload', 'like', $like);
                });
            })
            ->when($filters['status'] !== '', fn (Builder $query) => $query->where('status', $filters['status']))
            // Tanggal diinput dalam WIB, created_at tersimpan dalam timezone aplikasi (UTC)
            ->when($filters['from'], fn (Builder $query) => $query->where(
                'created_at', '>=', Carbon::parse($filters['from'], self::DISPLAY_TIMEZONE)->startOfDay()->timezone(config('app.timezone'))
            ))
            ->when($filters['to'], fn (Builder $query) => $query->where(
                'created_at', '<=', Carbon::parse($filters['to'], self::DISPLAY_TIMEZONE)->endOfDay()->timezone(config('app.timezone'))
            ))
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    protected function validDate(mixed $value): ?string
    {
        if (! is_string($value) || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return null;
        }

        $date = \DateTime::createFromFormat('!Y-m-d', $value);

        return $date && $date->format('Y-m-d') === $value ? $value : null;
    }

    protected function exportFilename(array $filters, string $extension): string
    {
        $period = match (true) {
            $filters['from'] && $filters['to'] => $filters['from'] . '_sd_' . $filters['to'],
            (bool) $filters['from']            => 'mulai_' . $filters['from'],
            (bool) $filters['to']              => 'sampai_' . $filters['to'],
            default                            => now()->timezone(self::DISPLAY_TIMEZONE)->format('Y-m-d_His'),
        };

        return "log-api-telemetri_{$period}.{$extension}";
    }
}
