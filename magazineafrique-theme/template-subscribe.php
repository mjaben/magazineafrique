<?php
/**
 * Template Name: Subscription & Club Prestige Plans
 * Template Post Type: page
 *
 * @package MagazineAfrique
 */

get_header(); 

$user_id = get_current_user_id();
$country_code = !empty($_SERVER['HTTP_CF_IPCOUNTRY']) ? strtoupper(sanitize_text_field($_SERVER['HTTP_CF_IPCOUNTRY'])) : '';
$reader_loc = function_exists('magazineafrique_get_reader_location') ? magazineafrique_get_reader_location() : '';

// Detect Nigeria from Cloudflare IP, User Profile, or Session Location
$is_nigeria = ($country_code === 'NG' || stripos($reader_loc, 'Lagos') !== false || stripos($reader_loc, 'Nigeria') !== false);

if (is_user_logged_in()) {
    $u_country = get_user_meta($user_id, 'reader_country', true);
    if (strcasecmp($u_country, 'Nigeria') === 0 || strcasecmp($u_country, 'NG') === 0) {
        $is_nigeria = true;
    }
}

// Allow explicit toggle via URL (?currency=ngn or ?currency=usd)
if (isset($_GET['currency'])) {
    $is_nigeria = (strtolower($_GET['currency']) === 'ngn');
}
?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 1040px; margin: 0 auto; padding-top: 2rem; padding-bottom: 4rem;">

    <!-- Masthead Intro -->
    <div style="text-align: center; border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 1.5rem; margin-bottom: 2.5rem;">
        <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #8B2500; font-family: 'JetBrains Mono', monospace; margin-bottom: 0.4rem;">
            ★ The Intellectual Gazette Syndicate · Subscriptions
        </div>
        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: clamp(2rem, 4vw, 2.75rem); font-weight: 900; color: var(--text-primary, #171513); margin: 0 0 0.75rem; line-height: 1.15;">
            Join Club Magazine Afrique Prestige
        </h1>
        <p style="font-size: 1rem; color: var(--text-secondary, #5C564E); max-width: 640px; margin: 0 auto 1.5rem; line-height: 1.6;">
            Support independent Pan-African investigative journalism and unlock classified corridors-of-power intelligence, proprietary business data, and video opinion participation.
        </p>

        <!-- Dynamic Currency Selector & Location Badge -->
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: var(--bg-card-subtle, #EFE9DE); padding: 0.35rem 0.5rem; border: 1.5px solid var(--border-color, #231F1D); border-radius: 4px; box-shadow: 2px 2px 0px var(--border-color, #231F1D);">
            <button type="button" id="curr-btn-ngn" onclick="switchCurrency('ngn')" class="currency-toggle-btn <?php echo $is_nigeria ? 'active' : ''; ?>" style="border: none; padding: 0.35rem 0.85rem; font-family: 'Geist Mono', monospace; font-size: 0.75rem; font-weight: 800; border-radius: 2px; cursor: pointer; transition: all 0.15s ease;">
                🇳🇬 Nigeria (₦ NGN)
            </button>
            <button type="button" id="curr-btn-usd" onclick="switchCurrency('usd')" class="currency-toggle-btn <?php echo !$is_nigeria ? 'active' : ''; ?>" style="border: none; padding: 0.35rem 0.85rem; font-family: 'Geist Mono', monospace; font-size: 0.75rem; font-weight: 800; border-radius: 2px; cursor: pointer; transition: all 0.15s ease;">
                🌐 International ($ USD)
            </button>
        </div>
        <div id="currency-notice-text" style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); margin-top: 0.5rem;">
            <?php echo $is_nigeria ? '✓ Showing regional pricing in Nigerian Naira (₦)' : '✓ Showing international pricing in US Dollars ($)'; ?>
        </div>
    </div>

    <!-- Core Subscriber Benefits Grid (The 5 Pillars) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; margin-bottom: 3rem;">
        
        <!-- Pillar 1 -->
        <div class="vintage-framed-box" style="background-color: var(--bg-card-subtle, #EFE9DE); border: 1.5px solid var(--border-color, #231F1D); padding: 1.25rem; border-radius: 3px;">
            <div style="font-size: 1.25rem; margin-bottom: 0.4rem;">📰</div>
            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.125rem; font-weight: 800; color: var(--text-primary, #171513); margin: 0 0 0.35rem;">
                Exclusive In-Depth News
            </h3>
            <p style="font-size: 0.8125rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                Unrestricted access to all deep investigative dossiers, offshore corporate audits, and cross-border geopolitical exposés.
            </p>
        </div>

        <!-- Pillar 2 -->
        <div class="vintage-framed-box" style="background-color: var(--bg-card-subtle, #EFE9DE); border: 1.5px solid var(--border-color, #231F1D); padding: 1.25rem; border-radius: 3px;">
            <div style="font-size: 1.25rem; margin-bottom: 0.4rem;">🚫</div>
            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.125rem; font-weight: 800; color: var(--text-primary, #171513); margin: 0 0 0.35rem;">
                100% Ad-Free Reading
            </h3>
            <p style="font-size: 0.8125rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                A distraction-free, zero-ad broadsheet layout across mobile, tablet, and desktop for pure literary immersion.
            </p>
        </div>

        <!-- Pillar 3 -->
        <div class="vintage-framed-box" style="background-color: var(--bg-card-subtle, #EFE9DE); border: 1.5px solid var(--border-color, #231F1D); padding: 1.25rem; border-radius: 3px;">
            <div style="font-size: 1.25rem; margin-bottom: 0.4rem;">🎥</div>
            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.125rem; font-weight: 800; color: var(--text-primary, #171513); margin: 0 0 0.35rem;">
                Video Opinions Feature
            </h3>
            <p style="font-size: 0.8125rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                Get featured on our video news format to give your verified opinion on continental affairs and join monthly reader roundtables.
            </p>
        </div>

        <!-- Pillar 4 -->
        <div class="vintage-framed-box" style="background-color: var(--bg-card-subtle, #EFE9DE); border: 1.5px solid var(--border-color, #231F1D); padding: 1.25rem; border-radius: 3px;">
            <div style="font-size: 1.25rem; margin-bottom: 0.4rem;">📊</div>
            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.125rem; font-weight: 800; color: var(--text-primary, #171513); margin: 0 0 0.35rem;">
                Exclusive Business Data
            </h3>
            <p style="font-size: 0.8125rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                Download proprietary African commodities indices, mineral concession records, sovereign debt matrices, and private equity trackers.
            </p>
        </div>

        <!-- Pillar 5 -->
        <div class="vintage-framed-box" style="background-color: var(--bg-card-subtle, #EFE9DE); border: 1.5px solid var(--border-color, #231F1D); padding: 1.25rem; border-radius: 3px;">
            <div style="font-size: 1.25rem; margin-bottom: 0.4rem;">🏛️</div>
            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.125rem; font-weight: 800; color: var(--text-primary, #171513); margin: 0 0 0.35rem;">
                Political Rumors &amp; Whispers
            </h3>
            <p style="font-size: 0.8125rem; color: var(--text-secondary, #5C564E); margin: 0; line-height: 1.5;">
                First-hand political rumors, leaked cabinet cables, and off-the-record diplomatic whispers from Abuja, Dakar, Nairobi, and Pretoria.
            </p>
        </div>

    </div>

    <!-- 3 Pricing Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; align-items: stretch; margin-bottom: 3.5rem;">
        
        <!-- Tier 1: Digital Reader -->
        <div class="vintage-framed-box" style="background-color: var(--bg-card, #F6F1E8); border: 2px solid var(--border-color, #231F1D); padding: 2rem 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary, #5C564E); font-family: 'JetBrains Mono', monospace;">
                    Standard Plan
                </div>
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.4rem; font-weight: 900; color: var(--text-primary, #171513); margin: 0.25rem 0 0.5rem;">
                    Digital Gazette
                </h3>
                <div style="font-family: 'Playfair Display', Georgia, serif; font-size: 2.25rem; font-weight: 900; color: var(--text-primary, #171513); margin-bottom: 1rem;">
                    <span class="price-val-ngn" style="<?php echo $is_nigeria ? 'display: inline;' : 'display: none;'; ?>">₦3,500</span>
                    <span class="price-val-usd" style="<?php echo !$is_nigeria ? 'display: inline;' : 'display: none;'; ?>">$4.99</span>
                    <span style="font-size: 0.875rem; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; color: var(--text-secondary, #5C564E);">/ month</span>
                </div>
                <ul style="list-style: none; padding: 0; margin: 0 0 1.5rem; font-size: 0.8125rem; color: var(--text-secondary, #38332C); display: flex; flex-direction: column; gap: 0.5rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                    <li>✓ Complete investigative news archive</li>
                    <li>✓ 100% Ad-Free reading experience</li>
                    <li>✓ Weekly Africa Brief Wire by email</li>
                    <li>✓ Bookmark &amp; follow unlimited topics</li>
                </ul>
            </div>
            <a href="mailto:membership@magazineafrique.org?subject=Digital%20Gazette%20Subscription" class="btn-vintage-box" style="display: block; text-align: center; text-decoration: none; padding: 0.75rem; background: var(--bg-card); color: var(--text-primary);">
                Select Digital Plan
            </a>
        </div>

        <!-- Tier 2: Club Prestige (Recommended / Featured) -->
        <div class="vintage-framed-box" style="background-color: #072213; color: #FAF7F2; border: 3px solid #D97706; padding: 2rem 1.5rem; display: flex; flex-direction: column; justify-content: space-between; transform: scale(1.02); box-shadow: 4px 4px 0px var(--vintage-box-shadow, #1C1917);">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                    <span style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #F59E0B; font-family: 'JetBrains Mono', monospace;">
                        ★ Most Prestigious
                    </span>
                    <span style="background-color: #D97706; color: #FFFFFF; font-size: 0.625rem; font-weight: 800; padding: 0.15rem 0.4rem; border-radius: 2px;">
                        ALL ACCESS
                    </span>
                </div>
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.5rem; font-weight: 900; color: #FFFFFF; margin: 0 0 0.5rem;">
                    Club Prestige All-Access
                </h3>
                <div style="font-family: 'Playfair Display', Georgia, serif; font-size: 2.5rem; font-weight: 900; color: #F59E0B; margin-bottom: 1rem;">
                    <span class="price-val-ngn" style="<?php echo $is_nigeria ? 'display: inline;' : 'display: none;'; ?>">₦8,500</span>
                    <span class="price-val-usd" style="<?php echo !$is_nigeria ? 'display: inline;' : 'display: none;'; ?>">$12.00</span>
                    <span style="font-size: 0.875rem; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; color: #D1D5DB;">/ month</span>
                </div>
                <ul style="list-style: none; padding: 0; margin: 0 0 1.5rem; font-size: 0.8125rem; color: #E5E7EB; display: flex; flex-direction: column; gap: 0.55rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                    <li>✓ <strong>Everything in Digital Gazette</strong></li>
                    <li>✓ <strong>Feature in Video Format News</strong> (share reader opinions)</li>
                    <li>✓ <strong>Exclusive Business &amp; Mining Data</strong> downloads</li>
                    <li>✓ <strong>First-Hand Political Rumors</strong> &amp; diplomatic cables</li>
                    <li>✓ Priority invitations to quarterly virtual editorial roundtables</li>
                </ul>
            </div>
            <a href="mailto:membership@magazineafrique.org?subject=Club%20Prestige%20All-Access%20Subscription" style="display: block; text-align: center; background-color: #D97706; color: #FFFFFF; text-decoration: none; font-weight: 900; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.08em; padding: 0.85rem; border-radius: 2px; transition: background-color 0.2s;">
                Subscribe to Club Prestige →
            </a>
        </div>

        <!-- Tier 3: Syndicate / Institutional -->
        <div class="vintage-framed-box" style="background-color: var(--bg-card, #F6F1E8); border: 2px solid var(--border-color, #231F1D); padding: 2rem 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary, #5C564E); font-family: 'JetBrains Mono', monospace;">
                    Institutions &amp; Funds
                </div>
                <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.4rem; font-weight: 900; color: var(--text-primary, #171513); margin: 0.25rem 0 0.5rem;">
                    Intelligence Syndicate
                </h3>
                <div style="font-family: 'Playfair Display', Georgia, serif; font-size: 2.25rem; font-weight: 900; color: var(--text-primary, #171513); margin-bottom: 1rem;">
                    <span class="price-val-ngn" style="<?php echo $is_nigeria ? 'display: inline;' : 'display: none;'; ?>">₦35,000</span>
                    <span class="price-val-usd" style="<?php echo !$is_nigeria ? 'display: inline;' : 'display: none;'; ?>">$39.00</span>
                    <span style="font-size: 0.875rem; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; color: var(--text-secondary, #5C564E);">/ month</span>
                </div>
                <ul style="list-style: none; padding: 0; margin: 0 0 1.5rem; font-size: 0.8125rem; color: var(--text-secondary, #38332C); display: flex; flex-direction: column; gap: 0.5rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                    <li>✓ All Club Prestige features for 5 team seats</li>
                    <li>✓ Raw CSV/JSON access to macroeconomic datasets</li>
                    <li>✓ Direct briefing channel with lead investigative reporters</li>
                    <li>✓ Invoiced billing (NGN, USD, EUR, GBP, KES, ZAR)</li>
                </ul>
            </div>
            <a href="mailto:membership@magazineafrique.org?subject=Institutional%20Syndicate%20Subscription" class="btn-vintage-box" style="display: block; text-align: center; text-decoration: none; padding: 0.75rem; background: var(--bg-card); color: var(--text-primary);">
                Inquire for Syndicate
            </a>
        </div>

    </div>

    <!-- Assurance / Guarantee Notice -->
    <div style="text-align: center; border-top: 1px solid var(--border-color, #DCD3C4); padding-top: 1.5rem; font-size: 0.8125rem; color: var(--text-secondary, #5C564E); font-family: 'Plus Jakarta Sans', sans-serif;">
        🔒 Direct bank wire and invoice support available. Automated payment gateway integration pending. Questions? Write to <a href="mailto:membership@magazineafrique.org" style="color: #8B2500; font-weight: 700; text-decoration: underline;">membership@magazineafrique.org</a>.
    </div>

</main>

<script>
function switchCurrency(curr) {
    const isNgn = (curr === 'ngn');
    document.querySelectorAll('.price-val-ngn').forEach(el => el.style.display = isNgn ? 'inline' : 'none');
    document.querySelectorAll('.price-val-usd').forEach(el => el.style.display = !isNgn ? 'inline' : 'none');

    const btnNgn = document.getElementById('curr-btn-ngn');
    const btnUsd = document.getElementById('curr-btn-usd');
    const notice = document.getElementById('currency-notice-text');

    if (btnNgn) btnNgn.classList.toggle('active', isNgn);
    if (btnUsd) btnUsd.classList.toggle('active', !isNgn);

    if (notice) {
        notice.textContent = isNgn ? '✓ Showing regional pricing in Nigerian Naira (₦)' : '✓ Showing international pricing in US Dollars ($)';
    }
}
</script>

<style>
.currency-toggle-btn {
    background: transparent;
    color: var(--text-secondary, #5C564E);
}
.currency-toggle-btn.active {
    background: #0B5128 !important;
    color: #FFFFFF !important;
}
[data-theme="dark"] .currency-toggle-btn {
    color: #A89D8D;
}
[data-theme="dark"] .currency-toggle-btn.active {
    background: #D97706 !important;
    color: #171513 !important;
}
</style>

<?php get_footer(); ?>
