<?php
/**
 * Magazine Afrique — Theme Functions & Engine Core
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('MAGAZINEAFRIQUE_VERSION')) {
    define('MAGAZINEAFRIQUE_VERSION', '1.8.4');
}

/**
 * Theme Setup
 */
if (!function_exists('magazineafrique_setup')) {
    function magazineafrique_setup() {
        // Translation support
        load_theme_textdomain('magazineafrique', __DIR__ . '/languages');

        // Feed links
        add_theme_support('automatic-feed-links');

        // Document title
        add_theme_support('title-tag');

        // Post thumbnails
        add_theme_support('post-thumbnails');

        // Custom image sizes optimized for editorial & Google Discover
        set_post_thumbnail_size(1200, 675, true);
        add_image_size('magazine-hero', 1200, 675, true);
        add_image_size('magazine-card', 600, 400, true);
        add_image_size('magazine-thumb', 300, 200, true);

        // Register Nav Menus
        register_nav_menus(array(
            'primary' => esc_html__('Main Menu (Header)', 'magazineafrique'),
            'footer'  => esc_html__('Footer Menu', 'magazineafrique'),
        ));

        // HTML5 support
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Responsive embeds
        add_theme_support('responsive-embeds');

        // Custom Logo Support
        add_theme_support('custom-logo', array(
            'height'      => 80,
            'width'       => 320,
            'flex-width'  => true,
            'flex-height' => true,
        ));
    }
}
add_action('after_setup_theme', 'magazineafrique_setup');

/**
 * Enqueue scripts and styles
 */
if (!function_exists('magazineafrique_scripts')) {
    function magazineafrique_scripts() {
        $uri = get_theme_file_uri();

        // Main compiled production styles
        wp_enqueue_style(
            'magazineafrique-main',
            $uri . '/assets/css/main.css',
            array(),
            MAGAZINEAFRIQUE_VERSION
        );

        // Theme style.css
        wp_enqueue_style(
            'magazineafrique-style',
            get_stylesheet_uri(),
            array('magazineafrique-main'),
            MAGAZINEAFRIQUE_VERSION
        );

        // Main client script
        wp_enqueue_script(
            'magazineafrique-script',
            $uri . '/assets/js/main.js',
            array(),
            MAGAZINEAFRIQUE_VERSION,
            true
        );

        // Unified Reader Engine (Multilingual, Smart Scroll, Live Likes & Shares, Bookmarks, Dark Mode)
        wp_enqueue_script(
            'magazineafrique-reader-engine',
            $uri . '/assets/js/reader-engine.js',
            array(),
            MAGAZINEAFRIQUE_VERSION,
            true
        );

        // Detect reader country from proxy headers (Cloudflare, LiteSpeed, etc.)
        $detected_country = sanitize_text_field($_SERVER['HTTP_CF_IPCOUNTRY'] ?? $_SERVER['HTTP_X_COUNTRY_CODE'] ?? $_SERVER['GEOIP_COUNTRY_CODE'] ?? '');

        // Localize script with AJAX URL, nonce, and version
        wp_localize_script('magazineafrique-script', 'magazineafrique_vars', array(
            'ajax_url'    => admin_url('admin-ajax.php'),
            'nonce'       => wp_create_nonce('magazineafrique_nonce'),
            'version'     => MAGAZINEAFRIQUE_VERSION,
            'geo_country' => $detected_country
        ));

        wp_localize_script('magazineafrique-reader-engine', 'magazineafrique_vars', array(
            'ajax_url'    => admin_url('admin-ajax.php'),
            'nonce'       => wp_create_nonce('magazineafrique_nonce'),
            'version'     => MAGAZINEAFRIQUE_VERSION,
            'geo_country' => $detected_country
        ));
    }
}
add_action('wp_enqueue_scripts', 'magazineafrique_scripts');

/**
 * Register Widget Area
 */
if (!function_exists('magazineafrique_widgets_init')) {
    function magazineafrique_widgets_init() {
        register_sidebar(array(
            'name'          => esc_html__('Editorial Sidebar', 'magazineafrique'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Widgets added here appear in article and category sidebars.', 'magazineafrique'),
            'before_widget' => '<section id="%1$s" class="widget card-editorial p-4 mb-6 %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h4 class="font-serif font-bold text-base border-b border-[#E8E2D8] pb-2 mb-3 text-[#1C1917]">',
            'after_title'   => '</h4>',
        ));
    }
}
add_action('widgets_init', 'magazineafrique_widgets_init');

/**
 * Include Modular Features safely using __DIR__
 */
$inc_files = array(
    __DIR__ . '/inc/template-tags.php',
    __DIR__ . '/inc/paywall.php',
    __DIR__ . '/inc/ads.php',
    __DIR__ . '/inc/newsletter.php',
    __DIR__ . '/inc/subscribers-manager.php',
    __DIR__ . '/inc/ai-schema.php',
    __DIR__ . '/inc/pwa.php',
    __DIR__ . '/inc/mail-template.php',
    __DIR__ . '/inc/onboarding-profile.php',
    __DIR__ . '/inc/admin-dashboard.php',
    __DIR__ . '/inc/admin-security-login.php',
    __DIR__ . '/inc/brand-reach-ads.php',
    __DIR__ . '/inc/cookie-consent.php',
    __DIR__ . '/inc/seo.php'
);

foreach ($inc_files as $file) {
    if (file_exists($file)) {
        require_once $file;
    }
}
