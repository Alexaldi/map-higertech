@extends('layouts.app')

@section('title', __('map.title'))

@section('body_class', 'overflow-hidden bg-slate-100 dark:bg-[#0B1120] font-sans text-slate-900 dark:text-slate-100 flex
    flex-col h-dvh')

    @push('head')
        <meta name="theme-color" content="#0f4c81">
    @endpush

@section('content')
    <div id="app" class="flex flex-1 min-h-0 flex-col" data-live-map>

        <main class="relative min-h-0 flex-1 overflow-hidden">
            <section id="map-workspace" class="relative h-full overflow-hidden bg-slate-200 dark:bg-[#070d18]"
                aria-label="Peta monitoring station">
                <div id="station-map" class="h-full w-full" role="application" aria-label="Live monitoring map Indonesia">
                </div>

                <button id="station-panel-launcher" class="station-panel-launcher" type="button"
                    aria-controls="station-sidebar" aria-expanded="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path d="M4 6h10M18 6h2M4 12h2m4 0h10M4 18h7m4 0h5" />
                        <circle cx="16" cy="6" r="2" />
                        <circle cx="8" cy="12" r="2" />
                        <circle cx="13" cy="18" r="2" />
                    </svg>
                    <span>{{ __('map.pos_button') }}</span>
                </button>

                @include('map.partials.sidebar')
                @include('map.partials.summary')

                <aside id="map-legend" class="map-legend" aria-label="Keterangan marker station">
                    <details>
                        <summary>
                            <span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    aria-hidden="true">
                                    <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" />
                                    <circle cx="12" cy="10" r="2.5" />
                                </svg>
                                <span><strong>{{ __('map.marker_legend') }}</strong><small>{{ __('map.marker_types_count') }}</small></span>
                            </span>
                            <svg class="map-legend__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" aria-hidden="true">
                                <path d="m9 7 5 5-5 5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </summary>
                        <ul id="map-legend-items"></ul>
                    </details>
                </aside>

                <div class="map-toolbar" aria-label="Kontrol peta">
                    <button id="reset-map" class="map-action" type="button" title="{{ __('map.reset_map') }}"
                        aria-label="{{ __('map.reset_map') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M4 12a8 8 0 1 0 2.3-5.7L4 8.6" />
                            <path d="M4 4v4.6h4.6" />
                        </svg>
                        <span class="sr-only">Reset map</span>
                    </button>
                    <button id="fit-markers" class="map-action" type="button" title="{{ __('map.fit_markers') }}"
                        aria-label="{{ __('map.fit_markers') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M8 3H3v5m13-5h5v5M8 21H3v-5m18 0v5h-5" />
                            <path d="M9 9h6v6H9z" />
                        </svg>
                        <span class="sr-only">Fit markers</span>
                    </button>
                    <button id="fullscreen-map" class="map-action" type="button" title="{{ __('map.fullscreen_map') }}"
                        aria-label="{{ __('map.fullscreen_map') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M8 3H3v5m13-5h5v5M8 21H3v-5m18-5v5h-5" />
                        </svg>
                        <span class="sr-only">Fullscreen map</span>
                    </button>
                </div>

                <div id="station-loading" class="map-state" role="status" aria-live="polite">
                    <span class="loading-spinner" aria-hidden="true"></span>
                    <span>{{ __('map.loading') }}</span>
                </div>

                <div id="station-empty" class="map-state hidden" role="status">
                    <strong>{{ __('map.empty_title') }}</strong>
                    <span>{{ __('map.empty_subtitle') }}</span>
                </div>

                <div id="station-error" class="map-state hidden" role="alert">
                    <strong>{{ __('map.error_title') }}</strong>
                    <span>{{ __('map.error_subtitle') }}</span>
                    <button id="stations-retry" type="button" class="state-retry">{{ __('map.retry') }}</button>
                </div>
            </section>
        </main>

        <button id="drawer-backdrop" class="fixed inset-0 z-[1100] hidden bg-slate-950/40 backdrop-blur-[1px]"
            type="button" aria-label="Tutup panel filter"></button>
    </div>
@endsection
