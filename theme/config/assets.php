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
	// Javascript files to register and enqueue in the frontend
	// ---------------------------------------------------------------
	'javascript' => array(
		array('theme-plugins', get_template_directory_uri() . '/assets/js/plugins.min.js', array('jquery'), '1.0.0', true),
		array('theme-scripts', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true),
	),

	// ---------------------------------------------------------------
	// CSS files to register and enqueue in the frontend
	// ---------------------------------------------------------------
	'css' => array(
		array('theme', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0', 'all')
	),

	// ---------------------------------------------------------------
	// CSS files to load for the TinyMCE editor in the admin
	// ---------------------------------------------------------------
	'editor_styles' => array(
		get_template_directory_uri() . '/assets/css/editor-styles.css'
	),

	// ---------------------------------------------------------------
	// Javascript data
	// Arguments: script-handle, variable name, data array
	// ---------------------------------------------------------------
	'javascript_data' => array(
		array('theme-scripts', 'js_data', array(
			'ajaxurl' => admin_url('admin-ajax.php'), // Accessible in JS via js_data.ajaxurl
		)),
        // TODO: Add conditional enqueuing, based on current location
        // 'uri/to/page' OR better use frame_location()
        // 'uri/to/page' => array('theme-scripts', 'js_data', array(
        //     'ajaxurl' => admin_url('admin-ajax.php'), // Accessible in JS via js_data.ajaxurl
        // )),
	),
);
