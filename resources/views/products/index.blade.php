@extends('layouts.app')
@section('title', ($selectedCategory ? $selectedCategory->name . ' | ' : '') . 'Produk - Higertech Karya Sinergi')
@section('content')

{{-- HERO SECTION (3 Baris Sesuai Arahan Pak Handy) --}}
<section id="hero"
    class="relative pt-10 pb-14 lg:pt-14 lg:pb-20 overflow-hidden bg-gradient-to-b from-[#F0F5FD] via-[#F8FAFC] to-white dark:from-[#080d1a] dark:via-[#0B1120] dark:to-[#0B1120] transition-colors duration-300 border-b border-slate-200/60 dark:border-slate-800/60">
    <div class="absolute inset-0 map-grid-bg pointer-events-none opacity-80 dark:opacity-35"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">

            {{-- 3 Baris Header --}}
            <div class="space-y-3 scroll-reveal">
                {{-- Baris 1: Sub judul halaman (font kecil) --}}
                <p class="text-xs sm:text-sm font-bold uppercase tracking-widest text-blue-600 dark:text-cyan-400">
                    Produk
                </p>

                {{-- Baris 2: Judul kategori (font besar warna hitam) --}}
                <h1
                    class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-[1.18] text-slate-950 dark:text-white">
                    {{ $selectedCategory ? $selectedCategory->name : 'Semua Produk' }}
                </h1>

                {{-- Baris 3: Sub deskripsi (font kecil warna abu-abu) --}}
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl leading-relaxed pt-1">
                    {{ $selectedCategory && $selectedCategory->description
                        ? $selectedCategory->description
                        : 'Beragam solusi digital untuk kebutuhan monitoring, manajemen data, dan sistem informasi — dirancang untuk mendukung pengambilan keputusan yang lebih cepat dan akurat.' }}
                </p>
            </div>

            {{-- Hero Visual Presentation --}}
            <div class="relative flex flex-col items-center justify-center scroll-reveal scroll-reveal-delay-1">
                {{-- Glow background --}}
                <div
                    class="absolute -top-10 w-64 h-64 sm:w-80 sm:h-80 bg-cyan-500/15 dark:bg-cyan-500/15 rounded-full blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute top-16 w-64 h-64 sm:w-80 sm:h-80 bg-blue-600/15 dark:bg-blue-600/15 rounded-full blur-3xl pointer-events-none">
                </div>

                {{-- Floating Unit Graphic --}}
                <div class="relative flex items-center justify-center w-full max-w-md py-2">
                    <img src="{{ asset('images/products/hero-unit.png') }}"
                        alt="{{ $selectedCategory ? $selectedCategory->name : 'Produk Higertech' }}"
                        class="w-full max-h-64 sm:max-h-76 object-contain relative z-10 animate-float-subtle drop-shadow-2xl transition-transform duration-500 hover:scale-105"
                        onerror="this.src='https://placehold.co/400x300/e2e8f0/94a3b8?text=Higertech+Product'">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PRODUCT LISTING SECTION WITH CATEGORY FILTER TABS --}}
<section class="py-12 lg:py-16 bg-white dark:bg-[#0B1120] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Category Pills Filter (Termasuk "All" & 10 Kategori) --}}
        <div class="mb-10">
            <div class="flex items-center gap-2 overflow-x-auto pb-3 pt-1 scrollbar-thin scrollbar-thumb-slate-300 dark:scrollbar-thumb-slate-700">
                {{-- Tab All --}}
                <a href="{{ route('products') }}"
                    class="shrink-0 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200
                    {{ !$selectedCategory
                        ? 'bg-blue-600 text-white shadow-md shadow-blue-500/25 dark:bg-cyan-500 dark:text-slate-950 dark:shadow-cyan-500/20'
                        : 'bg-slate-100 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    All (Semua)
                </a>

                {{-- Tab Per Kategori --}}
                @foreach ($categories as $cat)
                    @php
                        $isActive = $selectedCategory && $selectedCategory->id === $cat->id;
                        $shortLabel = $cat->sub_nama ?: $cat->name;
                    @endphp
                    <a href="{{ route('products', ['category' => $cat->id]) }}"
                        title="{{ $cat->name }}"
                        class="shrink-0 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 whitespace-nowrap
                        {{ $isActive
                            ? 'bg-blue-600 text-white shadow-md shadow-blue-500/25 dark:bg-cyan-500 dark:text-slate-950 dark:shadow-cyan-500/20'
                            : 'bg-slate-100 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                        {{ $shortLabel }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse ($products as $product)
                {{-- Product Card --}}
                <div
                    class="group relative rounded-2xl overflow-hidden shadow-sm
                    hover:shadow-xl transition-all duration-300
                    bg-white dark:bg-[#131D36]
                    border border-slate-200/80 dark:border-slate-800
                    h-full flex flex-col hover:-translate-y-1">

                    {{-- Card Image --}}
                    <div class="relative overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-800/50">
                        <img
                            src="{{ $product->image_url }}"
                            alt="{{ $product->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                            onerror="this.src='https://placehold.co/400x300/e2e8f0/94a3b8?text=Higertech'"
                        >
                    </div>

                    {{-- Card Footer --}}
                    <div
                        class="p-4 bg-[#1e3a8a] dark:bg-[#0f2460]
                        min-h-[120px] flex flex-col justify-center">

                        <span
                            class="inline-block text-[10px] font-bold uppercase tracking-widest
                            text-cyan-300 bg-white/10 px-2.5 py-1 rounded-full mb-2 w-fit">
                            {{ $product->category->name ?? 'Umum' }}
                        </span>

                        <h3 class="text-white font-extrabold text-sm leading-snug line-clamp-2">
                            {{ $product->title }}
                        </h3>
                    </div>

                    {{-- Hover Overlay --}}
                    <div
                        class="absolute inset-0 z-20
                        bg-[#10265a]/92 dark:bg-[#07142f]/95
                        flex flex-col justify-end
                        p-5
                        translate-y-full
                        group-hover:translate-y-0
                        transition-transform duration-500 ease-in-out">

                        <span
                            class="inline-block text-[10px] font-bold uppercase tracking-widest
                            text-cyan-300 bg-cyan-900/50
                            px-2.5 py-1 rounded-full w-fit mb-3">
                            {{ $product->category->name ?? 'Umum' }}
                        </span>

                        <h3
                            class="text-white font-extrabold
                            text-lg sm:text-xl
                            leading-tight mb-3">
                            {{ $product->title }}
                        </h3>

                        <p
                            class="text-slate-300
                            text-sm leading-relaxed
                            line-clamp-6">
                            {{ $product->desc }}
                        </p>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-slate-50 dark:bg-slate-900/40 rounded-2xl border border-dashed border-slate-300 dark:border-slate-800">
                    <svg class="size-12 mx-auto text-slate-400 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="m21 21-4.3-4.3M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/>
                    </svg>
                    <p class="text-slate-600 dark:text-slate-400 font-semibold text-base">Belum ada produk dalam kategori ini.</p>
                    <p class="text-slate-400 dark:text-slate-500 text-xs mt-1">Produk sedang dalam proses integrasi data dari e-Katalog Inaproc.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

@include('landing.partials.cta')
@include('landing.partials.footer')

@endsection