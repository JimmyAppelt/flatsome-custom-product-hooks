<?php
/**
 * Conditionals.
 *
 * @package Fl_Custom_Product_Hooks
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class FL_CPH_Conditionals
 */
class FL_CPH_Conditionals {

	/**
	 * Check if Flatsome theme is activated and its version is 3.4 or above.
	 *
	 * @return bool
	 */
	public function is_flatsome_activated() {
		$theme   = wp_get_theme( get_template() );
		$name    = $theme->get( 'Name' );
		$version = $theme->get( 'Version' );

		return 'Flatsome' === $name && version_compare( $version, '3.4.0', '>=' );
	}

	/**
	 * Check if WooCommerce is activated.
	 *
	 * @return bool
	 */
	public function is_woocommerce_activated() {
		return class_exists( 'WooCommerce', false );
	}

	/**
	 * Check if plugin is activated.
	 *
	 * @param string $class    Class name.
	 * @param bool   $autoload To autoload or not.
	 *
	 * @return bool
	 */
	public function is_plugin_activated( $class, $autoload = false ) {
		return class_exists( $class, $autoload );
	}
}