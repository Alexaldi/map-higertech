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
                                <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-2">
                                    <label for="gallery-images" class="form-label mb-0">Foto Galeri Tambahan</label>
                                    <span id="gallery-counter" class="gallery-counter">0 / 5 foto</span>
                                </div>
                                <small id="gallery-help" class="text-muted d-block mb-2">
                                    Maksimal 5 foto total termasuk gambar utama, 2 MB per foto, dimensi maksimal 6000 × 6000 piksel.
                                    Klik <b>Tambah Foto</b> berkali-kali atau seret file ke kotak untuk menambah; gunakan <b>Ganti</b> untuk mengganti foto tertentu.
                                </small>
                                @error('gallery_images')<div class="text-danger mt-1 fs-12">{{ $message }}</div>@enderror
                                @foreach ($errors->get('gallery_images.*') as $messages)
                                    @foreach ($messages as $message)<div class="text-danger mt-1 fs-12">{{ $message }}</div>@endforeach
                                @endforeach
                                @error('replace_gallery_images')<div class="text-danger mt-1 fs-12">{{ $message }}</div>@enderror
                                @foreach ($errors->get('replace_gallery_images.*') as $messages)
                                    @foreach ($messages as $message)<div class="text-danger mt-1 fs-12">{{ $message }}</div>@endforeach
                                @endforeach
                                @error('remove_gallery_images.*')<div class="text-danger mt-1 fs-12">{{ $message }}</div>@enderror

                                <div id="gallery-grid" class="gallery-grid" aria-live="polite">
                                    @foreach ($product->gallery_images ?? [] as $path)
                                        @php($markedRemove = in_array($path, old('remove_gallery_images', []), true))
                                        <div class="gallery-card {{ $markedRemove ? 'is-removed' : '' }}" data-existing-gallery>
                                            <span class="gallery-badge">Foto {{ $loop->iteration }}</span>
                                            <span class="gallery-status" data-status hidden></span>
                                            <img src="{{ asset('storage/'.$path) }}" data-original-src="{{ asset('storage/'.$path) }}" data-thumb alt="Foto galeri {{ $loop->iteration }}" loading="lazy" data-bs-toggle="modal" data-bs-target="#imagePreviewModal">
                                            <input type="file" class="d-none" name="replace_gallery_images[{{ $loop->index }}]" accept="image/png,image/jpeg,image/webp" data-replace-input>
                                            <input type="checkbox" class="d-none" name="remove_gallery_images[]" value="{{ $path }}" data-remove-input {{ $markedRemove ? 'checked' : '' }}>
                                            <div class="gallery-actions">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-action="replace"><i class="fe fe-refresh-cw"></i> Ganti</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-action="undo-replace" hidden><i class="fe fe-rotate-ccw"></i> Batal</button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-action="remove">{!! $markedRemove ? '<i class="fe fe-rotate-ccw"></i> Batal hapus' : '<i class="fe fe-trash-2"></i> Hapus' !!}</button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <label for="gallery-images" id="gallery-add-tile" class="gallery-card gallery-add">
                                        <i class="fe fe-plus"></i>
                                        <span>Tambah Foto</span>
                                        <small>klik atau seret file ke sini</small>
                                    </label>
                                </div>
                                <input type="file" name="gallery_images[]" id="gallery-images" class="d-none" accept="image/png,image/jpeg,image/webp" multiple aria-describedby="gallery-help">
                                <div id="gallery-error" class="text-danger mt-2 fs-12" role="alert" hidden></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="brochure" class="form-label">Brosur Produk (PDF)</label>
                                <input type="file" name="brochure" id="brochure" class="form-control @error('brochure') is-invalid @enderror" accept="application/pdf,.pdf" aria-describedby="brochure-help">
                                <small id="brochure-help" class="text-muted d-block mt-1">Opsional, maksimal 5 MB. Pilih PDF baru untuk mengganti brosur; biarkan kosong untuk mempertahankannya.</small>
                                @error('brochure')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                @if (isset($product) && $product->brochure_url)
                                    <a href="{{ $product->brochure_url }}" download="{{ $product->brochure_download_name }}" class="d-inline-block mt-2">Unduh brosur saat ini</a>
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

<style>
    .gallery-counter { font-size: 12px; font-weight: 600; padding: 2px 10px; border-radius: 999px; background: #f1f3f9; color: #495057; border: 1px solid #dee2e6; }
    .gallery-counter.is-full { background: #fff4e5; color: #b45309; border-color: #f5c27a; }
    .gallery-counter.is-over { background: #fdecec; color: #c0392b; border-color: #f1a9a0; }
    .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; }
    .gallery-card { position: relative; display: flex; flex-direction: column; border: 1px solid #dee2e6; border-radius: 8px; padding: 8px; background: #fff; transition: opacity .2s, border-color .2s; }
    .gallery-card img { width: 100%; height: 120px; object-fit: contain; background: #f8f9fa; border-radius: 6px; cursor: zoom-in; }
    .gallery-card.is-removed { opacity: .45; border-style: dashed; }
    .gallery-card.is-removed img { filter: grayscale(1); }
    .gallery-card.is-replaced { border-color: #0d6efd; }
    .gallery-card.is-new { border-color: #198754; }
    .gallery-badge, .gallery-status { position: absolute; top: 12px; font-size: 11px; font-weight: 600; padding: 1px 8px; border-radius: 999px; z-index: 1; }
    .gallery-badge { left: 12px; background: rgba(33, 37, 41, .75); color: #fff; }
    .gallery-status { right: 12px; background: #0d6efd; color: #fff; }
    .gallery-card.is-new .gallery-badge { background: #198754; }
    .gallery-card.is-removed .gallery-status { background: #dc3545; }
    .gallery-actions { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 8px; }
    .gallery-actions .btn { flex: 1 1 auto; font-size: 12px; padding: 2px 6px; }
    .gallery-add { align-items: center; justify-content: center; min-height: 170px; border: 2px dashed #ced4da; color: #6c757d; cursor: pointer; text-align: center; margin: 0; }
    .gallery-add i { font-size: 28px; }
    .gallery-add span { font-weight: 600; margin-top: 4px; }
    .gallery-add small { font-size: 11px; }
    .gallery-add:hover, .gallery-add.is-dragover { border-color: #0d6efd; color: #0d6efd; background: #f3f7ff; }
</style>

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

    const MAX_PHOTOS = 5;
    const MAX_PHOTO_SIZE = 2 * 1024 * 1024;
    const PHOTO_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
    const HAS_SAVED_PRIMARY = {{ isset($product) && $product->image ? 'true' : 'false' }};

    const form = document.getElementById('gallery-images').form;
    const galleryInput = document.getElementById('gallery-images');
    const galleryGrid = document.getElementById('gallery-grid');
    const addTile = document.getElementById('gallery-add-tile');
    const galleryError = document.getElementById('gallery-error');
    const galleryCounter = document.getElementById('gallery-counter');
    const imageInput = document.getElementById('image');
    const brochureInput = document.getElementById('brochure');
    const modalPreview = document.getElementById('modal-preview-img');

    // The file input replaces its selection on every pick, so new photos live here
    // and are copied back into the input, letting the admin add photos in several steps.
    let newGalleryFiles = [];

    function showGalleryError(messages) {
        galleryError.innerHTML = '';
        messages.forEach(message => {
            const line = document.createElement('div');
            line.textContent = message;
            galleryError.append(line);
        });
        galleryError.hidden = messages.length === 0;
    }

    function photoProblem(file) {
        if (!PHOTO_TYPES.includes(file.type)) return `${file.name}: format harus JPG, PNG, atau WEBP.`;
        if (file.size > MAX_PHOTO_SIZE) return `${file.name}: ukuran melebihi 2 MB.`;
        return null;
    }

    function photoCount() {
        const hasPrimary = imageInput.files.length > 0 || (HAS_SAVED_PRIMARY && !document.getElementById('remove-image')?.checked);
        const retained = galleryGrid.querySelectorAll('[data-existing-gallery]:not(.is-removed)').length;
        return Number(hasPrimary) + retained + newGalleryFiles.length;
    }

    function updateGalleryState() {
        const count = photoCount();
        galleryCounter.textContent = `${count} / ${MAX_PHOTOS} foto`;
        galleryCounter.classList.toggle('is-full', count === MAX_PHOTOS);
        galleryCounter.classList.toggle('is-over', count > MAX_PHOTOS);
        addTile.hidden = count >= MAX_PHOTOS;
        imageInput.setCustomValidity(imageInput.files[0]?.size > MAX_PHOTO_SIZE ? 'Ukuran gambar utama maksimal 2 MB.' : '');
        brochureInput.setCustomValidity(brochureInput.files[0]?.size > 5 * 1024 * 1024 ? 'Ukuran PDF maksimal 5 MB.' : '');
    }

    function syncGalleryInput() {
        const transfer = new DataTransfer();
        newGalleryFiles.forEach(file => transfer.items.add(file));
        galleryInput.files = transfer.files;
    }

    function renderNewGallery() {
        galleryGrid.querySelectorAll('[data-new-gallery]').forEach(card => {
            URL.revokeObjectURL(card.querySelector('img').src);
            card.remove();
        });
        newGalleryFiles.forEach((file, index) => {
            const card = document.createElement('div');
            card.className = 'gallery-card is-new';
            card.dataset.newGallery = '';

            const badge = document.createElement('span');
            badge.className = 'gallery-badge';
            badge.textContent = 'Baru';

            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.alt = file.name;
            image.title = file.name;
            image.dataset.bsToggle = 'modal';
            image.dataset.bsTarget = '#imagePreviewModal';

            const actions = document.createElement('div');
            actions.className = 'gallery-actions';
            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'btn btn-sm btn-outline-danger';
            remove.innerHTML = '<i class="fe fe-x"></i> Hapus';
            remove.addEventListener('click', () => {
                newGalleryFiles.splice(index, 1);
                syncGalleryInput();
                renderNewGallery();
                showGalleryError([]);
            });
            actions.append(remove);

            card.append(badge, image, actions);
            galleryGrid.insertBefore(card, addTile);
        });
        updateGalleryState();
    }

    function addGalleryFiles(files) {
        const errors = [];
        for (const file of files) {
            const problem = photoProblem(file);
            if (problem) {
                errors.push(problem);
                continue;
            }
            const duplicate = newGalleryFiles.some(f => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified);
            if (duplicate) continue;
            if (photoCount() >= MAX_PHOTOS) {
                errors.push(`Slot penuh (maksimal ${MAX_PHOTOS} foto). Hapus foto lain dulu untuk menambah "${file.name}".`);
                continue;
            }
            newGalleryFiles.push(file);
        }
        syncGalleryInput();
        renderNewGallery();
        showGalleryError(errors);
    }

    galleryInput.addEventListener('change', () => addGalleryFiles([...galleryInput.files]));

    ['dragenter', 'dragover'].forEach(type => addTile.addEventListener(type, event => {
        event.preventDefault();
        addTile.classList.add('is-dragover');
    }));
    ['dragleave', 'drop'].forEach(type => addTile.addEventListener(type, () => addTile.classList.remove('is-dragover')));
    addTile.addEventListener('drop', event => {
        event.preventDefault();
        addGalleryFiles([...event.dataTransfer.files]);
    });

    function resetReplacement(card) {
        const input = card.querySelector('[data-replace-input]');
        const thumb = card.querySelector('[data-thumb]');
        input.value = '';
        if (thumb.src.startsWith('blob:')) URL.revokeObjectURL(thumb.src);
        thumb.src = thumb.dataset.originalSrc;
        card.classList.remove('is-replaced');
        card.querySelector('[data-action="undo-replace"]').hidden = true;
        card.querySelector('[data-action="replace"]').hidden = false;
        setCardStatus(card);
    }

    function setCardStatus(card) {
        const status = card.querySelector('[data-status]');
        const text = card.classList.contains('is-removed') ? 'Akan dihapus' : (card.classList.contains('is-replaced') ? 'Akan diganti' : '');
        status.textContent = text;
        status.hidden = text === '';
    }

    galleryGrid.querySelectorAll('[data-existing-gallery]').forEach(card => {
        setCardStatus(card);
        card.querySelector('[data-replace-input]').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return resetReplacement(card);
            const problem = photoProblem(file);
            if (problem) {
                resetReplacement(card);
                return showGalleryError([problem]);
            }
            const thumb = card.querySelector('[data-thumb]');
            if (thumb.src.startsWith('blob:')) URL.revokeObjectURL(thumb.src);
            thumb.src = URL.createObjectURL(file);
            card.classList.add('is-replaced');
            card.querySelector('[data-action="undo-replace"]').hidden = false;
            card.querySelector('[data-action="replace"]').hidden = true;
            setCardStatus(card);
            showGalleryError([]);
        });
    });

    galleryGrid.addEventListener('click', event => {
        const button = event.target.closest('[data-action]');
        const card = button?.closest('[data-existing-gallery]');
        if (!card) return;

        if (button.dataset.action === 'replace') {
            card.querySelector('[data-replace-input]').click();
        } else if (button.dataset.action === 'undo-replace') {
            resetReplacement(card);
        } else if (button.dataset.action === 'remove') {
            const checkbox = card.querySelector('[data-remove-input]');
            if (checkbox.checked && photoCount() >= MAX_PHOTOS) {
                return showGalleryError([`Slot penuh (maksimal ${MAX_PHOTOS} foto). Hapus foto baru dulu sebelum membatalkan penghapusan.`]);
            }
            checkbox.checked = !checkbox.checked;
            if (checkbox.checked) resetReplacement(card);
            card.classList.toggle('is-removed', checkbox.checked);
            card.querySelector('[data-action="replace"]').disabled = checkbox.checked;
            button.innerHTML = checkbox.checked ? '<i class="fe fe-rotate-ccw"></i> Batal hapus' : '<i class="fe fe-trash-2"></i> Hapus';
            setCardStatus(card);
            showGalleryError([]);
            updateGalleryState();
        }
    });

    // Every gallery thumbnail opens the same zoom modal as the main image.
    document.addEventListener('click', event => {
        const thumb = event.target.closest('#image-preview-img, #gallery-grid img');
        if (thumb) modalPreview.src = thumb.src;
    });

    [imageInput, brochureInput, document.getElementById('remove-image')].filter(Boolean)
        .forEach(input => input.addEventListener('change', updateGalleryState));

    form.addEventListener('submit', event => {
        if (photoCount() > MAX_PHOTOS) {
            event.preventDefault();
            showGalleryError([`Total foto melebihi ${MAX_PHOTOS}. Hapus beberapa foto sebelum menyimpan.`]);
            galleryGrid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    galleryGrid.querySelectorAll('[data-existing-gallery].is-removed [data-action="replace"]').forEach(button => button.disabled = true);
    updateGalleryState();
</script>
@endpush
