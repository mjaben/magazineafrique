<?php
/**
 * Magazine Afrique — AI Schema Aggregation & LLM Endpoint Engine
 * Exposes machine-readable JSON-LD and llms.txt discovery endpoints for AI systems (Gemini, Claude, GPT, Perplexity)
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register REST API Endpoints for AI Systems
 */
add_action('rest_api_init', function () {
    // 1. Comprehensive AI Schema Aggregation Endpoint
    register_rest_route('magazineafrique/v1', '/ai-schema', array(
        'methods'             => 'GET',
        'callback'            => 'magazineafrique_get_ai_schema_payload',
        'permission_callback' => '__return_true',
    ));

    // 2. Single Article AI Dossier Endpoint
    register_rest_route('magazineafrique/v1', '/article-schema', array(
        'methods'             => 'GET',
        'callback'            => 'magazineafrique_get_single_article_schema',
        'permission_callback' => '__return_true',
        'args'                => array(
            'id' => array(
                'required'          => true,
                'validate_callback' => function($param) {
                    return is_numeric($param);
                }
            )
        )
    ));

    // 3. LLMS.txt Plaintext Feed Endpoint for Agents
    register_rest_route('magazineafrique/v1', '/llms', array(
        'methods'             => 'GET',
        'callback'            => 'magazineafrique_get_llms_txt_payload',
        'permission_callback' => '__return_true',
    ));
});

/**
 * Generate Main AI Schema Aggregation Payload
 */
if (!function_exists('magazineafrique_get_ai_schema_payload')) {
    function magazineafrique_get_ai_schema_payload() {
        $site_url = home_url('/');
        $site_name = get_bloginfo('name');
        $site_desc = "Independent pan-African journal of strategic analysis, macroeconomic intelligence, geopolitics, trade, and culture.";

        // 1. Core Organization Schema
        $organization_schema = array(
            '@type'                => 'NewsMediaOrganization',
            '@id'                  => $site_url . '#organization',
            'name'                 => $site_name,
            'url'                  => $site_url,
            'logo'                 => array(
                '@type' => 'ImageObject',
                'url'   => get_template_directory_uri() . '/assets/images/logo.png',
                'width' => 729,
                'height'=> 200
            ),
            'description'          => $site_desc,
            'foundingDate'         => '2024',
            'knowsAbout'           => array(
                'Pan-African Geopolitics',
                'African Macroeconomics',
                'AfCFTA Continental Trade',
                'Commodities & Energy Transition',
                'Fintech & Digital Infrastructure',
                'African Diplomatic Strategy'
            ),
            'publishingPrinciples' => $site_url . 'about/',
            'masthead'             => $site_url . 'about/',
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

        // 2. Query Recent 25 Articles for AI Indexing
        $articles_query = new WP_Query(array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 25,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ));

        $articles_schema = array();

        if ($articles_query->have_posts()) {
            while ($articles_query->have_posts()) {
                $articles_query->the_post();
                $pid = get_the_ID();
                $author_name = get_the_author();
                $categories = wp_get_post_categories($pid, array('fields' => 'names'));
                $tags = wp_get_post_tags($pid, array('fields' => 'names'));
                $thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url($pid, 'full') : '';
                $excerpt = get_the_excerpt() ?: wp_trim_words(strip_shortcodes(get_the_content()), 35);
                $clean_body = wp_strip_all_tags(strip_shortcodes(get_the_content()));
                $word_count = str_word_count($clean_body);

                $article_item = array(
                    '@type'            => 'AnalysisNewsArticle',
                    '@id'              => get_permalink() . '#article',
                    'isPartOf'         => array('@id' => $site_url . '#website'),
                    'headline'         => get_the_title(),
                    'description'      => $excerpt,
                    'url'              => get_permalink(),
                    'mainEntityOfPage' => get_permalink(),
                    'datePublished'    => get_the_date('c'),
                    'dateModified'     => get_the_modified_date('c'),
                    'author'           => array(
                        '@type'       => 'Person',
                        'name'        => $author_name,
                        'affiliation' => array(
                            '@type' => 'Organization',
                            'name'  => $site_name
                        )
                    ),
                    'publisher'        => array('@id' => $site_url . '#organization'),
                    'articleSection'   => !empty($categories) ? $categories[0] : 'General',
                    'keywords'         => implode(', ', array_merge($categories, $tags)),
                    'wordCount'        => $word_count,
                    'inLanguage'       => get_locale(),
                    'isAccessibleForFree' => !function_exists('magazineafrique_is_premium_post') || !magazineafrique_is_premium_post($pid)
                );

                if ($thumb_url) {
                    $article_item['image'] = array(
                        '@type' => 'ImageObject',
                        'url'   => $thumb_url
                    );
                }

                $article_item['articleSnippet'] = wp_trim_words($clean_body, 120, '...');

                $articles_schema[] = $article_item;
            }
            wp_reset_postdata();
        }

        $response = array(
            '@context'         => 'https://schema.org',
            '@graph'           => array_merge(array($organization_schema), $articles_schema),
            'generated_at'     => current_time('c'),
            'generator'        => 'Magazine Afrique AI Engine v1.3.0',
            'llm_discovery'    => rest_url('magazineafrique/v1/llms'),
            'total_indexed'    => count($articles_schema)
        );

        return rest_ensure_response($response);
    }
}

/**
 * Single Article AI Schema
 */
if (!function_exists('magazineafrique_get_single_article_schema')) {
    function magazineafrique_get_single_article_schema($request) {
        $post_id = $request->get_param('id');
        $post = get_post($post_id);

        if (!$post || $post->post_status !== 'publish') {
            return new WP_Error('not_found', 'Article not found', array('status' => 404));
        }

        $author = get_userdata($post->post_author);
        $categories = wp_get_post_categories($post_id, array('fields' => 'names'));
        $tags = wp_get_post_tags($post_id, array('fields' => 'names'));
        $clean_body = wp_strip_all_tags(strip_shortcodes($post->post_content));

        $schema = array(
            '@context'         => 'https://schema.org',
            '@type'            => 'AnalysisNewsArticle',
            'headline'         => $post->post_title,
            'description'      => $post->post_excerpt ?: wp_trim_words($clean_body, 30),
            'url'              => get_permalink($post_id),
            'datePublished'    => get_the_date('c', $post_id),
            'dateModified'     => get_the_modified_date('c', $post_id),
            'author'           => array(
                '@type' => 'Person',
                'name'  => $author ? $author->display_name : 'Staff Correspondent'
            ),
            'articleSection'   => !empty($categories) ? $categories[0] : 'General',
            'keywords'         => implode(', ', array_merge($categories, $tags)),
            'wordCount'        => str_word_count($clean_body),
            'fullContentText'  => $clean_body
        );

        return rest_ensure_response($schema);
    }
}

/**
 * Plaintext LLMS.txt Output for AI Crawlers
 */
if (!function_exists('magazineafrique_get_llms_txt_payload')) {
    function magazineafrique_get_llms_txt_payload() {
        header('Content-Type: text/plain; charset=utf-8');

        $out = "# Magazine Afrique — AI Knowledge Base & LLM Feed\n";
        $out .= "> Independent pan-African journal of strategic analysis, macroeconomic intelligence, geopolitics, trade, and culture.\n\n";
        $out .= "## Publication Identity\n";
        $out .= "- Canonical URL: " . home_url('/') . "\n";
        $out .= "- Bureaus: Dakar, Lagos, Nairobi, Johannesburg, Cairo, London\n";
        $out .= "- Full AI Schema (JSON-LD): " . rest_url('magazineafrique/v1/ai-schema') . "\n\n";
        $out .= "## Recent Strategic Intelligence Despatches\n\n";

        $posts = get_posts(array(
            'numberposts' => 15,
            'post_status' => 'publish'
        ));

        foreach ($posts as $p) {
            $cats = wp_get_post_categories($p->ID, array('fields' => 'names'));
            $cname = !empty($cats) ? $cats[0] : 'General';
            $snippet = wp_strip_all_tags(strip_shortcodes($p->post_content));
            $summary = wp_trim_words($snippet, 40);

            $out .= "### " . $p->post_title . "\n";
            $out .= "- Desk: " . $cname . "\n";
            $out .= "- Date: " . get_the_date('Y-m-d', $p->ID) . "\n";
            $out .= "- URL: " . get_permalink($p->ID) . "\n";
            $out .= "- Summary: " . $summary . "\n\n";
        }

        echo $out;
        exit;
    }
}

/**
 * Intercept /llms.txt at root URL
 */
add_action('init', function () {
    add_rewrite_rule('^llms\.txt$', 'index.php?magazineafrique_llms=1', 'top');
});

add_filter('query_vars', function ($vars) {
    $vars[] = 'magazineafrique_llms';
    return $vars;
});

add_action('template_redirect', function () {
    if (get_query_var('magazineafrique_llms')) {
        magazineafrique_get_llms_txt_payload();
    }
});
