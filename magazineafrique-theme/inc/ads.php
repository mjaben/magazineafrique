<?php
/**
 * Magazine Afrique — Strategic Google AdSense Monetization Engine
 * High-Yield, Zero Cumulative Layout Shift (CLS), Subscriber-Suppressed
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

        // 100% Ad-Free reading experience for Club Prestige subscribers
        if (function_exists('magazineafrique_user_has_active_subscription') && magazineafrique_user_has_active_subscription()) {
            return false;
        }

        return true;
    }
}

/**
 * Retrieve AdSense Publisher ID
 */
if (!function_exists('magazineafrique_get_adsense_client_id')) {
    function magazineafrique_get_adsense_client_id() {
        return get_option('magazineafrique_adsense_client_id', 'ca-pub-7175564788277515');
    }
}

/**
 * Render Header Leaderboard Ad Slot
 */
if (!function_exists('magazineafrique_render_ad_leaderboard')) {
    function magazineafrique_render_ad_leaderboard() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        $client_id = magazineafrique_get_adsense_client_id();
        ?>
        <div class="clean-ad-wrapper my-4">
            <span class="clean-ad-label">— Advertisement —</span>
            <div class="clean-ad-slot" style="min-height: 90px;">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="<?php echo esc_attr($client_id); ?>"
                     data-ad-slot="7175564788"
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
 * Render In-Article Middle Ad Slot
 */
if (!function_exists('magazineafrique_render_in_article_ad')) {
    function magazineafrique_render_in_article_ad() {
        if (!magazineafrique_should_display_ads()) {
            return '';
        }
        $client_id = magazineafrique_get_adsense_client_id();
        ob_start();
        ?>
        <div class="clean-ad-wrapper in-article-ad my-6">
            <span class="clean-ad-label">— Editorial Sponsored Dispatch —</span>
            <div class="clean-ad-slot" style="min-height: 280px;">
                <ins class="adsbygoogle"
                     style="display:block; text-align:center;"
                     data-ad-layout="in-article"
                     data-ad-format="fluid"
                     data-ad-client="<?php echo esc_attr($client_id); ?>"
                     data-ad-slot="7175564789"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

/**
 * Auto-inject In-Article Ad after paragraph 3 of single post content
 */
if (!function_exists('magazineafrique_inject_in_article_ad')) {
    function magazineafrique_inject_in_article_ad($content) {
        if (!is_singular('post') || !is_main_query() || !magazineafrique_should_display_ads()) {
            return $content;
        }

        // If post has paywall excerpt only, don't inject ad inside preview
        if (function_exists('magazineafrique_is_premium_post') && magazineafrique_is_premium_post() &&
            (!function_exists('magazineafrique_user_has_active_subscription') || !magazineafrique_user_has_active_subscription())) {
            return $content;
        }

        $paragraphs = explode('</p>', $content);
        if (count($paragraphs) > 4) {
            $injected = '';
            foreach ($paragraphs as $index => $para) {
                $injected .= $para . '</p>';
                if ($index === 2) { // After 3rd paragraph
                    $injected .= magazineafrique_render_in_article_ad();
                }
            }
            return $injected;
        }

        return $content;
    }
    add_filter('the_content', 'magazineafrique_inject_in_article_ad', 20);
}

/**
 * Render Sidebar Ad Slot
 */
if (!function_exists('magazineafrique_render_ad_sidebar')) {
    function magazineafrique_render_ad_sidebar() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        $client_id = magazineafrique_get_adsense_client_id();
        ?>
        <div class="clean-ad-wrapper sidebar-ad my-6">
            <span class="clean-ad-label">— Sponsored Intelligence —</span>
            <div class="clean-ad-slot" style="min-height: 250px;">
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="<?php echo esc_attr($client_id); ?>"
                     data-ad-slot="7175564790"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
        <?php
    }
}
