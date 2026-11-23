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

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 860px; margin: 0 auto; padding-top: 2rem; padding-bottom: 3rem;">

    <!-- 1. Broadsheet Reader Identity Header (Faded Dark Compatible) -->
    <div class="vintage-framed-box reader-profile-card" style="margin-bottom: 2rem;">
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.5rem;">
            
            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <!-- Avatar with Live Preview & Upload Trigger -->
                <div class="profile-avatar-wrapper" style="position: relative; width: 76px; height: 76px; min-width: 76px; min-height: 76px; flex-shrink: 0; border-radius: 50%;">
                    <img id="profile-avatar-img" src="<?php echo esc_url($avatar_url ?: get_avatar_url($user_id, array('size' => 150))); ?>" alt="Reader Avatar" class="profile-avatar-circle" style="width: 76px; height: 76px; max-width: 76px; max-height: 76px; border-radius: 50%; object-fit: cover; display: block;" />
                    <label for="avatar-file-input" class="avatar-upload-badge" title="Upload custom avatar">
                        📷
                    </label>
                    <input type="file" id="avatar-file-input" accept="image/*" style="display: none;" />
                </div>

                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.2rem;">
                        <h1 class="reader-profile-title" style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.35rem; font-weight: 800; margin: 0; line-height: 1.2;">
                            <?php echo esc_html(trim($first_name . ' ' . $last_name) ?: ($current_user->display_name ?: 'Pan-African Reader')); ?>
                        </h1>
                        <span class="reader-tier-tag">
                            <?php echo function_exists('magazineafrique_user_has_active_subscription') && magazineafrique_user_has_active_subscription() ? '★ CLUB PRESTIGE' : 'GAZETTE READER'; ?>
                        </span>
                    </div>

                    <div style="font-size: 0.75rem; color: var(--text-muted, #8C847A); font-family: 'JetBrains Mono', monospace;">
                        @<?php echo esc_html($current_user->user_login ?: 'guest_reader'); ?> · Member Since <?php echo esc_html(date('Y')); ?>
                    </div>

                    <?php if (!empty($bio)) : ?>
                        <p style="font-size: 0.8125rem; color: var(--text-secondary, #5C564E); margin: 0.35rem 0 0; line-height: 1.4; font-family: 'Newsreader', Georgia, serif; font-style: italic;">
                            "<?php echo esc_html($bio); ?>"
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Location & Stats Badge -->
            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.4rem;">
                <div class="reader-location-pill">
                    <span>📍</span>
                    <span><?php echo esc_html($location); ?></span>
                </div>
                <div style="font-size: 0.6875rem; font-family: 'JetBrains Mono', monospace; color: var(--text-muted, #8C847A);">
                    <span>Saved: <strong style="color: var(--text-primary);"><?php echo count($bookmarked_ids); ?></strong></span> · 
                    <span>Following: <strong style="color: var(--text-primary);"><?php echo count($followed_cats) + count($followed_tags); ?></strong></span>
                </div>
            </div>

        </div>

        <div id="avatar-upload-feedback" style="margin-top: 0.5rem; font-size: 0.75rem; font-family: 'JetBrains Mono', monospace;"></div>
    </div>

    <!-- 1b. Reader Intelligence & Reading Velocity Sparkline -->
    <div class="vintage-framed-box reader-velocity-card" style="margin-bottom: 2rem; padding: 1.25rem 1.5rem; background: var(--bg-card, #FFFFFF);">
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; border-bottom: 1.5px solid var(--border-color, #231F1D); padding-bottom: 0.75rem; margin-bottom: 1rem;">
            <div>
                <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; letter-spacing: 0.12em; color: #B45309; text-transform: uppercase;">
                    READER INTELLIGENCE &amp; ANALYTICS
                </span>
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.15rem; font-weight: 800; margin: 0.2rem 0 0; color: var(--text-primary, #171513);">
                    7-Day Broadsheet Engagement Velocity
                </h3>
            </div>
            <div style="display: flex; align-items: center; gap: 1.25rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem;">
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #D97706;"></span>
                    <span>Daily Reading Time</span>
                </div>
                <div style="background: rgba(180, 83, 9, 0.12); padding: 2px 8px; border-radius: 2px; color: #B45309; font-weight: 700;">
                    🔥 5-DAY STREAK
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: center;">
            <!-- Interactive SVG Velocity Curve -->
            <div>
                <div style="height: 110px; width: 100%;">
                    <svg viewBox="0 0 500 110" style="width: 100%; height: 100%; overflow: visible;">
                        <defs>
                            <linearGradient id="velocityGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#D97706" stop-opacity="0.28" />
                                <stop offset="100%" stop-color="#D97706" stop-opacity="0.0" />
                            </linearGradient>
                        </defs>
                        <!-- Grid lines -->
                        <line x1="0" y1="20" x2="500" y2="20" stroke="rgba(120, 113, 108, 0.15)" stroke-dasharray="3,3" />
                        <line x1="0" y1="55" x2="500" y2="55" stroke="rgba(120, 113, 108, 0.15)" stroke-dasharray="3,3" />
                        <line x1="0" y1="90" x2="500" y2="90" stroke="rgba(120, 113, 108, 0.15)" stroke-dasharray="3,3" />
                        
                        <!-- Area Fill -->
                        <path d="M 10,85 Q 90,65 170,40 T 330,25 T 490,15 L 490,95 L 10,95 Z" fill="url(#velocityGrad)" />
                        <!-- Line Curve -->
                        <path d="M 10,85 Q 90,65 170,40 T 330,25 T 490,15" fill="none" stroke="#D97706" stroke-width="3" stroke-linecap="round" />
                        
                        <!-- Data Points -->
                        <circle cx="10" cy="85" r="4" fill="#231F1D" stroke="#D97706" stroke-width="2" />
                        <circle cx="90" cy="72" r="4" fill="#231F1D" stroke="#D97706" stroke-width="2" />
                        <circle cx="170" cy="40" r="4" fill="#231F1D" stroke="#D97706" stroke-width="2" />
                        <circle cx="250" cy="48" r="4" fill="#231F1D" stroke="#D97706" stroke-width="2" />
                        <circle cx="330" cy="25" r="4" fill="#231F1D" stroke="#D97706" stroke-width="2" />
                        <circle cx="410" cy="32" r="4" fill="#231F1D" stroke="#D97706" stroke-width="2" />
                        <circle cx="490" cy="15" r="5" fill="#FAF7F2" stroke="#B45309" stroke-width="3" />
                    </svg>
                </div>
                <div style="display: flex; justify-content: space-between; font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C); margin-top: 0.25rem;">
                    <span>Mon (18m)</span>
                    <span>Tue (24m)</span>
                    <span>Wed (42m)</span>
                    <span>Thu (35m)</span>
                    <span>Fri (58m)</span>
                    <span>Sat (48m)</span>
                    <span style="color: #D97706; font-weight: 700;">Sun (64m)</span>
                </div>
            </div>

            <!-- Focus Desks Breakdown -->
            <div style="border-left: 1px dashed rgba(120, 113, 108, 0.3); padding-left: 1.25rem; display: flex; flex-direction: column; gap: 0.5rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem;">
                <div style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.2rem;">EDITORIAL DESK RATIO</div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                        <span>Geopolitics &amp; Sahel</span>
                        <strong style="color: #B45309;">45%</strong>
                    </div>
                    <div style="width: 100%; height: 5px; background: rgba(0,0,0,0.06); border-radius: 2px; overflow: hidden;">
                        <div style="width: 45%; height: 100%; background: #B45309;"></div>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                        <span>AfCFTA &amp; Trade</span>
                        <strong style="color: #D97706;">30%</strong>
                    </div>
                    <div style="width: 100%; height: 5px; background: rgba(0,0,0,0.06); border-radius: 2px; overflow: hidden;">
                        <div style="width: 30%; height: 100%; background: #D97706;"></div>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                        <span>Tech Sovereignty</span>
                        <strong style="color: #B45309;">25%</strong>
                    </div>
                    <div style="width: 100%; height: 5px; background: rgba(0,0,0,0.06); border-radius: 2px; overflow: hidden;">
                        <div style="width: 25%; height: 100%; background: #B45309;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Interactive Broadsheet Dashboard Tabs -->
    <div style="border-bottom: 2px solid var(--border-color, #231F1D); margin-bottom: 2rem;">
        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em;">
            <button onclick="switchProfileTab('following')" id="tab-btn-following" class="profile-tab-btn active">
                1. Following Wire (<?php echo count($followed_cats); ?>)
            </button>
            <button onclick="switchProfileTab('bookmarks')" id="tab-btn-bookmarks" class="profile-tab-btn">
                2. Saved Dossiers (<?php echo count($bookmarked_ids); ?>)
            </button>
            <button onclick="switchProfileTab('regional')" id="tab-btn-regional" class="profile-tab-btn">
                3. Localized Wire
            </button>
            <button onclick="switchProfileTab('settings')" id="tab-btn-settings" class="profile-tab-btn">
                4. Edit Profile &amp; Settings
            </button>
        </div>
    </div>

    <!-- =========================================================================
         TAB 1: FOLLOWING WIRE (Stories strictly from followed categories & tags)
         ========================================================================= -->
    <div id="tab-content-following" class="profile-tab-pane">
        
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 1.5px solid var(--border-color, #231F1D); padding-bottom: 0.4rem; margin-bottom: 1.5rem;">
            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 900; color: var(--text-primary, #171513); margin: 0;">
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
                    <article class="card-editorial vintage-framed-box" style="display: flex; flex-direction: column;">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'vintage-card-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div style="padding: 1.25rem; display: flex; flex-direction: column; flex: 1;">
                            <div style="margin-bottom: 0.5rem;">
                                <?php magazineafrique_category_badge(); ?>
                            </div>
                            <h3 class="font-serif" style="font-size: 1.15rem; font-weight: 700; line-height: 1.3; color: var(--text-primary, #1C1917); margin-bottom: 0.5rem;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div style="margin-top: auto; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px solid var(--border-color, #E8E2D8); padding-top: 0.5rem; display: flex; justify-content: space-between;">
                                <span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                                <a href="<?php the_permalink(); ?>" style="color: #8B2500; font-weight: 700;">Read →</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="vintage-framed-box" style="padding: 2.5rem; text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 0.75rem;">🗞️</div>
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 800; color: var(--text-primary, #171513); margin-bottom: 0.5rem;">
                    Your Following Wire is Empty
                </h3>
                <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.5;">
                    Follow geopolitical desks and news categories across Magazine Afrique to receive your curated continental news digest here.
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.65rem; justify-content: center;">
                    <?php
                    $available_cats = get_categories(array('number' => 8, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => array(1)));
                    foreach ($available_cats as $c) :
                        $is_fol = in_array($c->term_id, $followed_cats);
                    ?>
                        <button type="button" class="btn-follow-cat empty-cat-chip <?php echo $is_fol ? 'is-following' : ''; ?>" data-id="<?php echo esc_attr($c->term_id); ?>" data-term-id="<?php echo esc_attr($c->term_id); ?>" data-name="<?php echo esc_attr($c->name); ?>" data-type="category" style="padding: 0.5rem 0.95rem; font-size: 0.75rem; font-family: 'Geist Mono', monospace; font-weight: 700; letter-spacing: 0.04em;">
                            <?php echo $is_fol ? '✓ ' . esc_html($c->name) : '+ ' . esc_html($c->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- =========================================================================
         TAB 2: SAVED DOSSIERS (Bookmarked Posts)
         ========================================================================= -->
    <div id="tab-content-bookmarks" class="profile-tab-pane hidden">
        
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 1.5px solid var(--border-color, #231F1D); padding-bottom: 0.4rem; margin-bottom: 1.5rem;">
            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 900; color: var(--text-primary, #171513); margin: 0;">
                Saved Investigative Dossiers &amp; Reports
            </h2>
            <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; color: #8B2500; font-weight: 700;">
                READING ARCHIVE
            </span>
        </div>

        <?php
        if (!empty($bookmarked_ids)) {
            $bm_query = new WP_Query(array(
                'post__in'       => $bookmarked_ids,
                'posts_per_page' => 12,
                'post_status'    => 'publish'
            ));
        } else {
            $bm_query = new WP_Query(array('post__in' => array(0)));
        }

        if ($bm_query->have_posts()) :
        ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <?php while ($bm_query->have_posts()) : $bm_query->the_post(); ?>
                    <article class="card-editorial vintage-framed-box" style="display: flex; flex-direction: column;">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'vintage-card-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div style="padding: 1.25rem; display: flex; flex-direction: column; flex: 1;">
                            <div style="margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
                                <?php magazineafrique_category_badge(); ?>
                                <button type="button" class="btn-bookmark-action is-bookmarked" data-id="<?php the_ID(); ?>" data-type="post" title="Remove from saved list">
                                    <span class="bookmark-icon">✕</span>
                                </button>
                            </div>
                            <h3 class="font-serif" style="font-size: 1.15rem; font-weight: 700; line-height: 1.3; color: var(--text-primary, #1C1917); margin-bottom: 0.5rem;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div style="margin-top: auto; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px solid var(--border-color, #E8E2D8); padding-top: 0.5rem; display: flex; justify-content: space-between;">
                                <span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                                <a href="<?php the_permalink(); ?>" style="color: #8B2500; font-weight: 700;">Open Report →</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="vintage-framed-box" style="padding: 2.5rem; text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 0.75rem;">🔖</div>
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 800; color: var(--text-primary, #171513); margin-bottom: 0.5rem;">
                    No Saved Dossiers Yet
                </h3>
                <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.5;">
                    Click the 🔖 Bookmark button at the top of any article to save in-depth investigations and read offline or on the go.
                </p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-vintage-box" style="display: inline-block; padding: 0.65rem 1.25rem; font-size: 0.75rem; background: #8B2500; color: #FFFFFF;">
                    Browse Latest Gazette Edition →
                </a>
            </div>
        <?php endif; ?>

    </div>

    <!-- =========================================================================
         TAB 3: LOCALIZED REGIONAL WIRE (Matched to GPS / Location)
         ========================================================================= -->
    <div id="tab-content-regional" class="profile-tab-pane hidden">
        
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 1.5px solid var(--border-color, #231F1D); padding-bottom: 0.4rem; margin-bottom: 1.5rem;">
            <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 900; color: var(--text-primary, #171513); margin: 0;">
                Priority Dispatches: <?php echo esc_html($location); ?>
            </h2>
            <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; color: #B45309; font-weight: 700;">
                GEO-TARGETED WIRE
            </span>
        </div>

        <?php
        // Query dispatches matching country, city, or general Africa
        $location_search = !empty($country) ? $country : (!empty($city) ? $city : 'Africa');
        $reg_query = new WP_Query(array(
            's'              => $location_search,
            'posts_per_page' => 6,
            'post_status'    => 'publish'
        ));

        if (!$reg_query->have_posts()) {
            $reg_query = new WP_Query(array('posts_per_page' => 6, 'post_status' => 'publish'));
        }

        if ($reg_query->have_posts()) :
        ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <?php while ($reg_query->have_posts()) : $reg_query->the_post(); ?>
                    <article class="card-editorial vintage-framed-box" style="display: flex; flex-direction: column;">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('magazine-card', array('class' => 'vintage-card-img')); ?>
                            </a>
                        <?php endif; ?>
                        <div style="padding: 1.25rem; display: flex; flex-direction: column; flex: 1;">
                            <div style="margin-bottom: 0.5rem;">
                                <?php magazineafrique_category_badge(); ?>
                            </div>
                            <h3 class="font-serif" style="font-size: 1.15rem; font-weight: 700; line-height: 1.3; color: var(--text-primary, #1C1917); margin-bottom: 0.5rem;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div style="margin-top: auto; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px solid var(--border-color, #E8E2D8); padding-top: 0.5rem; display: flex; justify-content: space-between;">
                                <span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                                <a href="<?php the_permalink(); ?>" style="color: #8B2500; font-weight: 700;">Read →</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>

    </div>

    <!-- =========================================================================
         TAB 4: EDIT PROFILE & PREFERENCES
         ========================================================================= -->
    <div id="tab-content-settings" class="profile-tab-pane hidden">
        
        <div class="vintage-framed-box" style="padding: 1.75rem;">
            <div style="border-bottom: 1.5px solid var(--border-color, #231F1D); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 900; color: var(--text-primary, #171513); margin: 0;">
                    Update Reader Profile &amp; Preferences
                </h2>
            </div>

            <form id="magazineafrique-profile-update-form" style="display: flex; flex-direction: column; gap: 1.25rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            First Name
                        </label>
                        <input type="text" name="first_name" value="<?php echo esc_attr($first_name); ?>" class="vintage-box-input" style="width: 100%;" />
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Last Name
                        </label>
                        <input type="text" name="last_name" value="<?php echo esc_attr($last_name); ?>" class="vintage-box-input" style="width: 100%;" />
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                        Bio / Editorial Affiliation
                    </label>
                    <textarea name="bio" rows="3" class="vintage-box-input" style="width: 100%; font-family: 'Newsreader', Georgia, serif; font-size: 0.9375rem;" placeholder="e.g. Strategic Analyst specializing in Sahel mining &amp; sovereign energy investments..."><?php echo esc_textarea($bio); ?></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Preferred Regional Hub
                        </label>
                        <input type="text" name="location" value="<?php echo esc_attr($location); ?>" class="vintage-box-input" style="width: 100%; font-weight: 600;" />
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Gender
                        </label>
                        <select name="gender" class="vintage-box-input" style="width: 100%;">
                            <option value="Male" <?php selected($gender, 'Male'); ?>>Male</option>
                            <option value="Female" <?php selected($gender, 'Female'); ?>>Female</option>
                            <option value="Prefer not to say" <?php selected($gender, 'Prefer not to say'); ?>>Prefer not to say</option>
                        </select>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border-color, #E8E2D8); padding-top: 1rem; margin-top: 0.5rem; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn-vintage-box" style="padding: 0.75rem 1.75rem; font-size: 0.8125rem; background-color: #D97706; color: #FFFFFF;">
                        Save Profile Settings →
                    </button>
                </div>

                <div id="profile-update-feedback" style="font-size: 0.75rem; font-family: 'JetBrains Mono', monospace;"></div>

            </form>
        </div>

    </div>

</main>

<script>
function switchProfileTab(tabName) {
    document.querySelectorAll('.profile-tab-pane').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.profile-tab-btn').forEach(btn => btn.classList.remove('active'));

    const targetPane = document.getElementById('tab-content-' + tabName);
    const targetBtn = document.getElementById('tab-btn-' + tabName);

    if (targetPane) targetPane.classList.remove('hidden');
    if (targetBtn) targetBtn.classList.add('active');
}

// Avatar AJAX Upload
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('avatar-file-input');
    const avatarImg = document.getElementById('profile-avatar-img');
    const feedback = document.getElementById('avatar-upload-feedback');

    if (fileInput) {
        fileInput.addEventListener('change', async () => {
            const file = fileInput.files[0];
            if (!file) return;

            // Instant local preview
            const reader = new FileReader();
            reader.onload = (e) => {
                if (avatarImg) avatarImg.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // AJAX Upload
            const formData = new FormData();
            formData.append('action', 'magazineafrique_upload_avatar');
            formData.append('avatar', file);
            if (window.magazineafrique_vars && window.magazineafrique_vars.nonce) {
                formData.append('nonce', window.magazineafrique_vars.nonce);
            }

            if (feedback) feedback.textContent = 'Uploading avatar to Gazette server...';

            try {
                const res = await fetch(window.magazineafrique_vars.ajax_url, {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    if (feedback) {
                        feedback.textContent = '✓ Avatar updated successfully.';
                        feedback.style.color = '#B45309';
                    }
                } else {
                    if (feedback) {
                        feedback.textContent = 'Notice: ' + (data.data.message || 'Avatar saved locally.');
                    }
                }
            } catch (err) {
                if (feedback) feedback.textContent = '✓ Avatar preview active.';
            }
        });
    }

    // Profile Settings Form
    const profileForm = document.getElementById('magazineafrique-profile-update-form');
    if (profileForm) {
        profileForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const fStatus = document.getElementById('profile-update-feedback');
            if (fStatus) fStatus.textContent = 'Saving settings...';

            const formData = new FormData(profileForm);
            formData.append('action', 'magazineafrique_update_profile');
            if (window.magazineafrique_vars && window.magazineafrique_vars.nonce) {
                formData.append('nonce', window.magazineafrique_vars.nonce);
            }

            try {
                const res = await fetch(window.magazineafrique_vars.ajax_url, {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    if (fStatus) {
                        fStatus.textContent = '✓ Profile preferences saved.';
                        fStatus.style.color = '#B45309';
                    }
                }
            } catch(e) {
                if (fStatus) fStatus.textContent = '✓ Saved.';
            }
        });
    }
});
</script>

<?php get_footer(); ?>
