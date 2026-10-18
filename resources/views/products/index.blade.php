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

{{-- PRODUCT LISTING SECTION WITH TECHNICAL SPECIFICATION CARDS --}}
<section class="py-12 lg:py-16 bg-slate-50/60 dark:bg-[#0B1120] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Subheader / Category Status --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-slate-200 dark:border-slate-800 gap-4">
            <div>
                <span class="text-xs font-bold font-mono tracking-widest uppercase text-blue-600 dark:text-cyan-400">
                    KATALOG INSTRUMEN & SENSOR RESMI
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mt-1">
                    {{ $selectedCategory ? $selectedCategory->name : 'Daftar Seluruh Seri Produk' }}
                </h2>
            </div>

            @if ($selectedCategory)
                <a href="{{ route('products') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-cyan-400 hover:border-blue-400 dark:hover:border-cyan-500 shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span>Lihat Semua Kategori</span>
                </a>
            @endif
        </div>

        {{-- Product Grid (Technical Workstation Cards Style ala Gambar 3) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            @forelse ($products as $product)
                @php
                    $catName = $product->category->name ?? 'Instrumen Telemetri';
                    $subCat = $product->category->sub_nama ?? 'Standar PUPR / BMKG';

                    // Smart specs derivation
                    $isAWLR = str_contains($catName, 'AWLR') || str_contains($product->title, 'AWLR') || str_contains($product->title, 'Level');
                    $isARR = str_contains($catName, 'ARR') || str_contains($product->title, 'ARR') || str_contains($product->title, 'Rain');
                    $isAWS = str_contains($catName, 'AWS') || str_contains($product->title, 'AWS') || str_contains($product->title, 'Cuaca');
                    $isEWS = str_contains($catName, 'EWS') || str_contains($product->title, 'EWS') || str_contains($product->title, 'Sirine');

                    $badgeTop = 'TELEMETRI IOT';
                    $badgeRange = 'TKDN 40%';
                    $spec1 = 'Output: RS485 / Modbus';
                    $spec2 = 'Akurasi: Standar Industri';

                    if ($isAWLR) {
                        $badgeTop = 'RADAR / PRESSURE';
                        $badgeRange = '0 - 35m Range';
                        $spec1 = 'Akurasi: ±2mm';
                        $spec2 = 'Output: Modbus RTU / SDI-12';
                    } elseif ($isARR) {
                        $badgeTop = 'TIPPING BUCKET';
                        $badgeRange = 'Orifice 200mm';
                        $spec1 = 'Resolusi: 0.5 mm';
                        $spec2 = 'Material: SS 304 Anti-Karat';
                    } elseif ($isAWS) {
                        $badgeTop = 'ALL-IN-ONE AWS';
                        $badgeRange = 'Tower 10 Meter';
                        $spec1 = '7 Parameter Cuaca Terpadu';
                        $spec2 = 'Ultrasonic Wind 360°';
                    } elseif ($isEWS) {
                        $badgeTop = 'PERINGATAN DINI';
                        $badgeRange = '120dB Siren';
                        $spec1 = 'Radius Suara: s/d 2.000m';
                        $spec2 = 'Dual Trigger: Auto / Manual';
                    }
                @endphp

                @php
                    $targetUrl = route('products.show', $product->slug);
                @endphp

                <div class="rounded-3xl p-6 sm:p-7 bg-white dark:bg-[#131D36] border border-slate-200/90 dark:border-slate-800 shadow-md hover:shadow-2xl hover:border-cyan-500/80 dark:hover:border-cyan-400 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden cursor-pointer"
                    onclick="if(!event.target.closest('a')) { window.location.href='{{ $targetUrl }}'; }">
                    {{-- Top Gradient Stripe --}}
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-600 via-cyan-400 to-indigo-600 opacity-80 group-hover:opacity-100 transition"></div>

                    {{-- Card Header --}}
                    <div>
                        <div class="flex items-center justify-between pb-3.5 mb-3.5 border-b border-slate-100 dark:border-slate-800 text-xs font-mono">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-blue-500/10 dark:bg-cyan-500/10 text-blue-600 dark:text-cyan-400 flex items-center justify-center border border-blue-500/20 dark:border-cyan-500/20 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                    </svg>
                                </span>
                                <div>
                                    <span class="font-bold text-slate-800 dark:text-cyan-300 block text-[11px] uppercase tracking-wide">
                                        {{ $subCat }}
                                    </span>
                                    <span class="text-[9px] text-slate-400">Standar PUPR / BMKG / Ditjen SDA</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-blue-50 dark:bg-cyan-950/70 text-blue-700 dark:text-cyan-300 text-[10px] font-bold font-mono border border-blue-200 dark:border-cyan-800 shrink-0">
                                {{ $badgeRange }}
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition leading-snug">
                            <a href="{{ route('products.show', $product->slug) }}" class="no-underline hover:no-underline focus:no-underline">
                                {{ $product->title }}
                            </a>
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-2 leading-relaxed line-clamp-3">
                            {{ $product->desc }}
                        </p>
                    </div>

                    {{-- Visual & Specs Row --}}
                    <div class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                        {{-- Product Stage --}}
                        <div class="w-full sm:w-36 h-28 bg-gradient-to-b from-slate-50 via-blue-50/30 to-slate-100 dark:from-[#0c1626] dark:via-[#09101d] dark:to-[#080d19] rounded-2xl p-2 flex items-center justify-center border border-slate-200/80 dark:border-slate-800 shrink-0 group-hover:border-cyan-400/50 transition">
                            <img
                                src="{{ $product->image_url }}"
                                alt="{{ $product->title }}"
                                class="max-h-full max-w-full object-contain drop-shadow-md group-hover:scale-105 transition duration-300"
                                loading="lazy"
                                onerror="this.src='{{ asset('images/products/hero-unit.png') }}'"
                            >
                        </div>

                        {{-- Technical Badges & Inaproc --}}
                        <div class="w-full sm:text-right text-[11px] font-mono space-y-1 flex-1">
                            <div class="font-bold text-slate-900 dark:text-white">{{ $spec1 }}</div>
                            <div class="text-slate-500 dark:text-slate-400 text-[10px]">{{ $spec2 }}</div>

                            <div class="pt-2 flex sm:justify-end items-center gap-2 flex-wrap">
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 group-hover:bg-[#16275E] group-hover:text-white dark:group-hover:bg-cyan-500 dark:group-hover:text-slate-950 text-[11px] font-bold transition shadow-2xs">
                                    <span>Detail Spesifikasi</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white dark:bg-[#131D36] rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 p-8 shadow-xs">
                    <svg class="size-12 mx-auto text-slate-400 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="m21 21-4.3-4.3M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/>
                    </svg>
                    <p class="text-slate-800 dark:text-white font-bold text-base">Belum ada produk dalam kategori ini.</p>
                    <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Produk sedang dalam proses integrasi data dari e-Katalog Inaproc.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</section>

@include('landing.partials.cta')
@include('landing.partials.footer')

@endsection