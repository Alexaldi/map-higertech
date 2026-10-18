<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'sub_nama',
        'tipe',
        'sort_order',
        'description',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    public function scopeProduk($query)
    {
        return $query->where('tipe', 'produk');
    }

    public function scopeArtikel($query)
    {
        return $query->where('tipe', 'artikel');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getShortNameAttribute(): string
    {
        if (preg_match('/\/\s*([A-Za-z0-9\s]+)\s*\)/', $this->name, $matches)) {
            return trim($matches[1]);
        }
        if (preg_match('/\(\s*([^()]+)\s*\)/', $this->name, $matches)) {
            return trim($matches[1]);
        }
        return $this->name;
    }
}
