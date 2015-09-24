<?php

// Filters the menu item titles to allow shortcodes in them


function frame_hook_menu_items_shortcodes($item_output, $item = null, $depth = null, $args = null)
{
    return (!empty($item_output)) ? do_shortcode($item_output) : $item_output;
}

add_filter('walker_nav_menu_start_el', 'frame_hook_menu_items_shortcodes', 20, 4);
