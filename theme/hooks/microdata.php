<?php

/* Filters to add microdata support to common template tags. */
add_filter( 'the_author_posts_link',          'frame_the_author_posts_link',          5 );
add_filter( 'get_comment_author_link',        'frame_get_comment_author_link',        5 );
add_filter( 'get_comment_author_url_link',    'frame_get_comment_author_url_link',    5 );
add_filter( 'comment_reply_link',             'frame_comment_reply_link_filter',      5 );
add_filter( 'get_avatar',                     'frame_get_avatar',                     5 );
add_filter( 'post_thumbnail_html',            'frame_post_thumbnail_html',            5 );
add_filter( 'comments_popup_link_attributes', 'frame_comments_popup_link_attributes', 5 );

/**
 * Adds microdata to the author posts link.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $link
 * @return string
 */
function frame_the_author_posts_link( $link ) {
	$pattern = array(
		"/(<a.*?)(>)/i",
		'/(<a.*?>)(.*?)(<\/a>)/i'
	);
	$replace = array(
		'$1 class="url fn n" itemprop="url"$2',
		'$1<span itemprop="name">$2</span>$3'
	);
	return preg_replace( $pattern, $replace, $link );
}

/**
 * Adds microdata to the comment author link.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $link
 * @return string
 */
function frame_get_comment_author_link( $link ) {
	$patterns = array(
		'/(class=[\'"])(.+?)([\'"])/i',
		"/(<a.*?)(>)/i",
		'/(<a.*?>)(.*?)(<\/a>)/i'
	);
	$replaces = array(
		'$1$2 fn n$3',
		'$1 itemprop="url"$2',
		'$1<span itemprop="name">$2</span>$3'
	);
	return preg_replace( $patterns, $replaces, $link );
}
/**
 * Adds microdata to the comment author URL link.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $link
 * @return string
 */
function frame_get_comment_author_url_link( $link ) {
	$patterns = array(
		'/(class=[\'"])(.+?)([\'"])/i',
		"/(<a.*?)(>)/i"
	);
	$replaces = array(
		'$1$2 fn n$3',
		'$1 itemprop="url"$2'
	);
	return preg_replace( $patterns, $replaces, $link );
}
/**
 * Adds microdata to the comment reply link.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $link
 * @return string
 */
function frame_comment_reply_link_filter( $link ) {
	return preg_replace( '/(<a\s)/i', '$1itemprop="replyToUrl"', $link );
}
/**
 * Adds microdata to avatars.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $avatar
 * @return string
 */
function frame_get_avatar( $avatar ) {
	return preg_replace( '/(<img.*?)(\/>)/i', '$1itemprop="image" $2', $avatar );
}
/**
 * Adds microdata to the post thumbnail HTML.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $html
 * @return string
 */
function frame_post_thumbnail_html( $html ) {
	return function_exists( 'get_the_image' ) ? $html : preg_replace( '/(<img.*?)(\/>)/i', '$1itemprop="image" $2', $html );
}
/**
 * Adds microdata to the comments popup link.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $attr
 * @return string
 */
function frame_comments_popup_link_attributes( $attr ) {
	return 'itemprop="discussionURL"';
}