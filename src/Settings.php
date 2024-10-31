<?php

defined( 'ABSPATH' ) || exit;

/**
 * Settings for Nabil Bank Gateway.
 */
return array(
	'enabled'           => array(
		'title'   => __( 'Enable/Disable', 'nepal-payments-hub-nabil' ),
		'type'    => 'checkbox',
		'label'   => __( 'Enable Nabil Pay Payment', 'nepal-payments-hub-nabil' ),
		'default' => 'yes',
	),
	'title'             => array(
		'title'       => __( 'Title', 'nepal-payments-hub-nabil' ),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __( 'This controls the title which the user sees during checkout.', 'nepal-payments-hub-nabil' ),
		'default'     => __( 'Pay by Visa, Mastercard, UnionPay (Nabil)', 'nepal-payments-hub-nabil' ),
	),
	'description'       => array(
		'title'       => __( 'Description', 'nepal-payments-hub-nabil' ),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __( 'This controls the description which the user sees during checkout.', 'nepal-payments-hub-nabil' ),
		'default'     => __( 'Secure Payment by International Credit/Debit Visa, Mastercard or UnionPay.', 'nepal-payments-hub-nabil' ),
	),
	'merchant_id'       => array(
		'title'       => __( 'Merchant ID', 'nepal-payments-hub-nabil' ),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __( 'Please enter your Nabil Bank Merchant ID.', 'nepal-payments-hub-nabil' ),
		'default'     => '',
	),
	'merchant_password' => array(
		'title'       => __( 'Merchant Password', 'nepal-payments-hub-nabil' ),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __( 'Please enter your Nabil Bank metchant password.This is needed in order to take payment.', 'nepal-payments-hub-nabil' ),
		'default'     => '',
	),
	'test_mode'         => array(
		'title'       => __( 'Stage/Test mode', 'nepal-payments-hub-nabil' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable Stage/Test Mode', 'nepal-payments-hub-nabil' ),
		'default'     => 'no',
		'description' => __( 'If enabled, test mode Merchant ID and Merchant Password should be used.', 'nepal-payments-hub-nabil' ),
	),
	'invoice_prefix'    => array(
		'title'       => __( 'Invoice prefix', 'nepal-payments-hub-nabil' ),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __( 'Please enter a prefix for your invoice numbers. If you use your Nabil Bank account for multiple stores ensure this prefix is unique as Nabil Bank will not allow orders with the same invoice number.', 'nepal-payments-hub-nabil' ),
		'default'     => 'WC-',
	),
	'advanced'          => array(
		'title'       => __( 'Advanced options', 'nepal-payments-hub-nabil' ),
		'type'        => 'title',
		'description' => '',
	),
	'debug'             => array(
		'title'       => __( 'Debug log', 'nepal-payments-hub-nabil' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable logging', 'nepal-payments-hub-nabil' ),
		'default'     => 'no',
		/* translators: %s: Nabil Bank log file path */
		'description' => sprintf( __( 'Log Nabil Bank events, such as IPN requests, inside <code>%s</code>', 'nepal-payments-hub-nabil' ), wc_get_log_file_path( 'Nabil Bank' ) ),
	),
);
