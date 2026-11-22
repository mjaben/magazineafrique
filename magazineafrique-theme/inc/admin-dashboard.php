<?php
/**
 * Magazine Afrique — Custom Editorial Admin Dashboard
 * High-End Dark Creative SaaS UI/UX (Matching ArtCraft Workspace Architecture)
 * Directly built into the theme with zero separate plugins.
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Enqueue Dark Workspace Styles & Scripts in WP-Admin
 */
if (!function_exists('magazineafrique_enqueue_admin_assets')) {
    function magazineafrique_enqueue_admin_assets($hook) {
        $uri = get_theme_file_uri();
        $ver = defined('MAGAZINEAFRIQUE_VERSION') ? MAGAZINEAFRIQUE_VERSION : '1.2.0';

        // Custom Dark Workspace CSS
        wp_enqueue_style(
            'magazineafrique-admin-style',
            $uri . '/assets/css/admin-style.css',
            array(),
            $ver
        );

        // Google Fonts for Admin Workspace (Inter / Plus Jakarta Sans)
        wp_enqueue_style(
            'magazineafrique-admin-fonts',
            'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap',
            array(),
            null
        );

        // Admin Workspace Script
        wp_enqueue_script(
            'magazineafrique-admin-script',
            $uri . '/assets/js/admin-script.js',
            array('jquery'),
            $ver,
            true
        );

        wp_localize_script('magazineafrique-admin-script', 'magafrique_admin_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('magafrique_admin_nonce'),
            'home_url' => home_url('/')
        ));
    }
    add_action('admin_enqueue_scripts', 'magazineafrique_enqueue_admin_assets');
}

/**
 * 2. Customize WP Admin Menu & Add Brand Header
 */
if (!function_exists('magazineafrique_customize_admin_menu')) {
    function magazineafrique_customize_admin_menu() {
        // Add Magazine Afrique Options Menu Page
        add_menu_page(
            'Magazine Afrique Desk',
            'Gazette Desk',
            'manage_options',
            'magazineafrique-desk',
            'magazineafrique_render_admin_desk_page',
            'dashicons-media-document',
            2
        );
    }
    add_action('admin_menu', 'magazineafrique_customize_admin_menu');
}

/**
 * 3. Replace Default Dashboard with Editorial Creative Workspace
 */
if (!function_exists('magazineafrique_custom_dashboard_setup')) {
    function magazineafrique_custom_dashboard_setup() {
        global $wp_meta_boxes;

        // Only on main dashboard
        $screen = get_current_screen();
        if ($screen && $screen->id === 'dashboard') {
            // Remove standard clutter widgets
            remove_meta_box('dashboard_activity', 'dashboard', 'normal');
            remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
            remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
            remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
            remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
            remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
            remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
            remove_meta_box('dashboard_primary', 'dashboard', 'side');
            remove_meta_box('dashboard_secondary', 'dashboard', 'side');
            remove_action('welcome_panel', 'wp_welcome_panel');

            // Add our Full-Width Creative Editorial Workspace Widget
            wp_add_dashboard_widget(
                'magazineafrique_editorial_workspace_widget',
                'Editorial Command Workspace',
                'magazineafrique_render_workspace_dashboard',
                null,
                null,
                'normal',
                'high'
            );
        }
    }
    add_action('wp_dashboard_setup', 'magazineafrique_custom_dashboard_setup', 999);
}

/**
 * 4. Render the Full Creative Workspace Dashboard UI
 */
if (!function_exists('magazineafrique_render_workspace_dashboard')) {
    function magazineafrique_render_workspace_dashboard() {
        $published_posts = wp_count_posts()->publish;
        $draft_posts = wp_count_posts()->draft;
        $users_count = count_users()['total_users'];
        $categories_count = wp_count_terms('category');
        $site_url = home_url('/');
        $admin_url = admin_url();
        ?>
        <div class="workspace-editorial-container">
            
            <!-- Top Workspace Header (Matches ArtCraft Style) -->
            <div class="workspace-hero-header">
                <div class="workspace-tag-badge">YOUR EDITORIAL WORKSPACE</div>
                <h1 class="workspace-main-title">
                    What will you <span class="highlight-blue">publish</span> today?
                </h1>
                <p class="workspace-subtitle">
                    Start with an idea. Choose a tool or section to bring pan-African journalism to life.
                </p>
            </div>

            <!-- Metric Quick-Bar -->
            <div class="workspace-metrics-bar">
                <div class="metric-pill">
                    <span class="metric-label">Published Dispatches:</span>
                    <strong class="metric-value"><?php echo esc_html($published_posts); ?></strong>
                </div>
                <div class="metric-pill">
                    <span class="metric-label">Editorial Drafts:</span>
                    <strong class="metric-value"><?php echo esc_html($draft_posts); ?></strong>
                </div>
                <div class="metric-pill">
                    <span class="metric-label">Active Readers:</span>
                    <strong class="metric-value"><?php echo esc_html($users_count); ?></strong>
                </div>
                <div class="metric-pill">
                    <span class="metric-label">Geopolitical Desks:</span>
                    <strong class="metric-value"><?php echo esc_html($categories_count); ?></strong>
                </div>
                <div class="metric-pill metric-pill-adsense">
                    <span class="metric-label">AdSense Status:</span>
                    <strong class="metric-value metric-live">● Active</strong>
                </div>
            </div>

            <!-- Action Grid (3x3 matching ArtCraft UI/UX) -->
            <div class="workspace-section-label">CREATE &amp; MANAGE</div>

            <div class="workspace-tools-grid">
                
                <!-- 1. WRITE NEW ARTICLE -->
                <a href="<?php echo esc_url(admin_url('post-new.php')); ?>" class="workspace-tool-card card-accent-blue">
                    <div class="tool-card-left">
                        <div class="tool-icon-box bg-blue">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                        </div>
                        <div class="tool-content">
                            <h3 class="tool-name">WRITE ARTICLE</h3>
                            <p class="tool-desc">Draft breaking reports, investigative dossiers, or analysis.</p>
                        </div>
                    </div>
                    <div class="tool-card-arrow">→</div>
                </a>

                <!-- 2. EDITORIAL ARCHIVE -->
                <a href="<?php echo esc_url(admin_url('edit.php')); ?>" class="workspace-tool-card card-accent-purple">
                    <div class="tool-card-left">
                        <div class="tool-icon-box bg-purple">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                        </div>
                        <div class="tool-content">
                            <h3 class="tool-name">EDITORIAL DESK</h3>
                            <p class="tool-desc">Review submitted drafts, scheduled stories, and live articles.</p>
                        </div>
                    </div>
                    <div class="tool-card-arrow">→</div>
                </a>

                <!-- 3. CATEGORIES & TOPIC DESKS -->
                <a href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=category')); ?>" class="workspace-tool-card card-accent-gold">
                    <div class="tool-card-left">
                        <div class="tool-icon-box bg-gold">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                            </svg>
                        </div>
                        <div class="tool-content">
                            <h3 class="tool-name">DESKS &amp; TOPICS</h3>
                            <p class="tool-desc">Organize Geopolitics, Mining, Economy, and Cultural desks.</p>
                        </div>
                    </div>
                    <div class="tool-card-arrow">→</div>
                </a>

                <!-- 4. MEDIA VAULT -->
                <a href="<?php echo esc_url(admin_url('upload.php')); ?>" class="workspace-tool-card card-accent-cyan">
                    <div class="tool-card-left">
                        <div class="tool-icon-box bg-cyan">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </div>
                        <div class="tool-content">
                            <h3 class="tool-name">MEDIA VAULT</h3>
                            <p class="tool-desc">Upload vintage archival imagery, charts, and infographics.</p>
                        </div>
                    </div>
                    <div class="tool-card-arrow">→</div>
                </a>

                <!-- 5. CLUB PRESTIGE PAYWALL -->
                <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" target="_blank" class="workspace-tool-card card-accent-emerald">
                    <div class="tool-card-left">
                        <div class="tool-icon-box bg-emerald">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        </div>
                        <div class="tool-content">
                            <h3 class="tool-name">CLUB PRESTIGE</h3>
                            <p class="tool-desc">Manage the 5 exclusive subscriber benefits &amp; gating engine.</p>
                        </div>
                    </div>
                    <div class="tool-card-arrow">→</div>
                </a>

                <!-- 6. ADSENSE MONETIZATION -->
                <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-desk')); ?>" class="workspace-tool-card card-accent-amber">
                    <div class="tool-card-left">
                        <div class="tool-icon-box bg-amber">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <div class="tool-content">
                            <h3 class="tool-name">ADSENSE DESK</h3>
                            <p class="tool-desc">ca-pub-7175564788277515 slots: leaderboard, article &amp; sidebar.</p>
                        </div>
                    </div>
                    <div class="tool-card-arrow">→</div>
                </a>

                <!-- 7. READER NETWORK & PROFILES -->
                <a href="<?php echo esc_url(admin_url('users.php')); ?>" class="workspace-tool-card card-accent-orange">
                    <div class="tool-card-left">
                        <div class="tool-icon-box bg-orange">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="tool-content">
                            <h3 class="tool-name">READER NETWORK</h3>
                            <p class="tool-desc">Inspect registered readers, auto-locations, and saved dossiers.</p>
                        </div>
                    </div>
                    <div class="tool-card-arrow">→</div>
                </a>

                <!-- 8. BREAKING NOTIFICATIONS -->
                <a href="<?php echo esc_url(home_url('/notifications/')); ?>" target="_blank" class="workspace-tool-card card-accent-indigo">
                    <div class="tool-card-left">
                        <div class="tool-icon-box bg-indigo">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                        </div>
                        <div class="tool-content">
                            <h3 class="tool-name">BREAKING ALERTS</h3>
                            <p class="tool-desc">Preview notification board and reader dispatch channels.</p>
                        </div>
                    </div>
                    <div class="tool-card-arrow">→</div>
                </a>

                <!-- 9. CACHE PURGE & RELOAD -->
                <div class="workspace-tool-card card-accent-teal" id="admin-purge-cache-card" style="cursor: pointer;">
                    <div class="tool-card-left">
                        <div class="tool-icon-box bg-teal">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="23 4 23 10 17 10"></polyline>
                                <polyline points="1 20 1 14 7 14"></polyline>
                                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                            </svg>
                        </div>
                        <div class="tool-content">
                            <h3 class="tool-name">PURGE CACHE</h3>
                            <p class="tool-desc" id="admin-cache-status-text">1-click instant LiteSpeed &amp; PWA Service Worker purge.</p>
                        </div>
                    </div>
                    <div class="tool-card-arrow" id="admin-cache-spinner">↻</div>
                </div>

            </div>

            <!-- Footer Quick Launch Strip -->
            <div class="workspace-footer-banner">
                <div class="footer-banner-left">
                    <span class="banner-badge">LIVE EDITION</span>
                    <span class="banner-title">Magazine Afrique — Pan-African Gazette</span>
                </div>
                <div class="footer-banner-actions">
                    <a href="<?php echo esc_url($site_url); ?>" target="_blank" class="btn-workspace-preview">
                        View Live Gazette ↗
                    </a>
                </div>
            </div>

        </div>
        <?php
    }
}

/**
 * 5. Render Dedicated Gazette Desk Admin Options Page
 */
if (!function_exists('magazineafrique_render_admin_desk_page')) {
    function magazineafrique_render_admin_desk_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Save Settings
        $message = '';
        if (isset($_POST['magazineafrique_save_desk_nonce']) && wp_verify_nonce($_POST['magazineafrique_save_desk_nonce'], 'magazineafrique_save_desk')) {
            if (isset($_POST['adsense_client_id'])) {
                update_option('magazineafrique_adsense_client_id', sanitize_text_field($_POST['adsense_client_id']));
            }
            $message = 'Settings updated successfully.';
        }

        $current_adsense_id = get_option('magazineafrique_adsense_client_id', 'ca-pub-7175564788277515');
        ?>
        <div class="workspace-editorial-container" style="margin-top: 2rem;">
            <div class="workspace-hero-header">
                <div class="workspace-tag-badge">CONFIGURATION DESK</div>
                <h1 class="workspace-main-title">
                    Monetization &amp; <span class="highlight-blue">AdSense</span> Settings
                </h1>
                <p class="workspace-subtitle">
                    Configure your high-yield publisher tag and editorial layout controls.
                </p>
            </div>

            <?php if ($message) : ?>
                <div style="background: rgba(34, 197, 94, 0.15); border: 1px solid #22C55E; color: #4ADE80; padding: 0.85rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600;">
                    ✓ <?php echo esc_html($message); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="" class="workspace-desk-form">
                <?php wp_nonce_field('magazineafrique_save_desk', 'magazineafrique_save_desk_nonce'); ?>

                <div class="desk-form-card">
                    <h3 class="form-card-title">Google AdSense Publisher ID</h3>
                    <p class="form-card-desc">
                        Your registered AdSense client ID. Automatically applied to header, in-article breaks, and sidebars with zero CLS layout reservation.
                    </p>
                    <input type="text" name="adsense_client_id" value="<?php echo esc_attr($current_adsense_id); ?>" class="workspace-input-text" placeholder="ca-pub-7175564788277515" required />
                    
                    <div style="margin-top: 1.5rem;">
                        <button type="submit" class="btn-workspace-submit">
                            Save Publisher Settings
                        </button>
                    </div>
                </div>

                <div class="desk-form-card" style="margin-top: 1.5rem;">
                    <h3 class="form-card-title">Club Prestige Gating Rules</h3>
                    <p class="form-card-desc">
                        5 Active Benefits:
                    </p>
                    <ul style="color: #94A3B8; font-size: 0.875rem; line-height: 1.8; list-style: disc; padding-left: 1.25rem;">
                        <li>Exclusive in-depth dossiers &amp; diplomatic intelligence</li>
                        <li>100% Ad-Free reading experience across all devices</li>
                        <li>Video format news opinion feature for subscribers</li>
                        <li>African business, mining, and commodity market data</li>
                        <li>First-hand political rumors &amp; geopolitical forecasting</li>
                    </ul>
                </div>
            </form>
        </div>
        <?php
    }
}
