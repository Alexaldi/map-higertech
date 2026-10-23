<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesExports;
use App\Http\Controllers\Controller;
use App\Services\Admin\DeviceLogRecapService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DeviceApiLogRecapController extends Controller
{
    use HandlesExports;

    protected const PER_PAGE_OPTIONS = [25, 50, 100];

    // Satu baris rekap = satu alat per hari. Terukur ±92 MB untuk 300 baris (gagal di >±330 baris dengan batas 128 MB)
    public const PDF_MAX_ROWS = 300;

    public function __construct(private readonly DeviceLogRecapService $recap) {}

    /**
     * Rekap laporan log API telemetri per ID alat per hari
     */
    public function index(Request $request): View
    {
        $perPage = (int) $request->query('per_page', 25);
        if (! in_array($perPage, self::PER_PAGE_OPTIONS, true)) {
            $perPage = 25;
        }

        $filters = $this->recap->filters($request->query());
        $summary = $this->recap->summary($filters);

        $rows = $this->recap->recapQuery($filters)
            ->paginate($perPage)
            ->withQueryString();

        $breakdown = $this->recap->failureBreakdown($filters, $rows->items());

        return view('admin.device-logs.recap', [
            'rows'           => $rows,
            'summary'        => $summary,
            'breakdown'      => $breakdown,
            'filters'        => $filters,
            'perPage'        => $perPage,
            'perPageOptions' => self::PER_PAGE_OPTIONS,
            'sortOptions'    => DeviceLogRecapService::SORT_OPTIONS,
            'maxRangeDays'   => DeviceLogRecapService::MAX_RANGE_DAYS,
            'pdfMaxRows'     => self::PDF_MAX_ROWS,
            'recap'          => $this->recap,
        ]);
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $filters = $this->recap->filters($request->query());
        $rows = $this->recap->recapQuery($filters)->get();
        $breakdown = $this->recap->failureBreakdown($filters, $rows);
        $summary = $this->recap->summary($filters);

        return response()->streamDownload(function () use ($rows, $breakdown, $summary) {
            $handle = fopen('php://output', 'w');
            $put = fn (array $fields) => fputcsv($handle, $fields, ',', '"', '');

            // BOM agar Excel membaca UTF-8 dengan benar
            fwrite($handle, "\xEF\xBB\xBF");

            $put([
                'No', 'Tanggal (WIB)', 'ID Alat', 'Subdomain Balai', 'Total Data Masuk',
                'Berhasil (200)', 'Gagal', 'Rincian Kode Gagal', '% Berhasil',
            ]);

            foreach ($rows as $index => $row) {
                $rate = $this->recap->successRate($row);

                $put([
                    $index + 1,
                    $row->recap_date,
                    $this->sanitizeCsvCell((string) $row->device_id),
                    $row->sub_domain,
                    (int) $row->total,
                    (int) $row->success,
                    (int) $row->failed,
                    $this->recap->formatBreakdown($breakdown[$this->recap->rowKey($row)] ?? []),
                    $rate !== null ? number_format($rate, 1, '.', '') : '',
                ]);
            }

            $put([]);
            $put(['', 'TOTAL', $summary['devices'] . ' alat', '', $summary['total'], $summary['success'], $summary['failed'], '',
                $summary['rate'] !== null ? number_format($summary['rate'], 1, '.', '') : '']);

            fclose($handle);
        }, $this->exportFilename($filters, 'csv'), [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPdf(Request $request): Response
    {
        $this->raiseMemoryLimit();

        $filters = $this->recap->filters($request->query());
        $query = $this->recap->recapQuery($filters);
        $totalRows = $query->getCountForPagination();
        $rows = $query->limit(self::PDF_MAX_ROWS)->get();
        $breakdown = $this->recap->failureBreakdown($filters, $rows);
        $summary = $this->recap->summary($filters);

        $logoPath = public_path('images/brand/higertech-logo.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        return Pdf::loadView('pdf.device-api-log-recap', [
            'rows'        => $rows,
            'totalRows'   => $totalRows,
            'breakdown'   => $breakdown,
            'summary'     => $summary,
            'filters'     => $filters,
            'recap'       => $this->recap,
            'logoBase64'  => $logoBase64,
            'generatedAt' => now()->timezone(DeviceLogRecapService::TIMEZONE),
        ])
            ->setPaper('a4', 'landscape')
            ->setOption('isFontSubsettingEnabled', true)
            ->download($this->exportFilename($filters, 'pdf'));
    }

    protected function exportFilename(array $filters, string $extension): string
    {
        $period = $filters['from'] === $filters['to']
            ? $filters['from']
            : $filters['from'] . '_sd_' . $filters['to'];

        return "rekap-log-api-telemetri_{$period}.{$extension}";
    }
}
