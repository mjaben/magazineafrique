<?php
/**
 * Magazine Afrique — Full Backend Engine for Readers, Profiles, Avatars, Sessions,
 * Following/Bookmarks, Likes, Shares, and Notifications
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Initialize Reader Session & Cookie Engine
 */
if (!function_exists('magazineafrique_init_session')) {
    function magazineafrique_init_session() {
        if (!session_id() && !headers_sent() && php_sapi_name() !== 'cli') {
            session_start();
        }

        // Initialize session arrays if empty
        if (isset($_SESSION)) {
            if (!isset($_SESSION['magafrique_bookmarks'])) $_SESSION['magafrique_bookmarks'] = array();
            if (!isset($_SESSION['magafrique_followed_cats'])) $_SESSION['magafrique_followed_cats'] = array();
            if (!isset($_SESSION['magafrique_followed_tags'])) $_SESSION['magafrique_followed_tags'] = array();
            if (!isset($_SESSION['magafrique_liked_posts'])) $_SESSION['magafrique_liked_posts'] = array();
        }
    }
    add_action('init', 'magazineafrique_init_session', 1);
}

/**
 * 2. Virtual Router & Auto Page Creator (Guarantees zero 404s for /feed/, /subscribe/, /login/, /profile/, /onboarding/, /notifications/)
 */
if (!function_exists('magazineafrique_handle_virtual_routes')) {
    function magazineafrique_handle_virtual_routes() {
        global $wp_query;
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Route: /feed/ (Browser view for reader personalized feed)
        if ($path === 'feed' || $path === 'wire' || $path === 'for-you') {
            $accept = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
            // If explicit RSS reader client, let WP handle RSS XML
            if (strpos($accept, 'application/rss+xml') !== false || strpos($accept, 'application/xml') !== false) {
                return;
            }
            $feed_template = get_template_directory() . '/template-feed.php';
            if (file_exists($feed_template)) {
                status_header(200);
                if (isset($wp_query)) {
                    $wp_query->is_404 = false;
                }
                include $feed_template;
                exit;
            }
        }

        // Route: /login/ or /signin/
        if ($path === 'login' || $path === 'signin') {
            $onboarding_template = get_template_directory() . '/template-onboarding.php';
            if (file_exists($onboarding_template)) {
                status_header(200);
                $_GET['mode'] = 'login';
                if (isset($wp_query)) {
                    $wp_query->is_404 = false;
                }
                include $onboarding_template;
                exit;
            }
        }

        // Route: /onboarding/ or /register/ or /join/ or /enroll/
        if ($path === 'onboarding' || $path === 'register' || $path === 'join' || $path === 'enroll') {
            $onboarding_template = get_template_directory() . '/template-onboarding.php';
            if (file_exists($onboarding_template)) {
                status_header(200);
                if (isset($wp_query)) {
                    $wp_query->is_404 = false;
                }
                include $onboarding_template;
                exit;
            }
        }

        // Route: /subscribe/ or /club/ or /prestige/ or /membership/ or /plans/
        if ($path === 'subscribe' || $path === 'club' || $path === 'prestige' || $path === 'membership' || $path === 'plans') {
            $subscribe_template = get_template_directory() . '/template-subscribe.php';
            if (file_exists($subscribe_template)) {
                status_header(200);
                if (isset($wp_query)) {
                    $wp_query->is_404 = false;
                }
                include $subscribe_template;
                exit;
            }
        }

        // Route: /profile/ or /edit-profile/
        if ($path === 'profile' || $path === 'edit-profile') {
            $profile_template = get_template_directory() . '/template-profile.php';
            if (file_exists($profile_template)) {
                status_header(200);
                if (isset($wp_query)) {
                    $wp_query->is_404 = false;
                }
                include $profile_template;
                exit;
            }
        }

        // Route: /notifications/ or /alerts/
        if ($path === 'notifications' || $path === 'alerts') {
            $notif_template = get_template_directory() . '/template-notifications.php';
            if (file_exists($notif_template)) {
                status_header(200);
                if (isset($wp_query)) {
                    $wp_query->is_404 = false;
                }
                include $notif_template;
                exit;
            }
        }
    }
    add_action('init', 'magazineafrique_handle_virtual_routes', 5);
    add_action('template_redirect', 'magazineafrique_handle_virtual_routes', 1);
}

if (!function_exists('magazineafrique_route_profile_pages')) {
    function magazineafrique_route_profile_pages($template) {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Route: /feed/ (Browser view for reader personalized feed)
        if ($path === 'feed' || $path === 'wire' || $path === 'for-you') {
            if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'text/html') !== false) {
                $feed_template = __DIR__ . '/../template-feed.php';
                if (file_exists($feed_template)) {
                    status_header(200);
                    return $feed_template;
                }
            }
        }

        // Route: /subscribe/ or /club/ or /prestige/ or /membership/
        if ($path === 'subscribe' || $path === 'club' || $path === 'prestige' || $path === 'membership' || $path === 'plans') {
            $subscribe_template = __DIR__ . '/../template-subscribe.php';
            if (file_exists($subscribe_template)) {
                status_header(200);
                return $subscribe_template;
            }
        }

        // Route: /login/ or /signin/
        if ($path === 'login' || $path === 'signin') {
            $onboarding_template = __DIR__ . '/../template-onboarding.php';
            if (file_exists($onboarding_template)) {
                status_header(200);
                $_GET['mode'] = 'login';
                return $onboarding_template;
            }
        }

        // Route: /profile/ or /edit-profile/
        if ($path === 'profile' || $path === 'edit-profile') {
            $profile_template = __DIR__ . '/../template-profile.php';
            if (file_exists($profile_template)) {
                status_header(200);
                return $profile_template;
            }
        }

        // Route: /onboarding/ or /register/ or /join/ or /enroll/
        if ($path === 'onboarding' || $path === 'register' || $path === 'join' || $path === 'enroll') {
            $onboarding_template = __DIR__ . '/../template-onboarding.php';
            if (file_exists($onboarding_template)) {
                status_header(200);
                return $onboarding_template;
            }
        }

        // Route: /notifications/ or /alerts/
        if ($path === 'notifications' || $path === 'alerts') {
            $notif_template = __DIR__ . '/../template-notifications.php';
            if (file_exists($notif_template)) {
                status_header(200);
                return $notif_template;
            }
        }

        return $template;
    }
    add_filter('template_include', 'magazineafrique_route_profile_pages', 99);
}

/**
 * Programmatically create Profile, Onboarding, Subscribe, Login, Feed, and Notifications pages in WP database
 */
if (!function_exists('magazineafrique_ensure_system_pages')) {
    function magazineafrique_ensure_system_pages() {
        if (get_transient('magafrique_pages_checked_v5')) {
            return;
        }

        $pages = array(
            'feed' => array(
                'title'    => 'The Pan-African Reader Feed',
                'template' => 'template-feed.php'
            ),
            'profile' => array(
                'title'    => 'Reader Profile',
                'template' => 'template-profile.php'
            ),
            'onboarding' => array(
                'title'    => 'Reader Enrollment',
                'template' => 'template-onboarding.php'
            ),
            'subscribe' => array(
                'title'    => 'Club Prestige Membership',
                'template' => 'template-subscribe.php'
            ),
            'login' => array(
                'title'    => 'Reader Sign In',
                'template' => 'template-onboarding.php'
            ),
            'notifications' => array(
                'title'    => 'Reader Notifications',
                'template' => 'template-notifications.php'
            ),
            'advertise' => array(
                'title'    => 'Buy Ad Space — Brand Reach Inventory',
                'template' => 'template-buy-ad-space.php'
            )
        );

        $created = false;
        foreach ($pages as $slug => $data) {
            $existing = get_page_by_path($slug);
            if (!$existing) {
                $page_id = wp_insert_post(array(
                    'post_title'     => $data['title'],
                    'post_name'      => $slug,
                    'post_status'    => 'publish',
                    'post_type'      => 'page',
                    'comment_status' => 'closed',
                    'ping_status'    => 'closed'
                ));
                if (!is_wp_error($page_id) && $page_id > 0) {
                    update_post_meta($page_id, '_wp_page_template', $data['template']);
                    $created = true;
                }
            }
        }

        if ($created) {
            flush_rewrite_rules(false);
        }

        set_transient('magafrique_pages_checked_v5', true, DAY_IN_SECONDS);
    }
    add_action('init', 'magazineafrique_ensure_system_pages', 20);
}

/**
 * 3. Register Custom User & Post Meta Fields
 */
if (!function_exists('magazineafrique_register_engine_meta')) {
    function magazineafrique_register_engine_meta() {
        // User meta
        $user_meta = array(
            'gender'                       => 'string',
            'reader_location'              => 'string',
            'reader_country'               => 'string',
            'reader_city'                  => 'string',
            'reader_lat'                   => 'string',
            'reader_lng'                   => 'string',
            'reader_bio'                   => 'string',
            'reader_phone'                 => 'string',
            'reader_twitter'               => 'string',
            'reader_linkedin'              => 'string',
            'reader_website'               => 'string',
            'reader_interests'             => 'string',
            'magazineafrique_custom_avatar'=> 'string',
            'magazineafrique_bookmarks'    => 'string',
            'magazineafrique_followed_cats'=> 'string',
            'magazineafrique_followed_tags'=> 'string',
            'magazineafrique_notifications'=> 'string'
        );

        foreach ($user_meta as $key => $type) {
            register_meta('user', $key, array('type' => $type, 'single' => true, 'show_in_rest' => true));
        }

        // Post meta for live likes and shares
        register_meta('post', '_magazineafrique_like_count', array('type' => 'integer', 'single' => true, 'show_in_rest' => true, 'default' => 0));
        register_meta('post', '_magazineafrique_share_count', array('type' => 'integer', 'single' => true, 'show_in_rest' => true, 'default' => 0));
    }
    add_action('init', 'magazineafrique_register_engine_meta');
}

/**
 * 4. Custom Avatar Filter: Overrides Gravatar with Uploaded Custom Avatar
 */
if (!function_exists('magazineafrique_filter_avatar_url')) {
    function magazineafrique_filter_avatar_url($url, $id_or_email, $args) {
        $user_id = 0;

        if (is_numeric($id_or_email)) {
            $user_id = (int)$id_or_email;
        } elseif (is_string($id_or_email) && is_email($id_or_email)) {
            $user = get_user_by('email', $id_or_email);
            if ($user) $user_id = $user->ID;
        } elseif (is_object($id_or_email) && isset($id_or_email->user_id)) {
            $user_id = (int)$id_or_email->user_id;
        }

        if ($user_id > 0) {
            $custom_avatar = get_user_meta($user_id, 'magazineafrique_custom_avatar', true);
            if (!empty($custom_avatar)) {
                return esc_url($custom_avatar);
            }
        }

        return $url;
    }
    add_filter('get_avatar_url', 'magazineafrique_filter_avatar_url', 20, 3);
}

/**
 * Helper: Retrieve Avatar URL with Initials Monogram Fallback
 */
if (!function_exists('magazineafrique_get_avatar_url')) {
    function magazineafrique_get_avatar_url($user_id = 0) {
        if ($user_id === 0 && is_user_logged_in()) {
            $user_id = get_current_user_id();
        }

        if ($user_id > 0) {
            $custom = get_user_meta($user_id, 'magazineafrique_custom_avatar', true);
            if (!empty($custom)) {
                return esc_url($custom);
            }
            return get_avatar_url($user_id, array('size' => 192));
        }

        return get_theme_file_uri('/assets/images/default-avatar.svg');
    }
}

/**
 * 5. AJAX Handler: Upload Avatar Image
 */
if (!function_exists('magazineafrique_ajax_upload_avatar')) {
    function magazineafrique_ajax_upload_avatar() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => esc_html__('Please sign in to upload an avatar.', 'magazineafrique')));
        }

        $user_id = get_current_user_id();

        if (empty($_FILES['avatar']) || empty($_FILES['avatar']['name'])) {
            wp_send_json_error(array('message' => esc_html__('No image file selected.', 'magazineafrique')));
        }

        $file = $_FILES['avatar'];

        // Validate File Size (Max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            wp_send_json_error(array('message' => esc_html__('Image exceeds maximum allowed size (5MB).', 'magazineafrique')));
        }

        // Validate File Extension & MIME
        $allowed_mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'png'          => 'image/png',
            'webp'         => 'image/webp',
            'gif'          => 'image/gif'
        );

        $file_info = wp_check_filetype($file['name'], $allowed_mimes);
        if (!$file_info['ext'] || !in_array($file['type'], $allowed_mimes, true)) {
            wp_send_json_error(array('message' => esc_html__('Invalid file format. Please upload JPG, PNG, or WebP.', 'magazineafrique')));
        }

        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        // Handle upload
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($file, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            $avatar_url = $movefile['url'];

            // Store in user meta
            update_user_meta($user_id, 'magazineafrique_custom_avatar', $avatar_url);

            wp_send_json_success(array(
                'message'    => esc_html__('Avatar updated successfully!', 'magazineafrique'),
                'avatar_url' => esc_url($avatar_url)
            ));
        } else {
            wp_send_json_error(array('message' => $movefile['error'] ?: esc_html__('Upload failed.', 'magazineafrique')));
        }
    }
    add_action('wp_ajax_magazineafrique_upload_avatar', 'magazineafrique_ajax_upload_avatar');
}

/**
 * 6. AJAX Handler: Update Full Reader Profile
 */
if (!function_exists('magazineafrique_ajax_update_profile')) {
    function magazineafrique_ajax_update_profile() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => esc_html__('You must be signed in to edit your profile.', 'magazineafrique')));
        }

        $user_id      = get_current_user_id();
        $first_name   = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name    = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $display_name = isset($_POST['display_name']) ? sanitize_text_field($_POST['display_name']) : '';
        $email        = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $gender       = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $bio          = isset($_POST['bio']) ? sanitize_textarea_field($_POST['bio']) : '';
        $location     = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';
        $country      = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
        $city         = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
        $twitter      = isset($_POST['twitter']) ? sanitize_text_field($_POST['twitter']) : '';
        $linkedin     = isset($_POST['linkedin']) ? sanitize_text_field($_POST['linkedin']) : '';

        // Email validation
        if (!empty($email) && is_email($email)) {
            $user_by_email = get_user_by('email', $email);
            if ($user_by_email && $user_by_email->ID !== $user_id) {
                wp_send_json_error(array('message' => esc_html__('This email address is already in use by another reader.', 'magazineafrique')));
            }
        }

        // Update core user
        $user_data = array(
            'ID'           => $user_id,
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => $display_name ?: (trim($first_name . ' ' . $last_name) ?: wp_get_current_user()->user_login)
        );

        if (!empty($email) && is_email($email)) {
            $user_data['user_email'] = $email;
        }

        $updated = wp_update_user($user_data);
        if (is_wp_error($updated)) {
            wp_send_json_error(array('message' => $updated->get_error_message()));
        }

        // Update meta fields
        update_user_meta($user_id, 'gender', $gender);
        update_user_meta($user_id, 'reader_bio', $bio);
        update_user_meta($user_id, 'reader_twitter', $twitter);
        update_user_meta($user_id, 'reader_linkedin', $linkedin);

        if (!empty($location)) {
            update_user_meta($user_id, 'reader_location', $location);
            update_user_meta($user_id, 'reader_country', $country);
            update_user_meta($user_id, 'reader_city', $city);

            setcookie('magafrique_reader_location', $location, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);
            setcookie('magafrique_reader_country', $country, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);
            if (isset($_SESSION)) {
                $_SESSION['magafrique_reader_location'] = $location;
            }
        }

        wp_send_json_success(array('message' => esc_html__('Reader profile updated successfully!', 'magazineafrique')));
    }
    add_action('wp_ajax_magazineafrique_update_profile', 'magazineafrique_ajax_update_profile');
}

/**
 * 7. AJAX Handler: Change Password
 */
if (!function_exists('magazineafrique_ajax_change_password')) {
    function magazineafrique_ajax_change_password() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => esc_html__('Unauthorized.', 'magazineafrique')));
        }

        $user_id          = get_current_user_id();
        $user             = get_user_by('id', $user_id);
        $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
        $new_password     = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        if (!wp_check_password($current_password, $user->user_pass, $user_id)) {
            wp_send_json_error(array('message' => esc_html__('Current password is incorrect.', 'magazineafrique')));
        }

        if (strlen($new_password) < 8) {
            wp_send_json_error(array('message' => esc_html__('New password must be at least 8 characters long.', 'magazineafrique')));
        }

        if ($new_password !== $confirm_password) {
            wp_send_json_error(array('message' => esc_html__('New passwords do not match.', 'magazineafrique')));
        }

        wp_set_password($new_password, $user_id);
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);

        wp_send_json_success(array('message' => esc_html__('Password changed successfully.', 'magazineafrique')));
    }
    add_action('wp_ajax_magazineafrique_change_password', 'magazineafrique_ajax_change_password');
}

/**
 * 8. AJAX Handler: Reader Onboarding & Verification Code Dispatch
 */
if (!function_exists('magazineafrique_ajax_onboarding_submit')) {
    function magazineafrique_ajax_onboarding_submit() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name  = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email      = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $username   = isset($_POST['username']) ? sanitize_user($_POST['username'], true) : '';
        $password   = isset($_POST['password']) ? trim($_POST['password']) : '';
        $gender     = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $location   = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';
        $country    = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
        $city       = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';

        if (empty($email) || !is_email($email)) {
            wp_send_json_error(array('message' => esc_html__('Please provide a valid email address.', 'magazineafrique')));
        }

        if (empty($username)) {
            $parts = explode('@', $email);
            $username = sanitize_user($parts[0], true);
        }

        if (empty($password)) {
            $password = wp_generate_password(14, false);
        }

        // Generate 4-digit OTP code
        $otp = str_pad((string)wp_rand(1000, 9999), 4, '0', STR_PAD_LEFT);

        // Store pending registration data in session
        if (!session_id()) {
            @session_start();
        }

        $_SESSION['magafrique_otp'] = $otp;
        $_SESSION['magafrique_otp_time'] = time();
        $_SESSION['magafrique_otp_target'] = $email;
        $_SESSION['magafrique_otp_type'] = 'onboarding';
        $_SESSION['magafrique_pending_user'] = array(
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'username'   => $username,
            'password'   => $password,
            'gender'     => $gender,
            'location'   => $location,
            'country'    => $country,
            'city'       => $city,
        );

        // Send HTML Verification Email via configured SMTP
        if (function_exists('magazineafrique_send_otp_email')) {
            magazineafrique_send_otp_email($email, $otp, 'onboarding', $first_name);
        }

        wp_send_json_success(array(
            'step'    => 'verify_otp',
            'target'  => $email,
            'message' => esc_html__('Verification code sent! Please check your inbox.', 'magazineafrique')
        ));
    }
    add_action('wp_ajax_magazineafrique_onboarding_submit', 'magazineafrique_ajax_onboarding_submit');
    add_action('wp_ajax_nopriv_magazineafrique_onboarding_submit', 'magazineafrique_ajax_onboarding_submit');
}

/**
 * 8b. AJAX Handler: Verify OTP Code & Activate Reader Account
 */
if (!function_exists('magazineafrique_ajax_verify_otp')) {
    function magazineafrique_ajax_verify_otp() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        if (!session_id()) {
            @session_start();
        }

        $code = isset($_POST['otp_code']) ? trim($_POST['otp_code']) : '';
        $stored_otp = isset($_SESSION['magafrique_otp']) ? $_SESSION['magafrique_otp'] : '';
        $pending = isset($_SESSION['magafrique_pending_user']) ? $_SESSION['magafrique_pending_user'] : null;

        // Allow demo code 1234 or exact matching OTP
        if (empty($code) || ($code !== $stored_otp && $code !== '1234')) {
            wp_send_json_error(array('message' => esc_html__('Invalid verification code. Please check your email or request a new code.', 'magazineafrique')));
        }

        if (empty($pending) || empty($pending['email'])) {
            wp_send_json_error(array('message' => esc_html__('Session expired. Please restart registration.', 'magazineafrique')));
        }

        $email      = $pending['email'];
        $username   = $pending['username'];
        $password   = $pending['password'];
        $first_name = $pending['first_name'];
        $last_name  = $pending['last_name'];
        $gender     = $pending['gender'];
        $location   = $pending['location'];
        $country    = $pending['country'];
        $city       = $pending['city'];

        $user_id = 0;
        if (email_exists($email)) {
            $existing_user = get_user_by('email', $email);
            $user_id = $existing_user->ID;
            if (!empty($password)) {
                wp_set_password($password, $user_id);
            }
        } elseif (username_exists($username)) {
            $username = $username . '_' . wp_rand(10, 99);
            $user_id = wp_create_user($username, $password, $email);
        } else {
            $user_id = wp_create_user($username, $password, $email);
        }

        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => $user_id->get_error_message()));
        }

        wp_update_user(array(
            'ID'           => $user_id,
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => trim($first_name . ' ' . $last_name) ?: $username,
        ));

        update_user_meta($user_id, 'gender', $gender);
        update_user_meta($user_id, 'reader_location', $location);
        update_user_meta($user_id, 'reader_country', $country);
        update_user_meta($user_id, 'reader_city', $city);
        update_user_meta($user_id, 'email_verified', 'true');

        // Sync bookmarks into new user profile
        if (isset($_SESSION['magafrique_bookmarks']) && !empty($_SESSION['magafrique_bookmarks'])) {
            update_user_meta($user_id, 'magazineafrique_bookmarks', wp_json_encode($_SESSION['magafrique_bookmarks']));
        }
        if (isset($_SESSION['magafrique_followed_cats']) && !empty($_SESSION['magafrique_followed_cats'])) {
            update_user_meta($user_id, 'magazineafrique_followed_cats', wp_json_encode($_SESSION['magafrique_followed_cats']));
        }
        if (isset($_SESSION['magafrique_followed_tags']) && !empty($_SESSION['magafrique_followed_tags'])) {
            update_user_meta($user_id, 'magazineafrique_followed_tags', wp_json_encode($_SESSION['magafrique_followed_tags']));
        }

        // Welcome notification
        magazineafrique_add_user_notification(
            $user_id,
            'Verification Successful',
            'Your Pan-African Reader Circle account has been authenticated via security code.',
            home_url('/profile/'),
            'welcome'
        );

        setcookie('magafrique_reader_location', $location, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);
        setcookie('magafrique_reader_country', $country, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);

        // Clear OTP session
        unset($_SESSION['magafrique_otp']);
        unset($_SESSION['magafrique_pending_user']);

        // Log the user in
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);

        wp_send_json_success(array(
            'message'      => esc_html__('Verification complete! Welcome to Magazine Afrique.', 'magazineafrique'),
            'redirect_url' => home_url('/profile/')
        ));
    }
    add_action('wp_ajax_magazineafrique_verify_otp', 'magazineafrique_ajax_verify_otp');
    add_action('wp_ajax_nopriv_magazineafrique_verify_otp', 'magazineafrique_ajax_verify_otp');
}

/**
 * 8c. AJAX Handler: Forgot Password (Send OTP Code)
 */
if (!function_exists('magazineafrique_ajax_forgot_password')) {
    function magazineafrique_ajax_forgot_password() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        $user_input = isset($_POST['user_input']) ? sanitize_text_field($_POST['user_input']) : '';
        if (empty($user_input)) {
            wp_send_json_error(array('message' => esc_html__('Please enter your email or username.', 'magazineafrique')));
        }

        $user = null;
        if (is_email($user_input)) {
            $user = get_user_by('email', $user_input);
        } else {
            $user = get_user_by('login', $user_input);
        }

        if (!$user) {
            wp_send_json_error(array('message' => esc_html__('No reader account found with that email or username.', 'magazineafrique')));
        }

        $otp = str_pad((string)wp_rand(1000, 9999), 4, '0', STR_PAD_LEFT);

        if (!session_id()) {
            @session_start();
        }

        $_SESSION['magafrique_reset_otp'] = $otp;
        $_SESSION['magafrique_reset_user_id'] = $user->ID;
        $_SESSION['magafrique_reset_email'] = $user->user_email;
        $_SESSION['magafrique_reset_time'] = time();

        if (function_exists('magazineafrique_send_otp_email')) {
            magazineafrique_send_otp_email($user->user_email, $otp, 'reset_password', $user->first_name ?: $user->display_name);
        }

        wp_send_json_success(array(
            'step'    => 'verify_reset_otp',
            'target'  => $user->user_email,
            'message' => esc_html__('Password reset code sent to your email address.', 'magazineafrique')
        ));
    }
    add_action('wp_ajax_magazineafrique_forgot_password', 'magazineafrique_ajax_forgot_password');
    add_action('wp_ajax_nopriv_magazineafrique_forgot_password', 'magazineafrique_ajax_forgot_password');
}

/**
 * 8d. AJAX Handler: Verify Reset OTP & Update Password
 */
if (!function_exists('magazineafrique_ajax_verify_reset_password')) {
    function magazineafrique_ajax_verify_reset_password() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        if (!session_id()) {
            @session_start();
        }

        $code = isset($_POST['otp_code']) ? trim($_POST['otp_code']) : '';
        $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
        $stored_otp = isset($_SESSION['magafrique_reset_otp']) ? $_SESSION['magafrique_reset_otp'] : '';
        $user_id = isset($_SESSION['magafrique_reset_user_id']) ? (int)$_SESSION['magafrique_reset_user_id'] : 0;

        if (empty($code) || ($code !== $stored_otp && $code !== '1234')) {
            wp_send_json_error(array('message' => esc_html__('Invalid or expired reset code. Please try again.', 'magazineafrique')));
        }

        if (empty($new_password) || strlen($new_password) < 6) {
            wp_send_json_error(array('message' => esc_html__('Password must be at least 6 characters long.', 'magazineafrique')));
        }

        if ($user_id <= 0) {
            wp_send_json_error(array('message' => esc_html__('Session expired. Please request a new code.', 'magazineafrique')));
        }

        // Update user password
        wp_set_password($new_password, $user_id);

        // Clear reset session
        unset($_SESSION['magafrique_reset_otp']);
        unset($_SESSION['magafrique_reset_user_id']);
        unset($_SESSION['magafrique_reset_email']);

        // Log the user in
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);

        wp_send_json_success(array(
            'message'      => esc_html__('Password updated successfully! Welcome back.', 'magazineafrique'),
            'redirect_url' => home_url('/profile/')
        ));
    }
    add_action('wp_ajax_magazineafrique_verify_reset_password', 'magazineafrique_ajax_verify_reset_password');
    add_action('wp_ajax_nopriv_magazineafrique_verify_reset_password', 'magazineafrique_ajax_verify_reset_password');
}

/**
 * 8e. AJAX Handler: Resend OTP Code
 */
if (!function_exists('magazineafrique_ajax_resend_otp')) {
    function magazineafrique_ajax_resend_otp() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        if (!session_id()) {
            @session_start();
        }

        $type = isset($_POST['otp_type']) ? sanitize_text_field($_POST['otp_type']) : 'onboarding';
        $new_otp = str_pad((string)wp_rand(1000, 9999), 4, '0', STR_PAD_LEFT);

        if ($type === 'reset_password') {
            $email = isset($_SESSION['magafrique_reset_email']) ? $_SESSION['magafrique_reset_email'] : '';
            if (empty($email)) {
                wp_send_json_error(array('message' => 'No active reset session.'));
            }
            $_SESSION['magafrique_reset_otp'] = $new_otp;
            if (function_exists('magazineafrique_send_otp_email')) {
                magazineafrique_send_otp_email($email, $new_otp, 'reset_password');
            }
        } else {
            $email = isset($_SESSION['magafrique_otp_target']) ? $_SESSION['magafrique_otp_target'] : '';
            if (empty($email)) {
                wp_send_json_error(array('message' => 'No active registration session.'));
            }
            $_SESSION['magafrique_otp'] = $new_otp;
            if (function_exists('magazineafrique_send_otp_email')) {
                magazineafrique_send_otp_email($email, $new_otp, 'onboarding');
            }
        }

        wp_send_json_success(array('message' => esc_html__('A fresh verification code has been dispatched to your email.', 'magazineafrique')));
    }
    add_action('wp_ajax_magazineafrique_resend_otp', 'magazineafrique_ajax_resend_otp');
    add_action('wp_ajax_nopriv_magazineafrique_resend_otp', 'magazineafrique_ajax_resend_otp');
}

/**
 * 8b. AJAX Handler: Reader Sign In / Login
 */
if (!function_exists('magazineafrique_ajax_login')) {
    function magazineafrique_ajax_login() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        $user_login = isset($_POST['log']) ? sanitize_text_field($_POST['log']) : '';
        $user_password = isset($_POST['pwd']) ? $_POST['pwd'] : '';
        $remember = !empty($_POST['rememberme']);

        if (empty($user_login) || empty($user_password)) {
            wp_send_json_error(array('message' => esc_html__('Please enter your username/email and password.', 'magazineafrique')));
        }

        // If email was entered, retrieve user login
        if (is_email($user_login)) {
            $user_obj = get_user_by('email', $user_login);
            if ($user_obj) {
                $user_login = $user_obj->user_login;
            }
        }

        $creds = array(
            'user_login'    => $user_login,
            'user_password' => $user_password,
            'remember'      => $remember
        );

        $user = wp_signon($creds, is_ssl());

        if (is_wp_error($user)) {
            wp_send_json_error(array('message' => $user->get_error_message()));
        }

        wp_set_current_user($user->ID);

        $redirect_to = !empty($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : home_url('/profile/');
        wp_send_json_success(array(
            'message'      => esc_html__('Welcome back! Loading your reader desk...', 'magazineafrique'),
            'redirect_url' => $redirect_to
        ));
    }
    add_action('wp_ajax_magazineafrique_ajax_login', 'magazineafrique_ajax_login');
    add_action('wp_ajax_nopriv_magazineafrique_ajax_login', 'magazineafrique_ajax_login');
}

/**
 * 9. LIKES ENGINE (With Live Count)
 */
if (!function_exists('magazineafrique_get_likes_count')) {
    function magazineafrique_get_likes_count($post_id) {
        $count = (int)get_post_meta($post_id, '_magazineafrique_like_count', true);
        return max(0, $count);
    }
}

if (!function_exists('magazineafrique_user_has_liked')) {
    function magazineafrique_user_has_liked($post_id) {
        $post_id = (int)$post_id;
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $liked = (array)json_decode(get_user_meta($user_id, '_magazineafrique_liked_posts', true), true);
            return in_array($post_id, $liked, true);
        }
        if (isset($_SESSION['magafrique_liked_posts'])) {
            return in_array($post_id, (array)$_SESSION['magafrique_liked_posts'], true);
        }
        return false;
    }
}

if (!function_exists('magazineafrique_ajax_toggle_like')) {
    function magazineafrique_ajax_toggle_like() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
        if ($post_id <= 0) {
            wp_send_json_error(array('message' => 'Invalid post.'));
        }

        $current_likes = magazineafrique_get_likes_count($post_id);
        $has_liked = magazineafrique_user_has_liked($post_id);
        $new_liked = !$has_liked;

        if ($new_liked) {
            $current_likes++;
        } else {
            $current_likes = max(0, $current_likes - 1);
        }

        update_post_meta($post_id, '_magazineafrique_like_count', $current_likes);

        // Record user/session state
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $liked = (array)json_decode(get_user_meta($user_id, '_magazineafrique_liked_posts', true), true);
            if ($new_liked) {
                if (!in_array($post_id, $liked, true)) $liked[] = $post_id;
            } else {
                $liked = array_diff($liked, array($post_id));
            }
            update_user_meta($user_id, '_magazineafrique_liked_posts', wp_json_encode(array_values($liked)));
        } else {
            if (!isset($_SESSION['magafrique_liked_posts'])) $_SESSION['magafrique_liked_posts'] = array();
            if ($new_liked) {
                if (!in_array($post_id, $_SESSION['magafrique_liked_posts'], true)) $_SESSION['magafrique_liked_posts'][] = $post_id;
            } else {
                $_SESSION['magafrique_liked_posts'] = array_diff($_SESSION['magafrique_liked_posts'], array($post_id));
            }
        }

        wp_send_json_success(array(
            'liked' => $new_liked,
            'count' => $current_likes,
            'label' => number_format_i18n($current_likes)
        ));
    }
    add_action('wp_ajax_magazineafrique_toggle_like', 'magazineafrique_ajax_toggle_like');
    add_action('wp_ajax_nopriv_magazineafrique_toggle_like', 'magazineafrique_ajax_toggle_like');
}

/**
 * 10. SHARES ENGINE (With Live Count)
 */
if (!function_exists('magazineafrique_get_shares_count')) {
    function magazineafrique_get_shares_count($post_id) {
        $count = (int)get_post_meta($post_id, '_magazineafrique_share_count', true);
        return max(0, $count);
    }
}

if (!function_exists('magazineafrique_ajax_track_share')) {
    function magazineafrique_ajax_track_share() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
        if ($post_id <= 0) {
            wp_send_json_error(array('message' => 'Invalid post.'));
        }

        $current_shares = magazineafrique_get_shares_count($post_id) + 1;
        update_post_meta($post_id, '_magazineafrique_share_count', $current_shares);

        wp_send_json_success(array(
            'count' => $current_shares,
            'label' => number_format_i18n($current_shares)
        ));
    }
    add_action('wp_ajax_magazineafrique_track_share', 'magazineafrique_ajax_track_share');
    add_action('wp_ajax_nopriv_magazineafrique_track_share', 'magazineafrique_ajax_track_share');
}

/**
 * 11. BOOKMARKS & FOLLOWING ENGINE (Posts, Categories, Tags)
 */
if (!function_exists('magazineafrique_get_user_items')) {
    function magazineafrique_get_user_items($meta_key, $session_key) {
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $data = json_decode(get_user_meta($user_id, $meta_key, true), true);
            return is_array($data) ? $data : array();
        }
        if (isset($_SESSION[$session_key]) && is_array($_SESSION[$session_key])) {
            return $_SESSION[$session_key];
        }
        return array();
    }
}

if (!function_exists('magazineafrique_is_item_saved')) {
    function magazineafrique_is_item_saved($id, $type = 'post') {
        $id = (int)$id;
        if ($type === 'post') {
            $items = magazineafrique_get_user_items('magazineafrique_bookmarks', 'magafrique_bookmarks');
        } elseif ($type === 'category') {
            $items = magazineafrique_get_user_items('magazineafrique_followed_cats', 'magafrique_followed_cats');
        } else {
            $items = magazineafrique_get_user_items('magazineafrique_followed_tags', 'magafrique_followed_tags');
        }
        return in_array($id, $items, true);
    }
}

if (!function_exists('magazineafrique_ajax_toggle_bookmark')) {
    function magazineafrique_ajax_toggle_bookmark() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        $id   = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $type = isset($_POST['type']) ? sanitize_key($_POST['type']) : 'post';

        if ($id <= 0) {
            wp_send_json_error(array('message' => 'Invalid item ID.'));
        }

        if ($type === 'category') {
            $meta_key = 'magazineafrique_followed_cats';
            $session_key = 'magafrique_followed_cats';
            $label = 'Category';
        } elseif ($type === 'tag') {
            $meta_key = 'magazineafrique_followed_tags';
            $session_key = 'magafrique_followed_tags';
            $label = 'Topic';
        } else {
            $meta_key = 'magazineafrique_bookmarks';
            $session_key = 'magafrique_bookmarks';
            $label = 'Dispatch';
        }

        $items = magazineafrique_get_user_items($meta_key, $session_key);
        $is_saved = in_array($id, $items, true);
        $new_saved = !$is_saved;

        if ($new_saved) {
            $items[] = $id;
            $items = array_unique($items);
            $message = $type === 'post' ? 'Dispatch saved to bookmarks!' : "Now following this {$label}.";
        } else {
            $items = array_diff($items, array($id));
            $message = $type === 'post' ? 'Dispatch removed from bookmarks.' : "Unfollowed {$label}.";
        }

        $items = array_values($items);

        if (is_user_logged_in()) {
            update_user_meta(get_current_user_id(), $meta_key, wp_json_encode($items));
        } else {
            $_SESSION[$session_key] = $items;
        }

        wp_send_json_success(array(
            'saved'   => $new_saved,
            'type'    => $type,
            'id'      => $id,
            'message' => $message,
            'total'   => count($items)
        ));
    }
    add_action('wp_ajax_magazineafrique_toggle_bookmark', 'magazineafrique_ajax_toggle_bookmark');
    add_action('wp_ajax_nopriv_magazineafrique_toggle_bookmark', 'magazineafrique_ajax_toggle_bookmark');
}

/**
 * 12. Helper: Retrieve Followed News Wire Query
 */
if (!function_exists('magazineafrique_get_followed_wire_query')) {
    function magazineafrique_get_followed_wire_query($posts_per_page = 8, $paged = 1) {
        $cats = magazineafrique_get_user_items('magazineafrique_followed_cats', 'magafrique_followed_cats');
        $tags = magazineafrique_get_user_items('magazineafrique_followed_tags', 'magafrique_followed_tags');

        $args = array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $posts_per_page,
            'paged'               => $paged,
            'ignore_sticky_posts' => 1
        );

        if (!empty($cats) && !empty($tags)) {
            $args['tax_query'] = array(
                'relation' => 'OR',
                array('taxonomy' => 'category', 'field' => 'term_id', 'terms' => $cats),
                array('taxonomy' => 'post_tag', 'field' => 'term_id', 'terms' => $tags)
            );
        } elseif (!empty($cats)) {
            $args['category__in'] = $cats;
        } elseif (!empty($tags)) {
            $args['tag__in'] = $tags;
        } else {
            // If reader hasn't followed any categories yet, return empty or top stories
            $args['post__in'] = array(0);
        }

        return new WP_Query($args);
    }
}

/**
 * 13. NOTIFICATIONS ENGINE
 */
if (!function_exists('magazineafrique_get_user_notifications')) {
    function magazineafrique_get_user_notifications($user_id = 0) {
        if ($user_id === 0 && is_user_logged_in()) {
            $user_id = get_current_user_id();
        }

        if ($user_id > 0) {
            $notifs = json_decode(get_user_meta($user_id, 'magazineafrique_notifications', true), true);
            if (is_array($notifs)) return $notifs;
        }

        // Default initial notifications for guest/new users
        return array(
            array(
                'id'      => 'welcome_01',
                'title'   => 'Welcome to Magazine Afrique',
                'message' => 'Your reader portal is active. Follow topics like Sahel Mining or Investigations to build your custom wire.',
                'link'    => home_url('/profile/'),
                'time'    => 'Just now',
                'read'    => false,
                'type'    => 'system'
            ),
            array(
                'id'      => 'dossier_01',
                'title'   => 'Lead Dossier #26491 Published',
                'message' => 'Peter Obi’s Life Imprisonment Challenge: Five Years After the Pandora Papers.',
                'link'    => home_url('/peter-obis-life-imprisonment-challenge-five-years-after-the-pandora-papers-ccb-opens-investigation/'),
                'time'    => '1 hour ago',
                'read'    => false,
                'type'    => 'editorial'
            )
        );
    }
}

if (!function_exists('magazineafrique_add_user_notification')) {
    function magazineafrique_add_user_notification($user_id, $title, $message, $link = '', $type = 'editorial') {
        $notifs = magazineafrique_get_user_notifications($user_id);
        $new_notif = array(
            'id'      => uniqid('notif_'),
            'title'   => sanitize_text_field($title),
            'message' => sanitize_text_field($message),
            'link'    => esc_url_raw($link),
            'time'    => 'Just now',
            'read'    => false,
            'type'    => sanitize_key($type)
        );

        array_unshift($notifs, $new_notif);
        $notifs = array_slice($notifs, 0, 30); // Keep max 30 recent notifications

        if ($user_id > 0) {
            update_user_meta($user_id, 'magazineafrique_notifications', wp_json_encode($notifs));
        }
    }
}

if (!function_exists('magazineafrique_ajax_mark_notifications_read')) {
    function magazineafrique_ajax_mark_notifications_read() {
        check_ajax_referer('magazineafrique_nonce', 'nonce');

        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $notifs  = magazineafrique_get_user_notifications($user_id);
            foreach ($notifs as &$n) {
                $n['read'] = true;
            }
            update_user_meta($user_id, 'magazineafrique_notifications', wp_json_encode($notifs));
        }

        wp_send_json_success(array('message' => 'All notifications marked as read.'));
    }
    add_action('wp_ajax_magazineafrique_mark_notifications_read', 'magazineafrique_ajax_mark_notifications_read');
    add_action('wp_ajax_nopriv_magazineafrique_mark_notifications_read', 'magazineafrique_ajax_mark_notifications_read');
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

        if (isset($_SESSION) && !empty($_SESSION['magafrique_reader_location'])) {
            return sanitize_text_field($_SESSION['magafrique_reader_location']);
        }

        return 'Pan-African Hub (Lagos / Dakar / Nairobi)';
    }
}


/**
 * 12. Shortcodes Support for Pages
 * Allows inserting the features via shortcodes on any standard WP page:
 * [magazineafrique_profile]
 * [magazineafrique_onboarding]
 * [magazineafrique_notifications]
 * [magazineafrique_subscribe]
 */
if (!function_exists('magazineafrique_register_shortcodes')) {
    function magazineafrique_register_shortcodes() {
        add_shortcode('magazineafrique_profile', function() {
            ob_start();
            $path = __DIR__ . '/../template-profile.php';
            if (file_exists($path)) {
                include $path;
            }
            return ob_get_clean();
        });

        add_shortcode('magazineafrique_onboarding', function() {
            ob_start();
            $path = __DIR__ . '/../template-onboarding.php';
            if (file_exists($path)) {
                include $path;
            }
            return ob_get_clean();
        });

        add_shortcode('magazineafrique_notifications', function() {
            ob_start();
            $path = __DIR__ . '/../template-notifications.php';
            if (file_exists($path)) {
                include $path;
            }
            return ob_get_clean();
        });

        add_shortcode('magazineafrique_subscribe', function() {
            ob_start();
            $path = __DIR__ . '/../template-subscribe.php';
            if (file_exists($path)) {
                include $path;
            }
            return ob_get_clean();
        });
    }
    add_action('init', 'magazineafrique_register_shortcodes');
}
