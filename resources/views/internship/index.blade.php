@extends('layouts.app')

@section('title', __('internship.meta_title'))
@section('description', __('internship.meta_description'))

@push('head')
    <link rel="preload" href="{{ asset('images/brand/higertech-logo.webp') }}" as="image" type="image/webp"
        fetchpriority="high">
@endpush

@section('content')
    <main class="flex-1" data-internship-page>
        <!-- BEGIN: Hero Section -->
        <section
            class="relative pt-16 pb-20 sm:pt-20 sm:pb-24 px-4 sm:px-8 bg-gradient-to-b from-blue-50/40 via-slate-50 to-white dark:from-[#080d1a] dark:via-[#0B1120] dark:to-[#0B1120] map-grid-bg transition-colors duration-300 overflow-hidden">
            <div class="max-w-5xl mx-auto text-center relative z-10">
                <!-- Top Technical Badge -->
                <div
                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-mono font-bold tracking-wide bg-[#e0f2fe] text-[#0369a1] dark:bg-blue-950/70 dark:text-cyan-300 mb-6 shadow-xs border border-sky-200 dark:border-blue-800">
                    <span class="w-2 h-2 rounded-full bg-[#0284c7] dark:bg-cyan-400 animate-pulse"></span>
                    <span>{{ __('internship.hero_badge') }}</span>
                </div>

                <!-- Headline -->
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl lg:text-[54px] font-extrabold tracking-tight text-[#0f172a] dark:text-white mb-5 leading-tight">
                    {{ __('internship.hero_title_prefix') }}
                    <span
                        class="bg-gradient-to-r from-[#0284c7] to-[#0ea5e9] dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">{{ __('internship.hero_title_highlight') }}</span>
                </h1>

                <!-- Subheadline -->
                <p
                    class="text-base sm:text-lg text-[#334155] dark:text-slate-300 max-w-3xl mx-auto leading-relaxed font-normal mb-8">
                    {{ __('internship.hero_desc') }}
                </p>

                <!-- Action Bar -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-md mx-auto">
                    <a class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold text-white bg-[#0ea5e9] hover:bg-[#0284c7] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 shadow-md transition-all duration-150 cursor-pointer"
                        href="#komparasi-jalur"
                        onclick="event.preventDefault(); document.getElementById('komparasi-jalur').scrollIntoView({ behavior: 'smooth', block: 'start' });">
                        <span>{{ __('internship.hero_cta_apply') }}</span>
                        <span class="text-base leading-none">→</span>
                    </a>
                    <button
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-semibold text-[#0f172a] dark:text-slate-100 bg-white dark:bg-slate-800/90 hover:bg-slate-50 dark:hover:bg-slate-700 border border-[#cbd5e1] dark:border-slate-700 shadow-sm transition-all duration-150 font-mono cursor-pointer"
                        onclick="openModal('modal-lacak-status')" type="button">
                        <span>{{ __('internship.hero_cta_track') }}</span>
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" stroke-width="2"></circle>
                            <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>

                <!-- Technical Metatags -->
                <div
                    class="mt-8 flex flex-wrap items-center justify-center gap-3 text-xs font-mono text-[#1e293b] dark:text-slate-300">
                    <span
                        class="inline-flex items-center gap-1.5 bg-white dark:bg-slate-800/80 px-3.5 py-1.5 rounded-lg shadow-sm border border-[#e2e8f0] dark:border-slate-700/80 font-medium">
                        <svg class="w-3.5 h-3.5 text-[#0284c7] dark:text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                fill-rule="evenodd"></path>
                        </svg>
                        {{ __('internship.hero_meta_batch') }}
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 bg-white dark:bg-slate-800/80 px-3.5 py-1.5 rounded-lg shadow-sm border border-[#e2e8f0] dark:border-slate-700/80 font-medium">
                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path clip-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                fill-rule="evenodd"></path>
                        </svg>
                        {{ __('internship.hero_meta_location') }}
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 bg-white dark:bg-slate-800/80 px-3.5 py-1.5 rounded-lg shadow-sm border border-[#e2e8f0] dark:border-slate-700/80 font-medium">
                        <svg class="w-3.5 h-3.5 text-[#0284c7] dark:text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path clip-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                fill-rule="evenodd"></path>
                        </svg>
                        {{ __('internship.hero_meta_cert') }}
                    </span>
                </div>
            </div>
        </section>
        <!-- END: Hero Section -->

        <!-- BEGIN: Section Komparasi Jalur Program & Syarat Umum -->
        <section class="py-16 px-4 sm:px-8 bg-slate-100/50 dark:bg-[#07152b] transition-colors duration-300"
            id="komparasi-jalur">
            <div class="max-w-6xl mx-auto">
                @if (!$internshipEnabled)
                    <div
                        class="mb-10 p-5 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-900 dark:text-amber-200 flex items-start gap-3.5 shadow-sm scroll-reveal">
                        <div
                            class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="text-xs">
                            <h4 class="font-bold text-sm text-amber-800 dark:text-amber-300 mb-1">Pendaftaran Magang Saat
                                Ini Sedang Ditutup</h4>
                            <p class="leading-relaxed text-slate-700 dark:text-slate-300 mb-2">
                                {{ $closedMessage ?? 'Mohon maaf, pendaftaran program magang periode saat ini sedang ditutup. Nantikan pengumuman batch berikutnya atau hubungi kontak kami untuk informasi lebih lanjut.' }}
                            </p>
                            <div class="flex items-center gap-2 font-mono text-[11px]">
                                <span class="text-slate-500 dark:text-slate-400">Sudah pernah mendaftar sebelumnya?</span>
                                <button type="button" onclick="openModal('modal-lacak-status')"
                                    class="text-blue-600 dark:text-cyan-400 font-bold hover:underline cursor-pointer">
                                    Lacak Status Pengajuan & Unduh SK Penerimaan →
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="text-center max-w-3xl mx-auto mb-12 scroll-reveal">
                    <span
                        class="text-xs font-mono uppercase tracking-widest text-[#0284c7] dark:text-cyan-400 font-bold">{{ __('internship.comp_badge') }}</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0f172a] dark:text-white mt-1">
                        {{ __('internship.comp_title') }}
                    </h2>
                    <p class="text-sm text-[#475569] dark:text-slate-300 mt-2 font-medium">
                        {{ __('internship.comp_subtitle') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kolom 1: Praktik Kerja Lapangan (PKL SMK/MAK) -->
                    <div
                        class="scroll-reveal scroll-reveal-scale scroll-reveal-delay-1 bg-white dark:bg-[#131D36] rounded-3xl p-7 sm:p-8 flex flex-col justify-between shadow-lg shadow-slate-200/50 dark:shadow-none border border-[#e2e8f0] dark:border-slate-800 hover:border-blue-400 dark:hover:border-cyan-500/50 hover:-translate-y-1.5 transition-all duration-300 relative group">
                        <div>
                            <!-- Card Header -->
                            <div class="flex items-center justify-between gap-2 mb-5">
                                <div class="flex items-center space-x-2">
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-mono font-bold uppercase tracking-wider bg-blue-50 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200 border border-blue-100 dark:border-blue-800/60">
                                        {{ __('internship.smk_track') }}
                                    </span>
                                    <span
                                        class="px-2 py-1 rounded-md text-[11px] font-mono font-semibold bg-slate-100 text-[#0f172a] dark:bg-slate-800 dark:text-slate-200">
                                        {{ __('internship.smk_level') }}
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
                                {{ __('internship.smk_title') }}
                            </h3>
                            <p class="text-xs text-[#475569] dark:text-slate-300 mb-6 leading-relaxed font-normal">
                                {{ __('internship.smk_desc') }}
                            </p>

                            <!-- Spec Details -->
                            <div class="space-y-4 text-xs">
                                <!-- Durasi -->
                                <div
                                    class="p-3.5 bg-[#f1f5f9] dark:bg-[#0c1626] rounded-xl border border-slate-200/70 dark:border-slate-800">
                                    <span
                                        class="font-mono text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wide block mb-1">{{ __('internship.smk_duration_label') }}</span>
                                    <div
                                        class="flex items-center justify-between text-[#0f172a] dark:text-slate-200 font-semibold">
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-[#0284c7]"></span>
                                            <span>{{ __('internship.smk_duration_label') }}:</span>
                                            <strong
                                                class="font-bold text-[#0f172a] dark:text-white">{{ __('internship.smk_duration_val') }}</strong>
                                        </span>
                                        <span
                                            class="font-mono text-[#0284c7] dark:text-cyan-400 font-bold">{{ __('internship.smk_location_val') }}</span>
                                    </div>
                                </div>

                                <!-- Syarat Umum -->
                                <div>
                                    <span
                                        class="font-mono text-[11px] font-bold text-[#0f172a] dark:text-slate-200 uppercase tracking-wide block mb-2">{{ __('internship.smk_req_title') }}</span>
                                    <ul class="space-y-2 text-[#1e293b] dark:text-slate-300">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-[#0284c7] dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.smk_req_1') }}</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-[#0284c7] dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.smk_req_2') }}</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-[#0284c7] dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.smk_req_3') }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Fasilitas -->
                                <div class="pt-3">
                                    <span
                                        class="font-mono text-[11px] font-bold text-[#0f172a] dark:text-slate-200 uppercase tracking-wide block mb-2">{{ __('internship.smk_fac_title') }}</span>
                                    <ul class="space-y-2 text-[#1e293b] dark:text-slate-300">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.smk_fac_1') }}</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.smk_fac_2') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Cepat Jalur SMK -->
                        <div class="mt-8 pt-4">
                            @if ($internshipEnabled)
                                <button
                                    class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl text-xs font-bold text-white bg-[#2563eb] hover:bg-[#1d4ed8] dark:bg-blue-600 dark:hover:bg-blue-500 shadow-sm transition-all cursor-pointer"
                                    onclick="openModal('modal-daftar-smk')" type="button">
                                    <span>{{ __('internship.smk_btn') }}</span>
                                    <span class="text-sm">→</span>
                                </button>
                            @else
                                <button
                                    class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl text-xs font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 dark:text-slate-500 border border-slate-200 dark:border-slate-700 cursor-not-allowed"
                                    type="button" disabled>
                                    <span>Pendaftaran SMK Ditutup</span>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Kolom 2: Program Internship (D3 / D4 / S1 & Fresh Graduate) -->
                    <div
                        class="scroll-reveal scroll-reveal-scale scroll-reveal-delay-2 bg-white dark:bg-[#131D36] rounded-3xl p-7 sm:p-8 flex flex-col justify-between shadow-lg shadow-slate-200/50 dark:shadow-none border border-[#e2e8f0] dark:border-slate-800 hover:border-cyan-400 dark:hover:border-cyan-500/50 hover:-translate-y-1.5 transition-all duration-300 relative group">
                        <!-- Recommended Pill -->
                        <div
                            class="absolute -top-3 right-6 bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-mono text-[10px] font-bold px-3 py-1 rounded-full tracking-wider uppercase shadow-sm">
                            {{ __('internship.he_badge') }}
                        </div>

                        <div>
                            <!-- Card Header -->
                            <div class="flex items-center justify-between gap-2 mb-5">
                                <div class="flex items-center space-x-2">
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-mono font-bold uppercase tracking-wider bg-cyan-50 text-cyan-800 dark:bg-cyan-950/70 dark:text-cyan-200 border border-cyan-100 dark:border-cyan-800/60">
                                        {{ __('internship.he_track') }}
                                    </span>
                                    <span
                                        class="px-2 py-1 rounded-md text-[11px] font-mono font-semibold bg-slate-100 text-[#0f172a] dark:bg-slate-800 dark:text-slate-200">
                                        {{ __('internship.he_level') }}
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
                                {{ __('internship.he_title') }}
                            </h3>
                            <p class="text-xs text-[#475569] dark:text-slate-300 mb-6 leading-relaxed font-normal">
                                {{ __('internship.he_desc') }}
                            </p>

                            <!-- Spec Details -->
                            <div class="space-y-4 text-xs">
                                <!-- Durasi -->
                                <div
                                    class="p-3.5 bg-[#f1f5f9] dark:bg-[#0c1626] rounded-xl border border-slate-200/70 dark:border-slate-800">
                                    <span
                                        class="font-mono text-[10px] font-bold text-slate-600 dark:text-cyan-300 uppercase tracking-wide block mb-1">{{ __('internship.he_duration_label') }}</span>
                                    <div
                                        class="flex items-center justify-between text-[#0f172a] dark:text-slate-200 font-semibold">
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                                            <span>{{ __('internship.he_duration_label') }}:</span>
                                            <strong
                                                class="font-bold text-[#0f172a] dark:text-white">{{ __('internship.he_duration_val') }}</strong>
                                        </span>
                                        <span
                                            class="font-mono text-[#0284c7] dark:text-cyan-300 font-bold">{{ __('internship.he_location_val') }}</span>
                                    </div>
                                </div>

                                <!-- Syarat Umum -->
                                <div>
                                    <span
                                        class="font-mono text-[11px] font-bold text-[#0f172a] dark:text-slate-200 uppercase tracking-wide block mb-2">{{ __('internship.he_req_title') }}</span>
                                    <ul class="space-y-2 text-[#1e293b] dark:text-slate-300">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.he_req_1') }}</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.he_req_2') }}</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.he_req_3') }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Fasilitas -->
                                <div class="pt-3">
                                    <span
                                        class="font-mono text-[11px] font-bold text-[#0f172a] dark:text-slate-200 uppercase tracking-wide block mb-2">{{ __('internship.he_fac_title') }}</span>
                                    <ul class="space-y-2 text-[#1e293b] dark:text-slate-300">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.he_fac_1') }}</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <span>{{ __('internship.he_fac_2') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Cepat Mahasiswa -->
                        <div class="mt-8 pt-4">
                            @if ($internshipEnabled)
                                <button
                                    class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl text-xs font-bold text-white bg-[#06b6d4] hover:bg-[#0891b2] transition-all shadow-sm cursor-pointer"
                                    onclick="openModal('modal-daftar-mahasiswa')" type="button">
                                    <span>{{ __('internship.he_btn') }}</span>
                                    <span class="text-sm">→</span>
                                </button>
                            @else
                                <button
                                    class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl text-xs font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 dark:text-slate-500 border border-slate-200 dark:border-slate-700 cursor-not-allowed"
                                    type="button" disabled>
                                    <span>Pendaftaran Mahasiswa Ditutup</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: Section Komparasi Jalur Program -->

        <!-- BEGIN: Section Tahapan Alur Program & Verifikasi Berkas -->
        <section class="py-16 px-4 sm:px-8 bg-white dark:bg-[#060e20] transition-colors duration-300">
            <div class="max-w-6xl mx-auto">
                <div class="text-center max-w-2xl mx-auto mb-12 scroll-reveal">
                    <span
                        class="text-xs font-mono uppercase tracking-widest text-[#0284c7] dark:text-cyan-400 font-bold">{{ __('internship.steps_badge') }}</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0f172a] dark:text-white mt-1">
                        {{ __('internship.steps_title') }}
                    </h2>
                    <p class="text-xs sm:text-sm text-[#475569] dark:text-slate-300 mt-2 font-medium">
                        {{ __('internship.steps_subtitle') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Step 1 -->
                    <div
                        class="scroll-reveal scroll-reveal-scale scroll-reveal-delay-1 bg-white dark:bg-[#131D36] p-6 rounded-2xl shadow-sm border border-[#e2e8f0] dark:border-slate-800 hover:border-blue-400 dark:hover:border-cyan-500/50 hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div
                            class="font-mono text-2xl font-black text-[#0284c7] dark:text-cyan-400 mb-3 flex items-center justify-between">
                            <span>01</span>
                            <span
                                class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-sky-50 text-[#0369a1] dark:bg-blue-950/60 dark:text-blue-300 border border-sky-100 dark:border-blue-900">{{ __('internship.step1_tag') }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-[#0f172a] dark:text-white mb-2">
                            {{ __('internship.step1_title') }}</h3>
                        <p class="text-xs text-[#475569] dark:text-slate-300 leading-relaxed font-normal">
                            {{ __('internship.step1_desc') }}
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div
                        class="scroll-reveal scroll-reveal-scale scroll-reveal-delay-2 bg-white dark:bg-[#131D36] p-6 rounded-2xl shadow-sm border border-[#e2e8f0] dark:border-slate-800 hover:border-teal-400 dark:hover:border-teal-500/50 hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div
                            class="font-mono text-2xl font-black text-teal-600 dark:text-teal-400 mb-3 flex items-center justify-between">
                            <span>02</span>
                            <span
                                class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300 border border-teal-100 dark:border-teal-900">{{ __('internship.step2_tag') }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-[#0f172a] dark:text-white mb-2">
                            {{ __('internship.step2_title') }}</h3>
                        <p class="text-xs text-[#475569] dark:text-slate-300 leading-relaxed font-normal">
                            {{ __('internship.step2_desc') }}
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div
                        class="scroll-reveal scroll-reveal-scale scroll-reveal-delay-3 bg-white dark:bg-[#131D36] p-6 rounded-2xl shadow-sm border border-[#e2e8f0] dark:border-slate-800 hover:border-cyan-400 dark:hover:border-cyan-500/50 hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div
                            class="font-mono text-2xl font-black text-[#0284c7] dark:text-cyan-400 mb-3 flex items-center justify-between">
                            <span>03</span>
                            <span
                                class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-cyan-50 dark:bg-cyan-950/60 text-cyan-800 dark:text-cyan-300 border border-cyan-100 dark:border-cyan-900">{{ __('internship.step3_tag') }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-[#0f172a] dark:text-white mb-2">
                            {{ __('internship.step3_title') }}</h3>
                        <p class="text-xs text-[#475569] dark:text-slate-300 leading-relaxed font-normal">
                            {{ __('internship.step3_desc') }}
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div
                        class="scroll-reveal scroll-reveal-scale scroll-reveal-delay-4 bg-white dark:bg-[#131D36] p-6 rounded-2xl shadow-sm border border-[#e2e8f0] dark:border-slate-800 hover:border-emerald-400 dark:hover:border-emerald-500/50 hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div
                            class="font-mono text-2xl font-black text-emerald-600 dark:text-emerald-400 mb-3 flex items-center justify-between">
                            <span>04</span>
                            <span
                                class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-900">{{ __('internship.step4_tag') }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-[#0f172a] dark:text-white mb-2">
                            {{ __('internship.step4_title') }}</h3>
                        <p class="text-xs text-[#475569] dark:text-slate-300 leading-relaxed font-normal">
                            {{ __('internship.step4_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: Section Tahapan Alur Program -->

        @php
            $indonesianMonths = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];
            $startMonths = [];
            $curr = \Carbon\Carbon::now();
            for ($i = 0; $i < 12; $i++) {
                $itemDate = $curr->copy()->addMonths($i);
                $mNum = (int) $itemDate->format('n');
                $mYear = $itemDate->format('Y');
                $mName = ($indonesianMonths[$mNum] ?? $itemDate->format('F')) . ' ' . $mYear;
                if ($i === 0) {
                    $mName .= ' (Bulan Ini / Terdekat)';
                } elseif ($i === 1) {
                    $mName .= ' (Bulan Depan)';
                }
                $startMonths[] = [
                    'val' => $itemDate->format('Y-m'),
                    'label' => $mName,
                ];
            }
        @endphp

        <!-- MODAL 1: Pendaftaran PKL SMK/MAK -->
        <div class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-md overflow-y-auto"
            id="modal-daftar-smk" onclick="if (event.target === this) closeModal('modal-daftar-smk');">
            <div
                class="relative w-full max-w-2xl bg-white dark:bg-[#131D36] rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-auto max-h-[90vh] flex flex-col">
                <div
                    class="flex items-center justify-between px-6 sm:px-8 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-[#0c1626] flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center font-mono font-bold text-sm shadow-xs border border-blue-200 dark:border-blue-900">
                            SMK
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0f172a] dark:text-white leading-tight">
                                {{ __('internship.form_smk_title') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ __('internship.form_smk_subtitle') }}
                            </p>
                        </div>
                    </div>
                    <button
                        class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white flex items-center justify-center cursor-pointer transition"
                        onclick="closeModal('modal-daftar-smk')" type="button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="overflow-y-auto p-6 sm:p-8 space-y-4 text-xs">
                    <!-- Form Alert Box -->
                    <div id="alert-form-smk" class="hidden p-3.5 rounded-xl border text-xs leading-relaxed"></div>

                    <form id="form-smk" class="space-y-4" method="POST" action="{{ route('internship.apply') }}"
                        enctype="multipart/form-data" novalidate onsubmit="submitInternshipForm(event, 'smk')">
                        @csrf
                        <input type="hidden" name="type" value="vocational">

                        <!-- Tipe Pengajuan: Individu vs Kelompok / Tim -->
                        <div
                            class="p-3 bg-slate-50 dark:bg-[#0c1626] rounded-2xl border border-slate-200 dark:border-slate-700/80">
                            <label class="block font-bold text-slate-800 dark:text-slate-200 mb-2">
                                {{ __('internship.form_app_type') }}
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <label
                                    class="app-type-label-smk flex items-center justify-center gap-2 p-2.5 rounded-xl border-2 cursor-pointer transition text-xs font-semibold bg-blue-50/80 border-blue-500 text-blue-800 dark:bg-blue-950/60 dark:border-cyan-500 dark:text-cyan-300"
                                    data-mode="individual">
                                    <input type="radio" name="application_type" value="individual" checked
                                        class="hidden app-type-radio"
                                        onchange="toggleApplicationType('smk', 'individual')">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-cyan-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ __('internship.form_type_individual_smk') }}</span>
                                </label>
                                <label
                                    class="app-type-label-smk flex items-center justify-center gap-2 p-2.5 rounded-xl border-2 cursor-pointer transition text-xs font-semibold bg-white dark:bg-[#131D36] border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300"
                                    data-mode="group">
                                    <input type="radio" name="application_type" value="group"
                                        class="hidden app-type-radio" onchange="toggleApplicationType('smk', 'group')">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-cyan-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>{{ __('internship.form_type_group_smk') }}</span>
                                </label>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-2 font-normal">
                                {!! __('internship.form_team_note') !!}
                            </p>
                        </div>

                        <!-- Nama Lengkap & NISN/NIK -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_name_student') }}</label>
                                <input name="name"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_name_student_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_nisn') }}</label>
                                <input name="identity_number"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_nisn_ph') }}" required type="text" />
                            </div>
                        </div>

                        <!-- Email & WhatsApp -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_email') }}</label>
                                <input name="email"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_email_ph') }}" type="email" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_phone') }}</label>
                                <input name="phone"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_phone_ph') }}" required type="tel" />
                            </div>
                        </div>

                        <!-- Asal SMK (Searchable Dropdown + Lainnya) -->
                        <div>
                            <label
                                class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_school') }}</label>
                            <input type="hidden" name="institution" id="institution-smk" required>

                            <div class="searchable-combobox relative" data-target-input="institution-smk"
                                data-other-group="institution-other-group-smk" data-other-input="institution-other-smk">

                                <button type="button"
                                    class="combobox-trigger w-full flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb] text-left text-xs transition cursor-pointer">
                                    <span
                                        class="combobox-label truncate text-slate-500 dark:text-slate-400">{{ __('internship.combobox_school_ph') }}</span>
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 combobox-arrow flex-shrink-0 ml-2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div
                                    class="combobox-panel hidden absolute left-0 right-0 top-full mt-1.5 z-50 rounded-2xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-700 shadow-2xl p-2.5">
                                    <div class="relative mb-2">
                                        <input type="text"
                                            class="combobox-search w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-[#0c1626] text-slate-900 dark:text-white pl-8 pr-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#2563eb]"
                                            placeholder="{{ __('internship.combobox_school_search_ph') }}">
                                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <ul class="combobox-list max-h-52 overflow-y-auto space-y-1 text-xs pr-1">
                                        @php
                                            $smkSchools = [
                                                'SMKN 1 Cimahi (Teknologi & Industri)',
                                                'SMKN 2 Bandung',
                                                'SMKN 4 Bandung (Teknologi Informasi & Kelistrikan)',
                                                'SMKN 1 Katapang Kab. Bandung',
                                                'SMKN 1 Soreang',
                                                'SMKN 3 Bandung',
                                                'SMKN 6 Bandung',
                                                'SMKN 7 Bandung',
                                                'SMKN 8 Bandung',
                                                'SMKN 11 Bandung',
                                                'SMK Telkom Bandung',
                                                'SMK Medikacom Bandung',
                                                'SMK ICB Cinta Teknika Bandung',
                                                'SMK PU Negeri Bandung',
                                                'SMKN 1 Padalarang',
                                                'SMKN 2 Cimahi',
                                                'SMKN 3 Cimahi',
                                                'SMKN 1 Cihampelas',
                                                'SMK Negeri 1 Jakarta',
                                                'SMK Negeri 26 Jakarta',
                                                'SMKN 1 Surabaya',
                                                'SMKN 2 Yogyakarta',
                                                'SMKN 2 Surakarta',
                                                'SMKN 2 Semarang',
                                            ];
                                        @endphp
                                        @foreach ($smkSchools as $school)
                                            <li class="combobox-option px-3 py-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/40 cursor-pointer text-slate-800 dark:text-slate-200 transition"
                                                data-value="{{ $school }}">
                                                {{ $school }}
                                            </li>
                                        @endforeach
                                        <li class="combobox-option combobox-other px-3 py-2 rounded-lg bg-blue-50/70 dark:bg-blue-950/50 text-blue-600 dark:text-cyan-400 font-semibold hover:bg-blue-100 dark:hover:bg-blue-900/60 cursor-pointer border border-blue-200/60 dark:border-blue-800/60 transition mt-1"
                                            data-value="Lainnya">
                                            {{ __('internship.combobox_other_school') }}
                                        </li>
                                    </ul>
                                    <div
                                        class="combobox-notfound hidden mt-1.5 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-300 text-xs cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="truncate">{{ __('internship.combobox_use_query') }} "<strong
                                                    class="combobox-query-display font-semibold text-slate-900 dark:text-white"></strong>"</span>
                                            <span
                                                class="text-[11px] font-semibold text-blue-600 dark:text-cyan-400 flex items-center gap-1 flex-shrink-0">
                                                {{ __('internship.combobox_select_manual') }} &rarr;
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Input Manual Jika Memilih SMK 'Lainnya' -->
                            <div id="institution-other-group-smk"
                                class="hidden mt-2 p-3 rounded-xl bg-blue-50/50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 animate-in fade-in duration-200">
                                <label for="institution-other-smk"
                                    class="block font-semibold text-blue-900 dark:text-blue-300 mb-1 text-[11px]">
                                    {{ __('internship.manual_school_label') }}
                                </label>
                                <input type="text" name="institution_other" id="institution-other-smk"
                                    class="w-full rounded-lg border border-blue-300 dark:border-blue-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3 py-2 text-xs focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.manual_school_ph') }}">
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 block">
                                    {{ __('internship.manual_school_help') }}
                                </span>
                            </div>
                        </div>

                        <!-- Tingkat Kelas (Custom Dropdown) -->
                        <div>
                            <label
                                class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_class') }}</label>
                            <input type="hidden" name="grade_level" id="grade-level-smk" required>

                            <div class="searchable-combobox relative" data-target-input="grade-level-smk">
                                <button type="button"
                                    class="combobox-trigger w-full flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb] text-left text-xs transition cursor-pointer">
                                    <span
                                        class="combobox-label truncate text-slate-500 dark:text-slate-400">{{ __('internship.field_level_smk_select_ph') }}</span>
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 combobox-arrow flex-shrink-0 ml-2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div
                                    class="combobox-panel hidden absolute left-0 right-0 top-full mt-1.5 z-50 rounded-2xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-700 shadow-2xl p-2">
                                    <ul class="combobox-list max-h-52 overflow-y-auto space-y-1 text-xs pr-1">
                                        @php
                                            $smkClasses = [
                                                'Kelas XI (Semester 3 / 4)',
                                                'Kelas XII (Semester 5 / 6)',
                                                'Kelas XIII (Program SMK 4 Tahun)',
                                                'Alumni / Baru Lulus',
                                            ];
                                        @endphp
                                        @foreach ($smkClasses as $classOpt)
                                            <li class="combobox-option px-3 py-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/40 cursor-pointer text-slate-800 dark:text-slate-200 transition font-medium"
                                                data-value="{{ $classOpt }}">
                                                {{ $classOpt }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Periode Magang: Tanggal Mulai & Tanggal Selesai (Executive Range Card) -->
                        <div
                            class="p-4 rounded-2xl bg-gradient-to-r from-blue-50/70 to-slate-50/80 dark:from-blue-950/40 dark:to-[#0c1626] border border-blue-100 dark:border-blue-900/50 space-y-3">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-cyan-400 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2"
                                                stroke-width="2" />
                                            <path d="M16 2v4M8 2v4M3 10h18" stroke-width="2" />
                                        </svg>
                                    </span>
                                    <div>
                                        <span
                                            class="font-bold text-slate-900 dark:text-white text-xs block">{{ __('internship.form_period_title_smk') }}</span>
                                        <span
                                            class="text-[10px] text-slate-500 dark:text-slate-400 block">{{ __('internship.form_period_desc') }}</span>
                                    </div>
                                </div>
                                <span id="duration-badge-smk"
                                    class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white dark:bg-[#070c17] text-blue-700 dark:text-cyan-300 border border-blue-200 dark:border-blue-900 shadow-2xs">
                                    {{ __('internship.form_period_pick_badge') }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <div
                                    class="p-2.5 rounded-xl border border-slate-200/90 dark:border-slate-700/80 bg-white dark:bg-[#0c1626] focus-within:border-blue-500 dark:focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-500/20 transition">
                                    <div class="flex items-center justify-between mb-1">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('internship.field_start_date') }}</span>
                                        <span
                                            class="text-[10px] text-blue-600 dark:text-blue-400 font-medium">{{ __('internship.form_period_start') }}</span>
                                    </div>
                                    <input type="date" name="start_date" id="start-date-smk"
                                        onchange="calcDuration('smk')"
                                        onclick="if (typeof this.showPicker === 'function') { this.showPicker(); }"
                                        required
                                        class="w-full bg-transparent text-slate-900 dark:text-white text-xs font-semibold focus:outline-none cursor-pointer py-1">
                                </div>
                                <div
                                    class="p-2.5 rounded-xl border border-slate-200/90 dark:border-slate-700/80 bg-white dark:bg-[#0c1626] focus-within:border-blue-500 dark:focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-500/20 transition">
                                    <div class="flex items-center justify-between mb-1">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('internship.field_end_date') }}</span>
                                        <span
                                            class="text-[10px] text-blue-600 dark:text-blue-400 font-medium">{{ __('internship.form_period_end') }}</span>
                                    </div>
                                    <input type="date" name="end_date" id="end-date-smk"
                                        onchange="calcDuration('smk')"
                                        onclick="if (typeof this.showPicker === 'function') { this.showPicker(); }"
                                        required
                                        class="w-full bg-transparent text-slate-900 dark:text-white text-xs font-semibold focus:outline-none cursor-pointer py-1">
                                </div>
                            </div>
                            <input type="hidden" name="duration" id="duration-hidden-smk" value="">
                            <input type="hidden" name="start_period" id="start-period-hidden-smk" value="">
                        </div>

                        <!-- Peminatan Track SMK (Searchable Dropdown + Dinamis Admin + Lainnya) -->
                        <div>
                            <label
                                class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_interest') }}</label>
                            <input type="hidden" name="track" id="track-smk" required>

                            <div class="searchable-combobox relative" data-target-input="track-smk"
                                data-other-group="track-other-group-smk" data-other-input="track-other-smk">

                                <button type="button"
                                    class="combobox-trigger w-full flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb] text-left text-xs transition cursor-pointer">
                                    <span
                                        class="combobox-label truncate text-slate-500 dark:text-slate-400">{{ __('internship.combobox_track_smk_ph') }}</span>
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 combobox-arrow flex-shrink-0 ml-2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div
                                    class="combobox-panel hidden absolute left-0 right-0 top-full mt-1.5 z-50 rounded-2xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-700 shadow-2xl p-2.5">
                                    <div class="relative mb-2">
                                        <input type="text"
                                            class="combobox-search w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-[#0c1626] text-slate-900 dark:text-white pl-8 pr-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#2563eb]"
                                            placeholder="{{ __('internship.combobox_track_search_ph') }}">
                                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <ul class="combobox-list max-h-52 overflow-y-auto space-y-1 text-xs pr-1">
                                        @foreach ($smkTracks ?? [] as $trackItem)
                                            <li class="combobox-option px-3 py-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/40 cursor-pointer text-slate-800 dark:text-slate-200 transition"
                                                data-value="{{ $trackItem }}">
                                                {{ $trackItem }}
                                            </li>
                                        @endforeach
                                        <li class="combobox-option combobox-other px-3 py-2 rounded-lg bg-blue-50/70 dark:bg-blue-950/50 text-blue-600 dark:text-cyan-400 font-semibold hover:bg-blue-100 dark:hover:bg-blue-900/60 cursor-pointer border border-blue-200/60 dark:border-blue-800/60 transition mt-1"
                                            data-value="Lainnya">
                                            {{ __('internship.combobox_other_track') }}
                                        </li>
                                    </ul>
                                    <div
                                        class="combobox-notfound hidden mt-1.5 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-300 text-xs cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="truncate">{{ __('internship.combobox_use_query') }} "<strong
                                                    class="combobox-query-display font-semibold text-slate-900 dark:text-white"></strong>"</span>
                                            <span
                                                class="text-[11px] font-semibold text-blue-600 dark:text-cyan-400 flex items-center gap-1 flex-shrink-0">
                                                {{ __('internship.combobox_select_manual') }} &rarr;
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Input Manual Jika Memilih 'Lainnya' -->
                            <div id="track-other-group-smk"
                                class="hidden mt-2.5 p-3 rounded-xl bg-blue-50/50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 animate-in fade-in duration-200">
                                <label
                                    class="block font-semibold text-blue-900 dark:text-blue-300 mb-1 text-[11px]">{{ __('internship.manual_track_label') }}</label>
                                <input type="text" name="track_other" id="track-other-smk"
                                    placeholder="{{ __('internship.field_track_other_ph') }}"
                                    class="w-full rounded-lg border border-blue-300 dark:border-blue-700 bg-white dark:bg-[#070c17] text-slate-900 dark:text-white px-3 py-2 text-xs focus:ring-2 focus:ring-[#2563eb]">
                            </div>
                        </div>

                        <!-- Upload Berkas SMK -->
                        <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                            <label
                                class="block font-mono text-xs font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-wide">{{ __('internship.docs_header') }}</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_student_id') }}</span>
                                    <input name="file_identity" accept=".pdf,image/*"
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <div class="flex items-start justify-between gap-2 mb-1.5">
                                        <span class="font-semibold text-slate-800 dark:text-slate-200 leading-snug">
                                            {{ __('internship.doc_school_letter') }}
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-medium text-amber-700 dark:text-amber-300 bg-amber-100/70 dark:bg-amber-950/60 border border-amber-300/60 dark:border-amber-700/60 whitespace-nowrap shrink-0">
                                            {{ __('internship.doc_optional_badge') }}
                                        </span>
                                    </div>
                                    <input name="file_recommendation" accept=".pdf"
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        type="file" />
                                    <span
                                        class="block text-[10px] text-slate-400 mt-1">{{ __('internship.doc_school_letter_note') }}</span>
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_cv_optional') }}</span>
                                    <input name="file_cv" accept=".pdf"
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_report') }}</span>
                                    <input name="file_transcript" accept=".pdf"
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        required type="file" />
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Anggota Tim (Khusus Kelompok / Tim) -->
                        <div id="team-section-smk"
                            class="hidden p-4 rounded-2xl bg-blue-50/40 dark:bg-[#0c1626] border border-blue-200 dark:border-blue-900/60 space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white text-xs">
                                        {{ __('internship.team_section_title') }}</h4>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                        {{ __('internship.team_section_desc_smk') }}</p>
                                </div>
                                <button type="button" id="btn-add-member-smk" onclick="addTeamMember('smk')"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-[11px] shadow-sm transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>{{ __('internship.team_btn_add') }}</span>
                                </button>
                            </div>
                            <div id="team-members-list-smk" class="space-y-3">
                                <!-- Dynamic member cards rendered by JS -->
                            </div>
                        </div>

                        <div
                            class="pt-4 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                            <button
                                class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition font-semibold cursor-pointer"
                                onclick="closeModal('modal-daftar-smk')" type="button">
                                {{ __('internship.btn_cancel') }}
                            </button>
                            <button id="btn-submit-smk"
                                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#2563eb] hover:bg-[#1d4ed8] text-white font-bold transition shadow-sm cursor-pointer flex items-center justify-center gap-2"
                                type="submit">
                                <span>{{ __('internship.btn_submit_smk') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL 2: Pendaftaran Internship Mahasiswa & Fresh Graduate -->
        <div class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-md overflow-y-auto"
            id="modal-daftar-mahasiswa" onclick="if (event.target === this) closeModal('modal-daftar-mahasiswa');">
            <div
                class="relative w-full max-w-2xl bg-white dark:bg-[#131D36] rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-auto max-h-[90vh] flex flex-col">
                <div
                    class="flex items-center justify-between px-6 sm:px-8 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-[#0c1626] flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-cyan-50 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-mono font-bold text-sm shadow-xs border border-cyan-200 dark:border-cyan-900">
                            R&D
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0f172a] dark:text-white leading-tight">
                                {{ __('internship.form_he_title') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ __('internship.form_he_subtitle') }}
                            </p>
                        </div>
                    </div>
                    <button
                        class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white flex items-center justify-center cursor-pointer transition"
                        onclick="closeModal('modal-daftar-mahasiswa')" type="button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="overflow-y-auto p-6 sm:p-8 space-y-4 text-xs">
                    <!-- Form Alert Box -->
                    <div id="alert-form-mahasiswa" class="hidden p-3.5 rounded-xl border text-xs leading-relaxed"></div>

                    <form id="form-mahasiswa" class="space-y-4" method="POST"
                        action="{{ route('internship.apply') }}" enctype="multipart/form-data" novalidate
                        onsubmit="submitInternshipForm(event, 'university')">
                        @csrf
                        <input type="hidden" name="type" value="university">

                        <!-- Tipe Pengajuan: Individu vs Kelompok / Tim -->
                        <div
                            class="p-3 bg-slate-50 dark:bg-[#0c1626] rounded-2xl border border-slate-200 dark:border-slate-700/80">
                            <label class="block font-bold text-slate-800 dark:text-slate-200 mb-2">
                                {{ __('internship.form_app_type') }}
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <label
                                    class="app-type-label-univ flex items-center justify-center gap-2 p-2.5 rounded-xl border-2 cursor-pointer transition text-xs font-semibold bg-cyan-50/80 border-cyan-500 text-cyan-900 dark:bg-cyan-950/60 dark:border-cyan-400 dark:text-cyan-200"
                                    data-mode="individual">
                                    <input type="radio" name="application_type" value="individual" checked
                                        class="hidden app-type-radio"
                                        onchange="toggleApplicationType('univ', 'individual')">
                                    <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ __('internship.form_type_individual_univ') }}</span>
                                </label>
                                <label
                                    class="app-type-label-univ flex items-center justify-center gap-2 p-2.5 rounded-xl border-2 cursor-pointer transition text-xs font-semibold bg-white dark:bg-[#131D36] border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300"
                                    data-mode="group">
                                    <input type="radio" name="application_type" value="group"
                                        class="hidden app-type-radio" onchange="toggleApplicationType('univ', 'group')">
                                    <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>{{ __('internship.form_type_group_univ') }}</span>
                                </label>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-2 font-normal">
                                {!! __('internship.form_team_note') !!}
                            </p>
                        </div>

                        <!-- Nama Lengkap & NIM/NIK -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_name_he') }}</label>
                                <input name="name"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_name_he_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_nim') }}</label>
                                <input name="identity_number"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_nim_ph') }}" required type="text" />
                            </div>
                        </div>

                        <!-- Email & WhatsApp -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_email') }}</label>
                                <input name="email"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_email_ph') }}" type="email" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_phone_he') }}</label>
                                <input name="phone"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="08xxxxxxxxxx" required type="tel" />
                            </div>
                        </div>

                        <!-- Asal Kampus (Searchable Combobox) & Jurusan / Prodi (Searchable Combobox) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_univ') }}</label>
                                <input type="hidden" name="institution" id="institution-univ" required>

                                <div class="searchable-combobox relative" data-target-input="institution-univ"
                                    data-other-group="institution-other-group-univ"
                                    data-other-input="institution-other-univ">

                                    <button type="button"
                                        class="combobox-trigger w-full flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4] text-left text-xs transition cursor-pointer">
                                        <span
                                            class="combobox-label truncate text-slate-500 dark:text-slate-400">{{ __('internship.combobox_univ_ph') }}</span>
                                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 combobox-arrow flex-shrink-0 ml-2"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div
                                        class="combobox-panel hidden absolute left-0 right-0 top-full mt-1.5 z-50 rounded-2xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-700 shadow-2xl p-2.5">
                                        <div class="relative mb-2">
                                            <input type="text"
                                                class="combobox-search w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-[#0c1626] text-slate-900 dark:text-white pl-8 pr-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#06b6d4]"
                                                placeholder="{{ __('internship.combobox_univ_search_ph') }}">
                                            <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <ul class="combobox-list max-h-52 overflow-y-auto space-y-1 text-xs pr-1">
                                            @php
                                                $universities = [
                                                    'Institut Teknologi Bandung (ITB)',
                                                    'Universitas Indonesia (UI)',
                                                    'Universitas Gadjah Mada (UGM)',
                                                    'Institut Teknologi Sepuluh Nopember (ITS)',
                                                    'Telkom University (Tel-U)',
                                                    'Universitas Pendidikan Indonesia (UPI)',
                                                    'Universitas Padjadjaran (UNPAD)',
                                                    'Politeknik Negeri Bandung (POLBAN)',
                                                    'Politeknik Manufaktur Bandung (POLMAN)',
                                                    'Universitas Diponegoro (UNDIP)',
                                                    'Universitas Brawijaya (UB)',
                                                    'Universitas Airlangga (UNAIR)',
                                                    'Universitas Sebelas Maret (UNS)',
                                                    'Institut Pertanian Bogor (IPB University)',
                                                    'BINUS University',
                                                    'Universitas Islam Bandung (UNISBA)',
                                                    'Universitas Pasundan (UNPAS)',
                                                    'Universitas Komputer Indonesia (UNIKOM)',
                                                    'Institut Teknologi Nasional (ITENAS) Bandung',
                                                    'UIN Sunan Gunung Djati Bandung',
                                                    'Universitas Katolik Parahyangan (UNPAR)',
                                                    'Politeknik Elektronika Negeri Surabaya (PENS)',
                                                    'Politeknik Negeri Jakarta (PNJ)',
                                                    'Universitas Sriwijaya (UNSRI)',
                                                    'Universitas Hasanuddin (UNHAS)',
                                                    'Universitas Sumatera Utara (USU)',
                                                    'Universitas Andalas (UNAND)',
                                                    'Universitas Udayana (UNUD)',
                                                    'Universitas Syiah Kuala (USK)',
                                                    'Universitas Riau (UNRI)',
                                                    'Universitas Lampung (UNILA)',
                                                    'Universitas Negeri Yogyakarta (UNY)',
                                                    'Universitas Negeri Semarang (UNNES)',
                                                    'Universitas Negeri Surabaya (UNESA)',
                                                    'Universitas Negeri Malang (UM)',
                                                    'Universitas Jember (UNEJ)',
                                                    'Universitas Jenderal Soedirman (UNSOED)',
                                                ];
                                            @endphp
                                            @foreach ($universities as $univ)
                                                <li class="combobox-option px-3 py-2 rounded-lg hover:bg-cyan-50 dark:hover:bg-cyan-900/40 cursor-pointer text-slate-800 dark:text-slate-200 transition"
                                                    data-value="{{ $univ }}">
                                                    {{ $univ }}
                                                </li>
                                            @endforeach
                                            <li class="combobox-option combobox-other px-3 py-2 rounded-lg bg-cyan-50/70 dark:bg-cyan-950/50 text-cyan-600 dark:text-cyan-400 font-semibold hover:bg-cyan-100 dark:hover:bg-cyan-900/60 cursor-pointer border border-cyan-200/60 dark:border-cyan-800/60 transition mt-1"
                                                data-value="Lainnya">
                                                {{ __('internship.combobox_other_univ') }}
                                            </li>
                                        </ul>
                                        <div
                                            class="combobox-notfound hidden mt-1.5 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-300 text-xs cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="truncate">{{ __('internship.combobox_use_query') }} "<strong
                                                        class="combobox-query-display font-semibold text-slate-900 dark:text-white"></strong>"</span>
                                                <span
                                                    class="text-[11px] font-semibold text-cyan-600 dark:text-cyan-400 flex items-center gap-1 flex-shrink-0">
                                                    {{ __('internship.combobox_select_manual') }} &rarr;
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input Manual Jika Memilih Kampus 'Lainnya' -->
                                <div id="institution-other-group-univ"
                                    class="hidden mt-2 p-3 rounded-xl bg-cyan-50/50 dark:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 animate-in fade-in duration-200">
                                    <label for="institution-other-univ"
                                        class="block font-semibold text-cyan-900 dark:text-cyan-300 mb-1 text-[11px]">
                                        {{ __('internship.manual_univ_label') }}
                                    </label>
                                    <input type="text" name="institution_other" id="institution-other-univ"
                                        class="w-full rounded-lg border border-cyan-300 dark:border-cyan-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3 py-2 text-xs focus:ring-2 focus:ring-[#06b6d4]"
                                        placeholder="{{ __('internship.manual_univ_ph') }}">
                                    <span class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 block">
                                        {{ __('internship.manual_univ_help') }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_major_he') }}</label>
                                <input type="hidden" name="major" id="major-univ" required>

                                <div class="searchable-combobox relative" data-target-input="major-univ"
                                    data-other-group="major-other-group-univ" data-other-input="major-other-univ">

                                    <button type="button"
                                        class="combobox-trigger w-full flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4] text-left text-xs transition cursor-pointer">
                                        <span
                                            class="combobox-label truncate text-slate-500 dark:text-slate-400">{{ __('internship.combobox_major_ph') }}</span>
                                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 combobox-arrow flex-shrink-0 ml-2"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div
                                        class="combobox-panel hidden absolute left-0 right-0 top-full mt-1.5 z-50 rounded-2xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-700 shadow-2xl p-2.5">
                                        <div class="relative mb-2">
                                            <input type="text"
                                                class="combobox-search w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-[#0c1626] text-slate-900 dark:text-white pl-8 pr-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#06b6d4]"
                                                placeholder="{{ __('internship.combobox_major_search_ph') }}">
                                            <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <ul class="combobox-list max-h-52 overflow-y-auto space-y-1 text-xs pr-1">
                                            @php
                                                $majors = [
                                                    'S1 / D4 Teknik Elektro',
                                                    'S1 / D4 Teknik Komputer / Sistem Komputer',
                                                    'S1 / D4 Teknik Informatika / Ilmu Komputer',
                                                    'S1 / D4 Teknik Fisika / Instrumentasi & Kontrol',
                                                    'S1 / D4 Teknik Mekatronika & Robotika',
                                                    'S1 / D4 Teknik Telekomunikasi',
                                                    'S1 / D4 Rekayasa Otomasi Industri',
                                                    'S1 / D4 Sistem Informasi / Teknologi Informasi',
                                                    'S1 Meteorologi / Geofisika / Sains Kebumian',
                                                    'S1 Teknik Sipil / Pengairan & Sumber Daya Air (SDA)',
                                                    'S1 Teknik Lingkungan',
                                                    'S1 Sains Data (Data Science)',
                                                    'S1 Matematika / Statistika Komputasi',
                                                    'S1 Manajemen Bisnis / Administrasi Bisnis',
                                                    'S1 Desain Komunikasi Visual (DKV) / Desain Produk',
                                                ];
                                            @endphp
                                            @foreach ($majors as $majorItem)
                                                <li class="combobox-option px-3 py-2 rounded-lg hover:bg-cyan-50 dark:hover:bg-cyan-900/40 cursor-pointer text-slate-800 dark:text-slate-200 transition"
                                                    data-value="{{ $majorItem }}">
                                                    {{ $majorItem }}
                                                </li>
                                            @endforeach
                                            <li class="combobox-option combobox-other px-3 py-2 rounded-lg bg-cyan-50/70 dark:bg-cyan-950/50 text-cyan-600 dark:text-cyan-400 font-semibold hover:bg-cyan-100 dark:hover:bg-cyan-900/60 cursor-pointer border border-cyan-200/60 dark:border-cyan-800/60 transition mt-1"
                                                data-value="Lainnya">
                                                {{ __('internship.combobox_other_major') }}
                                            </li>
                                        </ul>
                                        <div
                                            class="combobox-notfound hidden mt-1.5 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-300 text-xs cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="truncate">{{ __('internship.combobox_use_query') }} "<strong
                                                        class="combobox-query-display font-semibold text-slate-900 dark:text-white"></strong>"</span>
                                                <span
                                                    class="text-[11px] font-semibold text-cyan-600 dark:text-cyan-400 flex items-center gap-1 flex-shrink-0">
                                                    {{ __('internship.combobox_select_manual') }} &rarr;
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input Manual Jika Memilih Prodi 'Lainnya' -->
                                <div id="major-other-group-univ"
                                    class="hidden mt-2 p-3 rounded-xl bg-cyan-50/50 dark:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 animate-in fade-in duration-200">
                                    <label
                                        class="block font-semibold text-cyan-900 dark:text-cyan-300 mb-1 text-[11px]">{{ __('internship.manual_major_label') }}</label>
                                    <input type="text" name="major_other" id="major-other-univ"
                                        placeholder="{{ __('internship.field_major_other_ph') }}"
                                        class="w-full rounded-lg border border-cyan-300 dark:border-cyan-700 bg-white dark:bg-[#070c17] text-slate-900 dark:text-white px-3 py-2 text-xs focus:ring-2 focus:ring-[#06b6d4]">
                                </div>
                            </div>
                        </div>

                        <!-- Semester Aktif (Custom Dropdown) -->
                        <div>
                            <label
                                class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_semester') }}</label>
                            <input type="hidden" name="grade_level" id="grade-level-univ" required>

                            <div class="searchable-combobox relative" data-target-input="grade-level-univ">
                                <button type="button"
                                    class="combobox-trigger w-full flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4] text-left text-xs transition cursor-pointer">
                                    <span
                                        class="combobox-label truncate text-slate-500 dark:text-slate-400">{{ __('internship.field_level_univ_select_ph') }}</span>
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 combobox-arrow flex-shrink-0 ml-2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div
                                    class="combobox-panel hidden absolute left-0 right-0 top-full mt-1.5 z-50 rounded-2xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-700 shadow-2xl p-2">
                                    <ul class="combobox-list max-h-52 overflow-y-auto space-y-1 text-xs pr-1">
                                        @php
                                            $univLevels = [
                                                'Semester 5 (Tingkat 3)',
                                                'Semester 6 (Tingkat 3)',
                                                'Semester 7 (Tingkat 4)',
                                                'Semester 8+ (Tingkat Akhir)',
                                                'Fresh Graduate (< 1 Tahun Lulus)',
                                            ];
                                        @endphp
                                        @foreach ($univLevels as $levelOpt)
                                            <li class="combobox-option px-3 py-2 rounded-lg hover:bg-cyan-50 dark:hover:bg-cyan-900/40 cursor-pointer text-slate-800 dark:text-slate-200 transition font-medium"
                                                data-value="{{ $levelOpt }}">
                                                {{ $levelOpt }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Periode Magang: Tanggal Mulai & Tanggal Selesai (Executive Range Card) -->
                        <div
                            class="p-4 rounded-2xl bg-gradient-to-r from-cyan-50/70 to-slate-50/80 dark:from-cyan-950/40 dark:to-[#0c1626] border border-cyan-100 dark:border-cyan-900/50 space-y-3">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="w-7 h-7 rounded-lg bg-cyan-100 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2"
                                                stroke-width="2" />
                                            <path d="M16 2v4M8 2v4M3 10h18" stroke-width="2" />
                                        </svg>
                                    </span>
                                    <div>
                                        <span
                                            class="font-bold text-slate-900 dark:text-white text-xs block">{{ __('internship.form_period_title_univ') }}</span>
                                        <span
                                            class="text-[10px] text-slate-500 dark:text-slate-400 block">{{ __('internship.form_period_desc') }}</span>
                                    </div>
                                </div>
                                <span id="duration-badge-univ"
                                    class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white dark:bg-[#070c17] text-cyan-700 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-800 shadow-2xs">
                                    {{ __('internship.form_period_pick_badge') }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <div
                                    class="p-2.5 rounded-xl border border-slate-200/90 dark:border-slate-700/80 bg-white dark:bg-[#0c1626] focus-within:border-cyan-500 dark:focus-within:border-cyan-400 focus-within:ring-2 focus-within:ring-cyan-500/20 transition">
                                    <div class="flex items-center justify-between mb-1">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('internship.field_start_date') }}</span>
                                        <span
                                            class="text-[10px] text-cyan-600 dark:text-cyan-400 font-medium">{{ __('internship.form_period_start') }}</span>
                                    </div>
                                    <input type="date" name="start_date" id="start-date-univ"
                                        onchange="calcDuration('univ')"
                                        onclick="if (typeof this.showPicker === 'function') { this.showPicker(); }"
                                        required
                                        class="w-full bg-transparent text-slate-900 dark:text-white text-xs font-semibold focus:outline-none cursor-pointer py-1">
                                </div>
                                <div
                                    class="p-2.5 rounded-xl border border-slate-200/90 dark:border-slate-700/80 bg-white dark:bg-[#0c1626] focus-within:border-cyan-500 dark:focus-within:border-cyan-400 focus-within:ring-2 focus-within:ring-cyan-500/20 transition">
                                    <div class="flex items-center justify-between mb-1">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('internship.field_end_date') }}</span>
                                        <span
                                            class="text-[10px] text-cyan-600 dark:text-cyan-400 font-medium">{{ __('internship.form_period_end') }}</span>
                                    </div>
                                    <input type="date" name="end_date" id="end-date-univ"
                                        onchange="calcDuration('univ')"
                                        onclick="if (typeof this.showPicker === 'function') { this.showPicker(); }"
                                        required
                                        class="w-full bg-transparent text-slate-900 dark:text-white text-xs font-semibold focus:outline-none cursor-pointer py-1">
                                </div>
                            </div>
                            <input type="hidden" name="duration" id="duration-hidden-univ" value="">
                            <input type="hidden" name="start_period" id="start-period-hidden-univ" value="">
                        </div>

                        <!-- Peminatan Track R&D (Searchable Combobox + Dinamis Admin + Lainnya) -->
                        <div>
                            <label
                                class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_interest_he') }}</label>
                            <input type="hidden" name="track" id="track-univ" required>

                            <div class="searchable-combobox relative" data-target-input="track-univ"
                                data-other-group="track-other-group-univ" data-other-input="track-other-univ">

                                <button type="button"
                                    class="combobox-trigger w-full flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4] text-left text-xs transition cursor-pointer">
                                    <span class="combobox-label truncate text-slate-500 dark:text-slate-400">Pilih atau
                                        cari Divisi / Peminatan R&D</span>
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 combobox-arrow flex-shrink-0 ml-2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div
                                    class="combobox-panel hidden absolute left-0 right-0 top-full mt-1.5 z-50 rounded-2xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-700 shadow-2xl p-2.5">
                                    <div class="relative mb-2">
                                        <input type="text"
                                            class="combobox-search w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-[#0c1626] text-slate-900 dark:text-white pl-8 pr-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#06b6d4]"
                                            placeholder="Cari peminatan / spesialisasi R&D...">
                                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <ul class="combobox-list max-h-52 overflow-y-auto space-y-1 text-xs pr-1">
                                        @foreach ($univTracks ?? [] as $trackItem)
                                            <li class="combobox-option px-3 py-2 rounded-lg hover:bg-cyan-50 dark:hover:bg-cyan-900/40 cursor-pointer text-slate-800 dark:text-slate-200 transition"
                                                data-value="{{ $trackItem }}">
                                                {{ $trackItem }}
                                            </li>
                                        @endforeach
                                        <li class="combobox-option combobox-other px-3 py-2 rounded-lg bg-cyan-50/70 dark:bg-cyan-950/50 text-cyan-600 dark:text-cyan-400 font-semibold hover:bg-cyan-100 dark:hover:bg-cyan-900/60 cursor-pointer border border-cyan-200/60 dark:border-cyan-800/60 transition mt-1"
                                            data-value="Lainnya">
                                            Lainnya (Peminatan Lain / Input Manual)...
                                        </li>
                                    </ul>
                                    <div
                                        class="combobox-notfound hidden mt-1.5 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-300 text-xs cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="truncate">Gunakan "<strong
                                                    class="combobox-query-display font-semibold text-slate-900 dark:text-white"></strong>"</span>
                                            <span
                                                class="text-[11px] font-semibold text-cyan-600 dark:text-cyan-400 flex items-center gap-1 flex-shrink-0">
                                                Pilih opsi manual &rarr;
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Input Manual Jika Memilih 'Lainnya' -->
                            <div id="track-other-group-univ"
                                class="hidden mt-2.5 p-3 rounded-xl bg-cyan-50/50 dark:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 animate-in fade-in duration-200">
                                <label
                                    class="block font-semibold text-cyan-900 dark:text-cyan-300 mb-1 text-[11px]">Tuliskan
                                    Bidang / Peminatan yang Diminati:</label>
                                <input type="text" name="track_other" id="track-other-univ"
                                    placeholder="{{ __('internship.field_track_other_ph') }}"
                                    class="w-full rounded-lg border border-cyan-300 dark:border-cyan-700 bg-white dark:bg-[#070c17] text-slate-900 dark:text-white px-3 py-2 text-xs focus:ring-2 focus:ring-[#06b6d4]">
                            </div>
                        </div>

                        <!-- Upload Berkas Mahasiswa -->
                        <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                            <label
                                class="block font-mono text-xs font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-wide">{{ __('internship.docs_header') }}</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_ktm') }}</span>
                                    <input name="file_identity" accept=".pdf,image/*"
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <div class="flex items-start justify-between gap-2 mb-1.5">
                                        <span class="font-semibold text-slate-800 dark:text-slate-200 leading-snug">
                                            {{ __('internship.doc_univ_letter') }}
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-medium text-amber-700 dark:text-amber-300 bg-amber-100/70 dark:bg-amber-950/60 border border-amber-300/60 dark:border-amber-700/60 whitespace-nowrap shrink-0">
                                            {{ __('internship.doc_optional_badge') }}
                                        </span>
                                    </div>
                                    <input name="file_recommendation" accept=".pdf"
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        type="file" />
                                    <span
                                        class="block text-[10px] text-slate-400 mt-1">{{ __('internship.doc_univ_letter_note') }}</span>
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_cv_he') }}</span>
                                    <input name="file_cv" accept=".pdf"
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_transcript') }}</span>
                                    <input name="file_transcript" accept=".pdf"
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        required type="file" />
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Anggota Tim (Khusus Kelompok / Tim) -->
                        <div id="team-section-univ"
                            class="hidden p-4 rounded-2xl bg-cyan-50/40 dark:bg-[#0c1626] border border-cyan-200 dark:border-cyan-900/60 space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white text-xs">
                                        {{ __('internship.team_section_title') }}</h4>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                        {{ __('internship.team_section_desc_univ') }}</p>
                                </div>
                                <button type="button" id="btn-add-member-univ" onclick="addTeamMember('univ')"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white font-bold text-[11px] shadow-sm transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>{{ __('internship.team_btn_add') }}</span>
                                </button>
                            </div>
                            <div id="team-members-list-univ" class="space-y-3">
                                <!-- Dynamic member cards rendered by JS -->
                            </div>
                        </div>

                        <div
                            class="pt-4 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                            <button
                                class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition font-semibold cursor-pointer"
                                onclick="closeModal('modal-daftar-mahasiswa')" type="button">
                                {{ __('internship.btn_cancel') }}
                            </button>
                            <button id="btn-submit-mahasiswa"
                                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#06b6d4] hover:bg-[#0891b2] text-white font-bold transition shadow-sm cursor-pointer flex items-center justify-center gap-2"
                                type="submit">
                                <span>{{ __('internship.btn_submit_he') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL 4: Konfirmasi Pendaftaran Sukses -->
        <div class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-md overflow-y-auto"
            id="modal-sukses-daftar" onclick="if (event.target === this) closeModal('modal-sukses-daftar');">
            <div
                class="relative w-full max-w-lg bg-white dark:bg-[#131D36] rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-auto p-6 sm:p-8 text-center space-y-5 animate-in fade-in duration-200">
                <div
                    class="w-16 h-16 rounded-2xl bg-emerald-100 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 mx-auto flex items-center justify-center shadow-xs">
                    <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">
                        {{ __('internship.success_title') }}
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto leading-relaxed">
                        {{ __('internship.success_desc') }}
                    </p>
                </div>
                <div
                    class="p-4 rounded-2xl bg-slate-50 dark:bg-[#0c1626] border border-slate-200/80 dark:border-slate-800 space-y-2">
                    <span
                        class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">{{ __('internship.success_reg_code_label') }}</span>
                    <div class="flex items-center justify-center gap-2">
                        <span id="success-reg-code"
                            class="text-2xl font-mono font-black text-cyan-600 dark:text-cyan-400 select-all tracking-wider">HGT-SMK-0001</span>
                        <button type="button" onclick="copyRegCode()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-200/80 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-xs font-semibold transition cursor-pointer"
                            title="{{ __('internship.btn_copy') }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="9" y="9" width="13" height="13" rx="2" stroke-width="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke-width="2"></path>
                            </svg>
                            <span>{{ __('internship.btn_copy') }}</span>
                        </button>
                    </div>
                    <p id="success-applicant-details" class="text-[11px] text-slate-600 dark:text-slate-400 font-medium">
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-1">
                    <button type="button" onclick="openTrackingWithCode()"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-bold text-xs transition shadow-sm cursor-pointer">
                        {{ __('internship.btn_track_now') }}
                    </button>
                    <button type="button" onclick="closeModal('modal-sukses-daftar')"
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 font-semibold text-xs transition cursor-pointer">
                        {{ __('internship.btn_close') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- DATALISTS FOR AUTOCOMPLETE & SEARCH (ALLOWS CUSTOM ENTRY) -->
        <datalist id="smk-schools-list">
            <option value="SMKN 1 Cimahi (Teknologi & Industri)">
            <option value="SMKN 2 Bandung (Teknologi Rekayasa)">
            <option value="SMKN 4 Bandung (Teknologi Informasi & Elektronika)">
            <option value="SMKN 7 Bandung (Analis Kimia & Instrumentasi)">
            <option value="SMKN 11 Bandung (Informatika & Bisnis)">
            <option value="SMKN 1 Katapang (Elektronika & Mekatronika)">
            <option value="SMKN 1 Soreang">
            <option value="SMKN 2 Baleendah">
            <option value="SMKN 1 Rancaekek">
            <option value="SMKN 1 Majalaya">
            <option value="SMKN 1 Padalarang">
            <option value="SMK Telkom Bandung">
            <option value="SMK Prakarya Internasional (PI) Bandung">
            <option value="SMK Angkasa 1 Margahayu Bandung">
            <option value="SMK Medikacom Bandung">
            <option value="SMKN 1 Sukabumi">
            <option value="SMKN 1 Cianjur">
            <option value="SMKN 1 Sumedang">
            <option value="SMKN 1 Garut">
            <option value="SMKN 1 Tasikmalaya">
            <option value="SMKN 2 Tasikmalaya">
            <option value="SMKN 1 Cirebon">
            <option value="SMKN 1 Karawang">
            <option value="SMKN 1 Kota Bekasi">
            <option value="SMKN 1 Kota Bogor">
            <option value="SMKN 1 Depok">
            <option value="SMKN 1 Jakarta">
            <option value="SMKN 26 Jakarta (Pembangunan)">
            <option value="SMKN 29 Jakarta (Penerbangan)">
            <option value="SMKN 2 Yogyakarta">
            <option value="SMKN 2 Surakarta">
            <option value="SMKN 2 Semarang">
            <option value="SMKN 1 Surabaya">
            <option value="SMKN 5 Surabaya">
            <option value="SMKN 1 Malang">
            <option value="SMK Telkom Purwokerto">
            <option value="SMK Telkom Malang">
            <option value="SMK Taruna Bhakti Depok">
        </datalist>

        <datalist id="univ-schools-list">
            <option value="Institut Teknologi Bandung (ITB)">
            <option value="Universitas Padjadjaran (UNPAD)">
            <option value="Universitas Pendidikan Indonesia (UPI)">
            <option value="Politeknik Negeri Bandung (POLBAN)">
            <option value="Politeknik Manufaktur Bandung (POLMAN)">
            <option value="Telkom University (Tel-U Bandung)">
            <option value="Universitas Indonesia (UI)">
            <option value="Universitas Gadjah Mada (UGM)">
            <option value="Institut Teknologi Sepuluh Nopember (ITS)">
            <option value="Universitas Diponegoro (UNDIP)">
            <option value="Universitas Brawijaya (UB)">
            <option value="Universitas Airlangga (UNAIR)">
            <option value="Universitas Sebelas Maret (UNS)">
            <option value="Institut Pertanian Bogor (IPB University)">
            <option value="Politeknik Elektronika Negeri Surabaya (PENS)">
            <option value="Politeknik Perkapalan Negeri Surabaya (PPNS)">
            <option value="Politeknik Negeri Jakarta (PNJ)">
            <option value="Universitas Bina Nusantara (BINUS University)">
            <option value="Universitas Komputer Indonesia (UNIKOM)">
            <option value="Universitas Pasundan (UNPAS)">
            <option value="Universitas Katolik Parahyangan (UNPAR)">
            <option value="Universitas Kristen Maranatha">
            <option value="Universitas Widyatama">
            <option value="Universitas Islam Bandung (UNISBA)">
            <option value="Universitas Islam Indonesia (UII)">
            <option value="Universitas Muhammadiyah Yogyakarta (UMY)">
            <option value="Universitas Jenderal Soedirman (UNSOED)">
            <option value="Universitas Negeri Semarang (UNNES)">
            <option value="Universitas Negeri Yogyakarta (UNY)">
            <option value="Universitas Negeri Malang (UM)">
            <option value="Universitas Udayana (UNUD)">
            <option value="Universitas Hasanuddin (UNHAS)">
            <option value="Universitas Sumatera Utara (USU)">
            <option value="Universitas Andalas (UNAND)">
            <option value="Universitas Sriwijaya (UNSRI)">
        </datalist>

        <datalist id="univ-majors-list">
            <option value="S1 / D4 Teknik Elektro">
            <option value="S1 / D4 Teknik Komputer / Sistem Komputer">
            <option value="S1 / D4 Teknik Informatika / Ilmu Komputer">
            <option value="S1 / D4 Teknik Fisika / Instrumentasi & Kontrol">
            <option value="S1 / D4 Teknik Mekatronika & Robotika">
            <option value="S1 / D4 Teknik Telekomunikasi">
            <option value="S1 / D4 Rekayasa Otomasi Industri">
            <option value="S1 / D4 Sistem Informasi / Teknologi Informasi">
            <option value="S1 Meteorologi / Geofisika / Sains Kebumian">
            <option value="S1 Teknik Sipil / Pengairan & Sumber Daya Air (SDA)">
            <option value="S1 Teknik Lingkungan">
            <option value="S1 Sains Data (Data Science)">
            <option value="S1 Manajemen Bisnis / Administrasi Bisnis">
            <option value="S1 Desain Komunikasi Visual (DKV) / Desain Produk">
        </datalist>

        <!-- MODAL 3: Pelacakan Status Berkas & Kelulusan (Real Dynamic Tracking) -->
        <div class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-md overflow-y-auto"
            id="modal-lacak-status" onclick="if (event.target === this) closeModal('modal-lacak-status');">
            <div
                class="relative w-full max-w-xl bg-white dark:bg-[#131D36] rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-auto max-h-[90vh] flex flex-col">
                <div
                    class="flex items-center justify-between px-6 sm:px-8 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-[#0c1626] flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl bg-cyan-50 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8" stroke-width="2" />
                                <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0f172a] dark:text-white leading-tight">
                                {{ __('internship.track_title') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ __('internship.track_subtitle') }}
                            </p>
                        </div>
                    </div>
                    <button
                        class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white flex items-center justify-center cursor-pointer transition font-bold"
                        onclick="closeModal('modal-lacak-status')" type="button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="overflow-y-auto p-6 sm:p-8 space-y-4 text-xs">
                    <!-- Form Query -->
                    <form class="space-y-3" onsubmit="searchStatus(event)">
                        <div>
                            <label for="lookup-query"
                                class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                {{ __('internship.track_input_label') }}
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input
                                    class="flex-1 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs font-mono focus:ring-2 focus:ring-[#0ea5e9] placeholder:font-sans placeholder:text-slate-400"
                                    id="lookup-query" placeholder="{{ __('internship.track_input_ph') }}"
                                    type="text" required />
                                <button id="lookup-btn"
                                    class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold text-xs transition cursor-pointer shadow-sm flex items-center justify-center gap-1.5 flex-shrink-0"
                                    type="submit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <circle cx="11" cy="11" r="8" stroke-width="2" />
                                        <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    <span>{{ __('internship.track_btn_submit') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Alert Box untuk pesan error / not found -->
                    <div id="lookup-alert" class="hidden p-3 rounded-xl border text-xs"></div>

                    <!-- Hasil Pelacakan Real Data (Awalnya Hidden) -->
                    <div class="hidden p-5 rounded-2xl bg-slate-50 dark:bg-[#0c1626] border border-slate-200/80 dark:border-slate-800 space-y-4 text-xs animate-in fade-in duration-200"
                        id="modal-timeline-result">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-200/60 dark:border-slate-800 gap-2">
                            <div>
                                <div class="font-mono font-bold text-slate-900 dark:text-white text-sm tracking-wide"
                                    id="result-ticket-id">
                                    -
                                </div>
                                <div class="text-slate-500 dark:text-slate-400 text-[11px] mt-0.5"
                                    id="result-applicant-info">
                                    -
                                </div>
                                <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono mt-0.5"
                                    id="result-date">
                                    -
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-md font-mono font-bold text-[10px] w-fit"
                                id="result-status-badge">
                                -
                            </span>
                        </div>

                        <!-- Dynamic Real Timeline -->
                        <div class="space-y-4 relative pl-6 border-l-2 border-slate-200 dark:border-slate-700 ml-2 py-1"
                            id="result-timeline">
                            <!-- Populated dynamically via JS -->
                        </div>

                        <!-- Catatan Admin (Jika ada) -->
                        <div id="result-notes-container"
                            class="hidden p-3 rounded-xl bg-blue-50/60 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 text-xs">
                            <span
                                class="font-bold text-blue-900 dark:text-blue-300 block mb-1">{{ __('internship.track_notes_title') }}</span>
                            <p class="text-slate-700 dark:text-slate-300" id="result-notes-text"></p>
                        </div>

                        <!-- Daftar Anggota Tim (Jika Permohonan Kelompok) -->
                        <div id="result-team-container"
                            class="hidden p-3.5 rounded-2xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-800 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800 dark:text-white flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-cyan-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>{{ __('internship.track_team_title') }} (<span
                                            id="result-team-count">0</span>)</span>
                                </span>
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-cyan-300 border border-blue-200 dark:border-blue-900">
                                    {{ __('internship.track_team_badge') }}
                                </span>
                            </div>
                            <ul id="result-team-list"
                                class="space-y-1.5 divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                                <!-- Populated dynamically via JS -->
                            </ul>
                        </div>

                        <!-- Tombol Unduh Surat Balasan (LoA PDF) Jika Diterima -->
                        <div id="result-loa-container"
                            class="hidden p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-xs">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <div
                                        class="font-bold text-emerald-900 dark:text-emerald-300 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 flex-shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>{{ __('internship.track_loa_title') }}</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 dark:text-emerald-400 mt-0.5"
                                        id="result-loa-info">
                                        {{ __('internship.track_loa_desc') }}
                                    </p>
                                </div>
                                <a id="result-loa-btn" href="#" target="_blank"
                                    class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition flex-shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>{{ __('internship.track_loa_download') }}</span>
                                </a>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div
                            class="pt-3 border-t border-slate-200/60 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <a id="result-wa-btn"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 font-bold hover:bg-emerald-100 transition text-[11px]"
                                href="{{ whatsapp_url('Halo Admin Higertech, saya ingin menanyakan perihal status pendaftaran magang.') }}"
                                rel="noopener noreferrer" target="_blank">
                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z" />
                                </svg>
                                <span>{{ __('internship.track_btn_wa') }}</span>
                            </a>
                            <button
                                class="px-3.5 py-1.5 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800 cursor-pointer font-medium"
                                onclick="closeModal('modal-lacak-status')" type="button">
                                {{ __('internship.btn_close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('landing.partials.footer')
@endsection
