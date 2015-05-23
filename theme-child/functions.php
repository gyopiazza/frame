<?php

// Control what gets loaded from the Frame parent theme

// Load the debug functions file
define('FRAME_LOAD_DEBUG', true);

// Load the helper functions file
define('FRAME_LOAD_HELPERS', true);

// Load the helper aliases file
define('FRAME_LOAD_ALIASES', true);

// Load the plugins activation class
define('FRAME_LOAD_PLUGINS_ACTIVATION', true);

// Load the theme activation file
define('FRAME_LOAD_THEME_ACTIVATION', true);

// Load the Frame initialisation file (requires the helpers)
define('FRAME_LOAD_INIT', true);



// Check for the existence of Frame to prevent PHP errors
// Not necessary but helpful to make sure that the parent theme exists
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

    // d(get_theme_mod("some_field_settings"));

    // print_r(config());
}

add_action('init', 'theme_child_init');


// var_dump(locate_template('config/'));
// var_dump(is_child_theme());


