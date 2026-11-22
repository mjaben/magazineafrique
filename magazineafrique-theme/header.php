<?php
/**
 * Magazine Afrique — Header Template
 * Mobile App UI/UX with Bottom Navigation & Pan-African Multilingual Support
 *
 * @package MagazineAfrique
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
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

<!-- Desktop Top Utility Bar (Hidden on Mobile) -->
<div class="top-nav-bar" style="display: none;">
    <div class="container-editorial" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.75rem;">
            <span style="font-weight: 800; color: #0B5128;">Pan-African Edition</span>
            <span style="color: #A8A29E;">|</span>
            <span style="color: #66615B;"><?php echo esc_html(date_i18n('l, j F Y')); ?></span>
            
            <!-- Language Switcher Pill -->
            <span style="color: #A8A29E;">|</span>
            <div class="lang-selector-wrapper" style="position: relative; display: inline-block;">
                <button id="lang-menu-btn" type="button" style="background: #FFFFFF; border: 1px solid #E8E2D8; border-radius: 9999px; padding: 0.2rem 0.65rem; font-size: 0.6875rem; font-weight: 700; color: #1C1917; cursor: pointer; display: flex; align-items: center; gap: 0.35rem;">
                    <span>🌍</span>
                    <span id="current-lang-label">English (EN)</span>
                    <span style="font-size: 0.55rem; color: #78716C;">▼</span>
                </button>
                <div id="lang-dropdown" class="hidden" style="position: absolute; top: 125%; left: 0; background: #FFFFFF; border: 1px solid #E8E2D8; border-radius: 0.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.12); min-width: 155px; z-index: 70; padding: 0.35rem 0;">
                    <a href="?lang=en" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.45rem 0.85rem; font-size: 0.75rem; font-weight: 700; color: #0B5128; background: #EFF5EE;">
                        <span>English</span><span style="font-size: 0.65rem; color: #78716C;">EN</span>
                    </a>
                    <a href="?lang=fr" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.45rem 0.85rem; font-size: 0.75rem; color: #1C1917;">
                        <span>Français</span><span style="font-size: 0.65rem; color: #78716C;">FR</span>
                    </a>
                    <a href="?lang=ar" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.45rem 0.85rem; font-size: 0.75rem; color: #1C1917;">
                        <span>العربية</span><span style="font-size: 0.65rem; color: #78716C;">AR</span>
                    </a>
                    <a href="?lang=pt" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.45rem 0.85rem; font-size: 0.75rem; color: #1C1917;">
                        <span>Português</span><span style="font-size: 0.65rem; color: #78716C;">PT</span>
                    </a>
                    <a href="?lang=sw" class="lang-option" style="display: flex; align-items: center; justify-content: space-between; padding: 0.45rem 0.85rem; font-size: 0.75rem; color: #1C1917;">
                        <span>Kiswahili</span><span style="font-size: 0.65rem; color: #78716C;">SW</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Links -->
        <div style="display: flex; align-items: center; gap: 0.85rem; font-size: 0.75rem;">
            <a href="<?php echo esc_url(home_url('/newsletter/')); ?>" style="color: #66615B; font-weight: 600;">✉ Newsletter</a>
            <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" style="background-color: #0B5128; color: #FFFFFF !important; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-weight: 700;">Subscribe</a>
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" style="color: #66615B;">Sign Out</a>
            <?php else : ?>
                <a href="<?php echo esc_url(wp_login_url()); ?>" style="color: #66615B; font-weight: 600;">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ===================================================
     NATIVE APP HEADER (Sticky Top Bar on Mobile & Desktop)
     =================================================== -->
<header class="site-masthead" style="position: sticky; top: 0; z-index: 50; background: rgba(250, 248, 245, 0.96); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
    <div class="container-editorial" style="display: flex; align-items: center; justify-content: space-between; padding: 0.4rem 1rem;">
        
        <!-- Left: App Menu Drawer Trigger -->
        <button id="mobile-menu-toggle" type="button" aria-label="Open App Menu" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #1C1917; width: 40px; height: 40px; display: flex; align-items: center; justify-content: flex-start;">
            <span>☰</span>
        </button>

        <!-- Center: App Brand Logo -->
        <div style="flex: 1; display: flex; justify-content: center; align-items: center;">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" style="display: flex; align-items: center; justify-content: center;">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/logo.jpg')); ?>" alt="<?php bloginfo('name'); ?>" style="max-height: 48px; width: auto; object-fit: contain;" />
                <?php endif; ?>
            </a>
        </div>

        <!-- Right: Push Notification Bell & Search Buttons -->
        <div style="display: flex; align-items: center; gap: 0.35rem; width: 40px; justify-content: flex-end;">
            <button id="push-bell-btn" type="button" aria-label="Enable Push Notifications" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #1C1917; padding: 0.25rem;" onclick="if(window.magazineafriqueRequestPush) window.magazineafriqueRequestPush();">
                🔔
            </button>
        </div>
    </div>
</header>

<!-- ===================================================
     SWIPEABLE APP CATEGORY CHIPS (Horizontal Scroll)
     =================================================== -->
<div class="app-category-chips">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="app-chip active">🔥 Top Stories</a>
    <?php
    $categories = get_categories(array('number' => 7, 'hide_empty' => false, 'orderby' => 'count', 'order' => 'DESC'));
    foreach ($categories as $cat) {
        $is_gold = in_array(strtolower($cat->slug), array('economy', 'business', 'tech', 'exclusive'));
        $chip_class = $is_gold ? 'app-chip chip-gold' : 'app-chip';
        echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="' . esc_attr($chip_class) . '">' . esc_html($cat->name) . '</a>';
    }
    ?>
    <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="app-chip chip-gold">★ Club Prestige</a>
</div>

<!-- Desktop Classic Nav Bar (Hidden on Mobile via CSS) -->
<nav class="main-nav" style="display: none;" aria-label="<?php esc_attr_e('Main Menu', 'magazineafrique'); ?>">
    <div class="container-editorial">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class'     => 'nav-links',
            'container'      => false,
            'fallback_cb'    => 'magazineafrique_desktop_menu_fallback'
        ));
        ?>
    </div>
</nav>

<!-- ===================================================
     MOBILE APP SLIDING DRAWER (NATIVE APP SHEET)
     =================================================== -->
<div id="mobile-nav-drawer" class="app-drawer-backdrop hidden" role="dialog" aria-modal="true">
    <div id="mobile-nav-panel" class="app-drawer-panel">
        
        <!-- Drawer Header / User Profile Card -->
        <div class="app-drawer-user-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 44px; height: 44px; border-radius: 9999px; background: #0B5128; border: 2px solid #D97706; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; font-weight: 800; color: #FFFFFF;">
                        MA
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 1rem; color: #FFFFFF; line-height: 1.2;">
                            Magazine Afrique
                        </div>
                        <div style="font-size: 0.75rem; color: #F59E0B; font-weight: 600;">
                            Pan-African Edition
                        </div>
                    </div>
                </div>
                <button id="close-mobile-menu" type="button" aria-label="Close menu" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #D1D5DB; padding: 0.2rem;">✕</button>
            </div>

            <!-- Upgrade / Subscribe App Banner -->
            <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" style="display: flex; align-items: center; justify-content: space-between; background: rgba(217, 119, 6, 0.18); border: 1px solid #D97706; border-radius: 0.5rem; padding: 0.6rem 0.85rem; color: #FFFFFF; text-decoration: none;">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 800; color: #F59E0B; text-transform: uppercase;">Club Prestige</div>
                    <div style="font-size: 0.8125rem; font-weight: 700;">Unlock All In-Depth Investigations</div>
                </div>
                <span style="font-size: 0.9rem; color: #F59E0B;">➔</span>
            </a>
        </div>

        <!-- Language Segmented Control Pill -->
        <div style="padding: 1rem 1rem 0.5rem; background: #FAF8F5; border-bottom: 1px solid #E8E2D8;">
            <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #78716C; margin-bottom: 0.5rem;">
                Select Language
            </div>
            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 0.25rem; background: #F3EFEA; padding: 0.25rem; border-radius: 0.5rem;">
                <a href="?lang=en" style="text-align: center; padding: 0.35rem 0; font-size: 0.6875rem; font-weight: 800; border-radius: 0.35rem; background: #0B5128; color: #FFFFFF; text-decoration: none;">EN</a>
                <a href="?lang=fr" style="text-align: center; padding: 0.35rem 0; font-size: 0.6875rem; font-weight: 700; border-radius: 0.35rem; color: #1C1917; text-decoration: none;">FR</a>
                <a href="?lang=ar" style="text-align: center; padding: 0.35rem 0; font-size: 0.6875rem; font-weight: 700; border-radius: 0.35rem; color: #1C1917; text-decoration: none;">AR</a>
                <a href="?lang=pt" style="text-align: center; padding: 0.35rem 0; font-size: 0.6875rem; font-weight: 700; border-radius: 0.35rem; color: #1C1917; text-decoration: none;">PT</a>
                <a href="?lang=sw" style="text-align: center; padding: 0.35rem 0; font-size: 0.6875rem; font-weight: 700; border-radius: 0.35rem; color: #1C1917; text-decoration: none;">SW</a>
            </div>
        </div>

        <!-- Sections Nav -->
        <nav class="app-drawer-nav">
            <div class="app-drawer-section-title">Navigation</div>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="app-drawer-link">
                <span><span class="link-icon">🏠</span> Home Feed</span>
                <span class="chevron">›</span>
            </a>

            <div class="app-drawer-section-title">Sections</div>
            <?php
            $cats = get_categories(array('number' => 8, 'hide_empty' => false, 'orderby' => 'count', 'order' => 'DESC'));
            foreach ($cats as $cat) {
                echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="app-drawer-link">';
                echo '<span><span class="link-icon">📌</span> ' . esc_html($cat->name) . '</span>';
                echo '<span class="chevron">›</span>';
                echo '</a>';
            }
            ?>

            <div class="app-drawer-section-title">Intelligence & Club</div>
            <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="app-drawer-link" style="color: #D97706;">
                <span><span class="link-icon">★</span> Club Prestige Membership</span>
                <span class="chevron">›</span>
            </a>
            <a href="<?php echo esc_url(home_url('/newsletter/')); ?>" class="app-drawer-link">
                <span><span class="link-icon">✉</span> The Africa Brief Newsletter</span>
                <span class="chevron">›</span>
            </a>
        </nav>

        <!-- Push Notifications Toggle & App Footer -->
        <div style="padding: 1rem; border-top: 1px solid #E8E2D8; background: #FAF8F5; margin-top: auto;">
            <button type="button" onclick="if(window.magazineafriqueRequestPush) window.magazineafriqueRequestPush();" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.75rem; background: #0B5128; color: #FFFFFF; font-weight: 700; font-size: 0.8125rem; border-radius: 0.5rem; border: none; cursor: pointer; margin-bottom: 0.75rem;">
                <span>🔔</span> Enable Push Alerts
            </button>
            <div style="text-align: center; font-size: 0.6875rem; color: #A8A29E;">
                Magazine Afrique App • PWA v1.0
            </div>
        </div>

    </div>
</div>

<!-- ===================================================
     NATIVE APP SEARCH BOTTOM SHEET / OVERLAY
     =================================================== -->
<div id="search-modal" class="modal-overlay hidden" role="dialog" aria-modal="true">
    <div id="search-panel" class="card-editorial" style="background: #FAF8F5; width: 100%; max-width: 580px; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 20px 45px rgba(0,0,0,0.3); border: 1px solid #E8E2D8; margin-top: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h3 class="font-serif" style="font-size: 1.25rem; font-weight: 700; color: #1C1917; margin: 0;">Search Magazine Afrique</h3>
            <button id="search-close" type="button" aria-label="Close search" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #66615B;">✕</button>
        </div>
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display: flex; gap: 0.5rem;">
            <input type="search" name="s" placeholder="Search by topic, country, leader..." style="flex: 1; padding: 0.85rem 1rem; border: 1px solid #E8E2D8; border-radius: 0.5rem; outline: none; font-size: 0.875rem; background: #FFFFFF;" />
            <button type="submit" class="btn-newsletter-submit" style="padding: 0.85rem 1.25rem; border-radius: 0.5rem;">Search</button>
        </form>
    </div>
</div>

<!-- Leaderboard Ad Slot -->
<div class="container-editorial">
    <?php magazineafrique_render_ad_leaderboard(); ?>
</div>
