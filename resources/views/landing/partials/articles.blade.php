@php
    $articlesList = collect($homeArticles ?? []);
@endphp

@if ($articlesList->isNotEmpty())
<section id="articles" class="py-20 bg-slate-50/50 dark:bg-[#0E1628] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 scroll-reveal">
            <span
                class="text-blue-600 dark:text-cyan-400 font-bold text-xs uppercase tracking-wider block mb-1">{{ __('landing.articles_label') }}</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                {{ __('landing.articles_title') }} <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-400 dark:to-blue-400">{{ __('landing.articles_title_highlight') }}</span>
                {{ __('landing.articles_title_end') }}
            </h2>
        </div>

        @php
            $art1 = $articlesList->get(0);
            $art2 = $articlesList->get(1);
            $art3 = $articlesList->get(2);
            $art4 = $articlesList->get(3);
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 scroll-reveal scroll-reveal-scale">
            {{-- Featured Card 1 (Left column) --}}
            @if ($art1)
                <article
                    class="lg:col-span-4 bg-white dark:bg-[#131D36] rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <div class="relative h-64 overflow-hidden bg-slate-100 dark:bg-slate-800">
                        <span
                            class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full bg-white/90 dark:bg-slate-900/90 backdrop-blur text-blue-700 dark:text-cyan-400 text-[11px] font-bold shadow-sm">
                            {{ $art1->category_name }}
                        </span>
                        <a href="{{ route('articles.show', $art1->slug) }}" class="block w-full h-full">
                            <img alt="{{ $art1->title }}" width="400" height="256"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                src="{{ $art1->image_url }}" loading="lazy" decoding="async">
                        </a>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3
                                class="font-bold text-lg text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug">
                                <a href="{{ route('articles.show', $art1->slug) }}">
                                    {{ $art1->title }}
                                </a>
                            </h3>
                            @if ($art1->excerpt)
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2.5 line-clamp-3">
                                    {{ $art1->excerpt }}
                                </p>
                            @endif
                        </div>
                        <div
                            class="pt-6 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <path d="M3 9h18M8 2v3M16 2v3" />
                                </svg>
                                {{ $art1->formatted_date }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                                {{ $art1->read_time_text }}
                            </span>
                        </div>
                    </div>
                </article>
            @endif

            {{-- Right Column --}}
            <div class="lg:col-span-8 flex flex-col gap-8">
                {{-- Featured Card 2 --}}
                @if ($art2)
                    <article
                        class="rounded-3xl bg-gradient-to-r from-blue-50/90 via-indigo-50/60 to-slate-50 dark:from-[#16275E] dark:via-indigo-900 dark:to-[#0B1120] text-slate-900 dark:text-white p-6 sm:p-8 flex flex-col sm:flex-row gap-6 items-center shadow-sm hover:shadow-xl border border-blue-200/80 dark:border-white/10 group transition-all duration-300">
                        <div
                            class="w-full sm:w-48 h-40 rounded-2xl overflow-hidden flex-shrink-0 bg-white shadow-inner border border-slate-200/60 dark:border-transparent">
                            <a href="{{ route('articles.show', $art2->slug) }}" class="block w-full h-full">
                                <img alt="{{ $art2->title }}" width="200" height="160"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    src="{{ $art2->image_url }}" loading="lazy" decoding="async">
                            </a>
                        </div>
                        <div class="flex-1 space-y-3">
                            <span
                                class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 border border-blue-200 dark:bg-cyan-400/20 dark:text-cyan-300 dark:border-cyan-400/30 text-[11px] font-semibold">
                                {{ $art2->category_name }}
                            </span>
                            <h3
                                class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-300 transition">
                                <a href="{{ route('articles.show', $art2->slug) }}">
                                    {{ $art2->title }}
                                </a>
                            </h3>
                            @if ($art2->excerpt)
                                <p
                                    class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-2">
                                    {{ $art2->excerpt }}
                                </p>
                            @endif
                            <div
                                class="flex items-center gap-6 text-xs text-slate-500 dark:text-slate-300 pt-2 font-mono">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <path d="M3 9h18M8 2v3M16 2v3" />
                                    </svg>
                                    {{ $art2->formatted_date }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M12 6v6l4 2" />
                                    </svg>
                                    {{ $art2->read_time_text }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endif

                {{-- Bottom 2 cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @if ($art3)
                        <article
                            class="bg-white dark:bg-[#131D36] rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                            <div class="relative h-48 overflow-hidden bg-slate-100 dark:bg-slate-800">
                                <span
                                    class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full bg-white/90 dark:bg-slate-900/90 backdrop-blur text-blue-700 dark:text-cyan-400 text-[11px] font-bold shadow-sm">
                                    {{ $art3->category_name }}
                                </span>
                                <a href="{{ route('articles.show', $art3->slug) }}" class="block w-full h-full">
                                    <img alt="{{ $art3->title }}" width="300" height="192"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                        src="{{ $art3->image_url }}" loading="lazy" decoding="async">
                                </a>
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <h3
                                    class="font-bold text-base text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug line-clamp-2">
                                    <a href="{{ route('articles.show', $art3->slug) }}">
                                        {{ $art3->title }}
                                    </a>
                                </h3>
                                <div
                                    class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400 font-mono">
                                    <span>{{ $art3->formatted_date }}</span>
                                    <span>{{ $art3->read_time_text }}</span>
                                </div>
                            </div>
                        </article>
                    @endif

                    @if ($art4)
                        <article
                            class="bg-white dark:bg-[#131D36] rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                            <div class="relative h-48 overflow-hidden bg-slate-100 dark:bg-slate-800">
                                <span
                                    class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full bg-cyan-500 text-slate-950 text-[11px] font-bold shadow-sm">
                                    {{ $art4->category_name }}
                                </span>
                                <a href="{{ route('articles.show', $art4->slug) }}" class="block w-full h-full">
                                    <img alt="{{ $art4->title }}" width="300" height="192"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                        src="{{ $art4->image_url }}" loading="lazy" decoding="async">
                                </a>
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <h3
                                    class="font-bold text-base text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug line-clamp-2">
                                    <a href="{{ route('articles.show', $art4->slug) }}">
                                        {{ $art4->title }}
                                    </a>
                                </h3>
                                <div
                                    class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400 font-mono">
                                    <span>{{ $art4->formatted_date }}</span>
                                    <span>{{ $art4->read_time_text }}</span>
                                </div>
                            </div>
                        </article>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif
