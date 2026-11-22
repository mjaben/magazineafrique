<?php
/**
 * Magazine Afrique — Google Ads & Publisher Tag (GPT) Monetization Engine
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Determine if ads should be displayed
 */
if (!function_exists('magazineafrique_should_display_ads')) {
    function magazineafrique_should_display_ads() {
        if (is_admin()) {
            return false;
        }

        // Hide ads for paid subscribers
        if (function_exists('magazineafrique_user_has_active_subscription') && magazineafrique_user_has_active_subscription()) {
            return false;
        }

        // Only display if client ID is configured
        $ad_client = get_option('magazineafrique_adsense_client_id', '');
        if (empty($ad_client) || $ad_client === 'ca-pub-XXXXXXXXXXXXXXXX') {
            // Placeholder mode: Return false so empty grey boxes never pollute the clean editorial layout
            return false;
        }

        return true;
    }
}

/**
 * Render Header Leaderboard Ad Slot (Only renders if active ads are configured)
 */
if (!function_exists('magazineafrique_render_ad_leaderboard')) {
    function magazineafrique_render_ad_leaderboard() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        $client_id = get_option('magazineafrique_adsense_client_id');
        ?>
        <div class="clean-ad-wrapper">
            <span class="clean-ad-label">— Advertisement —</span>
            <div class="clean-ad-slot">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="<?php echo esc_attr($client_id); ?>"
                     data-ad-slot="1234567890"
                     data-ad-format="horizontal"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
        <?php
    }
}

/**
 * Render Sidebar Ad Slot
 */
if (!function_exists('magazineafrique_render_ad_sidebar')) {
    function magazineafrique_render_ad_sidebar() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        $client_id = get_option('magazineafrique_adsense_client_id');
        ?>
        <div class="clean-ad-wrapper my-6">
            <span class="clean-ad-label">— Sponsored —</span>
            <div class="clean-ad-slot" style="min-height: 250px;">
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="<?php echo esc_attr($client_id); ?>"
                     data-ad-slot="2345678901"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
        <?php
    }
}
