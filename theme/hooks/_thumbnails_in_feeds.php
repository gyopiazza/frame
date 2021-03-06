<?php

// show post thumbnails in feeds
function frame_post_thumbnail_feeds($content)
{
	global $post;

	if (has_post_thumbnail($post->ID))
		$content = '<div>' . get_the_post_thumbnail($post->ID) . '</div>' . $content;

	return $content;
}

add_filter('the_excerpt_rss', 'frame_post_thumbnail_feeds');
add_filter('the_content_feed', 'frame_post_thumbnail_feeds');