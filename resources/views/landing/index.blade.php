@extends('layouts.app')

@section('title', 'Higertech Karya Sinergi | Integrated Telemetry Solution & Internship Academy')

@section('content')
    @include('partials.header')

    <main>
        @include('landing.partials.hero')
        @include('landing.partials.workstation')
        @include('landing.partials.pillars')
        @include('landing.partials.internship')
        @include('landing.partials.map-section')
        @include('landing.partials.clients')
        @include('landing.partials.articles')
        @include('landing.partials.cta')
    </main>

    @include('landing.partials.footer')
@endsection

@push('scripts')
    <script>
        // =============================================
        // Theme Switcher
        // =============================================
        const THEME_KEY = 'higertech_theme';

        function setTheme(theme) {
            localStorage.setItem(THEME_KEY, theme);
            document.documentElement.classList.toggle('dark', theme === 'dark');
            syncThemeUI(theme);
            window.dispatchEvent(new CustomEvent('theme-changed', {
                detail: theme
            }));
        }

        function syncThemeUI(theme) {
            const isDark = theme === 'dark';
            const btnLight = document.getElementById('btn-theme-light');
            const btnDark = document.getElementById('btn-theme-dark');
            if (!btnLight || !btnDark) return;

            if (isDark) {
                btnLight.className =
                    'flex items-center gap-1 px-2.5 py-1 rounded-md text-slate-400 hover:text-white bg-transparent transition-all duration-150 text-xs font-semibold';
                btnDark.className =
                    'flex items-center gap-1 px-2.5 py-1 rounded-md text-white bg-cyan-600 border border-cyan-400/40 shadow-xs transition-all duration-150 text-xs font-bold';
            } else {
                btnLight.className =
                    'flex items-center gap-1 px-2.5 py-1 rounded-md text-slate-900 bg-white shadow-xs border border-slate-300/80 transition-all duration-150 text-xs font-bold';
                btnDark.className =
                    'flex items-center gap-1 px-2.5 py-1 rounded-md text-slate-600 hover:text-slate-900 bg-transparent transition-all duration-150 text-xs font-semibold';
            }
        }

        // Sync on load
        document.addEventListener('DOMContentLoaded', () => {
            const isDark = document.documentElement.classList.contains('dark');
            syncThemeUI(isDark ? 'dark' : 'light');
        });

        // Listen for OS changes (only if no manual override)
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem(THEME_KEY)) {
                document.documentElement.classList.toggle('dark', e.matches);
                syncThemeUI(e.matches ? 'dark' : 'light');
            }
        });

        // =============================================
        // 4 Pillar Tab Switcher
        // =============================================
        const pillarData = [{
                title: '{{ __('landing.pillar_1_title') }}',
                badge: '{{ __('landing.pillar_1_badge') }}',
                desc: '{{ __('landing.pillar_1_desc') }}',
                iconColor: 'text-emerald-600 dark:text-emerald-400',
                bgColor: 'bg-emerald-500/10',
            },
            {
                title: '{{ __('landing.pillar_2_title') }}',
                badge: '{{ __('landing.pillar_2_badge') }}',
                desc: '{{ __('landing.pillar_2_desc') }}',
                iconColor: 'text-blue-600 dark:text-blue-400',
                bgColor: 'bg-blue-500/10',
            },
            {
                title: '{{ __('landing.pillar_3_title') }}',
                badge: '{{ __('landing.pillar_3_badge') }}',
                desc: '{{ __('landing.pillar_3_desc') }}',
                iconColor: 'text-cyan-600 dark:text-cyan-400',
                bgColor: 'bg-cyan-500/10',
            },
            {
                title: '{{ __('landing.pillar_4_title') }}',
                badge: '{{ __('landing.pillar_4_badge') }}',
                desc: '{{ __('landing.pillar_4_desc') }}',
                iconColor: 'text-amber-600 dark:text-amber-400',
                bgColor: 'bg-amber-500/10',
            },
        ];

        const pillarBtns = document.querySelectorAll('.pillar-btn');
        const displayTitle = document.getElementById('pillar-display-title');
        const displayBadge = document.getElementById('pillar-display-badge');
        const displayDesc = document.getElementById('pillar-display-desc');
        const displayBody = document.getElementById('pillar-display-body');
        const displayIconBox = document.getElementById('pillar-display-icon-box');
        const displayIconSvg = document.getElementById('pillar-display-icon-svg');

        function setActivePillar(index) {
            pillarBtns.forEach((btn, idx) => {
                if (idx === index) {
                    btn.classList.add('bg-blue-50/90', 'dark:bg-blue-900/30', 'border-2', 'border-blue-500',
                        'dark:border-cyan-500');
                    btn.classList.remove('bg-slate-50', 'dark:bg-[#131D36]', 'border', 'border-slate-200',
                        'dark:border-slate-800');
                } else {
                    btn.classList.remove('bg-blue-50/90', 'dark:bg-blue-900/30', 'border-2', 'border-blue-500',
                        'dark:border-cyan-500');
                    btn.classList.add('bg-slate-50', 'dark:bg-[#131D36]', 'border', 'border-slate-200',
                        'dark:border-slate-800');
                }
            });

            if (displayBody) {
                displayBody.style.opacity = '0';
                displayBody.style.transform = 'translateY(4px)';
                setTimeout(() => {
                    const item = pillarData[index];
                    if (displayTitle) displayTitle.textContent = item.title;
                    if (displayBadge) {
                        displayBadge.textContent = item.badge;
                        displayBadge.className =
                            `text-[10px] font-mono uppercase tracking-widest ${item.iconColor} font-bold block`;
                    }
                    if (displayDesc) displayDesc.textContent = item.desc;
                    if (displayIconBox && displayIconSvg) {
                        displayIconBox.className =
                            `w-12 h-12 rounded-2xl ${item.bgColor} ${item.iconColor} flex items-center justify-center`;
                        const btnSvg = pillarBtns[index]?.querySelector('svg');
                        if (btnSvg) {
                            displayIconSvg.innerHTML = btnSvg.innerHTML;
                        }
                    }
                    displayBody.style.opacity = '1';
                    displayBody.style.transform = 'translateY(0)';
                }, 120);
            }
        }

        pillarBtns.forEach((btn, idx) => {
            btn.addEventListener('click', () => setActivePillar(idx));
        });
    </script>
@endpush
