@extends('admin.layouts.app')
@section('title', (isset($product) ? 'Edit Produk' : 'Tambah Produk') . ' | Higertech Karya Sinergi')
@section('content')

<div class="row mt-4">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">

        <div class="card">

            <div class="card-header">
                <h4 class="card-title">
                    {{ isset($product) ? 'Edit Produk' : 'Tambah Produk' }}
                </h4>
            </div>

            <div class="card-body">

                <form
                    action="{{ isset($product)
                        ? route('admin.products.update', $product)
                        : route('admin.products.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf

                    @if(isset($product))
                        @method('PUT')
                    @endif

                    <div class="row">

                        {{-- Judul Produk --}}
                        <div class="col-md-8">
                            <div class="form-group">

                                <label for="title" class="form-label">
                                    Judul Produk
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    name="title"
                                    value="{{ old('title', $product->title ?? '') }}"
                                    placeholder="Masukkan judul produk"
                                    onkeyup="generateSlug(this.value)"
                                >

                                @error('title')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        {{-- Slug --}}
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="slug" class="form-label">
                                    Slug URL
                                    <span class="text-muted fs-12">(otomatis jika dikosongkan)</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    id="slug"
                                    name="slug"
                                    value="{{ old('slug', $product->slug ?? '') }}"
                                    placeholder="contoh: website-sistem-informasi-hidrologi"
                                >

                                <small class="text-muted fs-12">Dipakai sebagai URL halaman produk, harus unik dan tanpa spasi.</small>

                                @error('slug')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        {{-- Kategori --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="category_id" class="form-label">
                                    Kategori
                                </label>

                                <select
                                    class="form-control @error('category_id') is-invalid @enderror"
                                    id="category_id"
                                    name="category_id"
                                >
                                    <option value="" disabled {{ old('category_id', $product->category_id ?? '') === '' ? 'selected' : '' }}>
                                        -- Pilih Kategori --
                                    </option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        {{-- Link E-Katalog INAPROC --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-2">
                                    <label for="inaproc_link" class="form-label mb-0">
                                        Link Detail Produk di E-Katalog INAPROC LKPP
                                    </label>
                                    @if(isset($product) && $product->inaproc_link)
                                        <a href="{{ $product->inaproc_link }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-danger py-1 px-2.5 fs-12">
                                            <i class="fe fe-external-link me-1"></i> Buka Halaman Produk di INAPROC Asli
                                        </a>
                                    @endif
                                </div>
                                <input
                                    type="url"
                                    class="form-control @error('inaproc_link') is-invalid @enderror"
                                    id="inaproc_link"
                                    name="inaproc_link"
                                    value="{{ old('inaproc_link', $product->inaproc_link ?? '') }}"
                                    placeholder="Contoh: https://katalog.inaproc.id/higertech-karya-sinergi/perangkat-telemetri-cctv-capture-x"
                                >
                                <small class="text-muted fs-12">Format URL ke halaman detail spesifik di Inaproc: <code>https://katalog.inaproc.id/higertech-karya-sinergi/{slug-produk}</code>. Klik tombol di atas untuk melihat foto & spesifikasi aslinya di Inaproc.</small>
                                @error('inaproc_link')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-md-12">
                            <div class="form-group">

                                <label for="desc" class="form-label">
                                    Deskripsi
                                    <span class="text-muted fs-12">(opsional)</span>
                                </label>

                                <textarea
                                    class="form-control @error('desc') is-invalid @enderror"
                                    id="desc"
                                    name="desc"
                                    rows="4"
                                    placeholder="Masukkan deskripsi produk"
                                >{{ old('desc', $product->desc ?? '') }}</textarea>

                                @error('desc')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        {{-- Gambar Produk --}}
                        <div class="col-md-12">
                            <div class="form-group">

                                <label for="image" class="form-label">
                                    Gambar Produk
                                </label>

                                <input
                                    type="file"
                                    class="form-control @error('image') is-invalid @enderror"
                                    id="image"
                                    name="image"
                                    accept="image/png,image/jpeg,image/jpg,image/webp"
                                    onchange="previewProductImage(this)"
                                >

                                <small class="text-muted d-block mt-1">
                                    Format PNG, JPG, atau WEBP, maks 3MB.
                                </small>

                                @error('image')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                                {{-- Preview Box --}}
                                <div id="image-empty-notice" class="text-muted fs-12 mt-2" style="{{ isset($product) && $product->image ? 'display:none;' : '' }}">
                                    gambar belum di unggah
                                </div>

                                <div
                                    id="image-preview-container"
                                    style="max-width: 380px; {{ isset($product) && $product->image ? '' : 'display:none;' }}"
                                    class="mt-3 p-2 border bg-light"
                                >
                                    <span class="text-muted fs-12 d-block mb-1 fw-semibold">Preview Gambar:</span>
                                    <img
                                        id="image-preview-img"
                                        src="{{ isset($product) && $product->image ? $product->image_url : '' }}"
                                        alt="Preview Gambar"
                                        class="img-fluid"
                                        style="max-height: 220px; width: 100%; object-fit: contain; display: block; cursor: pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imagePreviewModal"
                                    >
                                </div>

                            </div>
                        </div>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary mt-3 mb-0"
                    >
                        {{ isset($product) ? 'Perbarui Produk' : 'Simpan Produk' }}
                    </button>

                    <a href="{{ route('admin.products.index') }}"
                        class="btn btn-light mt-3 mb-0 ms-2"
                    >
                        Batal
                    </a>

                </form>

            </div>

        </div>

    </div>
</div>

{{-- Modal Preview Gambar --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title mb-0">Preview Gambar Produk</h5>
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fe fe-x"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modal-preview-img" src="" alt="Preview Gambar" class="img-fluid">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let slugEditedManually = {{ isset($product) ? 'true' : 'false' }};
    let inaprocEditedManually = {{ isset($product) && !empty($product->inaproc_link) ? 'true' : 'false' }};
    const slugInput = document.getElementById('slug');
    const inaprocInput = document.getElementById('inaproc_link');

    if (slugInput) {
        slugInput.addEventListener('input', function() {
            slugEditedManually = true;
        });
    }

    if (inaprocInput) {
        inaprocInput.addEventListener('input', function() {
            inaprocEditedManually = true;
        });
    }

    function generateSlug(text) {
        const slug = text.toString().toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');

        if (!slugEditedManually && slugInput) {
            slugInput.value = slug;
        }

        if (!inaprocEditedManually && inaprocInput) {
            inaprocInput.value = slug ? ('https://katalog.inaproc.id/higertech-karya-sinergi/' + slug) : '';
        }
    }

    // simpan preview ke sessionStorage tiap kali pilih gambar
    function previewProductImage(input) {
        const container = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview-img');
        const modalPreview = document.getElementById('modal-preview-img');
        const emptyNotice = document.getElementById('image-empty-notice');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                modalPreview.src = e.target.result;
                container.style.display = '';
                if (emptyNotice) emptyNotice.style.display = 'none';
                sessionStorage.setItem('product_image_preview', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // pas halaman dimuat ulang (setelah gagal validasi), tampilkan lagi preview dari sessionStorage
    document.addEventListener('DOMContentLoaded', function() {
        const saved = sessionStorage.getItem('product_image_preview');
        const hasValidationError = {{ $errors->any() ? 'true' : 'false' }};

        if (saved && hasValidationError) {
            document.getElementById('image-preview-img').src = saved;
            document.getElementById('modal-preview-img').src = saved;
            document.getElementById('image-preview-container').style.display = '';
            document.getElementById('image-empty-notice').style.display = 'none';
        } else if (!hasValidationError) {
            sessionStorage.removeItem('product_image_preview');
        }
    });
</script>
@endpush