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
 * Render the High-Conversion Paywall Card with Comprehensive Subscriber Benefits
 */
if (!function_exists('magazineafrique_render_paywall_card')) {
    function magazineafrique_render_paywall_card() {
        ob_start();
        ?>
        <div class="paywall-wrapper">
            <div class="paywall-fade"></div>
            <div class="paywall-card" style="background-color: #072213; border: 2px solid #D97706; border-radius: 4px; padding: 2rem 1.5rem; color: #FAF7F2; box-shadow: 0 12px 32px rgba(0,0,0,0.4);">
                <div class="paywall-gold-bar" style="height: 3px; background: linear-gradient(90deg, #D97706, #F59E0B, #B45309); margin-bottom: 1.25rem;"></div>
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 1rem; color: #F59E0B;">★</span>
                            <span style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: #F59E0B; font-family: 'JetBrains Mono', monospace;">
                                Club Magazine Afrique Prestige Vault
                            </span>
                        </div>
                        <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; background: rgba(245, 158, 11, 0.15); color: #F59E0B; padding: 0.2rem 0.5rem; border-radius: 2px; border: 1px solid rgba(245, 158, 11, 0.3);">
                            Subscriber Protected
                        </span>
                    </div>

                    <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(1.4rem, 3.5vw, 1.85rem); font-weight: 900; line-height: 1.22; color: #FFFFFF; margin: 0;">
                        This Strategic Intelligence Dossier is Reserved for Club Subscribers
                    </h3>

                    <p style="font-size: 0.875rem; color: #D1D5DB; line-height: 1.6; max-width: 620px; margin: 0;">
                        Unlock the complete investigation, source registry filings, and receive our weekly classified diplomatic wire.
                    </p>

                    <!-- Core Subscriber Benefits Requested by Readers -->
                    <div style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(217, 119, 6, 0.3); border-radius: 3px; padding: 1rem; margin: 0.5rem 0;">
                        <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #F59E0B; margin-bottom: 0.75rem; font-family: 'JetBrains Mono', monospace;">
                            Club Prestige Member Benefits
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.8125rem; color: #FAF7F2; display: flex; flex-direction: column; gap: 0.55rem; line-height: 1.45;">
                            <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                                <span style="color: #10B981; font-weight: bold;">✓</span>
                                <div><strong>Exclusive In-Depth News:</strong> Unrestricted access to forensic investigations and confidential dossiers.</div>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                                <span style="color: #10B981; font-weight: bold;">✓</span>
                                <div><strong>100% Ad-Free Reading:</strong> Pristine broadsheet typography on mobile &amp; desktop with zero banner clutter.</div>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                                <span style="color: #10B981; font-weight: bold;">✓</span>
                                <div><strong>Video Format News Feature:</strong> Priority invitations to submit reader opinions and feature in monthly video dispatches.</div>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                                <span style="color: #10B981; font-weight: bold;">✓</span>
                                <div><strong>Exclusive Business &amp; Commodity Data:</strong> Direct access to African mineral concession tables, sovereign debt matrices, and market datasets.</div>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                                <span style="color: #10B981; font-weight: bold;">✓</span>
                                <div><strong>First-Hand Political Rumors &amp; Whispers:</strong> Off-the-record corridors of power intelligence from Abuja, Dakar, Nairobi, and Pretoria.</div>
                            </li>
                        </ul>
                    </div>

                    <!-- Pricing & Action Buttons -->
                    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; padding-top: 0.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="btn-paywall-cta" style="background-color: #D97706; color: #FFFFFF !important; font-weight: 800; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.06em; padding: 0.75rem 1.4rem; border-radius: 2px; text-decoration: none; display: inline-block;">
                                Subscribe · From $4.99 / mo
                            </a>
                            <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" style="color: #F59E0B; font-size: 0.75rem; text-decoration: underline; font-weight: 700;">
                                View All 3 Tiers →
                            </a>
                        </div>
                        <div style="font-size: 0.75rem; color: #9CA3AF;">
                            Existing subscriber? <a href="<?php echo esc_url(home_url('/onboarding/')); ?>" style="color: #F59E0B; text-decoration: underline; font-weight: 700;">Sign In Here</a>
                        </div>
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
