@extends('layouts.app')
@section('title', $product->title . ' - Higertech Karya Sinergi')
@section('description', $product->desc ?: $product->title)
@section('content')

<main data-product-detail>
    <section class="product-detail-hero relative isolate overflow-hidden py-12 text-white sm:py-16 lg:py-20">
        <canvas data-product-network class="pointer-events-none absolute inset-0 h-full w-full" aria-hidden="true"></canvas>
        <div class="relative mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-5 flex flex-wrap items-center gap-2 text-xs text-cyan-100/80">
                <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('products') }}" class="hover:text-white">Produk</a>
                @if ($product->category)
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('products', ['category' => $product->category_id]) }}" class="hover:text-white">{{ $product->category->short_name }}</a>
                @endif
            </nav>
            <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-cyan-200">Produk</p>
            <h1 class="mt-3 max-w-4xl text-2xl font-extrabold leading-snug sm:text-3xl lg:text-4xl">{{ $product->title }}</h1>
            @if ($product->category)
                <a href="{{ route('products', ['category' => $product->category_id]) }}" class="mt-4 inline-flex rounded-full bg-blue-600 px-3 py-1 text-xs font-bold text-white hover:bg-blue-500">{{ $product->category->short_name ?? $product->category->name }}</a>
            @endif
        </div>
    </section>

    <section class="bg-white py-10 dark:bg-brand-surface-dark sm:py-14 lg:py-20">
        <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="grid items-start gap-8 sm:gap-10 lg:grid-cols-[minmax(0,340px)_minmax(0,1fr)] lg:gap-x-12 xl:grid-cols-[minmax(0,360px)_minmax(0,1fr)]">
                <div class="mx-auto w-full max-w-md lg:mx-0 lg:max-w-none">
                    <a href="{{ $galleryImages[0] }}" data-gallery-open class="group relative block aspect-square overflow-hidden rounded-xl bg-white ring-1 ring-slate-200" aria-label="Perbesar foto {{ $product->title }}">
                        <img data-gallery-main src="{{ $galleryImages[0] }}" alt="{{ $product->title }}" width="700" height="700" class="h-full w-full object-contain transition-transform duration-300 group-hover:scale-[1.02]" data-image-fallback="{{ asset('assets/images/products.png') }}">
                        <span class="absolute inset-x-0 bottom-4 mx-auto w-fit rounded-full bg-white/95 px-3.5 py-1.5 text-xs font-semibold text-brand-900 opacity-0 shadow transition-opacity group-hover:opacity-100 group-focus-visible:opacity-100">Klik untuk memperbesar</span>
                    </a>
                    @if (count($galleryImages) > 1)
                        <div class="product-detail-thumbnails mt-3 flex gap-2 overflow-x-auto pb-1" aria-label="Foto produk">
                            @foreach ($galleryImages as $image)
                                <button type="button" data-gallery-thumb="{{ $loop->index }}" aria-label="Foto {{ $loop->iteration }}: {{ $product->title }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" class="aspect-square shrink-0 overflow-hidden rounded-lg border-2 bg-white">
                                    <img src="{{ $image }}" alt="" width="100" height="100" loading="lazy" class="h-full w-full object-contain" data-image-fallback="{{ asset('assets/images/products.png') }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                    <div class="mt-8 space-y-2.5">
                        @if ($product->brochure_url)
                        <a href="{{ $product->brochure_url }}" download="{{ $product->slug }}-brosur.pdf" class="flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#2f39a3] px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#3f4fc4]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 3v12m-5-5 5 5 5-5M5 21h14"/></svg>
                            Unduh Brosur
                        </a>
                        @endif
                        <a href="{{ $product->ecatalog_url }}" target="_blank" rel="noopener noreferrer" class="flex min-h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-brand-800 transition-colors hover:bg-brand-50 dark:border-slate-700 dark:bg-brand-card-dark dark:text-slate-100">
                            <img src="{{ asset('images/products/inaproc-logo.png') }}" alt="" width="20" height="20" class="h-5 w-5 rounded object-contain">
                            Lihat di INAPROC
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m7 17 10-10M8 7h9v9"/></svg>
                        </a>
                    </div>
                </div>
                <div class="min-w-0 space-y-8">
                    <div>
                        <h2 class="product-detail-heading">Deskripsi Produk</h2>
                        <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600 [overflow-wrap:anywhere] dark:text-slate-300 sm:text-base">{{ $product->desc ?: 'Deskripsi produk belum tersedia. Hubungi tim kami untuk informasi lebih lanjut.' }}</p>
                    </div>
                    <div>
                        <h2 class="product-detail-heading">Spesifikasi</h2>
                        <dl class="product-detail-specs mt-4 text-sm">
                            <div><dt>Produk</dt><dd>{{ $product->title }}</dd></div>
                            @if ($product->category)
                                <div><dt>Kategori</dt><dd>{{ $product->category->name }}</dd></div>
                            @endif
                        </dl>
                        <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">Untuk spesifikasi teknis lengkap dan dokumen TKDN produk ini, lihat katalog INAPROC atau hubungi tim kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-detail-cta px-5 py-14 text-center text-white sm:py-20">
        <h2 class="text-2xl font-extrabold sm:text-3xl">Butuh produk untuk proyek Anda?</h2>
        <p class="mx-auto mt-3 max-w-lg text-sm leading-7 text-indigo-200">Tim kami siap membantu memilih perangkat dan merancang arsitektur sistem yang tepat.</p>
        <a href="{{ route('contact') }}" class="mt-7 inline-flex items-center justify-center rounded-full bg-cyan-500 px-7 py-3.5 text-sm font-bold text-slate-950 shadow-lg transition-colors hover:bg-cyan-400">Hubungi Kami</a>
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="border-t border-slate-200 bg-slate-50 py-12 dark:border-slate-800 dark:bg-brand-surface-dark sm:py-16 lg:py-20">
            <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold tracking-tight text-brand-900 dark:text-white sm:text-3xl">Produk Lainnya</h2>
                <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-400">Temukan produk lain yang mungkin sesuai untuk proyek Anda.</p>
                <div class="mt-8 grid gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                    @foreach ($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->slug) }}" class="group flex flex-col overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 transition-shadow hover:shadow-xl dark:bg-brand-card-dark dark:ring-slate-700">
                            <div class="aspect-[4/3] overflow-hidden bg-white p-3">
                                <img src="{{ $related->image_url }}" alt="{{ $related->title }}" width="400" height="300" loading="lazy" class="h-full w-full object-contain transition-transform duration-300 group-hover:scale-105" data-image-fallback="{{ asset('assets/images/products.png') }}">
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <span class="w-fit rounded-full bg-blue-600 px-2.5 py-1 text-xs font-bold text-white">{{ $related->category->short_name ?? 'Produk' }}</span>
                                <h3 class="mt-3 text-base font-bold leading-snug text-brand-900 group-hover:text-blue-600 dark:text-white">{{ $related->title }}</h3>
                                <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $related->desc }}</p>
                                <span class="mt-auto pt-4 text-xs font-bold text-blue-700 dark:text-cyan-300">Lihat Detail &rarr;</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <dialog data-product-lightbox class="product-detail-lightbox w-[calc(100%-1.5rem)] max-w-5xl rounded-2xl bg-white p-0 text-brand-900 shadow-2xl dark:bg-brand-card-dark dark:text-white" aria-labelledby="product-lightbox-title">
        <div class="flex items-center gap-3 border-b border-slate-200 px-4 py-3 dark:border-slate-700">
            <h2 id="product-lightbox-title" class="min-w-0 flex-1 truncate text-sm font-bold">{{ $product->title }}</h2>
            <a data-gallery-download href="{{ $galleryImages[0] }}" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">Buka Foto</a>
            <form method="dialog"><button type="submit" autofocus class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-xl text-slate-700" aria-label="Tutup foto">&times;</button></form>
        </div>
        <div class="p-4 sm:p-6">
            <div class="relative rounded-xl bg-white">
                <img data-lightbox-image src="{{ $galleryImages[0] }}" alt="{{ $product->title }}" class="mx-auto max-h-[65dvh] w-full object-contain" data-image-fallback="{{ asset('assets/images/products.png') }}">
                @if (count($galleryImages) > 1)
                    <button data-gallery-prev type="button" aria-label="Foto sebelumnya" class="absolute left-2 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-brand-900 text-xl text-white disabled:opacity-30">&larr;</button>
                    <button data-gallery-next type="button" aria-label="Foto berikutnya" class="absolute right-2 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-brand-900 text-xl text-white disabled:opacity-30">&rarr;</button>
                @endif
            </div>
            <p data-gallery-counter class="mt-4 text-center text-xs" aria-live="polite">1 / {{ count($galleryImages) }}</p>
        </div>
    </dialog>
</main>
@include('landing.partials.footer')
@endsection
