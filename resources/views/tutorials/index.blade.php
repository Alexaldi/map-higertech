@extends('layouts.app')

@section('title', 'Tutorial & Panduan Teknis | Higertech Karya Sinergi')
@section('description', 'Tutorial langkah demi langkah untuk sistem monitoring, hidrologi, IoT, dan perangkat telemetri Higertech.')

@section('content')
    @php
        $tutorials = [
            ['title' => 'Installation Guide Automatic Weather Station (AWS)', 'text' => 'Panduan penempatan sensor, mast tower, penangkal petir, dan grounding untuk instalasi AWS yang aman.', 'type' => 'Panduan Instalasi', 'time' => '8 menit', 'image' => 'aws-guide.png'],
            ['title' => 'Setting dan Reset Logger AWLR Sonar Digital', 'text' => 'Langkah konfigurasi awal, pemeriksaan koneksi, serta reset logger untuk perangkat AWLR sonar digital.', 'type' => 'Video Tutorial', 'time' => '6 menit', 'image' => 'awlr-tutorial.png'],
            ['title' => 'Persiapan Perangkat Telemetri di Lapangan', 'text' => 'Checklist praktis sebelum perangkat dikirim, dipasang, dan dihubungkan ke sistem monitoring.', 'type' => 'Panduan Lapangan', 'time' => '5 menit', 'image' => 'deli-serdang.png'],
        ];
    @endphp

    <main class="overflow-hidden">
        <section class="relative isolate bg-slate-50 pb-20 pt-16 dark:bg-[#0B1120] sm:pb-28 sm:pt-24 transition-colors duration-300">
            <div class="map-grid-bg absolute inset-0 -z-10 opacity-70 dark:opacity-50"></div>
            <div class="absolute -left-24 top-6 -z-10 size-80 rounded-full bg-blue-400/20 blur-3xl dark:bg-blue-700/15"></div>
            <div class="absolute -right-20 bottom-0 -z-10 size-80 rounded-full bg-cyan-300/25 blur-3xl dark:bg-cyan-400/10"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-cyan-300"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/><path d="M9 12h11"/></svg>KEMBALI KE BERANDA</a>
                <div class="mt-8 inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white/80 px-4 py-2 text-[11px] font-bold uppercase tracking-[.16em] text-blue-700 shadow-sm dark:border-cyan-400/20 dark:bg-cyan-400/10 dark:text-cyan-300"><span class="size-1.5 rounded-full bg-cyan-500 animate-pulse"></span> Learning center Higertech</div>
                <h1 class="mt-6 text-4xl font-black tracking-tight text-slate-950 dark:text-white sm:text-6xl">Panduan yang Jelas.<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-300 dark:to-blue-400">Kuasai dengan Pengalaman.</span></h1>
                <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-300">Temukan tutorial langkah demi langkah untuk teknologi monitoring, hidrologi, IoT, dan perangkat pendukung agar solusi dapat diterapkan secara efektif.</p>
                <div class="mx-auto mt-9 max-w-xl relative"><label for="tutorial-search" class="sr-only">Cari tutorial</label><svg class="pointer-events-none absolute left-5 top-1/2 size-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg><input id="tutorial-search" type="search" placeholder="Cari tutorial atau perangkat..." class="w-full rounded-2xl border border-slate-200 bg-white px-12 py-4 text-sm text-slate-800 shadow-xl shadow-blue-950/5 outline-none placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#131D36] dark:text-white dark:focus:border-cyan-400 dark:focus:ring-cyan-400/10"></div>
            </div>
        </section>

        <section class="bg-white py-16 dark:bg-[#0E1628] sm:py-20 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="border-b border-slate-200 pb-8 dark:border-slate-800"><p class="text-xs font-bold uppercase tracking-[.16em] text-blue-600 dark:text-cyan-400">Tutorial</p><h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Belajar dengan percaya diri.<br>Bangun solusinya.</h2></div>
                <div id="tutorial-grid" class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($tutorials as $tutorial)
                        <article data-search="{{ strtolower($tutorial['title'] . ' ' . $tutorial['text'] . ' ' . $tutorial['type']) }}" class="tutorial-card group flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-[#131D36]">
                            <div class="relative h-56 overflow-hidden bg-slate-100 dark:bg-slate-800"><img src="{{ asset('images/articles/' . $tutorial['image']) }}" alt="{{ $tutorial['title'] }}" class="size-full object-cover transition duration-500 group-hover:scale-105" loading="lazy"><span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[10px] font-extrabold text-blue-700 shadow-sm backdrop-blur dark:bg-slate-950/80 dark:text-cyan-300">{{ $tutorial['type'] }}</span><span class="absolute bottom-4 right-4 flex size-10 items-center justify-center rounded-full bg-blue-600 text-white shadow-lg dark:bg-cyan-400 dark:text-slate-950"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3l14 9-14 9V3z"/></svg></span></div>
                            <div class="flex flex-1 flex-col p-6"><p class="text-xs font-mono text-slate-400">{{ $tutorial['time'] }} pembelajaran</p><h3 class="mt-3 text-xl font-bold leading-snug text-slate-900 transition group-hover:text-blue-600 dark:text-white dark:group-hover:text-cyan-300">{{ $tutorial['title'] }}</h3><p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $tutorial['text'] }}</p><div class="mt-auto border-t border-slate-100 pt-5 mt-6 text-xs font-bold text-blue-600 dark:border-slate-800 dark:text-cyan-400">Tutorial segera tersedia <span aria-hidden="true">→</span></div></div>
                        </article>
                    @endforeach
                </div>
                <p id="tutorial-empty" class="hidden py-16 text-center text-sm text-slate-500 dark:text-slate-400">Tutorial tidak ditemukan. Coba kata kunci lain.</p>
                <section class="mt-16 overflow-hidden rounded-3xl border border-blue-200 bg-gradient-to-r from-blue-50 via-indigo-50 to-cyan-50 p-8 dark:border-cyan-400/15 dark:from-[#16275E] dark:via-[#131D36] dark:to-[#0B1120] sm:p-10"><div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[.16em] text-blue-600 dark:text-cyan-300">Butuh bantuan teknis?</p><h2 class="mt-3 text-2xl font-extrabold text-slate-900 dark:text-white sm:text-3xl">Wujudkan monitoring yang lebih cerdas dan efisien.</h2><p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Tim Higertech siap membantu memilih perangkat dan rancangan sistem yang sesuai dengan kebutuhan pemantauan Anda.</p><a href="https://wa.me/628112332182" target="_blank" rel="noopener noreferrer" class="mt-6 inline-flex rounded-xl bg-blue-600 px-5 py-3 text-xs font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 dark:bg-cyan-400 dark:text-slate-950 dark:hover:bg-cyan-300">Konsultasi via WhatsApp</a></div></section>
            </div>
        </section>
    </main>
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
