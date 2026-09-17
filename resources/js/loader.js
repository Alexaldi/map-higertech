/**
 * Higertech Loader - Disabled as requested (top progress bar removed completely)
 */
export function startLoader() { }
export function stopLoader() { }
export function initGlobalLoader() {
    window.HigertechLoader = {
        start: startLoader,
        stop: stopLoader,
    };
}


