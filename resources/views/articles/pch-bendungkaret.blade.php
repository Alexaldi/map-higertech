@extends('layouts.app')

@section('title', 'Pemasangan Pos Curah Hujan (PCH) Bendungkaret Tawangsari | Higertech')
@section('description', 'Dokumentasi pemasangan Pos Curah Hujan (PCH) Bendungkaret Tawangsari oleh Higertech Karya Sinergi.')

@section('content')
    <main class="bg-white dark:bg-[#0E1628] transition-colors duration-300">
        <section class="relative isolate overflow-hidden bg-slate-50 pb-14 pt-12 dark:bg-[#0B1120] sm:pb-20 sm:pt-16">
            <div class="map-grid-bg absolute inset-0 -z-10 opacity-60 dark:opacity-40"></div>
            <div class="absolute -right-20 top-0 -z-10 size-80 rounded-full bg-cyan-300/20 blur-3xl dark:bg-cyan-400/10"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-cyan-300">Beranda</a><span>/</span>
                    <a href="{{ route('articles') }}" class="hover:text-blue-600 dark:hover:text-cyan-300">Artikel</a>
                </nav>
                <div class="mt-10 max-w-4xl">
                    <h1 class="text-4xl font-black leading-tight tracking-tight text-slate-950 dark:text-white sm:text-5xl lg:text-6xl">Pemasangan Pos Curah Hujan (PCH) Bendungkaret Tawangsari</h1>
                    <p class="mt-6 max-w-3xl text-base leading-8 text-slate-600 dark:text-slate-300 sm:text-lg">Mendukung ketersediaan data curah hujan yang akurat dan real-time melalui pemasangan perangkat telemetri di Bendungkaret, Tawangsari.</p>
                    <div class="mt-8 flex flex-wrap items-center gap-x-5 gap-y-3 text-xs font-semibold text-slate-500 dark:text-slate-400">
                        <span class="inline-flex items-center gap-2"><span class="flex size-8 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700 dark:bg-cyan-400/15 dark:text-cyan-300">H</span> Tim Higertech</span>
                        <span class="inline-flex items-center gap-1.5"><svg class="size-4 text-cyan-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M8 2v3M16 2v3"/></svg> 08 Juni 2026</span>
                        <span>•</span><span>4 menit baca</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="-mt-2 pb-20 sm:pb-28">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <figure class="overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 shadow-2xl shadow-blue-950/10 dark:border-slate-800 dark:bg-slate-900">
                    <img src="{{ asset('images/articles/deli-serdang.png') }}" alt="Dokumentasi pemasangan perangkat pemantauan curah hujan" class="aspect-[16/8] w-full object-cover" fetchpriority="high">
                    <figcaption class="px-5 py-3 text-xs text-slate-500 dark:text-slate-400">Dokumentasi implementasi perangkat telemetri Higertech di lapangan.</figcaption>
                </figure>

                <div class="mt-12 grid gap-12 lg:grid-cols-[minmax(0,1fr)_220px]">
                    <article class="article-prose min-w-0 text-[17px] leading-8 text-slate-600 dark:text-slate-300">
                        <div class="mb-9">
                            <h2 class="article-description-title">Deskripsi Artikel</h2>
                            <div class="article-description-rule" aria-hidden="true"><span></span></div>
                        </div>
                        <p class="lead text-xl font-medium leading-9 text-slate-700 dark:text-slate-200">Pos Curah Hujan (PCH) merupakan bagian penting dari jaringan pemantauan hidrometeorologi. Data yang dikirimkan secara berkala membantu pemantauan kondisi hujan dan mendukung pengambilan keputusan berbasis data.</p>
                        <h2 id="latar-belakang">Mendukung pemantauan curah hujan</h2>
                        <p>Pemasangan PCH Bendungkaret Tawangsari dirancang untuk menyediakan titik pengamatan curah hujan yang andal di lapangan. Perangkat mengukur intensitas hujan dan meneruskan data melalui sistem telemetri agar informasi dapat dipantau dari jarak jauh.</p>
                        <div class="my-8 rounded-2xl border border-blue-200 bg-blue-50 p-6 dark:border-cyan-400/20 dark:bg-cyan-400/10"><p class="m-0 text-sm font-semibold leading-7 text-blue-900 dark:text-cyan-100">Tujuan utama instalasi adalah memastikan data tersedia secara konsisten, mudah diakses, dan siap digunakan sebagai dasar pemantauan kondisi wilayah.</p></div>
                        <h2 id="tahapan">Tahapan pemasangan</h2>
                        <p>Tim teknis melakukan peninjauan lokasi untuk memastikan posisi perangkat aman, terbuka, dan representatif terhadap kondisi hujan di sekitarnya. Setelah titik pemasangan ditetapkan, struktur penyangga, sensor, sumber daya, serta perangkat komunikasi dipasang dan diuji.</p>
                        <ol><li>Verifikasi titik lokasi dan kesiapan area pemasangan.</li><li>Instalasi sensor curah hujan, enclosure, serta sistem catu daya.</li><li>Konfigurasi logger dan konektivitas telemetri.</li><li>Pengujian pembacaan sensor dan pengiriman data.</li></ol>
                        <h2 id="integrasi">Data yang terhubung</h2>
                        <p>Setelah proses commissioning selesai, perangkat dapat menjadi bagian dari jaringan pemantauan yang lebih luas. Data curah hujan dapat ditinjau secara berkala melalui platform monitoring untuk membantu evaluasi kondisi lapangan.</p>
                        <figure class="my-9 overflow-hidden rounded-2xl"><img src="{{ asset('images/articles/malahayu.png') }}" alt="Perangkat monitoring cuaca Higertech" class="w-full object-cover"><figcaption class="mt-3 text-center text-xs text-slate-500 dark:text-slate-400">Sistem instrumentasi yang dipersiapkan untuk kondisi lapangan.</figcaption></figure>
                        <h2 id="penutup">Komitmen pada data yang andal</h2>
                        <p>Melalui implementasi ini, Higertech terus mendukung kebutuhan instrumentasi dan telemetri untuk pemantauan sumber daya air serta lingkungan. Infrastruktur pengukuran yang baik menjadi fondasi untuk data yang lebih siap, respons yang lebih tepat, dan pengelolaan yang berkelanjutan.</p>
                    </article>
                    <aside class="lg:pt-3"><div class="sticky top-28 rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-[#131D36]"><p class="text-[11px] font-extrabold uppercase tracking-[0.14em] text-blue-600 dark:text-cyan-400">Dalam artikel ini</p><nav class="mt-4 space-y-3 text-sm font-semibold text-slate-600 dark:text-slate-300"><a href="#latar-belakang" class="block hover:text-blue-600 dark:hover:text-cyan-300">Pemantauan curah hujan</a><a href="#tahapan" class="block hover:text-blue-600 dark:hover:text-cyan-300">Tahapan pemasangan</a><a href="#integrasi" class="block hover:text-blue-600 dark:hover:text-cyan-300">Data yang terhubung</a><a href="#penutup" class="block hover:text-blue-600 dark:hover:text-cyan-300">Komitmen Higertech</a></nav></div></aside>
                </div>
                <div class="mt-14 flex flex-col items-start justify-between gap-5 border-t border-slate-200 pt-8 dark:border-slate-800 sm:flex-row sm:items-center"><a href="{{ route('articles') }}" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-cyan-600 dark:text-cyan-400"><span aria-hidden="true">←</span> Kembali ke semua artikel</a><a href="https://wa.me/628112332182" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-blue-600 px-5 py-3 text-xs font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Konsultasi kebutuhan telemetri</a></div>
            </div>
        </section>
    </main>
    @include('landing.partials.footer')
@endsection

@push('head')
    <style>
        .article-prose h2 { margin-top: 2.5rem; margin-bottom: 1rem; color: rgb(15 23 42); font-size: 1.5rem; font-weight: 800; line-height: 1.35; letter-spacing: -.02em; }
        .article-prose p { margin: 0 0 1.3rem; }
        .article-prose ol { margin: 0 0 1.5rem 1.3rem; list-style: decimal; }
        .article-prose li { padding-left: .4rem; margin-bottom: .5rem; }
        .article-prose .article-description-title { margin: 0; color: #1e3a8a; font-size: 1.25rem; }
        .article-description-rule { position: relative; margin-top: 1.15rem; height: 1px; background: rgb(148 163 184 / .55); }
        .article-description-rule span { position: absolute; left: 50%; top: -1px; width: 3.15rem; height: 3px; transform: translateX(-50%); background: #1d4ed8; }
        .dark .article-prose h2 { color: #fff; }
        .dark .article-prose .article-description-title { color: #67e8f9; }
        .dark .article-description-rule { background: rgb(71 85 105); }
        .dark .article-description-rule span { background: #22d3ee; }
    </style>
@endpush
