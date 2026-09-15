export const DEFAULT_VIEW = Object.freeze({ center: [-2.5, 118], zoom: 5 });

export const TYPE_META = Object.freeze({
    ARR: { label: 'Pos Curah Hujan', short: 'ARR', color: '#0284c7' },
    AWLR: { label: 'Pos Duga Air', short: 'AWLR', color: '#0891b2' },
    AWS: { label: 'Pos Klimatologi', short: 'AWS', color: '#d97706' },
    AWLR_ARR: { label: 'Duga Air + Curah Hujan', short: 'AWLR + ARR', color: '#7c3aed' },
    AGWLR: { label: 'Air Tanah', short: 'AGWLR', color: '#0d9488' },
    FM: { label: 'Flow Meter', short: 'FM', color: '#ea580c' },
    EWS: { label: 'Early Warning System', short: 'EWS', color: '#e11d48' },
    AVWR: { label: 'Automatic Valve', short: 'AVWR', color: '#4f46e5' },
    WQ: { label: 'Kualitas Air', short: 'WQ', color: '#059669' },
    VNOTCH: { label: 'V-Notch', short: 'VNOTCH', color: '#65a30d' },
    OW: { label: 'Observation Well', short: 'OW', color: '#475569' },
    OSP: { label: 'Outlet Structure Pump', short: 'OSP', color: '#c026d3' },
});

const FALLBACK_META = Object.freeze({ label: 'Station Lainnya', short: 'OTHER', color: '#64748b' });
export const STATION_TYPES = Object.freeze(Object.keys(TYPE_META));

const ICON_PATHS = Object.freeze({
    ARR: '<path d="M6 13a4 4 0 0 1 1-7.87A5 5 0 0 1 16.9 7H18a3 3 0 0 1 0 6H6Z"/><path d="m8 16-1 2m5-2-1 2m5-2-1 2"/>',
    AWLR: '<path d="M4 15c2-2 4 2 6 0s4 2 6 0 4 0 4 0M4 19c2-2 4 2 6 0s4 2 6 0 4 0 4 0"/><path d="M12 4v7m-3-3 3 3 3-3"/>',
    AWS: '<circle cx="12" cy="12" r="3"/><path d="M12 2v3m0 14v3M2 12h3m14 0h3M4.9 4.9 7 7m10 10 2.1 2.1m0-14.2L17 7M7 17l-2.1 2.1"/>',
    AWLR_ARR: '<path d="M5 11a3.5 3.5 0 0 1 1-6.86A4.5 4.5 0 0 1 15 6h1a3 3 0 0 1 0 6H5Z"/><path d="m8 14-1 2m5-2-1 2m-6 4c2-2 4 2 6 0s4 2 6 0 3 0 3 0"/>',
    AGWLR: '<path d="M4 18c2-2 4 2 6 0s4 2 6 0 4 0 4 0M12 3v11m-4-4 4 4 4-4"/>',
    FM: '<path d="M4 8h5l2 3h9v6H9l-2-3H4V8Z"/><path d="M14 8V5m3 3V5"/>',
    EWS: '<path d="M12 3 2.8 20h18.4L12 3Z"/><path d="M12 9v5m0 3h.01"/>',
    AVWR: '<path d="M4 7l8 5-8 5V7Zm16 0-8 5 8 5V7Z"/><circle cx="12" cy="12" r="2"/><path d="M12 10V5"/>',
    WQ: '<path d="M12 3s6 6.2 6 11a6 6 0 0 1-12 0c0-4.8 6-11 6-11Z"/><path d="m9 14 2 2 4-5"/>',
    VNOTCH: '<path d="M4 7l8 12L20 7"/><path d="M3 5h18M5 15c2-2 4 2 6 0s4 2 6 0 3 0 3 0"/>',
    OW: '<ellipse cx="12" cy="6" rx="6" ry="3"/><path d="M6 6v11c0 1.7 12 1.7 12 0V6M9 11h6m-6 4h6"/>',
    OSP: '<path d="M5 19V9h10v10M8 9V5h6l3 4M3 19h18"/><path d="M10 13h6m-2-2 2 2-2 2"/>',
    OTHER: '<circle cx="12" cy="12" r="7"/><path d="M12 8v4l3 2"/>',
});

export const BASEMAPS = Object.freeze([
    {
        key: 'street', label: 'Jalan', description: 'Peta jalan OpenStreetMap',
        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', thumbnail: 'https://a.tile.openstreetmap.org/5/26/16.png',
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors', maxZoom: 19,
    },
    {
        key: 'humanitarian', label: 'Humanitarian', description: 'Kontras untuk respons lapangan',
        url: 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', thumbnail: 'https://a.tile.openstreetmap.fr/hot/5/26/16.png',
        attribution: '&copy; OpenStreetMap contributors, Tiles style by HOT', maxZoom: 19,
    },
    {
        key: 'topographic', label: 'Topografi', description: 'Kontur dan relief permukaan',
        url: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', thumbnail: 'https://a.tile.opentopomap.org/5/26/16.png',
        attribution: 'Map data &copy; OpenStreetMap contributors, SRTM | Map style &copy; OpenTopoMap', maxZoom: 17,
    },
    {
        key: 'light', label: 'Light', description: 'Basemap terang dan minimal',
        url: 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}',
        thumbnail: 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/5/16/26',
        attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ', maxZoom: 16,
    },
    {
        key: 'dark', label: 'Dark', description: 'Basemap gelap command center',
        url: 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}',
        thumbnail: 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/5/16/26',
        attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ', maxZoom: 16,
    },
    {
        key: 'satellite', label: 'Satellite', description: 'Sentinel-2 Cloudless non-Google',
        url: 'https://tiles.maps.eox.at/wmts/1.0.0/s2cloudless-2025_3857/default/g/{z}/{y}/{x}.jpg',
        thumbnail: 'https://tiles.maps.eox.at/wmts/1.0.0/s2cloudless-2025_3857/default/g/5/16/26.jpg',
        attribution: '<a href="https://cloudless.eox.at">EOX Sentinel-2 Cloudless</a> (modified Copernicus Sentinel data 2025)',
        maxZoom: 19, maxNativeZoom: 14,
    },
]);

export const typeMeta = (type) => TYPE_META[type] ?? FALLBACK_META;

export const stationIconSvg = (type, className = '') => {
    const paths = ICON_PATHS[type] ?? ICON_PATHS.OTHER;
    const classAttribute = className ? ` class="${className}"` : '';

    return `<svg${classAttribute} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${paths}</svg>`;
};

export const stationLegendHtml = () => STATION_TYPES.map((type) => {
    const meta = typeMeta(type);

    return `
        <li data-legend-type="${type}" style="--station-color:${meta.color}">
            <span class="map-legend__icon">${stationIconSvg(type, 'map-legend__icon-svg')}</span>
            <span><strong>${meta.label}</strong><small>${meta.short}</small></span>
        </li>`;
}).join('');

export const stationTypeSummaryHtml = (counts = {}) => STATION_TYPES.map((type) => {
    const meta = typeMeta(type);
    const value = Number(counts?.[type]);
    const count = Number.isFinite(value) ? value : 0;

    return `
        <li data-summary-type="${type}" style="--station-color:${meta.color}">
            <span class="type-summary__icon">${stationIconSvg(type, 'type-summary__icon-svg')}</span>
            <span><strong>${meta.label}</strong><small>${meta.short}</small></span>
            <b>${count}</b>
        </li>`;
}).join('');
