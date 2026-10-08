import { typeMeta } from './constants.js';
import { escapeHtml, formatLocation } from './formatters.js';

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

export const buildPopup = (station = {}) => {
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

    const locationText = formatLocation(station).toUpperCase();
    const typeLabel = (meta.label || station.station_type || 'DUGA AIR').toUpperCase();
    const managerName = station.balai_name || 'Bendungan Ladongi';
    const deviceId = station.device_id || `HGT${station.id || '1097'}`;
    const installDate = station.installation_date || '1 Desember 2025';

    return `
        <article class="station-popup">
            <header class="station-popup__header">
                <span class="station-popup__eyebrow">INFORMASI PERANGKAT</span>
                <h3 class="station-popup__title">${escapeHtml(station.name || 'Pos Monitoring')}</h3>
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

            <div class="station-popup__info-list">
                <div class="station-popup__info-row">
                    <span class="station-popup__info-label">Pengelola</span>
                    <span class="station-popup__info-value station-popup__info-value--manager">${escapeHtml(managerName)}</span>
                </div>
                <div class="station-popup__info-row">
                    <span class="station-popup__info-label">Tipe Perangkat</span>
                    <span class="station-popup__info-value font-bold">${escapeHtml(typeLabel)}</span>
                </div>
                <div class="station-popup__info-row">
                    <span class="station-popup__info-label">Device ID</span>
                    <span class="station-popup__info-value font-mono font-bold">${escapeHtml(deviceId)}</span>
                </div>
                <div class="station-popup__info-row">
                    <span class="station-popup__info-label">Instalasi</span>
                    <span class="station-popup__info-value">${escapeHtml(installDate)}</span>
                </div>
                <div class="station-popup__info-row station-popup__info-row--location">
                    <span class="station-popup__info-label">Lokasi</span>
                    <span class="station-popup__info-value station-popup__info-value--location">${escapeHtml(locationText)}</span>
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
