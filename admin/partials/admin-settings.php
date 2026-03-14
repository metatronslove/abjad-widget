<?php
/**
 * Settings tab
 *
 * @package AbjadWidget
 * @subpackage Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$abjad_widget_options = get_option( 'abjad_widget_settings', array(
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
) );
?>

<div class="wrap abjad-settings-page">
    <h1><?php esc_html_e( 'Widget Settings', 'abjad-widget' ); ?></h1>

    <form method="post" action="options.php">
        <?php settings_fields( 'abjad_widget_options' ); ?>

        <div class="abjad-settings-tabs">
            <h2 class="nav-tab-wrapper">
                <a href="#general" class="nav-tab nav-tab-active"><?php esc_html_e( 'General', 'abjad-widget' ); ?></a>
                <a href="#button" class="nav-tab"><?php esc_html_e( 'Button', 'abjad-widget' ); ?></a>
            </h2>

            <div class="abjad-settings-tab-content" id="tab-general">
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Widget Status', 'abjad-widget' ); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="abjad_widget_settings[enabled]" value="1" <?php checked( $abjad_widget_options['enabled'], 1 ); ?> />
                                <?php esc_html_e( 'Widget active', 'abjad-widget' ); ?>
                            </label>
                            <p class="description"><?php esc_html_e( 'Check this box to activate the widget.', 'abjad-widget' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_id"><?php esc_html_e( 'Buy Me a Coffee ID', 'abjad-widget' ); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="abjad_id" 
                                   name="abjad_widget_settings[id]" 
                                   value="<?php echo esc_attr( $abjad_widget_options['id'] ); ?>" 
                                   class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Your Buy Me a Coffee username', 'abjad-widget' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_color"><?php esc_html_e( 'Button Color', 'abjad-widget' ); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="abjad_color" 
                                   name="abjad_widget_settings[color]" 
                                   value="<?php echo esc_attr( $abjad_widget_options['color'] ); ?>" 
                                   class="regular-text color-picker" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_position"><?php esc_html_e( 'Position', 'abjad-widget' ); ?></label></th>
                        <td>
                            <select id="abjad_position" name="abjad_widget_settings[position]">
                                <option value="left" <?php selected( $abjad_widget_options['position'], 'left' ); ?>><?php esc_html_e( 'Left', 'abjad-widget' ); ?></option>
                                <option value="right" <?php selected( $abjad_widget_options['position'], 'right' ); ?>><?php esc_html_e( 'Right', 'abjad-widget' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_message"><?php esc_html_e( 'Button Message', 'abjad-widget' ); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="abjad_message" 
                                   name="abjad_widget_settings[message]" 
                                   value="<?php echo esc_attr( $abjad_widget_options['message'] ); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_description"><?php esc_html_e( 'Description', 'abjad-widget' ); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="abjad_description" 
                                   name="abjad_widget_settings[description]" 
                                   value="<?php echo esc_attr( $abjad_widget_options['description'] ); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                </table>
            </div>

            <div class="abjad-settings-tab-content" id="tab-button" style="display: none;">
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Button Type', 'abjad-widget' ); ?></th>
                        <td>
                            <fieldset>
                                <label>
                                    <input type="radio" 
                                           name="abjad_widget_settings[button_type]" 
                                           value="emoji" 
                                           <?php checked( $abjad_widget_options['button_type'], 'emoji' ); ?> />
                                    <?php esc_html_e( 'Emoji', 'abjad-widget' ); ?>
                                </label><br>

                                <label>
                                    <input type="radio" 
                                           name="abjad_widget_settings[button_type]" 
                                           value="svg" 
                                           <?php checked( $abjad_widget_options['button_type'], 'svg' ); ?> />
                                    <?php esc_html_e( 'SVG Code', 'abjad-widget' ); ?>
                                </label><br>

                                <label>
                                    <input type="radio" 
                                           name="abjad_widget_settings[button_type]" 
                                           value="png" 
                                           <?php checked( $abjad_widget_options['button_type'], 'png' ); ?> />
                                    <?php esc_html_e( 'PNG Image URL', 'abjad-widget' ); ?>
                                </label>
                            </fieldset>
                        </td>
                    </tr>

                    <tr class="button-option button-option-emoji">
                        <th scope="row"><label for="button_emoji"><?php esc_html_e( 'Button Emoji', 'abjad-widget' ); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="button_emoji" 
                                   name="abjad_widget_settings[button_emoji]" 
                                   value="<?php echo esc_attr( $abjad_widget_options['button_emoji'] ); ?>" 
                                   class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Example: 🔮, ☯️, ✨', 'abjad-widget' ); ?></p>
                        </td>
                    </tr>

                    <tr class="button-option button-option-svg">
                        <th scope="row"><label for="button_svg"><?php esc_html_e( 'SVG Code', 'abjad-widget' ); ?></label></th>
                        <td>
                            <textarea id="button_svg" 
                                      name="abjad_widget_settings[button_svg]" 
                                      rows="5" 
                                      class="large-text code"><?php echo esc_textarea( $abjad_widget_options['button_svg'] ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Paste SVG code', 'abjad-widget' ); ?></p>
                        </td>
                    </tr>

                    <tr class="button-option button-option-png">
                        <th scope="row"><label for="button_png_url"><?php esc_html_e( 'PNG Image URL', 'abjad-widget' ); ?></label></th>
                        <td>
                            <input type="url" 
                                   id="button_png_url" 
                                   name="abjad_widget_settings[button_png_url]" 
                                   value="<?php echo esc_url( $abjad_widget_options['button_png_url'] ); ?>" 
                                   class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Enter image URL', 'abjad-widget' ); ?></p>

                            <?php if ( ! empty( $abjad_widget_options['button_png_url'] ) ) : ?>
                                <div style="margin-top: 10px;">
                                    <img src="<?php echo esc_url( $abjad_widget_options['button_png_url'] ); ?>" 
                                         style="max-width: 100px; max-height: 100px; border: 1px solid #ddd; padding: 5px;" />
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <?php submit_button( esc_html__( 'Save Settings', 'abjad-widget' ) ); ?>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    $('.color-picker').wpColorPicker();

    $('.nav-tab-wrapper a').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href').replace('#', '');
        $('.nav-tab-wrapper a').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.abjad-settings-tab-content').hide();
        $('#tab-' + target).show();
    });

    function toggleButtonOptions() {
        var selected = $('input[name="abjad_widget_settings[button_type]"]:checked').val();
        $('.button-option').hide();
        $('.button-option-' + selected).show();
    }

    $('input[name="abjad_widget_settings[button_type]"]').on('change', toggleButtonOptions);
    toggleButtonOptions();
});
</script>
