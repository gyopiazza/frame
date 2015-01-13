<?php

function frame_disable_feed()
{
	wp_die(__('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!', 'theme'));
}

add_action('do_feed', 'frame_disable_feed', 1);
add_action('do_feed_rdf', 'frame_disable_feed', 1);
add_action('do_feed_rss', 'frame_disable_feed', 1);
add_action('do_feed_rss2', 'frame_disable_feed', 1);
add_action('do_feed_atom', 'frame_disable_feed', 1);