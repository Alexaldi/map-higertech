@extends('layouts.app')

@section('title', 'Tutorial & Panduan Teknis | Higertech Karya Sinergi')
@section('description', 'Tutorial langkah demi langkah untuk sistem monitoring, hidrologi, IoT, dan perangkat telemetri Higertech.')

@section('content')
    <main class="overflow-hidden">
        <section class="relative isolate bg-slate-50 pb-20 pt-16 dark:bg-[#0B1120] sm:pb-28 sm:pt-24 transition-colors duration-300">
            <div class="map-grid-bg absolute inset-0 -z-10 opacity-70 dark:opacity-50"></div>
            <div class="absolute -left-24 top-6 -z-10 size-80 rounded-full bg-blue-400/20 blur-3xl dark:bg-blue-700/15"></div>
            <div class="absolute -right-20 bottom-0 -z-10 size-80 rounded-full bg-cyan-300/25 blur-3xl dark:bg-cyan-400/10"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="mt-8 inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white/80 px-4 py-2 text-[11px] font-bold uppercase tracking-[.16em] text-blue-700 shadow-sm dark:border-cyan-400/20 dark:bg-cyan-400/10 dark:text-cyan-300"><span class="size-1.5 rounded-full bg-cyan-500 animate-pulse"></span> Learning center Higertech</div>
                <h1 class="mt-6 text-4xl font-black tracking-tight text-slate-950 dark:text-white sm:text-6xl">{{ __('landing.tutorials_title') }}<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-300 dark:to-blue-400">{{ __('landing.tutorials_title_highlight') }}</span></h1>
                <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-300">{{ __('landing.tutorials_title_desc') }}</p>
                <div class="mx-auto mt-9 max-w-xl relative">
                    <form action="{{ route('tutorials') }}" method="GET" class="w-full">
                        <label for="tutorial-search" class="sr-only">Cari tutorial</label>
                        <svg class="pointer-events-none absolute left-5 top-1/2 size-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                        <input id="tutorial-search" name="q" value="{{ request('q') }}" type="search" placeholder="{{ __('landing.tutorials_placeholder.search') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-12 py-4 text-sm text-slate-800 shadow-xl shadow-blue-950/5 outline-none placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#131D36] dark:text-white dark:focus:border-cyan-400 dark:focus:ring-cyan-400/10">
                        @if(request('type'))
                            <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif
                    </form>
                </div>
            </div>
        </section>

        <section class="bg-white py-16 dark:bg-[#0E1628] sm:py-20 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-slate-200 pb-8 dark:border-slate-800">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-blue-600 dark:text-cyan-400">{{ __('landing.tutorials_label') }}</p>
                        <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">{{ __('landing.tutorials_title1') }}<br>{{ __('landing.tutorials_title2') }}</h2>
                    </div>
                    @if($types && $types->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('tutorials', ['q' => request('q')]) }}" class="rounded-full px-4 py-2 text-xs font-semibold transition-colors {{ !request('type') ? 'bg-blue-600 text-white dark:bg-cyan-500 dark:text-slate-900' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">Semua</a>
                            @foreach($types as $typeOption)
                                <a href="{{ route('tutorials', ['type' => $typeOption, 'q' => request('q')]) }}" class="rounded-full px-4 py-2 text-xs font-semibold transition-colors {{ request('type') === $typeOption ? 'bg-blue-600 text-white dark:bg-cyan-500 dark:text-slate-900' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">{{ $typeOption }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div id="tutorial-grid" class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($tutorials as $tutorial)
                        <a href="{{ route('tutorials.show', $tutorial->slug) }}" class="tutorial-card group flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-[#131D36]">
                            <div class="relative h-56 overflow-hidden bg-slate-100 dark:bg-slate-800">
                                <img src="{{ $tutorial->image_url }}" alt="{{ $tutorial->title }}" class="size-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                                @if($tutorial->type)
                                    <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[10px] font-extrabold text-blue-700 shadow-sm backdrop-blur dark:bg-slate-950/80 dark:text-cyan-300">{{ $tutorial->type }}</span>
                                @endif
                                <span class="absolute bottom-4 right-4 flex size-10 items-center justify-center rounded-full bg-blue-600 text-white shadow-lg transition-transform duration-300 group-hover:scale-110 dark:bg-cyan-400 dark:text-slate-950"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3l14 9-14 9V3z"/></svg></span>
                            </div>
                            <div class="flex flex-1 flex-col p-6">
                                <p class="text-xs font-mono text-slate-400">{{ $tutorial->duration_text }} pembelajaran</p>
                                <h3 class="mt-3 text-xl font-bold leading-snug text-slate-900 transition group-hover:text-blue-600 dark:text-white dark:group-hover:text-cyan-300">{{ $tutorial->title }}</h3>
                                <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400 line-clamp-2">{{ $tutorial->excerpt ?? strip_tags(Str::limit($tutorial->content, 120)) }}</p>
                                <div class="mt-auto border-t border-slate-100 pt-5 mt-6 text-xs font-bold text-blue-600 dark:border-slate-800 dark:text-cyan-400">Mulai belajar <span aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1 inline-block">→</span></div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <p class="text-slate-500 dark:text-slate-400">{{ __('landing.tutorials_not_found') ?? 'Tutorial tidak ditemukan.' }}</p>
                            @if(request('q') || request('type'))
                                <a href="{{ route('tutorials') }}" class="mt-4 inline-block text-blue-600 dark:text-cyan-400 text-sm font-semibold hover:underline">Lihat semua tutorial</a>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
    @include('landing.partials.cta')
    @include('landing.partials.footer')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const search = document.getElementById('tutorial-search');
            const cards = document.querySelectorAll('.tutorial-card');
            const empty = document.getElementById('tutorial-empty');
            search.addEventListener('input', () => { let visible = 0; const term = search.value.toLowerCase().trim(); cards.forEach(card => { const show = card.dataset.search.includes(term); card.classList.toggle('hidden', !show); if (show) visible++; }); empty.classList.toggle('hidden', visible !== 0); });
        });
    </script>
@endpush
