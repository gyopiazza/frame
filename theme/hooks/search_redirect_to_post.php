<?php

// Redirect to Post If Search Results Return One Post

function frame_redirect_single_post()
{
    if (is_search())
    {
        global $wp_query;
        if ($wp_query->post_count == 1 && $wp_query->max_num_pages == 1)
        {
            wp_redirect(get_permalink($wp_query->posts['0']->ID ));
            exit;
        }
    }
}

add_action('template_redirect', 'frame_redirect_single_post');
