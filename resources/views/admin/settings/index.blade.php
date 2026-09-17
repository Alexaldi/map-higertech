@extends('admin.layouts.app')
@section('title', 'Pengaturan Website | Higertech Karya Sinergi')
@section('content')
    <div class="row mt-5">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title mb-0">Pengaturan Website & Identitas</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="panel panel-primary">
                            <div class="tab-menu-heading border-bottom-0">
                                <div class="tabs-menu1">
                                    <ul class="nav panel-tabs gap-2" role="tablist">
                                        <li>
                                            <button class="nav-link active btn btn-outline-primary" data-bs-toggle="tab"
                                                data-bs-target="#tab-contact" type="button" role="tab">
                                                <i class="fe fe-phone me-1"></i> Kontak Utama
                                            </button>
                                        </li>
                                        <li>
                                            <button class="nav-link btn btn-outline-primary" data-bs-toggle="tab"
                                                data-bs-target="#tab-address" type="button" role="tab">
                                                <i class="fe fe-map-pin me-1"></i> Alamat & Profil
                                            </button>
                                        </li>
                                        <li>
                                            <button class="nav-link btn btn-outline-primary" data-bs-toggle="tab"
                                                data-bs-target="#tab-social" type="button" role="tab">
                                                <i class="fe fe-share-2 me-1"></i> Media Sosial
                                            </button>
                                        </li>
                                        <li>
                                            <button class="nav-link btn btn-outline-primary" data-bs-toggle="tab"
                                                data-bs-target="#tab-internship" type="button" role="tab">
                                                <i class="fe fe-award me-1"></i> Fitur & Peminatan Magang
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body pt-4">
                                <div class="tab-content">
                                    {{-- Tab 1: Kontak --}}
                                    <div class="tab-pane active" id="tab-contact" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="contact_email" class="form-label font-weight-semibold">Email
                                                    Kontak Resmi <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fe fe-mail"></i></span>
                                                    <input type="email"
                                                        class="form-control @error('contact_email') is-invalid @enderror"
                                                        id="contact_email" name="contact_email"
                                                        value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                                        placeholder="contoh: info@higertech.com" required>
                                                </div>
                                                <small class="text-muted">Ditampilkan pada topbar dan footer
                                                    website.</small>
                                                @error('contact_email')
                                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="contact_phone" class="form-label font-weight-semibold">Nomor
                                                    Telepon Kantor <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fe fe-phone-call"></i></span>
                                                    <input type="text"
                                                        class="form-control @error('contact_phone') is-invalid @enderror"
                                                        id="contact_phone" name="contact_phone"
                                                        value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                                                        placeholder="contoh: 022-2101-0299" required>
                                                </div>
                                                <small class="text-muted">Ditampilkan pada topbar dan footer
                                                    website.</small>
                                                @error('contact_phone')
                                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="contact_whatsapp" class="form-label font-weight-semibold">Nomor
                                                    WhatsApp Layanan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fe fe-message-circle"></i></span>
                                                    <input type="text"
                                                        class="form-control @error('contact_whatsapp') is-invalid @enderror"
                                                        id="contact_whatsapp" name="contact_whatsapp"
                                                        value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '') }}"
                                                        placeholder="contoh: 08112332182">
                                                </div>
                                                <small class="text-muted">Nomor kontak langsung via WA untuk konsultasi
                                                    teknis.</small>
                                                @error('contact_whatsapp')
                                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="site_name" class="form-label font-weight-semibold">Nama
                                                    Perusahaan / Website</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fe fe-globe"></i></span>
                                                    <input type="text"
                                                        class="form-control @error('site_name') is-invalid @enderror"
                                                        id="site_name" name="site_name"
                                                        value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                                                        placeholder="PT Higertech Karya Sinergi">
                                                </div>
                                                @error('site_name')
                                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tab 2: Alamat & Profil --}}
                                    <div class="tab-pane" id="tab-address" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="contact_address"
                                                    class="form-label font-weight-semibold">Alamat Workshop / Lab
                                                    R&D</label>
                                                <textarea class="form-control @error('contact_address') is-invalid @enderror" id="contact_address"
                                                    name="contact_address" rows="3" placeholder="Masukkan alamat lengkap">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                                                <small class="text-muted">Ditampilkan pada bagian workshop info di
                                                    footer.</small>
                                                @error('contact_address')
                                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label for="footer_about" class="form-label font-weight-semibold">Teks
                                                    Ringkasan Profil (Footer About)</label>
                                                <textarea class="form-control @error('footer_about') is-invalid @enderror" id="footer_about" name="footer_about"
                                                    rows="3" placeholder="Masukkan ringkasan profil">{{ old('footer_about', $settings['footer_about'] ?? '') }}</textarea>
                                                <small class="text-muted">Ditampilkan di bawah logo Higertech pada
                                                    footer.</small>
                                                @error('footer_about')
                                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tab 3: Media Sosial --}}
                                    <div class="tab-pane" id="tab-social" role="tabpanel">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                            <div>
                                                <h5 class="mb-1 font-weight-bold">Kelola Akun Media Sosial</h5>
                                                <p class="text-muted fs-12 mb-0">Pilih icon dari stok platform yang
                                                    tersedia, beri nama label, dan cantumkan URL tautan. Anda dapat menambah
                                                    atau menghapus media sosial kapan saja.</p>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="addSocialRow()">
                                                <i class="fe fe-plus me-1"></i> Tambah Media Sosial
                                            </button>
                                        </div>

                                        <div id="social-rows-container" class="d-flex flex-column gap-3">
                                            {{-- Rows dynamically populated via JS --}}
                                        </div>

                                        <div id="social-empty-state"
                                            class="text-center py-5 border rounded-3 bg-light d-none">
                                            <i class="fe fe-share-2 fs-30 text-muted d-block mb-2"></i>
                                            <span class="text-muted">Belum ada akun media sosial yang ditambahkan.</span>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm"
                                                    onclick="addSocialRow()">
                                                    <i class="fe fe-plus me-1"></i> Tambah Media Sosial
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tab 4: Fitur & Peminatan Magang --}}
                                    <div class="tab-pane" id="tab-internship" role="tabpanel">
                                        {{-- Pengaturan Status Pendaftaran Magang (Aktif / Nonaktif) --}}
                                        @php
                                            $isInternshipActive =
                                                (string) old(
                                                    'internship_enabled',
                                                    $settings['internship_enabled'] ?? '1',
                                                ) === '1';
                                            $defaultClosedMsg =
                                                'Mohon maaf, pendaftaran magang periode saat ini sedang ditutup. Nantikan pengumuman batch berikutnya atau hubungi kontak kami untuk informasi lebih lanjut.';
                                            $closedMsg = old(
                                                'internship_closed_message',
                                                $settings['internship_closed_message'] ?? $defaultClosedMsg,
                                            );
                                        @endphp

                                        <div class="card border mb-4 shadow-none">
                                            <div
                                                class="card-header bg-light d-flex justify-content-between align-items-center py-2.5">
                                                <h6 class="card-title mb-0 fs-13 fw-bold text-dark">
                                                    <i class="fe fe-toggle-right me-1 text-primary"></i> Kontrol Status
                                                    Pendaftaran Magang
                                                </h6>
                                                <span
                                                    class="badge {{ $isInternshipActive ? 'bg-success-transparent text-success border border-success' : 'bg-danger-transparent text-danger border border-danger' }} fs-11 px-2.5 py-1">
                                                    Status Saat Ini:
                                                    {{ $isInternshipActive ? 'AKTIF (DIBUKA)' : 'NONAKTIF (DITUTUP)' }}
                                                </span>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label
                                                            class="form-label fs-12 font-weight-semibold text-dark mb-2">
                                                            Pilih Status Portal Pendaftaran:
                                                        </label>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="card border p-3 cursor-pointer mb-0 h-100 {{ $isInternshipActive ? 'border-primary bg-primary-transparent' : 'bg-light' }}"
                                                                    for="internship_enabled_1" style="cursor: pointer;">
                                                                    <div class="d-flex align-items-start gap-2.5">
                                                                        <input class="form-check-input mt-1"
                                                                            type="radio" name="internship_enabled"
                                                                            id="internship_enabled_1" value="1"
                                                                            {{ $isInternshipActive ? 'checked' : '' }}>
                                                                        <div>
                                                                            <strong
                                                                                class="d-block text-success fs-13 mb-1">
                                                                                <i class="fe fe-check-circle me-1"></i>
                                                                                Buka Pendaftaran (Aktif)
                                                                            </strong>
                                                                            <small
                                                                                class="text-muted d-block line-height-sm">
                                                                                Siswa SMK dan Mahasiswa dapat mengakses
                                                                                formulir dan mendaftar program magang secara
                                                                                publik di website.
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="card border p-3 cursor-pointer mb-0 h-100 {{ !$isInternshipActive ? 'border-danger bg-danger-transparent' : 'bg-light' }}"
                                                                    for="internship_enabled_0" style="cursor: pointer;">
                                                                    <div class="d-flex align-items-start gap-2.5">
                                                                        <input class="form-check-input mt-1"
                                                                            type="radio" name="internship_enabled"
                                                                            id="internship_enabled_0" value="0"
                                                                            {{ !$isInternshipActive ? 'checked' : '' }}>
                                                                        <div>
                                                                            <strong class="d-block text-danger fs-13 mb-1">
                                                                                <i class="fe fe-x-circle me-1"></i> Tutup
                                                                                Pendaftaran (Nonaktif)
                                                                            </strong>
                                                                            <small
                                                                                class="text-muted d-block line-height-sm">
                                                                                Tombol pendaftaran dinonaktifkan &
                                                                                menampilkan pesan penutupan. <em>Peserta
                                                                                    lama tetap dapat melacak status &
                                                                                    mengunduh SK/LoA.</em>
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="internship_closed_message"
                                                            class="form-label fs-12 font-weight-semibold text-dark mb-1">
                                                            Pesan Keterangan Saat Pendaftaran Ditutup:
                                                        </label>
                                                        <textarea class="form-control fs-12" id="internship_closed_message" name="internship_closed_message" rows="2"
                                                            placeholder="Masukkan pesan yang ditampilkan ketika pendaftaran ditutup...">{{ $closedMsg }}</textarea>
                                                        <small class="text-muted d-block mt-1">
                                                            Pesan ini akan muncul sebagai banner peringatan di halaman
                                                            pendaftaran magang ketika status ditutup.
                                                        </small>
                                                        @error('internship_closed_message')
                                                            <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alert alert-info py-2 px-3 mb-3 d-flex align-items-center gap-2">
                                            <i class="fe fe-info fs-18"></i>
                                            <span class="small">
                                                Daftar peminatan ini akan muncul pada dropdown formulir pendaftaran magang
                                                publik di <code>/internship</code>. Tuliskan <strong>1 peminatan per
                                                    baris</strong>. Sistem juga secara otomatis menyediakan pilihan
                                                <em>"Lainnya (Tulis Manual)"</em> bagi peserta jika bidangnya tidak ada di
                                                daftar.
                                            </span>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="card border mb-0">
                                                    <div class="card-header bg-light py-2">
                                                        <h6 class="card-title mb-0 fs-13 fw-bold text-dark">
                                                            <i class="fe fe-briefcase me-1 text-secondary"></i> Peminatan
                                                            Khusus Siswa SMK
                                                        </h6>
                                                    </div>
                                                    <div class="card-body p-3">
                                                        <label for="internship_tracks_smk"
                                                            class="form-label fs-12 text-muted mb-1">
                                                            Daftar Peminatan (1 baris per opsi):
                                                        </label>
                                                        <textarea class="form-control font-monospace fs-12" id="internship_tracks_smk" name="internship_tracks_smk"
                                                            rows="8"
                                                            placeholder="Perakitan & Soldering Hardware IoT&#10;Wiring & Instalasi Panel Stasiun AWLR/AWS&#10;Teknisi Lapangan & Kalibrasi Sensor&#10;...">{{ old('internship_tracks_smk', $settings['internship_tracks_smk'] ?? implode("\n", internship_tracks('vocational'))) }}</textarea>
                                                        <small class="text-muted d-block mt-1">Disarankan menggunakan
                                                            istilah praktis dan kejuruan SMK.</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card border mb-0">
                                                    <div class="card-header bg-light py-2">
                                                        <h6 class="card-title mb-0 fs-13 fw-bold text-dark">
                                                            <i class="fe fe-book me-1 text-info"></i> Peminatan Khusus
                                                            Mahasiswa (Univ)
                                                        </h6>
                                                    </div>
                                                    <div class="card-body p-3">
                                                        <label for="internship_tracks_univ"
                                                            class="form-label fs-12 text-muted mb-1">
                                                            Daftar Peminatan (1 baris per opsi):
                                                        </label>
                                                        <textarea class="form-control font-monospace fs-12" id="internship_tracks_univ" name="internship_tracks_univ"
                                                            rows="8"
                                                            placeholder="IoT Embedded Firmware Engineer&#10;Hydrology & Sensor Field Engineer&#10;Web SCADA & GIS Telemetry Developer&#10;...">{{ old('internship_tracks_univ', $settings['internship_tracks_univ'] ?? implode("\n", internship_tracks('university'))) }}</textarea>
                                                        <small class="text-muted d-block mt-1">Dapat disesuaikan dengan
                                                            kebutuhan proyek riset & enjiniring lab Higertech.</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-1"></i> Simpan Pengaturan
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Kembali ke Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const availablePlatforms = @json($availablePlatforms ?? social_platforms());
        const initialSocialLinks = @json($socialLinks ?? []);

        let rowIndex = 0;

        function renderSocialRow(data = {}) {
            const container = document.getElementById('social-rows-container');

            const platKey = data.platform || 'whatsapp';
            const label = data.label !== undefined ? data.label : (availablePlatforms[platKey]?.name || '');
            const url = data.url || '';

            const currentPlat = availablePlatforms[platKey] || availablePlatforms['globe'] || {
                name: 'Pilih',
                icon: '',
                placeholder: 'https://...'
            };

            let iconPaletteItems = '';
            for (const [key, plat] of Object.entries(availablePlatforms)) {
                const isSelected = key === platKey ? 'border-primary bg-primary-transparent' : 'border-light bg-light';
                iconPaletteItems += `
                    <button type="button" class="btn btn-sm p-1 d-flex align-items-center justify-content-center rounded-3 border btn-icon-choice ${isSelected}"
                        data-key="${key}"
                        title="${plat.name}"
                        onclick="selectPlatform('${key}', ${rowIndex})"
                        style="width: 38px; height: 38px; transition: transform 0.15s ease;">
                        <span class="d-inline-flex align-items-center justify-content-center pointer-events-none">
                            ${plat.icon}
                        </span>
                    </button>
                `;
            }

            const rowDiv = document.createElement('div');
            rowDiv.className = 'card border shadow-none mb-0 social-row';
            rowDiv.id = `social-row-${rowIndex}`;
            rowDiv.innerHTML = `
                <div class="card-body p-3">
                    <div class="row align-items-center g-2">
                        <div class="col-md-2 col-sm-3 col-4">
                            <label class="form-label fs-12 text-muted mb-1">Pilih Icon</label>
                            <div class="dropdown">
                                <button type="button" class="btn btn-light border text-dark w-100 d-flex align-items-center justify-content-center gap-1.5 py-1 px-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="platform-btn-${rowIndex}" style="height: 38px; background: #fff;" title="Pilih Icon Media Sosial">
                                    <span id="platform-icon-display-${rowIndex}" class="d-inline-flex align-items-center justify-content-center">
                                        ${currentPlat.icon || ''}
                                    </span>
                                </button>
                                <input type="hidden" name="social_links[${rowIndex}][platform]" id="platform-input-${rowIndex}" value="${platKey}">
                                <div class="dropdown-menu shadow-lg p-2.5 border-0" style="width: 245px; z-index: 1050;">
                                    <div class="text-muted fs-11 px-1 py-1 font-weight-semibold text-uppercase tracking-wider border-bottom mb-2">Pilih Icon Medsos:</div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-start p-1">
                                        ${iconPaletteItems}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4 col-8">
                            <label class="form-label fs-12 text-muted mb-1">Nama / Label</label>
                            <input type="text" name="social_links[${rowIndex}][label]" class="form-control social-label" value="${label}" placeholder="Contoh: Instagram Resmi">
                        </div>
                        <div class="col-md-6 col-sm-4 col-10">
                            <label class="form-label fs-12 text-muted mb-1">Tautan / URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-link"></i></span>
                                <input type="url" name="social_links[${rowIndex}][url]" class="form-control social-url" value="${url}" placeholder="${currentPlat.placeholder || 'https://...'}" required>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-2 text-center">
                            <label class="form-label fs-12 text-muted mb-1 d-none d-md-block">Aksi</label>
                            <button type="button" class="btn btn-danger btn-sm rounded-11 d-inline-flex align-items-center justify-content-center w-100" style="height: 38px;" title="Hapus Media Sosial" onclick="removeSocialRow(${rowIndex})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6l-1 14H6L5 6"></path>
                                    <path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M9 6V4h6v2"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(rowDiv);
            rowIndex++;
            updateEmptyState();
        }

        function addSocialRow() {
            renderSocialRow({
                platform: 'whatsapp',
                label: 'WhatsApp',
                url: ''
            });
        }

        function removeSocialRow(id) {
            const row = document.getElementById(`social-row-${id}`);
            if (row) {
                row.remove();
                updateEmptyState();
            }
        }

        function selectPlatform(key, id) {
            const plat = availablePlatforms[key];
            if (!plat) return;

            document.getElementById(`platform-input-${id}`).value = key;
            document.getElementById(`platform-icon-display-${id}`).innerHTML = plat.icon;

            const row = document.getElementById(`social-row-${id}`);
            if (row) {
                row.querySelectorAll('.btn-icon-choice').forEach(b => {
                    b.classList.remove('border-primary', 'bg-primary-transparent');
                    b.classList.add('border-light', 'bg-light');
                });
                const activeBtn = row.querySelector(`.btn-icon-choice[data-key="${key}"]`);
                if (activeBtn) {
                    activeBtn.classList.add('border-primary', 'bg-primary-transparent');
                    activeBtn.classList.remove('border-light', 'bg-light');
                }

                const urlInput = row.querySelector('.social-url');
                const labelInput = row.querySelector('.social-label');
                if (urlInput) {
                    urlInput.placeholder = plat.placeholder;
                }
                if (labelInput && (!labelInput.value || Object.values(availablePlatforms).some(p => p.name === labelInput
                        .value))) {
                    labelInput.value = plat.name;
                }

                const btn = document.getElementById(`platform-btn-${id}`);
                if (btn && window.bootstrap && bootstrap.Dropdown) {
                    const dropdown = bootstrap.Dropdown.getInstance(btn);
                    if (dropdown) dropdown.hide();
                }
            }
        }

        function updateEmptyState() {
            const container = document.getElementById('social-rows-container');
            const emptyState = document.getElementById('social-empty-state');
            if (container.children.length === 0) {
                emptyState.classList.remove('d-none');
            } else {
                emptyState.classList.add('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (initialSocialLinks && initialSocialLinks.length > 0) {
                initialSocialLinks.forEach(link => renderSocialRow(link));
            } else {
                updateEmptyState();
            }
        });
    </script>
@endsection
