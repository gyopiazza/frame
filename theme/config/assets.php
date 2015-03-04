<?php

/**
 * Assets
 *
 * Set the static assets to register and enqueue
 * If the asset 'handle' begins with _ it will only be registered
 *
 * Javascript: $handle, $src, $deps, $ver, $in_footer
 * CSS: $handle, $src, $deps, $ver, $media
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * @package frame
 */

return array(

    // ---------------------------------------------------------------
    // Enable asset files versioning
    // @param bool: Enable/disable the feature, if 'true' the application.version is used
    // @param string|int: The value to be used instead of the application.version
    // ---------------------------------------------------------------
    'versioning' => true,


    // ---------------------------------------------------------------
    // Use filename versioning like style.123.css instead of style.css?v=123
    // It requires some rewrite rules to work.
    // @link http://wordpress.stackexchange.com/a/143520/16929
    // ---------------------------------------------------------------
    'filename_versioning' => false,


	// ---------------------------------------------------------------
	// CSS files to register and enqueue in the frontend
	// ---------------------------------------------------------------
	'css' => array(
        array('theme', get_stylesheet_directory_uri().'/assets/css/main.css', array(), null, 'all'),

        // Conditional loading test
        // 'post_id=2' => array('theme-conditional-loading', get_stylesheet_directory_uri().'/assets/css/main-conditional.css', array(), null, 'all'),

        // Conditional IE loading
        // Examples: if IE, if !IE, if IE 8, if lt IE 8, if lte IE 9, if gt IE 9, if gte IE 8
        // 'if IE' => array('theme-conditional-ie-loading', get_stylesheet_directory_uri().'/assets/css/main-ie-conditional.css', array(), '1.0', 'all'),
	),


	// ---------------------------------------------------------------
	// CSS files to load for the TinyMCE editor in the admin
	// ---------------------------------------------------------------
	'editor_styles' => array(
		// get_stylesheet_directory_uri() . '/assets/css/editor-styles.css'
	),


    // ---------------------------------------------------------------
    // Javascript files to register and enqueue in the frontend
    // ---------------------------------------------------------------
    'javascript' => array(
        // array('theme-plugins', get_stylesheet_directory_uri() . '/assets/js/plugins.min.js', array('jquery'), '1.0.0', true),
        // array('theme-scripts', get_stylesheet_directory_uri().'/assets/js/main.js', array('jquery'), '1.0.0', true),
    ),


	// ---------------------------------------------------------------
	// Javascript data
	// Arguments: script-handle, variable name, data array
	// ---------------------------------------------------------------
	'javascript_data' => array(
		array('theme-scripts', 'js_data', array(
			'ajaxurl' => admin_url('admin-ajax.php'), // Accessible in JS via js_data.ajaxurl
		)),
	),
);
