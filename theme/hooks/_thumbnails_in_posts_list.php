<?php

// Add the post thumbnail column to the admin listings

if (!function_exists('frame_add_thumb_column') && function_exists('add_theme_support')) {
    // for post and page
    function frame_add_thumb_column($cols) {
        $cols['thumbnail'] = __('Thumbnail', 'theme');
        return $cols;
    }

    function frame_add_thumb_value($column_name, $post_id) {
        $width = (int) 35;
        $height = (int) 35;
        if ( 'thumbnail' == $column_name ) {
            // thumbnail of WP 2.9
            $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
            
            // image from gallery
            $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
            
            if ($thumbnail_id)
                $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
            elseif ($attachments) {
                foreach ( $attachments as $attachment_id => $attachment ) {
                $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
            }
        }
        if ( isset($thumb) && $thumb ) { echo $thumb; }
        else { echo __('None', 'theme'); }
        }
    }

    // for posts
    add_filter( 'manage_posts_columns', 'frame_add_thumb_column' );
    add_action( 'manage_posts_custom_column', 'frame_add_thumb_value', 10, 2 );

    // for pages
    add_filter( 'manage_pages_columns', 'frame_add_thumb_column' );
    add_action( 'manage_pages_custom_column', 'frame_add_thumb_value', 10, 2 );
}