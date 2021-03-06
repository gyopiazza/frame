<?php

/**
 * Add post slug to body class, love this - Credit: Starkers Wordpress Theme
 *
 * @package frame
 * @subpackage frame\hooks
 * @param array $classes The body classes array
 * @return array $fields The modified body classes array
 */
function frame_hook_add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

add_filter('body_class', 'frame_hook_add_slug_to_body_class');
