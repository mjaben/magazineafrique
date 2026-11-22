/**
 * Magazine Afrique — PWA Installer, Push Alerts Engine & Splashscreen
 * - Uses exact site favicon for installation
 * - Push Notification Alert Banner (shows again after 7 days if dismissed)
 * - Floating Bell Button (active when unsubscribed)
 * - Interactive PWA Install Pop-up Guide Modal (iOS Safari & Android Chrome)
 * - High-speed Splashscreen / Preloader Dismissal
 * - Safe Area Mobile Nav & Zero-Overflow Layout
 *
 * @package MagazineAfrique
 */

(() => {
  'use strict';

  const currentVersion = (window.magazineafrique_vars && window.magazineafrique_vars.version) || '1.2.5';
  let deferredPrompt = null;

  // =========================================================================
  // 1. Splashscreen / Preloader Dismissal
  // =========================================================================
  function dismissSplashscreen() {
    const splash = document.getElementById('magafrique-splashscreen');
    if (!splash) return;

    splash.classList.add('fade-out');
    setTimeout(() => {
      splash.style.display = 'none';
    }, 400);
  }

  // Dismiss on window load, with guaranteed 850ms fallback
  window.addEventListener('load', dismissSplashscreen);
  setTimeout(dismissSplashscreen, 850);

  // =========================================================================
  // 2. Service Worker Registration & Cache Handshake
  // =========================================================================
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/sw.js?v=' + encodeURIComponent(currentVersion))
        .then((reg) => {
          if (reg.waiting && !sessionStorage.getItem('magafrique_update_toast_dismissed')) {
            showUpdateToast();
          }

          reg.addEventListener('updatefound', () => {
            const installing = reg.installing;
            if (!installing) return;
            installing.addEventListener('statechange', () => {
              if (installing.state === 'installed' && navigator.serviceWorker.controller) {
                if (!sessionStorage.getItem('magafrique_update_toast_dismissed')) {
                  showUpdateToast();
                }
              }
            });
          });

          reg.update().catch(() => {});
        })
        .catch(() => {});
    });
  }

  // Update Toast Controls
  const updateToast = document.getElementById('magafrique-update-toast');
  const reloadBtn = document.getElementById('toast-reload-btn');
  const dismissToastBtn = document.getElementById('toast-dismiss-btn');

  function showUpdateToast() {
    if (updateToast) updateToast.classList.add('visible');
  }

  if (dismissToastBtn) {
    dismissToastBtn.addEventListener('click', () => {
      if (updateToast) updateToast.classList.remove('visible');
      sessionStorage.setItem('magafrique_update_toast_dismissed', 'true');
    });
  }

  if (reloadBtn) {
    reloadBtn.addEventListener('click', async () => {
      reloadBtn.disabled = true;
      reloadBtn.innerHTML = 'Updating...';

      if ('caches' in window) {
        try {
          const keys = await caches.keys();
          await Promise.all(keys.map(k => caches.delete(k)));
        } catch (e) {}
      }

      if ('serviceWorker' in navigator) {
        try {
          const regs = await navigator.serviceWorker.getRegistrations();
          for (const reg of regs) {
            if (reg.waiting) reg.waiting.postMessage({ action: 'skipWaiting' });
            if (reg.active) reg.active.postMessage({ action: 'clearCache' });
          }
        } catch (e) {}
      }

      const targetUrl = new URL(window.location.href);
      targetUrl.searchParams.set('v_reload', Date.now());
      window.location.replace(targetUrl.toString());
    });
  }

  // =========================================================================
  // 3. Push Notification Engine (7-Day Dismissal Rule + Floating Bell)
  // =========================================================================
  const pushBanner = document.getElementById('magafrique-push-banner');
  const pushAllowBtn = document.getElementById('push-allow-btn');
  const pushDismissBtn = document.getElementById('push-dismiss-btn');
  const floatingBell = document.getElementById('magafrique-floating-bell');

  const SEVEN_DAYS_MS = 7 * 24 * 60 * 60 * 1000;

  function initPushNotificationAlert() {
    if (!('Notification' in window)) {
      return; // Browser doesn't support web notifications
    }

    // If already granted, hide both banner and floating bell
    if (Notification.permission === 'granted') {
      if (floatingBell) floatingBell.classList.add('hidden');
      if (pushBanner) pushBanner.classList.add('hidden');
      return;
    }

    // If permission is not granted, display the floating bell
    if (floatingBell) {
      floatingBell.classList.remove('hidden');
    }

    // Check 7-day dismissal window
    const lastDismissed = localStorage.getItem('magafrique_push_dismissed_time');
    const now = Date.now();

    if (lastDismissed && (now - parseInt(lastDismissed, 10)) < SEVEN_DAYS_MS) {
      // Still within 7-day silent period
      return;
    }

    // Display push alert banner after 2.5s delay
    setTimeout(() => {
      if (pushBanner && Notification.permission !== 'granted') {
        pushBanner.classList.remove('hidden');
      }
    }, 2500);
  }

  // Handle Push Permission Request
  async function requestPushPermission() {
    if (!('Notification' in window)) {
      alert('This device/browser does not support web notifications.');
      return;
    }

    try {
      const permission = await Notification.requestPermission();
      if (permission === 'granted') {
        if (pushBanner) pushBanner.classList.add('hidden');
        if (floatingBell) floatingBell.classList.add('hidden');
        localStorage.removeItem('magafrique_push_dismissed_time');

        // Optional feedback toast
        if (typeof showToast === 'function') {
          showToast('✓ Breaking news alerts activated!');
        } else {
          alert('✓ Breaking news alerts activated! You will receive dispatches on major African developments.');
        }
      } else {
        if (pushBanner) pushBanner.classList.add('hidden');
        localStorage.setItem('magafrique_push_dismissed_time', Date.now().toString());
      }
    } catch (e) {
      if (pushBanner) pushBanner.classList.add('hidden');
    }
  }

  if (pushAllowBtn) {
    pushAllowBtn.addEventListener('click', requestPushPermission);
  }

  if (pushDismissBtn) {
    pushDismissBtn.addEventListener('click', () => {
      if (pushBanner) pushBanner.classList.add('hidden');
      // Record dismissal timestamp for 7-day cooldown
      localStorage.setItem('magafrique_push_dismissed_time', Date.now().toString());
    });
  }

  if (floatingBell) {
    floatingBell.addEventListener('click', () => {
      // Clicking floating bell triggers permission request or opens banner
      if (pushBanner && pushBanner.classList.contains('hidden')) {
        pushBanner.classList.remove('hidden');
      } else {
        requestPushPermission();
      }
    });
  }

  // =========================================================================
  // 4. Interactive PWA Install Pop-up Guide Modal
  // =========================================================================
  const installModal = document.getElementById('magafrique-pwa-install-modal');
  const modalCloseBtn = document.getElementById('pwa-modal-close-btn');
  const nativeInstallBtn = document.getElementById('pwa-native-install-btn');
  const iosGuideSection = document.getElementById('pwa-guide-ios');
  const androidGuideSection = document.getElementById('pwa-guide-android');

  const isIosDevice = () => {
    const ua = window.navigator.userAgent.toLowerCase();
    return /iphone|ipad|ipod/.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
  };

  const isStandaloneApp = () => {
    return ('standalone' in window.navigator && window.navigator.standalone) || window.matchMedia('(display-mode: standalone)').matches;
  };

  // Capture beforeinstallprompt (Android / Chrome / Edge)
  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
  });

  // Open Install Modal Function
  window.magazineafriqueOpenInstallGuide = () => {
    if (!installModal) return;

    if (isIosDevice()) {
      if (iosGuideSection) iosGuideSection.classList.remove('hidden');
      if (androidGuideSection) androidGuideSection.classList.add('hidden');
    } else {
      if (iosGuideSection) iosGuideSection.classList.add('hidden');
      if (androidGuideSection) androidGuideSection.classList.remove('hidden');
    }

    installModal.classList.remove('hidden');
  };

  // Close Install Modal
  if (modalCloseBtn) {
    modalCloseBtn.addEventListener('click', () => {
      if (installModal) installModal.classList.add('hidden');
    });
  }

  if (installModal) {
    installModal.addEventListener('click', (e) => {
      if (e.target === installModal) {
        installModal.classList.add('hidden');
      }
    });
  }

  // Native Install button inside Modal
  if (nativeInstallBtn) {
    nativeInstallBtn.addEventListener('click', async () => {
      if (deferredPrompt) {
        deferredPrompt.prompt();
        const choice = await deferredPrompt.userChoice;
        deferredPrompt = null;
        if (installModal) installModal.classList.add('hidden');
      } else {
        alert('To install, tap the three dots (⋮) in your browser menu and select "Install app" or "Add to Home Screen".');
      }
    });
  }

  // Bind any button with .btn-install-app or #pwa-install-btn to open guide modal
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('.btn-install-app, #pwa-install-btn, .install-app-link');
    if (trigger) {
      e.preventDefault();
      if (deferredPrompt && !isIosDevice()) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then(() => { deferredPrompt = null; });
      } else {
        window.magazineafriqueOpenInstallGuide();
      }
    }
  });

  // =========================================================================
  // DOM Ready
  // =========================================================================
  document.addEventListener('DOMContentLoaded', () => {
    initPushNotificationAlert();
  });

})();
