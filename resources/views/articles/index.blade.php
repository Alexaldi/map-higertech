@extends('layouts.app')

@section('title', 'Artikel & Panduan | Higertech Karya Sinergi')
@section('description', 'Artikel, panduan teknis, dan cerita implementasi solusi telemetri Higertech.')

@section('content')
    <main class="overflow-hidden">
        <section class="relative isolate bg-slate-50 dark:bg-[#0B1120] pt-16 pb-20 sm:pt-24 sm:pb-28 transition-colors duration-300">
            <div class="absolute inset-0 -z-10 overflow-hidden">
                <div class="absolute -top-28 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-blue-400/20 blur-3xl dark:bg-cyan-400/10"></div>
                <div class="absolute right-0 top-20 h-72 w-72 rounded-full bg-indigo-400/15 blur-3xl dark:bg-blue-700/15"></div>
                <div class="map-grid-bg absolute inset-0 opacity-70 dark:opacity-50"></div>
            </div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="mt-8 inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white/80 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.16em] text-blue-700 shadow-sm dark:border-cyan-400/20 dark:bg-cyan-400/10 dark:text-cyan-300">
                    <span class="size-1.5 rounded-full bg-cyan-500 animate-pulse"></span> Knowledge hub Higertech
                </div>
                <h1 class="mt-6 text-4xl sm:text-6xl font-black tracking-tight text-slate-950 dark:text-white">{{ __('landing.subab1') }}<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-300 dark:to-blue-400">{{ __('landing.subab2') }}</span></h1>
                <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-300">{{ __('landing.desc') }}</p>
                <div class="mx-auto mt-9 max-w-xl relative">
                    <label for="article-search" class="sr-only">Cari artikel</label>
                    <svg class="pointer-events-none absolute left-5 top-1/2 size-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                    <input id="article-search" type="search" placeholder="{{ __('landing.placeholder.search') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-12 py-4 text-sm text-slate-800 shadow-xl shadow-blue-950/5 outline-none placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#131D36] dark:text-white dark:focus:border-cyan-400 dark:focus:ring-cyan-400/10">
                </div>
            </div>
        </section>

        <section class="bg-white py-16 dark:bg-[#0E1628] sm:py-20 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="border-b border-slate-200 pb-8 dark:border-slate-800 flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-cyan-400">{{ __('landing.articles_label') }}</p>
                        <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">{{ __('landing.article_desc1') }}<br>{{ __('landing.article_desc2') }}</h2>
                    </div>

                    @if (isset($categories) && $categories->isNotEmpty())
                        <div class="flex flex-wrap items-center gap-2" id="category-filters">
                            <button type="button" data-filter="all" class="category-btn px-4 py-1.5 rounded-full text-xs font-bold transition bg-blue-600 text-white shadow-sm">
                                Semua
                            </button>
                            @foreach ($categories as $cat)
                                <button type="button" data-filter="{{ strtolower($cat) }}" class="category-btn px-4 py-1.5 rounded-full text-xs font-bold transition bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                                    {{ $cat }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div id="article-grid" class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($articles as $article)
                        <article data-category="{{ strtolower($article->category_name) }}"
                            data-search="{{ strtolower($article->title . ' ' . $article->excerpt . ' ' . $article->category_name) }}"
                            class="article-card group flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-[#131D36] {{ ($loop->first && $articles->count() > 1) ? 'lg:col-span-2 lg:flex-row' : '' }}">
                            <div class="relative {{ ($loop->first && $articles->count() > 1) ? 'lg:w-1/2 lg:min-h-full' : 'h-52' }} overflow-hidden bg-slate-100 dark:bg-slate-800">
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="size-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                                <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[10px] font-extrabold text-blue-700 shadow-sm backdrop-blur dark:bg-slate-950/80 dark:text-cyan-300">
                                    {{ $article->category_name }}
                                </span>
                            </div>
                            <div class="flex flex-1 flex-col p-6 {{ ($loop->first && $articles->count() > 1) ? 'lg:p-8' : '' }}">
                                <p class="text-xs font-mono text-slate-400">{{ $article->formatted_date }}</p>
                                <h3 class="mt-3 text-xl font-bold leading-snug text-slate-900 transition group-hover:text-blue-600 dark:text-white dark:group-hover:text-cyan-300 {{ ($loop->first && $articles->count() > 1) ? 'lg:text-2xl' : '' }}">
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                @if ($article->excerpt)
                                    <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400 line-clamp-3">
                                        {{ $article->excerpt }}
                                    </p>
                                @endif
                                <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-5 mt-6 text-xs font-semibold text-slate-400 dark:border-slate-800">
                                    <span>{{ $article->read_time_text }}</span>
                                    <a href="{{ route('articles.show', $article->slug) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-cyan-600 dark:text-cyan-400 font-bold" aria-label="Baca {{ $article->title }}">
                                        Baca artikel <span aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <p class="text-base font-semibold text-slate-600 dark:text-slate-300">Belum ada artikel yang dipublikasikan.</p>
                        </div>
                    @endforelse
                </div>
                <p id="article-empty" class="hidden py-16 text-center text-sm text-slate-500 dark:text-slate-400">Artikel tidak ditemukan. Coba kata kunci lain.</p>
            </div>
        </section>
    </main>
    @include('landing.partials.cta')
    @include('landing.partials.footer')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const search = document.getElementById('article-search');
            const cards = document.querySelectorAll('.article-card');
            const empty = document.getElementById('article-empty');
            const categoryBtns = document.querySelectorAll('.category-btn');
            let activeCategory = 'all';

            const filter = () => {
                let visible = 0;
                const term = search.value.toLowerCase().trim();

                cards.forEach(card => {
                    const matchesSearch = card.dataset.search.includes(term);
                    const matchesCat = (activeCategory === 'all') || (card.dataset.category === activeCategory);
                    const show = matchesSearch && matchesCat;
                    card.classList.toggle('hidden', !show);
                    if (show) visible++;
                });

                if (empty) {
                    empty.classList.toggle('hidden', visible !== 0);
                }
            };

            if (search) {
                search.addEventListener('input', filter);
            }

            categoryBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    activeCategory = btn.dataset.filter;
                    categoryBtns.forEach(b => {
                        b.classList.remove('bg-blue-600', 'text-white');
                        b.classList.add('bg-slate-100', 'text-slate-700', 'dark:bg-slate-800', 'dark:text-slate-300');
                    });
                    btn.classList.add('bg-blue-600', 'text-white');
                    btn.classList.remove('bg-slate-100', 'text-slate-700', 'dark:bg-slate-800', 'dark:text-slate-300');
                    filter();
                });
            });
        });
    </script>
@endpush
