<?php 

/* Remove empty paragraph tags from the_content */
function frame_remove_empty_paragraphs($content)
{
    /*$pattern = "/<p[^>]*><\\/p[^>]*>/";   
    $content = preg_replace($pattern, '', $content);*/
    $content = str_replace("<p></p>","",$content);
    $content = str_replace("<p>&nbsp;</p>","",$content);
    return $content;
}

add_filter('the_content', 'frame_remove_empty_paragraphs', 99999);