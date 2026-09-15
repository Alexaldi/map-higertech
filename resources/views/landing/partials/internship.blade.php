<section id="internship"
    class="py-20 bg-gradient-to-b from-slate-50 via-cyan-50/30 to-white dark:from-[#0E1628] dark:via-[#09101f] dark:to-[#0B1120] border-t border-slate-200/80 dark:border-slate-800 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center max-w-3xl mx-auto mb-14 scroll-reveal">
            <div
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-100 dark:bg-cyan-950/70 border border-cyan-300 dark:border-cyan-700 text-cyan-800 dark:text-cyan-300 text-xs font-bold mb-3">
                <svg class="w-3.5 h-3.5 text-cyan-600 dark:text-cyan-400 animate-bounce" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z" />
                    <path d="M20 2v4M22 4h-4" />
                    <circle cx="4" cy="20" r="2" />
                </svg>
                <span>{{ __('landing.intern_label') }}</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                {{ __('landing.intern_title') }}</h2>
            <p class="mt-3 text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
                {{ __('landing.intern_desc') }}</p>
        </div>

        <div
            class="rounded-3xl bg-white dark:bg-[#131D36] border-2 border-cyan-500/40 shadow-xl p-6 sm:p-10 relative overflow-hidden scroll-reveal scroll-reveal-scale">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                {{-- Roles --}}
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span
                            class="px-3 py-1 rounded-md bg-emerald-500 text-white font-mono font-bold text-xs">{{ __('landing.intern_batch') }}</span>
                        <span
                            class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ __('landing.intern_location') }}</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                        {{ __('landing.intern_positions_title') }}</h3>

                    <div class="space-y-4">
                        @foreach ([['color' => 'bg-blue-600', 'title' => __('landing.intern_role1_title'), 'desc' => __('landing.intern_role1_desc'), 'icon' => '<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="8" y="8" width="8" rx="1" height="8"/>'], ['color' => 'bg-emerald-600', 'title' => __('landing.intern_role2_title'), 'desc' => __('landing.intern_role2_desc'), 'icon' => '<path d="m12 14 4-4M3.34 19a10 10 0 1 1 17.32 0"/>'], ['color' => 'bg-purple-600', 'title' => __('landing.intern_role3_title'), 'desc' => __('landing.intern_role3_desc'), 'icon' => '<rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>']] as $role)
                            <div
                                class="p-4 rounded-2xl bg-slate-50 dark:bg-[#0c1626] border border-slate-200 dark:border-slate-800 hover:border-cyan-400 transition flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl {{ $role['color'] }} text-white flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" aria-hidden="true">{!! $role['icon'] !!}</svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm sm:text-base text-slate-900 dark:text-white">
                                        {{ $role['title'] }}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                        {{ $role['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <span
                            class="text-xs font-mono font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-2">{{ __('landing.intern_benefit_label') }}</span>
                        <div class="flex flex-wrap gap-2 text-xs">
                            @foreach ([__('landing.intern_benefit_1'), __('landing.intern_benefit_2'), __('landing.intern_benefit_3'), __('landing.intern_benefit_4')] as $benefit)
                                <span
                                    class="px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium">{{ $benefit }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- CTA Box --}}
                <div class="lg:col-span-5">
                    <div
                        class="bg-gradient-to-br from-blue-50/90 via-indigo-50/60 to-slate-50 dark:from-[#0c1626] dark:via-[#111C38] dark:to-[#080d19] rounded-2xl p-6 sm:p-8 text-slate-900 dark:text-white shadow-xl border border-blue-200/80 dark:border-slate-700/80">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-600/10 dark:bg-cyan-400/15 text-blue-600 dark:text-cyan-300 flex items-center justify-center mb-4 border border-blue-200/50 dark:border-cyan-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11zM21.854 2.147l-10.94 10.939" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                            {{ __('landing.intern_cta_title') }}</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2 leading-relaxed">
                            {{ __('landing.intern_cta_desc') }}</p>

                        <div
                            class="my-6 p-4 rounded-xl bg-white dark:bg-[#070e1b] border border-blue-200/60 dark:border-slate-700/80 space-y-2 text-xs shadow-xs">
                            <div class="flex justify-between text-slate-600 dark:text-slate-300">
                                <span>{{ __('landing.intern_deadline') }}</span>
                                <span class="font-bold text-amber-600 dark:text-amber-400 font-mono">31 Juli 2025</span>
                            </div>
                            <div class="flex justify-between text-slate-600 dark:text-slate-300">
                                <span>{{ __('landing.intern_duration') }}</span>
                                <span class="font-bold text-slate-900 dark:text-white font-mono">3 - 6 Bulan</span>
                            </div>
                            <div class="flex justify-between text-slate-600 dark:text-slate-300">
                                <span>{{ __('landing.intern_method') }}</span>
                                <span class="font-bold text-blue-600 dark:text-cyan-400 font-mono">Hybrid (Lab &
                                    Field)</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <a href="mailto:higertechkaryasinergi@gmail.com?subject=Aplikasi%20Magang%20Higertech%20Batch%202025"
                                class="w-full inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl bg-blue-600 hover:bg-blue-700 text-white dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 font-bold text-sm transition shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                    <path d="M14 2v5a1 1 0 0 0 1 1h5M9 15l2 2 4-4" />
                                </svg>
                                <span>{{ __('landing.intern_register') }}</span>
                            </a>
                            <a href="https://wa.me/628112332182?text=Halo%20Admin%20Higertech%2C%20saya%20ingin%20bertanya%20mengenai%20program%20magang"
                                target="_blank"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-6 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-800 dark:bg-slate-800/80 dark:hover:bg-slate-700 dark:border-slate-700 dark:text-slate-200 font-semibold text-xs transition shadow-xs">
                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719" />
                                </svg>
                                <span>{{ __('landing.intern_wa') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
