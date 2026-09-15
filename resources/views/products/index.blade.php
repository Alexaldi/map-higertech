@extends('layouts.app')
@section('title', 'Produk | Higertech Karya Sinergi')
@section('content')

<section id="hero"
    class="relative pt-10 pb-16 lg:pt-14 lg:pb-24 overflow-hidden bg-gradient-to-b from-[#F0F5FD] via-[#F8FAFC] to-white dark:from-[#080d1a] dark:via-[#0B1120] dark:to-[#0B1120] transition-colors duration-300">
    <div class="absolute inset-0 map-grid-bg pointer-events-none opacity-80 dark:opacity-35"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-8 items-center">

            {{-- Text Content --}}
            <div class="space-y-6 scroll-reveal">
                <h1
                    class="text-4xl sm:text-5xl lg:text-[48px] font-extrabold tracking-tight leading-[1.15] text-slate-900 dark:text-white">
                    RealTime Monitoring & Data Management Platform<br>
                </h1>

                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-xl leading-relaxed">
                    Monitor field devices through an intuitive dashboard with real-time visualization, automated alerts, historical data analysis, and comprehensive reporting tools.
                </p>
            </div>

            {{-- Hero Visual Presentation (Clean 3D showcase without card container) --}}
            <div class="relative flex flex-col items-center justify-center scroll-reveal scroll-reveal-delay-1">
                {{-- Ambient Background Glow behind 3D Unit --}}
                <div
                    class="absolute -top-10 w-72 h-72 sm:w-80 sm:h-80 bg-cyan-500/15 dark:bg-cyan-500/15 rounded-full blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute top-16 w-72 h-72 sm:w-80 sm:h-80 bg-blue-600/15 dark:bg-blue-600/15 rounded-full blur-3xl pointer-events-none">
                </div>

                {{-- Concentric Radar Rings behind the 3D unit --}}
                <div class="relative flex items-center justify-center w-full max-w-lg py-2 sm:py-4">
                    <div
                        class="absolute w-60 h-60 sm:w-72 sm:h-72 rounded-full border border-blue-500/15 dark:border-cyan-400/15 pointer-events-none">
                    </div>
                    <div
                        class="absolute w-80 h-80 sm:w-96 sm:h-96 rounded-full border border-blue-500/10 dark:border-cyan-400/10 pointer-events-none">
                    </div>

                    {{-- Floating 3D Graphic with smooth CSS float animation --}}
                    <img src="{{ asset('assets/images/products.png') }}"
                        alt="Higertech Telemetry Field Monitoring Unit"
                        class="w-full max-h-72 sm:max-h-84 object-contain relative z-10 animate-float-subtle drop-shadow-2xl transition-transform duration-500 hover:scale-105">
                </div>
            </div>
        </div>
</section>

{{-- PRODUCT LISTING SECTION --}}
<section class="py-16 lg:py-24 bg-white dark:bg-[#0B1120] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="mb-12">
            <p class="text-blue-600 dark:text-cyan-400 text-xs font-bold uppercase tracking-widest mb-1 flex items-center gap-2">
                <span class="inline-block w-6 h-0.5 bg-blue-600 dark:bg-cyan-400"></span>
                Software Monitoring
            </p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight mt-3">
                Visualize Your Data.<br>
                <span class="text-blue-600 dark:text-cyan-400">Manage with Confidence.</span>
            </h2>
        </div>

        {{-- Product Grid --}}
        @php
            $products = [
                [
                    'category' => 'Software Monitoring',
                    'title'    => 'WEBSITE SISTEM INFORMASI HIDROLOGI',
                    'desc'     => 'Platform monitoring hidrologi berbasis web yang menampilkan data real-time dari seluruh pos pantau. Dilengkapi dengan dashboard interaktif, grafik debit air, peta distribusi sensor, dan sistem notifikasi otomatis untuk kondisi kritis.',
                    'image'    => asset('images/products/hidrologi.png'),
                ],
                [
                    'category' => 'Software Monitoring',
                    'title'    => 'PEMBUATAN WEB TELEMETRI HIGERTECH',
                    'desc'     => 'Web telemetri terintegrasi untuk akuisisi data lapangan secara otomatis. Menampilkan dashboard utama, kolom profil pos telemetri, nilai sensor real-time, serta informasi aset dan laporan berkala.',
                    'image'    => asset('images/products/telemetri.png'),
                ],
                [
                    'category' => 'Software Monitoring',
                    'title'    => 'WEB TELEMETRY DAN FLOOD EARLY WARNING SYSTEM (FEWS)',
                    'desc'     => 'Pembuatan Web Telemetry dan FEWS (Flood Early Warning System). Dashboard utama dengan kolom peta sebaran pos telemetri, profil pos detail, nilai sensor real-time, serta peta 2 dimensi banjir spasial dari hasil curah hujan satelit di wilayah target. Dilengkapi Real Time Flood Forecasting dengan total panjang sungai maksimal 200 km.',
                    'image'    => asset('images/products/fews.png'),
                ],
                [
                    'category' => 'Software Monitoring',
                    'title'    => 'SISTEM MONITORING KUALITAS AIR',
                    'desc'     => 'Sistem pemantauan kualitas air berbasis IoT yang mengintegrasikan sensor pH, kekeruhan, suhu, dan dissolved oxygen secara real-time. Dashboard terintegrasi dengan alert otomatis dan laporan historis.',
                    'image'    => asset('images/products/kualitas-air.png'),
                ],
                [
                    'category' => 'Software Monitoring',
                    'title'    => 'PLATFORM MONITORING CUACA OTOMATIS',
                    'desc'     => 'Platform digital untuk pemantauan kondisi cuaca secara otomatis melalui AWS (Automatic Weather Station). Menampilkan data curah hujan, kecepatan angin, suhu udara, dan kelembaban dalam satu dashboard terpadu.',
                    'image'    => asset('images/products/cuaca.png'),
                ],
                [
                    'category' => 'Software Monitoring',
                    'title'    => 'SISTEM INFORMASI GEOSPASIAL BENCANA',
                    'desc'     => 'Sistem informasi berbasis GIS untuk pemetaan potensi bencana alam. Mengintegrasikan data sensor lapangan, citra satelit, dan analitik spasial untuk mendukung pengambilan keputusan mitigasi bencana secara cepat dan akurat.',
                    'image'    => asset('images/products/gis.png'),
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach ($products as $product)
                {{-- Product Card --}}
                <div
                    class="group relative rounded-2xl overflow-hidden shadow-md
                    hover:shadow-xl transition-shadow duration-300
                    bg-white dark:bg-[#131D36]
                    border border-slate-200/80 dark:border-slate-700/50
                    h-full flex flex-col">

                    {{-- Card Image --}}
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img
                            src="{{ asset('assets/images/products.png') }}"
                            alt="{{ $product['title'] }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                            onerror="this.src='https://placehold.co/400x300/e2e8f0/94a3b8?text=Higertech'"
                        >
                    </div>

                    {{-- Card Footer --}}
                    <div
                        class="p-4 bg-[#1e3a8a] dark:bg-[#0f2460]
                        h-[120px] flex flex-col justify-center">

                        <span
                            class="inline-block text-[10px] font-bold uppercase tracking-widest
                            text-cyan-300 bg-white/10 px-2.5 py-1 rounded-full mb-2 w-fit">
                            {{ $product['category'] }}
                        </span>

                        <h3 class="text-white font-extrabold text-sm leading-snug line-clamp-2">
                            {{ $product['title'] }}
                        </h3>
                    </div>


                    {{-- Hover Overlay --}}
                    <div
                        class="absolute inset-0 z-20
                        bg-[#10265a]/89 dark:bg-[#07142f]/95
                        flex flex-col justify-end
                        p-5
                        translate-y-full
                        group-hover:translate-y-0
                        transition-transform duration-500 ease-in-out">

                        <span
                            class="inline-block text-[10px] font-bold uppercase tracking-widest
                            text-cyan-300 bg-cyan-900/50
                            px-2.5 py-1 rounded-full w-fit mb-3">
                            {{ $product['category'] }}
                        </span>

                        <h3
                            class="text-white font-extrabold
                            text-lg sm:text-xl
                            leading-tight mb-3">
                            {{ $product['title'] }}
                        </h3>

                        <p
                            class="text-slate-300
                            text-sm leading-relaxed
                            line-clamp-7">
                            {{ $product['desc'] }}
                        </p>

                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>

@include('landing.partials.cta')
@include('landing.partials.footer')

@endsection