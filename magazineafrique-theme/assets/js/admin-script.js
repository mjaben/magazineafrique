/**
 * Magazine Afrique — Admin Workspace Client Script
 *
 * @package MagazineAfrique
 */

(function ($) {
  'use strict';

  $(document).ready(function () {
    // 1. Tidy third-party plugin notices into a clean collapsed notice bar
    var $notices = $('.wrap > .notice, .wrap > div.updated, .wrap > div.error').not('.magafrique-notice');
    if ($notices.length > 0 && $('body.index-php').length > 0) {
      var $tray = $('<div class="magafrique-notices-tray" style="margin-bottom: 1.5rem; border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; overflow: hidden;"><button type="button" class="btn-toggle-notices" style="width:100%; text-align:left; background: #181A1F; border:none; padding: 0.6rem 1rem; color: #94A3B8; font-size: 0.75rem; cursor: pointer; display:flex; justify-content:space-between;"><span>🔔 Third-party plugin notices (' + $notices.length + ')</span><span>▼</span></button><div class="notices-drawer" style="display:none; padding: 1rem; background: #131418;"></div></div>');
      $notices.appendTo($tray.find('.notices-drawer'));
      $('.workspace-editorial-container').before($tray);

      $tray.find('.btn-toggle-notices').on('click', function () {
        $tray.find('.notices-drawer').slideToggle(200);
      });
    }

    // 2. 1-Click Cache Purge Card
    $('#admin-purge-cache-card').on('click', function (e) {
      e.preventDefault();
      var $spinner = $('#admin-cache-spinner');
      var $status = $('#admin-cache-status-text');

      $spinner.css('animation', 'spin 0.8s linear infinite');
      $status.text('Purging LiteSpeed & browser cache...');

      // Clear caches
      if ('caches' in window) {
        caches.keys().then(function (names) {
          names.forEach(function (name) {
            caches.delete(name);
          });
        });
      }

      if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function (registrations) {
          registrations.forEach(function (registration) {
            registration.unregister();
          });
        });
      }

      localStorage.removeItem('magafrique_posts_cache');
      localStorage.removeItem('magafrique_edition_data');

      setTimeout(function () {
        $spinner.css('animation', 'none');
        $status.text('✓ Cache purged! Reloading latest edition...');
        setTimeout(function () {
          window.location.reload();
        }, 800);
      }, 1000);
    });

  });
})(jQuery);
