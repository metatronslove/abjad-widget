<?php
class Abjad_Widget_Activator {

public static function activate() {
    // Widget ayarları
    $default_widget = array(
        'id'            => 'metatronslove',
        'color'         => '#FFDD00',
        'position'      => 'right',
        'message'       => 'Like my projects? Buy me a coffee!',
        'description'   => 'Support occult tools',
        'enabled'       => 1,
        'button_type'   => 'emoji',
        'button_emoji'  => '🔮',
        'button_svg'    => '',
        'button_png_url' => ''
    );
    
    // Stil ayarları
    $default_style = array('custom_css' => '');
    
    // Kod ayarları
    $default_code = array('custom_js' => '');
    
    // Sadece yoksa ekle
    if (false === get_option('abjad_widget_settings')) {
        update_option('abjad_widget_settings', $default_widget);
    }
    if (false === get_option('abjad_widget_style')) {
        update_option('abjad_widget_style', $default_style);
    }
    if (false === get_option('abjad_widget_code')) {
        update_option('abjad_widget_code', $default_code);
    }
}
}
