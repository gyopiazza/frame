<?php
/**
 * Remove fields from the comment form
 *
 * @param array $fields The comments form fields
 * @return array $fields The modified comment form fields
 * @package frame
 * @subpackage hooks
 */

function frame_hook_remove_comment_fields($fields)
{
    unset($fields['url']);
    return $fields;
}

add_filter('comment_form_default_fields','frame_hook_remove_comment_fields');
