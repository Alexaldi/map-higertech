<?php

namespace App\Models;

use Database\Factories\StationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    /** @use HasFactory<StationFactory> */
    use HasFactory;

    protected $fillable = [
        'external_id',
        'name',
        'slug',
        'station_type',
        'latitude',
        'longitude',
        'balai_name',
        'organization_code',
        'province_name',
        'regency_name',
        'district_name',
        'village_name',
        'river_area_name',
        'watershed_name',
        'device_id',
        'device_status',
        'timezone',
        'reading_at',
        'latest_reading',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'reading_at' => 'datetime',
            'latest_reading' => 'array',
        ];
    }
}
