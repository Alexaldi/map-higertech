<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Services\Admin\ArticleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleService $articleService) {}

    public function index(): View
    {
        $articles = $this->articleService->getAll();

        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.articles.form', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $this->articleService->create(
            $validated,
            $request->file('image')
        );

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.articles.form', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $this->validatedData($request, $article->id);

        $this->articleService->update(
            $article,
            $validated,
            $request->file('image')
        );

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->articleService->delete($article);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?int $articleId = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'category' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'author' => ['nullable', 'string', 'max:255'],
            'read_time' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'content.required' => 'Konten artikel tidak boleh kosong.',
            'image.image' => 'File harus berupa gambar valid.',
            'image.mimes' => 'Format gambar yang diizinkan: JPG, JPEG, PNG, WEBP, SVG.',
            'image.max' => 'Ukuran gambar maksimal 3MB.',
            'status.in' => 'Status artikel harus bernilai draf atau publik.',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        // If category_id is selected, synchronize the category name string as well
        if (! empty($validated['category_id'])) {
            $cat = Category::find($validated['category_id']);
            if ($cat) {
                $validated['category'] = $cat->name;
            }
        }

        return $validated;
    }
}

