<?php
/**
 * Template Name: About Us / Editorial Board
 * Template Post Type: page
 *
 * @package MagazineAfrique
 */

get_header(); ?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 1040px; margin: 0 auto; padding-top: 2rem; padding-bottom: 4rem;">

    <!-- 1. Broadsheet Hero Section -->
    <header class="page-broadsheet-hero" style="text-align: center; border-bottom: 3px double var(--border-color, #231F1D); padding-bottom: 2rem; margin-bottom: 3rem;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; letter-spacing: 0.14em; color: #B45309; text-transform: uppercase; margin-bottom: 0.75rem;">
            <span>❖</span>
            <span>MAGAZINE AFRIQUE · INSTITUTIONAL CHARTER</span>
            <span>❖</span>
        </div>
        
        <h1 class="font-serif vintage-newspaper-headline" style="font-size: clamp(2rem, 5vw, 3.25rem); font-weight: 900; line-height: 1.15; color: var(--text-primary, #171513); max-width: 900px; margin: 0 auto 1.25rem;">
            The Sovereign Chronicle of African Geopolitics, Enterprise &amp; Culture
        </h1>

        <p class="vintage-newspaper-deck" style="font-family: 'Newsreader', Georgia, serif; font-size: 1.2rem; font-style: italic; line-height: 1.5; color: var(--text-secondary, #575149); max-width: 760px; margin: 0 auto 1.75rem;">
            An independent pan-African journal of strategic intelligence, macroeconomic analysis, and sovereign statecraft serving 54 nations.
        </p>

        <!-- Broadsheet Masthead Dateline Bar -->
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 1.5rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px solid var(--border-color, #231F1D); border-bottom: 1px solid var(--border-color, #231F1D); padding: 0.65rem 0; text-transform: uppercase; letter-spacing: 0.08em;">
            <span>ESTABLISHED 2026</span>
            <span>·</span>
            <span>PAN-AFRICAN JOURNAL OF RECORD</span>
            <span>·</span>
            <span>BUREAUS IN LAGOS · NAIROBI · DAKAR · CAIRO · JOHANNESBURG</span>
        </div>
    </header>

    <!-- 2. Editorial Creed / Executive Mission (Parchment Tactile Card) -->
    <section class="vintage-framed-box" style="padding: 2.25rem 2.5rem; margin-bottom: 3.5rem; background: var(--bg-card, #FFFFFF);">
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1.5px solid var(--border-color, #231F1D); padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
            <h2 style="font-family: 'Geist Mono', monospace; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; color: #B45309; margin: 0;">
                OUR EDITORIAL MISSION &amp; JOURNALISTIC CREED
            </h2>
            <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C);">
                ARTICLE I OF CHARTER
            </span>
        </div>

        <div class="drop-cap-classic" style="font-family: 'Newsreader', Georgia, serif; font-size: 1.15rem; line-height: 1.75; color: var(--text-secondary, #2A2521);">
            <p style="margin-bottom: 1.25rem;">
                Magazine Afrique was founded on a singular conviction: that Africa’s geopolitical, economic, and technological destiny must be chronicled from within, with rigor, sovereignty, and uncompromised intellectual independence. In an era of fragmented narratives and external posturing, we provide high-resolution intelligence for continental decision-makers, policymakers, institutional investors, and engaged readers across Africa and its global diaspora.
            </p>
            <p style="margin: 0;">
                From the diplomatic corridors of Addis Ababa to the financial exchanges of Lagos, Johannesburg, and Nairobi, our network of seasoned correspondents reports on critical developments shaping sovereign trade, regional security alliances, macroeconomic policy under AfCFTA, and Africa’s cultural renaissance.
            </p>
        </div>
    </section>

    <!-- 3. Four Core Editorial Desks (Tactile Cards Grid) -->
    <section style="margin-bottom: 4rem;">
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 0.65rem; margin-bottom: 2rem;">
            <h2 class="font-serif vintage-newspaper-headline" style="font-size: 1.65rem; font-weight: 800; margin: 0; color: var(--text-primary, #171513);">
                Our Four Core Editorial Desks
            </h2>
            <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: #B45309; letter-spacing: 0.08em;">
                CONTINENTAL COVERAGE
            </span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
            
            <!-- Pillar 1 -->
            <article class="vintage-grid-card" style="padding: 1.5rem; display: flex; flex-direction: column;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.85rem;">
                    <span style="font-size: 1.75rem;">🌍</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309; letter-spacing: 0.1em;">DESK 01</span>
                </div>
                <h3 class="font-serif" style="font-size: 1.25rem; font-weight: 700; margin: 0 0 0.5rem; color: var(--text-primary, #171513);">
                    Sovereign Geopolitics
                </h3>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.9375rem; line-height: 1.55; color: var(--text-secondary, #575149); margin: 0;">
                    Rigorous analysis of Sahel diplomatic shifts, ECOWAS and EAC regional integration, African Union summits, and bilateral multipolar partnerships across the Global South.
                </p>
            </article>

            <!-- Pillar 2 -->
            <article class="vintage-grid-card" style="padding: 1.5rem; display: flex; flex-direction: column;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.85rem;">
                    <span style="font-size: 1.75rem;">📈</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309; letter-spacing: 0.1em;">DESK 02</span>
                </div>
                <h3 class="font-serif" style="font-size: 1.25rem; font-weight: 700; margin: 0 0 0.5rem; color: var(--text-primary, #171513);">
                    AfCFTA &amp; Sovereign Markets
                </h3>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.9375rem; line-height: 1.55; color: var(--text-secondary, #575149); margin: 0;">
                    Monitoring cross-border commercial flows, central bank monetary policy, sovereign debt restructuring, African mineral value chains, and domestic infrastructure bonds.
                </p>
            </article>

            <!-- Pillar 3 -->
            <article class="vintage-grid-card" style="padding: 1.5rem; display: flex; flex-direction: column;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.85rem;">
                    <span style="font-size: 1.75rem;">⚡</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309; letter-spacing: 0.1em;">DESK 03</span>
                </div>
                <h3 class="font-serif" style="font-size: 1.25rem; font-weight: 700; margin: 0 0 0.5rem; color: var(--text-primary, #171513);">
                    Technological Autonomy
                </h3>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.9375rem; line-height: 1.55; color: var(--text-secondary, #575149); margin: 0;">
                    Investigating African data centers, artificial intelligence trained on Indigenous languages, renewable microgrids, and sovereign digital identity infrastructures.
                </p>
            </article>

            <!-- Pillar 4 -->
            <article class="vintage-grid-card" style="padding: 1.5rem; display: flex; flex-direction: column;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.85rem;">
                    <span style="font-size: 1.75rem;">🎭</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309; letter-spacing: 0.1em;">DESK 04</span>
                </div>
                <h3 class="font-serif" style="font-size: 1.25rem; font-weight: 700; margin: 0 0 0.5rem; color: var(--text-primary, #171513);">
                    Cultural Statecraft
                </h3>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.9375rem; line-height: 1.55; color: var(--text-secondary, #575149); margin: 0;">
                    Critical appraisal of African literary renaissance, cinema, architectural heritage, historical restitution, and the philosophical foundations of pan-African unity.
                </p>
            </article>

        </div>
    </section>

    <!-- 4. Continental Bureau Network (6 Postcards) -->
    <section style="margin-bottom: 4rem;">
        <div style="display: flex; align-items: baseline; justify-content: space-between; border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 0.65rem; margin-bottom: 2rem;">
            <h2 class="font-serif vintage-newspaper-headline" style="font-size: 1.65rem; font-weight: 800; margin: 0; color: var(--text-primary, #171513);">
                The Continental Bureau Network
            </h2>
            <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 700; color: #B45309; letter-spacing: 0.08em;">
                PERMANENT STATIONS
            </span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            
            <!-- Bureau: Lagos -->
            <div class="vintage-framed-box" style="padding: 1.5rem; background: var(--bg-card, #FFFFFF);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; color: #B45309;">WEST AFRICA DESK</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C);">EST. 2026</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.2rem; font-weight: 800; margin: 0 0 0.35rem; color: var(--text-primary, #171513);">
                    Lagos, Nigeria
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: var(--text-secondary, #575149); margin: 0 0 0.85rem; line-height: 1.45;">
                    Victoria Island Editorial Suite · Covering Gulf of Guinea trade, sovereign fintech, and West African geopolitics.
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px dashed rgba(120, 113, 108, 0.3); padding-top: 0.5rem;">
                    Wire: lagos@magazineafrique.org
                </div>
            </div>

            <!-- Bureau: Nairobi -->
            <div class="vintage-framed-box" style="padding: 1.5rem; background: var(--bg-card, #FFFFFF);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; color: #B45309;">EAST AFRICA DESK</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C);">EST. 2026</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.2rem; font-weight: 800; margin: 0 0 0.35rem; color: var(--text-primary, #171513);">
                    Nairobi, Kenya
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: var(--text-secondary, #575149); margin: 0 0 0.85rem; line-height: 1.45;">
                    Upper Hill Diplomatic Quarter · Covering EAC single market, Horn of Africa security, and green energy investments.
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px dashed rgba(120, 113, 108, 0.3); padding-top: 0.5rem;">
                    Wire: nairobi@magazineafrique.org
                </div>
            </div>

            <!-- Bureau: Dakar -->
            <div class="vintage-framed-box" style="padding: 1.5rem; background: var(--bg-card, #FFFFFF);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; color: #B45309;">FRANCOPHONE DESK</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C);">EST. 2026</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.2rem; font-weight: 800; margin: 0 0 0.35rem; color: var(--text-primary, #171513);">
                    Dakar, Senegal
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: var(--text-secondary, #575149); margin: 0 0 0.85rem; line-height: 1.45;">
                    Plateau Media District · Covering AES Sahel sovereignty, West African monetary reform, and Francophone cultural life.
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px dashed rgba(120, 113, 108, 0.3); padding-top: 0.5rem;">
                    Wire: dakar@magazineafrique.org
                </div>
            </div>

            <!-- Bureau: Johannesburg -->
            <div class="vintage-framed-box" style="padding: 1.5rem; background: var(--bg-card, #FFFFFF);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; color: #B45309;">SOUTHERN AFRICA DESK</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C);">EST. 2026</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.2rem; font-weight: 800; margin: 0 0 0.35rem; color: var(--text-primary, #171513);">
                    Johannesburg, South Africa
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: var(--text-secondary, #575149); margin: 0 0 0.85rem; line-height: 1.45;">
                    Sandton Financial Centre · Tracking SADC industrial policy, mineral commodities, and BRICS financial corridors.
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px dashed rgba(120, 113, 108, 0.3); padding-top: 0.5rem;">
                    Wire: joburg@magazineafrique.org
                </div>
            </div>

            <!-- Bureau: Cairo -->
            <div class="vintage-framed-box" style="padding: 1.5rem; background: var(--bg-card, #FFFFFF);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; color: #B45309;">NORTH AFRICA DESK</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C);">EST. 2026</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.2rem; font-weight: 800; margin: 0 0 0.35rem; color: var(--text-primary, #171513);">
                    Cairo, Egypt
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: var(--text-secondary, #575149); margin: 0 0 0.85rem; line-height: 1.45;">
                    Zamalek Press Bureau · Covering Suez trade routes, Nile Basin geopolitics, and Afro-Arab economic integration.
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px dashed rgba(120, 113, 108, 0.3); padding-top: 0.5rem;">
                    Wire: cairo@magazineafrique.org
                </div>
            </div>

            <!-- Bureau: Addis Ababa -->
            <div class="vintage-framed-box" style="padding: 1.5rem; background: var(--bg-card, #FFFFFF);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; color: #B45309;">AU DIPLOMATIC DESK</span>
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; color: var(--text-muted, #78716C);">EST. 2026</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.2rem; font-weight: 800; margin: 0 0 0.35rem; color: var(--text-primary, #171513);">
                    Addis Ababa, Ethiopia
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; color: var(--text-secondary, #575149); margin: 0 0 0.85rem; line-height: 1.45;">
                    Bole Diplomatic Enclave · Covering African Union treaties, peacekeeping frameworks, and multilateral negotiations.
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px dashed rgba(120, 113, 108, 0.3); padding-top: 0.5rem;">
                    Wire: addis@magazineafrique.org
                </div>
            </div>

        </div>
    </section>

    <!-- 5. Editorial Standards & Whistleblower Shield -->
    <section class="vintage-framed-box" style="padding: 2rem 2.25rem; margin-bottom: 3.5rem; background: var(--bg-card, #FFFFFF);">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
            <span style="font-size: 1.25rem;">⚖️</span>
            <h3 class="font-serif" style="font-size: 1.25rem; font-weight: 800; margin: 0; color: var(--text-primary, #171513);">
                Journalistic Independence &amp; Source Verification
            </h3>
        </div>
        <p style="font-family: 'Newsreader', Georgia, serif; font-size: 1rem; line-height: 1.6; color: var(--text-secondary, #575149); margin: 0 0 1rem;">
            Magazine Afrique operates under strict non-partisan editorial governance. We accept no sovereign state control, partisan campaign sponsorship, or covert intelligence briefings. All investigative reporting undergoes multi-source corroboration through our cross-bureau editorial board.
        </p>
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="circular-notice-btn" style="text-decoration: none; font-size: 0.75rem;">
                Submit Secure Tip to Desks →
            </a>
            <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C);">
                Encrypted whistleblowing via PGP &amp; Signal available.
            </span>
        </div>
    </section>

    <!-- 6. Club Prestige CTA -->
    <section class="vintage-framed-box" style="background: #072213; color: #FAF7F2; border: 3px solid #D97706; padding: 2.5rem; text-align: center; box-shadow: 6px 6px 0px #1C1917;">
        <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; letter-spacing: 0.14em; color: #FBBF24; text-transform: uppercase;">
            ★ SOVEREIGN INTELLIGENCE MEMBERSHIP
        </span>
        <h2 class="font-serif" style="font-size: 1.85rem; font-weight: 900; margin: 0.5rem 0 1rem; color: #FAF7F2;">
            Join Club Prestige: The Continental Executive Circle
        </h2>
        <p style="font-family: 'Newsreader', Georgia, serif; font-size: 1.05rem; line-height: 1.5; color: #E2DACD; max-width: 600px; margin: 0 auto 1.5rem;">
            Receive unredacted geopolitical intelligence dossiers, macroeconomic data forecasts, and exclusive invites to closed-door sovereign roundtables.
        </p>
        <a href="<?php echo esc_url(home_url('/subscribe/')); ?>" class="circular-notice-btn" style="background: #FBBF24 !important; color: #171513 !important; border-color: #FBBF24 !important; font-size: 0.8125rem; display: inline-block; text-decoration: none;">
            Enroll in Club Prestige →
        </a>
    </section>

</main>

<?php get_footer(); ?>