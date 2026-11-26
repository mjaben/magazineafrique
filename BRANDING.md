# Magazine Afrique — Design System & Brand Guidelines
> **Living Specification & Single Source of Truth**  
> *Version: 1.9.6 · Last Updated: 2026-11-26*  
> *Applies to: User Frontend (Desktop & Mobile) and WordPress Admin Console (ArtCraft)*

---

## 1. Brand Identity & Editorial Mission

### 1.1 The Journal
**Magazine Afrique** is an independent, pan-African broadsheet magazine and journal of record established in 2024. It provides strategic geopolitical analysis, macroeconomic intelligence, continental trade monitoring, and cultural dossiers across Africa's five regional economic communities.

### 1.2 Official Meta Description
```text
Independent pan-African journal of strategic analysis, macroeconomic intelligence, geopolitics, trade, and culture.
```
*Note: This exact sentence is the canonical brand description and must be used in the footer brand lockup, SEO metadata, PWA manifests, and social graph tags.*

### 1.3 Core Visual Philosophy
- **Vintage Broadsheet Integrity:** Dignified typography inspired by century-old broadsheet gazettes (*The Financial Times*, *Le Monde Diplomatique*, historic African print journals).
- **Tactile Box UI (Neo-Brutalist Frame):** Solid 2px dark borders paired with crisp, unblurred 5px solid offset black drop shadows.
- **Calm Restraint:** Zero screaming colors, zero fluorescent banners, zero flashing badges.
- **Warm Contrast in All Modes:** 
  - **Light Mode:** Warm alabaster paper (`#FAF8F5` ground, `#FFFFFF` cards, `#171513` ink).
  - **Dark Mode:** Deep warm charcoal (`#0E0C0B` / `#171513` ground, `#FAF7F2` headlines, `#E2DACD` reader text, pitch-black offset shadows).

---

## 2. Color Palette & Design Tokens

### 2.1 Core Palette

| Role | Token / Value | Dark Mode Override | Usage |
| :--- | :--- | :--- | :--- |
| **Savannah Ochre / Gold** | `#B45309` | `#FBBF24` / `#D4AF37` | Desk tags, kickers, active nav links, glyphs (`❖`), subtle focus rings |
| **Sahel Forest** | `#0B5128` | `#10B981` (Accents) | Brand identity mark (`MA` badge), historic seal. **Never use as loud background!** |
| **Paper Ground** | `#FAF8F5` | `#0E0C0B` | Page canvas background |
| **Card Surface** | `#FFFFFF` | `#1A1715` / `#171513` | Postcards, article containers, desk cards, form boxes |
| **Ink Headline** | `#171513` | `#FAF7F2` | Large titles, broadsheet headlines, author bylines |
| **Ink Reading Text** | `#2E2925` | `#E2DACD` | Long-form body paragraphs, excerpts, leads, drop caps |
| **Muted Meta** | `#78716C` | `#A39A8E` | Datelines, reading times, kicker metadata, photo captions |
| **Tactile Border** | `#231F1D` (2px) | `rgba(255, 255, 255, 0.22)` | Postcards, image frames, input borders, button outlines |
| **Tactile Shadow** | `#231F1D` (5px) | `#000000` (5px) | Hard solid offset drop shadow (`5px 5px 0px`) |

### 2.2 The "No Green Everywhere" Rule
- **Loud neon greens are strictly prohibited** across all floating components, cards, and buttons.
- The **WhatsApp Floating Intelligence Pill** must use **frosted glassmorphism** (`backdrop-filter: blur(18px)`, translucent dark background, subtle white border, white/gold typography).
- Buttons and cards must use tactile broadsheet borders and offset shadows—not flat neon blocks.

---

## 3. Typography Hierarchy

### 3.1 Font Families
- **Headlines & Long-Form Reading:** `'Newsreader'`, `'Playfair Display'`, `Georgia`, serif
- **Second Title (Deck / Sub-Headline):** `'Newsreader'`, `Georgia`, serif italic
- **Telegraph, Kickers, Datelines & Desks:** `'Geist Mono'`, `'JetBrains Mono'`, monospace
- **Admin Workspace & Technical UI:** `'Archivo'`, sans-serif

### 3.2 Type Scale & Styling

#### A. Broadsheet Headline (`.vintage-newspaper-headline`, `.article-title-main`)
```css
font-family: 'Newsreader', 'Playfair Display', Georgia, serif !important;
font-weight: 700 !important;
font-size: clamp(2rem, 5.2vw, 3.25rem);
line-height: 1.12 !important;
letter-spacing: -0.025em !important;
color: #171513;
/* Dark Mode */
[data-theme="dark"] .vintage-newspaper-headline { color: #FAF7F2 !important; }
```

#### B. Second Title / Broadsheet Deck (`.vintage-newspaper-deck`, `.broadsheet-deck-subhead`)
*Rule: Every single article MUST display a second title/deck. If the author did not specify a manual excerpt, generate a 24–28 word summary deck automatically.*
```css
font-family: 'Newsreader', Georgia, serif !important;
font-style: italic !important;
font-size: clamp(1.15rem, 2.3vw, 1.35rem) !important;
line-height: 1.48 !important;
color: #575149;
/* Dark Mode */
[data-theme="dark"] .vintage-newspaper-deck { color: #D6CEC3 !important; }
```

#### C. Kicker Eyebrow (`.vintage-headline-kicker-strip`, `.broadsheet-kicker-row`)
```css
font-family: 'Geist Mono', monospace;
font-size: 0.6875rem;
font-weight: 700;
letter-spacing: 0.1em;
text-transform: uppercase;
color: #B45309;
/* Dark Mode */
[data-theme="dark"] .kicker-desk-tag { color: #FBBF24 !important; }
```

#### D. Long-Form Reading Body (`.article-reading-body p`)
```css
font-family: 'Newsreader', Georgia, serif;
font-size: 1.125rem;
line-height: 1.78;
color: #2E2925;
/* Dark Mode */
[data-theme="dark"] .article-reading-body p { color: #E2DACD !important; }
```

#### E. Classic Drop Cap (`.drop-cap-classic:first-letter`)
```css
font-family: 'Newsreader', Georgia, serif;
font-size: 3.5rem;
line-height: 0.85;
float: left;
margin-right: 0.65rem;
margin-bottom: -0.25rem;
font-weight: 700;
color: #171513;
/* Dark Mode: MUST NEVER BE INVISIBLE BLACK! */
[data-theme="dark"] .drop-cap-classic:first-letter { color: #FAF7F2 !important; }
```

---

## 4. Component Standards & The Tactile Box UI

### 4.1 The Tactile Box UI (Mandatory Pattern)
Used across Postcards, Image Frames, Notice Boxes, and Submit Buttons:

```css
/* Light Mode */
border: 2px solid #231F1D !important;
box-shadow: 5px 5px 0px #231F1D !important;
border-radius: 2px !important;
background: #FFFFFF !important;
transition: transform 0.15s ease, box-shadow 0.15s ease !important;

/* Interactive Hover Lift */
&:hover {
  transform: translate(-2px, -2px) !important;
  box-shadow: 7px 7px 0px #231F1D !important;
}

/* Dark Mode */
[data-theme="dark"] & {
  border-color: rgba(255, 255, 255, 0.22) !important;
  box-shadow: 5px 5px 0px #000000 !important;
  background: #1A1715 !important;
}
[data-theme="dark"] &:hover {
  box-shadow: 7px 7px 0px #000000 !important;
}
```

### 4.2 Featured Image Frame (Zero Overflow Architecture)
Featured images on single articles and landing pages must **never overflow horizontally**:
- Container: `max-width: 100% !important; width: 100% !important; box-sizing: border-box !important; overflow: hidden !important;`
- Frame: Tactile Box UI with 6px internal padding.
- Image: `width: 100% !important; max-width: 100% !important; height: auto !important; max-height: 520px !important; object-fit: cover !important; display: block !important;`
- Caption: Monospace archival archive stamp `[PHOTO ARCHIVE]` right-aligned.

### 4.3 Vintage Broadsheet Byline Strip
- Positioned immediately beneath the Second Title (Deck) and above the Featured Image.
- Top and bottom rules: `border-top: 2px solid #231F1D; border-bottom: 1px solid #231F1D;`.
- Left Cluster: `SPECIAL DESPATCH · BY [AUTHOR] · [DATE] · [READING TIME]`.
- Right Cluster:
  - Applaud / Like Button with live count (`♥ 12`).
  - Minimalist Broadsheet Wire Shares: `SHARE: WA / 𝕏 / IN / LINK`.

### 4.4 Commentary Form (`comments.php`)
- Follows **shadcn/ui** minimalist dark aesthetics.
- Card wrapper `#respond` uses the Tactile Box UI.
- Inputs (`.editorial-comment-input`) and textarea (`.editorial-comment-textarea`):
  - Dark mode background: `#141210` with subtle border `rgba(255, 255, 255, 0.2)`.
  - Focus state: savannah gold ring (`border-color: #FBBF24; box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.2)`).
  - Submit Button: Tactile Box UI with solid 4px offset shadow (`Post Commentary →`).

### 4.5 Floating WhatsApp Wire Pill
- Fixed to bottom right, dismissed with a 14-day expiry.
- Styling:
  ```css
  background: rgba(18, 17, 16, 0.82) !important;
  backdrop-filter: blur(18px) saturate(180%) !important;
  border: 1px solid rgba(255, 255, 255, 0.16) !important;
  border-radius: 8px !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.55) !important;
  ```
- Action button uses translucent white background (`rgba(255, 255, 255, 0.1)`), zero green blocks.

### 4.6 Floating Broadsheet Scroll-to-Top Button (`#magafrique-scroll-top`)
- Fixed to bottom-right (`bottom: 24px; right: 24px;` on desktop; `bottom: calc(68px + env(safe-area-inset-bottom, 0px)); right: 16px;` on mobile above the docked `.vintage-bottom-nav`), flipping cleanly to `left` in RTL (`[dir="rtl"]`) mode.
- Uses the **Tactile Box UI** (`2px solid #231F1D` border, `4px 4px 0px #231F1D` offset shadow, warm white `#FFFFFF` surface in light mode; `#1A1715` surface, `rgba(255, 255, 255, 0.22)` border, `#000000` shadow, and `#FBBF24` Savannah Gold hover accent in dark mode).
- Includes an integrated 3px bottom **reading-progress indicator bar** (`#B45309` light / `#FBBF24` dark).
- Reveals smoothly after scrolling past `360px`, respects `prefers-reduced-motion: reduce`, manages `tabindex`/`aria-hidden` for accessibility, and automatically clears the WhatsApp Wire Pill on mobile when active.

### 4.7 First-Time Viewer Welcome Modal (`#magafrique-welcome-modal`)
- Appears for first-time viewers and immediately after local cache is purged (`magazineafriquePurgeCacheAndReload` clears dismissal state).
- Prompts two clean one-tap actions inside a Tactile Box UI modal: **Install PWA App** (native `beforeinstallprompt` or inline iOS/browser guidance) and **Turn On Location** (`navigator.geolocation` for regional bourses and bureau alerts).
- Dismissing sets a **7-day cooldown** (`magafrique_welcome_dismissed_at`).
- **Never renders inside an installed PWA app** (`display-mode: standalone/fullscreen/minimal-ui`, `navigator.standalone`, or `android-app://`).

---

## 5. Landing Page Architecture (`front-page.php`)

1. **Above-the-Fold Hero & Continental Telegraph** + **Mid-Home Commercial Leaderboard** (`magazineafrique_render_ad_mid_home()`).
2. **Business & Enterprise:** Asymmetric Financial Dossier + AfCFTA Bourse Ribbon + Corporate Wire Ledger.
3. **Lifestyle & Living:** Full-width inverted-contrast salon (`#141210` light / `#FAF7F2` dark) with Tactile Postcards.
4. **Gazette Video Broadcasts (YouTube):** 12-playlist selector bar, widescreen player, broadcast wire queue, and Field Shorts shelf.
5. **Entertainment & Sports:** Split Cinema & Music pair + dedicated Sports Arena column.
6. **The Pan-African Archive Vault (History):** Classified historical dossier cards.
7. **Technology & Innovation:** 4-column modern tech grid.
8. **The Continental Series:** Full-bleed **Savannah Ochre brand-tinted band** (`#F5E6D3 → #ECD7BC` sandstone wash with `#92400E` borders & offset shadows in light mode; `#25190F → #1B120B` roasted umber with ochre-gold shadows in dark mode). Displays sub-category & reading time — **never displays `PART I` / `PART II` numbering**.
9. **Health & Longevity:** 3-column medical & longevity research grid.
10. **How-To's & Practical Manuals:** Asymmetric **Field Playbook & Workbook Ledger** (featured drafting blueprint card on the left + numbered horizontal quick-action rows `02`–`04` on the right — visually distinct from Health).
11. **Biography & Changemakers:** Executive portrait gallery.
12. **Education & Society:** 2-column broadsheet knowledge split.
13. **The Afrique Chronicle & Opinion:** 3-column sovereign essays & columnists gallery.
14. **Pan-African Topic Radar** & **The Africa Brief (Circular Notice)**.

---

## 6. WordPress Admin Architecture (ArtCraft Console)

### 6.1 Sidebar Section Titles & Spacing
- Menu Group Headers (`WORKSPACE`, `EDITORIAL`, `SYSTEM & PLUGINS`, `ADMINISTRATION`, `INTEGRATIONS`) **must never stick to the screen edge**.
- Enforced spacing:
  ```css
  .artcraft-menu-group-header {
    padding: 18px 0 6px 20px !important; /* 20px breathing room from screen side */
    letter-spacing: 0.14em !important;
  }
  ```
- Accompanied by 6px glowing dots (Blue, Purple, Teal, Emerald, Gold).

### 6.2 Zero-Gap Submenu Hover Architecture
- Top-level menu items must have an invisible hover bridge (`::after` with `right: -10px; width: 18px;`) to prevent the cursor from dropping.
- Flyout submenus overlap the sidebar by 4px (`left: 216px !important;`), completely eliminating dead-air gaps.
- Flyout submenus use dark charcoal `#171513` with `border: 1px solid rgba(255, 255, 255, 0.16) !important`.
- **Zero WordPress / Yoast Blue:** Hover and active states use neutral translucent highlights (`rgba(255, 255, 255, 0.08)`), never `#2271b1` or royal blue.

### 6.3 Technical Frames & Reticles
- WordPress List Tables (`.wp-list-table`) are framed in ArtCraft technical cards with `+` reticle crosshairs at all four corners.

---

## 7. Monetization Engine & Strategic Ad Inventory

### 7.1 Client & Slot Inventory
- **Publisher Client:** `ca-pub-7175564788277515`
- **Slot 1: Header Leaderboard:** `4687046934` (Responsive, below nav bar)
- **Slot 2: In-Article Ad 1:** `9866978622` (Injected after paragraph 2)
- **Slot 3: In-Article Ad 2:** `3777306824` (Fluid native, injected after paragraph 5)
- **Slot 4: Sidebar Ad:** `1854558906` (300x250)
- **Slot 5: Mid-Home Leaderboard:** `4687046934` (Between hero and desks)
- **Slot 6: End-of-Article / Above Footer:** `1801863291` (Horizontal responsive)

### 7.2 Administrator Live Ad Auditing Rule
- `magazineafrique_should_display_ads()` **must always return `true` for administrators and editors** (`current_user_can('edit_posts')`), allowing staff to audit and test live ad inventory at all times.
- Paid non-staff subscribers (`magazineafrique_sub_status === 'active'`) receive a 100% ad-free experience.

---

## 8. Protocol for Future Updates

Whenever a change to the UI, UX, styling, or brand layout is implemented:
1. **Update this file (`BRANDING.md`) first** to reflect the new rule, component, token, or behavior.
2. **Apply the code changes** in both `magazineafrique-theme/assets/css/main.css`, `style.css`, and `admin-style.css`.
3. **Bump the theme version** (`MAGAZINEAFRIQUE_VERSION` in `functions.php` and `style.css`) to invalidate browser, server, and CDN caches.
4. **Rebuild `magazineafrique-theme.zip`** using `Compress-Archive`.
5. **Commit and push to Git** with a reference to the updated section in `BRANDING.md`.
