<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.migueldaipre.com.br
 * @since             1.0.2
 * @package           Cmh_Bcb
 *
 * @wordpress-plugin
 * Plugin Name:       Cotação Moedas Hoje
 * Plugin URI:        https://github.com/migueldaipre/wp-cotacao-moedas-hoje
 * Description:       Cotação de Moedas do dia atualizadas diretamente do site do Banco Central do Brasil.
 * Version:           1.0.2
 * Author:            Miguel Ninno Daipré
 * Author URI:        www.migueldaipre.com.br
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cmh-bcb
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cmh-bcb-activator.php
 */
function activate_cmh_bcb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cmh-bcb-activator.php';
	Cmh_Bcb_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cmh-bcb-deactivator.php
 */
function deactivate_cmh_bcb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cmh-bcb-deactivator.php';
	Cmh_Bcb_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cmh_bcb' );
register_deactivation_hook( __FILE__, 'deactivate_cmh_bcb' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cmh-bcb.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cmh_bcb() {

	$plugin = new Cmh_Bcb();
	$plugin->run();

}
run_cmh_bcb();
