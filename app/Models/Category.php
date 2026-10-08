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
}
