<?php

// Show custom Gravatar in Settings > Discussion
function frame_gravatar($avatar_defaults)
{
    $avatar = get_stylesheet_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$avatar] = __('Custom Gravatar', 'frame');
    return $avatar_defaults;
}

add_filter('avatar_defaults', 'frame_gravatar');