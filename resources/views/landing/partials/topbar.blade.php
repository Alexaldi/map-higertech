<div
    class="bg-[#16275E] dark:bg-[#070c17] text-white text-xs py-2 border-b border-[#22377A] dark:border-slate-800 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center gap-2">
        {{-- Left: NOC Status --}}
        <div class="flex items-center gap-3">
            <span
                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                {{ __('landing.noc_status') }}
            </span>
            <span class="hidden md:inline-flex items-center gap-1 text-[11px] text-slate-300 font-mono">
                <svg class="w-3 h-3 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path
                        d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2" />
                </svg>
                {{ __('landing.server_ping') }}: <strong class="text-cyan-300">18ms</strong>
                {{ __('landing.zero_packet_loss') }}
            </span>
        </div>

        {{-- Right: Contacts + Theme Toggle + Lang --}}
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex items-center gap-4 text-slate-200 text-[12px]">
                <a href="mailto:{{ setting('contact_email', 'higertechkaryasinergi@gmail.com') }}"
                    class="flex items-center gap-1.5 hover:text-cyan-300 transition">
                    <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="2" y="4" width="20" height="16" rx="2" />
                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                    </svg>
                    <span class="font-medium">{{ setting('contact_email', 'higertechkaryasinergi@gmail.com') }}</span>
                </a>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', (string) setting('contact_phone', '02221010299')) }}"
                    class="flex items-center gap-1.5 hover:text-cyan-300 transition">
                    <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                    </svg>
                    <span class="font-medium">{{ setting('contact_phone', '022-2101-0299') }}</span>
                </a>
            </div>

            {{-- Theme Toggle --}}
            <div class="inline-flex items-center p-0.5 rounded-lg bg-slate-900/60 border border-white/15 gap-0.5"
                role="group" aria-label="Mode Tampilan">
                <button id="btn-theme-light" onclick="setTheme('light')" type="button"
                    class="flex items-center gap-1 px-2.5 py-1 rounded text-slate-300 bg-transparent transition-all duration-150 text-xs font-semibold">
                    <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="4" />
                        <path
                            d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41" />
                    </svg>
                    <span>{{ __('landing.theme_light') }}</span>
                </button>
                <button id="btn-theme-dark" onclick="setTheme('dark')" type="button"
                    class="flex items-center gap-1 px-2.5 py-1 rounded text-slate-300 bg-transparent transition-all duration-150 text-xs font-semibold">
                    <svg class="w-3 h-3 text-cyan-300" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401" />
                    </svg>
                    <span>{{ __('landing.theme_dark') }}</span>
                </button>
            </div>

            {{-- Language Switcher --}}
            <div class="flex items-center bg-black/30 p-0.5 rounded-full text-[11px] font-bold border border-white/10">
                @php $locale = app()->getLocale(); @endphp
                <a href="{{ route('locale.switch', 'id') }}"
                    class="px-2 py-0.5 rounded-full transition {{ $locale === 'id' ? 'bg-cyan-500 text-slate-950 font-extrabold shadow-sm' : 'text-slate-300 hover:text-white' }}">ID</a>
                <a href="{{ route('locale.switch', 'en') }}"
                    class="px-2 py-0.5 rounded-full transition {{ $locale === 'en' ? 'bg-cyan-500 text-slate-950 font-extrabold shadow-sm' : 'text-slate-300 hover:text-white' }}">EN</a>
            </div>
        </div>
    </div>
</div>
