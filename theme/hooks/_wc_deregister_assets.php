<?php

/**
 * Deregister default WooCommerce styles and scripts
 */

add_filter( 'woocommerce_enqueue_styles', '__return_false' );
