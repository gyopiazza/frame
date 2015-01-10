<?php

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function frame_clean_nav_markup($args = '')
{
    $args['container'] = false;
    return $args;
}

add_filter('wp_nav_menu_args', 'frame_clean_nav_markup');



/**
 * Remove the id="" on nav menu items
 * Return 'menu-slug' for nav menu classes
 */
function frame_nav_menu_css_class($classes, $item) {
  $slug = sanitize_title($item->title);
  $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);
  $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);
  $classes[] = 'menu-' . $slug;
  $classes = array_unique($classes);
  return array_filter($classes, 'is_element_empty');
}

add_filter('nav_menu_css_class', 'frame_nav_menu_css_class', 10, 2);
add_filter('nav_menu_item_id', '__return_null');