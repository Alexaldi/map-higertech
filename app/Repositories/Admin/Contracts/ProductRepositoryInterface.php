<?php

namespace App\Repositories\Admin\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): Product;

    public function create(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function delete(Product $product): void;
    
    public function getActive(?int $categoryId = null): Collection;

    public function getActivePaginated(?int $categoryId = null, int $perPage = 10): LengthAwarePaginator;
}