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

        return response()->json([
            'data' => StationResource::collection($stations)->resolve($request),
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
}
