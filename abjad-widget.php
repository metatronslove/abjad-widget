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

if (!defined('WPINC')) {
    die;
}

define('ABJAD_WIDGET_VERSION', '1.0.0');

function activate_abjad_widget() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-abjad-widget-activator.php';
    Abjad_Widget_Activator::activate();
}

function deactivate_abjad_widget() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-abjad-widget-deactivator.php';
    Abjad_Widget_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_abjad_widget');
register_deactivation_hook(__FILE__, 'deactivate_abjad_widget');

require plugin_dir_path(__FILE__) . 'includes/class-abjad-widget.php';

function run_abjad_widget() {
    $plugin = new Abjad_Widget();
    $plugin->run();
}
run_abjad_widget();
