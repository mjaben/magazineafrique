<?php
/**
 * Magazine Afrique — Custom Template Tags & Editorial Helpers
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Calculate and display estimated reading time in minutes
 */
if (!function_exists('magazineafrique_reading_time')) {
    function magazineafrique_reading_time($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        $content = get_post_field('post_content', $post_id);
        $word_count = str_word_count(strip_tags($content));
        $minutes = ceil($word_count / 220);
        return max(1, $minutes) . ' min read';
    }
}

/**
 * Output formatted publication date
 */
if (!function_exists('magazineafrique_posted_on')) {
    function magazineafrique_posted_on() {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date('F j, Y'))
        );
        echo '<span class="posted-on">' . $time_string . '</span>';
    }
}

/**
 * Output primary category badge
 */
if (!function_exists('magazineafrique_category_badge')) {
    function magazineafrique_category_badge($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        $categories = get_the_category($post_id);
        if (!empty($categories)) {
            $cat = $categories[0];
            $is_gold = in_array(strtolower($cat->slug), array('economy', 'business', 'tech', 'exclusive', 'special-report'));
            $badge_class = $is_gold ? 'badge-category badge-gold' : 'badge-category';
            echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="' . esc_attr($badge_class) . '">' . esc_html($cat->name) . '</a>';
        }
    }
}

/**
 * Output author byline with avatar
 */
if (!function_exists('magazineafrique_posted_by')) {
    function magazineafrique_posted_by() {
        $author_id = get_the_author_meta('ID');
        $author_name = get_the_author();
        $author_url = get_author_posts_url($author_id);
        ?>
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <div style="width: 28px; height: 28px; border-radius: 9999px; overflow: hidden; background: #171513; display: flex; align-items: center; justify-content: center; color: #FFFFFF; font-size: 0.75rem; font-weight: 700;">
                <?php echo get_avatar($author_id, 28, '', '', array('class' => 'rounded-full')); ?>
            </div>
            <span style="font-size: 0.8125rem; color: #78716C;">By</span>
            <a href="<?php echo esc_url($author_url); ?>" style="font-size: 0.8125rem; font-weight: 700; color: #1C1917;">
                <?php echo esc_html($author_name); ?>
            </a>
        </div>
        <?php
    }
}

/**
 * Desktop Nav Menu Fallback with Rich Editorial Categories & Sub-menus
 */
if (!function_exists('magazineafrique_get_cat_url')) {
    function magazineafrique_get_cat_url($slug) {
        $cat = get_category_by_slug($slug);
        if ($cat) {
            return get_category_link($cat->term_id);
        }
        return home_url('/category/' . sanitize_title($slug) . '/');
    }
}

/**
 * Retrieve real WordPress top-level categories and their actual child sub-categories.
 * Zero hardcoded or hallucinated menu items — only categories that exist in WordPress.
 */
if (!function_exists('magazineafrique_get_real_nav_categories')) {
    function magazineafrique_get_real_nav_categories() {
        $excluded_slugs = array('uncategorized', 'featured', 'sponsored');
        $exclude_ids = array(1);
        foreach ($excluded_slugs as $ex_slug) {
            $ex_cat = get_category_by_slug($ex_slug);
            if ($ex_cat && !is_wp_error($ex_cat)) {
                $exclude_ids[] = (int) $ex_cat->term_id;
            }
        }
        $exclude_ids = array_unique($exclude_ids);

        $top_cats = get_categories(array(
            'parent'     => 0,
            'hide_empty' => true,
            'exclude'    => $exclude_ids,
            'orderby'    => 'name',
            'order'      => 'ASC',
        ));

        if (empty($top_cats) || is_wp_error($top_cats)) {
            return array();
        }

        // Order existing real categories cleanly to align with editorial desks
        $preferred_order = array(
            'africa',
            'international-news',
            'politics',
            'business',
            'economy',
            'lifestyle',
            'entertainment',
            'sports',
            'culture-history',
            'technology',
            'cryptocurrency',
            'series',
            'health',
            'how-tos',
            'biography',
            'education',
            'opinion',
            'editorial',
        );
        $order_map = array_flip($preferred_order);

        usort($top_cats, function ($a, $b) use ($order_map) {
            $pos_a = isset($order_map[$a->slug]) ? $order_map[$a->slug] : 999;
            $pos_b = isset($order_map[$b->slug]) ? $order_map[$b->slug] : 999;
            if ($pos_a === $pos_b) {
                return strcasecmp($a->name, $b->name);
            }
            return ($pos_a < $pos_b) ? -1 : 1;
        });

        $nav_tree = array();
        foreach ($top_cats as $cat) {
            if (in_array(strtolower($cat->slug), $excluded_slugs, true)) {
                continue;
            }

            $children = get_categories(array(
                'parent'     => $cat->term_id,
                'hide_empty' => true,
                'exclude'    => $exclude_ids,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ));

            if (is_wp_error($children)) {
                $children = array();
            }

            $nav_tree[] = array(
                'term'     => $cat,
                'children' => $children,
            );
        }

        return $nav_tree;
    }
}

/**
 * Desktop Nav Menu Fallback — calm, unclustered single-row primary desks + "More" dropdown for remaining real categories.
 * Strictly real WordPress categories & real sub-categories (zero hallucinated items).
 */
if (!function_exists('magazineafrique_render_editorial_nav')) {
    function magazineafrique_render_editorial_nav() {
        $nav_tree = magazineafrique_get_real_nav_categories();

        // Keep desktop bar calm and spacious: up to 8 primary desks + clean "More" menu for the rest
        $primary_slugs = array(
            'africa',
            'politics',
            'business',
            'lifestyle',
            'entertainment',
            'technology',
            'series',
            'sports',
        );
        $primary_order = array_flip($primary_slugs);

        $primary_items = array();
        $overflow_items = array();

        foreach ($nav_tree as $item) {
            $slug = $item['term']->slug;
            if (isset($primary_order[$slug])) {
                $primary_items[] = $item;
            } else {
                $overflow_items[] = $item;
            }
        }

        usort($primary_items, function ($a, $b) use ($primary_order) {
            return $primary_order[$a['term']->slug] - $primary_order[$b['term']->slug];
        });

        // If fewer than 6 matched primary slugs (e.g. different category setup), promote from overflow up to 8 total
        while (count($primary_items) < 8 && !empty($overflow_items)) {
            $primary_items[] = array_shift($overflow_items);
        }
        ?>
        <ul class="editorial-nav-list">
            <li class="menu-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
            <?php foreach ($primary_items as $item) :
                $cat = $item['term'];
                $children = $item['children'];
                $has_children = !empty($children);
            ?>
                <li class="menu-item<?php echo $has_children ? ' menu-item-has-children' : ''; ?>">
                    <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
                    <?php if ($has_children) : ?>
                        <ul class="sub-menu">
                            <?php foreach ($children as $child) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($child->term_id)); ?>"><?php echo esc_html($child->name); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>

            <?php if (!empty($overflow_items)) : ?>
                <li class="menu-item menu-item-has-children nav-item-more">
                    <a href="javascript:void(0)" role="button" aria-haspopup="true">More</a>
                    <ul class="sub-menu sub-menu-align-right">
                        <?php foreach ($overflow_items as $o_item) :
                            $ocat = $o_item['term'];
                        ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($ocat->term_id)); ?>"><?php echo esc_html($ocat->name); ?></a>
                            </li>
                            <?php if (!empty($o_item['children'])) : ?>
                                <?php foreach ($o_item['children'] as $ochild) : ?>
                                    <li class="sub-menu-child-item">
                                        <a href="<?php echo esc_url(get_category_link($ochild->term_id)); ?>">↳ <?php echo esc_html($ochild->name); ?></a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
        <?php
    }
}

/**
 * Side Drawer Navigation — strictly real WordPress categories & real sub-categories
 */
if (!function_exists('magazineafrique_render_drawer_nav')) {
    function magazineafrique_render_drawer_nav() {
        $nav_tree = magazineafrique_get_real_nav_categories();
        ?>
        <ul class="drawer-menu-links">
            <li>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="drawer-link-item">
                    <span class="drawer-item-bullet" aria-hidden="true"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-right: 4px;"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
                    Home
                </a>
            </li>
            <?php foreach ($nav_tree as $item) :
                $cat = $item['term'];
                $children = $item['children'];
                $has_children = !empty($children);
            ?>
                <li<?php echo $has_children ? ' class="drawer-has-submenu"' : ''; ?>>
                    <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="drawer-link-item">
                        <span class="drawer-item-bullet">·</span> <?php echo esc_html($cat->name); ?>
                    </a>
                    <?php if ($has_children) : ?>
                        <ul class="drawer-sub-links">
                            <?php foreach ($children as $child) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($child->term_id)); ?>"><?php echo esc_html($child->name); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }
}

/**
 * Safely query posts by slug(s) or fallback to latest posts
 */
if (!function_exists('magazineafrique_query_category_posts')) {
    function magazineafrique_query_category_posts($slugs, $count = 3, $exclude_ids = array()) {
        if (!is_array($slugs)) {
            $slugs = array($slugs);
        }
        $args = array(
            'category_name'       => implode(',', $slugs),
            'posts_per_page'      => $count,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
        );
        if (!empty($exclude_ids)) {
            $args['post__not_in'] = $exclude_ids;
        }
        $query = new WP_Query($args);
        // Fallback to latest posts if category is empty or does not have enough posts
        if (!$query->have_posts()) {
            $fallback_args = array(
                'posts_per_page'      => $count,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
            );
            if (!empty($exclude_ids)) {
                $fallback_args['post__not_in'] = $exclude_ids;
            }
            $query = new WP_Query($fallback_args);
        }
        return $query;
    }
}

/**
 * Desktop Nav Menu Fallback
 */
if (!function_exists('magazineafrique_desktop_menu_fallback')) {
    function magazineafrique_desktop_menu_fallback() {
        magazineafrique_render_editorial_nav();
    }
}

/**
 * Mobile Drawer Menu Fallback (Guarantees zero bullet points and no internal membership pages)
 */
if (!function_exists('magazineafrique_mobile_menu_fallback')) {
    function magazineafrique_mobile_menu_fallback() {
        echo '<ul class="mobile-menu-list">';
        echo '<li><a href="' . esc_url(home_url('/')) . '"><span>Home</span><span style="color: #78716C;">›</span></a></li>';
        $cats = get_categories(array('number' => 8, 'hide_empty' => false, 'orderby' => 'count', 'order' => 'DESC'));
        foreach ($cats as $cat) {
            echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '"><span>' . esc_html($cat->name) . '</span><span style="color: #78716C;">›</span></a></li>';
        }
        echo '<li><a href="' . esc_url(home_url('/subscribe/')) . '" style="color: #D97706;"><span>★ Club Prestige</span><span style="color: #D97706;">›</span></a></li>';
        echo '</ul>';
    }
}

/**
 * Retrieve Series category data: category object, subcategories, tags, and query posts
 */
if (!function_exists('magazineafrique_get_series_data')) {
    function magazineafrique_get_series_data($count = 4, $exclude_ids = array()) {
        // 1. Find or create 'Series' category
        $series_cat = get_category_by_slug('series');
        if (!$series_cat) {
            $series_cat = get_term_by('name', 'Series', 'category');
        }

        // If not found, attempt to register automatically
        if (!$series_cat && function_exists('wp_insert_term')) {
            $inserted = wp_insert_term('Series', 'category', array(
                'slug'        => 'series',
                'description' => 'Multi-part investigative series, serial dossiers, and long-form projects.'
            ));
            if (!is_wp_error($inserted) && isset($inserted['term_id'])) {
                $series_cat = get_category($inserted['term_id']);
            }
        }

        $subcategories = array();
        $query = null;

        if ($series_cat && !is_wp_error($series_cat)) {
            // 2. Fetch child subcategories under Series
            $subcategories = get_categories(array(
                'parent'     => $series_cat->term_id,
                'hide_empty' => false,
                'orderby'    => 'count',
                'order'      => 'DESC'
            ));

            // 3. Query posts in Series (includes child subcategories by default in WP)
            $args = array(
                'cat'                 => $series_cat->term_id,
                'posts_per_page'      => $count,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
            );
            if (!empty($exclude_ids)) {
                $args['post__not_in'] = $exclude_ids;
            }
            $query = new WP_Query($args);
        }

        // 4. Graceful fallback if Series has no published posts yet
        if (empty($query) || !$query->have_posts()) {
            $fallback_args = array(
                'posts_per_page'      => $count,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
            );
            $alt_cat = get_category_by_slug('investigations') ?: get_category_by_slug('business');
            if ($alt_cat) {
                $fallback_args['cat'] = $alt_cat->term_id;
            }
            if (!empty($exclude_ids)) {
                $fallback_args['post__not_in'] = $exclude_ids;
            }
            $query = new WP_Query($fallback_args);
        }

        return array(
            'category'      => $series_cat,
            'subcategories' => $subcategories,
            'query'         => $query,
        );
    }
}

