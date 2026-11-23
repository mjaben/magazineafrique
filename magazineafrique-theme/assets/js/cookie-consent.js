/**
 * Magazine Afrique - Cookie Consent & Privacy Preference Controller
 * 
 * Manages user privacy consent, localStorage persistence, 1-year cookies,
 * and AJAX server-side synchronization for audit & GDPR compliance.
 */
(function() {
  'use strict';

  var STORAGE_KEY = 'magafrique_cookie_consent';

  function getStoredConsent() {
    try {
      var item = localStorage.getItem(STORAGE_KEY);
      if (item) {
        return JSON.parse(item);
      }
    } catch (e) {
      // LocalStorage access denied or quota exceeded
    }

    // Fallback: Check document.cookie
    var match = document.cookie.match(new RegExp('(?:^|; )' + STORAGE_KEY + '=([^;]*)'));
    if (match) {
      try {
        return JSON.parse(decodeURIComponent(match[1]));
      } catch (err) {}
    }

    return null;
  }

  function setStoredConsent(consent) {
    consent.timestamp = consent.timestamp || Date.now();
    consent.version = '1.0';

    var jsonStr = JSON.stringify(consent);

    // 1. LocalStorage
    try {
      localStorage.setItem(STORAGE_KEY, jsonStr);
    } catch (e) {}

    // 2. Cookie (1 Year, Path=/, SameSite=Lax)
    var expires = new Date(Date.now() + 365 * 24 * 60 * 60 * 1000).toUTCString();
    document.cookie = STORAGE_KEY + '=' + encodeURIComponent(jsonStr) + '; expires=' + expires + '; path=/; SameSite=Lax';

    // 3. Dispatch Global Custom Event for trackers/GTM/AdSense
    try {
      window.dispatchEvent(new CustomEvent('magafrique:cookie_consent', { detail: consent }));
    } catch (e) {}

    // 4. Server-Side Sync via AJAX
    if (typeof magafrique_cookie_vars !== 'undefined' && magafrique_cookie_vars.ajax_url) {
      var formData = new FormData();
      formData.append('action', 'magazineafrique_save_cookie_consent');
      formData.append('nonce', magafrique_cookie_vars.nonce || '');
      formData.append('necessary', 'true');
      formData.append('analytics', consent.analytics ? 'true' : 'false');
      formData.append('marketing', consent.marketing ? 'true' : 'false');

      if (window.fetch) {
        fetch(magafrique_cookie_vars.ajax_url, {
          method: 'POST',
          body: formData
        }).catch(function() {});
      } else {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', magafrique_cookie_vars.ajax_url, true);
        xhr.send(formData);
      }
    }
  }

  function initCookieConsent() {
    var banner = document.getElementById('magazineafrique-cookie-banner');
    if (!banner) return;

    var panel = document.getElementById('cookie-preferences-panel');
    var btnAcceptAll = document.getElementById('cookie-btn-accept-all');
    var btnEssential = document.getElementById('cookie-btn-essential');
    var btnTogglePrefs = document.getElementById('cookie-btn-toggle-prefs');
    var btnSavePrefs = document.getElementById('cookie-btn-save-prefs');
    var btnClose = document.getElementById('cookie-banner-close-btn');

    var checkAnalytics = document.getElementById('cookie-opt-analytics');
    var checkMarketing = document.getElementById('cookie-opt-marketing');

    var existing = getStoredConsent();

    if (existing) {
      // Set existing toggle states
      if (checkAnalytics) checkAnalytics.checked = !!existing.analytics;
      if (checkMarketing) checkMarketing.checked = !!existing.marketing;

      // Dispatch event for existing visitor
      try {
        window.dispatchEvent(new CustomEvent('magafrique:cookie_consent', { detail: existing }));
      } catch (e) {}
    } else {
      // Delay showing banner slightly to prevent layout shifts
      setTimeout(function() {
        banner.style.display = 'block';
        banner.classList.add('is-visible');
      }, 800);
    }

    function hideBanner() {
      banner.classList.remove('is-visible');
      setTimeout(function() {
        banner.style.display = 'none';
      }, 300);
    }

    // 1. Accept All
    if (btnAcceptAll) {
      btnAcceptAll.addEventListener('click', function() {
        if (checkAnalytics) checkAnalytics.checked = true;
        if (checkMarketing) checkMarketing.checked = true;

        setStoredConsent({
          necessary: true,
          analytics: true,
          marketing: true
        });

        hideBanner();
      });
    }

    // 2. Essential Only
    if (btnEssential) {
      btnEssential.addEventListener('click', function() {
        if (checkAnalytics) checkAnalytics.checked = false;
        if (checkMarketing) checkMarketing.checked = false;

        setStoredConsent({
          necessary: true,
          analytics: false,
          marketing: false
        });

        hideBanner();
      });
    }

    // 3. Toggle Preferences Panel
    if (btnTogglePrefs && panel) {
      btnTogglePrefs.addEventListener('click', function() {
        var isHidden = panel.style.display === 'none' || !panel.style.display;
        if (isHidden) {
          panel.style.display = 'block';
          if (btnSavePrefs) btnSavePrefs.style.display = 'inline-flex';
          btnTogglePrefs.textContent = 'Hide Preferences ▲';
        } else {
          panel.style.display = 'none';
          if (btnSavePrefs) btnSavePrefs.style.display = 'none';
          btnTogglePrefs.textContent = 'Customize Preferences ⚙';
        }
      });
    }

    // 4. Save Custom Preferences
    if (btnSavePrefs) {
      btnSavePrefs.addEventListener('click', function() {
        var isAnalytics = checkAnalytics ? checkAnalytics.checked : false;
        var isMarketing = checkMarketing ? checkMarketing.checked : false;

        setStoredConsent({
          necessary: true,
          analytics: isAnalytics,
          marketing: isMarketing
        });

        hideBanner();
      });
    }

    // 5. Close / Minimize
    if (btnClose) {
      btnClose.addEventListener('click', function() {
        hideBanner();
      });
    }

    // 6. Global Re-Open trigger for footer links
    document.addEventListener('click', function(e) {
      var trigger = e.target.closest('.open-cookie-settings');
      if (trigger) {
        e.preventDefault();
        var current = getStoredConsent();
        if (current) {
          if (checkAnalytics) checkAnalytics.checked = !!current.analytics;
          if (checkMarketing) checkMarketing.checked = !!current.marketing;
        }
        if (panel) {
          panel.style.display = 'block';
          if (btnSavePrefs) btnSavePrefs.style.display = 'inline-flex';
          if (btnTogglePrefs) btnTogglePrefs.textContent = 'Hide Preferences ▲';
        }
        banner.style.display = 'block';
        banner.classList.add('is-visible');
        banner.scrollIntoView({ behavior: 'smooth', block: 'end' });
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCookieConsent);
  } else {
    initCookieConsent();
  }
})();
