<?php

namespace App\Repositories\Admin;

use App\Models\Product;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(): Collection
    {
        return Product::with('category')->latest()->get();
    }

    public function findById(int $id): Product
    {
        return Product::with('category')->findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function getActive(?int $categoryId = null): Collection
    {
        return Product::with('category')
            ->active()
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->latest()
            ->get();
    }
}