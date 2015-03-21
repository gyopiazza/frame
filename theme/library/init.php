<?php

/**
 * Framework initialization
 *
 * @package frame
 */

// Load the debug functions file
require_once(locate_template('library/debug.php'));

// Load the helpers file
require_once(locate_template('library/helpers.php'));

// Load the aliases file
require_once(locate_template('library/aliases.php'));

// Load the plugins activation class
require_once(locate_template('library/plugin-activation.php'));

// Load the theme activation file
// require_once(locate_template('library/theme-activation.php'));


//--------------------------------------------------------------------------------------------
// Automatically load files from folders
//--------------------------------------------------------------------------------------------

// Scan and import hooks
// $hooks = frame_load_files('hooks', true);
frame_load_files('hooks', true);

// Scan and import files to be autoloaded
// $autoload = frame_load_files('autoload', true);
frame_load_files('autoload', true);


//--------------------------------------------------------------------------------------------
// Theme setup
//--------------------------------------------------------------------------------------------

function frame_theme_setup()
{
	//----------------------------------------------------------------------------------------
    // Languages
    //----------------------------------------------------------------------------------------

    load_theme_textdomain('theme', get_stylesheet_directory().'/languages');
    $locale = get_locale();
    $locale_file = get_stylesheet_directory().'/languages/'. $locale.'.php';
    if (is_readable($locale_file)) require_once($locale_file);


    //----------------------------------------------------------------------------------------
    // Theme support
    //----------------------------------------------------------------------------------------

    $features = frame_config('support');

    if (!empty($features))
    {
    	foreach ($features as $key => $value)
        {
            if (is_int($key))
                add_theme_support($value);
            else
                add_theme_support($key, $value);
        }
    }


    //----------------------------------------------------------------------------------------
    // Image sizes
    //----------------------------------------------------------------------------------------

    $image_sizes = frame_config('images');

    if (!empty($image_sizes))
    {
        foreach ($image_sizes as $key => $value)
        {
            $width = (!empty($value[0])) ? $value[0] : false;
            $height = (!empty($value[1])) ? $value[1] : false;
            $crop = (!empty($value[2])) ? $value[2] : false;

            if ($key == 'default_thumbnails')
                set_post_thumbnail_size($width, $height, $crop);
            else
                add_image_size($key, $width, $height, $crop);
        }
    }


    //----------------------------------------------------------------------------------------
    // TinyMCE editor style
    //----------------------------------------------------------------------------------------

    $editor_styles = frame_config('assets.editor_styles');

    if (!empty($editor_styles))
    {
        add_theme_support('editor-style');
        if (is_array($editor_styles))
            foreach ($editor_styles as $editor_style)
                add_editor_style($editor_style);
    }


    //----------------------------------------------------------------------------------------
    // Theme activation and deactivation functions
    //----------------------------------------------------------------------------------------

    $activation = frame_config('application.activation');
    if (!empty($activation) && function_exists($activation))
        add_action('after_switch_theme', $activation);

    $deactivation = frame_config('application.deactivation');
    if (!empty($deactivation) && function_exists($deactivation))
        add_action('switch_theme', $deactivation);
}

add_action('after_setup_theme', 'frame_theme_setup');


//--------------------------------------------------------------------------------------------
// Theme activation
//--------------------------------------------------------------------------------------------

function frame_switch_theme()
{
    // Flush rules
    flush_rewrite_rules(true);

    // Activation redirect
    $redirect = frame_config('application.activation_redirect');
    if (!empty($redirect)) wp_redirect($redirect);
}

add_action('after_switch_theme', 'frame_switch_theme');


//--------------------------------------------------------------------------------------------
// Assets
//--------------------------------------------------------------------------------------------

function frame_init_assets($enqueue = false)
{
    global $wp_styles;

    $action = (!empty($enqueue)) ? 'enqueue' : 'register';
    $assets = frame_config('assets');

    // d(frame_location());
    // wp_register_style( 'my-theme-ie', get_stylesheet_directory_uri() . "/css/ie.css");
    // $wp_styles->add_data( 'my-theme-ie', 'conditional', 'IE' );
    // wp_enqueue_style( 'my-theme-ie');

    // CSS
    if (!empty($assets['css']))
    {
        foreach($assets['css'] as $key => $asset)
        {
            $is_conditional = substr($key, 0, 2) === 'if';

            if ( is_numeric($key) || (is_string($key) && frame_location($key) || $is_conditional) )
                if (substr($asset[0], 0, 1) !== '_' && $action !== 'register')
                    call_user_func_array('wp_'.$action.'_style', frame_asset_version($asset));

            // Wrap the style into IE conditional comments if set
            if ($is_conditional && $action === 'enqueue')
            {
                $key = trim(str_replace('if', '', $key));
                $wp_styles->add_data($asset[0], 'conditional', $key);
            }
        }
    }

    // Javascript
    if (!empty($assets['javascript']))
        foreach($assets['javascript'] as $key => $asset)
            if ( is_numeric($key) || (is_string($key) && frame_location($key)) )
                if (substr($asset[0], 0, 1) !== '_' && $action !== 'register')
                    call_user_func_array('wp_'.$action.'_script', $asset);

    // Javascript data
    if (!empty($assets['javascript_data']))
        foreach($assets['javascript_data'] as $key => $asset)
            if ( is_numeric($key) || (is_string($key) && frame_location($key)) )
                call_user_func_array('wp_localize_script', $asset);

    // Load the comment reply script on singular posts with open comments if threaded comments are supported.
    if ($action === 'enqueue' && is_singular() && get_option('thread_comments') && comments_open() && frame_config('application.comments_trackbacks_support'))
        wp_enqueue_script('comment-reply');


    // if ($action == 'enqueue')
    // {
        // CSS
        // wp_enqueue_style('my-theme-ie', get_stylesheet_directory_uri().'/css/ie.css', array('theme'));
        // $wp_styles->add_data('my-theme-ie', 'conditional', 'IE');

        // Javascript
        // wp_enqueue_script('my-theme-ie', get_stylesheet_directory_uri() . "/js/ie.js");
        // $wp_scripts->add_data('my-theme-ie', 'conditional', 'IE');
        // wp_enqueue_script( 'jsFileIdentifier', get_stylesheet_directory_uri() . "/js/ie.js",  array('theme-scripts'));
        // $wp_scripts->add_data( 'jsFileIdentifier', 'conditional', 'lt IE 9' );
    // }
}

add_action('init', 'frame_init_assets');


function frame_init_enqueue_assets()
{
    // Tell the function to enqueue the assets, instead of registering them
    frame_init_assets(true);
}

add_action('wp_enqueue_scripts', 'frame_init_enqueue_assets');


/**
 * Automatically set the version for a given asset
 *
 */
function frame_asset_version($asset)
{
    $versioning = frame_config('assets.versioning');

    // Override the version only if not specifically set in the asset
    // if (isset($asset[3]) && ($asset[3] !== null || $asset[3] !== false))
    // if (isset($asset[3]) && is_string($asset[3]))
    // {
    if ($versioning)
    {
        $filename_versioning = frame_config('assets.filename_versioning');

        $version = (isset($asset[3])) ? $asset[3] : null;

        if ($version !== false)
            $version = (is_bool($versioning)) ? frame_config('application.version') : $versioning;

        // $version = (is_bool($versioning)) ? frame_config('application.version') : $versioning;
        // if (isset($asset[3]) && is_string($asset[3])) $version = $asset[3];

        if ($version)
        {
            $path = pathinfo($asset[1]);
            $extension = (isset($path['extension'])) ? $path['extension'] : '';

            if ($filename_versioning === true)
            {
                $asset[3] = null;
                $extension = remove_query_arg(array('ver'), $extension);
                $path['filename'] .= '.'.str_replace('.', '_', $version);

                // d($path, $version);
            }
            else
            {
                $extension = add_query_arg(array('ver' => $version), $extension);
            }

            $asset[1] = trailingslashit($path['dirname']).$path['filename'].'.'.$extension;
        }

        // d($path, $asset[1]);
        // d($asset);

        // $path = trailingslashit(dirname($asset[1]));
        // $url = explode('/', $asset[1]);
        // $filename = $filename[count($filename)-1];
        // $filename = explode('.', $url[count($url)-1]);

        // array_splice($filename, 1, 0, '213');

        // $filename = parse_url($asset[1], PHP_URL_PATH);
        // $filename = explode('&', $filename);

        // d(pathinfo($asset[1]), 'pathinfo');
        // d($url, 'url');
        // d($filename, $asset[1]);
    }

    return $asset;
}


//--------------------------------------------------------------------------------------------
// Show the custom image size labels in the dropdown when inserting media
//--------------------------------------------------------------------------------------------

function frame_init_show_image_sizes($sizes)
{
    $image_sizes = frame_config('images');
    $custom_sizes = array();

    if (!empty($image_sizes))
    {
        foreach ($image_sizes as $key => $value)
        {
            $label = (!empty($value[3])) ? $value[3] : false;
            if ($label) $custom_sizes[$key] = $label;
        }
    }

    return array_merge($sizes, $custom_sizes);
}

add_filter('image_size_names_choose', 'frame_init_show_image_sizes');


//--------------------------------------------------------------------------------------------
// Register theme menu locations
//--------------------------------------------------------------------------------------------

function frame_init_register_menu_locations()
{
    $menus = frame_config('menus');
    if (!empty($menus)) register_nav_menus($menus);
}

add_action('init', 'frame_init_register_menu_locations');


//--------------------------------------------------------------------------------------------
// Set Favicon
//--------------------------------------------------------------------------------------------

function frame_init_favicon()
{
    $application = frame_config('application');

    if (!empty($application['favicon']))
        echo '<link rel="shortcut icon" type="image/x-icon" href="'.$application['favicon'].'">';

    if (!empty($application['favicon_retina']))
        echo '<link rel="apple-touch-icon" href="'.$application['favicon_retina'].'">';
}

add_action('wp_head', 'frame_init_favicon');


//--------------------------------------------------------------------------------------------
// Register sidebars (aka widget areas)
//--------------------------------------------------------------------------------------------

function frame_init_widget_areas()
{
	$sidebars = frame_config('sidebars');

	if (!empty($sidebars))
		foreach ($sidebars as $sidebar)
			register_sidebar($sidebar);
}

add_action('widgets_init', 'frame_init_widget_areas');


//--------------------------------------------------------------------------------------------
// Deny access to wp-admin for specific user roles
//--------------------------------------------------------------------------------------------

function frame_init_no_admin_access()
{
    $redirect = isset($_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url('/');

    $allowed_roles = frame_config('admin.access');

    if (!empty($allowed_roles))
	    if (!frame_user_role($allowed_roles))
	        exit(wp_redirect($redirect));
}

add_action('admin_init', 'frame_init_no_admin_access', 100);


//--------------------------------------------------------------------------------------------
// Customise the TinyMCE editor
//--------------------------------------------------------------------------------------------

function frame_init_mce_buttons_2($buttons)
{
    $add_buttons = frame_config('editor.add_buttons');
    $remove_buttons = frame_config('editor.remove_buttons');

    if (!empty($add_buttons))
        foreach ($add_buttons as $button)
            $buttons[] = $button;

    if (!empty($remove_buttons))
        $buttons = array_diff($buttons, $remove_buttons);

    if (!empty(frame_config('editor.style_formats')))
        array_unshift($buttons, 'styleselect');

    return $buttons;
}

if (!empty(frame_config('editor')))
    add_filter('mce_buttons_2', 'frame_init_mce_buttons_2');

function frame_init_mce_custom_styles($init_array)
{
    $init_array['style_formats'] = json_encode(frame_config('editor.style_formats'));
    return $init_array;
}

if (!empty(frame_config('editor.style_formats')))
    add_filter('tiny_mce_before_init', 'frame_init_mce_custom_styles');


//--------------------------------------------------------------------------------------------
// Media library mime-types
//--------------------------------------------------------------------------------------------

function frame_init_mime_types($wp_mime_types)
{
    $mime_types = frame_config('admin.mime_types');
    // $mime_types['applescript'] = 'application/x-applescript'; //Adding applescript extension
    // $mime_types['avi'] = 'video/avi'; //Adding avi extension
    // unset($mime_types['pdf']); //Removing the pdf extension

    if (!empty($mime_types))
        foreach ($mime_types as $extension => $type)
            $wp_mime_types[$extension] = $type;

    return $wp_mime_types;
}

add_filter('upload_mimes', 'frame_init_mime_types', 1, 1);


//--------------------------------------------------------------------------------------------
// Enable/Disable admin bar
//--------------------------------------------------------------------------------------------

$admin_bar = frame_config('admin.admin_bar');

if ($admin_bar === false || (is_array($admin_bar) && !frame_user_role($admin_bar)))
    add_filter('show_admin_bar', '__return_false');


//--------------------------------------------------------------------------------------------
// Admin bar logo
//--------------------------------------------------------------------------------------------

function frame_init_admin_bar_logo()
{
    $admin_bar_logo = frame_config('admin.admin_bar_logo');

    if (!empty($admin_bar_logo))
        echo '<style type="text/css">#wp-admin-bar-wp-logo > .ab-item .ab-icon {background-image: url(' . $admin_bar_logo . ') !important; background-position: 0 0; } #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {background-position: 0 0; } </style>';

        // echo '<style type="text/css">#header-logo { background-image: url('.$application['admin_logo'].') !important; }</style>';
        // echo '<style type="text/css">#header-logo { background-image: url('.$application['admin_logo'].') !important; }</style>';
}

add_action('admin_head', 'frame_init_admin_bar_logo');




//--------------------------------------------------------------------------------------------
// Disable admin login CSS
//--------------------------------------------------------------------------------------------

if (frame_config('admin.default_login_css') === false)
{
    function frame_init_login_remove_scripts()
    {
        wp_deregister_style('wp-admin');
        wp_deregister_style('buttons');
        wp_deregister_style('open-sans');
        wp_deregister_style('dashicons');
        wp_deregister_style('login');
        wp_register_style('login', array()); // Fix to actually deregister the login css
    }

    add_action('login_init', 'frame_init_login_remove_scripts');
}


//--------------------------------------------------------------------------------------------
// Admin login logo
//--------------------------------------------------------------------------------------------

function frame_init_admin_login_logo()
{
    $admin_login_logo = frame_config('admin.admin_login_logo');

    if (!empty($admin_login_logo))
        echo '<style type="text/css">body.login div#login h1 a {background-image: url('.$admin_login_logo.'); } </style>';
}

add_action('login_enqueue_scripts', 'frame_init_admin_login_logo');


//--------------------------------------------------------------------------------------------
// Custom admin footer message
//--------------------------------------------------------------------------------------------

function frame_init_admin_footer()
{
    $admin_footer = frame_config('admin.admin_footer');
    if (!empty($admin_footer)) echo $admin_footer;
}

add_filter('admin_footer_text', 'frame_init_admin_footer');


//--------------------------------------------------------------------------------------------
// Remove comments and trackbacks support for specific post types
//--------------------------------------------------------------------------------------------

function frame_init_comments_trackbacks_support()
{
    $disabled_post_types = frame_config('application.comments_trackbacks_support');

    if (!empty($disabled_post_types))
    {
        $post_types = get_post_types();

        foreach ($post_types as $post_type)
        {
            if ( (is_array($disabled_post_types) && in_array($post_type, $disabled_post_types) && post_type_supports($post_type, 'comments')) || $disabled_post_types === true )
            {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }

        if (is_admin_bar_showing() && $disabled_post_types === true)
        {
            // Remove comments links from admin bar
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 50); // WP<3.3
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60); // WP 3.3
            if (is_multisite()) add_action('admin_bar_menu', 'frame_init_remove_network_comment_links', 500);
        }
    }
}

add_action('admin_init', 'frame_init_comments_trackbacks_support');

function frame_init_remove_network_comment_links($wp_admin_bar)
{
    $networkactive = (is_multisite() && array_key_exists(plugin_basename(__FILE__), (array) get_site_option('active_sitewide_plugins')));

    if ($networkactive)
    {
        foreach( (array) $wp_admin_bar->user->blogs as $blog )
            $wp_admin_bar->remove_menu( 'blog-'.$blog->userblog_id.'-c');
    }
    else
    {
        // We have no way to know whether the plugin is active on other sites, so only remove this one
        $wp_admin_bar->remove_menu( 'blog-'.get_current_blog_id().'-c');
    }
}


//--------------------------------------------------------------------------------------------
// Disable XMLRPC
//--------------------------------------------------------------------------------------------

if (frame_config('application.xmlrpc') === false)
{
    // Disable XMLRPC
    add_filter('xmlrpc_enabled', '__return_false');

    // Specifically disable the XMLRPC pingback
    function frame_init_remove_xmlrpc_pingback_ping($methods)
    {
       unset($methods['pingback.ping']);
       return $methods;
    }

    add_filter('xmlrpc_methods', 'frame_init_remove_xmlrpc_pingback_ping');
}


//--------------------------------------------------------------------------------------------
// Install plugins
//--------------------------------------------------------------------------------------------

function frame_init_register_required_plugins()
{
	$plugins = frame_config('plugins');

    if (!empty($plugins))
    {
        tgmpa($plugins);

        // foreach ($plugins as &$plugin)
        // {
        //     if (isset($plugin['silent_install']) && $plugin['silent_install'] === true)
        //     {
        //         $_GET['plugin'] = $plugin['slug'];
        //         $_GET['plugin_name'] = $plugin['name'];
        //         $_GET['plugin_source'] = $plugin['source'];
        //         $_GET['tgmpa-install'] = 'install-plugin';
        //         TGM_Plugin_Activation::$instance->do_plugin_install();
        //     }

        // }
    }
}

add_action('tgmpa_register', 'frame_init_register_required_plugins');


//----------------------------------------------------------------------------------------
// Files editor (Appearance > Editor)
//----------------------------------------------------------------------------------------

if (!defined('DISALLOW_FILE_EDIT') && frame_config('admin.files_editor') === false)
    define('DISALLOW_FILE_EDIT', true);


//----------------------------------------------------------------------------------------
// Post Revisions
//----------------------------------------------------------------------------------------

if (!defined('WP_POST_REVISIONS'))
    define('WP_POST_REVISIONS', frame_config('admin.post_revisions'));

