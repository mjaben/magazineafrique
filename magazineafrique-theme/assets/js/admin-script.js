/**
 * Magazine Afrique — Admin Workspace Client Script
 * Complete ArtCraft UI/UX Engine:
 * - Dynamic SVG Icon Injection (matching workspace cards)
 * - Sidebar Top Brand & Collapse Toggle Button
 * - Menu Segmentation Group Headers
 * - Notification Center Slide-Over Drawer
 * - 1-Click Cache Purge Engine
 *
 * @package MagazineAfrique
 */

(function ($) {
  'use strict';

  // SVG Line Icons matching the ArtCraft cards
  var ICONS = {
    dashboard: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>',
    desk: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path></svg>',
    analytics: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>',
    posts: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>',
    media: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>',
    pages: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
    comments: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>',
    appearance: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path></svg>',
    plugins: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="8" height="8" rx="1"></rect><rect x="14" y="2" width="8" height="8" rx="1"></rect><rect x="2" y="14" width="8" height="8" rx="1"></rect><path d="M14 14h2a2 2 0 0 1 2 2v2"></path><path d="M20 20h-2a2 2 0 0 1-2-2v-2"></path></svg>',
    users: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
    tools: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>',
    settings: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>',
    search: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
    mail: '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>'
  };

  $(document).ready(function () {

    // 1. Initial Folded State Check
    if (localStorage.getItem('magafrique_sidebar_folded') === '1') {
      $('body').addClass('folded');
    }

    // 2. Inject Top Sidebar Brand Row (Clean ArtCraft Style without top collapse clutter)
    if ($('#adminmenuwrap').length > 0 && $('.artcraft-sidebar-header').length === 0) {
      var deskUrl = magafrique_admin_vars ? magafrique_admin_vars.home_url + 'wp-admin/admin.php?page=magazineafrique-desk' : '#';
      var $header = $(
        '<div class="artcraft-sidebar-header">' +
          '<a href="' + deskUrl + '" class="artcraft-sidebar-brand" title="Magazine Afrique Console">' +
            '<div class="artcraft-brand-icon">MA</div>' +
            '<span class="artcraft-sidebar-brand-name">MAGAZINE AFRIQUE</span>' +
          '</a>' +
        '</div>'
      );
      $('#adminmenuwrap').prepend($header);
    }

    // 3. Track Bottom Collapse Button Click State
    $(document).on('click', '#collapse-button', function () {
      setTimeout(function () {
        var isFolded = $('body').hasClass('folded');
        localStorage.setItem('magafrique_sidebar_folded', isFolded ? '1' : '0');
      }, 100);
    });

    // 4. Inject Modern SVG Line Icons into Sidebar (replacing Dashicons)
    function injectModernIcons() {
      var iconMap = {
        '#menu-dashboard': ICONS.dashboard,
        '#toplevel_page_magazineafrique-desk': ICONS.desk,
        '#toplevel_page_magazineafrique-analytics': ICONS.analytics,
        '#menu-posts': ICONS.posts,
        '#menu-media': ICONS.media,
        '#menu-pages': ICONS.pages,
        '#menu-comments': ICONS.comments,
        '#menu-appearance': ICONS.appearance,
        '#menu-plugins': ICONS.plugins,
        '#menu-users': ICONS.users,
        '#menu-tools': ICONS.tools,
        '#menu-settings': ICONS.settings,
        '#toplevel_page_googlesitekit-dashboard': ICONS.analytics,
        '#toplevel_page_wpseo_workouts': ICONS.search,
        '#toplevel_page_wpseo_dashboard': ICONS.search,
        '#toplevel_page_mailchimp-for-wp': ICONS.mail,
        '#toplevel_page_gosmtp': ICONS.mail
      };

      $.each(iconMap, function (selector, svgHtml) {
        var $item = $(selector);
        if ($item.length > 0) {
          var $imgContainer = $item.find('.wp-menu-image');
          if ($imgContainer.length > 0 && $imgContainer.find('svg').length === 0) {
            $imgContainer.empty().html(svgHtml);
          }
        }
      });
    }
    injectModernIcons();

    // 5. Organize Sidebar Hierarchy & Inject Glowing Group Headers
    function organizeSidebarHierarchy() {
      // Move Gazette Desk directly under Dashboard in WORKSPACE
      if ($('#toplevel_page_magazineafrique-desk').length > 0 && $('#menu-dashboard').length > 0) {
        $('#toplevel_page_magazineafrique-desk').insertAfter('#menu-dashboard');
      }

      // Move Site Kit down next to Settings into INTEGRATIONS
      if ($('#toplevel_page_googlesitekit-dashboard').length > 0 && $('#menu-settings').length > 0) {
        $('#toplevel_page_googlesitekit-dashboard').insertAfter('#menu-settings');
      }

      // Inject Menu Segmentation Group Headers with glowing colored dots
      if ($('.artcraft-menu-group-header').length === 0) {
        // Workspace group (Blue dot)
        if ($('#menu-dashboard').length > 0) {
          $('<li class="artcraft-menu-group-header artcraft-group-workspace"><span class="artcraft-group-dot dot-blue"></span>WORKSPACE</li>').insertBefore('#menu-dashboard');
        }
        // Editorial group (Purple dot)
        if ($('#menu-posts').length > 0) {
          $('<li class="artcraft-menu-group-header artcraft-group-editorial"><span class="artcraft-group-dot dot-purple"></span>EDITORIAL</li>').insertBefore('#menu-posts');
        }
        // System & Plugins group (Teal dot)
        if ($('#menu-appearance').length > 0) {
          $('<li class="artcraft-menu-group-header artcraft-group-system"><span class="artcraft-group-dot dot-teal"></span>SYSTEM &amp; PLUGINS</li>').insertBefore('#menu-appearance');
        }
        // Administration group (Savannah Gold dot)
        if ($('#menu-users').length > 0) {
          $('<li class="artcraft-menu-group-header artcraft-group-admin"><span class="artcraft-group-dot dot-gold"></span>ADMINISTRATION</li>').insertBefore('#menu-users');
        }
        // Integrations group (Gold dot)
        var $firstIntegration = $('#toplevel_page_googlesitekit-dashboard, #toplevel_page_wpseo_dashboard, #toplevel_page_wpseo_workouts, #toplevel_page_mailchimp-for-wp, #toplevel_page_gosmtp').first();
        if ($firstIntegration.length > 0) {
          $('<li class="artcraft-menu-group-header artcraft-group-integrations"><span class="artcraft-group-dot dot-gold"></span>INTEGRATIONS</li>').insertBefore($firstIntegration);
        }
      }
    }
    organizeSidebarHierarchy();

    // 6. Modern Card Grid & Table Frame Manager
    // Initialize users grid mode preference before any table wrapping
    if ($('body').hasClass('users-php')) {
      var savedUsersView = localStorage.getItem('magafrique_users_view') || 'grid';
      if (savedUsersView === 'grid') {
        $('body').addClass('magafrique-users-grid-mode');
      }

      var $usersHeader = $('.wrap h1');
      if ($usersHeader.length > 0 && $('.magafrique-view-switcher').length === 0) {
        var $switcher = $(
          '<div class="magafrique-view-switcher" style="display: inline-flex; align-items: center; gap: 4px; margin-left: 1rem; background: rgba(255, 255, 255, 0.06); padding: 3px; border-radius: 4px; border: 1px solid var(--art-border); vertical-align: middle;">' +
            '<button type="button" class="artcraft-view-toggle-btn ' + (savedUsersView === 'grid' ? 'active' : '') + '" data-view="grid" title="Display Users as Cards" style="background: ' + (savedUsersView === 'grid' ? 'rgba(255, 255, 255, 0.15)' : 'transparent') + '; border: none; color: #FAF7F2; font-family: monospace; font-size: 11px; padding: 3px 8px; border-radius: 3px; cursor: pointer;">▦ Cards</button>' +
            '<button type="button" class="artcraft-view-toggle-btn ' + (savedUsersView === 'list' ? 'active' : '') + '" data-view="list" title="Display Users as Table" style="background: ' + (savedUsersView === 'list' ? 'rgba(255, 255, 255, 0.15)' : 'transparent') + '; border: none; color: #FAF7F2; font-family: monospace; font-size: 11px; padding: 3px 8px; border-radius: 3px; cursor: pointer;">☵ Table</button>' +
          '</div>'
        );
        $usersHeader.append($switcher);
      }

      $(document).on('click', '.artcraft-view-toggle-btn', function (e) {
        e.preventDefault();
        var view = $(this).data('view');
        $('.artcraft-view-toggle-btn').css('background', 'transparent').removeClass('active');
        $(this).css('background', 'rgba(255, 255, 255, 0.15)').addClass('active');

        var $userTable = $('.wp-list-table.users');
        if (view === 'grid') {
          $('body').addClass('magafrique-users-grid-mode');
          localStorage.setItem('magafrique_users_view', 'grid');
          if ($userTable.parent().hasClass('artcraft-table-card')) {
            $userTable.parent().find('> .artcraft-reticle').remove();
            $userTable.unwrap();
          }
        } else {
          $('body').removeClass('magafrique-users-grid-mode');
          localStorage.setItem('magafrique_users_view', 'list');
          if (!$userTable.parent().hasClass('artcraft-table-card')) {
            $userTable.wrap('<div class="artcraft-table-card"></div>');
            var $card = $userTable.parent();
            $card.prepend(
              '<span class="artcraft-reticle reticle-tl" aria-hidden="true">+</span>' +
              '<span class="artcraft-reticle reticle-tr" aria-hidden="true">+</span>' +
              '<span class="artcraft-reticle reticle-bl" aria-hidden="true">+</span>' +
              '<span class="artcraft-reticle reticle-br" aria-hidden="true">+</span>'
            );
          }
        }
      });
    }

    // Wrap WordPress List Tables in ArtCraft Technical Frame (Excluding Plugins & Grid Mode Users)
    function wrapTablesWithArtCraftFrame() {
      // Plugins page is always a responsive modern app-store grid; strip any table frame
      if ($('body').hasClass('plugins-php')) {
        $('.wp-list-table.plugins').each(function () {
          var $tbl = $(this);
          if ($tbl.parent().hasClass('artcraft-table-card')) {
            $tbl.parent().find('> .artcraft-reticle').remove();
            $tbl.unwrap();
          }
        });
        return;
      }
      $('.wp-list-table').each(function () {
        var $table = $(this);
        // Skip user table if currently viewed in modern card grid mode
        if ($('body').hasClass('users-php') && $('body').hasClass('magafrique-users-grid-mode') && $table.hasClass('users')) {
          if ($table.parent().hasClass('artcraft-table-card')) {
            $table.parent().find('> .artcraft-reticle').remove();
            $table.unwrap();
          }
          return;
        }
        if (!$table.parent().hasClass('artcraft-table-card')) {
          $table.wrap('<div class="artcraft-table-card"></div>');
          var $card = $table.parent();
          $card.prepend(
            '<span class="artcraft-reticle reticle-tl" aria-hidden="true">+</span>' +
            '<span class="artcraft-reticle reticle-tr" aria-hidden="true">+</span>' +
            '<span class="artcraft-reticle reticle-bl" aria-hidden="true">+</span>' +
            '<span class="artcraft-reticle reticle-br" aria-hidden="true">+</span>'
          );
        }
      });
    }
    wrapTablesWithArtCraftFrame();

    // Attach plugin update notices directly inside parent plugin card in grid view
    if ($('body').hasClass('plugins-php')) {
      $('tr.plugin-update-tr').each(function () {
        var $updateRow = $(this);
        var $prevPlugin = $updateRow.prev('tr');
        if ($prevPlugin.length) {
          var updateHtml = $updateRow.find('.update-message').html();
          if (updateHtml && $prevPlugin.find('.magafrique-plugin-update-notice').length === 0) {
            $prevPlugin.append(
              '<div class="magafrique-plugin-update-notice" style="margin-top: 0.85rem; padding: 0.65rem 0.85rem; background: rgba(217, 119, 6, 0.12); border: 1px solid rgba(217, 119, 6, 0.35); border-radius: 4px; font-size: 11.5px; color: #FBBF24; line-height: 1.4;">' +
                '<strong style="color: #FDE68A; display: inline-block; margin-right: 4px;">Update Available:</strong> ' +
                updateHtml +
              '</div>'
            );
          }
        }
        $updateRow.hide();
      });
    }

    // 7. Notification Center Management (Zero Popups on Canvas)
    var $notices = $('#wpbody-content > .notice, #wpbody-content > .updated, #wpbody-content > .error, #wpbody-content > .update-nag, .wrap > .notice, .wrap > .updated, .wrap > .error, .wrap > .update-nag');
    var noticeCount = $notices.length;

    if (noticeCount > 0) {
      $('#artcraft-notices-count').text(noticeCount);
      $('.artcraft-bar-bell-cluster').addClass('has-alerts');
      $('#artcraft-empty-notices').hide();

      // Move notices into drawer
      $notices.each(function () {
        var $clone = $(this).clone(true);
        $clone.css('display', 'block');
        $('#artcraft-notices-container').append($clone);
        $(this).remove(); // Remove from page canvas completely
      });
    }

    // Toggle Notification Drawer
    $(document).on('click', '#artcraft-notices-pill, .artcraft-notices-bar-item', function (e) {
      e.preventDefault();
      $('#artcraft-notices-drawer').addClass('open');
      $('#artcraft-drawer-backdrop').addClass('open');
    });

    $(document).on('click', '#artcraft-drawer-close, #artcraft-drawer-backdrop', function (e) {
      e.preventDefault();
      $('#artcraft-notices-drawer').removeClass('open');
      $('#artcraft-drawer-backdrop').removeClass('open');
    });

    // 8. Comments Page: Editorial Analytics Header
    if ($('body').hasClass('edit-comments-php')) {
      var allCount = $('.subsubsub .all .count').text().replace(/[()]/g, '') || '0';
      var modCount = $('.subsubsub .moderated .count').text().replace(/[()]/g, '') || '0';
      var appCount = $('.subsubsub .approved .count').text().replace(/[()]/g, '') || '0';
      var spamCount = $('.subsubsub .spam .count').text().replace(/[()]/g, '') || '0';

      if ($('.magafrique-comments-analytics-bar').length === 0) {
        var $analyticsBar = $(
          '<div class="magafrique-comments-analytics-bar artcraft-table-card" style="margin: 1.25rem 0 1.5rem; padding: 1.25rem 1.5rem;">' +
            '<span class="artcraft-reticle reticle-tl">+</span>' +
            '<span class="artcraft-reticle reticle-tr">+</span>' +
            '<span class="artcraft-reticle reticle-bl">+</span>' +
            '<span class="artcraft-reticle reticle-br">+</span>' +
            '<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid var(--art-border); padding-bottom: 0.85rem; margin-bottom: 1rem;">' +
              '<div>' +
                '<span style="font-family: \'Geist Mono\', monospace; font-size: 10px; font-weight: 700; letter-spacing: 0.12em; color: var(--art-text-muted); text-transform: uppercase;">READER DISCOURSE INTELLIGENCE</span>' +
                '<h3 style="margin: 0.2rem 0 0; color: #FFFFFF; font-size: 1.15rem; font-family: \'Archivo\', sans-serif; font-weight: 700;">Comments &amp; Engagement Analytics</h3>' +
              '</div>' +
              '<div style="display: flex; align-items: center; gap: 6px;">' +
                '<span style="width: 7px; height: 7px; border-radius: 50%; background: #10B981; display: inline-block;"></span>' +
                '<span style="font-family: \'Geist Mono\', monospace; font-size: 11px; color: #10B981; font-weight: 600;">ACTIVE MODERATION DISPATCH</span>' +
              '</div>' +
            '</div>' +
            '<div class="artcraft-kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin: 0;">' +
              '<div class="artcraft-kpi-card" style="padding: 0.85rem 1rem;">' +
                '<span class="kpi-label">TOTAL DISPATCHES</span>' +
                '<span class="kpi-val" style="font-size: 1.6rem;">' + allCount + '</span>' +
                '<span class="kpi-meta">All Recorded Commentary</span>' +
              '</div>' +
              '<div class="artcraft-kpi-card" style="padding: 0.85rem 1rem;">' +
                '<span class="kpi-label">APPROVED READERS</span>' +
                '<span class="kpi-val" style="font-size: 1.6rem; color: #34D399;">' + appCount + '</span>' +
                '<span class="kpi-meta">Live on Public Gazette</span>' +
              '</div>' +
              '<div class="artcraft-kpi-card" style="padding: 0.85rem 1rem;">' +
                '<span class="kpi-label">PENDING REVIEW</span>' +
                '<span class="kpi-val" style="font-size: 1.6rem; color: #FBBF24;">' + modCount + '</span>' +
                '<span class="kpi-meta">Awaiting Editorial Stamp</span>' +
              '</div>' +
              '<div class="artcraft-kpi-card" style="padding: 0.85rem 1rem;">' +
                '<span class="kpi-label">SPAM QUARANTINE</span>' +
                '<span class="kpi-val" style="font-size: 1.6rem; color: #F87171;">' + spamCount + '</span>' +
                '<span class="kpi-meta">Neutralized Intrusions</span>' +
              '</div>' +
            '</div>' +
          '</div>'
        );
        $('.wrap .subsubsub').first().after($analyticsBar);
      }
    }

    // 10. Clean Admin Header Text (Remove "Howdy, ")
    var $accountLink = $('#wp-admin-bar-my-account > a.ab-item');
    if ($accountLink.length > 0) {
      var html = $accountLink.html();
      if (html.indexOf('Howdy, ') !== -1) {
        $accountLink.html(html.replace('Howdy, ', ''));
      }
    }

    // 8. 1-Click Cache Purge Functionality (Both in Workspace Card & Admin Bar)
    function executeCachePurge(callback) {
      // Clear Cache API
      if ('caches' in window) {
        caches.keys().then(function (names) {
          names.forEach(function (name) {
            caches.delete(name);
          });
        });
      }

      // Unregister Service Workers
      if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function (registrations) {
          registrations.forEach(function (registration) {
            registration.unregister();
          });
        });
      }

      // Local storage
      localStorage.removeItem('magafrique_posts_cache');
      localStorage.removeItem('magafrique_edition_data');

      setTimeout(function () {
        if (callback) callback();
      }, 700);
    }

    // Workspace card purge
    $('#admin-purge-cache-card').on('click', function (e) {
      e.preventDefault();
      var $spinner = $('#admin-cache-spinner');
      var $status = $('#admin-cache-status-text');

      $spinner.css('animation', 'spin 0.8s linear infinite');
      $status.text('Purging LiteSpeed & browser cache...');

      executeCachePurge(function () {
        $spinner.css('animation', 'none');
        $status.text('✓ Cache purged! Reloading latest edition...');
        setTimeout(function () {
          window.location.reload();
        }, 600);
      });
    });

    // Admin bar purge
    $('#wp-admin-bar-artcraft-admin-bar-purge').on('click', function (e) {
      e.preventDefault();
      var $pill = $(this).find('.artcraft-bar-purge-pill');
      var origText = $pill.html();
      $pill.html('⚡ Purging...');

      executeCachePurge(function () {
        $pill.html('✓ Done!');
        setTimeout(function () {
          window.location.reload();
        }, 500);
      });
    });

  });
})(jQuery);
