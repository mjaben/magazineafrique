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

$active_tab = isset($_GET['tab']) && $_GET['tab'] === 'following' ? 'following' : 'for-you';
?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 960px; margin: 0 auto; padding-top: 2rem; padding-bottom: 4rem;">

    <!-- Feed Header (Vintage Archival Masthead) -->
    <div style="border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 1.25rem; margin-bottom: 2rem;">
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 0.5rem;">
            <div>
                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #8B2500;">
                    [ CORRESPONDENT INTELLIGENCE WIRE ]
                </span>
                <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(1.85rem, 3.5vw, 2.5rem); font-weight: 900; color: var(--text-primary, #171513); margin: 0.25rem 0 0.5rem; line-height: 1.2;">
                    The Pan-African Reader Feed
                </h1>
                <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5; max-width: 650px;">
                    Curated continental reporting tailored by editorial categories, investigative tags, and your personal following wire.
                </p>
            </div>

            <!-- RSS / Purge Quick Actions -->
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <a href="<?php echo esc_url(get_feed_link()); ?>" target="_blank" class="btn-vintage-box" style="padding: 0.4rem 0.75rem; font-size: 0.6875rem; background: var(--bg-card); color: var(--text-primary); text-decoration: none;">
                    📡 XML RSS
                </a>
                <a href="<?php echo esc_url(home_url('/feed/')); ?>" class="btn-vintage-box" style="padding: 0.4rem 0.75rem; font-size: 0.6875rem; background: var(--bg-card); color: var(--text-primary); text-decoration: none;" title="Refresh feed">
                    ↻ Refresh
                </a>
            </div>
        </div>

        <!-- Feed Mode Tabs: For You vs Following -->
        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
            <a href="?tab=for-you" class="btn-vintage-box <?php echo $active_tab === 'for-you' ? 'active-tab' : ''; ?>" style="padding: 0.65rem 1.25rem; font-size: 0.8125rem; text-decoration: none; <?php echo $active_tab === 'for-you' ? 'background: #B45309; color: #FFFFFF; font-weight: 800;' : 'background: var(--bg-card, #FAF6EE); color: var(--text-primary, #171513);'; ?>">
                ❖ For You (Categories &amp; Regional Hubs)
            </a>
            <a href="?tab=following" class="btn-vintage-box <?php echo $active_tab === 'following' ? 'active-tab' : ''; ?>" style="padding: 0.65rem 1.25rem; font-size: 0.8125rem; text-decoration: none; <?php echo $active_tab === 'following' ? 'background: #8B2500; color: #FFFFFF; font-weight: 800;' : 'background: var(--bg-card, #FAF6EE); color: var(--text-primary, #171513);'; ?>">
                ✦ Following Wire (<?php echo count($followed_cats) + count($followed_tags); ?> Topics)
            </a>
        </div>
    </div>

    <!-- Active Topics Cloud / Quick Follow Filter -->
    <div class="vintage-framed-box" style="padding: 1rem 1.25rem; margin-bottom: 2rem; background-color: var(--bg-card-subtle, #EFE9DE);">
        <div style="font-size: 0.6875rem; font-weight: 800; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-secondary, #5C564E); margin-bottom: 0.5rem;">
            Filter &amp; Follow Editorial Desks:
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 0.4rem; align-items: center;">
            <?php
            $popular_cats = get_categories(array('number' => 8, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => array(1)));
            foreach ($popular_cats as $cat) {
                $is_cat_followed = in_array((int)$cat->term_id, array_map('intval', $followed_cats), true);
                ?>
                <span class="tag-follow-pill" style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; background: var(--bg-card, #FAF6EE); border: 1px solid var(--border-color, #231F1D); padding: 0.2rem 0.5rem; border-radius: 2px;">
                    <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" style="font-weight: 700; color: var(--text-primary, #171513); text-decoration: none;">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                    <button type="button" class="btn-follow-cat <?php echo $is_cat_followed ? 'is-following' : ''; ?>" data-id="<?php echo esc_attr($cat->term_id); ?>" data-type="category" style="background: none; border: none; font-size: 0.6875rem; cursor: pointer; color: <?php echo $is_cat_followed ? '#B45309' : '#8B2500'; ?>; font-weight: 800; padding: 0 0.15rem;">
                        <?php echo $is_cat_followed ? '✓' : '+'; ?>
                    </button>
                </span>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- Feed Content -->
    <?php
    if ($active_tab === 'following') {
        // TAB 2: FOLLOWING WIRE (Based strictly on user's followed categories and tags)
        if (empty($followed_cats) && empty($followed_tags)) {
            ?>
            <div class="vintage-framed-box" style="padding: 2.5rem 1.5rem; text-align: center; background-color: var(--bg-card, #FAF6EE);">
                <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">✦</div>
                <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.5rem; font-weight: 800; color: var(--text-primary, #171513); margin: 0 0 0.5rem;">
                    Your Following Wire is Empty
                </h2>
                <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.5;">
                    Follow editorial desks or investigative tags using the <strong>+</strong> buttons above or across articles to populate your customized newsroom feed.
                </p>
                <a href="?tab=for-you" class="btn-vintage-box" style="padding: 0.75rem 1.5rem; font-size: 0.8125rem; background: #B45309; color: #FFFFFF; font-weight: 800; text-decoration: none;">
                    Explore "For You" Feed »
                </a>
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

            $following_query = new WP_Query(array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 15,
                'tax_query'      => $tax_query
            ));

            if ($following_query->have_posts()) {
                echo '<div style="display: flex; flex-direction: column; gap: 1.5rem;">';
                while ($following_query->have_posts()) {
                    $following_query->the_post();
                    $p_id = get_the_ID();
                    $is_bookmarked = function_exists('magazineafrique_is_bookmarked') ? magazineafrique_is_bookmarked($p_id, 'post') : false;
                    $is_liked = function_exists('magazineafrique_has_liked') ? magazineafrique_has_liked($p_id) : false;
                    $likes = function_exists('magazineafrique_get_likes_count') ? magazineafrique_get_likes_count($p_id) : 0;
                    ?>
                    <article class="vintage-framed-box" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.75rem; background-color: var(--bg-card, #FAF6EE);">
                        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.6875rem; font-family: 'JetBrains Mono', monospace;">
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <?php
                                $post_cats = get_the_category();
                                if (!empty($post_cats)) {
                                    $c = $post_cats[0];
                                    echo '<a href="' . esc_url(get_category_link($c->term_id)) . '" style="color: #8B2500; font-weight: 800; text-transform: uppercase; text-decoration: none;">' . esc_html($c->name) . '</a>';
                                }
                                ?>
                                <span style="color: var(--text-muted);">·</span>
                                <span style="color: var(--text-muted);"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                            </div>
                            <span style="color: #B45309; font-weight: 700;">★ MATCHES YOUR WIRE</span>
                        </div>

                        <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.35rem; font-weight: 800; margin: 0; line-height: 1.3;">
                            <a href="<?php the_permalink(); ?>" style="color: var(--text-primary, #171513); text-decoration: none;">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.55;">
                            <?php echo wp_trim_words(get_the_excerpt(), 24); ?>
                        </p>

                        <!-- Action Bar -->
                        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.5rem; border-top: 1px dashed var(--border-color, #4A433B); font-size: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <button type="button" class="btn-live-like <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" style="display: flex; align-items: center; gap: 0.35rem; background: none; border: none; cursor: pointer; color: var(--text-secondary);">
                                    <span>❤️</span> <span><?php echo esc_html($likes); ?></span>
                                </button>
                                <button type="button" class="btn-bookmark-action <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-id="<?php echo esc_attr($p_id); ?>" data-type="post" style="display: flex; align-items: center; gap: 0.35rem; background: none; border: none; cursor: pointer; color: var(--text-secondary);">
                                    <span>🔖</span> <span><?php echo $is_bookmarked ? 'Saved' : 'Save Dossier'; ?></span>
                                </button>
                            </div>
                            <a href="<?php the_permalink(); ?>" style="color: #8B2500; font-weight: 700; text-decoration: none;">
                                Read Dispatch →
                            </a>
                        </div>
                    </article>
                    <?php
                }
                echo '</div>';
                wp_reset_postdata();
            } else {
                echo '<div class="vintage-framed-box" style="padding: 2rem; text-align: center;">No stories found in your followed topics yet. Check back soon.</div>';
            }
        }

    } else {
        // TAB 1: FOR YOU (Curated by Categories & Tags)
        $for_you_query = new WP_Query(array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 12,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ));

        if ($for_you_query->have_posts()) {
            echo '<div style="display: flex; flex-direction: column; gap: 1.5rem;">';
            $counter = 0;
            while ($for_you_query->have_posts()) {
                $for_you_query->the_post();
                $counter++;
                $p_id = get_the_ID();
                $is_bookmarked = function_exists('magazineafrique_is_bookmarked') ? magazineafrique_is_bookmarked($p_id, 'post') : false;
                $is_liked = function_exists('magazineafrique_has_liked') ? magazineafrique_has_liked($p_id) : false;
                $likes = function_exists('magazineafrique_get_likes_count') ? magazineafrique_get_likes_count($p_id) : 0;
                ?>
                <article class="vintage-framed-box" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.75rem; background-color: var(--bg-card, #FAF6EE);">
                    
                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.6875rem; font-family: 'JetBrains Mono', monospace;">
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <?php
                            $post_cats = get_the_category();
                            if (!empty($post_cats)) {
                                $c = $post_cats[0];
                                $is_c_followed = in_array((int)$c->term_id, array_map('intval', $followed_cats), true);
                                echo '<a href="' . esc_url(get_category_link($c->term_id)) . '" style="color: #8B2500; font-weight: 800; text-transform: uppercase; text-decoration: none;">' . esc_html($c->name) . '</a>';
                                echo '<button type="button" class="btn-follow-cat ' . ($is_c_followed ? 'is-following' : '') . '" data-id="' . esc_attr($c->term_id); ?>" data-type="category" style="background: none; border: none; font-size: 0.6875rem; cursor: pointer; color: ' . ($is_c_followed ? '#B45309' : '#8B2500') . '; font-weight: 800;">' . ($is_c_followed ? '✓' : '+ Follow') . '</button>';
                            }
                            ?>
                            <span style="color: var(--text-muted);">·</span>
                            <span style="color: var(--text-muted);"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                        </div>
                        <span style="color: var(--text-muted); font-size: 0.625rem;">DISPATCH #<?php echo esc_html($p_id); ?></span>
                    </div>

                    <div style="display: grid; grid-template-columns: <?php echo has_post_thumbnail() ? '1fr 140px' : '1fr'; ?>; gap: 1.25rem; align-items: start;">
                        <div>
                            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.35rem; font-weight: 800; margin: 0 0 0.4rem; line-height: 1.3;">
                                <a href="<?php the_permalink(); ?>" style="color: var(--text-primary, #171513); text-decoration: none;">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.55;">
                                <?php echo wp_trim_words(get_the_excerpt(), 24); ?>
                            </p>
                        </div>

                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" style="display: block; width: 140px; height: 95px; overflow: hidden; border-radius: 2px; border: 1px solid rgba(0,0,0,0.12);">
                                <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Tags with 1-Click Follow -->
                    <?php
                    $post_tags = get_the_tags();
                    if ($post_tags) :
                    ?>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.35rem; align-items: center; margin-top: 0.25rem;">
                        <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; color: var(--text-muted);">TAGS:</span>
                        <?php
                        foreach (array_slice($post_tags, 0, 4) as $tg) {
                            $is_t_followed = in_array((int)$tg->term_id, array_map('intval', $followed_tags), true);
                            ?>
                            <span class="tag-follow-pill" style="font-size: 0.6875rem; padding: 0.15rem 0.4rem; background: var(--bg-card-subtle, #EFE9DE); border: 1px solid var(--border-color, #231F1D); border-radius: 2px;">
                                <a href="<?php echo esc_url(get_tag_link($tg->term_id)); ?>" style="color: var(--text-primary); text-decoration: none;">#<?php echo esc_html($tg->name); ?></a>
                                <button type="button" class="btn-follow-tag <?php echo $is_t_followed ? 'is-following' : ''; ?>" data-id="<?php echo esc_attr($tg->term_id); ?>" data-type="tag" style="background: none; border: none; font-size: 0.625rem; cursor: pointer; color: <?php echo $is_t_followed ? '#B45309' : '#8B2500'; ?>; font-weight: 800;">
                                    <?php echo $is_t_followed ? '✓' : '+'; ?>
                                </button>
                            </span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php endif; ?>

                    <!-- Action Bar -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.5rem; border-top: 1px dashed var(--border-color, #4A433B); font-size: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <button type="button" class="btn-live-like <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" style="display: flex; align-items: center; gap: 0.35rem; background: none; border: none; cursor: pointer; color: var(--text-secondary);">
                                <span>❤️</span> <span><?php echo esc_html($likes); ?></span>
                            </button>
                            <button type="button" class="btn-bookmark-action <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-id="<?php echo esc_attr($p_id); ?>" data-type="post" style="display: flex; align-items: center; gap: 0.35rem; background: none; border: none; cursor: pointer; color: var(--text-secondary);">
                                <span>🔖</span> <span><?php echo $is_bookmarked ? 'Saved' : 'Save Dossier'; ?></span>
                            </button>
                        </div>
                        <a href="<?php the_permalink(); ?>" style="color: #8B2500; font-weight: 700; text-decoration: none;">
                            Read Full Dossier →
                        </a>
                    </div>
                </article>

                <?php
                // Insert responsive article ad after story 3 in the feed
                if ($counter === 3 && function_exists('magazineafrique_render_article_ad_1')) {
                    echo magazineafrique_render_article_ad_1();
                }
            }
            echo '</div>';
            wp_reset_postdata();
        }
    }
    ?>

</main>

<?php get_footer(); ?>
