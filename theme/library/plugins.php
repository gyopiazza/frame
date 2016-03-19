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




////////////////////////////


// TGMP HACK for plugins automatic installation


function my_init()
{
    // echo '<pre>';
    // print_r(debug_backtrace());
    // echo '</pre>';

    // d('test');
}

add_action('init', 'my_init');


///

// Fetches the original plugins configuration and returns
// the plugins with 'auto_install' => true
function frame_automatic_get_plugins()
{
    $plugins_config = TGM_Plugin_Activation::get_instance();
    $plugins_config = !empty($plugins_config->plugins) ? $plugins_config->plugins : array();
    $plugins = array();

    foreach ($plugins_config as $slug => $plugin)
        if (!empty($plugin['auto_install']))
            $plugins[] = $slug;

    return $plugins;
}


// !!!!????!!!!!
// TODO: instead of changing input values, try appending hidden elements to the form...

// Usage:
//
// Copy the 2 functions below into your theme.
//
// Add the 'auto_install' attribute when registering the plugins:
//
// array(
//     'name'               => 'Some Plugin',
//     'slug'               => 'someplugin',
//     'silent_install'     => true,
//     'auto_install'       => true, // Automatically install and activate the plugin
// ),
//
// Then create a link for your users inside a notification or anywhere, pointing to:
// wp-admin/themes.php?page=tgmpa-install-plugins&autoaction=install
//
// The JS code will simulate the user interacion and install/activate
// the plugins with the 'auto_install' attribute previously set
//
// To help mitigate the redirects behavior, the g_automatic_plugins_loading()
// hook will cover the screen with a white div.
//
// Ideally, the TGMPA page could be loaded in a iframe, giving the users
// a better experience.


function frame_automatic_plugins_activation()
{
    // Stop execution if not in the tgmpa-install-plugins page
    if (empty($_GET['page']) || $_GET['page'] !== 'tgmpa-install-plugins')
        return;

    // Solution 1: create an array from the plugins $_GET parameter
    // $plugins = (!empty($_GET['plugins'])) ? $_GET['plugins'] : false;

    // Solution 2: get the information from the config
    $plugins_config = TGM_Plugin_Activation::get_instance();
    $plugins_config = !empty($plugins_config->plugins) ? $plugins_config->plugins : array();
    $plugins = array();

    foreach ($plugins_config as $slug => $plugin)
        if (!empty($plugin['auto_install']))
            $plugins[] = $slug;

    // Stop execution if no plugins have to be installed
    if (empty($plugins)) return;

    // Go on with the JS...
    ?>

    <script type="text/javascript">
        (function() {

            // Stop if there is an error message
            if (jQuery('#message.error').length > 0) { return; }

            // The script proceeds only if the 'autoaction' is set
            var autoaction = <?php echo (!empty($_GET['autoaction'])) ? '"'.$_GET['autoaction'].'"' : 'false'; ?>;
            if (!autoaction) return;

            var form = jQuery('#tgmpa-plugins');

            if (form.length <= 0) {
                setTimeout(function(){
                    if (autoaction == 'install') {
                        // Solution 1
                        // window.location.replace('<?php /*echo admin_url("themes.php?page=tgmpa-install-plugins&autoaction=activate&plugins=$plugins");*/ ?>');
                        // Solution 2
                        window.location.replace('<?php echo admin_url("themes.php?page=tgmpa-install-plugins&autoaction=activate"); ?>');
                    }
                }, 500);
                return;
            }

            // Create a JS array from the PHP $plugins
            // var plugins = '<?php /*echo $plugins;*/ ?>'.split(','); // Solution 1
            var plugins = "<?php echo implode(',', $plugins); ?>".split(','); // Solution 2

            // console.log('plugins', plugins);

            var input, parent;

            // Check all the selected plugins
            for (var i=0, len=plugins.length; i<len; i++) {
                input = jQuery('input[value="'+plugins[i]+'"]');
                parent = input.parents('tr').first;
                input.prop('checked', true);
            }

            // If there are plugins to install/activatre, change the 'action' select and submit the form
            if (jQuery('input[type=checkbox]:checked', form).length > 0) {
                jQuery('select[name="action"]', form).val('tgmpa-bulk-'+autoaction);
                form.submit();
            // All the plugins have been properly installed and activated
            } else if (autoaction == 'activate') {
                window.location.replace("<?php echo admin_url('plugins.php') ?>");
            }

        })();
    </script>

    <?php
}

add_action('in_admin_footer', 'frame_automatic_plugins_activation');



function frame_automatic_plugins_loading()
{
    // Stop execution if not in the tgmpa-install-plugins page
    if (empty($_GET['page']) || $_GET['page'] !== 'tgmpa-install-plugins' || empty($_GET['autoaction']))
        return;

    // Create an array from the plugins $_GET parameter
    // $plugins = (!empty($_GET['plugins'])) ? $_GET['plugins'] : false;

    // Stop execution if no plugins have to be installed
    // if ($plugins === false) return;

?>
    <style>
        #plugins-loading-box {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999999999999;
            padding: 50px;
            background-color: #fff;
        }
    </style>

    <div id="plugins-loading-box">Installing plugins...</div>

<?php
}

add_action('admin_head', 'frame_automatic_plugins_loading');




function frame_autoinstall_plugins()
{
    // Stop execution if not in the tgmpa-install-plugins page
    if (empty($_GET['page']) || $_GET['page'] !== 'tgmpa-install-plugins') return;
    // return;

    $post_data = array();
    $post_data['action'] = 'tgmpa-bulk-install';
    $post_data['plugin'] = frame_automatic_get_plugins();

    // foreach ($post_data as $key => $value)
        // $post_items[] = $key . '=' . $value;

    // $post_string = implode ('&', $post_items);

    $post_string = http_build_query($post_data);

    $curl_connection = curl_init(admin_url('themes.php?page=tgmpa-install-plugins'));
    // $curl_connection = curl_init(admin_url('http://localhost'.parse_url(get_admin_url(), PHP_URL_PATH)));

    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);

    curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);

    $result = curl_exec($curl_connection);
    //curl_close($curl_connection);
    // var_dump($result);
    frame_log($result);

    echo '<pre>';
    print_r(curl_getinfo($curl_connection));
    echo '</pre>';
}


// add_action('admin_init', 'frame_autoinstall_plugins');


