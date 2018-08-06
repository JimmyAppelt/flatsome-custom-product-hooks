<?php
/**
 * Example integration.
 *
 * @package Fl_Custom_Product_Hooks
 */

namespace Flcph\Inc\Integrations;

defined( 'ABSPATH' ) || exit;

/**
 * Class Example
 *
 * @package Flcph\Inc\Integrations
 */
final class Example extends Integration {

	/**
	 * Load when condition is met.
	 * (Check if the plugin is activated)
	 *
	 * @return bool
	 */
	protected function load() {
		return class_exists( 'a_plugin_class' );
	}

	/**
	 * Add new hooks.
	 * hook_name => label
	 *
	 * @return array
	 */
	protected function hooks() {
		return [
			'flatsome_hello_world_hook' => 'My new hook label',
		];
	}

	/**
	 * Attach content to newly created hooks.
	 */
	protected function attach() {
		add_action( 'flatsome_hello_world_hook', function () {
			echo 'Hello World!';
		} );
	}
}