<?php
class Abjad_Widget_i18n {
    public function load_plugin_textdomain() {
        // Ön yüz ve genel metinler
        load_plugin_textdomain(
            'abjadWidgetData.i18n',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

        // Admin paneli metinleri (ayrı domain)
        load_plugin_textdomain(
            'abjadwidgetadmin',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/admin/languages/'
        );
    }
}
