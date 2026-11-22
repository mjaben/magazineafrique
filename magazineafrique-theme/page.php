<?php
/**
 * Magazine Afrique — Standard Page Template
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial" style="margin-top: 2rem; max-width: 860px;">

    <?php while (have_posts()) : the_post(); ?>
        <article class="card-editorial" style="padding: 2.5rem 2rem; margin-bottom: 3rem;">
            <header class="page-header" style="border-bottom: 2px solid #0B5128; padding-bottom: 1rem; margin-bottom: 2rem;">
                <h1 class="font-serif" style="font-size: 2.25rem; font-weight: 800; color: #1C1917;">
                    <?php the_title(); ?>
                </h1>
            </header>

            <div class="article-body">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
