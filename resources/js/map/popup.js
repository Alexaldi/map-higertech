import { stationIconSvg, typeMeta } from './constants.js';
import { escapeHtml, formatLocation, relativeTime, telemetryRows } from './formatters.js';

const DUMMY_STATION_PHOTOS = [
    {
        url: 'https://images.unsplash.com/photo-1509391365360-2e959784a276?w=600&auto=format&fit=crop&q=80',
        title: 'Unit Telemetri Lapangan',
    },
    {
        url: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=600&auto=format&fit=crop&q=80',
        title: 'Sensor & Enclosure Monitoring',
    },
];

export const buildPopup = (station = {}, now = new Date()) => {
    const meta = typeMeta(station.station_type);
    const photos = (Array.isArray(station.photos) && station.photos.length > 0)
        ? station.photos
        : DUMMY_STATION_PHOTOS;

    const slidesHtml = photos.map((p, idx) => `
        <div class="station-popup__slide ${idx === 0 ? '' : 'hidden'}" data-slide-index="${idx}">
            <img src="${escapeHtml(p.url || p)}" alt="${escapeHtml(p.title || station.name || 'Station')}" class="station-popup__slide-img" loading="lazy" onerror="this.src='/images/products/hero-unit.png'" />
        </div>
    `).join('');

    const dotsHtml = photos.map((_, idx) => `
        <span class="station-popup__dot ${idx === 0 ? 'is-active' : ''}" data-dot-index="${idx}"></span>
    `).join('');

    const rows = telemetryRows(station);
    if (station.cloud_cover !== null && station.cloud_cover !== undefined) {
        rows.push({ label: 'Tutupan Awan (API)', value: station.cloud_cover + '%' });
    }

    const telemetry = rows.length
        ? rows.map((row) => `
            <div class="station-popup__metric">
                <span class="station-popup__metric-label">${escapeHtml(row.label)}</span>
                <strong class="station-popup__metric-val">${escapeHtml(row.value)}</strong>
            </div>`).join('')
        : '<span class="station-popup__no-data">Data realtime belum tersedia</span>';

    const deviceId = station.device_id || `HGT${station.id || '-'}`;
    const installDate = station.installation_date || '-';
    const managerName = station.balai_name || '-';
    const locationText = formatLocation(station);

    return `
        <article class="station-popup">
            <header class="station-popup__header">
                <span class="station-popup__category-icon" style="--station-color:${meta.color}">
                    ${stationIconSvg(station.station_type, 'station-popup__category-icon-svg')}
                </span>
                <div class="station-popup__heading">
                    <div class="station-popup__title-row">
                        <span class="station-popup__type" style="--station-color:${meta.color}">${escapeHtml(meta.short)}</span>
                        <h3 class="station-popup__title" title="${escapeHtml(station.name || 'Pos Monitoring')}">${escapeHtml(station.name || 'Pos Monitoring')}</h3>
                    </div>
                </div>
            </header>

            <div class="station-popup__carousel">
                <div class="station-popup__slides">
                    ${slidesHtml}
                </div>
                ${photos.length > 1 ? `
                    <button type="button" class="station-popup__slide-nav station-popup__slide-prev" aria-label="Foto sebelumnya">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <button type="button" class="station-popup__slide-nav station-popup__slide-next" aria-label="Foto selanjutnya">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                    <div class="station-popup__dots">
                        ${dotsHtml}
                    </div>
                    <span class="station-popup__counter">1/${photos.length}</span>
                ` : ''}
            </div>

            <div class="station-popup__context">
                <div class="station-popup__manager">
                    <span class="station-popup__label">PENGELOLA</span>
                    <strong class="station-popup__manager-val">${escapeHtml(managerName)}</strong>
                </div>
                <div class="station-popup__loc">
                    <span class="station-popup__label">LOKASI</span>
                    <p class="station-popup__loc-val">${escapeHtml(locationText)}</p>
                </div>
                <div class="station-popup__meta-row">
                    <div class="station-popup__meta-cell">
                        <span class="station-popup__label">DEVICE ID</span>
                        <strong class="station-popup__meta-text">${escapeHtml(deviceId)}</strong>
                    </div>
                    <div class="station-popup__meta-cell">
                        <span class="station-popup__label">UPDATE</span>
                        <strong class="station-popup__meta-text">${escapeHtml(relativeTime(station.reading_at, now))}</strong>
                    </div>
                    <div class="station-popup__meta-cell">
                        <span class="station-popup__label">INSTALASI</span>
                        <strong class="station-popup__meta-text">${escapeHtml(installDate)}</strong>
                    </div>
                </div>
            </div>

            <div class="station-popup__telemetry-wrap">
                <div class="station-popup__metrics">
                    ${telemetry}
                </div>
            </div>

            <div class="station-popup__action">
                <a href="https://www.google.com/maps/dir/?api=1&destination=${station.latitude},${station.longitude}" target="_blank" rel="noopener noreferrer" class="station-popup__direction-btn">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/>
                    </svg>
                    <span>Arahkan Lokasi</span>
                </a>
            </div>
        </article>`;
};

// Global click delegation for interactive popup carousel navigation
if (typeof document !== 'undefined') {
    document.addEventListener('click', (event) => {
        const prevBtn = event.target.closest('.station-popup__slide-prev');
        const nextBtn = event.target.closest('.station-popup__slide-next');
        const dotBtn = event.target.closest('.station-popup__dot');
        if (!prevBtn && !nextBtn && !dotBtn) return;

        const carousel = (prevBtn || nextBtn || dotBtn).closest('.station-popup__carousel');
        if (!carousel) return;

        const slides = carousel.querySelectorAll('.station-popup__slide');
        const dots = carousel.querySelectorAll('.station-popup__dot');
        const counter = carousel.querySelector('.station-popup__counter');
        if (!slides.length) return;

        let currentIndex = Array.from(slides).findIndex((slide) => !slide.classList.contains('hidden'));
        if (currentIndex === -1) currentIndex = 0;

        let targetIndex = currentIndex;
        if (nextBtn) {
            targetIndex = (currentIndex + 1) % slides.length;
        } else if (prevBtn) {
            targetIndex = (currentIndex - 1 + slides.length) % slides.length;
        } else if (dotBtn) {
            targetIndex = Number(dotBtn.dataset.dotIndex ?? 0);
        }

        slides.forEach((slide, idx) => {
            slide.classList.toggle('hidden', idx !== targetIndex);
        });
        dots.forEach((dot, idx) => {
            dot.classList.toggle('is-active', idx !== targetIndex);
        });
        if (counter) {
            counter.textContent = `${targetIndex + 1}/${slides.length}`;
        }
    });
}
