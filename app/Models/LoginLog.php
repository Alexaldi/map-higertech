<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'status',
        'login_at',
    ];

    protected function casts(): array
    {
        return [
            'login_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBrowserAttribute()
    {
        $userAgent = $this->user_agent;

        if (!$userAgent) {
            return 'Unknown';
        }

        if (preg_match('/Edg\/([\d]+)/i', $userAgent, $matches)) {
            return 'Edge ' . $matches[1];
        }

        if (preg_match('/OPR\/([\d]+)/i', $userAgent, $matches)) {
            return 'Opera ' . $matches[1];
        }

        if (preg_match('/Chrome\/([\d]+)/i', $userAgent, $matches)) {
            return 'Chrome ' . $matches[1];
        }

        if (preg_match('/Firefox\/([\d]+)/i', $userAgent, $matches)) {
            return 'Firefox ' . $matches[1];
        }

        if (
            preg_match('/Version\/([\d]+)/i', $userAgent, $matches) &&
            preg_match('/Safari/i', $userAgent)
        ) {
            return 'Safari ' . $matches[1];
        }

        return 'Unknown';
    }

    public function getDeviceAttribute()
    {
        $userAgent = $this->user_agent;

        if (!$userAgent) {
            return 'Unknown';
        }

        if (preg_match('/Windows NT/i', $userAgent)) {
            return 'Windows';
        }

        if (preg_match('/Android/i', $userAgent)) {
            return 'Android';
        }

        if (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            return 'iOS';
        }

        if (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            return 'macOS';
        }

        if (preg_match('/Linux/i', $userAgent)) {
            return 'Linux';
        }

        return 'Unknown';
    }
}