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
        <!-- Android / Chrome PWA Install Prompt -->
        <div id="pwa-install-banner" class="hidden" style="position: fixed; bottom: 1rem; left: 1rem; right: 1rem; max-width: 480px; margin: 0 auto; z-index: 100; background: #072714; color: #FFFFFF; border: 1px solid #D97706; border-radius: 0.75rem; padding: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="font-size: 1.5rem;">📲</span>
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

        <!-- iOS Add to Home Screen Banner -->
        <div id="pwa-ios-banner" class="hidden" style="position: fixed; bottom: 1rem; left: 1rem; right: 1rem; max-width: 450px; margin: 0 auto; z-index: 100; background: #FAF8F5; color: #1C1917; border: 2px solid #0B5128; border-radius: 0.75rem; padding: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.25);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                <div style="font-weight: 800; font-size: 0.875rem; color: #0B5128;">Install on iPhone / iPad</div>
                <button id="pwa-ios-close" style="background: none; border: none; font-size: 1rem; cursor: pointer;">✕</button>
            </div>
            <p style="font-size: 0.75rem; color: #57534E; line-height: 1.5; margin: 0;">
                Tap the <strong>Share</strong> button (<span>⎋</span> or <span>⬆</span>) below and select <strong>"Add to Home Screen"</strong> to receive push notifications and read offline.
            </p>
        </div>
        <?php
    }
    add_action('wp_footer', 'magazineafrique_render_pwa_banners', 50);
}
