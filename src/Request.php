<?php

namespace NPHN_PaymentForWooCommerce;

defined( 'ABSPATH' ) || exit;

/**
 * Request to Nabil Bank.
 */
class Request {

	/**
	 * Pointer to gateway making the request.
	 *
	 * @since 1.0.0
	 *
	 * @var WC_Gateway_Nabil_Bank
	 */
	protected $gateway;

	/**
	 * Endpoint for requests from Nabil Bank.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $notify_url;

	/**
	 * Endpoint for requests to Nabil Bank.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $endpoint;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Gateway_Nabil_Bank $gateway Gateway class.
	 */
	public function __construct( $gateway ) {
		$this->gateway    = $gateway;
		$this->notify_url = WC()->api_request_url( 'WC_Gateway_Nabil_Bank' );
	}

	/**
	 * Get the Nabil Bank request URL for an order or receive a response.
	 *
	 * @param  WC_Order $order   Order object.
	 *
	 * @since 1.0.0
	 *
	 * @return array The result of the request.
	 */
	public function result( $order ) {

		$test_mode = $this->gateway->get_option( 'test_mode' );

		$this->endpoint  = 'yes' === $test_mode ? 'https://stagesys.nabilbank.com/api/EPayment/Initiate' : 'https://sys.nabilbank.com/api/EPayment/Initiate';
		$nabil_bank_args = $this->get_nabil_bank_args( $order );

		\WC_Gateway_Nabil_Bank::log( 'Nabil Bank Request Args for order ' . $order->get_order_number() . ': ' . wc_print_r( $nabil_bank_args, true ) );

		$body = wp_json_encode( $nabil_bank_args );

		$options = array(
			'body'        => $body,
			'headers'     => array(
				'Content-Type' => 'application/json',
			),
			'timeout'     => 60,
			'redirection' => 5,
			'blocking'    => true,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'data_format' => 'body',
		);

		$response = wp_remote_post( $this->endpoint, $options );

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			\WC_Gateway_Nabil_Bank::log( 'Response error for order ' . $order->get_order_number() . ': ' . wc_print_r( $error_message, true ) );
		} else {
			$body = wp_remote_retrieve_body( $response );
			$body = json_decode( $body );

			\WC_Gateway_Nabil_Bank::log( 'Response details for ' . $order->get_order_number() . ': ' . wc_print_r( $body, true ) );

			return $body;
		}
	}

	/**
	 * Get Nabil Bank Args for passing to Nabil Bank.
	 *
	 * @param  WC_Order $order Order object.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_nabil_bank_args( $order ) {

		\WC_Gateway_Nabil_Bank::log( 'Generating payment form for order ' . $order->get_order_number() . '. Notify URL: ' . $this->notify_url );

		$product_details = $this->build_products( $order );

		return apply_filters(
			'nphn_payment_for_woocommerce_args',
			array(
				'totalAmount'    => wc_format_decimal( $order->get_total(), 2 ),
				'merchantId'     => $this->gateway->get_option( 'merchant_id' ),
				'invoiceNo'      => $this->gateway->get_option( 'invoice_prefix' ) . $order->get_order_number(),
				'returnUrl'      => apply_filters( 'nphn_payment_for_woocommerce_return_url', home_url( '/checkout/order-received/' . $order->get_order_number() . '/key=' . $order->get_order_key() ) ),
				'remarks'        => apply_filters( 'nphn_payment_for_woocommerce_remarks', 'Namaste!' ),
				'password'       => $this->gateway->get_option( 'merchant_password' ),
				'productDetails' => array_values( $product_details ),
			),
			$order
		);
	}

	/**
	 * Build product details to pass to Nabil Bank.
	 *
	 * @param  WC_Order $order Order object.
	 *
	 * @since 1.0.0
	 *
	 * @return array Product details
	 */
	protected function build_products( $order ) {
		$items = $order->get_items();

		$products = array();

		foreach ( $items as $key => $item ) {

			$item_data = $item->get_data();
			$product   = $item->get_product();

			$products[ $key ]['productName'] = $item_data['name'];
			$products[ $key ]['quantity']    = $item_data['quantity'];
			$products[ $key ]['rate']        = ! empty( $product->get_price() ) ? $product->get_price() : $item_data['subtotal'];
			$products[ $key ]['total']       = $item_data['total'];
		}

		return $products;
	}
}
