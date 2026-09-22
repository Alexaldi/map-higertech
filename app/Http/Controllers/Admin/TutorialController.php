<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutorial;
use App\Services\Admin\TutorialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TutorialController extends Controller
{
    public function __construct(private readonly TutorialService $tutorialService) {}

    public function index(): View
    {
        $tutorials = $this->tutorialService->getAll();

        return view('admin.tutorials.index', compact('tutorials'));
    }

    public function create(): View
    {
        return view('admin.tutorials.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $this->tutorialService->create($validated, $request->file('image'));

        return redirect()
            ->route('admin.tutorials.index')
            ->with('success', 'Tutorial berhasil ditambahkan.');
    }

    public function edit(Tutorial $tutorial): View
    {
        return view('admin.tutorials.form', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial): RedirectResponse
    {
        $validated = $this->validatedData($request, $tutorial->id);

        $this->tutorialService->update($tutorial, $validated, $request->file('image'));

        return redirect()
            ->route('admin.tutorials.index')
            ->with('success', 'Tutorial berhasil diperbarui.');
    }

    public function destroy(Tutorial $tutorial): RedirectResponse
    {
        $this->tutorialService->delete($tutorial);

        return redirect()
            ->route('admin.tutorials.index')
            ->with('success', 'Tutorial berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?int $tutorialId = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:100'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ], [
            'title.required' => 'Judul tutorial wajib diisi.',
            'image.image' => 'File harus berupa gambar valid.',
            'image.mimes' => 'Format gambar yang diizinkan: JPG, JPEG, PNG, WEBP, SVG.',
            'image.max' => 'Ukuran gambar maksimal 3MB.',
            'video_url.url' => 'URL video harus berupa alamat URL yang valid.',
            'status.in' => 'Status harus bernilai draf atau publik.',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        return $validated;
    }
}

