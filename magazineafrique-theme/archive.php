<?php
/**
 * Magazine Afrique — Archive Template (Categories, Tags, Authors, Dates)
 * Primary Language: English with Pan-African Multilingual Support
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial" style="margin-top: 1.5rem;">

    <header class="archive-header" style="border-bottom: 2px solid #0B5128; padding-bottom: 1rem; margin-bottom: 2rem;">
        <span style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #D97706; letter-spacing: 0.05em;">
            Section
        </span>
        <h1 class="font-serif" style="font-size: 2.25rem; font-weight: 800; color: #1C1917; margin-top: 0.25rem;">
            <?php the_archive_title(); ?>
        </h1>
        <?php if (get_the_archive_description()) : ?>
            <div style="font-size: 0.9375rem; color: #66615B; margin-top: 0.5rem; max-width: 700px;">
                <?php the_archive_description(); ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="grid-editorial-sidebar">
        
        <!-- Articles Grid -->
        <div>
            <?php if (have_posts()) : ?>
                <div class="grid-editorial-3" style="gap: 2rem 1.5rem; margin-bottom: 3rem;">
                    <?php
                    while (have_posts()) : the_post();
                    ?>
                    <article class="card-editorial" style="display: flex; flex-direction: column;">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('magazine-card', array('style' => 'width: 100%; height: 160px; object-fit: cover;')); ?>
                            </a>
                        <?php endif; ?>
                        <div style="padding: 1.25rem; display: flex; flex-direction: column; flex: 1;">
                            <div style="margin-bottom: 0.5rem;">
                                <?php magazineafrique_category_badge(); ?>
                            </div>
                            <h2 class="font-serif" style="font-size: 1.125rem; font-weight: 700; line-height: 1.3; color: #1C1917; margin-bottom: 0.5rem;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p style="font-size: 0.8125rem; color: #66615B; line-height: 1.5; margin-bottom: 1rem;">
                                <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                            </p>
                            <div style="margin-top: auto; font-size: 0.6875rem; color: #78716C; border-top: 1px solid #E8E2D8; padding-top: 0.5rem;">
                                <?php magazineafrique_posted_on(); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?>
                            </div>
                        </div>
                    </article>
                    <?php endwhile; ?>
                </div>

                <!-- Numbered Pagination -->
                <div style="margin: 2rem 0; display: flex; justify-content: center;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('« Previous', 'magazineafrique'),
                        'next_text' => __('Next »', 'magazineafrique'),
                    ));
                    ?>
                </div>

            <?php else : ?>
                <p style="font-size: 1rem; color: #66615B;">No articles found in this section yet.</p>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar-editorial">
            <?php magazineafrique_render_ad_sidebar(); ?>

            <div class="card-editorial" style="padding: 1.5rem; background: #FAF8F5; margin-bottom: 2rem;">
                <h4 class="font-serif" style="font-size: 1rem; font-weight: 700; color: #0B5128; margin-bottom: 0.5rem;">
                    Subscribe to Magazine Afrique
                </h4>
                <p style="font-size: 0.75rem; color: #66615B; margin-bottom: 1rem;">
                    Support fearless, independent pan-African journalism.
                </p>
                <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="btn-paywall-cta" style="display: block; text-align: center; font-size: 0.75rem;">
                    View Membership Plans
                </a>
            </div>

            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <?php dynamic_sidebar('sidebar-1'); ?>
            <?php endif; ?>
        </aside>

    </div>

</main>

<?php get_footer(); ?>
