<?php

namespace App\Services;

use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PosMonitoringService
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;
    protected int $timeout;

    public function __construct(
        ?string $baseUrl = null,
        ?string $username = null,
        ?string $password = null,
        ?int $timeout = null
    ) {
        $this->baseUrl = rtrim($baseUrl ?? config('services.pos_monitoring.base_url', 'http://103.183.75.71:5000'), '/');
        $this->username = $username ?? config('services.pos_monitoring.username', 'm0n1tor_st4tion');
        $this->password = $password ?? config('services.pos_monitoring.password', 'H1gertech.1dua3');
        $this->timeout = $timeout ?? (int) config('services.pos_monitoring.timeout', 30);
    }

    protected function client(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->withBasicAuth($this->username, $this->password)
            ->timeout($this->timeout)
            ->acceptJson();
    }

    /**
     * 1. GET /LastReading/all
     * Fetches all 1,400+ stations with their latest readings in one call.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchLastReadingAll(): array
    {
        $response = $this->client()->get('/LastReading/all');

        if (! $response->successful()) {
            Log::error('PosMonitoring: Failed to fetch /LastReading/all', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \RuntimeException("Failed to fetch PosMonitoring /LastReading/all: HTTP {$response->status()}");
        }

        $json = $response->json();

        return is_array($json) ? ($json['data'] ?? $json) : [];
    }

    /**
     * 2. GET /LastReading/Device/{deviceId}
     * Real-time refresh for a single device sensor reading.
     *
     * @return array<string, mixed>|null
     */
    public function fetchDeviceReading(string $deviceId): ?array
    {
        $response = $this->client()->get("/LastReading/Device/{$deviceId}");

        if (! $response->successful()) {
            return null;
        }

        $json = $response->json();

        return is_array($json) ? ($json['data'] ?? $json) : null;
    }

    /**
     * 3. GET /LastReading/Organization/{orgCode}
     * Fetch all latest readings for a specific organization / Balai.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchOrganizationLastReading(string $orgCode): array
    {
        $response = $this->client()->get("/LastReading/Organization/{$orgCode}");

        if (! $response->successful()) {
            return [];
        }

        $json = $response->json();

        return is_array($json) ? ($json['data'] ?? $json) : [];
    }

    /**
     * 4. GET /Station/All
     * Master station metadata catalogue.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchStationAll(): array
    {
        $response = $this->client()->get('/Station/All');

        if (! $response->successful()) {
            return [];
        }

        $json = $response->json();

        return is_array($json) ? ($json['data'] ?? $json) : [];
    }

    /**
     * 5. GET /Station/{stationId}
     * Fetch master profile for a single station by UUID.
     *
     * @return array<string, mixed>|null
     */
    public function fetchStationById(string $stationId): ?array
    {
        $response = $this->client()->get("/Station/{$stationId}");

        if (! $response->successful()) {
            return null;
        }

        $json = $response->json();

        return is_array($json) ? ($json['data'] ?? $json) : null;
    }

    /**
     * 6. GET /Station/Organization/{orgCode}
     * Fetch master stations list for a specific organization.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchStationByOrganization(string $orgCode): array
    {
        $response = $this->client()->get("/Station/Organization/{$orgCode}");

        if (! $response->successful()) {
            return [];
        }

        $json = $response->json();

        return is_array($json) ? ($json['data'] ?? $json) : [];
    }

    /**
     * Synchronize all stations from Pos Monitoring API into local database.
     *
     * @param bool $wipeDummy If true, deletes dummy stations created by initial seeder
     * @param (callable(int $current, int $total, string $stationName): void)|null $progressCallback
     * @return array{total: int, created: int, updated: int, failed: int}
     */
    public function syncAll(bool $wipeDummy = false, ?callable $progressCallback = null): array
    {
        if ($wipeDummy) {
            Station::where('device_id', 'like', '%-DUMMY-%')->delete();
        }

        $items = $this->fetchLastReadingAll();
        $total = count($items);
        $created = 0;
        $updated = 0;
        $failed = 0;

        $existingSlugs = Station::pluck('id', 'slug')->all();

        foreach ($items as $index => $item) {
            try {
                $externalId = $item['id'] ?? null;
                $deviceId = $item['deviceId'] ?? null;
                $name = trim((string) ($item['name'] ?? 'Station ' . ($deviceId ?? $index)));
                $stationType = strtoupper(trim((string) ($item['stationType'] ?? 'ARR')));

                // Generate guaranteed unique slug
                $slugCandidate = Str::slug($item['slug'] ?? $name);
                if (empty($slugCandidate)) {
                    $slugCandidate = 'station-' . Str::lower($deviceId ?? Str::random(6));
                }

                // If slug belongs to a different station, make it unique
                if (isset($existingSlugs[$slugCandidate])) {
                    $existingStationId = $existingSlugs[$slugCandidate];
                    $currentMatch = Station::where('external_id', $externalId)->value('id');
                    if ($currentMatch !== $existingStationId) {
                        $slugCandidate = $slugCandidate . '-' . Str::lower($deviceId ?? Str::random(4));
                    }
                }

                $readingAt = $this->parseReadingTimestamp($item);
                $latestReading = $this->extractTelemetry($stationType, $item);

                $deviceStatus = 'offline';
                if (isset($item['deviceStatus'])) {
                    if (is_bool($item['deviceStatus'])) {
                        $deviceStatus = $item['deviceStatus'] ? 'online' : 'offline';
                    } elseif (is_string($item['deviceStatus'])) {
                        $deviceStatus = strtolower($item['deviceStatus']) === 'online' ? 'online' : 'offline';
                    }
                }

                $data = [
                    'name' => $name,
                    'slug' => $slugCandidate,
                    'station_type' => $stationType,
                    'latitude' => isset($item['latitude']) ? (float) $item['latitude'] : null,
                    'longitude' => isset($item['longitude']) ? (float) $item['longitude'] : null,
                    'balai_name' => $item['balaiName'] ?? null,
                    'organization_code' => $item['organizationCode'] ?? null,
                    'province_name' => $item['provinceName'] ?? null,
                    'regency_name' => $item['regencyName'] ?? null,
                    'district_name' => $item['districtName'] ?? null,
                    'village_name' => $item['villageName'] ?? null,
                    'river_area_name' => $item['riverAreaName'] ?? null,
                    'watershed_name' => $item['watershedName'] ?? null,
                    'device_id' => $deviceId,
                    'device_status' => $deviceStatus,
                    'timezone' => $this->normalizeTimezone($item['timeZone'] ?? null),
                    'reading_at' => $readingAt,
                    'latest_reading' => $latestReading,
                ];

                // Match by external_id if present, otherwise device_id or slug
                $station = null;
                if ($externalId) {
                    $station = Station::where('external_id', $externalId)->first();
                }
                if (! $station && $deviceId) {
                    $station = Station::where('device_id', $deviceId)->first();
                }

                if ($station) {
                    $station->update(array_merge($data, ['external_id' => $externalId]));
                    $updated++;
                } else {
                    Station::create(array_merge($data, ['external_id' => $externalId]));
                    $created++;
                }

                $existingSlugs[$slugCandidate] = $station ? $station->id : true;

                if ($progressCallback) {
                    $progressCallback($index + 1, $total, $name);
                }
            } catch (\Throwable $e) {
                Log::warning('PosMonitoring: Failed syncing station item', [
                    'index' => $index,
                    'error' => $e->getMessage(),
                ]);
                $failed++;
            }
        }

        return [
            'total' => $total,
            'created' => $created,
            'updated' => $updated,
            'failed' => $failed,
        ];
    }

    protected function parseReadingTimestamp(array $item): ?Carbon
    {
        // Check reading timestamps from nested objects or top-level
        $candidates = [
            $item['lastReadingAt'] ?? null,
            $item['awlrLastReading']['readingAt'] ?? null,
            $item['arrLastReading']['readingAt'] ?? null,
            $item['awsLastReading']['readingAt'] ?? null,
            $item['awlrArrLastReading']['readingAt'] ?? null,
            $item['flowmeterLastReading']['readingAt'] ?? null,
            $item['waterQualityLastReading']['readingAt'] ?? null,
            $item['piezometerLastReading']['readingAt'] ?? null,
            $item['vNotchLastReading']['readingAt'] ?? null,
        ];

        foreach ($candidates as $candidate) {
            if ($candidate) {
                try {
                    return Carbon::parse($candidate);
                } catch (\Throwable) {
                    continue;
                }
            }
        }

        return null;
    }

    protected function normalizeTimezone(?string $timeZone): string
    {
        if (! $timeZone) {
            return 'Asia/Jakarta';
        }

        return match (strtoupper(trim($timeZone))) {
            'WITA' => 'Asia/Makassar',
            'WIT' => 'Asia/Jayapura',
            default => 'Asia/Jakarta',
        };
    }

    /**
     * Map raw API telemetry payloads to the standardized format consumed by Leaflet JS popups.
     *
     * @param array<string, mixed> $item
     * @return array<string, int|float|string>|null
     */
    protected function extractTelemetry(string $type, array $item): ?array
    {
        $awlr = $item['awlrLastReading'] ?? null;
        $arr = $item['arrLastReading'] ?? null;
        $aws = $item['awsLastReading'] ?? null;
        $awlrArr = $item['awlrArrLastReading'] ?? null;
        $flow = $item['flowmeterLastReading'] ?? null;
        $wq = $item['waterQualityLastReading'] ?? null;
        $piezo = $item['piezometerLastReading'] ?? null;
        $vnotch = $item['vNotchLastReading'] ?? null;

        $telemetry = match ($type) {
            'ARR' => $arr ? [
                'rainfall' => isset($arr['rainfall']) ? (float) $arr['rainfall'] : null,
                'rainfall_last_hour' => isset($arr['rainfallLastHour']) ? (float) $arr['rainfallLastHour'] : null,
                'intensity' => $arr['intensity'] ?? null,
            ] : null,

            'AWLR' => $awlr ? [
                'water_level' => isset($awlr['waterLevel']) ? (float) $awlr['waterLevel'] : null,
                'warning_status' => $awlr['warningStatus'] ?? 'Normal',
            ] : null,

            'AWS' => $aws ? [
                'temperature' => isset($aws['temperature']) ? (float) $aws['temperature'] : null,
                'humidity' => isset($aws['humidity']) ? (float) $aws['humidity'] : null,
                'pressure' => isset($aws['pressure']) ? (float) $aws['pressure'] : null,
                'wind_speed' => isset($aws['windSpeed']) ? (float) $aws['windSpeed'] : null,
                'wind_direction' => $aws['windDirectionStatus'] ?? (isset($aws['windDirection']) ? $aws['windDirection'] . '°' : null),
                'rainfall' => isset($aws['rainfall']) ? (float) $aws['rainfall'] : null,
                'solar_radiation' => isset($aws['solarRadiation']) ? (float) $aws['solarRadiation'] : null,
            ] : null,

            'AWLR_ARR' => ($awlrArr || $awlr || $arr) ? [
                'water_level' => isset($awlrArr['waterLevel']) ? (float) $awlrArr['waterLevel'] : ($awlr['waterLevel'] ?? null),
                'rainfall' => isset($awlrArr['rainfall']) ? (float) $awlrArr['rainfall'] : ($arr['rainfall'] ?? null),
                'warning_status' => $awlrArr['warningStatus'] ?? ($awlr['warningStatus'] ?? 'Normal'),
                'intensity' => $awlrArr['intensity'] ?? ($arr['intensity'] ?? null),
            ] : null,

            'FM' => $flow ? [
                'flow_rate' => isset($flow['flowRate']) ? (float) $flow['flowRate'] : null,
                'flow_total' => isset($flow['flowTotal']) ? (float) $flow['flowTotal'] : null,
                'flow_month' => isset($flow['flowMonth']) ? (float) $flow['flowMonth'] : null,
            ] : null,

            'WQ' => $wq ? [
                'ph' => isset($wq['ph']) ? (float) $wq['ph'] : null,
                'turbidity' => isset($wq['turbidity']) ? (float) $wq['turbidity'] : null,
                'dissolved_oxygen' => isset($wq['dissolvedOxygen']) ? (float) $wq['dissolvedOxygen'] : null,
            ] : null,

            'AGWLR' => ($piezo || $awlr) ? [
                'groundwater_level' => isset($piezo['piezometerLevel']) ? (float) $piezo['piezometerLevel'] : ($awlr['waterLevel'] ?? null),
                'battery_voltage' => isset($piezo['voltage']) ? (float) $piezo['voltage'] : null,
            ] : null,

            'VNOTCH' => $vnotch ? [
                'discharge' => isset($vnotch['discharge']) ? (float) $vnotch['discharge'] : null,
                'water_height' => isset($vnotch['waterHeight']) ? (float) $vnotch['waterHeight'] : null,
            ] : null,

            default => null,
        };

        if ($telemetry) {
            $filtered = array_filter($telemetry, fn ($v) => $v !== null && $v !== '');
            return empty($filtered) ? null : $filtered;
        }

        return null;
    }
}
