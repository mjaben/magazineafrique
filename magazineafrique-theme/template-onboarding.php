<?php
/**
 * Template Name: Reader Onboarding & Sign In
 * Template Post Type: page
 *
 * @package MagazineAfrique
 */

get_header(); 

$is_login_mode = isset($_GET['mode']) && $_GET['mode'] === 'login';
if (trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') === 'login' || trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') === 'signin') {
    $is_login_mode = true;
}
?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 580px; margin: 0 auto; padding-top: 2rem; padding-bottom: 4rem;">

    <!-- Vintage Retro Card Container (Maintains Brand Colors with Hard-Shadow UI) -->
    <div class="vintage-retro-card" style="background-color: var(--bg-card, #FAF6EE); border: 2.5px solid #000000; border-radius: 4px; box-shadow: 6px 6px 0px #000000; overflow: hidden;">
        
        <!-- Retro Chevron Geometric Top Bar (Archival African Poster Motif) -->
        <div class="vintage-chevron-header" style="height: 36px; background: repeating-linear-gradient(-45deg, #8B2500, #8B2500 12px, #D97706 12px, #D97706 24px, #F59E0B 24px, #F59E0B 36px, #0B5128 36px, #0B5128 48px); border-bottom: 2.5px solid #000000;"></div>

        <!-- Mode Toggle Tabs (Sign In vs Join Circle) -->
        <div id="auth-mode-tab-bar" style="display: flex; border-bottom: 2.5px solid #000000; background: var(--bg-card-subtle, #EFE9DE);">
            <button type="button" id="tab-btn-signin" class="vintage-auth-tab <?php echo $is_login_mode ? 'active' : ''; ?>" style="flex: 1; padding: 0.95rem; font-family: 'JetBrains Mono', monospace; font-size: 0.8125rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; border: none; cursor: pointer; transition: all 0.15s ease;">
                [ ⎆ Sign In ]
            </button>
            <button type="button" id="tab-btn-signup" class="vintage-auth-tab <?php echo !$is_login_mode ? 'active' : ''; ?>" style="flex: 1; padding: 0.95rem; font-family: 'JetBrains Mono', monospace; font-size: 0.8125rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; border: none; cursor: pointer; transition: all 0.15s ease;">
                [ ✍ Sign Up ]
            </button>
        </div>

        <div style="padding: 2.25rem 1.85rem;">

            <!-- ========================================== -->
            <!-- 1. SIGN IN SCREEN                          -->
            <!-- ========================================== -->
            <div id="screen-signin" style="<?php echo $is_login_mode ? 'display: block;' : 'display: none;'; ?>">
                <div style="border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 1.25rem; margin-bottom: 1.75rem; text-align: center;">
                    <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #8B2500; font-family: 'JetBrains Mono', monospace; margin-bottom: 0.35rem;">
                        [ PAN-AFRICAN CORRESPONDENT DESK ]
                    </div>
                    <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(1.6rem, 3.5vw, 2.1rem); font-weight: 900; color: var(--text-primary, #171513); margin: 0 0 0.5rem; line-height: 1.2;">
                        Log In to Your Account
                    </h1>
                    <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                        Enter your username or email address and password to access your reader desk.
                    </p>
                </div>

                <form id="magazineafrique-login-form" style="display: flex; flex-direction: column; gap: 1.25rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                    
                    <!-- Username or Email -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.4rem;">
                            Username or Email Address *
                        </label>
                        <input type="text" name="log" required placeholder="kwamemensah or reader@domain.com" class="vintage-box-input" style="width: 100%; border: 2px solid #000000; box-shadow: 3px 3px 0px #000000;" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                            <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513);">
                                Password *
                            </label>
                            <button type="button" id="trigger-forgot-password-btn" style="background: none; border: none; font-size: 0.75rem; color: #8B2500; font-weight: 700; text-decoration: underline; cursor: pointer; padding: 0;">
                                Forgot Password?
                            </button>
                        </div>
                        <input type="password" name="pwd" required placeholder="••••••••••••" class="vintage-box-input" style="width: 100%; font-family: 'JetBrains Mono', monospace; border: 2px solid #000000; box-shadow: 3px 3px 0px #000000;" />
                    </div>

                    <!-- Remember Me -->
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="rememberme" id="login-rememberme" value="forever" checked style="accent-color: #8B2500; width: 17px; height: 17px;" />
                        <label for="login-rememberme" style="font-size: 0.8125rem; color: var(--text-secondary, #5C564E); font-weight: 600; cursor: pointer;">
                            Keep me logged in on this browser
                        </label>
                    </div>

                    <input type="hidden" name="redirect_to" value="<?php echo esc_url(isset($_GET['redirect_to']) ? $_GET['redirect_to'] : home_url('/profile/')); ?>" />

                    <!-- Submit Button (Hard Shadow UI Button with Brand Color) -->
                    <div style="margin-top: 0.5rem;">
                        <button type="submit" class="vintage-continue-btn" style="width: 100%; padding: 0.95rem; font-size: 0.9375rem; background-color: #8B2500; color: #FFFFFF; font-weight: 800; letter-spacing: 0.06em; border: 2.5px solid #000000; box-shadow: 5px 5px 0px #000000; border-radius: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <span>Continue</span> <span>»</span>
                        </button>
                    </div>

                    <!-- Switch to Sign Up -->
                    <div style="text-align: center; margin-top: 0.5rem; font-size: 0.8125rem; color: var(--text-secondary, #5C564E);">
                        Not registered yet? 
                        <button type="button" id="switch-to-signup-btn" style="background: none; border: none; color: #D97706; font-weight: 800; text-decoration: underline; cursor: pointer; padding: 0 0.25rem;">
                            Sign Up
                        </button>
                    </div>

                    <div class="login-feedback" style="text-align: center; font-size: 0.8125rem;"></div>
                </form>
            </div>

            <!-- ========================================== -->
            <!-- 2. SIGN UP / REGISTRATION SCREEN           -->
            <!-- ========================================== -->
            <div id="screen-signup" style="<?php echo !$is_login_mode ? 'display: block;' : 'display: none;'; ?>">
                <div style="border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 1.25rem; margin-bottom: 1.75rem; text-align: center;">
                    <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #8B2500; font-family: 'JetBrains Mono', monospace; margin-bottom: 0.35rem;">
                        [ READER ENROLLMENT &amp; VERIFICATION ]
                    </div>
                    <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(1.6rem, 3.5vw, 2.1rem); font-weight: 900; color: var(--text-primary, #171513); margin: 0 0 0.5rem; line-height: 1.2;">
                        Join the Pan-African Reader Circle
                    </h1>
                    <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                        Create your reader profile. A single-use verification code will be sent to authenticate your account.
                    </p>
                </div>

                <form id="magazineafrique-onboarding-form" style="display: flex; flex-direction: column; gap: 1.25rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                    
                    <!-- First & Last Name -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                                First Name *
                            </label>
                            <input type="text" name="first_name" required placeholder="Kwame" class="vintage-box-input" style="width: 100%; border: 2px solid #000000; box-shadow: 3px 3px 0px #000000;" />
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                                Last Name *
                            </label>
                            <input type="text" name="last_name" required placeholder="Mensah" class="vintage-box-input" style="width: 100%; border: 2px solid #000000; box-shadow: 3px 3px 0px #000000;" />
                        </div>
                    </div>

                    <!-- Username & Email -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                                Username *
                            </label>
                            <input type="text" name="username" required placeholder="kwamemensah" class="vintage-box-input" style="width: 100%; font-family: 'JetBrains Mono', monospace; border: 2px solid #000000; box-shadow: 3px 3px 0px #000000;" />
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                                Email Address *
                            </label>
                            <input type="email" name="email" required placeholder="kwame@enterprise.africa" class="vintage-box-input" style="width: 100%; border: 2px solid #000000; box-shadow: 3px 3px 0px #000000;" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Password *
                        </label>
                        <input type="password" name="password" required placeholder="Minimum 6 characters" class="vintage-box-input" style="width: 100%; font-family: 'JetBrains Mono', monospace; border: 2px solid #000000; box-shadow: 3px 3px 0px #000000;" />
                    </div>

                    <!-- Gender -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Gender
                        </label>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; font-size: 0.8125rem;">
                            <label class="vintage-box" style="padding: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.35rem; cursor: pointer; font-weight: 600; border: 2px solid #000000; box-shadow: 2px 2px 0px #000000;">
                                <input type="radio" name="gender" value="Male" style="accent-color: #8B2500;" /> Male
                            </label>
                            <label class="vintage-box" style="padding: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.35rem; cursor: pointer; font-weight: 600; border: 2px solid #000000; box-shadow: 2px 2px 0px #000000;">
                                <input type="radio" name="gender" value="Female" style="accent-color: #8B2500;" /> Female
                            </label>
                            <label class="vintage-box" style="padding: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.35rem; cursor: pointer; font-weight: 600; border: 2px solid #000000; box-shadow: 2px 2px 0px #000000;">
                                <input type="radio" name="gender" value="Prefer not to say" checked style="accent-color: #8B2500;" /> Other
                            </label>
                        </div>
                    </div>

                    <!-- Auto-Location Section -->
                    <div class="vintage-box" style="background-color: var(--bg-card-subtle, #EFE9DE); border: 2px solid #000000; box-shadow: 3px 3px 0px #000000; padding: 1.15rem; margin-top: 0.25rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.35rem; font-weight: 800; font-size: 0.6875rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513);">
                                <span>📍</span> Reader Location (Auto-Detect)
                            </div>
                            <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #0B5128; background: #D1E7DD; padding: 0.15rem 0.4rem; border: 1px solid #0B5128; border-radius: 2px;">
                                Wire Personalization
                            </span>
                        </div>

                        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <input type="text" id="reader-location-input" name="location" placeholder="Detecting your location..." class="vintage-box-input" style="flex: 1; font-weight: 600; border: 2px solid #000000; box-shadow: 2px 2px 0px #000000;" />
                            <input type="hidden" id="reader-country-input" name="country" value="" />
                            <input type="hidden" id="reader-city-input" name="city" value="" />
                            <button type="button" id="btn-trigger-detect" class="btn-vintage-box" style="white-space: nowrap; padding: 0.5rem 0.85rem; font-size: 0.6875rem; background: var(--bg-card, #FAF6EE); color: var(--text-primary, #171513); border: 2px solid #000000; box-shadow: 2px 2px 0px #000000;">
                                🎯 Auto-Detect
                            </button>
                        </div>

                        <div id="location-detect-status" style="font-size: 0.6875rem; font-family: 'JetBrains Mono', monospace; color: #0B5128;">
                            ● Querying location via GPS or network IP...
                        </div>
                    </div>

                    <!-- Continue Button (Hard Shadow UI Button with Brand Color) -->
                    <div style="margin-top: 0.75rem;">
                        <button type="submit" class="vintage-continue-btn" style="width: 100%; padding: 0.95rem; font-size: 0.9375rem; background-color: #0B5128; color: #FFFFFF; font-weight: 800; letter-spacing: 0.06em; border: 2.5px solid #000000; box-shadow: 5px 5px 0px #000000; border-radius: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <span>Continue</span> <span>»</span>
                        </button>
                    </div>

                    <!-- Switch to Log In -->
                    <div style="text-align: center; margin-top: 0.5rem; font-size: 0.8125rem; color: var(--text-secondary, #5C564E);">
                        Already have an account? 
                        <button type="button" id="switch-to-signin-btn" style="background: none; border: none; color: #8B2500; font-weight: 800; text-decoration: underline; cursor: pointer; padding: 0 0.25rem;">
                            Log In
                        </button>
                    </div>

                    <div class="signup-feedback" style="text-align: center; font-size: 0.8125rem;"></div>
                </form>
            </div>

            <!-- ========================================== -->
            <!-- 3. VERIFY OTP SCREEN (MATCHES USER MOCKUP) -->
            <!-- ========================================== -->
            <div id="screen-verify-otp" style="display: none;">
                <div style="border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 1.25rem; margin-bottom: 1.75rem; text-align: center;">
                    <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #8B2500; font-family: 'JetBrains Mono', monospace; margin-bottom: 0.35rem;">
                        [ VERIFY READER CODE ]
                    </div>
                    <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(1.6rem, 3.5vw, 2.1rem); font-weight: 900; color: var(--text-primary, #171513); margin: 0 0 0.5rem; line-height: 1.2;">
                        Verify Code
                    </h1>
                    <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                        Code is sent to <strong id="otp-target-display" style="color: var(--text-primary, #171513);">your email address</strong>
                    </p>
                </div>

                <form id="magazineafrique-verify-otp-form" style="display: flex; flex-direction: column; gap: 1.5rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                    
                    <!-- 4 Square OTP Boxes with Crisp Black Border & Hard Shadow -->
                    <div style="display: flex; justify-content: center; gap: 0.85rem; margin: 0.5rem 0;">
                        <input type="text" maxlength="1" inputmode="numeric" class="vintage-otp-digit" id="otp-1" data-index="1" autofocus style="width: 60px; height: 60px; text-align: center; font-size: 26px; font-weight: 900; font-family: 'JetBrains Mono', monospace; border: 2.5px solid #000000; box-shadow: 4px 4px 0px #000000; border-radius: 3px; background: var(--bg-card, #FFFDF8); color: var(--text-primary, #171513);" />
                        <input type="text" maxlength="1" inputmode="numeric" class="vintage-otp-digit" id="otp-2" data-index="2" style="width: 60px; height: 60px; text-align: center; font-size: 26px; font-weight: 900; font-family: 'JetBrains Mono', monospace; border: 2.5px solid #000000; box-shadow: 4px 4px 0px #000000; border-radius: 3px; background: var(--bg-card, #FFFDF8); color: var(--text-primary, #171513);" />
                        <input type="text" maxlength="1" inputmode="numeric" class="vintage-otp-digit" id="otp-3" data-index="3" style="width: 60px; height: 60px; text-align: center; font-size: 26px; font-weight: 900; font-family: 'JetBrains Mono', monospace; border: 2.5px solid #000000; box-shadow: 4px 4px 0px #000000; border-radius: 3px; background: var(--bg-card, #FFFDF8); color: var(--text-primary, #171513);" />
                        <input type="text" maxlength="1" inputmode="numeric" class="vintage-otp-digit" id="otp-4" data-index="4" style="width: 60px; height: 60px; text-align: center; font-size: 26px; font-weight: 900; font-family: 'JetBrains Mono', monospace; border: 2.5px solid #000000; box-shadow: 4px 4px 0px #000000; border-radius: 3px; background: var(--bg-card, #FFFDF8); color: var(--text-primary, #171513);" />
                    </div>

                    <!-- Resend Countdown (Matching User Image: "RESEND After 60 Seconds") -->
                    <div style="text-align: center; font-size: 0.75rem; font-family: 'JetBrains Mono', monospace;">
                        <span id="resend-label" style="color: var(--text-secondary, #5C564E);">
                            RESEND Code After <span id="resend-countdown" style="font-weight: 800; color: #8B2500;">60</span> Seconds
                        </span>
                        <button type="button" id="btn-resend-otp" style="display: none; background: none; border: none; color: #8B2500; font-weight: 800; text-decoration: underline; cursor: pointer; padding: 0;">
                            Resend Code Now
                        </button>
                    </div>

                    <!-- Continue Button -->
                    <div>
                        <button type="submit" class="vintage-continue-btn" style="width: 100%; padding: 0.95rem; font-size: 0.9375rem; background-color: #0B5128; color: #FFFFFF; font-weight: 800; letter-spacing: 0.06em; border: 2.5px solid #000000; box-shadow: 5px 5px 0px #000000; border-radius: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <span>Continue</span> <span>»</span>
                        </button>
                    </div>

                    <div class="verify-feedback" style="text-align: center; font-size: 0.8125rem;"></div>
                </form>
            </div>

            <!-- ========================================== -->
            <!-- 4. FORGOT PASSWORD (REQUEST OTP)           -->
            <!-- ========================================== -->
            <div id="screen-forgot-password" style="display: none;">
                <div style="border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 1.25rem; margin-bottom: 1.75rem; text-align: center;">
                    <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #8B2500; font-family: 'JetBrains Mono', monospace; margin-bottom: 0.35rem;">
                        [ RECOVER READER CREDENTIALS ]
                    </div>
                    <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(1.6rem, 3.5vw, 2.1rem); font-weight: 900; color: var(--text-primary, #171513); margin: 0 0 0.5rem; line-height: 1.2;">
                        Reset Password
                    </h1>
                    <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                        Enter your username or email address. We will dispatch a 4-digit security code to verify your identity.
                    </p>
                </div>

                <form id="magazineafrique-forgot-form" style="display: flex; flex-direction: column; gap: 1.25rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.4rem;">
                            Username or Email Address *
                        </label>
                        <input type="text" name="user_input" required placeholder="kwamemensah or reader@domain.com" class="vintage-box-input" style="width: 100%; border: 2px solid #000000; box-shadow: 3px 3px 0px #000000;" />
                    </div>

                    <div>
                        <button type="submit" class="vintage-continue-btn" style="width: 100%; padding: 0.95rem; font-size: 0.9375rem; background-color: #8B2500; color: #FFFFFF; font-weight: 800; letter-spacing: 0.06em; border: 2.5px solid #000000; box-shadow: 5px 5px 0px #000000; border-radius: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <span>Continue (Send Code)</span> <span>»</span>
                        </button>
                    </div>

                    <div style="text-align: center; margin-top: 0.5rem; font-size: 0.8125rem;">
                        <button type="button" id="back-to-login-btn" style="background: none; border: none; color: #8B2500; font-weight: 800; text-decoration: underline; cursor: pointer; padding: 0;">
                            « Back to Log In
                        </button>
                    </div>

                    <div class="forgot-feedback" style="text-align: center; font-size: 0.8125rem;"></div>
                </form>
            </div>

            <!-- ========================================== -->
            <!-- 5. VERIFY RESET OTP & ENTER NEW PASSWORD   -->
            <!-- ========================================== -->
            <div id="screen-reset-password-verify" style="display: none;">
                <div style="border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 1.25rem; margin-bottom: 1.75rem; text-align: center;">
                    <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #8B2500; font-family: 'JetBrains Mono', monospace; margin-bottom: 0.35rem;">
                        [ ESTABLISH NEW CREDENTIALS ]
                    </div>
                    <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(1.6rem, 3.5vw, 2.1rem); font-weight: 900; color: var(--text-primary, #171513); margin: 0 0 0.5rem; line-height: 1.2;">
                        Verify &amp; Set New Password
                    </h1>
                    <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                        Enter the 4-digit code sent to your email along with your new password.
                    </p>
                </div>

                <form id="magazineafrique-reset-verify-form" style="display: flex; flex-direction: column; gap: 1.25rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                    
                    <!-- 4 Square OTP Boxes -->
                    <div style="display: flex; justify-content: center; gap: 0.85rem; margin: 0.5rem 0;">
                        <input type="text" maxlength="1" inputmode="numeric" class="vintage-otp-digit" id="reset-otp-1" data-index="1" style="width: 60px; height: 60px; text-align: center; font-size: 26px; font-weight: 900; font-family: 'JetBrains Mono', monospace; border: 2.5px solid #000000; box-shadow: 4px 4px 0px #000000; border-radius: 3px; background: var(--bg-card, #FFFDF8); color: var(--text-primary, #171513);" />
                        <input type="text" maxlength="1" inputmode="numeric" class="vintage-otp-digit" id="reset-otp-2" data-index="2" style="width: 60px; height: 60px; text-align: center; font-size: 26px; font-weight: 900; font-family: 'JetBrains Mono', monospace; border: 2.5px solid #000000; box-shadow: 4px 4px 0px #000000; border-radius: 3px; background: var(--bg-card, #FFFDF8); color: var(--text-primary, #171513);" />
                        <input type="text" maxlength="1" inputmode="numeric" class="vintage-otp-digit" id="reset-otp-3" data-index="3" style="width: 60px; height: 60px; text-align: center; font-size: 26px; font-weight: 900; font-family: 'JetBrains Mono', monospace; border: 2.5px solid #000000; box-shadow: 4px 4px 0px #000000; border-radius: 3px; background: var(--bg-card, #FFFDF8); color: var(--text-primary, #171513);" />
                        <input type="text" maxlength="1" inputmode="numeric" class="vintage-otp-digit" id="reset-otp-4" data-index="4" style="width: 60px; height: 60px; text-align: center; font-size: 26px; font-weight: 900; font-family: 'JetBrains Mono', monospace; border: 2.5px solid #000000; box-shadow: 4px 4px 0px #000000; border-radius: 3px; background: var(--bg-card, #FFFDF8); color: var(--text-primary, #171513);" />
                    </div>

                    <!-- New Password Input -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.4rem;">
                            New Password (Minimum 6 Characters) *
                        </label>
                        <input type="password" name="new_password" required placeholder="••••••••••••" class="vintage-box-input" style="width: 100%; font-family: 'JetBrains Mono', monospace; border: 2px solid #000000; box-shadow: 3px 3px 0px #000000;" />
                    </div>

                    <div>
                        <button type="submit" class="vintage-continue-btn" style="width: 100%; padding: 0.95rem; font-size: 0.9375rem; background-color: #8B2500; color: #FFFFFF; font-weight: 800; letter-spacing: 0.06em; border: 2.5px solid #000000; box-shadow: 5px 5px 0px #000000; border-radius: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <span>Continue (Update Password)</span> <span>»</span>
                        </button>
                    </div>

                    <div class="reset-feedback" style="text-align: center; font-size: 0.8125rem;"></div>
                </form>
            </div>

        </div>

    </div>

</main>

<script src="<?php echo esc_url(get_theme_file_uri('/assets/js/onboarding.js')); ?>"></script>

<?php get_footer(); ?>
