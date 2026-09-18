<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\Admin\ArticleService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleService $articleService) {}

    public function index(Request $request): View
    {
        $search = $request->query('q');
        $category = $request->query('category');

        $articles = $this->articleService->getPublished($search, $category);

        $categories = Article::published()
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('articles.index', compact('articles', 'categories', 'search', 'category'));
    }

    public function show(string $slug): View
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $recentArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('articles.show', compact('article', 'recentArticles'));
    }
}

