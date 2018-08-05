<?php
/**
 * Main class.
 *
 * @package Fl_Custom_Product_Hooks
 */

namespace Flcph\Inc;

use Flcph\Inc\Integrations\Germanized;

defined( 'ABSPATH' ) || exit;

/**
 * Class Plugin
 *
 * @package Flcph\Inc
 */
final class Plugin {

	/**
	 * Static instance
	 *
	 * @var Plugin $instance
	 */
	private static $instance = null;

	/**
	 * Conditionals
	 *
	 * @var Conditionals $conditionals
	 */
	public $conditionals;

	/**
	 * Germanized
	 *
	 * @var Germanized $germanized
	 */
	public $germanized;

	/**
	 * Custom hook list and their labels
	 *
	 * @var array
	 */
	private $custom_hooks = [];

	/**
	 * Initializes the plugin object and returns its instance.
	 *
	 * @return Plugin The plugin object instance
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );

		do_action( 'flcph_plugin_loaded' );
	}

	/**
	 * Init the plugin after plugins_loaded so environment variables are set.
	 */
	public function init() {
		include_once dirname( __FILE__ ) . '/class-conditionals.php';
		include_once dirname( __FILE__ ) . '/integrations/class-integration.php';
		include_once dirname( __FILE__ ) . '/integrations/class-germanized.php';

		$this->conditionals = new Conditionals();

		if ( ! $this->conditionals->is_flatsome_activated() || ! $this->conditionals->is_woocommerce_activated() ) {
			return;
		}

		// Start integration.
		$this->germanized = new Germanized();
		$this->germanized->integrate();

		$this->add_hooks_into_builder( $this->custom_hooks );
	}

	/**
	 * Adds new hooks and their labels to the custom hooks list.
	 *
	 * @param array $hooks Array that contains new hook names and their labels.
	 */
	public function add_to_hook_list( array $hooks ) {
		if ( ! $hooks ) {
			return;
		}
		foreach ( $hooks as $hook => $label ) {
			$this->custom_hooks[ $hook ] = $label;
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

Plugin::get_instance();

