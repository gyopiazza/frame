<?php

// Load the core Frame files, each element can be disabled in a child theme
// by defining the relevant constants

// Load the debug functions file
if (!defined('FRAME_LOAD_DEBUG') || FRAME_LOAD_DEBUG !== false)
    locate_template('library/debug.php', true, true);

// Load the helper functions file
if (!defined('FRAME_LOAD_HELPERS') || FRAME_LOAD_HELPERS !== false)
    locate_template('library/helpers.php', true, true);

// Load the helper aliases file
if (!defined('FRAME_LOAD_ALIASES') || FRAME_LOAD_ALIASES !== false)
    locate_template('library/aliases.php', true, true);

// Load the plugins activation class
if (!defined('FRAME_LOAD_PLUGINS_ACTIVATION') || FRAME_LOAD_PLUGINS_ACTIVATION !== false)
    locate_template('library/plugins-activation.php', true, true);

// Load the theme activation file
// if (!defined('FRAME_LOAD_THEME_ACTIVATION') || FRAME_LOAD_THEME_ACTIVATION !== false)
    // locate_template('library/theme-activation.php', true, true);

// Load the Frame initialisation file (requires the helpers)
if ( (!defined('FRAME_LOAD_INIT') || FRAME_LOAD_INIT !== false) &&
     (!defined('FRAME_LOAD_HELPERS') || FRAME_LOAD_HELPERS !== false) )
    locate_template('library/init.php', true, true);


// Place your code below here...


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


