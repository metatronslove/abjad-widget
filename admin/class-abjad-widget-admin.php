<?php
class Abjad_Widget_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles($hook) {
        if (strpos($hook, 'abjad-widget') === false) {
            return;
        }
        
        wp_enqueue_style(
            $this->plugin_name . '-admin',
            plugin_dir_url(__FILE__) . '/css/abjad-widget-admin.css',
            array(),
            $this->version,
            'all'
        );
        
        wp_enqueue_style('wp-codemirror');
    }
    
    public function generate_widget_js() {
        header('Content-Type: application/javascript; charset=UTF-8');
        $widget_options = get_option('abjad_widget_settings', array());
        $style_options = get_option('abjad_widget_style', array());
        $code_options = get_option('abjad_widget_code', array());
        include_once plugin_dir_path(dirname(__FILE__)) . '/public/abjadwidget-js.php';
        wp_die();
    }

    public function enqueue_scripts($hook) {
        if (strpos($hook, 'abjad-widget') === false) {
            return;
        }
        
        wp_enqueue_script(
            $this->plugin_name . '-admin',
            plugin_dir_url(__FILE__) . '/js/abjad-widget-admin.js',
            array('jquery', 'wp-codemirror'),
            $this->version,
            false
        );
        
        // Localize strings used in admin JavaScript.
        wp_localize_script(
            $this->plugin_name . '-admin',
            'abjadwidgetadmin',
            array(
                'invalid_url' => __('Please enter a valid URL.', 'abjad-widget-admin'),
            )
        );
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            __('Abjad Widget Dashboard', 'abjad-widget-admin'),
            __('Abjad Widget', 'abjad-widget-admin'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_dashboard_page'),
            'dashicons-crystal',
            30
        );
        
        add_submenu_page(
            $this->plugin_name,
            __('Dashboard', 'abjad-widget-admin'),
            __('Dashboard', 'abjad-widget-admin'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_dashboard_page')
        );
        
        add_submenu_page(
            $this->plugin_name,
            __('Widget Settings', 'abjad-widget-admin'),
            __('Settings', 'abjad-widget-admin'),
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_settings_page')
        );
        
        add_submenu_page(
            $this->plugin_name,
            __('Style Editor', 'abjad-widget-admin'),
            __('Style Editor', 'abjad-widget-admin'),
            'manage_options',
            $this->plugin_name . '-style-editor',
            array($this, 'display_style_editor_page')
        );
        
        add_submenu_page(
            $this->plugin_name,
            __('Code Editor', 'abjad-widget-admin'),
            __('Code Editor', 'abjad-widget-admin'),
            'manage_options',
            $this->plugin_name . '-code-editor',
            array($this, 'display_code_editor_page')
        );
    }

    public function display_dashboard_page() {
        include_once 'partials/admin-dashboard.php';
    }

    public function display_settings_page() {
        include_once 'partials/admin-settings.php';
    }

    public function display_style_editor_page() {
        include_once 'partials/admin-style-editor.php';
    }

    public function display_code_editor_page() {
        include_once 'partials/admin-code-editor.php';
    }

    public function register_settings() {
        register_setting(
            'abjad_widget_options',
            'abjad_widget_settings',
            array($this, 'sanitize_widget_settings')
        );
        
        register_setting(
            'abjad_widget_style_options',
            'abjad_widget_style',
            array($this, 'sanitize_style_settings')
        );
        
        register_setting(
            'abjad_widget_code_options',
            'abjad_widget_code',
            array($this, 'sanitize_code_settings')
        );
    }

    public function sanitize_widget_settings($input) {
        $sanitized = array();
        $sanitized['id']          = sanitize_text_field($input['id']);
        $sanitized['color']       = sanitize_hex_color($input['color']);
        $sanitized['position']    = in_array($input['position'], array('left', 'right')) ? $input['position'] : 'right';
        $sanitized['message']     = sanitize_text_field($input['message']);
        $sanitized['description'] = sanitize_text_field($input['description']);
        $sanitized['enabled']     = isset($input['enabled']) ? 1 : 0;
        
        $sanitized['button_type'] = in_array($input['button_type'], array('emoji', 'svg', 'png')) ? $input['button_type'] : 'emoji';
        $sanitized['button_emoji'] = sanitize_text_field($input['button_emoji']);
        $sanitized['button_svg'] = wp_kses_post($input['button_svg']);
        $sanitized['button_png_url'] = esc_url_raw($input['button_png_url']);
        
        return $sanitized;
    }

    public function sanitize_style_settings($input) {
        return array(
            'custom_css' => wp_kses_post($input['custom_css'])
        );
    }

    public function sanitize_code_settings($input) {
        return array(
            'custom_js' => $input['custom_js']
        );
    }
}
