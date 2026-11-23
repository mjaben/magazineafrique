<?php
/**
 * Template Name: Reader Feed (For You & Following)
 * Template Post Type: page
 *
 * Route: /feed/ (HTML browser view) or /wire/ or /for-you/
 * Stream: For You (curated by categories/tags) & Following (user's followed categories/tags)
 *
 * @package MagazineAfrique
 */

get_header();

$current_user = wp_get_current_user();
$is_logged_in = is_user_logged_in();
$user_id      = $current_user->ID;

// Followed Categories and Tags
$followed_cats = function_exists('magazineafrique_get_user_items') ? magazineafrique_get_user_items('magazineafrique_followed_cats', 'magafrique_followed_cats') : array();
$followed_tags = function_exists('magazineafrique_get_user_items') ? magazineafrique_get_user_items('magazineafrique_followed_tags', 'magafrique_followed_tags') : array();
if (!is_array($followed_cats)) { $followed_cats = array(); }
if (!is_array($followed_tags)) { $followed_tags = array(); }

$active_tab = isset($_GET['tab']) && $_GET['tab'] === 'following' ? 'following' : 'for-you';
$total_followed_count = count($followed_cats) + count($followed_tags);
?>

<style>
/* Scoped Editorial Broadsheet Styling for Reader Feed */
.feed-page-wrapper {
    max-width: 980px;
    margin: 0 auto;
    padding: 2.25rem 1.25rem 5rem;
}
.feed-header-section {
    border-bottom: 2.5px solid var(--border-color, #171513);
    padding-bottom: 1.5rem;
    margin-bottom: 2rem;
}
.feed-eyebrow-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 0.4rem;
}
.feed-eyebrow-text {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.6875rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: #8B2500;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.feed-main-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(2rem, 4vw, 2.75rem);
    font-weight: 900;
    line-height: 1.15;
    color: var(--text-primary, #171513);
    margin: 0.35rem 0 0.5rem;
}
.feed-lead-deck {
    font-size: 0.9375rem;
    color: var(--text-secondary, #5C564E);
    line-height: 1.6;
    max-width: 680px;
    margin: 0;
}
.feed-quick-tools {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}
.feed-tab-bar {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.75rem;
    flex-wrap: wrap;
}
.feed-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.65rem 1.35rem;
    font-size: 0.8125rem;
    font-weight: 800;
    text-decoration: none;
    border-radius: 2px;
    border: 2px solid #171513;
    box-shadow: 3px 3px 0px #171513;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.feed-tab-btn:hover {
    transform: translate(-1px, -1px);
    box-shadow: 4px 4px 0px #171513;
}
.feed-tab-btn.active-tab {
    background-color: #B45309 !important;
    color: #FFFFFF !important;
    border-color: #171513 !important;
    box-shadow: 4px 4px 0px #171513 !important;
}
.feed-tab-btn:not(.active-tab) {
    background-color: var(--bg-card, #FFFFFF);
    color: var(--text-primary, #171513);
}

/* Category Filter Strip */
.feed-desks-filter {
    background-color: var(--bg-card-subtle, #EFE9DE);
    border: 2px solid var(--border-color, #171513);
    box-shadow: 4px 4px 0px var(--shadow-color, #171513);
    border-radius: 3px;
    padding: 1rem 1.25rem;
    margin-bottom: 2.25rem;
}
.feed-desks-title {
    font-size: 0.6875rem;
    font-weight: 800;
    font-family: 'JetBrains Mono', monospace;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-secondary, #5C564E);
    margin-bottom: 0.65rem;
}
.feed-desks-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.45rem;
    align-items: center;
}
.feed-desk-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.75rem;
    background: var(--bg-card, #FFFFFF);
    border: 1.5px solid var(--border-color, #171513);
    padding: 0.25rem 0.6rem;
    border-radius: 2px;
}

/* Dispatch Article Card */
.feed-article-card {
    background-color: var(--bg-card, #FFFFFF);
    border: 2px solid #171513;
    box-shadow: 5px 5px 0px #171513;
    border-radius: 3px;
    padding: 1.4rem;
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
    margin-bottom: 1.6rem;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.feed-article-card:hover {
    transform: translate(-2px, -2px);
    box-shadow: 7px 7px 0px #171513;
}
.feed-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.6875rem;
    font-family: 'JetBrains Mono', monospace;
    border-bottom: 1px dashed var(--border-light, #E2DBD0);
    padding-bottom: 0.5rem;
}
.feed-card-main-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    align-items: start;
}
@media (min-width: 640px) {
    .feed-card-main-grid.has-thumb {
        grid-template-columns: 1fr 150px;
    }
}
.feed-card-headline {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(1.25rem, 2.5vw, 1.45rem);
    font-weight: 800;
    margin: 0 0 0.5rem;
    line-height: 1.3;
}
.feed-card-headline a {
    color: var(--text-primary, #171513);
    text-decoration: none;
    transition: color 0.15s ease;
}
.feed-card-headline a:hover {
    color: #B45309;
}
.feed-card-excerpt {
    font-size: 0.875rem;
    color: var(--text-secondary, #5C564E);
    margin: 0;
    line-height: 1.6;
}
.feed-thumb-link {
    display: block;
    width: 100%;
    max-width: 150px;
    height: 100px;
    overflow: hidden;
    border-radius: 2px;
    border: 1.5px solid #171513;
    box-shadow: 2px 2px 0px #171513;
}
.feed-thumb-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.25s ease;
}
.feed-thumb-link:hover .feed-thumb-img {
    transform: scale(1.05);
}

/* Card Action Bar */
.feed-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 0.65rem;
    border-top: 1px dashed var(--border-light, #E2DBD0);
    font-size: 0.75rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.feed-action-cluster {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.btn-feed-action {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-secondary, #5C564E);
    font-size: 0.75rem;
    font-family: inherit;
    font-weight: 600;
    padding: 0.2rem 0.4rem;
    border-radius: 2px;
    transition: background 0.15s ease, color 0.15s ease;
}
.btn-feed-action:hover {
    background-color: rgba(0, 0, 0, 0.05);
    color: var(--text-primary, #171513);
}
.btn-feed-read {
    color: #8B2500;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    transition: color 0.15s ease, transform 0.15s ease;
}
.btn-feed-read:hover {
    color: #B45309;
    transform: translateX(2px);
}

/* Dark Mode Overrides */
[data-theme="dark"] .feed-header-section {
    border-bottom-color: #38332F;
}
[data-theme="dark"] .feed-tab-btn:not(.active-tab) {
    background-color: #1C1917 !important;
    border-color: #38332F !important;
    box-shadow: 3px 3px 0px #000000 !important;
    color: #F7F2E8 !important;
}
[data-theme="dark"] .feed-desks-filter {
    background-color: #24201D !important;
    border-color: #38332F !important;
    box-shadow: 4px 4px 0px #000000 !important;
}
[data-theme="dark"] .feed-desk-chip {
    background-color: #1C1917 !important;
    border-color: #38332F !important;
}
[data-theme="dark"] .feed-article-card {
    background-color: #1C1917 !important;
    border-color: #38332F !important;
    box-shadow: 5px 5px 0px #000000 !important;
}
[data-theme="dark"] .feed-article-card:hover {
    box-shadow: 7px 7px 0px #000000 !important;
}
[data-theme="dark"] .feed-card-header,
[data-theme="dark"] .feed-card-footer {
    border-color: #38332F !important;
}
[data-theme="dark"] .feed-thumb-link {
    border-color: #38332F !important;
    box-shadow: 2px 2px 0px #000000 !important;
}
[data-theme="dark"] .btn-feed-action:hover {
    background-color: rgba(255, 255, 255, 0.08);
}
</style>

<main id="primary" class="site-main container-editorial broadsheet-main">
    <div class="feed-page-wrapper">

        <!-- Feed Masthead Section -->
        <header class="feed-header-section">
            <div class="feed-eyebrow-row">
                <div class="feed-eyebrow-text">
                    <span style="color: #D97706;">●</span> CORRESPONDENT INTELLIGENCE WIRE · VOL. XLVIII
                </div>

                <!-- Fast Utility Links -->
                <div class="feed-quick-tools">
                    <a href="<?php echo esc_url(get_feed_link()); ?>" target="_blank" class="btn-vintage-box" style="padding: 0.35rem 0.65rem; font-size: 0.6875rem; text-decoration: none;">
                        📡 XML RSS
                    </a>
                    <a href="<?php echo esc_url(home_url('/feed/')); ?>" class="btn-vintage-box" style="padding: 0.35rem 0.65rem; font-size: 0.6875rem; text-decoration: none;" title="Refresh Wire">
                        ↻ Refresh
                    </a>
                </div>
            </div>

            <h1 class="feed-main-title">
                The Pan-African Reader Feed
            </h1>

            <p class="feed-lead-deck">
                Curated continental reporting tailored by editorial categories, investigative tags, and your personal following wire across all 54 African states.
            </p>

            <!-- Mode Switcher Tabs: For You vs Following Wire -->
            <div class="feed-tab-bar">
                <a href="<?php echo esc_url(add_query_arg('tab', 'for-you')); ?>" class="feed-tab-btn <?php echo $active_tab === 'for-you' ? 'active-tab' : ''; ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    For You (All Desks &amp; Hubs)
                </a>

                <a href="<?php echo esc_url(add_query_arg('tab', 'following')); ?>" class="feed-tab-btn <?php echo $active_tab === 'following' ? 'active-tab' : ''; ?>">
                    <span style="color: <?php echo $active_tab === 'following' ? '#FFFFFF' : '#D97706'; ?>;">✦</span>
                    Following Wire (<?php echo esc_html($total_followed_count); ?> Topics)
                </a>
            </div>
        </header>

        <!-- Editorial Desks Quick Follow Filter Bar -->
        <section class="feed-desks-filter">
            <div class="feed-desks-title">
                Filter &amp; Follow Continental Desks:
            </div>
            <div class="feed-desks-list">
                <?php
                $popular_cats = get_categories(array('number' => 8, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => array(1)));
                foreach ($popular_cats as $cat) {
                    $is_cat_followed = in_array((int)$cat->term_id, array_map('intval', $followed_cats), true);
                    ?>
                    <span class="feed-desk-chip">
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" style="font-weight: 700; color: var(--text-primary, #171513); text-decoration: none;">
                            <?php echo esc_html($cat->name); ?>
                        </a>
                        <button type="button" class="btn-follow-cat <?php echo $is_cat_followed ? 'is-following' : ''; ?>" data-id="<?php echo esc_attr($cat->term_id); ?>" data-type="category" style="background: none; border: none; font-size: 0.6875rem; cursor: pointer; color: <?php echo $is_cat_followed ? '#B45309' : '#8B2500'; ?>; font-weight: 800; padding: 0 0.2rem;">
                            <?php echo $is_cat_followed ? '✓' : '+'; ?>
                        </button>
                    </span>
                    <?php
                }
                ?>
            </div>
        </section>

        <!-- Feed Content Stream -->
        <section class="feed-content-stream">
            <?php
            if ($active_tab === 'following') {
                // =========================================================================
                // TAB 2: FOLLOWING WIRE (User's followed categories & tags)
                // =========================================================================
                if (empty($followed_cats) && empty($followed_tags)) {
                    ?>
                    <div class="vintage-framed-box" style="padding: 2.75rem 1.5rem; text-align: center; background-color: var(--bg-card, #FFFFFF); margin-bottom: 2rem;">
                        <div style="font-size: 2.75rem; color: #D97706; margin-bottom: 0.75rem;">✦</div>
                        <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.65rem; font-weight: 900; color: var(--text-primary, #171513); margin: 0 0 0.5rem;">
                            Your Following Wire is Empty
                        </h2>
                        <p style="font-size: 0.9375rem; color: var(--text-secondary, #5C564E); max-width: 520px; margin: 0 auto 1.75rem; line-height: 1.6;">
                            Follow editorial desks (like <em>Geopolitics</em>, <em>Fintech</em>, or <em>Mining</em>) and investigative tags using the <strong>+</strong> buttons above or across articles to build your personalized intelligence wire.
                        </p>

                        <!-- Suggested Starting Topics -->
                        <div style="margin-bottom: 2rem;">
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 0.75rem;">
                                Quick-Follow Recommended Desks:
                            </div>
                            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem;">
                                <?php
                                $suggested_cats = get_categories(array('number' => 5, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => array(1)));
                                foreach ($suggested_cats as $sc) {
                                    ?>
                                    <button type="button" class="btn-follow-cat btn-vintage-box" data-id="<?php echo esc_attr($sc->term_id); ?>" data-type="category" style="padding: 0.4rem 0.85rem; font-size: 0.75rem; font-weight: 700; cursor: pointer;">
                                        + <?php echo esc_html($sc->name); ?>
                                    </button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <a href="<?php echo esc_url(add_query_arg('tab', 'for-you')); ?>" class="feed-tab-btn active-tab" style="display: inline-flex;">
                            Browse "For You" Feed »
                        </a>

                        <?php if (!$is_logged_in) : ?>
                            <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px dashed var(--border-light, #E2DBD0); font-size: 0.8125rem; color: var(--text-secondary);">
                                💡 Tip: <a href="<?php echo esc_url(home_url('/onboarding/?mode=login')); ?>" style="color: #8B2500; font-weight: 700; text-decoration: underline;">Sign In</a> or <a href="<?php echo esc_url(home_url('/onboarding/')); ?>" style="color: #8B2500; font-weight: 700; text-decoration: underline;">Create a Free Account</a> to sync your followed topics across your mobile phone and desktop.
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                } else {
                    $tax_query = array('relation' => 'OR');
                    if (!empty($followed_cats)) {
                        $tax_query[] = array(
                            'taxonomy' => 'category',
                            'field'    => 'term_id',
                            'terms'    => array_map('intval', $followed_cats),
                            'operator' => 'IN'
                        );
                    }
                    if (!empty($followed_tags)) {
                        $tax_query[] = array(
                            'taxonomy' => 'post_tag',
                            'field'    => 'term_id',
                            'terms'    => array_map('intval', $followed_tags),
                            'operator' => 'IN'
                        );
                    }

                    $paged = max(1, get_query_var('paged'), get_query_var('page'));
                    $following_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'post_status'    => 'publish',
                        'posts_per_page' => 15,
                        'paged'          => $paged,
                        'tax_query'      => $tax_query
                    ));

                    if ($following_query->have_posts()) {
                        while ($following_query->have_posts()) {
                            $following_query->the_post();
                            $p_id = get_the_ID();
                            $is_bookmarked = function_exists('magazineafrique_is_item_saved') ? magazineafrique_is_item_saved($p_id, 'post') : false;
                            $is_liked = function_exists('magazineafrique_user_has_liked') ? magazineafrique_user_has_liked($p_id) : false;
                            $likes = function_exists('magazineafrique_get_likes_count') ? magazineafrique_get_likes_count($p_id) : 0;
                            $post_cats = get_the_category();
                            ?>
                            <article class="feed-article-card">
                                <div class="feed-card-header">
                                    <div style="display: flex; align-items: center; gap: 0.45rem;">
                                        <?php if (!empty($post_cats)) : ?>
                                            <a href="<?php echo esc_url(get_category_link($post_cats[0]->term_id)); ?>" style="color: #8B2500; font-weight: 800; text-transform: uppercase; text-decoration: none;">
                                                <?php echo esc_html($post_cats[0]->name); ?>
                                            </a>
                                            <span style="color: var(--text-muted, #8C8275);">·</span>
                                        <?php endif; ?>
                                        <span style="color: var(--text-muted, #8C8275);"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                                    </div>
                                    <span style="color: #B45309; font-weight: 800; letter-spacing: 0.05em;">★ MATCHES YOUR WIRE</span>
                                </div>

                                <div class="feed-card-main-grid <?php echo has_post_thumbnail() ? 'has-thumb' : ''; ?>">
                                    <div>
                                        <h2 class="feed-card-headline">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h2>
                                        <p class="feed-card-excerpt">
                                            <?php echo wp_trim_words(get_the_excerpt(), 26); ?>
                                        </p>
                                    </div>

                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>" class="feed-thumb-link" aria-label="<?php the_title_attribute(); ?>">
                                            <?php the_post_thumbnail('medium', array('class' => 'feed-thumb-img', 'alt' => get_the_title())); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <!-- Action Bar -->
                                <footer class="feed-card-footer">
                                    <div class="feed-action-cluster">
                                        <button type="button" class="btn-live-like btn-feed-action <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" title="Applaud Dispatch">
                                            <span class="like-heart-icon"><?php echo $is_liked ? '❤️' : '🤍'; ?></span>
                                            <span class="live-like-counter"><?php echo esc_html($likes); ?></span>
                                        </button>
                                        <button type="button" class="btn-bookmark btn-feed-action <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" title="Save to Reading List">
                                            <span>🔖</span>
                                            <span><?php echo $is_bookmarked ? 'Saved' : 'Save Dossier'; ?></span>
                                        </button>
                                    </div>

                                    <a href="<?php the_permalink(); ?>" class="btn-feed-read">
                                        Read Dispatch →
                                    </a>
                                </footer>
                            </article>
                            <?php
                        }
                        wp_reset_postdata();
                    } else {
                        echo '<div class="vintage-framed-box" style="padding: 2.5rem; text-align: center; background-color: var(--bg-card, #FFFFFF);">No dispatches found matching your current topics. Follow more desks above to expand your feed.</div>';
                    }
                }

            } else {
                // =========================================================================
                // TAB 1: FOR YOU (Curated & algorithmic stream across categories & tags)
                // =========================================================================
                $paged = max(1, get_query_var('paged'), get_query_var('page'));
                $for_you_query = new WP_Query(array(
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => 12,
                    'paged'          => $paged,
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                ));

                if ($for_you_query->have_posts()) {
                    $counter = 0;
                    while ($for_you_query->have_posts()) {
                        $for_you_query->the_post();
                        $counter++;
                        $p_id = get_the_ID();
                        $is_bookmarked = function_exists('magazineafrique_is_item_saved') ? magazineafrique_is_item_saved($p_id, 'post') : false;
                        $is_liked = function_exists('magazineafrique_user_has_liked') ? magazineafrique_user_has_liked($p_id) : false;
                        $likes = function_exists('magazineafrique_get_likes_count') ? magazineafrique_get_likes_count($p_id) : 0;
                        $post_cats = get_the_category();
                        ?>
                        <article class="feed-article-card">
                            <div class="feed-card-header">
                                <div style="display: flex; align-items: center; gap: 0.45rem;">
                                    <?php
                                    if (!empty($post_cats)) {
                                        $c = $post_cats[0];
                                        $is_c_followed = in_array((int)$c->term_id, array_map('intval', $followed_cats), true);
                                        ?>
                                        <a href="<?php echo esc_url(get_category_link($c->term_id)); ?>" style="color: #8B2500; font-weight: 800; text-transform: uppercase; text-decoration: none;">
                                            <?php echo esc_html($c->name); ?>
                                        </a>
                                        <button type="button" class="btn-follow-cat <?php echo $is_c_followed ? 'is-following' : ''; ?>" data-id="<?php echo esc_attr($c->term_id); ?>" data-type="category" style="background: none; border: none; font-size: 0.6875rem; cursor: pointer; color: <?php echo $is_c_followed ? '#B45309' : '#8B2500'; ?>; font-weight: 800; padding: 0 0.15rem;">
                                            <?php echo $is_c_followed ? '✓' : '+ Follow'; ?>
                                        </button>
                                        <span style="color: var(--text-muted, #8C8275);">·</span>
                                        <?php
                                    }
                                    ?>
                                    <span style="color: var(--text-muted, #8C8275);"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                                </div>

                                <span style="color: var(--text-muted, #8C8275); font-size: 0.625rem; font-weight: 700;">DISPATCH #<?php echo esc_html($p_id); ?></span>
                            </div>

                            <div class="feed-card-main-grid <?php echo has_post_thumbnail() ? 'has-thumb' : ''; ?>">
                                <div>
                                    <h2 class="feed-card-headline">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    <p class="feed-card-excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 26); ?>
                                    </p>
                                </div>

                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>" class="feed-thumb-link" aria-label="<?php the_title_attribute(); ?>">
                                        <?php the_post_thumbnail('medium', array('class' => 'feed-thumb-img', 'alt' => get_the_title())); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Tags Strip with 1-Click Follow -->
                            <?php
                            $post_tags = get_the_tags();
                            if ($post_tags) :
                                ?>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.35rem; align-items: center; margin-top: 0.15rem;">
                                    <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; font-weight: 700; color: var(--text-muted, #8C8275);">TAGS:</span>
                                    <?php
                                    foreach (array_slice($post_tags, 0, 4) as $tg) {
                                        $is_t_followed = in_array((int)$tg->term_id, array_map('intval', $followed_tags), true);
                                        ?>
                                        <span class="tag-follow-pill" style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.6875rem; padding: 0.15rem 0.45rem; background: var(--bg-card-subtle, #EFE9DE); border: 1px solid var(--border-color, #171513); border-radius: 2px;">
                                            <a href="<?php echo esc_url(get_tag_link($tg->term_id)); ?>" style="color: var(--text-primary, #171513); text-decoration: none; font-weight: 600;">
                                                #<?php echo esc_html($tg->name); ?>
                                            </a>
                                            <button type="button" class="btn-follow-tag <?php echo $is_t_followed ? 'is-following' : ''; ?>" data-id="<?php echo esc_attr($tg->term_id); ?>" data-type="tag" style="background: none; border: none; font-size: 0.625rem; cursor: pointer; color: <?php echo $is_t_followed ? '#B45309' : '#8B2500'; ?>; font-weight: 800; padding: 0;">
                                                <?php echo $is_t_followed ? '✓' : '+'; ?>
                                            </button>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <!-- Action Bar -->
                            <footer class="feed-card-footer">
                                <div class="feed-action-cluster">
                                    <button type="button" class="btn-live-like btn-feed-action <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" title="Applaud Dispatch">
                                        <span class="like-heart-icon"><?php echo $is_liked ? '❤️' : '🤍'; ?></span>
                                        <span class="live-like-counter"><?php echo esc_html($likes); ?></span>
                                    </button>
                                    <button type="button" class="btn-bookmark btn-feed-action <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" title="Save to Reading List">
                                        <span>🔖</span>
                                        <span><?php echo $is_bookmarked ? 'Saved' : 'Save Dossier'; ?></span>
                                    </button>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="btn-feed-read">
                                    Read Full Dossier →
                                </a>
                            </footer>
                        </article>

                        <?php
                        // In-Stream Responsive Ad Slot after story 3
                        if ($counter === 3 && function_exists('magazineafrique_render_article_ad_1')) {
                            echo '<div style="margin: 1.5rem 0;">' . magazineafrique_render_article_ad_1() . '</div>';
                        }
                    }
                    wp_reset_postdata();
                }
            }
            ?>
        </section>

    </div>
</main>

<?php get_footer(); ?>
