<?php

namespace App\Services\Admin;

use App\Models\Tutorial;
use App\Repositories\Admin\TutorialRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TutorialService
{
    public function __construct(private readonly TutorialRepository $repository) {}

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function findById(int $id): ?Tutorial
    {
        return $this->repository->findById($id);
    }

    public function findBySlug(string $slug): ?Tutorial
    {
        return $this->repository->findBySlug($slug);
    }

    public function getPublished(?string $search = null, ?string $type = null): Collection
    {
        return $this->repository->getPublished($search, $type);
    }

    public function getFeaturedOrLatest(int $limit = 3): Collection
    {
        return $this->repository->getFeaturedOrLatest($limit);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data, ?UploadedFile $imageFile = null): Tutorial
    {
        $data['slug'] = $this->generateUniqueSlug($data['slug'] ?? $data['title']);

        if ($imageFile) {
            $data['image'] = $this->uploadImage($imageFile);
        }

        if (($data['status'] ?? 'published') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->repository->create($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Tutorial $tutorial, array $data, ?UploadedFile $imageFile = null): bool
    {
        $data['slug'] = $this->generateUniqueSlug(
            ! empty($data['slug']) ? $data['slug'] : $data['title'],
            $tutorial->id
        );

        if ($imageFile) {
            $this->deleteImageFile($tutorial->image);
            $data['image'] = $this->uploadImage($imageFile);
        }

        if (($data['status'] ?? 'published') === 'published' && empty($tutorial->published_at) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->repository->update($tutorial, $data);
    }

    public function delete(Tutorial $tutorial): bool
    {
        $this->deleteImageFile($tutorial->image);

        return $this->repository->delete($tutorial);
    }

    public function uploadImage(UploadedFile $file): string
    {
        return $file->store('tutorials', 'public');
    }

    public function deleteImageFile(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'images/') && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        if (empty($baseSlug)) {
            $baseSlug = 'tutorial-' . Str::lower(Str::random(6));
        }

        $slug = $baseSlug;
        $count = 1;

        while (Tutorial::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}

