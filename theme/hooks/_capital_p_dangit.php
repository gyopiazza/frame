<?php

// Remove the filter that changes the incorrect capitalization of Wordpress into WordPress.

if (function_exists('capital_P_dangit'))
{
	remove_filter('the_title', 'capital_P_dangit', 11);
	remove_filter('the_content', 'capital_P_dangit', 11);
	remove_filter('comment_text', 'capital_P_dangit', 31);
}