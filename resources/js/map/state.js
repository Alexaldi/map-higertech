import { stationIconSvg, typeMeta } from './constants.js';
import { escapeHtml, formatLocation, relativeTime } from './formatters.js';

export const buildStationQuery = (filters = {}) => {
    const params = new URLSearchParams();

    for (const key of ['search', 'type', 'status', 'organization']) {
        const value = String(filters[key] ?? '').trim();
        if (value) params.set(key, value);
    }

    return params.toString();
};

export const applyFilterDraft = (filters = {}, draft = {}) => ({
    search: filters.search ?? '',
    type: draft.type ?? '',
    status: draft.status ?? '',
    organization: draft.organization ?? '',
});

export const buildStationSuggestions = (stations = [], query = '', limit = 6) => {
    const normalizedQuery = String(query ?? '').trim().toLocaleLowerCase();
    const maxResults = Math.max(0, Number(limit) || 0);

    if (!normalizedQuery || !Array.isArray(stations) || maxResults === 0) return [];

    return stations
        .filter((station) => String(station?.name ?? '').trim().toLocaleLowerCase().includes(normalizedQuery))
        .sort((left, right) => {
            const leftName = String(left?.name ?? '').trim().toLocaleLowerCase();
            const rightName = String(right?.name ?? '').trim().toLocaleLowerCase();
            const leftStarts = leftName.startsWith(normalizedQuery);
            const rightStarts = rightName.startsWith(normalizedQuery);

            if (leftStarts !== rightStarts) return leftStarts ? -1 : 1;

            return leftName.localeCompare(rightName, 'id');
        })
        .slice(0, maxResults);
};

export const hasValidCoordinates = (station = {}) => {
    if (station.latitude === null || station.latitude === undefined || station.longitude === null || station.longitude === undefined) {
        return false;
    }

    return Number.isFinite(Number(station.latitude)) && Number.isFinite(Number(station.longitude));
};

export const buildStationCard = (station = {}, now = new Date()) => {
    const meta = typeMeta(station.station_type);
    const online = station.device_status === 'online';
    const clock = now instanceof Date ? now : new Date();
    const location = formatLocation({
        regency_name: station.regency_name,
        province_name: station.province_name,
    });
    const device = station.device_id
        ? `<span class="station-card__device"><b>Device</b>${escapeHtml(station.device_id)}</span>`
        : '';

    return `
        <button class="station-card" type="button" data-station-id="${Number(station.id)}" style="--station-color:${meta.color}">
            <span class="station-card__logo" aria-hidden="true">${stationIconSvg(station.station_type, 'station-card__logo-svg')}</span>
            <span class="station-card__content">
                <span class="station-card__heading">
                    <strong>${escapeHtml(station.name || 'Station tanpa nama')}</strong>
                    <span class="station-card__status ${online ? 'is-online' : 'is-offline'}">
                        <i aria-hidden="true"></i>${online ? 'Online' : 'Offline'}
                    </span>
                </span>
                <span class="station-card__category">
                    <span>${escapeHtml(meta.label)}</span><b>${escapeHtml(meta.short)}</b>
                </span>
                <span class="station-card__organization">${escapeHtml(station.balai_name || 'Instansi belum tersedia')}</span>
                <span class="station-card__details">
                    <span title="Lokasi station">${escapeHtml(location)}</span>
                    <span title="Update terakhir">${escapeHtml(relativeTime(station.reading_at, clock))}</span>
                </span>
                ${device}
            </span>
        </button>`;
};

export const focusStationMarker = (map, marker) => {
    const target = marker.getLatLng();
    const targetZoom = Math.max(map.getZoom(), 12);
    const currentCenter = map.getCenter?.();

    if (currentCenter?.equals?.(target) && map.getZoom() >= targetZoom) {
        marker.openPopup();
        return;
    }

    let opened = false;
    const openPopup = () => {
        if (opened) return;
        opened = true;
        marker.openPopup();
    };

    map.once('moveend zoomend', openPopup);
    map.flyTo(target, targetZoom, { duration: 0.7 });
};

export const setStationPanelOpen = ({ panel, launchers = [], backdrop }, open) => {
    panel?.classList.toggle('is-open', open);
    panel?.setAttribute('aria-hidden', String(!open));
    backdrop?.classList.toggle('hidden', !open);

    for (const launcher of launchers) {
        launcher?.setAttribute('aria-expanded', String(open));
    }
};
