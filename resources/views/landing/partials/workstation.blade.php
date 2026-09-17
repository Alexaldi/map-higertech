<section id="workstation"
    class="py-20 bg-slate-50/70 dark:bg-[#0E1628] border-y border-slate-200/80 dark:border-slate-800 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6 scroll-reveal">
            <div>
                <span
                    class="text-blue-600 dark:text-cyan-400 font-bold text-xs uppercase tracking-wider block mb-1">{{ __('landing.ws_label') }}</span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ __('landing.ws_title') }}</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('landing.ws_desc') }}</p>
            </div>
            <a href="#contact"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#16275E] hover:bg-blue-800 dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 text-xs font-bold transition shadow-sm shrink-0">
                <span>{{ __('landing.ws_download') }}</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path d="M12 17V3M6 11l6 6 6-6M19 21H5" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">

            {{-- LEFT: Data Logger Card --}}
            <div
                class="lg:col-span-5 rounded-3xl bg-white dark:bg-[#131D36] border-2 border-blue-500/40 dark:border-cyan-500/50 p-6 sm:p-7 flex flex-col justify-between shadow-xl relative overflow-hidden group hover:border-blue-600 dark:hover:border-cyan-400 transition-all duration-300 scroll-reveal scroll-reveal-scale">
                <div
                    class="absolute -top-24 -right-24 w-60 h-60 bg-gradient-to-br from-cyan-500/10 via-blue-600/15 to-transparent rounded-full blur-2xl pointer-events-none group-hover:scale-110 transition duration-500">
                </div>
                <div
                    class="absolute top-0 right-0 px-4 py-1.5 bg-gradient-to-l from-[#16275E] via-blue-700 to-cyan-500 text-white text-[11px] font-mono font-bold rounded-bl-2xl tracking-wider shadow-md flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-300 animate-pulse"></span>
                    <span>CENTRAL RTU CORE</span>
                </div>

                <div>
                    <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-slate-400 mb-3">
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            ONLINE 24/7
                        </span>
                        <span class="text-[11px] font-medium text-slate-600 dark:text-slate-300">HG-LOG900 Pro</span>
                    </div>
                    <h3
                        class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight leading-snug">
                        {{ __('landing.ws_logger_title') }}</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-2.5 leading-relaxed">
                        {{ __('landing.ws_logger_desc') }}</p>

                    {{-- Product Image Stage --}}
                    <div
                        class="my-5 p-5 rounded-2xl bg-gradient-to-b from-slate-100/90 via-slate-50 to-blue-50/40 dark:from-[#0c1626] dark:via-[#09101d] dark:to-[#080d19] border border-slate-200/90 dark:border-slate-800 relative overflow-hidden shadow-inner flex flex-col items-center justify-center min-h-[200px]">
                        <div class="w-full flex items-center justify-between relative z-10 mb-2">
                            <div
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-900/80 backdrop-blur text-white text-[10px] font-mono border border-white/10">
                                <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="4" y="4" width="16" height="16" rx="2" />
                                    <rect x="8" y="8" width="8" rx="1" height="8" />
                                    <path
                                        d="M12 20v2M12 2v2M17 20v2M17 2v2M2 12h2M2 17h2M2 7h2M20 12h2M20 17h2M20 7h2M7 20v2M7 2v2" />
                                </svg>
                                <span>SCHEMATIC V4.2</span>
                            </div>
                            <span
                                class="text-[10px] font-mono px-2 py-0.5 rounded bg-blue-500/10 text-blue-700 dark:text-cyan-300 font-semibold border border-blue-500/20">Dual
                                Core 32-Bit MCU</span>
                        </div>
                        <picture>
                            <source srcset="{{ asset('images/products/hg-log900.webp') }}" type="image/webp">
                            <img src="{{ asset('images/products/hg-log900.png') }}"
                                alt="Data Logger Multi Sensor HG-LOG900" width="400" height="240"
                                class="w-full h-56 sm:h-60 object-contain drop-shadow-2xl relative z-10 group-hover:scale-105 transition-transform duration-500 ease-out"
                                loading="lazy" decoding="async">
                        </picture>
                        <div class="w-3/4 h-3 bg-black/10 dark:bg-black/40 rounded-full blur-md -mt-1"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5 text-xs font-mono">
                        <div
                            class="bg-slate-100/90 dark:bg-[#0c1626] p-3 rounded-2xl border border-slate-200/90 dark:border-slate-800 hover:border-cyan-400/40 transition">
                            <div class="flex items-center justify-between mb-1">
                                <span
                                    class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400">Universal
                                    Bus</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                            </div>
                            <span class="font-bold text-slate-900 dark:text-cyan-300 text-xs block">RS485 / Modbus RTU /
                                SDI-12</span>
                        </div>
                        <div
                            class="bg-slate-100/90 dark:bg-[#0c1626] p-3 rounded-2xl border border-slate-200/90 dark:border-slate-800 hover:border-cyan-400/40 transition">
                            <div class="flex items-center justify-between mb-1">
                                <span
                                    class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400">Telemetry
                                    Uplink</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            </div>
                            <span class="font-bold text-slate-900 dark:text-cyan-300 text-xs block">4G LTE / GSM &
                                Satellite</span>
                        </div>
                    </div>
                </div>

                <div
                    class="pt-5 mt-5 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div
                        class="flex items-center gap-1.5 text-xs font-mono font-bold text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m16 9-5.5 5.5L8 12" />
                        </svg>
                        <span>MPPT Solar Charger Built-in</span>
                    </div>
                    <a href="#contact"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#16275E] hover:bg-blue-800 dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 text-xs font-bold transition shadow-sm">
                        <span>{{ __('landing.ws_cta_logger') }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M5 12h14m-7-7 7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- RIGHT: 2x2 Grid --}}
            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5 scroll-reveal scroll-reveal-delay-1">

                {{-- AWLR --}}
                <div
                    class="rounded-3xl p-5 sm:p-6 bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-800 shadow-md hover:shadow-xl hover:border-cyan-500 dark:hover:border-cyan-400 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                    <div
                        class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-cyan-400 to-blue-600 opacity-80 group-hover:opacity-100 transition">
                    </div>
                    <div>
                        <div
                            class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 dark:border-slate-800 text-xs font-mono">
                            <div class="flex items-center gap-2">
                                <span
                                    class="w-7 h-7 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center border border-cyan-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M2 12h20M2 12a10 10 0 0 1 10-10M2 12a10 10 0 0 0 10 10M12 2a10 10 0 0 1 10 10M12 22a10 10 0 0 0 10-10" />
                                    </svg>
                                </span>
                                <div>
                                    <span class="font-bold text-cyan-800 dark:text-cyan-300 block text-[11px]">AWLR
                                        RADAR / SONAR</span>
                                    <span class="text-[9px] text-slate-400">Standar Ditjen SDA</span>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full bg-cyan-50 dark:bg-cyan-950/70 text-cyan-800 dark:text-cyan-300 text-[10px] font-bold font-mono border border-cyan-300 dark:border-cyan-800">0-35m
                                Range</span>
                        </div>
                        <h4
                            class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug">
                            {{ __('landing.ws_awlr_title') }}</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                            {{ __('landing.ws_awlr_desc') }}</p>
                    </div>
                    <div
                        class="mt-4 pt-3.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                        <div
                            class="w-24 h-24 sm:w-28 sm:h-24 bg-gradient-to-b from-cyan-50/50 via-slate-50 to-slate-100 dark:from-[#0c1626] dark:via-[#09101d] dark:to-[#080d19] rounded-2xl p-1.5 flex items-center justify-center border border-slate-200/80 dark:border-slate-800 flex-shrink-0 group-hover:border-cyan-400/50 transition">
                            <picture>
                                <source srcset="{{ asset('images/products/awlr.webp') }}" type="image/webp">
                                <img src="{{ asset('images/products/awlr.png') }}" alt="AWLR Sensor Higertech"
                                    width="112" height="96"
                                    class="max-h-full max-w-full object-contain drop-shadow-md group-hover:scale-110 transition duration-300"
                                    loading="lazy" decoding="async">
                            </picture>
                        </div>
                        <div class="text-right text-[11px] font-mono space-y-0.5 flex-1">
                            <div class="font-bold text-slate-900 dark:text-white">Akurasi: ±2mm</div>
                            <div class="text-slate-500 dark:text-slate-400 text-[10px]">Output: Modbus RTU</div>
                            <span
                                class="inline-block mt-1 px-2 py-0.5 rounded-md bg-cyan-100 dark:bg-cyan-950/60 text-cyan-800 dark:text-cyan-300 text-[9px] font-extrabold border border-cyan-300 dark:border-cyan-700">E-Katalog
                                INAPROC</span>
                        </div>
                    </div>
                </div>

                {{-- ARR --}}
                <div
                    class="rounded-3xl p-5 sm:p-6 bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-800 shadow-md hover:shadow-xl hover:border-blue-500 dark:hover:border-blue-400 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                    <div
                        class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 opacity-80 group-hover:opacity-100 transition">
                    </div>
                    <div>
                        <div
                            class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 dark:border-slate-800 text-xs font-mono">
                            <div class="flex items-center gap-2">
                                <span
                                    class="w-7 h-7 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center border border-blue-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242M16 14v6M8 14v6M12 16v6" />
                                    </svg>
                                </span>
                                <div>
                                    <span class="font-bold text-blue-700 dark:text-blue-300 block text-[11px]">ARR
                                        TIPPING BUCKET</span>
                                    <span class="text-[9px] text-slate-400">Standar BMKG & WMO</span>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 text-[10px] font-bold font-mono border border-blue-200 dark:border-blue-800">Orifice
                                200mm</span>
                        </div>
                        <h4
                            class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug">
                            {{ __('landing.ws_arr_title') }}</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                            {{ __('landing.ws_arr_desc') }}</p>
                    </div>
                    <div
                        class="mt-4 pt-3.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                        <div
                            class="w-24 h-24 sm:w-28 sm:h-24 bg-gradient-to-b from-blue-50/50 via-slate-50 to-slate-100 dark:from-[#0c1626] dark:via-[#09101d] dark:to-[#080d19] rounded-2xl p-1.5 flex items-center justify-center border border-slate-200/80 dark:border-slate-800 flex-shrink-0 group-hover:border-blue-400/50 transition">
                            <picture>
                                <source srcset="{{ asset('images/products/arr.webp') }}" type="image/webp">
                                <img src="{{ asset('images/products/arr.png') }}" alt="ARR Sensor Higertech"
                                    width="112" height="96"
                                    class="max-h-full max-w-full object-contain drop-shadow-md group-hover:scale-110 transition duration-300"
                                    loading="lazy" decoding="async">
                            </picture>
                        </div>
                        <div class="text-right text-[11px] font-mono space-y-0.5 flex-1">
                            <div class="font-bold text-slate-900 dark:text-white">Resolusi: 0.5 mm</div>
                            <div class="text-slate-500 dark:text-slate-400 text-[10px]">SS 304 Anti-Karat</div>
                            <span
                                class="inline-block mt-1 px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-[9px] font-extrabold border border-emerald-300 dark:border-emerald-700">Field
                                Calibrated</span>
                        </div>
                    </div>
                </div>

                {{-- AWS --}}
                <div
                    class="rounded-3xl p-5 sm:p-6 bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-800 shadow-md hover:shadow-xl hover:border-indigo-500 dark:hover:border-indigo-400 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                    <div
                        class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-sky-400 opacity-80 group-hover:opacity-100 transition">
                    </div>
                    <div>
                        <div
                            class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 dark:border-slate-800 text-xs font-mono">
                            <div class="flex items-center gap-2">
                                <span
                                    class="w-7 h-7 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center border border-indigo-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2M9.6 4.6A2 2 0 1 1 11 8H2M12.6 19.4A2 2 0 1 0 14 16H2" />
                                    </svg>
                                </span>
                                <div>
                                    <span class="font-bold text-indigo-700 dark:text-indigo-300 block text-[11px]">AWS
                                        KLIMATOLOGI</span>
                                    <span class="text-[9px] text-slate-400">All-in-One Station</span>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 text-[10px] font-bold font-mono border border-indigo-200 dark:border-indigo-800">Tower
                                10 Meter</span>
                        </div>
                        <h4
                            class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug">
                            {{ __('landing.ws_aws_title') }}</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                            {{ __('landing.ws_aws_desc') }}</p>
                    </div>
                    <div
                        class="mt-4 pt-3.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                        <div
                            class="w-24 h-24 sm:w-28 sm:h-24 bg-gradient-to-b from-indigo-50/50 via-slate-50 to-slate-100 dark:from-[#0c1626] dark:via-[#09101d] dark:to-[#080d19] rounded-2xl p-1.5 flex items-center justify-center border border-slate-200/80 dark:border-slate-800 flex-shrink-0 group-hover:border-indigo-400/50 transition">
                            <picture>
                                <source srcset="{{ asset('images/products/aws.webp') }}" type="image/webp">
                                <img src="{{ asset('images/products/aws.png') }}" alt="AWS Stasiun Cuaca Higertech"
                                    width="112" height="96"
                                    class="max-h-full max-w-full object-contain drop-shadow-md group-hover:scale-110 transition duration-300"
                                    loading="lazy" decoding="async">
                            </picture>
                        </div>
                        <div class="text-right text-[11px] font-mono space-y-0.5 flex-1">
                            <div class="font-bold text-slate-900 dark:text-white">7 Parameter Cuaca</div>
                            <div class="text-slate-500 dark:text-slate-400 text-[10px]">Ultrasonic Wind 360°</div>
                            <span
                                class="inline-block mt-1 px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-cyan-300 text-[9px] font-extrabold border border-blue-300 dark:border-blue-700">SDA
                                & Pertanian</span>
                        </div>
                    </div>
                </div>

                {{-- EWS --}}
                <div
                    class="rounded-3xl p-5 sm:p-6 bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-800 shadow-md hover:shadow-xl hover:border-red-500 dark:hover:border-red-400 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                    <div
                        class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 to-amber-500 opacity-80 group-hover:opacity-100 transition">
                    </div>
                    <div>
                        <div
                            class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 dark:border-slate-800 text-xs font-mono">
                            <div class="flex items-center gap-2">
                                <span
                                    class="w-7 h-7 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 flex items-center justify-center border border-red-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                                    </svg>
                                </span>
                                <div>
                                    <span class="font-bold text-red-600 dark:text-red-400 block text-[11px]">EWS
                                        PERINGATAN BANJIR</span>
                                    <span class="text-[9px] text-slate-400">Mitigasi Hulu Sungai</span>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-300 text-[10px] font-bold font-mono border border-red-200 dark:border-red-800">120dB
                                Siren</span>
                        </div>
                        <h4
                            class="text-base font-bold text-slate-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400 transition leading-snug">
                            {{ __('landing.ws_ews_title') }}</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                            {{ __('landing.ws_ews_desc') }}</p>
                    </div>
                    <div
                        class="mt-4 pt-3.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                        <div
                            class="w-24 h-24 sm:w-28 sm:h-24 bg-gradient-to-b from-red-50/50 via-slate-50 to-slate-100 dark:from-[#0c1626] dark:via-[#09101d] dark:to-[#080d19] rounded-2xl p-1.5 flex items-center justify-center border border-slate-200/80 dark:border-slate-800 flex-shrink-0 group-hover:border-red-400/50 transition">
                            <picture>
                                <source srcset="{{ asset('images/products/ews.webp') }}" type="image/webp">
                                <img src="{{ asset('images/products/ews.png') }}"
                                    alt="EWS Dam Alarm System Higertech" width="112" height="96"
                                    class="max-h-full max-w-full object-contain drop-shadow-md group-hover:scale-110 transition duration-300"
                                    loading="lazy" decoding="async">
                            </picture>
                        </div>
                        <div class="text-right text-[11px] font-mono space-y-0.5 flex-1">
                            <div class="font-bold text-red-600 dark:text-red-400">Strobe & Horn 120 dB</div>
                            <div class="text-slate-500 dark:text-slate-400 text-[10px]">Otomatis Level Air</div>
                            <span
                                class="inline-block mt-1 px-2 py-0.5 rounded-md bg-red-100 dark:bg-red-950/60 text-red-700 dark:text-red-300 text-[9px] font-extrabold border border-red-300 dark:border-red-800">Mitigasi
                                Bencana</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
