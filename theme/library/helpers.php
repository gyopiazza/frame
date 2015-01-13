<?php

//--------------------------------------------------------------------------------------------
// Frame helper functions
//--------------------------------------------------------------------------------------------

/**
 * Load config files to an array
 *
 * @param mixed $file The file name relative to the theme directory, false means all the files
 * @param bool $refresh If true, it reloads the config files
 */

function frame_config($file = false, $refresh = false)
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
 * Access a multidimensional array with dot notation
 *
 * @param array $a The array to access
 * @param string $path The dot notation object
 * @param mixed $default The default value when nothing is found
 */
function frame_dot_array(array $a, $path, $default = null)
{
  $current = $a;
  $p = strtok($path, '.');

  while ($p !== false) {
    if (!isset($current[$p])) {
      return $default;
    }
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
                    $files[] = ($extension === true) ? $item->getFilename() : $item->getBasename('.' .$item->getExtension());
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
 * @param string $partial The file name without extension, relative to the partials directory
 */

function frame_partial($partial)
{
    $file = locate_template('partials/'.$partial.'.php');
    if (is_readable($file)) include($file);
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
        global $wp;

        if (!empty($wp->request))
            $current_url = add_query_arg($wp->query_string, '', home_url($wp->request));
        else
            $current_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $current_url = str_replace(MY_URL, '', $current_url);
        $segments = esc_url(parse_url($current_url, PHP_URL_PATH));
        $segments = explode('/', $segments);

        foreach($segments as $key => $val)
            if(empty($val))
                unset($segments[$key]);

        $segments = array_filter($segments);
        $segments = array_values($segments);

        $locale = (defined('ICL_LANGUAGE_CODE')) ? ICL_LANGUAGE_CODE : 'en';
        if (isset($segments[0]) && $segments[0] == $locale) unset($segments[0]);
    }

    // if no $index was requested, emulate REQUEST_URI
    if ($index === null)
    {
        return '/' . implode('/', $segments);
    }

    // return the segment index if valid, otherwise null
    $index = (int) $index - 1;
    return isset($segments[$index]) ? $segments[$index] : null;
}


/**
 * Get/Check the current location
 *
 * @param array $params The parameters to check against the current location
 */

function frame_location($params = null)
{
    global $post, $pagenow, $typenow, $current_screen;

    // If there is more than one argument, they are set as key => val
    // Example: frame_location('admin', true, 'post_type', 'page');
    $num_args = func_num_args();

    if ($num_args > 0)
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


    // d($_SERVER, '_SERVER');
    // d($_SERVER['PHP_SELF'], 'PHP_SELF');
    // d($_SERVER['REQUEST_URI'], 'REQUEST_URI');
    // d($_SERVER['SCRIPT_NAME'], 'SCRIPT_NAME');


    //////////////////////

    $admin      = is_admin(); // Are we in the admin area?
    $frontend   = !$admin; // Are we in the frontend area?
    $file       = basename($_SERVER['SCRIPT_NAME']); // The current filename (in the frontend it's always 'index.php')
    $page       = isset($_REQUEST['page']) ? sanitize_key($_REQUEST['page']) : null; // The current page number (used when paginating results)
    $post_type  = null; // The current post type
    $action     = isset($_GET['action']) ? sanitize_key($_GET['action']) : null; // Used in the admin
    $ajax       = (!defined('DOING_AJAX') || DOING_AJAX === false) ? false : true; // Are doing an ajax request?
    $saving     = (!empty($_POST)) ? true : false; // Are we sending post data? (maybe change this...)

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
    // When inside edit screens, get the post type from the post ID
    else if ($file == 'post.php' && isset($_REQUEST['post']) && !isset($_REQUEST['post_type']) && $admin)
        $post_type = get_post_type(sanitize_key($_REQUEST['post']));
    // No post type available
    // else
        // $post_type = null;

    // Put the values together
    $location = array(
        'admin'         => $admin,
        'frontend'      => $frontend,
        'file'          => $file,
        'page'          => $page,
        'post_type'     => $post_type,
        'action'        => $action,
        'ajax'          => $ajax,
        'saving'        => $saving
    );

    // d($current_screen, 'current_screen', true);
    // d($admin, 'admin', true);
    // d($file, 'file', true);
    // d($page, 'page', true);
    // d($post_type, 'post_type', true);
    // d($action, 'action', true);
    // d('==========================================================');

    // d($location, 'Current location');


    //////////////////////


    // Compare the $location array with the passed $params
    // Example: frame_location(array('param' => 'value')); // Return bool
    if (is_array($params))
    {
        foreach ($params as $key => $val)
        {
            // if (array_key_exists($key, $location) && $location[$key] !== $val)
            //  return false;

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
    else if (is_string($params))
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
 * Output a custom length excerpt (must be used inside the loop)
 *
 * @param int $length The number of characters to output
 * @return string
 */

function frame_excerpt($length = 40)
{
    global $post;
    $content = strip_tags($post->post_content);
    if (empty($content)) {
        $content = strip_tags($post->post_excerpt);
    }

    preg_match('/^\s*+(?:\S++\s*+){1,' . $length . '}/', $content, $matches);
    if (!empty($matches[0])) {
        echo "<p>" . $matches[0] . "...</p>";
    }
}


/**
 * Gets the posts count by author
 *
 * @todo Add configurable post_type
 * @param int $user_id The ID of the posts author
 * @return int The posts count
 */

function frame_count_posts_by_author($user_id)
{
    $args = array(
        'post_type' => array('club', 'classifieds'),
        'author' => $user_id,
        'post_staus' => 'publish',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    return $query->found_posts;
}


//--------------------------------------------------------------------------------------------
// Function aliases (just to make it nice and short...)
//--------------------------------------------------------------------------------------------

if (!function_exists('config')) { function config($file = false, $refresh = false) { return frame_config($file, $refresh); } }
if (!function_exists('partial')) { function partial($partial) { return frame_partial($partial); } }
if (!function_exists('segments')) { function segments($index = null) { return frame_segments($index); } }
if (!function_exists('location')) { function location() { $args = func_get_args(); return call_user_func_array('frame_location', $args); } }
if (!function_exists('is')) { function is() { $args = func_get_args(); return call_user_func_array('frame_location', $args); } }
if (!function_exists('not')) { function not() { $args = func_get_args(); return call_user_func_array('frame_location', $args); } }
if (!function_exists('pagination')) { function pagination($pages = null, $range = 4) { return frame_pagination($pages, $range); } }



//--------------------------------------------------------------------------------------------
// Maybe...
//--------------------------------------------------------------------------------------------

function is_empty($element)
{
    $element = trim($element);
    return !empty($element);
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
        'edit.php?post_type=event', // Temps d'Oci
        'edit.php?post_type=classifieds', // Busca i Troba
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
