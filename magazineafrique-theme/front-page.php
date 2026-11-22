<?php
/**
 * Magazine Afrique — Front Page (Editorial Homepage) Template
 * Primary Language: English with Pan-African Multilingual Support
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial" style="margin-top: 1.5rem;">

    <!-- Breaking News Ticker -->
    <div style="background: #FFFFFF; border: 1px solid #E8E2D8; border-radius: 0.375rem; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; overflow: hidden;">
        <span style="background: #C2410C; color: #FFFFFF; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; padding: 0.2rem 0.5rem; border-radius: 0.25rem; shrink-0: 0;">
            Breaking
        </span>
        <div style="overflow-x: auto; white-space: nowrap; font-size: 0.8125rem; color: #1C1917; display: flex; gap: 2rem;">
            <?php
            $ticker_posts = get_posts(array('numberposts' => 4, 'post_status' => 'publish'));
            foreach ($ticker_posts as $post) :
            ?>
                <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" style="display: inline-block;">
                    <span style="color: #66615B; font-size: 0.75rem; margin-right: 0.35rem;"><?php echo get_the_time('H:i', $post->ID); ?></span>
                    <?php echo esc_html(get_the_title($post->ID)); ?>
                </a>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </div>

    <!-- Hero Editorial Grid -->
    <section class="hero-editorial" style="margin-bottom: 3rem;">
        <?php
        $lead_query = new WP_Query(array('posts_per_page' => 1, 'ignore_sticky_posts' => 1));
        if ($lead_query->have_posts()) :
            while ($lead_query->have_posts()) : $lead_query->the_post();
        ?>
        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
            <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;" class="lg:grid-cols-12">
                
                <!-- Lead Story (Left Column) -->
                <article class="card-editorial" style="grid-column: span 8 / span 8;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" style="display: block; overflow: hidden;">
                            <?php the_post_thumbnail('magazine-hero', array('style' => 'width: 100%; height: auto; aspect-ratio: 16/9; object-fit: cover; transition: transform 0.3s;')); ?>
                        </a>
                    <?php endif; ?>
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                            <?php magazineafrique_category_badge(); ?>
                            <span style="font-size: 0.75rem; color: #66615B;"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                        </div>
                        <h1 class="font-serif" style="font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 700; line-height: 1.2; margin-bottom: 0.75rem; color: #1C1917;">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h1>
                        <p style="font-size: 0.9375rem; color: #66615B; line-height: 1.6; margin-bottom: 1rem;">
                            <?php echo wp_trim_words(get_the_excerpt(), 28); ?>
                        </p>
                        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #E8E2D8; padding-top: 0.75rem;">
                            <?php magazineafrique_posted_by(); ?>
                            <span style="font-size: 0.75rem; color: #78716C;"><?php magazineafrique_posted_on(); ?></span>
                        </div>
                    </div>
                </article>

                <!-- 2 Secondary Stories (Right Column) -->
                <div style="grid-column: span 4 / span 4; display: flex; flex-direction: column; gap: 1.5rem;">
                    <?php
                    $secondary_query = new WP_Query(array('posts_per_page' => 2, 'offset' => 1));
                    if ($secondary_query->have_posts()) :
                        while ($secondary_query->have_posts()) : $secondary_query->the_post();
                    ?>
                    <article class="card-editorial" style="display: flex; flex-direction: column; height: 100%;">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" style="display: block; overflow: hidden;">
                                <?php the_post_thumbnail('magazine-card', array('style' => 'width: 100%; height: 160px; object-fit: cover;')); ?>
                            </a>
                        <?php endif; ?>
                        <div style="padding: 1.25rem; display: flex; flex-direction: column; flex: 1;">
                            <div style="margin-bottom: 0.5rem;">
                                <?php magazineafrique_category_badge(); ?>
                            </div>
                            <h2 class="font-serif" style="font-size: 1.125rem; font-weight: 700; line-height: 1.3; margin-bottom: 0.5rem; color: #1C1917;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div style="margin-top: auto; font-size: 0.75rem; color: #78716C; border-top: 1px solid #E8E2D8; padding-top: 0.5rem;">
                                <?php magazineafrique_posted_on(); ?>
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
        </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </section>

    <!-- African Section Divider -->
    <div class="divider-africa">
        <span class="divider-africa-icon">❖</span>
    </div>

    <!-- Main Content & Sidebar Layout -->
    <div class="grid-editorial-sidebar">
        
        <!-- Left: Major Latest Stories Grid -->
        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #0B5128; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                <h3 class="font-serif" style="font-size: 1.5rem; font-weight: 800; color: #0B5128;">
                    Strategic Dossiers & Analysis
                </h3>
                <span style="font-size: 0.75rem; font-weight: 700; color: #66615B; text-transform: uppercase;">
                    Featured Investigations
                </span>
            </div>

            <div class="grid-editorial-3" style="margin-bottom: 2.5rem;">
                <?php
                $grid_query = new WP_Query(array('posts_per_page' => 6, 'offset' => 3));
                if ($grid_query->have_posts()) :
                    while ($grid_query->have_posts()) : $grid_query->the_post();
                ?>
                <article class="card-editorial" style="display: flex; flex-direction: column;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('magazine-card', array('style' => 'width: 100%; height: 150px; object-fit: cover;')); ?>
                        </a>
                    <?php endif; ?>
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex: 1;">
                        <div style="margin-bottom: 0.35rem;">
                            <?php magazineafrique_category_badge(); ?>
                        </div>
                        <h4 class="font-serif" style="font-size: 1rem; font-weight: 700; line-height: 1.3; color: #1C1917; margin-bottom: 0.5rem;">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <div style="margin-top: auto; font-size: 0.6875rem; color: #78716C;">
                            <?php echo esc_html(magazineafrique_reading_time()); ?> · <?php magazineafrique_posted_on(); ?>
                        </div>
                    </div>
                </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <!-- In-Feed Full-Width Newsletter Block -->
            <?php echo magazineafrique_render_newsletter_card(); ?>

        </div>

        <!-- Right: Editorial Sidebar -->
        <aside class="sidebar-editorial">
            
            <!-- Trending / Most Read -->
            <div class="card-editorial" style="padding: 1.5rem; margin-bottom: 2rem;">
                <h4 class="font-serif" style="font-size: 1.125rem; font-weight: 800; color: #0B5128; border-bottom: 2px solid #E8E2D8; padding-bottom: 0.5rem; margin-bottom: 1rem;">
                    ★ Most Read This Week
                </h4>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php
                    $trending = get_posts(array('numberposts' => 4, 'orderby' => 'comment_count'));
                    $counter = 1;
                    foreach ($trending as $post) :
                    ?>
                    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <span style="font-family: 'Newsreader', Georgia, serif; font-size: 1.5rem; font-weight: 800; color: #D97706; line-height: 1;">
                            0<?php echo $counter++; ?>
                        </span>
                        <div>
                            <h5 style="font-size: 0.875rem; font-weight: 700; line-height: 1.3; color: #1C1917;">
                                <a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php echo esc_html(get_the_title($post->ID)); ?></a>
                            </h5>
                            <span style="font-size: 0.6875rem; color: #78716C;"><?php echo get_the_date('M j, Y', $post->ID); ?></span>
                        </div>
                    </div>
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            </div>

            <!-- Half-Page Google Ad Slot (300x250 or 300x600 Zero-CLS) -->
            <?php magazineafrique_render_ad_sidebar(); ?>

            <!-- Dynamic WP Widgets -->
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <?php dynamic_sidebar('sidebar-1'); ?>
            <?php endif; ?>

        </aside>

    </div>

</main>

<?php get_footer(); ?>
