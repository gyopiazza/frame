<?php

// Set the content type of email from text/plain to text/html.
function frame_hook_email_content_type()
{
    return "text/html";
}

add_filter('wp_mail_content_type','frame_hook_email_content_type');
