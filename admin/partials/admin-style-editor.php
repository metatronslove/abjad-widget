<?php
/**
 * Style editor tab
 *
 * Allows the user to add custom CSS to override the widget's default styles.
 *
 * @package AbjadWidget
 * @subpackage Admin
 */

$style_options = get_option('abjad_widget_style', array('custom_css' => ''));

// Extract default CSS from the public file for the reset button.
$default_css_file = plugin_dir_path(dirname(__FILE__)) . 'public/abjadwidget-js.php';
$default_css = '';
if (file_exists($default_css_file)) {
    $content = file_get_contents($default_css_file);
    preg_match('/style\.textContent = `(.*?)`;/s', $content, $matches);
    if (isset($matches[1])) {
        $default_css = $matches[1];
    }
}
?>

<div class="wrap abjad-style-editor-page">
    <h1><?php _e('Style Editor', 'abjad-widget-admin'); ?></h1>
    
    <div class="notice notice-warning">
        <p>
            <strong><?php _e('WARNING', 'abjad-widget-admin'); ?>:</strong>
            <?php _e('Your changes will directly affect the widget appearance. If you don\'t know CSS, it\'s recommended to use default settings.', 'abjad-widget-admin'); ?>
        </p>
    </div>
    
    <div class="notice notice-info">
        <p>
            <?php _e('Add custom CSS to customize the widget appearance. This CSS will be applied after the default widget styles, so you can override any rule.', 'abjad-widget-admin'); ?>
        </p>
        <p>
            <?php _e('Changes are visible immediately on the frontend after saving. No preview is available here because the widget is dynamic, but you can test on your site.', 'abjad-widget-admin'); ?>
        </p>
    </div>
    
    <form method="post" action="options.php">
        <?php settings_fields('abjad_widget_style_options'); ?>
        
        <div class="abjad-editor-container">
            <div class="abjad-editor-toolbar">
                <button type="button" class="button" id="reset-css">
                    <?php _e('Reset to Default', 'abjad-widget-admin'); ?>
                </button>
            </div>
            
            <div class="abjad-editor-main">
                <textarea id="custom_css" 
                          name="abjad_widget_style[custom_css]" 
                          class="large-text code" 
                          rows="20"><?php echo esc_textarea($style_options['custom_css']); ?></textarea>
            </div>
            
            <p class="description"><?php _e('Enter your custom CSS rules here. They will be injected into the widget.', 'abjad-widget-admin'); ?></p>
        </div>
        
        <?php submit_button(__('Save CSS', 'abjad-widget-admin')); ?>
    </form>
</div>

<style>
.abjad-editor-container {
    margin: 20px 0;
}

.abjad-editor-toolbar {
    margin-bottom: 10px;
    padding: 10px;
    background: #f8f9fa;
    border: 1px solid #ccd0d4;
    border-radius: 4px;
}

.abjad-editor-toolbar .button {
    margin-right: 5px;
}

.CodeMirror {
    border: 1px solid #ccd0d4;
    height: auto;
    min-height: 400px;
    font-family: 'Courier New', monospace;
    font-size: 13px;
    line-height: 1.5;
}

.CodeMirror-gutters {
    background: #f8f9fa;
    border-right: 1px solid #ccd0d4;
}

.CodeMirror-linenumber {
    color: #666;
}
</style>

<script>
jQuery(document).ready(function($) {
    var editor = wp.codeEditor.initialize($('#custom_css'), {
        codemirror: {
            mode: 'css',
            lineNumbers: true,
            lineWrapping: true,
            theme: 'default',
            autoCloseBrackets: true,
            matchBrackets: true,
            indentUnit: 4,
            tabSize: 4,
            indentWithTabs: true,
            extraKeys: {
                'Ctrl-Space': 'autocomplete'
            }
        }
    });
    
    var cssEditor = editor.codemirror;
    
    $('#reset-css').on('click', function() {
        if (confirm('<?php echo esc_js(__('All your changes will be lost. Are you sure?', 'abjad-widget-admin')); ?>')) {
            var defaultCss = <?php echo json_encode($default_css); ?>;
            cssEditor.setValue(defaultCss);
        }
    });
});
</script>
