<?php
/**
 * Magazine Afrique — Single Article Template
 * Vintage Broadsheet Journalism, Archival Framing, Live Likes, Shares & Bookmarks
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial">

    <?php
    while (have_posts()) : the_post();
        $post_id = get_the_ID();
        $is_premium = function_exists('magazineafrique_is_premium_post') && magazineafrique_is_premium_post();
        $likes_count = function_exists('magazineafrique_get_likes_count') ? magazineafrique_get_likes_count($post_id) : 0;
        $shares_count = function_exists('magazineafrique_get_shares_count') ? magazineafrique_get_shares_count($post_id) : 0;
        $is_bookmarked = function_exists('magazineafrique_is_bookmarked') ? magazineafrique_is_bookmarked($post_id, 'post') : false;
        $is_liked = function_exists('magazineafrique_has_liked') ? magazineafrique_has_liked($post_id) : false;
    ?>

    <article class="article-reading-container">
        
        <!-- Breadcrumbs, Category & Bookmark Button -->
        <div class="article-meta-top">
            <div class="meta-left-tags">
                <?php
                $cats = get_the_category();
                $primary_cat = null;
                if (!empty($cats)) {
                    $primary_cat = $cats[0];
                    if (strtolower($primary_cat->slug) !== 'uncategorized') {
                        $is_cat_followed = function_exists('magazineafrique_is_followed') ? magazineafrique_is_followed($primary_cat->term_id, 'category') : false;
                        echo '<div class="cat-follow-badge-wrap">';
                        echo '<a href="' . esc_url(get_category_link($primary_cat->term_id)) . '" class="article-category-tag">' . esc_html($primary_cat->name) . '</a>';
                        echo '<button type="button" class="btn-follow-cat ' . ($is_cat_followed ? 'is-following' : '') . '" data-id="' . esc_attr($primary_cat->term_id) . '" data-type="category" title="Follow this topic">' . ($is_cat_followed ? '✓ Following' : '+ Follow') . '</button>';
                        echo '</div>';
                        echo '<span class="meta-dot">·</span>';
                    }
                }
                ?>
                <span class="meta-read-time"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                <?php if ($is_premium) : ?>
                    <span class="meta-dot">·</span>
                    <span class="subscriber-exclusive-tag">★ Club Prestige Dossier</span>
                <?php endif; ?>
            </div>

            <!-- Top Bookmark Dispatch -->
            <button type="button" class="btn-bookmark-action <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-id="<?php echo esc_attr($post_id); ?>" data-type="post" title="Save to reading list">
                <span class="bookmark-icon">🔖</span>
                <span class="bookmark-label"><?php echo $is_bookmarked ? 'Saved' : 'Save'; ?></span>
            </button>
        </div>

        <!-- Article Headline -->
        <h1 class="article-title-main">
            <?php the_title(); ?>
        </h1>

        <!-- Dek / Subtitle -->
        <?php if (has_excerpt()) : ?>
            <p class="article-dek-lead">
                <?php echo esc_html(get_the_excerpt()); ?>
            </p>
        <?php endif; ?>

        <!-- Author, Dateline, Live Likes & Shares Byline Bar -->
        <div class="article-byline-bar">
            <div class="byline-author-group">
                <span class="byline-by">By</span>
                <span class="byline-author-text"><?php the_author(); ?></span>
                <span class="byline-divider">—</span>
                <span class="byline-date"><?php echo esc_html(get_the_date('F j, Y')); ?></span>
            </div>

            <!-- Live Interactions (Likes & Shares) -->
            <div class="article-interactive-actions">
                
                <!-- Live Like Button -->
                <button type="button" class="btn-live-like <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($post_id); ?>" title="Applaud this reporting">
                    <svg class="like-heart-icon" width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $is_liked ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span class="like-count" id="like-count-<?php echo esc_attr($post_id); ?>"><?php echo esc_html($likes_count); ?></span>
                </button>

                <!-- Live Share Cluster -->
                <div class="share-live-cluster">
                    <span class="share-counter-tag"><span id="share-count-<?php echo esc_attr($post_id); ?>"><?php echo esc_html($shares_count); ?></span> shares</span>
                    <?php
                    $share_url = urlencode(get_permalink());
                    $share_title = urlencode(get_the_title());
                    ?>
                    <a href="https://api.whatsapp.com/send?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" class="share-pill-btn share-whatsapp" data-post-id="<?php echo esc_attr($post_id); ?>" title="Share on WhatsApp">
                        WhatsApp
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="share-pill-btn share-x" data-post-id="<?php echo esc_attr($post_id); ?>" title="Share on 𝕏">
                        𝕏
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-pill-btn share-linkedin" data-post-id="<?php echo esc_attr($post_id); ?>" title="Share on LinkedIn">
                        LinkedIn
                    </a>
                    <button type="button" class="share-pill-btn share-copy-link" data-post-id="<?php echo esc_attr($post_id); ?>" data-url="<?php echo esc_url(get_permalink()); ?>" title="Copy Article Link">
                        Link
                    </button>
                </div>

            </div>
        </div>

        <!-- Featured Media (Vintage Double-Border Framing) -->
        <?php if (has_post_thumbnail()) : ?>
            <figure class="vintage-double-frame" style="margin-bottom: 2rem;">
                <div class="vintage-frame-inner">
                    <?php the_post_thumbnail('full', array('class' => 'vintage-framed-img')); ?>
                </div>
                <?php if (get_the_post_thumbnail_caption()) : ?>
                    <figcaption class="vintage-photo-caption">
                        <span class="caption-text"><?php the_post_thumbnail_caption(); ?></span>
                        <span class="caption-archive-tag">[ARCHIVE DOSSIER]</span>
                    </figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <!-- Long-Form Reading Body -->
        <div class="article-reading-body drop-cap-classic">
            <?php the_content(); ?>
        </div>

        <!-- Article Footer Interactions (Repeat Like & Share for Reader Convenience) -->
        <div class="article-bottom-interaction-bar">
            <div class="bottom-like-wrap">
                <button type="button" class="btn-live-like <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($post_id); ?>">
                    <svg class="like-heart-icon" width="18" height="18" viewBox="0 0 24 24" fill="<?php echo $is_liked ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span>Applaud Report (<span class="like-count-sub"><?php echo esc_html($likes_count); ?></span>)</span>
                </button>
            </div>
            <button type="button" class="btn-bookmark-action <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-id="<?php echo esc_attr($post_id); ?>" data-type="post">
                <span>🔖 <?php echo $is_bookmarked ? 'Saved to Dossiers' : 'Bookmark this Dossier'; ?></span>
            </button>
        </div>

        <!-- Tags with Follow Buttons -->
        <?php
        $tags = get_the_tags();
        if ($tags) :
        ?>
        <div class="article-tags-wrapper">
            <span class="tags-label">Topics:</span>
            <?php
            foreach ($tags as $tag) {
                $is_tag_followed = function_exists('magazineafrique_is_followed') ? magazineafrique_is_followed($tag->term_id, 'tag') : false;
                echo '<span class="tag-follow-pill">';
                echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">#' . esc_html($tag->name) . '</a>';
                echo '<button type="button" class="btn-follow-tag ' . ($is_tag_followed ? 'is-following' : '') . '" data-id="' . esc_attr($tag->term_id) . '" data-type="tag" title="Follow #' . esc_attr($tag->name) . '">' . ($is_tag_followed ? '✓' : '+') . '</button>';
                echo '</span>';
            }
            ?>
        </div>
        <?php endif; ?>

        <!-- Author Bio (Vintage Literary Card) -->
        <div class="vintage-author-card">
            <div class="author-avatar-frame">
                <?php echo get_avatar(get_the_author_meta('ID'), 64); ?>
            </div>
            <div class="author-details">
                <h4 class="author-name">
                    <?php the_author(); ?>
                </h4>
                <p class="author-desc">
                    <?php echo esc_html(get_the_author_meta('description') ?: "Correspondent and strategic analyst at Magazine Afrique."); ?>
                </p>
            </div>
        </div>

        <!-- Paywall Benefits Card (if post is premium) -->
        <?php
        if ($is_premium && function_exists('magazineafrique_render_paywall_card')) {
            magazineafrique_render_paywall_card();
        }
        ?>

        <!-- Comments -->
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    </article>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
