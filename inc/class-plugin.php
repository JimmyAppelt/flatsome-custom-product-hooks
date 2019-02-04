<?php
/**
 * Main class.
 *
 * @package Fl_Custom_Product_Hooks
 */

namespace Flcph\Inc;

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
	 * @var Conditional
	 */
	public $conditional;

	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Init the plugin after plugins_loaded so environment variables are set.
	 */
	public function init() {
		// Main classes.
		include_once dirname( __FILE__ ) . '/class-conditional.php';
		include_once dirname( __FILE__ ) . '/class-integration.php';

		$this->conditional = new Conditional();

		if ( ! $this->conditional->is_flatsome_activated() || ! $this->conditional->is_woocommerce_activated() ) {
			return;
		}

		// External plugin integrations.
		// TODO: load dynamically from integrations folder.
		include_once dirname( __FILE__ ) . '/integrations/germanized.php';
	}

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
}

Plugin::get_instance();

