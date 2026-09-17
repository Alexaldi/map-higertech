{{-- Global Page Transition Skeleton & Telemetry Center Spinner Loader --}}
<div id="page-loader-overlay"
    class="fixed inset-0 z-[999999] pointer-events-none opacity-0 invisible transition-opacity duration-200 flex items-center justify-center bg-slate-100/85 dark:bg-[#070d1a]/90 backdrop-blur-md overflow-hidden"
    aria-hidden="true" role="status" aria-live="polite">

    <style>
        @keyframes hg-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .hg-spinner-active {
            animation: hg-spin 0.85s linear infinite !important;
        }
    </style>

    {{-- Center Spinner Card ("Loading Muter di Tengah") --}}
    <div id="page-loader-card"
        class="relative z-10 p-6 rounded-3xl bg-white/95 dark:bg-[#0c1322]/95 border border-slate-200/90 dark:border-cyan-500/40 shadow-2xl backdrop-blur-xl flex flex-col items-center text-center min-w-[240px] max-w-xs mx-4 transition-transform duration-200 transform scale-95 select-none">

        {{-- Clean, normal smooth circular spinner (tidak rame) --}}
        <div class="w-10 h-10 mb-3.5 flex items-center justify-center">
            <svg class="w-9 h-9 animate-spin text-cyan-600 dark:text-cyan-400" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3">
                </circle>
                <path class="opacity-90" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>

        {{-- Status Title & Subtitle --}}
        <h4 id="page-loader-title" class="text-sm font-bold text-slate-900 dark:text-white tracking-tight">
            {{ __('landing.loader_title') }}
        </h4>
        <p id="page-loader-subtitle" class="text-[11px] text-slate-500 dark:text-slate-400 font-mono mt-0.5">
            {{ __('landing.loader_subtitle') }}
        </p>
    </div>
</div>

<script>
    (function() {
        const overlay = document.getElementById('page-loader-overlay');
        const titleEl = document.getElementById('page-loader-title');
        const subEl = document.getElementById('page-loader-subtitle');
        const cardEl = document.getElementById('page-loader-card');
        if (!overlay) return;

        let delayTimer = null;
        let safetyTimer = null;

        // React-like delayed threshold: only show loader if loading takes > 180ms!
        // Instant transitions won't flash or interrupt the user.
        const LOADER_DELAY_MS = 180;

        window.showPageLoader = function(customTitle, customSubtitle, immediate = false) {
            clearTimeout(delayTimer);

            const activate = function() {
                if (titleEl && customTitle) titleEl.textContent = customTitle;
                if (subEl && customSubtitle) subEl.textContent = customSubtitle;

                overlay.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
                overlay.classList.add('opacity-100', 'visible', 'pointer-events-auto');
                if (cardEl) {
                    cardEl.classList.remove('scale-95');
                    cardEl.classList.add('scale-100');
                }

                // Safety timeout: dismiss if taking > 8 seconds
                clearTimeout(safetyTimer);
                safetyTimer = setTimeout(window.hidePageLoader, 8000);
            };

            if (immediate) {
                activate();
            } else {
                delayTimer = setTimeout(activate, LOADER_DELAY_MS);
            }
        };

        window.hidePageLoader = function() {
            clearTimeout(delayTimer);
            clearTimeout(safetyTimer);
            overlay.classList.add('opacity-0', 'invisible', 'pointer-events-none');
            overlay.classList.remove('opacity-100', 'visible', 'pointer-events-auto');
            if (cardEl) {
                cardEl.classList.add('scale-95');
                cardEl.classList.remove('scale-100');
            }
        };

        // Hide when navigating via browser back/forward (bfcache)
        window.addEventListener('pageshow', function() {
            window.hidePageLoader();
        });

        // Intercept internal link clicks to show loader only when there is delay
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href');
            if (!href) return;

            // Skip non-page navigation
            if (
                href.startsWith('#') ||
                href.startsWith('javascript:') ||
                href.startsWith('mailto:') ||
                href.startsWith('tel:') ||
                link.hasAttribute('download') ||
                link.getAttribute('target') === '_blank' ||
                link.classList.contains('no-loader') ||
                e.defaultPrevented ||
                e.ctrlKey || e.metaKey || e.shiftKey || e.altKey || e.button !== 0
            ) {
                return;
            }

            try {
                const targetUrl = new URL(link.href, window.location.origin);
                if (targetUrl.origin === window.location.origin) {
                    const currentCleanPath = window.location.pathname.replace(/\/+$/, '') || '/';
                    const targetCleanPath = targetUrl.pathname.replace(/\/+$/, '') || '/';

                    // If clicking the current page's active menu/link: PREVENT CLICKING!
                    if (targetCleanPath === currentCleanPath && targetUrl.search === window.location
                        .search) {
                        // Allow in-page anchor jumps (e.g. #komparasi-jalur) without loader
                        if (targetUrl.hash) {
                            return;
                        }
                        // Currently displaying menu/page: prevent click, reload, and loader!
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }

                    if (targetUrl.pathname.includes('/locale/')) {
                        const isId = targetUrl.pathname.endsWith('/id');
                        // Language switch has a small 80ms delay
                        window.showPageLoader(
                            isId ? '{{ __('landing.loader_switching_id') }}' :
                            '{{ __('landing.loader_switching_en') }}',
                            isId ? 'Sinkronisasi Pengaturan Bahasa' :
                            'Synchronizing Language Settings...',
                            false
                        );
                    } else {
                        // Standard page navigation: throttled (180ms delay)
                        window.showPageLoader(
                            '{{ __('landing.loader_title') }}',
                            '{{ __('landing.loader_subtitle') }}',
                            false
                        );
                    }
                }
            } catch (err) {
                // Ignore any invalid URL
            }
        });
    })();
</script>
