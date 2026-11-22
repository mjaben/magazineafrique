/**
 * Magazine Afrique — Unified Reader Engine
 * Multilingual Translation (Location-Aware + Google Translate),
 * Financial Markets & Crypto Live Ticker (Location-Aware Bourses),
 * Smart Bottom Nav Scroll, Non-Black Dark Mode, Live Likes, Live Shares, Bookmarks & Follow Wire
 *
 * @package MagazineAfrique
 */

(function () {
  'use strict';

  // =========================================================================
  // 1. Google Translate API & Multilingual Bridge (with Geo-Location Detection)
  // =========================================================================
  window.magazineafriqueSwitchLanguage = function (targetLang, isUserAction) {
    targetLang = (targetLang || 'en').toLowerCase();

    if (isUserAction) {
      try {
        localStorage.setItem('magafrique_user_lang_chosen', targetLang);
      } catch (e) {}
    }

    // 1. Set Google Translate Cookies (both with root domain and host)
    var domain = window.location.hostname;
    var hostParts = domain.split('.');
    var rootDomain = '';
    if (hostParts.length >= 2) {
      rootDomain = '.' + hostParts.slice(-2).join('.');
    }

    var cookieVal = '/en/' + targetLang;
    var expires = new Date(Date.now() + 365 * 864e5).toUTCString();

    document.cookie = 'googtrans=' + cookieVal + '; expires=' + expires + '; path=/';
    if (rootDomain) {
      document.cookie = 'googtrans=' + cookieVal + '; expires=' + expires + '; path=/; domain=' + rootDomain;
    }

    // 2. Adjust RTL for Arabic
    if (targetLang === 'ar') {
      document.documentElement.setAttribute('dir', 'rtl');
      document.documentElement.setAttribute('lang', 'ar');
    } else {
      document.documentElement.setAttribute('dir', 'ltr');
      document.documentElement.setAttribute('lang', targetLang);
    }

    // 3. Highlight active buttons
    document.querySelectorAll('.lang-chip, .lang-chip-footer').forEach(function (el) {
      if (el.getAttribute('data-lang') === targetLang || el.textContent.trim().toLowerCase() === targetLang) {
        el.classList.add('active');
      } else {
        el.classList.remove('active');
      }
    });

    // 4. Trigger Google Translate DOM Element
    var select = document.querySelector('.goog-te-combo');
    if (select) {
      select.value = targetLang;
      select.dispatchEvent(new Event('change'));
    } else if (isUserAction) {
      // Reload only on manual user choice if DOM widget isn't ready
      window.location.reload();
    }
  };

  // Automatic Geolocation Language Detection
  function initGeoLanguageDetection() {
    try {
      // Respect reader's explicit previous manual choice
      if (localStorage.getItem('magafrique_user_lang_chosen')) {
        return;
      }
      // If already automatically detected this session, don't loop
      if (sessionStorage.getItem('magafrique_geo_detected')) {
        return;
      }
      sessionStorage.setItem('magafrique_geo_detected', '1');
    } catch (e) {}

    var serverCountry = (window.magazineafrique_vars && window.magazineafrique_vars.geo_country) || '';
    serverCountry = serverCountry.toUpperCase().trim();

    var timezone = '';
    try {
      timezone = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
    } catch (e) {}

    var targetLang = 'en'; // default

    // Linguistic country clusters
    var francophone = ['SN', 'CI', 'CM', 'CD', 'ML', 'BF', 'GN', 'NE', 'BJ', 'TG', 'GA', 'CG', 'TD', 'MG', 'DJ', 'KM', 'SC', 'FR', 'BE', 'CH'];
    var lusophone   = ['AO', 'MZ', 'CV', 'GW', 'ST', 'PT', 'BR'];
    var arabic      = ['EG', 'MA', 'DZ', 'TN', 'LY', 'SD', 'MR', 'SA', 'AE', 'QA', 'KW'];
    var swahili     = ['TZ'];

    if (serverCountry) {
      if (francophone.indexOf(serverCountry) !== -1) targetLang = 'fr';
      else if (lusophone.indexOf(serverCountry) !== -1) targetLang = 'pt';
      else if (arabic.indexOf(serverCountry) !== -1) targetLang = 'ar';
      else if (swahili.indexOf(serverCountry) !== -1) targetLang = 'sw';
    } else if (timezone) {
      var tz = timezone.toLowerCase();
      if (
        tz.indexOf('dakar') !== -1 || tz.indexOf('abidjan') !== -1 || tz.indexOf('douala') !== -1 ||
        tz.indexOf('kinshasa') !== -1 || tz.indexOf('bamako') !== -1 || tz.indexOf('ouagadougou') !== -1 ||
        tz.indexOf('conakry') !== -1 || tz.indexOf('niamey') !== -1 || tz.indexOf('porto-novo') !== -1 ||
        tz.indexOf('lome') !== -1 || tz.indexOf('libreville') !== -1 || tz.indexOf('brazzaville') !== -1 ||
        tz.indexOf('ndjamena') !== -1 || tz.indexOf('casablanca') !== -1 || tz.indexOf('paris') !== -1 ||
        tz.indexOf('brussels') !== -1
      ) {
        targetLang = 'fr';
      } else if (
        tz.indexOf('luanda') !== -1 || tz.indexOf('maputo') !== -1 || tz.indexOf('cape_verde') !== -1 ||
        tz.indexOf('bissau') !== -1 || tz.indexOf('lisbon') !== -1 || tz.indexOf('sao_paulo') !== -1
      ) {
        targetLang = 'pt';
      } else if (
        tz.indexOf('cairo') !== -1 || tz.indexOf('algiers') !== -1 || tz.indexOf('tunis') !== -1 ||
        tz.indexOf('tripoli') !== -1 || tz.indexOf('khartoum') !== -1 || tz.indexOf('riyadh') !== -1 ||
        tz.indexOf('dubai') !== -1
      ) {
        targetLang = 'ar';
      } else if (tz.indexOf('dar_es_salaam') !== -1) {
        targetLang = 'sw';
      }
    }

    // If auto-detected language is not English, switch cleanly!
    if (targetLang && targetLang !== 'en') {
      var match = document.cookie.match(/googtrans=\/en\/([a-z]{2})/);
      var currentCookieLang = match ? match[1] : 'en';

      if (currentCookieLang !== targetLang) {
        window.magazineafriqueSwitchLanguage(targetLang, false);
      }
    }
  }

  // Sync active language pill on load
  function syncActiveLanguagePill() {
    var match = document.cookie.match(/googtrans=\/en\/([a-z]{2})/);
    var current = match ? match[1] : 'en';
    document.querySelectorAll('.lang-chip, .lang-chip-footer').forEach(function (el) {
      if (el.getAttribute('data-lang') === current || el.textContent.trim().toLowerCase() === current) {
        el.classList.add('active');
      } else {
        el.classList.remove('active');
      }
    });
    if (current === 'ar') {
      document.documentElement.setAttribute('dir', 'rtl');
    }
  }

  // Bind click on language chips to pass true for userAction
  document.addEventListener('click', function (e) {
    var chip = e.target.closest('.lang-chip, .lang-chip-footer');
    if (chip) {
      var lang = chip.getAttribute('data-lang');
      if (lang) {
        window.magazineafriqueSwitchLanguage(lang, true);
      }
    }
  });

  // =========================================================================
  // 2. Financial Markets & Crypto Live Ticker (Location-Aware Bourses)
  // =========================================================================
  function initFinancialTicker() {
    var tickerTrack = document.getElementById('ticker-track');
    var bourseNameEl = document.getElementById('ticker-bourse-name');
    if (!tickerTrack) return;

    var serverCountry = (window.magazineafrique_vars && window.magazineafrique_vars.geo_country) || '';
    serverCountry = serverCountry.toUpperCase().trim();

    var timezone = '';
    try {
      timezone = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
    } catch (e) {}

    var tz = timezone.toLowerCase();

    // Determine Market Region & Stocks
    var bourseName = 'PAN-AFRICA BOURSE';
    var localStocks = [];

    if (serverCountry === 'NG' || tz.indexOf('lagos') !== -1) {
      bourseName = 'NGX · LAGOS';
      localStocks = [
        { sym: 'NGX ASI', val: '104,562.05', chg: '▲ +0.42%', up: true },
        { sym: 'DANGCEM', val: '₦680.00', chg: '▲ +1.20%', up: true },
        { sym: 'MTNN', val: '₦225.50', chg: '▼ -0.80%', up: false },
        { sym: 'GTCO', val: '₦48.20', chg: '▲ +0.50%', up: true },
        { sym: 'ZENITHBANK', val: '₦40.50', chg: '▲ +0.75%', up: true },
        { sym: 'BRENT OIL', val: '$74.80', chg: '▲ +1.10%', up: true }
      ];
    } else if (serverCountry === 'ZA' || tz.indexOf('johannesburg') !== -1) {
      bourseName = 'JSE · JOHANNESBURG';
      localStocks = [
        { sym: 'JSE TOP 40', val: '76,140.80', chg: '▲ +0.35%', up: true },
        { sym: 'NPN NASPERS', val: 'R3,740.00', chg: '▲ +1.40%', up: true },
        { sym: 'GFI GOLD FIELDS', val: 'R285.50', chg: '▲ +2.10%', up: true },
        { sym: 'FSR FIRSTRAND', val: 'R78.20', chg: '▲ +0.45%', up: true },
        { sym: 'GOLD', val: '$2,710.40/oz', chg: '▲ +0.65%', up: true }
      ];
    } else if (serverCountry === 'KE' || tz.indexOf('nairobi') !== -1 || serverCountry === 'UG' || serverCountry === 'TZ') {
      bourseName = 'NSE · NAIROBI';
      localStocks = [
        { sym: 'NSE 20', val: '1,842.10', chg: '▲ +0.28%', up: true },
        { sym: 'SAFARICOM', val: 'KSh 15.65', chg: '▲ +0.90%', up: true },
        { sym: 'EQUITY GROUP', val: 'KSh 42.50', chg: '▲ +1.10%', up: true },
        { sym: 'KCB GROUP', val: 'KSh 34.00', chg: '▲ +0.60%', up: true },
        { sym: 'TEA (MOMBASA)', val: '$2.45/kg', chg: '▲ +0.80%', up: true }
      ];
    } else if (['CI', 'SN', 'BF', 'ML', 'BJ', 'TG', 'NE'].indexOf(serverCountry) !== -1 || tz.indexOf('abidjan') !== -1 || tz.indexOf('dakar') !== -1) {
      bourseName = 'BRVM · ABIDJAN';
      localStocks = [
        { sym: 'BRVM COMP', val: '272.40', chg: '▲ +0.31%', up: true },
        { sym: 'SONATEL', val: '19,800 CFA', chg: '▲ +0.80%', up: true },
        { sym: 'SGBCI', val: '18,500 CFA', chg: '▲ +0.50%', up: true },
        { sym: 'ETI ECOBANK', val: '21 CFA', chg: '▲ +1.20%', up: true },
        { sym: 'COCOA (ICCO)', val: '$8,450/t', chg: '▼ -1.40%', up: false }
      ];
    } else if (serverCountry === 'EG' || tz.indexOf('cairo') !== -1 || serverCountry === 'MA' || tz.indexOf('casablanca') !== -1) {
      bourseName = 'EGX &amp; MASI · NORTH AFRICA';
      localStocks = [
        { sym: 'EGX 30', val: '30,550.20', chg: '▲ +0.72%', up: true },
        { sym: 'CIB EGYPT', val: 'EGP 82.40', chg: '▲ +1.10%', up: true },
        { sym: 'MASI CASABLANCA', val: '14,210.50', chg: '▲ +0.45%', up: true },
        { sym: 'BRENT OIL', val: '$74.80', chg: '▲ +1.10%', up: true }
      ];
    } else {
      bourseName = 'GLOBAL &amp; PAN-AFRICA';
      localStocks = [
        { sym: 'S&P 500', val: '5,980.50', chg: '▲ +0.42%', up: true },
        { sym: 'NASDAQ 100', val: '19,120.20', chg: '▲ +0.58%', up: true },
        { sym: 'FTSE 100', val: '8,340.10', chg: '▲ +0.31%', up: true },
        { sym: 'BRENT OIL', val: '$74.80', chg: '▲ +1.10%', up: true },
        { sym: 'GOLD', val: '$2,710.40', chg: '▲ +0.65%', up: true }
      ];
    }

    if (bourseNameEl) {
      bourseNameEl.innerHTML = bourseName;
    }

    // Default Crypto
    var cryptoItems = [
      { sym: 'BTC/USD', val: '$98,420', chg: '▲ +2.4%', up: true, id: 'btc' },
      { sym: 'ETH/USD', val: '$3,380', chg: '▲ +1.8%', up: true, id: 'eth' },
      { sym: 'SOL/USD', val: '$242.10', chg: '▲ +3.1%', up: true, id: 'sol' },
      { sym: 'USDT', val: '$1.00', chg: '▲ +0.01%', up: true, id: 'usdt' }
    ];

    // Build ticker HTML items
    var allItems = cryptoItems.concat(localStocks);
    function renderItemsHtml() {
      return allItems.map(function (item) {
        var chgClass = item.up ? 'ticker-up' : 'ticker-down';
        var valId = item.id ? ' id="ticker-val-' + item.id + '"' : '';
        var chgId = item.id ? ' id="ticker-chg-' + item.id + '"' : '';
        return '<span class="ticker-chip"><span class="ticker-sym">' + item.sym + '</span> <span class="ticker-val"' + valId + '>' + item.val + '</span> <span class="ticker-chg ' + chgClass + '"' + chgId + '>' + item.chg + '</span></span><span class="ticker-chip-sep">/</span>';
      }).join('');
    }

    // Duplicate track content for seamless 100% infinite marquee
    tickerTrack.innerHTML = renderItemsHtml() + renderItemsHtml();

    // Background Live Crypto Update from CoinGecko API (Non-blocking)
    try {
      fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,solana&vs_currencies=usd&include_24hr_change=true')
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (data && data.bitcoin) {
            updateCryptoChip('btc', data.bitcoin.usd, data.bitcoin.usd_24h_change);
          }
          if (data && data.ethereum) {
            updateCryptoChip('eth', data.ethereum.usd, data.ethereum.usd_24h_change);
          }
          if (data && data.solana) {
            updateCryptoChip('sol', data.solana.usd, data.solana.usd_24h_change);
          }
        })
        .catch(function () {});
    } catch (e) {}

    function updateCryptoChip(id, price, change) {
      var valEls = document.querySelectorAll('#ticker-val-' + id);
      var chgEls = document.querySelectorAll('#ticker-chg-' + id);
      var priceStr = '$' + Number(price).toLocaleString('en-US', { maximumFractionDigits: 2 });
      var isUp = change >= 0;
      var chgStr = (isUp ? '▲ +' : '▼ ') + Math.abs(change).toFixed(2) + '%';

      valEls.forEach(function (el) { el.textContent = priceStr; });
      chgEls.forEach(function (el) {
        el.textContent = chgStr;
        el.className = 'ticker-chg ' + (isUp ? 'ticker-up' : 'ticker-down');
      });
    }
  }

  // =========================================================================
  // 3. Sticky Bottom Mobile Nav (Permanently Pinned, Never Disappears)
  // =========================================================================
  function initStickyBottomNav() {
    var nav = document.getElementById('vintage-mobile-nav');
    if (nav) {
      nav.classList.remove('nav-hidden');
    }
  }

  // =========================================================================
  // 4. Dark Mode Switcher (Calm Warm Kohl - NOT Black)
  // =========================================================================
  function initThemeToggle() {
    var toggleBtn = document.getElementById('theme-toggle-btn');
    if (!toggleBtn) return;

    function applyTheme(theme) {
      document.documentElement.setAttribute('data-theme', theme);
      try {
        localStorage.setItem('magafrique_theme_mode', theme);
      } catch (e) {}
    }

    toggleBtn.addEventListener('click', function () {
      var current = document.documentElement.getAttribute('data-theme') || 'light';
      var nextTheme = (current === 'dark') ? 'light' : 'dark';
      applyTheme(nextTheme);
    });
  }

  // =========================================================================
  // 5. Live Likes AJAX Dispatch with Instant Animation
  // =========================================================================
  function initLiveLikes() {
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.btn-live-like');
      if (!btn) return;
      e.preventDefault();

      var postId = btn.getAttribute('data-post-id');
      if (!postId) return;

      var likeCountSpans = document.querySelectorAll('#like-count-' + postId + ', .like-count-sub');
      var isLiked = btn.classList.contains('has-liked');

      likeCountSpans.forEach(function (span) {
        var count = parseInt(span.textContent.trim(), 10) || 0;
        span.textContent = isLiked ? Math.max(0, count - 1) : count + 1;
      });

      document.querySelectorAll('.btn-live-like[data-post-id="' + postId + '"]').forEach(function (b) {
        b.classList.toggle('has-liked');
        var heart = b.querySelector('.like-heart-icon');
        if (heart) {
          heart.setAttribute('fill', isLiked ? 'none' : 'currentColor');
        }
      });

      var ajaxUrl = (window.magazineafrique_vars && window.magazineafrique_vars.ajax_url) || '/wp-admin/admin-ajax.php';
      var nonce = (window.magazineafrique_vars && window.magazineafrique_vars.nonce) || '';

      var formData = new FormData();
      formData.append('action', 'magazineafrique_toggle_like');
      formData.append('post_id', postId);
      formData.append('nonce', nonce);

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData
      }).catch(function () {});
    });
  }

  // =========================================================================
  // 6. Live Shares Engine
  // =========================================================================
  function initLiveShares() {
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.btn-live-share');
      if (!btn) return;
      e.preventDefault();

      var url = btn.getAttribute('data-share-url') || window.location.href;
      var title = btn.getAttribute('data-share-title') || document.title;
      var postId = btn.getAttribute('data-post-id');

      if (navigator.share) {
        navigator.share({ title: title, url: url }).catch(function () {});
      } else {
        if (navigator.clipboard) {
          navigator.clipboard.writeText(url).then(function () {
            showToast('✓ Link copied to clipboard!');
          });
        }
      }

      if (postId) {
        var ajaxUrl = (window.magazineafrique_vars && window.magazineafrique_vars.ajax_url) || '/wp-admin/admin-ajax.php';
        var nonce = (window.magazineafrique_vars && window.magazineafrique_vars.nonce) || '';
        var formData = new FormData();
        formData.append('action', 'magazineafrique_record_share');
        formData.append('post_id', postId);
        formData.append('nonce', nonce);
        fetch(ajaxUrl, { method: 'POST', body: formData }).catch(function () {});
      }
    });
  }

  // =========================================================================
  // 7. Bookmarks Local + Cloud Engine
  // =========================================================================
  function initBookmarks() {
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.btn-bookmark');
      if (!btn) return;
      e.preventDefault();

      var postId = btn.getAttribute('data-post-id');
      if (!postId) return;

      var isBookmarked = btn.classList.contains('is-bookmarked');
      btn.classList.toggle('is-bookmarked');

      showToast(isBookmarked ? 'Article removed from Reading List' : '✓ Saved to your Reading List');

      var ajaxUrl = (window.magazineafrique_vars && window.magazineafrique_vars.ajax_url) || '/wp-admin/admin-ajax.php';
      var nonce = (window.magazineafrique_vars && window.magazineafrique_vars.nonce) || '';
      var formData = new FormData();
      formData.append('action', 'magazineafrique_toggle_bookmark');
      formData.append('post_id', postId);
      formData.append('nonce', nonce);
      fetch(ajaxUrl, { method: 'POST', body: formData }).catch(function () {});
    });
  }

  // =========================================================================
  // 8. Follow Topics / Desks Engine
  // =========================================================================
  function initTopicFollows() {
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.btn-follow-topic');
      if (!btn) return;
      e.preventDefault();

      var termId = btn.getAttribute('data-term-id');
      var type = btn.getAttribute('data-type') || 'category';
      if (!termId) return;

      var isFollowing = btn.classList.contains('is-following');
      btn.classList.toggle('is-following');

      if (type === 'category') {
        btn.textContent = isFollowing ? '+ Follow' : '✓ Following';
      } else {
        btn.textContent = isFollowing ? '+' : '✓';
      }

      showToast(isFollowing ? 'Unfollowed topic' : '✓ Following! News will appear in your Following Wire');

      var ajaxUrl = (window.magazineafrique_vars && window.magazineafrique_vars.ajax_url) || '/wp-admin/admin-ajax.php';
      var nonce = (window.magazineafrique_vars && window.magazineafrique_vars.nonce) || '';

      var formData = new FormData();
      formData.append('action', 'magazineafrique_toggle_follow');
      formData.append('term_id', termId);
      formData.append('type', type);
      formData.append('nonce', nonce);

      fetch(ajaxUrl, { method: 'POST', body: formData }).catch(function () {});
    });
  }

  // =========================================================================
  // 9. Elegant Editorial Toast Helper
  // =========================================================================
  function showToast(message) {
    var existing = document.getElementById('magafrique-toast');
    if (existing) existing.remove();

    var toast = document.createElement('div');
    toast.id = 'magafrique-toast';
    toast.className = 'magafrique-editorial-toast';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(function () {
      toast.classList.add('visible');
    }, 20);

    setTimeout(function () {
      toast.classList.remove('visible');
      setTimeout(function () { toast.remove(); }, 300);
    }, 2800);
  }

  // =========================================================================
  // 10. Strategic WhatsApp Wire Slide-In (14-Day Cooldown, 65% Scroll Trigger)
  // =========================================================================
  function initStrategicWhatsAppWire() {
    var pill = document.getElementById('magafrique-wa-slidein');
    var closeBtn = document.getElementById('magafrique-wa-close-btn');
    var joinBtn = document.getElementById('magafrique-wa-join-btn');
    if (!pill) return;

    var storageKey = 'magafrique_wa_dismissed';
    var joinedKey = 'magafrique_wa_joined';

    // If reader has already joined, never show again
    if (localStorage.getItem(joinedKey) === '1') return;

    // Check 14-day frequency capping if previously dismissed
    var lastDismissed = localStorage.getItem(storageKey);
    if (lastDismissed) {
      var daysElapsed = (Date.now() - parseInt(lastDismissed, 10)) / (1000 * 60 * 60 * 24);
      if (daysElapsed < 14) return;
    }

    var minReadTimeMet = false;
    setTimeout(function () {
      minReadTimeMet = true;
    }, 15000); // Minimum 15 seconds reading time

    var hasShown = false;
    window.addEventListener('scroll', function () {
      if (hasShown || !minReadTimeMet) return;

      var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      var docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      if (docHeight <= 0) return;

      var scrollPercent = (scrollTop / docHeight) * 100;
      if (scrollPercent >= 65) {
        hasShown = true;
        pill.style.display = 'block';
      }
    }, { passive: true });

    if (closeBtn) {
      closeBtn.addEventListener('click', function () {
        pill.style.display = 'none';
        localStorage.setItem(storageKey, Date.now().toString());
      });
    }

    if (joinBtn) {
      joinBtn.addEventListener('click', function () {
        pill.style.display = 'none';
        localStorage.setItem(joinedKey, '1');
      });
    }
  }

  // =========================================================================
  // DOM Ready Initialization
  // =========================================================================
  document.addEventListener('DOMContentLoaded', function () {
    syncActiveLanguagePill();
    initGeoLanguageDetection();
    initFinancialTicker();
    initStickyBottomNav();
    initThemeToggle();
    initLiveLikes();
    initLiveShares();
    initBookmarks();
    initTopicFollows();
    initStrategicWhatsAppWire();
  });

})();
