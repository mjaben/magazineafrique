<?php
/**
 * Magazine Afrique — Single Article Template
 * Calm, Minimalist, Literary African Journalism
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial">

    <?php
    while (have_posts()) : the_post();
        $is_premium = function_exists('magazineafrique_is_premium_post') && magazineafrique_is_premium_post();
    ?>

    <article class="article-reading-container">
        
        <!-- Breadcrumbs & Meta -->
        <div class="article-meta-top">
            <?php
            $cats = get_the_category();
            if (!empty($cats)) {
                $cat = $cats[0];
                if (strtolower($cat->slug) !== 'uncategorized') {
                    echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="article-category-tag">' . esc_html($cat->name) . '</a>';
                    echo '<span>·</span>';
                }
            }
            ?>
            <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
            <?php if ($is_premium) : ?>
                <span>·</span>
                <span style="color: #B45309; font-weight: 700;">★ Subscriber Exclusive</span>
            <?php endif; ?>
        </div>

        <!-- Article Headline -->
        <h1 class="article-title-main">
            <?php the_title(); ?>
        </h1>

        <!-- Dek / Subtitle -->
        <?php if (has_excerpt()) : ?>
            <p style="font-family: 'Newsreader', Georgia, serif; font-size: 1.25rem; font-style: italic; color: #554F49; line-height: 1.5; margin-bottom: 1.5rem;">
                <?php echo esc_html(get_the_excerpt()); ?>
            </p>
        <?php endif; ?>

        <!-- Author & Date Byline Bar -->
        <div class="article-byline-bar">
            <div>
                <span style="color: #70685E;">By</span>
                <span class="byline-author-text"><?php the_author(); ?></span>
                <span style="margin: 0 0.5rem; color: #C4BCB0;">—</span>
                <span><?php echo esc_html(get_the_date('F j, Y')); ?></span>
            </div>

            <!-- Minimalist Share Links -->
            <div class="article-share-links">
                <span style="font-size: 0.75rem; color: #8C847A;">Share:</span>
                <?php
                $share_url = urlencode(get_permalink());
                $share_title = urlencode(get_the_title());
                ?>
                <a href="https://api.whatsapp.com/send?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" class="share-text-link">WhatsApp</a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="share-text-link">𝕏</a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-text-link">LinkedIn</a>
            </div>
        </div>

        <!-- Featured Media -->
        <?php if (has_post_thumbnail()) : ?>
            <figure class="broadsheet-framed-photo" style="margin-bottom: 2rem;">
                <?php the_post_thumbnail('full', array('class' => 'broadsheet-img-cut')); ?>
                <?php if (get_the_post_thumbnail_caption()) : ?>
                    <figcaption class="broadsheet-photo-caption">
                        <span><?php the_post_thumbnail_caption(); ?></span>
                        <span class="caption-archive-tag">[PHOTO: ARCHIVE]</span>
                    </figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <!-- Long-Form Reading Body -->
        <div class="article-reading-body drop-cap-classic">
            <?php the_content(); ?>
        </div>

        <!-- Tags -->
        <?php
        $tags = get_the_tags();
        if ($tags) :
        ?>
        <div style="margin: 3rem 0 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; font-size: 0.8125rem;">
            <span style="color: #8C847A; font-weight: 600;">Tags:</span>
            <?php
            foreach ($tags as $tag) {
                echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="share-text-link">#' . esc_html($tag->name) . '</a>';
            }
            ?>
        </div>
        <?php endif; ?>

        <!-- Author Bio (Calm & Typographic) -->
        <div style="border-top: 1px solid #EAE3D6; border-bottom: 1px solid #EAE3D6; padding: 2rem 0; margin: 3rem 0; display: flex; gap: 1.5rem; align-items: center;">
            <div style="width: 56px; height: 56px; border-radius: 9999px; overflow: hidden; background: #0B5128; flex-shrink: 0;">
                <?php echo get_avatar(get_the_author_meta('ID'), 56); ?>
            </div>
            <div>
                <h4 style="font-family: 'Newsreader', Georgia, serif; font-size: 1.15rem; font-weight: 700; color: #171412; margin-bottom: 0.25rem;">
                    <?php the_author(); ?>
                </h4>
                <p style="font-size: 0.875rem; color: #615B55; line-height: 1.5; margin: 0;">
                    <?php echo esc_html(get_the_author_meta('description') ?: "Writer and analyst at Magazine Afrique."); ?>
                </p>
            </div>
        </div>

        <!-- Related Stories (Quiet Editorial Grid) -->
        <div style="margin-top: 4rem;">
            <h3 style="font-family: 'Newsreader', Georgia, serif; font-size: 1.35rem; font-weight: 700; color: #0B5128; padding-bottom: 0.75rem; border-bottom: 1px solid #EAE3D6; margin-bottom: 2rem;">
                Related Dossiers
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem;">
                <?php
                $related_query = new WP_Query(array(
                    'category__in'   => wp_get_post_categories(get_the_ID()),
                    'post__not_in'   => array(get_the_ID()),
                    'posts_per_page' => 3
                ));
                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                <article style="display: flex; flex-direction: column;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" style="display: block; margin-bottom: 0.75rem; overflow: hidden; border-radius: 0.25rem;">
                            <?php the_post_thumbnail('magazine-card', array('style' => 'width: 100%; height: 140px; object-fit: cover; display: block;')); ?>
                        </a>
                    <?php endif; ?>
                    <h4 style="font-family: 'Newsreader', Georgia, serif; font-size: 1.05rem; font-weight: 600; line-height: 1.35; color: #171412; margin-bottom: 0.5rem;">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                    <span style="font-size: 0.75rem; color: #8C847A; margin-top: auto;">
                        <?php echo esc_html(get_the_date('M j, Y')); ?>
                    </span>
                </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>

    </article>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
