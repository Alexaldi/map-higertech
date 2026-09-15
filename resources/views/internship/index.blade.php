@extends('layouts.app')

@section('title', __('internship.meta_title'))
@section('description', __('internship.meta_description'))

@section('content')
    <main class="flex-1">
        <!-- BEGIN: Hero Section -->
        <section
            class="relative pt-16 pb-20 sm:pt-20 sm:pb-24 px-4 sm:px-8 bg-gradient-to-b from-blue-50/40 via-slate-50 to-white dark:from-[#080d1a] dark:via-[#0B1120] dark:to-[#0B1120] map-grid-bg transition-colors duration-300 overflow-hidden">
            <div class="max-w-5xl mx-auto text-center relative z-10 scroll-reveal">
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
                        <span class="text-sm">🔍</span>
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
                            <button
                                class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl text-xs font-bold text-white bg-[#2563eb] hover:bg-[#1d4ed8] dark:bg-blue-600 dark:hover:bg-blue-500 shadow-sm transition-all cursor-pointer"
                                onclick="openModal('modal-daftar-smk')" type="button">
                                <span>{{ __('internship.smk_btn') }}</span>
                                <span class="text-sm">→</span>
                            </button>
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
                            <button
                                class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl text-xs font-bold text-white bg-[#06b6d4] hover:bg-[#0891b2] transition-all shadow-sm cursor-pointer"
                                onclick="openModal('modal-daftar-mahasiswa')" type="button">
                                <span>{{ __('internship.he_btn') }}</span>
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

        <!-- MODAL 1: Pendaftaran PKL SMK/MAK -->
        <div class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 sm:p-6 bg-black/75 backdrop-blur-md overflow-y-auto"
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
                                {{ __('internship.form_smk_title') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ __('internship.form_smk_subtitle') }}
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
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_name_student') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_name_student_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_nisn') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_nisn_ph') }}" required type="text" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_school') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_school_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_major') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_major_ph') }}" required type="text" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_class') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_class_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_phone') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_phone_ph') }}" required type="tel" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_duration') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_duration_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_start_month') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                    placeholder="{{ __('internship.field_start_month_ph') }}" required type="text" />
                            </div>
                        </div>
                        <div>
                            <label
                                class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_interest') }}</label>
                            <input
                                class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#2563eb]"
                                placeholder="{{ __('internship.field_interest_ph') }}" required type="text" />
                        </div>
                        <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                            <label
                                class="block font-mono text-xs font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-wide">{{ __('internship.docs_header') }}</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_student_id') }}</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_school_letter') }}</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_cv_optional') }}</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer"
                                        type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_report') }}</span>
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
                                {{ __('internship.btn_cancel') }}
                            </button>
                            <button
                                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#2563eb] hover:bg-[#1d4ed8] text-white font-bold transition shadow-sm cursor-pointer"
                                type="submit">
                                {{ __('internship.btn_submit_smk') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL 2: Pendaftaran Internship Mahasiswa -->
        <div class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 sm:p-6 bg-black/75 backdrop-blur-md overflow-y-auto"
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
                                {{ __('internship.form_he_title') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ __('internship.form_he_subtitle') }}
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
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_name_he') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_name_he_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_nim') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_nim_ph') }}" required type="text" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_univ') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_univ_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_major_he') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_major_he_ph') }}" required type="text" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_semester') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_semester_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_phone_he') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 font-mono focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="08xxxxxxxxxx" required type="tel" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_duration_he') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_duration_he_ph') }}" required type="text" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_start_month_he') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                    placeholder="{{ __('internship.field_start_month_he_ph') }}" required
                                    type="text" />
                            </div>
                        </div>
                        <div>
                            <label
                                class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.field_interest_he') }}</label>
                            <input
                                class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 focus:ring-2 focus:ring-[#06b6d4]"
                                placeholder="{{ __('internship.field_interest_he_ph') }}" required type="text" />
                        </div>
                        <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                            <label
                                class="block font-mono text-xs font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-wide">{{ __('internship.docs_header') }}</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_ktm') }}</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_univ_letter') }}</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_cv_he') }}</span>
                                    <input
                                        class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300 hover:file:bg-cyan-100 cursor-pointer"
                                        required type="file" />
                                </div>
                                <div
                                    class="p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-[#0c1626]">
                                    <span
                                        class="block font-semibold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('internship.doc_transcript') }}</span>
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
                                {{ __('internship.btn_cancel') }}
                            </button>
                            <button
                                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#06b6d4] hover:bg-[#0891b2] text-white font-bold transition shadow-sm cursor-pointer"
                                type="submit">
                                {{ __('internship.btn_submit_he') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL 3: Pelacakan Status Berkas & Kelulusan -->
        <div class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 sm:p-6 bg-black/75 backdrop-blur-md overflow-y-auto"
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
                            {{ __('internship.track_tab_id') }}
                        </button>
                        <button
                            class="py-2 px-3 rounded-lg font-bold text-xs transition-all text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer"
                            id="tab-lacak-email" onclick="switchLacakTab('email')" type="button">
                            {{ __('internship.track_tab_email') }}
                        </button>
                    </div>

                    <!-- Form Query -->
                    <form class="space-y-4" onsubmit="searchStatus(event)">
                        <div class="space-y-3" id="form-lacak-id-group">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.track_id_label') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs font-mono focus:ring-2 focus:ring-[#0ea5e9]"
                                    id="lookup-input-id" placeholder="cth: HGT-2025-0482 atau HGT-SMK-2025"
                                    type="text" value="HGT-2025-0482" required />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.track_name_label') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-[#0ea5e9]"
                                    id="lookup-input-name" placeholder="cth: Ahmad" type="text" value="Ahmad"
                                    required />
                            </div>
                        </div>

                        <div class="space-y-3 hidden" id="form-lacak-email-group">
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.track_email_label') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-[#0ea5e9]"
                                    id="lookup-input-email" placeholder="cth: ahmad.farhan@itb.ac.id" type="email" />
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('internship.track_phone_label') }}</label>
                                <input
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#0c1626] text-slate-900 dark:text-white px-3.5 py-2.5 text-xs font-mono focus:ring-2 focus:ring-[#0ea5e9]"
                                    id="lookup-input-phone" maxlength="4" placeholder="cth: 0299" type="text" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-1 gap-2">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                {{ __('internship.track_sample_note') }}
                                <code class="text-cyan-600 dark:text-cyan-400 font-mono font-bold">HGT-2025-0482</code>
                            </p>
                            <button
                                class="px-5 py-2.5 rounded-xl bg-[#0ea5e9] hover:bg-[#0284c7] text-white font-bold text-xs transition cursor-pointer shadow-sm"
                                type="submit">
                                {{ __('internship.track_btn_check') }}
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
                                    Ahmad Farhan — ITB
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-md bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 font-mono font-bold text-[10px] w-fit">
                                {{ __('internship.track_status_accepted') }}
                            </span>
                        </div>
                        <div
                            class="space-y-3.5 relative pl-6 border-l-2 border-emerald-500 dark:border-emerald-400 ml-2 py-1">
                            <div class="relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>
                                <div class="font-bold text-slate-900 dark:text-white">
                                    {{ __('internship.track_step_1_title') }}</div>
                                <div class="text-slate-500 text-[11px]">{{ __('internship.track_step_1_desc') }}</div>
                            </div>
                            <div class="relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>
                                <div class="font-bold text-slate-900 dark:text-white">
                                    {{ __('internship.track_step_2_title') }}</div>
                                <div class="text-slate-500 text-[11px]">{{ __('internship.track_step_2_desc') }}</div>
                            </div>
                            <div class="relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>
                                <div class="font-bold text-slate-900 dark:text-white">
                                    {{ __('internship.track_step_3_title') }}</div>
                                <div class="text-slate-500 text-[11px]">{{ __('internship.track_step_3_desc') }}</div>
                            </div>
                            <div class="relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-cyan-500 text-white flex items-center justify-center text-[9px] animate-pulse font-bold">●</span>
                                <div class="font-bold text-cyan-600 dark:text-cyan-400">
                                    {{ __('internship.track_step_4_title') }}</div>
                                <div class="text-slate-500 text-[11px]">{{ __('internship.track_step_4_desc') }}</div>
                            </div>
                        </div>
                        <div
                            class="pt-3 border-t border-slate-200/60 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <a class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0284c7] dark:text-cyan-400 hover:underline"
                                href="#"
                                onclick="alert('Mengunduh dokumen resmi Letter of Acceptance (LOA_Higertech.pdf)...'); return false;">
                                <span>{{ __('internship.track_download_loa') }}</span>
                            </a>
                            <div class="flex items-center gap-2">
                                <a class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 font-bold hover:underline text-[11px]"
                                    href="https://wa.me/628112332182" rel="noopener noreferrer" target="_blank">
                                    {{ __('internship.track_btn_wa') }}
                                </a>
                                <button
                                    class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800 cursor-pointer"
                                    onclick="closeModal('modal-lacak-status')" type="button">
                                    {{ __('internship.track_btn_close') }}
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
