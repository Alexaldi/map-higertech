@extends('admin.layouts.app')

@section('title', 'Login Activity | Higertech Karya Sinergi')

@section('content')
<div class="row mt-5">
    <div class="col-12 col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Login Activity</h3>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>IP Address</th>
                                <th>Browser / Device</th>
                                <th>Status</th>
                                <th>Waktu Login</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($loginLogs as $loginLog)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        @if ($loginLog->user)
                                            <h6 class="mb-0 fs-14 fw-semibold">
                                                {{ $loginLog->user->name }}
                                            </h6>

                                            <span class="fs-12 text-muted">
                                                {{ $loginLog->user->email }}
                                            </span>
                                        @else
                                            <h6 class="mb-0 fs-14 fw-semibold">
                                                Unknown
                                            </h6>

                                            <span class="fs-12 text-muted">
                                                Pengguna tidak ditemukan
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="fw-semibold">
                                            {{ $loginLog->ip_address ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div>
                                            <span class="fw-semibold">
                                                {{ $loginLog->browser }}
                                            </span>

                                            <br>

                                            <span class="fs-12 text-muted">
                                                {{ $loginLog->device }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($loginLog->status === 'success')
                                            <span class="badge bg-success-transparent text-success">
                                                Berhasil
                                            </span>
                                        @else
                                            <span class="badge bg-danger-transparent text-danger">
                                                Gagal
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $loginLog->login_at
                                            ? strtolower(
                                                $loginLog->login_at
                                                    ->timezone('Asia/Jakarta')
                                                    ->locale('id')
                                                    ->translatedFormat('d M Y H.i')
                                            )
                                            : '-' 
                                        }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Belum ada aktivitas login.
                                    </td>
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