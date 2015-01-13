<?php


/**
 * The WordPress.org theme review requires that a link be provided to the single post page for untitled 
 * posts.  This is a filter on 'the_title' so that an '(Untitled)' title appears in that scenario, allowing 
 * for the normal method to work.
 *
 * @since  1.6.0
 * @access public
 * @param  string  $title
 * @return string
 */

function frame_untitled_post($title)
{
	if (empty($title) && !is_singular() && in_the_loop() && !is_admin())
	{
		$title = _x('(Untitled)', 'Title for untitled posts', 'theme');
	}

	return $title;
}

add_filter('the_title', 'frame_untitled_post');