<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Segmalog.com
 * @since             1.0.0
 * @package           Woocommerce_Shipping_Company
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Shipping Company
 * Plugin URI:        Segmalog.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Segmalog
 * Author URI:        Segmalog.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-shipping-company
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
define( 'WOOCOMMERCE_SHIPPING_COMPANY_VERSION', '1.0.0' );
define( 'WOOCOMMERCE_SHIPPING_COMPANY_URL', plugin_dir_url(__FILE__) );
define( 'WOOCOMMERCE_SHIPPING_COMPANY_PATH', plugin_dir_path( __FILE__ )  );
define( 'WP_CURRENT_THIS_PLUGIN_URL', plugin_dir_url(__FILE__) );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-shipping-company-activator.php
 */
function activate_woocommerce_shipping_company() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-shipping-company-activator.php';
	Woocommerce_Shipping_Company_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-shipping-company-deactivator.php
 */
function deactivate_woocommerce_shipping_company() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-shipping-company-deactivator.php';
	Woocommerce_Shipping_Company_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_shipping_company' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_shipping_company' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-shipping-company.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_shipping_company() {

	$plugin = new Woocommerce_Shipping_Company();
	$plugin->run();

}
run_woocommerce_shipping_company();
