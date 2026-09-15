<section id="clients"
    class="py-16 bg-white dark:bg-[#0B1120] border-y border-slate-200/80 dark:border-slate-800 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-8 scroll-reveal">
            {{ __('landing.clients_title') }}<br class="hidden sm:inline">
            <span
                class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-400 dark:to-blue-400">{{ __('landing.clients_title_highlight') }}</span>
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 scroll-reveal scroll-reveal-scale">
            @php
                $clients = [
                    [
                        'abbr' => 'PU',
                        'name' => 'BALAI WILAYAH SUNGAI MALUKU',
                        'sub' => 'Kementerian PUPR',
                        'color' => 'bg-amber-400 text-slate-950',
                    ],
                    [
                        'abbr' => 'PEMKAB',
                        'name' => 'PEMKAB KUTAI TIMUR',
                        'sub' => 'Dinas PU & SDA',
                        'color' => 'bg-emerald-500 text-white',
                    ],
                    [
                        'abbr' => 'PU',
                        'name' => 'BWS SULAWESI II',
                        'sub' => 'Ditjen Sumber Daya Air',
                        'color' => 'bg-amber-400 text-slate-950',
                    ],
                    [
                        'abbr' => 'SDA',
                        'name' => 'DINAS SUMBER DAYA AIR',
                        'sub' => 'Pemprov Jawa Barat',
                        'color' => 'bg-blue-600 text-white',
                    ],
                    [
                        'abbr' => 'PU',
                        'name' => 'BWS SUMATERA IV',
                        'sub' => 'Ditjen SDA PUPR',
                        'color' => 'bg-amber-400 text-slate-950',
                    ],
                    [
                        'abbr' => 'PU',
                        'name' => 'BWS KALIMANTAN I',
                        'sub' => 'Kementerian PUPR',
                        'color' => 'bg-amber-400 text-slate-950',
                    ],
                    [
                        'abbr' => 'PU',
                        'name' => 'BWS SUMATERA VII',
                        'sub' => 'Ditjen Sumber Daya Air',
                        'color' => 'bg-amber-400 text-slate-950',
                    ],
                    [
                        'abbr' => 'PU',
                        'name' => 'BWS KALIMANTAN IV',
                        'sub' => 'Kementerian PUPR',
                        'color' => 'bg-amber-400 text-slate-950',
                    ],
                ];
            @endphp
            @foreach ($clients as $client)
                <div
                    class="rounded-2xl p-4 bg-slate-50 dark:bg-[#131D36] border border-slate-200 dark:border-slate-800 flex items-center gap-3 text-left shadow-sm hover:border-blue-400 transition">
                    <div
                        class="w-10 h-10 rounded-xl {{ $client['color'] }} flex items-center justify-center font-black text-xs flex-shrink-0">
                        {{ $client['abbr'] }}</div>
                    <div class="overflow-hidden">
                        <div class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $client['name'] }}
                        </div>
                        <div class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ $client['sub'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
