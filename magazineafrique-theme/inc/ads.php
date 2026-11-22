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
 * Determine if ads should be displayed to the current visitor
 */
if (!function_exists('magazineafrique_should_display_ads')) {
    function magazineafrique_should_display_ads() {
        if (is_admin()) {
            return false;
        }

        if (function_exists('magazineafrique_user_has_active_subscription') && magazineafrique_user_has_active_subscription()) {
            return false;
        }

        return true;
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
        ?>
        <div class="editorial-ad-container my-4">
            <span class="ad-label">— Advertisement —</span>
            <div class="ad-slot-box ad-leaderboard">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
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
 * Render Sidebar Rectangle / Half-Page Ad Slot
 */
if (!function_exists('magazineafrique_render_ad_sidebar')) {
    function magazineafrique_render_ad_sidebar() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        ?>
        <div class="editorial-ad-container my-6">
            <span class="ad-label">— Sponsored —</span>
            <div class="ad-slot-box ad-rectangle" style="min-height: 250px;">
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
                     data-ad-slot="2345678901"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
        <?php
    }
}

/**
 * Dynamic In-Article Ad Injection
 */
if (!function_exists('magazineafrique_inject_in_article_ads')) {
    function magazineafrique_inject_in_article_ads($content) {
        if (!is_singular('post') || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        if (!magazineafrique_should_display_ads()) {
            return $content;
        }

        $paragraphs = explode('</p>', $content);
        if (count($paragraphs) < 4) {
            return $content;
        }

        $ad_code = '
        <div class="editorial-ad-container">
            <span class="ad-label">— Advertisement —</span>
            <div class="ad-slot-box ad-rectangle">
                <ins class="adsbygoogle"
                     style="display:block; text-align:center;"
                     data-ad-layout="in-article"
                     data-ad-format="fluid"
                     data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
                     data-ad-slot="3456789012"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>';

        $new_content = '';
        foreach ($paragraphs as $index => $paragraph) {
            if (trim($paragraph)) {
                $new_content .= $paragraph . '</p>';
            }

            if ($index === 2) {
                $new_content .= $ad_code;
            }
        }

        return $new_content;
    }
    add_filter('the_content', 'magazineafrique_inject_in_article_ads', 10);
}
