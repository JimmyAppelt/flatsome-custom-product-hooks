<?php
/**
 * Custom Product Hooks Plugin for Flatsome
 *
 * @package   Fl_Custom_Product_Hooks
 * @license   GPL v3
 *
 * @wordpress-plugin
 * Plugin Name: Flatsome Custom Product Hooks
 * Description: Extends Flatsome custom product hooks with Germanized options.
 * Version:     1.0.0
 * Plugin URI:  https://github.com/
 * Author:      Jim Appelt
 * Text Domain: fl-cph
 * Domain Path: /languages/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'FL_CPH' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-fl-cph.php';
}

/**
 * Main instance of Flcph.
 *
 * @return FL_CPH
 */
function flcph() {
	return FL_CPH::get_instance();
}
