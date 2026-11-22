=== Magazine Afrique Theme ===
Contributors: Magazine Afrique Team
Tags: news, magazine, african, editorial, paywall, newsletter, google-ads, pwa, push-notifications, multilingual
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
License: GPLv2 or later

== Description ==

Magazine Afrique is a modern, high-performance, African-rooted editorial theme for Magazine Afrique.
Crafted specifically for shared hosting environments with ultra-fast page speed (TTFB < 100ms via LiteSpeed/FastCGI caching).

Key Features:
- Primary Language: English with built-in Language Switcher for African global languages (French, Arabic, Portuguese, Kiswahili)
- Progressive Web App (PWA) with Offline Reading mode
- Web Push Notifications on both Android and iOS (16.4+)
- Server-Side Paywall Engine (secure content truncation, zero inspect-element leaks)
- Google-Compliant NewsArticle & Paywall JSON-LD Schema (prevents cloaking penalties, optimizes Google News & Discover)
- Zero-CLS Google Ads Containers (AdSense & Google Ad Manager GPT)
- Automatic Ad Suppression for Paid Club Subscribers
- In-Article & Sidebar Newsletter Integration (compatible with Brevo, MailerLite, Mailchimp, Beehiiv)
- Deep-rooted African aesthetic: Heritage Horizon palette (Sahel Forest Emerald, Savannah Gold, Terracotta, Warm Alabaster)

== Installation ==

Method 1: From WordPress Admin
1. Compress the `magazineafrique-theme` directory into a `.zip` archive.
2. Log into your WordPress Dashboard (`/wp-admin`).
3. Navigate to: Appearance > Themes > Add New Theme > Upload Theme.
4. Select `magazineafrique-theme.zip` and click "Install Now".
5. Click "Activate".

Method 2: Via cPanel / FTP
1. Log into your cPanel > File Manager.
2. Navigate to: `public_html/wp-content/themes/`.
3. Upload and extract the `magazineafrique-theme` directory.
4. Activate the theme under Appearance > Themes.

== PWA & Push Notifications Configuration ==

- The theme includes a native Web App Manifest (`manifest.json`) and Service Worker (`sw.js`).
- iOS 16.4+ and Android users will receive an install prompt banner automatically.
- Once added to the Home Screen, visitors can read previously loaded stories offline and receive push notifications for breaking news.
- Compatible with OneSignal WordPress plugin if you want automated broadcast push on new post publish.

== Paywall Activation ==

To lock an article behind the Club Prestige paywall:
1. Add the tag `premium`, `subscriber`, or `exclusive` to the post, OR
2. Place the post in a category named `Premium`, `Exclusive`, or `Club`.
The theme will automatically truncate the post to the first 3 paragraphs and render the secure membership conversion card.
