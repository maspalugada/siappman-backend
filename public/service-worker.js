// Service Worker for SiAPPMan PWA
const CACHE_NAME = 'siappman-v1';
const urlsToCache = [
    '/',
    '/scanner',
    '/css/app.css',
    '/js/app.js',
    '/js/qrcode.min.js',
    '/manifest.json',
    '/icon-192x192.png',
    '/icon-512x512.png'
];

// Install Service Worker
self.addEventListener('install', event => {
    console.log('Service Worker installing.');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Opened cache');
                return cache.addAll(urlsToCache).catch(error => {
                    console.error('Failed to cache some resources:', error);
                    // Continue with installation even if some resources fail to cache
                    return Promise.resolve();
                });
            })
    );
    self.skipWaiting();
});

// Activate Service Worker
self.addEventListener('activate', event => {
    console.log('Service Worker activating.');
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch event - serve from cache if available, otherwise fetch from network
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                // Return cached version or fetch from network
                if (response) {
                    return response;
                }
                return fetch(event.request);
            })
            .catch(() => {
                // Return offline fallback for navigation requests
                if (event.request.mode === 'navigate') {
                    return caches.match('/');
                }
            })
    );
});

// Handle push notifications (optional, for future use)
self.addEventListener('push', event => {
    if (event.data) {
        const data = event.data.json();
        const options = {
            body: data.body,
            icon: '/icon-192x192.png',
            badge: '/icon-192x192.png',
            vibrate: [100, 50, 100],
            data: {
                dateOfArrival: Date.now(),
                primaryKey: 1
            }
        };
        event.waitUntil(
            self.registration.showNotification(data.title, options)
        );
    }
});

// Handle notification click
self.addEventListener('notificationclick', event => {
    console.log('Notification click received.');
    event.notification.close();
    event.waitUntil(
        clients.openWindow('/')
    );
});
