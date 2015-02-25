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
	// By default, 'administrator', 'editor', 'author',
	// 'contributor' and 'subscriber' are allowed to the Admin area.
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
	// Disable the admin bar in the frontend.
	// - Set a bool true/false to control the bar for all users.
	// - Set an array of user roles to enable the bar only for those.
	// ---------------------------------------------------------------
	'admin_bar' => false,


	// ---------------------------------------------------------------
	// Custom admin logos
	// ---------------------------------------------------------------
	'admin_login_logo' => get_stylesheet_directory_uri().'/assets/img/admin-login-logo.png',
	'admin_bar_logo' => get_stylesheet_directory_uri().'/assets/img/admin-bar-logo.png',


	// ---------------------------------------------------------------
	// Admin footer message (Replaces "Thank you for creating...")
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

    // ---------------------------------------------------------------
    // Add custom mime types to be uploaded in the media library
    // 'file extension' => 'mime type'
    // 'ext1|ext2' => 'mime type'
    // ---------------------------------------------------------------
    'mime_types' => array(
        'applescript|scpt' => 'application/x-applescript',
        'dmg' => 'application/x-apple-diskimage'
    ),
);


