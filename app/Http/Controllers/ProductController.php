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

        $products = $this->productService->getActiveProducts($categoryId);

        return view('products.index', compact('products', 'selectedCategory'));
    }
}