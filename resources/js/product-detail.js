const page = document.querySelector('[data-product-detail]');

page.querySelectorAll('[data-image-fallback]').forEach((image) => {
    const useFallback = () => {
        const fallback = new URL(image.dataset.imageFallback, document.baseURI).href;
        if (image.src !== fallback) image.src = fallback;
    };
    image.addEventListener('error', useFallback);
    if (image.complete && !image.naturalWidth) useFallback();
});

const mainImage = page.querySelector('[data-gallery-main]');
const openLink = page.querySelector('[data-gallery-open]');
const dialog = page.querySelector('[data-product-lightbox]');
const enlarged = dialog.querySelector('[data-lightbox-image]');
const download = dialog.querySelector('[data-gallery-download]');
const counter = dialog.querySelector('[data-gallery-counter]');
const thumbnails = [...page.querySelectorAll('[data-gallery-thumb]')];
const images = thumbnails.length ? thumbnails.map((button) => button.querySelector('img').src) : [mainImage.src];
const previous = dialog.querySelector('[data-gallery-prev]');
const next = dialog.querySelector('[data-gallery-next]');
let active = 0;

function selectImage(index) {
    active = Math.max(0, Math.min(images.length - 1, index));
    mainImage.src = enlarged.src = openLink.href = download.href = images[active];
    counter.textContent = `${active + 1} / ${images.length}`;
    thumbnails.forEach((button, i) => button.setAttribute('aria-pressed', String(i === active)));
    if (previous) previous.disabled = active === 0;
    if (next) next.disabled = active === images.length - 1;
}

thumbnails.forEach((button, index) => button.addEventListener('click', () => selectImage(index)));
previous?.addEventListener('click', () => selectImage(active - 1));
next?.addEventListener('click', () => selectImage(active + 1));
openLink.addEventListener('click', (event) => {
    if (!dialog.showModal) return;
    event.preventDefault();
    selectImage(active);
    dialog.showModal();
});
dialog.addEventListener('click', (event) => {
    if (event.target !== dialog) return;
    const bounds = dialog.getBoundingClientRect();
    if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) dialog.close();
});
dialog.addEventListener('keydown', (event) => {
    if (event.key === 'Tab') {
        const controls = [...dialog.querySelectorAll('a[href], button:not([disabled])')];
        const first = controls[0];
        const last = controls.at(-1);
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    }
    if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
        event.preventDefault();
        selectImage(active + (event.key === 'ArrowRight' ? 1 : -1));
    }
});
dialog.addEventListener('close', () => openLink.focus());
selectImage(0);

// Canvas is decorative; stop drawing offscreen and respect reduced motion.
const canvas = page.querySelector('[data-product-network]');
const context = canvas.getContext('2d');
if (context) {
    const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
    let points = [];
    let frame;
    let visible = true;
    let width = 0;
    let height = 0;

    function draw() {
        cancelAnimationFrame(frame);
        context.clearRect(0, 0, width, height);
        points.forEach((point, index) => {
            if (!motion.matches) {
                point.x = (point.x + .18) % width;
                point.y = (point.y + .06) % height;
            }
            context.fillStyle = '#67def980';
            context.beginPath();
            context.arc(point.x, point.y, 1.5, 0, Math.PI * 2);
            context.fill();
            points.slice(index + 1).forEach((other) => {
                const distance = Math.hypot(point.x - other.x, point.y - other.y);
                if (distance > 140) return;
                context.strokeStyle = `rgba(103,222,249,${(1 - distance / 140) * .25})`;
                context.beginPath();
                context.moveTo(point.x, point.y);
                context.lineTo(other.x, other.y);
                context.stroke();
            });
        });
        if (visible && !document.hidden && !motion.matches) frame = requestAnimationFrame(draw);
    }

    new ResizeObserver(() => {
        width = canvas.clientWidth;
        height = canvas.clientHeight;
        if (!width || !height) return;
        const scale = Math.min(window.devicePixelRatio || 1, 2);
        canvas.width = width * scale;
        canvas.height = height * scale;
        context.setTransform(scale, 0, 0, scale, 0, 0);
        points = Array.from({ length: Math.min(80, Math.ceil(width * height / 7000)) }, () => ({ x: Math.random() * width, y: Math.random() * height }));
        draw();
    }).observe(canvas);
    new IntersectionObserver(([entry]) => {
        visible = entry.isIntersecting;
        if (visible) draw();
        else cancelAnimationFrame(frame);
    }).observe(canvas);
    motion.addEventListener('change', draw);
    document.addEventListener('visibilitychange', draw);
}
