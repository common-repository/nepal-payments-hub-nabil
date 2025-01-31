<?php
/**
 * Payment gateway - Nabil Bank
 *
 * Provides a Nabil Bank Payment Gateway.
 *
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * WC_Gateway_Nabil_Bank Class.
 */
class WC_Gateway_Nabil_Bank extends WC_Payment_Gateway {

	/**
	 * Whether or not logging is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @var boolean
	 */
	public static $log_enabled = false;

	/**
	 * A log object returned by wc_get_logger().
	 *
	 * @since 1 .0.0
	 *
	 * @var boolean
	 */
	public static $log = false;

	/**
	 * Constructor for the gateway.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->id                 = 'nabil-bank';
		$this->has_fields         = false;
		$this->order_button_text  = __( 'Proceed to Payment', 'nepal-payments-hub-nabil' );
		$this->method_title       = __( 'Nabil Bank', 'nepal-payments-hub-nabil' );
		$this->method_description = __( 'Secure Payment by International Credit/Debit Visa, Mastercard or UnionPay.', 'nepal-payments-hub-nabil' );

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables.
		$this->title       = $this->get_option( 'title' );
		$this->description = $this->get_option( 'description' );
		$this->debug       = 'yes' === $this->get_option( 'debug', 'no' );
		$this->merchant_id = $this->get_option( 'merchant_id' );

		// Enable logging for events.
		self::$log_enabled = $this->debug;

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

		if ( ! $this->is_valid_for_use() ) {
			$this->enabled = 'no';
		} elseif ( $this->merchant_id ) {
			include_once NB_PAYMENT_FOR_WOOCOMMERCE_PLUGIN_PATH . '/src/Response.php';
			new \NPHN_PaymentForWooCommerce\Response( $this );
		}
	}

	/**
	 * Return whether or not this gateway still requires setup to function.
	 *
	 * When this gateway is toggled on via AJAX, if this returns true a
	 * redirect will occur to the settings page instead.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function needs_setup() {
		return empty( $this->merchant_id );
	}

	/**
	 * Logging method.
	 *
	 * @param string $message Log message.
	 * @param string $level Optional, defaults to info, valid levels:
	 *                      emergency|alert|critical|error|warning|notice|info|debug.
	 *
	 * @since 1.0.0
	 */
	public static function log( $message, $level = 'info' ) {
		if ( self::$log_enabled ) {
			if ( empty( self::$log ) ) {
				self::$log = wc_get_logger();
			}
			self::$log->log( $level, $message, array( 'source' => 'nabil-bank' ) );
		}
	}

	/**
	 * Processes and saves options.
	 * If there is an error thrown, will continue to save and validate fields, but will leave the erroring field out.
	 *
	 * @since 1.0.0
	 *
	 * @return bool was anything saved?
	 */
	public function process_admin_options() {
		$saved = parent::process_admin_options();

		// Maybe clear logs.
		if ( 'yes' !== $this->get_option( 'debug', 'no' ) ) {
			if ( empty( self::$log ) ) {
				self::$log = wc_get_logger();
			}
			self::$log->clear( 'nabil-bank' );
		}

		return $saved;
	}

	/**
	 * Check if this gateway is enabled and available in the user's country.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_valid_for_use() {
		return true;
	}

	/**
	 * Admin Panel Options.
	 * - Options for bits like 'title' and availability on a country-by-country basis.
	 *
	 * @since 1.0.0
	 */
	public function admin_options() {
		if ( $this->is_valid_for_use() ) {
			parent::admin_options();
		} else {
			?>
			<div class="inline error">
				<p>
					<strong><?php esc_html_e( 'Gateway Disabled', 'nepal-payments-hub-nabil' ); ?></strong>: <?php esc_html_e( 'Gateway Disabled.', 'nepal-payments-hub-nabil' ); ?>
				</p>
			</div>
			<?php
		}
	}

	/**
	 * Initialise Gateway Settings Form Fields.
	 *
	 * @since 1.0.0
	 */
	public function init_form_fields() {
		$this->form_fields = include NB_PAYMENT_FOR_WOOCOMMERCE_PLUGIN_PATH . '/src/Settings.php';
	}

	/**
	 * Process the payment and return the result.
	 *
	 * @param  int $order_id Order ID.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed
	 */
	public function process_payment( $order_id ) {
		include_once NB_PAYMENT_FOR_WOOCOMMERCE_PLUGIN_PATH . '/src/Request.php';

		$order = wc_get_order( $order_id );

		$request = new \NPHN_PaymentForWooCommerce\Request( $this );

		$result = $request->result( $order );

		if ( isset( $result->data->redirectionUrl ) ) {

			// Assuming success.
			return array(
				'result'   => 'success',
				'redirect' => esc_url( $result->data->redirectionUrl ),
			);
		}

		if ( isset( $result->message ) ) {

			wc_add_notice( 'ERROR: ' . esc_html( $result->message ), 'error' );

			// Failed with error.
			return;
		}

		// Failed anyway.
		return; //phpcs:ignore Squiz.PHP.NonExecutableCode.ReturnNotRequired.
	}
}
