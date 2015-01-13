<?php

function child_init()
{
	// frame_config('application.version');
	// echo '<pre>';
	// print_r(frame_config('application.version'));
	// echo '</pre>';
	// var_dump(locate_template('config/'));

	if (not('admin'))
		echo 'frontend!';
	else
		echo 'admin!';
}

add_action('init', 'child_init');


// var_dump(locate_template('config/'));
// var_dump(is_child_theme());

