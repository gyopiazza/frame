<?php

// Remove invalid rel attribute values in the categorylist
function frame_remove_category_rel_from_category_list($list)
{
    return str_replace('rel="category tag"', 'rel="tag"', $list);
}

add_filter('the_category', 'frame_remove_category_rel_from_category_list');