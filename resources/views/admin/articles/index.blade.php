@extends('admin.layouts.app')
@section('title', 'Artikel | Higertech Karya Sinergi')

@section('content')
    <div class="row mt-5">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h3 class="card-title mb-1">Daftar Artikel & Panduan</h3>
                        <p class="text-muted fs-12 mb-0">Kelola artikel publikasi, panduan instalasi, dan dokumentasi proyek telemetri.</p>
                    </div>

                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-1"></i>
                        Tambah Artikel
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 100px;">Thumbnail</th>
                                    <th>Judul Artikel</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 110px;">Tanggal</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($articles as $article)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="rounded overflow-hidden bg-slate-100 border text-center"
                                                style="width: 80px; height: 50px;">
                                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="font-weight-semibold text-wrap fs-14" style="max-width: 380px;">
                                                    {{ $article->title }}
                                                </span>
                                                <small class="text-muted text-truncate" style="max-width: 380px;">
                                                    {{ $article->slug }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-blue-transparent text-primary border border-primary px-2 py-1">
                                                {{ $article->category_name }}
                                            </span>
                                            @if ($article->is_featured)
                                                <span class="badge bg-warning-transparent text-warning border border-warning px-2 py-1 ms-1"
                                                    title="Artikel Unggulan">
                                                    <i class="fe fe-star me-1"></i>Unggulan
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $article->author ?: 'Tim Higertech' }}</td>
                                        <td>
                                            @if ($article->status === 'published')
                                                <span class="badge bg-success-transparent text-success border border-success px-2 py-1">
                                                    Publik
                                                </span>
                                            @else
                                                <span class="badge bg-warning-transparent text-warning border border-warning px-2 py-1">
                                                    Draf
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fs-12 text-muted">
                                                {{ $article->formatted_date }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                                                class="btn btn-info btn-sm rounded-11 me-1 d-inline-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-original-title="Lihat Halaman Publik">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.articles.edit', $article) }}"
                                                class="btn btn-primary btn-sm rounded-11 me-1 d-inline-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-original-title="Edit Artikel">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 20h9" />
                                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                                class="d-inline delete-form" data-title="Hapus Artikel?"
                                                data-message="Apakah Anda yakin ingin menghapus artikel '{{ $article->title }}'? File gambar dan data artikel akan dihapus secara permanen.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm rounded-11 d-inline-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Hapus Artikel">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6l-1 14H6L5 6"></path>
                                                        <path d="M10 11v6"></path>
                                                        <path d="M14 11v6"></path>
                                                        <path d="M9 6V4h6v2"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Belum ada data artikel.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection

