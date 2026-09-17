<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPartner extends Model
{
    protected $fillable = [
        'name',
        'sub',
        'abbr',
        'color',
        'logo',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (! $this->logo) {
            return null;
        }

        if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }

        if (str_starts_with($this->logo, 'images/')) {
            return asset($this->logo);
        }

        return asset('storage/' . ltrim($this->logo, '/'));
    }
}

