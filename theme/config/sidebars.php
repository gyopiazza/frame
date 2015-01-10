<?php

/**
 * Sidebars (aka Widget areas)
 *
 * Add widget sidebars to your theme. 
 * Place WordPress default settings for sidebars.
 *
 * @package frame
 */

return array(

	// First sidebar
	array(
		'name'			=> __('First sidebar', 'theme'),
		'description'	=> __('Area of first sidebar', 'theme'),
		'id'			=> 'first-sidebar',
		'class'         => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
	),

);