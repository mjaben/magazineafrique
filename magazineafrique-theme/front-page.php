<?php
/**
 * Magazine Afrique — Front Page Template
 * Vintage Broadsheet Newspaper Style with Editorial Desks & Strategic Monetization
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial broadsheet-main">

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
                    <figure class="broadsheet-framed-photo">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('magazine-hero', array('class' => 'broadsheet-img-cut')); ?>
                        </a>
                        <figcaption class="broadsheet-photo-caption">
                            <span><?php the_title(); ?></span>
                            <span class="caption-archive-tag">[PHOTO: ARCHIVE]</span>
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
                        [ Read Entire Despatch → ]
                    </a>
                </div>

            </article>

            <!-- 2 Secondary Columns (Right 5 cols on desktop) -->
            <aside class="broadsheet-secondary-col">
                
                <div class="broadsheet-section-header">
                    <h3 class="broadsheet-section-title">THE CONTINENTAL TELEGRAPH</h3>
                    <span class="broadsheet-edition-stamp">LATEST INTELLIGENCE</span>
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
                        <div class="vintage-framed-box">
                            <div class="framed-box-header">
                                <span class="framed-box-badge">FRONTIER WIRE</span>
                                <span class="framed-box-date"><?php echo esc_html(get_the_date('j M')); ?></span>
                            </div>
                            <h4 class="framed-box-title vintage-newspaper-headline">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <p class="framed-box-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 22); ?>
                            </p>
                            <div class="framed-box-footer">
                                <?php echo esc_html(magazineafrique_reading_time()); ?> · Dispatches
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- Secondary Ledger Story -->
                        <article class="broadsheet-ledger-item">
                            <div class="ledger-item-kicker">
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

    <!-- 3. Pan-African Editorial Category Desks ("DISPATCHES BY DESK") -->
    <section class="broadsheet-desks-section">
        <div class="broadsheet-section-header">
            <h3 class="broadsheet-section-title">PAN-AFRICAN EDITORIAL DESKS</h3>
            <span class="broadsheet-edition-stamp">INTELLIGENCE BY SECTOR</span>
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

            if (!empty($editorial_desks)) :
                foreach ($editorial_desks as $desk_cat) :
                    $desk_posts = new WP_Query(array(
                        'cat'            => $desk_cat->term_id,
                        'posts_per_page' => 3,
                    ));
                    if ($desk_posts->have_posts()) :
            ?>
                <div class="broadsheet-desk-column">
                    <!-- Desk Header -->
                    <div class="desk-masthead-bar">
                        <div class="desk-badge-wrap">
                            <span class="desk-bullet">❖</span>
                            <h4 class="desk-title"><?php echo esc_html($desk_cat->name); ?></h4>
                        </div>
                        <a href="<?php echo esc_url(get_category_link($desk_cat->term_id)); ?>" class="desk-view-all-link">Desk Index →</a>
                    </div>

                    <?php
                    $p_index = 0;
                    while ($desk_posts->have_posts()) : $desk_posts->the_post();
                        $p_index++;
                        if ($p_index === 1) :
                    ?>
                        <!-- Desk Featured Lead Postcard (Tactile 5px Offset Drop Shadow) -->
                        <article class="vintage-desk-lead-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="desk-card-thumb-link">
                                    <?php the_post_thumbnail('medium_large', array('class' => 'desk-card-img')); ?>
                                </a>
                            <?php endif; ?>
                            <div class="desk-card-body">
                                <div class="desk-card-meta">
                                    <span class="desk-card-date"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                                    <span class="desk-meta-dot">·</span>
                                    <span class="desk-card-time"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
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
                                    <span class="wire-arrow">›</span> <?php the_title(); ?>
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

    <!-- 4. The Continental Dispatches Ledger (6-Card Postcard Grid with Tactile Box UI) -->
    <section class="broadsheet-ledger-section">
        <div class="broadsheet-section-header">
            <h3 class="broadsheet-section-title">THE GAZETTE CHRONICLE</h3>
            <span class="broadsheet-edition-stamp">STRATEGIC DOSSIERS &amp; ESSAYS</span>
        </div>

        <div class="broadsheet-ledger-grid">
            <?php
            $grid_query = new WP_Query(array('posts_per_page' => 6, 'offset' => 3));
            if ($grid_query->have_posts()) :
                while ($grid_query->have_posts()) : $grid_query->the_post();
            ?>
            <article class="vintage-grid-card">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="vintage-card-thumb-link">
                        <?php the_post_thumbnail('magazine-card', array('class' => 'vintage-card-img')); ?>
                    </a>
                <?php endif; ?>

                <div class="vintage-card-kicker">
                    <?php
                    $cats = get_the_category();
                    if (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') {
                        echo esc_html($cats[0]->name);
                    } else {
                        echo 'DISPATCH';
                    }
                    ?>
                </div>

                <h4 class="vintage-card-title vintage-newspaper-headline">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>

                <p class="vintage-card-excerpt">
                    <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                </p>

                <div class="vintage-card-date">
                    <?php echo esc_html(get_the_date('M j, Y')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?>
                </div>
            </article>
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
