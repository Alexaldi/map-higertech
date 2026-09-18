@extends('admin.layouts.app')
@section('title', 'Tutorial & Panduan | Higertech Karya Sinergi')

@section('content')
    <div class="row mt-5">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h3 class="card-title mb-1">Daftar Tutorial & Panduan Teknis</h3>
                        <p class="text-muted fs-12 mb-0">Kelola tutorial, panduan instalasi, dan video panduan teknis.</p>
                    </div>

                    <a href="{{ route('admin.tutorials.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-1"></i>
                        Tambah Tutorial
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 100px;">Thumbnail</th>
                                    <th>Judul Tutorial</th>
                                    <th>Tipe</th>
                                    <th style="width: 80px;">Durasi</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 110px;">Tanggal</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tutorials as $tutorial)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div style="width: 80px; height: 50px; overflow: hidden;">
                                                <img src="{{ $tutorial->image_url }}" alt="{{ $tutorial->title }}"
                                                    style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="font-weight-semibold text-wrap fs-14" style="max-width: 360px;">
                                                    {{ $tutorial->title }}
                                                </span>
                                                <small class="text-muted text-truncate" style="max-width: 360px;">
                                                    {{ $tutorial->slug }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($tutorial->type)
                                                <span class="badge bg-info-transparent text-info border border-info px-2 py-1">
                                                    {{ $tutorial->type }}
                                                </span>
                                            @else
                                                <span class="text-muted fs-12">-</span>
                                            @endif
                                            @if ($tutorial->is_featured)
                                                <span class="badge bg-warning-transparent text-warning border border-warning px-2 py-1 ms-1">
                                                    <i class="fe fe-star me-1"></i>Unggulan
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fs-12">{{ $tutorial->duration_text }}</span>
                                        </td>
                                        <td>
                                            @if ($tutorial->status === 'published')
                                                <span class="badge bg-success-transparent text-success border border-success px-2 py-1">Publik</span>
                                            @else
                                                <span class="badge bg-warning-transparent text-warning border border-warning px-2 py-1">Draf</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fs-12 text-muted">{{ $tutorial->formatted_date }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('tutorials.show', $tutorial->slug) }}" target="_blank"
                                                class="btn btn-info btn-sm rounded-11 me-1 d-inline-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-original-title="Lihat Halaman Publik">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.tutorials.edit', $tutorial) }}"
                                                class="btn btn-primary btn-sm rounded-11 me-1 d-inline-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-original-title="Edit Tutorial">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 20h9" />
                                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.tutorials.destroy', $tutorial) }}" method="POST"
                                                class="d-inline delete-form" data-title="Hapus Tutorial?"
                                                data-message="Apakah Anda yakin ingin menghapus tutorial '{{ $tutorial->title }}'? Data akan dihapus secara permanen.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm rounded-11 d-inline-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Hapus Tutorial">
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
                                        <td colspan="8" class="text-center py-4">Belum ada data tutorial.</td>
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

