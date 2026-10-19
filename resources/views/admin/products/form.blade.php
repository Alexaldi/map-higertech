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
                    <input type="hidden" name="is_active" value="{{ old('is_active', $product->is_active ?? true) ? '1' : '0' }}">

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
                                    Gambar Utama Produk
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
                                    Format PNG, JPG, atau WEBP, maksimal 2 MB dan 6000 × 6000 piksel.
                                </small>

                                @error('image')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @if (isset($product) && $product->image)
                                    <label class="d-block mt-2">
                                        <input type="checkbox" name="remove_image" id="remove-image" value="1" {{ old('remove_image') ? 'checked' : '' }}>
                                        Hapus gambar utama (foto galeri pertama akan menjadi gambar utama).
                                    </label>
                                @endif

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

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="gallery-images" class="form-label">Foto Galeri Tambahan</label>
                                <input type="file" name="gallery_images[]" id="gallery-images" class="form-control" accept="image/png,image/jpeg,image/webp" multiple aria-describedby="gallery-help">
                                <small id="gallery-help" class="text-muted d-block mt-1">Maksimal 5 foto total termasuk gambar utama, 2 MB per foto, dimensi maksimal 6000 × 6000 piksel. Upload kosong mempertahankan foto lama.</small>
                                @error('gallery_images')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                @foreach ($errors->get('gallery_images.*') as $messages)
                                    @foreach ($messages as $message)<div class="text-danger mt-1">{{ $message }}</div>@endforeach
                                @endforeach
                                @error('remove_gallery_images.*')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                <div class="d-flex flex-wrap gap-3 mt-3">
                                    @foreach ($product->gallery_images ?? [] as $path)
                                        <div data-existing-gallery class="border rounded p-2" style="width: 140px;">
                                            <img src="{{ asset('storage/'.$path) }}" alt="Foto galeri {{ $loop->iteration }}" loading="lazy" class="w-100" style="height: 100px; object-fit: contain;">
                                            <label class="d-block mt-2 mb-0 fs-12">
                                                <input type="checkbox" name="remove_gallery_images[]" value="{{ $path }}" {{ in_array($path, old('remove_gallery_images', []), true) ? 'checked' : '' }}> Hapus foto ini
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="gallery-preview" class="d-flex flex-wrap gap-2 mt-3" aria-live="polite"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="brochure" class="form-label">Brosur Produk (PDF)</label>
                                <input type="file" name="brochure" id="brochure" class="form-control @error('brochure') is-invalid @enderror" accept="application/pdf,.pdf" aria-describedby="brochure-help">
                                <small id="brochure-help" class="text-muted d-block mt-1">Opsional, maksimal 5 MB. Pilih PDF baru untuk mengganti brosur; biarkan kosong untuk mempertahankannya.</small>
                                @error('brochure')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                @if (isset($product) && $product->brochure_url)
                                    <a href="{{ $product->brochure_url }}" download="{{ $product->slug }}-brosur.pdf" class="d-inline-block mt-2">Unduh brosur saat ini</a>
                                    <label class="d-block mt-2">
                                        <input type="checkbox" name="remove_brochure" value="1" {{ old('remove_brochure') ? 'checked' : '' }}> Hapus brosur saat ini
                                    </label>
                                @endif
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

    let mainPreviewUrl;
    function previewProductImage(input) {
        const container = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview-img');
        const modalPreview = document.getElementById('modal-preview-img');
        const emptyNotice = document.getElementById('image-empty-notice');
        if (input.files && input.files[0]) {
            if (mainPreviewUrl) URL.revokeObjectURL(mainPreviewUrl);
            mainPreviewUrl = URL.createObjectURL(input.files[0]);
            preview.src = modalPreview.src = mainPreviewUrl;
            container.style.display = '';
            if (emptyNotice) emptyNotice.style.display = 'none';
        }
    }

    const galleryInput = document.getElementById('gallery-images');
    const imageInput = document.getElementById('image');
    const brochureInput = document.getElementById('brochure');
    let galleryPreviewUrls = [];

    function validateMedia() {
        const retainedGallery = [...document.querySelectorAll('[data-existing-gallery] input')].filter(input => !input.checked).length;
        const hasPrimary = imageInput.files.length > 0 || ({{ isset($product) && $product->image ? 'true' : 'false' }} && !document.getElementById('remove-image')?.checked);
        const count = Number(hasPrimary) + retainedGallery + galleryInput.files.length;
        galleryInput.setCustomValidity(count > 5 ? 'Maksimal 5 foto total. Hapus foto lama sebelum menambah foto baru.' : '');
        if ([...galleryInput.files].some(file => file.size > 2 * 1024 * 1024)) {
            galleryInput.setCustomValidity('Ukuran setiap foto maksimal 2 MB.');
        }
        imageInput.setCustomValidity(imageInput.files[0]?.size > 2 * 1024 * 1024 ? 'Ukuran gambar utama maksimal 2 MB.' : '');
        brochureInput.setCustomValidity(brochureInput.files[0]?.size > 5 * 1024 * 1024 ? 'Ukuran PDF maksimal 5 MB.' : '');
    }

    galleryInput.addEventListener('change', () => {
        galleryPreviewUrls.forEach(url => URL.revokeObjectURL(url));
        galleryPreviewUrls = [];
        const container = document.getElementById('gallery-preview');
        container.replaceChildren();
        // Preview only the accepted-size files, with no base64 copies in browser storage.
        [...galleryInput.files].slice(0, 5).filter(file => file.size <= 2 * 1024 * 1024).forEach(file => {
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            galleryPreviewUrls.push(image.src);
            image.alt = file.name;
            image.style.cssText = 'width:100px;height:100px;object-fit:contain;border:1px solid #ddd;border-radius:6px';
            container.append(image);
        });
    });
    [galleryInput, imageInput, brochureInput, ...document.querySelectorAll('[name="remove_gallery_images[]"], #remove-image')].forEach(input => input.addEventListener('change', validateMedia));
    validateMedia();
    document.getElementById('image-preview-img').addEventListener('click', function () {
        document.getElementById('modal-preview-img').src = this.src;
    });
</script>
@endpush
