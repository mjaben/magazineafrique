<?php
/**
 * Magazine Afrique — Archive Template
 * Tactile Broadsheet Section Archive with Tactile Grid Cards & High Contrast Typography
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="padding-top: 2rem; padding-bottom: 4rem;">

    <header class="archive-header" style="border-bottom: 3px double var(--border-color, #231F1D); padding-bottom: 1.5rem; margin-bottom: 2.5rem;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; letter-spacing: 0.12em; color: #B45309; text-transform: uppercase; margin-bottom: 0.5rem;">
            <span>❖</span>
            <span>EDITORIAL DESK &amp; ARCHIVE DOSSIER</span>
            <span>❖</span>
        </div>
        <h1 class="font-serif vintage-newspaper-headline" style="font-size: clamp(2rem, 4vw, 2.75rem); font-weight: 900; color: var(--text-primary, #171513); margin: 0 0 0.5rem;">
            <?php the_archive_title(); ?>
        </h1>
        <?php if (get_the_archive_description()) : ?>
            <div style="font-family: 'Newsreader', Georgia, serif; font-size: 1.05rem; font-style: italic; color: var(--text-secondary, #575149); max-width: 720px; line-height: 1.55;">
                <?php the_archive_description(); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php if (have_posts()) : ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.75rem;">
            <?php while (have_posts()) : the_post(); 
                $p_id = get_the_ID();
                $is_bookmarked = function_exists('magazineafrique_is_bookmarked') ? magazineafrique_is_bookmarked($p_id, 'post') : false;
                $is_liked = function_exists('magazineafrique_has_liked') ? magazineafrique_has_liked($p_id) : false;
                $likes = function_exists('magazineafrique_get_likes_count') ? magazineafrique_get_likes_count($p_id) : 0;
            ?>
            <article class="vintage-grid-card" style="padding: 1.25rem; display: flex; flex-direction: column;">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="vintage-card-thumb-link">
                        <?php the_post_thumbnail('magazine-card', array('class' => 'vintage-card-img')); ?>
                    </a>
                <?php endif; ?>

                <div style="margin-bottom: 0.4rem; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #B45309;">
                        <?php
                        $cats = get_the_category();
                        if (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') {
                            echo esc_html($cats[0]->name);
                        } else {
                            echo 'DOSSIER';
                        }
                        ?>
                    </span>
                    <button type="button" class="btn-bookmark-action kicker-action-link <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-id="<?php echo esc_attr($p_id); ?>" data-type="post" title="Save to reading list" style="font-size: 0.75rem;">
                        🔖
                    </button>
                </div>

                <h2 class="font-serif vintage-newspaper-headline" style="font-size: 1.2rem; font-weight: 800; line-height: 1.3; margin: 0 0 0.5rem; color: var(--text-primary, #171513);">
                    <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
                </h2>

                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.9375rem; color: var(--text-secondary, #575149); line-height: 1.5; margin: 0 0 1rem; flex-grow: 1;">
                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                </p>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.65rem; border-top: 1px dashed rgba(120, 113, 108, 0.3); font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C);">
                    <span><?php echo esc_html(get_the_date('M j, Y')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?></span>
                    <button type="button" class="btn-live-like <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" style="background: none; border: none; cursor: pointer; color: inherit; font-size: 0.6875rem; display: flex; align-items: center; gap: 0.25rem;">
                        <span>♥</span> <span><?php echo esc_html($likes); ?></span>
                    </button>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <!-- Numbered Pagination -->
        <div style="margin: 3.5rem 0; display: flex; justify-content: center;">
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('« Previous', 'magazineafrique'),
                'next_text' => __('Next »', 'magazineafrique'),
            ));
            ?>
        </div>

    <?php else : ?>
        <div class="vintage-framed-box" style="padding: 3rem 2rem; text-align: center; background: var(--bg-card, #FFFFFF);">
            <div style="font-size: 2.25rem; margin-bottom: 0.75rem;">🗞️</div>
            <h3 class="font-serif" style="font-size: 1.35rem; font-weight: 800; margin: 0 0 0.5rem; color: var(--text-primary, #171513);">
                No Dispatches Filed Under This Desk Yet
            </h3>
            <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.9375rem; color: var(--text-secondary, #575149); max-width: 480px; margin: 0 auto 1.5rem;">
                Correspondents are actively compiling field reports. Return shortly for updated continental intelligence.
            </p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="circular-notice-btn" style="display: inline-block; text-decoration: none;">
                Return to Broadsheet Front Page →
            </a>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>