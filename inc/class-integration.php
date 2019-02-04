<?php
/**
 * Base integration class.
 *
 * @package Fl_Custom_Product_Hooks
 */

namespace Flcph\Inc\Integrations;

defined( 'ABSPATH' ) || exit;

/**
 * Class Integration
 *
 * @package Flcph\Inc\Integrations
 */
class Integration {

	/**
	 * Identifier
	 *
	 * @var string
	 */
	private $identifier = '';

	/**
	 * Whether or not the integration should integrate.
	 *
	 * @var bool
	 */
	private $load_condition = false;

	/**
	 * Holds new registered hooks
	 *
	 * @var array
	 */
	private $hooks = [];

	/**
	 * Holds attach callbacks.
	 *
	 * @var array
	 */
	private $callbacks = [];

	/**
	 * Integration constructor.
	 *
	 * @param string $label Integration identifier.
	 */
	public function __construct( $label ) {
		$this->identifier = $label;
		$this->integrate();
	}

	/**
	 * Start Integration.
	 */
	private function integrate() {
		add_action( 'init', function () {
			if ( $this->load_condition && get_theme_mod( 'product_layout' ) === 'custom' ) {
				if ( is_admin() ) {
					$this->add_hooks_into_builder( $this->hooks );
				}
				$this->run_callbacks();
			}
		} );
	}

	/**
	 * Needs the integration be loaded or not?
	 *
	 * @param callback $callback Return true or false.
	 */
	public function load( $callback ) {
		$this->load_condition = $callback();
	}

	/**
	 * Attach new functionality.
	 *
	 * @param array $hooks Hooks.
	 */
	public function hooks( array $hooks ) {
		$this->hooks = $hooks;
	}

	/**
	 * Attach new functionality.
	 *
	 * @param callback $callback Callback.
	 */
	public function attach( $callback ) {
		$this->callbacks[] = $callback;
	}

	/**
	 * Run all registered attach callbacks.
	 */
	private function run_callbacks() {
		foreach ( $this->callbacks as $callback ) {
			$callback();
		}
	}

	/**
	 * Hook up new custom hooks into the builder.
	 *
	 * @param array $custom_hooks Array that contains all hook names and their labels.
	 */
	private function add_hooks_into_builder( array $custom_hooks ) {
		if ( ! $custom_hooks ) {
			return;
		}

		add_filter( 'flatsome_custom_product_single_product_hooks', function ( $hooks ) use ( $custom_hooks ) {
			foreach ( $custom_hooks as $hook => $label ) {
				$hooks[ $hook ] = $label;
			}

			return $hooks;
		} );
	}
}
