<aside
    id="station-sidebar"
    class="station-panel"
    data-desktop-persistent
    aria-label="Filter dan daftar station"
    aria-hidden="false"
>
    <section class="station-panel__controls-card" data-dock="station-controls" data-station-controls aria-labelledby="station-discovery-heading">
        <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-blue-700">Jaringan Telemetri</p>
                <h2 id="station-discovery-heading" class="mt-0.5 text-sm font-bold text-slate-950">Temukan Pos</h2>
                <p class="mt-0.5 text-[11px] text-slate-500">Cari dan filter jaringan monitoring</p>
            </div>
            <button
                id="station-panel-close"
                class="inline-flex size-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                type="button"
                aria-label="Tutup daftar station"
            >
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="m6 6 12 12M18 6 6 18" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <div class="sidebar-controls p-3">
            <div>
                <label for="station-search" class="mb-1.5 block text-[11px] font-bold text-slate-700">Cari pos</label>
                <form id="station-search-form" class="station-search-field relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="11" cy="11" r="7" /><path d="m20 20-3.5-3.5" stroke-linecap="round" />
                    </svg>
                    <input id="station-search" class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-20 text-[13px] outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-3 focus:ring-blue-100" type="search" placeholder="Cari nama pos..." autocomplete="off" role="combobox" aria-controls="station-search-suggestions" aria-expanded="false">
                    <button id="station-search-submit" class="station-search-submit" type="submit">Search</button>
                    <div id="station-search-suggestions" class="station-search-suggestions" role="listbox" aria-label="Rekomendasi nama pos" hidden></div>
                </form>
            </div>

            <details id="station-filter-panel" class="station-filter-panel">
                <summary>
                    <span class="station-filter-panel__heading">
                        <span class="station-filter-panel__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6h10M18 6h2M4 12h2m4 0h10M4 18h7m4 0h5"/><circle cx="16" cy="6" r="2"/><circle cx="8" cy="12" r="2"/><circle cx="13" cy="18" r="2"/></svg>
                        </span>
                        <span><strong>Filter station</strong><small>Tipe, status, dan instansi</small></span>
                    </span>
                    <svg class="station-filter-panel__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </summary>

                <div class="station-filter-panel__body space-y-3.5">
                    <fieldset>
                        <legend class="mb-2 text-[11px] font-bold text-slate-700">Jenis pos <span class="font-medium text-slate-400">(12 tipe)</span></legend>
                        <div class="grid grid-cols-4 gap-1.5" data-type-filters>
                            <button class="filter-chip col-span-4 is-active" type="button" data-type="">Semua jenis pos</button>
                            <button class="filter-chip" type="button" data-type="ARR">ARR</button>
                            <button class="filter-chip" type="button" data-type="AWLR">AWLR</button>
                            <button class="filter-chip" type="button" data-type="AWS">AWS</button>
                            <button class="filter-chip" type="button" data-type="AWLR_ARR">AWLR+ARR</button>
                            <button class="filter-chip" type="button" data-type="AGWLR">AGWLR</button>
                            <button class="filter-chip" type="button" data-type="FM">FM</button>
                            <button class="filter-chip" type="button" data-type="EWS">EWS</button>
                            <button class="filter-chip" type="button" data-type="AVWR">AVWR</button>
                            <button class="filter-chip" type="button" data-type="WQ">WQ</button>
                            <button class="filter-chip" type="button" data-type="VNOTCH">VNOTCH</button>
                            <button class="filter-chip" type="button" data-type="OW">OW</button>
                            <button class="filter-chip" type="button" data-type="OSP">OSP</button>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="mb-2 text-[11px] font-bold text-slate-700">Status perangkat</legend>
                        <div class="grid grid-cols-3 gap-1.5" data-status-filters>
                            <button class="filter-chip is-active" type="button" data-status="">Semua</button>
                            <button class="filter-chip" type="button" data-status="online">Online</button>
                            <button class="filter-chip" type="button" data-status="offline">Offline</button>
                        </div>
                    </fieldset>

                    <div>
                        <label for="organization-filter" class="mb-1.5 block text-[11px] font-bold text-slate-700">Instansi / Balai</label>
                        <select id="organization-filter" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-[13px] outline-none transition focus:border-blue-500 focus:bg-white focus:ring-3 focus:ring-blue-100">
                            <option value="">Semua instansi</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <button id="clear-filters" class="rounded-lg border border-slate-200 px-3 py-2.5 text-[11px] font-bold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700" type="button">Reset</button>
                        <button id="apply-filters" class="rounded-lg bg-blue-600 px-3 py-2.5 text-[11px] font-bold text-white shadow-sm transition hover:bg-blue-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600" type="button">Terapkan Filter</button>
                    </div>
                </div>
            </details>
        </div>
    </section>

    <section class="station-panel__results-card" data-dock="station-results" data-station-list aria-labelledby="station-results-heading">
        <div class="station-panel__results-heading">
            <div>
                <p>Hasil pencarian</p>
                <h3 id="station-results-heading">Daftar Pos</h3>
            </div>
            <p id="station-result-status" aria-live="polite">Menyiapkan data...</p>
        </div>
        <div id="station-results" class="min-h-0 flex-1 space-y-1.5 overflow-y-auto bg-slate-50/70 p-3" aria-label="Hasil station"></div>
    </section>
</aside>
