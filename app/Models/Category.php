<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'sub_nama',
        'tipe',
        'description',
    ];

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
