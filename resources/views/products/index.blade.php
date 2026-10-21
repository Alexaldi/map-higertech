@extends('layouts.app')
@section('title', ($selectedCategory ? $selectedCategory->short_name . ' | ' : '') . 'Katalog Produk - Higertech')
@section('content')

<main data-product-catalog>
    <section class="border-b border-slate-200 bg-white py-10 dark:border-slate-800 dark:bg-brand-surface-dark sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600 dark:text-cyan-400">Katalog Produk</p>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 dark:text-white sm:text-4xl">Perangkat untuk setiap kebutuhan.</h1>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">Jelajahi seluruh produk Higertech, cari perangkat yang Anda butuhkan, dan temukan solusi sesuai kategori.</p>
        </div>
    </section>

    <section id="catalog" class="bg-slate-50 py-8 dark:bg-brand-surface-dark sm:py-10">
        <div class="mx-auto grid max-w-7xl items-start gap-6 px-4 sm:px-6 lg:grid-cols-[250px_minmax(0,1fr)] lg:gap-8 lg:px-8">
            <aside class="min-w-0 lg:sticky lg:top-28" aria-label="Filter kategori produk">
                <details data-product-filters open class="rounded-2xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-brand-card-dark">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-5 py-5 text-sm font-bold text-slate-900 dark:text-white">
                        <span>Filter Kategori</span>
                        <svg class="h-4 w-4 shrink-0 lg:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <nav class="space-y-1 border-t border-slate-100 p-3 dark:border-slate-800" aria-label="Kategori produk">
                        <a href="{{ route('products', ['q' => $search ?: null]) }}" data-category-all
                            @if (! $selectedCategory) aria-current="true" @endif
                            class="flex items-center justify-between gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition-colors {{ ! $selectedCategory ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/70 dark:text-cyan-300' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                            <span>Semua Produk</span><span class="text-xs tabular-nums">{{ $categories->sum('products_count') }}</span>
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('products', ['category' => $category->id, 'q' => $search ?: null]) }}" data-category-id="{{ $category->id }}"
                                @if ($selectedCategory?->id === $category->id) aria-current="true" @endif
                                class="flex items-start justify-between gap-3 rounded-xl px-3 py-3 text-xs font-medium leading-5 transition-colors {{ $selectedCategory?->id === $category->id ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/70 dark:text-cyan-300' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                                <span>{{ $category->name }}</span><span class="shrink-0 text-xs tabular-nums">{{ $category->products_count }}</span>
                            </a>
                        @endforeach
                    </nav>
                </details>
            </aside>

            <div class="min-w-0">
                <form action="{{ route('products') }}" method="GET" role="search" class="mb-6">
                    <label for="product-search" class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200">Cari produk</label>
                    @if ($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory->id }}">
                    @endif
                    <div class="flex gap-2">
                        <div class="relative min-w-0 flex-1">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 4.5 4.5"/></svg>
                            <input id="product-search" name="q" type="search" maxlength="100" value="{{ $search }}" placeholder="Nama atau deskripsi produk..." class="h-12 w-full rounded-xl border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-brand-card-dark dark:text-white">
                        </div>
                        <button type="submit" class="h-12 rounded-xl bg-brand-900 px-5 text-sm font-bold text-white transition-colors hover:bg-blue-800 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Cari</button>
                    </div>
                    @error('q')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </form>

                <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                    <h2 class="text-sm text-slate-600 dark:text-slate-400"><strong class="font-bold text-slate-950 dark:text-white">{{ $products->total() }} produk</strong>{{ $search !== '' ? ' untuk “'.$search.'”' : ' tersedia' }}</h2>
                    @if ($search !== '' || $selectedCategory)
                        <a href="{{ route('products') }}" class="text-xs font-semibold text-blue-700 hover:underline dark:text-cyan-300">Reset pencarian &amp; filter</a>
                    @endif
                </div>
                @if ($selectedCategory)
                    <p class="mb-5 inline-flex rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 dark:bg-blue-950/70 dark:text-cyan-300">{{ $selectedCategory->name }}</p>
                @endif

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    @forelse ($products as $product)
                        @php($photos = $product->gallery_urls)
                        <article data-product-card data-images="{{ json_encode($photos) }}" class="product-catalog-card group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-lg dark:border-slate-800 dark:bg-brand-card-dark">
                            <div class="relative overflow-hidden border-b border-slate-100 bg-white dark:border-slate-800">
                                <a href="{{ route('products.show', $product->slug) }}" class="block aspect-[4/3]" aria-label="Lihat detail {{ $product->title }}">
                                    <img data-card-image src="{{ $photos[0] }}" alt="{{ $product->title }}" width="700" height="525" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async" class="h-full w-full object-contain p-3 sm:p-4" data-image-fallback="{{ asset('assets/images/products.png') }}">
                                </a>
                                @if (count($photos) > 1)
                                    <button data-card-pause type="button" aria-label="Jeda slideshow {{ $product->title }}" aria-pressed="false" class="absolute left-3 top-3 flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white/95 text-brand-900 shadow-sm">
                                        <svg data-pause-icon class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 5h4v14H7zm6 0h4v14h-4z"/></svg>
                                        <svg data-play-icon hidden class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m8 4 12 8-12 8z"/></svg>
                                    </button>
                                    <button data-card-prev type="button" aria-label="Foto sebelumnya: {{ $product->title }}" class="absolute left-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white/95 text-lg text-brand-900 shadow-sm">&larr;</button>
                                    <button data-card-next type="button" aria-label="Foto berikutnya: {{ $product->title }}" class="absolute right-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white/95 text-lg text-brand-900 shadow-sm">&rarr;</button>
                                    <span data-card-counter aria-hidden="true" class="absolute bottom-3 right-3 rounded-full bg-slate-950/75 px-3 py-1 text-[11px] font-semibold tabular-nums text-white">1 / {{ count($photos) }}</span>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-5 sm:p-6">
                                <span class="w-fit rounded-full bg-blue-50 px-2.5 py-1 text-[11px] font-bold text-blue-700 dark:bg-blue-950/70 dark:text-cyan-300">{{ $product->category->short_name ?? 'Produk' }}</span>
                                <h3 class="mt-3 text-lg font-bold leading-snug text-slate-950 dark:text-white"><a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-700 dark:hover:text-cyan-300">{{ $product->title }}</a></h3>
                                <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $product->desc }}</p>
                                <a href="{{ route('products.show', $product->slug) }}" class="mt-auto flex items-center justify-between gap-3 pt-5 text-sm font-bold text-blue-700 dark:text-cyan-300"><span>Lihat Detail</span><span aria-hidden="true">&rarr;</span></a>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center dark:border-slate-700 dark:bg-brand-card-dark">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Produk tidak ditemukan</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">Coba kata kunci lain atau pilih kategori berbeda.</p>
                            <a href="{{ route('products') }}" class="mt-5 inline-flex rounded-xl bg-brand-900 px-5 py-3 text-sm font-semibold text-white dark:bg-cyan-500 dark:text-slate-950">Lihat semua produk</a>
                        </div>
                    @endforelse
                </div>

                @if ($products->hasPages())
                    <div class="mt-10">{{ $products->links() }}</div>
                @endif
            </div>
        </div>
    </section>
</main>
@include('landing.partials.footer')
@endsection
