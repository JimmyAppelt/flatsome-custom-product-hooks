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
	 * Start Integration.
	 */
	public function integrate() {
		if ( $this->load() ) {
			if ( get_theme_mod( 'product_layout' ) === 'custom' ) {
				flcph()->add_to_hook_list( $this->hooks() );
				$this->attach();
			}
		}
	}

	/**
	 * When should the integration integrate?
	 *
	 * @return bool
	 */
	abstract protected function load();

	/**
	 * Attach new hooks to the main hook list.
	 *
	 * @return array
	 */
	abstract protected function hooks();

	/**
	 * Attaches all hook content of the integration.
	 *
	 * @return mixed
	 */
	abstract protected function attach();
}
