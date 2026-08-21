<?php

namespace App\Services;

use App\Models\Station;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class StationService
{
    private const PUBLIC_COLUMNS = [
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
    ];

    private const PRIMARY_TYPES = ['ARR', 'AWLR', 'AWS', 'AWLR_ARR'];

    private const SOURCE_TYPES = ['ARR', 'AWLR', 'AWS', 'AWLR_ARR', 'AGWLR', 'FM', 'EWS', 'AVWR', 'WQ', 'VNOTCH', 'OW', 'OSP'];

    /** @param array<string, mixed> $filters */
    public function filtered(array $filters): Collection
    {
        return $this->applyFilters(
            Station::query()
                ->select(self::PUBLIC_COLUMNS)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude'),
            $filters,
        )->orderBy('name')->get();
    }

    public function organizations(): Collection
    {
        return Station::query()
            ->whereNotNull('organization_code')
            ->whereNotNull('balai_name')
            ->select('organization_code', 'balai_name')
            ->distinct()
            ->orderBy('balai_name')
            ->get()
            ->map(fn (Station $station): array => [
                'code' => $station->organization_code,
                'name' => $station->balai_name,
            ])
            ->values();
    }

    /** @return array{total: int, online: int, offline: int, organizations: int, types: array<string, int>} */
    public function summary(): array
    {
        $counts = Station::query()
            ->selectRaw(
                <<<'SQL'
                COUNT(*) AS total,
                SUM(CASE WHEN device_status = 'online' THEN 1 ELSE 0 END) AS online,
                SUM(CASE WHEN device_status = 'offline' THEN 1 ELSE 0 END) AS offline,
                COUNT(DISTINCT organization_code) AS organizations
                SQL
            )
            ->firstOrFail();

        $types = array_fill_keys(self::SOURCE_TYPES, 0);
        $typeCounts = Station::query()
            ->whereIn('station_type', self::SOURCE_TYPES)
            ->selectRaw('station_type, COUNT(*) AS aggregate')
            ->groupBy('station_type')
            ->pluck('aggregate', 'station_type');

        foreach ($typeCounts as $type => $count) {
            $types[$type] = (int) $count;
        }

        return [
            'total' => (int) $counts->total,
            'online' => (int) $counts->online,
            'offline' => (int) $counts->offline,
            'organizations' => (int) $counts->organizations,
            'types' => $types,
        ];
    }

    /** @param array<string, mixed> $filters */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $search = trim((string) ($filters['search'] ?? ''));

        if ($search !== '') {
            $query->where(function (Builder $query) use ($search): void {
                foreach (['name', 'balai_name', 'province_name', 'regency_name'] as $field) {
                    $query->orWhereLike($field, "%{$search}%", caseSensitive: false);
                }
            });
        }

        $type = strtoupper(trim((string) ($filters['type'] ?? '')));

        if ($type === 'OTHER') {
            $query->whereNotIn('station_type', self::PRIMARY_TYPES);
        } elseif (in_array($type, self::SOURCE_TYPES, true)) {
            $query->where('station_type', $type);
        }

        $status = strtolower(trim((string) ($filters['status'] ?? '')));

        if (in_array($status, ['online', 'offline'], true)) {
            $query->where('device_status', $status);
        }

        $organization = trim((string) ($filters['organization'] ?? ''));

        if ($organization !== '') {
            $query->where('organization_code', $organization);
        }

        return $query;
    }
}
