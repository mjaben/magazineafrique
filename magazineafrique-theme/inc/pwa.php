<?php
/**
 * Magazine Afrique — Progressive Web App (PWA) & Push Notifications Module
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Output PWA Meta Tags in wp_head
 */
if (!function_exists('magazineafrique_pwa_head_tags')) {
    function magazineafrique_pwa_head_tags() {
        $theme_uri = get_theme_file_uri();
        ?>
        <!-- PWA Web App Manifest -->
        <link rel="manifest" href="<?php echo esc_url($theme_uri . '/manifest.json'); ?>">

        <!-- Theme Colors for Android & iOS -->
        <meta name="theme-color" content="#0B5128">
        <meta name="msapplication-navbutton-color" content="#0B5128">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">

        <!-- iOS Specific PWA Tags -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="Magazine Afrique">
        <link rel="apple-touch-icon" href="<?php echo esc_url($theme_uri . '/assets/images/logo.jpg'); ?>">
        <?php
    }
    add_action('wp_head', 'magazineafrique_pwa_head_tags', 2);
}

/**
 * Enqueue PWA Client Script
 */
if (!function_exists('magazineafrique_enqueue_pwa_script')) {
    function magazineafrique_enqueue_pwa_script() {
        wp_enqueue_script(
            'magazineafrique-pwa',
            get_theme_file_uri('/assets/js/pwa.js'),
            array(),
            MAGAZINEAFRIQUE_VERSION,
            true
        );
    }
    add_action('wp_enqueue_scripts', 'magazineafrique_enqueue_pwa_script');
}

/**
 * Render PWA Install Banners in Footer
 */
if (!function_exists('magazineafrique_render_pwa_banners')) {
    function magazineafrique_render_pwa_banners() {
        ?>
        <!-- Android / Chrome PWA Install Prompt (Hidden by default) -->
        <div id="pwa-install-banner" class="pwa-banner-card hidden" style="background: #072714; color: #FFFFFF; border: 1px solid #D97706;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                    <line x1="12" y1="18" x2="12.01" y2="18"></line>
                </svg>
                <div>
                    <div style="font-weight: 800; font-size: 0.875rem; color: #F59E0B;">Install Magazine Afrique</div>
                    <div style="font-size: 0.75rem; color: #D1D5DB;">Fast offline reading & breaking alerts.</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <button id="pwa-install-btn" style="background: #D97706; color: #FFFFFF; border: none; font-size: 0.75rem; font-weight: 800; padding: 0.4rem 0.75rem; border-radius: 0.25rem; cursor: pointer;">
                    Install
                </button>
                <button id="pwa-dismiss-btn" style="background: none; border: none; color: #9CA3AF; font-size: 1rem; cursor: pointer;">
                    ✕
                </button>
            </div>
        </div>

        <!-- iOS Add to Home Screen Banner (Hidden by default) -->
        <div id="pwa-ios-banner" class="pwa-banner-card hidden" style="background: #FAF8F5; color: #1C1917; border: 2px solid #0B5128; flex-direction: column; align-items: stretch; gap: 0.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="font-weight: 800; font-size: 0.875rem; color: #0B5128;">Install on iPhone / iPad</div>
                <button id="pwa-ios-close" style="background: none; border: none; font-size: 1.125rem; cursor: pointer; color: #78716C;">✕</button>
            </div>
            <p style="font-size: 0.75rem; color: #57534E; line-height: 1.5; margin: 0;">
                Tap the <strong>Share</strong> button (<span>⎋</span> or <span>⬆</span>) below and select <strong>"Add to Home Screen"</strong> to receive push alerts and read offline.
            </p>
        </div>

        <!-- New Version / Cache Purge Toast Notification -->
        <div id="magafrique-update-toast" class="magafrique-update-toast" role="alert" aria-live="polite">
            <div class="toast-top-row">
                <div class="toast-pulse-icon"></div>
                <div class="toast-text-wrap">
                    <div class="toast-headline">New Edition Available</div>
                    <div class="toast-subtext">Magazine Afrique has been updated. Reload to view the latest edition.</div>
                </div>
            </div>
            <div class="toast-actions">
                <button id="toast-reload-btn" type="button" class="toast-btn-update">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/>
                    </svg>
                    Reload &amp; Update
                </button>
                <button id="toast-dismiss-btn" type="button" class="toast-btn-close" aria-label="Dismiss">✕</button>
            </div>
        </div>
        <?php
    }
    add_action('wp_footer', 'magazineafrique_render_pwa_banners', 50);
}
