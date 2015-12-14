<?php

//--------------------------------------------------------------------------------------------
// Frame helper functions
//--------------------------------------------------------------------------------------------

/**
 * Load config files to an array
 *
 * @param mixed $file The file name relative to the theme directory, false means all the files
 * @param mixed $value Set a new value for the config item
 * @param bool $refresh If true, it reloads the config files
 */

function frame_config($file = false, $value = null, $refresh = false)
{
    static $config = array();

    // var_dump(is_child_theme());

    // $path = locate_template('config').'/';
    // $path = get_stylesheet_directory().'/config/';

    // Load all the config files into one array
    if ($file === false)
    {
        // Get an array with all the config files
        $config_files = frame_load_files('config', true, false);

        // Add all the config files to the $config array
        foreach ($config_files as $config_file)
            frame_config($config_file, $refresh);

        return $config;
    }
    // Load te specified config file
    else
    {
        $segments = explode('.', $file);
        $config_item = $segments[0];

        // Set the new value
        if ($value !== null)
        {
            $config[$config_item] = $value;
            return $value;
        }

        // echo '<br>-----------<br>';
        // echo 'file: ' . $file . '<br>';
        // echo 'config_item: ' . $config_item . '<br>';
        // echo 'segments before: '.count($segments).'<br>';
        // print_r($segments);
        // echo '<br>';

        // Load the config file if it hasn't been cached already
        if (empty($config[$config_item]) || $refresh === true)
        {
            // $file_path = $path.$file.'.php';
            $file_path = locate_template('config/'.$config_item.'.php');

            if (is_readable($file_path))
            {
                $config[$config_item] = include($file_path);
                if (count($segments) > 1)
                {
                    array_shift($segments);
                    $segments = implode('.', $segments);
                    // echo 'segments after: '.$segments.'<br>';
                    return frame_dot_array($config[$config_item], $segments);
                }
                else
                {
                    return $config[$config_item];
                }
            }
        }
        // Return the cached config file
        else if (!empty($config[$config_item]))
        {
            if (count($segments) > 1)
            {
                array_shift($segments);
                $segments = implode('.', $segments);
                // echo 'segments after (cached): '.$segments.'<br>';
                return frame_dot_array($config[$config_item], $segments);
            }
            else
            {
                return $config[$config_item];
            }
        }
    }

    // Return null if nothing worked
    return null;
}


/**
 * Access a multidimensional array via dot notation
 *
 * @param array $a The array to access
 * @param string $path The dot notation object
 * @param mixed $default The default value when nothing is found
 */
function frame_dot_array(array $a, $path, $default = null)
{
  $current = $a;
  $p = strtok($path, '.');

  while ($p !== false)
  {
    if (!isset($current[$p]))
      return $default;

    $current = $current[$p];
    $p = strtok('.');
  }

  return $current;
}


/**
 * Load all the files from a folder
 *
 * @param string $folder The folder name relative to the theme directory
 * @param bool $include If true the files will be included
 * @param bool $extension Get the files with or without extension
 */
function frame_load_files($folder, $include = false, $extension = true)
{
    $path = locate_template($folder);
    $files = array();

    if (is_dir($path))
    {
        $path_items = new DirectoryIterator($path);

        foreach ($path_items as $item)
        {
            if (!$item->isDot() && $item->isFile())
            {
                if (substr($item->getFilename(), 0, 1) !== '.' &&
                    substr($item->getFilename(), 0, 1) !== '_')
                {
                    if ($include === true) include($item->getPathname());
                    $files[] = ($extension === true) ? $item->getFilename() : $item->getBasename('.'.$item->getExtension());
                }
            }
            // Recursive
            else if (!$item->isDot() && $item->isDir())
            {
                if (substr($item->getBasename(), 0, 1) !== '.' &&
                    substr($item->getBasename(), 0, 1) !== '_')
                {
                    $files = frame_load_files($folder.'/'.$item->getBasename(), $include, $extension);
                }
            }
        }
    }

    return $files;
}



/**
 * Load a partial into a view
 *
 * @param string $partial The file name without extension, relative to the 'partials' directory
 */

function frame_partial($partial)
{
    locate_template('partials/'.$partial.'.php', true, false);
}



/**
 * Get URI segments
 *
 * @param int $index The segment index to retrieve, if null returns all the segments
 */

/*
 * segments ( [ int $index = NULL ] ) -> string
 */

// URI: /this/is//a/path/to///nothing
// echo segments(4);   = path
// echo segments(18);  = null
// echo segments();    = /this/is/a/path/to/nothing

function frame_segments($index = null)
{
    static $segments;

    // build $segments on first function call
    if ($segments === null)
    {
        // global $wp;

        // if (!empty($wp->request))
            // $current_url = add_query_arg($wp->query_string, '', home_url($wp->request));
        // else
            // $current_url = home_url(add_query_arg(NULL, NULL));
            // $current_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            // $current_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // d(home_url(add_query_arg(array(),$wp->request)), 'xxx');

        $current_url = frame_url();

        // d(home_url());
        // d($current_url, 'before');

        // Strip the base url
        $current_url = str_replace(home_url(), '', $current_url);
        // Trim the leading/trailing slashes
        $current_url = trim($current_url, '/');
        // Create the segments array
        // $segments = esc_url(parse_url($current_url, PHP_URL_PATH));
        $segments = explode('/', $current_url);

        foreach($segments as $key => $val)
            if(empty($val))
                unset($segments[$key]);

        // $segments = array_filter($segments);
        // $segments = array_values($segments);

        // TODO: Add Polylang support
        $locale = (defined('ICL_LANGUAGE_CODE')) ? ICL_LANGUAGE_CODE : 'en';
        if (isset($segments[0]) && $segments[0] == $locale) unset($segments[0]);
    }

    // if no $index was requested, emulate REQUEST_URI
    if ($index === null)
    {
        return implode('/', $segments);
    }

    // return the segment index if valid, otherwise null
    $index = (int) $index - 1;
    return isset($segments[$index]) ? $segments[$index] : null;
}


/**
 * Get/Check the current location
 *
 * @param array $params The parameters to check against the current location
 * @todo Add single, archive,
 */

function frame_location($params = null)
{
    global $post, $pagenow, $typenow, $current_screen, $template;

    // Handle function arguments
    $num_args = func_num_args();

    // If there is more than one argument, they are set as key => val
    // Example: frame_location('admin', true, 'post_type', 'page');
    if ($num_args > 1)
    {
        $args = array();

        // Passing in keys as args this time so we don't need to access global scope
        for ($i = 0; $i < $num_args; $i++)
        {
            // Run following code on even args
            // (the even args are numbered as odd since it counts from zero)
            // `% 2` is a modulus operation (calculating remainder when dividing by 2)
            if ($i % 2 != 0)
            {
                $key = func_get_arg($i - 1);
                $val = func_get_arg($i);
                // Join odd and even args together as key/value pairs
                $args[$key] = $val;
            }
        }

        // Set the arguments to the $params in order to continue as normal
        if (!empty($args)) $params = $args;
    }
    // Allow for a single argument as a query string: arg1=something&arg2=somethingElse&multiArg=one|two|three
    else if ($num_args === 1 && is_string($params) && strpos($params, '=') !== false)
    {
        parse_str($params, $params);

        // Checks and split multiple values
        foreach ($params as &$param)
            if (strpos($param, '|') !== false)
                $param = explode('|', $param);
    }


    // d($_SERVER, '_SERVER');
    // d($_SERVER['PHP_SELF'], 'PHP_SELF');
    // d($_SERVER['REQUEST_URI'], 'REQUEST_URI');
    // d($_SERVER['SCRIPT_NAME'], 'SCRIPT_NAME');


    //////////////////////


    // Gather current location values

    $admin      = is_admin(); // Are we in the admin area?
    $frontend   = !$admin; // Are we in the frontend area?
    $logged_in  = is_user_logged_in(); // Is the current user logged in?
    $url        = frame_url(); // The current URL
    $segments   = (!empty($params['segments']) && frame_segments() != $params['segments']) ? false : frame_segments(); // The URI segments to match
    $file       = ($admin) ? basename($_SERVER['SCRIPT_NAME']) : basename($template); // The current filename (in the frontend it's 'index.php', 'archive.php' etc... it doesn't work with get_template_part: use __FILE__ instead)
    $post_type  = null; // The current post type
    $post_id    = (isset($post->ID)) ? $post->ID : null; // The current post id
    $slug       = (isset($post->post_name)) ? $post->post_name : null; // The current post slug
    $page       = isset($_REQUEST['page']) ? sanitize_key($_REQUEST['page']) : null; // The current page number (used when paginating results)
    $action     = isset($_GET['action']) ? sanitize_key($_GET['action']) : null; // Used in the admin
    $ajax       = ( !defined('DOING_AJAX') || (defined('DOING_AJAX') && DOING_AJAX === false) ) ? false : true; // Are doing an ajax request?
    $saving     = (!empty($_POST)) ? true : false; // Are we sending post data? (maybe change this...)
    $customizer = is_customize_preview();


    // $post_type specific optimization

    // Get post type from post object
    if ($post && $post->post_type)
        $post_type = $post->post_type;
    // Check $typenow object
    else if ($typenow)
        $post_type = $typenow;
    // Check $current_screen object
    else if ($current_screen && $current_screen->post_type)
        $post_type = $current_screen->post_type;
    // Pages and custom post types
    else if (isset($_REQUEST['post_type']) && $admin)
        $post_type = sanitize_key($_REQUEST['post_type']);
    // Standard posts
    else if ($file == 'edit.php' && !isset($_REQUEST['post_type']) && $admin)
        $post_type = 'post';
    // Attachments
    else if ($file == 'upload.php' && !isset($_REQUEST['post_type']) && $admin)
        $post_type = 'attachment';
    // When inside edit screens, get the post type from the post ID
    else if ($file == 'post.php' && isset($_REQUEST['post']) && !isset($_REQUEST['post_type']) && $admin)
        $post_type = get_post_type(sanitize_key($_REQUEST['post']));

    // End of $post_type specific optimization


    // Put the values together
    $location = array(
        'admin'         => $admin,
        'frontend'      => $frontend,
        'logged_in'     => $logged_in,
        'url'           => $url,
        'segments'      => $segments,
        'file'          => $file,
        'post_type'     => $post_type,
        'post_id'       => $post_id,
        'slug'          => $slug,
        'page'          => $page,
        'action'        => $action,
        'ajax'          => $ajax,
        'saving'        => $saving,
        'customizer'    => $customizer,
    );

    // d($current_screen, 'current_screen', true);
    // d($admin, 'admin', true);
    // d($file, 'file', true);
    // d($page, 'page', true);
    // d($post_type, 'post_type', true);
    // d($action, 'action', true);
    // d('==========================================================');

    // d($location, 'Current location');

    // parse_str($params, $params);
    // d($params, 'params');


    //////////////////////


    // Compare the $location array with the given $params
    // Example: frame_location(array('param' => 'value')); // Return bool
    if (is_array($params))
    {
        foreach ($params as $key => $val)
        {
            // d($val, $key);
            // if (array_key_exists($key, $location) && $location[$key] !== $val)
            //  return false;

            // TODO: Maybe change to...
            // $location = frame_location_item($key, $val);
            // if ( (is_array($val) && !in_array($location, $val)) || $location != $val )
            //     return false;

            // if (!frame_location_check($key, $val))
            //     return false;


            if (array_key_exists($key, $location))
            {
                if (is_array($val))
                {
                    // d($val, 'is_array');
                    if (!in_array($location[$key], $val))
                        return false;
                }
                else
                {
                    // d($val, 'normal');
                    if ($location[$key] != $val)
                        return false;
                }
            }
        }

        return true;
    }
    // Return one element from the $location array
    // Example: frame_location('param'); // Returns 'param' from $location
    else if (is_string($params) || is_numeric($params))
    {
        return (isset($location[$params])) ? $location[$params] : null;
    }
    // Return the whole location array
    // Example: frame_location(); // Return array
    else
    {
        return $location;
    }

    // global $current_screen;
    // d($current_screen, 'current_screen');
}


/**
 * Check single location items
 *
 * @return string The current URL string
 */
function frame_location_item($key = null, $val = null)
{
    global $post, $pagenow, $typenow, $current_screen;
    $key = strtolower($key);

    // Fetch the requested info
    // TODO: Maybe change to foreach through the location_items
    // if (in_array($key, $location_items) || $key === null)

    switch ($key)
    {
        // Are we in the admin area?
        case 'admin':
            return is_admin();
        break;

        // -----------

        // Are we in the frontend area?
        case 'frontend':
            return !is_admin();
        break;

        // -----------

        // Is the current user logged in?
        case 'logged_in':
            return is_user_logged_in();
        break;

        // -----------

        // The current URL
        case 'url':
            return frame_url();
        break;

        // -----------

        // The URI segments to match
        case 'segments':
            return frame_segments();
        break;

        // -----------

        // The current filename (in the frontend it's always 'index.php')
        case 'file':
            return basename($_SERVER['SCRIPT_NAME']);
        break;

        // -----------

        // The current post type
        case 'post_type':
            $admin = is_admin();
            $post_type  = null;

            // Get type from post object
            if ($post && $post->post_type)
                $post_type = $post->post_type;
            // Check $typenow object
            else if ($typenow)
                $post_type = $typenow;
            // Check $current_screen object
            else if ($current_screen && $current_screen->post_type)
                $post_type = $current_screen->post_type;
            // Pages and custom post types
            else if (isset($_REQUEST['post_type']) && $admin)
                $post_type = sanitize_key($_REQUEST['post_type']);
            // Standard posts
            else if ($file == 'edit.php' && !isset($_REQUEST['post_type']) && $admin)
                $post_type = 'post';
            // Attachments
            else if ($file == 'upload.php' && !isset($_REQUEST['post_type']) && $admin)
                $post_type = 'attachment';
            // Inside edit screens get the post type from the post ID
            else if ($file == 'post.php' && isset($_REQUEST['post']) && !isset($_REQUEST['post_type']) && $admin)
                $post_type = get_post_type(sanitize_key($_REQUEST['post']));

            return $post_type;
        break;

        // -----------

        // The current post id
        case 'post_id':
            return (isset($post->ID)) ? $post->ID : null;
        break;

        // -----------

        // The current page number (used when paginating results)
        case 'page':
            return isset($_REQUEST['page']) ? sanitize_key($_REQUEST['page']) : null;
        break;

        // -----------

        // Used in the admin
        case 'action':
            return isset($_GET['action']) ? sanitize_key($_GET['action']) : null;
        break;

        // -----------

        // Are doing an ajax request?
        case 'ajax':
            return (!defined('DOING_AJAX') || DOING_AJAX === false) ? false : true;
        break;

        // -----------

        // Are we sending post data? (maybe change this...)
        case 'saving':
            return (!empty($_POST)) ? true : false;
        break;

        // -----------

        // If nothing is requested, return the whole location array
        default:
            // The avaiable location items
            $location_items = array(
                'admin',
                'frontend',
                'logged_in',
                'url',
                'segments',
                'file',
                'post_type',
                'post_id',
                'page',
                'action',
                'ajax',
                'saving'
            );

            $location = array();

            foreach($location_items as $item)
                $location[$item] = frame_location_item($item);

            return $location;
        break;
    }
}



/**
 * Return the current URL
 *
 * @return string The current URL string
 */
function frame_url()
{
    static $url;

    if ($url === null)
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    return $url;
}



/**
 * Return the current theme (parent or child) URL with optional path
 * Basicallt wrapper for the get_stylesheet_directory_uri() function
 *
 * @param string A path that will be appended to the URL
 * @return string The current theme URL with optional path
 */
function frame_theme_url($path = '')
{
    return trailingslashit(get_stylesheet_directory_uri()).$path;
}



/**
 * Check if a particular user has one or more roles.
 * Returns true if a match was found.
 *
 * @param mixed (string/array) $role Role name(s).
 * @param int $user_id (Optional) The ID of a user. Defaults to the current user.
 * @return bool True if the user has at least one of the specified roles.
 */
function frame_user_role($role, $user_id = null)
{
  if (is_numeric($user_id))
    $user = get_userdata($user_id);
  else
    $user = wp_get_current_user();

  if (empty($user))
    return false;

  $intersection = array_intersect((array) $role, (array) $user->roles);

  return !empty($intersection) ? true : false;
}



/**
 * Gets the posts count by author.
 *
 * @param int $user_id The ID of the posts author
 * @param string|array The post type(s)
 * @return int The posts count
 */
function frame_count_posts_by_author($user_id, $post_type = array('post', 'page'))
{
    $args = array(
        'post_type'      => $post_type,
        'author'         => $user_id,
        'post_staus'     => 'publish',
        'posts_per_page' => -1
    );

    $query = new WP_Query($args);

    return $query->found_posts;
}



/**
 * Output inline styles in the pages
 *
 * @param array The style to add
 * @return void
 *
 * @example
 *
 * Without conditions, output in all the pages
 *
 * frame_style(array(
 *      'p' => 'color: white;'
 * ));
 *
 *
 * With condition, only output when the current post_id=2
 *
 * frame_style('post_id=2', array(
 *      'p' => 'color: white;'
 * ));
 *
 */

global $frame_styles;
$frame_styles = array();

function frame_style($condition, $style = null)
{
    global $frame_styles;

    if (is_string($condition))
        $frame_styles[$condition] = $style;
    else
        $frame_styles[] = $condition;
}

function frame_output_style()
{
    global $frame_styles;

    $output = '<style>';

    foreach ($frame_styles as $condition => $style)
    {
        if ((is_string($condition) && frame_location($condition)) || is_numeric($condition))
            foreach ($style as $selector => $rules)
                $output .= $selector . '{' . $rules . '}';
    }

    $output .= '</style>';

    echo $output;
}

add_action('wp_head','frame_output_style');


/**
 * Social share links
 *
 * Returns a string with a ul list containing all the chosen sharing providers.
 * Supported providers: facebook, google, linkedin, pinterest, reddit, twitter.
 *
 * @param array $providers An array of sharing providers
 * @param int $post_id The post to share, if null the current URL will be used
 * @return string A <ul> with the social sharing links
 */

function frame_share_links($providers = null, $post_id = null)
{
    // Get the providers
    if ($providers === null)
        $providers = array('facebook', 'google', 'linkedin', 'pinterest', 'reddit', 'twitter');
    else
        $providers = (array) $providers;

    $output = '<ul>';

    foreach($providers as $provider)
    {
        // $output .= '<li>'..'</li>';
    }

    $output .= '</ul>';
}



/**
 * Social share provider URL
 *
 * Returns a string with the URL that allows to share the resource.
 * Supported providers: facebook, google, linkedin, pinterest, reddit, twitter.
 *
 * @param string $provider The provider name to retrieve the share URL
 * @param int $post_id The post to share, if null the current URL will be used
 * @return string The share URL
 */
function frame_share($provider, $post_id = null)
{

    // $postid = url_to_postid( $url );

    $defaults = array(
        'provider' => null,
        'post_id' => $post_id,
        'url' => ($post_id === null) ? $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : get_permalink($post_id),
        'title' => ($post_id === null) ? '' : get_the_title($post_id),
        'description' => '',
        'tags' => '',
        'source' => ''
    );

    if (is_array($provider))
    {
        $args = wp_parse_args($provider, $defaults);
    }
    else if (is_string($provider))
    {

    }



    // Get the URL to share
    $url = ($post_id === null) ? $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : get_permalink($post_id);
    $url = urlencode($url);

    switch($args['provider'])
    {
        case 'facebook':
            break;

        case 'google':
            break;

        case 'linkedin':
            break;

        case 'pinterest':
            break;

        case 'reddit':
            break;

        case 'twitter':
            break;

        default:
            break;
    }


}


// frame_share_anchor('facebook', 123);
// frame_share_anchor(array(
//     'url' => get_permalink(),
//     'title' => get_the_title()
// ));

// frame_share('facebook', 123);
// frame_share(array(
//     'url' => get_permalink(),
//     'title' => get_the_title()
// ));



/**
* is_realy_woocommerce_page - Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
*
* @access public
* @return bool
*/
function frame_shop()
{
    if (function_exists("is_woocommerce") && is_woocommerce())
        return true;

    $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                    "woocommerce_terms_page_id" ,
                                    "woocommerce_cart_page_id" ,
                                    "woocommerce_checkout_page_id" ,
                                    "woocommerce_pay_page_id" ,
                                    "woocommerce_thanks_page_id" ,
                                    "woocommerce_myaccount_page_id" ,
                                    "woocommerce_edit_address_page_id" ,
                                    "woocommerce_view_order_page_id" ,
                                    "woocommerce_change_password_page_id" ,
                                    "woocommerce_logout_page_id" ,
                                    "woocommerce_lost_password_page_id" ) ;

    foreach ( $woocommerce_keys as $wc_page_id ) {
        if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
            return true ;
        }
    }

    return false;
}




//--------------------------------------------------------------------------------------------
// Maybe...
//--------------------------------------------------------------------------------------------

// Recursively remove array duplicates
function removeArrayDuplicates($array)
{
    return array_map('unserialize', array_unique(array_map('serialize'), $array));
}

function is_empty($element)
{
    $element = trim($element);
    return empty($element);
}

function startswith($haystack, $needle)
{
    return !strncmp($haystack, $needle, strlen($needle));
}

function endswith($string, $test)
{
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, -$testlen) === 0;
}

function endsWith2($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}


//------


// Rename 'posts' in the admin
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = "Blog";
    $submenu['edit.php'][5][0] = "Blog";
    // $submenu['edit.php'][10][0] = 'Add Contacts';
    // $submenu['edit.php'][15][0] = 'Status'; // Change name for categories
    // $submenu['edit.php'][16][0] = 'Labels'; // Change name for tags
    echo '';
}

function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = "Blog";
    // $labels->singular_name = 'Contact';
    // $labels->add_new = 'Add Contact';
    // $labels->add_new_item = 'Add Contact';
    // $labels->edit_item = 'Edit Contacts';
    // $labels->new_item = 'Contact';
    // $labels->view_item = 'View Contact';
    // $labels->search_items = 'Search Contacts';
    // $labels->not_found = 'No Contacts found';
    // $labels->not_found_in_trash = 'No Contacts found in Trash';
}
// add_action('init', 'change_post_object_label');
// add_action('admin_menu', 'change_post_menu_label');


//------


// Change admin menu order
function custom_menu_order($menu_ord) {
    if (!$menu_ord) {
        return true;
    }

    return array(
        'index.php', // Dashboard
        'edit.php', // Blog (Posts)
        'edit.php?post_type=event', // Events
        'edit.php?post_type=classifieds', // Classifieds
        'edit.php?post_type=page', // Pages
        'upload.php', // Media
    );
}
// add_filter('custom_menu_order', 'custom_menu_order');
// add_filter('menu_order', 'custom_menu_order');


//------


// function addUploadMimes($mimes)
// {
//     // Example using Textmate's files format
//     $mimes = array_merge($mimes, array(
//         'tmbundle|tmCommand|tmDragCommand|tmSnippet|tmLanguage|tmPreferences' => 'application/octet-stream'
//     ));

//     return $mimes;
// }

// add_filter('upload_mimes', 'addUploadMimes');


//------


// Set Different Editor Stylesheets For Different Post Types
// function my_editor_style() {
//     global $current_screen;
//     switch ($current_screen->post_type) {
//         case 'post':
//         add_editor_style('editor-style-post.css');
//         break;

//         case 'page':
//         add_editor_style('editor-style-page.css');
//         break;

//         case 'portfolio':
//         add_editor_style('editor-style-portfolio.css');
//         break;
//     }
// }
// add_action( 'admin_head', 'my_editor_style' );


//------


// REMOVE THE WORDPRESS UPDATE NOTIFICATION FOR ALL USERS EXCEPT SYSADMIN
// global $user_login;
// get_currentuserinfo();
// if (!current_user_can('update_plugins')) { // checks to see if current user can update plugins
//     add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
//     add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
// }
