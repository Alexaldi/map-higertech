@extends('admin.layouts.app')

@section('title', 'Log API Device Telemetri | Higertech Karya Sinergi')

@section('content')
    @include('admin.device-logs.partials.tabs')

    <div class="row">
        <!-- Stat Cards -->
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card bg-primary-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 text-white-50">Total Request</h6>
                            <h2 class="mb-0 text-white font-weight-bold">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="ms-auto">
                            <span class="avatar avatar-md bg-white-transparent rounded-circle">
                                <i class="fe fe-activity text-white fs-20"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card bg-success-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 text-white-50">Berhasil Diteruskan</h6>
                            <h2 class="mb-0 text-white font-weight-bold">{{ number_format($stats['success']) }}</h2>
                        </div>
                        <div class="ms-auto">
                            <span class="avatar avatar-md bg-white-transparent rounded-circle">
                                <i class="fe fe-check-circle text-white fs-20"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card bg-danger-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 text-white-50">Gagal / Error</h6>
                            <h2 class="mb-0 text-white font-weight-bold">{{ number_format($stats['failed']) }}</h2>
                        </div>
                        <div class="ms-auto">
                            <span class="avatar avatar-md bg-white-transparent rounded-circle">
                                <i class="fe fe-alert-triangle text-white fs-20"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card bg-info-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 text-white-50">Subdomain Balai</h6>
                            <h2 class="mb-0 text-white font-weight-bold">{{ number_format($stats['subdomains']) }}</h2>
                        </div>
                        <div class="ms-auto">
                            <span class="avatar avatar-md bg-white-transparent rounded-circle">
                                <i class="fe fe-server text-white fs-20"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table -->
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">Riwayat Penangkapan API Telemetri Perangkat</h3>
                        <p class="fs-12 text-muted mb-0 mt-1">Daftar rekaman request GET sensor alat IoT yang ditangkap dan diteruskan ke subdomain instansi/balai</p>
                    </div>
                    @if ($stats['total'] > 0)
                        @php
                            $exportParams = array_filter([
                                'q' => $filters['q'],
                                'status' => $filters['status'],
                                'from' => $filters['from'],
                                'to' => $filters['to'],
                            ]);
                        @endphp
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <a href="{{ route('admin.device-logs.export.csv', $exportParams) }}"
                                class="btn btn-outline-success btn-sm btn-export {{ $logs->total() === 0 ? 'disabled' : '' }}"
                                title="Unduh semua data sesuai filter dalam format CSV">
                                <i class="fe fe-file-text me-1"></i> Ekspor CSV
                            </a>
                            <a href="{{ route('admin.device-logs.export.pdf', $exportParams) }}"
                                class="btn btn-outline-primary btn-sm btn-export {{ $logs->total() === 0 ? 'disabled' : '' }}"
                                title="Unduh data sesuai filter dalam format PDF (maks. {{ number_format($pdfMaxRows) }} baris terbaru)">
                                <i class="fe fe-download me-1"></i> Ekspor PDF
                            </a>
                            <form action="{{ route('admin.device-logs.clear') }}" method="POST" id="form-clear-logs" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmClearLogs()">
                                    <i class="fe fe-trash-2 me-1"></i> Kosongkan Riwayat Log
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.device-logs.index') }}" method="GET"
                        class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <label class="d-flex align-items-center gap-2 mb-0">
                            Tampilkan
                            <select name="per_page" class="form-select form-select-sm" style="width: 80px;"
                                onchange="this.form.submit()">
                                @foreach ($perPageOptions as $option)
                                    <option value="{{ $option }}" {{ $perPage === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            baris
                        </label>

                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <select name="status" class="form-select form-select-sm" style="width: 140px;"
                                onchange="this.form.submit()" aria-label="Filter status">
                                <option value="">Semua Status</option>
                                <option value="success" {{ $filters['status'] === 'success' ? 'selected' : '' }}>Berhasil</option>
                                <option value="failed" {{ $filters['status'] === 'failed' ? 'selected' : '' }}>Gagal / Error</option>
                            </select>

                            <div class="input-group input-group-sm" style="width: 300px;">
                                <input type="date" name="from" class="form-control" value="{{ $filters['from'] }}"
                                    max="{{ $filters['to'] }}" title="Dari tanggal (WIB)" aria-label="Dari tanggal">
                                <span class="input-group-text">s/d</span>
                                <input type="date" name="to" class="form-control" value="{{ $filters['to'] }}"
                                    min="{{ $filters['from'] }}" title="Sampai tanggal (WIB)" aria-label="Sampai tanggal">
                            </div>

                            <label for="log-search" class="mb-0">Cari:</label>
                            <div class="input-group input-group-sm" style="width: 260px;">
                                <input type="text" name="q" id="log-search" class="form-control"
                                    placeholder="Subdomain / IP / ID alat..." value="{{ $search }}">
                                <button type="submit" class="btn btn-primary"><i class="fe fe-search"></i></button>
                                @if ($hasFilters)
                                    <a href="{{ route('admin.device-logs.index', ['per_page' => $perPage]) }}" class="btn btn-light"
                                        title="Reset filter"><i class="fe fe-x"></i></a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="device-log-table" class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Subdomain Balai</th>
                                    <th>Parameter Sensor (Payload)</th>
                                    <th>Status HTTP</th>
                                    <th>Durasi</th>
                                    <th>IP Device</th>
                                    <th>Waktu Masuk</th>
                                    <th style="width: 90px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($logs as $log)
                                    <tr>
                                        <td>{{ $logs->firstItem() + $loop->index }}</td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2">
                                                    <i class="fe fe-server fs-13"></i>
                                                </span>
                                                <div>
                                                    <span class="fw-semibold text-dark">{{ $log->sub_domain }}</span>
                                                    <small class="d-block text-muted fs-11">{{ $log->sub_domain }}.higertech.com</small>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div style="max-width: 280px; white-space: normal;">
                                                @if (!empty($log->payload) && is_array($log->payload))
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach (array_slice($log->payload, 0, 4) as $key => $val)
                                                            <span class="badge bg-light text-dark border fs-11">
                                                                <strong>{{ $key }}:</strong> {{ is_array($val) ? json_encode($val) : Str::limit($val, 15) }}
                                                            </span>
                                                        @endforeach
                                                        @if (count($log->payload) > 4)
                                                            <span class="badge bg-secondary-transparent text-secondary fs-11">+{{ count($log->payload) - 4 }} param</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="fs-12 text-muted">-</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            @if ($log->status === 'success')
                                                <span class="badge bg-success-transparent text-success px-2.5 py-1">
                                                    <i class="fe fe-check me-1"></i> {{ $log->status_code }} OK
                                                </span>
                                            @else
                                                <span class="badge bg-danger-transparent text-danger px-2.5 py-1" title="{{ Str::limit($log->response_body, 100) }}">
                                                    <i class="fe fe-x me-1"></i> {{ $log->status_code }} Error
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="fs-12 font-monospace text-muted">
                                                {{ $log->duration_ms !== null ? $log->duration_ms . ' ms' : '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="fs-12 font-monospace text-dark">
                                                {{ $log->ip_address ?: '-' }}
                                            </span>
                                        </td>

                                        <td data-order="{{ $log->created_at ? $log->created_at->timestamp : 0 }}">
                                            <span class="fs-12 text-dark fw-medium">
                                                {{ $log->created_at ? $log->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i:s') . ' WIB' : '-' }}
                                            </span>
                                            <small class="d-block text-muted fs-11">
                                                {{ $log->created_at ? $log->created_at->timezone('Asia/Jakarta')->diffForHumans() : '' }}
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            {{-- Payload data disimpan terpisah untuk modal detail --}}
                                            <div class="d-none log-payload"
                                                data-subdomain="{{ $log->sub_domain }}"
                                                data-endpoint="{{ $log->endpoint }}"
                                                data-ip="{{ $log->ip_address ?? '-' }}"
                                                data-status="{{ $log->status }}"
                                                data-status-code="{{ $log->status_code }}"
                                                data-duration="{{ $log->duration_ms !== null ? $log->duration_ms . ' ms' : '-' }}"
                                                data-time="{{ $log->created_at ? $log->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i:s') . ' WIB' : '-' }}">
                                                <div class="raw-payload">{{ json_encode($log->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</div>
                                                <div class="raw-response">{{ $log->response_body }}</div>
                                            </div>

                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-primary btn-sm btn-view-detail" title="Lihat Detail Request">
                                                    <i class="fe fe-eye"></i>
                                                </button>
                                                <form action="{{ route('admin.device-logs.destroy', $log->id) }}" method="POST" class="d-inline form-delete-single">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-delete-log" title="Hapus Log">
                                                        <i class="fe fe-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fe fe-inbox fs-30 d-block mb-2 text-muted opacity-50"></i>
                                            @if ($hasFilters)
                                                Tidak ada data yang sesuai dengan filter.
                                            @else
                                                Belum ada riwayat penangkapan data sensor telemetri.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($logs->total() > 0)
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                            <div class="small text-muted">
                                Menampilkan {{ $logs->firstItem() }} sampai {{ $logs->lastItem() }} dari
                                {{ number_format($logs->total()) }} data
                            </div>
                            <div>
                                {{ $logs->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Log Telemetri -->
    <div class="modal fade" id="modalDetailLog" tabindex="-1" aria-labelledby="modalDetailLogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalDetailLogLabel">
                        <i class="fe fe-cpu me-1 text-primary"></i> Detail Request Telemetri Device
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="fs-12 text-muted mb-0">Subdomain Tujuan:</label>
                            <div class="fw-bold fs-14 text-dark" id="modal-detail-subdomain">-</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="fs-12 text-muted mb-0">Waktu Masuk:</label>
                            <div class="fw-bold fs-14 text-dark" id="modal-detail-time">-</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="fs-12 text-muted mb-0">Status HTTP & Durasi:</label>
                            <div id="modal-detail-status">-</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="fs-12 text-muted mb-0">IP Address Pengirim:</label>
                            <div class="fw-bold fs-13 font-monospace text-dark" id="modal-detail-ip">-</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fs-12 text-muted mb-1 fw-bold">Parameter Sensor (Query Payload JSON):</label>
                        <pre class="p-3 bg-light border fs-12 font-monospace"
                             style="max-height: 240px; overflow-y: auto; border-radius: 6px !important;"
                             id="modal-detail-payload">-</pre>
                    </div>

                    <div>
                        <label class="fs-12 text-muted mb-1 fw-bold">Respon dari Server Balai Tujuan:</label>
                        <pre class="p-3 bg-light border fs-12 font-monospace"
                             style="max-height: 200px; overflow-y: auto; border-radius: 6px !important;"
                             id="modal-detail-response">-</pre>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.device-logs.partials.export-lock-script')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Paginasi & pencarian ditangani server (lihat DeviceApiLogController@index)

            // View detail modal handler
            $(document).on('click', '.btn-view-detail', function() {
                const $td = $(this).closest('td');
                const $payload = $td.find('.log-payload');
                const subdomain = $payload.attr('data-subdomain') || '-';
                const time = $payload.attr('data-time') || '-';
                const ip = $payload.attr('data-ip') || '-';
                const status = $payload.attr('data-status') || 'success';
                const statusCode = $payload.attr('data-status-code') || '200';
                const duration = $payload.attr('data-duration') || '-';
                const rawPayload = $payload.find('.raw-payload').text() || '{}';
                const rawResponse = $payload.find('.raw-response').text() || '-';

                $('#modal-detail-subdomain').html(
                    `<span class="badge bg-primary-transparent text-primary">${subdomain}</span> <small class="text-muted">(${subdomain}.higertech.com/api/device/store)</small>`
                );
                $('#modal-detail-time').text(time);
                $('#modal-detail-ip').text(ip);

                if (status === 'success') {
                    $('#modal-detail-status').html(
                        `<span class="badge bg-success-transparent text-success px-2 py-1"><i class="fe fe-check me-1"></i> ${statusCode} OK</span> <span class="text-muted ms-1 fs-12 font-monospace">(${duration})</span>`
                    );
                } else {
                    $('#modal-detail-status').html(
                        `<span class="badge bg-danger-transparent text-danger px-2 py-1"><i class="fe fe-x me-1"></i> ${statusCode} Failed</span> <span class="text-muted ms-1 fs-12 font-monospace">(${duration})</span>`
                    );
                }

                $('#modal-detail-payload').text(rawPayload);
                $('#modal-detail-response').text(rawResponse);

                const modal = new bootstrap.Modal(document.getElementById('modalDetailLog'));
                modal.show();
            });

            // Delete single log confirmation
            $(document).on('click', '.btn-delete-log', function() {
                const form = $(this).closest('form');
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Hapus Log Ini?',
                        text: 'Rekaman request API ini akan dihapus permanen.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    if (confirm('Yakin ingin menghapus rekaman log ini?')) {
                        form.submit();
                    }
                }
            });
        });

        // Clear all logs confirmation
        function confirmClearLogs() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Kosongkan Seluruh Riwayat Log?',
                    text: 'Semua rekaman request API telemetri akan dibersihkan dan tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Bersihkan Semua',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-clear-logs').submit();
                    }
                });
            } else {
                if (confirm('Yakin ingin membersihkan seluruh riwayat log API telemetri?')) {
                    $('#form-clear-logs').submit();
                }
            }
        }
    </script>
@endpush
