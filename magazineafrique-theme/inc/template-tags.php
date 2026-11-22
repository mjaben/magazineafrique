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
            <div style="width: 28px; height: 28px; border-radius: 9999px; overflow: hidden; background: #0B5128; display: flex; align-items: center; justify-content: center; color: #FFFFFF; font-size: 0.75rem; font-weight: 700;">
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
 * Desktop Nav Menu Fallback
 */
if (!function_exists('magazineafrique_desktop_menu_fallback')) {
    function magazineafrique_desktop_menu_fallback() {
        echo '<ul class="nav-links">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
        $cats = get_categories(array('number' => 7, 'hide_empty' => false, 'orderby' => 'count', 'order' => 'DESC'));
        foreach ($cats as $cat) {
            echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
        }
        echo '<li><a href="' . esc_url(home_url('/subscribe/')) . '" style="color: #D97706;">★ Club Prestige</a></li>';
        echo '</ul>';
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
