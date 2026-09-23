<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StationResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'station_type' => $this->station_type,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'balai_name' => $this->balai_name,
            'province_name' => $this->province_name,
            'regency_name' => $this->regency_name,
            'device_id' => $this->device_id,
            'device_status' => $this->device_status,
            'reading_at' => $this->reading_at?->toIso8601String(),
            'latest_reading' => $this->latest_reading,
        ];
    }
}
