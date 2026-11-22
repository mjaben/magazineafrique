/**
 * Magazine Afrique — PWA Installer & Push Notification Client
 * Compatible with Android & iOS (16.4+)
 */

(() => {
  // 1. Register Service Worker
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/sw.js')
        .then((reg) => {
          console.log('[PWA] Service Worker registered with scope:', reg.scope);
        })
        .catch((err) => {
          console.warn('[PWA] Service Worker registration failed:', err);
        });
    });
  }

  // 2. Android / Desktop Install Prompt
  let deferredPrompt;
  const pwaBanner = document.getElementById('pwa-install-banner');
  const installBtn = document.getElementById('pwa-install-btn');
  const dismissBtn = document.getElementById('pwa-dismiss-btn');

  window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent the mini-infobar from appearing on mobile
    e.preventDefault();
    deferredPrompt = e;

    // Check if user previously dismissed banner
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

  if (dismissBtn) {
    dismissBtn.addEventListener('click', () => {
      if (pwaBanner) pwaBanner.classList.add('hidden');
      localStorage.setItem('magafrique_pwa_dismissed', 'true');
    });
  }

  // 3. iOS Add to Home Screen Detection
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

  // 4. Push Notification Opt-In Helper
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
