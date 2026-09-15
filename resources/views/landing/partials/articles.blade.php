<section id="articles" class="py-20 bg-slate-50/50 dark:bg-[#0E1628] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 scroll-reveal">
            <span
                class="text-blue-600 dark:text-cyan-400 font-bold text-xs uppercase tracking-wider block mb-1">{{ __('landing.articles_label') }}</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                {{ __('landing.articles_title') }} <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-400 dark:to-blue-400">{{ __('landing.articles_title_highlight') }}</span>
                {{ __('landing.articles_title_end') }}
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 scroll-reveal scroll-reveal-scale">
            {{-- Featured Card --}}
            <article
                class="lg:col-span-4 bg-white dark:bg-[#131D36] rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                <div class="relative h-64 overflow-hidden bg-slate-100 dark:bg-slate-800">
                    <span
                        class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full bg-white/90 dark:bg-slate-900/90 backdrop-blur text-blue-700 dark:text-cyan-400 text-[11px] font-bold shadow-sm">Artikel</span>
                    <img alt="Perangkat Telemetry Klimatologi Malahayu"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        src="{{ asset('images/articles/malahayu.png') }}" loading="lazy">
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3
                            class="font-bold text-lg text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug">
                            Perangkat Telemetry Klimatologi Malahayu
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2.5 line-clamp-3">
                            Sistem pemantauan cuaca otomatis untuk mengukur data parameter iklim presisi di Malahayu,
                            Kec. Banjarharjo, Kab. Brebes, Jawa Tengah.
                        </p>
                    </div>
                    <div
                        class="pt-6 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <path d="M3 9h18M8 2v3M16 2v3" />
                            </svg>
                            08 Juni 2026
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                            5 mnt baca
                        </span>
                    </div>
                </div>
            </article>

            {{-- Right Column --}}
            <div class="lg:col-span-8 flex flex-col gap-8">
                {{-- Featured Tutorial Card --}}
                <article
                    class="rounded-3xl bg-gradient-to-r from-blue-50/90 via-indigo-50/60 to-slate-50 dark:from-[#16275E] dark:via-indigo-900 dark:to-[#0B1120] text-slate-900 dark:text-white p-6 sm:p-8 flex flex-col sm:flex-row gap-6 items-center shadow-sm hover:shadow-xl border border-blue-200/80 dark:border-white/10 group transition-all duration-300">
                    <div
                        class="w-full sm:w-48 h-40 rounded-2xl overflow-hidden flex-shrink-0 bg-white shadow-inner border border-slate-200/60 dark:border-transparent">
                        <img alt="Installation Guide AWS Higertech"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                            src="{{ asset('images/articles/aws-guide.png') }}" loading="lazy">
                    </div>
                    <div class="flex-1 space-y-3">
                        <span
                            class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 border border-blue-200 dark:bg-cyan-400/20 dark:text-cyan-300 dark:border-cyan-400/30 text-[11px] font-semibold">Tutorial
                            Teknis</span>
                        <h3
                            class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-300 transition">
                            Installation Guide Automatic Weather Station (AWS)
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            Panduan komprehensif penempatan sensor arah angin, pyranometer surya, mast tower penangkal
                            petir, dan grounding tahan uji.
                        </p>
                        <div class="flex items-center gap-6 text-xs text-slate-500 dark:text-slate-300 pt-2 font-mono">
                            <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <path d="M3 9h18M8 2v3M16 2v3" />
                                </svg> 20 Mei 2026</span>
                            <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg> 8 mnt baca</span>
                        </div>
                    </div>
                </article>

                {{-- Bottom 2 cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <article
                        class="bg-white dark:bg-[#131D36] rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                        <div class="relative h-48 overflow-hidden bg-slate-100 dark:bg-slate-800">
                            <span
                                class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full bg-white/90 dark:bg-slate-900/90 backdrop-blur text-blue-700 dark:text-cyan-400 text-[11px] font-bold shadow-sm">Artikel</span>
                            <img alt="Pemasangan Perangkat Telemetri Deli Serdang"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                src="{{ asset('images/articles/deli-serdang.png') }}" loading="lazy">
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <h3
                                class="font-bold text-base text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug">
                                Pemasangan Perangkat TELEMETRI Rumah Gerat
                            </h3>
                            <div
                                class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400 font-mono">
                                <span>08 Juni 2026</span>
                                <span>Deli Serdang</span>
                            </div>
                        </div>
                    </article>

                    <article
                        class="bg-white dark:bg-[#131D36] rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                        <div class="relative h-48 overflow-hidden bg-slate-100 dark:bg-slate-800">
                            <span
                                class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full bg-cyan-500 text-slate-950 text-[11px] font-bold shadow-sm">Video
                                Tutorial</span>
                            <img alt="Tutorial AWLR Sonar Digital"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                src="{{ asset('images/articles/awlr-tutorial.png') }}" loading="lazy">
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <h3
                                class="font-bold text-base text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug">
                                TUTORIAL SETTING DAN RESET LOGGER AWLR SONAR DIGITAL
                            </h3>
                            <div
                                class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400 font-mono">
                                <span>11 Maret 2025</span>
                                <span>Video Panduan</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>
