<?php

namespace App\Services\Admin;

use App\Models\Article;
use App\Repositories\Admin\ArticleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleService
{
    public function __construct(private readonly ArticleRepository $repository) {}

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function findById(int $id): ?Article
    {
        return $this->repository->findById($id);
    }

    public function findBySlug(string $slug): ?Article
    {
        return $this->repository->findBySlug($slug);
    }

    public function getPublished(?string $search = null, ?string $category = null): Collection
    {
        return $this->repository->getPublished($search, $category);
    }

    public function getFeaturedOrLatest(int $limit = 4): Collection
    {
        $featured = $this->repository->getFeatured($limit);

        if ($featured->count() < $limit) {
            $existingIds = $featured->pluck('id')->toArray();
            $needed = $limit - $featured->count();

            $additional = Article::published()
                ->whereNotIn('id', $existingIds)
                ->with('categoryRelation')
                ->orderByRaw('published_at IS NULL, published_at DESC')
                ->orderBy('id', 'desc')
                ->limit($needed)
                ->get();

            return $featured->concat($additional);
        }

        return $featured;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data, ?UploadedFile $imageFile = null): Article
    {
        $data['slug'] = $this->generateUniqueSlug($data['slug'] ?? $data['title']);

        if ($imageFile) {
            $data['image'] = $this->uploadImage($imageFile);
        }

        if (empty($data['author'])) {
            $data['author'] = 'Tim Higertech';
        }

        if (empty($data['read_time'])) {
            $data['read_time'] = $this->estimateReadTime($data['content'] ?? '');
        }

        if (($data['status'] ?? 'published') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->repository->create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Article $article, array $data, ?UploadedFile $imageFile = null): bool
    {
        $targetSlug = ! empty($data['slug']) ? $data['slug'] : $data['title'];
        $data['slug'] = $this->generateUniqueSlug($targetSlug, $article->id);

        if ($imageFile) {
            $this->deleteImageFile($article->image);
            $data['image'] = $this->uploadImage($imageFile);
        }

        if (empty($data['read_time'])) {
            $data['read_time'] = $this->estimateReadTime($data['content'] ?? '');
        }

        if (($data['status'] ?? 'published') === 'published' && empty($article->published_at) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->repository->update($article, $data);
    }

    public function delete(Article $article): bool
    {
        $this->deleteImageFile($article->image);

        return $this->repository->delete($article);
    }

    public function uploadImage(UploadedFile $file): string
    {
        return $file->store('articles', 'public');
    }

    public function deleteImageFile(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'images/') && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function estimateReadTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = (int) ceil($wordCount / 200);

        return max(1, $minutes);
    }

    public function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        if (empty($baseSlug)) {
            $baseSlug = 'artikel-' . Str::lower(Str::random(6));
        }

        $slug = $baseSlug;
        $count = 1;

        while (Article::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}

