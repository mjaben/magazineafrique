<?php
/**
 * Magazine Afrique - Cookie Consent & Privacy Compliance Engine
 * 
 * Features:
 * - GDPR & ePrivacy compliant granular cookie preferences (Necessary, Analytics, Marketing)
 * - Neo-brutalist broadsheet banner matching theme design system
 * - Dual storage: LocalStorage + 1-Year Cookie + Server-side DB Audit Logging
 * - AJAX endpoint to persist consent to user profile and aggregated compliance ledger
 * - Re-openable anytime via .open-cookie-settings trigger in footer
 * 
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Check Cookie Consent Helper
 *
 * @param string $category 'necessary', 'analytics', or 'marketing'
 * @return bool
 */
function magazineafrique_has_consent($category = 'necessary') {
    if ($category === 'necessary') {
        return true;
    }

    if (!empty($_COOKIE['magafrique_cookie_consent'])) {
        $raw = stripslashes($_COOKIE['magafrique_cookie_consent']);
        $data = json_decode($raw, true);
        if (is_array($data) && isset($data[$category])) {
            return (bool) $data[$category];
        }
    }

    return false;
}

/**
 * 2. AJAX Endpoint: Store Cookie Consent Server-Side
 */
function magazineafrique_ajax_save_cookie_consent() {
    check_ajax_referer('magazineafrique_cookie_nonce', 'nonce');

    $necessary = true;
    $analytics = !empty($_POST['analytics']) && $_POST['analytics'] === 'true';
    $marketing = !empty($_POST['marketing']) && $_POST['marketing'] === 'true';
    $timestamp = time();

    $consent_payload = array(
        'necessary' => $necessary,
        'analytics' => $analytics,
        'marketing' => $marketing,
        'timestamp' => $timestamp,
        'version'   => '1.0'
    );

    // 1. Set 1-Year Secure Cookie
    $cookie_json = wp_json_encode($consent_payload);
    setcookie(
        'magafrique_cookie_consent',
        $cookie_json,
        $timestamp + (365 * DAY_IN_SECONDS),
        COOKIEPATH,
        COOKIE_DOMAIN,
        is_ssl(),
        false // readable by JS
    );

    // 2. If user is logged in, persist to User Meta
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), 'magafrique_cookie_consent', $consent_payload);
    }

    // 3. Store Aggregated Anonymized Compliance Ledger in Options
    $consent_stats = get_option('magazineafrique_consent_stats', array(
        'total_recorded' => 0,
        'accepted_all'   => 0,
        'essential_only' => 0,
        'custom'         => 0,
        'last_updated'   => 0
    ));

    $consent_stats['total_recorded'] = intval($consent_stats['total_recorded']) + 1;
    if ($analytics && $marketing) {
        $consent_stats['accepted_all'] = intval($consent_stats['accepted_all']) + 1;
    } elseif (!$analytics && !$marketing) {
        $consent_stats['essential_only'] = intval($consent_stats['essential_only']) + 1;
    } else {
        $consent_stats['custom'] = intval($consent_stats['custom']) + 1;
    }
    $consent_stats['last_updated'] = $timestamp;
    update_option('magazineafrique_consent_stats', $consent_stats, false);

    // 4. Anonymized Audit Trail (Keep last 150 entries for legal proof)
    $audit_trail = get_option('magazineafrique_consent_audit_log', array());
    if (!is_array($audit_trail)) {
        $audit_trail = array();
    }
    $ip_hash = md5((!empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1') . wp_salt());
    
    $audit_entry = array(
        'h' => substr($ip_hash, 0, 12),
        't' => $timestamp,
        'a' => $analytics ? 1 : 0,
        'm' => $marketing ? 1 : 0
    );

    array_unshift($audit_trail, $audit_entry);
    if (count($audit_trail) > 150) {
        $audit_trail = array_slice($audit_trail, 0, 150);
    }
    update_option('magazineafrique_consent_audit_log', $audit_trail, false);

    wp_send_json_success(array(
        'message' => 'Consent stored successfully.',
        'consent' => $consent_payload
    ));
}
add_action('wp_ajax_magazineafrique_save_cookie_consent', 'magazineafrique_ajax_save_cookie_consent');
add_action('wp_ajax_nopriv_magazineafrique_save_cookie_consent', 'magazineafrique_ajax_save_cookie_consent');

/**
 * 3. Enqueue Cookie Consent Assets
 */
function magazineafrique_enqueue_cookie_consent_scripts() {
    wp_enqueue_script(
        'magazineafrique-cookie-consent',
        get_template_directory_uri() . '/assets/js/cookie-consent.js',
        array(),
        defined('MAGAZINEAFRIQUE_VERSION') ? MAGAZINEAFRIQUE_VERSION : '1.8.0',
        true
    );

    wp_localize_script('magazineafrique-cookie-consent', 'magafrique_cookie_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('magazineafrique_cookie_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'magazineafrique_enqueue_cookie_consent_scripts');

/**
 * 4. Render Cookie Consent Banner in Footer
 */
function magazineafrique_render_cookie_consent_banner() {
    ?>
    <!-- ==========================================================================
         MAGAZINE AFRIQUE BROADSHEET COOKIE & PRIVACY CONSENT BANNER
         ========================================================================== -->
    <div id="magazineafrique-cookie-banner" class="cookie-banner-wrapper" role="dialog" aria-modal="true" aria-labelledby="cookie-banner-title" style="display: none;">
        <div class="cookie-banner-card">
            
            <!-- Top Header Strip -->
            <div class="cookie-banner-top">
                <div class="cookie-title-wrap">
                    <span class="cookie-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;">
                            <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"/>
                            <path d="M8.5 8.5v.01"/>
                            <path d="M16 15.5v.01"/>
                            <path d="M12 12v.01"/>
                            <path d="M11 17v.01"/>
                            <path d="M7 13v.01"/>
                        </svg>
                        PRIVACY LEDGER
                    </span>
                    <h3 id="cookie-banner-title" class="cookie-heading">Cookie &amp; Reading Preferences</h3>
                </div>
                <button type="button" class="cookie-close-btn" id="cookie-banner-close-btn" aria-label="Close Notice">✕</button>
            </div>

            <!-- Notice Body Copy -->
            <p class="cookie-notice-text">
                Magazine Afrique uses essential cookies and local browser storage to secure your reading session, remember reading preferences, and measure continental readership metrics. Choose your preferences below or accept all for the complete broadsheet experience.
                <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" class="cookie-policy-link">Privacy Policy ↗</a>
            </p>

            <!-- Granular Preferences Panel (Toggled by "Customize Preferences") -->
            <div id="cookie-preferences-panel" class="cookie-preferences-panel" style="display: none;">
                
                <!-- Category 1: Strictly Necessary -->
                <div class="cookie-category-row">
                    <div class="cookie-cat-info">
                        <strong class="cookie-cat-name">1. Strictly Necessary &amp; Security</strong>
                        <p class="cookie-cat-desc">Required for reader authentication, paywall validation, security tokens, and responsive layout memory. Cannot be disabled.</p>
                    </div>
                    <div class="cookie-cat-toggle">
                        <input type="checkbox" id="cookie-opt-necessary" checked disabled class="cookie-checkbox" />
                        <span class="cookie-toggle-badge active">REQUIRED</span>
                    </div>
                </div>

                <!-- Category 2: Performance & Analytics -->
                <div class="cookie-category-row">
                    <div class="cookie-cat-info">
                        <strong class="cookie-cat-name">2. Readership Analytics &amp; Performance</strong>
                        <p class="cookie-cat-desc">Helps our editorial board measure article popularity, reading speed, and regional interest across African hubs.</p>
                    </div>
                    <div class="cookie-cat-toggle">
                        <label class="cookie-switch">
                            <input type="checkbox" id="cookie-opt-analytics" checked class="cookie-checkbox-input" />
                            <span class="cookie-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Category 3: Personalized Advertising -->
                <div class="cookie-category-row">
                    <div class="cookie-cat-info">
                        <strong class="cookie-cat-name">3. Sponsor Announcements &amp; Brand Reach</strong>
                        <p class="cookie-cat-desc">Allows relevant continental business sponsor notices and Brand Reach display campaigns tailored to your industry interests.</p>
                    </div>
                    <div class="cookie-cat-toggle">
                        <label class="cookie-switch">
                            <input type="checkbox" id="cookie-opt-marketing" checked class="cookie-checkbox-input" />
                            <span class="cookie-slider"></span>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Action Buttons Row -->
            <div class="cookie-banner-actions">
                <button type="button" id="cookie-btn-accept-all" class="cookie-action-btn btn-accept-all">
                    Accept All Cookies
                </button>
                <button type="button" id="cookie-btn-essential" class="cookie-action-btn btn-essential">
                    Essential Only
                </button>
                <button type="button" id="cookie-btn-toggle-prefs" class="cookie-action-btn btn-customize">
                    Customize Preferences ⚙
                </button>
                <button type="button" id="cookie-btn-save-prefs" class="cookie-action-btn btn-save-prefs" style="display: none;">
                    Save Choices
                </button>
            </div>

        </div>
    </div>
    <?php
}
add_action('wp_footer', 'magazineafrique_render_cookie_consent_banner', 99);
