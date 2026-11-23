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

if (!function_exists('magazineafrique_render_editorial_nav')) {
    function magazineafrique_render_editorial_nav() {
        ?>
        <ul class="editorial-nav-list">
            <li class="menu-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
            
            <!-- 1. News & Geopolitics (with sub-menu) -->
            <li class="menu-item menu-item-has-children">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('international-news')); ?>">News</a>
                <ul class="sub-menu">
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('international-news')); ?>">International News</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('politics')); ?>">Politics</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('africa')); ?>">Africa Wire</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('better-nigeria')); ?>">Better Nigeria</a></li>
                </ul>
            </li>

            <!-- 2. Business & Economy (with sub-menu) -->
            <li class="menu-item menu-item-has-children">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('business')); ?>">Business</a>
                <ul class="sub-menu">
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('business')); ?>">Markets &amp; Enterprise</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('economy')); ?>">Economy &amp; AfCFTA</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('fintech')); ?>">Fintech &amp; Banking</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('cryptocurrency')); ?>">Crypto &amp; Digital Assets</a></li>
                </ul>
            </li>

            <!-- 3. Technology (with sub-menu) -->
            <li class="menu-item menu-item-has-children">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('technology')); ?>">Technology</a>
                <ul class="sub-menu">
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('technology')); ?>">Tech Innovations &amp; AI</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('fintech')); ?>">Fintech Leapfrogging</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('cryptocurrency')); ?>">Web3 &amp; Blockchain</a></li>
                </ul>
            </li>

            <!-- 4. Lifestyle & Living (Pure African Luxury, Fashion, Design & Travel - NOT News, NOT Health, NOT How-To's) -->
            <li class="menu-item menu-item-has-children">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>">Lifestyle</a>
                <ul class="sub-menu">
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>">Living &amp; Style</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>">African Haute Couture</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>">Travel &amp; Escapes</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('lifestyle')); ?>">Design &amp; Architecture</a></li>
                </ul>
            </li>

            <!-- 5. Health & Longevity (Distinct from Lifestyle) -->
            <li class="menu-item menu-item-has-children">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>">Health</a>
                <ul class="sub-menu">
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>">Public Health &amp; Research</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>">Wellness &amp; Longevity</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('health')); ?>">Botanicals &amp; Nutrition</a></li>
                </ul>
            </li>

            <!-- 6. How-To's & Practical Guides (Distinct from Lifestyle) -->
            <li class="menu-item">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('how-tos')); ?>">How-To's</a>
            </li>

            <!-- 7. Entertainment & Culture (with sub-menu) -->
            <li class="menu-item menu-item-has-children">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('entertainment')); ?>">Entertainment</a>
                <ul class="sub-menu">
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('entertainment')); ?>">Music &amp; Cinema</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('celebrities')); ?>">Celebrities &amp; Icons</a></li>
                </ul>
            </li>

            <!-- 8. Sports -->
            <li class="menu-item">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('sports')); ?>">Sports</a>
            </li>

            <!-- 9. Education -->
            <li class="menu-item">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('education')); ?>">Education</a>
            </li>

            <!-- 10. Biography -->
            <li class="menu-item">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('biography')); ?>">Biography</a>
            </li>

            <!-- 11. Culture & History -->
            <li class="menu-item">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('culture-history')); ?>">History &amp; Archive</a>
            </li>

            <!-- 12. Opinion & Commentary (with sub-menu) -->
            <li class="menu-item menu-item-has-children">
                <a href="<?php echo esc_url(magazineafrique_get_cat_url('opinion')); ?>">Opinion</a>
                <ul class="sub-menu">
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('opinion')); ?>">The Gazette Chronicle</a></li>
                    <li><a href="<?php echo esc_url(magazineafrique_get_cat_url('editorial')); ?>">Editorial Board</a></li>
                </ul>
            </li>

            <!-- 13. Club Prestige -->
            <li class="nav-item-prestige"><a href="<?php echo esc_url(home_url('/subscribe/')); ?>">Club Prestige</a></li>
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

