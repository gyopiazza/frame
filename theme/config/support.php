<?php
/**
 * Support
 *
 * Configure the additional features for this theme
 *
 * @link http://codex.wordpress.org/Function_Reference/add_theme_support
 *
 * @package frame
 */

return array(

	// ---------------------------------------------------------------
	// Enable post thumbnails
	// ---------------------------------------------------------------
	'post-thumbnails' => array('post'),

	// ---------------------------------------------------------------
	// Enable post formats (aside, gallery, link, image, ...)
	// ---------------------------------------------------------------
	//'post-formats' => array('aside', 'audio', 'gallery', 'image', 'link', 'quote', 'video', 'status'),

	// ---------------------------------------------------------------
	// HTML5
	// ---------------------------------------------------------------
	'html5' => array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'),

	// ---------------------------------------------------------------
	// Titles (WP4.1+)
	// WordPress will add the <title> tag automatically in the <head>
	// ---------------------------------------------------------------
	'title-tag',

	// ---------------------------------------------------------------
	// Enable feed links in head
	// ---------------------------------------------------------------
	'automatic-feed-links',

	// ---------------------------------------------------------------
	// Enable WooCommerce support
	// ---------------------------------------------------------------
	// 'woocommerce' => true,

	// ---------------------------------------------------------------
	// Enable bbPress support
	// ---------------------------------------------------------------
	// 'bbpress' => true,

	// ---------------------------------------------------------------
	// Enable custom background (since WP 3.4)
	// ---------------------------------------------------------------
	//'custom-background'	=> array(
	//	'default-color'          => '',
	//	'default-image'          => '',
	//	'wp-head-callback'       => '_custom_background_cb',
	//	'admin-head-callback'    => '',
	//	'admin-preview-callback' => ''
	//),

	// ---------------------------------------------------------------
	// Enable custom header (not compatible for versions < WP 3.4)
	// ---------------------------------------------------------------
	//'custom-header'	=>	array(
	//	'default-image'          => '',
	//	'random-default'         => false,
	//	'width'                  => 0,
	//	'height'                 => 0,
	//	'flex-height'            => false,
	//	'flex-width'             => false,
	//	'default-text-color'     => '',
	//	'header-text'            => true,
	//	'uploads'                => true,
	//	'wp-head-callback'       => '',
	//	'admin-head-callback'    => '',
	//	'admin-preview-callback' => '',
	//),

);
