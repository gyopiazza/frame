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


