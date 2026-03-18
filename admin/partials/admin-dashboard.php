<?php
/**
 * Dashboard tab
 *
 * Provides a link to external dashboard or local content.
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
$abjad_widget_use_external = get_user_meta( $abjad_widget_user_id, 'abjad_use_external', true );

if ( $abjad_widget_use_external === '' ) {
    $abjad_widget_use_external = 1; // Default: external on
}

if ( isset( $_POST['abjad_dashboard_nonce'] ) ) {
    $abjad_widget_nonce = sanitize_key( wp_unslash( $_POST['abjad_dashboard_nonce'] ) );
    if ( wp_verify_nonce( $abjad_widget_nonce, 'abjad_dashboard_pref' ) ) {
        $abjad_widget_new_value = isset( $_POST['abjad_use_external'] ) ? intval( $_POST['abjad_use_external'] ) : 0;
        update_user_meta( $abjad_widget_user_id, 'abjad_use_external', $abjad_widget_new_value );
        $abjad_widget_use_external = $abjad_widget_new_value;
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Preference saved.', 'abjad-widget' ) . '</p></div>';
    }
}

$dashboard_url = "https://one.fanclub.rocks/widgets/dashboard.php?site=" . urlencode($abjad_widget_site_url) . "&widget=abjad-widget&version=" . urlencode($abjad_widget_version);
?>

<div class="wrap abjad-dashboard-page">
    <h1><?php esc_html_e( 'Abjad Widget Dashboard', 'abjad-widget' ); ?></h1>

    <form method="post" action="" style="margin-bottom: 20px;">
        <?php wp_nonce_field( 'abjad_dashboard_pref', 'abjad_dashboard_nonce' ); ?>
        <label>
            <input type="checkbox" name="abjad_use_external" value="1" <?php checked( $abjad_widget_use_external, 1 ); ?>>
            <?php esc_html_e( 'Use external dashboard', 'abjad-widget' ); ?>
        </label>
        <p class="description"><?php esc_html_e( 'Uncheck to see local content instead of the remote dashboard.', 'abjad-widget' ); ?></p>
        <?php submit_button( esc_html__( 'Save Preference', 'abjad-widget' ), 'secondary', 'submit', false ); ?>
    </form>

    <?php if ( $abjad_widget_use_external ) : ?>
        <div class="notice notice-info">
            <p>
                <?php esc_html_e( 'The dashboard is hosted externally.', 'abjad-widget' ); ?>
                <a href="<?php echo esc_url( $dashboard_url ); ?>" target="_blank" class="button button-primary">
                    <?php esc_html_e( 'Open External Dashboard', 'abjad-widget' ); ?>
                </a>
            </p>
        </div>
    <?php endif; ?>

    <div class="abjad-dashboard-container">
        <div class="abjad-dashboard-header">
            <p>
                <?php esc_html_e( 'Welcome! You can follow widget news and announcements from this panel.', 'abjad-widget' ); ?>
            </p>
        </div>

        <div class="abjad-dashboard-content">
            <?php include_once 'dashboard-local.php'; ?>
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
    padding: 20px;
}
</style>
