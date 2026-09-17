<section id="clients"
    class="py-16 sm:py-20 bg-white dark:bg-[#0B1120] border-y border-slate-200/80 dark:border-slate-800 transition-colors duration-300 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-10">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight scroll-reveal">
            {{ __('landing.clients_title') }}<br class="hidden sm:inline">
            <span
                class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-400 dark:to-blue-400">{{ __('landing.clients_title_highlight') }}</span>
        </h2>
    </div>

    @php
        $clientList = collect($clients ?? []);
        $half = (int) ceil($clientList->count() / 2);
        $row1 = $clientList->slice(0, $half);
        $row2 = $clientList->slice($half);
        if ($row2->isEmpty()) {
            $row2 = $row1;
        }
    @endphp

    @if ($clientList->isNotEmpty())
        {{-- Infinite Marquee Wrapper with side fade gradients --}}
        <div class="relative w-full overflow-hidden">
            {{-- Left & Right Gradient Shadows for seamless enter/exit --}}
            <div
                class="pointer-events-none absolute inset-y-0 left-0 w-16 sm:w-32 bg-gradient-to-r from-white dark:from-[#0B1120] to-transparent z-10">
            </div>
            <div
                class="pointer-events-none absolute inset-y-0 right-0 w-16 sm:w-32 bg-gradient-to-l from-white dark:from-[#0B1120] to-transparent z-10">
            </div>

            {{-- Row 1: Scrolling Left --}}
            <div class="marquee-track-left mb-4 sm:mb-5">
                @foreach ($row1->concat($row1) as $client)
                    <div
                        class="rounded-[20px] px-5 py-3 bg-[#24357a] hover:bg-[#2c4091] dark:bg-[#152347] dark:hover:bg-[#1d305f] border border-blue-400/20 shadow-md flex items-center justify-center gap-3 transition-all duration-300 min-w-[280px] sm:min-w-[320px] h-[80px] sm:h-[86px] cursor-default select-none hover:scale-[1.02]">
                        @if ($client->logo_url)
                            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" width="160" height="44"
                                class="h-10 sm:h-11 w-auto max-w-[260px] object-contain select-none pointer-events-none"
                                loading="lazy" decoding="async">
                        @else
                            <div
                                class="w-10 h-10 rounded-xl {{ $client->color ?: 'bg-amber-400 text-slate-950' }} flex items-center justify-center font-black text-xs flex-shrink-0">
                                {{ $client->abbr ?: 'PU' }}
                            </div>
                            <div class="overflow-hidden text-left">
                                <div class="text-xs font-bold text-white truncate max-w-[220px]">
                                    {{ $client->name }}
                                </div>
                                @if (!empty($client->sub))
                                    <div class="text-[10px] text-blue-200/80 truncate max-w-[220px]">
                                        {{ $client->sub }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Row 2: Scrolling Right --}}
            <div class="marquee-track-right">
                @foreach ($row2->concat($row2) as $client)
                    <div
                        class="rounded-[20px] px-5 py-3 bg-[#24357a] hover:bg-[#2c4091] dark:bg-[#152347] dark:hover:bg-[#1d305f] border border-blue-400/20 shadow-md flex items-center justify-center gap-3 transition-all duration-300 min-w-[280px] sm:min-w-[320px] h-[80px] sm:h-[86px] cursor-default select-none hover:scale-[1.02]">
                        @if ($client->logo_url)
                            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" width="160" height="44"
                                class="h-10 sm:h-11 w-auto max-w-[260px] object-contain select-none pointer-events-none"
                                loading="lazy" decoding="async">
                        @else
                            <div
                                class="w-10 h-10 rounded-xl {{ $client->color ?: 'bg-blue-600 text-white' }} flex items-center justify-center font-black text-xs flex-shrink-0">
                                {{ $client->abbr ?: 'PU' }}
                            </div>
                            <div class="overflow-hidden text-left">
                                <div class="text-xs font-bold text-white truncate max-w-[220px]">
                                    {{ $client->name }}
                                </div>
                                @if (!empty($client->sub))
                                    <div class="text-[10px] text-blue-200/80 truncate max-w-[220px]">
                                        {{ $client->sub }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-8 text-slate-400 text-sm">
            Belum ada mitra klien terdaftar.
        </div>
    @endif
</section>
