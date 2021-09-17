<?php
/*
Plugin Name: Km Services
Plugin URI: https://kienxmedia.com/
Description: This Plugin Is used to show Services
Version: 0.0.1
Author: Kinexmedia
Author URI: https://kinexmedia
License: GPLv2 or later
Text Domain: km-services
*/
define( 'KMCPT_VERSION', '0.0.1' );
define( 'KMCPT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, array( 'KMCPT', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'KMCPT', 'plugin_deactivation' ) );
register_activation_hook( __FILE__, 'create_plugin_database_table' );
register_activation_hook(__FILE__, 'create_plugin_database_table');
require_once( KMCPT_PLUGIN_DIR . 'class.kmcpt.php' );

global $kmcpt;
add_action('init', array( $kmcpt, 'init' ));
