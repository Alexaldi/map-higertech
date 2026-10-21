const catalog = document.querySelector('[data-product-catalog]');
const filters = catalog.querySelector('[data-product-filters]');
const desktop = window.matchMedia('(min-width: 1024px)');
const summary = filters.querySelector('summary');

function updateFilterLayout() {
    filters.open = desktop.matches;
    summary.tabIndex = desktop.matches ? -1 : 0;
}

summary.addEventListener('click', (event) => {
    if (desktop.matches) event.preventDefault();
});
desktop.addEventListener('change', updateFilterLayout);
updateFilterLayout();

const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
const slideshows = new Map();
let timer = null;

function canPlay(state) {
    return state.visible && !state.paused && !state.hovered && !state.focused && !document.hidden && !motion.matches;
}

function showPhoto(state, step) {
    state.active = (state.active + step + state.images.length) % state.images.length;
    // Keep only one image element per card; additional photos load on demand.
    state.image.loading = 'eager';
    state.image.src = state.images[state.active];
    state.counter.textContent = `${state.active + 1} / ${state.images.length}`;
}

function syncTimer() {
    const shouldPlay = [...slideshows.values()].some(canPlay);
    if (shouldPlay && timer === null) {
        timer = window.setInterval(() => {
            slideshows.forEach((state) => {
                if (canPlay(state)) showPhoto(state, 1);
            });
        }, 4000);
    } else if (!shouldPlay && timer !== null) {
        window.clearInterval(timer);
        timer = null;
    }
}

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        slideshows.get(entry.target).visible = entry.isIntersecting;
    });
    syncTimer();
}, { threshold: 0.1 });

catalog.querySelectorAll('[data-product-card]').forEach((card) => {
    const image = card.querySelector('[data-card-image]');
    const useFallback = () => {
        const fallback = new URL(image.dataset.imageFallback, document.baseURI).href;
        if (image.src !== fallback) image.src = fallback;
    };
    image.addEventListener('error', useFallback);
    if (image.complete && !image.naturalWidth) useFallback();

    const images = JSON.parse(card.dataset.images);
    if (images.length < 2) return;

    const pause = card.querySelector('[data-card-pause]');
    const state = { image, images, pause, counter: card.querySelector('[data-card-counter]'), active: 0, visible: false, paused: false, hovered: false, focused: false };
    slideshows.set(card, state);
    pause.hidden = motion.matches;
    card.querySelector('[data-card-prev]').addEventListener('click', () => showPhoto(state, -1));
    card.querySelector('[data-card-next]').addEventListener('click', () => showPhoto(state, 1));
    pause.addEventListener('click', () => {
        state.paused = !state.paused;
        pause.setAttribute('aria-pressed', String(state.paused));
        pause.setAttribute('aria-label', `${state.paused ? 'Putar' : 'Jeda'} slideshow ${image.alt}`);
        pause.querySelector('[data-pause-icon]').hidden = state.paused;
        pause.querySelector('[data-play-icon]').hidden = !state.paused;
        syncTimer();
    });
    card.addEventListener('pointerenter', (event) => {
        state.hovered = event.pointerType === 'mouse';
        syncTimer();
    });
    card.addEventListener('pointerleave', () => {
        state.hovered = false;
        syncTimer();
    });
    card.addEventListener('focusin', () => {
        state.focused = true;
        syncTimer();
    });
    card.addEventListener('focusout', (event) => {
        state.focused = card.contains(event.relatedTarget);
        syncTimer();
    });
    observer.observe(card);
});

motion.addEventListener('change', () => {
    slideshows.forEach((state) => { state.pause.hidden = motion.matches; });
    syncTimer();
});
document.addEventListener('visibilitychange', syncTimer);
window.addEventListener('pagehide', () => {
    window.clearInterval(timer);
    timer = null;
});
window.addEventListener('pageshow', syncTimer);
