<?php
/**
 * Magazine Afrique — Full Creative SaaS Admin Workspace Theme
 * 1:1 Implementation of the ArtCraft UI/UX Architecture
 * Completely self-contained in the theme. Zero separate plugins.
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Enqueue ArtCraft Dark Workspace Styles & Scripts in WP-Admin
 */
if (!function_exists('magazineafrique_enqueue_admin_assets')) {
    function magazineafrique_enqueue_admin_assets($hook) {
        $uri = get_theme_file_uri();
        $ver = defined('MAGAZINEAFRIQUE_VERSION') ? MAGAZINEAFRIQUE_VERSION : '1.2.3';

        // Custom ArtCraft Workspace CSS
        wp_enqueue_style(
            'magazineafrique-admin-style',
            $uri . '/assets/css/admin-style.css',
            array(),
            $ver
        );

        // Google Fonts for Admin Workspace (Plus Jakarta Sans & JetBrains Mono)
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
    add_action('admin_enqueue_scripts', 'magazineafrique_enqueue_admin_assets', 999);
}

/**
 * 2. Customize WP Admin Menu & Add Gazette Desk
 */
if (!function_exists('magazineafrique_customize_admin_menu')) {
    function magazineafrique_customize_admin_menu() {
        add_menu_page(
            'Gazette Desk',
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
 * 3. Replace Default Dashboard with ArtCraft Workspace
 */
if (!function_exists('magazineafrique_custom_dashboard_setup')) {
    function magazineafrique_custom_dashboard_setup() {
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

            // Add our Full-Width ArtCraft Editorial Workspace Widget
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

    /**
     * Render Workspace directly into Dashboard page content
     * Guarantees 100% reliable rendering above WordPress metaboxes
     */
    add_action('all_admin_notices', function() {
        $screen = get_current_screen();
        if ($screen && $screen->id === 'dashboard') {
            magazineafrique_render_workspace_dashboard();
        }
    });
}

/**
 * 4. Render the Exact ArtCraft UI/UX Workspace
 */
if (!function_exists('magazineafrique_render_workspace_dashboard')) {
    function magazineafrique_render_workspace_dashboard() {
        $site_url = home_url('/');
        ?>
        <div class="workspace-editorial-container">
            
            <!-- Top Pill Bar (Matches ArtCraft [ HOME ] bar) -->
            <div class="workspace-top-pill-bar">
                <div class="artcraft-home-pill">
                    HOME
                </div>
                <div class="artcraft-right-links">
                    <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" target="_blank" class="artcraft-link-text">
                        ★ Club Prestige
                    </a>
                    <a href="<?php echo esc_url($site_url); ?>" target="_blank" class="artcraft-btn-white">
                        Live Gazette ↗
                    </a>
                </div>
            </div>

            <!-- Hero Header (User Specified Title) -->
            <div class="workspace-hero-header">
                <div class="workspace-tag-badge">YOUR EDITORIAL WORKSPACE</div>
                <h1 class="workspace-main-title">
                    What do you want to <span class="highlight-blue">work</span> on today?
                </h1>
                <p class="workspace-subtitle">
                    Start with an idea. Choose a tool to bring it to life.
                </p>
            </div>

            <!-- Section Header & Line (Matches ArtCraft CREATE section) -->
            <div class="workspace-section-header-row">
                <div class="workspace-section-label">CREATE &amp; MANAGE</div>
                <div class="workspace-section-divider"></div>
            </div>

            <!-- Cards Grid (Exact User Specified Tools) -->
            <div class="workspace-tools-grid">
                
                <!-- 1. ADD A POST -->
                <a href="<?php echo esc_url(admin_url('post-new.php')); ?>" class="workspace-tool-card">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-blue">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">ADD A POST</h3>
                            </div>
                        </div>
                        <div class="tool-card-arrow">→</div>
                    </div>
                    <p class="tool-desc">Draft breaking dispatch, investigative report, or exclusive dossier.</p>
                </a>

                <!-- 2. ADD A CATEGORY -->
                <a href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=category')); ?>" class="workspace-tool-card">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-gold">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">ADD A CATEGORY</h3>
                            </div>
                        </div>
                        <div class="tool-card-arrow">→</div>
                    </div>
                    <p class="tool-desc">Create or organize news desks, geopolitical sections, and tags.</p>
                </a>

                <!-- 3. ADD MEDIA -->
                <a href="<?php echo esc_url(admin_url('media-new.php')); ?>" class="workspace-tool-card">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-cyan">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">ADD MEDIA</h3>
                            </div>
                        </div>
                        <div class="tool-card-arrow">→</div>
                    </div>
                    <p class="tool-desc">Upload vintage archival photography, illustrations, maps, and charts.</p>
                </a>

                <!-- 4. CLEAR CACHE -->
                <div class="workspace-tool-card" id="admin-purge-cache-card" style="cursor: pointer;">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-red">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="23 4 23 10 17 10"></polyline>
                                    <polyline points="1 20 1 14 7 14"></polyline>
                                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">CLEAR CACHE</h3>
                                <span class="tool-tag-beta">1-CLICK</span>
                            </div>
                        </div>
                        <div class="tool-card-arrow" id="admin-cache-spinner">↻</div>
                    </div>
                    <p class="tool-desc" id="admin-cache-status-text">Purge LiteSpeed edge cache and PWA Service Worker.</p>
                </div>

                <!-- 5. SETTINGS -->
                <a href="<?php echo esc_url(admin_url('options-general.php')); ?>" class="workspace-tool-card">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-purple">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">SETTINGS</h3>
                            </div>
                        </div>
                        <div class="tool-card-arrow">→</div>
                    </div>
                    <p class="tool-desc">Configure site parameters, reading rules, and AdSense desk.</p>
                </a>

                <!-- 6. USERS -->
                <a href="<?php echo esc_url(admin_url('users.php')); ?>" class="workspace-tool-card">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-orange">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">USERS</h3>
                            </div>
                        </div>
                        <div class="tool-card-arrow">→</div>
                    </div>
                    <p class="tool-desc">Manage editors, correspondents, subscribers, and reader profiles.</p>
                </a>

                <!-- 7. PAYWALL MANAGEMENT -->
                <a href="<?php echo esc_url(admin_url('admin.php?page=magazineafrique-desk')); ?>" class="workspace-tool-card">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-emerald">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">PAYWALL MANAGEMENT</h3>
                                <span class="tool-tag-new">PREMIUM</span>
                            </div>
                        </div>
                        <div class="tool-card-arrow">→</div>
                    </div>
                    <p class="tool-desc">Configure Club Prestige tiers ($4.99, $12, $39) and exclusive gating.</p>
                </a>

                <!-- 8. ANALYTICS (Site Kit by Google) -->
                <a href="<?php echo esc_url(admin_url('admin.php?page=googlesitekit-dashboard')); ?>" class="workspace-tool-card">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-blue">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">ANALYTICS</h3>
                                <span class="tool-tag-beta">SITE KIT</span>
                            </div>
                        </div>
                        <div class="tool-card-arrow">→</div>
                    </div>
                    <p class="tool-desc">View Google Search Console traffic, search queries, and views.</p>
                </a>

                <!-- 9. PLUGINS -->
                <a href="<?php echo esc_url(admin_url('plugins.php')); ?>" class="workspace-tool-card">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-amber">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">PLUGINS</h3>
                            </div>
                        </div>
                        <div class="tool-card-arrow">→</div>
                    </div>
                    <p class="tool-desc">Manage installed extensions, SEO, performance, and add-ons.</p>
                </a>

                <!-- 10. COMMENTS -->
                <a href="<?php echo esc_url(admin_url('edit-comments.php')); ?>" class="workspace-tool-card">
                    <div class="tool-card-top">
                        <div class="tool-badge-cluster">
                            <div class="tool-icon-box bg-indigo">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </div>
                            <div class="tool-name-wrap">
                                <h3 class="tool-name">COMMENTS</h3>
                            </div>
                        </div>
                        <div class="tool-card-arrow">→</div>
                    </div>
                    <p class="tool-desc">Moderate reader discussions, feedback, and correspondence.</p>
                </a>

            </div>

        </div>
        <?php
    }
}

/**
 * 5. Dedicated Gazette Desk Options Page
 */
if (!function_exists('magazineafrique_render_admin_desk_page')) {
    function magazineafrique_render_admin_desk_page() {
        if (!current_user_can('manage_options')) return;

        $message = '';
        if (isset($_POST['magazineafrique_save_desk_nonce']) && wp_verify_nonce($_POST['magazineafrique_save_desk_nonce'], 'magazineafrique_save_desk')) {
            if (isset($_POST['adsense_client_id'])) {
                update_option('magazineafrique_adsense_client_id', sanitize_text_field($_POST['adsense_client_id']));
            }
            $message = 'Publisher settings updated successfully.';
        }

        $current_adsense_id = get_option('magazineafrique_adsense_client_id', 'ca-pub-7175564788277515');
        ?>
        <div class="workspace-editorial-container">
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
                <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34D399; padding: 0.85rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; font-weight: 600;">
                    ✓ <?php echo esc_html($message); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <?php wp_nonce_field('magazineafrique_save_desk', 'magazineafrique_save_desk_nonce'); ?>

                <div class="workspace-tool-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
                    <h3 style="color: #FFFFFF; font-size: 1rem; font-weight: 700; margin: 0 0 0.5rem;">Google AdSense Publisher ID</h3>
                    <p style="color: var(--art-text-sub); font-size: 13px; margin: 0 0 1rem;">
                        Configured for zero Cumulative Layout Shift (CLS) in header, article middle break, and sidebar.
                    </p>
                    <input type="text" name="adsense_client_id" value="<?php echo esc_attr($current_adsense_id); ?>" style="width: 100%; max-width: 440px; font-family: 'JetBrains Mono', monospace;" required />
                    
                    <div style="margin-top: 1.25rem;">
                        <button type="submit" class="button-primary">
                            Save Publisher ID
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }
}
