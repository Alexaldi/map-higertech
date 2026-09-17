@extends('admin.layouts.app')
@section('title', 'Mitra & Klien | Higertech Karya Sinergi')
@section('content')
    <div class="row mt-4">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ isset($client) ? 'Edit Mitra Klien' : 'Tambah Mitra Klien' }}</h4>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($client) ? route('admin.clients.update', $client) : route('admin.clients.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($client)
                            @method('PUT')
                        @endisset

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label font-weight-semibold">Nama Instansi / Mitra
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $client->name ?? '') }}"
                                        placeholder="contoh: BALAI WILAYAH SUNGAI BANGKA BELITUNG" required>
                                    @error('name')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="sub" class="form-label font-weight-semibold">Kementerian / Dinas
                                        Naungan <span class="text-muted fs-12">(opsional)</span></label>
                                    <input type="text" class="form-control @error('sub') is-invalid @enderror"
                                        id="sub" name="sub" value="{{ old('sub', $client->sub ?? '') }}"
                                        placeholder="contoh: Kementerian Pekerjaan Umum dan Perumahan Rakyat">
                                    @error('sub')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="logo" class="form-label font-weight-semibold">Upload Gambar Logo
                                        Mitra</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        id="logo" name="logo" accept="image/png,image/jpeg,image/svg+xml,image/webp"
                                        onchange="previewLogo(this)">
                                    <small class="text-muted d-block mt-1">Disarankan gambar logo dengan background
                                        transparan (PNG atau SVG), rasio horizontal atau landscape, maks. 2MB.</small>
                                    @error('logo')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror

                                    {{-- Preview Box --}}
                                    <div id="logo-preview-container"
                                        class="mt-3 p-3 rounded-3 bg-dark text-center {{ isset($client) && $client->logo_url ? '' : 'd-none' }}"
                                        style="max-width: 320px; border: 1px solid #334155;">
                                        <span class="text-muted fs-12 d-block mb-2">Preview Logo:</span>
                                        <img id="logo-preview-img"
                                            src="{{ isset($client) && $client->logo_url ? $client->logo_url : '' }}"
                                            alt="Preview Logo" class="img-fluid"
                                            style="max-height: 55px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="order" class="form-label font-weight-semibold">Urutan Tampil <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                        id="order" name="order" value="{{ old('order', $client->order ?? 0) }}"
                                        min="0" required>
                                    <small class="text-muted">Makin kecil angkanya, makin awal munculnya.</small>
                                    @error('order')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                        name="is_active" value="1"
                                        {{ old('is_active', $client->is_active ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-semibold" for="is_active">Aktifkan mitra
                                        (ditampilkan di halaman Home)</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($client) ? 'Perbarui Mitra' : 'Simpan Mitra' }}
                            </button>
                            <a href="{{ route('admin.clients.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewLogo(input) {
            const container = document.getElementById('logo-preview-container');
            const preview = document.getElementById('logo-preview-img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
