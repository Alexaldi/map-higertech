@extends('layouts.app')
@section('title', $product->title . ' - Spesifikasi Teknis & e-Katalog Higertech')
@section('content')

{{-- BREADCRUMB & HEADER SECTION --}}
<section class="relative pt-10 pb-8 lg:pt-14 lg:pb-10 overflow-hidden bg-gradient-to-b from-[#F0F5FD] via-[#F8FAFC] to-white dark:from-[#080d1a] dark:via-[#0B1120] dark:to-[#0B1120] border-b border-slate-200/80 dark:border-slate-800 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-1.5 text-xs font-mono text-slate-500 dark:text-slate-400 mb-4 flex-wrap leading-relaxed">
            <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-cyan-400 transition shrink-0">Beranda</a>
            <span class="text-slate-400 dark:text-slate-600">/</span>
            <a href="{{ route('products') }}" class="hover:text-blue-600 dark:hover:text-cyan-400 transition shrink-0">Produk</a>
            <span class="text-slate-400 dark:text-slate-600">/</span>
            <a href="{{ route('products', ['category' => $product->category_id]) }}"
                class="hover:text-blue-600 dark:hover:text-cyan-400 transition shrink-0 font-medium text-blue-600 dark:text-cyan-400"
                title="{{ $product->category->name ?? 'Kategori' }}">
                {{ $product->category->short_name ?? $product->category->name ?? 'Kategori' }}
            </a>
            <span class="text-slate-400 dark:text-slate-600">/</span>
            <span class="text-slate-800 dark:text-slate-200 font-bold">{{ $product->title }}</span>
        </nav>

        {{-- Product Main Heading --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 text-blue-700 dark:text-cyan-400 text-xs font-mono font-bold border border-blue-500/20 mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                    {{ $product->category->sub_nama ?? 'Standar PUPR / BMKG' }}
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-950 dark:text-white tracking-tight leading-tight">
                    {{ $product->title }}
                </h1>
            </div>

            <a href="{{ route('products') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-[#131D36] border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-cyan-400 shadow-xs transition shrink-0 w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Kembali ke Katalog</span>
            </a>
        </div>
    </div>
</section>

{{-- DETAIL CONTENT SECTION --}}
<section class="py-12 lg:py-16 bg-white dark:bg-[#0B1120] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

            {{-- LEFT: Visual Image Stage & Status --}}
            <div class="lg:col-span-5 space-y-6">
                <div class="rounded-3xl p-8 bg-gradient-to-b from-slate-50 via-blue-50/20 to-slate-100 dark:from-[#131D36] dark:via-[#0E1628] dark:to-[#0B1120] border-2 border-slate-200/90 dark:border-slate-800 shadow-lg relative overflow-hidden flex flex-col items-center justify-center min-h-[320px]">
                    <div class="absolute top-4 left-4 inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-mono font-bold border border-emerald-500/20">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        TKDN 40% RESMI
                    </div>

                    <img
                        src="{{ $product->image_url }}"
                        alt="{{ $product->title }}"
                        class="w-full max-h-72 object-contain drop-shadow-2xl transition-transform duration-500 hover:scale-105"
                        onerror="this.src='{{ asset('images/products/hero-unit.png') }}'"
                    >
                </div>

                {{-- Action Box --}}
                <div class="p-6 rounded-3xl bg-slate-50 dark:bg-[#131D36] border border-slate-200 dark:border-slate-800 space-y-3">
                    <h4 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Ketersediaan & Pengadaan
                    </h4>


                    {{-- WhatsApp Consultation --}}
                    <a href="https://wa.me/6281120011400?text={{ urlencode('Halo Higertech, saya ingin meminta penawaran & spesifikasi teknis untuk: ' . $product->title . ' (Ref: ' . route('products.show', $product->slug) . ')') }}"
                        target="_blank" rel="noopener noreferrer"
                        class="w-full flex items-center justify-between px-5 py-3.5 rounded-2xl bg-[#16275E] hover:bg-blue-800 dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-sm shadow-sm transition group">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-white/20 dark:bg-slate-950/20 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                </svg>
                            </span>
                            <div class="text-left">
                                <span class="block text-xs font-normal opacity-90">Konsultasi Teknis & Pengadaan</span>
                                <span class="font-black text-sm">Hubungi Pihak Higertech</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 12h14m-7-7 7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- RIGHT: Specifications & Technical Description --}}
            <div class="lg:col-span-7 space-y-8">
                {{-- Deskripsi Utama --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="w-2 h-5 rounded-full bg-blue-600 dark:bg-cyan-400"></span>
                        Deskripsi & Ringkasan Produk
                    </h3>
                    <div class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed space-y-3 font-normal">
                        <p>{{ $product->desc }}</p>
                    </div>
                </div>

                {{-- Tabel Spesifikasi Standar INAPROC LKPP --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="w-2 h-5 rounded-full bg-cyan-500"></span>
                        Spesifikasi Teknis Standar INAPROC LKPP
                    </h3>

                    @php
                        $catName = $product->category->name ?? '';
                        $pTitle = $product->title;
                        $isAWLR = str_contains($catName, 'AWLR') || str_contains($pTitle, 'AWLR') || str_contains($pTitle, 'Water Level');
                        $isARR = str_contains($catName, 'ARR') || str_contains($pTitle, 'ARR') || str_contains($pTitle, 'Hujan') || str_contains($pTitle, 'Rain');
                        $isAWS = str_contains($catName, 'AWS') || str_contains($pTitle, 'AWS') || str_contains($pTitle, 'Cuaca') || str_contains($pTitle, 'Weather');
                        $isEWS = str_contains($catName, 'EWS') || str_contains($pTitle, 'EWS') || str_contains($pTitle, 'Peringatan') || str_contains($pTitle, 'Sirine');
                        $isCCTV = str_contains($catName, 'CCTV') || str_contains($pTitle, 'CCTV') || str_contains($pTitle, 'Camera');
                        $isAlatUkur = str_contains($catName, 'Alat Ukur') || str_contains($pTitle, 'Peilschaal') || str_contains($pTitle, 'Current Meter');

                        $sensorDesc = 'Sensor Industri Presisi Tinggi terkalibrasi';
                        if ($isAWLR) {
                            $sensorDesc = 'Radar Non-Kontak 80GHz / Submersible Pressure Sensor (Akurasi ±2mm)';
                        } elseif ($isARR) {
                            $sensorDesc = 'Tipping Bucket Orifice 200mm Stainless Steel SS304 (Resolusi 0.5mm)';
                        } elseif ($isAWS) {
                            $sensorDesc = '7 Parameter Terpadu: Wind Ultrasonic 360°, Suhu, RH, Tekanan, Solar Radiasi';
                        } elseif ($isEWS) {
                            $sensorDesc = 'Sirine Peringatan Dini 120dB (Jangkauan 2km) & Strobo Visual Otomatis';
                        } elseif ($isCCTV) {
                            $sensorDesc = 'High Definition Snapshot Camera Outdoor Night Vision + 4G Gateway';
                        } elseif ($isAlatUkur) {
                            $sensorDesc = 'Pelat Aluminium Enamel Khusus Tahan Asam & Karat / Impeller Current Meter';
                        }
                    @endphp

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden text-xs sm:text-sm font-mono">
                        <div class="grid grid-cols-3 p-3.5 bg-slate-100 dark:bg-[#131D36] font-bold text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-800">
                            <div class="col-span-1">Parameter</div>
                            <div class="col-span-2">Deskripsi Spesifikasi Teknis</div>
                        </div>

                        <div class="divide-y divide-slate-100 dark:divide-slate-800/80 bg-white dark:bg-[#0e1628]">
                            <div class="grid grid-cols-3 p-3.5">
                                <div class="col-span-1 font-bold text-slate-500 dark:text-slate-400">Tingkat Komponen (TKDN)</div>
                                <div class="col-span-2 text-slate-900 dark:text-white font-semibold">40.00% (Sertifikat Resmi Kemenperin / LKPP)</div>
                            </div>
                            <div class="grid grid-cols-3 p-3.5">
                                <div class="col-span-1 font-bold text-slate-500 dark:text-slate-400">Standar Acuan</div>
                                <div class="col-span-2 text-slate-900 dark:text-white">Ditjen Sumber Daya Air (SDA) Kementerian PUPR & BMKG</div>
                            </div>
                            <div class="grid grid-cols-3 p-3.5">
                                <div class="col-span-1 font-bold text-slate-500 dark:text-slate-400">Instrumen / Sensor Utama</div>
                                <div class="col-span-2 text-slate-900 dark:text-cyan-400 font-semibold">{{ $sensorDesc }}</div>
                            </div>
                            <div class="grid grid-cols-3 p-3.5">
                                <div class="col-span-1 font-bold text-slate-500 dark:text-slate-400">Data Logger Inti</div>
                                <div class="col-span-2 text-slate-900 dark:text-white">Dual-Core 32-Bit MCU, Low Power, Micro-SD Internal Storage</div>
                            </div>
                            <div class="grid grid-cols-3 p-3.5">
                                <div class="col-span-1 font-bold text-slate-500 dark:text-slate-400">Antarmuka Komunikasi</div>
                                <div class="col-span-2 text-slate-900 dark:text-white">Modbus RTU / RS485, SDI-12, Analog 4-20mA, Digital Counter</div>
                            </div>
                            <div class="grid grid-cols-3 p-3.5">
                                <div class="col-span-1 font-bold text-slate-500 dark:text-slate-400">Transmisi Telemetri</div>
                                <div class="col-span-2 text-slate-900 dark:text-white">4G LTE / GPRS IoT Gateway terintegrasi ke Server Pusat (MQTT / REST)</div>
                            </div>
                            <div class="grid grid-cols-3 p-3.5">
                                <div class="col-span-1 font-bold text-slate-500 dark:text-slate-400">Catu Daya Mandiri</div>
                                <div class="col-span-2 text-slate-900 dark:text-white">Solar Panel Monocrystalline, MPPT Controller, Baterai Deep Cycle / LiFePO4</div>
                            </div>
                            <div class="grid grid-cols-3 p-3.5">
                                <div class="col-span-1 font-bold text-slate-500 dark:text-slate-400">Perlindungan Enclosure</div>
                                <div class="col-span-2 text-slate-900 dark:text-white">Stainless Steel / Powder Coated Outdoor Box (IP65 / IP66)</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Fitur Utama --}}
                <div class="space-y-3 pt-2">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="w-2 h-5 rounded-full bg-emerald-500"></span>
                        Keunggulan Sistem Telemetri Higertech
                    </h3>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                        <li class="flex items-start gap-2 p-3 rounded-xl bg-slate-50 dark:bg-[#131D36] border border-slate-200/80 dark:border-slate-800">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Operasional mandiri 24/7 tanpa listrik PLN</span>
                        </li>
                        <li class="flex items-start gap-2 p-3 rounded-xl bg-slate-50 dark:bg-[#131D36] border border-slate-200/80 dark:border-slate-800">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Kompatibel protokol REST API, MQTT, dan database balai</span>
                        </li>
                        <li class="flex items-start gap-2 p-3 rounded-xl bg-slate-50 dark:bg-[#131D36] border border-slate-200/80 dark:border-slate-800">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Dukungan kalibrasi berkala & suku cadang resmi terjamin</span>
                        </li>
                        <li class="flex items-start gap-2 p-3 rounded-xl bg-slate-50 dark:bg-[#131D36] border border-slate-200/80 dark:border-slate-800">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Proses pengadaan resmi via e-Katalog LKPP terdaftar</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        {{-- RELATED PRODUCTS --}}
        @if ($relatedProducts->isNotEmpty())
            <div class="mt-16 pt-12 border-t border-slate-200 dark:border-slate-800">
                <h3 class="text-xl font-black text-slate-900 dark:text-white mb-6">
                    Produk Lain dalam Kategori Ini
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->slug) }}"
                            class="group rounded-2xl p-5 bg-white dark:bg-[#131D36] border border-slate-200/80 dark:border-slate-800 hover:border-blue-500 dark:hover:border-cyan-400 shadow-sm hover:shadow-lg transition flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="w-full h-32 bg-slate-50 dark:bg-[#0c1626] rounded-xl p-2 flex items-center justify-center border border-slate-100 dark:border-slate-800">
                                    <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="max-h-full max-w-full object-contain" onerror="this.src='{{ asset('images/products/hero-unit.png') }}'">
                                </div>
                                <span class="text-[10px] font-mono font-bold uppercase text-blue-600 dark:text-cyan-400 block">
                                    {{ $related->category->sub_nama ?? 'Telemetri' }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition line-clamp-2">
                                    {{ $related->title }}
                                </h4>
                            </div>
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 dark:text-cyan-400 mt-4">
                                <span>Lihat Spesifikasi</span>
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M5 12h14m-7-7 7 7-7 7"/>
                                </svg>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@include('landing.partials.cta')
@include('landing.partials.footer')

@endsection
