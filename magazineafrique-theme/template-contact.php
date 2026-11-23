<?php
/**
 * Template Name: Contact / Continental Bureaus
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
            <span>MAGAZINE AFRIQUE · CONTINENTAL DISPATCHES</span>
            <span>❖</span>
        </div>
        
        <h1 class="font-serif vintage-newspaper-headline" style="font-size: clamp(2rem, 5vw, 3.25rem); font-weight: 900; line-height: 1.15; color: var(--text-primary, #171513); max-width: 900px; margin: 0 auto 1.25rem;">
            Contact the Editorial Desks &amp; Continental Bureaus
        </h1>

        <p class="vintage-newspaper-deck" style="font-family: 'Newsreader', Georgia, serif; font-size: 1.2rem; font-style: italic; line-height: 1.5; color: var(--text-secondary, #575149); max-width: 760px; margin: 0 auto 1.75rem;">
            Submit investigative leaks, confidential dossiers, press inquiries, syndicate requests, or reach correspondents across Africa.
        </p>

        <!-- Broadsheet Masthead Dateline Bar -->
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 1.5rem; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C); border-top: 1px solid var(--border-color, #231F1D); border-bottom: 1px solid var(--border-color, #231F1D); padding: 0.65rem 0; text-transform: uppercase; letter-spacing: 0.08em;">
            <span>CONFIDENTIAL SOURCES PROTECTED</span>
            <span>·</span>
            <span>DIRECT TELEGRAPH WIRE</span>
            <span>·</span>
            <span>HOURS: 06:00 – 22:00 WAT / EAT</span>
        </div>
    </header>

    <!-- 2. Two-Column Layout (Dispatch Form + Bureaus Directory) -->
    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 2.75rem; align-items: start;">
        
        <!-- Left Column: Interactive Dispatch Form & Whistleblower Shield -->
        <div>
            
            <div class="vintage-framed-box" style="padding: 2.25rem; margin-bottom: 2rem; background: var(--bg-card, #FFFFFF);">
                <div style="border-bottom: 1.5px solid var(--border-color, #231F1D); padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; letter-spacing: 0.12em; color: #B45309; text-transform: uppercase;">
                        DIRECT TRANSMISSION
                    </span>
                    <h2 class="font-serif" style="font-size: 1.4rem; font-weight: 800; margin: 0.25rem 0 0; color: var(--text-primary, #171513);">
                        Transmit an Editorial Dispatch
                    </h2>
                </div>

                <form id="contact-dispatch-form" style="display: flex; flex-direction: column; gap: 1.25rem;">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                                Your Name / Source Codename *
                            </label>
                            <input type="text" name="dispatch_name" required class="editorial-comment-input" placeholder="e.g. Adebayo O. or 'Anonymous Source'" />
                        </div>
                        <div>
                            <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                                Contact Email / Signal ID *
                            </label>
                            <input type="email" name="dispatch_email" required class="editorial-comment-input" placeholder="e.g. source@protonmail.com" />
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                                Organization / Entity
                            </label>
                            <input type="text" name="dispatch_org" class="editorial-comment-input" placeholder="e.g. AU Commission, ECOWAS, Sovereign Fund" />
                        </div>
                        <div>
                            <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                                Recipient Bureau / Desk *
                            </label>
                            <select name="dispatch_desk" required class="editorial-comment-input">
                                <option value="investigative">🔍 Investigative Desk (Whistleblower Leaks)</option>
                                <option value="geopolitics">🌍 Sovereign Geopolitics &amp; Sahel Desk</option>
                                <option value="markets">📈 AfCFTA &amp; Macroeconomic Markets Desk</option>
                                <option value="opinion">✒️ Letters to Editor / Guest Opinion</option>
                                <option value="commercial">💼 Commercial Partnerships &amp; Advertising</option>
                                <option value="prestige">★ Club Prestige Member Concierge</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Dispatch Subject *
                        </label>
                        <input type="text" name="dispatch_subject" required class="editorial-comment-input" placeholder="e.g. Sovereign Mining Concessions Leak in Katanga Belt" />
                    </div>

                    <div>
                        <label style="display: block; font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-primary, #171513); margin-bottom: 0.35rem;">
                            Detailed Dispatch / Intel Notes *
                        </label>
                        <textarea name="dispatch_message" rows="5" required class="editorial-comment-textarea" placeholder="Please provide background details, verifiable references, or secure rendezvous instructions..."></textarea>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color, #E8E2D8); padding-top: 1rem; margin-top: 0.5rem;">
                        <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C);">
                            🔒 256-bit SSL encrypted transmission
                        </span>
                        <button type="submit" class="circular-notice-btn" style="background: #D97706 !important; border-color: #D97706 !important; color: #FFFFFF !important;">
                            Transmit Dispatch →
                        </button>
                    </div>

                    <div id="contact-form-feedback" style="display: none; padding: 0.85rem; border-radius: 2px; font-family: 'Geist Mono', monospace; font-size: 0.75rem; font-weight: 700;"></div>

                </form>
            </div>

            <!-- Whistleblower Protection Banner -->
            <div class="vintage-framed-box" style="padding: 1.5rem; background: #0D2818; color: #FAF7F2; border: 2px solid #0B5128; box-shadow: 4px 4px 0px #1C1917;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <span style="color: #FBBF24; font-size: 1.25rem;">🛡️</span>
                    <h3 style="font-family: 'Geist Mono', monospace; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.1em; color: #FBBF24; margin: 0; text-transform: uppercase;">
                        WHISTLEBLOWER &amp; SOURCE INTEGRITY PROMISE
                    </h3>
                </div>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.875rem; line-height: 1.5; color: #D6CEC3; margin: 0 0 0.75rem;">
                    We never log source IP addresses or track whistleblowers. If you are leaking sensitive documents or classified sovereign agreements, please reach us through encrypted channels:
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: #A39A8E; background: rgba(0,0,0,0.3); padding: 0.5rem 0.75rem; border-radius: 2px;">
                    Signal Wire: +234 (0) 812-AFRIQUE · PGP Key: 4A8F B92C 01ED 38BA
                </div>
            </div>

        </div>

        <!-- Right Column: Continental Bureaus & Direct Channels -->
        <aside style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <div style="border-bottom: 2px solid var(--border-color, #231F1D); padding-bottom: 0.5rem;">
                <span style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; font-weight: 800; color: #B45309; letter-spacing: 0.1em;">
                    CONTINENTAL ADDRESSES
                </span>
                <h3 class="font-serif" style="font-size: 1.25rem; font-weight: 800; margin: 0.2rem 0 0; color: var(--text-primary, #171513);">
                    Permanent Editorial Bureaus
                </h3>
            </div>

            <!-- Bureau Card 1: Lagos -->
            <div class="vintage-grid-card" style="padding: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309;">WEST AFRICA HUB</span>
                    <span style="font-size: 0.875rem;">🇳🇬</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.1rem; font-weight: 800; margin: 0 0 0.25rem; color: var(--text-primary, #171513);">
                    Lagos Bureau
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.8125rem; color: var(--text-secondary, #575149); margin: 0 0 0.5rem; line-height: 1.4;">
                    Ahmadu Bello Way, Victoria Island, Lagos
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C);">
                    Tel: +234 1 892 0100 · lagos@magazineafrique.org
                </div>
            </div>

            <!-- Bureau Card 2: Nairobi -->
            <div class="vintage-grid-card" style="padding: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309;">EAST AFRICA HUB</span>
                    <span style="font-size: 0.875rem;">🇰🇪</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.1rem; font-weight: 800; margin: 0 0 0.25rem; color: var(--text-primary, #171513);">
                    Nairobi Bureau
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.8125rem; color: var(--text-secondary, #575149); margin: 0 0 0.5rem; line-height: 1.4;">
                    Upper Hill Road, Nairobi, Kenya
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C);">
                    Tel: +254 20 762 1000 · nairobi@magazineafrique.org
                </div>
            </div>

            <!-- Bureau Card 3: Dakar -->
            <div class="vintage-grid-card" style="padding: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309;">FRANCOPHONE DESK</span>
                    <span style="font-size: 0.875rem;">🇸🇳</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.1rem; font-weight: 800; margin: 0 0 0.25rem; color: var(--text-primary, #171513);">
                    Dakar Bureau
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.8125rem; color: var(--text-secondary, #575149); margin: 0 0 0.5rem; line-height: 1.4;">
                    Avenue Albert Sarraut, Dakar-Plateau
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C);">
                    Tel: +221 33 821 4400 · dakar@magazineafrique.org
                </div>
            </div>

            <!-- Bureau Card 4: Johannesburg -->
            <div class="vintage-grid-card" style="padding: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                    <span style="font-family: 'Geist Mono', monospace; font-size: 0.625rem; font-weight: 800; color: #B45309;">SOUTHERN AFRICA</span>
                    <span style="font-size: 0.875rem;">🇿🇦</span>
                </div>
                <h4 class="font-serif" style="font-size: 1.1rem; font-weight: 800; margin: 0 0 0.25rem; color: var(--text-primary, #171513);">
                    Johannesburg Bureau
                </h4>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.8125rem; color: var(--text-secondary, #575149); margin: 0 0 0.5rem; line-height: 1.4;">
                    Alice Lane, Sandton, Johannesburg
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: var(--text-muted, #78716C);">
                    Tel: +27 11 784 9000 · joburg@magazineafrique.org
                </div>
            </div>

            <!-- Commercial Partnerships Card -->
            <div class="vintage-framed-box" style="padding: 1.25rem; background: var(--bg-card, #FFFFFF);">
                <div style="display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.35rem;">
                    <span style="font-size: 1rem;">💼</span>
                    <h4 class="font-serif" style="font-size: 1rem; font-weight: 800; margin: 0; color: var(--text-primary, #171513);">
                        Commercial &amp; Syndication
                    </h4>
                </div>
                <p style="font-family: 'Newsreader', Georgia, serif; font-size: 0.8125rem; color: var(--text-secondary, #575149); margin: 0 0 0.5rem; line-height: 1.4;">
                    For brand sponsorships, corporate partnerships, and print syndication agreements:
                </p>
                <div style="font-family: 'Geist Mono', monospace; font-size: 0.6875rem; color: #B45309; font-weight: 700;">
                    commercial@magazineafrique.org
                </div>
            </div>

        </aside>

    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('contact-dispatch-form');
    var feedback = document.getElementById('contact-form-feedback');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (feedback) {
                feedback.style.display = 'block';
                feedback.style.background = '#0B5128';
                feedback.style.color = '#FFFFFF';
                feedback.textContent = '✓ Dispatch transmitted securely to Magazine Afrique editorial board. We will review your correspondence within 12 hours.';
            }
            form.reset();
        });
    }
});
</script>

<?php get_footer(); ?>