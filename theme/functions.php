<?php

// Load WP Frame
require_once(locate_template('library/init.php'));

// Place your code below here...

function my_init()
{
    // echo '<pre>';
    // print_r(debug_backtrace());
    // echo '</pre>';

    // d('test');
}

add_action('init', 'my_init');
