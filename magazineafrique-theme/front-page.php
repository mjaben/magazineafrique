<?php
/**
 * Magazine Afrique — Front Page Template
 * Reuters & Essence Inspired Editorial Broadsheet
 * Strict Viewport-Fitted Above-the-Fold Hero & Complete Category Desks
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial broadsheet-main">

    <!-- ==========================================================================
         1. ABOVE-THE-FOLD VIEWPORT HERO SECTION (Reuters & Essence Model)
         Guaranteed 100% visible on load with zero scrolling required!
         ========================================================================== -->
    <section class="viewport-hero-section" aria-label="Lead Investigation &amp; Continental Telegraph">
        <div class="viewport-hero-grid">
            
            <?php
            // Track displayed post IDs to avoid duplicate stories across the front page
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
                    // Query 3 companion wire stories
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
                            <!-- Companion Story 1: Featured Wire Card with 16:9 Thumbnail -->
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
                            <!-- Companion Stories 2 & 3: Compact Aligned Wire Dispatches (Zero Excerpts for Strict Alignment) -->
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

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- ==========================================================================
         2. STRATEGIC COMMERCIAL LEADERBOARD (Mid-Home High-CPM Ad Zone)
         ========================================================================== -->
    <?php
    if (function_exists('magazineafrique_render_ad_mid_home')) {
        magazineafrique_render_ad_mid_home();
    }
    ?>

    <!-- ==========================================================================
         3. BUSINESS, ECONOMY & FINTECH LEDGER
         Enterprise, AfCFTA, Mining, Banking & Digital Assets
         ========================================================================== -->
    <section class="broadsheet-category-desk desk-business-ledger" aria-label="Business, Economy &amp; Fintech">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-eyebrow-bullet" style="color: #D97706;">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Business &amp; Economy</h2>
                <span class="desk-section-tag">AfCFTA · MACRO MARKETS · FINTECH</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('business')); ?>" class="desk-view-index-btn">
                Business Index →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $biz_query = magazineafrique_query_category_posts(array('business', 'economy', 'fintech', 'cryptocurrency'), 3, $displayed_post_ids);
            if ($biz_query->have_posts()) :
                while ($biz_query->have_posts()) : $biz_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
                    $c_cats = get_the_category();
                    $c_name = (!empty($c_cats) && strtolower($c_cats[0]->slug) !== 'uncategorized') ? $c_cats[0]->name : 'BUSINESS';
            ?>
                <article class="standard-editorial-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-wrap">
                            <?php the_post_thumbnail('magazine-card', array('class' => 'card-media-img')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-content-wrap">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge" style="color: #D97706;"><?php echo esc_html(strtoupper($c_name)); ?></span>
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

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- ==========================================================================
         4. LIFESTYLE, LIVING & CULTURE (Essence Magazine Showcase)
         African Luxury, Living, Health, Culinary & How-To's
         ========================================================================== -->
    <section class="broadsheet-category-desk desk-essence-lifestyle" aria-label="Lifestyle &amp; Living">
        <div class="desk-section-header" style="border-bottom-color: #B45309;">
            <div class="desk-heading-left">
                <span class="desk-eyebrow-bullet" style="color: #B45309;">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Lifestyle &amp; Living</h2>
                <span class="desk-section-tag" style="color: #B45309;">AFRICAN LUXURY · WELLNESS · HOW-TO'S</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>" class="desk-view-index-btn" style="color: #B45309;">
                Lifestyle Index →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $life_query = magazineafrique_query_category_posts(array('lifestyle', 'health', 'how-tos'), 3, $displayed_post_ids);
            if ($life_query->have_posts()) :
                while ($life_query->have_posts()) : $life_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
                    $l_cats = get_the_category();
                    $l_name = (!empty($l_cats) && strtolower($l_cats[0]->slug) !== 'uncategorized') ? $l_cats[0]->name : 'LIFESTYLE';
            ?>
                <article class="standard-editorial-card essence-warm-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-wrap">
                            <?php the_post_thumbnail('magazine-card', array('class' => 'card-media-img')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-content-wrap">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge" style="color: #B45309;"><?php echo esc_html(strtoupper($l_name)); ?></span>
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
                            <a href="<?php the_permalink(); ?>" class="card-read-more-link" style="color: #B45309;">Explore Living →</a>
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

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- ==========================================================================
         5. HISTORY & HERITAGE ARCHIVE (Vintage Pan-African Dossiers)
         Culture, Historical Milestones & Liberation Chronicles
         ========================================================================== -->
    <section class="broadsheet-category-desk desk-vintage-archive" aria-label="Culture &amp; History Archive">
        <div class="desk-section-header" style="border-bottom-color: #8B2500;">
            <div class="desk-heading-left">
                <span class="desk-eyebrow-bullet" style="color: #8B2500;">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Culture &amp; History Archive</h2>
                <span class="desk-section-tag" style="color: #8B2500;">PAN-AFRICAN DOSSIERS · HERITAGE FILES</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('culture-history')); ?>" class="desk-view-index-btn" style="color: #8B2500;">
                Archive Files →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $hist_query = magazineafrique_query_category_posts(array('culture-history'), 3, $displayed_post_ids);
            if ($hist_query->have_posts()) :
                while ($hist_query->have_posts()) : $hist_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="standard-editorial-card archive-dossier-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-wrap">
                            <?php the_post_thumbnail('magazine-card', array('class' => 'card-media-img')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-content-wrap">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge" style="color: #8B2500;">HISTORICAL DOSSIER</span>
                            <span class="card-meta-dot">·</span>
                            <span class="card-date-stamp">#ARCHIVE-<?php the_ID(); ?></span>
                        </div>
                        <h3 class="card-headline-clamped vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="card-excerpt-clamped">
                            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                        </p>
                        <div class="card-footer-meta">
                            <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                            <a href="<?php the_permalink(); ?>" class="card-read-more-link" style="color: #8B2500;">Open Dossier →</a>
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

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- ==========================================================================
         6. BIOGRAPHY & CONTINENTAL CHANGEMAKERS
         Profiles of African Statesmen, Innovators, Founders & Icons
         ========================================================================== -->
    <section class="broadsheet-category-desk desk-biography-profiles" aria-label="Biography &amp; Changemakers">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-eyebrow-bullet" style="color: #D97706;">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Biography &amp; Changemakers</h2>
                <span class="desk-section-tag">LEADERS · INNOVATORS · CORRIDORS OF POWER</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('biography')); ?>" class="desk-view-index-btn">
                Biography Index →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $bio_query = magazineafrique_query_category_posts(array('biography'), 3, $displayed_post_ids);
            if ($bio_query->have_posts()) :
                while ($bio_query->have_posts()) : $bio_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="standard-editorial-card biography-profile-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-wrap">
                            <?php the_post_thumbnail('magazine-card', array('class' => 'card-media-img')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-content-wrap">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge" style="color: #D97706;">CONTINENTAL PROFILE</span>
                            <span class="card-meta-dot">·</span>
                            <span class="card-date-stamp"><?php echo esc_html(get_the_date('Y')); ?></span>
                        </div>
                        <h3 class="card-headline-clamped vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="card-excerpt-clamped">
                            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                        </p>
                        <div class="card-footer-meta">
                            <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                            <a href="<?php the_permalink(); ?>" class="card-read-more-link">Read Profile →</a>
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

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- ==========================================================================
         7. TECHNOLOGY & INNOVATION DESK
         Fintech Leapfrogging, Tech Hubs, Clean Energy & AI in Africa
         ========================================================================== -->
    <section class="broadsheet-category-desk desk-technology" aria-label="Technology &amp; Innovation">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-eyebrow-bullet" style="color: #B45309;">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Technology &amp; Innovation</h2>
                <span class="desk-section-tag">DIGITAL INFRASTRUCTURE · LEAPFROGGING · AI</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('technology')); ?>" class="desk-view-index-btn">
                Technology Index →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $tech_query = magazineafrique_query_category_posts(array('technology', 'fintech'), 3, $displayed_post_ids);
            if ($tech_query->have_posts()) :
                while ($tech_query->have_posts()) : $tech_query->the_post();
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
                            <span class="card-kicker-badge" style="color: #B45309;">TECH INNOVATION</span>
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
                            <a href="<?php the_permalink(); ?>" class="card-read-more-link">Read Technology →</a>
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

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- ==========================================================================
         8. ENTERTAINMENT, CELEBRITIES & SPORTS
         Music, Afrobeats, Cinema, Celebrities & Continental Athletics
         ========================================================================== -->
    <section class="broadsheet-category-desk desk-entertainment-sports" aria-label="Entertainment &amp; Sports">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-eyebrow-bullet" style="color: #D97706;">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Entertainment &amp; Sports</h2>
                <span class="desk-section-tag">AFROBEATS · CINEMA · CELEBRITIES · ATHLETICS</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('entertainment')); ?>" class="desk-view-index-btn">
                Entertainment Index →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $ent_query = magazineafrique_query_category_posts(array('entertainment', 'celebrities', 'sports'), 3, $displayed_post_ids);
            if ($ent_query->have_posts()) :
                while ($ent_query->have_posts()) : $ent_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
                    $e_cats = get_the_category();
                    $e_name = (!empty($e_cats) && strtolower($e_cats[0]->slug) !== 'uncategorized') ? $e_cats[0]->name : 'ENTERTAINMENT';
            ?>
                <article class="standard-editorial-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-wrap">
                            <?php the_post_thumbnail('magazine-card', array('class' => 'card-media-img')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-content-wrap">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge" style="color: #D97706;"><?php echo esc_html(strtoupper($e_name)); ?></span>
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

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- ==========================================================================
         9. EDUCATION & ACADEMIA
         Universities, Research, Youth Demographics & Society
         ========================================================================== -->
    <section class="broadsheet-category-desk desk-education" aria-label="Education &amp; Society">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-eyebrow-bullet" style="color: #B45309;">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">Education &amp; Society</h2>
                <span class="desk-section-tag">DEMOGRAPHIC DIVIDEND · UNIVERSITIES · KNOWLEDGE</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('education')); ?>" class="desk-view-index-btn">
                Education Index →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $edu_query = magazineafrique_query_category_posts(array('education'), 3, $displayed_post_ids);
            if ($edu_query->have_posts()) :
                while ($edu_query->have_posts()) : $edu_query->the_post();
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
                            <span class="card-kicker-badge" style="color: #B45309;">EDUCATION &amp; THOUGHT</span>
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
                            <a href="<?php the_permalink(); ?>" class="card-read-more-link">Read Education →</a>
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

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- ==========================================================================
         10. THE GAZETTE CHRONICLE & SOVEREIGN OPINION
         Longform Commentary, Columnists & Op-Ed Essays
         ========================================================================== -->
    <section class="broadsheet-category-desk desk-chronicle-opinion" aria-label="The Gazette Chronicle &amp; Opinion">
        <div class="desk-section-header">
            <div class="desk-heading-left">
                <span class="desk-eyebrow-bullet" style="color: #D97706;">❖</span>
                <h2 class="desk-main-heading font-serif vintage-newspaper-headline">The Gazette Chronicle &amp; Opinion</h2>
                <span class="desk-section-tag">INTELLECTUAL COMMENTARY · EDITORIAL ESSAYS</span>
            </div>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('opinion')); ?>" class="desk-view-index-btn">
                Chronicle Index →
            </a>
        </div>

        <div class="grid-aligned-3col">
            <?php
            $op_query = magazineafrique_query_category_posts(array('opinion', 'editorial'), 3, $displayed_post_ids);
            if ($op_query->have_posts()) :
                while ($op_query->have_posts()) : $op_query->the_post();
                    $displayed_post_ids[] = get_the_ID();
            ?>
                <article class="standard-editorial-card opinion-column-card">
                    <div class="card-content-wrap" style="padding-top: 1.25rem;">
                        <div class="card-kicker-row">
                            <span class="card-kicker-badge" style="color: #D97706;">SOVEREIGN ESSAY</span>
                            <span class="card-meta-dot">·</span>
                            <span class="card-date-stamp"><?php echo esc_html(get_the_date('M j')); ?></span>
                        </div>
                        <h3 class="card-headline-clamped vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="card-excerpt-clamped">
                            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                        </p>
                        <div class="opinion-author-row" style="display: flex; align-items: center; gap: 0.65rem; margin-top: auto; padding-top: 0.75rem; border-top: 1px dashed var(--border-color, #4A433B);">
                            <div style="width: 26px; height: 26px; border-radius: 50%; overflow: hidden; background: #171513; flex-shrink: 0;">
                                <?php echo get_avatar(get_the_author_meta('ID'), 26); ?>
                            </div>
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-primary, #171513);">
                                <?php the_author(); ?>
                            </span>
                            <span style="margin-left: auto; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: #B45309; font-weight: 700;">
                                Essay →
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

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- ==========================================================================
         11. PAN-AFRICAN COMPASS (Category & Topic Explorer Strip)
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
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('culture-history')); ?>" class="compass-topic-chip">#CultureHistory</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('biography')); ?>" class="compass-topic-chip">#Biography</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('entertainment')); ?>" class="compass-topic-chip">#Entertainment</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('sports')); ?>" class="compass-topic-chip">#Sports</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('education')); ?>" class="compass-topic-chip">#Education</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('politics')); ?>" class="compass-topic-chip">#Politics</a>
            <a href="<?php echo esc_url(magazineafrique_get_cat_url('opinion')); ?>" class="compass-topic-chip">#Opinion</a>
        </div>
    </section>

    <!-- ==========================================================================
         12. CIRCULAR NOTICE (The Africa Brief Newsletter)
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
