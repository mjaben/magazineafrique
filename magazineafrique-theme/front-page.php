<?php
/**
 * Magazine Afrique — Front Page Template
 * Reuters & Essence Inspired Editorial Broadsheet
 * Distinct Layout UI for Each Section, Inverted Theme Contrast Section, & YouTube Video Broadcasts
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial broadsheet-main">

    <!-- ==========================================================================
         0. ABOVE-THE-FOLD VIEWPORT HERO SECTION (News & Geopolitics)
         Strictly 100% visible on load with zero scrolling required!
         ========================================================================== -->
    <section class="viewport-hero-section" aria-label="Lead Investigation &amp; Continental Telegraph">
        <div class="viewport-hero-grid">
            
            <?php
            $displayed_post_ids = array();

            // 1. Lead Story Query (Top breaking story)
            $lead_query = new WP_Query(array(
                'posts_per_page'      => 1,
                'ignore_sticky_posts' => 1,
                'post_status'         => 'publish'
            ));

            if ($lead_query->have_posts()) :
                while ($lead_query->have_posts()) : $lead_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
                    $cats = get_the_category();
                    $lead_cat_name = (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') ? $cats[0]->name : 'GEOPOLITICS';
            ?>
            <!-- Main Lead Story (Left Column: Dominant Editorial Investigation) -->
            <article class="hero-lead-card">
                <div class="hero-lead-header">
                    <div class="hero-kicker-cluster">
                        <span class="hero-kicker-lead-badge">★ LEAD INVESTIGATION</span>
                        <span class="hero-kicker-cat"><?php echo esc_html(strtoupper($lead_cat_name)); ?></span>
                        <span class="hero-kicker-sep">·</span>
                        <span class="hero-kicker-time"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                    </div>
                </div>

                <h1 class="hero-lead-headline vintage-newspaper-headline">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>

                <?php
                $lead_deck = get_the_excerpt();
                if (empty($lead_deck) || trim($lead_deck) === '') {
                    $lead_deck = wp_trim_words(strip_shortcodes(get_the_content()), 20, '...');
                }
                ?>
                <p class="hero-lead-deck">
                    <?php echo esc_html(wp_trim_words($lead_deck, 22)); ?>
                </p>

                <?php if (has_post_thumbnail()) : ?>
                    <figure class="hero-lead-figure">
                        <a href="<?php the_permalink(); ?>" class="hero-lead-img-wrap">
                            <?php the_post_thumbnail('magazine-hero', array('class' => 'hero-lead-img')); ?>
                        </a>
                    </figure>
                <?php endif; ?>

                <div class="hero-lead-footer">
                    <span class="hero-lead-byline">
                        By <?php the_author(); ?> · <?php echo esc_html(get_the_date('M j, Y')); ?>
                    </span>
                    <a href="<?php the_permalink(); ?>" class="hero-lead-cta">
                        Read Story →
                    </a>
                </div>
            </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>

            <!-- The Continental Telegraph (Right Column: 3 Aligned Companion Stories) -->
            <aside class="hero-telegraph-col">
                <div class="telegraph-header-bar">
                    <div class="telegraph-title-wrap">
                        <span class="pulse-amber-dot">●</span>
                        <h2 class="telegraph-main-title">THE CONTINENTAL TELEGRAPH</h2>
                    </div>
                    <span class="telegraph-badge">LIVE WIRE</span>
                </div>

                <div class="telegraph-stories-stack">
                    <?php
                    $telegraph_query = new WP_Query(array(
                        'posts_per_page'      => 3,
                        'post__not_in'        => $displayed_post_ids,
                        'ignore_sticky_posts' => 1,
                        'post_status'         => 'publish'
                    ));

                    $tel_idx = 0;
                    if ($telegraph_query->have_posts()) :
                        while ($telegraph_query->have_posts()) : $telegraph_query->the_post();
                            $displayed_post_ids[] = get_the_ID();
                            $tel_idx++;
                            $t_cats = get_the_category();
                            $t_cat_name = (!empty($t_cats) && strtolower($t_cats[0]->slug) !== 'uncategorized') ? $t_cats[0]->name : 'INTELLIGENCE';
                    ?>
                        <?php if ($tel_idx === 1) : ?>
                            <article class="telegraph-featured-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>" class="telegraph-thumb-link">
                                        <?php the_post_thumbnail('medium_large', array('class' => 'telegraph-thumb-img')); ?>
                                    </a>
                                <?php endif; ?>
                                <div class="telegraph-item-content">
                                    <div class="telegraph-item-kicker">
                                        <span class="kicker-tag"><?php echo esc_html(strtoupper($t_cat_name)); ?></span>
                                        <span class="kicker-dot">·</span>
                                        <span class="kicker-time"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                                    </div>
                                    <h3 class="telegraph-item-title vintage-newspaper-headline">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                </div>
                            </article>
                        <?php else : ?>
                            <article class="telegraph-compact-item">
                                <div class="telegraph-item-kicker">
                                    <span class="kicker-tag"><?php echo esc_html(strtoupper($t_cat_name)); ?></span>
                                    <span class="kicker-dot">·</span>
                                    <span class="kicker-time"><?php echo esc_html(get_the_date('j M')); ?></span>
                                </div>
                                <h3 class="telegraph-compact-title vintage-newspaper-headline">
                                    <a href="<?php the_permalink(); ?>">
                                        <span class="telegraph-arrow">›</span> <?php the_title(); ?>
                                    </a>
                                </h3>
                                <div class="telegraph-compact-meta">
                                    <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                                </div>
                            </article>
                        <?php endif; ?>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <!-- Continental Macro Radar Pill -->
                <div class="telegraph-macro-radar">
                    <div class="radar-label-row">
                        <span class="radar-title">CONTINENTAL MACRO RADAR</span>
                        <span class="radar-glyph">❖</span>
                    </div>
                    <div class="radar-pills-row">
                        <div class="radar-pill">
                            <span class="radar-lbl">AfCFTA</span>
                            <span class="radar-val" style="color: #D97706;">+18.4%</span>
                        </div>
                        <div class="radar-pill">
                            <span class="radar-lbl">RESERVES</span>
                            <span class="radar-val" style="color: #B45309;">$412B</span>
                        </div>
                        <div class="radar-pill">
                            <span class="radar-lbl">ENERGY</span>
                            <span class="radar-val" style="color: #D97706;">$24.2B</span>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         1. STRATEGIC COMMERCIAL LEADERBOARD (Mid-Home Ad Zone)
         ========================================================================== -->
    <?php
    if (function_exists('magazineafrique_render_ad_mid_home')) {
        magazineafrique_render_ad_mid_home();
    }
    ?>

    <!-- ==========================================================================
         2. BUSINESS & ENTERPRISE DESK (UI: Financial Ledger Split - Reuters Inspired)
         Asymmetrical 55/45: 1 Large Feature + 3 Horizontal Wire Rows
         ========================================================================== -->
    <!-- ==========================================================================
         2. BUSINESS, ENTERPRISE & AfCFTA INTELLIGENCE DESK
         UI: Asymmetric Financial Dossier & Continental Market Wire Ledger
         Featuring Pan-African Bourse Ribbon, Dominant Lead & Live Dispatch Stack
         ========================================================================== -->
    <section class="desk-section desk-business-split" aria-label="Business &amp; Economy">
        <div class="desk-section-header biz-section-header">
            <div class="desk-heading-left">
                <span class="desk-bullet">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Business &amp; Enterprise</h2>
                <span class="desk-section-tag">AfCFTA · MACRO MARKETS · BANKING &amp; ENERGY</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('business')); ?>" class="desk-view-index-btn">
                Business Index →
            </a>
        </div>

        <!-- Pan-African Financial Indicators & Bourse Ribbon -->
        <div class="biz-markets-ribbon" aria-label="Key African Market Indices">
            <div class="biz-ribbon-tag">
                <span class="biz-ribbon-pulse">●</span> AfCFTA BOURSE WIRE
            </div>
            <div class="biz-ribbon-items">
                <span class="biz-ticker-chip"><span class="ticker-sym">NGX 30</span> <span class="ticker-up">▲ 104,285 (+1.1%)</span></span>
                <span class="biz-ticker-sep">/</span>
                <span class="biz-ticker-chip"><span class="ticker-sym">JSE ALL SHARE</span> <span class="ticker-down">▼ 78,920 (-0.3%)</span></span>
                <span class="biz-ticker-sep">/</span>
                <span class="biz-ticker-chip"><span class="ticker-sym">EGX 30</span> <span class="ticker-up">▲ 31,450 (+0.8%)</span></span>
                <span class="biz-ticker-sep">/</span>
                <span class="biz-ticker-chip"><span class="ticker-sym">BRENT CRUDE</span> <span class="ticker-up">▲ $82.40/bbl</span></span>
                <span class="biz-ticker-sep">/</span>
                <span class="biz-ticker-chip"><span class="ticker-sym">COCOA FUTURES</span> <span class="ticker-up">▲ $7,650/t</span></span>
            </div>
        </div>

        <div class="biz-ledger-grid">
            <?php
            $biz_query = magazineafrique_query_category_posts(array('business', 'economy', 'fintech', 'cryptocurrency'), 5, $displayed_post_ids);
            $b_idx = 0;
            if ($biz_query->have_posts()) :
                while ($biz_query->have_posts()) : $biz_query->the_post();
                    $b_idx++;
                    $displayed_post_ids[] = get_the_ID();
                    $b_cats = get_the_category();
                    $b_name = (!empty($b_cats) && strtolower($b_cats[0]->slug) !== 'uncategorized') ? $b_cats[0]->name : 'BUSINESS';
            ?>
                <?php if ($b_idx === 1) : ?>
                    <!-- Left: Dominant Enterprise Feature -->
                    <article class="biz-lead-card">
                        <div class="biz-lead-top-strip">
                            <span class="biz-lead-dossier-pill">★ AfCFTA INTELLIGENCE DOSSIER</span>
                            <span class="biz-lead-date"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                        </div>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="biz-lead-thumb-wrap">
                                <?php the_post_thumbnail('magazine-hero', array('class' => 'biz-lead-thumb-img')); ?>
                                <span class="biz-lead-cat-tag"><?php echo esc_html(strtoupper($b_name)); ?></span>
                            </a>
                        <?php endif; ?>
                        <div class="biz-lead-body">
                            <div class="card-kicker-row">
                                <span class="card-kicker-badge"><?php echo esc_html(strtoupper($b_name)); ?></span>
                                <span class="card-meta-dot">·</span>
                                <span class="card-date-stamp"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                            </div>
                            <h3 class="biz-lead-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="biz-lead-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 24); ?>
                            </p>
                            <div class="biz-lead-footer">
                                <span class="biz-lead-byline">Correspondent Desk · Financial Despatch</span>
                                <a href="<?php the_permalink(); ?>" class="biz-lead-btn">Analyze Flow →</a>
                            </div>
                        </div>
                    </article>

                    <!-- Start Right: Continental Market Wire Ledger Container -->
                    <div class="biz-wire-ledger-box">
                        <div class="biz-wire-ledger-header">
                            <span class="biz-ledger-pill">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 4px; vertical-align: middle;">
                                    <polygon points="5 3 19 12 5 21 5 3"/>
                                </svg>
                                CORPORATE WIRE
                            </span>
                            <span class="biz-ledger-live">● LIVE DESK</span>
                        </div>
                        <div class="biz-wire-items-stack">
                <?php else : ?>
                    <!-- Right: Structured Dispatch Row with Thumbnail and Meta -->
                    <article class="biz-wire-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="biz-wire-thumb-link">
                                <?php the_post_thumbnail('magazine-thumb', array('class' => 'biz-wire-thumb-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="biz-wire-content">
                            <div class="card-kicker-row">
                                <span class="card-kicker-badge"><?php echo esc_html(strtoupper($b_name)); ?></span>
                                <span class="card-meta-dot">·</span>
                                <span class="card-date-stamp"><?php echo esc_html(get_the_date('j M')); ?></span>
                            </div>
                            <h4 class="biz-wire-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <div class="biz-wire-meta">
                                <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                                <a href="<?php the_permalink(); ?>" class="card-read-more-link">Read →</a>
                            </div>
                        </div>
                    </article>
                <?php endif; ?>
            <?php
                endwhile;
                if ($b_idx > 1) {
                    echo '</div>'; // close biz-wire-items-stack
                    echo '<div class="biz-wire-ledger-footer">';
                    echo '<a href="' . esc_url(magazineafrique_get_cat_url('business')) . '" class="biz-ledger-more-link">View Full Corporate Index &amp; Earnings Archive →</a>';
                    echo '</div>';
                    echo '</div>'; // close biz-wire-ledger-box
                }
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         3. LIFESTYLE & LIVING SALON (Full-Width Inverted Contrast Desk)
         Pure African Luxury, Haute Couture, Design & Private Escapes
         Inverted Theme: Dark in Light Mode (#141210) | Light in Dark Mode (#FAF7F2)
         Tactile Postcard Design with Offset Hard Drop Shadow (6px 6px 0px #000)
         Full-Width Viewport Spread (Not Boxed)
         ========================================================================== -->
    <section class="desk-section desk-lifestyle-fullwidth desk-lifestyle-inverted" aria-label="Lifestyle &amp; Living">
        <div class="lifestyle-fullwidth-inner">
            <div class="desk-section-header lifestyle-inverted-header">
                <div class="desk-heading-left">
                    <span class="desk-bullet">❖</span>
                    <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Lifestyle &amp; Living</h2>
                    <span class="desk-section-tag">AFRICAN LUXURY · HAUTE COUTURE · ESCAPES &amp; DESIGN</span>
                </div>
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>" class="lifestyle-index-club-btn">
                    Lifestyle Salon ↗
                </a>
            </div>

            <div class="lifestyle-postcards-grid">
                <?php
                $life_query = magazineafrique_query_category_posts(array('lifestyle'), 4, $displayed_post_ids);
                if ($life_query->have_posts()) :
                    while ($life_query->have_posts()) : $life_query->the_post();
                        $displayed_post_ids[] = get_the_ID();

                        // 1 tag if available, otherwise nothing (not hardcoded 'LIFESTYLE')
                        $life_tags = get_the_tags();
                        $life_tag_name = '';
                        if (!empty($life_tags) && is_array($life_tags)) {
                            $first_tag = reset($life_tags);
                            if (!empty($first_tag->name)) {
                                $life_tag_name = $first_tag->name;
                            }
                        }
                ?>
                    <article class="lifestyle-postcard">
                        <div class="lifestyle-postcard-stamp-header">
                            <?php if (!empty($life_tag_name)) : ?>
                                <span class="lifestyle-club-badge"><?php echo esc_html(strtoupper($life_tag_name)); ?></span>
                            <?php endif; ?>
                            <span class="lifestyle-postal-mark">AFRIQUE № <?php the_ID(); ?></span>
                        </div>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="lifestyle-postcard-img-wrap">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'lifestyle-postcard-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="lifestyle-postcard-body">
                            <h3 class="lifestyle-postcard-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="lifestyle-postcard-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 16); ?>
                            </p>
                            <div class="lifestyle-postcard-footer">
                                <span class="lifestyle-postcard-meta"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                                <a href="<?php the_permalink(); ?>" class="lifestyle-postcard-btn">
                                    READ ↗
                                </a>
                            </div>
                        </div>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         4. PAN-AFRICAN ARCHIVE VAULT (Culture, History & Liberation Papers)
         UI: Historic Classified Dossiers & Archival Records
         ========================================================================== -->
    <section class="desk-section desk-archive-vault" aria-label="Pan-African Culture &amp; History Archive">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-bullet">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">The Pan-African Archive Vault</h2>
                <span class="desk-section-tag">CLASSIFIED HISTORICAL DOSSIERS · LIBERATION PAPERS</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('culture-history')); ?>" class="desk-view-index-btn">
                Archive Registry →
            </a>
        </div>

        <div class="archive-vault-grid">
            <?php
            $hist_query = magazineafrique_query_category_posts(array('culture-history'), 3, $displayed_post_ids);
            if ($hist_query->have_posts()) :
                while ($hist_query->have_posts()) : $hist_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="archive-vault-card">
                    <div class="vault-card-stamp-row">
                        <span class="vault-stamp-tag">HISTORICAL RECORD</span>
                        <span class="vault-serial-num">#DOSSIER-<?php the_ID(); ?></span>
                    </div>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="vault-thumb-wrap">
                            <?php the_post_thumbnail('magazine-card', array('class' => 'vault-thumb-img')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="vault-card-body">
                        <h3 class="vault-card-title vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="vault-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                        </p>
                        <div class="vault-card-footer">
                            <span>ARCHIVE RECORD · <?php echo esc_html(get_the_date('M Y')); ?></span>
                            <a href="<?php the_permalink(); ?>" class="card-read-more-link">Unseal File →</a>
                        </div>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         5. YOUTUBE MULTIMEDIA BROADCASTS NETWORK (Long-Form & Shorts)
         Official Channel: @magazineafrique
         Featuring Playlists: Investigations, Business, Culture, Leaders & Docuseries
         ========================================================================== -->
    <section class="desk-section desk-youtube-broadcasts" aria-label="YouTube Video Network">
        <div class="desk-section-header yt-network-header">
            <div class="desk-heading-left">
                <span class="youtube-live-dot">●</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Gazette Video Broadcasts</h2>
                <span class="desk-section-tag">YOUTUBE MULTIMEDIA · INVESTIGATIONS, BRIEFINGS &amp; SHORTS</span>
            </div>
            <div class="yt-header-actions">
                <a href="https://www.youtube.com/@magazineafrique/playlists" target="_blank" rel="noopener" class="youtube-all-playlists-btn">
                    All Playlists ↗
                </a>
                <a href="https://www.youtube.com/@magazineafrique?sub_confirmation=1" target="_blank" rel="noopener" class="youtube-channel-subscribe-btn">
                    <svg width="18" height="14" viewBox="0 0 24 18" fill="currentColor" style="color: #FF0000; vertical-align: middle; margin-right: 4px;">
                        <path d="M23.498 2.628a3.008 3.008 0 0 0-2.119-2.128C19.505 0 12 0 12 0S4.495 0 2.621.5C1.684.75 1.002 1.488.752 2.628 0 4.512 0 8.5 0 8.5s0 3.988.752 5.872c.25.99.932 1.728 1.869 1.978C4.495 17 12 17 12 17s7.505 0 9.379-.5a3.008 3.008 0 0 0 2.119-2.128C24 12.488 24 8.5 24 8.5s0-3.988-.502-5.872zM9.545 12.115V4.885L15.818 8.5l-6.273 3.615z"/>
                    </svg>
                    Subscribe ↗
                </a>
            </div>
        </div>

        <!-- Playlist Selector Tabs: All 12 Official Playlists from @magazineafrique -->
        <div class="yt-playlist-nav-bar" role="tablist" aria-label="Gazette Video Playlists">
            <button class="yt-playlist-tab-btn is-active" data-playlist="PLnGpogtv2UARznTBTJ_TknKHKhWVk4qtv">
                ★ Politics
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLnGpogtv2UATSqmBn9XqTU4IMn6l0TAik">
                Business &amp; Economy
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLnGpogtv2UATD_q30h64Xr5YsBQADyOrI">
                Weekly Recap
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLLAt7u0bxSBg">
                News
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLnGpogtv2UATQd69yfPpidtZRPBpb00DK">
                Health
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLnGpogtv2UASAbRuiVSsjFjeqH5S_DbKV">
                Lifestyle
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLnGpogtv2UAQ4NEsMmTVDH5GlBNQv5Jwh">
                Trend
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLXG609iDRBIk">
                History
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLD7ZNgg8ggj8">
                Sports
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLDNmDjH5G7Uc">
                Technology
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLnGpogtv2UATgW12_6pUg-QLTfrZuECUf">
                Entertainment &amp; Celebrities
            </button>
            <button class="yt-playlist-tab-btn" data-playlist="PLnGpogtv2UAT7lLVZ-JOAvFt6Ell87pm7">
                Education
            </button>
        </div>

        <div class="youtube-studio-grid">
            
            <!-- Left (62%): Embedded Interactive Widescreen Player -->
            <div class="youtube-longform-column">
                <div class="yt-player-container-card">
                    <div class="yt-video-responsive-frame">
                        <iframe id="gazette-youtube-player" 
                                src="https://www.youtube-nocookie.com/embed/videoseries?list=PLnGpogtv2UARznTBTJ_TknKHKhWVk4qtv" 
                                title="Magazine Afrique YouTube Player" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                referrerpolicy="strict-origin-when-cross-origin" 
                                allowfullscreen>
                        </iframe>
                    </div>
                    <div class="yt-feature-meta-block">
                        <div class="yt-meta-badge-row">
                            <span class="yt-broadcast-kicker" id="yt-active-kicker">★ CONTINENTAL BROADCAST DESK</span>
                            <span class="yt-meta-live-badge">FULL ARCHIVE</span>
                        </div>
                        <h3 class="yt-feature-title" id="yt-active-title">
                            <a href="https://www.youtube.com/@magazineafrique" target="_blank" rel="noopener">
                                Magazine Afrique Video Despatches &amp; Investigative Series
                            </a>
                        </h3>
                        <p class="yt-feature-desc" id="yt-active-desc">
                            Direct from our correspondents across Dakar, Lagos, Nairobi, Johannesburg and London. Select any playlist tab above or video from the broadcast wire on the right to stream curated investigations, geopolitical deep-dives, economic masterclasses, and cultural portraits.
                        </p>
                        <div class="yt-quick-playlist-links">
                            <a href="https://youtube.com/playlist?list=PLnGpogtv2UARznTBTJ_TknKHKhWVk4qtv" target="_blank" rel="noopener" class="yt-pill-link">Politics ↗</a>
                            <a href="https://youtube.com/playlist?list=PLnGpogtv2UATSqmBn9XqTU4IMn6l0TAik" target="_blank" rel="noopener" class="yt-pill-link">Business Desk ↗</a>
                            <a href="https://youtube.com/playlist?list=PLnGpogtv2UATD_q30h64Xr5YsBQADyOrI" target="_blank" rel="noopener" class="yt-pill-link">Weekly Recap ↗</a>
                            <a href="https://youtube.com/playlist?list=PLLAt7u0bxSBg" target="_blank" rel="noopener" class="yt-pill-link">News Wire ↗</a>
                            <a href="https://youtube.com/playlist?list=PLDNmDjH5G7Uc" target="_blank" rel="noopener" class="yt-pill-link">Tech &amp; Innovation ↗</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right (38%): Up Next Broadcast Dispatches Queue (Fills height naturally, zero blank space) -->
            <div class="youtube-queue-column">
                <div class="yt-queue-header">
                    <span class="yt-queue-pill">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 4px; vertical-align: middle;">
                            <polygon points="5 3 19 12 5 21 5 3"/>
                        </svg>
                        BROADCAST WIRE
                    </span>
                    <span class="yt-queue-count">4 Episodes</span>
                </div>

                <div class="yt-queue-list">
                    <!-- Queue Item 1 -->
                    <div class="yt-queue-item is-playing" data-video-id="AvJa2PomdbE" data-playlist-id="PLnGpogtv2UATgW12_6pUg-QLTfrZuECUf" data-kicker="★ GEOPOLITICS &amp; SAHEL" data-title="Sovereignty, Suspicion, and the Sahel: The Shifting Balance of Power" data-desc="Analyzing political transitions, sovereign security alliances, and strategic diplomatic realignments across the Sahel region.">
                        <div class="yt-queue-thumb-wrap">
                            <img src="https://i.ytimg.com/vi/AvJa2PomdbE/hqdefault.jpg" alt="Sovereignty, Suspicion, and the Sahel" class="yt-queue-thumb-img" loading="lazy" />
                            <div class="yt-queue-thumb-scrim"></div>
                            <span class="yt-queue-play-btn">▶</span>
                            <span class="yt-queue-duration">12:45</span>
                        </div>
                        <div class="yt-queue-info">
                            <span class="yt-queue-cat">#GEOPOLITICS</span>
                            <h4 class="yt-queue-item-title">Sovereignty, Suspicion, and the Sahel: Balance of Power</h4>
                            <span class="yt-queue-meta">Magazine Afrique · Now Playing</span>
                        </div>
                    </div>

                    <!-- Queue Item 2 -->
                    <div class="yt-queue-item" data-video-id="0Mao6iEAUL4" data-playlist-id="PLnGpogtv2UATgW12_6pUg-QLTfrZuECUf" data-kicker="★ HISTORICAL RETROSPECTIVE" data-title="NIGERIA AT 64 : What Has Changed &amp; The Governance Roadmap" data-desc="A critical editorial documentary evaluating macroeconomic policies, fiscal federalism, and the governance roadmap for Africa's largest democracy.">
                        <div class="yt-queue-thumb-wrap">
                            <img src="https://i.ytimg.com/vi/0Mao6iEAUL4/hqdefault.jpg" alt="NIGERIA AT 64" class="yt-queue-thumb-img" loading="lazy" />
                            <div class="yt-queue-thumb-scrim"></div>
                            <span class="yt-queue-play-btn">▶</span>
                            <span class="yt-queue-duration">18:10</span>
                        </div>
                        <div class="yt-queue-info">
                            <span class="yt-queue-cat">#GOVERNANCE</span>
                            <h4 class="yt-queue-item-title">NIGERIA AT 64 : What Has Changed &amp; The Road Ahead</h4>
                            <span class="yt-queue-meta">Special Documentary · Stream</span>
                        </div>
                    </div>

                    <!-- Queue Item 3 -->
                    <div class="yt-queue-item" data-video-id="blvP6oNSW1U" data-playlist-id="PLnGpogtv2UASAbRuiVSsjFjeqH5S_DbKV" data-kicker="★ BUSINESS &amp; STRATEGIC RESOURCES" data-title="America Wants Congo Minerals: Where Are The Real Continental Investments?" data-desc="From Katanga's cobalt belt to global supply chains: examining how African nations are demanding domestic beneficiation.">
                        <div class="yt-queue-thumb-wrap">
                            <img src="https://i.ytimg.com/vi/blvP6oNSW1U/hqdefault.jpg" alt="America Wants Congo Minerals" class="yt-queue-thumb-img" loading="lazy" />
                            <div class="yt-queue-thumb-scrim"></div>
                            <span class="yt-queue-play-btn">▶</span>
                            <span class="yt-queue-duration">01:00</span>
                        </div>
                        <div class="yt-queue-info">
                            <span class="yt-queue-cat">#MINERALS</span>
                            <h4 class="yt-queue-item-title">America Wants Congo Minerals: Investment vs Scramble</h4>
                            <span class="yt-queue-meta">Business Desk · Stream</span>
                        </div>
                    </div>

                    <!-- Queue Item 4 -->
                    <div class="yt-queue-item" data-video-id="AaKx7GOLQ0c" data-playlist-id="PLLAt7u0bxSBg" data-kicker="★ MACRO-ECONOMY &amp; FINANCE" data-title="The Gambia to Receive $28 Million from IMF: Fiscal Realities Explained" data-desc="Analyzing debt sustainability, structural fiscal reforms, and foreign currency liquidity in West Africa.">
                        <div class="yt-queue-thumb-wrap">
                            <img src="https://i.ytimg.com/vi/AaKx7GOLQ0c/hqdefault.jpg" alt="Gambia IMF Funding" class="yt-queue-thumb-img" loading="lazy" />
                            <div class="yt-queue-thumb-scrim"></div>
                            <span class="yt-queue-play-btn">▶</span>
                            <span class="yt-queue-duration">01:00</span>
                        </div>
                        <div class="yt-queue-info">
                            <span class="yt-queue-cat">#MACRO</span>
                            <h4 class="yt-queue-item-title">The Gambia to Receive $28M from IMF: What It Means</h4>
                            <span class="yt-queue-meta">Finance Wire · Stream</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Dedicated Lower Shelf: Field Shorts & Vertical Reels with High-Res Channel Thumbnails -->
        <div class="yt-shorts-shelf">
            <div class="yt-shorts-shelf-header">
                <div class="yt-shorts-shelf-title">
                    <span class="yt-shorts-pill">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 4px; vertical-align: middle;">
                            <path d="M10 15l5.19-3L10 9v6m11.5-6.6a2.6 2.6 0 00-1.8-1.8C18 6.1 12 6.1 12 6.1s-6 0-7.7.5a2.6 2.6 0 00-1.8 1.8A27.2 27.2 0 002 12a27.2 27.2 0 00.5 5.6 2.6 2.6 0 001.8 1.8c1.7.5 7.7.5 7.7.5s6 0 7.7-.5a2.6 2.6 0 001.8-1.8A27.2 27.2 0 0022 12a27.2 27.2 0 00-.5-6.6z"/>
                        </svg>
                        FIELD SHORTS
                    </span>
                    <span class="yt-shorts-shelf-desc">Vertical Despatches &amp; On-the-Ground Correspondent Reels</span>
                </div>
                <a href="https://www.youtube.com/@magazineafrique/shorts" target="_blank" rel="noopener" class="yt-shorts-channel-link">
                    @magazineafrique/shorts ↗
                </a>
            </div>

            <div class="yt-shorts-shelf-grid">
                <!-- Reel 1: Congo Minerals -->
                <a href="https://www.youtube.com/shorts/blvP6oNSW1U" target="_blank" rel="noopener" class="yt-short-shelf-card">
                    <div class="yt-short-shelf-wrap">
                        <img src="https://i.ytimg.com/vi/blvP6oNSW1U/hqdefault.jpg" alt="America Wants Congo Minerals" class="yt-short-shelf-bg-img" loading="lazy" />
                        <div class="yt-short-shelf-scrim"></div>
                        <span class="yt-short-shelf-play">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#FFFFFF"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                        </span>
                        <div class="yt-short-shelf-caption">
                            <span class="yt-short-shelf-cat">#RESOURCES</span>
                            <h4 class="yt-short-shelf-title">America Wants Congo Minerals: Where Are The Real Investments?</h4>
                            <span class="yt-short-shelf-cta">Watch on Shorts ↗</span>
                        </div>
                    </div>
                </a>

                <!-- Reel 2: Gambia IMF -->
                <a href="https://www.youtube.com/shorts/AaKx7GOLQ0c" target="_blank" rel="noopener" class="yt-short-shelf-card">
                    <div class="yt-short-shelf-wrap">
                        <img src="https://i.ytimg.com/vi/AaKx7GOLQ0c/hqdefault.jpg" alt="Gambia IMF Funding" class="yt-short-shelf-bg-img" loading="lazy" />
                        <div class="yt-short-shelf-scrim"></div>
                        <span class="yt-short-shelf-play">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#FFFFFF"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                        </span>
                        <div class="yt-short-shelf-caption">
                            <span class="yt-short-shelf-cat">#MACRO</span>
                            <h4 class="yt-short-shelf-title">The Gambia Set to Receive $28M from IMF: What It Means</h4>
                            <span class="yt-short-shelf-cta">Watch on Shorts ↗</span>
                        </div>
                    </div>
                </a>

                <!-- Reel 3: Lagos Calabar Highway -->
                <a href="https://www.youtube.com/shorts/mWK05rniLe8" target="_blank" rel="noopener" class="yt-short-shelf-card">
                    <div class="yt-short-shelf-wrap">
                        <img src="https://i.ytimg.com/vi/mWK05rniLe8/hqdefault.jpg" alt="Lagos-Calabar Coastal Highway" class="yt-short-shelf-bg-img" loading="lazy" />
                        <div class="yt-short-shelf-scrim"></div>
                        <span class="yt-short-shelf-play">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#FFFFFF"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                        </span>
                        <div class="yt-short-shelf-caption">
                            <span class="yt-short-shelf-cat">#INFRASTRUCTURE</span>
                            <h4 class="yt-short-shelf-title">Lagos–Calabar Coastal Highway: Is the Route Changing?</h4>
                            <span class="yt-short-shelf-cta">Watch on Shorts ↗</span>
                        </div>
                    </div>
                </a>

                <!-- Reel 4: Health Alert -->
                <a href="https://www.youtube.com/shorts/icgp_N16u58" target="_blank" rel="noopener" class="yt-short-shelf-card">
                    <div class="yt-short-shelf-wrap">
                        <img src="https://i.ytimg.com/vi/icgp_N16u58/hqdefault.jpg" alt="WHO Health Alert" class="yt-short-shelf-bg-img" loading="lazy" />
                        <div class="yt-short-shelf-scrim"></div>
                        <span class="yt-short-shelf-play">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#FFFFFF"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                        </span>
                        <div class="yt-short-shelf-caption">
                            <span class="yt-short-shelf-cat">#HEALTH</span>
                            <h4 class="yt-short-shelf-title">Ebola &amp; Mpox Warning: Regional Health Surveillance Update</h4>
                            <span class="yt-short-shelf-cta">Watch on Shorts ↗</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         6. HEALTH & WELLNESS INTELLIGENCE (Strictly Separate from Lifestyle)
         UI: 3-Card Medical & Longevity Research Grid
         ========================================================================== -->
    <section class="desk-section desk-health-wellness" aria-label="Health &amp; Longevity">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-bullet">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Health &amp; Longevity</h2>
                <span class="desk-section-tag">PUBLIC HEALTH · RESEARCH · AFRICAN BOTANICALS</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>" class="desk-view-index-btn">
                Health Index →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $health_query = magazineafrique_query_category_posts(array('health'), 3, $displayed_post_ids);
            if ($health_query->have_posts()) :
                while ($health_query->have_posts()) : $health_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="standard-editorial-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-wrap">
                            <?php the_post_thumbnail('magazine-card', array('class' => 'card-media-img')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-content-wrap">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge">HEALTH INTELLIGENCE</span>
                            <span class="card-meta-dot">·</span>
                            <span class="card-date-stamp"><?php echo esc_html(get_the_date('M j')); ?></span>
                        </div>
                        <h3 class="card-headline-clamped vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="card-excerpt-clamped">
                            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                        </p>
                        <div class="card-footer-meta">
                            <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                            <a href="<?php the_permalink(); ?>" class="card-read-more-link">Read Research →</a>
                        </div>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         7. HOW-TO'S & PRACTICAL MASTERCLASSES (Strictly Separate from Lifestyle)
         UI: Step-by-Step Practical Manual Cards
         ========================================================================== -->
    <section class="desk-section desk-howtos-guides" aria-label="How-To's &amp; Guides">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-bullet">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">How-To's &amp; Practical Manuals</h2>
                <span class="desk-section-tag">STEP-BY-STEP GUIDES · BUSINESS PLAYBOOKS &amp; SKILLS</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('how-tos')); ?>" class="desk-view-index-btn">
                All Guides →
            </a>
        </div>

        <div class="howtos-manual-grid">
            <?php
            $how_query = magazineafrique_query_category_posts(array('how-tos'), 3, $displayed_post_ids);
            $h_num = 0;
            if ($how_query->have_posts()) :
                while ($how_query->have_posts()) : $how_query->the_post();
                    $h_num++;
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="manual-guide-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="manual-guide-thumb-wrap">
                            <a href="<?php the_permalink(); ?>" class="manual-guide-thumb-link" aria-label="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'manual-guide-thumb-img', 'loading' => 'lazy')); ?>
                            </a>
                            <span class="manual-step-badge">GUIDE #0<?php echo $h_num; ?></span>
                        </div>
                    <?php else : ?>
                        <div class="manual-guide-header">
                            <span class="manual-step-badge">GUIDE #0<?php echo $h_num; ?></span>
                            <span class="manual-type-pill">[ PRACTICAL MANUAL ]</span>
                        </div>
                    <?php endif; ?>
                    <div class="manual-guide-body">
                        <h3 class="manual-guide-title vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="manual-guide-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                        </p>
                    </div>
                    <div class="manual-guide-footer">
                        <span><?php echo esc_html(magazineafrique_reading_time()); ?> Manual</span>
                        <a href="<?php the_permalink(); ?>" class="manual-action-link">Open Manual →</a>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         8. BIOGRAPHY & CONTINENTAL CHANGEMAKERS (UI: Executive Portrait Gallery)
         ========================================================================== -->
    <section class="desk-section desk-biography-profiles" aria-label="Biography &amp; Changemakers">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-bullet">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Biography &amp; Changemakers</h2>
                <span class="desk-section-tag">STATESMEN · FOUNDERS · CONTINENTAL VOICES</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('biography')); ?>" class="desk-view-index-btn">
                Biography Index →
            </a>
        </div>

        <div class="bio-portrait-grid">
            <?php
            $bio_query = magazineafrique_query_category_posts(array('biography'), 3, $displayed_post_ids);
            if ($bio_query->have_posts()) :
                while ($bio_query->have_posts()) : $bio_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="bio-profile-card">
                    <div class="bio-card-top-row">
                        <div class="bio-avatar-ring">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', array('class' => 'bio-avatar-img')); ?>
                            <?php else : ?>
                                <span class="bio-avatar-initial"><?php echo esc_html(substr(get_the_title(), 0, 1)); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="bio-kicker-stack">
                            <span class="bio-badge">EXECUTIVE PROFILE</span>
                            <span class="bio-year"><?php echo esc_html(get_the_date('Y')); ?></span>
                        </div>
                    </div>
                    <h3 class="bio-profile-name vintage-newspaper-headline">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p class="bio-quote-deck">
                        “<?php echo wp_trim_words(get_the_excerpt(), 18); ?>”
                    </p>
                    <div class="card-footer-meta">
                        <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                        <a href="<?php the_permalink(); ?>" class="card-read-more-link">Read Profile →</a>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         9. TECHNOLOGY & INNOVATION (UI: 4-Column Modern Tech Grid)
         ========================================================================== -->
    <section class="desk-section desk-technology-modern" aria-label="Technology &amp; Innovation">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-bullet">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Technology &amp; Innovation</h2>
                <span class="desk-section-tag">LEAPFROGGING · AI · STARTUPS · CLEAN TECH</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('technology')); ?>" class="desk-view-index-btn">
                Tech Desk →
            </a>
        </div>

        <div class="tech-grid-4col">
            <?php
            $tech_query = magazineafrique_query_category_posts(array('technology', 'fintech'), 4, $displayed_post_ids);
            if ($tech_query->have_posts()) :
                while ($tech_query->have_posts()) : $tech_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="tech-card-compact">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-wrap">
                            <?php the_post_thumbnail('magazine-card', array('class' => 'card-media-img')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="tech-card-body">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge">INNOVATION</span>
                            <span class="card-meta-dot">·</span>
                            <span class="card-date-stamp"><?php echo esc_html(get_the_date('M j')); ?></span>
                        </div>
                        <h4 class="tech-card-title vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <div class="tech-card-footer">
                            <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                            <a href="<?php the_permalink(); ?>" class="card-read-more-link">Tech →</a>
                        </div>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         10. ENTERTAINMENT & SPORTS (UI: Split Pop-Culture & Athletics Marquee)
         ========================================================================== -->
    <section class="desk-section desk-entertainment-sports" aria-label="Entertainment &amp; Sports">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-bullet">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Entertainment &amp; Sports</h2>
                <span class="desk-section-tag">AFROBEATS · CINEMA · CELEBRITIES · ATHLETICS</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('entertainment')); ?>" class="desk-view-index-btn">
                Entertainment Index →
            </a>
        </div>

        <div class="marquee-ent-sports-grid">
            <!-- Left: 2 Large Photo Cards (Entertainment & Cinema) -->
            <div class="ent-cards-pair">
                <?php
                $ent_query = magazineafrique_query_category_posts(array('entertainment', 'celebrities'), 2, $displayed_post_ids);
                if ($ent_query->have_posts()) :
                    while ($ent_query->have_posts()) : $ent_query->the_post();
                        $displayed_post_ids[] = get_the_ID();
                ?>
                    <article class="standard-editorial-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="card-thumb-wrap">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'card-media-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-content-wrap">
                            <div class="card-kicker-row">
                                <span class="card-kicker-badge">CINEMA &amp; MUSIC</span>
                                <span class="card-meta-dot">·</span>
                                <span class="card-date-stamp"><?php echo esc_html(get_the_date('M j')); ?></span>
                            </div>
                            <h3 class="card-headline-clamped vintage-newspaper-headline">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="card-excerpt-clamped">
                                <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                            </p>
                            <div class="card-footer-meta">
                                <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                                <a href="<?php the_permalink(); ?>" class="card-read-more-link">Explore →</a>
                            </div>
                        </div>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <!-- Right: Dedicated Sports Arena Column -->
            <aside class="sports-arena-col">
                <div class="sports-arena-header">
                    <span class="sports-arena-badge">🏟 SPORTS ARENA</span>
                    <a href="<?php echo esc_url(magazineafrique_get_cat_url('sports')); ?>" class="sports-arena-link">All Sports →</a>
                </div>
                <div class="sports-fixtures-stack">
                    <?php
                    $sports_query = magazineafrique_query_category_posts(array('sports'), 3, $displayed_post_ids);
                    if ($sports_query->have_posts()) :
                        while ($sports_query->have_posts()) : $sports_query->the_post();
                            $displayed_post_ids[] = get_the_ID();
                    ?>
                        <article class="sports-wire-item">
                            <span class="sports-wire-kicker">ATHLETICS &amp; FOOTBALL</span>
                            <h4 class="sports-wire-title vintage-newspaper-headline">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <div class="sports-wire-meta">
                                <span><?php echo esc_html(get_the_date('j M')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?></span>
                            </div>
                        </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </aside>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         11. EDUCATION & ACADEMIA (UI: 2-Column Broadsheet Knowledge Split)
         ========================================================================== -->
    <section class="desk-section desk-education-split" aria-label="Education &amp; Society">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-bullet">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Education &amp; Society</h2>
                <span class="desk-section-tag">DEMOGRAPHIC DIVIDEND · UNIVERSITIES · RESEARCH</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('education')); ?>" class="desk-view-index-btn">
                Education Index →
            </a>
        </div>

        <div class="grid-2col-knowledge">
            <?php
            $edu_query = magazineafrique_query_category_posts(array('education'), 2, $displayed_post_ids);
            if ($edu_query->have_posts()) :
                while ($edu_query->have_posts()) : $edu_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="knowledge-split-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-wrap">
                            <?php the_post_thumbnail('medium_large', array('class' => 'card-media-img')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-content-wrap">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge">KNOWLEDGE ECONOMY</span>
                            <span class="card-meta-dot">·</span>
                            <span class="card-date-stamp"><?php echo esc_html(get_the_date('M j')); ?></span>
                        </div>
                        <h3 class="card-headline-clamped vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="card-excerpt-clamped">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </p>
                        <div class="card-footer-meta">
                            <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                            <a href="<?php the_permalink(); ?>" class="card-read-more-link">Read Dispatch →</a>
                        </div>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         12. THE GAZETTE CHRONICLE & SOVEREIGN OPINION (UI: Columnists Gallery)
         ========================================================================== -->
    <section class="desk-section desk-chronicle-opinion" aria-label="The Gazette Chronicle &amp; Opinion">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-bullet">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">The Gazette Chronicle &amp; Opinion</h2>
                <span class="desk-section-tag">SOVEREIGN ESSAYS · INTELLECTUAL COMMENTARY</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('opinion')); ?>" class="desk-view-index-btn">
                Chronicle Hall →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $op_query = magazineafrique_query_category_posts(array('opinion', 'editorial'), 3, $displayed_post_ids);
            if ($op_query->have_posts()) :
                while ($op_query->have_posts()) : $op_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="standard-editorial-card opinion-columnist-card">
                    <div class="card-content-wrap" style="padding-top: 1.35rem;">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge">OP-ED ESSAY</span>
                            <span class="card-meta-dot">·</span>
                            <span class="card-date-stamp"><?php echo esc_html(get_the_date('M j')); ?></span>
                        </div>
                        <h3 class="card-headline-clamped vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="card-excerpt-clamped font-serif" style="font-style: italic;">
                            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                        </p>
                        <div class="opinion-author-row" style="display: flex; align-items: center; gap: 0.65rem; margin-top: auto; padding-top: 0.75rem; border-top: 1px dashed var(--border-color, #E8E2D8);">
                            <div style="width: 28px; height: 28px; border-radius: 50%; overflow: hidden; background: #171513; flex-shrink: 0;">
                                <?php echo get_avatar(get_the_author_meta('ID'), 28); ?>
                            </div>
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-primary, #171513);">
                                <?php the_author(); ?>
                            </span>
                            <span style="margin-left: auto; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: #B45309; font-weight: 700;">
                                Column →
                            </span>
                        </div>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         13. PAN-AFRICAN TOPIC RADAR (Topic Explorer Strip)
         ========================================================================== -->
    <section class="vintage-dispatch-compass-strip">
        <div class="compass-label-wrap">
            <span class="compass-glyph">❖</span>
            <span class="compass-title">PAN-AFRICAN TOPIC RADAR:</span>
        </div>
        <div class="compass-tags-row">
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('international-news')); ?>" class="compass-topic-chip">#InternationalNews</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('business')); ?>" class="compass-topic-chip">#Business</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('fintech')); ?>" class="compass-topic-chip">#Fintech</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('technology')); ?>" class="compass-topic-chip">#Technology</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>" class="compass-topic-chip">#Lifestyle</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>" class="compass-topic-chip">#Health</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('how-tos')); ?>" class="compass-topic-chip">#HowTos</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('culture-history')); ?>" class="compass-topic-chip">#CultureHistory</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('biography')); ?>" class="compass-topic-chip">#Biography</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('entertainment')); ?>" class="compass-topic-chip">#Entertainment</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('sports')); ?>" class="compass-topic-chip">#Sports</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('education')); ?>" class="compass-topic-chip">#Education</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('opinion')); ?>" class="compass-topic-chip">#Opinion</a>
        </div>
    </section>

    <!-- Clean Editorial Hairline Divider -->
    <div class="editorial-section-divider"></div>

    <!-- ==========================================================================
         14. CIRCULAR NOTICE (The Africa Brief Newsletter)
         ========================================================================== -->
    <section class="vintage-circular-notice">
        <div class="circular-notice-badge">CIRCULAR NOTICE TO READERS</div>
        <h3 class="circular-notice-title">THE AFRICA BRIEF — DELIVERED BY WIRE</h3>
        <p class="circular-notice-desc">
            Over forty-five thousand leaders, diplomats, and macro analysts receive our weekly intelligence dispatch every Thursday morning.
        </p>
        <form class="magazine-newsletter-form circular-notice-form">
            <input type="email" name="email" placeholder="Your work email address" required class="circular-notice-input" />
            <button type="submit" class="circular-notice-btn">Subscribe Gratis</button>
            <div class="newsletter-feedback"></div>
        </form>
    </section>

</main>

<?php get_footer(); ?>
