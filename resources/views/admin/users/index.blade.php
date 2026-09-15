@extends('admin.layouts.app')
@section('title', 'Users | Higertech Karya Sinergi')
@section('content')
<div class="row mt-5">
    <div class="col-12 col-sm-12">
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Daftar Pengguna</h3>

                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fe fe-plus me-1"></i>
                    Tambah Pengguna
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Dibuat</th>
                                <th>Terakhir Diubah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td></td>

                                    <td>
                                        <h6 class="mb-0 fs-14 fw-semibold">
                                            {{ $user->name }}
                                        </h6>
                                        <span class="fs-12 text-muted">
                                            {{ $user->email }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $user->created_at->format('d-m-Y H:i') }}
                                    </td>

                                    <td>
                                        {{ $user->updated_at->format('d-m-Y H:i') }}
                                    </td>

                                    <td>
                                        <!-- edit -->
                                        <a
                                            href="{{ route('admin.users.edit', $user) }}"
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
                                         @if (auth()->id() !== $user->id)
                                            <form
                                                action="{{ route('admin.users.destroy', $user) }}"
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
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Belum ada pengguna.
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
@endsection