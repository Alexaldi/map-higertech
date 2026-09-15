/**
 * Higertech Telemetry Page Loader
 * High-tech, zero-dependency global progress bar with telemetry radar glow.
 */

let loaderContainer = null;
let loaderBar = null;
let progress = 0;
let progressTimer = null;
let isRunning = false;

function ensureLoaderElements() {
    if (loaderContainer && document.body.contains(loaderContainer)) {
        return;
    }

    loaderContainer = document.createElement('div');
    loaderContainer.id = 'higertech-global-loader';
    loaderContainer.className =
        'fixed top-0 left-0 right-0 h-[3px] z-[9999999] pointer-events-none transition-opacity duration-300 opacity-0';
    loaderContainer.setAttribute('aria-hidden', 'true');

    loaderBar = document.createElement('div');
    loaderBar.className =
        'h-full bg-gradient-to-r from-blue-600 via-cyan-400 to-indigo-500 relative transition-all duration-150 ease-out';
    loaderBar.style.width = '0%';
    loaderBar.style.boxShadow =
        '0 0 12px rgba(6, 182, 212, 0.9), 0 0 4px rgba(37, 99, 235, 0.8)';

    // Telemetry radar ping leading-edge indicator
    const pingDot = document.createElement('div');
    pingDot.className =
        'absolute -right-1 top-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-cyan-300 shadow-[0_0_8px_#22d3ee] animate-pulse';
    loaderBar.appendChild(pingDot);

    loaderContainer.appendChild(loaderBar);
    document.body.appendChild(loaderContainer);
}

export function startLoader() {
    ensureLoaderElements();
    if (!loaderContainer || !loaderBar) return;

    clearInterval(progressTimer);
    isRunning = true;
    progress = 18;
    loaderBar.style.width = '18%';
    loaderContainer.classList.remove('opacity-0');
    loaderContainer.classList.add('opacity-100');

    // Simulate telemetry stream progress
    progressTimer = setInterval(() => {
        if (progress < 60) {
            progress += Math.random() * 12 + 6;
        } else if (progress < 85) {
            progress += Math.random() * 4 + 1.5;
        }
        if (loaderBar) {
            loaderBar.style.width = `${Math.min(progress, 90)}%`;
        }
    }, 120);
}

export function stopLoader() {
    if (!loaderContainer || !loaderBar || !isRunning) return;

    clearInterval(progressTimer);
    loaderBar.style.width = '100%';

    setTimeout(() => {
        if (loaderContainer) {
            loaderContainer.classList.remove('opacity-100');
            loaderContainer.classList.add('opacity-0');
            setTimeout(() => {
                if (loaderBar) {
                    loaderBar.style.width = '0%';
                }
                isRunning = false;
            }, 300);
        }
    }, 160);
}

export function initGlobalLoader() {
    ensureLoaderElements();

    // Start on initial page entry, stop when window completes loading
    startLoader();
    if (document.readyState === 'complete') {
        stopLoader();
    } else {
        window.addEventListener('load', stopLoader, { once: true });
    }

    // Intercept internal link navigations for instant loading feedback
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href');
        if (
            !href ||
            href.startsWith('#') ||
            href.startsWith('javascript:') ||
            href.startsWith('tel:') ||
            href.startsWith('mailto:') ||
            link.hasAttribute('download') ||
            link.getAttribute('target') === '_blank' ||
            e.ctrlKey ||
            e.metaKey ||
            e.shiftKey ||
            e.defaultPrevented
        ) {
            return;
        }

        try {
            const targetUrl = new URL(link.href, window.location.origin);
            if (
                targetUrl.origin === window.location.origin &&
                (targetUrl.pathname !== window.location.pathname ||
                    targetUrl.search !== window.location.search)
            ) {
                startLoader();
            }
        } catch {
            // ignore malformed URLs
        }
    });

    // Also trigger on form submits (e.g. search or filter forms)
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (!form || form.getAttribute('target') === '_blank') return;
        startLoader();
    });

    // Provide global handle
    window.HigertechLoader = {
        start: startLoader,
        stop: stopLoader,
    };
}

