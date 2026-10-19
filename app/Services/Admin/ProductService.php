<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class ProductService
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository) {}

    public function getAll(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function create(array $data, ?UploadedFile $image = null): Product
    {
        return $this->save(null, $data, $image);
    }

    public function update(Product $product, array $data, ?UploadedFile $image = null): Product
    {
        return $this->save($product, $data, $image);
    }

    public function delete(Product $product): void
    {
        DB::transaction(function () use ($product) {
            $product = Product::lockForUpdate()->findOrFail($product->id);
            $files = [$product->image, ...($product->gallery_images ?? []), $product->brochure];
            $this->productRepository->delete($product);
            DB::afterCommit(fn () => $this->deleteFiles($files));
        });
    }

    private function save(?Product $product, array $data, ?UploadedFile $image): Product
    {
        $newFiles = [];

        try {
            return DB::transaction(function () use ($product, $data, $image, &$newFiles) {
                if ($product) {
                    $product = Product::lockForUpdate()->findOrFail($product->id);
                }
                $before = [$product?->image, ...($product?->gallery_images ?? []), $product?->brochure];
                $uploads = $data['gallery_images'] ?? [];
                $brochure = $data['brochure'] ?? null;
                $gallery = array_values(array_diff($product?->gallery_images ?? [], $data['remove_gallery_images'] ?? []));
                $primary = ! empty($data['remove_image']) ? null : ($product?->image ?: null);
                $brochurePath = ! empty($data['remove_brochure']) ? null : $product?->brochure;

                if (count($gallery) + count($uploads) + (int) ($image !== null || $primary !== null) > 5) {
                    throw ValidationException::withMessages(['gallery_images' => 'Maksimal 5 gambar per produk, termasuk gambar utama. Hapus foto lama sebelum menambah foto baru.']);
                }

                unset($data['image'], $data['gallery_images'], $data['brochure'], $data['remove_image'], $data['remove_gallery_images'], $data['remove_brochure']);
                $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['title'], $product?->id);
                if (empty($data['inaproc_link'])) {
                    $data['inaproc_link'] = 'https://katalog.inaproc.id/higertech-karya-sinergi/'.$data['slug'];
                }

                if ($image) {
                    $primary = $this->storeFile($image, 'products', $newFiles);
                }
                foreach ($uploads as $upload) {
                    $gallery[] = $this->storeFile($upload, 'products', $newFiles);
                }
                if (! $primary && $gallery !== []) {
                    $primary = array_shift($gallery);
                }
                if ($brochure) {
                    $brochurePath = $this->storeFile($brochure, 'products/brochures', $newFiles);
                }

                $data['image'] = $primary;
                $data['gallery_images'] = $gallery;
                $data['brochure'] = $brochurePath;
                $saved = $product
                    ? $this->productRepository->update($product, $data)
                    : $this->productRepository->create($data);
                $removed = array_diff(array_filter($before), array_filter([$primary, ...$gallery, $brochurePath]));
                DB::afterCommit(fn () => $this->deleteFiles($removed));

                return $saved;
            });
        } catch (Throwable $exception) {
            $this->deleteFiles($newFiles);
            throw $exception;
        }
    }

    private function resolveSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug ?: $title);
        $unique = $base;
        $counter = 1;

        while (
            Product::where('slug', $unique)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $unique = "{$base}-{$counter}";
            $counter++;
        }

        return $unique;
    }

    private function storeFile(UploadedFile $file, string $directory, array &$newFiles): string
    {
        $path = $file->store($directory, 'public');
        if ($path === false) {
            throw new RuntimeException('File produk gagal disimpan.');
        }
        $newFiles[] = $path;

        return $path;
    }

    private function deleteFiles(array $paths): void
    {
        foreach (array_unique(array_filter($paths)) as $path) {
            // Only managed uploads may be deleted, never public assets or external URLs.
            if (! str_starts_with($path, 'products/') || str_contains($path, '..') || str_contains($path, '\\')) {
                continue;
            }
            try {
                $referenced = Product::where('image', $path)->orWhere('brochure', $path)->orWhereJsonContains('gallery_images', $path)->exists();
                if (! $referenced) {
                    Storage::disk('public')->delete($path);
                }
            } catch (Throwable $exception) {
                report($exception);
            }
        }
    }

    public function getActiveProducts(?int $categoryId = null): Collection
    {
        return $this->productRepository->getActive($categoryId);
    }

    public function getActivePaginated(?int $categoryId = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->productRepository->getActivePaginated($categoryId, $perPage);
    }
}
