<?php
/**
 * Magazine Afrique — Brand Reach Ad Inventory & CPM Booking Engine
 * 
 * Rules:
 * - Brand Reach Only (Cost Per Mille / 1,000 Impressions model).
 * - Higher fees for good/premium spots (Masthead, Mid-Article) than lower spots (Bottom).
 * - Baseline CPM: ₦5,000 / 1,000 impressions.
 * - Spot Tiers:
 *   1. Prime Masthead Leaderboard (Top):       ₦10,000 ($10.00) / 1,000 impressions
 *   2. Mid-Dossier In-Article (Core Read):      ₦8,000  ($8.00)  / 1,000 impressions
 *   3. Continental Telegraph Sidebar (Sticky):  ₦6,500  ($6.50)  / 1,000 impressions
 *   4. Broadsheet Bottom Leaderboard (Footer):  ₦5,000  ($5.00)  / 1,000 impressions
 * 
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Database Table Setup for Brand Reach Campaigns
 */
if (!function_exists('magazineafrique_setup_ad_campaigns_table')) {
    function magazineafrique_setup_ad_campaigns_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            booking_code varchar(32) NOT NULL,
            brand_name varchar(255) NOT NULL,
            contact_name varchar(255) NOT NULL,
            contact_email varchar(255) NOT NULL,
            contact_phone varchar(64) DEFAULT '',
            country varchar(100) DEFAULT '',
            spot varchar(64) NOT NULL,
            spot_title varchar(255) NOT NULL,
            cpm_rate decimal(10,2) NOT NULL,
            currency varchar(10) DEFAULT 'NGN',
            impressions_booked bigint(20) NOT NULL,
            impressions_served bigint(20) DEFAULT 0,
            clicks bigint(20) DEFAULT 0,
            total_amount decimal(12,2) NOT NULL,
            creative_url text NOT NULL,
            destination_url text NOT NULL,
            target_desk varchar(100) DEFAULT 'all',
            start_date date DEFAULT NULL,
            status varchar(32) DEFAULT 'pending_review',
            payment_status varchar(32) DEFAULT 'unpaid',
            admin_notes text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY booking_code (booking_code),
            KEY spot_status (spot, status)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
    add_action('after_switch_theme', 'magazineafrique_setup_ad_campaigns_table');
    // Ensure table exists on init if missing
    add_action('admin_init', function() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            magazineafrique_setup_ad_campaigns_table();
        }
    });
}

/**
 * 1b. Official Commercial Remittance & Bank Settlement Details
 * Eco Bank | Magazine Afrique Limited | 0089765434
 * Receipt Submission Hotline: 09082533705 on WhatsApp
 */
if (!function_exists('magazineafrique_get_ad_bank_details')) {
    function magazineafrique_get_ad_bank_details() {
        return array(
            'bank_name'       => get_option('magafrique_ad_bank_name', 'Eco Bank'),
            'account_name'    => get_option('magafrique_ad_account_name', 'Magazine Afrique Limited'),
            'account_number'  => get_option('magafrique_ad_account_number', '0089765434'),
            'whatsapp_number' => get_option('magafrique_ad_whatsapp_number', '09082533705'),
            'whatsapp_intl'   => get_option('magafrique_ad_whatsapp_intl', '2349082533705'),
            'advisory'        => 'Send receipt to 09082533705 on WhatsApp for faster response on any issue.'
        );
    }
}

/**
 * 2. CPM Rate & Spot Inventory Matrix
 */
if (!function_exists('magazineafrique_get_ad_spots_matrix')) {
    function magazineafrique_get_ad_spots_matrix() {
        return array(
            'header_masthead' => array(
                'id'            => 'header_masthead',
                'title'         => 'Prime Masthead Leaderboard',
                'placement'     => 'Top of Masthead (Immediate Viewport)',
                'cpm_ngn'       => floatval(get_option('magafrique_cpm_header_masthead_ngn', 10000)),
                'cpm_usd'       => floatval(get_option('magafrique_cpm_header_masthead_usd', 10.00)),
                'tier'          => 'Prime Position',
                'badge'         => 'HIGHEST VISIBILITY',
                'dimensions'    => '728x90 / 970x90 Desktop · 320x50 Mobile',
                'description'   => 'Unmatched initial impact on every desktop, tablet, and mobile visit. Positioned directly below the dateline header.'
            ),
            'in_article' => array(
                'id'            => 'in_article',
                'title'         => 'Mid-Dossier Editorial Core',
                'placement'     => 'Embedded Within Investigative Articles',
                'cpm_ngn'       => floatval(get_option('magafrique_cpm_in_article_ngn', 8000)),
                'cpm_usd'       => floatval(get_option('magafrique_cpm_in_article_usd', 8.00)),
                'tier'          => 'Core Engagement',
                'badge'         => 'LONGEST DWELL TIME',
                'dimensions'    => 'Fluid Native / 300x250 Medium Rectangle',
                'description'   => 'High-attention interstitial placement inserted right after article lead paragraphs when reader focus is at its maximum peak.'
            ),
            'sidebar' => array(
                'id'            => 'sidebar',
                'title'         => 'Continental Telegraph Sidebar',
                'placement'     => 'Sticky Reading Companion (Desktop & Tablet)',
                'cpm_ngn'       => floatval(get_option('magafrique_cpm_sidebar_ngn', 6500)),
                'cpm_usd'       => floatval(get_option('magafrique_cpm_sidebar_usd', 6.50)),
                'tier'          => 'Persistent Reach',
                'badge'         => 'HIGH VIEWABILITY',
                'dimensions'    => '300x250 / 300x600 Half-Page Box',
                'description'   => 'Stays persistently in reader view as visitors scroll through real-time intelligence feeds and long-form analysis.'
            ),
            'bottom' => array(
                'id'            => 'bottom',
                'title'         => 'Broadsheet Bottom Leaderboard',
                'placement'     => 'Above Footer (All Reports & Home)',
                'cpm_ngn'       => floatval(get_option('magafrique_cpm_bottom_ngn', 5000)),
                'cpm_usd'       => floatval(get_option('magafrique_cpm_bottom_usd', 5.00)),
                'tier'          => 'Baseline Reach',
                'badge'         => 'BASE RATE',
                'dimensions'    => '728x90 / 970x90 Desktop · 300x250 Mobile',
                'description'   => 'Broadsheet full-width closing placement seen by all engaged readers completing briefings, dispatches, and sector archives.'
            )
        );
    }
}

/**
 * 2b. 5-Hour Space Rotation Balancer (Google Ads vs Sponsored Ads)
 * 
 * Rules:
 * - We cannot show Google Ads and Sponsored Ads in the same spot simultaneously.
 * - Advertisers are buying space normally occupied by Google Ads.
 * - Sponsored Ads CANNOT occupy all ad spaces across the site at once — Google Ads must still run to maintain revenue.
 * - Space is rotated in balanced 5-hour shifts:
 *   Shift Alpha (even 5-hr blocks): Header, Article 2, and Bottom = Direct Sponsored; Article 1 and Sidebar = Google Ads.
 *   Shift Beta (odd 5-hr blocks): Article 1 and Sidebar = Direct Sponsored; Header, Article 2, and Bottom = Google Ads.
 * - Automatically resets/cycles every 5 hours!
 * - Any direct spot with no active campaign seamlessly falls back to Google Ads.
 */
if (!function_exists('magazineafrique_get_ad_rotation_state')) {
    function magazineafrique_get_ad_rotation_state() {
        $period_hours = (int) get_option('magafrique_ad_rotation_period', 5);
        if ($period_hours < 1) {
            $period_hours = 5;
        }
        $window_seconds = $period_hours * HOUR_IN_SECONDS;
        $offset = (int) get_option('magafrique_ad_rotation_offset', 0);
        $mode = get_option('magafrique_ad_rotation_mode', 'balanced'); // 'balanced', 'force_direct', 'google_only'

        $now = time() + $offset;
        $cycle_number = (int) floor($now / $window_seconds);
        $elapsed_in_cycle = $now % $window_seconds;
        $seconds_remaining = $window_seconds - $elapsed_in_cycle;

        $hours_remaining = (int) floor($seconds_remaining / HOUR_IN_SECONDS);
        $minutes_remaining = (int) floor(($seconds_remaining % HOUR_IN_SECONDS) / MINUTE_IN_SECONDS);
        $secs_remaining = $seconds_remaining % MINUTE_IN_SECONDS;

        // Shift calculation: Even cycle = Shift Alpha, Odd cycle = Shift Beta
        $shift = ($cycle_number % 2 === 0) ? 'alpha' : 'beta';

        $zones = array(
            'header' => array(
                'title'       => 'Master Masthead Leaderboard',
                'spot_key'    => 'header_masthead',
                'shift_group' => 'alpha',
                'active_mode' => ($shift === 'alpha') ? 'direct' : 'google',
            ),
            'article_1' => array(
                'title'       => 'Mid-Dossier Paragraph 3',
                'spot_key'    => 'in_article',
                'shift_group' => 'beta',
                'active_mode' => ($shift === 'beta') ? 'direct' : 'google',
            ),
            'article_2' => array(
                'title'       => 'Mid-Dossier Paragraph 7+',
                'spot_key'    => 'in_article',
                'shift_group' => 'alpha',
                'active_mode' => ($shift === 'alpha') ? 'direct' : 'google',
            ),
            'sidebar' => array(
                'title'       => 'Continental Telegraph Sidebar',
                'spot_key'    => 'sidebar',
                'shift_group' => 'beta',
                'active_mode' => ($shift === 'beta') ? 'direct' : 'google',
            ),
            'bottom' => array(
                'title'       => 'Broadsheet Bottom Leaderboard',
                'spot_key'    => 'bottom',
                'shift_group' => 'alpha',
                'active_mode' => ($shift === 'alpha') ? 'direct' : 'google',
            ),
        );

        if ($mode === 'force_direct') {
            foreach ($zones as $k => $z) {
                $zones[$k]['active_mode'] = 'direct';
            }
        } elseif ($mode === 'google_only') {
            foreach ($zones as $k => $z) {
                $zones[$k]['active_mode'] = 'google';
            }
        }

        return array(
            'period_hours'        => $period_hours,
            'window_seconds'      => $window_seconds,
            'cycle_number'        => $cycle_number,
            'shift'               => $shift,
            'shift_name'          => ($shift === 'alpha') ? 'Shift Alpha' : 'Shift Beta',
            'seconds_remaining'   => $seconds_remaining,
            'hours_remaining'     => $hours_remaining,
            'minutes_remaining'   => $minutes_remaining,
            'secs_remaining'      => $secs_remaining,
            'formatted_remaining' => sprintf('%02dh %02dm %02ds', $hours_remaining, $minutes_remaining, $secs_remaining),
            'mode'                => $mode,
            'zones'               => $zones,
        );
    }
}

/**
 * 2c. Check if a specific spot and zone is currently in its Direct Sponsored window
 */
if (!function_exists('magazineafrique_is_spot_in_direct_shift')) {
    function magazineafrique_is_spot_in_direct_shift($spot_key, $zone = '') {
        $state = magazineafrique_get_ad_rotation_state();
        if ($state['mode'] === 'google_only') {
            return false;
        }
        if ($state['mode'] === 'force_direct') {
            return true;
        }

        // Match by zone identifier if passed
        if (!empty($zone) && isset($state['zones'][$zone])) {
            return $state['zones'][$zone]['active_mode'] === 'direct';
        }

        // Match by spot key fallback
        if ($spot_key === 'header_masthead' || $spot_key === 'bottom') {
            return $state['shift'] === 'alpha';
        }
        if ($spot_key === 'sidebar') {
            return $state['shift'] === 'beta';
        }

        return true;
    }
}

/**
 * 3. Register Dedicated Top-Level Menu & Gazette Desk Submenu for Buy Ad Space
 */
if (!function_exists('magazineafrique_register_brand_ads_admin_menu')) {
    function magazineafrique_register_brand_ads_admin_menu() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';
        
        $pending_count = 0;
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
            $pending_count = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'pending_review' OR payment_status = 'unpaid'");
        }
        
        $badge = '';
        if ($pending_count > 0) {
            $badge = ' <span class="awaiting-mod update-plugins count-' . $pending_count . '" style="background:#D97706;color:#171513;border-radius:9999px;font-weight:900;padding:1px 6px;font-size:10px;"><span class="pending-count">' . $pending_count . '</span></span>';
        }

        // Dedicated Top-Level Menu in WP-Admin Sidebar
        add_menu_page(
            'Buy Ad Space — Brand Reach Monetization',
            'Buy Ad Space' . $badge,
            'manage_options',
            'magazineafrique-brand-ads',
            'magazineafrique_render_brand_ads_admin_page',
            'dashicons-megaphone',
            25
        );

        // Submenus under Top-Level
        add_submenu_page(
            'magazineafrique-brand-ads',
            'All Campaigns & Ledger',
            'All Campaigns' . $badge,
            'manage_options',
            'magazineafrique-brand-ads',
            'magazineafrique_render_brand_ads_admin_page'
        );

        add_submenu_page(
            'magazineafrique-brand-ads',
            'Commercial Bank & Remittance Desk',
            'Remittance (Eco Bank)',
            'manage_options',
            'magazineafrique-ad-bank',
            function() {
                $_GET['tab'] = 'bank';
                magazineafrique_render_brand_ads_admin_page();
            }
        );

        add_submenu_page(
            'magazineafrique-brand-ads',
            'CPM Rates & Ad Spots',
            'CPM Pricing & Spots',
            'manage_options',
            'magazineafrique-ad-rates',
            function() {
                $_GET['tab'] = 'rates';
                magazineafrique_render_brand_ads_admin_page();
            }
        );

        add_submenu_page(
            'magazineafrique-brand-ads',
            '5-Hour Ad Space Rotation Shift',
            '5-Hr Space Rotation',
            'manage_options',
            'magazineafrique-ad-rotation',
            function() {
                $_GET['tab'] = 'rotation';
                magazineafrique_render_brand_ads_admin_page();
            }
        );

        add_submenu_page(
            'magazineafrique-brand-ads',
            'Book Manual Campaign',
            '+ Book Manual Ad',
            'manage_options',
            'magazineafrique-ad-manual',
            function() {
                $_GET['tab'] = 'manual';
                magazineafrique_render_brand_ads_admin_page();
            }
        );

        // Also maintain under Gazette Desk
        add_submenu_page(
            'magazineafrique-desk',
            'Brand Reach Ads — Inventory & CPM Campaigns',
            'Buy Ad Space (Brand Reach)' . $badge,
            'manage_options',
            'magazineafrique-brand-ads',
            'magazineafrique_render_brand_ads_admin_page'
        );
    }
    add_action('admin_menu', 'magazineafrique_register_brand_ads_admin_menu', 20);
}

/**
 * 4. Render ArtCraft Dark Admin Management Dashboard for Brand Reach Ads
 */
if (!function_exists('magazineafrique_render_brand_ads_admin_page')) {
    function magazineafrique_render_brand_ads_admin_page() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';
        $spots = magazineafrique_get_ad_spots_matrix();
        $bank_details = magazineafrique_get_ad_bank_details();
        $rot_state = magazineafrique_get_ad_rotation_state();

        // ---------------------------------------------------------------------
        // Action: CSV Export (triggered before headers)
        // ---------------------------------------------------------------------
        if (isset($_GET['action']) && $_GET['action'] === 'export_csv') {
            check_admin_referer('magafrique_export_csv');
            
            $rows = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC", ARRAY_A);
            if (ob_get_level()) {
                ob_end_clean();
            }
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=magazineafrique-brand-reach-ads-' . date('Y-m-d') . '.csv');
            $out = fopen('php://output', 'w');
            fputcsv($out, array('ID', 'Booking Code', 'Brand Name', 'Contact Name', 'Contact Email', 'Phone', 'Country', 'Spot', 'Spot Title', 'CPM Rate', 'Currency', 'Booked Impressions', 'Served Impressions', 'Clicks', 'Total Amount', 'Status', 'Payment Status', 'Destination URL', 'Creative URL', 'Created At'));
            
            foreach ($rows as $r) {
                fputcsv($out, array(
                    $r['id'],
                    $r['booking_code'],
                    $r['brand_name'],
                    $r['contact_name'],
                    $r['contact_email'],
                    $r['contact_phone'],
                    $r['country'],
                    $r['spot'],
                    $r['spot_title'],
                    $r['cpm_rate'],
                    $r['currency'],
                    $r['impressions_booked'],
                    $r['impressions_served'],
                    $r['clicks'],
                    $r['total_amount'],
                    $r['status'],
                    $r['payment_status'],
                    $r['destination_url'],
                    $r['creative_url'],
                    $r['created_at']
                ));
            }
            fclose($out);
            exit;
        }

        // ---------------------------------------------------------------------
        // Action: Resend Wire Invoice Email
        // ---------------------------------------------------------------------
        if (isset($_GET['action'], $_GET['campaign_id']) && $_GET['action'] === 'resend_invoice') {
            check_admin_referer('magafrique_ad_action');
            $c_id = intval($_GET['campaign_id']);
            $camp = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $c_id));
            if ($camp) {
                $formatted_total = ($camp->currency === 'USD' ? '$' : '₦') . number_format($camp->total_amount);
                $client_subject = "[Commercial Invoice & Remittance Wire] Ad Space Booking #{$camp->booking_code} — {$camp->brand_name}";
                $client_message = "Dear {$camp->contact_name},\n\n" .
                    "This is your official commercial invoice and remittance dispatch for ad space with Magazine Afrique.\n\n" .
                    "CAMPAIGN RESERVATION DOSSIER:\n" .
                    "====================================================\n" .
                    "Official Booking Reference : #{$camp->booking_code}\n" .
                    "Brand / Organization       : {$camp->brand_name}\n" .
                    "Selected Ad Space          : {$camp->spot_title}\n" .
                    "Guaranteed Reach Delivery  : " . number_format($camp->impressions_booked) . " verified readers\n" .
                    "Contract Investment Total  : $formatted_total\n" .
                    "Destination URL            : {$camp->destination_url}\n" .
                    "====================================================\n\n" .
                    "OFFICIAL REMITTANCE & WIRE INSTRUCTIONS:\n" .
                    "----------------------------------------------------\n" .
                    "Bank Institution           : " . $bank_details['bank_name'] . "\n" .
                    "Beneficiary Account Name   : " . $bank_details['account_name'] . "\n" .
                    "Account Number (10 Digits) : " . $bank_details['account_number'] . "\n" .
                    "----------------------------------------------------\n\n" .
                    "IMPORTANT RECEIPT ROUTING ADVISORY:\n" .
                    "Send receipt to " . $bank_details['whatsapp_number'] . " on WhatsApp for faster response on any issue.\n\n" .
                    "Direct 1-Click WhatsApp Receipt Link:\n" .
                    "https://wa.me/" . $bank_details['whatsapp_intl'] . "?text=" . urlencode("Hello Magazine Afrique Commercial Desk, here is the payment receipt for Brand Reach Booking #{$camp->booking_code} ({$camp->brand_name}, $formatted_total).") . "\n\n" .
                    "Upon receipt confirmation, our editorial ad server immediately activates your banner asset across all 54 jurisdictions.\n\n" .
                    "Warm regards,\n" .
                    "Continental Commercial Syndicate Desk\n" .
                    "Magazine Afrique — Sovereign Pan-African Journalism\n" .
                    "commercial@magazineafrique.org";

                $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: Magazine Afrique Commercial <commercial@magazineafrique.org>');
                wp_mail($camp->contact_email, $client_subject, $client_message, $headers);
                echo '<div class="notice notice-success is-dismissible"><p>✓ Commercial invoice and Eco Bank wire instructions successfully resent to <strong>' . esc_html($camp->contact_email) . '</strong>.</p></div>';
            }
        }

        // ---------------------------------------------------------------------
        // Action: Campaign Status Toggles (Activate, Pause, Complete, Delete, Paid, Unpaid)
        // ---------------------------------------------------------------------
        if (isset($_GET['action'], $_GET['campaign_id']) && check_admin_referer('magafrique_ad_action')) {
            $campaign_id = intval($_GET['campaign_id']);
            $action = sanitize_text_field($_GET['action']);

            if ($action === 'activate') {
                $wpdb->update($table_name, array('status' => 'active', 'payment_status' => 'paid'), array('id' => $campaign_id));
                echo '<div class="notice notice-success is-dismissible"><p>✓ Campaign #' . $campaign_id . ' activated and set live on site (marked paid).</p></div>';
            } elseif ($action === 'pause') {
                $wpdb->update($table_name, array('status' => 'paused'), array('id' => $campaign_id));
                echo '<div class="notice notice-warning is-dismissible"><p>● Campaign #' . $campaign_id . ' paused.</p></div>';
            } elseif ($action === 'complete') {
                $wpdb->update($table_name, array('status' => 'completed'), array('id' => $campaign_id));
                echo '<div class="notice notice-info is-dismissible"><p>✓ Campaign #' . $campaign_id . ' marked as completed.</p></div>';
            } elseif ($action === 'mark_paid') {
                $wpdb->update($table_name, array('payment_status' => 'paid'), array('id' => $campaign_id));
                echo '<div class="notice notice-success is-dismissible"><p>✓ Campaign #' . $campaign_id . ' marked as PAID &amp; VERIFIED.</p></div>';
            } elseif ($action === 'mark_unpaid') {
                $wpdb->update($table_name, array('payment_status' => 'unpaid'), array('id' => $campaign_id));
                echo '<div class="notice notice-warning is-dismissible"><p>● Campaign #' . $campaign_id . ' marked as UNPAID.</p></div>';
            } elseif ($action === 'delete') {
                $wpdb->delete($table_name, array('id' => $campaign_id));
                echo '<div class="notice notice-error is-dismissible"><p>✕ Campaign #' . $campaign_id . ' deleted.</p></div>';
            }
        }

        // ---------------------------------------------------------------------
        // Action: Save Edited Campaign Form
        // ---------------------------------------------------------------------
        if (isset($_POST['magafrique_save_edit_campaign']) && check_admin_referer('magafrique_edit_campaign_nonce')) {
            $edit_id = intval($_POST['campaign_id']);
            $edit_spot_key = sanitize_text_field($_POST['spot']);
            $edit_spot = isset($spots[$edit_spot_key]) ? $spots[$edit_spot_key] : $spots['bottom'];
            $edit_imps = max(1000, intval($_POST['impressions_booked']));
            $edit_currency = sanitize_text_field($_POST['currency'] ?? 'NGN');
            $edit_cpm = ($edit_currency === 'USD') ? floatval($edit_spot['cpm_usd']) : floatval($edit_spot['cpm_ngn']);
            $edit_total = ($edit_imps / 1000) * $edit_cpm;

            $update_data = array(
                'brand_name'         => sanitize_text_field($_POST['brand_name']),
                'contact_name'       => sanitize_text_field($_POST['contact_name']),
                'contact_email'      => sanitize_email($_POST['contact_email']),
                'contact_phone'      => sanitize_text_field($_POST['contact_phone'] ?? ''),
                'country'            => sanitize_text_field($_POST['country'] ?? ''),
                'spot'               => $edit_spot_key,
                'spot_title'         => $edit_spot['title'],
                'cpm_rate'           => $edit_cpm,
                'currency'           => $edit_currency,
                'impressions_booked' => $edit_imps,
                'total_amount'       => $edit_total,
                'destination_url'    => esc_url_raw($_POST['destination_url']),
                'status'             => sanitize_text_field($_POST['status']),
                'payment_status'     => sanitize_text_field($_POST['payment_status']),
            );

            if (!empty($_FILES['creative_file']['name'])) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/image.php';
                require_once ABSPATH . 'wp-admin/includes/media.php';

                $attachment_id = media_handle_upload('creative_file', 0);
                if (!is_wp_error($attachment_id)) {
                    $update_data['creative_url'] = wp_get_attachment_url($attachment_id);
                }
            }

            $wpdb->update($table_name, $update_data, array('id' => $edit_id));
            echo '<div class="notice notice-success is-dismissible"><p>✓ Campaign #' . $edit_id . ' (' . esc_html($_POST['brand_name']) . ') successfully updated.</p></div>';
        }

        // ---------------------------------------------------------------------
        // Action: Save Dynamic CPM Rates Form
        // ---------------------------------------------------------------------
        if (isset($_POST['magafrique_save_cpm_rates']) && check_admin_referer('magafrique_save_cpm_rates_nonce')) {
            foreach ($spots as $s_key => $s_data) {
                if (isset($_POST['cpm_' . $s_key . '_ngn'])) {
                    update_option('magafrique_cpm_' . $s_key . '_ngn', max(100, floatval($_POST['cpm_' . $s_key . '_ngn'])));
                }
                if (isset($_POST['cpm_' . $s_key . '_usd'])) {
                    update_option('magafrique_cpm_' . $s_key . '_usd', max(1, floatval($_POST['cpm_' . $s_key . '_usd'])));
                }
            }
            $spots = magazineafrique_get_ad_spots_matrix();
            echo '<div class="notice notice-success is-dismissible"><p>✓ Sovereign CPM pricing matrix updated. Live calculator now reflects new rates.</p></div>';
        }

        // ---------------------------------------------------------------------
        // Action: Save Bank Remittance Settings Form
        // ---------------------------------------------------------------------
        if (isset($_POST['magafrique_save_bank_details']) && check_admin_referer('magafrique_save_bank_details_nonce')) {
            update_option('magafrique_ad_bank_name', sanitize_text_field($_POST['ad_bank_name'] ?? 'Eco Bank'));
            update_option('magafrique_ad_account_name', sanitize_text_field($_POST['ad_account_name'] ?? 'Magazine Afrique Limited'));
            update_option('magafrique_ad_account_number', sanitize_text_field($_POST['ad_account_number'] ?? '0089765434'));
            update_option('magafrique_ad_whatsapp_number', sanitize_text_field($_POST['ad_whatsapp_number'] ?? '09082533705'));
            update_option('magafrique_ad_whatsapp_intl', sanitize_text_field($_POST['ad_whatsapp_intl'] ?? '2349082533705'));
            $bank_details = magazineafrique_get_ad_bank_details();
            echo '<div class="notice notice-success is-dismissible"><p>✓ Official Commercial Bank Account &amp; WhatsApp Receipt routing settings saved.</p></div>';
        }

        // ---------------------------------------------------------------------
        // Action: 5-Hour Space Rotation Actions & Settings
        // ---------------------------------------------------------------------
        if (isset($_GET['rotation_action']) && check_admin_referer('magafrique_rotation_action')) {
            $r_action = sanitize_text_field($_GET['rotation_action']);
            if ($r_action === 'shift') {
                $period = (int) get_option('magafrique_ad_rotation_period', 5);
                $curr_offset = (int) get_option('magafrique_ad_rotation_offset', 0);
                update_option('magafrique_ad_rotation_offset', $curr_offset + ($period * HOUR_IN_SECONDS));
                echo '<div class="notice notice-success is-dismissible"><p>✓ 5-Hour Ad Space Rotation successfully shifted to next cycle.</p></div>';
            } elseif ($r_action === 'reset_offset') {
                update_option('magafrique_ad_rotation_offset', 0);
                echo '<div class="notice notice-info is-dismissible"><p>✓ 5-Hour Ad Space Rotation synchronized to standard clock epoch.</p></div>';
            }
            $rot_state = magazineafrique_get_ad_rotation_state();
        }

        if (isset($_POST['magafrique_save_rotation']) && check_admin_referer('magafrique_save_rotation_nonce')) {
            $period = max(1, min(24, intval($_POST['rotation_period'] ?? 5)));
            $mode = sanitize_text_field($_POST['rotation_mode'] ?? 'balanced');
            update_option('magafrique_ad_rotation_period', $period);
            update_option('magafrique_ad_rotation_mode', $mode);
            $rot_state = magazineafrique_get_ad_rotation_state();
            echo '<div class="notice notice-success is-dismissible"><p>✓ Rotation settings saved: ' . $period . '-hour interval with ' . esc_html($mode) . ' mode.</p></div>';
        }

        // Active Tab Determination
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'campaigns';

        // Query Campaign Totals & Metrics
        $total_campaigns = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $active_campaigns = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'active'");
        $pending_campaigns = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'pending_review'");
        $unpaid_campaigns = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE payment_status = 'unpaid'");
        $total_impressions_served = (int) $wpdb->get_var("SELECT SUM(impressions_served) FROM $table_name");
        $total_impressions_booked = (int) $wpdb->get_var("SELECT SUM(impressions_booked) FROM $table_name");
        $total_clicks = (int) $wpdb->get_var("SELECT SUM(clicks) FROM $table_name");
        $overall_ctr = ($total_impressions_served > 0) ? round(($total_clicks / $total_impressions_served) * 100, 2) : 0;
        $total_revenue_ngn = (float) $wpdb->get_var("SELECT SUM(total_amount) FROM $table_name WHERE currency = 'NGN' AND payment_status = 'paid'");
        $total_revenue_usd = (float) $wpdb->get_var("SELECT SUM(total_amount) FROM $table_name WHERE currency = 'USD' AND payment_status = 'paid'");

        // Query Campaign List with Filters & Search
        $current_filter = isset($_GET['status_filter']) ? sanitize_text_field($_GET['status_filter']) : 'all';
        $search_term = isset($_GET['s']) ? sanitize_text_field(trim($_GET['s'])) : '';

        $where_clauses = array();
        if ($current_filter !== 'all') {
            if ($current_filter === 'unpaid') {
                $where_clauses[] = "payment_status = 'unpaid'";
            } else {
                $where_clauses[] = $wpdb->prepare("status = %s", $current_filter);
            }
        }
        if (!empty($search_term)) {
            $wild = '%' . $wpdb->esc_like($search_term) . '%';
            $where_clauses[] = $wpdb->prepare("(brand_name LIKE %s OR booking_code LIKE %s OR contact_name LIKE %s OR contact_email LIKE %s OR spot_title LIKE %s)", $wild, $wild, $wild, $wild, $wild);
        }
        $where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";
        $campaigns = $wpdb->get_results("SELECT * FROM $table_name $where_sql ORDER BY id DESC LIMIT 150");
        ?>

        <div class="wrap artcraft-dark-canvas" style="padding-top: 1rem; max-width: 1400px; margin: 0 auto; color: #FAF7F2; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            
            <!-- 1. Header Masthead -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.12); padding-bottom: 1.25rem;">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.35rem;">
                        <span style="background: #D97706; color: #171513; font-family: 'Geist Mono', monospace; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 3px; letter-spacing: 0.08em;">
                            SOVEREIGN MONETIZATION DESK
                        </span>
                        <span style="font-family: 'Geist Mono', monospace; font-size: 11px; color: #A39A8E;">
                            BRAND REACH INVENTORY (CPM MODEL) · 54 JURISDICTIONS
                        </span>
                    </div>
                    <h1 style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 2rem; font-weight: 800; margin: 0; line-height: 1.2;">
                        Buy Ad Space &amp; Commercial Ledger
                    </h1>
                </div>

                <div style="display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap;">
                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=export_csv'), 'magafrique_export_csv')); ?>" class="button" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px;">
                        📥 Export CSV Ledger
                    </a>
                    <a href="<?php echo esc_url(home_url('/advertise/')); ?>" target="_blank" class="button" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px;">
                        ↗ View Public Booking Page
                    </a>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&tab=manual')); ?>" class="button button-primary" style="background: #D97706; border-color: #D97706; color: #171513; font-weight: 800; font-family: 'Geist Mono', monospace; font-size: 11px;">
                        + Book Manual Campaign
                    </a>
                </div>
            </div>

            <!-- 2. Navigation Tabs Bar -->
            <div style="display: flex; gap: 0.35rem; margin-bottom: 1.5rem; border-bottom: 2px solid rgba(255,255,255,0.1); padding-bottom: 0; overflow-x: auto;">
                <?php
                $tabs = array(
                    'campaigns' => array('label' => '📊 All Campaigns & Ledger', 'count' => $total_campaigns),
                    'bank'      => array('label' => '🏦 Remittance Desk (Eco Bank)', 'badge' => '0089765434'),
                    'rates'     => array('label' => '💰 CPM Pricing & Spots', 'badge' => '4 Spots'),
                    'rotation'  => array('label' => '⏱ 5-Hr Space Rotation', 'badge' => $rot_state ? $rot_state['shift_name'] : 'Active'),
                    'manual'    => array('label' => '➕ Book Manual Ad', 'badge' => 'Offline Direct')
                );
                foreach ($tabs as $t_key => $t_info) :
                    $is_current = ($active_tab === $t_key);
                ?>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&tab=' . $t_key)); ?>" style="padding: 9px 16px; font-family: 'Geist Mono', monospace; font-size: 12px; font-weight: 700; text-decoration: none; border-bottom: 3px solid <?php echo $is_current ? '#D97706' : 'transparent'; ?>; color: <?php echo $is_current ? '#FBBF24' : '#A39A8E'; ?>; background: <?php echo $is_current ? 'rgba(217, 119, 6, 0.12)' : 'transparent'; ?>; border-radius: 4px 4px 0 0; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; transition: all 0.15s ease;">
                        <?php echo esc_html($t_info['label']); ?>
                        <?php if (isset($t_info['count'])) : ?>
                            <span style="background: <?php echo $is_current ? '#D97706' : 'rgba(255,255,255,0.1)'; ?>; color: <?php echo $is_current ? '#171513' : '#FAF7F2'; ?>; font-size: 10px; padding: 1px 6px; border-radius: 9999px; font-weight: 800;"><?php echo esc_html($t_info['count']); ?></span>
                        <?php elseif (isset($t_info['badge'])) : ?>
                            <span style="background: rgba(255,255,255,0.06); color: #78716C; font-size: 10px; padding: 1px 5px; border-radius: 3px; font-weight: 600;"><?php echo esc_html($t_info['badge']); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 1: ALL CAMPAIGNS & LEDGER                                 -->
            <!-- ============================================================= -->
            <?php if ($active_tab === 'campaigns') : ?>

                <!-- Metrics Strip -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                    
                    <!-- Metric: Active Live Ads -->
                    <div style="background: #171513; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.3);">
                        <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.35rem;">Active Live Reach Ads</div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #FBBF24;">
                            <?php echo esc_html($active_campaigns); ?> <span style="font-size: 0.875rem; color: #78716C;">/ <?php echo esc_html($total_campaigns); ?> total</span>
                        </div>
                    </div>

                    <!-- Metric: Impressions Fulfilled -->
                    <div style="background: #171513; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.3);">
                        <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.35rem;">Guaranteed Impressions</div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #FFFFFF;">
                            <?php echo number_format($total_impressions_served); ?>
                        </div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #78716C; margin-top: 2px;">
                            Booked: <?php echo number_format($total_impressions_booked); ?> (<?php echo ($total_impressions_booked > 0) ? round(($total_impressions_served / $total_impressions_booked) * 100, 1) : 0; ?>% delivered)
                        </div>
                    </div>

                    <!-- Metric: Realized Revenue -->
                    <div style="background: #171513; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.3);">
                        <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.35rem;">Realized Paid Revenue</div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #34D399;">
                            ₦<?php echo number_format($total_revenue_ngn); ?>
                        </div>
                        <?php if ($total_revenue_usd > 0) : ?>
                            <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #34D399; margin-top: 2px;">
                                + $<?php echo number_format($total_revenue_usd); ?> USD
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Metric: Pending / Unpaid -->
                    <div style="background: #171513; border: 1px solid <?php echo ($pending_campaigns > 0 || $unpaid_campaigns > 0) ? 'rgba(245, 158, 11, 0.4)' : 'rgba(255,255,255,0.12)'; ?>; padding: 1.25rem; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.3);">
                        <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.35rem;">Pending Review / Unpaid</div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #F59E0B;">
                            <?php echo esc_html($pending_campaigns); ?> <span style="font-size: 0.875rem; color: #78716C;">/ <?php echo esc_html($unpaid_campaigns); ?> unpaid</span>
                        </div>
                    </div>

                    <!-- Metric: Clicks & CTR -->
                    <div style="background: #171513; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.3);">
                        <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.35rem;">Tracked Clicks &amp; CTR</div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #60A5FA;">
                            <?php echo number_format($total_clicks); ?>
                        </div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #78716C; margin-top: 2px;">
                            Avg CTR: <?php echo esc_html($overall_ctr); ?>%
                        </div>
                    </div>

                </div>

                <!-- Filter & Search Bar Strip -->
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; background: #13110F; border: 1px solid rgba(255,255,255,0.1); padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                    
                    <!-- Filter Pills -->
                    <div style="display: flex; gap: 0.4rem; flex-wrap: wrap; font-family: 'Geist Mono', monospace; font-size: 11px;">
                        <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&status_filter=all')); ?>" style="padding: 4px 10px; border-radius: 3px; text-decoration: none; <?php echo $current_filter === 'all' ? 'background: #D97706; color: #171513; font-weight: 800;' : 'background: rgba(255,255,255,0.06); color: #FAF7F2;'; ?>">
                            All (<?php echo esc_html($total_campaigns); ?>)
                        </a>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&status_filter=active')); ?>" style="padding: 4px 10px; border-radius: 3px; text-decoration: none; <?php echo $current_filter === 'active' ? 'background: #D97706; color: #171513; font-weight: 800;' : 'background: rgba(255,255,255,0.06); color: #FAF7F2;'; ?>">
                            Active Live (<?php echo esc_html($active_campaigns); ?>)
                        </a>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&status_filter=pending_review')); ?>" style="padding: 4px 10px; border-radius: 3px; text-decoration: none; <?php echo $current_filter === 'pending_review' ? 'background: #D97706; color: #171513; font-weight: 800;' : 'background: rgba(255,255,255,0.06); color: #FAF7F2;'; ?>">
                            Pending Review (<?php echo esc_html($pending_campaigns); ?>)
                        </a>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&status_filter=unpaid')); ?>" style="padding: 4px 10px; border-radius: 3px; text-decoration: none; <?php echo $current_filter === 'unpaid' ? 'background: #D97706; color: #171513; font-weight: 800;' : 'background: rgba(255,255,255,0.06); color: #FAF7F2;'; ?>">
                            Awaiting Wire (<?php echo esc_html($unpaid_campaigns); ?>)
                        </a>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&status_filter=completed')); ?>" style="padding: 4px 10px; border-radius: 3px; text-decoration: none; <?php echo $current_filter === 'completed' ? 'background: #D97706; color: #171513; font-weight: 800;' : 'background: rgba(255,255,255,0.06); color: #FAF7F2;'; ?>">
                            Completed
                        </a>
                    </div>

                    <!-- Search Input Form -->
                    <form method="get" action="<?php echo esc_url(admin_url('admin.php')); ?>" style="display: flex; align-items: center; gap: 0.35rem;">
                        <input type="hidden" name="page" value="magazineafrique-brand-ads" />
                        <?php if ($current_filter !== 'all') : ?>
                            <input type="hidden" name="status_filter" value="<?php echo esc_attr($current_filter); ?>" />
                        <?php endif; ?>
                        <input type="text" name="s" value="<?php echo esc_attr($search_term); ?>" placeholder="Search brand, code, email..." style="background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; padding: 4px 8px; border-radius: 3px; width: 220px;" />
                        <button type="submit" class="button" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px;">
                            Search
                        </button>
                        <?php if (!empty($search_term)) : ?>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads')); ?>" class="button" style="background: transparent; color: #A39A8E; font-size: 11px;">Clear</a>
                        <?php endif; ?>
                    </form>

                </div>

                <!-- Campaign Cards List -->
                <?php if (empty($campaigns)) : ?>
                    <div style="background: #171513; border: 1px dashed rgba(255,255,255,0.15); border-radius: 4px; padding: 3.5rem 1.5rem; text-align: center; color: #A39A8E;">
                        <div style="font-size: 2.25rem; margin-bottom: 0.5rem;">📢</div>
                        <h3 style="color: #FAF7F2; font-family: 'Newsreader', Georgia, serif; font-size: 1.45rem; margin: 0 0 0.5rem;">No Brand Reach Campaigns Found</h3>
                        <p style="font-size: 13px; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.5;">
                            Direct advertisers acquire broadsheet space via the public Buy Ad Space portal with Eco Bank wire remittance. You can also register direct offline agency contracts.
                        </p>
                        <div style="display: flex; gap: 0.75rem; justify-content: center;">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&tab=manual')); ?>" class="button button-primary" style="background: #D97706; border-color: #D97706; color: #171513; font-weight: 800; font-family: 'Geist Mono', monospace;">
                                + Book Manual Campaign
                            </a>
                            <a href="<?php echo esc_url(home_url('/advertise/')); ?>" target="_blank" class="button" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace;">
                                Open Public Booking Portal ↗
                            </a>
                        </div>
                    </div>
                <?php else : ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
                        <?php foreach ($campaigns as $camp) : 
                            $pct = ($camp->impressions_booked > 0) ? min(100, round(($camp->impressions_served / $camp->impressions_booked) * 100, 1)) : 0;
                            $status_color = '#F59E0B';
                            if ($camp->status === 'active') $status_color = '#34D399';
                            if ($camp->status === 'completed') $status_color = '#A39A8E';
                            if ($camp->status === 'paused') $status_color = '#FB923C';
                            $is_paid = ($camp->payment_status === 'paid');
                            $ctr_camp = ($camp->impressions_served > 0) ? round(($camp->clicks / $camp->impressions_served) * 100, 2) : 0;
                        ?>
                            <div style="background: #171513; border: 1px solid rgba(255,255,255,0.14); border-radius: 4px; padding: 1.25rem; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 8px 24px rgba(0,0,0,0.45); position: relative;">
                                
                                <div>
                                    <!-- Header: Reference & Badges -->
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.65rem;">
                                        <span style="font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 800; color: #D97706; letter-spacing: 0.05em;">
                                            #<?php echo esc_html($camp->booking_code); ?>
                                        </span>
                                        <div style="display: flex; gap: 4px; align-items: center;">
                                            <!-- Payment Status Badge -->
                                            <span style="font-family: 'Geist Mono', monospace; font-size: 9.5px; font-weight: 800; text-transform: uppercase; padding: 2px 6px; border-radius: 2px; <?php echo $is_paid ? 'background: rgba(16, 185, 129, 0.15); color: #34D399; border: 1px solid rgba(16, 185, 129, 0.35);' : 'background: rgba(245, 158, 11, 0.15); color: #FBBF24; border: 1px solid rgba(245, 158, 11, 0.35);'; ?>">
                                                <?php echo $is_paid ? '✓ PAID' : '⚠ UNPAID'; ?>
                                            </span>
                                            <!-- Campaign State Badge -->
                                            <span style="font-family: 'Geist Mono', monospace; font-size: 9.5px; font-weight: 800; text-transform: uppercase; color: <?php echo esc_attr($status_color); ?>; background: rgba(255,255,255,0.06); padding: 2px 6px; border-radius: 2px; border: 1px solid rgba(255,255,255,0.1);">
                                                ● <?php echo esc_html(str_replace('_', ' ', $camp->status)); ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Brand Name & Contacts -->
                                    <h3 style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 1.25rem; font-weight: 800; margin: 0 0 0.35rem; line-height: 1.25;">
                                        <?php echo esc_html($camp->brand_name); ?>
                                    </h3>
                                    <div style="font-family: 'Geist Mono', monospace; font-size: 11px; color: #A39A8E; margin-bottom: 0.85rem; line-height: 1.45;">
                                        <?php echo esc_html($camp->contact_name); ?> · <a href="mailto:<?php echo esc_attr($camp->contact_email); ?>" style="color: #D97706; text-decoration: none;"><?php echo esc_html($camp->contact_email); ?></a>
                                        <?php if (!empty($camp->contact_phone)) : ?>
                                            · <a href="tel:<?php echo esc_attr($camp->contact_phone); ?>" style="color: #A39A8E; text-decoration: none;"><?php echo esc_html($camp->contact_phone); ?></a>
                                        <?php endif; ?>
                                        <?php if (!empty($camp->country)) echo ' (' . esc_html($camp->country) . ')'; ?>
                                    </div>

                                    <!-- Spot & Budget Matrix Box -->
                                    <div style="background: #141210; border: 1px solid rgba(255,255,255,0.08); padding: 0.85rem; border-radius: 3px; margin-bottom: 0.85rem;">
                                        <div style="display: flex; justify-content: space-between; font-size: 12px; color: #FAF7F2; margin-bottom: 4px;">
                                            <span>Target Ad Spot:</span>
                                            <strong style="color: #FBBF24;"><?php echo esc_html($camp->spot_title); ?></strong>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-family: 'Geist Mono', monospace; font-size: 11px; color: #A39A8E; margin-bottom: 3px;">
                                            <span>CPM Rate:</span>
                                            <span><?php echo $camp->currency === 'USD' ? '$' : '₦'; ?><?php echo number_format($camp->cpm_rate); ?> / 1k imps</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-family: 'Geist Mono', monospace; font-size: 11px; color: #A39A8E;">
                                            <span>Total Investment:</span>
                                            <strong style="color: #34D399; font-size: 12px;"><?php echo $camp->currency === 'USD' ? '$' : '₦'; ?><?php echo number_format($camp->total_amount); ?></strong>
                                        </div>
                                    </div>

                                    <!-- Progress Bar (Served vs Booked) -->
                                    <div style="margin-bottom: 0.85rem;">
                                        <div style="display: flex; justify-content: space-between; font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; margin-bottom: 4px;">
                                            <span>Delivery: <?php echo number_format($camp->impressions_served); ?> / <?php echo number_format($camp->impressions_booked); ?> imps</span>
                                            <span style="font-weight: 700; color: #FAF7F2;"><?php echo esc_html($pct); ?>%</span>
                                        </div>
                                        <div style="width: 100%; height: 6px; background: rgba(255,255,255,0.08); border-radius: 3px; overflow: hidden;">
                                            <div style="width: <?php echo esc_attr($pct); ?>%; height: 100%; background: #D97706;"></div>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-family: 'Geist Mono', monospace; font-size: 9.5px; color: #78716C; margin-top: 3px;">
                                            <span>Clicks: <?php echo number_format($camp->clicks); ?></span>
                                            <span>CTR: <?php echo esc_html($ctr_camp); ?>%</span>
                                        </div>
                                    </div>

                                    <!-- Creative Thumbnail Asset -->
                                    <?php if (!empty($camp->creative_url)) : ?>
                                        <div style="margin-bottom: 0.85rem;">
                                            <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 9.5px; color: #78716C; margin-bottom: 3px;">CREATIVE BANNER (CLICK TO ENLARGE):</span>
                                            <div onclick="window.openImageLightbox('<?php echo esc_url($camp->creative_url); ?>', '<?php echo esc_js($camp->brand_name); ?>');" style="cursor: pointer; max-height: 85px; overflow: hidden; border-radius: 2px; border: 1px solid rgba(255,255,255,0.12); background: #000; transition: border-color 0.15s ease;">
                                                <img src="<?php echo esc_url($camp->creative_url); ?>" alt="Creative Asset" style="width: 100%; height: auto; display: block; object-fit: contain;" />
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Destination Link -->
                                    <?php if (!empty($camp->destination_url)) : ?>
                                        <div style="font-family: 'Geist Mono', monospace; font-size: 10.5px; color: #A39A8E; word-break: break-all; margin-bottom: 0.85rem;">
                                            Link: <a href="<?php echo esc_url($camp->destination_url); ?>" target="_blank" style="color: #D6CEC3;"><?php echo esc_html($camp->destination_url); ?> ↗</a>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Action Buttons Cluster -->
                                <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; gap: 0.4rem; flex-wrap: wrap; align-items: center;">
                                    
                                    <!-- 1. Live Status Toggle -->
                                    <?php if ($camp->status !== 'active') : ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=activate&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" class="button button-small" style="background: #10B981; border-color: #10B981; color: #000000; font-weight: 800; font-family: 'Geist Mono', monospace; font-size: 10px;">
                                            ✓ Set Live
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=pause&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" class="button button-small" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 10px;">
                                            ⏸ Pause
                                        </a>
                                    <?php endif; ?>

                                    <!-- 2. Payment Status Toggle -->
                                    <?php if (!$is_paid) : ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=mark_paid&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" class="button button-small" style="background: #3B82F6; border-color: #3B82F6; color: #FFFFFF; font-weight: 700; font-family: 'Geist Mono', monospace; font-size: 10px;">
                                            💵 Mark Paid
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=mark_unpaid&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" class="button button-small" style="background: transparent; border-color: rgba(255,255,255,0.2); color: #A39A8E; font-family: 'Geist Mono', monospace; font-size: 10px;" title="Revert to unpaid status">
                                            Mark Unpaid
                                        </a>
                                    <?php endif; ?>

                                    <!-- 3. Direct WhatsApp Chat with Advertiser -->
                                    <?php
                                    $raw_p = !empty($camp->contact_phone) ? $camp->contact_phone : '';
                                    $clean_p = preg_replace('/[^0-9]/', '', $raw_p);
                                    if (!empty($clean_p) && substr($clean_p, 0, 1) === '0') {
                                        $clean_p = '234' . substr($clean_p, 1);
                                    }
                                    if (!empty($clean_p)) :
                                        $wa_client_msg = urlencode("Hello " . $camp->brand_name . " (" . $camp->contact_name . "), Magazine Afrique Commercial Desk here regarding your ad space booking #" . $camp->booking_code . " (" . $camp->spot_title . "). We would like to confirm your Eco Bank payment receipt so we can activate your banner on the live broadsheet wire.");
                                    ?>
                                        <a href="https://wa.me/<?php echo esc_attr($clean_p); ?>?text=<?php echo $wa_client_msg; ?>" target="_blank" class="button button-small" style="background: #25D366; border-color: #25D366; color: #171513; font-weight: 800; font-family: 'Geist Mono', monospace; font-size: 10px;" title="Direct WhatsApp verification with advertiser">
                                            💬 WhatsApp
                                        </a>
                                    <?php endif; ?>

                                    <!-- 4. Resend Wire Invoice -->
                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=resend_invoice&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" class="button button-small" style="background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.15); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 10px;" title="Resend commercial invoice with Eco Bank wire details to client email">
                                        ✉ Invoice
                                    </a>

                                    <!-- 5. Edit Button -->
                                    <button type="button" onclick="window.openEditModal(<?php echo htmlspecialchars(json_encode($camp), ENT_QUOTES, 'UTF-8'); ?>);" class="button button-small" style="background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.15); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 10px;">
                                        ✎ Edit
                                    </button>

                                    <!-- 6. Delete Button -->
                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=delete&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" onclick="return confirm('Permanently delete campaign #<?php echo esc_js($camp->booking_code); ?>?');" class="button button-small button-link-delete" style="font-family: 'Geist Mono', monospace; font-size: 10px; margin-left: auto;">
                                        ✕
                                    </a>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <!-- ============================================================= -->
            <!-- TAB 2: REMITTANCE DESK & BANK SETTINGS                        -->
            <!-- ============================================================= -->
            <?php elseif ($active_tab === 'bank') : ?>

                <div style="background: #171513; border: 2px solid #D97706; border-radius: 4px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 8px 32px rgba(0,0,0,0.6);">
                    <div style="border-bottom: 1px solid rgba(255,255,255,0.12); padding-bottom: 1rem; margin-bottom: 1.5rem;">
                        <span style="background: #D97706; color: #171513; font-family: 'Geist Mono', monospace; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 3px; display: inline-block; margin-bottom: 0.35rem;">
                            OFFICIAL MONETIZATION REMITTANCE PIPELINE
                        </span>
                        <h2 style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 1.65rem; font-weight: 800; margin: 0 0 0.35rem;">
                            Commercial Bank Settlement &amp; WhatsApp Receipt Routing
                        </h2>
                        <p style="color: #A39A8E; font-size: 13px; margin: 0; line-height: 1.5;">
                            All direct broadsheet advertisers on the Buy Ad Space portal are instructed to transfer payments to this official bank account and dispatch proof of payment via WhatsApp for immediate campaign clearance.
                        </p>
                    </div>

                    <!-- Live Bank Credentials Card Preview -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
                        <div style="background: #11100F; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px;">
                            <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 10px; color: #78716C; text-transform: uppercase;">Bank Institution</span>
                            <strong style="color: #FAF7F2; font-size: 1.35rem; font-family: 'Newsreader', Georgia, serif;"><?php echo esc_html($bank_details['bank_name']); ?></strong>
                        </div>
                        <div style="background: #11100F; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px;">
                            <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 10px; color: #78716C; text-transform: uppercase;">Beneficiary Account Name</span>
                            <strong style="color: #FAF7F2; font-size: 1.15rem;"><?php echo esc_html($bank_details['account_name']); ?></strong>
                        </div>
                        <div style="background: #11100F; border: 1px solid rgba(217, 119, 6, 0.5); padding: 1.25rem; border-radius: 4px;">
                            <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 10px; color: #D97706; text-transform: uppercase;">Account Number (10 Digits)</span>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; margin-top: 3px;">
                                <strong style="color: #FBBF24; font-family: 'Geist Mono', monospace; font-size: 1.5rem; letter-spacing: 0.08em;"><?php echo esc_html($bank_details['account_number']); ?></strong>
                                <button type="button" onclick="navigator.clipboard.writeText('<?php echo esc_js($bank_details['account_number']); ?>'); this.innerText='COPIED!'; var b=this; setTimeout(function(){ b.innerText='COPY'; }, 2000);" class="button" style="background: #D97706; color: #171513; border: none; font-weight: 800; font-family: 'Geist Mono', monospace; font-size: 11px;">COPY</button>
                            </div>
                        </div>
                        <div style="background: #11100F; border: 1px solid rgba(37, 211, 102, 0.4); padding: 1.25rem; border-radius: 4px;">
                            <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 10px; color: #25D366; text-transform: uppercase;">WhatsApp Receipt Desk</span>
                            <strong style="color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 1.35rem;"><?php echo esc_html($bank_details['whatsapp_number']); ?></strong>
                            <a href="https://wa.me/<?php echo esc_attr($bank_details['whatsapp_intl']); ?>?text=Hello+Magazine+Afrique+Commercial+Desk" target="_blank" style="display: block; font-size: 11px; color: #25D366; text-decoration: none; margin-top: 4px; font-weight: 700;">Test WhatsApp Channel ↗</a>
                        </div>
                    </div>

                    <!-- Policy Advisory Callout -->
                    <div style="background: rgba(217, 119, 6, 0.1); border-left: 3px solid #D97706; padding: 1rem 1.25rem; font-family: 'Geist Mono', monospace; font-size: 12px; color: #FBBF24; margin-bottom: 2rem; border-radius: 0 4px 4px 0;">
                        📌 <strong>Official Policy Advisory to Advertisers:</strong> "Send receipt to <?php echo esc_html($bank_details['whatsapp_number']); ?> on WhatsApp for faster response on any issue."
                    </div>

                    <!-- Bank Settings Edit Form -->
                    <div style="background: #12100E; border: 1px solid rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 4px;">
                        <h3 style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 1.25rem; margin: 0 0 1rem;">
                            Update Remittance Credentials
                        </h3>
                        <form method="post">
                            <?php wp_nonce_field('magafrique_save_bank_details_nonce'); ?>
                            <input type="hidden" name="magafrique_save_bank_details" value="1">
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                                <div>
                                    <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 11px; color: #FAF7F2; margin-bottom: 6px;">Bank Institution Name *</label>
                                    <input type="text" name="ad_bank_name" value="<?php echo esc_attr($bank_details['bank_name']); ?>" style="width: 100%; background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #FAF7F2; padding: 8px 10px; font-family: 'Geist Mono', monospace; font-size: 12px; border-radius: 3px;" required>
                                </div>
                                <div>
                                    <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 11px; color: #FAF7F2; margin-bottom: 6px;">Beneficiary Account Name *</label>
                                    <input type="text" name="ad_account_name" value="<?php echo esc_attr($bank_details['account_name']); ?>" style="width: 100%; background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #FAF7F2; padding: 8px 10px; font-family: 'Geist Mono', monospace; font-size: 12px; border-radius: 3px;" required>
                                </div>
                                <div>
                                    <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 11px; color: #FAF7F2; margin-bottom: 6px;">Account Number (10 Digits) *</label>
                                    <input type="text" name="ad_account_number" value="<?php echo esc_attr($bank_details['account_number']); ?>" style="width: 100%; background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #FAF7F2; padding: 8px 10px; font-family: 'Geist Mono', monospace; font-size: 12px; border-radius: 3px;" required>
                                </div>
                                <div>
                                    <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 11px; color: #FAF7F2; margin-bottom: 6px;">WhatsApp Hotline (Local Display) *</label>
                                    <input type="text" name="ad_whatsapp_number" value="<?php echo esc_attr($bank_details['whatsapp_number']); ?>" style="width: 100%; background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #FAF7F2; padding: 8px 10px; font-family: 'Geist Mono', monospace; font-size: 12px; border-radius: 3px;" required>
                                </div>
                                <div>
                                    <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 11px; color: #FAF7F2; margin-bottom: 6px;">WhatsApp Intl (wa.me format) *</label>
                                    <input type="text" name="ad_whatsapp_intl" value="<?php echo esc_attr($bank_details['whatsapp_intl']); ?>" style="width: 100%; background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #FAF7F2; padding: 8px 10px; font-family: 'Geist Mono', monospace; font-size: 12px; border-radius: 3px;" required>
                                </div>
                            </div>
                            <button type="submit" class="button button-primary" style="background: #D97706; border-color: #D97706; color: #171513; font-weight: 800; font-family: 'Geist Mono', monospace; padding: 6px 16px;">
                                Save Remittance Settings
                            </button>
                        </form>
                    </div>
                </div>

            <!-- ============================================================= -->
            <!-- TAB 3: CPM PRICING & INVENTORY SPOTS                          -->
            <!-- ============================================================= -->
            <?php elseif ($active_tab === 'rates') : ?>

                <div style="background: #171513; border: 1px solid rgba(255,255,255,0.12); border-radius: 4px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 8px 32px rgba(0,0,0,0.6);">
                    <div style="border-bottom: 1px solid rgba(255,255,255,0.12); padding-bottom: 1rem; margin-bottom: 1.5rem;">
                        <span style="background: #D97706; color: #171513; font-family: 'Geist Mono', monospace; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 3px; display: inline-block; margin-bottom: 0.35rem;">
                            INVENTORY PRICING DESK
                        </span>
                        <h2 style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 1.65rem; font-weight: 800; margin: 0 0 0.35rem;">
                            Broadsheet CPM Pricing &amp; Spot Inventory Matrix
                        </h2>
                        <p style="color: #A39A8E; font-size: 13px; margin: 0; line-height: 1.5;">
                            Configure the sovereign Cost-Per-Thousand (CPM) rates for each placement across Magazine Afrique. Higher rates apply to premium high-dwell placements like the Master Masthead and In-Article core. Changes directly power the live rate calculator on the public Buy Ad Space page.
                        </p>
                    </div>

                    <form method="post">
                        <?php wp_nonce_field('magafrique_save_cpm_rates_nonce'); ?>
                        <input type="hidden" name="magafrique_save_cpm_rates" value="1">
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
                            <?php foreach ($spots as $s_id => $s) : ?>
                                <div style="background: #12100E; border: 1px solid rgba(255,255,255,0.12); border-radius: 4px; padding: 1.25rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <span style="font-family: 'Geist Mono', monospace; font-size: 10px; font-weight: 800; background: rgba(217, 119, 6, 0.2); color: #FBBF24; border: 1px solid rgba(217, 119, 6, 0.4); padding: 2px 6px; border-radius: 2px;">
                                            <?php echo esc_html($s['badge']); ?>
                                        </span>
                                        <span style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #78716C;">
                                            <?php echo esc_html($s['tier']); ?>
                                        </span>
                                    </div>
                                    <h4 style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 1.15rem; margin: 0 0 0.35rem;">
                                        <?php echo esc_html($s['title']); ?>
                                    </h4>
                                    <p style="font-size: 12px; color: #A39A8E; margin: 0 0 0.75rem; line-height: 1.45;">
                                        <?php echo esc_html($s['description']); ?>
                                    </p>
                                    <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #78716C; margin-bottom: 1rem;">
                                        Dimensions: <?php echo esc_html($s['dimensions']); ?>
                                    </div>

                                    <!-- Price Inputs -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                                        <div>
                                            <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 10px; color: #D97706; margin-bottom: 4px;">CPM Rate (NGN ₦)</label>
                                            <input type="number" name="cpm_<?php echo esc_attr($s_id); ?>_ngn" value="<?php echo esc_attr($s['cpm_ngn']); ?>" min="500" step="100" style="width: 100%; background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #FBBF24; font-family: 'Geist Mono', monospace; font-size: 12px; font-weight: 700; padding: 6px 8px; border-radius: 3px;" required>
                                        </div>
                                        <div>
                                            <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 10px; color: #34D399; margin-bottom: 4px;">CPM Rate (USD $)</label>
                                            <input type="number" name="cpm_<?php echo esc_attr($s_id); ?>_usd" value="<?php echo esc_attr($s['cpm_usd']); ?>" min="1" step="0.25" style="width: 100%; background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #34D399; font-family: 'Geist Mono', monospace; font-size: 12px; font-weight: 700; padding: 6px 8px; border-radius: 3px;" required>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="submit" class="button button-primary" style="background: #D97706; border-color: #D97706; color: #171513; font-weight: 800; font-family: 'Geist Mono', monospace; padding: 8px 20px; font-size: 12px;">
                            Save CPM Pricing Matrix
                        </button>
                    </form>
                </div>

            <!-- ============================================================= -->
            <!-- TAB 4: 5-HOUR SPACE ROTATION CONTROLLER                       -->
            <!-- ============================================================= -->
            <?php elseif ($active_tab === 'rotation') : ?>

                <div style="background: #171513; border: 2px solid #D97706; border-radius: 4px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 8px 32px rgba(0,0,0,0.6);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid rgba(255,255,255,0.12); padding-bottom: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="display: inline-block; width: 9px; height: 9px; border-radius: 50%; background: #D97706; box-shadow: 0 0 8px #D97706;"></span>
                                <span style="font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 800; color: #FBBF24; text-transform: uppercase; letter-spacing: 0.08em;">
                                    5-Hour Space Rotation Balancer · Current Shift: <?php echo esc_html($rot_state['shift_name']); ?> (Cycle #<?php echo esc_html($rot_state['cycle_number']); ?>)
                                </span>
                            </div>
                            <p style="font-size: 13px; color: #A39A8E; margin: 6px 0 0; line-height: 1.5;">
                                Balances direct sponsored placements with programmatic Google AdSense tags so reader fatigue is minimized and monetization remains diversified.
                            </p>
                        </div>

                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); padding: 6px 14px; border-radius: 3px; font-family: 'Geist Mono', monospace; font-size: 12px;">
                                <span style="color: #A39A8E;">NEXT ROTATION IN:</span> 
                                <strong id="rot-timer-display" style="color: #FBBF24; font-size: 13px;"><?php echo esc_html($rot_state['formatted_remaining']); ?></strong>
                            </div>
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&tab=rotation&rotation_action=shift'), 'magafrique_rotation_action')); ?>" class="button" style="background: #D97706; border-color: #D97706; color: #171513; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 800;" onclick="return confirm('Immediately shift the site ad space rotation to the next cycle?');">
                                ↻ Shift Cycle Now
                            </a>
                        </div>
                    </div>

                    <!-- 5 Zones Allocation Matrix -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                        <?php foreach ($rot_state['zones'] as $zone_key => $zone) : 
                            $is_direct = ($zone['active_mode'] === 'direct');
                            $active_ad_in_zone = magazineafrique_get_active_brand_ad($zone['spot_key'], $zone_key);
                        ?>
                            <div style="background: #12100E; border: 1px solid <?php echo $is_direct ? 'rgba(217, 119, 6, 0.45)' : 'rgba(59, 130, 246, 0.35)'; ?>; border-radius: 4px; padding: 1rem; position: relative;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                                    <span style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase;">
                                        ZONE: <?php echo strtoupper($zone_key); ?>
                                    </span>
                                    <span style="font-family: 'Geist Mono', monospace; font-size: 9.5px; font-weight: 800; padding: 2px 6px; border-radius: 2px; <?php echo $is_direct ? 'background: rgba(217, 119, 6, 0.2); color: #FBBF24; border: 1px solid rgba(217, 119, 6, 0.4);' : 'background: rgba(59, 130, 246, 0.15); color: #93C5FD; border: 1px solid rgba(59, 130, 246, 0.3);'; ?>">
                                        <?php echo $is_direct ? '★ DIRECT REACH' : '● GOOGLE ADS'; ?>
                                    </span>
                                </div>
                                <strong style="display: block; color: #FFFFFF; font-size: 13px; margin-bottom: 0.35rem;">
                                    <?php echo esc_html($zone['title']); ?>
                                </strong>
                                <div style="font-size: 11px; color: <?php echo $is_direct ? ($active_ad_in_zone ? '#34D399' : '#FBBF24') : '#93C5FD'; ?>; font-family: 'Geist Mono', monospace;">
                                    <?php if ($is_direct) : ?>
                                        <?php if ($active_ad_in_zone) : ?>
                                            ✓ Serving: <?php echo esc_html($active_ad_in_zone->brand_name); ?>
                                        <?php else : ?>
                                            ○ Ready (Google Ads Fallback)
                                        <?php endif; ?>
                                    <?php else : ?>
                                        ✓ Active Programmatic Slot
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Settings Bar Form -->
                    <form method="post" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; background: #13110F; border: 1px solid rgba(255,255,255,0.08); padding: 1rem 1.25rem; border-radius: 4px;">
                        <?php wp_nonce_field('magafrique_save_rotation_nonce'); ?>
                        <input type="hidden" name="magafrique_save_rotation" value="1">
                        <div style="display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;">
                            <label style="font-family: 'Geist Mono', monospace; font-size: 12px; color: #FAF7F2;">
                                Rotation Interval:
                                <select name="rotation_period" style="background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; margin-left: 6px; padding: 4px 8px;">
                                    <?php foreach (array(1, 2, 3, 4, 5, 6, 8, 12, 24) as $hrs) : ?>
                                        <option value="<?php echo $hrs; ?>" <?php selected($rot_state['period_hours'], $hrs); ?>><?php echo $hrs; ?> Hours <?php echo $hrs === 5 ? '(Default)' : ''; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>

                            <label style="font-family: 'Geist Mono', monospace; font-size: 12px; color: #FAF7F2;">
                                Balance Mode:
                                <select name="rotation_mode" style="background: #171513; border: 1px solid rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; margin-left: 6px; padding: 4px 8px;">
                                    <option value="balanced" <?php selected($rot_state['mode'], 'balanced'); ?>>Balanced Shift (Direct + Programmatic)</option>
                                    <option value="force_direct" <?php selected($rot_state['mode'], 'force_direct'); ?>>Direct Priority (All Active Direct Ads)</option>
                                    <option value="google_only" <?php selected($rot_state['mode'], 'google_only'); ?>>Google Ads Only (Emergency Reset)</option>
                                </select>
                            </label>
                        </div>

                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <button type="submit" class="button button-primary" style="background: #D97706; border-color: #D97706; color: #171513; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 800;">
                                Save Rotation Settings
                            </button>
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&tab=rotation&rotation_action=reset_offset'), 'magafrique_rotation_action')); ?>" class="button" style="background: transparent; border-color: rgba(255,255,255,0.1); color: #78716C; font-family: 'Geist Mono', monospace; font-size: 11px;" title="Reset custom shift offset to 0">
                                Reset Offset
                            </a>
                        </div>
                    </form>
                </div>

                <script>
                (function() {
                    var secondsLeft = <?php echo (int) $rot_state['seconds_remaining']; ?>;
                    var display = document.getElementById('rot-timer-display');
                    if (display) {
                        var timer = setInterval(function() {
                            secondsLeft--;
                            if (secondsLeft <= 0) {
                                clearInterval(timer);
                                display.textContent = '00h 00m 00s (Cycling...)';
                                setTimeout(function() { location.reload(); }, 2000);
                                return;
                            }
                            var h = Math.floor(secondsLeft / 3600);
                            var m = Math.floor((secondsLeft % 3600) / 60);
                            var s = secondsLeft % 60;
                            var pad = function(n) { return (n < 10 ? '0' : '') + n; };
                            display.textContent = pad(h) + 'h ' + pad(m) + 'm ' + pad(s) + 's';
                        }, 1000);
                    }
                })();
                </script>

            <!-- ============================================================= -->
            <!-- TAB 5: BOOK MANUAL CAMPAIGN                                   -->
            <!-- ============================================================= -->
            <?php elseif ($active_tab === 'manual') : ?>

                <div style="background: #171513; border: 2px solid #D97706; border-radius: 4px; padding: 2rem; max-width: 720px; margin: 0 auto 2rem; box-shadow: 0 8px 32px rgba(0,0,0,0.6);">
                    <div style="border-bottom: 1px solid rgba(255,255,255,0.12); padding-bottom: 1rem; margin-bottom: 1.5rem;">
                        <span style="background: #D97706; color: #171513; font-family: 'Geist Mono', monospace; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 3px; display: inline-block; margin-bottom: 0.35rem;">
                            OFFLINE &amp; DIRECT SALES DESK
                        </span>
                        <h2 style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 1.65rem; font-weight: 800; margin: 0 0 0.35rem;">
                            Book Direct / Agency Contract Brand Reach Campaign
                        </h2>
                        <p style="color: #A39A8E; font-size: 13px; margin: 0; line-height: 1.5;">
                            Register an ad campaign closed via direct corporate wire, invoice, or syndicate partnership.
                        </p>
                    </div>

                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="magazineafrique_admin_create_ad_campaign" />
                        <?php wp_nonce_field('magafrique_admin_create_ad'); ?>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Institutional / Brand Name *</label>
                            <input type="text" name="brand_name" required placeholder="e.g. Dangote Cement, Standard Chartered Bank" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 9px 12px; border-radius: 3px; font-family: inherit; font-size: 13px;" />
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Contact Officer Name *</label>
                                <input type="text" name="contact_name" required placeholder="e.g. Amina Mohammed" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 9px 12px; border-radius: 3px; font-family: inherit; font-size: 13px;" />
                            </div>
                            <div>
                                <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Corporate Email *</label>
                                <input type="email" name="contact_email" required placeholder="officer@brand.com" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 9px 12px; border-radius: 3px; font-family: inherit; font-size: 13px;" />
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Phone / WhatsApp Line</label>
                                <input type="text" name="contact_phone" placeholder="+234 800 000 0000" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 9px 12px; border-radius: 3px; font-family: inherit; font-size: 13px;" />
                            </div>
                            <div>
                                <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Operating Territory / Country</label>
                                <input type="text" name="country" placeholder="e.g. Nigeria, Kenya, South Africa" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 9px 12px; border-radius: 3px; font-family: inherit; font-size: 13px;" />
                            </div>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Target Ad Placement *</label>
                            <select name="spot" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 9px 12px; border-radius: 3px; font-family: inherit; font-size: 13px;">
                                <?php foreach ($spots as $s_id => $s) : ?>
                                    <option value="<?php echo esc_attr($s_id); ?>">
                                        <?php echo esc_html($s['title']); ?> (CPM: ₦<?php echo number_format($s['cpm_ngn']); ?> / $<?php echo number_format($s['cpm_usd'], 2); ?> per 1k)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Impressions Booked *</label>
                                <input type="number" name="impressions_booked" value="25000" min="5000" step="1000" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 9px 12px; border-radius: 3px; font-family: inherit; font-size: 13px;" />
                            </div>
                            <div>
                                <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Initial Flight Status</label>
                                <select name="status" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 9px 12px; border-radius: 3px; font-family: inherit; font-size: 13px;">
                                    <option value="active">Active (Deliver Live Immediately)</option>
                                    <option value="pending_review">Pending Review (Hold until confirmed)</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Destination URL (Where Readers Land) *</label>
                            <input type="url" name="destination_url" required placeholder="https://brand.com/annual-report" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 9px 12px; border-radius: 3px; font-family: inherit; font-size: 13px;" />
                        </div>

                        <div style="margin-bottom: 1.75rem;">
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Creative Banner Asset (WebP, PNG, JPG, GIF) *</label>
                            <input type="file" name="creative_file" accept="image/*" required style="color: #A39A8E; font-size: 12px;" />
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                            <button type="submit" class="button button-primary" style="background: #D97706; border-color: #D97706; color: #171513; font-weight: 800; font-family: 'Geist Mono', monospace; padding: 8px 24px; font-size: 12px;">
                                Register &amp; Activate Ad Campaign
                            </button>
                        </div>
                    </form>
                </div>

            <?php endif; ?>

        </div>

        <!-- ============================================================= -->
        <!-- MODAL: EDIT CAMPAIGN INLINE                                   -->
        <!-- ============================================================= -->
        <div id="magafrique-edit-campaign-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 99999; align-items: center; justify-content: center; padding: 1rem;">
            <div style="background: #171513; border: 2px solid #D97706; border-radius: 4px; padding: 2rem; max-width: 600px; width: 100%; box-shadow: 0 16px 48px rgba(0,0,0,0.9); max-height: 90vh; overflow-y: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.75rem;">
                    <div>
                        <span style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #D97706; text-transform: uppercase;">EDIT CAMPAIGN PARAMETERS</span>
                        <h3 id="edit_modal_title" style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 1.45rem; margin: 2px 0 0;">
                            Edit Campaign
                        </h3>
                    </div>
                    <button type="button" onclick="document.getElementById('magafrique-edit-campaign-modal').style.display='none'" style="background: none; border: none; color: #FAF7F2; font-size: 1.5rem; cursor: pointer;">✕</button>
                </div>

                <form method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field('magafrique_edit_campaign_nonce'); ?>
                    <input type="hidden" name="magafrique_save_edit_campaign" value="1" />
                    <input type="hidden" id="edit_campaign_id" name="campaign_id" value="" />

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Brand / Company Name *</label>
                        <input type="text" id="edit_brand_name" name="brand_name" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;" />
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Contact Name *</label>
                            <input type="text" id="edit_contact_name" name="contact_name" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;" />
                        </div>
                        <div>
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Corporate Email *</label>
                            <input type="email" id="edit_contact_email" name="contact_email" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;" />
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Phone / WhatsApp</label>
                            <input type="text" id="edit_contact_phone" name="contact_phone" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;" />
                        </div>
                        <div>
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Country</label>
                            <input type="text" id="edit_country" name="country" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;" />
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Target Ad Spot</label>
                        <select id="edit_spot" name="spot" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;">
                            <?php foreach ($spots as $s_id => $s) : ?>
                                <option value="<?php echo esc_attr($s_id); ?>">
                                    <?php echo esc_html($s['title']); ?> (CPM: ₦<?php echo number_format($s['cpm_ngn']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Impressions Booked</label>
                            <input type="number" id="edit_impressions_booked" name="impressions_booked" min="1000" step="1000" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;" required />
                        </div>
                        <div>
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Currency</label>
                            <select id="edit_currency" name="currency" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;">
                                <option value="NGN">NGN (₦)</option>
                                <option value="USD">USD ($)</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Campaign State</label>
                            <select id="edit_status" name="status" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;">
                                <option value="active">Active (Serving Live)</option>
                                <option value="pending_review">Pending Review</option>
                                <option value="paused">Paused</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Payment State</label>
                            <select id="edit_payment_status" name="payment_status" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;">
                                <option value="paid">Paid &amp; Verified</option>
                                <option value="unpaid">Unpaid / Awaiting Wire</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Destination URL *</label>
                        <input type="url" id="edit_destination_url" name="destination_url" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px 10px; border-radius: 3px; font-size: 13px;" />
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 700; margin-bottom: 4px;">Replace Creative Banner (Optional)</label>
                        <input type="file" name="creative_file" accept="image/*" style="color: #A39A8E; font-size: 12px;" />
                        <span style="display: block; font-size: 10px; color: #78716C; margin-top: 3px;">Leave blank to preserve current creative banner image.</span>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                        <button type="button" onclick="document.getElementById('magafrique-edit-campaign-modal').style.display='none'" class="button" style="background: transparent; color: #FAF7F2;">Cancel</button>
                        <button type="submit" class="button button-primary" style="background: #D97706; border-color: #D97706; color: #171513; font-weight: 800; font-family: 'Geist Mono', monospace;">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- MODAL: IMAGE LIGHTBOX                                         -->
        <!-- ============================================================= -->
        <div id="magafrique-image-lightbox" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.92); z-index: 999999; align-items: center; justify-content: center; padding: 2rem;" onclick="this.style.display='none';">
            <div style="max-width: 900px; width: 100%; text-align: center;" onclick="event.stopPropagation();">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span id="lightbox_title" style="font-family: 'Geist Mono', monospace; font-size: 12px; color: #FBBF24; font-weight: 700;">Creative Asset</span>
                    <button type="button" onclick="document.getElementById('magafrique-image-lightbox').style.display='none'" style="background: none; border: none; color: #FFFFFF; font-size: 1.5rem; cursor: pointer;">✕</button>
                </div>
                <img id="lightbox_img" src="#" alt="Creative Preview" style="max-width: 100%; max-height: 80vh; border-radius: 4px; box-shadow: 0 12px 40px rgba(0,0,0,0.9); border: 1px solid rgba(255,255,255,0.2);" />
            </div>
        </div>

        <!-- Inline JavaScript for Modals & Lightbox -->
        <script>
        window.openEditModal = function(camp) {
            document.getElementById('edit_modal_title').textContent = 'Edit: ' + camp.brand_name + ' (#' + camp.booking_code + ')';
            document.getElementById('edit_campaign_id').value = camp.id;
            document.getElementById('edit_brand_name').value = camp.brand_name || '';
            document.getElementById('edit_contact_name').value = camp.contact_name || '';
            document.getElementById('edit_contact_email').value = camp.contact_email || '';
            document.getElementById('edit_contact_phone').value = camp.contact_phone || '';
            document.getElementById('edit_country').value = camp.country || '';
            document.getElementById('edit_spot').value = camp.spot || 'bottom';
            document.getElementById('edit_impressions_booked').value = camp.impressions_booked || 25000;
            document.getElementById('edit_currency').value = camp.currency || 'NGN';
            document.getElementById('edit_status').value = camp.status || 'pending_review';
            document.getElementById('edit_payment_status').value = camp.payment_status || 'unpaid';
            document.getElementById('edit_destination_url').value = camp.destination_url || '';
            document.getElementById('magafrique-edit-campaign-modal').style.display = 'flex';
        };

        window.openImageLightbox = function(url, title) {
            document.getElementById('lightbox_img').src = url;
            document.getElementById('lightbox_title').textContent = title + ' — Full Resolution Banner Preview';
            document.getElementById('magafrique-image-lightbox').style.display = 'flex';
        };
        </script>

        <?php
    }
}

/**
 * 5. Handle Admin Post Manual Campaign Creation
 */
add_action('admin_post_magazineafrique_admin_create_ad_campaign', function() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }
    check_admin_referer('magafrique_admin_create_ad');

    global $wpdb;
    $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';
    $spots = magazineafrique_get_ad_spots_matrix();

    $spot_key = sanitize_text_field($_POST['spot']);
    $spot_data = isset($spots[$spot_key]) ? $spots[$spot_key] : $spots['bottom'];
    $impressions = max(5000, intval($_POST['impressions_booked']));
    $cpm = floatval($spot_data['cpm_ngn']);
    $total_amount = ($impressions / 1000) * $cpm;

    $creative_url = '';
    if (!empty($_FILES['creative_file']['name'])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $attachment_id = media_handle_upload('creative_file', 0);
        if (!is_wp_error($attachment_id)) {
            $creative_url = wp_get_attachment_url($attachment_id);
        }
    }

    $booking_code = 'MA-AD-' . wp_rand(10000, 99999);
    $status = sanitize_text_field($_POST['status']);

    $wpdb->insert($table_name, array(
        'booking_code'       => $booking_code,
        'brand_name'         => sanitize_text_field($_POST['brand_name']),
        'contact_name'       => sanitize_text_field($_POST['contact_name']),
        'contact_email'      => sanitize_email($_POST['contact_email']),
        'contact_phone'      => sanitize_text_field($_POST['contact_phone'] ?? ''),
        'spot'               => $spot_key,
        'spot_title'         => $spot_data['title'],
        'cpm_rate'           => $cpm,
        'currency'           => 'NGN',
        'impressions_booked' => $impressions,
        'impressions_served' => 0,
        'clicks'             => 0,
        'total_amount'       => $total_amount,
        'creative_url'       => esc_url_raw($creative_url),
        'destination_url'    => esc_url_raw($_POST['destination_url']),
        'status'             => $status,
        'payment_status'     => ($status === 'active') ? 'paid' : 'unpaid',
        'created_at'         => current_time('mysql')
    ));

    wp_safe_redirect(admin_url('admin.php?page=magazineafrique-brand-ads&created=1'));
    exit;
});

/**
 * 6. Public AJAX Handler for Advertiser Booking & Creative Submission
 */
if (!function_exists('magazineafrique_ajax_submit_ad_booking')) {
    function magazineafrique_ajax_submit_ad_booking() {
        check_ajax_referer('magazineafrique_ad_booking_nonce', 'nonce');

        $brand_name   = sanitize_text_field($_POST['brand_name'] ?? '');
        $contact_name = sanitize_text_field($_POST['contact_name'] ?? '');
        $email        = sanitize_email($_POST['contact_email'] ?? '');
        $phone        = sanitize_text_field($_POST['contact_phone'] ?? '');
        $country      = sanitize_text_field($_POST['country'] ?? '');
        $spot_key     = sanitize_text_field($_POST['spot_key'] ?? $_POST['spot'] ?? 'header_masthead');
        $impressions  = max(5000, intval($_POST['impressions'] ?? 10000));
        $dest_url     = esc_url_raw($_POST['destination_url'] ?? '');
        $target_desk  = sanitize_text_field($_POST['target_desk'] ?? 'all');
        $currency     = sanitize_text_field($_POST['currency'] ?? 'NGN');

        if (empty($brand_name) || empty($contact_name) || !is_email($email) || empty($dest_url)) {
            wp_send_json_error(array('message' => 'Please fill in all required fields with a valid email and destination link.'));
        }

        $spots = magazineafrique_get_ad_spots_matrix();
        if (!isset($spots[$spot_key])) {
            $spot_key = 'header_masthead';
        }
        $spot_data = $spots[$spot_key];

        $cpm = ($currency === 'USD') ? $spot_data['cpm_usd'] : $spot_data['cpm_ngn'];
        $total_amount = ($impressions / 1000) * $cpm;

        // Handle Creative Upload (support both creative_asset and creative_file input names)
        $file_key = '';
        if (!empty($_FILES['creative_asset']['name'])) {
            $file_key = 'creative_asset';
        } elseif (!empty($_FILES['creative_file']['name'])) {
            $file_key = 'creative_file';
        }

        $creative_url = '';
        if (!empty($file_key)) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $attachment_id = media_handle_upload($file_key, 0);
            if (!is_wp_error($attachment_id)) {
                $creative_url = wp_get_attachment_url($attachment_id);
            }
        }

        if (empty($creative_url)) {
            wp_send_json_error(array('message' => 'Please upload a valid creative banner image (PNG, JPG, WebP, or GIF).'));
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';
        $booking_code = 'MA-AD-' . wp_rand(10000, 99999);

        $inserted = $wpdb->insert($table_name, array(
            'booking_code'       => $booking_code,
            'brand_name'         => $brand_name,
            'contact_name'       => $contact_name,
            'contact_email'      => $email,
            'contact_phone'      => $phone,
            'country'            => $country,
            'spot'               => $spot_key,
            'spot_title'         => $spot_data['title'],
            'cpm_rate'           => $cpm,
            'currency'           => $currency,
            'impressions_booked' => $impressions,
            'impressions_served' => 0,
            'clicks'             => 0,
            'total_amount'       => $total_amount,
            'creative_url'       => $creative_url,
            'destination_url'    => $dest_url,
            'target_desk'        => $target_desk,
            'status'             => 'pending_review',
            'payment_status'     => 'unpaid',
            'created_at'         => current_time('mysql')
        ));

        if (!$inserted) {
            wp_send_json_error(array('message' => 'Unable to record booking into database. Please try again or contact commercial@magazineafrique.org.'));
        }

        // Fetch Official Bank Settlement Details
        $bank = magazineafrique_get_ad_bank_details();
        $formatted_total = ($currency === 'USD' ? '$' : '₦') . number_format($total_amount);

        // 1. Send Administrative Notification
        $admin_email = get_option('admin_email');
        $subject = "[Brand Reach Ad Booking] #$booking_code — $brand_name";
        $message = "New Brand Reach Ad Space Reservation received on Continental Desk:\n\n" .
                   "Booking Code          : #$booking_code\n" .
                   "Brand                 : $brand_name\n" .
                   "Contact Officer       : $contact_name ($email, $phone)\n" .
                   "Jurisdiction          : $country\n" .
                   "Target Space          : " . $spot_data['title'] . "\n" .
                   "Guaranteed Impressions: " . number_format($impressions) . "\n" .
                   "CPM Rate              : " . ($currency === 'USD' ? '$' : '₦') . number_format($cpm) . "\n" .
                   "Total Investment      : $formatted_total\n" .
                   "Destination URL       : $dest_url\n" .
                   "Creative Asset        : $creative_url\n\n" .
                   "REMITTANCE ROUTING:\n" .
                   "Bank: " . $bank['bank_name'] . "\n" .
                   "Account Name: " . $bank['account_name'] . "\n" .
                   "Account Number: " . $bank['account_number'] . "\n" .
                   "WhatsApp Receipt Line: " . $bank['whatsapp_number'] . "\n\n" .
                   "Review and approve in WP-Admin > Gazette Desk > Brand Reach Ads.";
        wp_mail(array($admin_email, 'commercial@magazineafrique.org'), $subject, $message);

        // 2. Send Automated Branded Confirmation Email to Advertiser Desk
        $client_subject = "[Commercial Invoice & Remittance Wire] Ad Space Booking #$booking_code — $brand_name";
        $client_message = "Dear $contact_name,\n\n" .
            "Thank you for acquiring sovereign broadsheet ad space with Magazine Afrique.\n\n" .
            "CAMPAIGN RESERVATION DOSSIER:\n" .
            "====================================================\n" .
            "Official Booking Reference : #$booking_code\n" .
            "Brand / Organization       : $brand_name\n" .
            "Selected Ad Space          : " . $spot_data['title'] . "\n" .
            "Guaranteed Reach Delivery  : " . number_format($impressions) . " verified readers\n" .
            "Contract Investment Total  : $formatted_total\n" .
            "Destination URL            : $dest_url\n" .
            "====================================================\n\n" .
            "OFFICIAL REMITTANCE & WIRE INSTRUCTIONS:\n" .
            "----------------------------------------------------\n" .
            "Bank Institution           : " . $bank['bank_name'] . "\n" .
            "Beneficiary Account Name   : " . $bank['account_name'] . "\n" .
            "Account Number (10 Digits) : " . $bank['account_number'] . "\n" .
            "----------------------------------------------------\n\n" .
            "IMPORTANT RECEIPT ROUTING ADVISORY:\n" .
            "Send receipt to " . $bank['whatsapp_number'] . " on WhatsApp for faster response on any issue.\n\n" .
            "Direct 1-Click WhatsApp Receipt Link:\n" .
            "https://wa.me/" . $bank['whatsapp_intl'] . "?text=" . urlencode("Hello Magazine Afrique Commercial Desk, here is the payment receipt for Brand Reach Booking #" . $booking_code . " ($brand_name, $formatted_total).") . "\n\n" .
            "Upon receipt confirmation, our editorial ad server immediately activates your banner asset across all 54 jurisdictions.\n\n" .
            "Warm regards,\n" .
            "Continental Commercial Syndicate Desk\n" .
            "Magazine Afrique — Sovereign Pan-African Journalism\n" .
            "commercial@magazineafrique.org";

        $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: Magazine Afrique Commercial <commercial@magazineafrique.org>');
        wp_mail($email, $client_subject, $client_message, $headers);

        $wa_prefill = 'Hello Magazine Afrique Commercial Desk, I have transferred payment for Ad Space Booking #' . $booking_code . ' (' . $brand_name . ', ' . $formatted_total . '). Here is my payment receipt.';
        $wa_link = 'https://wa.me/' . $bank['whatsapp_intl'] . '?text=' . urlencode($wa_prefill);

        wp_send_json_success(array(
            'message'        => 'Booking reserved successfully! Our commercial desk has received your creative dossier.',
            'booking_code'   => $booking_code,
            'brand_name'     => $brand_name,
            'spot_title'     => $spot_data['title'],
            'impressions'    => number_format($impressions),
            'currency'       => $currency,
            'total_amount'   => number_format($total_amount),
            'bank_name'      => $bank['bank_name'],
            'account_name'   => $bank['account_name'],
            'account_number' => $bank['account_number'],
            'whatsapp_num'   => $bank['whatsapp_number'],
            'whatsapp_intl'  => $bank['whatsapp_intl'],
            'whatsapp_link'  => $wa_link,
            'instructions'   => 'Your campaign has been logged under reference #' . $booking_code . '. An invoice with Eco Bank wire remittance instructions has been dispatched to ' . $email . '. Send receipt to ' . $bank['whatsapp_number'] . ' on WhatsApp for faster response on any issue.'
        ));
    }
    add_action('wp_ajax_magazineafrique_submit_ad_booking', 'magazineafrique_ajax_submit_ad_booking');
    add_action('wp_ajax_nopriv_magazineafrique_submit_ad_booking', 'magazineafrique_ajax_submit_ad_booking');
}

/**
 * 7. Active Brand Reach Ad Retrival & Serving
 * Queries database for active direct brand campaigns.
 * If one is active and has remaining impressions, serves it and increments impressions.
 * If none active, impressions exhausted, or current 5-hour shift is reserved for Google Ads,
 * returns false (falls back to Google AdSense).
 */
if (!function_exists('magazineafrique_get_active_brand_ad')) {
    function magazineafrique_get_active_brand_ad($spot_key, $zone = '') {
        if (!function_exists('magazineafrique_should_display_ads') || !magazineafrique_should_display_ads()) {
            return false;
        }

        // 1. 5-Hour Space Rotation Check:
        // Direct Sponsored Ads and Google Ads cannot show in the same spot simultaneously.
        // Direct ads cannot take over all spaces — Google Ads must still run to maintain balance.
        // If this spot is currently rotated to Google Ads for this 5-hour shift, return false!
        if (!magazineafrique_is_spot_in_direct_shift($spot_key, $zone)) {
            return false;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';

        // Check if table exists
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            return false;
        }

        // Query active campaign with remaining impressions
        // If multiple active campaigns exist, serve round-robin by lowest impressions_served
        $campaign = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name 
             WHERE status = 'active' 
             AND spot = %s 
             AND impressions_served < impressions_booked 
             ORDER BY impressions_served ASC, id ASC LIMIT 1",
            $spot_key
        ));

        if (!$campaign) {
            return false;
        }

        // Atomically increment impressions served
        $wpdb->query($wpdb->prepare(
            "UPDATE $table_name SET impressions_served = impressions_served + 1 WHERE id = %d",
            $campaign->id
        ));

        // Auto-complete if impressions reached
        if (($campaign->impressions_served + 1) >= $campaign->impressions_booked) {
            $wpdb->update($table_name, array('status' => 'completed'), array('id' => $campaign->id));
        }

        return $campaign;
    }
}

/**
 * 8. Track Clicks On Direct Brand Reach Ads
 */
if (!function_exists('magazineafrique_ajax_track_brand_ad_click')) {
    function magazineafrique_ajax_track_brand_ad_click() {
        $campaign_id = intval($_POST['campaign_id'] ?? 0);
        if ($campaign_id > 0) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';
            $wpdb->query($wpdb->prepare(
                "UPDATE $table_name SET clicks = clicks + 1 WHERE id = %d",
                $campaign_id
            ));
        }
        wp_send_json_success();
    }
    add_action('wp_ajax_magazineafrique_track_ad_click', 'magazineafrique_ajax_track_brand_ad_click');
    add_action('wp_ajax_nopriv_magazineafrique_track_ad_click', 'magazineafrique_ajax_track_brand_ad_click');
}
