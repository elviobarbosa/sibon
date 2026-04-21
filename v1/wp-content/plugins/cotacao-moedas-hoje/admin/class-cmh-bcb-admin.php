<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.migueldaipre.com.br
 * @since      1.0.0
 *
 * @package    Cmh_Bcb
 * @subpackage Cmh_Bcb/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cmh_Bcb
 * @subpackage Cmh_Bcb/admin
 * @author     Miguel Ninno Daipré <contato@migueldaipre.com.br>
 */
class Cmh_Bcb_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cmh_Bcb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cmh_Bcb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cmh-bcb-admin.css', array('wp-color-picker'), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cmh_Bcb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cmh_Bcb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cmh-bcb-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );

	}

	/**
	*
	* 
	*
	**/

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

		/*
		* Add a settings page for this plugin to the Settings menu.
		*
		* NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		*
		*        Administration Menus: http://codex.wordpress.org/Administration_Menus
		*
		*/
		add_options_page( 'Cotação Moedas', 'Cotação Moedas', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links($links) {

		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);
		return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
		include_once( 'partials/cmh-bcb-admin-display.php' );
	}


	/**
	*
	* admin/class-wp-cbf-admin.php
	*
	**/
	public function validate($input) {
	    // All checkboxes inputs        
	    $valid = array();

		//Inputs CHM
		$valid['active'] = (isset($input['active']) && !empty($input['active'])) ? 1 : 0;
	    $valid['usd'] = (isset($input['usd']) && !empty($input['usd'])) ? 1 : 0;
	   	$valid['eur'] = (isset($input['eur']) && !empty($input['eur'])) ? 1 : 0;
		$valid['jpy'] = (isset($input['jpy']) && !empty($input['jpy'])) ? 1 : 0;
		
		
		// ColorPickers
		// Login Customization
		// item_background_color
		$valid['item_background_color'] = (isset($input['item_background_color']) && !empty($input['item_background_color'])) ? sanitize_text_field($input['item_background_color']) : '';

		if ( !empty($valid['item_background_color']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['item_background_color']  ) ) { // if user insert a HEX color with #
			add_settings_error(
					'item_background_color',                     // Setting title
					'item_background_color_texterror',            // Error ID
					'Por favor, preencha um valor Hexadecimal válido',     // Error message
					'error'                         // Type of message
			);
		}

		//Background barra
		$valid['plugin_background_color'] = (isset($input['plugin_background_color']) && !empty($input['plugin_background_color'])) ? sanitize_text_field($input['plugin_background_color']) : '';

		if ( !empty($valid['plugin_background_color']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['plugin_background_color']  ) ) { // if user insert a HEX color with #
			add_settings_error(
					'plugin_background_color',                     // Setting title
					'plugin_background_color_texterror',            // Error ID
					'Por favor, preencha um valor Hexadecimal válido',     // Error message
					'error'                         // Type of message
			);
		}

	    return $valid;
	}

	/**
	*
	* admin/class-wp-cbf-admin.php
	*
	**/
	public function options_update() {
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}

}
