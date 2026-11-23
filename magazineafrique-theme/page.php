<?php
/**
 * Magazine Afrique — Standard Broadsheet Page Template
 * Completely revamped: Tactile Box UI, Hero Masthead, Clean Modern Typography, Zero Legacy Styling.
 * Automatically serves specialized layouts for About Us, Contact, and Advertise With Us.
 *
 * @package MagazineAfrique
 */

// If slug is 'about' or 'about-us', seamlessly load the full About template
if (is_page(array('about', 'about-us'))) {
    include locate_template('template-about.php');
    return;
}

// If slug is 'contact' or 'contact-us', seamlessly load the full Contact template
if (is_page(array('contact', 'contact-us'))) {
    include locate_template('template-contact.php');
    return;
}

get_header(); ?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 960px; margin: 0 auto; padding-top: 2rem; padding-bottom: 4rem;">

    <?php while (have_posts()) : the_post(); 
        $page_id = get_the_ID();
        $page_slug = get_post_field('post_name', $page_id);
    ?>

        <!-- 1. Tactile Broadsheet Hero Section -->
        <header class="page-broadsheet-hero" style="text-align: center; border-bottom: 3px double var(--border-color, #231F1D); padding-bottom: 1.75rem; margin-bottom: 2.5rem;">
            
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; letter-spacing: 0.14em; color: #B45309; text-transform: uppercase; margin-bottom: 0.75rem;">
                <span>❖</span>
                <span>MAGAZINE AFRIQUE · OFFICIAL RECORD</span>
                <span>❖</span>
            </div>

            <h1 class="font-serif vintage-newspaper-headline" style="font-size: clamp(2rem, 4.5vw, 3rem); font-weight: 900; line-height: 1.15; color: var(--text-primary, #171513); margin: 0 auto 1rem; max-width: 820px;">
                <?php the_title(); ?>
            </h1>

            <!-- Broadsheet Dateline & Certification Bar -->
            <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 1.25rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px solid var(--border-color, #231F1D); border-bottom: 1px solid var(--border-color, #231F1D); padding: 0.6rem 0; text-transform: uppercase; letter-spacing: 0.08em;">
                <span>DESPATCH REF #<?php echo esc_html($page_id); ?></span>
                <span>·</span>
                <span>UPDATED: <?php echo esc_html(get_the_modified_date('j F Y')); ?></span>
                <span>·</span>
                <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                <span>·</span>
                <span>CONTINENTAL EDITION</span>
            </div>

        </header>

        <!-- 2. Featured Image (if available) in Tactile 5px Offset Frame -->
        <?php if (has_post_thumbnail()) : ?>
            <figure class="vintage-featured-image-box" style="margin-bottom: 2.5rem;">
                <div class="vintage-frame-inner">
                    <?php the_post_thumbnail('large', array('class' => 'vintage-framed-img')); ?>
                </div>
                <?php if (get_the_post_thumbnail_caption()) : ?>
                    <figcaption class="vintage-photo-caption" style="padding: 0.5rem 1rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); background: rgba(0,0,0,0.03); display: flex; justify-content: space-between;">
                        <span><?php the_post_thumbnail_caption(); ?></span>
                        <span>[DOCUMENT ARCHIVE]</span>
                    </figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <!-- 3. Specialized Showcase for "Advertise With Us" -->
        <?php if ($page_slug === 'advertise-with-us') : ?>
            
            <section style="margin-bottom: 2.5rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                    <div class="vintage-framed-box" style="padding: 1.25rem; text-align: center; background: var(--bg-card, #FFFFFF);">
                        <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #B45309;">250K+</div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: var(--text-muted, #78716C); text-transform: uppercase; margin-top: 0.25rem;">Monthly Decision-Makers</div>
                    </div>
                    <div class="vintage-framed-box" style="padding: 1.25rem; text-align: center; background: var(--bg-card, #FFFFFF);">
                        <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #D97706;">54</div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: var(--text-muted, #78716C); text-transform: uppercase; margin-top: 0.25rem;">Sovereign Jurisdictions</div>
                    </div>
                    <div class="vintage-framed-box" style="padding: 1.25rem; text-align: center; background: var(--bg-card, #FFFFFF);">
                        <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #B45309;">82%</div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: var(--text-muted, #78716C); text-transform: uppercase; margin-top: 0.25rem;">C-Suite &amp; Diplomats</div>
                    </div>
                    <div class="vintage-framed-box" style="padding: 1.25rem; text-align: center; background: var(--bg-card, #FFFFFF);">
                        <div style="font-family: 'Geist Mono', monospace; font-size: 1.75rem; font-weight: 800; color: #171513;">6</div>
                        <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: var(--text-muted, #78716C); text-transform: uppercase; margin-top: 0.25rem;">Continental Bureaus</div>
                    </div>
                </div>

                <!-- Commercial Inventory Cards -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
                    
                    <div class="vintage-grid-card" style="padding: 1.5rem;">
                        <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309;">SLOT 4687046934</span>
                        <h4 class="font-serif" style="font-size: 1.15rem; font-weight: 800; margin: 0.35rem 0 0.5rem; color: var(--text-primary, #171513);">
                            Masthead Leaderboard
                        </h4>
                        <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: var(--text-secondary, #575149); line-height: 1.5; margin: 0 0 1rem;">
                            High-visibility top placement across every edition and investigative dossier on desktop and mobile.
                        </p>
                        <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: #B45309;">728x90 · Responsive</span>
                    </div>

                    <div class="vintage-grid-card" style="padding: 1.5rem;">
                        <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309;">SLOT 5892214502</span>
                        <h4 class="font-serif" style="font-size: 1.15rem; font-weight: 800; margin: 0.35rem 0 0.5rem; color: var(--text-primary, #171513);">
                            Mid-Dossier Editorial Insertion
                        </h4>
                        <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: var(--text-secondary, #575149); line-height: 1.5; margin: 0 0 1rem;">
                            Engaging interstitial placement embedded directly after the executive summary in long-form intelligence reports.
                        </p>
                        <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: #B45309;">300x250 · Fluid In-Article</span>
                    </div>

                    <div class="vintage-grid-card" style="padding: 1.5rem;">
                        <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309;">SLOT 1854558906</span>
                        <h4 class="font-serif" style="font-size: 1.15rem; font-weight: 800; margin: 0.35rem 0 0.5rem; color: var(--text-primary, #171513);">
                            Continental Telegraph Sidebar
                        </h4>
                        <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: var(--text-secondary, #575149); line-height: 1.5; margin: 0 0 1rem;">
                            Persistent sticky sidebar positioning alongside real-time news briefs on all PC and tablet reading views.
                        </p>
                        <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: #B45309;">300x250 · Sticky Broadsheet</span>
                    </div>

                </div>

                <!-- Advertising Inquiries Callout -->
                <div class="vintage-framed-box" style="padding: 1.5rem; background: #171513; color: #FAF7F2; border: 2px solid #D97706; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
                    <div>
                        <h4 class="font-serif" style="font-size: 1.2rem; font-weight: 800; margin: 0 0 0.25rem; color: #FAF7F2;">
                            Request the 2026 Continental Media Kit
                        </h4>
                        <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: #E2DACD; margin: 0;">
                            Direct inquiries to commercial@magazineafrique.org or submit via our dispatch wire.
                        </p>
                    </div>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="circular-notice-btn" style="background: #FBBF24 !important; color: #171513 !important; border-color: #FBBF24 !important; text-decoration: none; font-size: 0.75rem;">
                        Contact Commercial Desk →
                    </a>
                </div>
            </section>

        <?php endif; ?>

        <!-- 4. Tactile Broadsheet Content Container (5px Offset Shadow, Clean Typography) -->
        <article class="vintage-framed-box page-reading-container" style="padding: 2.5rem 2.75rem; margin-bottom: 3.5rem; background: var(--bg-card, #FFFFFF);">
            
            <div class="article-body drop-cap-classic" style="font-family: 'Newsreader', Georgia, serif; font-size: 1.1rem; line-height: 1.8; color: var(--text-secondary, #2A2521);">
                <?php the_content(); ?>
            </div>

            <!-- Broadsheet Document Seal & Verification Footer -->
            <div style="border-top: 1.5px solid var(--border-color, #231F1D); padding-top: 1.25rem; margin-top: 2.5rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C);">
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <span style="color: #B45309; font-weight: 800;">✓</span>
                    <span>OFFICIALLY CERTIFIED BY THE EDITORIAL BOARD</span>
                </div>
                <div>
                    <span>MAGAZINE AFRIQUE PUBLISHING GROUP · REGISTERED JOURNAL OF RECORD</span>
                </div>
            </div>

        </article>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>