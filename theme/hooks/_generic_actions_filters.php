<?php

//-------------------------------------------------------------------
// Add Actions
//-------------------------------------------------------------------

// ...


//-------------------------------------------------------------------
// Remove Actions
//-------------------------------------------------------------------

remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);




// WPML
// if (isset($sitepress)) remove_action('wp_head', array($sitepress, 'meta_generator_tag'));
// if (isset($sitepress)) remove_action('wp_head', array($sitepress, 'front_end_js'));
// define ('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);

// WooCommerce
// remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
// remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');


//-------------------------------------------------------------------
// Add filters
//-------------------------------------------------------------------

add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in widgets (Dynamic Sidebars)

// WooCommerce
// add_filter('woocommerce_enqueue_styles', '__return_false'); // Disable default WooCommerce styles (>=2.1)


//-------------------------------------------------------------------
// Remove Filters
//-------------------------------------------------------------------

// remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether
// remove_filter('single_post_title', 'strip_tags'); // Don't strip tags on single post titles

