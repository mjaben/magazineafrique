<?php
/**
 * Template Name: Buy Ad Space / Brand Reach Advertising
 * Description: Dedicated broadsheet brand reach advertising booking page with live interactive daily rate calculator and creative upload desk.
 *
 * @package MagazineAfrique
 */

get_header();

$spots_matrix = function_exists('magazineafrique_get_ad_spots_matrix') ? magazineafrique_get_ad_spots_matrix() : array();
$rot_state = function_exists('magazineafrique_get_ad_rotation_state') ? magazineafrique_get_ad_rotation_state() : false;
$bank_details = function_exists('magazineafrique_get_ad_bank_details') ? magazineafrique_get_ad_bank_details() : array(
    'bank_name'       => 'Eco Bank',
    'account_name'    => 'Magazine Afrique Limited',
    'account_number'  => '0089765434',
    'whatsapp_number' => '09082533705',
    'whatsapp_intl'   => '2349082533705',
    'advisory'        => 'Send receipt to 09082533705 on WhatsApp for faster response on any issue.'
);
$nonce = wp_create_nonce('magazineafrique_ad_booking_nonce');
?>

<main id="primary" class="site-main ad-space-portal">

  <!-- 1. Commercial Desk Header Strip -->
  <section class="ad-portal-masthead-strip">
    <div class="ad-portal-container">
      <div class="ad-masthead-inner">
        <span class="ad-masthead-dateline">
          <span class="pulse-dot"></span>
          COMMERCIAL DESK · CONTINENTAL BRAND REACH PLATFORM · ALL 54 JURISDICTIONS
        </span>
        <div class="ad-masthead-rates-ticker">
          <span class="ticker-label">5-HR ROTATION SHIFT:</span>
          <span class="ticker-val" style="color: #FBBF24;"><?php echo esc_html($rot_state ? $rot_state['shift_name'] : 'Shift Alpha'); ?> (RESET IN <?php echo esc_html($rot_state ? $rot_state['formatted_remaining'] : '05h 00m'); ?>)</span>
          <span style="color: #78716C; margin: 0 6px;">·</span>
          <span class="ticker-label">BASE RATE:</span>
          <span class="ticker-val">₦2,000 / $2.00 per day (Min ₦2k/day · Max 56 Days)</span>
        </div>
      </div>
    </div>
  </section>

  <!-- 2. Hero Section -->
  <section class="ad-portal-hero">
    <div class="ad-portal-container">
      <div class="ad-hero-grid">
        <div class="ad-hero-content">
          <div class="ad-hero-kicker">
            <span class="kicker-badge">BRAND REACH ONLY</span>
            <span class="kicker-text">Zero Clickbait · Guaranteed Editorial High-Dwell Exposure</span>
          </div>
          <h1 class="ad-hero-title">
            Acquire Sovereign Continental Reach: Broadsheet Brand Display Inventory
          </h1>
          <p class="ad-hero-deck">
            Magazine Afrique operates strictly on a continuous daily broadsheet placement model. We do not run intrusive affiliate popups, deceptive redirects, or spammy performance clutter. Every booking secures verified broadsheet placement per day delivered directly to ministers, diplomats, C-suite executives, and institutional investors across Africa.
          </p>

          <div class="ad-hero-actions">
            <a href="#ad-calculator" class="ad-btn ad-btn-primary">
              <span class="btn-text">Open Rate Calculator &amp; Book</span>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
            </a>
            <a href="#ad-inventory" class="ad-btn ad-btn-secondary">
              <span class="btn-text">Inspect Ad Spots</span>
            </a>
          </div>
        </div>

        <div class="ad-hero-card">
          <div class="ad-hero-card-header">
            <span class="card-kicker">EDITORIAL AUDIENCE DOSSIER</span>
            <span class="card-status">Q4 2026 AUDIT</span>
          </div>
          <div class="ad-hero-stats">
            <div class="stat-cell">
              <span class="stat-number">54</span>
              <span class="stat-label">African Jurisdictions</span>
              <span class="stat-sub">Sovereign continental distribution</span>
            </div>
            <div class="stat-cell">
              <span class="stat-number">82%</span>
              <span class="stat-label">Institutional &amp; C-Suite</span>
              <span class="stat-sub">Ministers, founders, senior directors</span>
            </div>
            <div class="stat-cell">
              <span class="stat-number">4.2<span class="unit">min</span></span>
              <span class="stat-label">Avg. Reading Dwell Time</span>
              <span class="stat-sub">Unrivaled deep essay attention</span>
            </div>
            <div class="stat-cell highlight-cell">
              <span class="stat-number">100%</span>
              <span class="stat-label">Brand-Safe Environment</span>
              <span class="stat-sub">Zero programmatic adjacency risk</span>
            </div>
          </div>
          <div class="ad-hero-card-footer">
            <span class="footer-guarantee">✓ Continuous Daily Placement · Cryptographic Audit Ledger</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. Ad Inventory Matrix (Higher fee for prime spot, baseline for lower space) -->
  <section id="ad-inventory" class="ad-portal-inventory">
    <div class="ad-portal-container">
      <div class="section-heading-box">
        <span class="section-kicker">AVAILABLE DISPLAY INVENTORY</span>
        <h2 class="section-title">Continental Ad Spots &amp; Broadsheet Placement</h2>
        <p class="section-desc">
          Pricing is strictly tiered according to placement prominence. Prime top-of-site positions command an elevated reach premium, while broadsheet baseline positions start at our accessible ₦2,000 (2k) base rate per day. Advertisers can choose flight duration from 1 day up to 56 days maximum.
        </p>
      </div>

      <!-- 5-Hour Space Rotation Protocol Explainer Card -->
      <div class="ad-rotation-policy-card">
        <div class="policy-card-icon">↻</div>
        <div class="policy-card-body">
          <div class="policy-card-tag">CONTINENTAL INVENTORY STANDARD</div>
          <h3 class="policy-card-title">5-Hour Balanced Space Rotation Protocol</h3>
          <p class="policy-card-text">
            To prevent ad clutter and maintain a fair balance with programmatic Google Ads across our 54 jurisdictions, brand reach ad spaces rotate in dedicated <strong>5-hour high-attention shifts</strong>. Direct brand ads and Google Ads are strictly exclusive and never collide in the same spot. <strong>Your contracted daily broadsheet placement runs actively throughout your booked flight window</strong> during live direct shifts.
          </p>
        </div>
        <div class="policy-card-status">
          <span class="policy-status-kicker">CURRENT 5-HOUR SHIFT:</span>
          <span class="policy-shift-badge"><?php echo esc_html($rot_state ? $rot_state['shift_name'] : 'Shift Alpha'); ?></span>
          <span class="policy-timer-label">Next Rotation Reset:</span>
          <span class="policy-timer-val mono" id="front_rot_timer"><?php echo esc_html($rot_state ? $rot_state['formatted_remaining'] : '05h 00m'); ?></span>
        </div>
      </div>

      <div class="ad-inventory-grid">
        <?php foreach ($spots_matrix as $spot_key => $spot): ?>
          <div class="ad-spot-card <?php echo $spot_key === 'header_masthead' ? 'is-prime is-selected' : ''; ?>" data-spot-key="<?php echo esc_attr($spot_key); ?>" data-daily-ngn="<?php echo esc_attr($spot['daily_rate_ngn'] ?? $spot['cpm_ngn']); ?>" data-daily-usd="<?php echo esc_attr($spot['daily_rate_usd'] ?? $spot['cpm_usd']); ?>" data-spot-title="<?php echo esc_attr($spot['title']); ?>">
            <div class="spot-card-badge-row">
              <span class="spot-tag"><?php echo esc_html($spot['badge']); ?></span>
              <span class="spot-tier-chip"><?php
                if (!empty($spot['tier'])) {
                  echo esc_html(strtoupper($spot['tier']));
                } elseif (!empty($spot['tier_number'])) {
                  echo 'TIER ' . esc_html($spot['tier_number']);
                } else {
                  echo 'TIER 1';
                }
              ?></span>
            </div>

            <h3 class="spot-card-title"><?php echo esc_html($spot['title']); ?></h3>
            <p class="spot-card-desc"><?php echo esc_html(!empty($spot['description']) ? $spot['description'] : (!empty($spot['desc']) ? $spot['desc'] : 'Strategic brand reach display inventory.')); ?></p>

            <div class="spot-specs-box">
              <div class="spec-row">
                <span class="spec-name">Placement</span>
                <span class="spec-val"><?php echo esc_html(!empty($spot['placement']) ? $spot['placement'] : (!empty($spot['location']) ? $spot['location'] : 'Broadsheet Primary')); ?></span>
              </div>
              <div class="spec-row">
                <span class="spec-name">Dimensions</span>
                <span class="spec-val mono"><?php
                  if (!empty($spot['dimensions'])) {
                    echo esc_html($spot['dimensions']);
                  } elseif (!empty($spot['desktop_dim']) || !empty($spot['mobile_dim'])) {
                    echo esc_html(trim(($spot['desktop_dim'] ?? '') . ' / ' . ($spot['mobile_dim'] ?? ''), ' /'));
                  } else {
                    echo 'Responsive IAB Standard';
                  }
                ?></span>
              </div>
              <div class="spec-row">
                <span class="spec-name">Guaranteed View</span>
                <span class="spec-val"><?php echo esc_html(!empty($spot['viewability']) ? $spot['viewability'] : '100% Verified'); ?> Viewability</span>
              </div>
            </div>

            <div class="spot-pricing-block">
              <span class="rate-prefix">DAILY PLACEMENT RATE</span>
              <div class="rate-number">
                <span class="currency-symbol">₦</span><?php echo number_format($spot['daily_rate_ngn'] ?? $spot['cpm_ngn']); ?>
                <span class="rate-unit">/ day</span>
              </div>
              <span class="usd-alt">Equivalent to $<?php echo number_format($spot['daily_rate_usd'] ?? $spot['cpm_usd'], 2); ?> USD / day</span>
            </div>

            <button type="button" class="select-spot-btn" onclick="selectSpotFromCard('<?php echo esc_attr($spot_key); ?>')" style="background: #D97706 !important; color: #171513 !important; border: 1.5px solid #D97706 !important; font-weight: 800 !important; cursor: pointer;">
              <span>Select This Space</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-left: 6px; display: inline-block; vertical-align: middle;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Social Media Video Sponsorship Spotlight Card -->
      <div class="social-video-spotlight-card">
        <div class="social-spotlight-badge-row">
          <span class="social-spotlight-tag">MULTI-CHANNEL VIDEO SYNDICATION</span>
          <span class="social-feature-chip">FIXED FEE PACKAGE</span>
        </div>
        <div class="social-spotlight-grid">
          <div class="social-spotlight-text">
            <h3 class="social-spotlight-title">Also Feature Your Brand in Our Social Media Videos</h3>
            <p class="social-spotlight-desc">
              Deliver viral institutional reach across Magazine Afrique video broadcasts on <strong>YouTube Shorts, TikTok, Instagram Reels &amp; X Video</strong>.
            </p>
            <div class="social-spotlight-perks-row">
              <div class="social-perk-item">
                <span class="perk-icon">⚡</span>
                <div class="perk-info">
                  <strong>₦30,000 Fixed Fee</strong>
                  <span>($30 USD equivalent)</span>
                </div>
              </div>
              <div class="social-perk-item">
                <span class="perk-icon">⏱</span>
                <div class="perk-info">
                  <strong>4 Days Flight</strong>
                  <span>Broadcasted across all channels</span>
                </div>
              </div>
              <div class="social-perk-item">
                <span class="perk-icon">👁</span>
                <div class="perk-info">
                  <strong>100,000+ Brand Views</strong>
                  <span>Guaranteed minimum delivery</span>
                </div>
              </div>
            </div>
          </div>
          <div class="social-spotlight-cta-col">
            <button type="button" class="social-spotlight-btn" onclick="addSocialVideoToCalculator()">
              <span>Include In Rate Calculator ↓</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
            </button>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- 4. Interactive Live Rate Calculator & Order Configurator -->
  <section id="ad-calculator" class="ad-portal-calculator">
    <div class="ad-portal-container">
      <div class="calculator-card-wrap">
        <div class="calc-header-row">
          <div>
            <span class="calc-kicker">INTERACTIVE FLIGHT ESTIMATOR</span>
            <h2 class="calc-title">Configure Your Campaign Flight Duration</h2>
          </div>
          <div class="currency-toggle-group">
            <span class="curr-label">Currency:</span>
            <button type="button" class="curr-btn active" data-currency="NGN" onclick="switchCurrency('NGN')">NGN (₦)</button>
            <button type="button" class="curr-btn" data-currency="USD" onclick="switchCurrency('USD')">USD ($)</button>
          </div>
        </div>

        <div class="calculator-body-grid">
          <!-- Left: Controls -->
          <div class="calc-controls-col">
            <!-- Step A: Select Spot -->
            <div class="calc-control-group">
              <label class="control-label">1. Choose Broadsheet Placement</label>
              <div class="spot-selector-radios">
                <?php foreach ($spots_matrix as $spot_key => $spot): ?>
                  <label class="spot-radio-label <?php echo $spot_key === 'header_masthead' ? 'is-selected' : ''; ?>" id="radio-label-<?php echo esc_attr($spot_key); ?>">
                    <input type="radio" name="calc_spot" value="<?php echo esc_attr($spot_key); ?>" <?php checked($spot_key, 'header_masthead'); ?> onchange="onSpotChanged(this.value)">
                    <div class="radio-content">
                      <div class="radio-title-row">
                        <span class="radio-title"><?php echo esc_html($spot['title']); ?></span>
                        <span class="radio-cpm mono" data-daily-ngn="<?php echo esc_attr($spot['daily_rate_ngn'] ?? $spot['cpm_ngn']); ?>" data-daily-usd="<?php echo esc_attr($spot['daily_rate_usd'] ?? $spot['cpm_usd']); ?>">₦<?php echo number_format($spot['daily_rate_ngn'] ?? $spot['cpm_ngn']); ?> / day</span>
                      </div>
                      <span class="radio-desc"><?php echo esc_html(!empty($spot['placement']) ? $spot['placement'] : (!empty($spot['location']) ? $spot['location'] : '')); ?></span>
                    </div>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Step B: Select Flight Days (1 to 56 Days) -->
            <div class="calc-control-group">
              <label class="control-label">2. Select Campaign Flight Duration (Days · Max 56 Days)</label>
              <div class="duration-pills">
                <button type="button" class="day-pill" data-days="1" onclick="setFlightDays(1)">1 Day (Min · ₦2k Base)</button>
                <button type="button" class="day-pill" data-days="3" onclick="setFlightDays(3)">3 Days</button>
                <button type="button" class="day-pill active" data-days="7" onclick="setFlightDays(7)">7 Days (1 Wk)</button>
                <button type="button" class="day-pill" data-days="14" onclick="setFlightDays(14)">14 Days (2 Wks)</button>
                <button type="button" class="day-pill" data-days="30" onclick="setFlightDays(30)">30 Days (1 Mo)</button>
                <button type="button" class="day-pill" data-days="56" onclick="setFlightDays(56)">56 Days (Max)</button>
              </div>

              <div class="custom-days-wrap">
                <label for="custom_days_input" class="custom-days-label">Or Custom Flight Duration (1 to 56 Days):</label>
                <div class="custom-days-input-group">
                  <input type="number" id="custom_days_input" class="custom-days-field" value="7" min="1" max="56" step="1" oninput="onCustomDaysInput(this.value)">
                  <span class="input-suffix">Days of Placement (Max 56)</span>
                </div>
              </div>
            </div>

            <!-- Step C: Social Media Video Feature Add-on -->
            <div class="calc-control-group">
              <label class="control-label">3. Optional Social Media Video Sponsorship</label>
              <div class="social-addon-card" id="social_addon_box" onclick="toggleSocialVideoClick(event)">
                <div class="social-addon-checkbox-col">
                  <input type="checkbox" id="calc_social_video" onchange="toggleSocialVideo(this.checked)" onclick="event.stopPropagation()">
                </div>
                <div class="social-addon-content">
                  <div class="social-addon-head">
                    <span class="social-addon-title">Feature on Our Social Media Videos</span>
                    <span class="social-addon-fee-badge" id="social_addon_fee_badge">+ ₦30,000 Fixed Fee</span>
                  </div>
                  <p class="social-addon-desc">
                    Your ad and brand sponsorship are professionally produced and featured in Magazine Afrique social media video broadcasts across <strong>YouTube Shorts, TikTok, Instagram Reels &amp; X Video</strong>.
                  </p>
                  <div class="social-addon-perks">
                    <span class="perk-tag">✓ 4 Days Fixed Flight</span>
                    <span class="perk-tag">✓ Guaranteed 100,000+ Brand Views</span>
                    <span class="perk-tag">✓ Produced For Vertical Video</span>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- Right: Live Real-Time Invoice Summary -->
          <div class="calc-summary-col">
            <div class="calc-summary-card">
              <div class="summary-card-header">
                <span class="summary-kicker">DISPATCH MANIFEST</span>
                <span class="summary-badge">BRAND REACH CAMPAIGN</span>
              </div>

              <div class="summary-line-items">
                <div class="summary-line">
                  <span class="line-label">Selected Space</span>
                  <span class="line-val" id="summary_spot_title">Spot 1: Master Masthead Leaderboard</span>
                </div>
                <div class="summary-line">
                  <span class="line-label">Daily Placement Rate</span>
                  <span class="line-val mono" id="summary_daily_rate">₦7,500 / day</span>
                </div>
                <div class="summary-line">
                  <span class="line-label">Flight Duration</span>
                  <span class="line-val mono" id="summary_flight_days">7 Days (Continuous Placement)</span>
                </div>
                <div class="summary-line">
                  <span class="line-label">Broadsheet Display</span>
                  <span class="line-val mono" id="summary_subtotal">₦52,500</span>
                </div>
                <div class="summary-line" id="summary_social_line" style="display: none;">
                  <span class="line-label" style="color: #C084FC;">Social Video Feature</span>
                  <span class="line-val mono" id="summary_social_val" style="color: #C084FC; font-weight: 700;">+ ₦30,000 (100k Views · 4 Days)</span>
                </div>
                <div class="summary-line">
                  <span class="line-label">Ad Serving Priority</span>
                  <span class="line-val" style="color: #D97706; font-weight: 700;">Direct Tier 1 (Over Programmatic)</span>
                </div>
              </div>

              <div class="summary-total-block">
                <span class="total-caption">TOTAL AD INVESTMENT</span>
                <div class="total-figure" id="summary_total_display">₦52,500</div>
                <span class="total-vat-note">Inclusive of verified broadsheet flight delivery and cryptographic audit logs.</span>
              </div>

              <a href="#ad-booking-desk" class="summary-cta-btn" onclick="syncCalculatorToBookingForm()">
                Proceed to Creative Booking Desk →
              </a>

              <div class="commercial-hotline-strip">
                <span>Direct Commercial Desk Support:</span>
                <a href="https://wa.me/2349082533705?text=Hello%20Magazine%20Afrique%20Commercial%20Desk,%20I%20am%20inquiring%20about%20booking%20brand%20reach%20display%20inventory." target="_blank" rel="noopener">
                  WhatsApp Commercial Hotline ↗
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 5. Direct Booking & Creative Asset Submission Desk -->
  <section id="ad-booking-desk" class="ad-portal-booking">
    <div class="ad-portal-container">
      <div class="booking-grid">
        <!-- Form Left -->
        <div class="booking-form-box">
          <div class="form-header">
            <span class="form-kicker">RESERVATION DISPATCH</span>
            <h2 class="form-title">Reserve Brand Reach Inventory</h2>
            <p class="form-subtitle">
              Submit your creative asset and flight parameters. Our commercial team reviews your banner creative and approves your payment upon Eco Bank wire remittance to launch your ad live across the broadsheet.
            </p>
          </div>

          <form id="magazineafrique-ad-form" enctype="multipart/form-data">
            <input type="hidden" name="action" value="magazineafrique_submit_ad_booking">
            <input type="hidden" name="nonce" value="<?php echo esc_attr($nonce); ?>">
            <input type="hidden" id="form_spot_key" name="spot_key" value="header_masthead">
            <input type="hidden" id="form_currency" name="currency" value="NGN">
            <input type="hidden" id="form_days" name="days" value="7">
            <input type="hidden" id="form_social_video" name="social_video" value="0">

            <div class="form-row two-cols">
              <div class="form-group">
                <label for="brand_name" class="field-label">Institutional / Brand Name <span class="req">*</span></label>
                <input type="text" id="brand_name" name="brand_name" class="field-input" placeholder="e.g. Dangote Group / Afreximbank" required>
              </div>
              <div class="form-group">
                <label for="contact_name" class="field-label">Contact Officer / Representative <span class="req">*</span></label>
                <input type="text" id="contact_name" name="contact_name" class="field-input" placeholder="e.g. Amina Bello" required>
              </div>
            </div>

            <div class="form-row two-cols">
              <div class="form-group">
                <label for="contact_email" class="field-label">Corporate Email Address <span class="req">*</span></label>
                <input type="email" id="contact_email" name="contact_email" class="field-input" placeholder="amina@organization.com" required>
              </div>
              <div class="form-group">
                <label for="contact_phone" class="field-label">Phone / WhatsApp Line <span class="req">*</span></label>
                <input type="tel" id="contact_phone" name="contact_phone" class="field-input" placeholder="+234 800 000 0000" required>
              </div>
            </div>

            <div class="form-row two-cols">
              <div class="form-group">
                <label for="country" class="field-label">Operating Country / Headquarters <span class="req">*</span></label>
                <input type="text" id="country" name="country" class="field-input" placeholder="e.g. Nigeria, South Africa, Kenya" required>
              </div>
              <div class="form-group">
                <label for="start_date" class="field-label">Target Campaign Launch Date</label>
                <input type="date" id="start_date" name="start_date" class="field-input" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="destination_url" class="field-label">Creative Destination URL (Where Readers Land) <span class="req">*</span></label>
              <input type="url" id="destination_url" name="destination_url" class="field-input" placeholder="https://yourbrand.com/annual-report" required>
            </div>

            <!-- Social Media Video Sponsorship Checkbox Option in Form -->
            <div class="form-group social-form-toggle-wrap">
              <label class="social-form-checkbox-label">
                <input type="checkbox" id="form_social_video_checkbox" onchange="syncSocialVideoFromForm(this.checked)">
                <span class="social-checkbox-copy">
                  <strong style="color: #FBBF24;">Include Social Media Video Feature (+₦30,000 / $30 USD)</strong>
                  <span style="display: block; font-size: 0.75rem; color: #A8A29E; margin-top: 2px;">Fixed 4-day flight with guaranteed 100,000+ views across YouTube Shorts, TikTok, Reels &amp; X Video.</span>
                </span>
              </label>
            </div>

            <!-- Creative Banner Upload Dropzone -->
            <div class="form-group">
              <label class="field-label">Display Creative Banner Asset <span class="req">*</span></label>
              <div class="creative-dropzone" id="creative_dropzone" onclick="document.getElementById('creative_asset').click()">
                <input type="file" id="creative_asset" name="creative_asset" accept="image/png,image/jpeg,image/webp,image/gif" style="display: none;" onchange="handleFileSelect(this)">
                
                <div class="dropzone-empty" id="dropzone_empty_ui">
                  <div class="dropzone-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                  </div>
                  <div class="dropzone-text">
                    <strong>Click or drag creative banner here</strong>
                    <span>Supported formats: WebP, PNG, JPEG, GIF (Max 4MB)</span>
                  </div>
                  <span class="dropzone-tag" id="dropzone_dim_hint">Recommended: 970×250 (Desktop) · 320×100 (Mobile)</span>
                </div>

                <div class="dropzone-preview" id="dropzone_preview_ui" style="display: none;">
                  <img id="creative_preview_img" src="#" alt="Creative Preview">
                  <div class="preview-meta">
                    <span id="preview_filename" class="preview-name">banner.webp</span>
                    <button type="button" class="remove-preview-btn" onclick="event.stopPropagation(); removeSelectedFile();">Change File</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="notes" class="field-label">Special Campaign Instructions / Video Details (Optional)</label>
              <textarea id="notes" name="notes" rows="3" class="field-textarea" placeholder="Specify any editorial desk preferences or provide your brand social handles / video assets..."></textarea>
            </div>

            <!-- Booking Overview Banner Inside Form -->
            <div class="booking-manifest-banner">
              <div class="manifest-item">
                <span class="m-label">Selected Space:</span>
                <span class="m-val" id="form_manifest_spot">Spot 1: Master Masthead Leaderboard</span>
              </div>
              <div class="manifest-item">
                <span class="m-label">Flight Duration:</span>
                <span class="m-val" id="form_manifest_duration">7 Days</span>
              </div>
              <div class="manifest-item">
                <span class="m-label">Social Video:</span>
                <span class="m-val" id="form_manifest_social">Not Selected</span>
              </div>
              <div class="manifest-item">
                <span class="m-label">Total Remittance:</span>
                <span class="m-val highlight" id="form_manifest_total">₦52,500</span>
              </div>
            </div>

            <div id="form-feedback" class="form-feedback-alert" style="display: none;"></div>

            <button type="submit" class="submit-booking-btn" id="submit_booking_btn">
              <span class="btn-spinner" id="btn_spinner" style="display: none;"></span>
              <span class="btn-text" id="btn_label">Transmit Ad Booking &amp; Generate Invoice</span>
            </button>

            <p class="form-compliance-notice">
              By submitting, your organization agrees to Magazine Afrique's Editorial Brand Standards. Direct campaigns take sovereign priority over programmatic tags throughout your booked flight days.
            </p>
          </form>
        </div>

        <!-- Sidebar Right: Standards & Assurance -->
        <div class="booking-sidebar">
          <div class="sidebar-info-card">
            <h3 class="info-card-title">Broadsheet Brand Standards</h3>
            <ul class="standards-list">
              <li>
                <strong>Brand Reach Guarantee:</strong> Your banner is served continuously across high-authority analytical essays and broadsheet dispatches throughout your booked flight duration (1 to 56 days).
              </li>
              <li>
                <strong>No Bot Fraud:</strong> Magazine Afrique uses server-side tokenized verification to filter automated scrapers and ensure real human executive readership.
              </li>
              <li>
                <strong>Priority Slot Override:</strong> Direct Brand Reach partners take sovereign priority over programmatic Google AdSense slots throughout the active flight days.
              </li>
              <li>
                <strong>Instant Reversion:</strong> Once your booked flight period concludes, the slot seamlessly reverts to programmatic inventory without causing layout shifts.
              </li>
            </ul>
          </div>

          <div class="sidebar-info-card wire-info-card">
            <h3 class="info-card-title">Commercial Wire Settlement</h3>
            <p class="wire-desc">
              Direct brand reservations are settled via verified institutional wire transfer or commercial electronic bank transfer:
            </p>

            <div class="remittance-official-box" style="background: var(--bg-card-subtle, #F7F2E8); border: 2px solid var(--text-primary, #171513); padding: 1.25rem; border-radius: 4px; margin-bottom: 1rem;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.65rem;">
                <span style="font-family: 'Geist Mono', monospace; font-size: 0.65rem; font-weight: 800; background: #D97706; color: #171513; padding: 2px 6px; border-radius: 2px; text-transform: uppercase;">
                  Official Bank Details
                </span>
                <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C);">NGN Wire</span>
              </div>
              <div style="margin-bottom: 0.5rem;">
                <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C); text-transform: uppercase;">Bank Institution</span>
                <strong style="font-size: 1.05rem; color: var(--text-primary, #171513); font-family: 'Playfair Display', Georgia, serif;"><?php echo esc_html($bank_details['bank_name']); ?></strong>
              </div>
              <div style="margin-bottom: 0.5rem;">
                <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C); text-transform: uppercase;">Beneficiary Account Name</span>
                <strong style="font-size: 0.95rem; color: var(--text-primary, #171513); font-family: 'Playfair Display', Georgia, serif;"><?php echo esc_html($bank_details['account_name']); ?></strong>
              </div>
              <div style="background: #171513; border: 1px solid #D97706; padding: 0.75rem; border-radius: 3px; display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;">
                <div>
                  <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.58rem; color: #A8A29E; text-transform: uppercase; letter-spacing: 0.08em;">Account Number</span>
                  <span style="font-family: 'Geist Mono', monospace; font-size: 1.25rem; font-weight: 900; color: #FBBF24; letter-spacing: 0.08em;" id="sidebar_acc_num"><?php echo esc_html($bank_details['account_number']); ?></span>
                </div>
                <button type="button" onclick="navigator.clipboard.writeText('<?php echo esc_js($bank_details['account_number']); ?>'); this.innerText='COPIED!'; var b=this; setTimeout(function(){ b.innerText='COPY'; }, 2000);" style="background: #D97706; border: none; color: #171513; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; padding: 5px 10px; border-radius: 2px; cursor: pointer;">
                  COPY
                </button>
              </div>
            </div>

            <!-- Fast-Track Receipt Routing Callout -->
            <div class="whatsapp-routing-alert" style="background: rgba(217, 119, 6, 0.1); border-left: 3px solid #D97706; padding: 0.85rem; margin-bottom: 1rem; border-radius: 0 3px 3px 0;">
              <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.72rem; font-weight: 700; color: #D97706; margin-bottom: 3px;">
                ⚡ FAST-TRACK ACTIVATION ADVISORY:
              </span>
              <p style="margin: 0 0 0.5rem; font-size: 0.8125rem; line-height: 1.45; color: var(--text-primary, #171513);">
                Send receipt to <strong><?php echo esc_html($bank_details['whatsapp_number']); ?></strong> on WhatsApp for faster response on any issue.
              </p>
              <a href="https://wa.me/<?php echo esc_attr($bank_details['whatsapp_intl']); ?>?text=<?php echo urlencode('Hello Magazine Afrique Commercial Desk, I am remitting payment for Ad Space Booking.'); ?>" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; font-family: 'Geist Mono', monospace; font-size: 0.75rem; font-weight: 800; color: #15803D; text-decoration: none;">
                Send Receipt via WhatsApp ↗
              </a>
            </div>

            <span class="wire-dispatch-note">Automated pro-forma invoice is dispatched to your email upon transmission.</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 6. Modal: Booking Success Confirmation -->
  <div id="ad-success-modal" class="ad-modal-overlay" style="display: none;">
    <div class="ad-modal-box">
      <div class="modal-reticle reticle-tl">+</div>
      <div class="modal-reticle reticle-tr">+</div>
      <div class="modal-reticle reticle-bl">+</div>
      <div class="modal-reticle reticle-br">+</div>

      <div class="modal-header">
        <div class="modal-icon-success">✓</div>
        <span class="modal-kicker">COMMERCIAL RESERVATION RECORDED</span>
        <h3 class="modal-title">Brand Reach Campaign Transmitted</h3>
      </div>

      <div class="modal-body">
        <p class="modal-text">
          Your brand reach ad space reservation has been registered on the Continental Commercial Desk ledger.
        </p>

        <div class="booking-code-box">
          <span class="code-label">OFFICIAL BOOKING REFERENCE:</span>
          <span class="code-number mono" id="modal_booking_code">MA-AD-00000</span>
          <span class="code-sub">Quote this code on all remittances and correspondence.</span>
        </div>

        <div class="modal-summary-grid">
          <div class="modal-summary-cell">
            <span class="cell-l">Brand</span>
            <span class="cell-v" id="modal_brand_name">-</span>
          </div>
          <div class="modal-summary-cell">
            <span class="cell-l">Space</span>
            <span class="cell-v" id="modal_spot_title">-</span>
          </div>
          <div class="modal-summary-cell">
            <span class="cell-l">Flight Duration</span>
            <span class="cell-v mono" id="modal_duration">-</span>
          </div>
          <div class="modal-summary-cell">
            <span class="cell-l">Social Video</span>
            <span class="cell-v mono" id="modal_social">-</span>
          </div>
          <div class="modal-summary-cell" style="grid-column: 1 / -1;">
            <span class="cell-l">Total Investment</span>
            <span class="cell-v mono highlight" id="modal_total_amount">-</span>
          </div>
        </div>

        <!-- Official Remittance Bank Details Box Inside Modal -->
        <div class="modal-bank-remittance-card" style="background: #11100F; border: 1px solid #D97706; padding: 1rem; border-radius: 3px; margin-bottom: 1.25rem;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
            <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #D97706; letter-spacing: 0.08em; text-transform: uppercase;">
              OFFICIAL WIRE REMITTANCE
            </span>
            <span style="font-family: 'Geist Mono', monospace; font-size: 0.65rem; color: #A8A29E;">Instant Processing</span>
          </div>
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 0.75rem; font-size: 0.8125rem;">
            <div>
              <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.58rem; color: #78716C; text-transform: uppercase;">Bank</span>
              <strong style="color: #FAF7F2;"><?php echo esc_html($bank_details['bank_name']); ?></strong>
            </div>
            <div>
              <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.58rem; color: #78716C; text-transform: uppercase;">Account Name</span>
              <strong style="color: #FAF7F2;"><?php echo esc_html($bank_details['account_name']); ?></strong>
            </div>
          </div>
          <div style="background: rgba(217, 119, 6, 0.12); border: 1px dashed #D97706; padding: 0.6rem 0.85rem; border-radius: 2px; display: flex; align-items: center; justify-content: space-between;">
            <div>
              <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.58rem; color: #A8A29E; text-transform: uppercase;">Account Number</span>
              <span style="font-family: 'Geist Mono', monospace; font-size: 1.25rem; font-weight: 900; color: #FBBF24; letter-spacing: 0.08em;"><?php echo esc_html($bank_details['account_number']); ?></span>
            </div>
            <button type="button" onclick="navigator.clipboard.writeText('<?php echo esc_js($bank_details['account_number']); ?>'); this.innerText='COPIED!'; var b=this; setTimeout(function(){ b.innerText='COPY'; }, 2000);" style="background: #D97706; border: none; color: #171513; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; padding: 4px 8px; border-radius: 2px; cursor: pointer;">
              COPY
            </button>
          </div>
        </div>

        <!-- WhatsApp Receipt Routing Notice -->
        <div class="modal-whatsapp-advisory" style="background: rgba(37, 211, 102, 0.12); border: 1px solid rgba(37, 211, 102, 0.35); padding: 0.85rem; border-radius: 3px; margin-bottom: 1.25rem; text-align: center;">
          <span style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.72rem; font-weight: 800; color: #25D366; text-transform: uppercase; margin-bottom: 4px;">
            💬 WhatsApp Receipt Routing
          </span>
          <p style="margin: 0; font-size: 0.8125rem; line-height: 1.45; color: #FAF7F2;">
            Send receipt to <strong><?php echo esc_html($bank_details['whatsapp_number']); ?></strong> on WhatsApp for faster response on any issue.
          </p>
        </div>

        <div class="modal-next-steps">
          <strong>Next Action &amp; Live Approval:</strong>
          <span>A copy of this invoice has been sent to your email. You can transmit your Eco Bank payment receipt directly via WhatsApp below. Once our commercial desk reviews your creative and approves payment, your ad goes live immediately!</span>
        </div>
      </div>

      <div class="modal-footer">
        <a id="modal_whatsapp_link" href="https://wa.me/<?php echo esc_attr($bank_details['whatsapp_intl']); ?>" target="_blank" class="modal-btn modal-btn-whatsapp" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
          Send Receipt on WhatsApp (<?php echo esc_html($bank_details['whatsapp_number']); ?>) ↗
        </a>
        <button type="button" class="modal-btn modal-btn-primary" onclick="closeSuccessModal()">
          Acknowledged &amp; Return
        </button>
      </div>
    </div>
  </div>

</main>

<script>
/**
 * Magazine Afrique Brand Reach Advertising Portal Controller (Daily Rate & Flight Model)
 */
(function($) {
  'use strict';

  // Dynamic pricing matrix
  var spotsMatrix = <?php echo json_encode($spots_matrix); ?>;
  var currentCurrency = 'NGN';
  var currentSpot = 'header_masthead';
  var currentDays = 7;
  var maxDays = 56;
  var hasSocialVideo = false;
  var socialFeeNGN = 30000;
  var socialFeeUSD = 30.00;

  // Live 5-Hour Rotation Countdown Timer on Buy Ad Space Page
  var rotSeconds = <?php echo (int) ($rot_state ? $rot_state['seconds_remaining'] : 18000); ?>;
  var frontTimerEl = document.getElementById('front_rot_timer');
  if (frontTimerEl) {
    setInterval(function() {
      rotSeconds--;
      if (rotSeconds <= 0) {
        frontTimerEl.textContent = 'Rotating Space...';
        setTimeout(function() { location.reload(); }, 2000);
        return;
      }
      var h = Math.floor(rotSeconds / 3600);
      var m = Math.floor((rotSeconds % 3600) / 60);
      var s = rotSeconds % 60;
      var pad = function(n) { return (n < 10 ? '0' : '') + n; };
      frontTimerEl.textContent = pad(h) + 'h ' + pad(m) + 'm ' + pad(s) + 's';
    }, 1000);
  }

  // Window exposure for inline onclick handlers
  window.switchCurrency = function(curr) {
    currentCurrency = curr;
    $('.curr-btn').removeClass('active');
    $('.curr-btn[data-currency="' + curr + '"]').addClass('active');
    $('#form_currency').val(curr);
    recalculateRates();
  };

  window.onSpotChanged = function(spotKey) {
    currentSpot = spotKey;
    $('.spot-radio-label').removeClass('is-selected');
    $('#radio-label-' + spotKey).addClass('is-selected');
    $('#form_spot_key').val(spotKey);

    // Update dropzone dimension hint
    if (spotsMatrix[spotKey]) {
      var dHint = 'Recommended: ' + (spotsMatrix[spotKey].desktop_dim || '970×250') + ' (Desktop) · ' + (spotsMatrix[spotKey].mobile_dim || '320×100') + ' (Mobile)';
      $('#dropzone_dim_hint').text(dHint);
    }

    recalculateRates();
  };

  window.selectSpotFromCard = function(spotKey) {
    $('.ad-spot-card').removeClass('is-selected');
    $('.ad-spot-card[data-spot-key="' + spotKey + '"]').addClass('is-selected');
    $('input[name="calc_spot"][value="' + spotKey + '"]').prop('checked', true).trigger('change');
    // Smooth scroll to calculator
    var target = document.getElementById('ad-calculator');
    if (target) {
      target.scrollIntoView({ behavior: 'smooth' });
    }
  };

  window.setFlightDays = function(days) {
    days = parseInt(days, 10);
    if (!days || days < 1) days = 1;
    if (days > maxDays) days = maxDays;
    currentDays = days;

    $('.day-pill').removeClass('active');
    $('.day-pill[data-days="' + days + '"]').addClass('active');
    $('#custom_days_input').val(currentDays);
    $('#form_days').val(currentDays);
    recalculateRates();
  };

  window.onCustomDaysInput = function(val) {
    var days = parseInt(val, 10);
    if (!days || days < 1) days = 1;
    if (days > maxDays) {
      days = maxDays;
      $('#custom_days_input').val(maxDays);
    }
    currentDays = days;
    $('.day-pill').removeClass('active');
    $('.day-pill[data-days="' + days + '"]').addClass('active');
    $('#form_days').val(currentDays);
    recalculateRates();
  };

  window.toggleSocialVideo = function(isChecked) {
    hasSocialVideo = !!isChecked;
    $('#calc_social_video').prop('checked', hasSocialVideo);
    $('#form_social_video').val(hasSocialVideo ? '1' : '0');
    $('#form_social_video_checkbox').prop('checked', hasSocialVideo);
    if (hasSocialVideo) {
      $('#social_addon_box').addClass('is-active');
    } else {
      $('#social_addon_box').removeClass('is-active');
    }
    recalculateRates();
  };

  window.toggleSocialVideoClick = function(e) {
    var current = $('#calc_social_video').prop('checked');
    window.toggleSocialVideo(!current);
  };

  window.syncSocialVideoFromForm = function(checked) {
    window.toggleSocialVideo(checked);
  };

  window.addSocialVideoToCalculator = function() {
    window.toggleSocialVideo(true);
    var target = document.getElementById('ad-calculator');
    if (target) {
      target.scrollIntoView({ behavior: 'smooth' });
    }
  };

  function recalculateRates() {
    var spot = spotsMatrix[currentSpot];
    if (!spot) return;

    var dailyRate = currentCurrency === 'USD' ? (spot.daily_rate_usd || spot.cpm_usd) : (spot.daily_rate_ngn || spot.cpm_ngn);
    var broadsheetSubtotal = Math.round(currentDays * dailyRate);
    var socialFee = hasSocialVideo ? (currentCurrency === 'USD' ? socialFeeUSD : socialFeeNGN) : 0;
    var grandTotal = broadsheetSubtotal + socialFee;

    var sym = currentCurrency === 'USD' ? '$' : '₦';
    var formattedDaily = sym + Number(dailyRate).toLocaleString() + ' / day';
    var formattedSubtotal = sym + Number(broadsheetSubtotal).toLocaleString();
    var formattedGrandTotal = sym + Number(grandTotal).toLocaleString();
    var formattedSocialFee = sym + Number(currentCurrency === 'USD' ? socialFeeUSD : socialFeeNGN).toLocaleString();

    // Update social badge text with current currency
    $('#social_addon_fee_badge').text('+ ' + formattedSocialFee + ' Fixed Fee');

    // Update summary lines
    $('#summary_spot_title').text(spot.title);
    $('#summary_daily_rate').text(formattedDaily);
    $('#summary_flight_days').text(currentDays + (currentDays === 1 ? ' Day' : ' Days') + ' (Continuous Placement)');
    $('#summary_subtotal').text(formattedSubtotal);
    
    if (hasSocialVideo) {
      $('#summary_social_line').show();
      $('#summary_social_val').text('+ ' + formattedSocialFee + ' (100k Views · 4 Days)');
    } else {
      $('#summary_social_line').hide();
    }
    
    $('#summary_total_display').text(formattedGrandTotal);

    // Update form manifest
    $('#form_manifest_spot').text(spot.title);
    $('#form_manifest_duration').text(currentDays + (currentDays === 1 ? ' Day' : ' Days'));
    $('#form_manifest_social').text(hasSocialVideo ? 'Included (+ 100k Views · 4 Days)' : 'None (Broadsheet Only)');
    $('#form_manifest_total').text(formattedGrandTotal);
  }

  window.syncCalculatorToBookingForm = function() {
    var target = document.getElementById('ad-booking-desk');
    if (target) {
      target.scrollIntoView({ behavior: 'smooth' });
    }
  };

  // Creative Asset Dropzone Handling
  window.handleFileSelect = function(input) {
    if (input.files && input.files[0]) {
      var file = input.files[0];
      if (file.size > 4 * 1024 * 1024) {
        alert('File size exceeds the 4MB limit. Please provide a lighter web banner.');
        input.value = '';
        return;
      }

      var reader = new FileReader();
      reader.onload = function(e) {
        $('#creative_preview_img').attr('src', e.target.result);
        $('#preview_filename').text(file.name + ' (' + Math.round(file.size / 1024) + ' KB)');
        $('#dropzone_empty_ui').hide();
        $('#dropzone_preview_ui').show();
      };
      reader.readAsDataURL(file);
    }
  };

  window.removeSelectedFile = function() {
    $('#creative_asset').val('');
    $('#creative_preview_img').attr('src', '#');
    $('#dropzone_preview_ui').hide();
    $('#dropzone_empty_ui').show();
  };

  // AJAX Form Submission
  $('#magazineafrique-ad-form').on('submit', function(e) {
    e.preventDefault();

    var $form = $(this);
    var $btn = $('#submit_booking_btn');
    var $spinner = $('#btn_spinner');
    var $label = $('#btn_label');
    var $alert = $('#form-feedback');

    // Validation
    if (!$('#creative_asset')[0].files.length) {
      $alert.removeClass('alert-success').addClass('alert-error').text('Please upload your creative banner asset before transmitting the booking.').show();
      return;
    }

    var formData = new FormData(this);

    // UI Loading state
    $btn.prop('disabled', true);
    $spinner.show();
    $label.text('Securing Space & Transmitting...');
    $alert.hide();

    $.ajax({
      url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        $btn.prop('disabled', false);
        $spinner.hide();
        $label.text('Transmit Ad Booking & Generate Invoice');

        if (response && response.success) {
          var data = response.data;
          $('#modal_booking_code').text(data.booking_code);
          $('#modal_brand_name').text(data.brand_name);
          $('#modal_spot_title').text(data.spot_title);
          $('#modal_duration').text(data.days + (data.days === 1 ? ' Day' : ' Days') + ' (' + data.daily_rate + ')');
          $('#modal_social').text(data.has_social ? '✓ 4-Day Feature (100k Views Guaranteed)' : 'None (Broadsheet Only)');
          $('#modal_total_amount').text(data.currency === 'USD' ? '$' + Number(data.total_amount).toLocaleString() : '₦' + Number(data.total_amount).toLocaleString());

          // WhatsApp link with Eco Bank payment receipt prefilled routing
          var waNumber = data.whatsapp_intl || '<?php echo esc_js($bank_details['whatsapp_intl']); ?>';
          var socialText = data.has_social ? ' + Social Video Feature (100k views)' : '';
          var waText = encodeURIComponent('Hello Magazine Afrique Commercial Desk, I have just booked brand reach ad space for ' + data.brand_name + ' (Booking Code: #' + data.booking_code + '). Flight: ' + data.days + ' days' + socialText + '. Total: ' + data.currency + ' ' + Number(data.total_amount).toLocaleString() + '. Attached is my payment receipt to Eco Bank (0089765434).');
          $('#modal_whatsapp_link').attr('href', 'https://wa.me/' + waNumber + '?text=' + waText);

          $('#ad-success-modal').fadeIn(200);
          $form[0].reset();
          removeSelectedFile();
        } else {
          var errMsg = response && response.data && response.data.message ? response.data.message : 'An error occurred during submission. Please check your network or contact commercial desk.';
          $alert.removeClass('alert-success').addClass('alert-error').text(errMsg).show();
        }
      },
      error: function() {
        $btn.prop('disabled', false);
        $spinner.hide();
        $label.text('Transmit Ad Booking & Generate Invoice');
        $alert.removeClass('alert-success').addClass('alert-error').text('Connection failure. Please retry or contact commercial@magazineafrique.org').show();
      }
    });
  });

  window.closeSuccessModal = function() {
    $('#ad-success-modal').fadeOut(200);
  };

  // Initial calculation
  recalculateRates();

})(jQuery);
</script>

<?php
get_footer();
