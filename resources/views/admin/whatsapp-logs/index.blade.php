@extends('admin.layouts.app')

@section('title', 'Log WhatsApp | Higertech Karya Sinergi')

@section('content')
    <div class="row mt-5">
        <!-- Stat Cards -->
        <div class="col-sm-6 col-md-6 col-lg-4">
            <div class="card bg-primary-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 text-white-50">Total Pesan Diproses</h6>
                            <h2 class="mb-0 text-white font-weight-bold">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="ms-auto">
                            <span class="avatar avatar-md bg-white-transparent rounded-circle">
                                <i class="fe fe-message-circle text-white fs-20"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-4">
            <div class="card bg-success-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 text-white-50">Berhasil Terkirim</h6>
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
        <div class="col-sm-6 col-md-6 col-lg-4">
            <div class="card bg-danger-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 text-white-50">Gagal Terkirim</h6>
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

        <!-- Main Table -->
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">Riwayat Pengiriman WhatsApp</h3>
                        <p class="fs-12 text-muted mb-0 mt-1">Daftar rekaman pesan dan berkas dokumen yang dikirim oleh
                            sistem WhatsApp Bot Higertech</p>
                    </div>
                    @if ($logs->count() > 0)
                        <div>
                            <form action="{{ route('admin.whatsapp-logs.clear') }}" method="POST" id="form-clear-logs"
                                class="d-inline">
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
                    <div class="table-responsive">
                        <table id="data-table" class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>No. WhatsApp Tujuan</th>
                                    <th>Tipe</th>
                                    <th>Ringkasan Pesan / Berkas</th>
                                    <th>Status</th>
                                    <th>Waktu Pengiriman</th>
                                    <th style="width: 90px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($logs as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="avatar avatar-sm bg-success-transparent text-success rounded-circle me-2">
                                                    <i class="fe fe-phone fs-13"></i>
                                                </span>
                                                <div>
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $log->phone) }}"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="fw-semibold text-dark hover:underline">
                                                        {{ $log->phone }}
                                                    </a>
                                                    <small class="d-block text-muted fs-11">Buka di WhatsApp &rarr;</small>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            @if ($log->type === 'file')
                                                <span class="badge bg-purple-transparent text-purple px-2 py-1">
                                                    <i class="fe fe-file me-1"></i> Berkas File
                                                </span>
                                            @else
                                                <span class="badge bg-info-transparent text-info px-2 py-1">
                                                    <i class="fe fe-message-square me-1"></i> Pesan Teks
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <div style="max-width: 320px; white-space: normal;">
                                                @if ($log->type === 'file' && $log->attachment_name)
                                                    <div class="fw-bold fs-12 text-dark mb-1">
                                                        <i
                                                            class="fe fe-paperclip text-muted me-1"></i>{{ $log->attachment_name }}
                                                    </div>
                                                @endif
                                                <span class="fs-12 text-muted">
                                                    {{ \Illuminate\Support\Str::limit($log->message ?: '-', 90) }}
                                                </span>
                                            </div>
                                        </td>

                                        <td>
                                            @if ($log->status === 'success')
                                                <span class="badge bg-success-transparent text-success px-2.5 py-1">
                                                    <i class="fe fe-check me-1"></i> Berhasil
                                                </span>
                                            @else
                                                <span class="badge bg-danger-transparent text-danger px-2.5 py-1"
                                                    title="{{ $log->response }}">
                                                    <i class="fe fe-x me-1"></i> Gagal
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="fs-12 text-dark fw-medium">
                                                {{ $log->sent_at ? $log->sent_at->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : '-' }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button"
                                                    class="btn btn-outline-primary btn-sm btn-view-detail"
                                                    data-phone="{{ $log->phone }}"
                                                    data-type="{{ $log->type === 'file' ? 'Berkas File' : 'Pesan Teks' }}"
                                                    data-status="{{ $log->status }}"
                                                    data-attachment="{{ $log->attachment_name ?? '' }}"
                                                    data-time="{{ $log->sent_at ? $log->sent_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i:s') . ' WIB' : '-' }}"
                                                    data-message="{{ $log->message }}"
                                                    data-response="{{ $log->response ?? '' }}" title="Lihat Detail Pesan">
                                                    <i class="fe fe-eye"></i>
                                                </button>
                                                <form action="{{ route('admin.whatsapp-logs.destroy', $log->id) }}"
                                                    method="POST" class="d-inline form-delete-single">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm btn-delete-log"
                                                        title="Hapus Log">
                                                        <i class="fe fe-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fe fe-inbox fs-30 d-block mb-2 text-muted opacity-50"></i>
                                            Belum ada riwayat pengiriman pesan WhatsApp.
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

    <!-- Modal Detail Log -->
    <div class="modal fade" id="modalDetailLog" tabindex="-1" aria-labelledby="modalDetailLogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalDetailLogLabel">
                        <i class="fe fe-message-circle me-1 text-primary"></i> Detail Pesan WhatsApp
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="fs-12 text-muted mb-0">Nomor Tujuan:</label>
                            <div class="fw-bold fs-14 text-dark" id="modal-detail-phone">-</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="fs-12 text-muted mb-0">Waktu Pengiriman:</label>
                            <div class="fw-bold fs-14 text-dark" id="modal-detail-time">-</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="fs-12 text-muted mb-0">Tipe:</label>
                            <div id="modal-detail-type">-</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="fs-12 text-muted mb-0">Status:</label>
                            <div id="modal-detail-status">-</div>
                        </div>
                        <div class="col-12" id="modal-detail-attachment-wrapper" style="display: none;">
                            <label class="fs-12 text-muted mb-0">Nama Berkas Lampiran:</label>
                            <div class="fw-bold fs-13 text-primary" id="modal-detail-attachment">-</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fs-12 text-muted mb-1 fw-bold">Isi Pesan / Caption:</label>
                        <div class="p-3 bg-light border fs-13"
                            style="white-space: pre-wrap; font-family: inherit; max-height: 280px; overflow-y: auto; border-radius: 6px !important;"
                            id="modal-detail-message">-</div>
                    </div>

                    <div id="modal-detail-response-wrapper" style="display: none;">
                        <label class="fs-12 text-danger mb-1 fw-bold">Keterangan / Pesan Error:</label>
                        <div class="p-2.5 bg-danger-transparent text-danger border border-danger-subtle fs-12 font-monospace"
                            style="white-space: pre-wrap; border-radius: 6px !important;" id="modal-detail-response">-
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($('#data-table').length) {
                $('#data-table').DataTable({
                    order: [
                        [5, 'desc']
                    ], // Sort by sent_at column desc
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ baris",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                        infoFiltered: "(disaring dari _MAX_ total data)",
                        zeroRecords: "Tidak ada data yang sesuai",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "&rarr;",
                            previous: "&larr;"
                        }
                    }
                });
            }

            // View detail modal handler
            $('.btn-view-detail').on('click', function() {
                const phone = $(this).data('phone');
                const type = $(this).data('type');
                const status = $(this).data('status');
                const time = $(this).data('time');
                const message = $(this).data('message');
                const attachment = $(this).data('attachment');
                const response = $(this).data('response');

                $('#modal-detail-phone').text(phone);
                $('#modal-detail-time').text(time);
                $('#modal-detail-type').html(type === 'Berkas File' ?
                    '<span class="badge bg-purple-transparent text-purple"><i class="fe fe-file me-1"></i> Berkas File</span>' :
                    '<span class="badge bg-info-transparent text-info"><i class="fe fe-message-square me-1"></i> Pesan Teks</span>'
                );

                $('#modal-detail-status').html(status === 'success' ?
                    '<span class="badge bg-success-transparent text-success"><i class="fe fe-check me-1"></i> Berhasil Terkirim</span>' :
                    '<span class="badge bg-danger-transparent text-danger"><i class="fe fe-x me-1"></i> Gagal Terkirim</span>'
                );

                if (attachment) {
                    $('#modal-detail-attachment').text(attachment);
                    $('#modal-detail-attachment-wrapper').show();
                } else {
                    $('#modal-detail-attachment-wrapper').hide();
                }

                $('#modal-detail-message').text(message || '(Tidak ada pesan teks)');

                if (response && status !== 'success') {
                    $('#modal-detail-response').text(response);
                    $('#modal-detail-response-wrapper').show();
                } else {
                    $('#modal-detail-response-wrapper').hide();
                }

                const modal = new bootstrap.Modal(document.getElementById('modalDetailLog'));
                modal.show();
            });

            // Delete single log
            $('.btn-delete-log').on('click', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Hapus Log Ini?',
                        text: 'Data riwayat pesan ini akan dihapus permanen.',
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
                    if (confirm('Yakin ingin menghapus baris log ini?')) {
                        form.submit();
                    }
                }
            });
        });

        // Clear all logs
        function confirmClearLogs() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Kosongkan Semua Log WhatsApp?',
                    text: 'Seluruh data riwayat pengiriman pesan akan dibersihkan dan tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Bersihkan Semua',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-clear-logs').submit();
                    }
                });
            } else {
                if (confirm('Yakin ingin mengosongkan seluruh riwayat log WhatsApp?')) {
                    document.getElementById('form-clear-logs').submit();
                }
            }
        }
    </script>
@endpush
