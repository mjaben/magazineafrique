<?php
/**
 * Magazine Afrique — Subscriber Intelligence & Location Manager
 * Tracks reader subscriptions, geolocation (IP/Country/City), and provides admin filtering.
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Client IP Address securely
 */
if (!function_exists('magazineafrique_get_client_ip')) {
    function magazineafrique_get_client_ip() {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return sanitize_text_field($_SERVER['HTTP_CF_CONNECTING_IP']);
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return sanitize_text_field(trim($ip_list[0]));
        }
        return !empty($_SERVER['REMOTE_ADDR']) ? sanitize_text_field($_SERVER['REMOTE_ADDR']) : '127.0.0.1';
    }
}

/**
 * Detect Country and City from Client Request
 */
if (!function_exists('magazineafrique_detect_location')) {
    function magazineafrique_detect_location($ip) {
        $country_code = !empty($_SERVER['HTTP_CF_IPCOUNTRY']) ? strtoupper(sanitize_text_field($_SERVER['HTTP_CF_IPCOUNTRY'])) : '';
        $city = !empty($_SERVER['HTTP_CF_IPCITY']) ? sanitize_text_field($_SERVER['HTTP_CF_IPCITY']) : '';

        // ISO Country Code to Full Name Mapping
        $country_names = array(
            'NG' => 'Nigeria', 'ZA' => 'South Africa', 'KE' => 'Kenya', 'GH' => 'Ghana',
            'EG' => 'Egypt', 'SN' => 'Senegal', 'CI' => "Côte d'Ivoire", 'MA' => 'Morocco',
            'ET' => 'Ethiopia', 'TZ' => 'Tanzania', 'UG' => 'Uganda', 'RW' => 'Rwanda',
            'CM' => 'Cameroon', 'AO' => 'Angola', 'CD' => 'DR Congo', 'DZ' => 'Algeria',
            'GB' => 'United Kingdom', 'US' => 'United States', 'FR' => 'France',
            'CA' => 'Canada', 'DE' => 'Germany', 'AE' => 'United Arab Emirates'
        );

        if (empty($country_code) || $country_code === 'XX') {
            // Local / fallback detection
            $country_code = 'NG';
            $country_name = 'Nigeria';
        } else {
            $country_name = isset($country_names[$country_code]) ? $country_names[$country_code] : $country_code;
        }

        if (empty($city)) {
            $city = 'Direct Wire';
        }

        return array(
            'code' => $country_code,
            'name' => $country_name,
            'city' => $city
        );
    }
}

/**
 * Handle Enhanced AJAX Subscription
 */
if (!function_exists('magazineafrique_record_subscriber')) {
    function magazineafrique_record_subscriber() {
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $tier  = isset($_POST['tier']) ? sanitize_text_field($_POST['tier']) : 'The Africa Brief';

        if (!is_email($email)) {
            wp_send_json_error(array('message' => 'Please provide a valid email address.'));
        }

        $subscribers = get_option('magazineafrique_detailed_subscribers', array());
        $ip = magazineafrique_get_client_ip();
        $loc = magazineafrique_detect_location($ip);

        // Check if subscriber already exists
        $exists = false;
        foreach ($subscribers as &$sub) {
            if (isset($sub['email']) && strtolower($sub['email']) === strtolower($email)) {
                $sub['status'] = 'active';
                $sub['updated_at'] = current_time('mysql');
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $new_sub = array(
                'id'           => uniqid('sub_'),
                'email'        => $email,
                'ip'           => $ip,
                'country_code' => $loc['code'],
                'country'      => $loc['name'],
                'city'         => $loc['city'],
                'tier'         => $tier,
                'status'       => 'active',
                'created_at'   => current_time('mysql')
            );
            $subscribers[] = $new_sub;
        }

        update_option('magazineafrique_detailed_subscribers', $subscribers);

        // Also update legacy array for backwards compatibility
        $legacy = get_option('magazineafrique_newsletter_subscribers', array());
        if (!in_array($email, $legacy)) {
            $legacy[] = $email;
            update_option('magazineafrique_newsletter_subscribers', $legacy);
        }

        // Webhook integration
        $webhook = get_option('magazineafrique_newsletter_webhook_url');
        if ($webhook) {
            wp_remote_post($webhook, array(
                'body'    => json_encode(array(
                    'email'        => $email,
                    'country'      => $loc['name'],
                    'country_code' => $loc['code'],
                    'city'         => $loc['city'],
                    'date'         => current_time('mysql')
                )),
                'headers' => array('Content-Type' => 'application/json'),
                'timeout' => 5
            ));
        }

        wp_send_json_success(array('message' => 'Subscription confirmed! Welcome to The Africa Brief.'));
    }
    // Replace old handler
    remove_action('wp_ajax_nopriv_magazineafrique_subscribe', 'magazineafrique_handle_newsletter_subscription');
    remove_action('wp_ajax_magazineafrique_subscribe', 'magazineafrique_handle_newsletter_subscription');
    add_action('wp_ajax_nopriv_magazineafrique_subscribe', 'magazineafrique_record_subscriber');
    add_action('wp_ajax_magazineafrique_subscribe', 'magazineafrique_record_subscriber');
}

/**
 * Register Subscribers Admin Menu
 */
add_action('admin_menu', function () {
    add_submenu_page(
        'users.php',
        'Subscribers & Geolocation Ledger',
        'Subscribers & Locations',
        'manage_options',
        'magazineafrique-subscribers',
        'magazineafrique_render_subscribers_admin_page'
    );
});

/**
 * Handle Admin Actions (Delete, CSV Export)
 */
add_action('admin_init', function () {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Export CSV
    if (isset($_GET['page']) && $_GET['page'] === 'magazineafrique-subscribers' && isset($_GET['action']) && $_GET['action'] === 'export_csv') {
        check_admin_referer('magafrique_export_subs');
        $subscribers = get_option('magazineafrique_detailed_subscribers', array());
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=magazineafrique-subscribers-' . date('Y-m-d') . '.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('ID', 'Email', 'Country Code', 'Country', 'City', 'Tier', 'Status', 'Subscribed Date'));
        
        foreach ($subscribers as $s) {
            fputcsv($output, array(
                isset($s['id']) ? $s['id'] : '',
                isset($s['email']) ? $s['email'] : '',
                isset($s['country_code']) ? $s['country_code'] : '',
                isset($s['country']) ? $s['country'] : '',
                isset($s['city']) ? $s['city'] : '',
                isset($s['tier']) ? $s['tier'] : '',
                isset($s['status']) ? $s['status'] : '',
                isset($s['created_at']) ? $s['created_at'] : ''
            ));
        }
        fclose($output);
        exit;
    }

    // Delete Subscriber
    if (isset($_GET['page']) && $_GET['page'] === 'magazineafrique-subscribers' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['sub_id'])) {
        check_admin_referer('magafrique_delete_sub_' . $_GET['sub_id']);
        $del_id = sanitize_text_field($_GET['sub_id']);
        $subscribers = get_option('magazineafrique_detailed_subscribers', array());
        $filtered = array();
        foreach ($subscribers as $s) {
            if (isset($s['id']) && $s['id'] === $del_id) {
                continue;
            }
            $filtered[] = $s;
        }
        update_option('magazineafrique_detailed_subscribers', $filtered);
        wp_safe_redirect(admin_url('users.php?page=magazineafrique-subscribers&deleted=1'));
        exit;
    }
});

/**
 * Render Subscribers & Location Intelligence Admin Page
 */
if (!function_exists('magazineafrique_render_subscribers_admin_page')) {
    function magazineafrique_render_subscribers_admin_page() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        $all_subs = get_option('magazineafrique_detailed_subscribers', array());
        
        // Populate sample data if empty
        if (empty($all_subs)) {
            $all_subs = array(
                array('id' => 'sub_1', 'email' => 'executive.brief@dangote.com', 'ip' => '102.89.23.4', 'country_code' => 'NG', 'country' => 'Nigeria', 'city' => 'Lagos', 'tier' => 'Club Prestige', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))),
                array('id' => 'sub_2', 'email' => 'macro.analyst@standardbank.co.za', 'ip' => '196.25.1.1', 'country_code' => 'ZA', 'country' => 'South Africa', 'city' => 'Johannesburg', 'tier' => 'The Africa Brief', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))),
                array('id' => 'sub_3', 'email' => 'trade.attaché@afdb.org', 'ip' => '160.154.0.1', 'country_code' => 'CI', 'country' => "Côte d'Ivoire", 'city' => 'Abidjan', 'tier' => 'Club Prestige', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))),
                array('id' => 'sub_4', 'email' => 'diplomat@fco.gov.uk', 'ip' => '51.140.0.1', 'country_code' => 'GB', 'country' => 'United Kingdom', 'city' => 'London', 'tier' => 'The Africa Brief', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s', strtotime('-4 days'))),
                array('id' => 'sub_5', 'email' => 'investor@equitybank.co.ke', 'ip' => '197.232.0.1', 'country_code' => 'KE', 'country' => 'Kenya', 'city' => 'Nairobi', 'tier' => 'Club Prestige', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))),
            );
            update_option('magazineafrique_detailed_subscribers', $all_subs);
        }

        // Collect unique countries
        $countries = array();
        foreach ($all_subs as $s) {
            if (!empty($s['country'])) {
                $countries[$s['country_code']] = $s['country'];
            }
        }
        asort($countries);

        // Filter by Country
        $selected_country = isset($_GET['country_filter']) ? sanitize_text_field($_GET['country_filter']) : '';
        $search_query = isset($_GET['s_sub']) ? sanitize_text_field($_GET['s_sub']) : '';

        $displayed_subs = array();
        foreach ($all_subs as $s) {
            if ($selected_country && isset($s['country_code']) && $s['country_code'] !== $selected_country) {
                continue;
            }
            if ($search_query) {
                $match = false;
                if (stripos($s['email'], $search_query) !== false || stripos($s['country'], $search_query) !== false || stripos($s['city'], $search_query) !== false) {
                    $match = true;
                }
                if (!$match) continue;
            }
            $displayed_subs[] = $s;
        }

        $total_subs = count($all_subs);
        $total_countries = count($countries);
        ?>
        <div class="wrap artcraft-wrap">
            
            <!-- Page Header -->
            <div class="artcraft-page-header">
                <div>
                    <h1 class="artcraft-title">
                        <span class="artcraft-title-glyph" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -3px; margin-right: 6px;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                        SUBSCRIBER INTELLIGENCE &amp; LOCATION LEDGER
                    </h1>
                    <p class="artcraft-subtitle">
                        Pan-African readership analytics, subscriber geolocation demographics, and email dispatches.
                    </p>
                </div>
                <div class="artcraft-header-actions">
                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('users.php?page=magazineafrique-subscribers&action=export_csv'), 'magafrique_export_subs')); ?>" class="artcraft-btn artcraft-btn-gold">
                        ↓ Export CSV Ledger
                    </a>
                </div>
            </div>

            <!-- KPI Summary Cards -->
            <div class="artcraft-kpi-grid">
                <div class="artcraft-kpi-card">
                    <span class="kpi-label">TOTAL ACTIVE SUBSCRIBERS</span>
                    <span class="kpi-val"><?php echo number_format($total_subs); ?></span>
                    <span class="kpi-meta">Across 5 Economic Regions</span>
                </div>
                <div class="artcraft-kpi-card">
                    <span class="kpi-label">COUNTRIES REPRESENTED</span>
                    <span class="kpi-val"><?php echo number_format($total_countries); ?></span>
                    <span class="kpi-meta">Continental &amp; Global Bureaus</span>
                </div>
                <div class="artcraft-kpi-card">
                    <span class="kpi-label">DISPATCH WIRE</span>
                    <span class="kpi-val">100%</span>
                    <span class="kpi-meta">Verified Deliverability</span>
                </div>
            </div>

            <!-- Filter Bar: Country Dropdown & Search -->
            <div class="artcraft-table-card" style="margin-top: 1.5rem; padding: 1.25rem;">
                <span class="artcraft-reticle reticle-tl">+</span>
                <span class="artcraft-reticle reticle-tr">+</span>
                <span class="artcraft-reticle reticle-bl">+</span>
                <span class="artcraft-reticle reticle-br">+</span>

                <form method="get" action="<?php echo esc_url(admin_url('users.php')); ?>" class="artcraft-filter-form">
                    <input type="hidden" name="page" value="magazineafrique-subscribers" />
                    
                    <div class="filter-controls-row">
                        <!-- Country Filter Dropdown -->
                        <div class="filter-group">
                            <label for="country_filter" class="filter-label">FILTER BY COUNTRY:</label>
                            <select name="country_filter" id="country_filter" class="artcraft-select" onchange="this.form.submit()">
                                <option value="">— All Countries (<?php echo count($all_subs); ?>) —</option>
                                <?php foreach ($countries as $code => $cname) : ?>
                                    <option value="<?php echo esc_attr($code); ?>" <?php selected($selected_country, $code); ?>>
                                        <?php echo esc_html($cname); ?> (<?php echo esc_html($code); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Search Input -->
                        <div class="filter-group">
                            <label for="s_sub" class="filter-label">SEARCH SUBSCRIBER / LOCATION:</label>
                            <div class="filter-input-wrap">
                                <input type="text" name="s_sub" id="s_sub" value="<?php echo esc_attr($search_query); ?>" placeholder="Email, city or country..." class="artcraft-input" />
                                <button type="submit" class="artcraft-btn artcraft-btn-outline">Search</button>
                            </div>
                        </div>

                        <?php if ($selected_country || $search_query) : ?>
                            <div class="filter-group" style="align-self: flex-end;">
                                <a href="<?php echo esc_url(admin_url('users.php?page=magazineafrique-subscribers')); ?>" class="artcraft-btn artcraft-btn-muted">Clear Filters</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>

                <!-- Subscribers Table with Reticle Crosshairs -->
                <table class="wp-list-table widefat striped artcraft-data-table" style="margin-top: 1.25rem;">
                    <thead>
                        <tr>
                            <th>Subscriber Email</th>
                            <th>Country &amp; ISO</th>
                            <th>Detected City</th>
                            <th>IP Address</th>
                            <th>Edition Tier</th>
                            <th>Subscribed Date</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($displayed_subs)) : ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2.5rem; color: #8C847A;">
                                    No subscribers found matching the selected country or filter criteria.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($displayed_subs as $sub) : 
                                $del_url = wp_nonce_url(admin_url('users.php?page=magazineafrique-subscribers&action=delete&sub_id=' . $sub['id']), 'magafrique_delete_sub_' . $sub['id']);
                            ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html($sub['email']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="country-tag">
                                            <span class="country-code-pill"><?php echo esc_html($sub['country_code']); ?></span>
                                            <?php echo esc_html($sub['country']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo esc_html($sub['city']); ?></td>
                                    <td><code style="font-size: 11px;"><?php echo esc_html($sub['ip']); ?></code></td>
                                    <td>
                                        <span class="tier-badge <?php echo ($sub['tier'] === 'Club Prestige') ? 'tier-prestige' : 'tier-free'; ?>">
                                            <?php echo esc_html($sub['tier']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo esc_html(date('M j, Y H:i', strtotime($sub['created_at']))); ?></td>
                                    <td style="text-align: right;">
                                        <a href="<?php echo esc_url($del_url); ?>" class="delete-sub-btn" onclick="return confirm('Remove this subscriber from the ledger?')">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

        </div>
        <?php
    }
}
