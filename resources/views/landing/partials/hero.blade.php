<section id="hero"
    class="relative pt-10 pb-16 lg:pt-14 lg:pb-24 overflow-hidden bg-gradient-to-b from-[#F0F5FD] via-[#F8FAFC] to-white dark:from-[#080d1a] dark:via-[#0B1120] dark:to-[#0B1120] transition-colors duration-300">
    {{-- Blueprint Grid Background across entire Hero Section --}}
    <div class="absolute inset-0 map-grid-bg pointer-events-none opacity-80 dark:opacity-35"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-8 items-center">

            {{-- Text Content --}}
            <div class="space-y-6 scroll-reveal">
                <h1
                    class="text-4xl sm:text-5xl lg:text-[48px] font-extrabold tracking-tight leading-[1.15] text-slate-900 dark:text-white">
                    {{ __('landing.hero_title') }}<br>
                    <span class="text-[#16275E] dark:text-cyan-400">{{ __('landing.hero_title_highlight') }}</span>
                </h1>

                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-xl leading-relaxed">
                    {{ __('landing.hero_desc') }}
                </p>

                {{-- Stats Grid --}}
                <div
                    class="grid grid-cols-3 gap-2 p-3 rounded-xl bg-white/80 dark:bg-[#131D36]/80 backdrop-blur-sm border border-slate-200/90 dark:border-slate-700 text-xs font-mono max-w-lg shadow-xs">
                    <div>
                        <div class="text-[10px] uppercase text-slate-500 dark:text-slate-400">
                            {{ __('landing.hero_stat_uptime') }}</div>
                        <div class="font-bold text-slate-900 dark:text-emerald-400 text-sm">99.85%</div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase text-slate-500 dark:text-slate-400">
                            {{ __('landing.hero_stat_sensor') }}</div>
                        <div class="font-bold text-slate-900 dark:text-white text-sm">1,240+ Unit</div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase text-slate-500 dark:text-slate-400">
                            {{ __('landing.hero_stat_protocol') }}</div>
                        <div class="font-bold text-slate-900 dark:text-cyan-400 text-sm">MQTT / MODBUS</div>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="#workstation"
                        class="inline-flex items-center gap-2.5 px-6 py-3 rounded-lg bg-[#16275E] hover:bg-blue-800 text-white font-bold text-sm transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path
                                d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83zM2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17" />
                        </svg>
                        <span>{{ __('landing.hero_cta_workstation') }}</span>
                    </a>
                    <a href="#internship"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 font-semibold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition shadow-2xs">
                        <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                            <path d="M22 10v6M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
                        </svg>
                        <span>{{ __('landing.hero_cta_internship') }}</span>
                    </a>
                </div>
            </div>

            {{-- Hero Visual Presentation (Clean 3D showcase without card container) --}}
            <div class="relative flex flex-col items-center justify-center scroll-reveal scroll-reveal-delay-1">
                {{-- Ambient Background Glow behind 3D Unit --}}
                <div
                    class="absolute -top-10 w-72 h-72 sm:w-80 sm:h-80 bg-cyan-500/15 dark:bg-cyan-500/15 rounded-full blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute top-16 w-72 h-72 sm:w-80 sm:h-80 bg-blue-600/15 dark:bg-blue-600/15 rounded-full blur-3xl pointer-events-none">
                </div>

                {{-- Concentric Radar Rings behind the 3D unit --}}
                <div class="relative flex items-center justify-center w-full max-w-lg py-2 sm:py-4">
                    <div
                        class="absolute w-60 h-60 sm:w-72 sm:h-72 rounded-full border border-blue-500/15 dark:border-cyan-400/15 pointer-events-none">
                    </div>
                    <div
                        class="absolute w-80 h-80 sm:w-96 sm:h-96 rounded-full border border-blue-500/10 dark:border-cyan-400/10 pointer-events-none">
                    </div>

                    {{-- Floating 3D Graphic with smooth CSS float animation --}}
                    <img src="{{ asset('images/products/hero-unit.png') }}"
                        alt="Higertech Telemetry Field Monitoring Unit"
                        class="w-full max-h-72 sm:max-h-84 object-contain relative z-10 animate-float-subtle drop-shadow-2xl transition-transform duration-500 hover:scale-105">
                </div>
            </div>
        </div>
</section>
