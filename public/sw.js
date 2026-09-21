const CACHE_NAME = 'higertech-admin-assets-v1';

// Cuma cache ekstensi file statis — HTML/data routes TIDAK pernah di-cache
const CACHEABLE_EXTENSIONS = /\.(css|js|png|jpg|jpeg|webp|svg|woff2?|ttf|ico)$/;

self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys
                    .filter((key) => key !== CACHE_NAME)
                    .map((key) => caches.delete(key))
            );
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // Cuma tangani GET request
    if (event.request.method !== 'GET') return;

    // Cuma tangani asset statis — halaman, form, API tetap langsung ke network
    if (!CACHEABLE_EXTENSIONS.test(url.pathname)) return;

    event.respondWith(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.match(event.request).then((cached) => {
                if (cached) {
                    // Refresh cache di background (stale-while-revalidate)
                    fetch(event.request)
                        .then((response) => {
                            if (response.ok) cache.put(event.request, response.clone());
                        })
                        .catch(() => {});
                    return cached;
                }

                return fetch(event.request).then((response) => {
                    if (response.ok) cache.put(event.request, response.clone());
                    return response;
                });
            });
        })
    );
});