<?php

/**
 * Admin
 *
 * Generic admin settings
 *
 * @package frame
 */

return array(

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
		'administrator', // Do not remove!
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
	// Custom admin logos
	// ---------------------------------------------------------------
	'admin_login_logo' => get_stylesheet_directory_uri().'/assets/img/admin-login-logo.png',
	'admin_bar_logo' => get_stylesheet_directory_uri().'/assets/img/admin-bar-logo.png',


	// ---------------------------------------------------------------
	// Admin footer message (Replaces "Thank you for creating with WordPress")
	// ---------------------------------------------------------------
	'admin_footer' => __('You are using a <a href="#">Theme</a> designed by <a href="#">Someone</a>', 'theme'),


	// ---------------------------------------------------------------
	// Post revisions (bool/int)
	// ---------------------------------------------------------------
	'post_revisions' => 10,


	// ---------------------------------------------------------------
	// Enable/Disable the files editor (Appearance > Editor)
	// ---------------------------------------------------------------
	'files_editor' => false,


	// ---------------------------------------------------------------
	// Add fields to the user profile
	// ---------------------------------------------------------------
	// 'add_profile_fields' => true,

	// ---------------------------------------------------------------
	// Remove fields from the user profile
	// ---------------------------------------------------------------
	// 'remove_profile_fields' => true,
);


