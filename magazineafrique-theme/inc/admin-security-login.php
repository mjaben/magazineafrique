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

            if (!$cookie_valid && !$param_valid && !isset($_POST['log'])) {
                // Redirect stealthily to home page
                wp_safe_redirect(home_url('/'));
                exit;
            }
        }
    }
    add_action('init', 'magazineafrique_handle_secret_admin_route', 1);
}

/**
 * 2. Render ArtCraft 1:1 Dark SaaS Admin Login Page
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
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Console Gateway ‹ Magazine Afrique</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wdth,wght@0,62..125,100..900;1,62..125,100..900&family=Geist+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-canvas: #121316;
            --bg-panel: #1A1B1F;
            --bg-input: #101014;
            --border: rgba(255, 255, 255, 0.12);
            --border-focus: #74AAFF;
            --text-primary: #F2F1EE;
            --text-muted: rgba(255, 255, 255, 0.5);
            --accent: #2D81FF;
            --accent-ink: #74AAFF;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: var(--bg-canvas);
            color: var(--text-primary);
            font-family: 'Archivo', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }
        /* Subtle background radial glow */
        body::before {
            content: '';
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 400px;
            background: radial-gradient(circle, rgba(45, 129, 255, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background-color: var(--bg-panel);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 2.25rem 2rem;
            position: relative;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            z-index: 10;
        }
        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1.5rem;
        }
        .hud-eyebrow {
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--accent-ink);
            margin-bottom: 0.5rem;
        }
        .brand-title {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .brand-logo-mark {
            width: 24px;
            height: 24px;
            border-radius: 2px;
            background: #0B5128;
            color: #FAF7F2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 900;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-family: 'Geist Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 0.45rem;
        }
        .form-input {
            width: 100%;
            background-color: var(--bg-input);
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 0.75rem 0.95rem;
            border-radius: 3px;
            font-size: 14px;
            font-family: 'Archivo', sans-serif;
            transition: all 0.15s ease;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 1px var(--border-focus);
            background-color: rgba(255, 255, 255, 0.02);
        }
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 12px;
            color: var(--text-muted);
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            cursor: pointer;
        }
        .remember-label input {
            accent-color: var(--accent);
        }
        .submit-btn {
            width: 100%;
            background-color: var(--accent);
            color: #FFFFFF;
            border: none;
            padding: 0.85rem;
            border-radius: 3px;
            font-family: 'Geist Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .submit-btn:hover {
            background-color: #3B8AFF;
            transform: translateY(-1px);
        }
        .submit-btn:active {
            transform: translateY(1px);
        }
        .error-alert {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #F87171;
            padding: 0.75rem;
            border-radius: 3px;
            font-size: 12px;
            margin-bottom: 1.25rem;
            line-height: 1.4;
        }
        .footer-tag {
            text-align: center;
            margin-top: 1.5rem;
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            color: var(--text-muted);
            letter-spacing: 0.1em;
        }
        .footer-tag a {
            color: var(--text-muted);
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-header">
            <div class="hud-eyebrow">[ SECURE ADMIN CONSOLE · TERMINAL ]</div>
            <h1 class="brand-title">
                <span class="brand-logo-mark">❖</span>
                Magazine Afrique
            </h1>
        </div>

        <?php if (!empty($login_error)) : ?>
            <div class="error-alert">
                <?php echo wp_kses_post($login_error); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('artcraft_admin_login_action', 'artcraft_login_nonce'); ?>
            <input type="hidden" name="artcraft_login_submit" value="1">

            <div class="form-group">
                <label for="user_login" class="form-label">Username or Work Email</label>
                <input type="text" name="log" id="user_login" class="form-input" required autofocus autocomplete="username" placeholder="editor or admin@magazineafrique.org">
            </div>

            <div class="form-group">
                <label for="user_pass" class="form-label">Password</label>
                <input type="password" name="pwd" id="user_pass" class="form-input" required autocomplete="current-password" placeholder="••••••••••••">
            </div>

            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="rememberme" value="forever" checked>
                    <span>Keep terminal active</span>
                </label>
                <a href="<?php echo esc_url(home_url('/onboarding/?mode=login')); ?>" style="color: var(--accent-ink); text-decoration: none;">Reader Login ↗</a>
            </div>

            <button type="submit" class="submit-btn">
                <span>Enter Admin Workspace</span>
                <span>→</span>
            </button>
        </form>

        <div class="footer-tag">
            GATEWAY: /<?php echo esc_html(MAGAZINEAFRIQUE_SECRET_ADMIN_SLUG); ?> · ENCRYPTED
        </div>
    </div>

</body>
</html>
        <?php
    }
}
