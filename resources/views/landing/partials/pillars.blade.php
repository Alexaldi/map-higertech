<section id="why-us" class="py-20 bg-white dark:bg-[#0B1120] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-12 scroll-reveal">
            <span
                class="text-blue-600 dark:text-cyan-400 font-bold text-xs uppercase tracking-wider block mb-2">{{ __('landing.pillar_label') }}</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                {{ __('landing.pillar_title') }}<br>
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-400 dark:to-blue-400">{{ __('landing.pillar_title_highlight') }}</span>
            </h2>
            <p class="mt-3 text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
                {{ __('landing.pillar_desc') }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch scroll-reveal scroll-reveal-scale">
            {{-- Tab Buttons --}}
            <div class="lg:col-span-5 space-y-3" id="pillar-tabs" role="tablist"
                aria-label="{{ __('landing.pillar_label') }}">
                @php
                    $pillars = [
                        [
                            'title' => __('landing.pillar_1_title'),
                            'sub' => 'Teknologi Ramah Lingkungan & Mandiri Energi',
                            'badge' => __('landing.pillar_1_badge'),
                            'desc' => __('landing.pillar_1_desc'),
                            'gradient' => 'from-emerald-500 to-teal-700',
                            'ring' => 'ring-emerald-400/30',
                            'iconColor' => 'text-emerald-600 dark:text-emerald-400',
                            'bgColor' => 'bg-emerald-500/10',
                        ],
                        [
                            'title' => __('landing.pillar_2_title'),
                            'sub' => 'Akurasi Tinggi & Transmisi Real-Time',
                            'badge' => __('landing.pillar_2_badge'),
                            'desc' => __('landing.pillar_2_desc'),
                            'gradient' => 'from-blue-600 to-indigo-800',
                            'ring' => 'ring-blue-400/20',
                            'iconColor' => 'text-blue-600 dark:text-blue-400',
                            'bgColor' => 'bg-blue-500/10',
                        ],
                        [
                            'title' => __('landing.pillar_3_title'),
                            'sub' => 'Perlindungan Ekosistem Sungai & DAS',
                            'badge' => __('landing.pillar_3_badge'),
                            'desc' => __('landing.pillar_3_desc'),
                            'gradient' => 'from-cyan-500 to-blue-600',
                            'ring' => 'ring-cyan-400/20',
                            'iconColor' => 'text-cyan-600 dark:text-cyan-400',
                            'bgColor' => 'bg-cyan-500/10',
                        ],
                        [
                            'title' => __('landing.pillar_4_title'),
                            'sub' => 'Mitra Resmi Pemerintah & Institusi',
                            'badge' => __('landing.pillar_4_badge'),
                            'desc' => __('landing.pillar_4_desc'),
                            'gradient' => 'from-amber-500 to-orange-600',
                            'ring' => 'ring-amber-400/20',
                            'iconColor' => 'text-amber-600 dark:text-amber-400',
                            'bgColor' => 'bg-amber-500/10',
                        ],
                    ];
                @endphp

                @foreach ($pillars as $i => $pillar)
                    <button type="button" role="tab" id="pillar-tab-{{ $i }}"
                        aria-controls="pillar-display-body" aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                        tabindex="{{ $i === 0 ? '0' : '-1' }}"
                        class="pillar-btn w-full text-left p-4 rounded-2xl transition-all flex items-center gap-4 cursor-pointer {{ $i === 0 ? 'bg-blue-50/90 dark:bg-blue-900/30 border-2 border-blue-500 dark:border-cyan-500' : 'bg-slate-50 dark:bg-[#131D36] border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800' }}"
                        data-index="{{ $i }}" data-title="{{ $pillar['title'] }}"
                        data-badge="{{ $pillar['badge'] }}" data-desc="{{ $pillar['desc'] }}"
                        data-icon-color="{{ $pillar['iconColor'] }}" data-bg-color="{{ $pillar['bgColor'] }}">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $pillar['gradient'] }} text-white flex items-center justify-center flex-shrink-0 shadow-md ring-2 {{ $pillar['ring'] }}">
                            @if ($i === 0)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z" />
                                    <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                                </svg>
                            @elseif($i === 1)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M4.9 19.1C1 15.2 1 8.8 4.9 4.9M7.8 16.2c-2.3-2.3-2.3-6.1 0-8.5M12 12h.01M16.2 7.8c2.3 2.3 2.3 6.1 0 8.5M19.1 4.9C23 8.8 23 15.1 19.1 19" />
                                </svg>
                            @elseif($i === 2)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    <path d="M12 8v4M12 16h.01" />
                                </svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="8" r="6" />
                                    <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <div
                                class="font-bold text-xs sm:text-sm {{ $i === 0 ? 'text-slate-900 dark:text-white' : 'text-slate-700 dark:text-slate-300' }} tracking-wide">
                                {{ $pillar['title'] }}</div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400">{{ $pillar['sub'] }}</div>
                        </div>
                    </button>
                @endforeach
            </div>

            {{-- Display Panel --}}
            <div class="lg:col-span-7">
                <div
                    class="rounded-3xl border border-blue-200 dark:border-slate-800 bg-gradient-to-br from-blue-50/60 via-slate-50 to-indigo-50/40 dark:from-[#131D36] dark:via-[#0E1628] dark:to-[#0B1120] p-6 sm:p-10 shadow-sm min-h-[380px] flex flex-col justify-between relative overflow-hidden">
                    <div id="pillar-display-body" role="tabpanel" aria-labelledby="pillar-tab-0"
                        class="space-y-5 relative z-10 transition-all duration-200"
                        style="transition: opacity 0.2s ease, transform 0.2s ease;">
                        <div class="flex items-center gap-3">
                            <div id="pillar-display-icon-box"
                                class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                                <svg id="pillar-display-icon-svg" class="w-6 h-6" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z" />
                                    <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                                </svg>
                            </div>
                            <div>
                                <span id="pillar-display-badge"
                                    class="text-[10px] font-mono uppercase tracking-widest text-emerald-600 dark:text-cyan-400 font-bold block">{{ __('landing.pillar_1_badge') }}</span>
                                <h3 id="pillar-display-title"
                                    class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                                    {{ __('landing.pillar_1_title') }}</h3>
                            </div>
                        </div>
                        <p id="pillar-display-desc"
                            class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
                            {{ __('landing.pillar_1_desc') }}</p>

                        {{-- Keunggulan untuk Pengguna / Instansi --}}
                        <div
                            class="p-4 rounded-2xl bg-white/80 dark:bg-[#0c1626]/80 border border-slate-200/80 dark:border-slate-800">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-center text-xs">
                                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80">
                                    <span
                                        class="text-emerald-600 dark:text-emerald-400 font-bold block text-sm">24/7</span>
                                    <span class="text-slate-600 dark:text-slate-300 font-medium text-[11px]">Monitoring
                                        Real-Time</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80">
                                    <span class="text-blue-600 dark:text-blue-400 font-bold block text-sm">BMKG &
                                        PUPR</span>
                                    <span class="text-slate-600 dark:text-slate-300 font-medium text-[11px]">Standar
                                        Resmi</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80">
                                    <span
                                        class="text-cyan-600 dark:text-cyan-400 font-bold block text-sm">Garansi</span>
                                    <span class="text-slate-600 dark:text-slate-300 font-medium text-[11px]">Layanan
                                        Purna Jual</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80">
                                    <span
                                        class="text-amber-600 dark:text-amber-400 font-bold block text-sm">Nasional</span>
                                    <span class="text-slate-600 dark:text-slate-300 font-medium text-[11px]">Sebaran 34
                                        Provinsi</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 relative z-10 flex flex-wrap items-center gap-3">
                        <a href="#contact"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#16275E] hover:bg-blue-800 dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 text-xs sm:text-sm font-bold transition shadow-md group">
                            <span>{{ __('landing.pillar_cta') }}</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M5 12h14m-7-7 7 7-7 7" />
                            </svg>
                        </a>
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Respon Cepat Tim
                            Teknis</span>
                    </div>

                    <div
                        class="absolute -right-6 -bottom-6 w-48 h-48 opacity-5 dark:opacity-10 text-blue-600 dark:text-cyan-400 pointer-events-none">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            class="w-full h-full" aria-hidden="true">
                            <path
                                d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
