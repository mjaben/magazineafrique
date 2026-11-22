<?php
/**
 * Magazine Afrique — Paywall Engine & Google-Compliant Access Control
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if the current post is designated as Premium / Gated content
 */
if (!function_exists('magazineafrique_is_premium_post')) {
    function magazineafrique_is_premium_post($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        if (!$post_id) {
            return false;
        }

        $meta_flag = get_post_meta($post_id, '_magazineafrique_is_premium', true);
        if ($meta_flag === '1' || $meta_flag === 'yes') {
            return true;
        }

        if (has_category(array('premium', 'exclusive', 'exclusif', 'club'), $post_id) || has_tag(array('premium', 'subscriber', 'abonne', 'exclusive'), $post_id)) {
            return true;
        }

        return false;
    }
}

/**
 * Check if current user has an active paid subscription
 */
if (!function_exists('magazineafrique_user_has_active_subscription')) {
    function magazineafrique_user_has_active_subscription($user_id = null) {
        if (!is_user_logged_in()) {
            return false;
        }

        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        if (current_user_can('edit_posts')) {
            return true;
        }

        $sub_status = get_user_meta($user_id, 'magazineafrique_sub_status', true);
        if ($sub_status === 'active') {
            return true;
        }

        if (function_exists('wc_memberships_is_user_active_member') && wc_memberships_is_user_active_member($user_id, 'premium')) {
            return true;
        }

        return false;
    }
}

/**
 * Server-Side Paywall Gating via the_content filter
 */
if (!function_exists('magazineafrique_paywall_content_gatekeeper')) {
    function magazineafrique_paywall_content_gatekeeper($content) {
        if (!is_singular('post') || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        if (!magazineafrique_is_premium_post()) {
            return $content;
        }

        if (magazineafrique_user_has_active_subscription()) {
            return $content;
        }

        $paragraphs = explode('</p>', $content);
        $teaser_count = min(3, count($paragraphs) - 1);
        
        $teaser_content = '';
        for ($i = 0; $i < $teaser_count; $i++) {
            if (trim($paragraphs[$i])) {
                $teaser_content .= $paragraphs[$i] . '</p>';
            }
        }

        $paywall_box = magazineafrique_render_paywall_card();

        return $teaser_content . $paywall_box;
    }
    add_filter('the_content', 'magazineafrique_paywall_content_gatekeeper', 20);
}

/**
 * Render the High-Conversion Paywall Card
 */
if (!function_exists('magazineafrique_render_paywall_card')) {
    function magazineafrique_render_paywall_card() {
        ob_start();
        ?>
        <div class="paywall-wrapper">
            <div class="paywall-fade"></div>
            <div class="paywall-card">
                <div class="paywall-gold-bar"></div>
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 9999px; background-color: #F59E0B;"></span>
                        <span style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #F59E0B;">
                            Club Magazine Afrique Prestige
                        </span>
                    </div>

                    <h3 class="font-serif" style="font-size: 1.5rem; font-weight: 700; line-height: 1.25; color: #FFFFFF;">
                        This in-depth investigative story is exclusive to Club Subscribers
                    </h3>

                    <p style="font-size: 0.875rem; color: #D1D5DB; line-height: 1.6; max-width: 600px;">
                        Gain unlimited access to all strategic economic dossiers, policy analyses, and independent continental journalism shaping Africa's future.
                    </p>

                    <ul style="list-style: none; padding: 0; margin: 0.5rem 0; font-size: 0.8125rem; color: #E5E7EB; display: flex; flex-direction: column; gap: 0.35rem;">
                        <li>✓ Complete, unrestricted access to all major investigative dossiers</li>
                        <li>✓ 100% Ad-Free reading experience across desktop and mobile</li>
                        <li>✓ Monthly executive briefing and quarterly strategic report in PDF</li>
                    </ul>

                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin-top: 0.5rem;">
                        <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="btn-paywall-cta">
                            Subscribe · From $4.99 / month
                        </a>
                        <span style="font-size: 0.8125rem; color: #9CA3AF;">
                            Already a subscriber? <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" style="color: #F59E0B; text-decoration: underline;">Sign In</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

/**
 * Output Google-Compliant NewsArticle JSON-LD Schema
 */
if (!function_exists('magazineafrique_output_paywall_schema')) {
    function magazineafrique_output_paywall_schema() {
        if (!is_singular('post')) {
            return;
        }

        $post_id = get_the_ID();
        $is_premium = magazineafrique_is_premium_post($post_id);

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id' => get_permalink($post_id)
            ),
            'headline' => get_the_title($post_id),
            'datePublished' => get_the_date('c', $post_id),
            'dateModified' => get_the_modified_date('c', $post_id),
            'inLanguage' => get_locale(),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author_meta('display_name', get_post_field('post_author', $post_id))
            ),
            'publisher' => array(
                '@type' => 'NewsMediaOrganization',
                'name' => get_bloginfo('name'),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_theme_file_uri('/assets/images/logo.jpg')
                )
            )
        );

        if (has_post_thumbnail($post_id)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
            if ($img_src) {
                $schema['image'] = array($img_src[0]);
            }
        }

        if ($is_premium) {
            $schema['isAccessibleForFree'] = 'False';
            $schema['hasPart'] = array(
                '@type' => 'WebPageElement',
                'isAccessibleForFree' => 'False',
                'cssSelector' => '.paywall-wrapper'
            );
        } else {
            $schema['isAccessibleForFree'] = 'True';
        }

        echo "\n<!-- Google News & Paywall Structured Data -->\n";
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
    add_action('wp_head', 'magazineafrique_output_paywall_schema', 15);
}
