<section id="hero"
    class="relative pt-10 pb-16 lg:pt-14 lg:pb-24 overflow-hidden bg-gradient-to-b from-[#F0F5FD] via-[#F8FAFC] to-white dark:from-[#080d1a] dark:via-[#0B1120] dark:to-[#0B1120] transition-colors duration-300">
    {{-- Blueprint Grid Background across entire Hero Section --}}
    <div class="absolute inset-0 map-grid-bg pointer-events-none opacity-80 dark:opacity-35"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-8 items-center">

            {{-- Text Content --}}
            <div class="space-y-6">
                <h1
                    class="text-4xl sm:text-5xl lg:text-[48px] font-extrabold tracking-tight leading-[1.15] text-slate-900 dark:text-white">
                    {{ __('landing.hero_title') }}<br>
                    <span class="text-[#16275E] dark:text-cyan-400">{{ __('landing.hero_title_highlight') }}</span>
                </h1>

                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-xl leading-relaxed">
                    {{ __('landing.hero_desc') }}
                </p>


                {{-- CTA Buttons --}}
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ route('products') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white border border-slate-200 dark:border-transparent text-slate-900 font-semibold text-sm hover:bg-slate-50 transition shadow-sm">
                        <span>{{ __('landing.hero_cta_product') }}</span>
                    </a>
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-cyan-400 hover:bg-cyan-500 text-slate-900 font-semibold text-sm transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span>{{ __('landing.hero_cta_contact') }}</span>
                    </a>
                </div>
            </div>

            {{-- Hero Visual Presentation (Clean 3D showcase without card container) --}}
            <div class="relative flex flex-col items-center justify-center">
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
                    <picture>
                        <source srcset="{{ asset('images/products/hero-unit.webp') }}" type="image/webp">
                        <img src="{{ asset('images/products/hero-unit.png') }}"
                            alt="Higertech Telemetry Field Monitoring Unit" width="512" height="384"
                            fetchpriority="high" loading="eager" decoding="async"
                            class="w-full max-h-72 sm:max-h-84 object-contain relative z-10 animate-float-subtle drop-shadow-2xl transition-transform duration-500 hover:scale-105">
                    </picture>
                </div>
            </div>
        </div>
</section>
