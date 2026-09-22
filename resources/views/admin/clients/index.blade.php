@extends('admin.layouts.app')
@section('title', 'Mitra & Klien | Higertech Karya Sinergi')
@section('content')
    <div class="row mt-5">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Daftar Mitra & Klien Instansi</h3>

                    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-1"></i>
                        Tambah Mitra
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 160px;">Logo</th>
                                    <th>Nama Instansi</th>
                                    <th>Kementerian / Dinas</th>
                                    <th style="width: 80px;">Urutan</th>
                                    <th style="width: 90px;">Status</th>
                                    <th style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $client)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($client->logo_url)
                                                <div class="p-2 bg-dark d-inline-block text-center"
                                                    style="background-color: #1e293b !important; border: 1px solid #334155; min-width: 140px; border-radius: 6px !important;">
                                                    <img src="{{ $client->logo_url }}" alt="{{ $client->name }}"
                                                        style="height: 36px; max-width: 130px; object-fit: contain; border-radius: 2px;">
                                                </div>
                                            @else
                                                <span
                                                    class="badge {{ $client->color ?: 'bg-secondary text-white' }} px-2 py-1 font-weight-bold fs-12">
                                                    {{ $client->abbr ?: 'PU' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="font-weight-semibold">{{ $client->name }}</td>
                                        <td>{{ $client->sub ?: '-' }}</td>
                                        <td>{{ $client->order }}</td>
                                        <td>
                                            @if ($client->is_active)
                                                <span
                                                    class="badge bg-success-transparent text-success border border-success px-2 py-1">Aktif</span>
                                            @else
                                                <span
                                                    class="badge bg-danger-transparent text-danger border border-danger px-2 py-1">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.clients.edit', $client) }}"
                                                class="btn btn-primary btn-sm rounded-11 me-2 d-inline-flex align-items-center justify-content-center"
                                                data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 20h9" />
                                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.clients.destroy', $client) }}" method="POST"
                                                class="d-inline delete-form" data-title="Hapus Mitra Klien?"
                                                data-message="Apakah Anda yakin ingin menghapus mitra '{{ $client->name }}'? Logo dan data terkait akan dihapus secara permanen.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm rounded-11 d-inline-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Hapus">
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
                                        <td colspan="7" class="text-center py-4">Belum ada data mitra klien.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#data-table').DataTable();
            });
        </script>
    @endpush
@endsection
