<?php
/**
 * Template Name: Reader Feed (For You & Following)
 * Template Post Type: page
 *
 * Route: /feed/ (HTML browser view) or /wire/ or /for-you/
 * Modern Social Feed Experience:
 * - Sticky "For You" & "Following" Tabs Bar
 * - Guest Sign-In Gate on "Following" Tab
 * - 2 Cards per row on Mobile, 3 Cards per row on Desktop
 * - Image-first media cards with punchy headlines
 * - Modern, minimalist Save/Bookmark & Like social actions
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
/* ==========================================================================
   MODERN SOCIAL EDITORIAL FEED STYLES
   ========================================================================== */
.feed-social-canvas {
    max-width: 1040px;
    margin: 0 auto;
    padding: 0 0.75rem 5rem;
}

/* 1. STICKY TOP TAB BAR */
.feed-sticky-header {
    position: sticky;
    top: 52px;
    z-index: 35;
    background-color: var(--bg-canvas, #FAF7F2);
    border-bottom: 2px solid var(--border-color, #171513);
    margin: 0 -0.75rem 1.25rem;
    padding: 0 0.75rem;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    transition: background-color 0.2s ease, border-color 0.2s ease;
}
@media (min-width: 768px) {
    .feed-sticky-header {
        top: 66px;
        margin: 0 0 1.5rem;
        padding: 0;
        border-radius: 0;
    }
}
.feed-sticky-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1040px;
    margin: 0 auto;
}
.feed-social-tabs {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.social-tab-link {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.85rem 1rem;
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    font-size: 0.9375rem;
    font-weight: 800;
    text-decoration: none;
    color: var(--text-secondary, #6E675F);
    transition: color 0.15s ease;
}
.social-tab-link:hover {
    color: var(--text-primary, #171513);
}
.social-tab-link.active {
    color: var(--text-primary, #171513);
}
.social-tab-indicator {
    position: absolute;
    bottom: -2px;
    left: 1rem;
    right: 1rem;
    height: 3.5px;
    background-color: transparent;
    border-radius: 3px 3px 0 0;
    transition: background-color 0.2s ease;
}
.social-tab-link.active .social-tab-indicator {
    background-color: #D97706;
}
.social-tab-lock {
    font-size: 0.75rem;
    opacity: 0.75;
}
.social-tab-count {
    background: #D97706;
    color: #FFFFFF;
    font-size: 0.6875rem;
    font-weight: 800;
    padding: 0.1rem 0.4rem;
    border-radius: 999px;
    line-height: 1.2;
}

/* Quick Tools in Sticky Bar */
.feed-sticky-tools {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.btn-feed-tool {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--bg-card, #FFFFFF);
    border: 1.5px solid var(--border-color, #171513);
    color: var(--text-primary, #171513);
    text-decoration: none;
    transition: transform 0.15s ease, background-color 0.15s ease;
}
.btn-feed-tool:hover {
    transform: scale(1.05);
    background-color: var(--bg-card-subtle, #EFE9DE);
}

/* 2. HORIZONTAL TOPICS / DESKS CAROUSEL STRIP */
.feed-topics-bar {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding-bottom: 0.75rem;
    margin-bottom: 1.25rem;
}
.feed-topics-bar::-webkit-scrollbar {
    display: none;
    width: 0;
    height: 0;
}
.topic-pill-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    white-space: nowrap;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.35rem 0.7rem;
    background: var(--bg-card, #FFFFFF);
    border: 1.5px solid var(--border-color, #171513);
    border-radius: 20px;
    color: var(--text-primary, #171513);
    text-decoration: none;
    box-shadow: 2px 2px 0px var(--shadow-color, #171513);
    flex-shrink: 0;
    transition: transform 0.15s ease, background 0.15s ease;
}
.topic-pill-chip:hover {
    transform: translate(-1px, -1px);
    background: var(--bg-card-subtle, #EFE9DE);
}
.topic-pill-chip .btn-follow-cat {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 0.75rem;
    font-weight: 800;
    color: #D97706;
    padding: 0 0.15rem;
}

/* 3. SOCIAL CARDS GRID: 2 ON A ROW ON MOBILE, 3 ON DESKTOP */
.feed-social-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}
@media (min-width: 680px) {
    .feed-social-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }
}
@media (min-width: 1040px) {
    .feed-social-grid {
        gap: 1.5rem;
    }
}

/* 4. SOCIAL DISPATCH CARD (IMAGE-FIRST, MINIMAL TEXT) */
.social-card {
    background: var(--bg-card, #FFFFFF);
    border: 2px solid var(--border-color, #171513);
    box-shadow: 4px 4px 0px var(--shadow-color, #171513);
    border-radius: 6px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.18s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.18s cubic-bezier(0.16, 1, 0.3, 1);
}
.social-card:hover {
    transform: translate(-2px, -2px);
    box-shadow: 6px 6px 0px var(--shadow-color, #171513);
}

/* Image Wrap (Dominant Media) */
.social-card-media {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background-color: #24201D;
    display: block;
    border-bottom: 1.5px solid var(--border-color, #171513);
}
.social-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.35s ease;
}
.social-card:hover .social-card-img {
    transform: scale(1.06);
}

/* Overlaid Badge & Match Tag */
.social-card-badge-overlay {
    position: absolute;
    bottom: 8px;
    left: 8px;
    background: rgba(23, 21, 19, 0.88);
    backdrop-filter: blur(4px);
    color: #FAF7F2;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.625rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 0.2rem 0.45rem;
    border-radius: 2px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    max-width: calc(100% - 16px);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.social-match-flag {
    position: absolute;
    top: 8px;
    right: 8px;
    background: #B45309;
    color: #FFFFFF;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.5625rem;
    font-weight: 900;
    padding: 0.15rem 0.4rem;
    border-radius: 2px;
    box-shadow: 1px 1px 0px #000;
}

/* Card Body */
.social-card-body {
    padding: 0.65rem 0.75rem 0.5rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
@media (min-width: 680px) {
    .social-card-body {
        padding: 0.85rem 1rem 0.65rem;
    }
}

.social-card-headline {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 0.9375rem;
    font-weight: 800;
    line-height: 1.25;
    margin: 0 0 0.35rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
@media (min-width: 680px) {
    .social-card-headline {
        font-size: 1.05rem;
        -webkit-line-clamp: 3;
    }
}
.social-card-headline a {
    color: var(--text-primary, #171513);
    text-decoration: none;
    transition: color 0.15s ease;
}
.social-card-headline a:hover {
    color: #B45309;
}

/* Excerpt: hidden on mobile, 1 concise sentence on desktop */
.social-card-excerpt {
    display: none;
    font-size: 0.8125rem;
    color: var(--text-secondary, #6E675F);
    line-height: 1.45;
    margin: 0 0 0.5rem;
}
@media (min-width: 768px) {
    .social-card-excerpt {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
}

/* Date / Read Info */
.social-card-meta {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.625rem;
    color: var(--text-muted, #8C8275);
    margin-top: auto;
    padding-top: 0.35rem;
}

/* 5. MODERN MINIMALIST ACTION BAR */
.social-action-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.45rem 0.75rem 0.55rem;
    border-top: 1px dashed var(--border-light, #E2DBD0);
    background-color: var(--bg-card-subtle, rgba(0, 0, 0, 0.015));
}
@media (min-width: 680px) {
    .social-action-bar {
        padding: 0.55rem 1rem 0.65rem;
    }
}

.social-action-btn-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* Modern Minimalist Like Button (Clean SVG, No Red Pill Capsule) */
.social-card .btn-live-like,
.social-card .social-like-btn,
.social-like-btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.25rem !important;
    background: transparent !important;
    background-color: transparent !important;
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    border-radius: 0 !important;
    padding: 0.2rem 0.3rem !important;
    cursor: pointer !important;
    color: var(--text-secondary, #6E675F) !important;
    font-family: 'JetBrains Mono', monospace !important;
    font-size: 0.6875rem !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    transition: transform 0.15s ease, color 0.15s ease !important;
    -webkit-tap-highlight-color: transparent !important;
}
.social-card .btn-live-like:hover,
.social-card .social-like-btn:hover,
.social-like-btn:hover,
.social-card .btn-live-like:focus,
.social-card .social-like-btn:focus,
.social-like-btn:focus,
.social-card .btn-live-like:active,
.social-card .social-like-btn:active,
.social-like-btn:active {
    background: transparent !important;
    background-color: transparent !important;
    border: none !important;
    box-shadow: none !important;
    border-radius: 0 !important;
    transform: scale(1.1) !important;
    color: #E11D48 !important;
}
.social-card .btn-live-like.has-liked,
.social-card .social-like-btn.has-liked,
.social-like-btn.has-liked,
.social-card .btn-live-like.has-liked:hover,
.social-card .social-like-btn.has-liked:hover,
.social-like-btn.has-liked:hover,
.social-card .btn-live-like.has-liked:focus,
.social-card .social-like-btn.has-liked:focus,
.social-like-btn.has-liked:focus {
    background: transparent !important;
    background-color: transparent !important;
    border: none !important;
    box-shadow: none !important;
    border-radius: 0 !important;
    color: #E11D48 !important;
    transform: none !important;
}
.social-card .btn-live-like svg,
.social-card .social-like-btn svg,
.social-like-btn svg {
    width: 16px !important;
    height: 16px !important;
    fill: none !important;
    stroke: currentColor !important;
    stroke-width: 2.2 !important;
    transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275), fill 0.2s ease, stroke 0.2s ease !important;
}
.social-card .btn-live-like.has-liked svg,
.social-card .social-like-btn.has-liked svg,
.social-like-btn.has-liked svg {
    fill: #E11D48 !important;
    stroke: #E11D48 !important;
    transform: scale(1.15) !important;
}
.social-card .live-like-counter,
.social-like-btn .live-like-counter {
    font-size: 0.6875rem !important;
    font-weight: 700 !important;
    color: inherit !important;
}

/* Modern Minimalist Bookmark Button (Clean SVG Icon) */
.social-bookmark-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    padding: 0.2rem;
    cursor: pointer;
    color: var(--text-secondary, #6E675F);
    transition: transform 0.15s ease, color 0.15s ease;
}
.social-bookmark-btn:hover {
    transform: scale(1.1);
    color: #D97706;
}
.social-bookmark-btn.is-bookmarked {
    color: #D97706 !important;
}
.social-bookmark-btn.is-bookmarked svg {
    fill: #D97706;
    stroke: #D97706;
}

/* Share Icon Button */
.social-share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    padding: 0.2rem;
    cursor: pointer;
    color: var(--text-secondary, #6E675F);
    transition: transform 0.15s ease, color 0.15s ease;
}
.social-share-btn:hover {
    transform: scale(1.1);
    color: #0B5128;
}

/* 6. GUEST SIGN-IN GATE ON FOLLOWING TAB */
.feed-auth-gate-box {
    background: var(--bg-card, #FFFFFF);
    border: 2px solid var(--border-color, #171513);
    box-shadow: 6px 6px 0px var(--shadow-color, #171513);
    border-radius: 6px;
    padding: 3rem 1.5rem;
    text-align: center;
    max-width: 580px;
    margin: 2rem auto;
}
.gate-icon-circle {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: rgba(217, 119, 6, 0.12);
    border: 2px solid #D97706;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 1.75rem;
}
.gate-headline {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(1.5rem, 3vw, 1.85rem);
    font-weight: 900;
    color: var(--text-primary, #171513);
    margin: 0 0 0.65rem;
}
.gate-body-text {
    font-size: 0.9375rem;
    color: var(--text-secondary, #6E675F);
    line-height: 1.6;
    max-width: 440px;
    margin: 0 auto 1.75rem;
}
.gate-actions-row {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    max-width: 340px;
    margin: 0 auto 1.75rem;
}
@media (min-width: 480px) {
    .gate-actions-row {
        flex-direction: row;
        max-width: none;
        justify-content: center;
    }
}
.btn-gate-primary {
    background: #D97706;
    color: #FFFFFF !important;
    font-size: 0.875rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 0.75rem 1.5rem;
    border-radius: 3px;
    border: 2px solid #171513;
    box-shadow: 3px 3px 0px #171513;
    text-decoration: none;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
    display: inline-block;
}
.btn-gate-primary:hover {
    transform: translate(-1px, -1px);
    box-shadow: 4px 4px 0px #171513;
}
.btn-gate-secondary {
    background: var(--bg-card, #FFFFFF);
    color: var(--text-primary, #171513) !important;
    font-size: 0.875rem;
    font-weight: 700;
    padding: 0.75rem 1.25rem;
    border-radius: 3px;
    border: 2px solid var(--border-color, #171513);
    text-decoration: none;
    transition: background 0.15s ease;
    display: inline-block;
}
.btn-gate-secondary:hover {
    background: var(--bg-card-subtle, #EFE9DE);
}

/* 7. DARK MODE OVERRIDES */
[data-theme="dark"] .feed-sticky-header {
    background-color: rgba(20, 18, 16, 0.92) !important;
    border-bottom-color: #38332F !important;
}
[data-theme="dark"] .social-tab-link {
    color: #A39A8E;
}
[data-theme="dark"] .social-tab-link.active {
    color: #FAF7F2;
}
[data-theme="dark"] .topic-pill-chip {
    background: #1C1917 !important;
    border-color: #38332F !important;
    color: #FAF7F2 !important;
    box-shadow: 2px 2px 0px #000000 !important;
}
[data-theme="dark"] .social-card {
    background: #1C1917 !important;
    border-color: #38332F !important;
    box-shadow: 4px 4px 0px #000000 !important;
}
[data-theme="dark"] .social-card:hover {
    box-shadow: 6px 6px 0px #000000 !important;
}
[data-theme="dark"] .social-card-media {
    border-bottom-color: #38332F !important;
}
[data-theme="dark"] .social-action-bar {
    border-top-color: #38332F !important;
    background-color: rgba(255, 255, 255, 0.02) !important;
}
[data-theme="dark"] .feed-auth-gate-box {
    background: #1C1917 !important;
    border-color: #38332F !important;
    box-shadow: 6px 6px 0px #000000 !important;
}
[data-theme="dark"] .btn-gate-secondary {
    background: #24201D !important;
    border-color: #38332F !important;
    color: #FAF7F2 !important;
}
</style>

<main id="primary" class="site-main container-editorial broadsheet-main">
    <div class="feed-social-canvas">

        <!-- 1. STICKY SOCIAL TABS (FOR YOU vs FOLLOWING) -->
        <nav class="feed-sticky-header" aria-label="Feed Streams Navigation">
            <div class="feed-sticky-inner">
                <div class="feed-social-tabs">
                    <a href="<?php echo esc_url(add_query_arg('tab', 'for-you')); ?>" class="social-tab-link <?php echo $active_tab === 'for-you' ? 'active' : ''; ?>">
                        <span>For You</span>
                        <span class="social-tab-indicator"></span>
                    </a>

                    <a href="<?php echo esc_url(add_query_arg('tab', 'following')); ?>" class="social-tab-link <?php echo $active_tab === 'following' ? 'active' : ''; ?>">
                        <span>Following</span>
                        <?php if ($is_logged_in && $total_followed_count > 0) : ?>
                            <span class="social-tab-count"><?php echo esc_html($total_followed_count); ?></span>
                        <?php elseif (!$is_logged_in) : ?>
                            <span class="social-tab-lock" title="Sign In to Access Following Wire">🔒</span>
                        <?php endif; ?>
                        <span class="social-tab-indicator"></span>
                    </a>
                </div>

                <!-- Fast Refresh Tool -->
                <div class="feed-sticky-tools">
                    <a href="<?php echo esc_url(home_url('/feed/')); ?>" class="btn-feed-tool" title="Refresh Feed" aria-label="Refresh Feed">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
                    </a>
                </div>
            </div>
        </nav>

        <!-- 2. QUICK FOLLOW DESKS HORIZONTAL STRIP -->
        <div class="feed-topics-bar" role="region" aria-label="Desks Filter">
            <?php
            $popular_cats = get_categories(array('number' => 8, 'orderby' => 'count', 'order' => 'DESC', 'exclude' => array(1)));
            foreach ($popular_cats as $cat) {
                $is_cat_followed = in_array((int)$cat->term_id, array_map('intval', $followed_cats), true);
                ?>
                <span class="topic-pill-chip">
                    <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" style="color: inherit; text-decoration: none;">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                    <button type="button" class="btn-follow-cat <?php echo $is_cat_followed ? 'is-following' : ''; ?>" data-id="<?php echo esc_attr($cat->term_id); ?>" data-type="category" title="<?php echo $is_cat_followed ? 'Unfollow' : 'Follow ' . esc_attr($cat->name); ?>" aria-label="Follow <?php echo esc_attr($cat->name); ?>">
                        <?php echo $is_cat_followed ? '✓' : '+'; ?>
                    </button>
                </span>
                <?php
            }
            ?>
        </div>

        <!-- 3. FEED STREAMS (FOR YOU vs FOLLOWING) -->
        <?php
        if ($active_tab === 'following') {
            // =========================================================================
            // TAB: FOLLOWING WIRE
            // =========================================================================

            // REQUIREMENT: Guest readers MUST sign in to access Following Wire
            if (!$is_logged_in) {
                ?>
                <div class="feed-auth-gate-box">
                    <div class="gate-icon-circle">🔒</div>
                    <h2 class="gate-headline">Sign in to unlock your Following Wire</h2>
                    <p class="gate-body-text">
                        Your Following Wire is a personalized social stream curated by the specific continental desks, investigative tags, and correspondents you follow.
                    </p>
                    <div class="gate-actions-row">
                        <a href="<?php echo esc_url(home_url('/onboarding/?mode=login&redirect_to=' . urlencode(home_url('/feed/?tab=following')))); ?>" class="btn-gate-primary">
                            Sign In to Your Wire →
                        </a>
                        <a href="<?php echo esc_url(home_url('/onboarding/?redirect_to=' . urlencode(home_url('/feed/?tab=following')))); ?>" class="btn-gate-secondary">
                            Create Free Account
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo esc_url(add_query_arg('tab', 'for-you')); ?>" style="font-size: 0.8125rem; color: #D97706; font-weight: 700; text-decoration: underline;">
                            Looking for open continental dispatches? Browse "For You" Feed »
                        </a>
                    </div>
                </div>
                <?php
            } else {
                // Logged-in user: show followed stream
                if (empty($followed_cats) && empty($followed_tags)) {
                    ?>
                    <div class="feed-auth-gate-box" style="padding: 2.5rem 1.5rem;">
                        <div style="font-size: 2.5rem; color: #D97706; margin-bottom: 0.75rem;">✦</div>
                        <h2 class="gate-headline" style="font-size: 1.5rem;">Your Following Wire is Empty</h2>
                        <p class="gate-body-text">
                            Tap the <strong>+</strong> button on any desk in the strip above or on tags across articles to populate your custom feed.
                        </p>
                        <a href="<?php echo esc_url(add_query_arg('tab', 'for-you')); ?>" class="btn-gate-primary">
                            Discover Stories in "For You" »
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

                    $paged = max(1, get_query_var('paged'), get_query_var('page'));
                    $following_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'post_status'    => 'publish',
                        'posts_per_page' => 16,
                        'paged'          => $paged,
                        'tax_query'      => $tax_query
                    ));

                    if ($following_query->have_posts()) {
                        echo '<div class="feed-social-grid">';
                        while ($following_query->have_posts()) {
                            $following_query->the_post();
                            $p_id = get_the_ID();
                            $is_bookmarked = function_exists('magazineafrique_is_item_saved') ? magazineafrique_is_item_saved($p_id, 'post') : false;
                            $is_liked = function_exists('magazineafrique_user_has_liked') ? magazineafrique_user_has_liked($p_id) : false;
                            $likes = function_exists('magazineafrique_get_likes_count') ? magazineafrique_get_likes_count($p_id) : 0;
                            $post_cats = get_the_category();
                            $cat_name = !empty($post_cats) ? $post_cats[0]->name : 'Dispatch';
                            ?>
                            <article class="social-card">
                                <a href="<?php the_permalink(); ?>" class="social-card-media" aria-label="<?php the_title_attribute(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large', array('class' => 'social-card-img', 'alt' => get_the_title())); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/login-hero.jpg'); ?>" alt="Magazine Afrique" class="social-card-img" />
                                    <?php endif; ?>
                                    <span class="social-card-badge-overlay"><?php echo esc_html($cat_name); ?></span>
                                    <span class="social-match-flag">MATCH</span>
                                </a>

                                <div class="social-card-body">
                                    <h3 class="social-card-headline">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>

                                    <p class="social-card-excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 14); ?>
                                    </p>

                                    <div class="social-card-meta">
                                        <?php echo esc_html(get_the_date('M j')); ?> · <?php echo function_exists('magazineafrique_reading_time') ? magazineafrique_reading_time($p_id) : '3 min'; ?>
                                    </div>
                                </div>

                                <footer class="social-action-bar">
                                    <div class="social-action-btn-group">
                                        <button type="button" class="btn-live-like social-like-btn <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" title="Like" aria-label="Like story">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                                            <span class="live-like-counter"><?php echo esc_html($likes > 0 ? $likes : ''); ?></span>
                                        </button>

                                        <button type="button" class="btn-bookmark social-bookmark-btn <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" title="Save Dossier" aria-label="Save Dossier">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                                        </button>
                                    </div>

                                    <button type="button" class="social-share-btn" onclick="magafriqueSocialShare('<?php echo esc_js(get_the_title()); ?>', '<?php echo esc_url(get_permalink()); ?>')" title="Share Dispatch" aria-label="Share">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                                    </button>
                                </footer>
                            </article>
                            <?php
                        }
                        echo '</div>';
                        wp_reset_postdata();
                    }
                }
            }

        } else {
            // =========================================================================
            // TAB: FOR YOU (Publicly visible to ALL guests & readers)
            // =========================================================================
            $paged = max(1, get_query_var('paged'), get_query_var('page'));
            $for_you_query = new WP_Query(array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 18,
                'paged'          => $paged,
                'orderby'        => 'date',
                'order'          => 'DESC'
            ));

            if ($for_you_query->have_posts()) {
                echo '<div class="feed-social-grid">';
                $counter = 0;
                while ($for_you_query->have_posts()) {
                    $for_you_query->the_post();
                    $counter++;
                    $p_id = get_the_ID();
                    $is_bookmarked = function_exists('magazineafrique_is_item_saved') ? magazineafrique_is_item_saved($p_id, 'post') : false;
                    $is_liked = function_exists('magazineafrique_user_has_liked') ? magazineafrique_user_has_liked($p_id) : false;
                    $likes = function_exists('magazineafrique_get_likes_count') ? magazineafrique_get_likes_count($p_id) : 0;
                    $post_cats = get_the_category();
                    $cat_name = !empty($post_cats) ? $post_cats[0]->name : 'Dispatch';
                    ?>
                    <article class="social-card">
                        <a href="<?php the_permalink(); ?>" class="social-card-media" aria-label="<?php the_title_attribute(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', array('class' => 'social-card-img', 'alt' => get_the_title())); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/login-hero.jpg'); ?>" alt="Magazine Afrique" class="social-card-img" />
                            <?php endif; ?>
                            <span class="social-card-badge-overlay"><?php echo esc_html($cat_name); ?></span>
                        </a>

                        <div class="social-card-body">
                            <h3 class="social-card-headline">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <p class="social-card-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 14); ?>
                            </p>

                            <div class="social-card-meta">
                                <?php echo esc_html(get_the_date('M j')); ?> · <?php echo function_exists('magazineafrique_reading_time') ? magazineafrique_reading_time($p_id) : '3 min'; ?>
                            </div>
                        </div>

                        <footer class="social-action-bar">
                            <div class="social-action-btn-group">
                                <!-- Modern Like Button -->
                                <button type="button" class="btn-live-like social-like-btn <?php echo $is_liked ? 'has-liked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" title="Like" aria-label="Like story">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                                    <span class="live-like-counter"><?php echo esc_html($likes > 0 ? $likes : ''); ?></span>
                                </button>

                                <!-- Modern Minimalist Bookmark Button -->
                                <button type="button" class="btn-bookmark social-bookmark-btn <?php echo $is_bookmarked ? 'is-bookmarked' : ''; ?>" data-post-id="<?php echo esc_attr($p_id); ?>" title="Save Dossier" aria-label="Save Dossier">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                                </button>
                            </div>

                            <!-- Modern Share Button -->
                            <button type="button" class="social-share-btn" onclick="magafriqueSocialShare('<?php echo esc_js(get_the_title()); ?>', '<?php echo esc_url(get_permalink()); ?>')" title="Share Dispatch" aria-label="Share">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            </button>
                        </footer>
                    </article>
                    <?php
                }
                echo '</div>';
                wp_reset_postdata();
            }
        }
        ?>

    </div>
</main>

<script>
function magafriqueSocialShare(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title + ' — Magazine Afrique',
            url: url
        }).catch(function(){});
    } else {
        navigator.clipboard.writeText(url).then(function() {
            if (typeof showToast === 'function') {
                showToast('✓ Link copied to clipboard');
            } else {
                alert('Link copied to clipboard!');
            }
        });
    }
}
</script>

<?php get_footer(); ?>
