<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository) {}

    public function getAll(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function create(array $data, ?UploadedFile $image = null): Product
    {
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['title']);

        if ($image) {
            $data['image'] = $this->storeImage($image);
        }

        return $this->productRepository->create($data);
    }

    public function update(Product $product, array $data, ?UploadedFile $image = null): Product
    {
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['title'], $product->id);

        if ($image) {
            $this->deleteImage($product);
            $data['image'] = $this->storeImage($image);
        }

        return $this->productRepository->update($product, $data);
    }

    public function delete(Product $product): void
    {
        $this->deleteImage($product);
        $this->productRepository->delete($product);
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

    private function storeImage(UploadedFile $image): string
    {
        return $image->store('products', 'public');
    }

    private function deleteImage(Product $product): void
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
    }

    public function getActiveProducts(?int $categoryId = null): Collection
    {
        return $this->productRepository->getActive($categoryId);
    }
}