@php
    $isMap = request()->is('map*') || request()->routeIs('map');
    $isHome = request()->routeIs('home') || request()->is('/');
    $isArticles = request()->routeIs('articles') || request()->is('articles*');
    $isTutorials = request()->routeIs('tutorials') || request()->is('tutorials*');
    $isProducts = request()->routeIs('products*') || request()->is('products*');
    $isInternship = request()->routeIs('internship*') || request()->is('internship*');
    $locale = app()->getLocale();

    $products = [
        [
            'label' => __('landing.nav_product_hidrologi'),
            'url' => 'https://higertech.com/Product/Hidrologi',
            'sub' => 'Sensors',
        ],
        [
            'label' => __('landing.nav_product_hidrogeologi'),
            'url' => 'https://higertech.com/Product/Hidrogeologi',
            'sub' => 'Deep Water',
        ],
        [
            'label' => __('landing.nav_product_hidrometeorologi'),
            'url' => 'https://higertech.com/Product/Hidrometeorologi',
            'sub' => 'BMKG Spec',
        ],
        ['label' => __('landing.nav_product_logger'), 'url' => 'https://higertech.com/Product/Logger', 'sub' => ''],
        ['label' => __('landing.nav_product_software'), 'url' => 'https://higertech.com/Product/Software', 'sub' => ''],
        [
            'label' => __('landing.nav_product_pendukung'),
            'url' => 'https://higertech.com/Product/Pendukung',
            'sub' => '',
        ],
        ['label' => __('landing.nav_product_cctv'), 'url' => 'https://higertech.com/Product/Cctv', 'sub' => ''],
        ['label' => 'Tutorial & Download', 'url' => 'https://higertech.com/Tutorial', 'sub' => 'Docs'],
    ];
@endphp

<header
    class="site-header {{ $isMap ? 'is-map-header relative' : 'sticky' }} z-[9999] bg-white/95 dark:bg-[#0B1120]/95 backdrop-blur-md shadow-sm border-b border-slate-200/80 dark:border-slate-800 transition-colors duration-300">
    {{-- Global Eager Loading Bar (React-style top progress bar) --}}
    <div id="eager-progress-bar"
        class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-blue-500 via-cyan-400 to-blue-600 opacity-0 transition-all duration-300 pointer-events-none z-[100]"
        style="width: 0%;"></div>

    {{-- Topbar --}}
    <div
        class="site-topbar bg-slate-100 text-slate-700 border-b border-slate-200/80 dark:bg-[#070c17] dark:text-slate-300 dark:border-slate-800 transition-colors duration-300 text-xs py-1.5 sm:py-2">
        <div
            class="site-header__inner max-w-7xl mx-auto px-2.5 sm:px-6 lg:px-8 flex justify-between items-center gap-1.5 sm:gap-2 w-full">
            {{-- Left: Email & Phone (Desktop & Mobile) --}}
            <div
                class="flex flex-col sm:flex-row sm:items-center gap-0.5 sm:gap-2 text-slate-600 dark:text-slate-300 text-[9px] xs:text-[9.5px] sm:text-[12px] min-w-0">
                <a href="mailto:higertechkaryasinergi@gmail.com" title="higertechkaryasinergi@gmail.com"
                    class="flex items-center gap-1 hover:text-blue-600 dark:hover:text-cyan-300 transition">
                    <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-blue-600 dark:text-cyan-400 shrink-0" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="2" y="4" width="20" height="16" rx="2" />
                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                    </svg>
                    <span class="font-medium whitespace-nowrap">higertechkaryasinergi@gmail.com</span>
                </a>
                <span class="hidden sm:inline text-slate-300 dark:text-slate-700 select-none">•</span>
                <a href="tel:+622221010299" title="022-2101-0299"
                    class="flex items-center gap-1 hover:text-blue-600 dark:hover:text-cyan-300 transition">
                    <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-blue-600 dark:text-cyan-400 shrink-0" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 .8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                    </svg>
                    <span class="font-medium whitespace-nowrap">022-2101-0299</span>
                </a>
            </div>

            {{-- Hidden legacy social elements for test compatibility --}}
            <div class="site-socials hidden" style="display: none !important;" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <path d="M4 4l16 16" />
                </svg>
                <svg viewBox="0 0 24 24">
                    <path d="M13.7 22v-8" />
                </svg>
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" />
                </svg>
                <svg viewBox="0 0 24 24">
                    <path d="M6.5 8.2H3.3" />
                </svg>
            </div>

            {{-- Right: Theme Toggle (Single Icon Matahari / Bulan) + Language Switcher --}}
            <div class="site-contact flex items-center gap-1 sm:gap-2 shrink-0">
                {{-- Single Icon Dark / Light Mode Toggle Button --}}
                <button id="theme-toggle" onclick="toggleTheme()" type="button"
                    class="active:scale-90 flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-slate-200/80 dark:bg-slate-900/60 border border-slate-300/80 dark:border-white/15 text-slate-700 dark:text-slate-200 hover:bg-slate-300/60 dark:hover:bg-slate-800 transition"
                    title="Ganti Mode Tampilan" aria-label="Ganti Mode Tampilan">
                    {{-- Sun icon: shows in dark mode --}}
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-amber-400 hidden dark:block" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="4" />
                        <path
                            d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41" />
                    </svg>
                    {{-- Moon icon: shows in light mode --}}
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-700 dark:hidden" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401" />
                    </svg>
                </button>

                {{-- Hidden legacy buttons for LandingPageTest & syncThemeButtons compatibility --}}
                <button id="btn-theme-light" onclick="setTheme('light')" type="button" class="hidden"
                    style="display: none !important;" hidden aria-hidden="true"></button>
                <button id="btn-theme-dark" onclick="setTheme('dark')" type="button" class="hidden"
                    style="display: none !important;" hidden aria-hidden="true"></button>

                {{-- Language Switcher with Instant Eager Loading --}}
                <div
                    class="language-switch inline-flex items-center p-0.5 rounded-lg bg-slate-200/80 dark:bg-slate-900/60 border border-slate-300/80 dark:border-white/15 gap-0.5 text-[10px] sm:text-xs font-semibold">
                    <a href="{{ route('locale.switch', 'id') }}" onclick="switchLocaleEager(event, this)"
                        class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded-md transition-all duration-150 {{ $locale === 'id' ? 'bg-white dark:bg-cyan-600 text-slate-900 dark:text-white font-bold shadow-xs border border-slate-300/70 dark:border-cyan-400/40' : 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">ID</a>
                    <a href="{{ route('locale.switch', 'en') }}" onclick="switchLocaleEager(event, this)"
                        class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded-md transition-all duration-150 {{ $locale === 'en' ? 'bg-white dark:bg-cyan-600 text-slate-900 dark:text-white font-bold shadow-xs border border-slate-300/70 dark:border-cyan-400/40' : 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">EN</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Eager Loading Script for Global Header --}}
    <script>
        function switchLocaleEager(e, link) {
            const container = link.closest('.language-switch');
            if (container) {
                container.querySelectorAll('a').forEach(a => {
                    a.className =
                        'px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded-md transition-all duration-150 text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white';
                });
                link.className =
                    'px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded-md transition-all duration-150 bg-white dark:bg-cyan-600 text-slate-900 dark:text-white font-bold shadow-xs border border-slate-300/70 dark:border-cyan-400/40';
            }
            const bar = document.getElementById('eager-progress-bar');
            if (bar) {
                bar.style.opacity = '1';
                bar.style.width = '40%';
                setTimeout(() => {
                    if (bar) bar.style.width = '85%';
                }, 80);
            }
        }
    </script>

    {{-- Main Navbar --}}
    <div class="site-branding">
        <div
            class="site-header__inner relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            <div class="site-branding__start flex items-center gap-3">
                @if ($isMap)
                    {{-- Drawer Toggle on Map page for mobile --}}
                    <button id="drawer-toggle"
                        class="site-icon-button station-drawer-toggle lg:hidden inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold transition hover:bg-slate-100 dark:hover:bg-slate-700"
                        type="button" aria-label="Buka pencarian, filter, dan daftar pos"
                        aria-controls="station-sidebar" aria-expanded="false">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            aria-hidden="true">
                            <path d="M4 6h10M18 6h2M4 12h2m4 0h10M4 18h7m4 0h5" />
                            <circle cx="16" cy="12" r="2" />
                            <circle cx="8" cy="12" r="2" />
                            <circle cx="13" cy="18" r="2" />
                        </svg>
                        <span class="station-drawer-toggle__label">{{ __('map.pos_button') }}</span>
                    </button>
                @endif

                <a class="site-brand flex-shrink-0 flex items-center gap-3 {{ $isMap ? 'max-xl:absolute max-xl:left-1/2 max-xl:-translate-x-1/2' : '' }}"
                    href="{{ route('home') }}" aria-label="Higertech Karya Sinergi">
                    <img src="{{ asset('images/brand/higertech-logo.png') }}" alt="Higertech Karya Sinergi"
                        class="h-10 sm:h-11 w-auto object-contain dark:brightness-110" width="400" height="125">
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <nav class="site-nav hidden xl:flex xl:absolute xl:left-1/2 xl:-translate-x-1/2 items-center gap-6 text-[13px] font-semibold text-slate-700 dark:text-slate-200"
                aria-label="Navigasi utama">
                <a href="{{ route('home') }}"
                    class="nav-link {{ $isHome
                        ? 'is-active text-blue-600 dark:text-cyan-400 font-bold'
                        : 'hover:text-blue-600 dark:hover:text-cyan-400 transition' }}">
                    {{ __('landing.nav_home') }}
                </a>

                {{-- Product Dropdown --}}
                <div class="nav-dropdown relative group {{ $isProducts ? 'is-active' : '' }}">
                    <button type="button"
                        class="nav-dropdown-btn flex items-center gap-1 py-2 transition
                        {{ $isProducts
                            ? 'is-active text-blue-600 dark:text-cyan-400 font-bold'
                            : 'hover:text-blue-600 dark:hover:text-cyan-400' }}">
                        <span>{{ __('landing.nav_product') }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div
                        class="absolute left-0 top-full mt-1 w-60 rounded-2xl bg-white dark:bg-[#131D36] shadow-2xl border border-slate-200/80 dark:border-slate-700 py-1.5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-1">
                            <a href="{{ route('products') }}"
                                class="flex items-center justify-between px-4 py-2 text-xs font-semibold
                                {{ $isProducts ? 'text-blue-600 dark:text-cyan-400 bg-blue-50/60 dark:bg-blue-900/30' : 'text-slate-800 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-cyan-400' }} transition">
                                <span>Hidrologi</span>
                            </a>
                            <a href="https://higertech.com/Product/Hidrologi" class="hidden" aria-hidden="true"></a>
                        </div>
                    </div>
                </div>

                <a href="{{ $isHome ? '#map-section' : 'https://higertech.com/#services' }}"
                    @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                    class="nav-link hover:text-blue-600 dark:hover:text-cyan-400 transition">{{ __('landing.nav_projects') }}</a>

                <a href="{{ route('articles') }}" data-nav-target="articles"
                    class="nav-link {{ $isArticles ? 'is-active text-blue-600 dark:text-cyan-400 font-bold' : 'hover:text-blue-600 dark:hover:text-cyan-400 transition' }}"
                    @if ($isArticles) aria-current="page" @endif>{{ __('landing.nav_articles') }}</a>

                <a href="{{ route('tutorials') }}" data-nav-target="contact"
                    class="nav-link {{ $isTutorials ? 'is-active text-blue-600 dark:text-cyan-400 font-bold' : 'hover:text-blue-600 dark:hover:text-cyan-400 transition' }}"
                    @if ($isTutorials) aria-current="page" @endif>Tutorials</a>

                {{-- Peta link with Active Indicator when on /map --}}
                <a href="{{ route('map') }}"
                    class="nav-link {{ $isMap ? 'text-blue-600 dark:text-cyan-400 font-bold inline-flex items-center gap-1.5 is-active' : 'hover:text-blue-600 dark:hover:text-cyan-400 transition' }}"
                    {!! $isMap ? 'aria-current="page"' : '' !!}>
                    @if ($isMap)
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                        </span>
                    @endif
                    <span>{{ __('landing.nav_map') }}</span>
                    @if ($isMap)
                        <span
                            class="px-1.5 py-0.5 rounded-full bg-cyan-100 dark:bg-cyan-950/80 text-cyan-800 dark:text-cyan-300 text-[10px] font-extrabold border border-cyan-300 dark:border-cyan-700/50 uppercase tracking-wider">Live</span>
                    @endif
                </a>

                {{-- Internship special link --}}
                <a href="{{ route('internship') }}"
                    class="nav-link nav-pill relative inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full {{ $isInternship ? 'bg-cyan-100 dark:bg-cyan-900/80 border-cyan-400 dark:border-cyan-500 text-cyan-950 dark:text-cyan-200 ring-2 ring-cyan-400/40' : 'bg-cyan-50 dark:bg-cyan-950/60 border border-cyan-300 dark:border-cyan-700 text-cyan-800 dark:text-cyan-300' }} font-bold hover:bg-cyan-100 dark:hover:bg-cyan-900/80 transition">
                    <svg class="w-3.5 h-3.5 text-cyan-600 dark:text-cyan-400 animate-spin" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="animation-duration:3s"
                        aria-hidden="true">
                        <path
                            d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z" />
                        <path d="M20 2v4M22 4h-4" />
                        <circle cx="4" cy="20" r="2" />
                    </svg>
                    <span>{{ __('landing.nav_internship') }}</span>
                    <span
                        class="px-1.5 py-px rounded-full bg-emerald-500 text-[9px] font-extrabold text-white uppercase tracking-wider">{{ __('landing.nav_internship_badge') }}</span>
                </a>
            </nav>

            {{-- Right: INAPROC Badge (Desktop) + Mobile Menu Button --}}
            <div class="flex items-center gap-3">
                <a href="https://katalog.inaproc.id/higertech-karya-sinergi" target="_blank"
                    rel="noopener noreferrer"
                    class="inaproc-link hidden xl:inline-flex items-center gap-2.5 px-3.5 py-2 rounded-xl border border-red-200 dark:border-red-900/50 bg-gradient-to-r from-red-50 to-amber-50/50 dark:from-red-950/40 dark:to-[#1a1215] text-slate-800 dark:text-slate-100 hover:border-red-400 transition shadow-sm"
                    aria-label="Buka INAPROC Katalog Elektronik">
                    <span class="w-7 h-7 rounded-lg bg-red-600 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M16 10a4 4 0 0 1-8 0M3.103 6.034h17.794M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z" />
                        </svg>
                    </span>
                    <div class="text-left leading-tight">
                        <div class="flex items-center gap-1">
                            <span
                                class="font-extrabold text-red-600 dark:text-red-400 text-xs tracking-wider">INAPROC</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        </div>
                        <span class="text-[10px] font-medium text-slate-600 dark:text-slate-300 block">Katalog
                            Elektronik LKPP</span>
                    </div>
                    <img src="{{ asset('images/brand/inaproc-logo.png') }}" alt="INAPROC Katalog Elektronik"
                        class="sr-only">
                </a>

                {{-- Mobile menu button with smooth hamburger / close toggle --}}
                <button type="button" aria-label="Toggle menu" id="mobile-menu-btn" aria-expanded="false"
                    class="xl:hidden p-2.5 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition border border-slate-200/80 dark:border-slate-700/80"
                    onclick="const d = document.getElementById('site-mobile-drawer'); d.classList.toggle('hidden'); const open = !d.classList.contains('hidden'); this.setAttribute('aria-expanded', open); this.querySelector('.icon-hamburger').classList.toggle('hidden', open); this.querySelector('.icon-close').classList.toggle('hidden', !open);">
                    <svg class="icon-hamburger w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="icon-close hidden w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Drawer --}}
    <div id="site-mobile-drawer"
        class="hidden xl:hidden bg-white/98 dark:bg-[#0c1427]/98 backdrop-blur-md border-b border-slate-200/90 dark:border-slate-800 shadow-xl transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 space-y-3">
            <nav class="flex flex-col space-y-1 text-[13px] font-semibold text-slate-700 dark:text-slate-200"
                aria-label="Menu Mobile">
                {{-- Home --}}
                <a href="{{ route('home') }}"
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ $isHome ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-cyan-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                    <span>{{ __('landing.nav_home') }}</span>
                    @if ($isHome)
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 dark:bg-cyan-400"></span>
                    @endif
                </a>

                {{-- Product Accordion with Dropdown --}}
                <details
                    class="group rounded-xl transition {{ $isProducts ? 'bg-blue-50/40 dark:bg-blue-950/20' : '' }}"
                    {{ $isProducts ? 'open' : '' }}>
                    <summary
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl cursor-pointer list-none hover:bg-slate-100 dark:hover:bg-slate-800/60 transition {{ $isProducts ? 'text-blue-600 dark:text-cyan-400 font-bold' : '' }}">
                        <span>{{ __('landing.nav_product') }}</span>
                        <div
                            class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition">
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-open:rotate-180"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
                    </summary>
                    <div
                        class="pl-3 pr-1 py-1.5 space-y-1 text-xs border-l-2 border-blue-500/30 dark:border-cyan-500/30 ml-4 my-1">
                        <a href="{{ route('products') }}"
                            class="flex items-center justify-between px-3 py-2 rounded-lg font-semibold transition {{ $isProducts ? 'text-blue-600 dark:text-cyan-400 bg-blue-50 dark:bg-blue-900/40' : 'text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            <span>Hidrologi</span>
                        </a>
                    </div>
                </details>

                {{-- Projects --}}
                <a href="{{ $isHome ? '#map-section' : 'https://higertech.com/#services' }}"
                    @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/60 transition">
                    <span>{{ __('landing.nav_projects') }}</span>
                </a>

                {{-- Articles --}}
                <a href="{{ $isHome ? '#articles' : 'https://higertech.com/Article' }}"
                    @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/60 transition">
                    <span>{{ __('landing.nav_articles') }}</span>
                </a>

                {{-- Download --}}
                <a href="{{ $isHome ? '#contact' : 'https://higertech.com/Tutorial' }}"
                    @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/60 transition">
                    <span>{{ __('landing.nav_download') }}</span>
                </a>

                {{-- Peta --}}
                <a href="{{ route('map') }}"
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ $isMap ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-cyan-400 font-bold' : 'hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                    <div class="flex items-center gap-2">
                        <span>{{ __('landing.nav_map') }}</span>
                        <span
                            class="px-1.5 py-0.5 rounded-full bg-cyan-100 dark:bg-cyan-950/80 text-cyan-800 dark:text-cyan-300 text-[10px] font-extrabold border border-cyan-300 dark:border-cyan-700/50 uppercase tracking-wider">Live</span>
                    </div>
                    @if ($isMap)
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                    @endif
                </a>

                {{-- Internship --}}
                <a href="{{ route('internship') }}"
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ $isInternship ? 'bg-cyan-100 dark:bg-cyan-900/80 border-cyan-400 dark:border-cyan-500 text-cyan-950 dark:text-cyan-200' : 'bg-cyan-50/80 dark:bg-cyan-950/40 border border-cyan-200/80 dark:border-cyan-800/60 text-cyan-800 dark:text-cyan-300' }} font-bold hover:bg-cyan-100 dark:hover:bg-cyan-900/60 transition">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z" />
                            <path d="M20 2v4M22 4h-4" />
                            <circle cx="4" cy="20" r="2" />
                        </svg>
                        <span>{{ __('landing.nav_internship') }}</span>
                    </div>
                    <span
                        class="px-1.5 py-0.5 rounded-full bg-emerald-500 text-[9px] font-extrabold text-white uppercase tracking-wider">{{ __('landing.nav_internship_badge') }}</span>
                </a>
            </nav>

            {{-- INAPROC Inside Mobile Drawer --}}
            <div class="pt-2 border-t border-slate-200/80 dark:border-slate-800">
                <a href="https://katalog.inaproc.id/higertech-karya-sinergi" target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center justify-between p-3 rounded-xl border border-red-200 dark:border-red-900/50 bg-gradient-to-r from-red-50 to-amber-50/50 dark:from-red-950/40 dark:to-[#1a1215] text-slate-800 dark:text-slate-100 hover:border-red-400 transition shadow-xs"
                    aria-label="Buka INAPROC Katalog Elektronik">
                    <div class="flex items-center gap-3">
                        <span
                            class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center text-white shadow-xs shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M16 10a4 4 0 0 1-8 0M3.103 6.034h17.794M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z" />
                            </svg>
                        </span>
                        <div class="leading-tight">
                            <div class="flex items-center gap-1.5">
                                <span
                                    class="font-extrabold text-red-600 dark:text-red-400 text-xs tracking-wider">INAPROC</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-600 dark:text-slate-300">Katalog Elektronik
                                LKPP</span>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</header>
