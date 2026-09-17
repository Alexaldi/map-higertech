<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientPartner;
use App\Services\Admin\ClientPartnerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientPartnerController extends Controller
{
    public function __construct(private readonly ClientPartnerService $clientService) {}

    public function index(): View
    {
        $clients = $this->clientService->getAll();

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('admin.clients.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->clientService->create(
            $this->validatedData($request),
            $request->file('logo')
        );

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Mitra klien berhasil ditambahkan.');
    }

    public function edit(ClientPartner $client): View
    {
        return view('admin.clients.form', compact('client'));
    }

    public function update(Request $request, ClientPartner $client): RedirectResponse
    {
        $this->clientService->update(
            $client,
            $this->validatedData($request),
            $request->file('logo')
        );

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Mitra klien berhasil diperbarui.');
    }

    public function destroy(ClientPartner $client): RedirectResponse
    {
        $this->clientService->delete($client);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Mitra klien berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sub' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
            'order' => ['required', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ], [
            'name.required' => 'Nama instansi/mitra wajib diisi.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo yang diizinkan: PNG, JPG, JPEG, SVG, WEBP.',
            'logo.max' => 'Ukuran file logo maksimal 2MB.',
            'order.required' => 'Nomor urutan tampil wajib diisi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
