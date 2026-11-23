<?php
/**
 * Magazine Afrique — Single Article Template
 * Vintage Broadsheet Journalism with Desktop/Tablet Sidebar, In-Article Ads & Related Intelligence
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
        
        $cats = get_the_category();
        $primary_cat = (!empty($cats) && strtolower($cats[0]->slug) !== 'uncategorized') ? $cats[0] : null;
        $share_url = urlencode(get_permalink());
        $share_title = urlencode(get_the_title());
    ?>

    <!-- 1. The Vintage Broadsheet Kicker Bar -->
    <div class="vintage-headline-kicker-strip">
        <div class="kicker-left-cluster">
            <span class="kicker-desk-tag">
                <?php
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

    <!-- 5. Featured Media (Non-Overflowing Vintage Box Frame with 5px Offset Drop Shadow) -->
    <?php if (has_post_thumbnail()) : ?>
        <figure class="vintage-double-frame vintage-featured-image-box">
            <div class="vintage-frame-inner">
                <?php the_post_thumbnail('large', array('class' => 'vintage-framed-img')); ?>
            </div>
            <?php if (get_the_post_thumbnail_caption()) : ?>
                <figcaption class="vintage-photo-caption">
                    <span class="caption-text"><?php the_post_thumbnail_caption(); ?></span>
                    <span class="caption-archive-tag">[PHOTO ARCHIVE]</span>
                </figcaption>
            <?php endif; ?>
        </figure>
    <?php endif; ?>

    <!-- 6. Two-Column Broadsheet Reading Grid (Primary Content + Sidebar on PC/Tablet) -->
    <div class="article-broadsheet-layout">
        
        <!-- Left Column: Article Body, Bio, Paywall, Related Posts, Comments -->
        <div class="article-primary-column">
            
            <!-- Long-Form Reading Body -->
            <div class="article-reading-body drop-cap-classic">
                <?php the_content(); ?>
            </div>

            <!-- Article Footer Interactions (Like & Save Dossier) -->
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

            <!-- Strategic In-Article Conclusion Ad Slot (Slot 1801863291 - Before Related Dossiers) -->
            <?php
            if (function_exists('magazineafrique_render_ad_bottom')) {
                magazineafrique_render_ad_bottom();
            }
            ?>

            <!-- Related Articles & "Posts You May Like Based on Engagement" -->
            <section class="vintage-related-dossiers-section">
                <div class="broadsheet-section-header">
                    <h3 class="broadsheet-section-title">RELATED DOSSIERS &amp; ENGAGEMENT WIRE</h3>
                    <span class="broadsheet-edition-stamp">INTELLIGENCE BRIEFS</span>
                </div>
                
                <div class="related-dossiers-grid">
                    <?php
                    $related_args = array(
                        'posts_per_page'      => 3,
                        'post__not_in'        => array($post_id),
                        'ignore_sticky_posts' => 1
                    );
                    if ($primary_cat) {
                        $related_args['category__in'] = array($primary_cat->term_id);
                    }
                    $related_query = new WP_Query($related_args);
                    if ($related_query->have_posts()) :
                        while ($related_query->have_posts()) : $related_query->the_post();
                    ?>
                    <article class="vintage-grid-card related-post-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="vintage-card-thumb-link">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'vintage-card-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="vintage-card-kicker">
                            <?php
                            $rcats = get_the_category();
                            echo (!empty($rcats) && strtolower($rcats[0]->slug) !== 'uncategorized') ? esc_html($rcats[0]->name) : 'DOSSIER';
                            ?>
                        </div>
                        <h4 class="vintage-card-title vintage-newspaper-headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <p class="vintage-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 16); ?>
                        </p>
                        <div class="vintage-card-date">
                            <?php echo esc_html(get_the_date('M j, Y')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?>
                        </div>
                    </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>

            <!-- Comments -->
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        </div>

        <!-- Right Column: Sidebar on PC & Tablet -->
        <aside class="article-sidebar-column">
            <div class="article-sidebar-sticky">

                <!-- 1. Commercial Dispatch Sidebar Ad Slot (Slot 1854558906) -->
                <?php
                if (function_exists('magazineafrique_render_ad_sidebar')) {
                    magazineafrique_render_ad_sidebar();
                }
                ?>

                <!-- 2. The Continental Telegraph / Trending Dossiers -->
                <div class="vintage-sidebar-widget">
                    <div class="sidebar-widget-header">
                        <span class="sidebar-widget-glyph" aria-hidden="true"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -1px; margin-right: 4px;"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m8 17 4 4 4-4"/></svg></span>
                        <h4 class="sidebar-widget-title">CONTINENTAL TELEGRAPH</h4>
                    </div>
                    <div class="sidebar-telegraph-list">
                        <?php
                        $trending_query = new WP_Query(array(
                            'posts_per_page'      => 4,
                            'post__not_in'        => array($post_id),
                            'orderby'             => 'comment_count date',
                            'ignore_sticky_posts' => 1
                        ));
                        if ($trending_query->have_posts()) :
                            while ($trending_query->have_posts()) : $trending_query->the_post();
                        ?>
                        <article class="sidebar-telegraph-item">
                            <div class="telegraph-item-kicker">
                                <?php
                                $tc = get_the_category();
                                echo (!empty($tc) && strtolower($tc[0]->slug) !== 'uncategorized') ? esc_html($tc[0]->name) : 'WIRE';
                                ?>
                            </div>
                            <h5 class="telegraph-item-title vintage-newspaper-headline">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h5>
                            <div class="telegraph-item-meta">
                                <span><?php echo esc_html(get_the_date('j M')); ?></span> · 
                                <span><?php echo esc_html(magazineafrique_reading_time()); ?></span>
                            </div>
                        </article>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>

                <!-- 3. Bureaus Dispatch Compass -->
                <div class="vintage-sidebar-widget">
                    <div class="sidebar-widget-header">
                        <span class="sidebar-widget-glyph" aria-hidden="true"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -1px; margin-right: 4px;"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg></span>
                        <h4 class="sidebar-widget-title">DISPATCH TOPICS</h4>
                    </div>
                    <div class="sidebar-compass-chips">
                        <?php
                        $topics = get_categories(array('number' => 8, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => array(1)));
                        foreach ($topics as $tp) :
                        ?>
                            <a href="<?php echo esc_url(get_category_link($tp->term_id)); ?>" class="sidebar-topic-chip">
                                #<?php echo esc_html($tp->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 4. Club Prestige Dispatch Pass -->
                <div class="vintage-sidebar-widget vintage-prestige-sidebar-card">
                    <div class="prestige-card-badge">★ CLUB PRESTIGE</div>
                    <h4 class="prestige-card-title">Strategic Dossiers For African Decision Makers</h4>
                    <p class="prestige-card-desc">
                        Unrestricted executive briefings, geopolitical wire dispatches, and macroeconomic forecast data.
                    </p>
                    <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="circular-notice-btn prestige-card-btn">
                        Enroll in Club →
                    </a>
                </div>

            </div>
        </aside>

    </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
