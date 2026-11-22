<?php
/**
 * Template Name: Reader Profile
 * Template Post Type: page
 *
 * @package MagazineAfrique
 */

get_header();

$current_user = wp_get_current_user();
$is_logged_in = is_user_logged_in();
$user_id      = $current_user->ID;

$first_name = $is_logged_in ? get_user_meta($user_id, 'first_name', true) : '';
$last_name  = $is_logged_in ? get_user_meta($user_id, 'last_name', true) : '';
$gender     = $is_logged_in ? get_user_meta($user_id, 'gender', true) : '';
$location   = function_exists('magazineafrique_get_reader_location') ? magazineafrique_get_reader_location() : 'Pan-African Hub';
$country    = $is_logged_in ? get_user_meta($user_id, 'reader_country', true) : '';
$city       = $is_logged_in ? get_user_meta($user_id, 'reader_city', true) : '';
?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 720px; margin: 0 auto; padding-top: 2rem;">

    <!-- Profile Header Card -->
    <div class="vintage-framed-box" style="background-color: #EFE9DE; border: 2px solid #231F1D; padding: 1.5rem; margin-bottom: 2rem; border-radius: 4px;">
        <div style="display: flex; flex-wrap: wrap; items-center; justify-content: space-between; gap: 1rem; border-bottom: 1px solid #DCD3C4; padding-bottom: 1rem; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 56px; height: 56px; border-radius: 50%; background-color: #171513; color: #F6F1E8; display: flex; align-items: center; justify-content: center; font-family: 'Playfair Display', Georgia, serif; font-size: 1.35rem; font-weight: 900; border: 2px solid #8B2500;">
                    <?php
                    $initials = strtoupper(substr($first_name ?: ($current_user->display_name ?: 'M'), 0, 1) . substr($last_name ?: 'A', 0, 1));
                    echo esc_html($initials);
                    ?>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.35rem; font-weight: 900; color: #171513; margin: 0;">
                            <?php echo esc_html(trim($first_name . ' ' . $last_name) ?: ($current_user->display_name ?: 'Pan-African Reader')); ?>
                        </h1>
                        <span style="font-size: 0.5625rem; font-family: 'JetBrains Mono', monospace; font-weight: 800; background-color: #8B2500; color: #FFFFFF; padding: 0.15rem 0.4rem; border-radius: 2px;">
                            READER
                        </span>
                    </div>
                    <div style="font-size: 0.75rem; color: #5C564E; font-family: 'JetBrains Mono', monospace; margin-top: 2px;">
                        @<?php echo esc_html($current_user->user_login ?: 'guest_reader'); ?> · Free Gazette Reader
                    </div>
                </div>
            </div>

            <!-- Location Badge -->
            <div style="display: flex; align-items: center; gap: 0.5rem; background: #FAF6F0; border: 1.5px solid #231F1D; padding: 0.4rem 0.75rem; border-radius: 3px; font-size: 0.75rem; font-weight: 700; color: #0B5128;">
                <span>📍</span>
                <span><?php echo esc_html($location); ?></span>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #5C564E; font-family: 'JetBrains Mono', monospace;">
            <span>News Personalization: <strong>ACTIVE</strong></span>
            <?php if (!$is_logged_in) : ?>
                <a href="<?php echo esc_url(home_url('/onboarding/')); ?>" style="color: #8B2500; font-weight: 800; text-decoration: underline;">Complete Enrollment →</a>
            <?php else : ?>
                <span style="color: #0B5128; font-weight: 800;">✓ Synced with Regional Wire</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Personalized Regional Dispatches Section -->
    <div style="margin-bottom: 2.5rem;">
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 2px solid #231F1D; padding-bottom: 0.4rem; margin-bottom: 1.25rem;">
            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.15rem; font-weight: 900; color: #171513; margin: 0; text-transform: uppercase;">
                Your Localized Intelligence Feed
            </h2>
            <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; color: #8B2500; font-weight: 700;">
                BASED ON <?php echo esc_html(strtoupper($location)); ?>
            </span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
            <?php
            $localized_query = new WP_Query(array('posts_per_page' => 3, 'ignore_sticky_posts' => 1));
            if ($localized_query->have_posts()) :
                while ($localized_query->have_posts()) : $localized_query->the_post();
            ?>
            <article class="vintage-grid-card" style="padding-bottom: 1rem; border-bottom: 1px solid #DCD3C4;">
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #8B2500; margin-bottom: 0.25rem;">
                    <span>REGIONAL DISPATCH</span>
                    <span><?php echo esc_html(get_the_date('M j')); ?></span>
                </div>
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.125rem; font-weight: 700; color: #171513; margin: 0 0 0.35rem; line-height: 1.3;">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <p style="font-size: 0.8125rem; color: #5C564E; margin: 0 0 0.5rem; line-height: 1.5;">
                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                </p>
                <div style="font-size: 0.6875rem; color: #8C847A; font-family: 'JetBrains Mono', monospace;">
                    By <?php the_author(); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?>
                </div>
            </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="vintage-framed-box" style="background-color: #F6F1E8; border: 2px solid #231F1D; padding: 1.5rem; border-radius: 4px;">
        <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.15rem; font-weight: 900; color: #171513; margin: 0 0 1rem; border-bottom: 1px solid #231F1D; padding-bottom: 0.5rem;">
            Update Reader Profile &amp; Location
        </h3>

        <?php if ($is_logged_in) : ?>
            <form id="magazineafrique-profile-form" style="display: flex; flex-direction: column; gap: 1rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.3rem;">First Name</label>
                        <input type="text" name="first_name" value="<?php echo esc_attr($first_name); ?>" class="circular-notice-input" style="width: 100%;" />
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.3rem;">Last Name</label>
                        <input type="text" name="last_name" value="<?php echo esc_attr($last_name); ?>" class="circular-notice-input" style="width: 100%;" />
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.3rem;">Gender</label>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; font-size: 0.75rem;">
                        <label style="border: 1px solid #231F1D; background: #FFFFFF; padding: 0.4rem; display: flex; align-items: center; justify-content: center; gap: 0.3rem; cursor: pointer;">
                            <input type="radio" name="gender" value="Male" <?php checked($gender, 'Male'); ?> style="accent-color: #8B2500;" /> Male
                        </label>
                        <label style="border: 1px solid #231F1D; background: #FFFFFF; padding: 0.4rem; display: flex; align-items: center; justify-content: center; gap: 0.3rem; cursor: pointer;">
                            <input type="radio" name="gender" value="Female" <?php checked($gender, 'Female'); ?> style="accent-color: #8B2500;" /> Female
                        </label>
                        <label style="border: 1px solid #231F1D; background: #FFFFFF; padding: 0.4rem; display: flex; align-items: center; justify-content: center; gap: 0.3rem; cursor: pointer;">
                            <input type="radio" name="gender" value="Prefer not to say" <?php checked($gender, 'Prefer not to say'); ?> style="accent-color: #8B2500;" /> Other
                        </label>
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.3rem;">Active Location</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="text" id="reader-location-input" name="location" value="<?php echo esc_attr($location); ?>" class="circular-notice-input" style="flex: 1;" />
                        <input type="hidden" id="reader-country-input" name="country" value="<?php echo esc_attr($country); ?>" />
                        <input type="hidden" id="reader-city-input" name="city" value="<?php echo esc_attr($city); ?>" />
                        <button type="button" id="btn-trigger-detect" class="circular-notice-btn" style="padding: 0.45rem 0.75rem; font-size: 0.6875rem;">
                            🎯 Re-Detect
                        </button>
                    </div>
                    <div id="location-detect-status" style="font-size: 0.6875rem; font-family: 'JetBrains Mono', monospace; color: #0B5128; margin-top: 0.35rem;"></div>
                </div>

                <div style="margin-top: 0.5rem;">
                    <button type="submit" class="circular-notice-btn" style="width: 100%; padding: 0.75rem; font-size: 0.8125rem;">
                        Save Profile Changes
                    </button>
                </div>
                <div class="form-feedback" style="text-align: center; font-size: 0.8125rem;"></div>
            </form>
        <?php else : ?>
            <p style="font-size: 0.8125rem; color: #5C564E; margin-bottom: 1rem;">
                You are currently viewing as a guest reader. Enroll to manage your preferences and sync across devices.
            </p>
            <a href="<?php echo esc_url(home_url('/onboarding/')); ?>" class="circular-notice-btn" style="display: block; text-align: center; text-decoration: none; padding: 0.75rem;">
                Enroll Now as Reader →
            </a>
        <?php endif; ?>
    </div>

</main>

<script src="<?php echo esc_url(get_theme_file_uri('/assets/js/onboarding.js')); ?>"></script>

<?php get_footer(); ?>
