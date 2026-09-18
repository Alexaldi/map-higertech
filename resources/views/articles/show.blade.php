@extends('layouts.app')

@section('title', $article->title . ' | Higertech')
@section('description', $article->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($article->content), 160))

@push('head')
    <style>
        .article-prose h2 { margin-top: 2.5rem; margin-bottom: 1rem; color: rgb(15 23 42); font-size: 1.5rem; font-weight: 800; line-height: 1.35; letter-spacing: -.02em; }
        .article-prose h3 { margin-top: 2rem; margin-bottom: 0.75rem; color: rgb(15 23 42); font-size: 1.25rem; font-weight: 700; line-height: 1.4; }
        .article-prose p { margin: 0 0 1.3rem; }
        .article-prose ul { margin: 0 0 1.5rem 1.3rem; list-style: disc; }
        .article-prose ol { margin: 0 0 1.5rem 1.3rem; list-style: decimal; }
        .article-prose li { padding-left: .4rem; margin-bottom: .5rem; }
        .article-prose blockquote { border-left: 4px solid #0284c7; padding-left: 1rem; color: #0369a1; font-style: italic; margin: 1.5rem 0; }
        .article-prose img { border-radius: 1rem; margin: 1.5rem 0; max-width: 100%; height: auto; }
        .article-prose table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; }
        .article-prose table th, .article-prose table td { border: 1px solid #cbd5e1; padding: 0.75rem; }
        .article-prose table th { background-color: #f1f5f9; font-weight: 700; }
        .article-prose .article-description-title { margin: 0; color: #1e3a8a; font-size: 1.25rem; }
        .article-description-rule { position: relative; margin-top: 1.15rem; height: 1px; background: rgb(148 163 184 / .55); }
        .article-description-rule span { position: absolute; left: 50%; top: -1px; width: 3.15rem; height: 3px; transform: translateX(-50%); background: #1d4ed8; }
        .dark .article-prose h2, .dark .article-prose h3 { color: #fff; }
        .dark .article-prose blockquote { border-color: #22d3ee; color: #67e8f9; }
        .dark .article-prose table th { background-color: #1e293b; color: #f8fafc; }
        .dark .article-prose table th, .dark .article-prose table td { border-color: #334155; }
        .dark .article-prose .article-description-title { color: #67e8f9; }
        .dark .article-description-rule { background: rgb(71 85 105); }
        .dark .article-description-rule span { background: #22d3ee; }
    </style>
@endpush

@section('content')
    <main class="bg-white dark:bg-[#0E1628] transition-colors duration-300">
        <section class="relative isolate overflow-hidden bg-slate-50 pb-14 pt-12 dark:bg-[#0B1120] sm:pb-20 sm:pt-16">
            <div class="map-grid-bg absolute inset-0 -z-10 opacity-60 dark:opacity-40"></div>
            <div class="absolute -right-20 top-0 -z-10 size-80 rounded-full bg-cyan-300/20 blur-3xl dark:bg-cyan-400/10"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-cyan-300">Beranda</a><span>/</span>
                    <a href="{{ route('articles') }}" class="hover:text-blue-600 dark:hover:text-cyan-300">Artikel</a><span>/</span>
                    <span class="text-slate-400 truncate max-w-xs">{{ $article->title }}</span>
                </nav>
                <div class="mt-10 max-w-4xl">
                    <span class="inline-block rounded-full bg-blue-100 dark:bg-cyan-950/60 px-3 py-1 text-xs font-bold text-blue-700 dark:text-cyan-400 mb-4">
                        {{ $article->category_name }}
                    </span>
                    <h1 class="text-4xl font-black leading-tight tracking-tight text-slate-950 dark:text-white sm:text-5xl lg:text-6xl">{{ $article->title }}</h1>
                    @if ($article->excerpt)
                        <p class="mt-6 max-w-3xl text-base leading-8 text-slate-600 dark:text-slate-300 sm:text-lg">{{ $article->excerpt }}</p>
                    @endif
                    <div class="mt-8 flex flex-wrap items-center gap-x-5 gap-y-3 text-xs font-semibold text-slate-500 dark:text-slate-400">
                        <span class="inline-flex items-center gap-2">
                            <span class="flex size-8 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700 dark:bg-cyan-400/15 dark:text-cyan-300">
                                {{ mb_substr($article->author ?: 'H', 0, 1) }}
                            </span>
                            {{ $article->author ?: 'Tim Higertech' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="size-4 text-cyan-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <path d="M3 9h18M8 2v3M16 2v3"/>
                            </svg>
                            {{ $article->formatted_date }}
                        </span>
                        <span>•</span>
                        <span>{{ $article->read_time_text }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="-mt-2 pb-20 sm:pb-28">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                @if ($article->image_url)
                    <figure class="overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 shadow-2xl shadow-blue-950/10 dark:border-slate-800 dark:bg-slate-900">
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="aspect-[16/8] w-full object-cover" fetchpriority="high">
                        <figcaption class="px-5 py-3 text-xs text-slate-500 dark:text-slate-400">Dokumentasi: {{ $article->title }}</figcaption>
                    </figure>
                @endif

                <div class="mt-12 grid gap-12 lg:grid-cols-[minmax(0,1fr)_260px]">
                    <article class="article-prose min-w-0 text-[17px] leading-8 text-slate-600 dark:text-slate-300">
                        <div class="mb-9">
                            <h2 class="article-description-title">Deskripsi Artikel</h2>
                            <div class="article-description-rule" aria-hidden="true"><span></span></div>
                        </div>

                        {!! $article->content !!}
                    </article>

                    {{-- Sidebar with recent articles --}}
                    <aside class="lg:pt-3">
                        <div class="sticky top-28 space-y-6">
                            @if (isset($recentArticles) && $recentArticles->isNotEmpty())
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#131D36]">
                                    <p class="text-[11px] font-extrabold uppercase tracking-[0.14em] text-blue-600 dark:text-cyan-400">
                                        Artikel Terbaru
                                    </p>
                                    <div class="mt-4 space-y-4">
                                        @foreach ($recentArticles as $recent)
                                            <a href="{{ route('articles.show', $recent->slug) }}" class="group block">
                                                <span class="text-xs text-slate-400 font-mono">{{ $recent->formatted_date }}</span>
                                                <h4 class="mt-1 text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition line-clamp-2 leading-snug">
                                                    {{ $recent->title }}
                                                </h4>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="rounded-2xl border border-blue-200/80 bg-blue-50/70 p-5 dark:border-cyan-400/20 dark:bg-[#131D36]">
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Konsultasi Telemetri?</h4>
                                <p class="mt-2 text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                    Diskusikan kebutuhan instrumen dan stasiun monitoring Anda bersama tim ahli Higertech.
                                </p>
                                <a href="https://wa.me/628112332182" target="_blank" rel="noopener noreferrer"
                                    class="mt-4 block w-full rounded-xl bg-blue-600 py-2.5 px-3 text-center text-xs font-bold text-white shadow-sm hover:bg-blue-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 transition">
                                    Hubungi Tim Kami
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>

                <div class="mt-14 flex flex-col items-start justify-between gap-5 border-t border-slate-200 pt-8 dark:border-slate-800 sm:flex-row sm:items-center">
                    <a href="{{ route('articles') }}" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-cyan-600 dark:text-cyan-400">
                        <span aria-hidden="true">←</span> Kembali ke semua artikel
                    </a>
                    <a href="https://wa.me/628112332182" target="_blank" rel="noopener noreferrer"
                        class="rounded-xl bg-blue-600 px-5 py-3 text-xs font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">
                        Konsultasi kebutuhan telemetri
                    </a>
                </div>
            </div>
        </section>
    </main>
    @include('landing.partials.footer')
@endsection

