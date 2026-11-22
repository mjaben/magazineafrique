/**
 * Magazine Afrique — Unified Reader Engine
 * Multilingual Translation (Google Translate), Smart Bottom Nav Scroll,
 * Non-Black Dark Mode, Live Likes, Live Shares, Bookmarks & Follow Wire
 *
 * @package MagazineAfrique
 */

(function () {
  'use strict';

  // =========================================================================
  // 1. Google Translate API & Multilingual Bridge
  // =========================================================================
  window.magazineafriqueSwitchLanguage = function (targetLang) {
    targetLang = (targetLang || 'en').toLowerCase();

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
    } else {
      // Reload so cookie takes effect
      window.location.reload();
    }
  };

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

  // =========================================================================
  // 2. Smart Bottom Nav Scroll Behavior (Zero Jitter, Smooth Slide)
  // =========================================================================
  function initSmartBottomNavScroll() {
    var nav = document.getElementById('vintage-mobile-nav');
    if (!nav) return;

    var lastScrollY = window.pageYOffset || document.documentElement.scrollTop;
    var ticking = false;
    var scrollThreshold = 14;

    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          var currentScrollY = window.pageYOffset || document.documentElement.scrollTop;
          var maxScroll = document.documentElement.scrollHeight - window.innerHeight;
          var diff = currentScrollY - lastScrollY;

          // Always show at very top (first 80px) or near bottom
          if (currentScrollY <= 80 || currentScrollY >= maxScroll - 40) {
            nav.classList.remove('nav-hidden');
          } else if (diff > scrollThreshold) {
            // Scrolling Down: Hide nav to maximize reading room
            nav.classList.add('nav-hidden');
          } else if (diff < -scrollThreshold) {
            // Scrolling Up: Reveal nav
            nav.classList.remove('nav-hidden');
          }

          lastScrollY = Math.max(0, currentScrollY);
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }

  // =========================================================================
  // 3. Dark Mode Switcher (Calm Warm Kohl - NOT Black)
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
  // 4. Live Likes AJAX Dispatch with Instant Animation
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

      // Optimistic visual count update
      likeCountSpans.forEach(function (span) {
        var count = parseInt(span.textContent.trim(), 10) || 0;
        span.textContent = isLiked ? Math.max(0, count - 1) : count + 1;
      });

      // Toggle state class on all like buttons for this post
      document.querySelectorAll('.btn-live-like[data-post-id="' + postId + '"]').forEach(function (b) {
        b.classList.toggle('has-liked');
        var heart = b.querySelector('.like-heart-icon');
        if (heart) {
          heart.setAttribute('fill', isLiked ? 'none' : 'currentColor');
        }
      });

      // Dispatch AJAX
      var ajaxUrl = (window.magazineafrique_vars && window.magazineafrique_vars.ajax_url) || '/wp-admin/admin-ajax.php';
      var nonce = (window.magazineafrique_vars && window.magazineafrique_vars.nonce) || '';

      var formData = new FormData();
      formData.append('action', 'magazineafrique_toggle_like');
      formData.append('post_id', postId);
      formData.append('nonce', nonce);

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData
      })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (data && data.success && typeof data.data.count !== 'undefined') {
          likeCountSpans.forEach(function (span) {
            span.textContent = data.data.count;
          });
        }
      })
      .catch(function (err) {
        console.warn('Like sync notice:', err);
      });
    });
  }

  // =========================================================================
  // 5. Live Shares Tracking & Link Copying
  // =========================================================================
  function initLiveShares() {
    // 1. Copy link button
    document.addEventListener('click', function (e) {
      var copyBtn = e.target.closest('.share-copy-link');
      if (copyBtn) {
        e.preventDefault();
        var url = copyBtn.getAttribute('data-url') || window.location.href;
        var postId = copyBtn.getAttribute('data-post-id');

        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(url).then(function () {
            showToast('✓ Link copied to clipboard');
          });
        } else {
          showToast('✓ Link copied');
        }

        trackShare(postId);
      }
    });

    // 2. External share buttons (WhatsApp, X, LinkedIn)
    document.addEventListener('click', function (e) {
      var shareBtn = e.target.closest('.share-whatsapp, .share-x, .share-linkedin');
      if (shareBtn) {
        var postId = shareBtn.getAttribute('data-post-id');
        if (postId) {
          trackShare(postId);
        }
      }
    });

    function trackShare(postId) {
      if (!postId) return;
      var counterEl = document.getElementById('share-count-' + postId);
      if (counterEl) {
        var curr = parseInt(counterEl.textContent.trim(), 10) || 0;
        counterEl.textContent = curr + 1;
      }

      var ajaxUrl = (window.magazineafrique_vars && window.magazineafrique_vars.ajax_url) || '/wp-admin/admin-ajax.php';
      var nonce = (window.magazineafrique_vars && window.magazineafrique_vars.nonce) || '';

      var formData = new FormData();
      formData.append('action', 'magazineafrique_track_share');
      formData.append('post_id', postId);
      formData.append('nonce', nonce);

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData
      }).catch(function () {});
    }
  }

  // =========================================================================
  // 6. Bookmarks Dispatch (Posts, Categories, Tags)
  // =========================================================================
  function initBookmarks() {
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.btn-bookmark-action');
      if (!btn) return;
      e.preventDefault();

      var itemId = btn.getAttribute('data-id');
      var itemType = btn.getAttribute('data-type') || 'post';
      if (!itemId) return;

      var isBookmarked = btn.classList.contains('is-bookmarked');
      btn.classList.toggle('is-bookmarked');

      var label = btn.querySelector('.bookmark-label');
      if (label) {
        label.textContent = isBookmarked ? 'Save' : 'Saved';
      }

      showToast(isBookmarked ? 'Removed from reading list' : '✓ Saved to your reading list');

      var ajaxUrl = (window.magazineafrique_vars && window.magazineafrique_vars.ajax_url) || '/wp-admin/admin-ajax.php';
      var nonce = (window.magazineafrique_vars && window.magazineafrique_vars.nonce) || '';

      var formData = new FormData();
      formData.append('action', 'magazineafrique_toggle_bookmark');
      formData.append('item_id', itemId);
      formData.append('item_type', itemType);
      formData.append('nonce', nonce);

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData
      }).catch(function () {});
    });
  }

  // =========================================================================
  // 7. Topic Follow Dispatch (Categories & Tags)
  // =========================================================================
  function initTopicFollows() {
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.btn-follow-cat, .btn-follow-tag');
      if (!btn) return;
      e.preventDefault();

      var termId = btn.getAttribute('data-id');
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

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData
      }).catch(function () {});
    });
  }

  // =========================================================================
  // 8. Elegant Editorial Toast Helper
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
  // DOM Ready Initialization
  // =========================================================================
  document.addEventListener('DOMContentLoaded', function () {
    syncActiveLanguagePill();
    initSmartBottomNavScroll();
    initThemeToggle();
    initLiveLikes();
    initLiveShares();
    initBookmarks();
    initTopicFollows();
  });

})();
