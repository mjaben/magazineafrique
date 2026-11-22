<?php
/**
 * Magazine Afrique — Front Page Template
 * Vintage Broadsheet Newspaper Style
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

                <h1 class="broadsheet-lead-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>

                <?php if (has_excerpt()) : ?>
                    <div class="broadsheet-deck-subhead">
                        <?php echo esc_html(get_the_excerpt()); ?>
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
                        <!-- Framed Newspaper Box ("Story in a Frame") -->
                        <div class="vintage-framed-box">
                            <div class="framed-box-header">
                                <span class="framed-box-badge">FRONTIER WIRE</span>
                                <span class="framed-box-date"><?php echo esc_html(get_the_date('j M')); ?></span>
                            </div>
                            <h4 class="framed-box-title">
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
                            <h4 class="ledger-item-title">
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

    <!-- 2. The Continental Dispatches Ledger (6-Card Grid) -->
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
                    }
                    ?>
                </div>

                <h4 class="vintage-card-title">
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

    <!-- 3. Vintage Circular Notice (The Africa Brief) -->
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
