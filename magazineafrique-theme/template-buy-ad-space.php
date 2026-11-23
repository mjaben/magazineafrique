<?php
/**
 * Template Name: Buy Ad Space / Brand Reach Advertising
 * Description: Dedicated broadsheet brand reach advertising booking page with live interactive CPM calculator and creative upload desk.
 *
 * @package MagazineAfrique
 */

get_header();

$spots_matrix = function_exists('magazineafrique_get_ad_spots_matrix') ? magazineafrique_get_ad_spots_matrix() : array();
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
          <span class="ticker-label">BASE BROADSHEET RATE:</span>
          <span class="ticker-val">₦5,000 / $5.00 CPM (PER 1,000 GUARANTEED IMPRESSIONS)</span>
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
            Magazine Afrique operates strictly on a guaranteed Brand Reach model. We do not run intrusive affiliate popups, deceptive redirects, or spammy performance clutter. Every booking secures verified Cost-Per-Thousand (CPM) impressions delivered directly to ministers, diplomats, C-suite executives, and institutional investors across Africa.
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
            <span class="footer-guarantee">✓ Verified Impression Delivery · Cryptographic Audit Ledger</span>
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
          Pricing is strictly tiered according to placement prominence. Prime top-of-site positions command an elevated reach premium, while broadsheet baseline positions start at our standard ₦5,000 base rate.
        </p>
      </div>

      <div class="ad-inventory-grid">
        <?php foreach ($spots_matrix as $spot_key => $spot): ?>
          <div class="ad-spot-card <?php echo $spot_key === 'spot_masthead' ? 'is-prime' : ''; ?>" data-spot-key="<?php echo esc_attr($spot_key); ?>" data-cpm-ngn="<?php echo esc_attr($spot['cpm_ngn']); ?>" data-cpm-usd="<?php echo esc_attr($spot['cpm_usd']); ?>" data-spot-title="<?php echo esc_attr($spot['title']); ?>">
            <div class="spot-card-badge-row">
              <span class="spot-tag"><?php echo esc_html($spot['badge']); ?></span>
              <span class="spot-tier-chip">TIER <?php echo substr($spot_key, -1); ?></span>
            </div>

            <h3 class="spot-card-title"><?php echo esc_html($spot['title']); ?></h3>
            <p class="spot-card-desc"><?php echo esc_html($spot['desc']); ?></p>

            <div class="spot-specs-box">
              <div class="spec-row">
                <span class="spec-name">Placement</span>
                <span class="spec-val"><?php echo esc_html($spot['location']); ?></span>
              </div>
              <div class="spec-row">
                <span class="spec-name">Dimensions</span>
                <span class="spec-val mono"><?php echo esc_html($spot['desktop_dim']); ?> / <?php echo esc_html($spot['mobile_dim']); ?></span>
              </div>
              <div class="spec-row">
                <span class="spec-name">Guaranteed View</span>
                <span class="spec-val"><?php echo esc_html($spot['viewability']); ?> Viewability</span>
              </div>
            </div>

            <div class="spot-pricing-block">
              <span class="rate-prefix">BRAND REACH RATE</span>
              <div class="rate-number">
                <span class="currency-symbol">₦</span><?php echo number_format($spot['cpm_ngn']); ?>
                <span class="rate-unit">/ 1,000 imps</span>
              </div>
              <span class="usd-alt">Equivalent to $<?php echo number_format($spot['cpm_usd'], 2); ?> USD CPM</span>
            </div>

            <button type="button" class="select-spot-btn" onclick="selectSpotFromCard('<?php echo esc_attr($spot_key); ?>')">
              Select This Space
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 4. Interactive Live CPM Calculator & Order Configurator -->
  <section id="ad-calculator" class="ad-portal-calculator">
    <div class="ad-portal-container">
      <div class="calculator-card-wrap">
        <div class="calc-header-row">
          <div>
            <span class="calc-kicker">INTERACTIVE COST ESTIMATOR</span>
            <h2 class="calc-title">Configure Your Campaign Volume</h2>
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
                  <label class="spot-radio-label <?php echo $spot_key === 'spot_masthead' ? 'is-selected' : ''; ?>" id="radio-label-<?php echo esc_attr($spot_key); ?>">
                    <input type="radio" name="calc_spot" value="<?php echo esc_attr($spot_key); ?>" <?php checked($spot_key, 'spot_masthead'); ?> onchange="onSpotChanged(this.value)">
                    <div class="radio-content">
                      <div class="radio-title-row">
                        <span class="radio-title"><?php echo esc_html($spot['title']); ?></span>
                        <span class="radio-cpm mono" data-cpm-ngn="<?php echo esc_attr($spot['cpm_ngn']); ?>" data-cpm-usd="<?php echo esc_attr($spot['cpm_usd']); ?>">₦<?php echo number_format($spot['cpm_ngn']); ?> CPM</span>
                      </div>
                      <span class="radio-desc"><?php echo esc_html($spot['location']); ?></span>
                    </div>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Step B: Select Impression Target -->
            <div class="calc-control-group">
              <label class="control-label">2. Select Guaranteed Impression Reach</label>
              <div class="impression-pills">
                <button type="button" class="imp-pill" data-imps="10000" onclick="setImpressionPackage(10000)">10,000 imps</button>
                <button type="button" class="imp-pill active" data-imps="25000" onclick="setImpressionPackage(25000)">25,000 imps</button>
                <button type="button" class="imp-pill" data-imps="50000" onclick="setImpressionPackage(50000)">50,000 imps</button>
                <button type="button" class="imp-pill" data-imps="100000" onclick="setImpressionPackage(100000)">100,000 imps</button>
              </div>

              <div class="custom-imp-wrap">
                <label for="custom_imps_input" class="custom-imp-label">Or Custom Impressions Volume (Min. 5,000):</label>
                <div class="custom-imp-input-group">
                  <input type="number" id="custom_imps_input" class="custom-imp-field" value="25000" min="5000" step="5000" oninput="onCustomImpsInput(this.value)">
                  <span class="input-suffix">Guaranteed Readers</span>
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
                  <span class="line-label">Base CPM Rate</span>
                  <span class="line-val mono" id="summary_cpm_rate">₦10,000 per 1,000</span>
                </div>
                <div class="summary-line">
                  <span class="line-label">Guaranteed Impressions</span>
                  <span class="line-val mono" id="summary_impressions">25,000 Readers</span>
                </div>
                <div class="summary-line">
                  <span class="line-label">Model</span>
                  <span class="line-val">Guaranteed Brand Reach</span>
                </div>
                <div class="summary-line">
                  <span class="line-label">Ad Serving Priority</span>
                  <span class="line-val" style="color: #D97706; font-weight: 700;">Direct Tier 1 (Over Programmatic)</span>
                </div>
              </div>

              <div class="summary-total-block">
                <span class="total-caption">TOTAL AD INVESTMENT</span>
                <div class="total-figure" id="summary_total_display">₦250,000</div>
                <span class="total-vat-note">Inclusive of verified impression auditing and live performance reporting.</span>
              </div>

              <a href="#ad-booking-desk" class="summary-cta-btn" onclick="syncCalculatorToBookingForm()">
                Proceed to Creative Booking Desk →
              </a>

              <div class="commercial-hotline-strip">
                <span>Direct Commercial Desk Support:</span>
                <a href="https://wa.me/2348120000000?text=Hello%20Magazine%20Afrique%20Commercial%20Desk,%20I%20am%20inquiring%20about%20booking%20brand%20reach%20display%20inventory." target="_blank" rel="noopener">
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
              Submit your creative asset and campaign parameters. Our commercial team reviews brand suitability within 2 business hours and activates your campaign upon wire confirmation.
            </p>
          </div>

          <form id="magazineafrique-ad-form" enctype="multipart/form-data">
            <input type="hidden" name="action" value="magazineafrique_submit_ad_booking">
            <input type="hidden" name="nonce" value="<?php echo esc_attr($nonce); ?>">
            <input type="hidden" id="form_spot_key" name="spot_key" value="spot_masthead">
            <input type="hidden" id="form_currency" name="currency" value="NGN">
            <input type="hidden" id="form_impressions" name="impressions" value="25000">

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
              <label for="notes" class="field-label">Special Campaign Instructions / Sector Targeting (Optional)</label>
              <textarea id="notes" name="notes" rows="3" class="field-textarea" placeholder="Specify any editorial desk preferences (Finance, Energy, Diplomacy) or campaign flight dates..."></textarea>
            </div>

            <!-- Booking Overview Banner Inside Form -->
            <div class="booking-manifest-banner">
              <div class="manifest-item">
                <span class="m-label">Selected Space:</span>
                <span class="m-val" id="form_manifest_spot">Spot 1: Master Masthead Leaderboard</span>
              </div>
              <div class="manifest-item">
                <span class="m-label">Target Reach:</span>
                <span class="m-val" id="form_manifest_imps">25,000 Guaranteed Impressions</span>
              </div>
              <div class="manifest-item">
                <span class="m-label">Total Amount:</span>
                <span class="m-val highlight" id="form_manifest_total">₦250,000</span>
              </div>
            </div>

            <div id="form-feedback" class="form-feedback-alert" style="display: none;"></div>

            <button type="submit" class="submit-booking-btn" id="submit_booking_btn">
              <span class="btn-spinner" id="btn_spinner" style="display: none;"></span>
              <span class="btn-text" id="btn_label">Transmit Ad Booking &amp; Generate Invoice</span>
            </button>

            <p class="form-compliance-notice">
              By submitting, your organization agrees to Magazine Afrique's Editorial Brand Standards. Direct campaigns take priority over programmatic tags and serve until the booked impressions quota is fully delivered.
            </p>
          </form>
        </div>

        <!-- Sidebar Right: Standards & Assurance -->
        <div class="booking-sidebar">
          <div class="sidebar-info-card">
            <h3 class="info-card-title">Broadsheet Brand Standards</h3>
            <ul class="standards-list">
              <li>
                <strong>Brand Reach Guarantee:</strong> Your banner is served across high-authority analytical essays and broadsheet dispatches until your contracted impression count is 100% fulfilled.
              </li>
              <li>
                <strong>No Bot Fraud:</strong> Magazine Afrique uses server-side tokenized verification to filter automated scrapers and ensure real human reader impressions.
              </li>
              <li>
                <strong>Priority Slot Override:</strong> Direct Brand Reach partners take instant priority over programmatic Google AdSense slots.
              </li>
              <li>
                <strong>Instant Reversion:</strong> Once contracted impressions are delivered, the slot seamlessly reverts to Google AdSense without causing layout shifts.
              </li>
            </ul>
          </div>

          <div class="sidebar-info-card wire-info-card">
            <h3 class="info-card-title">Commercial Wire Settlement</h3>
            <p class="wire-desc">
              Following booking transmission, a pro-forma commercial invoice is automatically issued. Bank wire transfers are accepted via:
            </p>
            <div class="settlement-banks">
              <div class="bank-pill">
                <span class="bank-currency">NGN</span>
                <span class="bank-details">Zenith Bank Plc · Magazine Afrique Commercial</span>
              </div>
              <div class="bank-pill">
                <span class="bank-currency">USD / EUR</span>
                <span class="bank-details">Standard Chartered Bank · Swift Continental Wire</span>
              </div>
            </div>
            <span class="wire-dispatch-note">Paystack corporate settlement link provided upon confirmation.</span>
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
            <span class="cell-l">Guaranteed Reach</span>
            <span class="cell-v mono" id="modal_impressions">-</span>
          </div>
          <div class="modal-summary-cell">
            <span class="cell-l">Total Amount</span>
            <span class="cell-v mono highlight" id="modal_total_amount">-</span>
          </div>
        </div>

        <div class="modal-next-steps">
          <strong>Next Action:</strong>
          <span>A confirmation dispatch has been sent to your email. Our commercial representative will contact your desk on WhatsApp / phone to confirm creative activation.</span>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="modal-btn modal-btn-primary" onclick="closeSuccessModal()">
          Acknowledged &amp; Return
        </button>
        <a id="modal_whatsapp_link" href="#" target="_blank" class="modal-btn modal-btn-whatsapp">
          Connect with Commercial Desk on WhatsApp ↗
        </a>
      </div>
    </div>
  </div>

</main>

<script>
/**
 * Magazine Afrique Brand Reach Advertising Portal Controller
 */
(function($) {
  'use strict';

  // Dynamic pricing matrix
  var spotsMatrix = <?php echo json_encode($spots_matrix); ?>;
  var currentCurrency = 'NGN';
  var currentSpot = 'spot_masthead';
  var currentImpressions = 25000;

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
      var dHint = 'Recommended: ' + spotsMatrix[spotKey].desktop_dim + ' (Desktop) · ' + spotsMatrix[spotKey].mobile_dim + ' (Mobile)';
      $('#dropzone_dim_hint').text(dHint);
    }

    recalculateRates();
  };

  window.selectSpotFromCard = function(spotKey) {
    $('input[name="calc_spot"][value="' + spotKey + '"]').prop('checked', true).trigger('change');
    // Smooth scroll to calculator
    var target = document.getElementById('ad-calculator');
    if (target) {
      target.scrollIntoView({ behavior: 'smooth' });
    }
  };

  window.setImpressionPackage = function(imps) {
    currentImpressions = parseInt(imps, 10);
    $('.imp-pill').removeClass('active');
    $('.imp-pill[data-imps="' + imps + '"]').addClass('active');
    $('#custom_imps_input').val(currentImpressions);
    $('#form_impressions').val(currentImpressions);
    recalculateRates();
  };

  window.onCustomImpsInput = function(val) {
    var imps = parseInt(val, 10);
    if (!imps || imps < 5000) {
      imps = 5000;
    }
    currentImpressions = imps;
    $('.imp-pill').removeClass('active');
    $('#form_impressions').val(currentImpressions);
    recalculateRates();
  };

  function recalculateRates() {
    var spot = spotsMatrix[currentSpot];
    if (!spot) return;

    var cpmRate = currentCurrency === 'USD' ? spot.cpm_usd : spot.cpm_ngn;
    var total = Math.round((currentImpressions / 1000) * cpmRate);
    var formattedTotal = currentCurrency === 'USD' ? '$' + total.toLocaleString() : '₦' + total.toLocaleString();
    var formattedRate = currentCurrency === 'USD' ? '$' + cpmRate.toFixed(2) + ' per 1,000' : '₦' + cpmRate.toLocaleString() + ' per 1,000';

    // Update summary column
    $('#summary_spot_title').text(spot.title);
    $('#summary_cpm_rate').text(formattedRate);
    $('#summary_impressions').text(currentImpressions.toLocaleString() + ' Readers');
    $('#summary_total_display').text(formattedTotal);

    // Update form manifest banner
    $('#form_manifest_spot').text(spot.title);
    $('#form_manifest_imps').text(currentImpressions.toLocaleString() + ' Guaranteed Impressions');
    $('#form_manifest_total').text(formattedTotal);
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
          $('#modal_impressions').text(Number(data.impressions).toLocaleString() + ' Guaranteed Readers');
          $('#modal_total_amount').text(data.currency === 'USD' ? '$' + Number(data.total_amount).toLocaleString() : '₦' + Number(data.total_amount).toLocaleString());

          // WhatsApp link
          var waText = encodeURIComponent('Hello Magazine Afrique Commercial Desk, I have just booked brand reach ad space for ' + data.brand_name + ' (Booking Code: ' + data.booking_code + '). Total: ' + data.currency + ' ' + Number(data.total_amount).toLocaleString());
          $('#modal_whatsapp_link').attr('href', 'https://wa.me/2348120000000?text=' + waText);

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
