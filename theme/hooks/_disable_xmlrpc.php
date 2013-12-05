<?php
/**
 * Disable the xmlrpc services
 *
 * For better security, add this to the .htaccess file:
 *
 * <Files xmlrpc.php>
 * order deny,allow
 * deny from all
 * allow from 123.123.123.123
 * </Files>
 *
 * @since  1.0.0
 */

add_filter('xmlrpc_enabled', '__return_false');
