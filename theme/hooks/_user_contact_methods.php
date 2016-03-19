<?php

// Customize the contact information fields available to your WordPress users.

if (!function_exists('frame_hook_user_contact_methods')):

    function frame_hook_user_contact_methods($user_contact)
    {
        // Add user contact methods
        $user_contact['skype']   = __('Skype Username', 'theme');
        $user_contact['twitter'] = __('Twitter Username', 'theme');

        // Remove user contact methods
        unset($user_contact['aim']);
        unset($user_contact['jabber']);

        return $user_contact;
    }

    add_filter('user_contactmethods', 'frame_hook_user_contact_methods');

endif;
