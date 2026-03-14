<?php
class Abjad_Widget {

    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'abjad-widget';
        $this->version = ABJAD_WIDGET_VERSION;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-abjad-widget-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-abjad-widget-i18n.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-abjad-widget-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-abjad-widget-public.php';

        $this->loader = new Abjad_Widget_Loader();
    }

    private function set_locale() {
        $plugin_i18n = new Abjad_Widget_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks() {
        $plugin_admin = new Abjad_Widget_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('wp_ajax_abjad_widget_js', $plugin_admin, 'generate_widget_js');
		$this->loader->add_action('wp_ajax_nopriv_abjad_widget_js', $plugin_admin, 'generate_widget_js');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'register_settings');
    }

	private function define_public_hooks() {
		$plugin_public = new Abjad_Widget_Public( $this->get_plugin_name(), $this->get_version() );
		// Widget script'ini footer'a ekle
		$this->loader->add_action( 'wp_footer', $plugin_public, 'output_widget_script' );
	}

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
}
