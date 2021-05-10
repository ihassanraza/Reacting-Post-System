<?php
/**
 * Plugin Name:       Reacting Post System
 * Plugin URI:        https://www.wp-sqr.com/
 * Description:       RPS is reacting for the posts.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            WP Square
 * Author URI:        https://www.wp-sqr.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       RPS
 * 
 * 
 *  @package racting-post-system
 */

/**
 * Exit if accessed directlyS.
 *
 * @since   1.0.0
 */
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin folder path.
 *
 * @since   1.0.0
 */  
if( !defined('RPS_PLUGIN_DIR') ) {
	define( 'RPS_PLUGIN_DIR', wp_normalize_path( plugin_dir_path( __FILE__ ) ) );
}

/**
 * Plugin Folder URL.
 *
 * @since   1.0.0
 */
if ( ! defined( 'RPS_PLUGIN_URL' ) ) {
	define( 'RPS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

include 'functions.php';

/**
 * Enqueue the scripts file.
 *
 * @since   1.0.0
 */
add_action( 'wp_enqueue_scripts', 'ldp_enqueue_files' );
function ldp_enqueue_files() {
	wp_enqueue_style( 'custom-RPS', RPS_PLUGIN_URL . '/assests/css/RPS.css' );
	wp_enqueue_script( 'custom-RPS', RPS_PLUGIN_URL . '/assests/js/RPS.js', array('jquery') );
	wp_localize_script( 'custom-RPS', 'rps_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

/**
 * Creating Post Reacting Tables.
 *
 * @since   1.0.0
 */
register_activation_hook( __FILE__, 'rps_reacting_table' );
function rps_reacting_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "rps_reacting_system";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        user_name tinytext NOT NULL,
        post_id mediumint(9) NOT NULL,
        reacting_love_count mediumint(9) NOT NULL,
		reacting_like_count mediumint(9) NOT NULL,
		reacting_ok_count mediumint(9) NOT NULL,
		reacting_dislike_count mediumint(9) NOT NULL,
		reacting_hate_count mediumint(9) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}