import { DEFAULT_VIEW } from './constants.js';

export const bindMapControls = ({ map, clusters, resetButton, fitButton, fullscreenButton }) => {
    const reset = () => map.setView(DEFAULT_VIEW.center, DEFAULT_VIEW.zoom, { animate: true });

    const fit = () => {
        const bounds = clusters.getBounds();
        if (bounds.isValid()) {
            map.fitBounds(bounds.pad(0.12), { animate: true, maxZoom: 12 });
        } else {
            reset();
        }
    };

    const fullscreenTarget = map.getContainer().parentElement;

    const toggleFullscreen = async () => {
        try {
            if (document.fullscreenElement) {
                await document.exitFullscreen();
            } else if (fullscreenTarget?.requestFullscreen) {
                await fullscreenTarget.requestFullscreen();
            }
        } catch {
            fullscreenButton.title = 'Fullscreen tidak tersedia di browser ini';
        }
    };

    const resize = () => window.setTimeout(() => map.invalidateSize(), 80);

    resetButton.addEventListener('click', reset);
    fitButton.addEventListener('click', fit);
    fullscreenButton.addEventListener('click', toggleFullscreen);
    document.addEventListener('fullscreenchange', resize);

    if (!fullscreenTarget?.requestFullscreen) {
        fullscreenButton.hidden = true;
    }

    return { fit, reset, resize };
};
