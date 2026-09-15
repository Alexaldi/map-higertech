import L from 'leaflet';
import 'leaflet.markercluster';
import { typeMeta, stationIconSvg } from './constants.js';
import { buildPopup } from './popup.js';

const STATIONS_URL = '/api/stations';

export function initMapPreview() {
    const container = document.getElementById('preview-station-map');
    if (!container) return;

    const isDark = document.documentElement.classList.contains('dark');

    const darkTileUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}';
    const lightTileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

    const tileLayer = L.tileLayer(isDark ? darkTileUrl : lightTileUrl, {
        attribution: isDark
            ? 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ'
            : '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 16,
        minZoom: 4,
    });

    const map = L.map(container, {
        center: [-2.5489, 118.0149],
        zoom: 5,
        minZoom: 4,
        maxZoom: 16,
        zoomControl: false,
        preferCanvas: true,
        scrollWheelZoom: false,
    });

    tileLayer.addTo(map);

    window.addEventListener('theme-changed', (e) => {
        tileLayer.setUrl(e.detail === 'dark' ? darkTileUrl : lightTileUrl);
    });

    const clusters = L.markerClusterGroup({
        chunkedLoading: true,
        maxClusterRadius: 45,
        showCoverageOnHover: false,
        spiderfyOnMaxZoom: true,
        iconCreateFunction(cluster) {
            const count = cluster.getChildCount();
            const size = count >= 100 ? 'large' : count >= 10 ? 'medium' : 'small';
            return L.divIcon({
                className: 'station-cluster-wrapper',
                html: `<span class="station-cluster station-cluster--${size}">${count}</span>`,
                iconSize: L.point(42, 42),
            });
        },
    });

    clusters.addTo(map);

    const dismissSkeleton = () => {
        const skeleton = document.getElementById('map-preview-skeleton');
        if (skeleton) {
            skeleton.classList.add('opacity-0');
            setTimeout(() => skeleton.remove(), 500);
        }
    };

    tileLayer.once('load', dismissSkeleton);

    fetch(STATIONS_URL)
        .then(res => res.json())
        .then(res => {
            dismissSkeleton();
            const stations = res.data || [];
            const countBadge = document.getElementById('preview-station-count');
            if (countBadge) {
                countBadge.textContent = `${stations.length} Pos Terhubung`;
            }

            stations.forEach(station => {
                if (!station.latitude || !station.longitude) return;
                const meta = typeMeta(station.station_type);
                const icon = L.divIcon({
                    className: 'station-marker-wrapper',
                    html: `<span class="station-marker" style="--station-color:${meta.color}"><span>${stationIconSvg(station.station_type, 'station-marker__icon')}</span></span>`,
                    iconSize: L.point(34, 42),
                    iconAnchor: L.point(17, 40),
                    popupAnchor: L.point(0, -36),
                });

                const marker = L.marker([Number(station.latitude), Number(station.longitude)], {
                    icon,
                    title: station.name || 'Station',
                }).bindPopup(buildPopup(station), {
                    className: 'telemetry-popup',
                    maxWidth: 320,
                    minWidth: 260,
                });

                clusters.addLayer(marker);
            });
        })
        .catch(err => {
            dismissSkeleton();
            console.warn('Map preview stations error:', err);
        });

    const btnZoomIn = document.getElementById('preview-zoom-in');
    if (btnZoomIn) {
        btnZoomIn.addEventListener('click', () => {
            map.zoomIn();
        });
    }

    const btnZoomOut = document.getElementById('preview-zoom-out');
    if (btnZoomOut) {
        btnZoomOut.addEventListener('click', () => {
            map.zoomOut();
        });
    }

    const btnReset = document.getElementById('preview-reset-map');
    if (btnReset) {
        btnReset.addEventListener('click', () => {
            map.setView([-2.5489, 118.0149], 5, { animate: true });
        });
    }

    const btnFit = document.getElementById('preview-fit-markers');
    if (btnFit) {
        btnFit.addEventListener('click', () => {
            if (clusters.getLayers().length > 0) {
                map.fitBounds(clusters.getBounds(), { padding: [60, 40], maxZoom: 12 });
            }
        });
    }
}

