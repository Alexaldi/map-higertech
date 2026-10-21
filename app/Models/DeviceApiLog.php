<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceApiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_domain',
        'endpoint',
        'method',
        'payload',
        'ip_address',
        'status_code',
        'status',
        'response_body',
        'duration_ms',
    ];

    protected $casts = [
        'payload'     => 'array',
        'status_code' => 'integer',
        'duration_ms' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];
}
