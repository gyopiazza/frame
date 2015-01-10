<?php

// Remove 'text/css' from our enqueued stylesheet
function frame_clean_enqueued_stylesheets($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

add_filter('style_loader_tag', 'frame_clean_enqueued_stylesheets');