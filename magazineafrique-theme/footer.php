<?php
/**
 * Magazine Afrique — Footer Template
 * Minimalist Editorial Architecture
 *
 * @package MagazineAfrique
 */
?>

<div class="divider-africa container-editorial">
    <span class="divider-africa-icon">❖</span>
</div>

<footer class="site-footer">
    <div class="container-editorial">
        <div class="footer-inner-grid">
            
            <!-- Column 1: Brand Info -->
            <div class="footer-col" style="max-width: 340px;">
                <div style="font-family: 'Newsreader', Georgia, serif; font-size: 1.5rem; font-weight: 700; letter-spacing: -0.01em; margin-bottom: 0.75rem;">
                    <span style="color: #FAF7F2;">Magazine</span> <span style="color: #F59E0B;">Afrique</span>
                </div>
                <p style="font-size: 0.8125rem; color: #C7BFB3; line-height: 1.6; margin-bottom: 1rem;">
                    Independent pan-African journal of strategic analysis, economics, politics, and culture.
                </p>
                <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #D1C9BE;">
                    <a href="https://twitter.com" target="_blank" rel="noopener">𝕏</a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener">LinkedIn</a>
                    <a href="https://facebook.com" target="_blank" rel="noopener">Facebook</a>
                </div>
            </div>

            <!-- Column 2: Key Sections -->
            <div class="footer-col">
                <h4>Sections</h4>
                <ul>
                    <?php
                    $categories = get_categories(array('number' => 6, 'hide_empty' => false, 'exclude' => array(1)));
                    foreach ($categories as $cat) {
                        if (strtolower($cat->slug) === 'uncategorized') continue;
                        echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Column 3: Membership -->
            <div class="footer-col">
                <h4>Club & Subscriptions</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/subscribe/')); ?>">Membership Plans</a></li>
                    <li><a href="<?php echo esc_url(home_url('/subscriber-portal/')); ?>">Prestige Dossiers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/newsletter/')); ?>">The Africa Brief</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact Editorial Desk</a></li>
                </ul>
            </div>

            <!-- Column 4: Newsletter -->
            <div class="footer-col" style="max-width: 300px;">
                <h4>The Africa Brief</h4>
                <p style="font-size: 0.75rem; color: #C7BFB3; margin-bottom: 0.75rem; line-height: 1.5;">
                    Essential continental intelligence, delivered every Thursday morning.
                </p>
                <form class="magazine-newsletter-form" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <input type="email" name="email" placeholder="Your work email" required style="padding: 0.6rem 0.75rem; border-radius: 0.25rem; border: 1px solid rgba(255,255,255,0.15); background: rgba(255,255,255,0.06); font-size: 0.75rem; color: #FAF7F2; outline: none;" />
                    <button type="submit" style="background-color: #0B5128; color: #FAF7F2; font-weight: 700; border: 1px solid #0E6834; padding: 0.55rem; border-radius: 0.25rem; font-size: 0.75rem; cursor: pointer;">
                        Subscribe
                    </button>
                    <div class="newsletter-feedback"></div>
                </form>
            </div>

        </div>

        <!-- Bottom Copyright & Legal -->
        <div class="footer-bottom-row">
            <div>
                &copy; <?php echo esc_html(date('Y')); ?> Magazine Afrique. All rights reserved.
            </div>
            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <a href="<?php echo esc_url(home_url('/legal-notice/')); ?>">Legal Notice</a>
                <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy</a>
                <a href="<?php echo esc_url(home_url('/terms/')); ?>">Terms</a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a>
                <a href="javascript:void(0)" onclick="window.magazineafriquePurgeCacheAndReload &amp;&amp; window.magazineafriquePurgeCacheAndReload()" class="footer-cache-reload-link" title="Purge local cache and load newest edition">↻ Reload Edition</a>
            </div>
        </div>
    </div>
</footer>

<!-- Vintage Broadsheet Bottom Mobile Navigation -->
<nav class="vintage-bottom-nav" aria-label="Mobile Navigation">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="vintage-nav-item <?php echo is_front_page() ? 'active' : ''; ?>">
        <svg class="vintage-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/>
            <path d="M18 14h-8"/>
            <path d="M15 18h-5"/>
            <path d="M10 6h8v4h-8V6Z"/>
        </svg>
        <span class="vintage-nav-label">Gazette</span>
    </a>

    <button type="button" id="bottom-menu-toggle" class="vintage-nav-item" aria-label="Open Sections Menu">
        <svg class="vintage-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
        <span class="vintage-nav-label">Sections</span>
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

    <a href="<?php echo esc_url(home_url('/newsletter/')); ?>" class="vintage-nav-item <?php echo is_page('newsletter') ? 'active' : ''; ?>">
        <svg class="vintage-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect width="20" height="16" x="2" y="4" rx="2"/>
            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
        </svg>
        <span class="vintage-nav-label">The Brief</span>
    </a>
</nav>

<?php wp_footer(); ?>
</body>
</html>
