<?php

namespace App\Repositories\Admin;

use App\Models\Tutorial;
use Illuminate\Database\Eloquent\Collection;

class TutorialRepository
{
    public function getAll(): Collection
    {
        return Tutorial::orderBy('id', 'desc')->get();
    }

    public function findById(int $id): ?Tutorial
    {
        return Tutorial::find($id);
    }

    public function findBySlug(string $slug): ?Tutorial
    {
        return Tutorial::where('slug', $slug)->first();
    }

    public function getPublished(?string $search = null, ?string $type = null): Collection
    {
        return Tutorial::published()
            ->when($type, fn ($q) => $q->where('type', $type))
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->orderByRaw('published_at IS NULL, published_at DESC')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getFeaturedOrLatest(int $limit = 3): Collection
    {
        $featured = Tutorial::published()->featured()
            ->orderByRaw('published_at IS NULL, published_at DESC')
            ->limit($limit)
            ->get();

        if ($featured->count() < $limit) {
            $existingIds = $featured->pluck('id')->toArray();
            $additional = Tutorial::published()
                ->whereNotIn('id', $existingIds)
                ->orderByRaw('published_at IS NULL, published_at DESC')
                ->limit($limit - $featured->count())
                ->get();

            return $featured->concat($additional);
        }

        return $featured;
    }

    public function create(array $data): Tutorial
    {
        return Tutorial::create($data);
    }

    public function update(Tutorial $tutorial, array $data): bool
    {
        return $tutorial->update($data);
    }

    public function delete(Tutorial $tutorial): bool
    {
        return (bool) $tutorial->delete();
    }
}

