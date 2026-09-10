<?php

namespace App\Repositories;

use App\Models\Station;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class StationRepository
{
    public const PRIMARY_TYPES = ['ARR', 'AWLR', 'AWS', 'AWLR_ARR'];

    public const SOURCE_TYPES = ['ARR', 'AWLR', 'AWS', 'AWLR_ARR', 'AGWLR', 'FM', 'EWS', 'AVWR', 'WQ', 'VNOTCH', 'OW', 'OSP'];

    /**
     * @param array<string, mixed> $filters
     * @param array<int, string> $columns
     */
    public function getFiltered(array $filters, array $columns = ['*']): Collection
    {
        $query = Station::query()
            ->select($columns)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        return $this->applyFilters($query, $filters)->orderBy('name')->get();
    }

    public function getOrganizations(): Collection
    {
        return Station::query()
            ->whereNotNull('organization_code')
            ->whereNotNull('balai_name')
            ->select('organization_code', 'balai_name')
            ->distinct()
            ->orderBy('balai_name')
            ->get();
    }

    public function getSummaryCounts(): object
    {
        return Station::query()
            ->selectRaw(
                <<<'SQL'
                COUNT(*) AS total,
                SUM(CASE WHEN device_status = 'online' THEN 1 ELSE 0 END) AS online,
                SUM(CASE WHEN device_status = 'offline' THEN 1 ELSE 0 END) AS offline,
                COUNT(DISTINCT organization_code) AS organizations
                SQL
            )
            ->firstOrFail();
    }

    public function getTypeCounts(): Collection
    {
        return Station::query()
            ->whereIn('station_type', self::SOURCE_TYPES)
            ->selectRaw('station_type, COUNT(*) AS aggregate')
            ->groupBy('station_type')
            ->pluck('aggregate', 'station_type');
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

