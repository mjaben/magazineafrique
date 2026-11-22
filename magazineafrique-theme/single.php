<?php
/**
 * Magazine Afrique — Single Article Template
 * Primary Language: English with Pan-African Multilingual Support
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial" style="margin-top: 1.5rem;">

    <?php
    while (have_posts()) : the_post();
        $is_premium = function_exists('magazineafrique_is_premium_post') && magazineafrique_is_premium_post();
    ?>

    <!-- Breadcrumbs -->
    <div style="font-size: 0.75rem; color: #78716C; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span>›</span>
        <?php
        $cats = get_the_category();
        if (!empty($cats)) {
            echo '<a href="' . esc_url(get_category_link($cats[0]->term_id)) . '">' . esc_html($cats[0]->name) . '</a>';
            echo '<span>›</span>';
        }
        ?>
        <span style="color: #1C1917; font-weight: 600;"><?php the_title(); ?></span>
    </div>

    <!-- Article Header -->
    <header class="article-header" style="max-width: 860px; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <?php magazineafrique_category_badge(); ?>
            <?php if ($is_premium) : ?>
                <span class="badge-category badge-premium">★ Subscriber Exclusive</span>
            <?php endif; ?>
            <span style="font-size: 0.8125rem; color: #66615B;">
                <?php echo esc_html(magazineafrique_reading_time()); ?>
            </span>
        </div>

        <h1 class="font-serif" style="font-size: clamp(2rem, 4vw, 2.75rem); font-weight: 800; line-height: 1.2; color: #1C1917; margin-bottom: 1rem;">
            <?php the_title(); ?>
        </h1>

        <?php if (has_excerpt()) : ?>
            <p style="font-size: 1.125rem; color: #57534E; line-height: 1.6; margin-bottom: 1.5rem;">
                <?php echo esc_html(get_the_excerpt()); ?>
            </p>
        <?php endif; ?>

        <!-- Author & Date Byline Bar -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; border-top: 1px solid #E8E2D8; border-bottom: 1px solid #E8E2D8; padding: 0.75rem 0;">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <?php magazineafrique_posted_by(); ?>
                <span style="font-size: 0.75rem; color: #78716C;">
                    Published on <?php echo esc_html(get_the_date('F j, Y \a\t H:i')); ?>
                </span>
            </div>

            <!-- Social Share Buttons -->
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 700;">
                <span style="color: #78716C;">Share:</span>
                <?php
                $share_url = urlencode(get_permalink());
                $share_title = urlencode(get_the_title());
                ?>
                <a href="https://api.whatsapp.com/send?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" style="background: #25D366; color: white; padding: 0.2rem 0.5rem; border-radius: 0.25rem;">WhatsApp</a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" style="background: #000; color: white; padding: 0.2rem 0.5rem; border-radius: 0.25rem;">𝕏</a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener" style="background: #0A66C2; color: white; padding: 0.2rem 0.5rem; border-radius: 0.25rem;">LinkedIn</a>
            </div>
        </div>
    </header>

    <!-- Main Layout Grid -->
    <div class="grid-editorial-sidebar">
        
        <!-- Main Article Reading Well -->
        <article class="article-well" style="max-width: 820px;">
            
            <?php if (has_post_thumbnail()) : ?>
                <figure style="margin-bottom: 2rem;">
                    <?php the_post_thumbnail('magazine-hero', array('style' => 'width: 100%; height: auto; aspect-ratio: 16/9; object-fit: cover; border-radius: 0.5rem;')); ?>
                    <?php if (get_the_post_thumbnail_caption()) : ?>
                        <figcaption style="font-size: 0.75rem; color: #78716C; margin-top: 0.5rem; text-align: right;">
                            <?php the_post_thumbnail_caption(); ?>
                        </figcaption>
                    <?php endif; ?>
                </figure>
            <?php endif; ?>

            <!-- Article Body -->
            <div class="article-body">
                <?php the_content(); ?>
            </div>

            <!-- Tags -->
            <div style="margin: 2.5rem 0 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center;">
                <span style="font-size: 0.75rem; font-weight: 700; color: #78716C; text-transform: uppercase;">Tags:</span>
                <?php
                $tags = get_the_tags();
                if ($tags) {
                    foreach ($tags as $tag) {
                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" style="background: #F3EFEA; border: 1px solid #E8E2D8; font-size: 0.75rem; padding: 0.2rem 0.5rem; border-radius: 0.25rem; color: #1C1917;">#' . esc_html($tag->name) . '</a>';
                    }
                }
                ?>
            </div>

            <!-- Author Bio Box -->
            <div class="card-editorial" style="padding: 1.5rem; margin: 2rem 0; display: flex; gap: 1.25rem; align-items: center; background: #FAF8F5;">
                <div style="width: 60px; height: 60px; border-radius: 9999px; overflow: hidden; shrink-0: 0;">
                    <?php echo get_avatar(get_the_author_meta('ID'), 60); ?>
                </div>
                <div>
                    <h4 class="font-serif" style="font-size: 1.125rem; font-weight: 700; color: #1C1917; margin-bottom: 0.25rem;">
                        About <?php the_author(); ?>
                    </h4>
                    <p style="font-size: 0.8125rem; color: #66615B; line-height: 1.5;">
                        <?php echo esc_html(get_the_author_meta('description') ?: "Journalist and essayist at Magazine Afrique."); ?>
                    </p>
                </div>
            </div>

            <!-- Related Articles Grid -->
            <div style="margin-top: 3rem;">
                <h3 class="font-serif" style="font-size: 1.35rem; font-weight: 700; color: #0B5128; border-bottom: 2px solid #0B5128; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                    Related Investigations
                </h3>
                <div class="grid-editorial-3">
                    <?php
                    $related_query = new WP_Query(array(
                        'category__in'   => wp_get_post_categories(get_the_ID()),
                        'post__not_in'   => array(get_the_ID()),
                        'posts_per_page' => 3
                    ));
                    if ($related_query->have_posts()) :
                        while ($related_query->have_posts()) : $related_query->the_post();
                    ?>
                    <article class="card-editorial" style="display: flex; flex-direction: column;">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('magazine-thumb', array('style' => 'width: 100%; height: 130px; object-fit: cover;')); ?>
                            </a>
                        <?php endif; ?>
                        <div style="padding: 0.75rem; display: flex; flex-direction: column; flex: 1;">
                            <h4 class="font-serif" style="font-size: 0.875rem; font-weight: 700; line-height: 1.3; color: #1C1917; margin-bottom: 0.5rem;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <span style="font-size: 0.6875rem; color: #78716C; margin-top: auto;"><?php magazineafrique_posted_on(); ?></span>
                        </div>
                    </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

        </article>

        <!-- Sidebar -->
        <aside class="sidebar-editorial">
            
            <!-- Sticky Half-Page Google Ad Slot -->
            <?php magazineafrique_render_ad_sidebar(); ?>

            <!-- Newsletter Sidebar Callout -->
            <div class="card-editorial" style="padding: 1.5rem; background: #FAF8F5; border-left: 3px solid #D97706; margin-bottom: 2rem;">
                <h4 class="font-serif" style="font-size: 1rem; font-weight: 700; color: #1C1917; margin-bottom: 0.5rem;">
                    Receive Our Dossiers
                </h4>
                <p style="font-size: 0.75rem; color: #66615B; margin-bottom: 0.75rem;">
                    Key investigative reports and briefings every Thursday in your inbox.
                </p>
                <form class="magazine-newsletter-form" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <input type="email" name="email" placeholder="Your work email" required style="padding: 0.5rem; border-radius: 0.25rem; border: 1px solid #E8E2D8; font-size: 0.75rem;" />
                    <button type="submit" class="btn-newsletter-submit" style="padding: 0.5rem; font-size: 0.75rem;">Subscribe</button>
                    <div class="newsletter-feedback"></div>
                </form>
            </div>

            <!-- Dynamic Sidebar Widgets -->
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <?php dynamic_sidebar('sidebar-1'); ?>
            <?php endif; ?>

        </aside>

    </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
