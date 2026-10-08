@extends('layouts.app')

@section('title', 'Kontak | Higertech Karya Sinergi')
@section('description', 'Hubungi tim Higertech untuk solusi telemetry terbaik. Email, telepon, WhatsApp, dan kunjungi kantor kami di Bandung.')

@section('content')
<main>

    {{-- ===== HERO ===== --}}
    <section class="relative overflow-hidden bg-slate-50 dark:bg-[#070c17] py-24 sm:py-32 transition-colors duration-300">
        {{-- Decorative blobs --}}
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-blue-100 dark:bg-blue-600/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-20 w-[400px] h-[400px] rounded-full bg-cyan-100 dark:bg-cyan-500/10 blur-3xl pointer-events-none"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block mb-4 px-4 py-1.5 rounded-full bg-blue-100 dark:bg-blue-500/20 border border-blue-200 dark:border-blue-400/30 text-blue-600 dark:text-blue-300 text-xs font-bold uppercase tracking-widest">{{ __('contact.hero_badge') }}</span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white leading-tight mb-6">
                {{ __('contact.hero_title') }} <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-400 dark:to-blue-400">{{ __('contact.hero_title_highlight') }}</span>
            </h1>
            <p class="text-slate-600 dark:text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                {{ __('contact.hero_desc') }}
            </p>

            {{-- Quick Stats --}}
            <div class="mt-10 flex flex-wrap justify-center gap-4 sm:gap-8">
                <div class="flex flex-col items-center gap-1">
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ __('contact.stat_free') }}</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ __('contact.stat_free_desc') }}</span>
                </div>
                <div class="w-px h-12 bg-slate-200 dark:bg-slate-700 hidden sm:block self-center"></div>
                <div class="flex flex-col items-center gap-1">
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ __('contact.stat_fast') }}</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ __('contact.stat_fast_desc') }}</span>
                </div>
                <div class="w-px h-12 bg-slate-200 dark:bg-slate-700 hidden sm:block self-center"></div>
                <div class="flex flex-col items-center gap-1">
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ __('contact.stat_hq') }}</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ __('contact.stat_hq_desc') }}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CONTACT INFO + FORM ===== --}}
    <section class="py-16 sm:py-24 bg-white dark:bg-[#0B1120]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">

                {{-- Left: Contact Info --}}
                <div class="space-y-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-2">{{ __('contact.info_title') }}</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('contact.info_desc') }}</p>
                    </div>

                    {{-- Info Cards --}}
                    <div class="space-y-4">
                        {{-- Email --}}
                        <a href="mailto:higertechkaryasinergi@gmail.com"
                            class="flex items-center gap-4 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-[#131D36] hover:border-blue-400 dark:hover:border-cyan-500 transition group">
                            <span class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-cyan-400 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white dark:group-hover:bg-cyan-500 dark:group-hover:text-slate-900 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-0.5">{{ __('contact.info_email') }}</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">higertechkaryasinergi@gmail.com</p>
                            </div>
                        </a>

                        {{-- Phone --}}
                        <a href="tel:+622163732954"
                            class="flex items-center gap-4 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-[#131D36] hover:border-blue-400 dark:hover:border-cyan-500 transition group">
                            <span class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-cyan-400 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white dark:group-hover:bg-cyan-500 dark:group-hover:text-slate-900 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 .8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-0.5">{{ __('contact.info_phone') }}</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">(022) 6373 2954</p>
                            </div>
                        </a>

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/628112332182" target="_blank" rel="noopener noreferrer"
                            class="flex items-center gap-4 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-[#131D36] hover:border-emerald-400 dark:hover:border-emerald-500 transition group">
                            <span class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-0.5">{{ __('contact.info_wa') }}</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">+62 811-2332-182</p>
                            </div>
                        </a>

                        {{-- Address --}}
                        <div class="flex items-start gap-4 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-[#131D36]">
                            <span class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-cyan-400 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-0.5">{{ __('contact.info_address') }}</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 leading-relaxed">
                                    {{ __('contact.address_text') }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">{{ __('contact.operational_hours') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div class="flex items-center gap-3 pt-2">
                        <a href="https://www.instagram.com/higertech.ks/" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-500 hover:text-white transition flex items-center justify-center" aria-label="Instagram">
                            <svg class="w-4.5 h-4.5 w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                        </a>
                        <a href="https://www.youtube.com/@higertechkaryasinergi" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-red-600 hover:text-white transition flex items-center justify-center" aria-label="YouTube">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="mailto:higertechkaryasinergi@gmail.com"
                            class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-blue-600 hover:text-white transition flex items-center justify-center" aria-label="Email">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Right: Contact Form --}}
                <div class="bg-white dark:bg-[#0d1b3e] border border-slate-200 dark:border-transparent rounded-3xl p-8 sm:p-10 shadow-2xl">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 2 11 13M22 2 15 22l-4-9-9-4 20-7z"/>
                        </svg>
                        {{ __('contact.form_title') }}
                    </h2>

                    @if (session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20">
                            <p class="text-sm text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                                {{ session('success') }}
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5" id="contact-form">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('contact.form_name') }} <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="text" name="name" required placeholder="{{ __('contact.form_name_placeholder') }}"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-[#16275E]/60 border border-slate-200 dark:border-slate-600/50 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-cyan-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('contact.form_company') }}</label>
                                <input type="text" name="company" placeholder="{{ __('contact.form_company_placeholder') }}"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-[#16275E]/60 border border-slate-200 dark:border-slate-600/50 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-cyan-500 focus:border-transparent transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('contact.info_email') }} <span class="text-red-500 dark:text-red-400">*</span></label>
                                <input type="email" name="email" required placeholder="{{ __('contact.form_email_placeholder') }}"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-[#16275E]/60 border border-slate-200 dark:border-slate-600/50 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-cyan-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('contact.info_phone') }}</label>
                                <input type="tel" name="phone" placeholder="{{ __('contact.form_phone_placeholder') }}"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-[#16275E]/60 border border-slate-200 dark:border-slate-600/50 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-cyan-500 focus:border-transparent transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">{{ __('contact.form_message') }} <span class="text-red-500 dark:text-red-400">*</span></label>
                            <textarea name="message" required rows="5" placeholder="{{ __('contact.form_message_placeholder') }}"
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-[#16275E]/60 border border-slate-200 dark:border-slate-600/50 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-cyan-500 focus:border-transparent transition resize-none"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-900 font-bold text-sm transition shadow-lg shadow-blue-500/20 dark:shadow-cyan-500/20 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M22 2 11 13M22 2 15 22l-4-9-9-4 20-7z"/>
                            </svg>
                            {{ __('contact.form_submit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== WHY CHOOSE US / FEATURE CARDS ===== --}}
    <section class="py-16 sm:py-24 bg-slate-50 dark:bg-[#070c17] transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-12">
                <div>
                    <span class="inline-block mb-2 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-500/20 border border-blue-200 dark:border-blue-400/30 text-blue-600 dark:text-blue-300 text-xs font-bold uppercase tracking-widest">{{ __('contact.partner_badge') }}</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
                        {{ __('contact.partner_title') }}
                    </h2>
                    <p class="mt-3 text-slate-600 dark:text-slate-400 text-sm max-w-lg">{{ __('contact.partner_desc') }}</p>
                </div>
                <a href="{{ route('internship') }}"
                    class="shrink-0 inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-900 font-bold text-sm transition shadow-lg shadow-blue-500/20 dark:shadow-cyan-500/20">
                    {{ __('contact.partner_cta') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                    $partnerTypes = [
                        [
                            'icon' => '<path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/>',
                            'label' => __('contact.partner_type_1_label'),
                            'desc' => __('contact.partner_type_1_desc'),
                        ],
                        [
                            'icon' => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/>',
                            'label' => __('contact.partner_type_2_label'),
                            'desc' => __('contact.partner_type_2_desc'),
                        ],
                        [
                            'icon' => '<path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z"/>',
                            'label' => __('contact.partner_type_3_label'),
                            'desc' => __('contact.partner_type_3_desc'),
                        ],
                        [
                            'icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
                            'label' => __('contact.partner_type_4_label'),
                            'desc' => __('contact.partner_type_4_desc'),
                        ],
                    ];
                @endphp

                @foreach ($partnerTypes as $type)
                    <div class="bg-white dark:bg-white/5 hover:bg-slate-50 dark:hover:bg-white/10 border border-slate-200 dark:border-white/10 hover:border-blue-400/50 dark:hover:border-cyan-500/30 rounded-2xl p-6 transition group shadow-sm hover:shadow-md">
                        <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-500/20 text-blue-600 dark:text-cyan-400 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white dark:group-hover:bg-cyan-500 dark:group-hover:text-slate-900 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                {!! $type['icon'] !!}
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2">{{ $type['label'] }}</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">{{ $type['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== GOOGLE MAPS ===== --}}
    <section class="py-16 sm:py-24 bg-white dark:bg-[#0B1120]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <span class="inline-block mb-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-500/20 border border-blue-200 dark:border-blue-400/30 text-blue-600 dark:text-blue-300 text-xs font-bold uppercase tracking-widest">{{ __('contact.location_badge') }}</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">{{ __('contact.location_title') }}</h2>
                <p class="mt-2 text-slate-500 dark:text-slate-400 text-sm max-w-lg">
                    {{ __('contact.location_desc') }}
                </p>
            </div>

            {{-- Office selector tabs --}}
            <div class="flex gap-3 mb-6 flex-wrap">
                <button onclick="switchOffice('marketing')" id="tab-marketing"
                    class="office-tab inline-flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-blue-500 bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-cyan-300 font-bold text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ __('contact.tab_marketing') }}
                </button>
                <button onclick="switchOffice('telemetri')" id="tab-telemetri"
                    class="office-tab inline-flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold text-sm hover:border-blue-400 dark:hover:border-cyan-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    {{ __('contact.tab_telemetri') }}
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- ========== KANTOR MARKETING ========== --}}
                <div id="office-marketing" class="office-panel lg:col-span-1 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-lg">
                    {{-- Card Header --}}
                    <div class="p-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-[#131D36]">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-cyan-400 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-[10px] font-bold text-blue-600 dark:text-cyan-400 uppercase tracking-wider">{{ __('contact.panel_marketing_subtitle') }}</p>
                                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ __('contact.panel_marketing_title') }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Details --}}
                    <div class="p-5 bg-white dark:bg-[#0B1120] space-y-3 text-sm">
                        <div class="flex justify-between gap-2">
                            <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('contact.info_email') }}</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100 text-right">higertechkaryasinergi@gmail.com</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('contact.info_phone') }}</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100">(022) 6373 2954</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('contact.info_wa') }}</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100">+62 811-2332-182</span>
                        </div>
                        <div class="flex justify-between gap-2 items-start">
                            <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('contact.info_address') }}</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100 text-right leading-snug">
                                {{ __('contact.address_text') }}
                            </span>
                        </div>
                    </div>
                    {{-- Maps Button --}}
                    <div class="px-5 pb-5 bg-white dark:bg-[#0B1120]">
                        <a href="https://maps.google.com/?q=Graha+Pos+Indonesia,+Jl.+Banda+No.+30,+Kel.+Citarum,+Kec.+Bandung+Wetan,+Kota+Bandung,+Jawa+Barat+40115"
                            target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl border-2 border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 font-semibold text-sm hover:border-blue-500 hover:text-blue-600 dark:hover:border-cyan-500 dark:hover:text-cyan-400 transition">
                            {{ __('contact.map_button') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                {{-- ========== HIGERTECH TELEMETRI ========== --}}
                <div id="office-telemetri" class="office-panel hidden lg:col-span-1 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-lg">
                    {{-- Card Header --}}
                    <div class="p-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-[#131D36]">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-cyan-400 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-[10px] font-bold text-blue-600 dark:text-cyan-400 uppercase tracking-wider">{{ __('contact.panel_telemetri_subtitle') }}</p>
                                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ __('contact.panel_telemetri_title') }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Details --}}
                    <div class="p-5 bg-white dark:bg-[#0B1120] space-y-3 text-sm">
                        <div class="flex justify-between gap-2">
                            <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('contact.info_email') }}</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100 text-right">higertechkaryasinergi@gmail.com</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('contact.info_phone') }}</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100">022-2101-0299</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('contact.info_wa') }}</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100">+62 811-2332-182</span>
                        </div>
                        <div class="flex justify-between gap-2 items-start">
                            <span class="text-slate-500 dark:text-slate-400 shrink-0">{{ __('contact.info_address') }}</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100 text-right leading-snug">
                                Jl. Mandala Raya No. 36, Mandala Mekar, Kec. Cimenyan, Kota Bandung, Jawa Barat 40193
                            </span>
                        </div>
                    </div>
                    {{-- Maps Button --}}
                    <div class="px-5 pb-5 bg-white dark:bg-[#0B1120]">
                        <a href="https://maps.google.com/?q=Jl.+Mandala+Raya+No.+36,+Mandala+Mekar,+Kec.+Cimenyan,+Kota+Bandung,+Jawa+Barat+40193"
                            target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl border-2 border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 font-semibold text-sm hover:border-blue-500 hover:text-blue-600 dark:hover:border-cyan-500 dark:hover:text-cyan-400 transition">
                            {{ __('contact.map_button') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Embedded Google Maps iframe (switches on tab) --}}
                <div class="lg:col-span-2 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-lg h-[420px]">
                    <iframe id="map-iframe"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.0196428028817!2d107.61547027465065!3d-6.908785493093088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7a977173e31%3A0xf29571e89fca8c7c!2sGraha%20Pos%20Indonesia!5e0!3m2!1sen!2sid!4v1728386201000!5m2!1sen!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi Kantor Higertech">
                    </iframe>
                </div>
            </div>
        </div>

        <script>
            var mapUrls = {
                marketing: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.0196428028817!2d107.61547027465065!3d-6.908785493093088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7a977173e31%3A0xf29571e89fca8c7c!2sGraha%20Pos%20Indonesia!5e0!3m2!1sen!2sid!4v1728386201000!5m2!1sen!2sid',
                telemetri: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.4553!2d107.6757!3d-6.8852!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e8b1!2sHigertech+Telemetri!5e0!3m2!1sen!2sid!4v1728386202000!5m2!1sen!2sid',
            };

            function switchOffice(key) {
                // Toggle card panels
                document.getElementById('office-marketing').classList.toggle('hidden', key !== 'marketing');
                document.getElementById('office-telemetri').classList.toggle('hidden', key !== 'telemetri');

                // Update map iframe
                document.getElementById('map-iframe').src = mapUrls[key];

                // Toggle tab styles
                var tabs = document.querySelectorAll('.office-tab');
                tabs.forEach(function(t) {
                    t.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-950/60', 'text-blue-700', 'dark:text-cyan-300', 'font-bold');
                    t.classList.add('border-slate-200', 'dark:border-slate-700', 'text-slate-600', 'dark:text-slate-300', 'font-semibold');
                });
                var active = document.getElementById('tab-' + key);
                active.classList.remove('border-slate-200', 'dark:border-slate-700', 'text-slate-600', 'dark:text-slate-300', 'font-semibold');
                active.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-950/60', 'text-blue-700', 'dark:text-cyan-300', 'font-bold');
            }
        </script>
    </section>

</main>

@include('landing.partials.footer')
@endsection


