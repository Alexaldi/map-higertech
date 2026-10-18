<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService) {}

    public function index(Request $request): View
    {
        $categoryId = $request->integer('category') ?: null;

        $selectedCategory = $categoryId
            ? Category::produk()->find($categoryId)
            : null;

        $categories = Category::produk()->ordered()->get();
        $products = $this->productService->getActivePaginated($categoryId, 10)->withQueryString();

        return view('products.index', compact('products', 'selectedCategory', 'categories'));
    }

    public function show(string $slug): View
    {
        $product = \App\Models\Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = \App\Models\Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}