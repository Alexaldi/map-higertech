@extends('admin.layouts.app')
@section('title', 'Pesan Kontak | Higertech Karya Sinergi')
@section('content')
<div class="row mt-5">
    <div class="col-12 col-sm-12">
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Daftar Pesan Kontak</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Pengirim</th>
                                <th>Perusahaan</th>
                                <th>Diterima</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($messages as $msg)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        @if($msg->is_read)
                                            <span class="badge bg-success">Dibaca</span>
                                        @else
                                            <span class="badge bg-danger">Baru</span>
                                        @endif
                                    </td>

                                    <td>
                                        <h6 class="mb-0 fs-14 fw-semibold">
                                            {{ $msg->name }}
                                        </h6>
                                        <span class="fs-12 text-muted">
                                            {{ $msg->email }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $msg->company ?: '-' }}
                                    </td>

                                    <td>
                                        {{ strtolower($msg->created_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y H.i')) }}
                                    </td>

                                    <td>
                                        <!-- view -->
                                        <a
                                            href="{{ route('admin.contacts.show', $msg) }}"
                                            class="btn btn-primary btn-sm rounded-11 me-2 d-inline-flex align-items-center justify-content-center"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="Lihat"
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
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>

                                        <!-- delete -->
                                        <form
                                            action="{{ route('admin.contacts.destroy', $msg) }}"
                                            method="POST"
                                            class="d-inline delete-form"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm rounded-11 d-inline-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="Hapus"
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
                                    <td colspan="6" class="text-center">
                                        Belum ada pesan kontak.
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

