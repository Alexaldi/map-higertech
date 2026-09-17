<section id="contact"
    class="py-16 bg-gradient-to-r from-blue-50/90 via-indigo-50/60 to-blue-50/90 dark:from-[#0B1120] dark:via-[#111C38] dark:to-[#0B1120] border-y border-blue-200/70 dark:border-slate-800 text-slate-900 dark:text-white relative transition-colors duration-300">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 scroll-reveal scroll-reveal-scale">
        <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-100 text-blue-800 dark:bg-cyan-950/70 dark:text-cyan-300 text-xs font-mono font-medium mb-4 border border-blue-200 dark:border-cyan-800/60">
            <svg class="w-3.5 h-3.5 text-blue-600 dark:text-cyan-400" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" aria-hidden="true">
                <rect x="4" y="4" width="16" height="16" rx="2" />
                <rect x="8" y="8" width="8" rx="1" height="8" />
                <path d="M12 20v2M12 2v2M17 20v2M17 2v2M2 12h2M2 17h2M2 7h2M20 12h2M20 17h2M20 7h2M7 20v2M7 2v2" />
            </svg>
            <span>{{ __('landing.cta_label') }}</span>
        </div>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-slate-900 dark:text-white">
            {{ __('landing.cta_title') }}</h2>
        <p class="mt-3 text-slate-600 dark:text-slate-300 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
            {{ __('landing.cta_desc') }}</p>
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ whatsapp_url() }}" target="_blank" rel="noopener noreferrer"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 font-bold text-xs sm:text-sm transition shadow-sm">
                <svg class="w-4 h-4 text-white dark:text-slate-950" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719" />
                </svg>
                <span>{{ __('landing.cta_wa') }}</span>
            </a>
            <a href="#workstation"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-white hover:bg-slate-50 border border-slate-300 text-slate-800 dark:bg-slate-800/80 dark:hover:bg-slate-700 dark:border-slate-700 dark:text-slate-200 font-semibold text-xs sm:text-sm transition shadow-xs">
                <svg class="w-4 h-4 text-slate-700 dark:text-slate-300" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                    <path d="M14 2v5a1 1 0 0 0 1 1h5M10 9H8M16 13H8M16 17H8" />
                </svg>
                <span>{{ __('landing.cta_catalog') }}</span>
            </a>
        </div>
    </div>
</section>
