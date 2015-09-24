##PRIO A

- [x] IMPORTANT: Include grunt-newer in the tasks

- [ ] Add 'environments' to the config files to load different files depending on the environment (especially useful for assets dev/live)

- [ ] Add 'social sharing' links helper (from pins), also launch them in a popup (magnific popup)

- [ ] Add automatic styleguide generator

- [ ] Add automatic documentation generator

- [ ] Add example widget to 'widgets'

- [x] Add application.version to the js/css assets

- [x] Add IE conditional assets loading (http://www.quirksmode.org/css/condcom.html)

- [ ] Implement – somehow – the rewrite rules from pins

- [ ] Fix admin_bar_logo

- [x] Change config.menus to support location (make an array of id and label)

- [ ] Add custom pointers (help tooltips) http://wpsnipp.com/index.php/functions-php/add-custom-pointers-in-themes-and-plugins/

- [ ] Allow to override the default ‘jquery’ js if $handle == jquery ... wp_deregister_script('jquery');

- [ ] Add Travis CI support: https://github.com/xwp/wp-dev-lib

- [ ] Add data import on theme activation or on demand (by using a php file, instead of the standard import process)


---


##PRIO B

- [ ] Reorganize files/folder... maybe move everything inside a "frame" folder?
Separate 'helpers' into api and helpers (?)

- [ ] Add some plugins for development (duplicate post, regenerate thumbnails, cache, auto optimize, debug bar...)
Maybe move the 'plugins' folder inside 'library'

- [ ] Add login background image option (or hook), or better add an admin_login_css file to be loaded

- [ ] Move hooks.images_quality to config.media

- [ ] Test functions conflict by duplicating the theme and launching the customizer

- [ ] Add support for Polylang in helpers/frame_segments

- [ ] Add cron config (?)

- [ ] Rename all the hook functions to 'frame_hook_function_name'

- [ ] Set application.version to the theme version by default, fetched from style.css
$my_theme = wp_get_theme(); $version = str_replace('.','_',$my_theme->get( 'Version' ));

- [ ] Add: Restricting users to view only media library items they upload
http://wpsnipp.com/index.php/functions-php/restricting-users-to-view-only-media-library-items-they-upload/

- [ ] Add theme automatic updates:
http://code.tutsplus.com/tutorials/create-a-license-controlled-theme-and-plugin-update-system-part-1-the-license-manager-plugin--cms-22621

- [x] Put the SASS files into css/source (as for ‘js’)

- [ ] Change admin.post_revision config to allow for an array of ['post_type' => X] values:
http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_revisions_to_keep

- [ ] Add some snippets that can only be applied manually on a WP install (wp-config, htaccess etc...)
Change default media path/url.
Create htaccess with usefulness like limiting access by IP, maintenance mode...

- [ ] Double check: application.comments_trackbacks_support
It says an array of post types to disable on... it should be reversed or using the prepended '_'

- [ ] Make assets.editor_styles conditional
https://gist.github.com/gyopiazza/9d49b54124a3de63771c

- [ ] Create basic maintenance.php & db-error.php pages (they need to be placed into wp-content/)
http://alisothegeek.com/2011/01/custom-maintenance-and-database-error-pages-in-wordpress/

- [ ] Add get_queried_object_id() to $post_id in frame_location #304

- [ ] Remove application.version and use the one from style.css

- [ ] Maybe rename config.application to config.theme

- [ ] Add 'client' (dalekjs) and 'server' (pick a php test lib) inside tests to differentiate the types

- [ ] Add custom admin color schemes
https://www.domsammut.com/code/add-a-custom-admin-colour-scheme-in-wordpress

- [ ] Add the ability to declare a function name for conditional loading assets, to allow for more advanced checks

---


##TO CHECK:

Check if application.comments_trackbacks_support works properly

Test/Modify 'theme activation' page from roots (https://github.com/roots/roots/tree/master/lib)

Add gruntfile and prepare for SASS (check skyline.is and inuit)

Test editor.add_buttons

Check frame_location('post_id=123') in the admin (and various scenarios like for post_type)
Check frame_location('slug=something')

Check the is_tree() function:
https://github.com/chriscoyier/css-tricks-functionality-plugin/blob/master/includes/template-functions.php#L86

Implement some snippets from: https://github.com/roots/roots-snippets (?)



###Useful links:
- http://jayj.dk/using-grunt-automate-theme-releases
- https://github.com/justintadlock/hybrid-core
- https://github.com/use-init/init
- https://github.com/FlagshipWP/compass
- https://github.com/justintadlock/get-the-image
- https://github.com/UpTrendingLLC/WP-Scaffolding


###Development plugins:
– Debug Bar
– Debug Bar Extender
– Rewrite Rules Inspector
– Log Deprecated Notices
– Regenerate Thumbnails
– Theme Check
– ThemeForest-Check
– Theme Mentor


