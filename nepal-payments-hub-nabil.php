<?php
/**
 * Plugin Name: Nepal Payments Hub - Nabil
 * Description: Accept international payments from Credit Cards (Visa, Mastercard, UnionPay) via your Nabil Bank Merchant
 * Requires Plugins: woocommerce
 * Version: 1.0.0
 * Author: Nepal Payments Hub
 * Author URI: https://nepalpaymentshub.com
 * Text Domain: nepal-payments-hub-nabil
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Plugin.
 *
 * @package    Add Nabil Bank Payment In WooCommerce
 * @author     Nepal Payments Hub
 * @since      1.0.0
 *
 * @license    GPL-3.0+ @see https://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) || die();

/**
 * Plugin constants.
 *
 * @since 1.0.0
 */
define( 'NPHN_PAYMENT_FOR_WOOCOMMERCE_PLUGIN_FILE', __FILE__ );
define( 'NPHN_PAYMENT_FOR_WOOCOMMERCE_PLUGIN_PATH', __DIR__ );
define( 'NPHN_PAYMENT_FOR_WOOCOMMERCE_VERSION', '1.0.0' );

add_action(
	'plugins_loaded',
	function() {

		// Return if WooCommerce is not installed.
		if ( ! defined( 'WC_VERSION' ) ) {
			return;
		}

		require_once __DIR__ . '/src/Plugin.php';
	}
);

add_filter( 'woocommerce_payment_gateways', 'nphn_payment_for_woocommerce' );

/**
 * Add Nabil Bank gateway to WooCommerce.
 *
 * @param  array $methods WooCommerce payment methods.
 *
 * @since 1.0.0
 *
 * @return array Payment methods including Nabil Bank.
 */
function nphn_payment_for_woocommerce( $methods ) {
	$methods[] = 'WC_Gateway_Nabil_Bank';

	return $methods;
}
