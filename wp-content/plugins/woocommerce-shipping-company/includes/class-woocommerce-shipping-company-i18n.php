<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       Segmalog.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Shipping_Company
 * @subpackage Woocommerce_Shipping_Company/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Shipping_Company
 * @subpackage Woocommerce_Shipping_Company/includes
 * @author     Segmalog <contact@segmalog.com>
 */
class Woocommerce_Shipping_Company_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-shipping-company',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
