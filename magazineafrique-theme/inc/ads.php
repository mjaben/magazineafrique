<?php
/**
 * Magazine Afrique — Strategic Google AdSense Monetization Engine
 * Client ID: ca-pub-7175564788277515
 * 
 * Ad Inventory:
 * 1. Header Leaderboard: Slot 4687046934 (Responsive)
 * 2. In-Article Ad 1:   Slot 9866978622 (Different sizes per screen: Mobile 300x250, Tablet 336x280 / 728x90, Desktop 728x90)
 * 3. In-Article Ad 2:   Slot 3777306824 (Fluid Native In-Article format, rotated and mixed with Ad 1)
 * 4. Sidebar Ad:        Slot 1854558906 (300x250 / 300x600)
 * 5. Bottom Ad:         Slot 1801863291 (Horizontal / Responsive above footer & article end)
 *
 * Fully subscriber-suppressed (100% Ad-Free for Club Prestige members).
 * Zero Cumulative Layout Shift (CLS) architecture.
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
 * Enqueue Google AdSense Asynchronous Script in Head
 */
if (!function_exists('magazineafrique_enqueue_adsense_script')) {
    function magazineafrique_enqueue_adsense_script() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        ?>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7175564788277515" crossorigin="anonymous"></script>
        <style>
            /* Responsive Sizing for Article Ad 1 (Slot 9866978622) */
            .magafrique-article-ad-slot-1 {
                display: block;
                margin: 0 auto;
                width: 300px;
                height: 250px; /* Default: Mobile screen */
            }
            @media (min-width: 500px) and (max-width: 767px) {
                .magafrique-article-ad-slot-1 {
                    width: 336px;
                    height: 280px; /* Phablet / Large Mobile */
                }
            }
            @media (min-width: 768px) and (max-width: 1023px) {
                .magafrique-article-ad-slot-1 {
                    width: 728px;
                    height: 90px; /* Tablet Leaderboard */
                }
            }
            @media (min-width: 1024px) {
                .magafrique-article-ad-slot-1 {
                    width: 728px;
                    height: 90px; /* Desktop Leaderboard */
                }
            }

            /* Container styling */
            .vintage-ad-container {
                margin: 1.5rem auto;
                text-align: center;
                clear: both;
            }
            .vintage-ad-label {
                font-family: 'JetBrains Mono', monospace;
                font-size: 0.625rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--text-muted, #857D73);
                margin-bottom: 0.35rem;
            }
            .vintage-ad-box {
                background: var(--bg-card-subtle, #EFE9DE);
                border: 1px dashed var(--border-color, #4A433B);
                padding: 0.5rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                overflow: hidden;
            }
            [data-theme="dark"] .vintage-ad-box {
                background: #24211E;
                border-color: #3D3730;
            }
        </style>
        <?php
    }
    add_action('wp_head', 'magazineafrique_enqueue_adsense_script', 5);
}

/**
 * 1. Render Header Ad Slot (Slot: 4687046934)
 */
if (!function_exists('magazineafrique_render_ad_header')) {
    function magazineafrique_render_ad_header() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        ?>
        <div class="vintage-ad-container header-ad-zone container-editorial">
            <div class="vintage-ad-label">— SPONSORED DISPATCH —</div>
            <div class="vintage-ad-box" style="min-height: 90px; max-width: 970px;">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-7175564788277515"
                     data-ad-slot="4687046934"
                     data-ad-format="auto"
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
 * 2. Render In-Article Ad Slot 1 (Slot: 9866978622 - Different sizes per screen)
 */
if (!function_exists('magazineafrique_render_article_ad_1')) {
    function magazineafrique_render_article_ad_1() {
        if (!magazineafrique_should_display_ads()) {
            return '';
        }
        ob_start();
        ?>
        <div class="vintage-ad-container in-article-ad-1 my-6">
            <div class="vintage-ad-label">— EDITORIAL SPONSORED BRIEF —</div>
            <div class="vintage-ad-box" style="min-height: 100px;">
                <ins class="adsbygoogle magafrique-article-ad-slot-1"
                     data-ad-client="ca-pub-7175564788277515"
                     data-ad-slot="9866978622"></ins>
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
 * 3. Render In-Article Ad Slot 2 (Slot: 3777306824 - Fluid Native In-Article)
 */
if (!function_exists('magazineafrique_render_article_ad_2')) {
    function magazineafrique_render_article_ad_2() {
        if (!magazineafrique_should_display_ads()) {
            return '';
        }
        ob_start();
        ?>
        <div class="vintage-ad-container in-article-ad-2 my-6">
            <div class="vintage-ad-label">— CONTINENTAL INTELLIGENCE PARTNER —</div>
            <div class="vintage-ad-box" style="min-height: 120px; width: 100%; max-width: 728px;">
                <ins class="adsbygoogle"
                     style="display:block; text-align:center;"
                     data-ad-layout="in-article"
                     data-ad-format="fluid"
                     data-ad-client="ca-pub-7175564788277515"
                     data-ad-slot="3777306824"></ins>
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
 * 4. Render Sidebar Ad Slot (Slot: 1854558906)
 */
if (!function_exists('magazineafrique_render_ad_sidebar')) {
    function magazineafrique_render_ad_sidebar() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        ?>
        <div class="vintage-ad-container sidebar-ad-zone">
            <div class="vintage-ad-label">— COMMERCIAL DISPATCH —</div>
            <div class="vintage-ad-box" style="min-height: 250px; width: 300px; margin: 0 auto;">
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="ca-pub-7175564788277515"
                     data-ad-slot="1854558906"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
        <?php
    }
}

/**
 * 5. Render Bottom Ad Slot (Slot: 1801863291 - Above Footer / Bottom of Page)
 */
if (!function_exists('magazineafrique_render_ad_bottom')) {
    function magazineafrique_render_ad_bottom() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        ?>
        <div class="vintage-ad-container bottom-ad-zone container-editorial" style="margin-top: 2rem; margin-bottom: 2rem;">
            <div class="vintage-ad-label">— SPONSORED DOSSIER &amp; ALLIANCE —</div>
            <div class="vintage-ad-box" style="min-height: 90px; max-width: 970px;">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-7175564788277515"
                     data-ad-slot="1801863291"
                     data-ad-format="auto"
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
 * Auto-inject and Mix In-Article Ads into single post content
 * Logic:
 * - In long articles (> 6 paragraphs): Injects Ad 1 (responsive 9866978622) after paragraph 3,
 *   and Ad 2 (fluid 3777306824) after paragraph 6.
 * - In shorter articles (4-6 paragraphs): Switches/alternates between Ad 1 and Ad 2 based on post ID!
 */
if (!function_exists('magazineafrique_inject_in_article_ads')) {
    function magazineafrique_inject_in_article_ads($content) {
        if (!is_singular('post') || !is_main_query() || !magazineafrique_should_display_ads()) {
            return $content;
        }

        // If post has paywall excerpt only, don't inject inside preview
        if (function_exists('magazineafrique_is_premium_post') && magazineafrique_is_premium_post() &&
            (!function_exists('magazineafrique_user_has_active_subscription') || !magazineafrique_user_has_active_subscription())) {
            return $content;
        }

        $paragraphs = explode('</p>', $content);
        $total_paras = count($paragraphs);

        if ($total_paras < 4) {
            return $content;
        }

        $post_id = get_the_ID();
        // If post ID is even, start with Ad 1; if odd, start with Ad 2 for dynamic alternation
        $ad_slot_first = ($post_id % 2 === 0) ? magazineafrique_render_article_ad_1() : magazineafrique_render_article_ad_2();
        $ad_slot_second = ($post_id % 2 === 0) ? magazineafrique_render_article_ad_2() : magazineafrique_render_article_ad_1();

        $injected = '';
        foreach ($paragraphs as $index => $para) {
            $injected .= $para . '</p>';

            // First insertion after paragraph 3
            if ($index === 2) {
                $injected .= $ad_slot_first;
            }

            // Second insertion after paragraph 6 if article is long enough
            if ($index === 5 && $total_paras >= 7) {
                $injected .= $ad_slot_second;
            }
        }

        return $injected;
    }
    add_filter('the_content', 'magazineafrique_inject_in_article_ads', 20);
}

/**
 * Shortcode support for manual ad placement: [magazineafrique_ad type="article_1|article_2|sidebar|bottom"]
 */
add_shortcode('magazineafrique_ad', function($atts) {
    $atts = shortcode_atts(array(
        'type' => 'article_1'
    ), $atts);

    switch ($atts['type']) {
        case 'article_2':
            return magazineafrique_render_article_ad_2();
        case 'sidebar':
            ob_start();
            magazineafrique_render_ad_sidebar();
            return ob_get_clean();
        case 'bottom':
            ob_start();
            magazineafrique_render_ad_bottom();
            return ob_get_clean();
        case 'header':
            ob_start();
            magazineafrique_render_ad_header();
            return ob_get_clean();
        case 'article_1':
        default:
            return magazineafrique_render_article_ad_1();
    }
});
