<?php
/**
 * Images
 *
 * Configure the additional image sizes your application needs.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_image_size
 *
 * @key string The size name.
 * @param int $width The image width.
 * @param int $height The image height.
 * @param bool|array $crop Crop option. Since 3.9, define a crop position with an array.
 * @param bool|string $label Add the custom image size to the dropdown when adding a media (if string, it will be used as the label)
 *
 * @package frame
 */

return array(

	// This changes the built-in thumbnails size, used across the WP admin
	// http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
	'default_thumbnails' => array(200, 200, true),

	// Custom image sizes (width, height, crop, label)
	'full-hd' => array(1920, false, true, __('Full HD (w: 1920, h: auto)', 'theme')), // 1080p (1920x1080)
	'hd' => array(1280, false, true), // 720p (1280x720)
	'standard' => array(853, false, true), // 480p (853x480)
	'low' => array(640, false, true), // 360p (640x360)
	'very-low' => array(480, false, true, __('Very low (w: 480, h: auto)', 'theme')), // 320p (480x320)

);
