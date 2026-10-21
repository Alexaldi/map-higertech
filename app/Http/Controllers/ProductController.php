<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService) {}

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'category' => ['nullable', 'integer', 'min:1'],
            'q' => ['nullable', 'string', 'max:100'],
        ]);
        $categoryId = $validated['category'] ?? null;
        $search = trim($validated['q'] ?? '');

        $selectedCategory = $categoryId
            ? Category::produk()->findOrFail($categoryId)
            : null;

        $categories = Category::produk()->ordered()->withCount([
            'products' => fn ($query) => $query->where('is_active', true),
        ])->get();
        $products = $this->productService->getActivePaginated($categoryId, 10, $search)->withQueryString();

        return view('products.index', compact('products', 'selectedCategory', 'categories', 'search'));
    }

    public function show(string $slug): View
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        $galleryImages = $product->gallery_urls;

        return view('products.show', compact('product', 'relatedProducts', 'galleryImages'));
    }
}
