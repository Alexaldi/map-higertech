<section id="map-section"
    class="py-20 bg-slate-50/50 dark:bg-[#080d19] border-t border-slate-200/80 dark:border-slate-800 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span
                    class="text-blue-600 dark:text-cyan-400 font-bold text-xs uppercase tracking-wider block mb-1">{{ __('landing.map_label') }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    {{ __('landing.map_title') }}</h2>
            </div>
            <div class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ __('landing.map_subtitle') }}</div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- GIS Map Canvas with Real Live Map Preview --}}
            <div
                class="lg:col-span-7 bg-slate-100 dark:bg-[#0c1626] rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-xl relative isolate z-10 min-h-[440px] sm:min-h-[530px] flex flex-col justify-between">
                {{-- Top Overlay Bar --}}
                <div
                    class="absolute top-3 left-3 right-3 sm:top-4 sm:left-4 sm:right-4 z-30 flex items-center justify-between gap-1 sm:gap-2 pointer-events-auto">
                    <div
                        class="flex items-center gap-1 sm:gap-2 bg-white/95 dark:bg-slate-900/90 backdrop-blur-md px-2 py-1.5 sm:px-3.5 sm:py-2 rounded-xl border border-slate-200/90 dark:border-slate-700 text-xs text-slate-800 dark:text-slate-200 shadow-md min-w-0 shrink">
                        <span
                            class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-emerald-500 animate-ping shrink-0"></span>
                        <span
                            class="hidden md:inline font-medium font-mono text-xs truncate">{{ __('landing.map_live_label') }}</span>
                        <span class="hidden md:inline text-slate-300 dark:text-slate-600">|</span>
                        <span id="preview-station-count"
                            class="text-blue-600 dark:text-cyan-300 font-mono font-bold text-[10px] sm:text-[11px] whitespace-nowrap">Memuat
                            pos...</span>
                    </div>
                    <div class="flex items-center gap-1 sm:gap-1.5 shrink-0">
                        <button id="preview-zoom-in" type="button"
                            class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg sm:rounded-xl bg-white/95 dark:bg-slate-900/90 backdrop-blur-md border border-slate-200/90 dark:border-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-cyan-300 transition shadow-xs"
                            title="Perbesar" aria-label="Zoom in">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </button>
                        <button id="preview-zoom-out" type="button"
                            class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg sm:rounded-xl bg-white/95 dark:bg-slate-900/90 backdrop-blur-md border border-slate-200/90 dark:border-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-cyan-300 transition shadow-xs"
                            title="Perkecil" aria-label="Zoom out">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M5 12h14" />
                            </svg>
                        </button>
                        <button id="preview-reset-map" type="button"
                            class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg sm:rounded-xl bg-white/95 dark:bg-slate-900/90 backdrop-blur-md border border-slate-200/90 dark:border-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-cyan-300 transition shadow-xs"
                            title="Reset View" aria-label="Reset View">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4 12a8 8 0 1 0 2.3-5.7L4 8.6" />
                                <path d="M4 4v4.6h4.6" />
                            </svg>
                        </button>
                        <button id="preview-fit-markers" type="button"
                            class="hidden sm:flex w-8 h-8 md:w-9 md:h-9 rounded-lg sm:rounded-xl bg-white/95 dark:bg-slate-900/90 backdrop-blur-md border border-slate-200/90 dark:border-slate-700 text-slate-700 dark:text-slate-200 items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-cyan-300 transition shadow-xs"
                            title="Fit All Markers" aria-label="Fit All Markers">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8 3H3v5m13-5h5v5M8 21H3v-5m18 0v5h-5" />
                                <path d="M9 9h6v6H9z" />
                            </svg>
                        </button>
                        <a href="{{ route('map') }}"
                            class="inline-flex items-center gap-1 px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg sm:rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-[11px] sm:text-xs transition shadow-md"
                            title="Buka Peta Penuh" aria-label="Buka peta live">
                            <span>Peta</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M15 3h6v6M21 3l-7 7M3 21l7-7M9 21H3v-6" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Real Interactive Leaflet Map --}}
                <div id="preview-station-map" class="w-full h-[440px] sm:h-[530px] rounded-3xl relative z-0"
                    data-preview-map></div>

                {{-- Bottom Overlay Legend Bar --}}
                <div
                    class="absolute bottom-3 left-3 right-3 sm:bottom-4 sm:left-4 sm:right-4 z-30 pointer-events-none flex items-center justify-between gap-2 text-xs text-slate-700 dark:text-slate-300 font-mono bg-white/95 dark:bg-slate-950/85 backdrop-blur-md px-3 py-1.5 sm:px-4 sm:py-2.5 rounded-xl sm:rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xl">
                    <div class="flex items-center gap-2.5 sm:gap-4 text-[10px] sm:text-xs">
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-cyan-500"></span> AWLR</span>
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-blue-600"></span> ARR</span>
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-amber-500"></span> AWS</span>
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-rose-500"></span> EWS</span>
                    </div>
                    <span class="hidden sm:inline text-blue-700 dark:text-cyan-400 text-[11px] font-semibold">Live GIS
                        Telemetry •
                        Higertech</span>
                </div>
            </div>

            {{-- Stats --}}
            <div class="lg:col-span-5 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    @php
                        $landingCounts = \Illuminate\Support\Facades\Cache::remember('landing_map_stats', 300, function () {
                            return [
                                'awlr' => \App\Models\Station::whereIn('station_type', ['AWLR', 'AWLR_ARR'])->count(),
                                'arr' => \App\Models\Station::whereIn('station_type', ['ARR', 'AWLR_ARR'])->count(),
                                'aws' => \App\Models\Station::where('station_type', 'AWS')->count(),
                                'agencies' => \App\Models\Station::whereNotNull('balai_name')->distinct()->count('balai_name'),
                            ];
                        });

                        $awlrCount = ($landingCounts['awlr'] ?? 0) > 0 ? $landingCounts['awlr'] . '+' : '500+';
                        $arrCount = ($landingCounts['arr'] ?? 0) > 0 ? $landingCounts['arr'] . '+' : '300+';
                        $awsCount = ($landingCounts['aws'] ?? 0) > 0 ? $landingCounts['aws'] . '+' : '60+';
                        $agencyCount = ($landingCounts['agencies'] ?? 0) > 0 ? $landingCounts['agencies'] . '+' : '75+';

                        $stats = [
                            [
                                'count' => $awlrCount,
                                'label' => __('landing.map_stat_awlr'),
                                'color' => 'text-blue-600 dark:text-cyan-400',
                                'bg' => 'bg-blue-50 dark:bg-blue-900/40',
                                'icon' => '<path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>',
                            ],
                            [
                                'count' => $arrCount,
                                'label' => __('landing.map_stat_arr'),
                                'color' => 'text-cyan-600 dark:text-cyan-400',
                                'bg' => 'bg-cyan-50 dark:bg-cyan-900/40',
                                'icon' =>
                                    '<path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242M16 14v6M8 14v6M12 16v6"/>',
                            ],
                            [
                                'count' => $awsCount,
                                'label' => __('landing.map_stat_aws'),
                                'color' => 'text-amber-500 dark:text-amber-400',
                                'bg' => 'bg-amber-50 dark:bg-amber-900/40',
                                'icon' =>
                                    '<path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41M12 7a5 5 0 1 0 5 5"/>',
                            ],
                            [
                                'count' => $agencyCount,
                                'label' => __('landing.map_stat_agencies'),
                                'color' => 'text-emerald-500 dark:text-emerald-400',
                                'bg' => 'bg-emerald-50 dark:bg-emerald-900/40',
                                'icon' =>
                                    '<path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18ZM6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2M10 6h4M10 10h4M10 14h4M10 18h4"/>',
                            ],
                        ];
                    @endphp

                    @foreach ($stats as $stat)
                        <div
                            class="rounded-2xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
                            <div
                                class="w-9 h-9 rounded-xl {{ $stat['bg'] }} flex items-center justify-center mb-3 {{ $stat['color'] }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" aria-hidden="true">{!! $stat['icon'] !!}</svg>
                            </div>
                            <div class="text-3xl font-black tracking-tight text-slate-900 dark:text-white font-mono">
                                {{ $stat['count'] }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                                {{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('map') }}"
                    class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-2xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-100 font-semibold text-sm transition">
                    <span>{{ __('landing.map_explore') }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path d="M5 12h14m-7-7 7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
