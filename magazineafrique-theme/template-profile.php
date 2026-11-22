<?php
/**
 * Template Name: Reader Profile & Dashboard
 * Template Post Type: page
 *
 * @package MagazineAfrique
 */

get_header();

$current_user = wp_get_current_user();
$is_logged_in = is_user_logged_in();
$user_id      = $current_user->ID;

$first_name   = $is_logged_in ? get_user_meta($user_id, 'first_name', true) : '';
$last_name    = $is_logged_in ? get_user_meta($user_id, 'last_name', true) : '';
$gender       = $is_logged_in ? get_user_meta($user_id, 'gender', true) : '';
$bio          = $is_logged_in ? get_user_meta($user_id, 'reader_bio', true) : '';
$location     = function_exists('magazineafrique_get_reader_location') ? magazineafrique_get_reader_location() : 'Pan-African Hub';
$country      = $is_logged_in ? get_user_meta($user_id, 'reader_country', true) : '';
$city         = $is_logged_in ? get_user_meta($user_id, 'reader_city', true) : '';
$avatar_url   = function_exists('magazineafrique_get_avatar_url') ? magazineafrique_get_avatar_url($user_id) : '';

$bookmarked_ids = function_exists('magazineafrique_get_user_items') ? magazineafrique_get_user_items('magazineafrique_bookmarks', 'magafrique_bookmarks') : array();
$followed_cats  = function_exists('magazineafrique_get_user_items') ? magazineafrique_get_user_items('magazineafrique_followed_cats', 'magafrique_followed_cats') : array();
$followed_tags  = function_exists('magazineafrique_get_user_items') ? magazineafrique_get_user_items('magazineafrique_followed_tags', 'magafrique_followed_tags') : array();
?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 860px; margin: 0 auto; padding-top: 2rem;">

    <!-- 1. Broadsheet Reader Identity Header -->
    <div class="vintage-framed-box" style="background-color: #EFE9DE; border: 2px solid #231F1D; padding: 1.5rem; margin-bottom: 2rem; border-radius: 4px;">
        <div style="display: flex; flex-wrap: wrap; items-center; justify-content: space-between; gap: 1.25rem;">
            
            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <!-- Avatar with Live Preview & Upload Trigger -->
                <div style="position: relative; width: 72px; height: 72px;">
                    <img id="profile-avatar-img" src="<?php echo esc_url($avatar_url); ?>" alt="Reader Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2.5px solid #231F1D; background-color: #171513;" />
                    <label for="avatar-file-input" style="position: absolute; bottom: -4px; right: -4px; background: #8B2500; color: #FFFFFF; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; cursor: pointer; border: 2px solid #EFE9DE;" title="Upload custom avatar">
                        📷
                    </label>
                    <input type="file" id="avatar-file-input" accept="image/*" style="display: none;" />
                </div>

                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.2rem;">
                        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.5rem; font-weight: 900; color: #171513; margin: 0;">
                            <?php echo esc_html(trim($first_name . ' ' . $last_name) ?: ($current_user->display_name ?: 'Pan-African Reader')); ?>
                        </h1>
                        <span style="font-size: 0.5625rem; font-family: 'JetBrains Mono', monospace; font-weight: 800; background-color: #8B2500; color: #FFFFFF; padding: 0.15rem 0.45rem; border-radius: 2px;">
                            <?php echo function_exists('magazineafrique_user_has_active_subscription') && magazineafrique_user_has_active_subscription() ? '★ CLUB PRESTIGE' : 'GAZETTE READER'; ?>
                        </span>
                    </div>

                    <div style="font-size: 0.75rem; color: #5C564E; font-family: 'JetBrains Mono', monospace;">
                        @<?php echo esc_html($current_user->user_login ?: 'guest_reader'); ?> · Member Since <?php echo esc_html(date('Y')); ?>
                    </div>

                    <?php if (!empty($bio)) : ?>
                        <p style="font-size: 0.8125rem; color: #38332C; margin: 0.35rem 0 0; line-height: 1.4; font-family: 'Newsreader', Georgia, serif; font-style: italic;">
                            "<?php echo esc_html($bio); ?>"
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Location & Stats Badge -->
            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.4rem;">
                <div style="display: flex; align-items: center; gap: 0.4rem; background: #FAF6F0; border: 1.5px solid #231F1D; padding: 0.35rem 0.75rem; border-radius: 3px; font-size: 0.75rem; font-weight: 700; color: #0B5128;">
                    <span>📍</span>
                    <span><?php echo esc_html($location); ?></span>
                </div>
                <div style="font-size: 0.6875rem; font-family: 'JetBrains Mono', monospace; color: #8C847A;">
                    <span>Saved: <strong class="text-[#171513]"><?php echo count($bookmarked_ids); ?></strong></span> · 
                    <span>Following: <strong class="text-[#171513]"><?php echo count($followed_cats) + count($followed_tags); ?></strong></span>
                </div>
            </div>

        </div>

        <div id="avatar-upload-feedback" style="margin-top: 0.5rem; font-size: 0.75rem; font-family: 'JetBrains Mono', monospace;"></div>
    </div>

    <!-- 2. Interactive Broadsheet Dashboard Tabs -->
    <div style="border-bottom: 2px solid #231F1D; margin-bottom: 2rem;">
        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em;">
            <button onclick="switchProfileTab('following')" id="tab-btn-following" class="profile-tab-btn" style="padding: 0.65rem 1rem; border: 1.5px solid #231F1D; border-bottom: none; background: #8B2500; color: #FFFFFF; border-radius: 3px 3px 0 0; cursor: pointer;">
                1. Following Wire (<?php echo count($followed_cats); ?>)
            </button>
            <button onclick="switchProfileTab('bookmarks')" id="tab-btn-bookmarks" class="profile-tab-btn" style="padding: 0.65rem 1rem; border: 1.5px solid #231F1D; border-bottom: none; background: #EFE9DE; color: #171513; border-radius: 3px 3px 0 0; cursor: pointer;">
                2. Saved Dossiers (<?php echo count($bookmarked_ids); ?>)
            </button>
            <button onclick="switchProfileTab('regional')" id="tab-btn-regional" class="profile-tab-btn" style="padding: 0.65rem 1rem; border: 1.5px solid #231F1D; border-bottom: none; background: #EFE9DE; color: #171513; border-radius: 3px 3px 0 0; cursor: pointer;">
                3. Localized Wire
            </button>
            <button onclick="switchProfileTab('settings')" id="tab-btn-settings" class="profile-tab-btn" style="padding: 0.65rem 1rem; border: 1.5px solid #231F1D; border-bottom: none; background: #EFE9DE; color: #171513; border-radius: 3px 3px 0 0; cursor: pointer;">
                4. Edit Profile &amp; Settings
            </button>
        </div>
    </div>

    <!-- =========================================================================
         TAB 1: FOLLOWING WIRE (Stories strictly from followed categories & tags)
         ========================================================================= -->
    <div id="tab-content-following" class="profile-tab-pane">
        
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 1.5px solid #231F1D; padding-bottom: 0.4rem; margin-bottom: 1.5rem;">
            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 900; color: #171513; margin: 0;">
                Your Followed Categories &amp; Topics Wire
            </h2>
            <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; color: #8B2500; font-weight: 700;">
                PERSONALIZED DISPATCHES
            </span>
        </div>

        <?php
        $followed_query = function_exists('magazineafrique_get_followed_wire_query') ? magazineafrique_get_followed_wire_query(6) : new WP_Query(array('post__in' => array(0)));
        if ($followed_query->have_posts()) :
        ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <?php while ($followed_query->have_posts()) : $followed_query->the_post(); ?>
                    <article class="vintage-grid-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="vintage-card-thumb-link">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'vintage-card-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="vintage-card-kicker"><?php magazineafrique_category_badge(); ?></div>
                        <h3 class="vintage-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="vintage-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                        <div class="vintage-card-date"><?php echo esc_html(get_the_date('M j, Y')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?></div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <!-- Empty State with 1-Click Suggested Categories to Follow -->
            <div class="vintage-framed-box" style="background-color: #F6F1E8; border: 2px dashed #231F1D; padding: 2rem 1.5rem; text-align: center; border-radius: 4px;">
                <div style="font-size: 1.75rem; margin-bottom: 0.5rem;">✦</div>
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 900; color: #171513; margin: 0 0 0.5rem;">
                    You are not following any categories yet
                </h3>
                <p style="font-size: 0.8125rem; color: #5C564E; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                    Follow our lead editorial sections below to curate your custom intelligence wire.
                </p>

                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.75rem;">
                    <?php
                    $all_cats = get_categories(array('number' => 6, 'hide_empty' => false, 'exclude' => array(1)));
                    foreach ($all_cats as $cat) :
                        if (strtolower($cat->slug) === 'uncategorized') continue;
                        $is_followed = in_array((int)$cat->term_id, $followed_cats, true);
                    ?>
                        <button type="button" class="btn-toggle-follow circular-notice-btn" data-id="<?php echo esc_attr($cat->term_id); ?>" data-type="category" style="background-color: <?php echo $is_followed ? '#0B5128' : '#231F1D'; ?>; padding: 0.4rem 0.85rem; font-size: 0.6875rem;">
                            <?php echo $is_followed ? '✓ Following ' . esc_html($cat->name) : '+ Follow ' . esc_html($cat->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- =========================================================================
         TAB 2: SAVED DOSSIERS (BOOKMARKS)
         ========================================================================= -->
    <div id="tab-content-bookmarks" class="profile-tab-pane" style="display: none;">
        
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 1.5px solid #231F1D; padding-bottom: 0.4rem; margin-bottom: 1.5rem;">
            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 900; color: #171513; margin: 0;">
                Your Bookmarked Dispatches
            </h2>
            <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; color: #8B2500; font-weight: 700;">
                SAVED ARCHIVE
            </span>
        </div>

        <?php if (!empty($bookmarked_ids)) :
            $bm_query = new WP_Query(array('post__in' => $bookmarked_ids, 'posts_per_page' => 12, 'ignore_sticky_posts' => 1));
            if ($bm_query->have_posts()) :
        ?>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <?php while ($bm_query->have_posts()) : $bm_query->the_post(); ?>
                    <article class="vintage-grid-card" style="padding-bottom: 1rem; border-bottom: 1px solid #DCD3C4; display: flex; flex-direction: row; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                        <div style="flex: 1;">
                            <div class="vintage-card-kicker"><?php magazineafrique_category_badge(); ?></div>
                            <h3 class="vintage-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="vintage-card-date"><?php echo esc_html(get_the_date('M j, Y')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?></div>
                        </div>
                        <button type="button" class="btn-toggle-bookmark" data-id="<?php the_ID(); ?>" data-type="post" style="background: none; border: 1px solid #DCD3C4; border-radius: 3px; padding: 0.35rem 0.65rem; font-size: 0.6875rem; color: #8B2500; font-weight: bold; cursor: pointer;">
                            ✕ Remove
                        </button>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <p style="color: #8C847A; font-size: 0.875rem; text-align: center; padding: 2rem;">No bookmarks saved yet.</p>
        <?php endif; else : ?>
            <div class="vintage-framed-box" style="background-color: #F6F1E8; border: 2px dashed #231F1D; padding: 2rem 1.5rem; text-align: center; border-radius: 4px;">
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 900; color: #171513; margin: 0 0 0.5rem;">
                    No Saved Dispatches
                </h3>
                <p style="font-size: 0.8125rem; color: #5C564E; margin: 0 auto 1.5rem; max-width: 420px; line-height: 1.5;">
                    Tap the 🔖 bookmark icon on any investigative dispatch to store it in your reading archive.
                </p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="circular-notice-btn" style="text-decoration: none; padding: 0.65rem 1.25rem;">
                    Browse Front Page Gazette →
                </a>
            </div>
        <?php endif; ?>

    </div>

    <!-- =========================================================================
         TAB 3: LOCALIZED REGIONAL WIRE (Auto-Location GPS)
         ========================================================================= -->
    <div id="tab-content-regional" class="profile-tab-pane" style="display: none;">
        
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 1.5px solid #231F1D; padding-bottom: 0.4rem; margin-bottom: 1.5rem;">
            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 900; color: #171513; margin: 0;">
                Localized Regional Wire
            </h2>
            <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; color: #0B5128; font-weight: 700;">
                ACTIVE: <?php echo esc_html(strtoupper($location)); ?>
            </span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
            <?php
            $regional_q = new WP_Query(array('posts_per_page' => 4, 'ignore_sticky_posts' => 1));
            if ($regional_q->have_posts()) :
                while ($regional_q->have_posts()) : $regional_q->the_post();
            ?>
            <article class="vintage-grid-card">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="vintage-card-thumb-link">
                        <?php the_post_thumbnail('magazine-card', array('class' => 'vintage-card-img')); ?>
                    </a>
                <?php endif; ?>
                <div class="vintage-card-kicker"><?php magazineafrique_category_badge(); ?></div>
                <h3 class="vintage-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p class="vintage-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                <div class="vintage-card-date"><?php echo esc_html(get_the_date('M j, Y')); ?> · <?php echo esc_html(magazineafrique_reading_time()); ?></div>
            </article>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>

    </div>

    <!-- =========================================================================
         TAB 4: EDIT PROFILE & AVATAR & PASSWORD SETTINGS
         ========================================================================= -->
    <div id="tab-content-settings" class="profile-tab-pane" style="display: none;">
        
        <div class="vintage-framed-box" style="background-color: #F6F1E8; border: 2px solid #231F1D; padding: 1.5rem; border-radius: 4px;">
            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.35rem; font-weight: 900; color: #171513; margin: 0 0 1rem; border-bottom: 1.5px solid #231F1D; padding-bottom: 0.5rem;">
                Edit Reader Profile
            </h2>

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

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.3rem;">Email Address</label>
                            <input type="email" name="email" value="<?php echo esc_attr($current_user->user_email); ?>" class="circular-notice-input" style="width: 100%;" />
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.3rem;">Display Name</label>
                            <input type="text" name="display_name" value="<?php echo esc_attr($current_user->display_name); ?>" class="circular-notice-input" style="width: 100%;" />
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.3rem;">Biography / Reader Focus</label>
                        <textarea name="bio" rows="2" class="circular-notice-input" style="width: 100%; font-family: 'Plus Jakarta Sans', sans-serif;"><?php echo esc_textarea($bio); ?></textarea>
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

                    <!-- Auto-Location -->
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.3rem;">Active Location (Auto-Location)</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" id="reader-location-input" name="location" value="<?php echo esc_attr($location); ?>" class="circular-notice-input" style="flex: 1; font-weight: 600;" />
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

                <!-- Change Password Form -->
                <div style="border-top: 1.5px solid #231F1D; margin-top: 2rem; padding-top: 1.5rem;">
                    <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.15rem; font-weight: 900; color: #171513; margin: 0 0 1rem;">
                        Security &amp; Password
                    </h3>
                    <form id="magazineafrique-password-form" style="display: flex; flex-direction: column; gap: 0.85rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                        <div>
                            <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.25rem;">Current Password</label>
                            <input type="password" name="current_password" required class="circular-notice-input" style="width: 100%;" />
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.25rem;">New Password</label>
                                <input type="password" name="new_password" required minlength="8" class="circular-notice-input" style="width: 100%;" />
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; color: #171513; margin-bottom: 0.25rem;">Confirm New Password</label>
                                <input type="password" name="confirm_password" required minlength="8" class="circular-notice-input" style="width: 100%;" />
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="circular-notice-btn" style="background-color: #231F1D; padding: 0.65rem 1.25rem; font-size: 0.75rem;">
                                Update Password
                            </button>
                        </div>
                        <div class="password-feedback" style="font-size: 0.75rem;"></div>
                    </form>
                </div>

            <?php else : ?>
                <div style="text-align: center; padding: 1.5rem 0;">
                    <p style="font-size: 0.875rem; color: #5C564E; margin-bottom: 1rem;">
                        Sign in or enroll to manage your preferences and sync your followed topics across devices.
                    </p>
                    <a href="<?php echo esc_url(home_url('/onboarding/')); ?>" class="circular-notice-btn" style="text-decoration: none; padding: 0.75rem 1.5rem;">
                        Enroll Now as Reader →
                    </a>
                </div>
            <?php endif; ?>

        </div>

    </div>

</main>

<script src="<?php echo esc_url(get_theme_file_uri('/assets/js/reader-engine.js')); ?>"></script>
<script>
function switchProfileTab(tab) {
    document.querySelectorAll('.profile-tab-pane').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.profile-tab-btn').forEach(btn => {
        btn.style.backgroundColor = '#EFE9DE';
        btn.style.color = '#171513';
    });

    const activePane = document.getElementById('tab-content-' + tab);
    const activeBtn = document.getElementById('tab-btn-' + tab);

    if (activePane) activePane.style.display = 'block';
    if (activeBtn) {
        activeBtn.style.backgroundColor = '#8B2500';
        activeBtn.style.color = '#FFFFFF';
    }
}
</script>

<?php get_footer(); ?>
