import { BASEMAPS } from './constants.js';

export const addBasemapGallery = (L, map) => {
    const layers = new Map(BASEMAPS.map((definition) => [
        definition.key,
        L.tileLayer(definition.url, {
            attribution: definition.attribution,
            maxZoom: definition.maxZoom,
            ...(definition.maxNativeZoom ? { maxNativeZoom: definition.maxNativeZoom } : {}),
        }),
    ]));
    let activeKey = BASEMAPS[0].key;
    layers.get(activeKey).addTo(map);

    const control = L.control({ position: 'bottomright' });
    control.onAdd = () => {
        const container = L.DomUtil.create('div', 'leaflet-control basemap-gallery');
        container.id = 'basemap-gallery';
        container.innerHTML = `
            <button class="basemap-gallery__toggle" type="button" aria-label="Pilih tampilan basemap" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m12 3-9 5 9 5 9-5-9-5Z"/><path d="m3 12 9 5 9-5M3 16l9 5 9-5"/></svg>
                <span>Basemap</span>
            </button>
            <div class="basemap-gallery__panel" role="group" aria-label="Pilihan tampilan peta" hidden>
                <div class="basemap-gallery__heading"><strong>Tampilan peta</strong><span>Pilih basemap</span></div>
                <div class="basemap-gallery__grid">
                    ${BASEMAPS.map((definition, index) => `
                        <button class="basemap-option${index === 0 ? ' is-active' : ''}" type="button" data-basemap="${definition.key}" aria-pressed="${index === 0}">
                            <img src="${definition.thumbnail}" alt="" loading="lazy" referrerpolicy="no-referrer">
                            <span><strong>${definition.label}</strong><small>${definition.description}</small></span>
                        </button>`).join('')}
                </div>
            </div>`;

        L.DomEvent.disableClickPropagation(container);
        L.DomEvent.disableScrollPropagation(container);

        const toggle = container.querySelector('.basemap-gallery__toggle');
        const panel = container.querySelector('.basemap-gallery__panel');
        const close = () => {
            panel.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', () => {
            panel.hidden = !panel.hidden;
            toggle.setAttribute('aria-expanded', String(!panel.hidden));
        });
        container.addEventListener('click', (event) => {
            const option = event.target.closest('[data-basemap]');
            if (!option || option.dataset.basemap === activeKey) return;

            map.removeLayer(layers.get(activeKey));
            activeKey = option.dataset.basemap;
            layers.get(activeKey).addTo(map);
            for (const button of container.querySelectorAll('[data-basemap]')) {
                const selected = button.dataset.basemap === activeKey;
                button.classList.toggle('is-active', selected);
                button.setAttribute('aria-pressed', String(selected));
            }
            close();
        });
        container.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') close();
        });
        map.on('click', close);

        return container;
    };
    control.addTo(map);

    return layers;
};
