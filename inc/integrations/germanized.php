<?php
/**
 * Germanized integration
 *
 * @package Fl_Custom_Product_Hooks
 */

namespace Flcph\Inc\Integrations;

defined( 'ABSPATH' ) || exit;

/**
 * Initialise new integration.
 */
$germanized = new Integration( 'germanized' );

/**
 * Specify when to load this (when the plugin is activated).
 */
$germanized->load( function () {
	return class_exists( 'WooCommerce_Germanized' );
} );

/**
 * Add new hooks.
 * hook_name => label
 */
$germanized->hooks( [
	'flatsome_woocommerce_gzd_template_single_price_unit'         => 'Germanized - Price Unit',
	'flatsome_woocommerce_gzd_template_single_legal_info'         => 'Germanized - Legal Info',
	'flatsome_woocommerce_gzd_template_single_delivery_time_info' => 'Germanized - Delivery Time Info',
	'flatsome_woocommerce_gzd_template_single_product_units'      => 'Germanized - Product Units',
] );

/**
 * Attach content to the new specified hooks.
 */
$germanized->attach( function () {
	// Unit price.
	if ( get_option( 'woocommerce_gzd_display_product_detail_unit_price' ) === 'yes' ) {
		add_action( 'flatsome_woocommerce_gzd_template_single_price_unit', 'woocommerce_gzd_template_single_price_unit', wc_gzd_get_hook_priority( 'single_price_unit' ) );
	}
	// Tax info.
	if ( get_option( 'woocommerce_gzd_display_product_detail_tax_info' ) === 'yes' || get_option( 'woocommerce_gzd_display_product_detail_shipping_costs' ) === 'yes' ) {
		add_action( 'flatsome_woocommerce_gzd_template_single_legal_info', 'woocommerce_gzd_template_single_legal_info', wc_gzd_get_hook_priority( 'single_legal_info' ) );
	}
	// Delivery time.
	if ( get_option( 'woocommerce_gzd_display_product_detail_delivery_time' ) === 'yes' ) {
		add_action( 'flatsome_woocommerce_gzd_template_single_delivery_time_info', 'woocommerce_gzd_template_single_delivery_time_info', wc_gzd_get_hook_priority( 'single_delivery_time_info' ) );
	}
	// Product Units.
	if ( get_option( 'woocommerce_gzd_display_product_detail_product_units' ) === 'yes' ) {
		add_action( 'flatsome_woocommerce_gzd_template_single_product_units', 'woocommerce_gzd_template_single_product_units', wc_gzd_get_hook_priority( 'single_product_units' ) );
	}
} );
