<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'desc',
        'inaproc_link',
        'image',
        'gallery_images',
        'brochure',
        'is_active',
    ];

    public function getEcatalogUrlAttribute(): string
    {
        if (! empty($this->inaproc_link) && $this->inaproc_link !== 'https://katalog.inaproc.id/higertech-karya-sinergi') {
            return $this->inaproc_link;
        }

        return 'https://katalog.inaproc.id/higertech-karya-sinergi/'.$this->slug;
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'gallery_images' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->resolveImageUrl($this->image);
    }

    public function getGalleryUrlsAttribute(): array
    {
        $paths = array_values(array_unique(array_filter([$this->image, ...($this->gallery_images ?? [])])));

        return $paths === []
            ? [$this->image_url]
            : array_map(fn (string $path): string => $this->resolveImageUrl($path), $paths);
    }

    public function getBrochureUrlAttribute(): ?string
    {
        return $this->brochure ? asset('storage/'.$this->brochure) : null;
    }

    private function resolveImageUrl(?string $path): string
    {
        if (! $path) {
            return asset('assets/images/products.png');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/') || str_starts_with($path, 'assets/')) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/'.ltrim($path, '/'));
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
