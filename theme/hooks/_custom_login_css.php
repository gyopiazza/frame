<?php

// Load CSS files in the login page
function frame_custom_login_layout()
{
    $files = '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/css/a.css" />';
              // <script src="'.get_stylesheet_directory_uri().'/js/jquery.min.js"></script>';
    echo $files;
}

add_action('login_head', 'frame_custom_login_layout');