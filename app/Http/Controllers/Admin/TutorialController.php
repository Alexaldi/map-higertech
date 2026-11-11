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

        try {
            $this->tutorialService->create($validated, $request->file('image'), $request->file('document'));
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan tutorial: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.tutorials.index')
            ->with('success', 'Tutorial berhasil ditambahkan.');
    }

    public function show(Tutorial $tutorial): RedirectResponse
    {
        if ($tutorial->status !== 'published') {
            return redirect()->route('admin.tutorials.edit', $tutorial);
        }

        return redirect()->route('tutorials.show', $tutorial->slug);
    }

    public function edit(Tutorial $tutorial): View
    {
        return view('admin.tutorials.form', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial): RedirectResponse
    {
        $validated = $this->validatedData($request, $tutorial->id);

        try {
            $this->tutorialService->update($tutorial, $validated, $request->file('image'), $request->file('document'));
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui tutorial: ' . $e->getMessage());
        }

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
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'remove_image' => ['sometimes', 'boolean'],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'remove_document' => ['sometimes', 'boolean'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ], [
            'title.required' => 'Judul tutorial wajib diisi.',
            'image.file' => 'File harus berupa file valid.',
            'image.uploaded' => 'Gagal mengunggah gambar sampul. Pastikan ukuran file tidak melebihi batas upload server.',
            'image.mimes' => 'Format gambar yang diizinkan: JPG, JPEG, PNG, WEBP, SVG.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
            'document.file' => 'Dokumen harus berupa file valid.',
            'document.uploaded' => 'Gagal mengunggah dokumen. Pastikan ukuran file tidak melebihi batas upload server.',
            'document.mimes' => 'Dokumen / manual instalasi harus berformat PDF.',
            'document.max' => 'Ukuran file dokumen / manual instalasi maksimal 10MB.',
            'video_url.url' => 'URL video harus berupa alamat URL yang valid.',
            'status.in' => 'Status harus bernilai draf atau publik.',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['remove_image'] = $request->boolean('remove_image');
        $validated['remove_document'] = $request->boolean('remove_document');

        return $validated;
    }
}

