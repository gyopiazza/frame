<?php

// Threaded Comments
function frame_enable_threaded_comments()
{
    if (!is_admin())
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
            wp_enqueue_script('comment-reply');
}

add_action('get_header', 'frame_enable_threaded_comments');