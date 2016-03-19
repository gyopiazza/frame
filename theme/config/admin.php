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
	'admin_bar' => true,


	// ---------------------------------------------------------------
    // Load the default admin login CSS (in wp-login.php)
    // ---------------------------------------------------------------
    'default_login_css' => true,


    // ---------------------------------------------------------------
    // Login logo title
    // ---------------------------------------------------------------
    'login_logo_title' => __('My Theme Title', 'theme'),


    // ---------------------------------------------------------------
    // Login logo url
    // ---------------------------------------------------------------
    'login_logo_url' => 'http://www.giordanopiazza.com',


    // ---------------------------------------------------------------
	// Custom admin logos
	// ---------------------------------------------------------------
	// 'admin_login_logo' => get_stylesheet_directory_uri().'/assets/img/admin-login-logo.png',
	// 'admin_bar_logo' => get_stylesheet_directory_uri().'/assets/img/admin-bar-logo.png',


	// ---------------------------------------------------------------
	// Admin footer message (Replaces "Thank you for creating...")
	// ---------------------------------------------------------------
	'admin_footer' => __('You are using a <a href="#">Theme</a> designed by <a href="#">Gyo</a>', 'theme'),


	// ---------------------------------------------------------------
	// Post revisions (bool/int)
	// ---------------------------------------------------------------
	'post_revisions' => 10,


	// ---------------------------------------------------------------
	// Enable/Disable the files editor (Appearance > Editor)
	// ---------------------------------------------------------------
	'files_editor' => false,


    // ---------------------------------------------------------------
    // Limit the amount of custom post fields
    // ---------------------------------------------------------------
    'custom_post_fields_limit' => 30,


	// ---------------------------------------------------------------
    // Toolbar links
    // ---------------------------------------------------------------
    'toolbar_links' => array(
        array(
            'id'    => 'theme_customizer',
            'title' => __('Customizer', 'theme'),
            'href'  => admin_url('customize.php'),
            // 'href'  => admin_url('customize.php?autofocus[control]=control-name'),
            // 'meta'  => array('class' => 'my-toolbar-page'),
        ),
        // array(
        //     'id'     => 'my_page2',
        //     'title'  => 'My Page 2',
        //     'href'   => 'http://mysite.com/my-page2/',
        //     'meta'   => array('class' => 'my-toolbar-page2'),
        //     'parent' => 'my_page',
        // ),
    ),


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
    // @link http://www.freeformatter.com/mime-types-list.html
    // ---------------------------------------------------------------
    // 'mime_types' => array(
    //     'applescript|scpt' => 'application/x-applescript',
    //     'dmg' => 'application/x-apple-diskimage'
    // ),
);


