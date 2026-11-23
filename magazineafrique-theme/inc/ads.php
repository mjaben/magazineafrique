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

        // Administrators and Editors MUST always see live ads to monitor and test ad inventory
        if (current_user_can('edit_posts')) {
            return true;
        }

        // 100% Ad-Free reading experience for paying Club Prestige subscribers (non-staff)
        $user_id = get_current_user_id();
        if ($user_id) {
            $sub_status = get_user_meta($user_id, 'magazineafrique_sub_status', true);
            if ($sub_status === 'active') {
                return false;
            }
            if (function_exists('wc_memberships_is_user_active_member') && wc_memberships_is_user_active_member($user_id, 'premium')) {
                return false;
            }
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
                width: 100%;
                box-sizing: border-box;
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
                background: transparent;
                border: 1px dashed var(--border-color, #4A433B);
                padding: 0.5rem;
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
                margin: 0 auto;
                position: relative;
                overflow: hidden;
            }
            .vintage-ad-box ins.adsbygoogle {
                display: block !important;
                width: 100% !important;
                min-width: 280px;
                min-height: 90px;
            }
            .vintage-ad-box ins.adsbygoogle[data-ad-status="unfilled"] {
                display: none !important;
            }
            [data-theme="dark"] .vintage-ad-box {
                border-color: #3D3730;
            }
            .ad-house-fallback {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 1rem;
                padding: 1rem 1.5rem;
                background: linear-gradient(135deg, #171513 0%, #2A241F 100%);
                color: #FAF7F2;
                border: 2px solid #000000;
                box-shadow: 4px 4px 0px #000000;
                border-radius: 3px;
                text-align: left;
                width: 100%;
                box-sizing: border-box;
            }
            .ad-house-fallback-left {
                flex: 1 1 300px;
            }
            .ad-house-fallback-kicker {
                font-family: 'JetBrains Mono', monospace;
                font-size: 0.625rem;
                font-weight: 800;
                color: #D97706;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                margin-bottom: 0.2rem;
            }
            .ad-house-fallback-title {
                font-family: 'Playfair Display', Georgia, serif;
                font-size: 1.05rem;
                font-weight: 700;
                color: #FAF7F2;
                margin: 0 0 0.25rem;
                line-height: 1.3;
            }
            .ad-house-fallback-desc {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 0.78rem;
                color: #D6CEC3;
                margin: 0;
                line-height: 1.4;
            }
            .ad-house-fallback-btn {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 0.75rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                background-color: #B85D18;
                color: #FAF7F2 !important;
                padding: 0.55rem 1.1rem;
                border: 2px solid #000000;
                box-shadow: 3px 3px 0px #000000;
                border-radius: 2px;
                text-decoration: none !important;
                white-space: nowrap;
                transition: transform 0.15s ease;
            }
            .ad-house-fallback-btn:hover {
                background-color: #C25E00;
                transform: translate(-1px, -1px);
            }
        </style>
        <?php
    }
    add_action('wp_head', 'magazineafrique_enqueue_adsense_script', 5);
}

/**
 * 1. Render Header Ad Slot (Slot: 4687046934 / Direct Brand Reach)
 */
if (!function_exists('magazineafrique_render_ad_header')) {
    function magazineafrique_render_ad_header() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }

        // Check for active direct Brand Reach campaign in this 5-hour rotation shift
        $direct_ad = function_exists('magazineafrique_get_active_brand_ad') ? magazineafrique_get_active_brand_ad('header_masthead', 'header') : false;
        if ($direct_ad) {
            ?>
            <div class="vintage-ad-container header-ad-zone container-editorial">
                <div class="vintage-ad-label">— CONTINENTAL BRAND REACH PARTNER —</div>
                <div class="vintage-ad-box direct-brand-reach-box" style="max-width: 970px; padding: 0; background: transparent; border: 1px solid rgba(0,0,0,0.15);">
                    <a href="<?php echo esc_url($direct_ad->destination_url); ?>" target="_blank" rel="sponsored noopener" class="direct-brand-ad-link" data-campaign-id="<?php echo esc_attr($direct_ad->id); ?>" style="display: block; width: 100%;">
                        <img src="<?php echo esc_url($direct_ad->creative_url); ?>" alt="<?php echo esc_attr($direct_ad->brand_name); ?>" class="direct-brand-ad-img" style="max-width: 100%; height: auto; display: block; margin: 0 auto;" />
                    </a>
                </div>
            </div>
            <?php
            return;
        }
        ?>
        <div class="vintage-ad-container header-ad-zone container-editorial">
            <div class="vintage-ad-label">— ADVERTISEMENT —</div>
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
                <div class="ad-house-fallback">
                    <div class="ad-house-fallback-left">
                        <div class="ad-house-fallback-kicker">✦ Pan-African Brand Reach Inventory</div>
                        <h4 class="ad-house-fallback-title">Reach 1.8M+ Continental Decision Makers &amp; Founders</h4>
                        <p class="ad-house-fallback-desc">Promote your brand directly across our investigative dossiers and regional economic briefings.</p>
                    </div>
                    <a href="<?php echo esc_url(home_url('/advertise/')); ?>" class="ad-house-fallback-btn">
                        Reserve Ad Space →
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
}

/**
 * 2. Render In-Article Ad Slot 1 (Slot: 9866978622 / Direct Brand Reach)
 */
if (!function_exists('magazineafrique_render_article_ad_1')) {
    function magazineafrique_render_article_ad_1() {
        if (!magazineafrique_should_display_ads()) {
            return '';
        }

        // Check for active direct Brand Reach campaign in this 5-hour rotation shift (Zone: article_1)
        $direct_ad = function_exists('magazineafrique_get_active_brand_ad') ? magazineafrique_get_active_brand_ad('in_article', 'article_1') : false;
        if ($direct_ad) {
            ob_start();
            ?>
            <div class="vintage-ad-container in-article-ad-1 my-6">
                <div class="vintage-ad-label">— CONTINENTAL BRAND REACH PARTNER —</div>
                <div class="vintage-ad-box direct-brand-reach-box" style="padding: 0; background: transparent; border: 1px solid rgba(0,0,0,0.15);">
                    <a href="<?php echo esc_url($direct_ad->destination_url); ?>" target="_blank" rel="sponsored noopener" class="direct-brand-ad-link" data-campaign-id="<?php echo esc_attr($direct_ad->id); ?>" style="display: block; width: 100%;">
                        <img src="<?php echo esc_url($direct_ad->creative_url); ?>" alt="<?php echo esc_attr($direct_ad->brand_name); ?>" class="direct-brand-ad-img" style="max-width: 100%; height: auto; display: block; margin: 0 auto;" />
                    </a>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

        ob_start();
        ?>
        <div class="vintage-ad-container in-article-ad-1 my-6">
            <div class="vintage-ad-label">— ADVERTISEMENT —</div>
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
 * 3. Render In-Article Ad Slot 2 (Slot: 3777306824 / Direct Brand Reach)
 */
if (!function_exists('magazineafrique_render_article_ad_2')) {
    function magazineafrique_render_article_ad_2() {
        if (!magazineafrique_should_display_ads()) {
            return '';
        }

        // Check for active direct Brand Reach campaign in this 5-hour rotation shift (Zone: article_2)
        $direct_ad = function_exists('magazineafrique_get_active_brand_ad') ? magazineafrique_get_active_brand_ad('in_article', 'article_2') : false;
        if ($direct_ad) {
            ob_start();
            ?>
            <div class="vintage-ad-container in-article-ad-2 my-6">
                <div class="vintage-ad-label">— CONTINENTAL BRAND REACH PARTNER —</div>
                <div class="vintage-ad-box direct-brand-reach-box" style="padding: 0; background: transparent; border: 1px solid rgba(0,0,0,0.15);">
                    <a href="<?php echo esc_url($direct_ad->destination_url); ?>" target="_blank" rel="sponsored noopener" class="direct-brand-ad-link" data-campaign-id="<?php echo esc_attr($direct_ad->id); ?>" style="display: block; width: 100%;">
                        <img src="<?php echo esc_url($direct_ad->creative_url); ?>" alt="<?php echo esc_attr($direct_ad->brand_name); ?>" class="direct-brand-ad-img" style="max-width: 100%; height: auto; display: block; margin: 0 auto;" />
                    </a>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

        ob_start();
        ?>
        <div class="vintage-ad-container in-article-ad-2 my-6">
            <div class="vintage-ad-label">— ADVERTISEMENT —</div>
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
 * 4. Render Sidebar Ad Slot (Slot: 1854558906 / Direct Brand Reach)
 */
if (!function_exists('magazineafrique_render_ad_sidebar')) {
    function magazineafrique_render_ad_sidebar() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }

        // Check for active direct Brand Reach campaign in this 5-hour rotation shift (Zone: sidebar)
        $direct_ad = function_exists('magazineafrique_get_active_brand_ad') ? magazineafrique_get_active_brand_ad('sidebar', 'sidebar') : false;
        if ($direct_ad) {
            ?>
            <div class="vintage-ad-container sidebar-ad-zone">
                <div class="vintage-ad-label">— BRAND REACH PARTNER —</div>
                <div class="vintage-ad-box direct-brand-reach-box" style="width: 300px; margin: 0 auto; padding: 0; background: transparent; border: 1px solid rgba(0,0,0,0.15);">
                    <a href="<?php echo esc_url($direct_ad->destination_url); ?>" target="_blank" rel="sponsored noopener" class="direct-brand-ad-link" data-campaign-id="<?php echo esc_attr($direct_ad->id); ?>" style="display: block; width: 100%;">
                        <img src="<?php echo esc_url($direct_ad->creative_url); ?>" alt="<?php echo esc_attr($direct_ad->brand_name); ?>" class="direct-brand-ad-img" style="max-width: 100%; height: auto; display: block; margin: 0 auto;" />
                    </a>
                </div>
            </div>
            <?php
            return;
        }
        ?>
        <div class="vintage-ad-container sidebar-ad-zone">
            <div class="vintage-ad-label">— ADVERTISEMENT —</div>
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
 * 5. Render Bottom Ad Slot (Slot: 1801863291 / Direct Brand Reach)
 */
if (!function_exists('magazineafrique_render_ad_bottom')) {
    function magazineafrique_render_ad_bottom() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }

        // Check for active direct Brand Reach campaign in this 5-hour rotation shift (Zone: bottom)
        $direct_ad = function_exists('magazineafrique_get_active_brand_ad') ? magazineafrique_get_active_brand_ad('bottom', 'bottom') : false;
        if ($direct_ad) {
            ?>
            <div class="vintage-ad-container bottom-ad-zone container-editorial" style="margin-top: 2rem; margin-bottom: 2rem;">
                <div class="vintage-ad-label">— CONTINENTAL BRAND REACH PARTNER —</div>
                <div class="vintage-ad-box direct-brand-reach-box" style="max-width: 970px; padding: 0; background: transparent; border: 1px solid rgba(0,0,0,0.15);">
                    <a href="<?php echo esc_url($direct_ad->destination_url); ?>" target="_blank" rel="sponsored noopener" class="direct-brand-ad-link" data-campaign-id="<?php echo esc_attr($direct_ad->id); ?>" style="display: block; width: 100%;">
                        <img src="<?php echo esc_url($direct_ad->creative_url); ?>" alt="<?php echo esc_attr($direct_ad->brand_name); ?>" class="direct-brand-ad-img" style="max-width: 100%; height: auto; display: block; margin: 0 auto;" />
                    </a>
                </div>
            </div>
            <?php
            return;
        }
        ?>
        <div class="vintage-ad-container bottom-ad-zone container-editorial" style="margin-top: 2rem; margin-bottom: 2rem;">
            <div class="vintage-ad-label">— ADVERTISEMENT —</div>
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
                <div class="ad-house-fallback">
                    <div class="ad-house-fallback-left">
                        <div class="ad-house-fallback-kicker">✦ Pan-African Brand Reach Inventory</div>
                        <h4 class="ad-house-fallback-title">Reach 1.8M+ Continental Decision Makers &amp; Founders</h4>
                        <p class="ad-house-fallback-desc">Promote your brand directly across our investigative dossiers and regional economic briefings.</p>
                    </div>
                    <a href="<?php echo esc_url(home_url('/advertise/')); ?>" class="ad-house-fallback-btn">
                        Reserve Ad Space →
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
}

/**
 * 6. Render Mid-Home Ad Slot (Responsive Leaderboard between Front Page Sections)
 */
if (!function_exists('magazineafrique_render_ad_mid_home')) {
    function magazineafrique_render_ad_mid_home() {
        if (!magazineafrique_should_display_ads()) {
            return;
        }
        ?>
        <div class="vintage-ad-container mid-home-ad-zone container-editorial" style="margin-top: 2.5rem; margin-bottom: 2.5rem;">
            <div class="vintage-ad-label">— ADVERTISEMENT —</div>
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
                <div class="ad-house-fallback">
                    <div class="ad-house-fallback-left">
                        <div class="ad-house-fallback-kicker">✦ Pan-African Brand Reach Inventory</div>
                        <h4 class="ad-house-fallback-title">Reach 1.8M+ Continental Decision Makers &amp; Founders</h4>
                        <p class="ad-house-fallback-desc">Promote your brand directly across our investigative dossiers and regional economic briefings.</p>
                    </div>
                    <a href="<?php echo esc_url(home_url('/advertise/')); ?>" class="ad-house-fallback-btn">
                        Reserve Ad Space →
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
}

/**
 * Auto-inject and Mix In-Article Ads into single post content
 * Dynamic Multi-Ad Logic for All Lengths:
 * - Short articles (2-3 paragraphs): Injects 1 ad after paragraph 1 or 2.
 * - Medium articles (4-7 paragraphs): Injects 2 ads (after paragraph 2 and paragraph 5).
 * - Long articles (8-12 paragraphs): Injects 3 ads (after paragraph 2, paragraph 5, and paragraph 8).
 * - Very long investigations (> 12 paragraphs): Injects periodically every 3-4 paragraphs (paras 2, 6, 10, 14...).
 * - Alternates dynamically between Slot 9866978622 (Responsive Ad 1) and Slot 3777306824 (Fluid In-Article Ad 2).
 */
if (!function_exists('magazineafrique_inject_in_article_ads')) {
    function magazineafrique_inject_in_article_ads($content) {
        if (!is_singular('post') || !is_main_query() || !magazineafrique_should_display_ads()) {
            return $content;
        }

        // If post has paywall excerpt only and user is not paid/admin, don't inject inside preview
        if (function_exists('magazineafrique_is_premium_post') && magazineafrique_is_premium_post() &&
            (!function_exists('magazineafrique_user_has_active_subscription') || !magazineafrique_user_has_active_subscription())) {
            return $content;
        }

        $paragraphs = explode('</p>', $content);
        $total_paras = count($paragraphs);

        if ($total_paras < 2) {
            return $content;
        }

        $post_id = get_the_ID();

        // Calculate target insertion paragraphs based on article length
        $target_indices = array();
        if ($total_paras <= 3) {
            $target_indices[] = 1; // After para 2 (0-indexed: 1)
        } elseif ($total_paras <= 7) {
            $target_indices[] = 1; // After para 2
            $target_indices[] = 4; // After para 5
        } elseif ($total_paras <= 12) {
            $target_indices[] = 1; // After para 2
            $target_indices[] = 4; // After para 5
            $target_indices[] = 7; // After para 8
        } else {
            // For long investigative reports (>12 paragraphs), inject every 4 paragraphs up to paragraph count - 2
            for ($p = 1; $p < ($total_paras - 2); $p += 4) {
                $target_indices[] = $p;
            }
        }

        $injected = '';
        $ad_counter = ($post_id % 2 === 0) ? 0 : 1;

        foreach ($paragraphs as $index => $para) {
            if (trim($para) === '') continue;
            $injected .= $para . '</p>';

            if (in_array($index, $target_indices, true)) {
                // Alternate between Ad Slot 1 (Responsive Leaderboard/Box) and Ad Slot 2 (Fluid Native In-Article)
                $current_ad = ($ad_counter % 2 === 0) 
                    ? magazineafrique_render_article_ad_1() 
                    : magazineafrique_render_article_ad_2();
                $injected .= $current_ad;
                $ad_counter++;
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
