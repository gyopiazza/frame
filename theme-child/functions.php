<?php

// Check for the existence of wp-frame to prevent PHP errors
$current_theme = wp_get_theme();
if (!empty($current_theme->get('Template')))
{
    $parent_theme = wp_get_theme($current_theme->get('Template'));
    if (!$parent_theme->exists()) die('You need wp-frame for this theme to work');
}

function theme_child_init()
{
    global $wp_query;
	// frame_config('application.version');
	// echo '<pre>';
	// print_r(frame_config('application.version'));
	// echo '</pre>';
	// var_dump(locate_template('config/'));

	// if (is('admin', false))
	// 	echo 'frontend!';
	// else
	// 	echo 'admin!';

    // d(location(), 'location');
    // d(get_queried_object());

    // if (is('admin', true, 'post_type', 'post'))
    // if (is('admin=1&post_type=post'))
    //     echo 'ok';
    // else
    //     echo 'no';

    // d(location('post_type'), 'location');
}

add_action('init', 'theme_child_init');


// var_dump(locate_template('config/'));
// var_dump(is_child_theme());
