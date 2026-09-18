<?php

namespace App\Repositories\Admin;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository
{
    public function getAll(): Collection
    {
        return Article::with('categoryRelation')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function findById(int $id): ?Article
    {
        return Article::with('categoryRelation')->find($id);
    }

    public function findBySlug(string $slug): ?Article
    {
        return Article::with('categoryRelation')
            ->where('slug', $slug)
            ->first();
    }

    public function getPublished(?string $search = null, ?string $category = null): Collection
    {
        return Article::published()
            ->with('categoryRelation')
            ->when($category, function ($query, $category) {
                $query->where(function ($q) use ($category) {
                    $q->where('category', $category)
                      ->orWhereHas('categoryRelation', function ($sub) use ($category) {
                          $sub->where('name', $category);
                      });
                });
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->orderByRaw('published_at IS NULL, published_at DESC')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getFeatured(int $limit = 4): Collection
    {
        return Article::published()
            ->featured()
            ->with('categoryRelation')
            ->orderByRaw('published_at IS NULL, published_at DESC')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    public function create(array $data): Article
    {
        return Article::create($data);
    }

    public function update(Article $article, array $data): bool
    {
        return $article->update($data);
    }

    public function delete(Article $article): bool
    {
        return (bool) $article->delete();
    }
}

