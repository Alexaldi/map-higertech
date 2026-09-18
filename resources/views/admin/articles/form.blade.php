@extends('admin.layouts.app')
@section('title', (isset($article) ? 'Edit Artikel' : 'Tambah Artikel') . ' | Higertech Karya Sinergi')

@push('styles')
    <!-- SUMMERNOTE CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/summernote/summernote-bs4.css') }}">
    <style>
        .note-editor.note-frame {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
        }
        .note-editor.note-frame .note-toolbar {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="row mt-4">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ isset($article) ? 'Edit Artikel' : 'Tambah Artikel Baru' }}</h4>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fe fe-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($article) ? route('admin.articles.update', $article) : route('admin.articles.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($article)
                            @method('PUT')
                        @endisset

                        <div class="row">
                            {{-- Judul Artikel --}}
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label font-weight-semibold">
                                        Judul Artikel <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $article->title ?? '') }}"
                                        placeholder="Masukkan judul artikel" required onkeyup="generateSlug(this.value)">
                                    @error('title')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="slug" class="form-label font-weight-semibold">
                                        Slug URL <span class="text-muted fs-12">(otomatis jika dikosongkan)</span>
                                    </label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name="slug" value="{{ old('slug', $article->slug ?? '') }}"
                                        placeholder="slug-url-artikel">
                                    @error('slug')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label font-weight-semibold">
                                        Kategori Master
                                    </label>
                                    <select class="form-control form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" onchange="toggleCustomCategory(this)">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" data-name="{{ $cat->name }}"
                                                {{ old('category_id', $article->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                        <option value="custom" {{ old('category') && !old('category_id', $article->category_id ?? '') ? 'selected' : '' }}>
                                            + Ketik Kategori Lainnya...
                                        </option>
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kategori Kustom (jika tidak ada di master) --}}
                            <div class="col-md-4" id="custom-category-group" style="{{ (old('category') && !old('category_id', $article->category_id ?? '')) ? '' : 'display: none;' }}">
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label font-weight-semibold">
                                        Nama Kategori Baru
                                    </label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror"
                                        id="category" name="category" value="{{ old('category', $article->category ?? '') }}"
                                        placeholder="Misal: Berita, Inovasi, Riset">
                                    @error('category')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Penulis --}}
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="author" class="form-label font-weight-semibold">Penulis</label>
                                    <input type="text" class="form-control @error('author') is-invalid @enderror"
                                        id="author" name="author"
                                        value="{{ old('author', $article->author ?? 'Tim Higertech') }}"
                                        placeholder="Nama Penulis">
                                    @error('author')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Estimasi Waktu Baca --}}
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label for="read_time" class="form-label font-weight-semibold">Waktu Baca (Menit)</label>
                                    <input type="number" class="form-control @error('read_time') is-invalid @enderror"
                                        id="read_time" name="read_time" min="1"
                                        value="{{ old('read_time', $article->read_time ?? 5) }}" placeholder="5">
                                    <small class="text-muted">Dalam menit</small>
                                    @error('read_time')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tanggal Publikasi --}}
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="published_at" class="form-label font-weight-semibold">Tanggal Publikasi</label>
                                    <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                        id="published_at" name="published_at"
                                        value="{{ old('published_at', isset($article->published_at) ? $article->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                                    @error('published_at')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status Publikasi --}}
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label font-weight-semibold">Status <span class="text-danger">*</span></label>
                                    <select class="form-control form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                        <option value="published" {{ old('status', $article->status ?? 'published') === 'published' ? 'selected' : '' }}>
                                            Publik (Published)
                                        </option>
                                        <option value="draft" {{ old('status', $article->status ?? '') === 'draft' ? 'selected' : '' }}>
                                            Draf (Draft)
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Featured Switch --}}
                            <div class="col-md-4 d-flex align-items-center">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_featured"
                                        name="is_featured" value="1"
                                        {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-semibold ms-2" for="is_featured">
                                        Jadikan Artikel Unggulan (Featured)
                                    </label>
                                    <small class="text-muted d-block ms-2">Ditampilkan dengan ukuran kartu lebih besar di frontend.</small>
                                </div>
                            </div>

                            {{-- Ringkasan / Excerpt --}}
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="excerpt" class="form-label font-weight-semibold">
                                        Ringkasan / Excerpt <span class="text-muted fs-12">(opsional, untuk preview kartu & SEO)</span>
                                    </label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                        id="excerpt" name="excerpt" rows="2"
                                        placeholder="Ringkasan singkat tentang isi artikel">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                                    @error('excerpt')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Upload Gambar Thumbnail --}}
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label font-weight-semibold">
                                        Gambar Sampul / Thumbnail
                                    </label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/png,image/jpeg,image/webp,image/svg+xml"
                                        onchange="previewArticleImage(this)">
                                    <small class="text-muted d-block mt-1">Disarankan gambar rasio horizontal/landscape (16:9), format PNG, JPG, atau WEBP, maks 3MB.</small>
                                    @error('image')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror

                                    {{-- Preview Box --}}
                                    <div id="image-empty-notice" class="text-muted fs-12 mt-2" style="{{ isset($article) && $article->image ? 'display:none;' : '' }}">
                                        gambar belum di unggah
                                    </div>

                                    <div id="image-preview-container"
                                        style="max-width: 380px; {{ isset($article) && $article->image ? '' : 'display:none;' }}"
                                        class="mt-3 p-2 border bg-light">
                                        <span class="text-muted fs-12 d-block mb-1 font-weight-semibold">Preview Gambar:</span>
                                        <img id="image-preview-img"
                                            src="{{ isset($article) && $article->image ? $article->image_url : '' }}"
                                            alt="Preview Gambar" class="img-fluid"
                                            style="max-height: 180px; width: 100%; object-fit: cover; display: block;">
                                    </div>
                                </div>
                            </div>

                            {{-- Konten Artikel (Summernote) --}}
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="summernote" class="form-label font-weight-semibold">
                                        Konten Lengkap Artikel <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                        id="summernote" name="content" rows="12"
                                        placeholder="Tuliskan isi artikel di sini...">{{ old('content', $article->content ?? '') }}</textarea>
                                    @error('content')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-1"></i>
                                {{ isset($article) ? 'Perbarui Artikel' : 'Simpan Artikel' }}
                            </button>
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SUMMERNOTE JS -->
    <script src="{{ asset('admin/assets/plugins/summernote/summernote-bs4.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Tulis isi artikel lengkap di sini. Anda dapat menambahkan heading, paragraf, gambar, kutipan, dan tautan...',
                tabsize: 2,
                height: 380,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        let slugEditedManually = {{ isset($article) ? 'true' : 'false' }};
        const slugInput = document.getElementById('slug');

        if (slugInput) {
            slugInput.addEventListener('input', function() {
                slugEditedManually = true;
            });
        }

        function generateSlug(text) {
            if (!slugEditedManually) {
                const slug = text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
                document.getElementById('slug').value = slug;
            }
        }

        function toggleCustomCategory(select) {
            const customGroup = document.getElementById('custom-category-group');
            const customInput = document.getElementById('category');
            if (select.value === 'custom') {
                customGroup.style.display = 'block';
                select.value = '';
                customInput.focus();
            } else if (select.value !== '') {
                customGroup.style.display = 'none';
                customInput.value = '';
            }
        }

        function previewArticleImage(input) {
            const container = document.getElementById('image-preview-container');
            const preview = document.getElementById('image-preview-img');
            const emptyNotice = document.getElementById('image-empty-notice');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = '';
                    if (emptyNotice) {
                        emptyNotice.style.display = 'none';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                container.style.display = 'none';
                if (emptyNotice) {
                    emptyNotice.style.display = '';
                }
            }
        }
    </script>
@endpush

