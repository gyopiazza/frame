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
	// Theme version
	// ---------------------------------------------------------------
	'version' => '1.0.0',


	// ---------------------------------------------------------------
	// Set the current environment, useful for specific optimizations
    // Not currently in use
	// ---------------------------------------------------------------
	'environment' => 'development',


    // ---------------------------------------------------------------
    // Set the maximum allowed width for any content in the theme,
    // like oEmbeds and images added to posts.
    // @link https://codex.wordpress.org/Content_Width
    // ---------------------------------------------------------------
    'content_width' => 960,


	// ---------------------------------------------------------------
	// Set Favicon URLs
	// ---------------------------------------------------------------

	// 16x16 or 32x32 ico file
	// 'favicon' => get_stylesheet_directory_uri().'/assets/img/favicon.ico',

	// 180x180 png file
	// 'favicon_retina' => get_stylesheet_directory_uri().'/assets/img/favicon.png',


	// ---------------------------------------------------------------
	// array: post types for which to disable comments/trackbacks
    // bool: If false, the comments are disabled everywhere
	// ---------------------------------------------------------------
	'comments_trackbacks_support' => true,


    // ---------------------------------------------------------------
    // Enable/Disable the XMLRPC functionality
    // ---------------------------------------------------------------
    'xmlrpc' => false,


    // ---------------------------------------------------------------
    // Redirect on theme activation
    // ---------------------------------------------------------------
    // 'activation_redirect' => 'themes.php?page=themeoptions',


    // ---------------------------------------------------------------
    // Execute a function on theme activation and deactivation
    // ---------------------------------------------------------------
    // 'activation' => 'some_activation_function_name',
    // 'deactivation' => 'some_deactivation_function_name',


    // ---------------------------------------------------------------
    // CRON tasks
    // recurrence, hook, args...
    // ---------------------------------------------------------------
    // 'cron' => array(
    //     array('task-name', 'some_function_name'),
    // ),
);
