<?php
/**
 * Magazine Afrique — Footer Template
 * Primary Language: English with Pan-African Multilingual Support
 *
 * @package MagazineAfrique
 */
?>

<div class="divider-africa container-editorial">
    <span class="divider-africa-icon">❖</span>
</div>

<footer class="site-footer">
    <div class="container-editorial">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2.5rem; margin-bottom: 3rem;">
            
            <!-- Column 1: Brand Info -->
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em;">
                    <span style="color: #FAF8F5;">Magazine</span> <span style="color: #F59E0B;">Afrique</span>
                </div>
                <p style="font-size: 0.8125rem; color: #D1D5DB; line-height: 1.6;">
                    Pan-African journal of strategic analysis and foresight. Illuminating geopolitical transitions, economic innovation, and cultural dynamics shaping the continent's future.
                </p>
                <div style="display: flex; gap: 0.75rem; font-size: 1.125rem;">
                    <a href="https://twitter.com" target="_blank" rel="noopener" aria-label="X">𝕏</a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener" aria-label="LinkedIn">in</a>
                    <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook">fb</a>
                    <a href="https://youtube.com" target="_blank" rel="noopener" aria-label="YouTube">yt</a>
                </div>
            </div>

            <!-- Column 2: Navigation Links -->
            <div>
                <h4 class="font-serif" style="font-size: 1rem; font-weight: 700; color: #F59E0B; margin-bottom: 1rem;">
                    Key Sections
                </h4>
                <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.8125rem;">
                    <?php
                    $categories = get_categories(array('number' => 6));
                    foreach ($categories as $cat) {
                        echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Column 3: Club & Paywall -->
            <div>
                <h4 class="font-serif" style="font-size: 1rem; font-weight: 700; color: #F59E0B; margin-bottom: 1rem;">
                    Club & Subscriptions
                </h4>
                <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.8125rem;">
                    <li><a href="<?php echo esc_url(home_url('/subscribe/')); ?>">Membership Plans</a></li>
                    <li><a href="<?php echo esc_url(home_url('/subscriber-portal/')); ?>">Subscriber Prestige Portal</a></li>
                    <li><a href="<?php echo esc_url(home_url('/special-reports/')); ?>">Strategic Reports & Dossiers</a></li>
                    <li><a href="<?php echo esc_url(home_url('/corporate-access/')); ?>">Corporate & Diplomatic Access</a></li>
                </ul>
            </div>

            <!-- Column 4: Newsletter Quick Sign-Up -->
            <div>
                <h4 class="font-serif" style="font-size: 1rem; font-weight: 700; color: #F59E0B; margin-bottom: 1rem;">
                    The Africa Brief
                </h4>
                <p style="font-size: 0.75rem; color: #D1D5DB; margin-bottom: 0.75rem; line-height: 1.5;">
                    Every Thursday morning, receive the continent's essential intelligence directly in your inbox.
                </p>
                <form class="magazine-newsletter-form" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <input type="email" name="email" placeholder="Your work email" required style="padding: 0.5rem; border-radius: 0.25rem; border: none; font-size: 0.75rem; color: #1C1917;" />
                    <button type="submit" style="background-color: #D97706; color: #FFFFFF; font-weight: 700; border: none; padding: 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; cursor: pointer;">
                        Join The Brief
                    </button>
                    <div class="newsletter-feedback"></div>
                </form>
            </div>

        </div>

        <!-- Bottom Copyright & Legal -->
        <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; font-size: 0.75rem; color: #9CA3AF;">
            <div>
                &copy; <?php echo esc_html(date('Y')); ?> Magazine Afrique. All rights reserved.
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="<?php echo esc_url(home_url('/legal-notice/')); ?>">Legal Notice</a>
                <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>
                <a href="<?php echo esc_url(home_url('/terms/')); ?>">Terms & Conditions</a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact & Editorial Desk</a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
