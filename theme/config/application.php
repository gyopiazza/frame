<?php

/**
 * Application
 *
 * Generic application settings
 *
 * @package frame
 */

return array(

	// ---------------------------------------------------------------
	// Theme version, also used for the assets cache
	// ---------------------------------------------------------------
	'version' => '1.0.0',

	// ---------------------------------------------------------------
	// Set the current environment, useful for specific optimizations
	// ---------------------------------------------------------------
	'environment' => 'development',


	// ---------------------------------------------------------------
	// Set Favicon URLs
	// ---------------------------------------------------------------

	// 16x16 or 32x32 ico file
	'favicon' => get_stylesheet_directory_uri().'/assets/img/favicon.ico',

	// 180x180 png file
	'favicon_retina' => get_stylesheet_directory_uri().'/assets/img/favicon.png',


	// ---------------------------------------------------------------
	// An array of post types on which to disable comments/trackbacks
	// ---------------------------------------------------------------
	'remove_comments_support' => array(),


    // ---------------------------------------------------------------
    // An array (extension => mime) of additional allowed mime types
    // ---------------------------------------------------------------
    'mime_types' => array(
        // 'applescript' => 'application/x-applescript'
    ),


    // ---------------------------------------------------------------
    // Flush rewrite rules on theme activation
    // ---------------------------------------------------------------
    'flush_rewrite_rules' => true,


    // ---------------------------------------------------------------
    // Redirect on theme activation
    // ---------------------------------------------------------------
    // 'activation_redirect' => 'themes.php?page=themeoptions',


    // ---------------------------------------------------------------
    // Execute a function on theme activation and deactivation
    // ---------------------------------------------------------------
    // 'activation' => 'some_activation_function_name',
    // 'deactivation' => 'some_deactivation_function_name',

);
