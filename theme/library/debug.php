<?php

/*
 *------------------------------------------------------------------------------------------------
 * Debug functions
 *------------------------------------------------------------------------------------------------
 *
 */

global $frame_debug_stack;
$frame_debug_stack = array();

// Short function d() for t_debug()
if (!function_exists('d')) { function d($var, $label = '', $verbose = false, $stack = false) { t_debug($var, $label, $verbose, $stack); } }

function t_debug($var, $label = '', $verbose = false, $stack = false)
{
	// Stop execution if not in debug mode
	// if (defined('WP_DEBUG') && WP_DEBUG === false) return;

	// Only admins can see debug messages
	if (!current_user_can('manage_options')) return;

	global $frame_debug_stack;

	$t = microtime(true);
	$micro = sprintf("%06d",($t - floor($t)) * 1000000);

	$debug  = '<div>';
	$debug .= '<h2><strong>'.$label.'</strong></h2>';
	$debug .= '<pre>';
	ob_start();
	if ($verbose) var_dump($var); else print_r($var);
	$var_content = ob_get_contents();
	ob_end_clean();
	$debug .= htmlspecialchars($var_content, ENT_QUOTES);
	$debug .= '</pre>';
	$debug .= '<small>';
	$debug .= '#'.count($frame_debug_stack).' &mdash; ';
	$debug .=  date("l jS F \@\ g:i:s.".$micro." a", microtime(true));
	// if (class_exists('frame_UI')) $debug .= ' &mdash; Called by: ' . frame_UI::get_caller_class();
	$debug .= ' &mdash; Called by: ' . frame_caller_class();
	if ($stack) $debug .= frame_call_stack(debug_backtrace());
	// $callers = debug_backtrace();
	// $debug .= '<pre>'.var_export(debug_backtrace(), true).'</pre>';

	$debug .= '</small>';
	$debug .= '</div><br><br><br>';

	

	$frame_debug_stack[] = $debug;
}


function frame_print_debug()
{
	global $frame_debug_stack;
	foreach ($frame_debug_stack as $debug)
		echo '<div style="background:#fff;color:#333;border-top:1px solid #333; padding:30px;">'.$debug.'</div>';
}
add_action('admin_footer', 'frame_print_debug');
add_action('wp_footer', 'frame_print_debug');

function frame_call_stack($stacktrace)
{
    $output = '<br>'.str_repeat("=", 50) .'<br>';
    $i = 1;
    foreach($stacktrace as $node) {
    	if (isset($node['file']) && isset($node['line']))
        	$output .= "$i. <strong>".basename($node['file']) ."</strong>: " .$node['function'] ." (#" .$node['line'].")<br>";
        $i++;
    }

    return $output;
} 

function frame_caller_class()
{
    $traces = debug_backtrace();
    return (isset($traces[2]['class'])) ? $traces[2]['class'] : null;
}

function frame_log($msg = '')
{ 
	// Stop execution if not in debug mode
	// if (defined('T_DEBUG') && T_DEBUG === false) return;
	
	if (is_array($msg) || is_object($msg)) $msg = var_export($msg, true) . "\n" . '--------------------';

    // open file
    $fd = fopen(locate_template('log.txt'), "a");
    //$fd = fopen(T_PATH.'frame_log.txt', "a");
    // write string
    fwrite($fd, date("Y-m-d H:i:s").' - '.$msg . "\n");
    // close file
    fclose($fd);
}