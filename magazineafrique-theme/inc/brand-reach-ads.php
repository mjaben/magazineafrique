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
 * 2. CPM Rate & Spot Inventory Matrix
 */
if (!function_exists('magazineafrique_get_ad_spots_matrix')) {
    function magazineafrique_get_ad_spots_matrix() {
        return array(
            'header_masthead' => array(
                'id'            => 'header_masthead',
                'title'         => 'Prime Masthead Leaderboard',
                'placement'     => 'Top of Masthead (Immediate Viewport)',
                'cpm_ngn'       => 10000,
                'cpm_usd'       => 10.00,
                'tier'          => 'Prime Position',
                'badge'         => 'HIGHEST VISIBILITY',
                'dimensions'    => '728x90 / 970x90 Desktop · 320x50 Mobile',
                'description'   => 'Unmatched initial impact on every desktop, tablet, and mobile visit. Positioned directly below the dateline header.'
            ),
            'in_article' => array(
                'id'            => 'in_article',
                'title'         => 'Mid-Dossier Editorial Core',
                'placement'     => 'Embedded Within Investigative Articles',
                'cpm_ngn'       => 8000,
                'cpm_usd'       => 8.00,
                'tier'          => 'Core Engagement',
                'badge'         => 'LONGEST DWELL TIME',
                'dimensions'    => 'Fluid Native / 300x250 Medium Rectangle',
                'description'   => 'High-attention interstitial placement inserted right after article lead paragraphs when reader focus is at its maximum peak.'
            ),
            'sidebar' => array(
                'id'            => 'sidebar',
                'title'         => 'Continental Telegraph Sidebar',
                'placement'     => 'Sticky Reading Companion (Desktop & Tablet)',
                'cpm_ngn'       => 6500,
                'cpm_usd'       => 6.50,
                'tier'          => 'Persistent Reach',
                'badge'         => 'HIGH VIEWABILITY',
                'dimensions'    => '300x250 / 300x600 Half-Page Box',
                'description'   => 'Stays persistently in reader view as visitors scroll through real-time intelligence feeds and long-form analysis.'
            ),
            'bottom' => array(
                'id'            => 'bottom',
                'title'         => 'Broadsheet Bottom Leaderboard',
                'placement'     => 'Above Footer (All Reports & Home)',
                'cpm_ngn'       => 5000,
                'cpm_usd'       => 5.00,
                'tier'          => 'Baseline Reach',
                'badge'         => 'BASE RATE',
                'dimensions'    => '728x90 / 970x90 Desktop · 300x250 Mobile',
                'description'   => 'Broadsheet full-width closing placement seen by all engaged readers completing briefings, dispatches, and sector archives.'
            )
        );
    }
}

/**
 * 3. Register ArtCraft Dark Admin Management Screen under Gazette Desk
 */
if (!function_exists('magazineafrique_register_brand_ads_admin_menu')) {
    function magazineafrique_register_brand_ads_admin_menu() {
        add_submenu_page(
            'magazineafrique-desk',
            'Brand Reach Ads — Inventory & CPM Campaigns',
            'Brand Reach Ads',
            'manage_options',
            'magazineafrique-brand-ads',
            'magazineafrique_render_brand_ads_admin_page'
        );
    }
    add_action('admin_menu', 'magazineafrique_register_brand_ads_admin_menu', 20);
}

/**
 * 4. Render ArtCraft Dark Admin Page for Brand Reach Campaigns
 */
if (!function_exists('magazineafrique_render_brand_ads_admin_page')) {
    function magazineafrique_render_brand_ads_admin_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';

        // Process status action if requested
        if (isset($_GET['action'], $_GET['campaign_id']) && check_admin_referer('magafrique_ad_action')) {
            $campaign_id = intval($_GET['campaign_id']);
            $action = sanitize_text_field($_GET['action']);

            if ($action === 'activate') {
                $wpdb->update($table_name, array('status' => 'active', 'payment_status' => 'paid'), array('id' => $campaign_id));
                echo '<div class="notice notice-success is-dismissible"><p>✓ Campaign #' . $campaign_id . ' activated and set live on site.</p></div>';
            } elseif ($action === 'pause') {
                $wpdb->update($table_name, array('status' => 'paused'), array('id' => $campaign_id));
                echo '<div class="notice notice-warning is-dismissible"><p>● Campaign #' . $campaign_id . ' paused.</p></div>';
            } elseif ($action === 'complete') {
                $wpdb->update($table_name, array('status' => 'completed'), array('id' => $campaign_id));
                echo '<div class="notice notice-info is-dismissible"><p>✓ Campaign #' . $campaign_id . ' marked as completed.</p></div>';
            } elseif ($action === 'delete') {
                $wpdb->delete($table_name, array('id' => $campaign_id));
                echo '<div class="notice notice-error is-dismissible"><p>✕ Campaign #' . $campaign_id . ' deleted.</p></div>';
            }
        }

        // Query Campaign Totals & Metrics
        $total_campaigns = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $active_campaigns = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'active'");
        $pending_campaigns = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'pending_review'");
        $total_impressions_served = (int) $wpdb->get_var("SELECT SUM(impressions_served) FROM $table_name");
        $total_impressions_booked = (int) $wpdb->get_var("SELECT SUM(impressions_booked) FROM $table_name");
        $total_revenue_ngn = (float) $wpdb->get_var("SELECT SUM(total_amount) FROM $table_name WHERE currency = 'NGN' AND payment_status = 'paid'");

        // Query Campaign List
        $current_filter = isset($_GET['status_filter']) ? sanitize_text_field($_GET['status_filter']) : 'all';
        $where_clause = ($current_filter !== 'all') ? $wpdb->prepare("WHERE status = %s", $current_filter) : "";
        $campaigns = $wpdb->get_results("SELECT * FROM $table_name $where_clause ORDER BY id DESC LIMIT 100");
        $spots = magazineafrique_get_ad_spots_matrix();
        ?>
        <div class="wrap artcraft-dark-canvas" style="padding-top: 1rem;">
            
            <!-- ArtCraft Masthead Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                        <span style="background: #D97706; color: #171513; font-family: 'Geist Mono', monospace; font-size: 10px; font-weight: 900; padding: 2px 6px; border-radius: 3px;">
                            MONETIZATION DESK
                        </span>
                        <span style="font-family: 'Geist Mono', monospace; font-size: 11px; color: #A39A8E;">
                            BRAND REACH INVENTORY (CPM MODEL)
                        </span>
                    </div>
                    <h1 style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 1.85rem; font-weight: 800; margin: 0;">
                        Direct Brand Reach Ad Campaigns
                    </h1>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="<?php echo esc_url(home_url('/advertise/')); ?>" target="_blank" class="button" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 11px;">
                        ↗ View Live Buy Ad Space Page
                    </a>
                    <button type="button" onclick="document.getElementById('manual-ad-modal').style.display='flex'" class="button button-primary" style="background: #D97706; border-color: #D97706; color: #171513; font-weight: 800; font-family: 'Geist Mono', monospace; font-size: 11px;">
                        + Book Manual Campaign
                    </button>
                </div>
            </div>

            <!-- Metrics Cluster Bar -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: #171513; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.3);">
                    <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.35rem;">Active Live Reach Ads</div>
                    <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #FBBF24;">
                        <?php echo esc_html($active_campaigns); ?> <span style="font-size: 0.875rem; color: #78716C;">/ <?php echo esc_html($total_campaigns); ?> total</span>
                    </div>
                </div>

                <div style="background: #171513; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.3);">
                    <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.35rem;">Impressions Delivered</div>
                    <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #FFFFFF;">
                        <?php echo number_format($total_impressions_served); ?>
                    </div>
                    <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #78716C; margin-top: 2px;">
                        Booked: <?php echo number_format($total_impressions_booked); ?>
                    </div>
                </div>

                <div style="background: #171513; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.3);">
                    <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.35rem;">Total Direct Revenue</div>
                    <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #34D399;">
                        ₦<?php echo number_format($total_revenue_ngn); ?>
                    </div>
                </div>

                <div style="background: #171513; border: 1px solid rgba(255,255,255,0.12); padding: 1.25rem; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.3);">
                    <div style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.35rem;">Pending Approvals</div>
                    <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #F59E0B;">
                        <?php echo esc_html($pending_campaigns); ?>
                    </div>
                </div>
            </div>

            <!-- Spot Inventory Pricing Matrix Reference -->
            <div style="background: #1A1816; border: 1px solid rgba(217, 119, 6, 0.3); border-radius: 4px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 800; color: #FBBF24; text-transform: uppercase;">
                        ❖ Active Spot CPM Rate Matrix (Brand Reach Model)
                    </span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E;">
                        Direct Brand Ad Takes Priority Over Google AdSense When Active
                    </span>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.75rem;">
                    <?php foreach ($spots as $s_id => $s) : ?>
                        <div style="background: #141210; border: 1px solid rgba(255,255,255,0.08); padding: 0.75rem; border-radius: 3px;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                <strong style="color: #FAF7F2; font-size: 12px;"><?php echo esc_html($s['title']); ?></strong>
                                <span style="font-family: 'Geist Mono', monospace; font-size: 11px; font-weight: 800; color: #D97706;">
                                    ₦<?php echo number_format($s['cpm_ngn']); ?> / 1k
                                </span>
                            </div>
                            <div style="font-family: 'Geist Mono', monospace; font-size: 9.5px; color: #78716C; margin-top: 4px;">
                                <?php echo esc_html($s['dimensions']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Campaign Filter Tabs -->
            <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; font-family: 'Geist Mono', monospace; font-size: 11px;">
                <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&status_filter=all')); ?>" style="padding: 4px 10px; border-radius: 3px; text-decoration: none; <?php echo $current_filter === 'all' ? 'background: #D97706; color: #171513; font-weight: 800;' : 'background: rgba(255,255,255,0.06); color: #FAF7F2;'; ?>">
                    All (<?php echo esc_html($total_campaigns); ?>)
                </a>
                <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&status_filter=active')); ?>" style="padding: 4px 10px; border-radius: 3px; text-decoration: none; <?php echo $current_filter === 'active' ? 'background: #D97706; color: #171513; font-weight: 800;' : 'background: rgba(255,255,255,0.06); color: #FAF7F2;'; ?>">
                    Active Live (<?php echo esc_html($active_campaigns); ?>)
                </a>
                <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&status_filter=pending_review')); ?>" style="padding: 4px 10px; border-radius: 3px; text-decoration: none; <?php echo $current_filter === 'pending_review' ? 'background: #D97706; color: #171513; font-weight: 800;' : 'background: rgba(255,255,255,0.06); color: #FAF7F2;'; ?>">
                    Pending Review (<?php echo esc_html($pending_campaigns); ?>)
                </a>
                <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-brand-ads&status_filter=completed')); ?>" style="padding: 4px 10px; border-radius: 3px; text-decoration: none; <?php echo $current_filter === 'completed' ? 'background: #D97706; color: #171513; font-weight: 800;' : 'background: rgba(255,255,255,0.06); color: #FAF7F2;'; ?>">
                    Completed
                </a>
            </div>

            <!-- Campaign Cards Grid -->
            <?php if (empty($campaigns)) : ?>
                <div style="background: #171513; border: 1px dashed rgba(255,255,255,0.15); border-radius: 4px; padding: 3rem 1.5rem; text-align: center; color: #A39A8E;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📢</div>
                    <h3 style="color: #FAF7F2; font-family: 'Newsreader', Georgia, serif; font-size: 1.35rem; margin: 0 0 0.5rem;">No Brand Reach Campaigns Found</h3>
                    <p style="font-size: 13px; max-width: 440px; margin: 0 auto 1.25rem;">
                        Direct advertisers can purchase guaranteed impression space directly through the public booking portal, or you can register an offline contract above.
                    </p>
                    <a href="<?php echo esc_url(home_url('/advertise/')); ?>" target="_blank" class="button" style="background: #D97706; color: #171513; border: none; font-weight: 800;">
                        Open Public Booking Portal →
                    </a>
                </div>
            <?php else : ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 1.25rem;">
                    <?php foreach ($campaigns as $camp) : 
                        $pct = ($camp->impressions_booked > 0) ? min(100, round(($camp->impressions_served / $camp->impressions_booked) * 100, 1)) : 0;
                        $status_badge_color = '#F59E0B';
                        if ($camp->status === 'active') $status_badge_color = '#34D399';
                        if ($camp->status === 'completed') $status_badge_color = '#A39A8E';
                        if ($camp->status === 'paused') $status_badge_color = '#FB923C';
                    ?>
                        <div style="background: #171513; border: 1px solid rgba(255,255,255,0.14); border-radius: 4px; padding: 1.25rem; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 8px 24px rgba(0,0,0,0.45); position: relative;">
                            
                            <div>
                                <!-- Header row -->
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-family: 'Geist Mono', monospace; font-size: 10px; font-weight: 800; color: #D97706;">
                                        #<?php echo esc_html($camp->booking_code); ?>
                                    </span>
                                    <span style="font-family: 'Geist Mono', monospace; font-size: 10px; font-weight: 800; text-transform: uppercase; color: <?php echo esc_attr($status_badge_color); ?>; background: rgba(255,255,255,0.06); padding: 2px 7px; border-radius: 3px; border: 1px solid rgba(255,255,255,0.1);">
                                        ● <?php echo esc_html(str_replace('_', ' ', $camp->status)); ?>
                                    </span>
                                </div>

                                <h3 style="color: #FFFFFF; font-family: 'Archivo', sans-serif; font-size: 1.15rem; font-weight: 700; margin: 0 0 0.35rem;">
                                    <?php echo esc_html($camp->brand_name); ?>
                                </h3>
                                <div style="font-family: 'Geist Mono', monospace; font-size: 11px; color: #A39A8E; margin-bottom: 0.75rem;">
                                    <?php echo esc_html($camp->contact_name); ?> · <a href="mailto:<?php echo esc_attr($camp->contact_email); ?>" style="color: #D97706;"><?php echo esc_html($camp->contact_email); ?></a>
                                    <?php if (!empty($camp->contact_phone)) echo ' · ' . esc_html($camp->contact_phone); ?>
                                </div>

                                <!-- Spot Info Box -->
                                <div style="background: #141210; border: 1px solid rgba(255,255,255,0.08); padding: 0.75rem; border-radius: 3px; margin-bottom: 0.75rem;">
                                    <div style="display: flex; justify-content: space-between; font-size: 11.5px; color: #FAF7F2; margin-bottom: 4px;">
                                        <span>Target Spot:</span>
                                        <strong style="color: #FBBF24;"><?php echo esc_html($camp->spot_title); ?></strong>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; font-family: 'Geist Mono', monospace; font-size: 11px; color: #A39A8E;">
                                        <span>CPM Rate:</span>
                                        <span>₦<?php echo number_format($camp->cpm_rate); ?> / 1,000 imps</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; font-family: 'Geist Mono', monospace; font-size: 11px; color: #A39A8E; margin-top: 2px;">
                                        <span>Total Budget:</span>
                                        <strong style="color: #34D399;">₦<?php echo number_format($camp->total_amount); ?></strong>
                                    </div>
                                </div>

                                <!-- Impression Progress Bar -->
                                <div style="margin-bottom: 0.85rem;">
                                    <div style="display: flex; justify-content: space-between; font-family: 'Geist Mono', monospace; font-size: 10px; color: #A39A8E; margin-bottom: 4px;">
                                        <span>Served: <?php echo number_format($camp->impressions_served); ?> / <?php echo number_format($camp->impressions_booked); ?> imps</span>
                                        <span style="font-weight: 700; color: #FAF7F2;"><?php echo esc_html($pct); ?>%</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background: rgba(255,255,255,0.08); border-radius: 3px; overflow: hidden;">
                                        <div style="width: <?php echo esc_attr($pct); ?>%; height: 100%; background: #D97706;"></div>
                                    </div>
                                </div>

                                <!-- Creative Thumbnail Preview -->
                                <?php if (!empty($camp->creative_url)) : ?>
                                    <div style="margin-bottom: 0.75rem;">
                                        <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 9.5px; color: #78716C; margin-bottom: 3px;">CREATIVE ASSET:</span>
                                        <div style="max-height: 80px; overflow: hidden; border-radius: 2px; border: 1px solid rgba(255,255,255,0.1); background: #000;">
                                            <img src="<?php echo esc_url($camp->creative_url); ?>" alt="Creative" style="width: 100%; height: auto; display: block; object-fit: contain;" />
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($camp->destination_url)) : ?>
                                    <div style="font-family: 'Geist Mono', monospace; font-size: 11px; color: #A39A8E; word-break: break-all; margin-bottom: 0.75rem;">
                                        Link: <a href="<?php echo esc_url($camp->destination_url); ?>" target="_blank" style="color: #D6CEC3;"><?php echo esc_html($camp->destination_url); ?> ↗</a>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Action Bar -->
                            <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                <?php if ($camp->status !== 'active') : ?>
                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=activate&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" class="button button-small" style="background: #10B981; border-color: #10B981; color: #000000; font-weight: 800; font-family: 'Geist Mono', monospace; font-size: 10.5px;">
                                        ✓ Approve &amp; Make Live
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=pause&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" class="button button-small" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #FAF7F2; font-family: 'Geist Mono', monospace; font-size: 10.5px;">
                                        Pause
                                    </a>
                                <?php endif; ?>

                                <?php if ($camp->status !== 'completed') : ?>
                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=complete&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" class="button button-small" style="font-family: 'Geist Mono', monospace; font-size: 10.5px;">
                                        Mark Completed
                                    </a>
                                <?php endif; ?>

                                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=magazineafrique-brand-ads&action=delete&campaign_id=' . $camp->id), 'magafrique_ad_action')); ?>" onclick="return confirm('Delete this campaign record permanently?');" class="button button-small button-link-delete" style="font-family: 'Geist Mono', monospace; font-size: 10.5px; margin-left: auto;">
                                    Delete
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- Manual Campaign Booking Modal for Editorial Staff -->
        <div id="manual-ad-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 99999; align-items: center; justify-content: center; padding: 1rem;">
            <div style="background: #171513; border: 1px solid #D97706; border-radius: 4px; padding: 2rem; max-width: 540px; width: 100%; box-shadow: 0 16px 48px rgba(0,0,0,0.8); max-height: 90vh; overflow-y: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.75rem;">
                    <h3 style="color: #FFFFFF; font-family: 'Newsreader', Georgia, serif; font-size: 1.35rem; margin: 0;">
                        Book Offline / Direct Contract Brand Reach Campaign
                    </h3>
                    <button type="button" onclick="document.getElementById('manual-ad-modal').style.display='none'" style="background: none; border: none; color: #FAF7F2; font-size: 1.25rem; cursor: pointer;">✕</button>
                </div>
                
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="magazineafrique_admin_create_ad_campaign" />
                    <?php wp_nonce_field('magafrique_admin_create_ad'); ?>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: #FAF7F2; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Brand / Company Name *</label>
                        <input type="text" name="brand_name" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px; border-radius: 3px;" />
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; color: #FAF7F2; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Contact Name *</label>
                            <input type="text" name="contact_name" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px; border-radius: 3px;" />
                        </div>
                        <div>
                            <label style="display: block; color: #FAF7F2; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Work Email *</label>
                            <input type="email" name="contact_email" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px; border-radius: 3px;" />
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: #FAF7F2; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Ad Spot Inventory *</label>
                        <select name="spot" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px; border-radius: 3px;">
                            <?php foreach ($spots as $s_id => $s) : ?>
                                <option value="<?php echo esc_attr($s_id); ?>">
                                    <?php echo esc_html($s['title']); ?> (CPM: ₦<?php echo number_format($s['cpm_ngn']); ?> / 1k imps)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; color: #FAF7F2; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Impressions Booked *</label>
                            <input type="number" name="impressions_booked" value="25000" min="5000" step="1000" required style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px; border-radius: 3px;" />
                        </div>
                        <div>
                            <label style="display: block; color: #FAF7F2; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Status Immediately</label>
                            <select name="status" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px; border-radius: 3px;">
                                <option value="active">Active (Serve Immediately)</option>
                                <option value="pending_review">Pending Review</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: #FAF7F2; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Destination URL (Link to brand site) *</label>
                        <input type="url" name="destination_url" required placeholder="https://brand.com/campaign" style="width: 100%; background: #1F1D1A; border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; padding: 8px; border-radius: 3px;" />
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: #FAF7F2; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Upload Creative Banner (PNG/JPG/WebP/GIF) *</label>
                        <input type="file" name="creative_file" accept="image/*" required style="color: #A39A8E; font-size: 12px;" />
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                        <button type="button" onclick="document.getElementById('manual-ad-modal').style.display='none'" class="button" style="background: transparent; color: #FAF7F2;">Cancel</button>
                        <button type="submit" class="button button-primary" style="background: #D97706; border-color: #D97706; color: #171513; font-weight: 800;">Register &amp; Save Campaign</button>
                    </div>
                </form>
            </div>
        </div>
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
        $spot_key     = sanitize_text_field($_POST['spot'] ?? 'bottom');
        $impressions  = max(5000, intval($_POST['impressions'] ?? 10000));
        $dest_url     = esc_url_raw($_POST['destination_url'] ?? '');
        $target_desk  = sanitize_text_field($_POST['target_desk'] ?? 'all');
        $currency     = sanitize_text_field($_POST['currency'] ?? 'NGN');

        if (empty($brand_name) || empty($contact_name) || !is_email($email) || empty($dest_url)) {
            wp_send_json_error(array('message' => 'Please fill in all required fields with a valid email and destination link.'));
        }

        $spots = magazineafrique_get_ad_spots_matrix();
        if (!isset($spots[$spot_key])) {
            $spot_key = 'bottom';
        }
        $spot_data = $spots[$spot_key];

        $cpm = ($currency === 'USD') ? $spot_data['cpm_usd'] : $spot_data['cpm_ngn'];
        $total_amount = ($impressions / 1000) * $cpm;

        // Handle Creative Upload
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

        // Send Administrative Notification
        $admin_email = get_option('admin_email');
        $subject = "[Brand Reach Ad Booking] #$booking_code — $brand_name";
        $message = "New Brand Reach Ad Space Reservation received:\n\n" .
                   "Booking Code: $booking_code\n" .
                   "Brand: $brand_name\n" .
                   "Contact: $contact_name ($email, $phone)\n" .
                   "Spot: " . $spot_data['title'] . "\n" .
                   "Guaranteed Impressions: " . number_format($impressions) . "\n" .
                   "CPM Rate: " . ($currency === 'USD' ? '$' : '₦') . number_format($cpm) . "\n" .
                   "Total Budget: " . ($currency === 'USD' ? '$' : '₦') . number_format($total_amount) . "\n" .
                   "Destination: $dest_url\n" .
                   "Creative Asset: $creative_url\n\n" .
                   "Review and approve this campaign in WP-Admin > Gazette Desk > Brand Reach Ads.";
        wp_mail(array($admin_email, 'commercial@magazineafrique.org'), $subject, $message);

        wp_send_json_success(array(
            'message'        => 'Booking reserved successfully! Our commercial desk has received your creative dossier.',
            'booking_code'   => $booking_code,
            'brand_name'     => $brand_name,
            'spot_title'     => $spot_data['title'],
            'impressions'    => number_format($impressions),
            'currency'       => $currency,
            'total_amount'   => number_format($total_amount),
            'instructions'   => 'Your campaign has been logged under reference #' . $booking_code . '. An invoice with sovereign wire instructions has been dispatched to ' . $email . '. Upon confirmation, your brand reach campaign goes live immediately.'
        ));
    }
    add_action('wp_ajax_magazineafrique_submit_ad_booking', 'magazineafrique_ajax_submit_ad_booking');
    add_action('wp_ajax_nopriv_magazineafrique_submit_ad_booking', 'magazineafrique_ajax_submit_ad_booking');
}

/**
 * 7. Active Brand Reach Ad Retrival & Serving
 * Queries database for active direct brand campaigns.
 * If one is active and has remaining impressions, serves it and increments impressions.
 * If none active or impressions exhausted, returns false (falls back to Google AdSense).
 */
if (!function_exists('magazineafrique_get_active_brand_ad')) {
    function magazineafrique_get_active_brand_ad($spot_key) {
        if (!function_exists('magazineafrique_should_display_ads') || !magazineafrique_should_display_ads()) {
            return false;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'magazineafrique_ad_campaigns';

        // Check if table exists
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            return false;
        }

        $campaign = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name 
             WHERE status = 'active' 
             AND spot = %s 
             AND impressions_served < impressions_booked 
             ORDER BY id ASC LIMIT 1",
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
