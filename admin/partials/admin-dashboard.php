<?php
/**
 * Dashboard tab
 *
 * Provides an iframe to external dashboard or local content.
 *
 * @package AbjadWidget
 * @subpackage Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$abjad_widget_site_url    = get_site_url();
$abjad_widget_version     = ABJAD_WIDGET_VERSION;
$abjad_widget_user_id     = get_current_user_id();
$abjad_widget_use_iframe  = get_user_meta( $abjad_widget_user_id, 'abjad_dashboard_iframe', true );

if ( $abjad_widget_use_iframe === '' ) {
    $abjad_widget_use_iframe = 1; // Default: iframe on
}

if ( isset( $_POST['abjad_dashboard_nonce'] ) ) {
    $abjad_widget_nonce = sanitize_key( wp_unslash( $_POST['abjad_dashboard_nonce'] ) );
    if ( wp_verify_nonce( $abjad_widget_nonce, 'abjad_dashboard_pref' ) ) {
        $abjad_widget_new_value = isset( $_POST['abjad_use_iframe'] ) ? intval( $_POST['abjad_use_iframe'] ) : 0;
        update_user_meta( $abjad_widget_user_id, 'abjad_dashboard_iframe', $abjad_widget_new_value );
        $abjad_widget_use_iframe = $abjad_widget_new_value;
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Preference saved.', 'abjad-widget' ) . '</p></div>';
    }
}
?>

<div class="wrap abjad-dashboard-page">
    <h1><?php esc_html_e( 'Abjad Widget Dashboard', 'abjad-widget' ); ?></h1>

    <form method="post" action="" style="margin-bottom: 20px;">
        <?php wp_nonce_field( 'abjad_dashboard_pref', 'abjad_dashboard_nonce' ); ?>
        <label>
            <input type="checkbox" name="abjad_use_iframe" value="1" <?php checked( $abjad_widget_use_iframe, 1 ); ?>>
            <?php esc_html_e( 'Use external dashboard (iframe)', 'abjad-widget' ); ?>
        </label>
        <p class="description"><?php esc_html_e( 'Uncheck to see local content instead of the remote dashboard.', 'abjad-widget' ); ?></p>
        <?php submit_button( esc_html__( 'Save Preference', 'abjad-widget' ), 'secondary', 'submit', false ); ?>
    </form>

    <div class="abjad-dashboard-container">
        <div class="abjad-dashboard-header">
            <p>
                <?php esc_html_e( 'Welcome! You can follow widget news and announcements from this panel.', 'abjad-widget' ); ?>
            </p>
        </div>

        <div class="abjad-dashboard-content">
            <?php if ( $abjad_widget_use_iframe ) : ?>
                <iframe 
                    src="https://one.fanclub.rocks/widgets/dashboard.php?site=<?php echo urlencode( $abjad_widget_site_url ); ?>&widget=abjad-widget&version=<?php echo esc_attr( $abjad_widget_version ); ?>"
                    class="abjad-dashboard-iframe"
                    frameborder="0"
                    onload="this.style.opacity=1"
                    style="opacity:0; transition: opacity 0.3s ease;">
                </iframe>
                <div class="abjad-dashboard-loader">
                    <span class="spinner is-active"></span>
                    <p><?php esc_html_e( 'Loading...', 'abjad-widget' ); ?></p>
                </div>
            <?php else : ?>
                <?php include_once 'dashboard-local.php'; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.abjad-dashboard-page {
    margin: 20px 20px 0 2px;
}

.abjad-dashboard-container {
    background: #fff;
    border: 1px solid #ccd0d4;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
    margin-top: 20px;
}

.abjad-dashboard-header {
    padding: 15px 20px;
    border-bottom: 1px solid #ccd0d4;
    background: #f8f9fa;
}

.abjad-dashboard-header p {
    margin: 0;
    font-size: 14px;
}

.abjad-dashboard-content {
    min-height: 500px;
    position: relative;
    background: #fff;
}

.abjad-dashboard-iframe {
    width: 100%;
    min-height: 600px;
    border: none;
    display: block;
    background: #fff;
}

.abjad-dashboard-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 1;
    pointer-events: none;
}

.abjad-dashboard-loader .spinner {
    float: none;
    margin: 0 auto 10px;
    visibility: visible;
}

.abjad-dashboard-loader p {
    margin: 0;
    color: #666;
}

.abjad-dashboard-iframe[style*="opacity: 1"] + .abjad-dashboard-loader {
    display: none;
}
</style>

<script>
jQuery(document).ready(function($) {
    var iframe = $('.abjad-dashboard-iframe');

    iframe.on('load', function() {
        $(this).css('opacity', 1);
    });

    if (iframe.length) {
        setTimeout(function() {
            if (iframe.css('opacity') != '1') {
                $('.abjad-dashboard-loader').html(
                    '<div class="notice notice-error"><p><?php echo esc_js( __( 'An error occurred while loading content.', 'abjad-widget' ) ); ?></p></div>'
                );
            }
        }, 10000);
    }
});
</script>
