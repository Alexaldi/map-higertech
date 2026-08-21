import { stationIconSvg, typeMeta } from './constants.js';
import { escapeHtml, formatLocation, relativeTime, telemetryRows } from './formatters.js';

export const buildPopup = (station = {}, now = new Date()) => {
    const meta = typeMeta(station.station_type);
    const online = station.device_status === 'online';
    const rows = telemetryRows(station);
    const organization = station.balai_name
        ? `<p class="station-popup__organization">${escapeHtml(station.balai_name)}</p>`
        : '';
    const device = station.device_id
        ? `<span><small>Device ID</small>${escapeHtml(station.device_id)}</span>`
        : '';
    const telemetry = rows.length
        ? rows.map((row) => `
            <div class="station-popup__metric">
                <span>${escapeHtml(row.label)}</span>
                <strong>${escapeHtml(row.value)}</strong>
            </div>`).join('')
        : '<p class="station-popup__no-data">Data telemetry belum tersedia</p>';

    return `
        <article class="station-popup">
            <header class="station-popup__header">
                <span class="station-popup__category-icon" style="--station-color:${meta.color}">${stationIconSvg(station.station_type, 'station-popup__category-icon-svg')}</span>
                <div class="station-popup__heading">
                    <p class="station-popup__eyebrow">LIVE TELEMETRY</p>
                    <h3>${escapeHtml(station.name || 'Station tanpa nama')}</h3>
                </div>
                <span class="station-popup__type" style="--station-color:${meta.color}">${escapeHtml(meta.short)}</span>
            </header>
            <div class="station-popup__status ${online ? 'is-online' : 'is-offline'}">
                <span aria-hidden="true"></span>${online ? 'Online' : 'Offline'}
            </div>
            <section class="station-popup__context">
                ${organization}
                <p>${escapeHtml(formatLocation(station))}</p>
                <div class="station-popup__meta">
                    ${device}
                    <span><small>Update Terakhir</small>${escapeHtml(relativeTime(station.reading_at, now))}</span>
                </div>
            </section>
            <section class="station-popup__telemetry">
                <p class="station-popup__section-title">TELEMETRY TERKINI</p>
                <div class="station-popup__metrics">${telemetry}</div>
            </section>
        </article>`;
};
