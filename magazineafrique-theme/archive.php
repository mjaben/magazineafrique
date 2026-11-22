<?php
/**
 * Magazine Afrique — Archive Template
 * Calm, Minimalist Editorial Section Archive
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial" style="padding-top: 2rem;">

    <header class="archive-header" style="border-bottom: 2px solid #0B5128; padding-bottom: 1rem; margin-bottom: 2.5rem;">
        <span style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #B45309; letter-spacing: 0.1em;">
            Section
        </span>
        <h1 style="font-family: 'Newsreader', Georgia, serif; font-size: 2.25rem; font-weight: 700; color: #171412; margin-top: 0.25rem;">
            <?php the_archive_title(); ?>
        </h1>
        <?php if (get_the_archive_description()) : ?>
            <div style="font-size: 0.9375rem; color: #554F49; margin-top: 0.5rem; max-width: 680px; line-height: 1.6;">
                <?php the_archive_description(); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php if (have_posts()) : ?>
        <div class="editorial-masonry-grid">
            <?php while (have_posts()) : the_post(); 
                $p_id = get_the_ID();
                $is_bookmarked = function_exists('magazineafrique_is_bookmarked') ? magazineafrique_is_bookmarked($p_id, 'post') : false;
                $is_liked = function_exists('magazineafrique_has_liked') ? magazineafrique_has_liked($p_id) : false;
                $likes = function_exists('magazineafrique_get_likes_count') ? magazineafrique_get_likes_count($p_id) : 0;
            ?>
            <article class="editorial-masonry-card">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="vintage-double-frame" style="display: block; margin-bottom: 0.85rem; overflow: hidden; border-radius: 2px;">
                        <?php the_post_thumbnail('magazine-card', array('style' => 'width: 100%; height: auto; max-height: 220px; object-fit: cover; display: block;')); ?>
                    </a>
                <?php endif; ?>

                <div style="font-size: 0.6875rem; font-weight: 800; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em; color: #8B2500; margin-bottom: 0.35rem;">
                    <?php
                    $cats = get_the_category();
                    if (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') {
                        echo esc_html($cats[0]->name);
                    }
                    ?>
                </div>

                <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 800; line-height: 1.35; color: var(--text-primary, #171412); margin: 0 0 0.5rem;">
                    <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
                </h2>

                <p style="font-size: 0.875rem; color: var(--text-secondary, #554F49); line-height: 1.55; margin: 0 0 0.85rem;">
                    <?php echo wp_trim_words(get_the_excerpt(), 22); ?>
                </p>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.5rem; border-top: 1px dashed var(--border-color, #4A433B); font-size: 0.75rem;">
                    <span style="color: var(--text-muted, #8C847A); font-family: 'JetBrains Mono', monospace; font-size: 0.6875rem;">
                        <?php echo esc_html(get_the_date('M j, Y')); ?>
                    </span>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <button type="button" class="btn-live-like <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" style="background: none; border: none; cursor: pointer; color: var(--text-secondary); font-size: 0.75rem; display: flex; align-items: center; gap: 0.25rem;">
                            <span>❤️</span> <span><?php echo esc_html($likes); ?></span>
                        </button>
                        <button type="button" class="btn-bookmark-action <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-id="<?php echo esc_attr($p_id); ?>" data-type="post" style="background: none; border: none; cursor: pointer; color: var(--text-secondary); font-size: 0.75rem;">
                            <span>🔖</span>
                        </button>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <!-- Numbered Pagination -->
        <div style="margin: 3rem 0; display: flex; justify-content: center;">
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('« Previous', 'magazineafrique'),
                'next_text' => __('Next »', 'magazineafrique'),
            ));
            ?>
        </div>

    <?php else : ?>
        <p style="font-size: 1rem; color: #615B55;">No articles published in this section yet.</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
