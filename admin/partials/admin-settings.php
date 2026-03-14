<?php
/**
 * Settings tab
 *
 * @package AbjadWidget
 * @subpackage Admin
 */

$options = get_option('abjad_widget_settings', array(
    'id' => 'metatronslove',
    'color' => '#FFDD00',
    'position' => 'right',
    'message' => 'Like my projects? Buy me a coffee!',
    'description' => 'Support occult tools',
    'enabled' => 1,
    'button_type' => 'emoji',
    'button_emoji' => '🔮',
    'button_svg' => '',
    'button_png_url' => ''
));
?>

<div class="wrap abjad-settings-page">
    <h1><?php _e('Widget Settings', 'abjad-widget-admin'); ?></h1>
    
    <form method="post" action="options.php">
        <?php settings_fields('abjad_widget_options'); ?>
        
        <div class="abjad-settings-tabs">
            <h2 class="nav-tab-wrapper">
                <a href="#general" class="nav-tab nav-tab-active"><?php _e('General', 'abjad-widget-admin'); ?></a>
                <a href="#button" class="nav-tab"><?php _e('Button', 'abjad-widget-admin'); ?></a>
            </h2>
            
            <div class="abjad-settings-tab-content" id="tab-general">
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Widget Status', 'abjad-widget-admin'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="abjad_widget_settings[enabled]" value="1" <?php checked($options['enabled'], 1); ?> />
                                <?php _e('Widget active', 'abjad-widget-admin'); ?>
                            </label>
                            <p class="description"><?php _e('Check this box to activate the widget.', 'abjad-widget-admin'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_id"><?php _e('Buy Me a Coffee ID', 'abjad-widget-admin'); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="abjad_id" 
                                   name="abjad_widget_settings[id]" 
                                   value="<?php echo esc_attr($options['id']); ?>" 
                                   class="regular-text" />
                            <p class="description"><?php _e('Your Buy Me a Coffee username', 'abjad-widget-admin'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_color"><?php _e('Button Color', 'abjad-widget-admin'); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="abjad_color" 
                                   name="abjad_widget_settings[color]" 
                                   value="<?php echo esc_attr($options['color']); ?>" 
                                   class="regular-text color-picker" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_position"><?php _e('Position', 'abjad-widget-admin'); ?></label></th>
                        <td>
                            <select id="abjad_position" name="abjad_widget_settings[position]">
                                <option value="left" <?php selected($options['position'], 'left'); ?>><?php _e('Left', 'abjad-widget-admin'); ?></option>
                                <option value="right" <?php selected($options['position'], 'right'); ?>><?php _e('Right', 'abjad-widget-admin'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_message"><?php _e('Button Message', 'abjad-widget-admin'); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="abjad_message" 
                                   name="abjad_widget_settings[message]" 
                                   value="<?php echo esc_attr($options['message']); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="abjad_description"><?php _e('Description', 'abjad-widget-admin'); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="abjad_description" 
                                   name="abjad_widget_settings[description]" 
                                   value="<?php echo esc_attr($options['description']); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="abjad-settings-tab-content" id="tab-button" style="display: none;">
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Button Type', 'abjad-widget-admin'); ?></th>
                        <td>
                            <fieldset>
                                <label>
                                    <input type="radio" 
                                           name="abjad_widget_settings[button_type]" 
                                           value="emoji" 
                                           <?php checked($options['button_type'], 'emoji'); ?> />
                                    <?php _e('Emoji', 'abjad-widget-admin'); ?>
                                </label><br>
                                
                                <label>
                                    <input type="radio" 
                                           name="abjad_widget_settings[button_type]" 
                                           value="svg" 
                                           <?php checked($options['button_type'], 'svg'); ?> />
                                    <?php _e('SVG Code', 'abjad-widget-admin'); ?>
                                </label><br>
                                
                                <label>
                                    <input type="radio" 
                                           name="abjad_widget_settings[button_type]" 
                                           value="png" 
                                           <?php checked($options['button_type'], 'png'); ?> />
                                    <?php _e('PNG Image URL', 'abjad-widget-admin'); ?>
                                </label>
                            </fieldset>
                        </td>
                    </tr>
                    
                    <tr class="button-option button-option-emoji">
                        <th scope="row"><label for="button_emoji"><?php _e('Button Emoji', 'abjad-widget-admin'); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="button_emoji" 
                                   name="abjad_widget_settings[button_emoji]" 
                                   value="<?php echo esc_attr($options['button_emoji']); ?>" 
                                   class="regular-text" />
                            <p class="description"><?php _e('Example: 🔮, ☯️, ✨', 'abjad-widget-admin'); ?></p>
                        </td>
                    </tr>
                    
                    <tr class="button-option button-option-svg">
                        <th scope="row"><label for="button_svg"><?php _e('SVG Code', 'abjad-widget-admin'); ?></label></th>
                        <td>
                            <textarea id="button_svg" 
                                      name="abjad_widget_settings[button_svg]" 
                                      rows="5" 
                                      class="large-text code"><?php echo esc_textarea($options['button_svg']); ?></textarea>
                            <p class="description"><?php _e('Paste SVG code', 'abjad-widget-admin'); ?></p>
                        </td>
                    </tr>
                    
                    <tr class="button-option button-option-png">
                        <th scope="row"><label for="button_png_url"><?php _e('PNG Image URL', 'abjad-widget-admin'); ?></label></th>
                        <td>
                            <input type="url" 
                                   id="button_png_url" 
                                   name="abjad_widget_settings[button_png_url]" 
                                   value="<?php echo esc_url($options['button_png_url']); ?>" 
                                   class="regular-text" />
                            <p class="description"><?php _e('Enter image URL', 'abjad-widget-admin'); ?></p>
                            
                            <?php if (!empty($options['button_png_url'])): ?>
                                <div style="margin-top: 10px;">
                                    <img src="<?php echo esc_url($options['button_png_url']); ?>" 
                                         style="max-width: 100px; max-height: 100px; border: 1px solid #ddd; padding: 5px;" />
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <?php submit_button(__('Save Settings', 'abjad-widget-admin')); ?>
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
