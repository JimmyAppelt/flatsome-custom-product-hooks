<?php
/**
 * Main class.
 *
 * @package Fl_Custom_Product_Hooks
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class FL_CPH
 *
 * @class FL_CPH
 */
final class FL_CPH {

	/**
	 * Static instance
	 *
	 * @var FL_CPH $instance
	 */
	private static $instance = null;

	/**
	 * FL_CPH_Conditionals
	 *
	 * @var object FL_CPH_Conditionals
	 */
	public $conditionals;

	/**
	 * FL_CPH_Germanized
	 *
	 * @var object FL_CPH_Germanized
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
	 * @return FL_CPH The plugin object instance
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * FL_CPH constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );

		do_action( 'fl_cph_loaded' );
	}

	/**
	 * Init the plugin after plugins_loaded so environment variables are set.
	 */
	public function init() {
		include_once dirname( __FILE__ ) . '/class-fl-cph-conditionals.php';
		include_once dirname( __FILE__ ) . '/integrations/class-fl-cph-germanized.php';

		$this->conditionals = new FL_CPH_Conditionals();

		if ( ! $this->conditionals->is_flatsome_activated() || ! $this->conditionals->is_woocommerce_activated() ) {
			return;
		}

		// Start integration.
		$this->germanized = new FL_CPH_Germanized();
		$this->germanized->create_builder_options();

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

FL_CPH::get_instance();

