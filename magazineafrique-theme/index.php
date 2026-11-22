<?php
/**
 * Magazine Afrique — Main Fallback Template
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial" style="margin-top: 1.5rem;">
    <div class="grid-editorial-sidebar">
        <div>
            <?php if (have_posts()) : ?>
                <div class="grid-editorial-3" style="gap: 1.5rem; margin-bottom: 3rem;">
                    <?php while (have_posts()) : the_post(); ?>
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
                                <div style="margin-top: auto; font-size: 0.6875rem; color: #78716C; border-top: 1px solid #E8E2D8; padding-top: 0.5rem;">
                                    <?php magazineafrique_posted_on(); ?>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php the_posts_pagination(); ?>
            <?php else : ?>
                <p>Aucun article trouvé.</p>
            <?php endif; ?>
        </div>

        <aside class="sidebar-editorial">
            <?php magazineafrique_render_ad_sidebar(); ?>
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <?php dynamic_sidebar('sidebar-1'); ?>
            <?php endif; ?>
        </aside>
    </div>
</main>

<?php get_footer(); ?>
