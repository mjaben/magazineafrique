/**
 * Magazine Afrique — PWA Installer, Update Toast & Cache Purge Engine
 * Compatible with Android, iOS (16.4+), and Modern Desktop Browsers
 */

(() => {
  const currentVersion = (window.magazineafrique_vars && window.magazineafrique_vars.version) || '1.0.4';
  const updateToast = document.getElementById('magafrique-update-toast');
  const reloadBtn = document.getElementById('toast-reload-btn');
  const dismissBtn = document.getElementById('toast-dismiss-btn');

  function showUpdateToast() {
    if (updateToast) {
      updateToast.classList.add('visible');
    }
  }

  function hideUpdateToast() {
    if (updateToast) {
      updateToast.classList.remove('visible');
      sessionStorage.setItem('magafrique_update_toast_dismissed', 'true');
    }
  }

  if (dismissBtn) {
    dismissBtn.addEventListener('click', hideUpdateToast);
  }

  // 1. Purge Cache and Reload Action
  window.magazineafriquePurgeCacheAndReload = async () => {
    if (reloadBtn) {
      reloadBtn.disabled = true;
      reloadBtn.innerHTML = 'Updating...';
    }

    // A. Clear all CacheStorage in the browser
    if ('caches' in window) {
      try {
        const cacheKeys = await caches.keys();
        await Promise.all(cacheKeys.map(key => caches.delete(key)));
        console.log('[PWA] Cleared CacheStorage:', cacheKeys);
      } catch (err) {
        console.warn('[PWA] Error deleting CacheStorage:', err);
      }
    }

    // B. Tell Service Worker to purge and skipWaiting
    if ('serviceWorker' in navigator) {
      try {
        const registrations = await navigator.serviceWorker.getRegistrations();
        for (const reg of registrations) {
          if (reg.waiting) {
            reg.waiting.postMessage({ action: 'skipWaiting' });
          }
          if (reg.active) {
            reg.active.postMessage({ action: 'clearCache' });
            reg.active.postMessage({ action: 'skipWaiting' });
          }
          await reg.update().catch(() => {});
        }
      } catch (err) {
        console.warn('[PWA] Error communicating with SW:', err);
      }
    }

    // C. Update stored theme version
    try {
      localStorage.setItem('magafrique_theme_version', currentVersion);
      sessionStorage.clear();
    } catch (e) {}

    // D. Hard reload bypassing browser HTTP cache
    const targetUrl = new URL(window.location.href);
    targetUrl.searchParams.set('reload_v', Date.now());
    window.location.replace(targetUrl.toString());
  };

  if (reloadBtn) {
    reloadBtn.addEventListener('click', window.magazineafriquePurgeCacheAndReload);
  }

  // 2. Service Worker Registration & Live Update Detection
  let swRegistration = null;

  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      // Register with version query to prevent SW script itself from getting stuck in HTTP cache
      navigator.serviceWorker.register('/sw.js?v=' + encodeURIComponent(currentVersion))
        .then((reg) => {
          swRegistration = reg;
          console.log('[PWA] Service Worker registered with scope:', reg.scope);

          // If a worker is already waiting, an update is ready!
          if (reg.waiting) {
            if (!sessionStorage.getItem('magafrique_update_toast_dismissed')) {
              showUpdateToast();
            }
          }

          // Listen for new worker installing
          reg.addEventListener('updatefound', () => {
            const installingWorker = reg.installing;
            if (!installingWorker) return;

            installingWorker.addEventListener('statechange', () => {
              if (installingWorker.state === 'installed' && navigator.serviceWorker.controller) {
                // A new version has been downloaded and installed in the background!
                if (!sessionStorage.getItem('magafrique_update_toast_dismissed')) {
                  showUpdateToast();
                }
              }
            });
          });

          // Check for SW updates periodically & immediately
          reg.update().catch(() => {});
        })
        .catch((err) => {
          console.warn('[PWA] Service Worker registration failed:', err);
        });

      // Avoid infinite reload loops if controller changes
      let refreshing = false;
      navigator.serviceWorker.addEventListener('controllerchange', () => {
        if (!refreshing) {
          refreshing = true;
          window.location.reload();
        }
      });
    });
  }

  // 3. Client Version Handshake (detects updates even before SW checks)
  const storedVersion = localStorage.getItem('magafrique_theme_version');
  if (storedVersion && storedVersion !== currentVersion) {
    // Current server build is newer than previously loaded build
    if (!sessionStorage.getItem('magafrique_update_toast_dismissed')) {
      showUpdateToast();
    }
  } else if (!storedVersion) {
    try {
      localStorage.setItem('magafrique_theme_version', currentVersion);
    } catch (e) {}
  }

  // 4. Android / Desktop Install Prompt
  let deferredPrompt;
  const pwaBanner = document.getElementById('pwa-install-banner');
  const installBtn = document.getElementById('pwa-install-btn');
  const dismissInstallBtn = document.getElementById('pwa-dismiss-btn');

  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    if (!localStorage.getItem('magafrique_pwa_dismissed')) {
      if (pwaBanner) pwaBanner.classList.remove('hidden');
    }
  });

  if (installBtn) {
    installBtn.addEventListener('click', async () => {
      if (!deferredPrompt) return;
      deferredPrompt.prompt();
      const { outcome } = await deferredPrompt.userChoice;
      console.log('[PWA] User response to install prompt:', outcome);
      deferredPrompt = null;
      if (pwaBanner) pwaBanner.classList.add('hidden');
    });
  }

  if (dismissInstallBtn) {
    dismissInstallBtn.addEventListener('click', () => {
      if (pwaBanner) pwaBanner.classList.add('hidden');
      localStorage.setItem('magafrique_pwa_dismissed', 'true');
    });
  }

  // 5. iOS Add to Home Screen Detection
  const isIos = () => {
    const userAgent = window.navigator.userAgent.toLowerCase();
    return /iphone|ipad|ipod/.test(userAgent);
  };

  const isInStandaloneMode = () => {
    return ('standalone' in window.navigator) && (window.navigator.standalone);
  };

  if (isIos() && !isInStandaloneMode() && !localStorage.getItem('magafrique_ios_prompt_dismissed')) {
    const iosPrompt = document.getElementById('pwa-ios-banner');
    if (iosPrompt) {
      iosPrompt.classList.remove('hidden');
      const iosClose = document.getElementById('pwa-ios-close');
      if (iosClose) {
        iosClose.addEventListener('click', () => {
          iosPrompt.classList.add('hidden');
          localStorage.setItem('magafrique_ios_prompt_dismissed', 'true');
        });
      }
    }
  }

  // 6. Push Notification Opt-In Helper
  window.magazineafriqueRequestPush = async () => {
    if (!('Notification' in window)) {
      alert('This browser does not support desktop notifications');
      return;
    }

    if (Notification.permission === 'granted') {
      alert('Push notifications are already active for Magazine Afrique!');
      return;
    }

    if (Notification.permission !== 'denied') {
      const permission = await Notification.requestPermission();
      if (permission === 'granted') {
        alert('✓ Push alerts activated! You will receive breaking Pan-African stories.');
      }
    }
  };
})();
