<?php
/**
 * Plugin Name:       Abjad Widget
 * Plugin URI:        https://one.fanclub.rocks/wordpress-abjad-widget
 * Description:       Sitenizin köşesine özelleştirilebilir bir yardım butonu (widget) ekler.
 * Version:           1.0.0
 * Author:            Abjad
 * Author URI:        https://one.fanclub.rocks
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       abjad-widget
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'ABJAD_WIDGET_VERSION', '1.0.0' );

/**
 * Activate the plugin.
 */
function abjad_widget_activate() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-abjad-widget-activator.php';
    Abjad_Widget_Activator::activate();
}

/**
 * Deactivate the plugin.
 */
function abjad_widget_deactivate() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-abjad-widget-deactivator.php';
    Abjad_Widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'abjad_widget_activate' );
register_deactivation_hook( __FILE__, 'abjad_widget_deactivate' );

require plugin_dir_path( __FILE__ ) . 'includes/class-abjad-widget.php';

/**
 * Run the plugin.
 */
function abjad_widget_run() {
    $plugin = new Abjad_Widget();
    $plugin->run();
}
abjad_widget_run();
