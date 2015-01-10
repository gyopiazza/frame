<?php

/**
 * Framework starting point
 *
 * @package tema
 */

// Load the debug functions file
require_once(locate_template('library/debug.php'));

// Load the helpers file
require_once(locate_template('library/helpers.php'));

// Load the plugins activation class
require_once(locate_template('library/plugin-activation.php'));


//--------------------------------------------------------------------------------------------
// Theme initialisation
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


    //----------------------------------------------------------------------------------------
    // Files editor (Appearance > Editor)
    //----------------------------------------------------------------------------------------
    
    if (frame_config('application.files_editor') === false)
        define('DISALLOW_FILE_EDIT', true);

}

add_action('after_setup_theme', 'frame_theme_setup');



//--------------------------------------------------------------------------------------------
// Automatically load files
//--------------------------------------------------------------------------------------------

// Scan for hooks and import them
$hooks = frame_load_files('hooks', true);


//--------------------------------------------------------------------------------------------
// Assets
//--------------------------------------------------------------------------------------------

function frame_assets($enqueue = false)
{
    $action = (!empty($enqueue)) ? 'enqueue' : 'register';
    $assets = frame_config('assets');

    if (!empty($assets['javascript']))
        foreach($assets['javascript'] as $asset)
            if (substr($asset[0], 0, 1) !== '_' && $action !== 'register')
                call_user_func_array('wp_'.$action.'_script', $asset);

    if (!empty($assets['css']))
        foreach($assets['css'] as $asset)
            if (substr($asset[0], 0, 1) !== '_' && $action !== 'register')
                call_user_func_array('wp_'.$action.'_style', $asset);

    if (!empty($assets['javascript_data']))
        foreach($assets['javascript_data'] as $asset)
            call_user_func_array('wp_localize_script', $asset);
}

add_action('init', 'frame_assets');

function frame_enqueue_assets()
{
    // Tell the function to enqueue the assets, instead of registering them
    frame_assets(true);
}

add_action('wp_enqueue_scripts', 'frame_enqueue_assets');


//--------------------------------------------------------------------------------------------
// Activation redirect
//--------------------------------------------------------------------------------------------


function frame_activation_redirect()
{
    $redirect = frame_config('application.activation_redirect');
    if (!empty($redirect)) wp_redirect($redirect);
    
}

add_action('after_switch_theme', 'frame_activation_redirect');


//--------------------------------------------------------------------------------------------
// Show custom image sizes in the dropdown when inserting media
//--------------------------------------------------------------------------------------------

function frame_show_image_sizes($sizes)
{
    $image_sizes = frame_config('images');
    $custom_sizes = array();

    frame_log($image_sizes);

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

add_filter('image_size_names_choose', 'frame_show_image_sizes');


// add_filter('image_size_names_choose', 'my_image_sizes');
// function my_image_sizes($sizes) {
//     $addsizes = array(
//         "full-hd" => __( "New Size")
//     );
//     $newsizes = array_merge($sizes, $addsizes);
//     return $newsizes;
// }


//--------------------------------------------------------------------------------------------
// Register theme menu locations
//--------------------------------------------------------------------------------------------

function frame_register_menu_locations()
{
    register_nav_menus(frame_config('menus'));
}

add_action('init', 'frame_register_menu_locations');


//--------------------------------------------------------------------------------------------
// Set Favicon
//--------------------------------------------------------------------------------------------

function frame_favicon_init()
{
    $application = frame_config('application');

    if (!empty($application['favicon']))
        echo '<link rel="shortcut icon" type="image/x-icon" href="'.$application['favicon'].'">';

    if (!empty($application['favicon_retina']))
        echo '<link rel="apple-touch-icon" href="'.$application['favicon_retina'].'">';
}

add_action('wp_head', 'frame_favicon_init');


//--------------------------------------------------------------------------------------------
// Register sidebars (aka widget areas)
//--------------------------------------------------------------------------------------------

function frame_widget_areas_init()
{
	$sidebars = frame_config('sidebars');

	if (!empty($sidebars))
		foreach ($sidebars as $sidebar)
			register_sidebar($sidebar);
}

add_action('widgets_init', 'frame_widget_areas_init');


//--------------------------------------------------------------------------------------------
// Deny access to wp-admin for specific user roles
//--------------------------------------------------------------------------------------------

function frame_no_admin_access()
{
    $redirect = isset($_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url('/');

    $allowed_roles = frame_config('application');

    if (!empty($allowed_roles['access']))
	    if (!frame_user_role($allowed_roles['access']))
	        exit(wp_redirect($redirect));
}

add_action('admin_init', 'frame_no_admin_access', 100);


//--------------------------------------------------------------------------------------------
// Admin bar logo
//--------------------------------------------------------------------------------------------

function frame_admin_bar_logo_init()
{
    $application = frame_config('application');

    if (!empty($application['admin_bar_logo']))
        echo '<style type="text/css">#wp-admin-bar-wp-logo > .ab-item .ab-icon {background-image: url(' . $application['admin_bar_logo'] . ') !important; background-position: 0 0; } #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {background-position: 0 0; } </style>';

        // echo '<style type="text/css">#header-logo { background-image: url('.$application['admin_logo'].') !important; }</style>';
        // echo '<style type="text/css">#header-logo { background-image: url('.$application['admin_logo'].') !important; }</style>';
}

add_action('admin_head', 'frame_admin_bar_logo_init');


//--------------------------------------------------------------------------------------------
// Admin login logo
//--------------------------------------------------------------------------------------------

function frame_admin_login_logo_init()
{
    $application = frame_config('application');
    
    if (!empty($application['admin_login_logo']))
        echo '<style type="text/css">body.login div#login h1 a {background-image: url('.$application['admin_login_logo'].'); } </style>';
}

add_action('login_enqueue_scripts', 'frame_admin_login_logo_init');


//--------------------------------------------------------------------------------------------
// Enable/Disable admin bar
//--------------------------------------------------------------------------------------------

$application = frame_config('application');

if (isset($application['admin_bar']))
{
    if ($application['admin_bar'] === false)
        add_filter('show_admin_bar', '__return_false');
    else if (is_array($application['admin_bar']) && !frame_user_role($application['admin_bar']))
        add_filter('show_admin_bar', '__return_false');
}


//--------------------------------------------------------------------------------------------
// Remove comments and trackbacks support for specific post types
//--------------------------------------------------------------------------------------------

function frame_remove_comments_support()
{
    $disabled_post_types = frame_config('application.remove_comments_support');

    if (!empty($disabled_post_types))
    {
        $post_types = get_post_types();

        foreach ($post_types as $post_type)
        {
            if (in_array($post_type, $disabled_post_types) && post_type_supports($post_type, 'comments'))
            {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    }
}

add_action('admin_init', 'frame_remove_comments_support');


//--------------------------------------------------------------------------------------------
// Custom admin footer message
//--------------------------------------------------------------------------------------------

function frame_admin_footer()
{
    $application = frame_config('application');

    if (!empty($application['admin_footer']))
        echo $application['admin_footer'];
}

add_filter('admin_footer_text', 'frame_admin_footer');


//--------------------------------------------------------------------------------------------
// Install plugins
//--------------------------------------------------------------------------------------------

function frame_register_required_plugins()
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

add_action('tgmpa_register', 'frame_register_required_plugins');





