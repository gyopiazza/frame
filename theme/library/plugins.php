<?php

function frame_get_plugins($plugins)
{
    $args = array(
        'path' => ABSPATH.'wp-content/plugins/',
        'preserve_zip' => false
    );

    foreach($plugins as $plugin)
    {
        // frame_plugin_download($plugin['path'], $args['path'].$plugin['name'].'.zip');
        frame_plugin_copy($plugin['path'], $args['path'].$plugin['name'].'.zip');
        frame_plugin_unpack($args, $args['path'].$plugin['name'].'.zip');
        frame_plugin_activate($plugin['install']);
    }
}

function frame_plugin_download($url, $path)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    if (file_put_contents($path, $data))
        return true;
    else
        return false;
}

function frame_plugin_copy($plugin, $path)
{
    copy($plugin, $path);
}

function frame_plugin_unpack($args, $target)
{
    if($zip = zip_open($target))
    {
            while($entry = zip_read($zip))
            {
                    $is_file = substr(zip_entry_name($entry), -1) == '/' ? false : true;
                    $file_path = $args['path'].zip_entry_name($entry);
                    if($is_file)
                    {
                            if(zip_entry_open($zip,$entry,"r"))
                            {
                                    $fstream = zip_entry_read($entry, zip_entry_filesize($entry));
                                    file_put_contents($file_path, $fstream );
                                    chmod($file_path, 0777);
                                    //echo "save: ".$file_path."<br />";
                            }
                            zip_entry_close($entry);
                    }
                    else
                    {
                            if(zip_entry_name($entry))
                            {
                                    mkdir($file_path);
                                    chmod($file_path, 0777);
                                    //echo "create: ".$file_path."<br />";
                            }
                    }
            }
            zip_close($zip);
    }

    if($args['preserve_zip'] === false)
    {
        unlink($target);
    }
}

function frame_plugin_activate($installer)
{
    require_once ABSPATH . 'wp-admin/includes/plugin.php'; // Need for plugins_api.
    require_once ABSPATH . 'wp-admin/includes/plugin-install.php'; // Need for plugins_api.
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php'; // Need for upgrade classes.

    $current = get_option('active_plugins');
    $plugin = plugin_basename(trim($installer));

    activate_plugin($installer, $redirect = '', false, false);

    // if (!in_array($plugin, $current))
    // {
    //     $current[] = $plugin;
    //     sort($current);
    //     do_action('activate_plugin', trim($plugin));
    //     update_option('active_plugins', $current);
    //     do_action('activate_'.trim($plugin));
    //     do_action('activated_plugin', trim($plugin));
    //     return true;
    // }
    // else
    //     return false;
}
