<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StationResource;
use App\Services\StationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StationController extends Controller
{
    public function __construct(private readonly StationService $stations) {}

    public function index(Request $request): JsonResponse
    {
        $stations = $this->stations->filtered($request->only(['search', 'type', 'status', 'organization']));
        $data = StationResource::collection($stations)->resolve($request);

        return response()->json([
            'data' => $data,
            'meta' => [
                'count' => $stations->count(),
                'organizations' => $this->stations->organizations(),
            ],
        ]);
    }

    public function summary(): JsonResponse
    {
        return response()->json($this->stations->summary());
    }

    public function cloudCover(): JsonResponse
    {
        try {
            $data = Cache::remember('stations_cloud_cover', 7200, function () {
                $stations = $this->stations->filtered([]);
                $results = [];

                // Open-Meteo accepts multiple lat/lon comma separated.
                // But URL length is limited, so we chunk them.
                $chunks = $stations->chunk(50);

                foreach ($chunks as $chunk) {
                    $latitudes = $chunk->pluck('latitude')->filter()->values();
                    $longitudes = $chunk->pluck('longitude')->filter()->values();

                    if ($latitudes->count() !== $chunk->count() || $longitudes->count() !== $chunk->count()) {
                        throw new \UnexpectedValueException('Open-Meteo request coordinates were incomplete.');
                    }

                    $response = Http::timeout(10)->get('https://api.open-meteo.com/v1/forecast', [
                        'latitude' => $latitudes->implode(','),
                        'longitude' => $longitudes->implode(','),
                        'current' => 'cloud_cover',
                        'timezone' => 'auto',
                    ]);

                    if (! $response->successful()) {
                        throw new \RuntimeException('Open-Meteo returned HTTP '.$response->status());
                    }

                    $json = $response->json();
                    if (! is_array($json)) {
                        throw new \UnexpectedValueException('Open-Meteo returned an invalid response.');
                    }

                    if (isset($json[0])) {
                        if (! array_is_list($json) || count($json) !== $chunk->count()) {
                            throw new \UnexpectedValueException('Open-Meteo returned an incomplete location list.');
                        }

                        foreach ($chunk->values() as $index => $station) {
                            $value = $json[$index]['current']['cloud_cover'] ?? null;
                            if (! is_numeric($value) || (float) $value < 0 || (float) $value > 100) {
                                throw new \UnexpectedValueException('Open-Meteo returned missing or invalid cloud cover.');
                            }

                            $results[$station->id] = $value;
                        }
                    } else {
                        if ($chunk->count() !== 1) {
                            throw new \UnexpectedValueException('Open-Meteo returned an unexpected response structure.');
                        }

                        $value = $json['current']['cloud_cover'] ?? null;
                        if (! is_numeric($value) || (float) $value < 0 || (float) $value > 100) {
                            throw new \UnexpectedValueException('Open-Meteo returned missing or invalid cloud cover.');
                        }

                        $station = $chunk->first();
                        $results[$station->id] = $value;
                    }
                }

                if ($stations->isEmpty() || count($results) !== $stations->count()) {
                    throw new \UnexpectedValueException('Open-Meteo did not return cloud cover for every station.');
                }

                return $results;
            });
        } catch (\Throwable $exception) {
            Log::error('Cloud cover refresh was not cached.', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            $data = [];
        }

        return response()->json($data);
    }
}
