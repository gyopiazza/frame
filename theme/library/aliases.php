<?php

//--------------------------------------------------------------------------------------------
// Function and Class aliases (just to make it nice and short...)
//--------------------------------------------------------------------------------------------

if (!function_exists('config') && function_exists('frame_config')) { function config($file = false, $refresh = false) { return frame_config($file, $refresh); } }
if (!function_exists('partial') && function_exists('frame_partial')) { function partial($partial) { return frame_partial($partial); } }
if (!function_exists('segments') && function_exists('frame_segments')) { function segments($index = null) { return frame_segments($index); } }
if (!function_exists('location') && function_exists('frame_location')) { function location() { $args = func_get_args(); return call_user_func_array('frame_location', $args); } }
if (!function_exists('is') && function_exists('frame_location')) { function is() { $args = func_get_args(); return call_user_func_array('frame_location', $args); } }
if (!function_exists('not') && function_exists('frame_location')) { function not() { $args = func_get_args(); return call_user_func_array('frame_location', $args); } }
if (!function_exists('pagination') && function_exists('frame_pagination')) { function pagination($pages = null, $range = 4) { return frame_pagination($pages, $range); } }
