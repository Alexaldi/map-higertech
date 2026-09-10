import L from 'leaflet';
import 'leaflet.markercluster';

import { addBasemapGallery } from './basemaps.js';
import { DEFAULT_VIEW, stationIconSvg, stationLegendHtml, stationTypeSummaryHtml, typeMeta } from './constants.js';
import { bindMapControls } from './controls.js';
import { escapeHtml, formatLocation } from './formatters.js';
import { buildPopup } from './popup.js';
import { applyFilterDraft, buildStationCard, buildStationQuery, buildStationSuggestions, focusStationMarker, hasValidCoordinates, setStationPanelOpen } from './state.js';

const STATIONS_URL = '/api/stations';
const SUMMARY_URL = '/api/stations/summary';
const root = document.querySelector('[data-live-map]');

if (root) {
    initialize(root);
}

function initialize(rootElement) {
    const elements = {
        map: document.querySelector('#station-map'),
        results: document.querySelector('#station-results'),
        resultStatus: document.querySelector('#station-result-status'),
        search: document.querySelector('#station-search'),
        searchForm: document.querySelector('#station-search-form'),
        searchSuggestions: document.querySelector('#station-search-suggestions'),
        organization: document.querySelector('#organization-filter'),
        typeFilters: document.querySelector('[data-type-filters]'),
        statusFilters: document.querySelector('[data-status-filters]'),
        clearFilters: document.querySelector('#clear-filters'),
        applyFilters: document.querySelector('#apply-filters'),
        filterPanel: document.querySelector('#station-filter-panel'),
        loading: document.querySelector('#station-loading'),
        empty: document.querySelector('#station-empty'),
        error: document.querySelector('#station-error'),
        stationsRetry: document.querySelector('#stations-retry'),
        summaryRetry: document.querySelector('#summary-retry'),
        sidebar: document.querySelector('#station-sidebar'),
        panelLauncher: document.querySelector('#station-panel-launcher'),
        panelClose: document.querySelector('#station-panel-close'),
        drawerToggle: document.querySelector('#drawer-toggle'),
        drawerBackdrop: document.querySelector('#drawer-backdrop'),
        resetMap: document.querySelector('#reset-map'),
        fitMarkers: document.querySelector('#fit-markers'),
        fullscreenMap: document.querySelector('#fullscreen-map'),
        legendItems: document.querySelector('#map-legend-items'),
        typeSummaryItems: document.querySelector('#type-summary-items'),
    };

    if (!elements.map) return;

    if (elements.legendItems) elements.legendItems.innerHTML = stationLegendHtml();

    const map = createMap(elements.map);
    const clusters = createClusterLayer().addTo(map);
    bindMapControls({
        map,
        clusters,
        resetButton: elements.resetMap,
        fitButton: elements.fitMarkers,
        fullscreenButton: elements.fullscreenMap,
    });
    const state = {
        filters: { search: '', type: '', status: '', organization: '' },
        stations: [],
        markers: new Map(),
        request: null,
        searchTimer: null,
        organizationsLoaded: false,
    };

    bindFilters(elements, state, fetchStations);
    bindSearchSuggestions(elements, state, map);
    const closeStationPanel = bindStationPanel(elements);
    bindStationNavigation(elements, state, map, closeStationPanel);
    elements.stationsRetry.addEventListener('click', () => fetchStations());
    elements.summaryRetry.addEventListener('click', () => fetchSummary());

    fetchSummary();
    fetchStations();

    async function fetchStations() {
        state.request?.abort();
        const request = new AbortController();
        state.request = request;
        showStationState(elements, 'loading');
        elements.resultStatus.textContent = 'Memuat station...';

        try {
            const query = buildStationQuery(state.filters);
            const response = await fetch(`${STATIONS_URL}${query ? `?${query}` : ''}`, {
                signal: request.signal,
                headers: { Accept: 'application/json' },
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const payload = await response.json();
            if (!Array.isArray(payload?.data)) throw new Error('Invalid station payload');

            populateOrganizations(elements.organization, payload.meta?.organizations, state);
            renderStations(payload.data, elements, state, map, clusters);
        } catch (error) {
            if (error.name === 'AbortError') return;

            showStationState(elements, 'error');
            elements.resultStatus.textContent = 'Gagal memuat station';
        }
    }

    async function fetchSummary() {
        elements.summaryRetry.classList.add('hidden');

        try {
            const response = await fetch(SUMMARY_URL, { headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const summary = await response.json();
            setText('#summary-total', summary.total);
            setText('#summary-organizations', summary.organizations);
            setText('#summary-online', summary.online);
            setText('#summary-offline', summary.offline);
            if (elements.typeSummaryItems) {
                elements.typeSummaryItems.innerHTML = stationTypeSummaryHtml(summary.types);
            }
        } catch {
            elements.summaryRetry.classList.remove('hidden');
        }
    }
}

function createMap(container) {
    const map = L.map(container, {
        center: DEFAULT_VIEW.center,
        zoom: DEFAULT_VIEW.zoom,
        minZoom: 4,
        zoomControl: true,
        preferCanvas: true,
    });

    addBasemapGallery(L, map);

    return map;
}

function createClusterLayer() {
    return L.markerClusterGroup({
        chunkedLoading: true,
        maxClusterRadius: 52,
        removeOutsideVisibleBounds: true,
        showCoverageOnHover: false,
        spiderfyOnMaxZoom: true,
        iconCreateFunction(cluster) {
            const count = cluster.getChildCount();
            const size = count >= 100 ? 'large' : count >= 10 ? 'medium' : 'small';

            return L.divIcon({
                className: 'station-cluster-wrapper',
                html: `<span class="station-cluster station-cluster--${size}">${count}</span>`,
                iconSize: L.point(46, 46),
            });
        },
    });
}

function createMarker(station) {
    const meta = typeMeta(station.station_type);
    const icon = L.divIcon({
        className: 'station-marker-wrapper',
        html: `<span class="station-marker" style="--station-color:${meta.color}"><span>${stationIconSvg(station.station_type, 'station-marker__icon')}</span></span>`,
        iconSize: L.point(38, 46),
        iconAnchor: L.point(19, 44),
        popupAnchor: L.point(0, -40),
    });

    return L.marker([Number(station.latitude), Number(station.longitude)], {
        icon,
        title: station.name || 'Station telemetry',
        riseOnHover: true,
    }).bindPopup(buildPopup(station), {
        autoPanPaddingTopLeft: L.point(20, 160),
        autoPanPaddingBottomRight: L.point(20, 20),
        className: 'telemetry-popup',
        maxWidth: 340,
        minWidth: 290,
    });
}

function renderStations(stations, elements, state, map, clusters) {
    const nextMarkers = new Map();
    const layers = [];
    const validStations = [];

    for (const station of stations) {
        if (!hasValidCoordinates(station)) continue;

        try {
            const marker = createMarker(station);
            nextMarkers.set(Number(station.id), marker);
            layers.push(marker);
            validStations.push(station);
        } catch {
            // A malformed station is skipped without affecting the rest of the network.
        }
    }

    clusters.clearLayers();
    clusters.addLayers(layers);
    state.stations = validStations;
    state.markers = nextMarkers;
    elements.results.innerHTML = validStations.map(buildStationCard).join('');
    elements.resultStatus.textContent = `${validStations.length} station ditemukan`;
    renderSearchSuggestions(elements, state);

    if (validStations.length === 0) {
        showStationState(elements, 'empty');
        map.setView(DEFAULT_VIEW.center, DEFAULT_VIEW.zoom);
    } else {
        showStationState(elements, 'ready');
    }
}

function populateOrganizations(select, organizations, state) {
    if (state.organizationsLoaded || !Array.isArray(organizations)) return;

    const fragment = document.createDocumentFragment();
    for (const organization of organizations) {
        if (!organization?.code || !organization?.name) continue;
        const option = document.createElement('option');
        option.value = organization.code;
        option.textContent = organization.name;
        fragment.append(option);
    }

    select.append(fragment);
    state.organizationsLoaded = true;
}

function showStationState(elements, mode) {
    elements.loading.classList.toggle('hidden', mode !== 'loading');
    elements.empty.classList.toggle('hidden', mode !== 'empty');
    elements.error.classList.toggle('hidden', mode !== 'error');
}

function bindFilters(elements, state, fetchStations) {
    let draft = {
        type: state.filters.type,
        status: state.filters.status,
        organization: state.filters.organization,
    };

    elements.search.addEventListener('input', () => {
        delete elements.searchSuggestions.dataset.selected;
        renderSearchSuggestions(elements, state);
        window.clearTimeout(state.searchTimer);
        state.searchTimer = window.setTimeout(() => {
            state.filters.search = elements.search.value;
            fetchStations();
        }, 300);
    });

    elements.searchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        window.clearTimeout(state.searchTimer);
        state.searchTimer = null;
        state.filters.search = elements.search.value;
        elements.searchSuggestions.dataset.selected = 'true';
        elements.searchSuggestions.hidden = true;
        elements.search.setAttribute('aria-expanded', 'false');
        fetchStations();
    });

    elements.typeFilters.addEventListener('click', (event) => {
        const button = event.target.closest('[data-type]');
        if (!button) return;
        draft.type = button.dataset.type;
        activateFilter(elements.typeFilters, '[data-type]', button);
    });

    elements.statusFilters.addEventListener('click', (event) => {
        const button = event.target.closest('[data-status]');
        if (!button) return;
        draft.status = button.dataset.status;
        activateFilter(elements.statusFilters, '[data-status]', button);
    });

    elements.organization.addEventListener('change', () => {
        draft.organization = elements.organization.value;
    });

    elements.clearFilters.addEventListener('click', () => {
        draft = { type: '', status: '', organization: '' };
        elements.organization.value = '';
        activateFilter(elements.typeFilters, '[data-type]', elements.typeFilters.querySelector('[data-type=""]'));
        activateFilter(elements.statusFilters, '[data-status]', elements.statusFilters.querySelector('[data-status=""]'));
    });

    elements.applyFilters.addEventListener('click', () => {
        state.filters = applyFilterDraft(state.filters, draft);
        fetchStations();
        elements.filterPanel.open = false;
    });

    activateFilter(elements.typeFilters, '[data-type]', elements.typeFilters.querySelector('.is-active'));
    activateFilter(elements.statusFilters, '[data-status]', elements.statusFilters.querySelector('.is-active'));
}

function bindSearchSuggestions(elements, state, map) {
    if (!elements.searchSuggestions) return;

    const hide = () => {
        elements.searchSuggestions.hidden = true;
        elements.search.setAttribute('aria-expanded', 'false');
    };

    elements.searchSuggestions.addEventListener('click', (event) => {
        const suggestion = event.target.closest('[data-station-id]');
        if (!suggestion) return;

        const stationId = Number(suggestion.dataset.stationId);
        const station = state.stations.find((item) => Number(item.id) === stationId);
        const marker = state.markers.get(stationId);
        if (!station || !marker) return;

        elements.search.value = station.name || '';
        window.clearTimeout(state.searchTimer);
        state.searchTimer = null;
        state.request?.abort();
        state.filters.search = station.name || '';
        elements.searchSuggestions.dataset.selected = 'true';
        hide();
        focusStationMarker(map, marker);
    });

    elements.search.addEventListener('focus', () => renderSearchSuggestions(elements, state));
    elements.search.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            event.stopPropagation();
            hide();
        }
    });
    document.addEventListener('click', (event) => {
        if (!elements.searchSuggestions.contains(event.target) && event.target !== elements.search) hide();
    });
}

function renderSearchSuggestions(elements, state) {
    if (!elements.searchSuggestions) return;

    if (elements.searchSuggestions.dataset.selected === 'true') {
        elements.searchSuggestions.hidden = true;
        elements.search.setAttribute('aria-expanded', 'false');
        return;
    }

    const suggestions = buildStationSuggestions(state.stations, elements.search.value, 6);
    elements.searchSuggestions.innerHTML = suggestions.map((station) => {
        const meta = typeMeta(station.station_type);
        const location = formatLocation({
            regency_name: station.regency_name,
            province_name: station.province_name,
        });

        return `
            <button class="station-search-suggestion" type="button" role="option" data-station-id="${Number(station.id)}" style="--station-color:${meta.color}">
                <span class="station-search-suggestion__icon" aria-hidden="true">${stationIconSvg(station.station_type)}</span>
                <span class="station-search-suggestion__copy">
                    <strong>${escapeHtml(station.name || 'Station tanpa nama')}</strong>
                    <small>${escapeHtml(`${meta.short} · ${location}`)}</small>
                </span>
            </button>`;
    }).join('');

    const visible = suggestions.length > 0 && elements.search.value.trim().length >= 2;
    elements.searchSuggestions.hidden = !visible;
    elements.search.setAttribute('aria-expanded', String(visible));
}

function activateFilter(container, selector, active) {
    for (const button of container.querySelectorAll(selector)) {
        const selected = button === active;
        button.classList.toggle('is-active', selected);
        button.setAttribute('aria-pressed', String(selected));
    }
}

function bindStationNavigation(elements, state, map, closeStationPanel) {
    elements.results.addEventListener('click', (event) => {
        const card = event.target.closest('[data-station-id]');
        if (!card) return;

        const marker = state.markers.get(Number(card.dataset.stationId));
        if (!marker) return;

        focusStationMarker(map, marker);

        if (window.matchMedia('(max-width: 1023px)').matches) {
            closeStationPanel();
        }
    });
}

function bindStationPanel(elements) {
    const mobile = window.matchMedia('(max-width: 1023px)');
    const mobileNav = document.querySelector('.site-mobile-nav');
    const controls = {
        panel: elements.sidebar,
        launchers: [elements.panelLauncher, elements.drawerToggle],
        backdrop: elements.drawerBackdrop,
    };
    const setOpen = (open) => {
        if (open && mobileNav) mobileNav.open = false;
        setStationPanelOpen(controls, open);
    };
    const close = () => setStationPanelOpen(controls, false);
    const toggle = () => {
        const open = !elements.sidebar.classList.contains('is-open');
        if (open) document.querySelector('.basemap-gallery__toggle[aria-expanded="true"]')?.click();
        setOpen(open);
    };

    elements.panelLauncher.addEventListener('click', toggle);
    elements.drawerToggle.addEventListener('click', toggle);
    elements.drawerBackdrop.addEventListener('click', close);
    elements.panelClose.addEventListener('click', close);
    mobile.addEventListener('change', () => setOpen(!mobile.matches));
    setOpen(!mobile.matches);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') close();
    });

    return close;
}

function setText(selector, value) {
    const element = document.querySelector(selector);
    if (element) element.textContent = Number.isFinite(Number(value)) ? String(value) : '—';
}
