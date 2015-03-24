

Useful links:
- http://jayj.dk/using-grunt-automate-theme-releases
- https://github.com/justintadlock/hybrid-core
- https://github.com/use-init/init
- https://github.com/FlagshipWP/compass
- https://github.com/justintadlock/get-the-image
- https://github.com/UpTrendingLLC/WP-Scaffolding


---


[PRIO A]

[ ] IMPORTANT: Include grunt-newer in the tasks

[ ] Add 'environments' to the config files to load different files depending on the environment (especially useful for assets dev/live)

[ ] Add 'social sharing' links helper (from pins), also launch them in a popup (magnific popup)

[ ] Add automatic styleguide generator

[ ] Add automatic documentation generator

[ ] Add example widget to 'widgets'

[x] Add application.version to the js/css assets

[x] Add IE conditional assets loading (http://www.quirksmode.org/css/condcom.html)

[ ] Implement – somehow – the rewrite rules from pins

[ ] Fix admin_bar_logo

[ ] Change config.menus to support location (make an array of id and label)

[ ] Add custom pointers (help tooltips)
http://wpsnipp.com/index.php/functions-php/add-custom-pointers-in-themes-and-plugins/

[ ] Overwrite the ‘jquery’ js if $handle == jquery ... wp_deregister_script('jquery');

[ ] Add Travis CI support: https://github.com/xwp/wp-dev-lib


---


[PRIO B]

Reorganize files/folder... maybe move everything inside a "frame" folder?
Separate 'helpers' into api and helpers (?)

Add some plugins for development (duplicate post, regenerate thumbnails, cache, auto optimize, debug bar...)
Maybe move the 'plugins' folder inside 'library'

Add login background image option (or hook), or better add an admin_login_css file to be loaded

Move hooks.images_quality to config.media

Test functions conflict by duplicating the theme and launching the customizer

Add support for Polylang in helpers/frame_segments

Add cron config (?)

Rename all the hook functions to 'frame_hook_function_name'

Set application.version to the theme version by default, fetched from style.css
$my_theme = wp_get_theme(); $version = str_replace('.','_',$my_theme->get( 'Version' ));

Add: Restricting users to view only media library items they upload
http://wpsnipp.com/index.php/functions-php/restricting-users-to-view-only-media-library-items-they-upload/

Add theme automatic updates:
http://code.tutsplus.com/tutorials/create-a-license-controlled-theme-and-plugin-update-system-part-1-the-license-manager-plugin--cms-22621

Put the SASS files into css/source (as for ‘js’)

Change admin.post_revision config to allow for an array of ['post_type' => X] values:
http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_revisions_to_keep

Implement some snippets from: https://github.com/roots/roots-snippets (?)

Add some snippets that can only be applied manually on a WP install (wp-config, htaccess etc...)
Change default media path/url.
Create htaccess with usefulness like limiting access by IP, maintenance mode...


---


TO CHECK:

Check if application.comments_trackbacks_support works properly

Test/Modify 'theme activation' page from roots (https://github.com/roots/roots/tree/master/lib)

Add gruntfile and prepare for SASS (check skyline.is and inuit)

Test editor.add_buttons

Check frame_location('post_id=123') in the admin (and various scenarios like for post_type)


