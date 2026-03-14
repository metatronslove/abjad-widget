(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Sekme yönetimi
        function initTabs() {
            var hash = window.location.hash;
            
            if (hash) {
                var tab = hash.replace('#', '');
                $('.nav-tab-wrapper a[href="#' + tab + '"]').trigger('click');
            }
        }
        
        // Renk seçici
        if ($.fn.wpColorPicker) {
            $('.color-picker').wpColorPicker({
                change: function(event, ui) {
                    $(this).trigger('input');
                }
            });
        }
        
        // Buton tipi göster/gizle
        function toggleButtonOptions() {
            var selected = $('input[name="abjad_widget_settings[button_type]"]:checked').val();
            
            $('.button-option').hide();
            $('.button-option-' + selected).show();
        }
        
        $('input[name="abjad_widget_settings[button_type]"]').on('change', toggleButtonOptions);
        toggleButtonOptions();
        
        // Sekme tıklamaları
        $('.nav-tab-wrapper a').on('click', function(e) {
            e.preventDefault();
            
            var target = $(this).attr('href').replace('#', '');
            
            $('.nav-tab-wrapper a').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            
            $('.abjad-settings-tab-content').hide();
            $('#tab-' + target).show();
            
            window.location.hash = target;
        });
        
        // Sayfa yüklendiğinde sekmeyi göster
        initTabs();
        
        // Form gönderimi öncesi doğrulama
        $('form').on('submit', function(e) {
            var isValid = true;
            
            // Buton PNG URL kontrolü
            var buttonType = $('input[name="abjad_widget_settings[button_type]"]:checked').val();
            if (buttonType === 'png') {
                var pngUrl = $('#button_png_url').val();
                if (pngUrl && !/^https?:\/\//i.test(pngUrl)) {
                    alert('Geçerli bir URL giriniz.');
                    isValid = false;
                }
            }
            
            return isValid;
        });
        
        // Önizleme güncelleme (style editor için)
        if ($('#custom_css').length) {
            var previewStyle = $('#preview-style');
            
            $('#custom_css').on('keyup change', function() {
                previewStyle.html($(this).val());
            });
        }
        
        // Dashboard iframe yükleme kontrolü
        var iframe = $('.abjad-dashboard-iframe');
        if (iframe.length) {
            iframe.on('load', function() {
                $(this).css('opacity', 1);
            });
        }
    });
    
})(jQuery);
