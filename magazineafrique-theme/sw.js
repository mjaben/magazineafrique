/**
 * Magazine Afrique — Service Worker (PWA & Web Push Engine)
 * Compatible with Android & iOS (16.4+)
 */

const CACHE_NAME = 'magazineafrique-v1.1.0';
const STATIC_ASSETS = [
  '/',
  '/wp-content/themes/magazineafrique-theme/assets/css/main.css',
  '/wp-content/themes/magazineafrique-theme/assets/js/main.js',
  '/wp-content/themes/magazineafrique-theme/assets/images/logo.jpg',
  '/wp-content/themes/magazineafrique-theme/manifest.json'
];

// 1. Install & Pre-cache
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(STATIC_ASSETS);
    })
  );
  self.skipWaiting();
});

// 2. Activate & Clean Old Caches immediately
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.map((key) => {
          if (key !== CACHE_NAME) {
            console.log('[SW] Purging outdated cache:', key);
            return caches.delete(key);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

// 3. Message Listener for Instant Cache Clear & SkipWaiting
self.addEventListener('message', (event) => {
  if (!event.data) return;

  if (event.data.action === 'skipWaiting') {
    self.skipWaiting();
  }

  if (event.data.action === 'clearCache') {
    caches.keys().then((keys) => {
      return Promise.all(keys.map(key => caches.delete(key)));
    }).then(() => {
      if (event.ports && event.ports[0]) {
        event.ports[0].postMessage({ success: true });
      }
    });
  }
});

// 4. Fetch Strategy:
// - CSS / JS: Network-First with Cache Fallback (guarantees updates take effect immediately)
// - Static Images / Fonts: Stale-While-Revalidate
// - HTML Pages: Network-First with Offline Cache Fallback
self.addEventListener('fetch', (event) => {
  const req = event.request;

  // Don't intercept WP Admin, POST requests, or Google Ads
  if (req.method !== 'GET' || req.url.includes('/wp-admin/') || req.url.includes('google') || req.url.includes('pagead')) {
    return;
  }

  // CSS & JS: Network-First (ensures style and script revisions update without waiting)
  if (req.url.match(/\.(css|js)(\?.*)?$/)) {
    event.respondWith(
      fetch(req)
        .then((networkResponse) => {
          if (networkResponse && networkResponse.status === 200) {
            const responseClone = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(req, responseClone);
            });
          }
          return networkResponse;
        })
        .catch(() => {
          return caches.match(req);
        })
    );
    return;
  }

  // Images & Fonts: Cache-First with Network Revalidation
  if (req.url.match(/\.(woff2|woff|ttf|jpg|jpeg|png|webp|svg|gif|ico)(\?.*)?$/)) {
    event.respondWith(
      caches.match(req).then((cached) => {
        if (cached) return cached;
        return fetch(req).then((response) => {
          if (response && response.status === 200) {
            const responseClone = response.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(req, responseClone);
            });
          }
          return response;
        });
      })
    );
    return;
  }

  // HTML Pages (Network-First with Offline Cache Fallback)
  event.respondWith(
    fetch(req)
      .then((networkResponse) => {
        return caches.open(CACHE_NAME).then((cache) => {
          cache.put(req, networkResponse.clone());
          return networkResponse;
        });
      })
      .catch(() => {
        return caches.match(req).then((cached) => {
          if (cached) return cached;
          return new Response(
            `<!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Offline — Magazine Afrique</title>
              <style>
                body { font-family: system-ui, sans-serif; background: #FAF8F5; color: #1C1917; text-align: center; padding: 3rem 1.5rem; }
                h1 { color: #0B5128; font-size: 1.75rem; margin-bottom: 0.75rem; }
                p { color: #66615B; font-size: 0.95rem; max-width: 450px; margin: 0 auto 1.5rem; }
                .btn { background: #0B5128; color: white; padding: 0.65rem 1.25rem; border-radius: 0.375rem; text-decoration: none; font-weight: 700; display: inline-block; }
              </style>
            </head>
            <body>
              <h1>📡 Offline Mode</h1>
              <p>You are currently offline or have a spotty connection. Articles you previously loaded remain readable.</p>
              <a href="/" class="btn">Retry Loading Homepage</a>
            </body>
            </html>`,
            { headers: { 'Content-Type': 'text/html; charset=utf-8' } }
          );
        });
      })
  );
});

// 4. Web Push Notifications Listener (Android & iOS 16.4+)
self.addEventListener('push', (event) => {
  let data = {
    title: 'Magazine Afrique Alert',
    body: 'New breaking analysis published on Magazine Afrique.',
    icon: '/wp-content/themes/magazineafrique-theme/assets/images/logo.jpg',
    url: '/'
  };

  if (event.data) {
    try {
      data = Object.assign(data, event.data.json());
    } catch (e) {
      data.body = event.data.text();
    }
  }

  const options = {
    body: data.body,
    icon: data.icon,
    badge: data.icon,
    vibrate: [100, 50, 100],
    data: {
      url: data.url || '/'
    },
    actions: [
      { action: 'read', title: 'Read Story' },
      { action: 'close', title: 'Dismiss' }
    ]
  };

  event.waitUntil(
    self.registration.showNotification(data.title, options)
  );
});

// 5. Notification Click Action
self.addEventListener('notificationclick', (event) => {
  event.notification.close();

  if (event.action === 'close') {
    return;
  }

  const targetUrl = event.notification.data && event.notification.data.url ? event.notification.data.url : '/';

  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
      for (const client of clientList) {
        if (client.url === targetUrl && 'focus' in client) {
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(targetUrl);
      }
    })
  );
});
