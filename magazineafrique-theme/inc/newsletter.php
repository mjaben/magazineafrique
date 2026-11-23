<?php
/**
 * Magazine Afrique — Newsletter Integration & Subscription Engine
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Newsletter Signup Card
 */
if (!function_exists('magazineafrique_render_newsletter_card')) {
    function magazineafrique_render_newsletter_card($title = null, $subtitle = null) {
        if (!$title) {
            $title = "The Africa Brief: Essential continental intelligence every Thursday";
        }
        if (!$subtitle) {
            $subtitle = "Join 45,000 leaders, investors, and policymakers receiving our curated economic and geopolitical analysis directly in their inbox.";
        }

        ob_start();
        ?>
        <div class="newsletter-card">
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; font-weight: 700; color: #B45309; text-transform: uppercase; letter-spacing: 0.05em;">
                    <span>✉</span> Weekly Newsletter
                </div>

                <h3 class="font-serif" style="font-size: 1.25rem; font-weight: 700; color: #1C1917; line-height: 1.3;">
                    <?php echo esc_html($title); ?>
                </h3>

                <p style="font-size: 0.8125rem; color: #66615B; line-height: 1.5;">
                    <?php echo esc_html($subtitle); ?>
                </p>

                <form class="magazine-newsletter-form" style="margin-top: 0.5rem; display: flex; flex-direction: column; gap: 0.5rem;">
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <input type="email" name="email" placeholder="Your work email address" required class="newsletter-input" style="flex: 1; min-width: 220px;" />
                        <button type="submit" class="btn-newsletter-submit">
                            Subscribe Free
                        </button>
                    </div>
                    <div class="newsletter-feedback"></div>
                    <span style="font-size: 0.6875rem; color: #78716C;">
                        🔒 Zero spam. Unsubscribe in 1-click anytime.
                    </span>
                </form>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

/**
 * Automatically inject newsletter block into articles
 */
if (!function_exists('magazineafrique_inject_in_article_newsletter')) {
    function magazineafrique_inject_in_article_newsletter($content) {
        if (!is_singular('post') || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        $paragraphs = explode('</p>', $content);
        if (count($paragraphs) < 7) {
            return $content;
        }

        $newsletter_html = magazineafrique_render_newsletter_card();
        $new_content = '';

        foreach ($paragraphs as $index => $paragraph) {
            if (trim($paragraph)) {
                $new_content .= $paragraph . '</p>';
            }

            if ($index === 5) {
                $new_content .= $newsletter_html;
            }
        }

        return $new_content;
    }
    add_filter('the_content', 'magazineafrique_inject_in_article_newsletter', 15);
}

/**
 * Handle AJAX subscription submission
 */
if (!function_exists('magazineafrique_handle_newsletter_subscription')) {
    function magazineafrique_handle_newsletter_subscription() {
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

        if (!is_email($email)) {
            wp_send_json_error('Please provide a valid email address.');
        }

        $subscribers = get_option('magazineafrique_newsletter_subscribers', array());
        if (!in_array($email, $subscribers)) {
            $subscribers[] = $email;
            update_option('magazineafrique_newsletter_subscribers', $subscribers);
        }

        $webhook_url = get_option('magazineafrique_newsletter_webhook_url');
        if ($webhook_url) {
            wp_remote_post($webhook_url, array(
                'body' => json_encode(array('email' => $email, 'date' => current_time('mysql'))),
                'headers' => array('Content-Type' => 'application/json'),
                'timeout' => 5
            ));
        }

        wp_send_json_success('Subscription confirmed! Welcome to The Africa Brief.');
    }
    add_action('wp_ajax_nopriv_magazineafrique_subscribe', 'magazineafrique_handle_newsletter_subscription');
    add_action('wp_ajax_magazineafrique_subscribe', 'magazineafrique_handle_newsletter_subscription');
}
