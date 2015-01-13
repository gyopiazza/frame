<?php

/**
 * Plugins
 *
 * Automatically install plugins on theme activation
 *
 * @link http://tgmpluginactivation.com
 *
 * @package frame
 */

return array(

    // This is an example of how to include a plugin pre-packaged with a theme.
    array(
        'name'               => 'Notifier', // The plugin name.
        'slug'               => 'notifier', // The plugin slug (typically the folder name).
        'source'             => get_template_directory() . '/plugins/notifier.zip', // The plugin source.
        'silent_install'     => true,
        'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        'external_url'       => '', // If set, overrides default API URL and points to an external URL.
    ),

    // This is an example of how to include a plugin pre-packaged with a theme.
    // array(
    //     'name'               => 'TGM Example Plugin', // The plugin name.
    //     'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
    //     'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
    //     'required'           => true, // If false, the plugin is only 'recommended' instead of required.
    //     'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
    //     'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
    //     'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
    //     'external_url'       => '', // If set, overrides default API URL and points to an external URL.
    // ),

    // // This is an example of how to include a plugin from a private repo in your theme.
    // array(
    //     'name'               => 'TGM New Media Plugin', // The plugin name.
    //     'slug'               => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
    //     'source'             => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
    //     'required'           => true, // If false, the plugin is only 'recommended' instead of required.
    //     'external_url'       => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
    // ),

    // This is an example of how to include a plugin from the WordPress Plugin Repository.
    array(
        'name'             => 'Debug Bar',
        'slug'             => 'debug-bar',
        'required'         => false,
        'force_activation' => true,
    ),

    array(
        'name'             => 'Theme Check',
        'slug'             => 'theme-check',
        'required'         => false,
        'force_activation' => true,
    ),

    array(
        'name'             => 'Themeforest Check',
        'slug'             => 'themeforest-check',
        'required'         => false,
        'force_activation' => true,
    ),

);
