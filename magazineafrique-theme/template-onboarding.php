<?php
/**
 * Template Name: Reader Onboarding
 * Template Post Type: page
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 680px; margin: 0 auto; padding-top: 2rem; padding-bottom: 3rem;">

    <div class="vintage-framed-box" style="background-color: var(--bg-card, #FAF6EE); border: 2px solid var(--border-color, #231F1D); border-radius: 4px; box-shadow: 4px 4px 0px var(--vintage-box-shadow, #1C1917); overflow: hidden;">
        
        <!-- Vintage Retro Geometric Chevron Header (Inspired by Archival African Posters) -->
        <div class="vintage-chevron-header" style="height: 48px; background: repeating-linear-gradient(-45deg, #8B2500, #8B2500 12px, #D97706 12px, #D97706 24px, #F59E0B 24px, #F59E0B 36px, #0B5128 36px, #0B5128 48px); border-bottom: 2px solid #231F1D;"></div>

        <div style="padding: 2rem 1.75rem;">
            <!-- Header -->
            <div style="border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 1.25rem; margin-bottom: 1.75rem; text-align: center;">
                <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #8B2500; font-family: 'JetBrains Mono', monospace; margin-bottom: 0.35rem;">
                    [ READER ENROLLMENT &amp; VERIFICATION ]
                </div>
                <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(1.6rem, 3.5vw, 2.3rem); font-weight: 900; color: var(--text-primary, #171513); margin: 0 0 0.5rem; line-height: 1.2;">
                    Join the Pan-African Reader Circle
                </h1>
                <p style="font-size: 0.875rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                    Configure your correspondent profile to receive localized dispatches, follow continental desks, and save exclusive investigative dossiers.
                </p>
            </div>

            <!-- Onboarding Form -->
            <form id="magazineafrique-onboarding-form" style="display: flex; flex-direction: column; gap: 1.25rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                
                <!-- First & Last Name -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            First Name *
                        </label>
                        <input type="text" name="first_name" required placeholder="Kwame" class="vintage-box-input" style="width: 100%;" />
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Last Name *
                        </label>
                        <input type="text" name="last_name" required placeholder="Mensah" class="vintage-box-input" style="width: 100%;" />
                    </div>
                </div>

                <!-- Username & Email -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Username *
                        </label>
                        <input type="text" name="username" required placeholder="kwamemensah" class="vintage-box-input" style="width: 100%; font-family: 'JetBrains Mono', monospace;" />
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Email Address *
                        </label>
                        <input type="email" name="email" required placeholder="kwame@enterprise.africa" class="vintage-box-input" style="width: 100%;" />
                    </div>
                </div>

                <!-- Gender -->
                <div>
                    <label style="display: block; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                        Gender
                    </label>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; font-size: 0.8125rem;">
                        <label class="vintage-box" style="padding: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.35rem; cursor: pointer; font-weight: 600;">
                            <input type="radio" name="gender" value="Male" style="accent-color: #8B2500;" /> Male
                        </label>
                        <label class="vintage-box" style="padding: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.35rem; cursor: pointer; font-weight: 600;">
                            <input type="radio" name="gender" value="Female" style="accent-color: #8B2500;" /> Female
                        </label>
                        <label class="vintage-box" style="padding: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.35rem; cursor: pointer; font-weight: 600;">
                            <input type="radio" name="gender" value="Prefer not to say" checked style="accent-color: #8B2500;" /> Other
                        </label>
                    </div>
                </div>

                <!-- Auto-Location Section (Vintage Box Style) -->
                <div class="vintage-box" style="background-color: var(--bg-card-subtle, #EFE9DE); padding: 1.15rem; margin-top: 0.5rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.35rem; font-weight: 800; font-size: 0.6875rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513);">
                            <span>📍</span> Reader Location (Auto-Detect)
                        </div>
                        <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #0B5128; background: #D1E7DD; padding: 0.15rem 0.4rem; border-radius: 2px;">
                            Wire Personalization
                        </span>
                    </div>

                    <p style="font-size: 0.75rem; color: var(--text-secondary, #5C564E); margin: 0 0 0.75rem; line-height: 1.45;">
                        Your geographic location enables our newsroom to deliver priority stories from your continental hub (West Africa, Sahel, East Africa, Southern Africa, North Africa, or Diaspora).
                    </p>

                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <input type="text" id="reader-location-input" name="location" placeholder="Detecting your location..." class="vintage-box-input" style="flex: 1; font-weight: 600;" />
                        <input type="hidden" id="reader-country-input" name="country" value="" />
                        <input type="hidden" id="reader-city-input" name="city" value="" />
                        <button type="button" id="btn-trigger-detect" class="btn-vintage-box" style="white-space: nowrap; padding: 0.5rem 0.85rem; font-size: 0.6875rem; background: #FAF6EE; color: #171513;">
                            🎯 Auto-Detect
                        </button>
                    </div>

                    <div id="location-detect-status" style="font-size: 0.6875rem; font-family: 'JetBrains Mono', monospace; color: #0B5128;">
                        ● Querying location via GPS or network IP...
                    </div>
                </div>

                <!-- Submit Button (Vintage Hard Shadow Box Button) -->
                <div style="margin-top: 0.75rem;">
                    <button type="submit" class="btn-vintage-box" style="width: 100%; padding: 0.95rem; font-size: 0.875rem; background-color: #D97706; color: #FFFFFF; font-weight: 800; letter-spacing: 0.08em;">
                        Continue &amp; Access Pan-African Wire »
                    </button>
                </div>

                <div class="form-feedback" style="text-align: center; font-size: 0.8125rem;"></div>

            </form>
        </div>

    </div>

</main>

<script src="<?php echo esc_url(get_theme_file_uri('/assets/js/onboarding.js')); ?>"></script>

<?php get_footer(); ?>
