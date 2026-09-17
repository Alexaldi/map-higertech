@extends('admin.layouts.app')
@section('title', 'Pendaftaran Magang | Higertech Karya Sinergi')

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="page-title mb-1">Manajemen Pendaftaran Magang</h1>
                    <p class="text-muted mb-0">Tinjau permohonan magang dari Mahasiswa dan Siswa SMK, verifikasi berkas, dan
                        kirimkan keputusan via WhatsApp.</p>
                </div>
                <div>
                    <a href="{{ route('internship') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fe fe-external-link me-1"></i> Buka Portal Publik
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fe fe-alert-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    {{-- Stat Counter Cards --}}
    <div class="row mb-4">
        <div class="col-sm-6 col-md-4 col-xl-2">
            <div class="card shadow-sm border-0 border-start border-primary border-3">
                <div class="card-body p-3">
                    <div class="text-muted small text-uppercase fw-semibold">Total Pendaftar</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <h3 class="fw-bold mb-0 text-primary">{{ $counts['all'] ?? 0 }}</h3>
                        <div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle">
                            <i class="fe fe-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-2">
            <div class="card shadow-sm border-0 border-start border-info border-3">
                <div class="card-body p-3">
                    <div class="text-muted small text-uppercase fw-semibold">Mahasiswa</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <h3 class="fw-bold mb-0 text-info">{{ $counts['university'] ?? 0 }}</h3>
                        <div class="avatar avatar-sm bg-info-transparent text-info rounded-circle">
                            <i class="fe fe-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-2">
            <div class="card shadow-sm border-0 border-start border-secondary border-3">
                <div class="card-body p-3">
                    <div class="text-muted small text-uppercase fw-semibold">Siswa SMK</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <h3 class="fw-bold mb-0 text-secondary">{{ $counts['vocational'] ?? 0 }}</h3>
                        <div class="avatar avatar-sm bg-secondary-transparent text-secondary rounded-circle">
                            <i class="fe fe-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-2">
            <div class="card shadow-sm border-0 border-start border-warning border-3">
                <div class="card-body p-3">
                    <div class="text-muted small text-uppercase fw-semibold">Menunggu Review</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <h3 class="fw-bold mb-0 text-warning">{{ $counts['pending'] ?? 0 }}</h3>
                        <div class="avatar avatar-sm bg-warning-transparent text-warning rounded-circle">
                            <i class="fe fe-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-2">
            <div class="card shadow-sm border-0 border-start border-success border-3">
                <div class="card-body p-3">
                    <div class="text-muted small text-uppercase fw-semibold">Diterima</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <h3 class="fw-bold mb-0 text-success">{{ $counts['accepted'] ?? 0 }}</h3>
                        <div class="avatar avatar-sm bg-success-transparent text-success rounded-circle">
                            <i class="fe fe-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-2">
            <div class="card shadow-sm border-0 border-start border-danger border-3">
                <div class="card-body p-3">
                    <div class="text-muted small text-uppercase fw-semibold">Ditolak</div>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <h3 class="fw-bold mb-0 text-danger">{{ $counts['rejected'] ?? 0 }}</h3>
                        <div class="avatar avatar-sm bg-danger-transparent text-danger rounded-circle">
                            <i class="fe fe-x-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <div class="d-flex flex-wrap justify-content-between align-items-center w-100 gap-3">
                {{-- Tabs Filter Jenjang --}}
                <ul class="nav nav-pills card-header-pills m-0">
                    <li class="nav-item">
                        <a class="nav-link {{ empty($filters['type']) ? 'active' : '' }}"
                            href="{{ route('admin.internships.index', array_merge(request()->except('type', 'page'), ['type' => ''])) }}">
                            Semua Kategori <span class="badge bg-light text-dark ms-1">{{ $counts['all'] ?? 0 }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($filters['type'] ?? '') === 'university' ? 'active' : '' }}"
                            href="{{ route('admin.internships.index', array_merge(request()->except('type', 'page'), ['type' => 'university'])) }}">
                            <i class="fe fe-book me-1"></i> Mahasiswa <span
                                class="badge bg-info text-white ms-1">{{ $counts['university'] ?? 0 }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($filters['type'] ?? '') === 'vocational' ? 'active' : '' }}"
                            href="{{ route('admin.internships.index', array_merge(request()->except('type', 'page'), ['type' => 'vocational'])) }}">
                            <i class="fe fe-briefcase me-1"></i> Siswa SMK <span
                                class="badge bg-secondary text-white ms-1">{{ $counts['vocational'] ?? 0 }}</span>
                        </a>
                    </li>
                </ul>

                {{-- Filter Status & Pencarian --}}
                <form action="{{ route('admin.internships.index') }}" method="GET"
                    class="d-flex align-items-center gap-2 m-0 flex-wrap">
                    @if (!empty($filters['type']))
                        <input type="hidden" name="type" value="{{ $filters['type'] }}">
                    @endif

                    <select name="status" class="form-select form-select-sm" style="width: 170px;"
                        onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>
                            Menunggu Review</option>
                        <option value="reviewing" {{ ($filters['status'] ?? '') === 'reviewing' ? 'selected' : '' }}>
                            Sedang Ditinjau</option>
                        <option value="accepted" {{ ($filters['status'] ?? '') === 'accepted' ? 'selected' : '' }}>
                            Diterima (Accepted)</option>
                        <option value="rejected" {{ ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' }}>
                            Ditolak (Rejected)</option>
                    </select>

                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nama / NISN / kampus..." value="{{ $filters['search'] ?? '' }}">
                        <button type="submit" class="btn btn-primary"><i class="fe fe-search"></i></button>
                        @if (!empty($filters['search']) || !empty($filters['status']) || !empty($filters['type']))
                            <a href="{{ route('admin.internships.index') }}" class="btn btn-light"
                                title="Reset filter"><i class="fe fe-x"></i></a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="table-internships" class="table table-hover table-striped align-middle mb-0 text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width: 50px;">No</th>
                            <th>Kode & Peserta</th>
                            <th>Institusi & Tingkat</th>
                            <th>Peminatan (Track)</th>
                            <th>Periode & Durasi</th>
                            <th>Berkas Dokumen</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-center pe-3" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr id="app-row-{{ $app->id }}">
                                <td class="ps-3 text-muted">
                                    {{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            <span
                                                class="badge bg-dark-transparent font-monospace text-dark px-2 py-1">{{ $app->registration_code }}</span>
                                            @if ($app->type === 'university')
                                                <span class="badge bg-info-transparent text-info px-2 py-1"
                                                    style="line-height: 1.2;">Univ</span>
                                            @else
                                                <span class="badge bg-secondary-transparent text-secondary px-2 py-1"
                                                    style="line-height: 1.2;">SMK</span>
                                            @endif
                                            @if ($app->is_group)
                                                <span class="badge bg-purple-transparent text-purple px-2 py-1"
                                                    style="line-height: 1.2;"
                                                    title="Pengajuan Kelompok / Tim ({{ $app->all_members->count() }} Orang)">
                                                    <i class="fe fe-users me-1"></i> Tim
                                                    ({{ $app->all_members->count() }})
                                                </span>
                                            @endif
                                        </div>
                                        <strong class="text-dark fs-14">{{ $app->name }}</strong>
                                        <div class="small text-muted d-flex align-items-center gap-2 mt-1">
                                            @php
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $app->phone);
                                                if (str_starts_with($cleanPhone, '0')) {
                                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                                }
                                            @endphp
                                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank"
                                                class="text-success text-decoration-none d-inline-flex align-items-center gap-1"
                                                title="Kirim Pesan WhatsApp">
                                                <i class="fa fa-whatsapp"></i> {{ $app->phone }}
                                            </a>
                                            <span>•</span>
                                            <span>{{ $app->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold text-dark">{{ $app->institution }}</span>
                                        @if ($app->major)
                                            <span class="small text-muted">{{ $app->major }}</span>
                                        @endif
                                        <span class="small text-secondary">{{ $app->grade_level }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-light text-primary border border-primary-light px-2 py-1 text-wrap"
                                        style="max-width: 200px; text-align: left;">
                                        {{ $app->track }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span
                                            class="badge bg-primary-transparent text-primary mb-1 align-self-start px-2 py-1"
                                            style="font-size: 11px; line-height: 1.4;">{{ $app->duration }}</span>
                                        @if ($app->period_formatted && $app->period_formatted !== '-')
                                            <span class="small text-muted">
                                                <i class="fe fe-calendar me-1"></i>{{ $app->period_formatted }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($app->file_identity)
                                            <a href="{{ $app->file_identity_url }}" target="_blank"
                                                class="btn btn-outline-secondary"
                                                title="{{ $app->type === 'vocational' ? 'Kartu Pelajar / KTP' : 'KTM / KTP' }}">
                                                <i class="fe fe-user"></i>
                                            </a>
                                        @endif
                                        @if ($app->file_recommendation)
                                            <a href="{{ $app->file_recommendation_url }}" target="_blank"
                                                class="btn btn-outline-secondary" title="Surat Pengantar / Rekomendasi">
                                                <i class="fe fe-file-text"></i>
                                            </a>
                                        @endif
                                        @if ($app->file_cv)
                                            <a href="{{ $app->file_cv_url }}" target="_blank"
                                                class="btn btn-outline-secondary" title="Curriculum Vitae / Portofolio">
                                                <i class="fe fe-briefcase"></i>
                                            </a>
                                        @endif
                                        @if ($app->file_transcript)
                                            <a href="{{ $app->file_transcript_url }}" target="_blank"
                                                class="btn btn-outline-secondary"
                                                title="{{ $app->type === 'vocational' ? 'Rapor' : 'Transkrip Nilai' }}">
                                                <i class="fe fe-award"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $app->badge_class }}"
                                        style="font-size: 11px; line-height: 1.4 !important; font-weight: 600; letter-spacing: 0.3px; display: inline-block; padding: 4px 8px !important;">
                                        {{ $app->status_label }}
                                    </span>
                                    @if ($app->notified_at)
                                        <div class="small text-success mt-1"
                                            title="Notifikasi WA terkirim {{ $app->notified_at->diffForHumans() }}">
                                            <i class="fa fa-whatsapp"></i> Terkirim
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="small text-muted">{{ $app->created_at->timezone('Asia/Jakarta')->format('d M Y') }}</span>
                                    <div class="text-muted text-xs">
                                        {{ $app->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                                </td>
                                <td class="text-center pe-3">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        {{-- Tombol Unduh Surat Balasan jika Accepted --}}
                                        @if ($app->status === 'accepted')
                                            <a href="{{ route('admin.internships.letter', $app) }}"
                                                class="btn btn-outline-success btn-sm rounded-11"
                                                title="Unduh Surat Balasan (PDF)">
                                                <i class="fe fe-file-text"></i>
                                            </a>
                                        @endif

                                        {{-- Tombol Modal Review --}}
                                        @php
                                            $appPayload = [
                                                'id' => $app->id,
                                                'code' => $app->registration_code,
                                                'name' => $app->name,
                                                'email' => $app->email,
                                                'phone' => $app->phone,
                                                'type_label' => $app->type_label,
                                                'is_group' => (bool) $app->is_group,
                                                'team_count' => $app->all_members->count(),
                                                'institution' => $app->institution,
                                                'institution_address' => $app->institution_address,
                                                'major' => $app->major,
                                                'head_of_program' => $app->head_of_program,
                                                'grade_level' => $app->grade_level,
                                                'track' => $app->track,
                                                'duration' => $app->duration,
                                                'period' => $app->period_formatted,
                                                'status' => $app->status,
                                                'notes' => $app->notes,
                                                'reference_number' => $app->reference_number,
                                                'reference_date' => $app->reference_date
                                                    ? $app->reference_date->format('Y-m-d')
                                                    : '',
                                                'acceptance_number' => $app->acceptance_number_formatted,
                                                'acceptance_date' => $app->acceptance_date
                                                    ? $app->acceptance_date->format('Y-m-d')
                                                    : now()->format('Y-m-d'),
                                                'letter_download_url' => route('admin.internships.letter', $app),
                                                'letter_preview_url' => route('admin.internships.letter.preview', $app),
                                                'update_url' => route('admin.internships.update', $app),
                                                'doc_identity' => $app->file_identity_url,
                                                'doc_rec' => $app->file_recommendation_url,
                                                'doc_cv' => $app->file_cv_url,
                                                'doc_transcript' => $app->file_transcript_url,
                                                'is_smk' => $app->type === 'vocational',
                                                'members' => $app->all_members
                                                    ->map(
                                                        fn($m) => [
                                                            'name' => $m->name,
                                                            'identity_number' => $m->identity_number,
                                                            'phone' => $m->phone,
                                                            'email' => $m->email,
                                                            'is_leader' => (bool) $m->is_leader,
                                                            'doc_identity' => $m->file_identity_url,
                                                            'doc_cv' => $m->file_cv_url,
                                                            'doc_transcript' => $m->file_transcript_url,
                                                        ],
                                                    )
                                                    ->values()
                                                    ->toArray(),
                                            ];
                                        @endphp
                                        <button type="button" class="btn btn-primary btn-sm rounded-11 btn-review-app"
                                            data-app="{{ json_encode($appPayload) }}" title="Tinjau & Putuskan">
                                            <i class="fe fe-edit-3"></i> Tinjau
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('admin.internships.destroy', $app) }}" method="POST"
                                            class="d-inline form-delete-internship" data-id="{{ $app->id }}"
                                            data-name="{{ $app->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-outline-danger btn-sm rounded-11 btn-delete-internship"
                                                data-bs-toggle="tooltip" title="Hapus Berkas">
                                                <i class="fe fe-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="fe fe-inbox fs-40 text-muted mb-2"></i>
                                        <h5 class="text-muted fw-normal">Belum ada data pendaftaran magang</h5>
                                        <p class="text-muted small mb-0">Permohonan magang yang diajukan peserta melalui
                                            form pendaftaran publik akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($applications->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Menampilkan {{ $applications->firstItem() ?? 0 }} - {{ $applications->lastItem() ?? 0 }} dari
                    {{ $applications->total() }} data
                </div>
                <div>
                    {{ $applications->links() }}
                </div>
            </div>
        @endif
    </div>

    {{-- MODAL REVIEW TERPADU PEMBINA MAGANG --}}
    <div class="modal fade" id="modal-review" tabindex="-1" aria-labelledby="modalReviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <form id="form-review-internship" method="POST" class="modal-content border-0 shadow-lg"
                style="max-height: 88vh; display: flex; flex-direction: column;">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white py-3 flex-shrink-0">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fe fe-check-square fs-20"></i>
                        <div>
                            <h5 class="modal-title mb-0 fw-bold text-white" id="modalReviewLabel">Peninjauan Permohonan
                                Magang</h5>
                            <small class="text-white-50" id="modal-sub-code">Kode Pendaftaran</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 flex-grow-1" style="overflow-y: auto;">
                    {{-- Profil Singkat Pemohon --}}
                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body p-3">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-semibold mb-0">Nama Lengkap</label>
                                    <div class="fw-bold text-dark fs-15" id="rev-name">-</div>
                                    <div class="small text-muted" id="rev-contact">-</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-semibold mb-0">Institusi &
                                        Tingkat</label>
                                    <div class="fw-bold text-dark" id="rev-institution">-</div>
                                    <div class="small text-muted" id="rev-major">-</div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label class="text-muted small text-uppercase fw-semibold mb-0">Peminatan
                                        (Track)</label>
                                    <div><span class="badge bg-primary text-white" id="rev-track">-</span></div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label class="text-muted small text-uppercase fw-semibold mb-0">Periode Magang</label>
                                    <div class="fw-semibold text-dark" id="rev-period">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Anggota Tim (Jika Permohonan Kelompok) --}}
                    <div id="rev-team-container"
                        class="card border border-primary-subtle bg-primary-transparent mb-3 d-none">
                        <div
                            class="card-header bg-transparent py-2 px-3 border-bottom border-primary-subtle d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary small"><i class="fe fe-users me-1"></i> Daftar Anggota Tim
                                Magang (<span id="rev-team-count">0</span> Orang)</span>
                            <span class="badge bg-primary text-white">Kelompok / Tim</span>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered bg-white mb-0 text-dark align-middle">
                                    <thead class="table-light">
                                        <tr class="small text-muted">
                                            <th style="width: 30px;" class="text-center">#</th>
                                            <th>Nama Lengkap</th>
                                            <th>NIM / NISN</th>
                                            <th>Peran</th>
                                            <th>Kontak</th>
                                            <th class="text-center">Berkas</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rev-team-tbody">
                                        {{-- Populated by JS --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Unduh / Tinjau Berkas Dokumen --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold text-dark mb-0">
                                <i class="fe fe-folder me-1 text-primary"></i> Berkas Lampiran Persyaratan Pemohon Utama
                            </label>
                            <small class="text-muted">Pratinjau langsung atau buka tab baru</small>
                        </div>
                        <div class="row g-2" id="rev-docs-container">
                            <div class="col-sm-6 col-md-3">
                                <div class="card border p-2 h-100 mb-0 shadow-none bg-white">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fe fe-credit-card fs-16 text-primary"></i>
                                        <div class="small fw-bold text-truncate" id="label-doc-id">KTM / KTP</div>
                                    </div>
                                    <div class="d-flex gap-1 mt-auto">
                                        <button type="button" class="btn btn-primary btn-sm flex-grow-1 btn-preview-doc"
                                            id="btn-view-id" data-url="#" data-title="KTM / KTP">
                                            <i class="fe fe-eye me-1"></i> Pratinjau
                                        </button>
                                        <a id="link-doc-id" href="#" target="_blank"
                                            class="btn btn-outline-primary btn-sm" title="Buka Tab Baru">
                                            <i class="fe fe-external-link"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="card border p-2 h-100 mb-0 shadow-none bg-white">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fe fe-file-text fs-16 text-info"></i>
                                        <div class="small fw-bold text-truncate">Surat Pengantar</div>
                                    </div>
                                    <div class="d-flex gap-1 mt-auto">
                                        <button type="button"
                                            class="btn btn-info text-white btn-sm flex-grow-1 btn-preview-doc"
                                            id="btn-view-rec" data-url="#" data-title="Surat Pengantar / Rekomendasi">
                                            <i class="fe fe-eye me-1"></i> Pratinjau
                                        </button>
                                        <a id="link-doc-rec" href="#" target="_blank"
                                            class="btn btn-outline-info btn-sm" title="Buka Tab Baru">
                                            <i class="fe fe-external-link"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="card border p-2 h-100 mb-0 shadow-none bg-white">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fe fe-briefcase fs-16 text-warning"></i>
                                        <div class="small fw-bold text-truncate">CV / Portofolio</div>
                                    </div>
                                    <div class="d-flex gap-1 mt-auto">
                                        <button type="button"
                                            class="btn btn-warning text-white btn-sm flex-grow-1 btn-preview-doc"
                                            id="btn-view-cv" data-url="#" data-title="CV & Portofolio">
                                            <i class="fe fe-eye me-1"></i> Pratinjau
                                        </button>
                                        <a id="link-doc-cv" href="#" target="_blank"
                                            class="btn btn-outline-warning btn-sm" title="Buka Tab Baru">
                                            <i class="fe fe-external-link"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="card border p-2 h-100 mb-0 shadow-none bg-white">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fe fe-award fs-16 text-success"></i>
                                        <div class="small fw-bold text-truncate" id="label-doc-trans">Transkrip Nilai
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1 mt-auto">
                                        <button type="button" class="btn btn-success btn-sm flex-grow-1 btn-preview-doc"
                                            id="btn-view-trans" data-url="#" data-title="Transkrip / Rapor">
                                            <i class="fe fe-eye me-1"></i> Pratinjau
                                        </button>
                                        <a id="link-doc-trans" href="#" target="_blank"
                                            class="btn btn-outline-success btn-sm" title="Buka Tab Baru">
                                            <i class="fe fe-external-link"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Pratinjau Dokumen Inline --}}
                        <div id="inline-preview-box" class="mt-3 d-none">
                            <div class="border rounded-3 shadow-sm bg-white overflow-hidden">
                                <div
                                    class="bg-dark text-white px-3 py-2 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fe fe-file-text text-info"></i>
                                        <span class="small fw-bold" id="inline-preview-name">Pratinjau Dokumen</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a id="inline-preview-popout" href="#" target="_blank"
                                            class="btn btn-outline-light btn-sm py-0 px-2" style="font-size: 11px;">
                                            <i class="fe fe-external-link me-1"></i> Buka Tab Penuh
                                        </a>
                                        <button type="button" class="btn btn-outline-light btn-sm py-0 px-2"
                                            id="btn-close-inline-doc" style="font-size: 11px;">
                                            <i class="fe fe-x me-1"></i> Tutup Pratinjau
                                        </button>
                                    </div>
                                </div>
                                <div class="position-relative" style="height: 480px; background: #525659;">
                                    <iframe id="inline-preview-frame" src=""
                                        style="width: 100%; height: 100%; border: none;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    {{-- Form Keputusan Status (Bebas Class .btn untuk Hindari Konflik White-space Zanex) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-2">
                            <i class="fe fe-check-circle me-1 text-primary"></i> Keputusan Pembina / Tim Seleksi <span
                                class="text-danger">*</span>
                        </label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="review-status-card" id="card-status-reviewing" for="status-reviewing">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" class="form-check-input mt-0 status-radio-input"
                                            name="status" id="status-reviewing" value="reviewing" autocomplete="off">
                                        <span class="fw-bold text-info fs-13"><i class="fe fe-search me-1"></i> Sedang
                                            Ditinjau</span>
                                    </div>
                                    <div class="status-desc ps-4">
                                        Dokumen valid, sedang proses verifikasi pembina.
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="review-status-card" id="card-status-accepted" for="status-accepted">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" class="form-check-input mt-0 status-radio-input"
                                            name="status" id="status-accepted" value="accepted" autocomplete="off">
                                        <span class="fw-bold text-success fs-13"><i class="fe fe-check me-1"></i> Diterima
                                            (Accepted)</span>
                                    </div>
                                    <div class="status-desc ps-4">
                                        Lolos seleksi permohonan magang PT Higertech.
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="review-status-card" id="card-status-rejected" for="status-rejected">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" class="form-check-input mt-0 status-radio-input"
                                            name="status" id="status-rejected" value="rejected" autocomplete="off">
                                        <span class="fw-bold text-danger fs-13"><i class="fe fe-x me-1"></i> Ditolak
                                            (Rejected)</span>
                                    </div>
                                    <div class="status-desc ps-4">
                                        Kuota penuh atau syarat berkas belum sesuai.
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Pengaturan Surat Balasan Permohonan (LoA PDF) - Muncul saat Diterima --}}
                    <div id="box-letter-settings"
                        class="card border border-success-subtle bg-success-transparent mb-3 d-none">
                        <div
                            class="card-header bg-transparent py-2 px-3 border-bottom border-success-subtle d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-success small">
                                <i class="fe fe-file-text me-1"></i> Format & Data Surat Balasan Penerimaan (LoA PDF)
                            </span>
                            <div class="d-flex gap-1" id="letter-action-buttons">
                                <a id="btn-letter-preview" href="#" target="_blank"
                                    class="btn btn-outline-success btn-sm py-0 px-2" style="font-size: 11px;">
                                    <i class="fe fe-eye me-1"></i> Pratinjau PDF
                                </a>
                                <a id="btn-letter-download" href="#"
                                    class="btn btn-success text-white btn-sm py-0 px-2" style="font-size: 11px;">
                                    <i class="fe fe-download me-1"></i> Unduh PDF
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-3 bg-white">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-dark mb-1">Nomor Surat Balasan
                                        Resmi</label>
                                    <input type="text" name="acceptance_number" id="rev-acceptance-number"
                                        class="form-control form-control-sm" placeholder="Contoh: 394/SP.KP/HGT/VII/2026">
                                    <div class="form-text text-xs text-muted">Format standar:
                                        <code>[No]/SP.KP/HGT/[Romawi]/[Tahun]</code>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-dark mb-1">Tanggal Surat
                                        Balasan</label>
                                    <input type="date" name="acceptance_date" id="rev-acceptance-date"
                                        class="form-control form-control-sm">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-dark mb-1">Yth. Ketua Jurusan / Kaprodi
                                        / Sekolah</label>
                                    <input type="text" name="head_of_program" id="rev-head-of-program"
                                        class="form-control form-control-sm"
                                        placeholder="Contoh: Ketua Program Studi D3 Teknik Komputer">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-dark mb-1">Alamat Kampus /
                                        Sekolah</label>
                                    <input type="text" name="institution_address" id="rev-institution-address"
                                        class="form-control form-control-sm"
                                        placeholder="Contoh: Jl. Gegerkalong Hilir, Ds. Ciwaruga, Bandung">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-dark mb-1">No. Surat Permohonan Kampus
                                        / Sekolah</label>
                                    <input type="text" name="reference_number" id="rev-reference-number"
                                        class="form-control form-control-sm" placeholder="Contoh: B/124/UN40.F3/KM/2026">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-dark mb-1">Tanggal Surat Permohonan
                                        Kampus</label>
                                    <input type="date" name="reference_date" id="rev-reference-date"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Catatan / Instruksi Pembina --}}
                    <div class="mb-3">
                        <label for="review-notes" class="form-label fw-bold text-dark mb-1">
                            Catatan / Instruksi Pembina <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <textarea name="notes" id="review-notes" rows="3" class="form-control"
                            placeholder="Contoh: Diterima di Lab IoT Bandung divisi Hardware. Jadwal orientasi Senin 1 Oktober 2026 pkl 08.30 WIB dengan membawa laptop dan surat pengantar asli."></textarea>
                        <div class="form-text small">Catatan ini akan langsung disertakan dalam pesan notifikasi
                            WhatsApp dan pada halaman live tracking peserta.</div>
                    </div>


                </div>

                <div
                    class="modal-footer bg-light py-2 px-4 flex-shrink-0 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold" id="btn-submit-decision">
                        <i class="fe fe-save me-1"></i> Simpan Keputusan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .review-status-card {
            display: block;
            padding: 12px 14px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            background-color: #ffffff;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            white-space: normal !important;
            word-break: normal;
            overflow-wrap: break-word;
            height: 100%;
            margin-bottom: 0;
        }

        .review-status-card:hover {
            border-color: #94a3b8;
            background-color: #f8fafc;
        }

        .review-status-card.active-reviewing {
            border-color: #0dcaf0 !important;
            background-color: #f0fbfc !important;
            box-shadow: 0 0 0 1px #0dcaf0;
        }

        .review-status-card.active-accepted {
            border-color: #198754 !important;
            background-color: #f0fdf4 !important;
            box-shadow: 0 0 0 1px #198754;
        }

        .review-status-card.active-rejected {
            border-color: #dc3545 !important;
            background-color: #fef2f2 !important;
            box-shadow: 0 0 0 1px #dc3545;
        }

        .review-status-card .status-desc {
            font-size: 11.5px;
            line-height: 1.35;
            color: #64748b;
            margin-top: 4px;
            white-space: normal !important;
            word-break: break-word;
        }
    </style>

    <script>
        function escapeHtml(text) {
            if (!text) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function updateStatusCards(status) {
            $('.review-status-card').removeClass('active-reviewing active-accepted active-rejected');
            if (status === 'reviewing') $('#card-status-reviewing').addClass('active-reviewing');
            if (status === 'accepted') $('#card-status-accepted').addClass('active-accepted');
            if (status === 'rejected') $('#card-status-rejected').addClass('active-rejected');
        }

        function updateLetterBoxVisibility(status) {
            if (status === 'accepted') {
                $('#box-letter-settings').removeClass('d-none');
                if (!$('#rev-acceptance-date').val()) {
                    var today = new Date().toISOString().split('T')[0];
                    $('#rev-acceptance-date').val(today);
                }
            } else {
                $('#box-letter-settings').addClass('d-none');
            }
        }

        $(document).on('change', '.status-radio-input', function() {
            var val = $(this).val();
            updateStatusCards(val);
            updateLetterBoxVisibility(val);
        });

        $(document).on('click', '.btn-review-app', function(e) {
            e.preventDefault();
            var btn = $(this).closest('.btn-review-app');
            var raw = btn.attr('data-app');
            var data = {};
            try {
                data = typeof raw === 'object' ? raw : JSON.parse(raw);
            } catch (err) {
                console.error('Error parsing data-app:', err, raw);
                return;
            }

            var formEl = document.getElementById('form-review-internship');
            if (formEl) {
                formEl.setAttribute('action', data.update_url || '');
            }

            // Set modal info
            $('#modal-sub-code').text('Kode Registrasi: ' + (data.code || '-'));
            $('#rev-name').text((data.name || '-') + (data.type_label ? ' (' + data.type_label + ')' : ''));
            $('#rev-contact').text((data.phone || '-') + ' • ' + (data.email || '-'));
            $('#rev-institution').text(data.institution || '-');
            $('#rev-major').text((data.major ? data.major + ' • ' : '') + (data.grade_level || ''));
            $('#rev-track').text(data.track || '-');
            $('#rev-period').text((data.period || '-') + (data.duration ? ' (' + data.duration + ')' : ''));

            // Render team members if group
            if (data.is_group && data.members && data.members.length > 0) {
                $('#rev-team-count').text(data.members.length);
                var tbody = $('#rev-team-tbody');
                tbody.empty();
                data.members.forEach(function(m, idx) {
                    var roleBadge = m.is_leader ?
                        '<span class="badge bg-primary text-white">Ketua Tim</span>' :
                        '<span class="badge bg-light text-dark border">Anggota</span>';
                    var docs = [];
                    if (m.doc_identity) {
                        docs.push(
                            '<button type="button" class="btn btn-outline-primary btn-sm py-0 px-2 btn-preview-doc" data-url="' +
                            m.doc_identity + '" data-title="KTM/KTP - ' + escapeHtml(m.name) +
                            '" title="Lihat Identitas"><i class="fe fe-credit-card me-1"></i>KTM</button>'
                        );
                    }
                    if (m.doc_cv) {
                        docs.push(
                            '<button type="button" class="btn btn-outline-warning btn-sm py-0 px-2 btn-preview-doc" data-url="' +
                            m.doc_cv + '" data-title="CV - ' + escapeHtml(m.name) +
                            '" title="Lihat CV"><i class="fe fe-briefcase me-1"></i>CV</button>');
                    }
                    if (m.doc_transcript) {
                        docs.push(
                            '<button type="button" class="btn btn-outline-success btn-sm py-0 px-2 btn-preview-doc" data-url="' +
                            m.doc_transcript + '" data-title="Transkrip - ' + escapeHtml(m.name) +
                            '" title="Lihat Transkrip"><i class="fe fe-award me-1"></i>Transkrip</button>'
                        );
                    }
                    var docsHtml = docs.length > 0 ? docs.join(' ') :
                        '<span class="text-muted small">-</span>';

                    tbody.append(
                        '<tr>' +
                        '<td class="text-center">' + (idx + 1) + '</td>' +
                        '<td><strong class="text-dark">' + escapeHtml(m.name) + '</strong></td>' +
                        '<td class="font-monospace small">' + escapeHtml(m.identity_number || '-') +
                        '</td>' +
                        '<td>' + roleBadge + '</td>' +
                        '<td class="small">' + escapeHtml(m.phone || '-') +
                        '<br><span class="text-muted">' + escapeHtml(m.email || '-') + '</span></td>' +
                        '<td class="text-center">' + docsHtml + '</td>' +
                        '</tr>'
                    );
                });
                $('#rev-team-container').removeClass('d-none');
            } else {
                $('#rev-team-container').addClass('d-none');
            }

            // Document labels & links for leader/single applicant
            $('#label-doc-id').text(data.is_smk ? 'Kartu Pelajar / KTP' : 'KTM / KTP');
            $('#label-doc-trans').text(data.is_smk ? 'Rapor Terakhir' : 'Transkrip Nilai');

            // Reset inline preview box
            $('#inline-preview-box').addClass('d-none');
            $('#inline-preview-frame').attr('src', '');

            function setupDoc(linkSel, viewBtnSel, url, title) {
                var linkEl = $(linkSel);
                var viewEl = $(viewBtnSel);
                if (url) {
                    linkEl.attr('href', url).removeClass('disabled').attr('title', 'Buka ' + title +
                        ' di Tab Baru');
                    viewEl.attr('data-url', url).attr('data-title', title).prop('disabled', false).html(
                        '<i class="fe fe-eye me-1"></i> Pratinjau');
                } else {
                    linkEl.attr('href', '#').addClass('disabled').attr('title', 'Berkas tidak diunggah');
                    viewEl.attr('data-url', '#').prop('disabled', true).html(
                        '<i class="fe fe-slash me-1"></i> Kosong');
                }
            }

            setupDoc('#link-doc-id', '#btn-view-id', data.doc_identity, data.is_smk ? 'Kartu Pelajar / KTP' :
                'KTM / KTP');
            setupDoc('#link-doc-rec', '#btn-view-rec', data.doc_rec, 'Surat Pengantar Kampus / Sekolah');
            setupDoc('#link-doc-cv', '#btn-view-cv', data.doc_cv, 'Curriculum Vitae / Portofolio');
            setupDoc('#link-doc-trans', '#btn-view-trans', data.doc_transcript, data.is_smk ? 'Rapor Terakhir' :
                'Transkrip Nilai');

            // Status radio
            var currentStatus = data.status || 'reviewing';
            var radioEl = document.getElementById('status-' + currentStatus);
            if (radioEl) {
                radioEl.checked = true;
            } else {
                var defaultRadio = document.getElementById('status-reviewing');
                if (defaultRadio) defaultRadio.checked = true;
            }
            updateStatusCards(currentStatus);

            // Set letter settings
            $('#rev-acceptance-number').val(data.acceptance_number || '');
            $('#rev-acceptance-date').val(data.acceptance_date || '');
            $('#rev-head-of-program').val(data.head_of_program || '');
            $('#rev-institution-address').val(data.institution_address || '');
            $('#rev-reference-number').val(data.reference_number || '');
            $('#rev-reference-date').val(data.reference_date || '');

            if (data.letter_preview_url) {
                $('#btn-letter-preview').attr('href', data.letter_preview_url).removeClass('disabled');
            } else {
                $('#btn-letter-preview').attr('href', '#').addClass('disabled');
            }

            if (data.letter_download_url) {
                $('#btn-letter-download').attr('href', data.letter_download_url).removeClass('disabled');
            } else {
                $('#btn-letter-download').attr('href', '#').addClass('disabled');
            }

            updateLetterBoxVisibility(currentStatus);

            // Notes
            $('#review-notes').val(data.notes || '');

            // Open Modal via Bootstrap 5 or jQuery modal
            var modalEl = document.getElementById('modal-review');
            if (window.bootstrap && bootstrap.Modal) {
                bootstrap.Modal.getOrCreateInstance(modalEl).show();
            } else {
                $('#modal-review').modal('show');
            }
        });

        // Inline preview toggle inside modal
        $(document).on('click', '.btn-preview-doc', function(e) {
            e.preventDefault();
            var url = $(this).attr('data-url');
            var title = $(this).attr('data-title') || 'Pratinjau Dokumen';
            if (!url || url === '#') return;

            $('#inline-preview-name').text(title);
            $('#inline-preview-popout').attr('href', url);
            $('#inline-preview-frame').attr('src', url);
            $('#inline-preview-box').removeClass('d-none');

            // Smooth scroll modal body to preview
            var modalBody = $('#modal-review .modal-body');
            var previewOffset = $('#inline-preview-box').position().top + modalBody.scrollTop();
            modalBody.animate({
                scrollTop: previewOffset - 20
            }, 300);
        });

        $(document).on('click', '#btn-close-inline-doc', function(e) {
            e.preventDefault();
            $('#inline-preview-box').addClass('d-none');
            $('#inline-preview-frame').attr('src', '');
        });

        $('#modal-review').on('hidden.bs.modal', function() {
            $('#inline-preview-box').addClass('d-none');
            $('#inline-preview-frame').attr('src', '');
        });

        // Handle SweetAlert2 Delete Confirmation for Internship Application
        $(document).on('submit', '.form-delete-internship', function(e) {
            e.preventDefault();
            var form = $(this);
            var appId = form.data('id');
            var appName = form.data('name') || 'Pendaftar ini';
            var actionUrl = form.attr('action');

            if (typeof Swal === 'undefined') {
                if (confirm('Apakah Anda yakin ingin menghapus data pendaftaran magang atas nama ' + appName +
                        '? Seluruh berkas file yang diunggah akan dihapus permanen.')) {
                    form.off('submit').submit();
                }
                return;
            }

            Swal.fire({
                title: 'Hapus Pendaftaran Magang?',
                html: 'Data pendaftaran atas nama <b>' + $('<div>').text(appName).html() +
                    '</b> beserta seluruh berkas dokumennya akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fe fe-trash-2 me-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }).catch(function(xhr) {
                        var errorMsg = 'Gagal menghapus data pendaftaran.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.showValidationMessage(errorMsg);
                    });
                },
                allowOutsideClick: function() {
                    return !Swal.isLoading();
                }
            }).then(function(result) {
                if (result.isConfirmed && result.value && result.value.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Dihapus',
                        text: result.value.message || 'Data pendaftaran magang berhasil dihapus.',
                        timer: 1800,
                        showConfirmButton: false
                    });

                    // Smooth fade out and remove row
                    var row = $('#app-row-' + appId);
                    if (row.length) {
                        row.fadeOut(350, function() {
                            $(this).remove();
                            // If table is now empty, reload page to refresh counters and pagination
                            if ($('#table-internships tbody tr').length === 0) {
                                window.location.reload();
                            }
                        });
                    } else {
                        window.location.reload();
                    }
                }
            });
        });
    </script>
@endpush
