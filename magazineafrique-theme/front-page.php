<?php
/**
 * Magazine Afrique — Front Page Template
 * High-End Minimalist Editorial Magazine
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial" style="padding-top: 2rem;">

    <!-- Lead Editorial Hero -->
    <section class="hero-editorial-section" style="margin-bottom: 3.5rem;">
        <?php
        $lead_query = new WP_Query(array('posts_per_page' => 1, 'ignore_sticky_posts' => 1));
        if ($lead_query->have_posts()) :
            while ($lead_query->have_posts()) : $lead_query->the_post();
        ?>
        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;" class="lg:grid-cols-12">
            
            <!-- Main Lead Story (Left 7 cols on desktop) -->
            <article style="grid-column: span 7 / span 7; display: flex; flex-direction: column;">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" style="display: block; margin-bottom: 1.25rem; overflow: hidden; border-radius: 0.375rem;">
                        <?php the_post_thumbnail('magazine-hero', array('style' => 'width: 100%; height: auto; aspect-ratio: 16/9; object-fit: cover; display: block;')); ?>
                    </a>
                <?php endif; ?>
                
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.65rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">
                    <?php magazineafrique_category_badge(); ?>
                    <span style="color: #8C847A;">·</span>
                    <span style="color: #8C847A;"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                </div>

                <h1 style="font-family: 'Newsreader', Georgia, serif; font-size: clamp(1.85rem, 3.5vw, 2.5rem); font-weight: 700; line-height: 1.2; color: #171412; margin-bottom: 0.85rem;">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>

                <p style="font-size: 1rem; color: #554F49; line-height: 1.6; margin-bottom: 1rem;">
                    <?php echo wp_trim_words(get_the_excerpt(), 28); ?>
                </p>

                <div style="margin-top: auto; font-size: 0.75rem; color: #8C847A;">
                    By <span style="font-weight: 700; color: #1F1C1A;"><?php the_author(); ?></span> — <?php echo esc_html(get_the_date('F j, Y')); ?>
                </div>
            </article>

            <!-- 2 Secondary Curated Stories (Right 5 cols on desktop) -->
            <div style="grid-column: span 5 / span 5; display: flex; flex-direction: column; gap: 2rem;">
                <?php
                $secondary_query = new WP_Query(array('posts_per_page' => 2, 'offset' => 1));
                if ($secondary_query->have_posts()) :
                    while ($secondary_query->have_posts()) : $secondary_query->the_post();
                ?>
                <article style="display: flex; flex-direction: column; padding-bottom: 1.75rem; border-bottom: 1px solid #EAE3D6;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" style="display: block; margin-bottom: 0.85rem; overflow: hidden; border-radius: 0.25rem;">
                            <?php the_post_thumbnail('magazine-card', array('style' => 'width: 100%; height: 160px; object-fit: cover; display: block;')); ?>
                        </a>
                    <?php endif; ?>
                    
                    <div style="margin-bottom: 0.4rem; font-size: 0.6875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #B45309;">
                        <?php
                        $cats = get_the_category();
                        if (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') {
                            echo esc_html($cats[0]->name);
                        }
                        ?>
                    </div>

                    <h2 style="font-family: 'Newsreader', Georgia, serif; font-size: 1.25rem; font-weight: 600; line-height: 1.3; color: #171412; margin-bottom: 0.5rem;">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <div style="font-size: 0.75rem; color: #8C847A; margin-top: auto;">
                        <?php echo esc_html(get_the_date('M j, Y')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?>
                    </div>
                </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

        </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </section>

    <!-- Hairline Editorial Divider -->
    <div style="height: 1px; background-color: #EAE3D6; margin: 3rem 0;"></div>

    <!-- Editorial Dossiers Section -->
    <section style="margin-bottom: 4rem;">
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 2px solid #0B5128; padding-bottom: 0.65rem; margin-bottom: 2rem;">
            <h3 style="font-family: 'Newsreader', Georgia, serif; font-size: 1.5rem; font-weight: 700; color: #0B5128; margin: 0;">
                Strategic Dossiers & Analysis
            </h3>
            <span style="font-size: 0.6875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #8C847A;">
                Continental Perspectives
            </span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem 2rem;">
            <?php
            $grid_query = new WP_Query(array('posts_per_page' => 6, 'offset' => 3));
            if ($grid_query->have_posts()) :
                while ($grid_query->have_posts()) : $grid_query->the_post();
            ?>
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

                <h4 style="font-family: 'Newsreader', Georgia, serif; font-size: 1.15rem; font-weight: 600; line-height: 1.35; color: #171412; margin-bottom: 0.5rem;">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>

                <p style="font-size: 0.875rem; color: #554F49; line-height: 1.55; margin-bottom: 0.75rem;">
                    <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                </p>

                <div style="margin-top: auto; font-size: 0.75rem; color: #8C847A;">
                    <?php echo esc_html(get_the_date('M j, Y')); ?>
                </div>
            </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- In-Feed Newsletter Invitation -->
    <div style="background-color: #F4EFE6; border: 1px solid #E2D9C8; border-radius: 0.5rem; padding: 2.5rem 2rem; margin: 3rem 0; text-align: center;">
        <span style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #0B5128; display: block; margin-bottom: 0.5rem;">
            The Africa Brief
        </span>
        <h3 style="font-family: 'Newsreader', Georgia, serif; font-size: 1.5rem; font-weight: 700; color: #171412; margin-bottom: 0.5rem;">
            Essential continental intelligence every Thursday morning
        </h3>
        <p style="font-size: 0.875rem; color: #554F49; max-width: 500px; margin: 0 auto 1.5rem; line-height: 1.6;">
            Join over 45,000 leaders and policy analysts who read our weekly curated dossiers.
        </p>
        <form class="magazine-newsletter-form" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem; max-width: 440px; margin: 0 auto;">
            <input type="email" name="email" placeholder="Your work email" required style="flex: 1; min-width: 200px; padding: 0.75rem 1rem; border-radius: 0.25rem; border: 1px solid #D8CDBA; background: #FFFFFF; font-size: 0.8125rem; outline: none;" />
            <button type="submit" style="background-color: #0B5128; color: #FAF7F2; font-weight: 700; padding: 0.75rem 1.25rem; border-radius: 0.25rem; border: none; font-size: 0.8125rem; cursor: pointer;">
                Subscribe Free
            </button>
            <div class="newsletter-feedback" style="width: 100%; text-align: center;"></div>
        </form>
    </div>

</main>

<?php get_footer(); ?>
