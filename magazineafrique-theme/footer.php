<?php
/**
 * Magazine Afrique — Footer Template
 * Minimalist Editorial Architecture with Vintage Bottom Mobile Bar
 *
 * @package MagazineAfrique
 */
?>

<?php
// Bottom Ad Slot (Slot 1801863291 - Above Footer)
if (function_exists('magazineafrique_render_ad_bottom')) {
    magazineafrique_render_ad_bottom();
}
?>

<!-- Centered Pan-African Editorial Rule Divider -->
<div class="footer-editorial-rule container-editorial" aria-hidden="true">
    <span class="rule-line"></span>
    <span class="rule-glyph">❖</span>
    <span class="rule-line"></span>
</div>

<footer class="site-footer" id="colophon">
    <div class="container-editorial">
        <!-- Top Editorial Masthead Banner -->
        <div class="footer-top-masthead">
            <div class="footer-brand-lockup">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="footer-logo-link" title="<?php bloginfo('name'); ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-dark.png'); ?>" alt="<?php bloginfo('name'); ?>" class="footer-logo-img" width="220" height="60" />
                </a>
                <p class="footer-masthead-desc">
                    Independent pan-African journal of strategic analysis, macroeconomic intelligence, geopolitics, trade, and culture.
                </p>
            </div>
            <div class="footer-edition-pills">
                <span class="footer-edition-label">Editions:</span>
                <button type="button" class="lang-chip-footer active" onclick="window.magazineafriqueSwitchLanguage('en')">EN</button>
                <button type="button" class="lang-chip-footer" onclick="window.magazineafriqueSwitchLanguage('fr')">FR</button>
                <button type="button" class="lang-chip-footer" onclick="window.magazineafriqueSwitchLanguage('ar')">AR</button>
                <button type="button" class="lang-chip-footer" onclick="window.magazineafriqueSwitchLanguage('pt')">PT</button>
                <button type="button" class="lang-chip-footer" onclick="window.magazineafriqueSwitchLanguage('sw')">SW</button>
            </div>
        </div>

        <!-- 4-Column Architectural Grid -->
        <div class="footer-inner-grid">
            
            <!-- Column 1: Continental Bureaus & Dispatch Wire -->
            <div class="footer-col footer-col-mission">
                <h4 class="footer-col-title">Continental Bureaus</h4>
                <p class="footer-bureaus-detail">
                    Continuous intelligence despatches from accredited correspondents across Africa's five regional economic communities.
                </p>
                <div class="footer-bureaus-tag">
                    <span>Active Bureaus:</span> Dakar · Lagos · Nairobi · Johannesburg · Cairo · London
                </div>
                <div class="footer-social-row">
                    <a href="https://twitter.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="X (Twitter)">𝕏</a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="LinkedIn">LinkedIn</a>
                    <a href="https://whatsapp.com/channel/0029VbABUTT23n3fleq5C91h" target="_blank" rel="noopener" class="footer-social-btn footer-wa-btn" aria-label="WhatsApp Channel">Wire ↗</a>
                </div>
            </div>

            <!-- Column 2: Editorial Desks -->
            <div class="footer-col">
                <h4 class="footer-col-title">Editorial Desks</h4>
                <ul class="footer-link-list">
                    <?php
                    $categories = get_categories(array('number' => 6, 'hide_empty' => false, 'exclude' => array(1)));
                    foreach ($categories as $cat) {
                        if (strtolower($cat->slug) === 'uncategorized') continue;
                        echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '"><span class="footer-bullet">·</span> ' . esc_html($cat->name) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Column 3: Club & Reader Portal -->
            <div class="footer-col">
                <h4 class="footer-col-title">Reader Services</h4>
                <ul class="footer-link-list">
                    <li><a href="<?php echo esc_url(home_url('/subscribe/')); ?>"><span class="footer-bullet">★</span> Club Prestige Membership</a></li>
                    <li><a href="<?php echo esc_url(home_url('/profile/')); ?>"><span class="footer-bullet">👤</span> Reader Profile &amp; Wire</a></li>
                    <li><a href="<?php echo esc_url(home_url('/notifications/')); ?>"><span class="footer-bullet">🔔</span> Breaking Intelligence Alerts</a></li>
                    <li><a href="<?php echo esc_url(home_url('/newsletter/')); ?>"><span class="footer-bullet">✉</span> The Africa Brief Dispatch</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><span class="footer-bullet">✉</span> Contact Editorial Desk</a></li>
                    <li><a href="javascript:void(0)" class="btn-install-app footer-pwa-link"><span class="footer-bullet">📲</span> Install Gazette App (PWA)</a></li>
                </ul>
            </div>

            <!-- Column 4: Newsletter Wire Box -->
            <div class="footer-col footer-col-newsletter">
                <h4 class="footer-col-title">The Africa Brief</h4>
                <p class="footer-newsletter-desc">
                    Essential continental intelligence, macroeconomic trends, and diplomatic briefings delivered every Thursday.
                </p>
                <form class="magazine-newsletter-form footer-newsletter-form">
                    <div class="footer-input-group">
                        <input type="email" name="email" placeholder="Your work email address" required class="footer-email-input" />
                        <button type="submit" class="footer-submit-btn">Subscribe Gratis</button>
                    </div>
                    <div class="newsletter-feedback"></div>
                    <span class="footer-privacy-note">Zero spam. Encrypted dispatch. Unsubscribe at will.</span>
                </form>
            </div>

        </div>

        <!-- Bottom Copyright & Legal Line -->
        <div class="footer-bottom-row">
            <div class="footer-copyright-note">
                &copy; <?php echo esc_html(date('Y')); ?> Magazine Afrique. All rights reserved. Registered Pan-African Press Syndicate.
            </div>
            <div class="footer-legal-links">
                <a href="<?php echo esc_url(home_url('/legal-notice/')); ?>">Legal Notice</a>
                <span class="footer-sep">·</span>
                <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>
                <span class="footer-sep">·</span>
                <a href="<?php echo esc_url(home_url('/terms/')); ?>">Terms of Service</a>
                <span class="footer-sep">·</span>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact &amp; Bureaus</a>
                <span class="footer-sep">·</span>
                <a href="javascript:void(0)" class="btn-install-app footer-cache-reload-link" title="Install Magazine Afrique to your home screen or desktop">📲 Install App</a>
                <span class="footer-sep">·</span>
                <a href="javascript:void(0)" onclick="window.magazineafriquePurgeCacheAndReload && window.magazineafriquePurgeCacheAndReload()" class="footer-cache-reload-link" title="Purge local cache and load newest edition">↻ Reload Edition</a>
            </div>
        </div>
    </div>
</footer>

<!-- Vintage Broadsheet Bottom Mobile Navigation (Docked, Safe, Non-overflowing) -->
<nav class="vintage-bottom-nav" id="vintage-mobile-nav" aria-label="Mobile Navigation">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="vintage-nav-item <?php echo is_front_page() ? 'active' : ''; ?>">
        <svg class="vintage-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/>
            <path d="M18 14h-8"/>
            <path d="M15 18h-5"/>
            <path d="M10 6h8v4h-8V6Z"/>
        </svg>
        <span class="vintage-nav-label">Gazette</span>
    </a>

    <button type="button" id="bottom-menu-toggle" class="vintage-nav-item" aria-label="Open Categories Menu">
        <svg class="vintage-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
        <span class="vintage-nav-label">Categories</span>
    </button>

    <button type="button" id="bottom-search-toggle" class="vintage-nav-item" aria-label="Open Search">
        <svg class="vintage-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <span class="vintage-nav-label">Search</span>
    </button>

    <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="vintage-nav-item <?php echo is_page('subscribe') ? 'active' : ''; ?>">
        <svg class="vintage-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
        <span class="vintage-nav-label">Prestige</span>
    </a>

    <?php if (is_user_logged_in()) : ?>
        <a href="<?php echo esc_url(home_url('/profile/')); ?>" class="vintage-nav-item <?php echo is_page('profile') ? 'active' : ''; ?>">
            <svg class="vintage-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span class="vintage-nav-label">Profile</span>
        </a>
    <?php else : ?>
        <a href="<?php echo esc_url(home_url('/login/')); ?>" class="vintage-nav-item <?php echo is_page('login') ? 'active' : ''; ?>">
            <svg class="vintage-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            <span class="vintage-nav-label">Sign In</span>
        </a>
    <?php endif; ?>
</nav>

<!-- Strategic Slide-In Pill for WhatsApp Official Channel (14-day capped, 65% scroll trigger) -->
<div id="magafrique-wa-slidein" class="magafrique-wa-slidein" style="display:none;" aria-live="polite">
    <div class="magafrique-wa-content">
        <span class="magafrique-wa-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
            </svg>
        </span>
        <div class="magafrique-wa-text">
            <strong>Pan-African Wire on WhatsApp</strong>
            <span>Direct breaking intelligence briefs.</span>
        </div>
        <a href="https://whatsapp.com/channel/0029VbABUTT23n3fleq5C91h" target="_blank" rel="noopener" class="magafrique-wa-action-btn" id="magafrique-wa-join-btn">
            Follow Wire ↗
        </a>
        <button type="button" class="magafrique-wa-close-btn" id="magafrique-wa-close-btn" aria-label="Dismiss">✕</button>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
