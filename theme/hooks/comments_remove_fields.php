<?php

// Remove fields from the comment form
function frame_remove_comment_fields($fields) {
    unset($fields['url']);
    return $fields;
}

add_filter('comment_form_default_fields','frame_remove_comment_fields');
