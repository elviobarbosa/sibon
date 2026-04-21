<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.migueldaipre.com.br
 * @since      1.0.0
 *
 * @package    Cmh_Bcb
 * @subpackage Cmh_Bcb/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cmh_Bcb
 * @subpackage Cmh_Bcb/includes
 * @author     Miguel Ninno Daipré <contato@migueldaipre.com.br>
 */
class Cmh_Bcb_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cmh-bcb',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
