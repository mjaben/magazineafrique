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
        
        <!-- 1. The Vintage Broadsheet Kicker Bar -->
        <div class="vintage-headline-kicker-strip">
            <div class="kicker-left-cluster">
                <span class="kicker-desk-tag">
                    <?php
                    $cats = get_the_category();
                    $primary_cat = (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') ? $cats[0] : null;
                    if ($primary_cat) {
                        echo '<a href="' . esc_url(get_category_link($primary_cat->term_id)) . '" class="kicker-desk-link">' . esc_html(strtoupper($primary_cat->name)) . '</a>';
                    } else {
                        echo 'SPECIAL INVESTIGATION';
                    }
                    ?>
                </span>
                <span class="kicker-sep">|</span>
                <span class="kicker-dispatch-meta">DESPATCH #<?php the_ID(); ?> · <?php echo esc_html(get_the_date('j F Y')); ?></span>
                <span class="kicker-sep">·</span>
                <span class="kicker-reading-time"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                <?php if ($is_premium) : ?>
                    <span class="kicker-sep">·</span>
                    <span class="kicker-prestige-badge">★ CLUB PRESTIGE</span>
                <?php endif; ?>
            </div>

            <div class="kicker-right-cluster">
                <?php if ($primary_cat) : 
                    $is_cat_fol = function_exists('magazineafrique_is_followed') ? magazineafrique_is_followed($primary_cat->term_id, 'category') : false;
                ?>
                    <button type="button" class="btn-follow-cat kicker-action-link <?php echo $is_cat_fol ? 'is-following' : ''; ?>" data-id="<?php echo esc_attr($primary_cat->term_id); ?>" data-type="category" title="Follow this topic">
                        <?php echo $is_cat_fol ? '✓ Following Topic' : '+ Follow Topic'; ?>
                    </button>
                    <span class="kicker-sep">·</span>
                <?php endif; ?>
                <button type="button" class="btn-bookmark-action kicker-action-link <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-id="<?php echo esc_attr($post_id); ?>" data-type="post" title="Save to reading list">
                    🔖 <?php echo $is_bookmarked ? 'Saved' : 'Save'; ?>
                </button>
            </div>
        </div>

        <!-- Broadsheet Hairline Divider -->
        <div class="vintage-kicker-hairline"></div>

        <!-- 2. The Main Headline (Vintage Broadsheet Newspaper Font) -->
        <h1 class="article-title-main vintage-newspaper-headline">
            <?php the_title(); ?>
        </h1>

        <!-- 3. The Second Title / Broadsheet Subhead (Deck) -->
        <?php
        $deck = get_the_excerpt();
        if (empty($deck) || trim($deck) === '') {
            $deck = wp_trim_words(strip_shortcodes(get_the_content()), 26, '...');
        }
        if (!empty($deck)) :
        ?>
            <div class="vintage-newspaper-deck">
                <?php echo esc_html($deck); ?>
            </div>
        <?php endif; ?>

        <!-- 4. Vintage Broadsheet Newspaper Byline Strip -->
        <?php
        $share_url = urlencode(get_permalink());
        $share_title = urlencode(get_the_title());
        ?>
        <div class="vintage-newspaper-byline">
            <div class="byline-top-strip">
                <div class="byline-meta-cluster">
                    <span class="byline-correspondent-tag">SPECIAL DESPATCH</span>
                    <span class="byline-sep">·</span>
                    <span class="byline-author-label">BY</span>
                    <span class="byline-author-name"><?php the_author(); ?></span>
                    <span class="byline-sep">·</span>
                    <span class="byline-dateline"><?php echo esc_html(get_the_date('j F Y')); ?></span>
                    <span class="byline-sep">·</span>
                    <span class="byline-reading-est"><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                </div>
                
                <div class="byline-tools-cluster">
                    <!-- Applaud / Like Button -->
                    <button type="button" class="byline-tool-btn btn-live-like <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($post_id); ?>" title="Applaud this reporting">
                        <span class="byline-tool-icon">♥</span>
                        <span class="like-count" id="like-count-<?php echo esc_attr($post_id); ?>"><?php echo esc_html($likes_count); ?></span>
                    </button>

                    <!-- Minimalist Broadsheet Share Row -->
                    <div class="byline-share-group">
                        <span class="byline-share-label">SHARE:</span>
                        <a href="https://api.whatsapp.com/send?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" class="byline-share-link" title="Share via WhatsApp">WA</a>
                        <span class="byline-sep">/</span>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="byline-share-link" title="Share via 𝕏">𝕏</a>
                        <span class="byline-sep">/</span>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="byline-share-link" title="Share via LinkedIn">IN</a>
                        <span class="byline-sep">/</span>
                        <button type="button" class="byline-share-link share-copy-link" data-post-id="<?php echo esc_attr($post_id); ?>" data-url="<?php echo esc_url(get_permalink()); ?>" title="Copy Article Link">LINK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Media (Non-Overflowing Vintage Offset Box Frame) -->
        <?php if (has_post_thumbnail()) : ?>
            <figure class="vintage-double-frame vintage-featured-image-box">
                <div class="vintage-frame-inner">
                    <?php the_post_thumbnail('large', array('class' => 'vintage-framed-img')); ?>
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

        <!-- Strategic End-of-Article WhatsApp Wire Dispatch Box -->
        <div class="vintage-whatsapp-dispatch-card">
            <div class="wa-dispatch-top">
                <div class="wa-badge-cluster">
                    <span class="wa-icon-box">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                    </span>
                    <div>
                        <span class="wa-dispatch-eyebrow">VERIFIED EDITORIAL WIRE</span>
                        <h4 class="wa-dispatch-title">Get breaking Pan-African intelligence on WhatsApp</h4>
                    </div>
                </div>
                <a href="https://whatsapp.com/channel/0029VbABUTT23n3fleq5C91h" target="_blank" rel="noopener" class="vintage-continue-btn wa-join-btn">
                    Join Official Channel ↗
                </a>
            </div>
            <p class="wa-dispatch-sub">
                Zero spam. Daily curated executive briefings, exclusive investigative dossiers, and critical geopolitical wire updates directly to your phone.
            </p>
        </div>

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

        <!-- Strategic In-Article Conclusion Ad Slot (Slot 1801863291 - Before Reader Dispatches) -->
        <?php
        if (function_exists('magazineafrique_render_ad_bottom')) {
            magazineafrique_render_ad_bottom();
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
