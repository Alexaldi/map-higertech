<?php

namespace App\Services;

use App\Models\Station;
use App\Repositories\StationRepository;
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

    public function __construct(private readonly StationRepository $stationRepository) {}

    /** @param array<string, mixed> $filters */
    public function filtered(array $filters): Collection
    {
        return $this->stationRepository->getFiltered($filters, self::PUBLIC_COLUMNS);
    }

    public function organizations(): Collection
    {
        return $this->stationRepository->getOrganizations()
            ->map(fn (Station $station): array => [
                'code' => $station->organization_code,
                'name' => $station->balai_name,
            ])
            ->values();
    }

    /** @return array{total: int, online: int, offline: int, organizations: int, types: array<string, int>} */
    public function summary(): array
    {
        $counts = $this->stationRepository->getSummaryCounts();

        $types = array_fill_keys(StationRepository::SOURCE_TYPES, 0);
        $typeCounts = $this->stationRepository->getTypeCounts();

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
}
