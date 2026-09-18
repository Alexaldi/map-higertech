<footer
    class="bg-white dark:bg-[#070c17] border-t border-slate-200 dark:border-slate-800 pt-16 pb-12 text-slate-600 dark:text-slate-400 text-sm transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 mb-12">

            {{-- Brand Info --}}
            <div class="lg:col-span-5 space-y-4">
                <a href="{{ route('home') }}" aria-label="Higertech">
                    <picture>
                        <source srcset="{{ asset('images/brand/higertech-logo.webp') }}" type="image/webp">
                        <img src="{{ asset('images/brand/higertech-logo.png') }}" alt="Higertech Karya Sinergi"
                            class="h-10 w-auto object-contain dark:brightness-110" width="425" height="125"
                            loading="lazy" decoding="async"
                            onerror="this.onerror=null;this.src='https://placehold.co/220x70/16275E/FFFFFF?text=HIGERTECH'">
                    </picture>
                </a>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed max-w-sm">
                    {{ setting('footer_about', __('landing.footer_about')) }}</p>
                <div class="pt-2 space-y-1.5 text-xs text-slate-600 dark:text-slate-300">
                    <p class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-cyan-500 flex-shrink-0" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        <strong
                            class="text-slate-900 dark:text-white font-semibold">{{ __('landing.footer_phone') }}</strong>
                        {{ setting('contact_phone', '022-2101-0299') }}
                    </p>
                    <p class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-cyan-500 flex-shrink-0" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        <strong
                            class="text-slate-900 dark:text-white font-semibold">{{ __('landing.footer_email') }}</strong>
                        {{ setting('contact_email', 'higertechkaryasinergi@gmail.com') }}
                    </p>
                    <p class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-cyan-500 flex-shrink-0" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <strong
                            class="text-slate-900 dark:text-white font-semibold">{{ __('landing.footer_workshop') }}</strong>
                        {{ setting('contact_address', 'Bandung, Jawa Barat, Indonesia') }}
                    </p>
                </div>
            </div>

            {{-- Solutions --}}
            <div class="lg:col-span-3 space-y-3">
                <h3 class="text-slate-900 dark:text-white font-bold text-sm tracking-wide">
                    {{ __('landing.footer_solutions') }}</h3>
                <ul class="space-y-2 text-xs text-slate-500 dark:text-slate-400">
                    <li><a href="#workstation" class="hover:text-blue-600 dark:hover:text-cyan-400 transition">Water
                            Level Recorder (AWLR)</a></li>
                    <li><a href="#workstation" class="hover:text-blue-600 dark:hover:text-cyan-400 transition">Automatic
                            Rainfall Recorder (ARR)</a></li>
                    <li><a href="#workstation" class="hover:text-blue-600 dark:hover:text-cyan-400 transition">Weather
                            Station (AWS)</a></li>
                    <li><a href="#workstation" class="hover:text-blue-600 dark:hover:text-cyan-400 transition">Early
                            Warning System (EWS)</a></li>
                    <li><a href="#workstation" class="hover:text-blue-600 dark:hover:text-cyan-400 transition">Data
                            Logger HG-LOG900</a></li>
                </ul>
            </div>

            {{-- Company --}}
            <div class="lg:col-span-2 space-y-3">
                <h3 class="text-slate-900 dark:text-white font-bold text-sm tracking-wide">
                    {{ __('landing.footer_company') }}</h3>
                <ul class="space-y-2 text-xs text-slate-500 dark:text-slate-400">
                    <li><a href="#why-us"
                            class="hover:text-blue-600 dark:hover:text-cyan-400 transition">{{ __('landing.footer_about_us') }}</a>
                    </li>
                    <li><a href="#internship"
                            class="hover:text-blue-600 dark:hover:text-cyan-400 transition">{{ __('landing.footer_internship') }}</a>
                    </li>
                    <li><a href="{{ route('map') }}"
                            class="hover:text-blue-600 dark:hover:text-cyan-400 transition">{{ __('landing.footer_projects') }}</a>
                    </li>
                    <li><a href="{{ route('articles') }}"
                            class="hover:text-blue-600 dark:hover:text-cyan-400 transition">{{ __('landing.footer_articles') }}</a>
                    </li>
                    <li><a href="https://e-katalog.lkpp.go.id" target="_blank"
                            class="hover:text-blue-600 dark:hover:text-cyan-400 transition">{{ __('landing.footer_ecatalog') }}</a>
                    </li>
                </ul>
            </div>

            {{-- Social --}}
            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-slate-900 dark:text-white font-bold text-sm tracking-wide">
                    {{ __('landing.footer_social') }}</h3>
                <div class="flex items-center gap-2.5 flex-wrap">
                    @foreach (setting_social_links() as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                            aria-label="{{ $social['label'] }}" title="{{ $social['label'] }}"
                            class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 {{ $social['hover_class'] ?? 'hover:bg-blue-600 hover:text-white' }} transition flex items-center justify-center">
                            {!! $social['icon'] !!}
                        </a>
                    @endforeach
                    <a href="mailto:{{ setting('contact_email', 'higertechkaryasinergi@gmail.com') }}"
                        aria-label="Email" title="Email"
                        class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 hover:bg-blue-600 hover:text-white transition flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Copyright Bar --}}
        <div
            class="pt-8 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 dark:text-slate-400 gap-4">
            <div>{{ __('landing.footer_copyright') }}</div>
        </div>
    </div>

    {{-- Floating Back-To-Top Button (follows user on scroll) --}}
    <button id="btn-back-to-top" type="button" aria-label="Kembali ke atas"
        class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-xl bg-[#16275E] dark:bg-cyan-500 text-white dark:text-slate-950 hover:bg-blue-800 dark:hover:bg-cyan-400 shadow-lg shadow-slate-900/20 dark:shadow-cyan-950/40 flex items-center justify-center transition-all duration-300 opacity-0 pointer-events-none translate-y-4 hover:scale-105 active:scale-95 focus-visible:outline-2 focus-visible:outline-blue-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
            aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 7-7 7 7M12 19V5" />
        </svg>
    </button>
</footer>
