<?php
/**
 * Magazine Afrique — Comprehensive Editorial SEO, Open Graph & Structured Data Engine
 * 
 * Provides end-to-end SEO optimization across all page types:
 * - Dynamically generated editorial meta titles & descriptions
 * - Self-referencing canonical URLs
 * - Google Discover optimized robots directives (max-image-preview:large)
 * - Complete Open Graph (Facebook, WhatsApp, LinkedIn, Telegram) & Twitter Card markup
 * - Google News & AI compliant JSON-LD Schemas:
 *   - NewsMediaOrganization (all pages with bureaus & governance)
 *   - WebSite with SearchAction (homepage)
 *   - AnalysisNewsArticle / NewsArticle with Speakable & Author data (single articles)
 *   - CollectionPage (category/tag archives)
 *   - ProfilePage (author archives)
 *   - AboutPage / ContactPage / WebPage (static pages)
 *   - BreadcrumbList (navigational schema for rich SERP snippets)
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Editorial Document Title Separator & Parts Filter
 */
function magazineafrique_seo_document_title_separator($sep) {
    return '—';
}
add_filter('document_title_separator', 'magazineafrique_seo_document_title_separator');

function magazineafrique_seo_document_title_parts($title) {
    if (is_front_page()) {
        $title['title'] = get_bloginfo('name');
        $title['tagline'] = 'Pan-African Journal of Geopolitics, Enterprise & Culture';
    } elseif (is_category()) {
        $cat = get_queried_object();
        $title['title'] = $cat ? $cat->name . ' Intelligence & Wire' : single_cat_title('', false);
        $title['site'] = get_bloginfo('name');
    } elseif (is_tag()) {
        $tag = get_queried_object();
        $title['title'] = '#' . ($tag ? $tag->name : single_tag_title('', false)) . ' Dossiers';
        $title['site'] = get_bloginfo('name');
    } elseif (is_author()) {
        $author = get_queried_object();
        $title['title'] = ($author ? $author->display_name : 'Correspondent') . ' Dispatches';
        $title['site'] = get_bloginfo('name');
    } elseif (is_search()) {
        $title['title'] = 'Search: "' . get_search_query() . '"';
        $title['site'] = get_bloginfo('name');
    } elseif (is_404()) {
        $title['title'] = '404 Dispatch Not Found';
        $title['site'] = get_bloginfo('name');
    } elseif (is_page()) {
        if (is_page('about') || is_page_template('template-about.php')) {
            $title['title'] = 'Institutional Charter & Editorial Board';
        } elseif (is_page('contact') || is_page_template('template-contact.php')) {
            $title['title'] = 'Continental Bureaus & Editorial Desks';
        } elseif (is_page('advertise') || is_page('buy-ad-space') || is_page_template('template-buy-ad-space.php')) {
            $title['title'] = 'Brand Reach Advertising & Sponsored Dossiers';
        } elseif (is_page('subscribe') || is_page_template('template-subscribe.php')) {
            $title['title'] = 'Club Prestige Membership & Subscription';
        } elseif (is_page('feed') || is_page_template('template-feed.php')) {
            $title['title'] = 'Pan-African Intelligence Wire & Reader Feed';
        }
        $title['site'] = get_bloginfo('name');
    }
    return $title;
}
add_filter('document_title_parts', 'magazineafrique_seo_document_title_parts');

/**
 * 2. Helper: Get Dynamic Meta Description
 */
function magazineafrique_seo_get_description() {
    $desc = '';

    if (is_front_page() || is_home()) {
        $desc = "Magazine Afrique is the sovereign pan-African journal of geopolitical analysis, macroeconomic intelligence, continental trade, business, technology, culture, and high-level commentary across all 54 African states.";
    } elseif (is_single()) {
        $post = get_post();
        if ($post) {
            if (!empty($post->post_excerpt)) {
                $desc = wp_strip_all_tags($post->post_excerpt);
            } else {
                $desc = wp_trim_words(wp_strip_all_tags(strip_shortcodes($post->post_content)), 28, '...');
            }
        }
    } elseif (is_page()) {
        $post = get_post();
        if ($post) {
            if (is_page('about') || is_page_template('template-about.php')) {
                $desc = "Magazine Afrique Institutional Charter — Pan-African journal dedicated to independent geopolitical analysis, economic sovereignty, and intellectual inquiry across all 54 African states.";
            } elseif (is_page('contact') || is_page_template('template-contact.php')) {
                $desc = "Contact Magazine Afrique editorial desks, foreign correspondents, and bureau chiefs in Dakar, Lagos, Nairobi, Johannesburg, Cairo, London, and headquarters.";
            } elseif (is_page('privacy-policy')) {
                $desc = "Magazine Afrique Privacy Policy & Data Governance — How we collect, safeguard, and respect reader information under GDPR and continental privacy regulations.";
            } elseif (is_page('terms')) {
                $desc = "Magazine Afrique Terms of Service, Syndication Rights, Editorial Copyright, and Reader License.";
            } elseif (is_page('advertise') || is_page('buy-ad-space') || is_page_template('template-buy-ad-space.php')) {
                $desc = "Reach 1.8M+ continental decision-makers, executives, and sovereign founders through Magazine Afrique Brand Reach, sponsored intelligence dossiers, and display advertising.";
            } elseif (is_page('subscribe') || is_page_template('template-subscribe.php')) {
                $desc = "Join the Magazine Afrique Club Prestige — Sovereign membership providing unrestricted access to classified dossiers, real-time geopolitical intelligence, executive briefings, and ad-free journalism.";
            } elseif (is_page('feed') || is_page_template('template-feed.php')) {
                $desc = "Personalized Pan-African Wire — Live dispatches, following feeds, and curated geopolitical reports tailored to your sovereign interests.";
            } elseif (is_page('newsletter')) {
                $desc = "Subscribe to The Africa Brief — Essential continental intelligence, macroeconomic trends, and diplomatic briefings delivered every Thursday.";
            } elseif (!empty($post->post_excerpt)) {
                $desc = wp_strip_all_tags($post->post_excerpt);
            } else {
                $desc = wp_trim_words(wp_strip_all_tags(strip_shortcodes($post->post_content)), 28, '...');
            }
        }
    } elseif (is_category()) {
        $cat_desc = category_description();
        if (!empty($cat_desc)) {
            $desc = wp_strip_all_tags($cat_desc);
        } else {
            $cat_name = single_cat_title('', false);
            $desc = "Latest investigative dossiers, market wires, policy analysis, and reports on " . $cat_name . " across Africa from Magazine Afrique.";
        }
    } elseif (is_tag()) {
        $tag_name = single_tag_title('', false);
        $desc = "Special coverage, news dispatches, and deep-dive investigations tagged #" . $tag_name . " across the African continent.";
    } elseif (is_author()) {
        $author = get_queried_object();
        $author_name = $author ? $author->display_name : 'Author';
        $desc = "Author archive: Read the latest dispatches, investigations, and commentary by " . $author_name . " on Magazine Afrique.";
    } elseif (is_search()) {
        $desc = 'Editorial search results for "' . get_search_query() . '" across Magazine Afrique dossiers, investigations, and archives.';
    } elseif (is_404()) {
        $desc = 'The requested dispatch or dossier could not be located in the Magazine Afrique archives.';
    }

    if (empty($desc)) {
        $desc = get_bloginfo('description') ?: "Pan-African journal of geopolitics, macroeconomic intelligence, and sovereign enterprise.";
    }

    return esc_attr(trim(preg_replace('/\s+/', ' ', $desc)));
}

/**
 * 3. Helper: Get Canonical URL
 */
function magazineafrique_seo_get_canonical_url() {
    if (is_front_page() || is_home()) {
        return home_url('/');
    } elseif (is_single() || is_page()) {
        return get_permalink();
    } elseif (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        return $term ? get_term_link($term) : home_url('/');
    } elseif (is_author()) {
        $author = get_queried_object();
        return $author ? get_author_posts_url($author->ID) : home_url('/');
    } elseif (is_search()) {
        return home_url('/?s=' . urlencode(get_search_query()));
    }
    return home_url('/');
}

/**
 * 4. Helper: Get Primary Featured Image
 */
function magazineafrique_seo_get_image() {
    $fallback = get_template_directory_uri() . '/assets/images/login-hero.jpg';
    $image_data = array(
        'url'    => $fallback,
        'width'  => 1200,
        'height' => 675,
        'alt'    => 'Magazine Afrique — Sovereign Pan-African Journalism'
    );

    if (is_single() || is_page()) {
        $post_id = get_the_ID();
        if (has_post_thumbnail($post_id)) {
            $src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'magazine-hero');
            if ($src) {
                $image_data['url'] = $src[0];
                $image_data['width'] = $src[1];
                $image_data['height'] = $src[2];
                $image_data['alt'] = get_the_title($post_id);
            }
        }
    }

    return $image_data;
}

/**
 * 5. Inject SEO Meta Tags, Canonical, OpenGraph & Twitter Cards into wp_head
 */
function magazineafrique_seo_meta_tags() {
    $description = magazineafrique_seo_get_description();
    $canonical_url = magazineafrique_seo_get_canonical_url();
    $image = magazineafrique_seo_get_image();
    $site_name = get_bloginfo('name');
    $site_locale = get_locale();

    // Standard Document Meta
    echo "\n    <!-- ========================================================================== -->\n";
    echo "    <!-- MAGAZINE AFRIQUE SEO ENGINE (Google, Bing, Social & AI Discover) -->\n";
    echo "    <!-- ========================================================================== -->\n";
    echo '    <meta name="description" content="' . $description . '" />' . "\n";
    echo '    <link rel="canonical" href="' . esc_url($canonical_url) . '" />' . "\n";

    // Robots Meta Directives
    $is_private_page = is_search() || is_404() || is_page('onboarding') || is_page('profile') || is_page('notifications') 
        || is_page_template('template-onboarding.php') || is_page_template('template-profile.php') || is_page_template('template-notifications.php');

    if ($is_private_page) {
        echo '    <meta name="robots" content="noindex, follow" />' . "\n";
    } else {
        echo '    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />' . "\n";
    }

    // Editorial Author
    if (is_single()) {
        $author_name = get_the_author();
        echo '    <meta name="author" content="' . esc_attr($author_name) . '" />' . "\n";
    } else {
        echo '    <meta name="author" content="Magazine Afrique Editorial Board" />' . "\n";
    }

    // Open Graph Metadata (Facebook, WhatsApp, LinkedIn, Telegram)
    echo '    <meta property="og:site_name" content="' . esc_attr($site_name) . '" />' . "\n";
    echo '    <meta property="og:locale" content="' . esc_attr($site_locale) . '" />' . "\n";
    echo '    <meta property="og:url" content="' . esc_url($canonical_url) . '" />' . "\n";
    echo '    <meta property="og:title" content="' . esc_attr(wp_get_document_title()) . '" />' . "\n";
    echo '    <meta property="og:description" content="' . $description . '" />' . "\n";
    echo '    <meta property="og:image" content="' . esc_url($image['url']) . '" />' . "\n";
    echo '    <meta property="og:image:width" content="' . esc_attr($image['width']) . '" />' . "\n";
    echo '    <meta property="og:image:height" content="' . esc_attr($image['height']) . '" />' . "\n";
    echo '    <meta property="og:image:alt" content="' . esc_attr($image['alt']) . '" />' . "\n";

    if (is_single()) {
        echo '    <meta property="og:type" content="article" />' . "\n";
        echo '    <meta property="article:published_time" content="' . esc_attr(get_the_date('c')) . '" />' . "\n";
        echo '    <meta property="article:modified_time" content="' . esc_attr(get_the_modified_date('c')) . '" />' . "\n";
        echo '    <meta property="article:author" content="' . esc_attr(get_the_author()) . '" />' . "\n";
        echo '    <meta property="article:publisher" content="' . esc_url(home_url('/')) . '" />' . "\n";

        $categories = get_the_category();
        if (!empty($categories)) {
            echo '    <meta property="article:section" content="' . esc_attr($categories[0]->name) . '" />' . "\n";
        }

        $tags = get_the_tags();
        if ($tags) {
            foreach ($tags as $tg) {
                echo '    <meta property="article:tag" content="' . esc_attr($tg->name) . '" />' . "\n";
            }
        }
    } else {
        echo '    <meta property="og:type" content="website" />' . "\n";
    }

    // Twitter Card Metadata (X)
    echo '    <meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '    <meta name="twitter:site" content="@magazineafrique" />' . "\n";
    echo '    <meta name="twitter:creator" content="@magazineafrique" />' . "\n";
    echo '    <meta name="twitter:title" content="' . esc_attr(wp_get_document_title()) . '" />' . "\n";
    echo '    <meta name="twitter:description" content="' . $description . '" />' . "\n";
    echo '    <meta name="twitter:image" content="' . esc_url($image['url']) . '" />' . "\n";
    echo '    <meta name="twitter:image:alt" content="' . esc_attr($image['alt']) . '" />' . "\n";
}
add_action('wp_head', 'magazineafrique_seo_meta_tags', 1);

/**
 * 6. Inject Google & AI Compliant JSON-LD Structured Data Schemas
 */
function magazineafrique_seo_json_ld_schemas() {
    $site_url = home_url('/');
    $site_name = get_bloginfo('name');
    $logo_url = get_template_directory_uri() . '/assets/images/logo.png';

    // 1. Core Organization Schema
    $org_schema = array(
        '@context'             => 'https://schema.org',
        '@type'                => 'NewsMediaOrganization',
        '@id'                  => $site_url . '#organization',
        'name'                 => $site_name,
        'url'                  => $site_url,
        'logo'                 => array(
            '@type'  => 'ImageObject',
            'url'    => $logo_url,
            'width'  => 729,
            'height' => 200
        ),
        'sameAs'               => array(
            'https://twitter.com/magazineafrique',
            'https://youtube.com/@magazineafrique',
            'https://www.linkedin.com/company/magazineafrique'
        ),
        'description'          => 'Independent pan-African journal of strategic analysis, macroeconomic intelligence, geopolitics, trade, and culture.',
        'foundingDate'         => '2024',
        'publishingPrinciples' => $site_url . 'about/',
        'masthead'             => $site_url . 'about/',
        'correctionsPolicy'    => $site_url . 'terms/',
        'diversityPolicy'      => $site_url . 'about/',
        'ethicsPolicy'         => $site_url . 'about/',
        'address'              => array(
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Lagos',
            'addressCountry'  => 'NG'
        ),
        'location'             => array(
            array('@type' => 'Place', 'name' => 'Dakar Bureau'),
            array('@type' => 'Place', 'name' => 'Lagos Bureau'),
            array('@type' => 'Place', 'name' => 'Nairobi Bureau'),
            array('@type' => 'Place', 'name' => 'Johannesburg Bureau'),
            array('@type' => 'Place', 'name' => 'Cairo Bureau'),
            array('@type' => 'Place', 'name' => 'London Bureau')
        )
    );

    $schemas = array($org_schema);

    // 2. WebSite Schema with Sitelinks SearchBox (Front Page)
    if (is_front_page()) {
        $website_schema = array(
            '@context'        => 'https://schema.org',
            '@type'           => 'WebSite',
            '@id'             => $site_url . '#website',
            'url'             => $site_url,
            'name'            => $site_name,
            'description'     => magazineafrique_seo_get_description(),
            'publisher'       => array('@id' => $site_url . '#organization'),
            'inLanguage'      => get_locale(),
            'potentialAction' => array(
                '@type'       => 'SearchAction',
                'target'      => array(
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => $site_url . '?s={search_term_string}'
                ),
                'query-input' => 'required name=search_term_string'
            )
        );
        $schemas[] = $website_schema;
    }

    // 3. Single Article Schema (Google News & Discover Rich Results)
    if (is_single()) {
        $post = get_post();
        $author_id = $post->post_author;
        $author_name = get_the_author_meta('display_name', $author_id) ?: 'Correspondent Desk';
        $post_url = get_permalink($post->ID);
        $image_info = magazineafrique_seo_get_image();
        $categories = wp_get_post_categories($post->ID, array('fields' => 'names'));
        $tags = wp_get_post_tags($post->ID, array('fields' => 'names'));
        $clean_content = wp_strip_all_tags(strip_shortcodes($post->post_content));
        $word_count = str_word_count($clean_content);
        $is_premium = function_exists('magazineafrique_is_premium_post') && magazineafrique_is_premium_post($post->ID);

        $article_schema = array(
            '@context'         => 'https://schema.org',
            '@type'            => 'AnalysisNewsArticle',
            '@id'              => $post_url . '#article',
            'isPartOf'         => array('@id' => $site_url . '#website'),
            'headline'         => wp_strip_all_tags($post->post_title),
            'description'      => magazineafrique_seo_get_description(),
            'url'              => $post_url,
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id'   => $post_url
            ),
            'datePublished'    => get_the_date('c', $post->ID),
            'dateModified'     => get_the_modified_date('c', $post->ID),
            'image'            => array(
                '@type'  => 'ImageObject',
                'url'    => $image_info['url'],
                'width'  => $image_info['width'],
                'height' => $image_info['height']
            ),
            'author'           => array(
                '@type'       => 'Person',
                'name'        => $author_name,
                'url'         => get_author_posts_url($author_id),
                'affiliation' => array('@id' => $site_url . '#organization')
            ),
            'publisher'        => array('@id' => $site_url . '#organization'),
            'articleSection'   => !empty($categories) ? $categories[0] : 'Intelligence Wire',
            'keywords'         => implode(', ', array_merge($categories, $tags)),
            'wordCount'        => $word_count,
            'inLanguage'       => get_locale(),
            'isAccessibleForFree' => !$is_premium,
            'speakable'        => array(
                '@type'       => 'SpeakableSpecification',
                'cssSelector' => array('.single-hero-title', '.single-article-deck', '.article-lead-paragraph')
            )
        );

        if ($is_premium) {
            $article_schema['hasPart'] = array(
                '@type' => 'WebPageElement',
                'isAccessibleForFree' => false,
                'cssSelector' => '.paywall-wrapper'
            );
        }

        $schemas[] = $article_schema;

        // Navigational Breadcrumb Schema for Articles
        $breadcrumb_items = array(
            array(
                '@type'    => 'ListItem',
                'position' => 1,
                'name'     => 'Home',
                'item'     => $site_url
            )
        );

        $pos = 2;
        $cats = get_the_category($post->ID);
        if (!empty($cats)) {
            $breadcrumb_items[] = array(
                '@type'    => 'ListItem',
                'position' => $pos++,
                'name'     => $cats[0]->name,
                'item'     => get_category_link($cats[0]->term_id)
            );
        }

        $breadcrumb_items[] = array(
            '@type'    => 'ListItem',
            'position' => $pos,
            'name'     => wp_strip_all_tags($post->post_title),
            'item'     => $post_url
        );

        $schemas[] = array(
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $breadcrumb_items
        );
    }

    // 4. Archive & Category CollectionPage Schema
    if (is_category() || is_tag()) {
        $term = get_queried_object();
        if ($term) {
            $schemas[] = array(
                '@context'    => 'https://schema.org',
                '@type'       => 'CollectionPage',
                '@id'         => get_term_link($term) . '#collection',
                'name'        => $term->name,
                'description' => magazineafrique_seo_get_description(),
                'url'         => get_term_link($term),
                'publisher'   => array('@id' => $site_url . '#organization')
            );

            $schemas[] = array(
                '@context'        => 'https://schema.org',
                '@type'           => 'BreadcrumbList',
                'itemListElement' => array(
                    array(
                        '@type'    => 'ListItem',
                        'position' => 1,
                        'name'     => 'Home',
                        'item'     => $site_url
                    ),
                    array(
                        '@type'    => 'ListItem',
                        'position' => 2,
                        'name'     => $term->name,
                        'item'     => get_term_link($term)
                    )
                )
            );
        }
    }

    // 5. Author ProfilePage Schema
    if (is_author()) {
        $author = get_queried_object();
        if ($author) {
            $author_url = get_author_posts_url($author->ID);
            $schemas[] = array(
                '@context'    => 'https://schema.org',
                '@type'       => 'ProfilePage',
                '@id'         => $author_url . '#profile',
                'name'        => $author->display_name . ' Correspondent Archive',
                'description' => magazineafrique_seo_get_description(),
                'url'         => $author_url,
                'publisher'   => array('@id' => $site_url . '#organization'),
                'mainEntity'  => array(
                    '@type'       => 'Person',
                    'name'        => $author->display_name,
                    'description' => get_the_author_meta('description', $author->ID) ?: 'Editorial Correspondent for Magazine Afrique',
                    'url'         => $author_url,
                    'affiliation' => array('@id' => $site_url . '#organization')
                )
            );

            $schemas[] = array(
                '@context'        => 'https://schema.org',
                '@type'           => 'BreadcrumbList',
                'itemListElement' => array(
                    array(
                        '@type'    => 'ListItem',
                        'position' => 1,
                        'name'     => 'Home',
                        'item'     => $site_url
                    ),
                    array(
                        '@type'    => 'ListItem',
                        'position' => 2,
                        'name'     => 'Correspondents',
                        'item'     => $site_url
                    ),
                    array(
                        '@type'    => 'ListItem',
                        'position' => 3,
                        'name'     => $author->display_name,
                        'item'     => $author_url
                    )
                )
            );
        }
    }

    // 6. Static Pages Schema (AboutPage, ContactPage, WebPage)
    if (is_page() && !is_front_page()) {
        $post = get_post();
        if ($post) {
            $page_url = get_permalink($post->ID);
            $page_type = 'WebPage';
            if (is_page('about') || is_page_template('template-about.php')) {
                $page_type = 'AboutPage';
            } elseif (is_page('contact') || is_page_template('template-contact.php')) {
                $page_type = 'ContactPage';
            }

            $schemas[] = array(
                '@context'    => 'https://schema.org',
                '@type'       => $page_type,
                '@id'         => $page_url . '#webpage',
                'name'        => wp_strip_all_tags($post->post_title),
                'description' => magazineafrique_seo_get_description(),
                'url'         => $page_url,
                'publisher'   => array('@id' => $site_url . '#organization')
            );

            $schemas[] = array(
                '@context'        => 'https://schema.org',
                '@type'           => 'BreadcrumbList',
                'itemListElement' => array(
                    array(
                        '@type'    => 'ListItem',
                        'position' => 1,
                        'name'     => 'Home',
                        'item'     => $site_url
                    ),
                    array(
                        '@type'    => 'ListItem',
                        'position' => 2,
                        'name'     => wp_strip_all_tags($post->post_title),
                        'item'     => $page_url
                    )
                )
            );
        }
    }

    // Output All Structured Data in Single Clean JSON-LD Block
    echo "    <!-- Structured Data JSON-LD Schemas -->\n";
    foreach ($schemas as $schema) {
        echo '    <script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "</script>\n";
    }
}
add_action('wp_head', 'magazineafrique_seo_json_ld_schemas', 2);
