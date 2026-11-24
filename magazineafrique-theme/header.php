<?php
/**
 * Magazine Afrique — Header Template
 * Minimalist Editorial Design with Calm African Warmth, Vintage Menu & Reader Auth
 *
 * @package MagazineAfrique
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Instant Dark Mode Init Script (Zero Flash / FOUT) -->
    <script>
    (function(){
        try {
            var saved = localStorage.getItem('magafrique_theme_mode');
            if (saved === 'dark' || (!saved && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        } catch(e) {}
    })();
    </script>

    <!-- Google Fonts: Playfair Display, Newsreader, Plus Jakarta Sans, JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,900;1,400;1,700&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;0,6..72,700;1,6..72,400;1,6..72,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

    <!-- Google AdSense Tag -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7175564788277515" crossorigin="anonymous"></script>

    <!-- Google Translate Element (Hidden Container) -->
    <div id="google_translate_element" style="display:none;"></div>
    <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,fr,ar,pt,sw',
            autoDisplay: false
        }, 'google_translate_element');
    }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Editorial Gazette PWA Splashscreen / Preloader -->
<div id="magafrique-splashscreen" class="magafrique-splashscreen" aria-hidden="true">
    <div class="splash-inner">
        <div class="splash-logo-cluster">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-192.png'); ?>" alt="Magazine Afrique" width="68" height="68" class="splash-crest-img" />
        </div>
        <div class="splash-brand-text">MAGAZINE AFRIQUE</div>
        <div class="splash-tagline">Pan-African Journal · Geopolitics &amp; Culture</div>
        <div class="splash-loading-bar-wrap">
            <div class="splash-loading-bar"></div>
        </div>
    </div>
</div>

<!-- Calm Broadsheet Masthead -->
<header class="site-masthead">
    <div class="container-editorial header-inner">
        
        <!-- Left: Vintage Letterpress Menu Button + Multi-Lingual Switcher -->
        <div class="header-left-cluster">
            <button id="mobile-menu-toggle" type="button" aria-label="Open Gazette Index" class="vintage-menu-btn" title="Open Broadsheet Index">
                <span class="vintage-btn-bracket">[</span>
                <span class="vintage-menu-ornament" aria-hidden="true"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -1px; margin-right: 2px;"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg></span>
                <span class="vintage-btn-text">INDEX</span>
                <span class="vintage-btn-bracket">]</span>
            </button>

            <!-- Language Pills (EN, FR, AR, PT, SW) -->
            <div class="header-lang-pills" aria-label="Select Language">
                <button type="button" class="lang-chip active" data-lang="en" onclick="window.magazineafriqueSwitchLanguage('en')">EN</button>
                <span class="lang-divider">·</span>
                <button type="button" class="lang-chip" data-lang="fr" onclick="window.magazineafriqueSwitchLanguage('fr')">FR</button>
                <span class="lang-divider">·</span>
                <button type="button" class="lang-chip" data-lang="ar" onclick="window.magazineafriqueSwitchLanguage('ar')">AR</button>
                <span class="lang-divider">·</span>
                <button type="button" class="lang-chip" data-lang="pt" onclick="window.magazineafriqueSwitchLanguage('pt')">PT</button>
                <span class="lang-divider">·</span>
                <button type="button" class="lang-chip" data-lang="sw" onclick="window.magazineafriqueSwitchLanguage('sw')">SW</button>
            </div>
        </div>

        <!-- Center: Official Logo (Light and Dark variants, fully transparent) -->
        <div class="brand-logo-wrap">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="brand-nameplate-link" title="<?php bloginfo('name'); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" class="brand-logo-img logo-light" width="220" height="60" />
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-dark.png'); ?>" alt="<?php bloginfo('name'); ?>" class="brand-logo-img logo-dark" width="220" height="60" />
            </a>
        </div>

        <!-- Right: Actions (Dark Mode, Notifications, Auth, Search, Club Pill) -->
        <div class="header-right-actions">
            
            <!-- Refined Dark Mode Toggle (Crisp SVG Icons, Faded Dark Palette) -->
            <button id="theme-toggle-btn" type="button" aria-label="Toggle Night/Day Mode" class="theme-toggle-btn" title="Toggle Reading Mode">
                <svg class="theme-icon-svg theme-icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
                <svg class="theme-icon-svg theme-icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="5"></circle>
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
            </button>

            <!-- Notification Bell -->
            <a href="<?php echo esc_url(home_url('/notifications/')); ?>" class="header-action-icon-btn notif-bell-link" aria-label="Notifications" title="Notifications">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span class="header-notif-dot" id="header-unread-dot"></span>
            </a>

            <!-- Search Button -->
            <button id="search-toggle" type="button" aria-label="Search" class="search-text-btn" title="Search Gazette">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>

            <!-- Vintage Auth Trigger in Header -->
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(home_url('/profile/')); ?>" class="header-reader-pill" title="Reader Profile">
                    <span class="reader-pill-icon">👤</span>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/onboarding/?mode=login')); ?>" class="header-auth-text-link" title="Reader Sign In / Enroll">
                    Sign In
                </a>
            <?php endif; ?>

            <!-- Club Prestige Pill -->
            <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="header-subscribe-pill">
                Club
            </a>
        </div>

    </div>

    <!-- Quiet Single-Line Dateline Strip -->
    <div class="masthead-dateline-strip">
        <div class="container-editorial dateline-inner">
            <span class="dateline-city"><?php echo esc_html(date_i18n('l, j F Y')); ?></span>
            <span class="dateline-edition">Pan-African Edition · Vol. XLVIII</span>
        </div>
    </div>
</header>

<!-- Financial Markets & Crypto Live Ticker (Location-Aware Bourses) -->
<div id="vintage-markets-ticker" class="vintage-markets-ticker" aria-label="Financial Markets & Crypto Live Ticker">
    <div class="ticker-inner">
        <div class="ticker-location-cluster" id="ticker-location-badge">
            <span class="ticker-dot">●</span>
            <span class="ticker-bourse-title" id="ticker-bourse-name">MARKETS</span>
        </div>
        <div class="ticker-viewport">
            <div class="ticker-track" id="ticker-track">
                <!-- Populated dynamically based on reader location + live crypto -->
                <span class="ticker-chip"><span class="ticker-sym">BTC/USD</span> <span class="ticker-val" id="ticker-val-btc">$98,420</span> <span class="ticker-chg ticker-up" id="ticker-chg-btc">▲ +2.4%</span></span>
                <span class="ticker-chip-sep">/</span>
                <span class="ticker-chip"><span class="ticker-sym">ETH/USD</span> <span class="ticker-val" id="ticker-val-eth">$3,380</span> <span class="ticker-chg ticker-up" id="ticker-chg-eth">▲ +1.8%</span></span>
                <span class="ticker-chip-sep">/</span>
                <span class="ticker-chip"><span class="ticker-sym">SOL/USD</span> <span class="ticker-val" id="ticker-val-sol">$242.10</span> <span class="ticker-chg ticker-up" id="ticker-chg-sol">▲ +3.1%</span></span>
                <span class="ticker-chip-sep">/</span>
                <span class="ticker-chip"><span class="ticker-sym">NGX ASI</span> <span class="ticker-val">104,562.05</span> <span class="ticker-chg ticker-up">▲ +0.42%</span></span>
                <span class="ticker-chip-sep">/</span>
                <span class="ticker-chip"><span class="ticker-sym">DANGCEM</span> <span class="ticker-val">₦680.00</span> <span class="ticker-chg ticker-up">▲ +1.20%</span></span>
                <span class="ticker-chip-sep">/</span>
                <span class="ticker-chip"><span class="ticker-sym">MTNN</span> <span class="ticker-val">₦225.50</span> <span class="ticker-chg ticker-down">▼ -0.80%</span></span>
                <span class="ticker-chip-sep">/</span>
                <span class="ticker-chip"><span class="ticker-sym">BRENT OIL</span> <span class="ticker-val">$74.80</span> <span class="ticker-chg ticker-up">▲ +1.10%</span></span>
                <span class="ticker-chip-sep">/</span>
                <span class="ticker-chip"><span class="ticker-sym">GOLD</span> <span class="ticker-val">$2,710.40</span> <span class="ticker-chg ticker-up">▲ +0.65%</span></span>
            </div>
        </div>
    </div>
</div>

<!-- Desktop Calm Category Navigation Bar -->
<nav class="desktop-editorial-nav" aria-label="Main Navigation">
    <div class="container-editorial">
        <?php
        if (has_nav_menu('primary')) {
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'editorial-nav-list',
                'depth'          => 3,
                'fallback_cb'    => 'magazineafrique_render_editorial_nav',
            ));
        } else {
            magazineafrique_render_editorial_nav();
        }
        ?>
    </div>
</nav>

<?php 
// Header Leaderboard Ad Slot (Slot 4687046934)
// Only show on non-front-page to keep homepage hero strictly 100% visible in the above-the-fold viewport!
if (!is_front_page() && function_exists('magazineafrique_render_ad_header')) {
    magazineafrique_render_ad_header();
}
?>

<!-- Minimalist Literary Menu Drawer (Vintage Broadsheet Side-Out Panel) -->
<div id="mobile-nav-drawer" class="minimal-drawer-overlay hidden" role="dialog" aria-modal="true">
    <div id="mobile-nav-panel" class="minimal-drawer-panel vintage-drawer-frame">
        
        <!-- Drawer Header with Archival Seal -->
        <div class="drawer-header vintage-drawer-header">
            <div class="drawer-brand">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="Magazine Afrique" class="drawer-logo-img logo-light" height="34" />
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-dark.png'); ?>" alt="Magazine Afrique" class="drawer-logo-img logo-dark" height="34" />
                <span class="drawer-edition-tag">PAN-AFRICAN GAZETTE · INDEX</span>
            </div>
            <button id="close-mobile-menu" type="button" aria-label="Close menu" class="drawer-close-btn vintage-close-btn" title="Close Index">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Dynamic Vintage Reader Session / Login / Logout Box -->
        <?php if (is_user_logged_in()) : 
            $curr_user = wp_get_current_user();
            $user_name = $curr_user->first_name ?: $curr_user->display_name;
        ?>
            <div class="vintage-reader-session-box">
                <div class="session-user-row">
                    <span class="session-badge">READER ACTIVE</span>
                    <span class="session-name"><?php echo esc_html($user_name); ?></span>
                </div>
                <div class="session-actions-row">
                    <a href="<?php echo esc_url(home_url('/profile/')); ?>" class="vintage-session-btn">[ 👤 Desk &amp; Wire ]</a>
                    <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="vintage-session-btn btn-logout">[ ⎋ Disconnect ]</a>
                </div>
            </div>
        <?php else : ?>
            <div class="vintage-reader-session-box">
                <div class="session-user-row">
                    <span class="session-badge">GUEST READER</span>
                    <span class="session-name">Join Correspondent Network</span>
                </div>
                <div class="session-actions-row">
                    <a href="<?php echo esc_url(home_url('/onboarding/')); ?>" class="vintage-session-btn btn-enroll">[ ✍ Enroll Free ]</a>
                    <a href="<?php echo esc_url(home_url('/onboarding/?mode=login')); ?>" class="vintage-session-btn">[ ⎆ Sign In ]</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Broadsheet Categorized Navigation -->
        <nav class="drawer-nav-content">
            <div class="drawer-section-heading">— EDITORIAL DESKS &amp; WIRE —</div>
            <ul class="drawer-menu-links">
                <li><a href="<?php echo esc_url(home_url('/')); ?>" class="drawer-link-item"><span class="drawer-item-bullet" aria-hidden="true"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-right: 4px;"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span> Gazette Front Page</a></li>
                
                <!-- News Desk -->
                <li class="drawer-has-submenu">
                    <a href="<?php echo esc_url(magazineafrique_get_cat_url('international-news')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> News &amp; Geopolitics</a>
                    <ul class="drawer-sub-links">
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('international-news')); ?>">International News</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('politics')); ?>">Politics</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('africa')); ?>">Africa Wire</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('better-nigeria')); ?>">Better Nigeria</a></li>
                    </ul>
                </li>

                <!-- Business Desk -->
                <li class="drawer-has-submenu">
                    <a href="<?php echo esc_url(magazineafrique_get_cat_url('business')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> Business &amp; Economy</a>
                    <ul class="drawer-sub-links">
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('business')); ?>">Markets &amp; Enterprise</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('economy')); ?>">Economy &amp; AfCFTA</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('fintech')); ?>">Fintech &amp; Banking</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('cryptocurrency')); ?>">Crypto &amp; Digital Assets</a></li>
                    </ul>
                </li>

                <!-- Technology Desk -->
                <li class="drawer-has-submenu">
                    <a href="<?php echo esc_url(magazineafrique_get_cat_url('technology')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> Technology &amp; Innovation</a>
                    <ul class="drawer-sub-links">
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('technology')); ?>">Tech Innovations &amp; AI</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('fintech')); ?>">Fintech Infrastructure</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('cryptocurrency')); ?>">Web3 &amp; Blockchain</a></li>
                    </ul>
                </li>

                <!-- Lifestyle (Pure African Luxury, Living & Style) -->
                <li class="drawer-has-submenu">
                    <a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> Lifestyle &amp; Living</a>
                    <ul class="drawer-sub-links">
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>">Living &amp; Style</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>">African Haute Couture</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>">Travel &amp; Escapes</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>">Design &amp; Architecture</a></li>
                    </ul>
                </li>

                <!-- Health & Wellness (Distinct from Lifestyle) -->
                <li class="drawer-has-submenu">
                    <a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> Health &amp; Longevity</a>
                    <ul class="drawer-sub-links">
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>">Public Health &amp; Research</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>">Wellness &amp; Longevity</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>">Botanicals &amp; Nutrition</a></li>
                    </ul>
                </li>

                <!-- How-To's (Distinct from Lifestyle) -->
                <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('how-tos')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> How-To's &amp; Manuals</a></li>

                <!-- Entertainment -->
                <li class="drawer-has-submenu">
                    <a href="<?php echo esc_url(magazineafrique_get_cat_url('entertainment')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> Entertainment &amp; Celebrities</a>
                    <ul class="drawer-sub-links">
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('entertainment')); ?>">Music &amp; Cinema</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('celebrities')); ?>">Celebrities &amp; Icons</a></li>
                    </ul>
                </li>

                <!-- Sports -->
                <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('sports')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> Sports</a></li>

                <!-- Education -->
                <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('education')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> Education &amp; Academia</a></li>

                <!-- Biography -->
                <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('biography')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> Biography &amp; Changemakers</a></li>

                <!-- Opinion -->
                <li class="drawer-has-submenu">
                    <a href="<?php echo esc_url(magazineafrique_get_cat_url('opinion')); ?>" class="drawer-link-item"><span class="drawer-item-bullet">·</span> Opinion &amp; Chronicle</a>
                    <ul class="drawer-sub-links">
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('opinion')); ?>">The Gazette Chronicle</a></li>
                        <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('editorial')); ?>">Editorial Board</a></li>
                    </ul>
                </li>
            </ul>

            <div class="drawer-section-heading" style="margin-top: 1.5rem;">— READER SERVICES &amp; WIRE —</div>
            <ul class="drawer-menu-links">
                <li>
                    <a href="<?php echo esc_url(home_url('/profile/')); ?>" class="drawer-link-item">
                        <span class="drawer-item-bullet">👤</span> Reader Profile &amp; Following Wire
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/notifications/')); ?>" class="drawer-link-item">
                        <span class="drawer-item-bullet">🔔</span> Breaking News Alerts
                    </a>
                </li>
                <li style="margin-top: 0.75rem;">
                    <a href="<?php echo esc_url(home_url('/advertise/')); ?>" class="drawer-prestige-card-btn" style="border-color: #D97706; background: rgba(217, 119, 6, 0.12);">
                        <span class="prestige-star" style="color: #FBBF24;">📢</span>
                        <div>
                            <strong style="display:block; font-size: 0.8125rem; color: #FAF7F2;">Buy Ad Space (Brand Reach)</strong>
                            <span style="font-size: 0.6875rem; color: #FBBF24;">Daily Broadsheet Placement · 54 Countries</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="drawer-prestige-card-btn">
                        <span class="prestige-star">★</span>
                        <div>
                            <strong style="display:block; font-size: 0.8125rem;">Club Prestige Membership</strong>
                            <span style="font-size: 0.6875rem; color: #E5A84B;">100% Ad-Free · Leaked Dossiers · Mining Data</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/newsletter/')); ?>" class="drawer-link-item" style="font-size: 0.8125rem;">
                        <span class="drawer-item-bullet">✉</span> The Africa Brief Newsletter
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Drawer Footer: Multi-Lingual Switcher & Reload -->
        <div class="drawer-footer">
            <div class="drawer-lang-row">
                <span class="lang-title">Language:</span>
                <button type="button" class="lang-chip active" data-lang="en" onclick="window.magazineafriqueSwitchLanguage('en')">EN</button>
                <span class="lang-dot">·</span>
                <button type="button" class="lang-chip" data-lang="fr" onclick="window.magazineafriqueSwitchLanguage('fr')">FR</button>
                <span class="lang-dot">·</span>
                <button type="button" class="lang-chip" data-lang="ar" onclick="window.magazineafriqueSwitchLanguage('ar')">AR</button>
                <span class="lang-dot">·</span>
                <button type="button" class="lang-chip" data-lang="pt" onclick="window.magazineafriqueSwitchLanguage('pt')">PT</button>
                <span class="lang-dot">·</span>
                <button type="button" class="lang-chip" data-lang="sw" onclick="window.magazineafriqueSwitchLanguage('sw')">SW</button>
            </div>
            <div class="drawer-copyright" style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.75rem;">
                <span>&copy; <?php echo esc_html(date('Y')); ?> Magazine Afrique</span>
                <a href="javascript:void(0)" onclick="window.magazineafriquePurgeCacheAndReload &amp;&amp; window.magazineafriquePurgeCacheAndReload()" style="color: var(--text-muted, #8C847A); text-decoration: underline; font-size: 0.6875rem;">↻ Reload Edition</a>
            </div>
        </div>

    </div>
</div>

<!-- Vintage Broadsheet Search Overlay (Mobile Bottom Pop-Up Sheet) -->
<div id="search-modal" class="search-modal-backdrop hidden" role="dialog" aria-modal="true">
    <div id="search-panel" class="search-modal-card vintage-search-popup">
        <div class="vintage-search-handle-bar"></div>
        <div class="search-modal-header">
            <div>
                <span class="vintage-search-kicker">— GAZETTE ARCHIVES —</span>
                <h3 class="search-title font-serif">Query Pan-African Wire</h3>
            </div>
            <button id="search-close" type="button" aria-label="Close search" class="search-close-btn vintage-search-close">
                <span class="close-bracket">[</span> ✕ <span class="close-bracket">]</span>
            </button>
        </div>
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form-row vintage-search-form">
            <input type="search" name="s" placeholder="Search dispatches, leaders, minerals, or diplomacy..." class="search-input-field vintage-search-input" />
            <button type="submit" class="search-submit-btn vintage-search-submit">[ Query ]</button>
        </form>
        <div class="vintage-search-topics">
            <span class="search-topics-label">Desks:</span>
            <a href="<?php echo esc_url(home_url('/category/politics/')); ?>" class="search-topic-tag">#Politics</a>
            <a href="<?php echo esc_url(home_url('/category/business/')); ?>" class="search-topic-tag">#Business</a>
            <a href="<?php echo esc_url(home_url('/category/international-news/')); ?>" class="search-topic-tag">#InternationalNews</a>
            <a href="<?php echo esc_url(home_url('/category/entertainment/')); ?>" class="search-topic-tag">#Entertainment</a>
            <a href="<?php echo esc_url(home_url('/category/africa/')); ?>" class="search-topic-tag">#Africa</a>
            <a href="<?php echo esc_url(home_url('/category/business/fintech/')); ?>" class="search-topic-tag">#Fintech</a>
        </div>
    </div>
</div>
