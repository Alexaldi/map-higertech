@extends('layouts.app')

@section('title', 'Pusat Layanan Magang & PKL - PT Higertech Karya Sinergi')
@section('description',
    'Pusat layanan pendaftaran Praktik Kerja Lapangan (PKL SMK/MAK) dan program Internship R&D
    mahasiswa PT Higertech Karya Sinergi.')

@section('content')
    <main class="flex-1">
        <!-- BEGIN: Hero Section -->
        <section class="relative pt-16 pb-20 sm:pt-20 sm:pb-24 px-4 sm:px-8 bg-transparent transition-colors duration-300">
            <div class="max-w-5xl mx-auto text-center">
                <!-- Top Technical Badge -->
                <div
                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-mono font-bold tracking-wide bg-[#e0f2fe] text-[#0369a1] dark:bg-blue-950/70 dark:text-cyan-300 mb-6 shadow-xs border border-sky-200 dark:border-blue-800">
                    <span class="w-2 h-2 rounded-full bg-[#0284c7] dark:bg-cyan-400 animate-pulse"></span>
                    <span>DIVISI LITBANG & PENGEMBANGAN TALENTA VOKASI - PT HIGERTECH KARYA SINERGI</span>
                </div>

                <!-- Headline -->
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl lg:text-[54px] font-extrabold tracking-tight text-[#0f172a] dark:text-white mb-5 leading-tight">
                    Membangun Talenta Instrumentasi &
                    <span
                        class="bg-gradient-to-r from-[#0284c7] to-[#0ea5e9] dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">Telemetri
                        Nasional</span>
                </h1>

                <!-- Subheadline -->
                <p
                    class="text-base sm:text-lg text-[#334155] dark:text-slate-300 max-w-3xl mx-auto leading-relaxed font-normal mb-8">
                    Program magang terstruktur yang melibatkan siswa SMK/MAK dan mahasiswa dari
                    <strong class="text-[#0f172a] dark:text-white font-bold">SEMUA JURUSAN</strong>
                    (Teknik, IT, Administrasi, Bisnis, Desain, & lainnya) langsung dalam perakitan perangkat keras RTU,
                    kalibrasi sensor hidrometeorologi, dan implementasi sistem SCADA.
                </p>

                <!-- Action Bar -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-md mx-auto">
                    <a class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold text-white bg-[#0ea5e9] hover:bg-[#0284c7] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 shadow-md transition-all duration-150 cursor-pointer"
                        href="#komparasi-jalur"
                        onclick="event.preventDefault(); document.getElementById('komparasi-jalur').scrollIntoView({ behavior: 'smooth', block: 'start' });">
                        <span>Ajukan Pendaftaran Magang / PKL</span>
                        <span class="text-base leading-none">→</span>
                    </a>
                    <button
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-semibold text-[#0f172a] dark:text-slate-100 bg-white dark:bg-slate-800/90 hover:bg-slate-50 dark:hover:bg-slate-700 border border-[#cbd5e1] dark:border-slate-700 shadow-sm transition-all duration-150 font-mono cursor-pointer"
                        onclick="openModal('modal-lacak-status')" type="button">
                        <span>Lacak Status Berkas & Kelulusan</span>
                        <span class="text-sm">🔍</span>
                    </button>
                </div>

                <!-- Technical Telemetry Metatags -->
                <div
                    class="mt-8 flex flex-wrap items-center justify-center gap-3 text-xs font-mono text-[#1e293b] dark:text-slate-300">
                    <span
                        class="inline-flex items-center gap-1.5 bg-white dark:bg-slate-800/80 px-3.5 py-1.5 rounded-lg shadow-sm border border-[#e2e8f0] dark:border-slate-700/80 font-medium">
                        <svg class="w-3.5 h-3.5 text-[#0284c7] dark:text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                fill-rule="evenodd"></path>
                        </svg>
                        Batch Ganjil 2025/2026
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 bg-white dark:bg-slate-800/80 px-3.5 py-1.5 rounded-lg shadow-sm border border-[#e2e8f0] dark:border-slate-700/80 font-medium">
                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path clip-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                fill-rule="evenodd"></path>
                        </svg>
                        Lab R&D Bandung (WFO)
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 bg-white dark:bg-slate-800/80 px-3.5 py-1.5 rounded-lg shadow-sm border border-[#e2e8f0] dark:border-slate-700/80 font-medium">
                        <svg class="w-3.5 h-3.5 text-[#0284c7] dark:text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path clip-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                fill-rule="evenodd"></path>
                        </svg>
                        Sertifikasi Industri Resmi
                    </span>
                </div>
            </div>
        </section>
        <!-- END: Hero Section -->

        <!-- BEGIN: Section Komparasi Jalur Program & Syarat Umum -->
        <section class="py-16 px-4 sm:px-8 bg-slate-100/50 dark:bg-[#07152b] transition-colors duration-300"
            id="komparasi-jalur">
            <div class="max-w-6xl mx-auto">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <span
                        class="text-xs font-mono uppercase tracking-widest text-[#0284c7] dark:text-cyan-400 font-bold">STANDAR
                        KUALIFIKASI VOKASI</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0f172a] dark:text-white mt-1">
                        Komparasi Jalur Program & Persyaratan Teknis
                    </h2>
                    <p class="text-sm text-[#475569] dark:text-slate-300 mt-2 font-medium">
                        Pilih jalur magang yang selaras dengan jenjang studi dan kurikulum institusi pendidikan Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kolom 1: Praktik Kerja Lapangan (PKL SMK/MAK) -->
                    <div
                        class="bg-white dark:bg-[#131D36] rounded-3xl p-7 sm:p-8 flex flex-col justify-between shadow-lg shadow-slate-200/50 dark:shadow-none border border-[#e2e8f0] dark:border-slate-800 hover:border-blue-300 dark:hover:border-slate-700 transition-all duration-300 relative group">
                        <div>
                            <!-- Card Header -->
                            <div class="flex items-center justify-between gap-2 mb-5">
                                <div class="flex items-center space-x-2">
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-mono font-bold uppercase tracking-wider bg-blue-50 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200 border border-blue-100 dark:border-blue-800/60">
                                        JALUR VOKASI MENENGAH
                                    </span>
                                    <span
                                        class="px-2 py-1 rounded-md text-[11px] font-mono font-semibold bg-slate-100 text-[#0f172a] dark:bg-slate-800 dark:text-slate-200">
                                        SMK / MAK
                                    </span>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-400 flex items-center justify-center group-hover:scale-105 transition-transform border border-blue-100 dark:border-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"></path>
                                        <path
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        <path d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"></path>
                                    </svg>
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-[#0f172a] dark:text-white mb-2">
                                Praktik Kerja Lapangan (PKL SMK/MAK)
                            </h3>
                            <p class="text-xs text-[#475569] dark:text-slate-300 mb-6 leading-relaxed font-normal">
                                Fokus pada standardisasi instalasi perkabelan RTU, soldering mikrokomponen, kalibrasi
                                mekanik sensor, dan penyiapan instrumen telemetry hidrologi di lapangan.
                            </p>

                            <!-- Technical Spec Details -->
                            <div class="space-y-4 text-xs">
                                <!-- Durasi -->
                                <div
                                    class="p-3.5 bg-[#f1f5f9] dark:bg-[#0c1626] rounded-xl border border-slate-200/70 dark:border-slate-800">
                                    <span
                                        class="font-mono text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wide block mb-1">Durasi
                                        & Lokasi Kerja</span>
                                    <div
                                        class="flex items-center justify-between text-[#0f172a] dark:text-slate-200 font-semibold">
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-[#0284c7]"></span>
                                            Durasi:
                                            <strong class="font-bold text-[#0f172a] dark:text-white">3 - 6 Bulan</strong>
                                        </span>
                                        <span class="font-mono text-[#0284c7] dark:text-cyan-400 font-bold">WFO Lab
                                            Bandung</span>
                                    </div>
                                </div>

                                <!-- Syarat Umum -->
                                <div>
                                    <span
                                        class="font-mono text-[11px] font-bold text-[#0f172a] dark:text-slate-200 uppercase tracking-wide block mb-2">Syarat
                                        Umum Kualifikasi:</span>
                                    <ul class="space-y-2 text-[#1e293b] dark:text-slate-300">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-[#0284c7] dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Terbuka untuk siswa aktif SMK / MAK dari <strong
                                                    class="text-[#0f172a] dark:text-white font-bold">SEMUA jurusan</strong>
                                                dengan minat belajar teknologi hardware, IoT, atau data.</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-[#0284c7] dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Surat Rekomendasi/Pengantar Resmi dari Sekolah/Kepala Jurusan
                                                (PDF).</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-[#0284c7] dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Surat Izin Orang Tua / Wali untuk kegiatan onsite di laboratorium
                                                Bandung.</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Fasilitas -->
                                <div class="pt-3">
                                    <span
                                        class="font-mono text-[11px] font-bold text-[#0f172a] dark:text-slate-200 uppercase tracking-wide block mb-2">Fasilitas
                                        & Benefit Pembinaan:</span>
                                    <ul class="space-y-2 text-[#1e293b] dark:text-slate-300">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Bimbingan teknisi senior, modul praktikum resmi, dan akses workshop
                                                perangkat keras.</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Sertifikat Industri Resmi & Penilaian Kinerja Laporan PKL langsung ke
                                                sekolah.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Cepat Jalur SMK -->
                        <div class="mt-8 pt-4">
                            <button
                                class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl text-xs font-bold text-white bg-[#2563eb] hover:bg-[#1d4ed8] dark:bg-blue-600 dark:hover:bg-blue-500 shadow-sm transition-all cursor-pointer"
                                onclick="openModal('modal-daftar-smk')" type="button">
                                <span>Daftar Jalur SMK</span>
                                <span class="text-sm">→</span>
                            </button>
                        </div>
                    </div>

                    <!-- Kolom 2: Program Internship (D3 / D4 / S1 & Fresh Graduate) -->
                    <div
                        class="bg-white dark:bg-[#131D36] rounded-3xl p-7 sm:p-8 flex flex-col justify-between shadow-lg shadow-slate-200/50 dark:shadow-none border border-[#e2e8f0] dark:border-slate-800 hover:border-cyan-300 dark:hover:border-slate-700 transition-all duration-300 relative group">
                        <!-- Recommended Pill -->
                        <div
                            class="absolute -top-3 right-6 bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-mono text-[10px] font-bold px-3 py-1 rounded-full tracking-wider uppercase shadow-sm">
                            R&D Research Track
                        </div>

                        <div>
                            <!-- Card Header -->
                            <div class="flex items-center justify-between gap-2 mb-5">
                                <div class="flex items-center space-x-2">
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-mono font-bold uppercase tracking-wider bg-cyan-50 text-cyan-800 dark:bg-cyan-950/70 dark:text-cyan-200 border border-cyan-100 dark:border-cyan-800/60">
                                        JALUR PERGURUAN TINGGI
                                    </span>
                                    <span
                                        class="px-2 py-1 rounded-md text-[11px] font-mono font-semibold bg-slate-100 text-[#0f172a] dark:bg-slate-800 dark:text-slate-200">
                                        D3 / D4 / S1 / FRESH GRAD
                                    </span>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-xl bg-cyan-50 dark:bg-cyan-950 text-cyan-700 dark:text-cyan-400 flex items-center justify-center group-hover:scale-105 transition-transform border border-cyan-100 dark:border-cyan-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                    </svg>
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-[#0f172a] dark:text-white mb-2">
                                Program Internship (D3 / D4 / S1 & Fresh Graduate)
                            </h3>
                            <p class="text-xs text-[#475569] dark:text-slate-300 mb-6 leading-relaxed font-normal">
                                Pengembangan arsitektur embedded telemetry (STM32/ESP32), integrasi protokol MQTT/Modbus,
                                sistem SCADA hidrometeorologi, dan riset analitik data sensor.
                            </p>

                            <!-- Technical Spec Details -->
                            <div class="space-y-4 text-xs">
                                <!-- Durasi -->
                                <div
                                    class="p-3.5 bg-[#f1f5f9] dark:bg-[#0c1626] rounded-xl border border-slate-200/70 dark:border-slate-800">
                                    <span
                                        class="font-mono text-[10px] font-bold text-slate-600 dark:text-cyan-300 uppercase tracking-wide block mb-1">Durasi
                                        & Skema Kerja</span>
                                    <div
                                        class="flex items-center justify-between text-[#0f172a] dark:text-slate-200 font-semibold">
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                                            Durasi:
                                            <strong class="font-bold text-[#0f172a] dark:text-white">6 - 12 Bulan</strong>
                                        </span>
                                        <span class="font-mono text-[#0284c7] dark:text-cyan-300 font-bold">WFO Lab Litbang
                                            Bandung</span>
                                    </div>
                                </div>

                                <!-- Syarat Umum -->
                                <div>
                                    <span
                                        class="font-mono text-[11px] font-bold text-[#0f172a] dark:text-slate-200 uppercase tracking-wide block mb-2">Syarat
                                        Umum Kualifikasi:</span>
                                    <ul class="space-y-2 text-[#1e293b] dark:text-slate-300">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Mahasiswa aktif (minimal semester 5) atau Fresh Graduate dari <strong
                                                    class="text-[#0f172a] dark:text-white font-bold">SEMUA jurusan /
                                                    program studi</strong> tanpa batasan.</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Surat Pengantar Magang Kampus / Rekomendasi Program MBKM Mandiri.</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Curriculum Vitae (CV) & Portofolio Proyek atau karya kreatif yang pernah
                                                dikerjakan.</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Fasilitas -->
                                <div class="pt-3">
                                    <span
                                        class="font-mono text-[11px] font-bold text-[#0f172a] dark:text-slate-200 uppercase tracking-wide block mb-2">Fasilitas
                                        & Benefit Penugasan:</span>
                                    <ul class="space-y-2 text-[#1e293b] dark:text-slate-300">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Stipend penugasan proyek Litbang, sertifikasi industri, dan mentorship
                                                insinyur telemetri.</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>Kesempatan fast-track rekrutmen permanen sebagai R&D Associate
                                                Engineer.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Cepat Mahasiswa -->
                        <div class="mt-8 pt-4">
                            <button
                                class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl text-xs font-bold text-white bg-[#06b6d4] hover:bg-[#0891b2] transition-all shadow-sm cursor-pointer"
                                onclick="openModal('modal-daftar-mahasiswa')" type="button">
                                <span>Daftar Jalur Mahasiswa</span>
                                <span class="text-sm">→</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: Section Komparasi Jalur Program -->

        <!-- BEGIN: Section Tahapan Alur Program & Verifikasi Berkas -->
        <section class="py-16 px-4 sm:px-8 bg-white dark:bg-[#060e20] transition-colors duration-300">
            <div class="max-w-6xl mx-auto">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span
                        class="text-xs font-mono uppercase tracking-widest text-[#0284c7] dark:text-cyan-400 font-bold">FLOW
                        PROSES STANDAR</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0f172a] dark:text-white mt-1">
                        Tahapan Alur Program & Verifikasi Berkas
                    </h2>
                    <p class="text-xs sm:text-sm text-[#475569] dark:text-slate-300 mt-2 font-medium">
                        Siklus penerimaan transparan, terukur, dan terintegrasi sistem pelacakan otomatis.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Step 1 -->
                    <div
                        class="bg-white dark:bg-[#131D36] p-6 rounded-2xl shadow-sm border border-[#e2e8f0] dark:border-slate-800 hover:border-blue-300 dark:hover:border-slate-700 transition-all">
                        <div
                            class="font-mono text-2xl font-black text-[#0284c7] dark:text-cyan-400 mb-3 flex items-center justify-between">
                            <span>01</span>
                            <span
                                class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-sky-50 text-[#0369a1] dark:bg-blue-950/60 dark:text-blue-300 border border-sky-100 dark:border-blue-900">Online</span>
                        </div>
                        <h3 class="text-sm font-bold text-[#0f172a] dark:text-white mb-2">Pengajuan Formulir Online</h3>
                        <p class="text-xs text-[#475569] dark:text-slate-300 leading-relaxed font-normal">
                            Pengisian identitas, peminatan bidang (Embedded RTU / Sensor / Web SCADA), serta unggah berkas
                            PDF.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div
                        class="bg-white dark:bg-[#131D36] p-6 rounded-2xl shadow-sm border border-[#e2e8f0] dark:border-slate-800 hover:border-teal-300 dark:hover:border-slate-700 transition-all">
                        <div
                            class="font-mono text-2xl font-black text-teal-600 dark:text-teal-400 mb-3 flex items-center justify-between">
                            <span>02</span>
                            <span
                                class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300 border border-teal-100 dark:border-teal-900">SLA:
                                2-3 Hari</span>
                        </div>
                        <h3 class="text-sm font-bold text-[#0f172a] dark:text-white mb-2">Verifikasi Berkas Administrasi
                        </h3>
                        <p class="text-xs text-[#475569] dark:text-slate-300 leading-relaxed font-normal">
                            Validasi surat pengantar resmi, keselarasan silabus kampus/sekolah, dan ketersediaan kuota
                            pembimbing lab.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div
                        class="bg-white dark:bg-[#131D36] p-6 rounded-2xl shadow-sm border border-[#e2e8f0] dark:border-slate-800 hover:border-cyan-300 dark:hover:border-slate-700 transition-all">
                        <div
                            class="font-mono text-2xl font-black text-[#0284c7] dark:text-cyan-400 mb-3 flex items-center justify-between">
                            <span>03</span>
                            <span
                                class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-cyan-50 dark:bg-cyan-950/60 text-cyan-800 dark:text-cyan-300 border border-cyan-100 dark:border-cyan-900">Daring</span>
                        </div>
                        <h3 class="text-sm font-bold text-[#0f172a] dark:text-white mb-2">Asesmen Teknis & Wawancara</h3>
                        <p class="text-xs text-[#475569] dark:text-slate-300 leading-relaxed font-normal">
                            Diskusi kompetensi dasar logika mikrokontroler, hardware perakitan, dan kesiapan penugasan
                            proyek lab.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div
                        class="bg-white dark:bg-[#131D36] p-6 rounded-2xl shadow-sm border border-[#e2e8f0] dark:border-slate-800 hover:border-emerald-300 dark:hover:border-slate-700 transition-all">
                        <div
                            class="font-mono text-2xl font-black text-emerald-600 dark:text-emerald-400 mb-3 flex items-center justify-between">
                            <span>04</span>
                            <span
                                class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-900">Bandung</span>
                        </div>
                        <h3 class="text-sm font-bold text-[#0f172a] dark:text-white mb-2">Onboarding & Penugasan Lab</h3>
                        <p class="text-xs text-[#475569] dark:text-slate-300 leading-relaxed font-normal">
                            Penerbitan LOA digital resmi, induksi K3, penyerahan modul RTU, dan integrasi bersama tim
                            litbang teknis.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: Section Tahapan Alur Program -->

        <!-- MODAL 1: Pendaftaran PKL SMK/MAK -->
        <div class="fixed inset-0 z-[2000] hidden items-center justify-center p-4 sm:p-6 bg-black/75 backdrop-blur-md overflow-y-auto"
            id="modal-daftar-smk" onclick="if (event.target === this) closeModal('modal-daftar-smk');">
            <div
                class="relative w-full max-w-2xl bg-white dark:bg-[#131D36] rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-auto max-h-[90vh] flex flex-col">
                <div
                    class="flex items-center justify-between px-6 sm:px-8 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-[#0c1626] flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center font-mono font-bold">
                            SMK
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0f172a] dark:text-white leading-tight">
                                Formulir Pendaftaran PKL Jalur SMK / MAK
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Lab Instrumentasi, Perakitan RTU & Telemetri Bandung
                            </p>
                        </div>
                    </div>
                    <button
                        class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white flex items-center justify-center cursor-pointer transition font-bold"
                        onclick="closeModal('modal-daftar-smk')" type="button">
                        ✕
                    </button>
                </div>
                <div class="overflow-y-auto p-6 sm:p-8 space-y-4 text-xs">
                    <form class="space-y-4"
                        onsubmit="handleFormSubmit(event, 'modal-daftar-smk', 'Pendaftaran PKL SMK berhasil dikirim! Nomor Registrasi Pelacakan: HGT-SMK-' + Math.floor(1000 + Math.random() * 9000))">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap
                                    Siswa *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="Nama lengkap sesuai kartu pelajar" required type="text" />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">NISN / NIK
                                    Siswa *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="00xxxxxxxx / 32xxxxxxxx" required type="text" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Asal Sekolah
                                    (SMK / MAK) *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="cth: SMKN 1 Cimahi / SMKN 2 Bandung" required type="text" />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Jurusan /
                                    Kompetensi Keahlian *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="cth: TKJ, RPL, Mekatronika, Elektronika" required type="text" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kelas /
                                    Tingkat *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="cth: Kelas XI / XII" required type="text" />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">No. WhatsApp
                                    Siswa *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="08xxxxxxxxxx" required type="tel" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Durasi Magang
                                    *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="cth: 3 Bulan / 6 Bulan" required type="text" />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Bulan Mulai
                                    Magang *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="cth: Juli / Agustus 2025" required type="text" />
                            </div>
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Peminatan / Minat
                                Bidang PKL *</label>
                            <input
                                class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                placeholder="cth: Perakitan Hardware RTU & Solder Komponen, Kalibrasi Sensor" required
                                type="text" />
                        </div>
                        <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                            <label
                                class="block font-mono text-xs font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-wide">Unggah
                                Kelengkapan Dokumen (Format PDF, Maks. 2MB per file):</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">a. Kartu
                                        Pelajar / Scan KTP *</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">b. Surat
                                        Pengantar Sekolah *</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">c. CV &
                                        Portofolio Singkat</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">d.
                                        Transkrip Nilai / Rapor *</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        required type="file" />
                                </div>
                            </div>
                        </div>
                        <div
                            class="pt-4 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                            <button
                                class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition font-semibold cursor-pointer"
                                onclick="closeModal('modal-daftar-smk')" type="button">
                                Batal
                            </button>
                            <button
                                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#2563eb] hover:bg-[#1d4ed8] text-white font-bold transition shadow-sm cursor-pointer"
                                type="submit">
                                Kirim Berkas Pendaftaran SMK
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL 2: Pendaftaran Internship Mahasiswa -->
        <div class="fixed inset-0 z-[2000] hidden items-center justify-center p-4 sm:p-6 bg-black/75 backdrop-blur-md overflow-y-auto"
            id="modal-daftar-mahasiswa" onclick="if (event.target === this) closeModal('modal-daftar-mahasiswa');">
            <div
                class="relative w-full max-w-2xl bg-white dark:bg-[#131D36] rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-auto max-h-[90vh] flex flex-col">
                <div
                    class="flex items-center justify-between px-6 sm:px-8 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-[#0c1626] flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl bg-cyan-50 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-mono font-bold">
                            R&D
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0f172a] dark:text-white leading-tight">
                                Formulir Internship Mahasiswa & Fresh Graduate
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Program Litbang Embedded Telemetri, SCADA & IoT Cloud
                            </p>
                        </div>
                    </div>
                    <button
                        class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white flex items-center justify-center cursor-pointer transition font-bold"
                        onclick="closeModal('modal-daftar-mahasiswa')" type="button">
                        ✕
                    </button>
                </div>
                <div class="overflow-y-auto p-6 sm:p-8 space-y-4 text-xs">
                    <form class="space-y-4"
                        onsubmit="handleFormSubmit(event, 'modal-daftar-mahasiswa', 'Pendaftaran Magang Mahasiswa berhasil dikirim! ID Tiket Anda: HGT-RND-' + Math.floor(1000 + Math.random() * 9000))">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap
                                    Mahasiswa *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="Nama lengkap beserta gelar jika ada" required type="text" />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">NIM / NIK
                                    *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="NIM Mahasiswa / NIK KTP" required type="text" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Asal
                                    Universitas / Institut / Politeknik *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="cth: Institut Teknologi Bandung / Polban" required type="text" />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Program Studi
                                    / Jurusan *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="cth: Teknik Elektro, Informatika, Fisika" required type="text" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Semester Aktif
                                    / Status *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="cth: Semester 5 / 6 / 7 / Fresh Grad" required type="text" />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">No. WhatsApp
                                    Aktif *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="08xxxxxxxxxx" required type="tel" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Durasi Magang
                                    / Riset *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="cth: 6 Bulan / 1 Tahun" required type="text" />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Bulan Mulai
                                    Magang *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="cth: September 2025" required type="text" />
                            </div>
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Minat Riset /
                                Posisi Peminatan *</label>
                            <input
                                class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                placeholder="cth: Embedded Firmware STM32/ESP32, SCADA & Web Telemetry, IoT Cloud" required
                                type="text" />
                        </div>
                        <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                            <label
                                class="block font-mono text-xs font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-wide">Unggah
                                Dokumen Berkas (Format PDF, Maks. 2MB per file):</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">a. KTM /
                                        Scan KTP *</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">b. Surat
                                        Pengantar Kampus / MBKM *</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">c.
                                        Curriculum Vitae & Portofolio *</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">d.
                                        Transkrip Nilai Akademik *</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        required type="file" />
                                </div>
                            </div>
                        </div>
                        <div
                            class="pt-4 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                            <button
                                class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition font-semibold cursor-pointer"
                                onclick="closeModal('modal-daftar-mahasiswa')" type="button">
                                Batal
                            </button>
                            <button
                                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#06b6d4] hover:bg-[#0891b2] text-white font-bold transition shadow-sm cursor-pointer"
                                type="submit">
                                Kirim Berkas Pendaftaran Mahasiswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL 3: Pelacakan Status Berkas & Kelulusan -->
        <div class="fixed inset-0 z-[2000] hidden items-center justify-center p-4 sm:p-6 bg-black/75 backdrop-blur-md overflow-y-auto"
            id="modal-lacak-status" onclick="if (event.target === this) closeModal('modal-lacak-status');">
            <div
                class="relative w-full max-w-xl bg-white dark:bg-[#131D36] rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-auto max-h-[90vh] flex flex-col">
                <div
                    class="flex items-center justify-between px-6 sm:px-8 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-[#0c1626] flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl bg-cyan-50 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-base font-bold">
                            🔍
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0f172a] dark:text-white leading-tight">
                                Pelacakan Status Berkas & LOA
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Cek progres seleksi penerimaan & unduh Letter of Acceptance
                            </p>
                        </div>
                    </div>
                    <button
                        class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white flex items-center justify-center cursor-pointer transition font-bold"
                        onclick="closeModal('modal-lacak-status')" type="button">
                        ✕
                    </button>
                </div>
                <div class="overflow-y-auto p-6 sm:p-8 space-y-5 text-xs">
                    <!-- Segmented Tab Switcher -->
                    <div
                        class="grid grid-cols-2 gap-1 p-1 bg-slate-100 dark:bg-[#0c1626] rounded-xl border border-slate-200/80 dark:border-slate-800">
                        <button
                            class="py-2 px-3 rounded-lg font-bold text-xs transition-all bg-white dark:bg-[#131D36] text-[#0284c7] dark:text-cyan-400 shadow-sm cursor-pointer"
                            id="tab-lacak-id" onclick="switchLacakTab('id')" type="button">
                            Berdasarkan ID Registrasi
                        </button>
                        <button
                            class="py-2 px-3 rounded-lg font-bold text-xs transition-all text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer"
                            id="tab-lacak-email" onclick="switchLacakTab('email')" type="button">
                            Berdasarkan Email
                        </button>
                    </div>

                    <!-- Form Query -->
                    <form class="space-y-4" onsubmit="searchStatus(event)">
                        <div class="space-y-3" id="form-lacak-id-group">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">ID Permintaan
                                    / Registrasi *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs font-mono focus:ring-2 focus:ring-[#0ea5e9]"
                                    id="lookup-input-id" placeholder="cth: HGT-2025-0482 atau HGT-SMK-2025"
                                    type="text" value="HGT-2025-0482" required />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Verifikasi
                                    Nama Depan Pemohon *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-[#0ea5e9]"
                                    id="lookup-input-name" placeholder="cth: Ahmad" type="text" value="Ahmad"
                                    required />
                            </div>
                        </div>

                        <div class="space-y-3 hidden" id="form-lacak-email-group">
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email
                                    Terdaftar *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-[#0ea5e9]"
                                    id="lookup-input-email" placeholder="cth: ahmad.farhan@itb.ac.id" type="email" />
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Verifikasi 4
                                    Digit Terakhir No. HP *</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs font-mono focus:ring-2 focus:ring-[#0ea5e9]"
                                    id="lookup-input-phone" maxlength="4" placeholder="cth: 0299" type="text" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-1 gap-2">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                * Coba sampel:
                                <code class="text-cyan-600 dark:text-cyan-400 font-mono font-bold">HGT-2025-0482</code>
                            </p>
                            <button
                                class="px-5 py-2.5 rounded-xl bg-[#0ea5e9] hover:bg-[#0284c7] text-white font-bold text-xs transition cursor-pointer shadow-sm"
                                type="submit">
                                Cek Status Pengajuan
                            </button>
                        </div>
                    </form>

                    <!-- Hasil Pelacakan Timeline -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 dark:bg-[#0c1626] border border-slate-200/80 dark:border-slate-800 space-y-4 text-xs"
                        id="modal-timeline-result">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-200/60 dark:border-slate-800 gap-2">
                            <div>
                                <div class="font-mono font-bold text-slate-900 dark:text-white text-sm"
                                    id="result-ticket-id">
                                    HGT-2025-0482
                                </div>
                                <div class="text-slate-500 dark:text-slate-400 text-[11px]" id="result-applicant-info">
                                    Ahmad Farhan — ITB (Track SCADA Telemetri & Modbus)
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-md bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 font-mono font-bold text-[10px] w-fit">
                                DITERIMA (LETTER OF ACCEPTANCE TERBIT)
                            </span>
                        </div>
                        <div
                            class="space-y-3.5 relative pl-6 border-l-2 border-emerald-500 dark:border-emerald-400 ml-2 py-1">
                            <div class="relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>
                                <div class="font-bold text-slate-900 dark:text-white">1. Pengajuan Formulir & Berkas
                                    Digital</div>
                                <div class="text-slate-500 text-[11px]">Terkirim & terverifikasi lengkap pada sistem
                                    penerimaan</div>
                            </div>
                            <div class="relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>
                                <div class="font-bold text-slate-900 dark:text-white">2. Seleksi Administrasi & Surat
                                    Rekomendasi</div>
                                <div class="text-slate-500 text-[11px]">Selesai — Sesuai kuota pembimbing laboratorium R&D
                                    Bandung</div>
                            </div>
                            <div class="relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>
                                <div class="font-bold text-slate-900 dark:text-white">3. Asesmen Teknis & Wawancara Online
                                </div>
                                <div class="text-slate-500 text-[11px]">Hasil evaluasi kompetensi mikrokontroler & IoT:
                                    Skor 94/100</div>
                            </div>
                            <div class="relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-cyan-500 text-white flex items-center justify-center text-[9px] animate-pulse font-bold">●</span>
                                <div class="font-bold text-cyan-600 dark:text-cyan-400">4. Onboarding Lab R&D Bandung &
                                    Penerbitan LOA Digital</div>
                                <div class="text-slate-500 text-[11px]">Dokumen penugasan resmi aktif untuk Batch Ganjil
                                    2025/2026</div>
                            </div>
                        </div>
                        <div
                            class="pt-3 border-t border-slate-200/60 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <a class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0284c7] dark:text-cyan-400 hover:underline"
                                href="#"
                                onclick="alert('Mengunduh dokumen resmi Letter of Acceptance (LOA_Higertech_2025.pdf)...'); return false;">
                                <span>📄 Unduh LOA Digital (PDF, 420 KB)</span>
                            </a>
                            <div class="flex items-center gap-2">
                                <a class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 font-bold hover:underline text-[11px]"
                                    href="https://wa.me/628112332182" rel="noopener noreferrer" target="_blank">
                                    Hubungi WhatsApp Litbang
                                </a>
                                <button
                                    class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800 cursor-pointer"
                                    onclick="closeModal('modal-lacak-status')" type="button">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('landing.partials.footer')
@endsection

@push('scripts')
    <script>
        function switchLacakTab(tab) {
            const btnId = document.getElementById("tab-lacak-id");
            const btnEmail = document.getElementById("tab-lacak-email");
            const groupId = document.getElementById("form-lacak-id-group");
            const groupEmail = document.getElementById("form-lacak-email-group");
            if (!btnId || !btnEmail || !groupId || !groupEmail) return;

            if (tab === "id") {
                btnId.className =
                    "py-2 px-3 rounded-lg font-bold text-xs transition-all bg-white dark:bg-[#131D36] text-[#0284c7] dark:text-cyan-400 shadow-sm cursor-pointer";
                btnEmail.className =
                    "py-2 px-3 rounded-lg font-bold text-xs transition-all text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer";
                groupId.classList.remove("hidden");
                groupEmail.classList.add("hidden");
            } else {
                btnEmail.className =
                    "py-2 px-3 rounded-lg font-bold text-xs transition-all bg-white dark:bg-[#131D36] text-[#0284c7] dark:text-cyan-400 shadow-sm cursor-pointer";
                btnId.className =
                    "py-2 px-3 rounded-lg font-bold text-xs transition-all text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer";
                groupEmail.classList.remove("hidden");
                groupId.classList.add("hidden");
            }
        }

        function openModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove("hidden");
                el.classList.add("flex");
                document.body.style.overflow = "hidden";
            }
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add("hidden");
                el.classList.remove("flex");
                document.body.style.overflow = "";
            }
        }

        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                closeModal("modal-daftar-smk");
                closeModal("modal-daftar-mahasiswa");
                closeModal("modal-lacak-status");
            }
        });

        function handleFormSubmit(e, modalId, message) {
            e.preventDefault();
            alert(message);
            closeModal(modalId);
        }

        function searchStatus(e) {
            e.preventDefault();
            const inputId = document.getElementById("lookup-input-id");
            const query = inputId ? inputId.value : "";
            const result = document.getElementById("modal-timeline-result");
            if (result) {
                result.classList.remove("hidden");
                alert("Memperbarui data pelacakan untuk: " + query);
            }
        }
    </script>
@endpush
