<?php
/**
 * Base integration class.
 *
 * @package Fl_Custom_Product_Hooks
 */

namespace Flcph\Inc\Integrations;

/**
 * Class Integration
 *
 * @package Flcph\Inc\Integrations
 */
abstract class Integration {

	/**
	 * Integration instance received from its creation.
	 *
	 * @var  $instance
	 */
	private $instance;

	/**
	 * Set condition to load the integration or not.
	 *
	 * @var array $condition
	 */
	protected $condition = [];

	/**
	 * Hooks that will be attached to the builder.
	 *
	 * @var array $hooks
	 */
	protected $hooks = [];

	/**
	 * Methods that will run to new hooks
	 *
	 * @var array $callbacks
	 */
	protected $callbacks = [];


	/**
	 * Integration constructor.
	 *
	 * @param object $class_instance Called class instance.
	 */
	public function __construct( $class_instance ) {
		$this->instance = $class_instance;
	}

	/**
	 * Set up an integration.
	 *
	 * @param array $args Arguments.
	 */
	public function set_args( $args ) {
		$this->condition = $args['condition'];
		$this->hooks     = $args['hooks'];
		$this->callbacks = $args['callbacks'];
	}

	/**
	 * Integrate everything.
	 */
	public function integrate() {
		if ( flcph()->conditionals->is_plugin_activated( $this->condition['class'] ) ) {
			if ( get_theme_mod( 'product_layout' ) === 'custom' ) {
				$this->add_hooks();
				foreach ( $this->callbacks as $callback ) {
					call_user_func( [ $this->instance, $callback ] );
				}
			}
		}
	}

	/**
	 * Attach new hooks to the main hook list.
	 */
	public function add_hooks() {
		flcph()->add_to_hook_list( $this->hooks );
	}
}