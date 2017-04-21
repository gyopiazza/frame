<?php
/**
 * Disable the JSON API
 *
 * @since  1.0.0
 */

function frame_hook_disable_json_api($access) {
  return new WP_Error('rest_cannot_access', __('Access denied', 'theme'), array('status' => rest_authorization_required_code()));
  // if (!is_user_logged_in()) {
  //   return new WP_Error( 'rest_cannot_access', __( 'Only authenticated users can access the REST API.', 'disable-json-api' ), array( 'status' => rest_authorization_required_code() ) );
  // }
  // return $access;
}

add_filter('rest_authentication_errors', 'frame_hook_disable_json_api');


function frame_hook_json_api_slug($slug) {
  return 'api';
}

add_filter('rest_url_prefix', 'frame_hook_json_api_slug');
