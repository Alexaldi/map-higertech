@extends('admin.layouts.app')
@section('title', 'Produk | Higertech Karya Sinergi')
@section('content')
<div class="row mt-5">
    <div class="col-12 col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Daftar Produk</h3>

                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fe fe-plus me-1"></i>
                    Tambah Produk
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <img
                                            src="{{ $product->image_url }}"
                                            alt="{{ $product->title }}"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                                            onerror="this.src='https://placehold.co/60x60/e2e8f0/94a3b8?text=No+Image'"
                                        >
                                    </td>

                                    <td>
                                        <h6 class="mb-0 fs-14 fw-semibold">
                                            {{ $product->title }}
                                        </h6>
                                        <span class="fs-12 text-muted">
                                            {{ $product->slug }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $product->category->name ?? '-' }}
                                    </td>

                                    <td>
                                        @if ($product->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ strtolower($product->created_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y H.i')) }}
                                    </td>

                                    <td>
                                        <!-- edit -->
                                        <a
                                            href="{{ route('admin.products.edit', $product) }}"
                                            class="btn btn-primary btn-sm rounded-11 me-2 d-inline-flex align-items-center justify-content-center"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="Edit"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="16"
                                                height="16"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="M12 20h9"/>
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                            </svg>
                                        </a>

                                        <!-- delete -->
                                        <form
                                            action="{{ route('admin.products.destroy', $product) }}"
                                            method="POST"
                                            class="d-inline delete-form"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm rounded-11 d-inline-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="Delete"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="16"
                                                    height="16"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                >
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
                                    <td colspan="7" class="text-center">
                                        Belum ada produk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- COL END -->
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#data-table').DataTable();
    });
</script>
@endpush
@endsection