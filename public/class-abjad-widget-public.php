<?php
/**
 * Abjad Widget Public Class
 *
 * Handles the public-facing functionality of the widget.
 *
 * @package AbjadWidget
 * @since   1.0.0
 */

class Abjad_Widget_Public {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Returns an associative array of all translation strings used in the widget.
     * Values are in English to match the .po files' msgid's.
     */
    private function get_translation_strings() {
        return array(
            // Tab labels
            'abjadTab'                => __('Abjad', 'abjad-widget'),
            'bastetTab'               => __('Bastet', 'abjad-widget'),
            'huddamTab'               => __('Huddam', 'abjad-widget'),
            'settingsTab'             => __('Settings', 'abjad-widget'),
            'supportTab'              => __('Support', 'abjad-widget'),

            // Data entry & Profile
            'dataEntryPlaceholder'    => __('Enter text... Arabic, Hebrew, Turkish letters, numbers', 'abjad-widget'),
            'dataTypeProfile'         => __('Data type profile', 'abjad-widget'),
            'autoDetect'              => __('Let character quantity decide', 'abjad-widget'),
            'ARABIC'                  => __('Arabic', 'abjad-widget'),
            'hebrew'                  => __('Hebrew', 'abjad-widget'),
            'turkish'                 => __('Turkish', 'abjad-widget'),
            'ARABICNumbers'           => __('Arabic numbers', 'abjad-widget'),
            'indianNumbers'           => __('Indian numbers', 'abjad-widget'),
            'possiblePhrases'         => __('Possible phrases', 'abjad-widget'),
            'separators'              => __('Separators', 'abjad-widget'),
            'regularExpression'       => __('Regular expression', 'abjad-widget'),
            'datasEntered'            => __('Entered data', 'abjad-widget'),
            'programSettings'         => __('Program settings', 'abjad-widget'),

            // General Settings
            'interfaceLanguage'        => __('Interface language', 'abjad-widget'),
            'whenDataIsEntered'        => __('When data is entered', 'abjad-widget'),
            'autoCalculateImmediately' => __('auto calculate immediately', 'abjad-widget'),
            'waitForSettings'          => __('wait for settings and data entry', 'abjad-widget'),
            'abjadFunctionSettings'    => __('abjad() functions settings', 'abjad-widget'),
            'areForcedToOther'         => __('force to other functions', 'abjad-widget'),
            'areNotForced'             => __('do not force to other functions', 'abjad-widget'),
            'undefinedCharacters'      => __('Undefined characters', 'abjad-widget'),
            'willBeRemoved'            => __('purify data', 'abjad-widget'),
            'willNotBeRemoved'         => __('do not purify', 'abjad-widget'),
            'numericalValues'          => __('Numerical values', 'abjad-widget'),
            'willUseArabicNumbers'     => __('display with Arabic numbers', 'abjad-widget'),
            'willUseIndianNumbers'     => __('display with Indian numbers', 'abjad-widget'),
            'textOrNumberCell'         => __('Text or number cell', 'abjad-widget'),
            'forDataEntered'           => __('For entered data', 'abjad-widget'),
            'viewAbjadSums'            => __('show abjad values', 'abjad-widget'),
            'doNotViewAbjadSums'       => __('hide abjad values', 'abjad-widget'),

            // Abjad order
            'hisabElCumel'            => __('Hisab al jumal', 'abjad-widget'),
            'gematria'                => __('Gematria', 'abjad-widget'),
            'turkishAlphabetAbjad'    => __('Turkish Alphabet Abjad', 'abjad-widget'),
            'maghribianAbjad'         => __('Maghribian abjad', 'abjad-widget'),
            'quranFrequency'          => __('Frequency in Quran', 'abjad-widget'),
            'hijaOrder'               => __('Hija order', 'abjad-widget'),
            'maghribianHijaOrder'     => __('Maghribian hija order', 'abjad-widget'),
            'iklilsOrder'             => __('Iklil\'s order', 'abjad-widget'),
            'shamseeAbjadOrder'       => __('Shamsee abjad order', 'abjad-widget'),

            // Abjad table
            'asgari'                  => __('Minimum', 'abjad-widget'),
            'saghir'                  => __('Small', 'abjad-widget'),
            'kabir'                   => __('Big', 'abjad-widget'),
            'akbar'                   => __('Bigger', 'abjad-widget'),
            'saghirPlusLetterCount'   => __('Small + letter count', 'abjad-widget'),
            'letterCount'             => __('Letter count', 'abjad-widget'),

            // Shadda
            'countOnce'               => __('count once', 'abjad-widget'),
            'countTwice'              => __('count twice', 'abjad-widget'),

            // Details
            'dontShow'                => __('hide', 'abjad-widget'),
            'showDetail'              => __('show', 'abjad-widget'),

            // Element Classification Method
            'turkishElements'         => __('Turkish alphabet elements', 'abjad-widget'),
            'ibniArabi'               => __('Muhiyyiddin Ibn Arabi', 'abjad-widget'),
            'ahmadAlBuni'             => __('Ahmad al Buni', 'abjad-widget'),
            'sulaymanAlHuseyni'       => __('Sulayman al Huseyni', 'abjad-widget'),
            'hebrewElements'          => __('Hebrew alphabet elements', 'abjad-widget'),
            'regularClassification'   => __('Regularly preferred classification', 'abjad-widget'),

            // Add Elements Checkboxes
            'all'                      => __('All', 'abjad-widget'),
            'fire'                     => __('Fire', 'abjad-widget'),
            'air'                      => __('Air', 'abjad-widget'),
            'water'                    => __('Water', 'abjad-widget'),
            'earth'                    => __('Earth', 'abjad-widget'),

            // Abjad results
            'abjadCalculationResults'  => __('Abjad calculation results', 'abjad-widget'),

            // Bastet Tab
            'bastetFunctionSettings'   => __('bastet() and nutket() functions settings', 'abjad-widget'),
            'viewBastOperation'        => __('show bast results', 'abjad-widget'),
            'doNotViewBastOperation'   => __('hide bast results', 'abjad-widget'),
            'bastSource'               => __('As data for operation', 'abjad-widget'),
            'useAbjadResults'          => __('use calculated abjad results', 'abjad-widget'),
            'useAbjadTotal'            => __('use calculated abjad total', 'abjad-widget'),
            'useEnteredData'           => __('use entered data directly', 'abjad-widget'),
            'useDataTotal'             => __('use entered data total', 'abjad-widget'),
            'bastLanguage'             => __('Number reading language', 'abjad-widget'),
            'bastRepetition'           => __('Bast repetition count', 'abjad-widget'),
            'bastDetail'               => __('Calculation details', 'abjad-widget'),
            'bastAddQuantity'          => __('Entry letter count', 'abjad-widget'),
            'no'                       => __('do not add to initial value', 'abjad-widget'),
            'yes'                      => __('add to initial value', 'abjad-widget'),
            'bastUseElement'           => __('Element classification', 'abjad-widget'),
            'onlyBeginning'            => __('use only at beginning if possible', 'abjad-widget'),
            'allRepetitions'           => __('use in all bast repetitions', 'abjad-widget'),
            'bastElementGuide'         => __('Element classification method', 'abjad-widget'),
            'bastRepetationResults'    => __('Bast loop results', 'abjad-widget'),

            // Huddam Tab
            'huddamFunctionSettings'    => __('huddam() function settings', 'abjad-widget'),
            'viewDutyEntityNames'       => __('show huddam names', 'abjad-widget'),
            'doNotViewDutyEntityNames'  => __('hide huddam names', 'abjad-widget'),
            'huddamSource'              => __('As data for operation', 'abjad-widget'),
            'useBastetResults'          => __('use calculated bast results', 'abjad-widget'),
            'huddamOrder'               => __('Abjad order', 'abjad-widget'),
            'dutyEntityType'            => __('Duty entity type', 'abjad-widget'),
            'ulvi'                      => __('High', 'abjad-widget'),
            'sufli'                     => __('Low', 'abjad-widget'),
            'ser'                       => __('Evil', 'abjad-widget'),
            'otherSuffix'               => __('other suffix', 'abjad-widget'),
            'suffix'                    => __('suffix', 'abjad-widget'),
            'huddamMode'                => __('When reading large digits', 'abjad-widget'),
            'groupMultiplier'           => __('group multiplier letters', 'abjad-widget'),
            'repeatMultiplier'          => __('repeat multiplier for each digit', 'abjad-widget'),
            'dutyEntityNamesResults'    => __('Duty entity name results', 'abjad-widget'),

            // Settings Tab (duplicates handled)
            'autoCalculate'             => __('When data is entered', 'abjad-widget'),
            'immediate'                 => __('auto calculate immediately', 'abjad-widget'),
            'wait'                      => __('wait for settings and data entry', 'abjad-widget'),
            'forceRules'                => __('abjad() functions settings', 'abjad-widget'),
            'forceToOther'              => __('force to other functions', 'abjad-widget'),
            'doNotForce'                => __('do not force to other functions', 'abjad-widget'),
            'purify'                    => __('Undefined characters', 'abjad-widget'),
            'removeUndefined'           => __('purify data', 'abjad-widget'),
            'keepUndefined'             => __('do not purify', 'abjad-widget'),
            'digitsDisplay'             => __('Numerical values', 'abjad-widget'),
            'ARABICNumbersDisplay'      => __('display with Arabic numbers', 'abjad-widget'),
            'indianNumbersDisplay'      => __('display with Indian numbers', 'abjad-widget'),

            // Support Tab
            'bmcMessage'                 => __('Buy me a coffee', 'abjad-widget'),
            'bmcDescription'             => __('Like my projects? Buy me a coffee!', 'abjad-widget'),
            'bmcNote'                    => __('Thank you for your support!', 'abjad-widget'),

            // Table Headers & Result Messages
            'order'                      => __('Order', 'abjad-widget'),
            'entry'                      => __('Entry', 'abjad-widget'),
            'value'                      => __('Value', 'abjad-widget'),
            'total'                      => __('Total', 'abjad-widget'),
            'abjad_not_viewed'           => __('Abjad calculations hidden', 'abjad-widget'),
            'abjad_not_calculated'       => __('Abjad not calculated', 'abjad-widget'),
            'bast_not_viewed'            => __('Bast results hidden', 'abjad-widget'),
            'bast_not_calculated'        => __('Bast not calculated', 'abjad-widget'),
            'huddam_not_viewed'          => __('Huddam names hidden', 'abjad-widget'),
            'huddam_not_calculated'      => __('Huddam not calculated', 'abjad-widget'),
            'no_data'                    => __('no data entered', 'abjad-widget'),
            'click_row_for_details'      => __('Click row for details', 'abjad-widget'),
            'bast_times'                 => __('times bast applied.', 'abjad-widget'),
            'bast_none'                  => __('no bast applied.', 'abjad-widget'),
            'pronunciation'              => __('Pronunciation', 'abjad-widget'),
            'taken_letter_abjad'         => __('Taken (letter; abjad)', 'abjad-widget'),
            'taken_letter'               => __('Taken (letter)', 'abjad-widget'),
            'for_number'                  => __('', 'abjad-widget'),
            'number_space'                => __(' count ', 'abjad-widget'),
            'calc_abjad_of'               => __('', 'abjad-widget'),
            'after_adding_letters'        => __('abjad calculated and letter count added', 'abjad-widget'),
            'and'                         => __('and', 'abjad-widget'),
            'used_letters'            => __('Taken Letters', 'abjad-widget'),
            'abjad_value'             => __('Abjad Value', 'abjad-widget'),

            // Data Entry Separators
            'dataEntrySeparators'        => __('Data entry separators:', 'abjad-widget'),
            'ARABICLetters'              => __('Arabic letters', 'abjad-widget'),
            'hebrewLetters'              => __('Hebrew letters', 'abjad-widget'),
            'turkishLetters'             => __('Turkish letters', 'abjad-widget'),
            'newline'                    => __('[new-line]', 'abjad-widget'),
            'tab'                        => __('[tab]', 'abjad-widget'),
            'dot'                        => __('[dot]', 'abjad-widget'),
            'comma'                      => __('[comma]', 'abjad-widget'),
            'parenthesis'                 => __('[parenthesis]', 'abjad-widget'),
            'parenthesis_open'            => __('[open parenthesis]', 'abjad-widget'),
            'parenthesis_close'           => __('[close parenthesis]', 'abjad-widget'),
            'ARABIC_comma'                => __('[arabic comma]', 'abjad-widget'),
            'semicolon'                   => __('[semicolon]', 'abjad-widget'),
            'ARABIC_semicolon'            => __('[arabic semicolon]', 'abjad-widget'),
            'ayah_end'                    => __('[end of ayah]', 'abjad-widget'),
            'ARABIC_parenthesis_open'     => __('[arabic parenthesis open]', 'abjad-widget'),
            'ARABIC_parenthesis_close'    => __('[arabic parenthesis close]', 'abjad-widget'),
            'quotes'                      => __('[quote]', 'abjad-widget'),
            'apostrophe'                  => __('[apostrophe]', 'abjad-widget'),
            'space'                       => __('[space]', 'abjad-widget'),
            'comaDefaultMessage'          => __('Comma is default separator and must remain checked!', 'abjad-widget'),

            // Keyboard strings
            'keyboard_00' => __('Show numpad', 'abjad-widget'),
            'keyboard_01' => __('Show virtual keyboard', 'abjad-widget'),
            'keyboard_02' => __('Choose Keyboard Layout', 'abjad-widget'),
            'keyboard_03' => __('Dead keys', 'abjad-widget'),
            'keyboard_04' => __('Open', 'abjad-widget'),
            'keyboard_05' => __('Closed', 'abjad-widget'),
            'keyboard_06' => __('Close Keyboard', 'abjad-widget'),
            'keyboard_07' => __('Reset', 'abjad-widget'),
            'keyboard_08' => __('Clear text box', 'abjad-widget'),
            'keyboard_09' => __('Version', 'abjad-widget'),
            'keyboard_10' => __('Decrease keyboard size', 'abjad-widget'),
            'keyboard_11' => __('Increase keyboard size', 'abjad-widget'),

            // Additional keys for abjadwidget.js
            'bastet'                     => __('Bastet', 'abjad-widget'),
            'huddam'                     => __('Huddam', 'abjad-widget'),
            'calculateabjad'             => __('Calculate Abjad', 'abjad-widget'),
            'calculate'                  => __('Calculate', 'abjad-widget'),
            'dont'                       => __('Don\'t calculate', 'abjad-widget'),
            'addElements'                => __('Add elements', 'abjad-widget'),
            'valueAndDetail'              => __('Value & Detail', 'abjad-widget'),
            'calculatebastet'             => __('Calculate Bastet', 'abjad-widget'),
            'bastetOrder'                 => __('Bastet order', 'abjad-widget'),
            'bastetTable'                 => __('Bastet table', 'abjad-widget'),
            'bastetShadda'                => __('Bastet shadda', 'abjad-widget'),
            'bast'                        => __('bast', 'abjad-widget'),
            'calculatehuddam'             => __('Calculate Huddam', 'abjad-widget'),
            'unseparator_newline'         => __('[new-line]', 'abjad-widget'),
            'unseparator_tab'              => __('[tab]', 'abjad-widget'),
            'unseparator_dot'               => __('[dot]', 'abjad-widget'),
            'unseparator_comma'              => __('[comma]', 'abjad-widget'),
            'unseparator_parenthesis'        => __('[parenthesis]', 'abjad-widget'),
            'unseparator_ARABIC_comma'       => __('[arabic comma]', 'abjad-widget'),
            'unseparator_semicolon'           => __('[semicolon]', 'abjad-widget'),
            'unseparator_ARABIC_semicolon'    => __('[arabic semicolon]', 'abjad-widget'),
            'unseparator_ayah_end'             => __('[end of ayah]', 'abjad-widget'),
            'unseparator_ARABIC_parenthesis'   => __('[arabic parenthesis]', 'abjad-widget'),
            'unseparator_quotes'                => __('[quote]', 'abjad-widget'),
            'unseparator_space'                 => __('[space]', 'abjad-widget'),
            'abjadSettings'                 => __('Abjad Settings', 'abjad-widget'),
            
            // Abjad sekmesi etiketleri
            'abjad_order_label'        => __('Abjad order', 'abjad-widget'),
            'abjad_table_label'        => __('Abjad table', 'abjad-widget'),
            'shadda_label'             => __('Shadda letters', 'abjad-widget'),
            'element_method_label'     => __('Element classification method', 'abjad-widget'),
            'details_label'            => __('Calculation details', 'abjad-widget'),
        );
    }

    /**
     * Outputs the widget script in the footer.
     */
    public function output_widget_script() {
        $options = get_option('abjad_widget_settings');
        if (empty($options['enabled'])) return;
        
        $plugin_url = trailingslashit(plugin_dir_url(__FILE__));
        // Global config for keyboard.js
        echo '<script>window.abjadWidgetConfig = window.abjadWidgetConfig || {}; window.abjadWidgetConfig.pluginUrl = "' . esc_js($plugin_url) . '";</script>';        
        
        // Abjad kütüphanesi
        wp_enqueue_script(
            $this->plugin_name . '-abjad',
            $plugin_url . 'js/abjad.min.js',
            array('jquery'),
            $this->version,
            true
        );
        
        // Sanal klavye
        wp_enqueue_script(
            $this->plugin_name . '-keyboard',
            $plugin_url . 'js/keyboard.js',
            array($this->plugin_name . '-abjad'),
            $this->version,
            true
        );
        
        // DİNAMİK JS - AJAX ÜZERİNDEN
        $ajax_url = admin_url('admin-ajax.php?action=abjad_widget_js');
        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            $ajax_url .= '&min=1';
        }
 
        // Keyboard i18n - update VKI_i18n object
        $translations = $this->get_translation_strings();
        $keyboard_i18n_script = "
if (typeof VKI_i18n !== 'undefined') {
    VKI_i18n['00'] = '" . esc_js($translations['keyboard_00']) . "';
    VKI_i18n['01'] = '" . esc_js($translations['keyboard_01']) . "';
    VKI_i18n['02'] = '" . esc_js($translations['keyboard_02']) . "';
    VKI_i18n['03'] = '" . esc_js($translations['keyboard_03']) . "';
    VKI_i18n['04'] = '" . esc_js($translations['keyboard_04']) . "';
    VKI_i18n['05'] = '" . esc_js($translations['keyboard_05']) . "';
    VKI_i18n['06'] = '" . esc_js($translations['keyboard_06']) . "';
    VKI_i18n['07'] = '" . esc_js($translations['keyboard_07']) . "';
    VKI_i18n['08'] = '" . esc_js($translations['keyboard_08']) . "';
    VKI_i18n['09'] = '" . esc_js($translations['keyboard_09']) . "';
    VKI_i18n['10'] = '" . esc_js($translations['keyboard_10']) . "';
    VKI_i18n['11'] = '" . esc_js($translations['keyboard_11']) . "';
}";
        wp_add_inline_script($this->plugin_name . '-keyboard', $keyboard_i18n_script);        
        wp_enqueue_script(
            $this->plugin_name . '-widget',
            $ajax_url, // Artık admin-ajax.php'ye istek yapıyor
            array($this->plugin_name . '-keyboard', 'jquery'),
            $this->version,
            true
        );
              
        // Localize script with translations and config
		wp_localize_script($this->plugin_name . '-widget', 'abjadWidgetData', array(
			'i18n'    => $translations,
			'config'  => array(
				'id'          => esc_attr($options['id']),
				'color'       => esc_attr($options['color']),
				'position'    => esc_attr($options['position']),
				'message'     => esc_attr($options['message']),
				'description' => esc_attr($options['description']),
				'button_type' => isset($options['button_type']) ? esc_attr($options['button_type']) : 'emoji',
				'button_emoji' => isset($options['button_emoji']) ? esc_attr($options['button_emoji']) : '🔮',
				'button_svg' => isset($options['button_svg']) ? $options['button_svg'] : '',
				'button_png_url' => isset($options['button_png_url']) ? esc_url($options['button_png_url']) : '',
				'pluginUrl'   => $plugin_url
			)
		));
    }
}
