<?php
/**
 * Dashboard tab
 *
 * Provides an iframe to external dashboard or local content.
 *
 * @package AbjadWidget
 * @subpackage Admin
 */

$site_url = get_site_url();
$widget_version = ABJAD_WIDGET_VERSION;

$user_id = get_current_user_id();
$use_iframe = get_user_meta($user_id, 'abjad_dashboard_iframe', true);
if ($use_iframe === '') {
    $use_iframe = 1; // Default: iframe on
}

if (isset($_POST['abjad_dashboard_nonce']) && wp_verify_nonce($_POST['abjad_dashboard_nonce'], 'abjad_dashboard_pref')) {
    $new_value = isset($_POST['abjad_use_iframe']) ? 1 : 0;
    update_user_meta($user_id, 'abjad_dashboard_iframe', $new_value);
    $use_iframe = $new_value;
    echo '<div class="notice notice-success is-dismissible"><p>' . __('Preference saved.', 'abjad-widget-admin') . '</p></div>';
}
?>

<div class="wrap abjad-dashboard-page">
    <h1><?php _e('Abjad Widget Dashboard', 'abjad-widget-admin'); ?></h1>

    <form method="post" action="" style="margin-bottom: 20px;">
        <?php wp_nonce_field('abjad_dashboard_pref', 'abjad_dashboard_nonce'); ?>
        <label>
            <input type="checkbox" name="abjad_use_iframe" value="1" <?php checked($use_iframe, 1); ?>>
            <?php _e('Use external dashboard (iframe)', 'abjad-widget-admin'); ?>
        </label>
        <p class="description"><?php _e('Uncheck to see local content instead of the remote dashboard.', 'abjad-widget-admin'); ?></p>
        <?php submit_button(__('Save Preference', 'abjad-widget-admin'), 'secondary', 'submit', false); ?>
    </form>

    <div class="abjad-dashboard-container">
        <div class="abjad-dashboard-header">
            <p>
                <?php _e('Welcome! You can follow widget news and announcements from this panel.', 'abjad-widget-admin'); ?>
            </p>
        </div>

        <div class="abjad-dashboard-content">
            <?php if ($use_iframe) : ?>
                <iframe 
                    src="https://one.fanclub.rocks/widgets/dashboard.php?site=<?php echo urlencode($site_url); ?>&widget=abjad-widget&version=<?php echo $widget_version; ?>"
                    class="abjad-dashboard-iframe"
                    frameborder="0"
                    onload="this.style.opacity=1"
                    style="opacity:0; transition: opacity 0.3s ease;">
                </iframe>
                <div class="abjad-dashboard-loader">
                    <span class="spinner is-active"></span>
                    <p><?php _e('Loading...', 'abjad-widget-admin'); ?></p>
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
                    '<div class="notice notice-error"><p><?php echo esc_js(__('An error occurred while loading content.', 'abjad-widget-admin')); ?></p></div>'
                );
            }
        }, 10000);
    }
});
</script>
