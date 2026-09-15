@php
    $isMap = request()->is('map*') || request()->routeIs('map');
    $isHome = request()->routeIs('home') || request()->is('/');
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
    class="site-header sticky z-50 bg-white/95 dark:bg-[#0B1120]/95 backdrop-blur-md shadow-sm border-b border-slate-200/80 dark:border-slate-800 transition-colors duration-300">
    {{-- Topbar --}}
    <div
        class="site-topbar bg-slate-100 text-slate-700 border-b border-slate-200/80 dark:bg-[#070c17] dark:text-slate-300 dark:border-slate-800 transition-colors duration-300 text-xs py-2">
        <div
            class="site-header__inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center gap-2 w-full">
            {{-- Left: Company Identity + Socials --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-[12px] font-medium text-slate-600 dark:text-slate-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="font-bold text-slate-900 dark:text-slate-100 tracking-tight">PT Higertech Karya
                        Sinergi</span>
                    <span class="hidden sm:inline text-slate-300 dark:text-slate-700">•</span>
                    <span class="hidden sm:inline text-slate-600 dark:text-slate-400 font-normal">Solusi Telemetri &
                        Instrumentasi</span>
                </div>
                {{-- Social Icons (Required by MapPageTest) --}}
                <div class="site-socials hidden lg:flex items-center gap-2.5 pl-3 border-l border-slate-300 dark:border-white/15 text-slate-500 dark:text-slate-400"
                    aria-label="Media sosial Higertech">
                    <svg class="w-3.5 h-3.5 hover:text-blue-600 dark:hover:text-cyan-300 transition cursor-pointer"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        aria-label="X">
                        <path d="M4 4l16 16M20 4 4 20" />
                    </svg>
                    <svg class="w-3.5 h-3.5 hover:text-blue-600 dark:hover:text-cyan-300 transition cursor-pointer"
                        viewBox="0 0 24 24" fill="currentColor" aria-label="Facebook">
                        <path
                            d="M13.7 22v-8h2.7l.4-3.1h-3.1V9c0-.9.3-1.5 1.6-1.5H17V4.7c-.8-.1-1.6-.2-2.4-.2-2.4 0-4.1 1.5-4.1 4.2v2.2H7.8V14h2.7v8h3.2Z" />
                    </svg>
                    <svg class="w-3.5 h-3.5 hover:text-blue-600 dark:hover:text-cyan-300 transition cursor-pointer"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        aria-label="Instagram">
                        <rect x="3" y="3" width="18" height="18" rx="5" />
                        <circle cx="12" cy="12" r="4" />
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                    </svg>
                    <svg class="w-3.5 h-3.5 hover:text-blue-600 dark:hover:text-cyan-300 transition cursor-pointer"
                        viewBox="0 0 24 24" fill="currentColor" aria-label="LinkedIn">
                        <path
                            d="M6.5 8.2H3.3V21h3.2V8.2ZM4.9 3A1.9 1.9 0 1 0 5 6.8 1.9 1.9 0 0 0 5 3ZM21 13.7c0-3.8-2-5.6-4.7-5.6a4 4 0 0 0-3.6 2V8.3H9.5V21h3.2v-6.3c0-1.7.3-3.3 2.4-3.3 2 0 2.1 1.9 2.1 3.4V21H21v-7.3Z" />
                    </svg>
                </div>
            </div>

            {{-- Right: Contacts + Theme Toggle + Lang --}}
            <div class="site-contact flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-4 text-slate-600 dark:text-slate-300 text-[12px]">
                    <a href="mailto:higertechkaryasinergi@gmail.com"
                        class="flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-cyan-300 transition">
                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-cyan-400" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                        </svg>
                        <span class="font-medium">higertechkaryasinergi@gmail.com</span>
                    </a>
                    <a href="tel:+622221010299"
                        class="flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-cyan-300 transition">
                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-cyan-400" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 .8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                        </svg>
                        <span class="font-medium">022-2101-0299</span>
                    </a>
                </div>

                {{-- Theme Toggle --}}
                <div class="inline-flex items-center p-0.5 rounded-lg bg-slate-200/80 dark:bg-slate-900/60 border border-slate-300/80 dark:border-white/15 gap-0.5"
                    role="group" aria-label="Mode Tampilan">
                    <button id="btn-theme-light" onclick="setTheme('light')" type="button"
                        class="flex items-center gap-1 px-2.5 py-1 rounded text-slate-700 dark:text-slate-300 bg-transparent transition-all duration-150 text-xs font-semibold">
                        <svg class="w-3 h-3 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="4" />
                            <path
                                d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41" />
                        </svg>
                        <span>{{ __('landing.theme_light') }}</span>
                    </button>
                    <button id="btn-theme-dark" onclick="setTheme('dark')" type="button"
                        class="flex items-center gap-1 px-2.5 py-1 rounded text-slate-700 dark:text-slate-300 bg-transparent transition-all duration-150 text-xs font-semibold">
                        <svg class="w-3 h-3 text-blue-600 dark:text-cyan-300" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401" />
                        </svg>
                        <span>{{ __('landing.theme_dark') }}</span>
                    </button>
                </div>

                {{-- Language Switcher --}}
                <div
                    class="language-switch inline-flex items-center p-0.5 rounded-lg bg-slate-200/80 dark:bg-slate-900/60 border border-slate-300/80 dark:border-white/15 gap-0.5 text-xs font-semibold">
                    <a href="{{ route('locale.switch', 'id') }}"
                        class="px-2.5 py-1 rounded-md transition-all duration-150 {{ $locale === 'id' ? 'bg-white dark:bg-cyan-600 text-slate-900 dark:text-white font-bold shadow-xs border border-slate-300/70 dark:border-cyan-400/40' : 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">ID</a>
                    <a href="{{ route('locale.switch', 'en') }}"
                        class="px-2.5 py-1 rounded-md transition-all duration-150 {{ $locale === 'en' ? 'bg-white dark:bg-cyan-600 text-slate-900 dark:text-white font-bold shadow-xs border border-slate-300/70 dark:border-cyan-400/40' : 'text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">EN</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Navbar --}}
    <div class="site-branding">
        <div class="site-header__inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            <div class="site-branding__start flex items-center gap-3">
                @if ($isMap)
                    {{-- Drawer Toggle on Map page for mobile --}}
                    <button id="drawer-toggle"
                        class="site-icon-button station-drawer-toggle xl:hidden inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold transition hover:bg-slate-100 dark:hover:bg-slate-700"
                        type="button" aria-label="Buka pencarian, filter, dan daftar pos"
                        aria-controls="station-sidebar" aria-expanded="false">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" aria-hidden="true">
                            <path d="M4 6h10M18 6h2M4 12h2m4 0h10M4 18h7m4 0h5" />
                            <circle cx="16" cy="6" r="2" />
                            <circle cx="8" cy="12" r="2" />
                            <circle cx="13" cy="18" r="2" />
                        </svg>
                        <span class="station-drawer-toggle__label">{{ __('map.pos_button') }}</span>
                    </button>
                @endif

                <a class="site-brand flex-shrink-0 flex items-center gap-3" href="{{ route('home') }}"
                    aria-label="Higertech Karya Sinergi">
                    <img src="{{ asset('images/brand/higertech-logo.png') }}" alt="Higertech Karya Sinergi"
                        class="h-10 sm:h-11 w-auto object-contain dark:brightness-110" width="400" height="125">
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <nav class="site-nav hidden xl:flex items-center gap-6 text-[13px] font-semibold text-slate-700 dark:text-slate-200"
                aria-label="Navigasi utama">
                <a href="{{ route('home') }}" data-nav-target="hero"
                    class="nav-link {{ $isHome ? 'is-active text-blue-600 dark:text-cyan-400 font-bold' : 'hover:text-blue-600 dark:hover:text-cyan-400 transition' }}">{{ __('landing.nav_home') }}</a>

                {{-- Product Dropdown --}}
                <div class="nav-dropdown relative group" data-nav-target="workstation">
                    <button type="button"
                        class="nav-dropdown-btn flex items-center gap-1 hover:text-blue-600 dark:hover:text-cyan-400 transition py-2">
                        <span>{{ __('landing.nav_product') }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div
                        class="absolute left-0 top-full mt-1 w-72 rounded-2xl bg-white dark:bg-[#131D36] shadow-2xl border border-slate-200/80 dark:border-slate-700 py-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-1">
                            @foreach (array_slice($products, 0, 3) as $product)
                                <a href="{{ $isHome ? '#workstation' : $product['url'] }}"
                                    @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                                    class="flex items-center justify-between px-4 py-2 text-xs font-semibold text-slate-800 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-cyan-400">
                                    <span>{{ $product['label'] }}</span>
                                    @if (!empty($product['sub']))
                                        <span
                                            class="text-[10px] text-slate-400 font-mono">{{ $product['sub'] }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                        <div class="border-t border-slate-100 dark:border-slate-800 py-1">
                            @foreach (array_slice($products, 3) as $product)
                                <a href="{{ $isHome && !str_contains($product['url'], 'Tutorial') ? '#workstation' : $product['url'] }}"
                                    @if (!$isHome || str_contains($product['url'], 'Tutorial')) target="_blank" rel="noopener noreferrer" @endif
                                    class="block px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-cyan-400">{{ $product['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <a href="{{ $isHome ? '#map-section' : 'https://higertech.com/#services' }}"
                    data-nav-target="map-section"
                    @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                    class="nav-link hover:text-blue-600 dark:hover:text-cyan-400 transition">{{ __('landing.nav_projects') }}</a>

                <a href="{{ $isHome ? '#articles' : 'https://higertech.com/Article' }}" data-nav-target="articles"
                    @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                    class="nav-link hover:text-blue-600 dark:hover:text-cyan-400 transition">{{ __('landing.nav_articles') }}</a>

                <a href="{{ $isHome ? '#contact' : 'https://higertech.com/Tutorial' }}" data-nav-target="contact"
                    @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                    class="nav-link hover:text-blue-600 dark:hover:text-cyan-400 transition">{{ __('landing.nav_download') }}</a>

                {{-- Peta link with Active Indicator when on /map --}}
                <a href="{{ route('map') }}" data-nav-target="map"
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
                <a href="{{ $isHome ? '#internship' : route('home') . '#internship' }}" data-nav-target="internship"
                    class="nav-link nav-pill relative inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-cyan-50 dark:bg-cyan-950/60 border border-cyan-300 dark:border-cyan-700 text-cyan-800 dark:text-cyan-300 font-bold hover:bg-cyan-100 dark:hover:bg-cyan-900/80 transition">
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

            {{-- Right: INAPROC Badge + Mobile Menu --}}
            <div class="flex items-center gap-3">
                <a href="https://katalog.inaproc.id/higertech-karya-sinergi" target="_blank"
                    rel="noopener noreferrer"
                    class="inaproc-link inline-flex items-center gap-2.5 px-3.5 py-2 rounded-xl border border-red-200 dark:border-red-900/50 bg-gradient-to-r from-red-50 to-amber-50/50 dark:from-red-950/40 dark:to-[#1a1215] text-slate-800 dark:text-slate-100 hover:border-red-400 transition shadow-sm"
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

                {{-- Mobile menu button --}}
                <button type="button" aria-label="Toggle menu"
                    class="xl:hidden p-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                    onclick="document.getElementById('site-mobile-drawer').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path d="M4 5h16M4 12h16M4 19h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Drawer --}}
    <div id="site-mobile-drawer"
        class="hidden xl:hidden bg-white dark:bg-[#0E1628] border-b border-slate-200 dark:border-slate-800 px-4 py-4">
        <div class="grid grid-cols-2 gap-2 text-xs font-semibold">
            <a href="{{ route('home') }}" data-nav-target="hero"
                class="p-2 rounded transition {{ $isHome ? 'is-active bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-cyan-400 font-bold' : 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white' }}">{{ __('landing.nav_home') }}</a>
            <a href="{{ $isHome ? '#workstation' : 'https://higertech.com/Product/Hidrologi' }}"
                data-nav-target="workstation"
                @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                class="p-2 rounded bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white transition">{{ __('landing.nav_product') }}</a>
            <a href="{{ $isHome ? '#map-section' : 'https://higertech.com/#services' }}"
                data-nav-target="map-section"
                @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                class="p-2 rounded bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white transition">{{ __('landing.nav_projects') }}</a>
            <a href="{{ $isHome ? '#articles' : 'https://higertech.com/Article' }}" data-nav-target="articles"
                @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                class="p-2 rounded bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white transition">{{ __('landing.nav_articles') }}</a>
            <a href="{{ $isHome ? '#contact' : 'https://higertech.com/Tutorial' }}" data-nav-target="contact"
                @if (!$isHome) target="_blank" rel="noopener noreferrer" @endif
                class="p-2 rounded bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white transition">{{ __('landing.nav_download') }}</a>
            <a href="{{ route('map') }}" data-nav-target="map"
                class="p-2 rounded transition {{ $isMap ? 'is-active bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-cyan-400 font-bold' : 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white' }}">{{ __('landing.nav_map') }}</a>
            <a href="{{ $isHome ? '#internship' : route('home') . '#internship' }}" data-nav-target="internship"
                class="col-span-2 p-2 rounded bg-cyan-100 dark:bg-cyan-950 text-cyan-900 dark:text-cyan-300 font-bold transition">{{ __('landing.nav_internship') }}</a>
        </div>
    </div>
</header>
