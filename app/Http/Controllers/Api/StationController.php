<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StationResource;
use App\Services\StationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function __construct(private readonly StationService $stations) {}

    public function index(Request $request): JsonResponse
    {
        $stations = $this->stations->filtered($request->only(['search', 'type', 'status', 'organization']));
        $cloudCovers = json_decode($this->cloudCover()->getContent(), true);

        $data = StationResource::collection($stations)->resolve($request);
        
        // Inject cloud cover data
        foreach ($data as &$station) {
            $station['cloud_cover'] = $cloudCovers[$station['id']] ?? null;
        }

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
        $data = \Illuminate\Support\Facades\Cache::remember('stations_cloud_cover', 7200, function () {
            $stations = $this->stations->filtered([]);
            $results = [];

            // Open-Meteo accepts multiple lat/lon comma separated.
            // But URL length is limited, so we chunk them.
            $chunks = $stations->chunk(50);
            
            foreach ($chunks as $chunk) {
                $lats = $chunk->pluck('latitude')->filter()->implode(',');
                $lons = $chunk->pluck('longitude')->filter()->implode(',');
                
                if (empty($lats) || empty($lons)) continue;

                try {
                    $response = \Illuminate\Support\Facades\Http::timeout(10)->get('https://api.open-meteo.com/v1/forecast', [
                        'latitude' => $lats,
                        'longitude' => $lons,
                        'current' => 'cloud_cover',
                        'timezone' => 'auto'
                    ]);

                    if ($response->successful()) {
                        $json = $response->json();
                        // Open-Meteo returns array of objects if multiple coordinates provided
                        if (isset($json[0])) {
                            $i = 0;
                            foreach ($chunk as $station) {
                                if (isset($json[$i]['current']['cloud_cover'])) {
                                    $results[$station->id] = $json[$i]['current']['cloud_cover'];
                                }
                                $i++;
                            }
                        } else {
                            // Single coordinate fallback
                            foreach ($chunk as $station) {
                                if (isset($json['current']['cloud_cover'])) {
                                    $results[$station->id] = $json['current']['cloud_cover'];
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Open-Meteo API Error: ' . $e->getMessage());
                }
            }

            return $results;
        });

        return response()->json($data);
    }
}
