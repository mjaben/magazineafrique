<?php
/**
 * Magazine Afrique — Reader Onboarding & Profile Engine
 * Handles user enrollment, auto-location detection, and news personalization
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register User Meta Fields for Custom Profile
 */
if (!function_exists('magazineafrique_register_user_meta')) {
    function magazineafrique_register_user_meta() {
        $meta_fields = array(
            'gender'           => 'string',
            'reader_location'  => 'string',
            'reader_country'   => 'string',
            'reader_city'      => 'string',
            'reader_lat'       => 'string',
            'reader_lng'       => 'string',
            'reader_interests' => 'string'
        );

        foreach ($meta_fields as $meta_key => $type) {
            register_meta('user', $meta_key, array(
                'type'         => $type,
                'single'       => true,
                'show_in_rest' => true,
            ));
        }
    }
    add_action('init', 'magazineafrique_register_user_meta');
}

/**
 * AJAX Handler: Reader Onboarding & Account Creation
 */
if (!function_exists('magazineafrique_ajax_onboarding_submit')) {
    function magazineafrique_ajax_onboarding_submit() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name  = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email      = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $username   = isset($_POST['username']) ? sanitize_user($_POST['username'], true) : '';
        $gender     = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $location   = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';
        $country    = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
        $city       = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';

        if (empty($email) || !is_email($email)) {
            wp_send_json_error(array('message' => esc_html__('Please provide a valid email address.', 'magazineafrique')));
        }

        // If username not provided, generate from email
        if (empty($username)) {
            $parts = explode('@', $email);
            $username = sanitize_user($parts[0], true);
        }

        $user_id = 0;

        // Check if user already exists
        if (email_exists($email)) {
            $existing_user = get_user_by('email', $email);
            $user_id = $existing_user->ID;
        } elseif (username_exists($username)) {
            $username = $username . '_' . wp_rand(10, 99);
            $random_password = wp_generate_password(16, false);
            $user_id = wp_create_user($username, $random_password, $email);
        } else {
            $random_password = wp_generate_password(16, false);
            $user_id = wp_create_user($username, $random_password, $email);
        }

        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => $user_id->get_error_message()));
        }

        // Update User Profile Details
        wp_update_user(array(
            'ID'           => $user_id,
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => trim($first_name . ' ' . $last_name) ?: $username,
        ));

        // Save Meta Details
        update_user_meta($user_id, 'gender', $gender);
        update_user_meta($user_id, 'reader_location', $location);
        update_user_meta($user_id, 'reader_country', $country);
        update_user_meta($user_id, 'reader_city', $city);

        // Also set persistent cookie for localized regional news feed (30 days)
        setcookie('magafrique_reader_location', $location, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);
        setcookie('magafrique_reader_country', $country, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);

        // Auto-login the user
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);

        wp_send_json_success(array(
            'message'      => esc_html__('Enrollment complete! Welcome to Magazine Afrique.', 'magazineafrique'),
            'redirect_url' => home_url('/profile/')
        ));
    }
    add_action('wp_ajax_magazineafrique_onboarding_submit', 'magazineafrique_ajax_onboarding_submit');
    add_action('wp_ajax_nopriv_magazineafrique_onboarding_submit', 'magazineafrique_ajax_onboarding_submit');
}

/**
 * AJAX Handler: Update Profile
 */
if (!function_exists('magazineafrique_ajax_update_profile')) {
    function magazineafrique_ajax_update_profile() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => esc_html__('You must be logged in to update your profile.', 'magazineafrique')));
        }

        $user_id    = get_current_user_id();
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name  = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $gender     = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $location   = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';
        $country    = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
        $city       = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';

        wp_update_user(array(
            'ID'           => $user_id,
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => trim($first_name . ' ' . $last_name) ?: wp_get_current_user()->user_login,
        ));

        update_user_meta($user_id, 'gender', $gender);
        if (!empty($location)) {
            update_user_meta($user_id, 'reader_location', $location);
            update_user_meta($user_id, 'reader_country', $country);
            update_user_meta($user_id, 'reader_city', $city);

            setcookie('magafrique_reader_location', $location, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);
            setcookie('magafrique_reader_country', $country, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);
        }

        wp_send_json_success(array('message' => esc_html__('Profile updated successfully!', 'magazineafrique')));
    }
    add_action('wp_ajax_magazineafrique_update_profile', 'magazineafrique_ajax_update_profile');
}

/**
 * Helper: Retrieve localized reader location
 */
if (!function_exists('magazineafrique_get_reader_location')) {
    function magazineafrique_get_reader_location() {
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $loc = get_user_meta($user_id, 'reader_location', true);
            if (!empty($loc)) return $loc;
        }

        if (!empty($_COOKIE['magafrique_reader_location'])) {
            return sanitize_text_field($_COOKIE['magafrique_reader_location']);
        }

        return 'Pan-African Hub (Lagos / Dakar / Nairobi)';
    }
}
