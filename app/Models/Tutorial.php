<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tutorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'document',
        'video_url',
        'duration',
        'status',
        'is_featured',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'duration' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('images/articles/aws-guide.png');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function getDocumentUrlAttribute(): ?string
    {
        if (! $this->document) {
            return null;
        }

        if (str_starts_with($this->document, 'http://') || str_starts_with($this->document, 'https://')) {
            return $this->document;
        }

        return asset('storage/' . ltrim($this->document, '/'));
    }

    public function getDocumentDownloadNameAttribute(): string
    {
        $title = trim(preg_replace('/\s+/u', ' ', preg_replace('/[\\\\\/:*?"<>|\x00-\x1F]+/u', ' ', (string) $this->title)));

        return trim('Manual-'.$title).'.pdf';
    }

    public function getDocumentSizeFormattedAttribute(): ?string
    {
        if (! $this->document || str_starts_with($this->document, 'http://') || str_starts_with($this->document, 'https://')) {
            return null;
        }

        try {
            if (! Storage::disk('public')->exists($this->document)) {
                return null;
            }

            $bytes = Storage::disk('public')->size($this->document);
            $units = ['B', 'KB', 'MB', 'GB'];
            $i = 0;
            while ($bytes >= 1024 && $i < count($units) - 1) {
                $bytes /= 1024;
                $i++;
            }

            return round($bytes, 2) . ' ' . $units[$i];
        } catch (\Throwable) {
            return null;
        }
    }

    public function getDurationTextAttribute(): string
    {
        return ($this->duration ?: 5) . ' menit';
    }

    public function getFormattedDateAttribute(): string
    {
        $date = $this->published_at ?? $this->created_at ?? now();

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $carbon = Carbon::parse($date);

        return sprintf('%02d %s %04d', $carbon->day, $months[$carbon->month], $carbon->year);
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}

