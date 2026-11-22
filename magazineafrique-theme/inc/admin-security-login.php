<?php
/**
 * Magazine Afrique — Secure Admin Gateway & Custom Login Engine
 * Secret Admin URL: /admincontrol-bkasjgf56090875
 * Full ArtCraft Dark SaaS Theme for Admin Authentication
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MAGAZINEAFRIQUE_SECRET_ADMIN_SLUG', 'admincontrol-bkasjgf56090875');

/**
 * 1. Virtual Route for Secret Admin Login URL
 */
if (!function_exists('magazineafrique_handle_secret_admin_route')) {
    function magazineafrique_handle_secret_admin_route() {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Check if accessing secret admin login path
        if ($path === MAGAZINEAFRIQUE_SECRET_ADMIN_SLUG) {
            // Set verification cookie valid for 1 hour
            setcookie('magafrique_admin_gate', 'unlocked_' . md5(SECURE_AUTH_KEY), time() + 3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);

            if (is_user_logged_in() && current_user_can('edit_posts')) {
                wp_safe_redirect(admin_url('index.php'));
                exit;
            }

            magazineafrique_render_artcraft_login_page();
            exit;
        }

        // Intercept direct unauthorized hits to wp-login.php
        global $pagenow;
        if ($pagenow === 'wp-login.php' && !is_user_logged_in()) {
            $action = isset($_GET['action']) ? $_GET['action'] : '';
            
            // Allow logout and password reset routines
            if ($action === 'logout' || $action === 'lostpassword' || $action === 'resetpass' || $action === 'rp') {
                return;
            }

            // Allow if valid secret cookie or query param is present
            $cookie_valid = isset($_COOKIE['magafrique_admin_gate']) && $_COOKIE['magafrique_admin_gate'] === 'unlocked_' . md5(SECURE_AUTH_KEY);
            $param_valid = isset($_GET['secret']) && $_GET['secret'] === MAGAZINEAFRIQUE_SECRET_ADMIN_SLUG;

            if ($cookie_valid || $param_valid) {
                if (empty($action) && empty($_POST)) {
                    magazineafrique_render_artcraft_login_page();
                    exit;
                }
            } else if (!isset($_POST['log'])) {
                // Redirect stealthily to home page
                wp_safe_redirect(home_url('/'));
                exit;
            }
        }
    }
    add_action('init', 'magazineafrique_handle_secret_admin_route', 1);
}

/**
 * 2. Render ArtCraft 1:1 Split-Card Dark SaaS Admin Login Page
 * Split Card with Technical Blueprint Reticles (+), Welcome back heading,
 * and Pan-African Editorial Hero Artwork.
 */
if (!function_exists('magazineafrique_render_artcraft_login_page')) {
    function magazineafrique_render_artcraft_login_page() {
        $login_error = '';
        $redirect_to = admin_url('index.php');

        // Process login submission if POSTed
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artcraft_login_submit'])) {
            check_admin_referer('artcraft_admin_login_action', 'artcraft_login_nonce');

            $creds = array(
                'user_login'    => sanitize_text_field($_POST['log'] ?? ''),
                'user_password' => $_POST['pwd'] ?? '',
                'remember'      => !empty($_POST['rememberme'])
            );

            if (is_email($creds['user_login'])) {
                $user_obj = get_user_by('email', $creds['user_login']);
                if ($user_obj) {
                    $creds['user_login'] = $user_obj->user_login;
                }
            }

            $user = wp_signon($creds, is_ssl());

            if (is_wp_error($user)) {
                $login_error = $user->get_error_message();
            } else {
                wp_set_current_user($user->ID);
                wp_set_auth_cookie($user->ID, !empty($_POST['rememberme']));
                wp_safe_redirect($redirect_to);
                exit;
            }
        }

        $hero_img_url = get_template_directory_uri() . '/assets/images/login-hero.jpg';
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editorial Workspace ‹ Magazine Afrique</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wdth,wght@0,62..125,100..900;1,62..125,100..900&family=Geist+Mono:wght@400;500;600;700&family=Newsreader:ital,opsz,wght@1,6..72,400;1,6..72,600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-canvas: #0E0F12;
            --bg-card: #17181C;
            --bg-input: #121316;
            --border: rgba(255, 255, 255, 0.12);
            --border-hover: rgba(255, 255, 255, 0.25);
            --border-focus: #2D81FF;
            --text-white: #F2F1EE;
            --text-gray: #9AA0A6;
            --text-muted: #5F6672;
            --accent-blue: #2D81FF;
            --accent-cyan: #22D3EE;
            --accent-ink: #74AAFF;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-canvas);
            color: var(--text-white);
            font-family: 'Archivo', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Subtle atmospheric ambient glow */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 40%, rgba(45, 129, 255, 0.05) 0%, transparent 65%);
            pointer-events: none;
        }

        /* Outer Split Frame with Technical Reticles (+) */
        .artcraft-split-container {
            position: relative;
            width: 100%;
            max-width: 920px;
            min-height: 540px;
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            display: flex;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.7);
            z-index: 10;
            overflow: visible;
        }

        /* Technical Reticle Corner Crosshairs (+) Matching ArtCraft */
        .artcraft-reticle {
            position: absolute;
            width: 15px;
            height: 15px;
            line-height: 13px;
            text-align: center;
            font-family: 'Geist Mono', monospace;
            font-size: 15px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.45);
            pointer-events: none;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reticle-tl { top: -8px; left: -8px; }
        .reticle-tr { top: -8px; right: -8px; }
        .reticle-bl { bottom: -8px; left: -8px; }
        .reticle-br { bottom: -8px; right: -8px; }

        /* Left Side: Form */
        .split-form-panel {
            flex: 1;
            padding: 44px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: var(--bg-card);
            border-radius: 4px 0 0 4px;
            position: relative;
            z-index: 5;
        }

        .brand-badge-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .brand-badge-icon {
            width: 28px;
            height: 28px;
            background: #0B5128;
            color: #FAF7F2;
            font-size: 12px;
            font-weight: 900;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: -0.05em;
            box-shadow: 0 0 10px rgba(11, 81, 40, 0.4);
        }

        .split-login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: -0.025em;
            margin-bottom: 6px;
            line-height: 1.15;
        }

        .title-serif-italic {
            font-family: 'Newsreader', Georgia, serif;
            font-style: italic;
            font-weight: 400;
            color: #FFFFFF;
        }

        .split-login-sub {
            font-size: 13px;
            color: var(--text-gray);
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 7px;
        }

        .form-label {
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: rgba(255, 255, 255, 0.45);
        }

        .forgot-link {
            font-family: 'Archivo', sans-serif;
            font-size: 11px;
            color: var(--accent-ink);
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .forgot-link:hover {
            color: #FFFFFF;
            text-decoration: underline;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            height: 42px;
            background-color: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 0 14px;
            color: #FFFFFF;
            font-family: 'Archivo', sans-serif;
            font-size: 13px;
            transition: all 0.15s ease;
            outline: none;
            box-sizing: border-box;
        }

        .form-input:hover {
            border-color: var(--border-hover);
        }

        .form-input:focus {
            background-color: #0B0C0E;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 2px rgba(45, 129, 255, 0.25);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.25);
            font-size: 12px;
        }

        .toggle-password-btn {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.15s ease;
        }

        .toggle-password-btn:hover {
            color: #FFFFFF;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 12px;
            color: var(--text-gray);
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            accent-color: var(--accent-blue);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Solid White ArtCraft Log In Button */
        .submit-btn-white {
            width: 100%;
            height: 44px;
            background-color: #FFFFFF;
            color: #000000;
            border: none;
            border-radius: 4px;
            font-family: 'Geist Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-btn-white:hover {
            background-color: #F0EDE8;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(255, 255, 255, 0.2);
        }

        .submit-btn-white:active {
            transform: translateY(0);
        }

        .error-alert {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #F87171;
            padding: 10px 14px;
            border-radius: 4px;
            font-size: 12px;
            margin-bottom: 20px;
            line-height: 1.45;
        }

        /* Right Side: Hero African Artwork */
        .split-hero-panel {
            flex: 1;
            position: relative;
            background-color: #121316;
            background-image: url('<?php echo esc_url($hero_img_url); ?>');
            background-size: cover;
            background-position: center top;
            border-radius: 0 4px 4px 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 36px 32px;
            box-sizing: border-box;
        }

        /* Dark gradient bottom vignette on hero artwork */
        .split-hero-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(14, 15, 18, 0.05) 20%, rgba(14, 15, 18, 0.6) 60%, rgba(14, 15, 18, 0.95) 95%);
            pointer-events: none;
        }

        .hero-caption-cluster {
            position: relative;
            z-index: 5;
        }

        .hero-tag {
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #FBBF24;
            background: rgba(245, 158, 11, 0.18);
            border: 1px solid rgba(245, 158, 11, 0.4);
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .hero-heading {
            font-size: 1.35rem;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: -0.015em;
            line-height: 1.25;
            margin-bottom: 8px;
        }

        .hero-desc {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.5;
            max-width: 380px;
        }

        @media (max-width: 820px) {
            .artcraft-split-container {
                flex-direction: column;
                max-width: 440px;
            }
            .split-hero-panel {
                min-height: 220px;
                border-radius: 0 0 4px 4px;
            }
            .split-form-panel {
                border-radius: 4px 4px 0 0;
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>

    <div class="artcraft-split-container">
        <!-- Cad-Style Corner Reticles (+) -->
        <span class="artcraft-reticle reticle-tl" aria-hidden="true">+</span>
        <span class="artcraft-reticle reticle-tr" aria-hidden="true">+</span>
        <span class="artcraft-reticle reticle-bl" aria-hidden="true">+</span>
        <span class="artcraft-reticle reticle-br" aria-hidden="true">+</span>

        <!-- Left Column: Pure Form Panel -->
        <div class="split-form-panel">
            <div class="brand-badge-row">
                <div class="brand-badge-icon">MA</div>
            </div>

            <h1 class="split-login-title">Welcome <span class="title-serif-italic">back.</span></h1>
            <p class="split-login-sub">Log in to your editorial workspace.</p>

            <?php if (!empty($login_error)) : ?>
                <div class="error-alert">
                    <?php echo wp_kses_post($login_error); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="" id="artcraft-login-form">
                <?php wp_nonce_field('artcraft_admin_login_action', 'artcraft_login_nonce'); ?>
                <input type="hidden" name="artcraft_login_submit" value="1">

                <div class="form-group">
                    <div class="label-row">
                        <label for="user_login" class="form-label">EMAIL OR USERNAME</label>
                    </div>
                    <div class="input-wrapper">
                        <input type="text" name="log" id="user_login" class="form-input" required autofocus autocomplete="username" placeholder="you@example.com or username">
                    </div>
                </div>

                <div class="form-group">
                    <div class="label-row">
                        <label for="user_pass" class="form-label">PASSWORD</label>
                        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="forgot-link">Forgot password?</a>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" name="pwd" id="user_pass" class="form-input" required autocomplete="current-password" placeholder="Min. 8 characters">
                        <button type="button" class="toggle-password-btn" id="toggle-pwd-btn" aria-label="Toggle password visibility">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" name="rememberme" id="rememberme" value="forever" checked>
                        <span>Keep terminal active</span>
                    </label>
                </div>

                <!-- Solid White ArtCraft Action Button -->
                <button type="submit" class="submit-btn-white">
                    LOG IN
                </button>
            </form>
        </div>

        <!-- Right Column: Pan-African Artwork Hero Panel -->
        <div class="split-hero-panel">
            <div class="hero-caption-cluster">
                <span class="hero-tag">PAN-AFRICAN EDITORIAL DESK</span>
                <h2 class="hero-heading">The Voice of Modern Africa</h2>
                <p class="hero-desc">Curating strategic intelligence, diplomatic analysis, and Pan-African intellect.</p>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var toggleBtn = document.getElementById('toggle-pwd-btn');
            var pwdInput = document.getElementById('user_pass');
            if (toggleBtn && pwdInput) {
                toggleBtn.addEventListener('click', function() {
                    var isPassword = pwdInput.type === 'password';
                    pwdInput.type = isPassword ? 'text' : 'password';
                });
            }
        })();
    </script>
</body>
</html>
        <?php
    }
}
        <?php
    }
}
