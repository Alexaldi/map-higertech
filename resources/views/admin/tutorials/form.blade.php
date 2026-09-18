@extends('admin.layouts.app')
@section('title', (isset($tutorial) ? 'Edit Tutorial' : 'Tambah Tutorial') . ' | Higertech Karya Sinergi')

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
                    <h4 class="card-title mb-0">{{ isset($tutorial) ? 'Edit Tutorial' : 'Tambah Tutorial Baru' }}</h4>
                    <a href="{{ route('admin.tutorials.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fe fe-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($tutorial) ? route('admin.tutorials.update', $tutorial) : route('admin.tutorials.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($tutorial)
                            @method('PUT')
                        @endisset

                        <div class="row">
                            {{-- Judul Tutorial --}}
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label font-weight-semibold">
                                        Judul Tutorial <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $tutorial->title ?? '') }}"
                                        placeholder="Masukkan judul tutorial" required onkeyup="generateSlug(this.value)">
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
                                        id="slug" name="slug" value="{{ old('slug', $tutorial->slug ?? '') }}"
                                        placeholder="slug-url-tutorial">
                                    @error('slug')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tipe Tutorial --}}
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label font-weight-semibold">Tipe / Kategori Tutorial</label>
                                    <input type="text" class="form-control @error('type') is-invalid @enderror"
                                        id="type" name="type"
                                        value="{{ old('type', $tutorial->type ?? '') }}"
                                        placeholder="Contoh: Panduan Instalasi, Video Tutorial, Panduan Lapangan"
                                        list="type-suggestions">
                                    <datalist id="type-suggestions">
                                        <option value="Panduan Instalasi">
                                        <option value="Video Tutorial">
                                        <option value="Panduan Lapangan">
                                        <option value="Panduan Teknis">
                                        <option value="Tutorial Dasar">
                                        <option value="Tutorial Lanjutan">
                                    </datalist>
                                    @error('type')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Durasi --}}
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label for="duration" class="form-label font-weight-semibold">Durasi (Menit)</label>
                                    <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                        id="duration" name="duration" min="1"
                                        value="{{ old('duration', $tutorial->duration ?? 5) }}" placeholder="5">
                                    <small class="text-muted">Estimasi durasi pembelajaran</small>
                                    @error('duration')
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
                                        value="{{ old('published_at', isset($tutorial->published_at) ? $tutorial->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
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
                                        <option value="published" {{ old('status', $tutorial->status ?? 'published') === 'published' ? 'selected' : '' }}>
                                            Publik (Published)
                                        </option>
                                        <option value="draft" {{ old('status', $tutorial->status ?? '') === 'draft' ? 'selected' : '' }}>
                                            Draf (Draft)
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Featured Switch --}}
                            <div class="col-md-12 d-flex align-items-center mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_featured"
                                        name="is_featured" value="1"
                                        {{ old('is_featured', $tutorial->is_featured ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-semibold ms-2" for="is_featured">
                                        Jadikan Tutorial Unggulan (Featured)
                                    </label>
                                    <small class="text-muted d-block ms-2">Ditampilkan di halaman utama website.</small>
                                </div>
                            </div>

                            {{-- Ringkasan --}}
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="excerpt" class="form-label font-weight-semibold">
                                        Ringkasan / Excerpt <span class="text-muted fs-12">(opsional, untuk preview kartu & SEO)</span>
                                    </label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                        id="excerpt" name="excerpt" rows="2"
                                        placeholder="Ringkasan singkat tentang isi tutorial">{{ old('excerpt', $tutorial->excerpt ?? '') }}</textarea>
                                    @error('excerpt')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- URL Video --}}
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="video_url" class="form-label font-weight-semibold">
                                        URL Video <span class="text-muted fs-12">(opsional, YouTube / Vimeo)</span>
                                    </label>
                                    <input type="url" class="form-control @error('video_url') is-invalid @enderror"
                                        id="video_url" name="video_url"
                                        value="{{ old('video_url', $tutorial->video_url ?? '') }}"
                                        placeholder="https://www.youtube.com/watch?v=...">
                                    @error('video_url')
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
                                        onchange="previewTutorialImage(this)">
                                    <small class="text-muted d-block mt-1">Disarankan gambar rasio horizontal/landscape (16:9), format PNG, JPG, atau WEBP, maks 3MB.</small>
                                    @error('image')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror

                                    {{-- Preview Box --}}
                                    <div id="image-empty-notice" class="text-muted fs-12 mt-2" style="{{ isset($tutorial) && $tutorial->image ? 'display:none;' : '' }}">
                                        gambar belum di unggah
                                    </div>

                                    <div id="image-preview-container"
                                        style="max-width: 380px; {{ isset($tutorial) && $tutorial->image ? '' : 'display:none;' }}"
                                        class="mt-3 p-2 border bg-light">
                                        <span class="text-muted fs-12 d-block mb-1 font-weight-semibold">Preview Gambar:</span>
                                        <img id="image-preview-img"
                                            src="{{ isset($tutorial) && $tutorial->image ? $tutorial->image_url : '' }}"
                                            alt="Preview Gambar" class="img-fluid"
                                            style="max-height: 180px; width: 100%; object-fit: cover; display: block;">
                                    </div>
                                </div>
                            </div>

                            {{-- Konten Tutorial (Summernote) --}}
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="summernote" class="form-label font-weight-semibold">
                                        Konten Lengkap Tutorial <span class="text-muted fs-12">(opsional)</span>
                                    </label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                        id="summernote" name="content" rows="12"
                                        placeholder="Tuliskan isi tutorial lengkap di sini...">{{ old('content', $tutorial->content ?? '') }}</textarea>
                                    @error('content')
                                        <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-1"></i>
                                {{ isset($tutorial) ? 'Perbarui Tutorial' : 'Simpan Tutorial' }}
                            </button>
                            <a href="{{ route('admin.tutorials.index') }}" class="btn btn-light">Batal</a>
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
                placeholder: 'Tulis isi tutorial lengkap di sini. Anda dapat menambahkan heading, paragraf, gambar, kutipan, dan tautan...',
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

        let slugEditedManually = {{ isset($tutorial) ? 'true' : 'false' }};
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

        function previewTutorialImage(input) {
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

