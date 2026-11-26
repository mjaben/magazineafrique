<?php
/**
 * Magazine Afrique — Progressive Web App (PWA) & Push Notifications Module
 * Complete Engine:
 * - Full PWA & Apple iOS Metadata & Manifest
 * - Push Notification Alert Banner (7-day dismissal memory)
 * - Floating Notification Bell (for unsubscribed readers)
 * - Interactive PWA Install Guide Modal (iOS Safari & Android Chrome)
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Output Rich PWA Meta Tags in wp_head
 */
if (!function_exists('magazineafrique_pwa_head_tags')) {
    function magazineafrique_pwa_head_tags() {
        $theme_uri = get_theme_file_uri();
        ?>
        <!-- PWA Web App Manifest -->
        <link rel="manifest" href="<?php echo esc_url($theme_uri . '/manifest.json'); ?>">

        <!-- Theme Colors for Android, iOS & Desktop -->
        <meta name="theme-color" content="#171513">
        <meta name="msapplication-navbutton-color" content="#171513">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

        <!-- iOS Web App Metadata -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="Magazine Afrique">
        <link rel="apple-touch-icon" href="<?php echo esc_url($theme_uri . '/assets/images/apple-touch-icon.png'); ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url($theme_uri . '/assets/images/apple-touch-icon.png'); ?>">
        <link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url($theme_uri . '/assets/images/icon-192.png'); ?>">
        <link rel="icon" type="image/png" sizes="512x512" href="<?php echo esc_url($theme_uri . '/assets/images/icon-512.png'); ?>">

        <!-- Windows Tile Metadata -->
        <meta name="msapplication-TileImage" content="<?php echo esc_url($theme_uri . '/assets/images/icon-512.png'); ?>">
        <meta name="msapplication-TileColor" content="#171513">
        <?php
    }
    add_action('wp_head', 'magazineafrique_pwa_head_tags', 2);
}

/**
 * 2. Enqueue PWA Client Script
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
 * 3. Render PWA Install Modals, Push Banners & Floating Bell in Footer
 */
if (!function_exists('magazineafrique_render_pwa_banners')) {
    function magazineafrique_render_pwa_banners() {
        $theme_uri = get_theme_file_uri();
        ?>
        <!-- 1. Floating Notification Bell (Visible if not subscribed) -->
        <button id="magafrique-floating-bell" class="magafrique-floating-bell hidden" aria-label="Enable Breaking News Alerts" title="Enable Breaking News Alerts">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="bell-ping"></span>
        </button>

        <!-- 2. Push Notification Alert Banner (With 7-Day Dismissal Memory) -->
        <div id="magafrique-push-banner" class="magafrique-push-banner hidden" role="dialog" aria-modal="true">
            <div class="push-banner-inner">
                <div class="push-banner-icon-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FAF7F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </div>
                <div class="push-banner-text">
                    <h4 class="push-banner-title">Turn on Breaking News Alerts</h4>
                    <p class="push-banner-desc">Get instant dispatches on major African geopolitical and economic developments.</p>
                </div>
                <div class="push-banner-actions">
                    <button type="button" id="push-allow-btn" class="push-btn-allow">Enable Alerts</button>
                    <button type="button" id="push-dismiss-btn" class="push-btn-dismiss">Later</button>
                </div>
            </div>
        </div>

        <!-- 3. Interactive PWA Install Guide Modal (Pop-up on Install App click) -->
        <div id="magafrique-pwa-install-modal" class="magafrique-pwa-modal-overlay hidden" role="dialog" aria-modal="true">
            <div class="magafrique-pwa-modal-card">
                
                <!-- Modal Header -->
                <div class="modal-card-header">
                    <div class="modal-brand-cluster">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/icon-192.png'); ?>" alt="Magazine Afrique" width="40" height="40" class="modal-app-icon" />
                        <div>
                            <span class="modal-eyebrow">OFFICIAL PROGRESSIVE WEB APP</span>
                            <h3 class="modal-title">Install Magazine Afrique</h3>
                        </div>
                    </div>
                    <button type="button" id="pwa-modal-close-btn" class="modal-close-btn" aria-label="Close">✕</button>
                </div>

                <!-- Modal Content -->
                <div class="modal-card-body">
                    
                    <!-- Dynamic View for iOS Safari -->
                    <div id="pwa-guide-ios" class="pwa-guide-section hidden">
                        <p class="guide-lead-text">Install Magazine Afrique on your iPhone or iPad for fullscreen offline reading and breaking alerts:</p>
                        <ol class="ios-install-steps">
                            <li>
                                <span class="step-num">1</span>
                                <span class="step-desc">Tap the <strong>Share button</strong> <span class="ios-share-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg></span> in Safari toolbar below.</span>
                            </li>
                            <li>
                                <span class="step-num">2</span>
                                <span class="step-desc">Scroll down and tap <strong>"Add to Home Screen"</strong> <span class="ios-plus-badge">⊞</span>.</span>
                            </li>
                            <li>
                                <span class="step-num">3</span>
                                <span class="step-desc">Tap <strong>"Add"</strong> in the top-right corner to finish.</span>
                            </li>
                        </ol>
                    </div>

                    <!-- Dynamic View for Android / Chrome / Edge -->
                    <div id="pwa-guide-android" class="pwa-guide-section">
                        <p class="guide-lead-text">Install our high-speed editorial app directly to your home screen or desktop with zero app store download:</p>
                        <ul class="pwa-benefits-list">
                            <li>✓ Instant loading with offline archival access</li>
                            <li>✓ Push alerts on breaking Pan-African dispatches</li>
                            <li>✓ Fast, zero-clutter reading experience</li>
                        </ul>
                        <div class="modal-install-btn-row">
                            <button type="button" id="pwa-native-install-btn" class="btn-pwa-install-action">
                                📥 Install App Now
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-card-footer">
                    <span class="modal-footer-note">Free · No Storage Bloat · High Speed</span>
                </div>

            </div>
        </div>

        <!-- 3b. First-Time Viewer Welcome Modal (Install PWA + Turn On Location)
             Shows for first-time / cleared-cache viewers; 7-day dismiss cooldown; never inside installed PWA -->
        <div id="magafrique-welcome-modal" class="magafrique-welcome-overlay hidden" role="dialog" aria-modal="true" aria-labelledby="welcome-modal-heading">
            <div class="magafrique-welcome-card">
                <div class="welcome-card-header">
                    <div class="welcome-brand-cluster">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/icon-192.png'); ?>" alt="Magazine Afrique" width="40" height="40" class="welcome-app-icon" />
                        <div>
                            <span class="welcome-eyebrow">WELCOME TO MAGAZINE AFRIQUE</span>
                            <h3 id="welcome-modal-heading" class="welcome-title">Personalize Your Edition</h3>
                        </div>
                    </div>
                    <button type="button" id="welcome-close-btn" class="welcome-close-btn" aria-label="Dismiss welcome prompt">✕</button>
                </div>

                <div class="welcome-card-body">
                    <p class="welcome-intro-text">
                        Get faster offline reading and regional market dispatches tailored to your desk in two quick steps.
                    </p>

                    <div class="welcome-action-stack">
                        <!-- Action 1: Install PWA App -->
                        <div class="welcome-action-item" id="welcome-pwa-row">
                            <div class="welcome-action-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                                    <line x1="12" y1="18" x2="12.01" y2="18"/>
                                </svg>
                            </div>
                            <div class="welcome-action-copy">
                                <strong class="welcome-action-title">Install the Magazine Afrique App</strong>
                                <span class="welcome-action-desc">Instant home-screen access with offline reading.</span>
                                <div id="welcome-pwa-inline-tip" class="welcome-inline-tip hidden" aria-live="polite"></div>
                            </div>
                            <button type="button" id="welcome-install-pwa-btn" class="welcome-action-btn welcome-btn-primary">
                                Install App
                            </button>
                        </div>

                        <!-- Action 2: Turn On Location -->
                        <div class="welcome-action-item" id="welcome-location-row">
                            <div class="welcome-action-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div class="welcome-action-copy">
                                <strong class="welcome-action-title">Turn On Location</strong>
                                <span class="welcome-action-desc">Unlock regional bourses, local editions, and bureau alerts.</span>
                                <div id="welcome-location-status" class="welcome-inline-tip hidden" aria-live="polite"></div>
                            </div>
                            <button type="button" id="welcome-enable-location-btn" class="welcome-action-btn welcome-btn-secondary">
                                Enable
                            </button>
                        </div>
                    </div>
                </div>

                <div class="welcome-card-footer">
                    <span class="welcome-cooldown-note">You can dismiss and revisit this in 7 days.</span>
                    <button type="button" id="welcome-dismiss-btn" class="welcome-dismiss-link">
                        Continue to Edition →
                    </button>
                </div>
            </div>
        </div>

        <!-- 4. New Version / Cache Purge Toast Notification -->
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
