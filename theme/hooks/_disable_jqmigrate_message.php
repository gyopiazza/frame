<?php

/**
 * Disable the annoying 'JQMIGRATE: Migrate is installed, version 1.4.1' console log text
 */

add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
    }
} );
