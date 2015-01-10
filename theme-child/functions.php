<?php

function test_init()
{
	// frame_config('application.version');
	// echo '<pre>';
	// print_r(frame_config('application.version'));
	// echo '</pre>';
	// var_dump(locate_template('config/'));
}

add_action('init', 'test_init');


// var_dump(locate_template('config/'));
// var_dump(is_child_theme());

