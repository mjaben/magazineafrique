<?php
/**
 * Template Name: Reader Onboarding
 * Template Post Type: page
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 680px; margin: 0 auto; padding-top: 2rem;">

    <div class="vintage-framed-box" style="background-color: #F6F1E8; border: 2px solid #231F1D; padding: 2rem 1.5rem; border-radius: 4px; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
        
        <!-- Header -->
        <div style="border-bottom: 2px solid #231F1D; padding-bottom: 1rem; margin-bottom: 1.5rem; text-align: center;">
            <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #8B2500; font-family: 'Plus Jakarta Sans', sans-serif; margin-bottom: 0.25rem;">
                Reader Enrollment &amp; Verification
            </div>
            <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(1.6rem, 3.5vw, 2.2rem); font-weight: 900; color: #171513; margin: 0 0 0.5rem; line-height: 1.2;">
                Join the Pan-African Reader Circle
            </h1>
            <p style="font-size: 0.875rem; color: #5C564E; margin: 0; line-height: 1.5;">
                Configure your reading profile to unlock localized regional dispatches, tailored continental analysis, and save investigative dossiers.
            </p>
        </div>

        <!-- Onboarding Form -->
        <form id="magazineafrique-onboarding-form" style="display: flex; flex-direction: column; gap: 1.25rem; font-family: 'Plus Jakarta Sans', sans-serif;">
            
            <!-- First & Last Name -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #171513; margin-bottom: 0.35rem;">
                        First Name *
                    </label>
                    <input type="text" name="first_name" required placeholder="e.g. Kwame" class="circular-notice-input" style="width: 100%;" />
                </div>
                <div>
                    <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #171513; margin-bottom: 0.35rem;">
                        Last Name *
                    </label>
                    <input type="text" name="last_name" required placeholder="e.g. Mensah" class="circular-notice-input" style="width: 100%;" />
                </div>
            </div>

            <!-- Username & Email -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #171513; margin-bottom: 0.35rem;">
                        Username *
                    </label>
                    <input type="text" name="username" required placeholder="kwamemensah" class="circular-notice-input" style="width: 100%; font-family: 'JetBrains Mono', monospace;" />
                </div>
                <div>
                    <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #171513; margin-bottom: 0.35rem;">
                        Email Address *
                    </label>
                    <input type="email" name="email" required placeholder="kwame@enterprise.africa" class="circular-notice-input" style="width: 100%;" />
                </div>
            </div>

            <!-- Gender -->
            <div>
                <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #171513; margin-bottom: 0.35rem;">
                    Gender
                </label>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; font-size: 0.8125rem;">
                    <label style="border: 1px solid #231F1D; background: #FFFFFF; padding: 0.5rem; border-radius: 2px; display: flex; align-items: center; justify-content: center; gap: 0.35rem; cursor: pointer; font-weight: 600;">
                        <input type="radio" name="gender" value="Male" style="accent-color: #8B2500;" /> Male
                    </label>
                    <label style="border: 1px solid #231F1D; background: #FFFFFF; padding: 0.5rem; border-radius: 2px; display: flex; align-items: center; justify-content: center; gap: 0.35rem; cursor: pointer; font-weight: 600;">
                        <input type="radio" name="gender" value="Female" style="accent-color: #8B2500;" /> Female
                    </label>
                    <label style="border: 1px solid #231F1D; background: #FFFFFF; padding: 0.5rem; border-radius: 2px; display: flex; align-items: center; justify-content: center; gap: 0.35rem; cursor: pointer; font-weight: 600;">
                        <input type="radio" name="gender" value="Prefer not to say" checked style="accent-color: #8B2500;" /> Other
                    </label>
                </div>
            </div>

            <!-- Auto-Location Section -->
            <div style="border: 2px solid #231F1D; background-color: #EFE9DE; padding: 1rem; border-radius: 3px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.35rem; font-weight: 800; font-size: 0.6875rem; text-transform: uppercase; letter-spacing: 0.08em; color: #171513;">
                        <span>📍</span> Reader Location (Auto-Detect)
                    </div>
                    <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #0B5128; background: #D1E7DD; padding: 0.15rem 0.4rem; border-radius: 2px;">
                        News Personalization
                    </span>
                </div>

                <p style="font-size: 0.75rem; color: #5C564E; margin: 0 0 0.75rem; line-height: 1.45;">
                    Your location allows our editorial desk to deliver priority stories from your geographic hub (West Africa, Sahel, East Africa, Southern Africa, North Africa, or the Diaspora).
                </p>

                <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <input type="text" id="reader-location-input" name="location" placeholder="Detecting your location..." class="circular-notice-input" style="flex: 1; font-weight: 600;" />
                    <input type="hidden" id="reader-country-input" name="country" value="" />
                    <input type="hidden" id="reader-city-input" name="city" value="" />
                    <button type="button" id="btn-trigger-detect" class="circular-notice-btn" style="white-space: nowrap; padding: 0.5rem 0.85rem; font-size: 0.6875rem;">
                        🎯 Auto-Detect
                    </button>
                </div>

                <div id="location-detect-status" style="font-size: 0.6875rem; font-family: 'JetBrains Mono', monospace; color: #0B5128;">
                    ● Querying location via GPS or network IP...
                </div>
            </div>

            <!-- Submit -->
            <div style="margin-top: 0.5rem;">
                <button type="submit" class="circular-notice-btn" style="width: 100%; padding: 0.85rem; font-size: 0.8125rem; background-color: #8B2500; font-weight: 900; letter-spacing: 0.08em;">
                    Complete Enrollment &amp; View Personalized Dispatches →
                </button>
            </div>

            <div class="form-feedback" style="text-align: center; font-size: 0.8125rem;"></div>

        </form>

    </div>

</main>

<script src="<?php echo esc_url(get_theme_file_uri('/assets/js/onboarding.js')); ?>"></script>

<?php get_footer(); ?>
