<?php
/**
 * Magazine Afrique — Front Page Template
 * Vintage Broadsheet Newspaper Style with Editorial Desks & Strategic Monetization
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial broadsheet-main">

    <!-- Master Broadsheet Dateline & Edition Banner (Quiet, Prestigious Broadsheet Header) -->
    <div class="broadsheet-master-dateline-bar">
        <div class="dateline-bar-left">
            <span class="dateline-vol-badge">VOL. LXXIV · ISSUE 28,409</span>
            <span class="dateline-sep">❖</span>
            <span class="dateline-status-badge"><span class="pulse-amber-dot">●</span> LIVE GAZETTE WIRE</span>
        </div>
        <div class="dateline-bar-center">
            PAN-AFRICAN BROADSHEET OF RECORD · DAKAR · LAGOS · NAIROBI · JOHANNESBURG · CAIRO · LONDON
        </div>
        <div class="dateline-bar-right">
            <span class="dateline-calendar-date"><?php echo esc_html(date_i18n('l, j F Y')); ?></span>
            <span class="dateline-sep">|</span>
            <span class="dateline-price-badge">CONTINENTAL EDITION</span>
        </div>
    </div>

    <!-- 1. Lead Broadsheet Banner Section -->
    <section class="broadsheet-hero-section">
        <?php
        $lead_query = new WP_Query(array('posts_per_page' => 1, 'ignore_sticky_posts' => 1));
        if ($lead_query->have_posts()) :
            while ($lead_query->have_posts()) : $lead_query->the_post();
        ?>
        <div class="broadsheet-hero-grid">
            
            <!-- Main Lead Story (Left 7 cols on desktop) -->
            <article class="broadsheet-lead-story">
                
                <div class="broadsheet-kicker-row">
                    <span class="broadsheet-kicker-lead-pill">
                        ★ LEAD CONTINENTAL INVESTIGATION
                    </span>
                    <span class="broadsheet-kicker-tag">
                        <?php
                        $cats = get_the_category();
                        if (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') {
                            echo esc_html($cats[0]->name);
                        } else {
                            echo 'SPECIAL DESPATCH';
                        }
                        ?>
                    </span>
                    <span class="kicker-sep">|</span>
                    <span class="kicker-meta">RECORD #<?php the_ID(); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?></span>
                </div>

                <h1 class="broadsheet-lead-title vintage-newspaper-headline">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>

                <?php
                $lead_deck = get_the_excerpt();
                if (empty($lead_deck) || trim($lead_deck) === '') {
                    $lead_deck = wp_trim_words(strip_shortcodes(get_the_content()), 24, '...');
                }
                if (!empty($lead_deck)) :
                ?>
                    <div class="broadsheet-deck-subhead">
                        <?php echo esc_html($lead_deck); ?>
                    </div>
                <?php endif; ?>

                <?php if (has_post_thumbnail()) : ?>
                    <figure class="broadsheet-lead-hero-figure">
                        <a href="<?php the_permalink(); ?>" class="hero-clean-thumb-wrap">
                            <?php the_post_thumbnail('magazine-hero', array('class' => 'hero-clean-img')); ?>
                        </a>
                        <figcaption class="broadsheet-photo-caption">
                            <span><?php the_title(); ?></span>
                            <span class="caption-archive-tag">[PHOTO: GAZETTE ARCHIVE / CORRESPONDENT]</span>
                        </figcaption>
                    </figure>
                <?php endif; ?>

                <div class="broadsheet-lead-excerpt drop-cap-classic">
                    <?php echo wp_trim_words(get_the_content(), 45); ?>
                </div>

                <div class="broadsheet-lead-footer">
                    <span class="broadsheet-byline-text">
                        From Our Special Correspondent in <?php the_author(); ?> — <?php echo esc_html(get_the_date('M j, Y')); ?>
                    </span>
                    <a href="<?php the_permalink(); ?>" class="broadsheet-read-link">
                        [ Read Complete Despatch → ]
                    </a>
                </div>

            </article>

            <!-- 2 Secondary Columns (Right 5 cols on desktop) -->
            <aside class="broadsheet-secondary-col">
                
                <div class="broadsheet-section-header">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="pulse-amber-dot">●</span>
                        <h3 class="broadsheet-section-title" style="margin: 0;">THE CONTINENTAL TELEGRAPH</h3>
                    </div>
                    <span class="broadsheet-edition-stamp">INTELLIGENCE WIRE</span>
                </div>

                <?php
                $secondary_query = new WP_Query(array('posts_per_page' => 2, 'offset' => 1));
                $sec_count = 0;
                if ($secondary_query->have_posts()) :
                    while ($secondary_query->have_posts()) : $secondary_query->the_post();
                        $sec_count++;
                ?>
                    <?php if ($sec_count === 1) : ?>
                        <!-- Framed Newspaper Box ("Story in a Frame" with Tactile Box UI) -->
                        <div class="vintage-framed-box" style="border-top: 3px solid #D97706; margin-bottom: 1.25rem;">
                            <div class="framed-box-header">
                                <span class="framed-box-badge">FRONTIER WIRE</span>
                                <span class="framed-box-date"><?php echo esc_html(get_the_date('j M')); ?></span>
                            </div>
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="telegraph-thumb-wrap" style="display: block; margin: 0.5rem 0; overflow: hidden; border-radius: 2px;">
                                    <?php the_post_thumbnail('medium_large', array('class' => 'telegraph-clean-img', 'style' => 'width: 100%; height: 140px; object-fit: cover; display: block; border: none; padding: 0; box-shadow: none;')); ?>
                                </a>
                            <?php endif; ?>
                            <h4 class="framed-box-title vintage-newspaper-headline" style="margin: 0.5rem 0 0.35rem;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <p class="framed-box-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                            </p>
                            <div class="framed-box-footer" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed var(--border-color, #4A433B); padding-top: 0.5rem; margin-top: 0.5rem;">
                                <span><?php echo esc_html(magazineafrique_reading_time()); ?> · Dispatches</span>
                                <a href="<?php the_permalink(); ?>" style="color: #B45309; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700;">Read Wire →</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- Secondary Ledger Story -->
                        <article class="broadsheet-ledger-item" style="border-bottom: 1px dashed var(--border-color, #4A433B); padding-bottom: 1rem; margin-bottom: 1rem;">
                            <div class="ledger-item-kicker" style="color: #B45309;">
                                <?php
                                $c = get_the_category();
                                if (!empty($c) && strtolower($c[0]->slug) !== 'uncategorized') {
                                    echo esc_html($c[0]->name);
                                }
                                ?>
                            </div>
                            <h4 class="ledger-item-title vintage-newspaper-headline">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <p class="ledger-item-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                            </p>
                            <div class="ledger-item-meta">
                                <?php echo esc_html(get_the_date('M j, Y')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

                <!-- Sovereign Market Radar Pill -->
                <div class="continental-market-radar-pill">
                    <div class="radar-header">
                        <span class="radar-title">CONTINENTAL MACRO RADAR</span>
                        <span class="radar-glyph">❖</span>
                    </div>
                    <div class="radar-items-grid">
                        <div class="radar-item">
                            <span class="radar-label">AfCFTA FLOWS</span>
                            <span class="radar-val" style="color: #D97706;">+18.4%</span>
                        </div>
                        <div class="radar-item">
                            <span class="radar-label">SOVEREIGN RESERVES</span>
                            <span class="radar-val" style="color: #B45309;">$412B</span>
                        </div>
                        <div class="radar-item">
                            <span class="radar-label">ENERGY TRANSITION</span>
                            <span class="radar-val" style="color: #D97706;">$24.2B</span>
                        </div>
                    </div>
                </div>

            </aside>

        </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </section>

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- 2. Strategic Mid-Home Commercial Leaderboard -->
    <?php
    if (function_exists('magazineafrique_render_ad_mid_home')) {
        magazineafrique_render_ad_mid_home();
    }
    ?>

    <!-- 3. Pan-African Editorial Category Desks (Unique Vintage Archival Color Wing) -->
    <section class="broadsheet-desks-section vintage-archive-desks-wing">
        <div class="archive-wing-header">
            <div class="archive-wing-eyebrow">
                <span class="wing-glyph">❖</span>
                <span>VINTAGE ARCHIVE DESKS · CONTINENTAL DOSSIER FILES</span>
                <span class="wing-glyph">❖</span>
            </div>
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 0.5rem;">
                <h3 class="font-serif vintage-newspaper-headline" style="font-size: 1.65rem; font-weight: 900; margin: 0; color: var(--text-primary, #171513);">
                    Pan-African Editorial Desks
                </h3>
                <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: #B45309; letter-spacing: 0.08em;">
                    SECTOR INTELLIGENCE
                </span>
            </div>
        </div>

        <div class="broadsheet-desks-grid">
            <?php
            // Query top 3 non-empty categories
            $editorial_desks = get_categories(array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => 3,
                'exclude'    => array(1),
                'hide_empty' => true
            ));

            // Distinct warm brand color themes per desk (strictly NO green!)
            $desk_colors = array('#B45309', '#D97706', '#8B2500');
            $desk_badges = array('GEOPOLITICAL INTELLIGENCE', 'MACRO MARKETS & AfCFTA', 'SOVEREIGN STRATEGY');

            if (!empty($editorial_desks)) :
                $desk_idx = 0;
                foreach ($editorial_desks as $desk_cat) :
                    $current_color = $desk_colors[$desk_idx % count($desk_colors)];
                    $current_badge = $desk_badges[$desk_idx % count($desk_badges)];
                    $desk_idx++;

                    $desk_posts = new WP_Query(array(
                        'cat'            => $desk_cat->term_id,
                        'posts_per_page' => 3,
                    ));
                    if ($desk_posts->have_posts()) :
            ?>
                <div class="broadsheet-desk-column vintage-desk-themed-col" style="border-top: 3px solid <?php echo esc_attr($current_color); ?>;">
                    <!-- Desk Header -->
                    <div class="desk-masthead-bar">
                        <div class="desk-badge-wrap">
                            <span class="desk-bullet" style="color: <?php echo esc_attr($current_color); ?>;">❖</span>
                            <h4 class="desk-title"><?php echo esc_html($desk_cat->name); ?></h4>
                        </div>
                        <a href="<?php echo esc_url(get_category_link($desk_cat->term_id)); ?>" class="desk-view-all-link" style="color: <?php echo esc_attr($current_color); ?>;">Desk Index →</a>
                    </div>

                    <?php
                    $p_index = 0;
                    while ($desk_posts->have_posts()) : $desk_posts->the_post();
                        $p_index++;
                        if ($p_index === 1) :
                    ?>
                        <!-- Desk Featured Lead Postcard (Clean Image, No Image Frame, Tactile Drop Shadow) -->
                        <article class="vintage-desk-lead-card" style="border-top: 2px solid <?php echo esc_attr($current_color); ?>;">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="desk-card-thumb-clean">
                                    <?php the_post_thumbnail('medium_large', array('class' => 'desk-clean-img')); ?>
                                </a>
                            <?php endif; ?>
                            <div class="desk-card-body">
                                <div class="desk-card-meta">
                                    <span class="desk-badge-pill" style="background: rgba(180, 83, 9, 0.12); color: <?php echo esc_attr($current_color); ?>; font-weight: 700;">
                                        <?php echo esc_html($current_badge); ?>
                                    </span>
                                    <span class="desk-meta-dot">·</span>
                                    <span class="desk-card-date"><?php echo esc_html(get_the_date('M j')); ?></span>
                                </div>
                                <h5 class="desk-card-title vintage-newspaper-headline">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h5>
                                <p class="desk-card-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                                </p>
                            </div>
                        </article>
                    <?php else : ?>
                        <!-- Desk Secondary Wire Bullet -->
                        <div class="desk-wire-bullet-item">
                            <h6 class="desk-wire-bullet-title vintage-newspaper-headline">
                                <a href="<?php the_permalink(); ?>">
                                    <span class="wire-arrow" style="color: <?php echo esc_attr($current_color); ?>;">›</span> <?php the_title(); ?>
                                </a>
                            </h6>
                            <div class="desk-wire-bullet-meta">
                                <span><?php echo esc_html(get_the_date('j M')); ?></span> · 
                                <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                            </div>
                        </div>
                    <?php
                        endif;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php
                    endif;
                endforeach;
            endif;
            ?>
        </div>
    </section>

    <!-- Broadsheet Double Rule Divider -->
    <div class="broadsheet-double-rule"></div>

    <!-- 4. The Gazette Chronicle (Asymmetric Dynamic Masonry & Color-Graded Card UI) -->
    <section class="broadsheet-ledger-section">
        <div class="broadsheet-section-header">
            <h3 class="broadsheet-section-title">THE GAZETTE CHRONICLE</h3>
            <span class="broadsheet-edition-stamp">STRATEGIC DOSSIERS &amp; ESSAYS</span>
        </div>

        <div class="gazette-chronicle-masonry-grid">
            <?php
            $grid_query = new WP_Query(array('posts_per_page' => 6, 'offset' => 3));
            $chronicle_idx = 0;
            if ($grid_query->have_posts()) :
                while ($grid_query->have_posts()) : $grid_query->the_post();
                    $chronicle_idx++;
                    $cats = get_the_category();
                    $cat_name = (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') ? $cats[0]->name : 'DISPATCH';
            ?>
                <?php if ($chronicle_idx === 1) : ?>
                    <!-- CARD 1: Lead Investigative Feature (Spans 2 columns, Hero Postcard) -->
                    <article class="vintage-grid-card chronicle-lead-feature-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="chronicle-thumb-clean">
                                <?php the_post_thumbnail('large', array('class' => 'chronicle-clean-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="chronicle-card-content">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span class="chronicle-lead-badge">★ LEAD INVESTIGATIVE DOSSIER</span>
                                <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: #B45309; font-weight: 700;">#<?php the_ID(); ?></span>
                            </div>
                            <h4 class="font-serif vintage-newspaper-headline" style="font-size: 1.55rem; font-weight: 900; line-height: 1.25; margin: 0 0 0.65rem;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <p class="drop-cap-classic font-serif" style="font-size: 1.05rem; line-height: 1.6; color: var(--text-secondary, #575149); margin: 0 0 1rem;">
                                <?php echo wp_trim_words(get_the_excerpt(), 28); ?>
                            </p>
                            <div class="vintage-card-date" style="display: flex; justify-content: space-between; border-top: 1px solid var(--border-color, #231F1D); padding-top: 0.65rem;">
                                <span><?php echo esc_html(get_the_date('j F Y')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?></span>
                                <a href="<?php the_permalink(); ?>" style="color: #B45309; font-weight: 800; font-family: 'Geist Mono', monospace; font-size: 0.6875rem;">Full Dossier →</a>
                            </div>
                        </div>
                    </article>

                <?php elseif ($chronicle_idx === 2) : ?>
                    <!-- CARD 2: The Obsidian Dark Contrast Postcard (High Visual Impact) -->
                    <article class="vintage-grid-card chronicle-obsidian-card">
                        <div class="vintage-card-kicker" style="color: #FBBF24;">
                            ❖ SAVANNAH WIRE · <?php echo esc_html(strtoupper($cat_name)); ?>
                        </div>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="chronicle-thumb-clean" style="margin: 0.5rem 0;">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'chronicle-clean-img')); ?>
                            </a>
                        <?php endif; ?>
                        <h4 class="vintage-card-title vintage-newspaper-headline" style="color: #FAF7F2; margin: 0.4rem 0;">
                            <a href="<?php the_permalink(); ?>" style="color: inherit;"><?php the_title(); ?></a>
                        </h4>
                        <p class="vintage-card-excerpt" style="color: #D6CEC3;">
                            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                        </p>
                        <div class="vintage-card-date" style="color: #A39A8E; border-top-color: rgba(255,255,255,0.15);">
                            <span><?php echo esc_html(get_the_date('M j')); ?></span> · 
                            <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                        </div>
                    </article>

                <?php elseif ($chronicle_idx === 3) : ?>
                    <!-- CARD 3: Parchment Dossier Card with Amber Top Rule -->
                    <article class="vintage-grid-card chronicle-parchment-card" style="border-top: 3px solid #D97706;">
                        <div class="vintage-card-kicker" style="color: #B45309;">
                            SPECIAL DISPATCH · <?php echo esc_html(strtoupper($cat_name)); ?>
                        </div>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="chronicle-thumb-clean">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'chronicle-clean-img')); ?>
                            </a>
                        <?php endif; ?>
                        <h4 class="vintage-card-title vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <p class="vintage-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                        </p>
                        <div class="vintage-card-date">
                            <span><?php echo esc_html(get_the_date('M j, Y')); ?></span> · 
                            <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                        </div>
                    </article>

                <?php else : ?>
                    <!-- CARDS 4, 5, 6: Tactile Broadsheet Postcards -->
                    <article class="vintage-grid-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="chronicle-thumb-clean">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'chronicle-clean-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="vintage-card-kicker">
                            <?php echo esc_html(strtoupper($cat_name)); ?>
                        </div>
                        <h4 class="vintage-card-title vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <p class="vintage-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 16); ?>
                        </p>
                        <div class="vintage-card-date">
                            <span><?php echo esc_html(get_the_date('M j, Y')); ?></span> · 
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
    </section>

    <!-- 5. Broadsheet Dispatch Compass (Category & Topic Explorer Strip) -->
    <section class="vintage-dispatch-compass-strip">
        <div class="compass-label-wrap">
            <span class="compass-glyph">❖</span>
            <span class="compass-title">PAN-AFRICAN COMPASS:</span>
        </div>
        <div class="compass-tags-row">
            <?php
            $all_topics = get_categories(array('number' => 8, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => array(1)));
            foreach ($all_topics as $topic) :
            ?>
                <a href="<?php echo esc_url(get_category_link($topic->term_id)); ?>" class="compass-topic-chip">
                    #<?php echo esc_html($topic->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 6. Vintage Circular Notice (The Africa Brief) -->
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
