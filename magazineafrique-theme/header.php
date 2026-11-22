<?php
/**
 * Magazine Afrique — Header Template
 * Minimalist Editorial Design with Calm African Warmth
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

<!-- Calm Top Editorial Header -->
<header class="site-masthead">
    <div class="container-editorial header-inner">
        
        <!-- Left: Quiet Menu Button -->
        <button id="mobile-menu-toggle" type="button" aria-label="Open Menu" class="menu-text-btn">
            <span class="menu-icon-lines">
                <span class="line"></span>
                <span class="line"></span>
            </span>
            <span class="menu-label">Menu</span>
        </button>

        <!-- Center: Logo -->
        <div class="brand-logo-wrap">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/logo.jpg')); ?>" alt="<?php bloginfo('name'); ?>" class="brand-logo" />
                <?php endif; ?>
            </a>
        </div>

        <!-- Right: Actions (Search & Subscribe) -->
        <div class="header-right-actions">
            <button id="search-toggle" type="button" aria-label="Search" class="search-text-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
            <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="header-subscribe-pill">
                Subscribe
            </a>
        </div>

    </div>
</header>

<!-- Desktop Calm Category Navigation Bar -->
<nav class="desktop-editorial-nav" aria-label="Main Navigation">
    <div class="container-editorial">
        <ul class="editorial-nav-list">
            <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
            <?php
            $nav_cats = get_categories(array('number' => 7, 'hide_empty' => false, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => array(1))); // exclude Uncategorized
            foreach ($nav_cats as $cat) {
                if (strtolower($cat->slug) === 'uncategorized') continue;
                echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
            }
            ?>
            <li class="nav-item-prestige"><a href="<?php echo esc_url(home_url('/subscribe/')); ?>">Club Prestige</a></li>
        </ul>
    </div>
</nav>

<!-- Minimalist Literary Menu Drawer (Quiet & Elegant) -->
<div id="mobile-nav-drawer" class="minimal-drawer-overlay hidden" role="dialog" aria-modal="true">
    <div id="mobile-nav-panel" class="minimal-drawer-panel">
        
        <!-- Drawer Header -->
        <div class="drawer-header">
            <div class="drawer-brand">
                <span class="drawer-title">Magazine Afrique</span>
                <span class="drawer-subtitle">Pan-African Review</span>
            </div>
            <button id="close-mobile-menu" type="button" aria-label="Close menu" class="drawer-close-btn">
                ✕
            </button>
        </div>

        <!-- Typographic Editorial Navigation (No emojis, no clutter) -->
        <nav class="drawer-nav-content">
            <ul class="drawer-menu-links">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                <?php
                foreach ($nav_cats as $cat) {
                    if (strtolower($cat->slug) === 'uncategorized') continue;
                    echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
                }
                ?>
                <li class="drawer-prestige-link"><a href="<?php echo esc_url(home_url('/subscribe/')); ?>">★ Club Prestige Membership</a></li>
                <li><a href="<?php echo esc_url(home_url('/newsletter/')); ?>">The Africa Brief Newsletter</a></li>
            </ul>
        </nav>

        <!-- Drawer Footer: Language & Details -->
        <div class="drawer-footer">
            <div class="drawer-lang-row">
                <span class="lang-title">Language:</span>
                <a href="?lang=en" class="lang-link active">EN</a>
                <span class="lang-dot">·</span>
                <a href="?lang=fr" class="lang-link">FR</a>
                <span class="lang-dot">·</span>
                <a href="?lang=ar" class="lang-link">AR</a>
                <span class="lang-dot">·</span>
                <a href="?lang=pt" class="lang-link">PT</a>
                <span class="lang-dot">·</span>
                <a href="?lang=sw" class="lang-link">SW</a>
            </div>
            <div class="drawer-copyright">
                &copy; <?php echo esc_html(date('Y')); ?> Magazine Afrique. All rights reserved.
            </div>
        </div>

    </div>
</div>

<!-- Calm Search Overlay -->
<div id="search-modal" class="search-modal-backdrop hidden" role="dialog" aria-modal="true">
    <div id="search-panel" class="search-modal-card">
        <div class="search-modal-header">
            <h3 class="search-title">Search</h3>
            <button id="search-close" type="button" aria-label="Close search" class="search-close-btn">✕</button>
        </div>
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form-row">
            <input type="search" name="s" placeholder="Type a keyword, country, or author..." class="search-input-field" />
            <button type="submit" class="search-submit-btn">Search</button>
        </form>
    </div>
</div>
