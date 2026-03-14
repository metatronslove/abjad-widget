<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}
delete_option('abjad_widget_settings');
delete_option('abjad_widget_style');
delete_option('abjad_widget_code');
