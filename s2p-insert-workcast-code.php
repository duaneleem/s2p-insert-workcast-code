<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://duaneleem.com
 * @since             1.0.0
 * @package           S2P_Insert_WorkCast_Code
 *
 * @wordpress-plugin
 * Plugin Name:       S2P Insert WorkCast Code
 * Plugin URI:        https://github.com/duaneleem/s2p-insert-workcast-code
 * Description:       Turns any page to a WorkCast page.
 * Version:           1.0.0
 * Author:            Duane Leem
 * Author URI:        https://duaneleem.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       s2p-insert-workcast-code
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

/*
  * Executes S2P Insert WorkCast Code plugin.
  */
function runWorkCastCode() {
  require plugin_dir_path( __FILE__ ) . 'library/PageTemplater.php';

  require plugin_dir_path( __FILE__ ) . 'library/StpInjectAssets.php';
  new StpInjectAssets();
}
runWorkCastCode();