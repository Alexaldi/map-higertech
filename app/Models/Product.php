<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'desc',
        'inaproc_link',
        'image',
        'is_active',
    ];

    public function getEcatalogUrlAttribute(): string
    {
        if (! empty($this->inaproc_link) && $this->inaproc_link !== 'https://katalog.inaproc.id/higertech-karya-sinergi') {
            return $this->inaproc_link;
        }

        return 'https://katalog.inaproc.id/higertech-karya-sinergi/' . $this->slug;
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('assets/images/products.png');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'images/') || str_starts_with($this->image, 'assets/')) {
            return asset(ltrim($this->image, '/'));
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}