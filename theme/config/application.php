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
	// Restrict access to the WordPress Admin for users with a
	// specific role. 
	// Once the theme is activated, you can only log in by going
	// to 'wp-login.php' or 'login' (if permalinks changed) urls.
	// By default, allows 'administrator', 'editor', 'author',
	// 'contributor' and 'subscriber' to access the ADMIN area.
	// Edit this configuration in order to limit access.
	// --------------------------------------------------------------- 
	'access' => array(
		// Default roles
		'administrator',
		'editor',
		'author',
		'contributor',
		'subscriber',
	),
	

	// --------------------------------------------------------------- 
	// Disable the admin bar in the frontend
	// - Set a bool true/false to control the bar for all users
	// - Set an array of user roles to enable the bar only for them
	// --------------------------------------------------------------- 
	'admin_bar' => true,


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
	// Set Favicon URLs
	// --------------------------------------------------------------- 

	// 16x16 or 32x32 ico file
	'favicon' => get_stylesheet_directory_uri().'/assets/img/favicon.ico',

	// 180x180 png file
	'favicon_retina' => get_stylesheet_directory_uri().'/assets/img/favicon.png',


	// --------------------------------------------------------------- 
	// Custom admin logos
	// --------------------------------------------------------------- 
	'admin_login_logo' => get_stylesheet_directory_uri().'/assets/img/admin-login-logo.png',
	'admin_bar_logo' => get_stylesheet_directory_uri().'/assets/img/admin-bar-logo.png',


	// --------------------------------------------------------------- 
	// Admin footer message (Replaces "Thank you for creating with WordPress")
	// --------------------------------------------------------------- 
	'admin_footer' => __('You are using a <a href="#">Theme</a> designed by <a href="#">Someone</a>', 'theme'),


	// --------------------------------------------------------------- 
	// An array of post types on which to disable comments/trackbacks
	// --------------------------------------------------------------- 
	'remove_comments_support' => array(),


	// --------------------------------------------------------------- 
	// Enable/Disable the files editor (Appearance > Editor)
	// --------------------------------------------------------------- 
	'files_editor' => true,


	// --------------------------------------------------------------- 
	// Add fields to the user profile
	// --------------------------------------------------------------- 
	// 'add_profile_fields' => true,

	// --------------------------------------------------------------- 
	// Remove fields from the user profile
	// --------------------------------------------------------------- 
	// 'remove_profile_fields' => true,
);


