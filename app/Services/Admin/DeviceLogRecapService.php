<?php

namespace App\Services\Admin;

use App\Models\DeviceApiLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Rekap laporan log API telemetri per ID alat per hari (WIB):
 * jumlah alat, total data masuk, berhasil (2xx/3xx) dan gagal beserta rincian kode HTTP.
 */
class DeviceLogRecapService
{
    public const TIMEZONE = 'Asia/Jakarta';

    public const MAX_RANGE_DAYS = 31;

    public const SORT_OPTIONS = [
        'date_desc'   => 'Tanggal terbaru',
        'device'      => 'ID alat (A-Z)',
        'failed_desc' => 'Gagal terbanyak',
        'total_desc'  => 'Data masuk terbanyak',
        'rate_asc'    => '% berhasil terendah',
    ];

    public const NO_DEVICE_ID = '(tanpa ID)';

    /**
     * Normalisasi filter: rentang tanggal WIB (default hari ini, maks. MAX_RANGE_DAYS hari), kata kunci, urutan
     *
     * @return array{from: string, to: string, q: string, sort: string, clamped: bool}
     */
    public function filters(array $input): array
    {
        $today = now(self::TIMEZONE)->toDateString();

        $from = $this->validDate($input['from'] ?? null) ?? $today;
        $to = $this->validDate($input['to'] ?? null) ?? $from;

        if ($from > $to) {
            [$from, $to] = [$to, $from];
        }

        // Batasi rentang agar query agregasi tetap ringan
        $clamped = false;
        $maxTo = Carbon::parse($from)->addDays(self::MAX_RANGE_DAYS - 1)->toDateString();
        if ($to > $maxTo) {
            $to = $maxTo;
            $clamped = true;
        }

        $sort = (string) ($input['sort'] ?? '');

        return [
            'from'    => $from,
            'to'      => $to,
            'q'       => trim((string) ($input['q'] ?? '')),
            'sort'    => array_key_exists($sort, self::SORT_OPTIONS) ? $sort : 'date_desc',
            'clamped' => $clamped,
        ];
    }

    /**
     * Ringkasan untuk kartu statistik
     *
     * @return array{devices: int, total: int, success: int, failed: int, rate: ?float}
     */
    public function summary(array $filters): array
    {
        $deviceIdExpr = $this->deviceIdExpression();

        $row = $this->baseQuery($filters)
            ->selectRaw(
                "COUNT(DISTINCT {$deviceIdExpr}) AS devices,
                COUNT(*) AS total,
                SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) AS success,
                SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) AS failed"
            )
            ->toBase()
            ->first();

        $total = (int) ($row->total ?? 0);
        $success = (int) ($row->success ?? 0);

        return [
            'devices' => (int) ($row->devices ?? 0),
            'total'   => $total,
            'success' => $success,
            'failed'  => (int) ($row->failed ?? 0),
            'rate'    => $total > 0 ? round($success / $total * 100, 1) : null,
        ];
    }

    /**
     * Query rekap: satu baris per tanggal (WIB) + ID alat + subdomain
     */
    public function recapQuery(array $filters): \Illuminate\Database\Query\Builder
    {
        $dateExpr = $this->localDateExpression();
        $deviceIdExpr = $this->deviceIdExpression();

        $query = $this->baseQuery($filters)
            ->toBase()
            ->selectRaw(
                "{$dateExpr} AS recap_date,
                {$deviceIdExpr} AS device_id,
                sub_domain,
                COUNT(*) AS total,
                SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) AS success,
                SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) AS failed"
            )
            ->groupByRaw("{$dateExpr}, {$deviceIdExpr}, sub_domain");

        // Tie-breaker tetap agar urutan stabil antar halaman
        match ($filters['sort']) {
            'device'      => $query->orderBy('device_id')->orderByDesc('recap_date'),
            'failed_desc' => $query->orderByDesc('failed')->orderByDesc('recap_date')->orderBy('device_id'),
            'total_desc'  => $query->orderByDesc('total')->orderByDesc('recap_date')->orderBy('device_id'),
            'rate_asc'    => $query->orderByRaw("SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) * 1.0 / COUNT(*) ASC")
                ->orderByDesc('total')->orderBy('device_id'),
            default       => $query->orderByDesc('recap_date')->orderBy('device_id'),
        };

        return $query->orderBy('sub_domain');
    }

    /**
     * Rincian kode HTTP gagal untuk baris rekap yang sedang ditampilkan,
     * dikunci dengan "tanggal|id alat|subdomain" → [kode => jumlah]
     *
     * @param  iterable<object>  $rows
     * @return array<string, array<int, int>>
     */
    public function failureBreakdown(array $filters, iterable $rows): array
    {
        $rows = collect($rows)->filter(fn ($row) => (int) $row->failed > 0);
        if ($rows->isEmpty()) {
            return [];
        }

        $dateExpr = $this->localDateExpression();
        $deviceIdExpr = $this->deviceIdExpression();

        $codes = $this->baseQuery($filters)
            ->toBase()
            ->where('status', 'failed')
            ->whereIn('sub_domain', $rows->pluck('sub_domain')->unique()->values())
            ->selectRaw("{$dateExpr} AS recap_date, {$deviceIdExpr} AS device_id, sub_domain, status_code, COUNT(*) AS aggregate")
            ->groupByRaw("{$dateExpr}, {$deviceIdExpr}, sub_domain, status_code")
            ->orderBy('status_code')
            ->get();

        $breakdown = [];
        foreach ($codes as $code) {
            $key = $this->rowKey($code);
            $breakdown[$key][(int) $code->status_code] = (int) $code->aggregate;
        }

        return $breakdown;
    }

    public function rowKey(object $row): string
    {
        return $row->recap_date . '|' . $row->device_id . '|' . $row->sub_domain;
    }

    public function successRate(object $row): ?float
    {
        return (int) $row->total > 0 ? round((int) $row->success / (int) $row->total * 100, 1) : null;
    }

    /**
     * @param  array<int, int>  $codes
     */
    public function formatBreakdown(array $codes): string
    {
        return collect($codes)->map(fn ($count, $code) => "{$code}: {$count}")->implode(', ');
    }

    protected function baseQuery(array $filters): Builder
    {
        $appTimezone = config('app.timezone');

        return DeviceApiLog::query()
            // Rentang tanggal WIB dikonversi ke timezone penyimpanan (UTC)
            ->where('created_at', '>=', Carbon::parse($filters['from'], self::TIMEZONE)->startOfDay()->timezone($appTimezone))
            ->where('created_at', '<=', Carbon::parse($filters['to'], self::TIMEZONE)->endOfDay()->timezone($appTimezone))
            ->when($filters['q'] !== '', function (Builder $query) use ($filters) {
                $rawTerm = $filters['q'];
                $lowerLike = '%' . mb_strtolower($rawTerm, 'UTF-8') . '%';
                $wrapId = DB::connection()->getQueryGrammar()->wrap('payload->id');

                $query->where(function (Builder $q) use ($lowerLike, $wrapId) {
                    $q->whereRaw('LOWER(sub_domain) LIKE ?', [$lowerLike])
                        ->orWhereRaw("LOWER({$wrapId}) LIKE ?", [$lowerLike]);
                });
            });
    }

    /**
     * Ekspresi SQL ID alat dari payload JSON (portabel MySQL/SQLite via grammar Laravel)
     */
    protected function deviceIdExpression(): string
    {
        $json = DB::connection()->getQueryGrammar()->wrap('payload->id');
        $fallback = DB::connection()->getPdo()->quote(self::NO_DEVICE_ID);

        return "COALESCE(NULLIF({$json}, ''), {$fallback})";
    }

    /**
     * Ekspresi SQL tanggal lokal (WIB) dari created_at yang tersimpan di timezone aplikasi
     */
    protected function localDateExpression(): string
    {
        $offsetMinutes = now(self::TIMEZONE)->utcOffset() - now(config('app.timezone'))->utcOffset();

        return match (DB::connection()->getDriverName()) {
            'sqlite' => "DATE(created_at, '{$this->signed($offsetMinutes)} minutes')",
            'pgsql'  => "DATE(created_at + INTERVAL '{$offsetMinutes} minutes')",
            default  => "DATE(DATE_ADD(created_at, INTERVAL {$offsetMinutes} MINUTE))",
        };
    }

    protected function signed(int $value): string
    {
        return $value >= 0 ? '+' . $value : (string) $value;
    }

    protected function validDate(mixed $value): ?string
    {
        if (! is_string($value) || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return null;
        }

        $date = \DateTime::createFromFormat('!Y-m-d', $value);

        return $date && $date->format('Y-m-d') === $value ? $value : null;
    }
}
