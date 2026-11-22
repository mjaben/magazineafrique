<?php
/**
 * Magazine Afrique — Header Template
 * Primary Language: English with Pan-African Multilingual Support (FR, AR, PT, SW)
 *
 * @package MagazineAfrique
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Preload Featured Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google AdSense / GPT Tag (Async) -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXXX" crossorigin="anonymous"></script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Top Utility Bar -->
<div class="top-nav-bar">
    <div class="container-editorial" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
        
        <!-- Left: Edition, Date & Language Switcher -->
        <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.75rem;">
            <span style="font-weight: 800; color: #0B5128;">Pan-African Edition</span>
            <span style="color: #A8A29E;">|</span>
            <span style="color: #66615B;"><?php echo esc_html(date_i18n('l, j F Y')); ?></span>
            
            <!-- Language Switcher Pill -->
            <span style="color: #A8A29E;">|</span>
            <div class="lang-selector-wrapper" style="position: relative; display: inline-block;">
                <button id="lang-menu-btn" style="background: #FFFFFF; border: 1px solid #E8E2D8; border-radius: 9999px; padding: 0.15rem 0.6rem; font-size: 0.6875rem; font-weight: 700; color: #1C1917; cursor: pointer; display: flex; align-items: center; gap: 0.35rem;">
                    <span>🌍</span>
                    <span id="current-lang-label">English (EN)</span>
                    <span style="font-size: 0.6rem;">▼</span>
                </button>
                <div id="lang-dropdown" class="hidden" style="position: absolute; top: 120%; left: 0; background: #FFFFFF; border: 1px solid #E8E2D8; border-radius: 0.5rem; box-shadow: 0 10px 20px rgba(0,0,0,0.08); min-width: 150px; z-index: 70; padding: 0.35rem 0;">
                    <a href="?lang=en" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.4rem 0.75rem; font-size: 0.75rem; font-weight: 700; color: #0B5128; background: #EFF5EE;">
                        <span>English</span><span style="font-size: 0.65rem; color: #78716C;">EN</span>
                    </a>
                    <a href="?lang=fr" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.4rem 0.75rem; font-size: 0.75rem; color: #1C1917;">
                        <span>Français</span><span style="font-size: 0.65rem; color: #78716C;">FR</span>
                    </a>
                    <a href="?lang=ar" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.4rem 0.75rem; font-size: 0.75rem; color: #1C1917;">
                        <span>العربية</span><span style="font-size: 0.65rem; color: #78716C;">AR</span>
                    </a>
                    <a href="?lang=pt" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.4rem 0.75rem; font-size: 0.75rem; color: #1C1917;">
                        <span>Português</span><span style="font-size: 0.65rem; color: #78716C;">PT</span>
                    </a>
                    <a href="?lang=sw" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.4rem 0.75rem; font-size: 0.75rem; color: #1C1917;">
                        <span>Kiswahili</span><span style="font-size: 0.65rem; color: #78716C;">SW</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right: Newsletter, Subscribe & Auth Links -->
        <div style="display: flex; align-items: center; gap: 0.85rem; font-size: 0.75rem;">
            <a href="<?php echo esc_url(home_url('/newsletter/')); ?>" style="color: #66615B; font-weight: 600;">
                ✉ Newsletter
            </a>
            <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" style="background-color: #0B5128; color: #FFFFFF !important; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-weight: 700; transition: background 0.2s;">
                Subscribe
            </a>
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" style="color: #66615B;">Sign Out</a>
            <?php else : ?>
                <a href="<?php echo esc_url(wp_login_url()); ?>" style="color: #66615B; font-weight: 600;">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Main Masthead -->
<header class="site-masthead">
    <div class="container-editorial" style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 0.75rem;">
        <div style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
            <!-- Mobile Menu Toggle Button -->
            <button id="mobile-menu-toggle" aria-label="Menu" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #1C1917; display: flex; align-items: center; gap: 0.35rem;">
                <span>☰</span>
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Menu</span>
            </button>

            <!-- Brand Logo -->
            <div style="flex: 1; display: flex; justify-content: center;">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" style="display: inline-block;">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.jpg'); ?>" alt="<?php bloginfo('name'); ?>" style="max-height: 65px; width: auto; object-fit: contain;" />
                    <?php endif; ?>
                </a>
            </div>

            <!-- Search Toggle Button -->
            <button id="search-toggle" aria-label="Search" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #1C1917;">
                🔍
            </button>
        </div>

        <p style="font-size: 0.8125rem; color: #66615B; font-style: italic; max-width: 620px; margin: 0 auto;">
            The Premier Pan-African Review: Strategic Economics, Geopolitics, Technology, and Cultural Foresight.
        </p>
    </div>
</header>

<!-- Sticky Navigation Bar -->
<nav class="main-nav" aria-label="<?php esc_attr_e('Main Menu', 'magazineafrique'); ?>">
    <div class="container-editorial">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class'     => 'nav-links',
            'container'      => false,
            'fallback_cb'    => function() {
                echo '<ul class="nav-links">';
                echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
                $cats = get_categories(array('number' => 6));
                foreach ($cats as $cat) {
                    echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
                }
                echo '<li><a href="' . esc_url(home_url('/club-afrique/')) . '" style="color: #D97706;">★ Club Prestige</a></li>';
                echo '</ul>';
            }
        ));
        ?>
    </div>
</nav>

<!-- Mobile Navigation Drawer -->
<div id="mobile-nav-drawer" class="hidden" style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 80;">
    <div style="background: #FAF8F5; width: 85%; max-width: 320px; height: 100%; padding: 1.5rem; overflow-y: auto; display: flex; flex-direction: column; gap: 1.5rem; box-shadow: 2px 0 10px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E8E2D8; padding-bottom: 1rem;">
            <span style="font-weight: 800; color: #0B5128; font-size: 1.125rem;">Magazine Afrique</span>
            <button id="close-mobile-menu" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">✕</button>
        </div>

        <div>
            <h4 style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #78716C; margin-bottom: 0.75rem;">Sections</h4>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false
            ));
            ?>
        </div>

        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid #E8E2D8; display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="btn-paywall-cta" style="text-align: center;">
                Join Club Prestige
            </a>
            <a href="<?php echo esc_url(home_url('/newsletter/')); ?>" style="text-align: center; font-size: 0.8125rem; font-weight: 700; color: #0B5128;">
                ✉ The Africa Brief Newsletter
            </a>
        </div>
    </div>
</div>

<!-- Search Modal -->
<div id="search-modal" class="hidden" style="position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 90; display: flex; align-items: flex-start; justify-content: center; padding-top: 5rem;">
    <div style="background: #FAF8F5; width: 90%; max-width: 600px; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 class="font-serif" style="font-size: 1.25rem; font-weight: 700;">Search Magazine Afrique</h3>
            <button id="search-close" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;">✕</button>
        </div>
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display: flex; gap: 0.5rem;">
            <input type="search" name="s" placeholder="Search by topic, country, leader..." style="flex: 1; padding: 0.75rem; border: 1px solid #E8E2D8; border-radius: 0.375rem; outline: none;" />
            <button type="submit" class="btn-newsletter-submit">Search</button>
        </form>
    </div>
</div>

<!-- Header Leaderboard Ad Slot (Zero-CLS container) -->
<div class="container-editorial">
    <?php magazineafrique_render_ad_leaderboard(); ?>
</div>
