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
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem 2rem; margin-bottom: 3.5rem;">
            <?php while (have_posts()) : the_post(); ?>
            <article style="display: flex; flex-direction: column;">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" style="display: block; margin-bottom: 1rem; overflow: hidden; border-radius: 0.25rem;">
                        <?php the_post_thumbnail('magazine-card', array('style' => 'width: 100%; height: 175px; object-fit: cover; display: block;')); ?>
                    </a>
                <?php endif; ?>

                <div style="font-size: 0.6875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #B45309; margin-bottom: 0.35rem;">
                    <?php
                    $cats = get_the_category();
                    if (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') {
                        echo esc_html($cats[0]->name);
                    }
                    ?>
                </div>

                <h2 style="font-family: 'Newsreader', Georgia, serif; font-size: 1.15rem; font-weight: 600; line-height: 1.35; color: #171412; margin-bottom: 0.5rem;">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

                <p style="font-size: 0.875rem; color: #554F49; line-height: 1.55; margin-bottom: 0.75rem;">
                    <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                </p>

                <div style="margin-top: auto; font-size: 0.75rem; color: #8C847A;">
                    <?php echo esc_html(get_the_date('M j, Y')); ?>
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
