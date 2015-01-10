<?php

// Remove admin bar menu items
function frame_admin_bar()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');

    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('new-post');
}

add_action('wp_before_admin_bar_render', 'frame_admin_bar');