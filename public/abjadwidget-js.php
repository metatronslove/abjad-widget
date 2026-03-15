<?php
/**
 * Abjad Widget Dynamic JavaScript Generator
 *
 * This is the ONLY JavaScript file for the widget in production.
 * It reads all settings from database and generates the widget code dynamically.
 *
 * @package AbjadWidget
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Content-Type: text/plain' );
	echo '// Direct access not allowed';
	exit;
}

// JavaScript header'ı gönder
header( 'Content-Type: application/javascript; charset=UTF-8' );
header( 'X-Content-Type-Options: nosniff' );

// Cache kontrolü
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
	header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
} else {
	header( 'Cache-Control: public, max-age=3600' );
	header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + 3600 ) . ' GMT' );
}

// =========================================================================
// VERİTABANINDAN TÜM AYARLARI OKU
// =========================================================================

$abjad_widget_options = get_option( 'abjad_widget_settings', array(
	'id'			=> 'metatronslove',
	'color'		 => '#FFDD00',
	'position'	  => 'right',
	'message'	   => 'Like my projects? Buy me a coffee!',
	'description'   => 'Support occult tools',
	'enabled'	   => 1,
	'button_type'   => 'emoji',
	'button_emoji'  => '🔮',
	'button_svg'	=> '',
	'button_png_url' => ''
) );

$abjad_widget_style_options = get_option( 'abjad_widget_style', array( 'custom_css' => '' ) );
$abjad_widget_code_options  = get_option( 'abjad_widget_code', array( 'custom_js' => '' ) );

$abjad_widget_plugin_url = plugin_dir_url( __FILE__ );

// =========================================================================
// BUTON İÇERİĞİNİ OLUŞTUR
// =========================================================================

$abjad_widget_button_content = '🔮';
switch ( $abjad_widget_options['button_type'] ) {
	case 'emoji':
		$abjad_widget_button_content = ! empty( $abjad_widget_options['button_emoji'] ) ? $abjad_widget_options['button_emoji'] : '🔮';
		break;
	case 'svg':
		$abjad_widget_button_content = ! empty( $abjad_widget_options['button_svg'] ) ? trim( $abjad_widget_options['button_svg'] ) : '🔮';
		break;
	case 'png':
		$abjad_widget_button_content = ! empty( $abjad_widget_options['button_png_url'] )
			? '<img src="' . esc_url( $abjad_widget_options['button_png_url'] ) . '" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">'
			: '🔮';
		break;
}

// =========================================================================
// VARSAYILAN WIDGET KODU (DAHİLİ)
// =========================================================================

$abjad_widget_default_js = <<<'EOT'
/**
 * abjadwidget.js – Occult Abjad Calculator Widget
 * 
 * The widget will appear as a floating button. Use data-* attributes to configure:
 *   data-id="metatronslove"	   (Buy Me a Coffee username)
 *   data-color="#FFDD00"		   (button color)
 *   data-position="right"		  (left/right)
 *   data-message="Support me"	  (button message)
 *   data-description="Like my work?" (description)
 */
	// =========================================================================
	// ANİMASYONLU GÖSTER/GİZLE
	// =========================================================================

	function fadeIn(el, duration) {
		el.style.opacity = 0;
		el.style.display = '';
		var start = performance.now();
		
		function animate(current) {
			var elapsed = current - start;
			var progress = Math.min(elapsed / duration, 1);
			el.style.opacity = progress;
			if (progress < 1) {
				requestAnimationFrame(animate);
			}
		}
		
		requestAnimationFrame(animate);
	}

	function fadeOut(el, duration) {
		el.style.opacity = 1;
		var start = performance.now();
		
		function animate(current) {
			var elapsed = current - start;
			var progress = Math.min(elapsed / duration, 1);
			el.style.opacity = 1 - progress;
			if (progress < 1) {
				requestAnimationFrame(animate);
			} else {
				el.style.display = 'none';
			}
		}
		
		requestAnimationFrame(animate);
	}

	function HideAndSeek(tohide, toshow, duration, delay) {
		setTimeout(() => {
			tohide.forEach(function(sel) {
				document.querySelectorAll(sel).forEach(function(el) {
					fadeOut(el, duration);
				});
			});
			toshow.forEach(function(sel) {
				document.querySelectorAll(sel).forEach(function(el) {
					fadeIn(el, duration);
				});
			});
		}, delay);
	}

	function HideAndView(order) {
		var firstEl = document.getElementById(order[0].toString());
		if (!firstEl) return;
		
		var duration = 450;
		
		if (firstEl.style.display == 'none') {
			let s = 0;
			function showNext() {
				if (s < order.length) {
					var el = document.getElementById(order[s].toString());
					if (el) {
						fadeIn(el, duration / order.length * 3);
					}
					s++;
					setTimeout(showNext, duration / order.length);
				}
			}
			showNext();
		} else {
			let h = order.length - 1;
			function hideNext() {
				if (h >= 0) {
					var el = document.getElementById(order[h].toString());
					if (el) {
						fadeOut(el, duration / order.length * 3);
					}
					h--;
					setTimeout(hideNext, duration / order.length);
				}
			}
			hideNext();
		}
	}

(function(global, $) {
	'use strict';

	// =========================================================================
	// YARDIMCI FONKSİYONLAR
	// =========================================================================

	function __(key) {
		return window.abjadWidgetI18n && window.abjadWidgetI18n[key] ? window.abjadWidgetI18n[key] : key;
	}

	function $(id) {
		return document.getElementById(window.widgetId + '-' + id);
	}

	function getSetting(id) {
		var el = document.getElementById(window.widgetId + '-' + id);
		return el ? el.value : null;
	}

	function setSetting(id, val) {
		var el = document.getElementById(window.widgetId + '-' + id);
		if (el) el.value = val;
	}

	// =========================================================================
	// SEKMELER
	// =========================================================================
	
	function switchTab(tabId) {
		window.widgetState.activeTab = tabId;
		document.querySelectorAll('.' + window.widgetId + '-tab').forEach(function(t) {
			t.classList.toggle('active', t.dataset.tab === tabId);
		});
		document.querySelectorAll('.' + window.widgetId + '-tab-content').forEach(function(c) {
			c.style.display = c.dataset.tab === tabId ? 'block' : 'none';
		});
		if (tabId !== 'settings' && tabId !== 'support') calculations('reload');
	}

	// =========================================================================
	// VERİ TİPİ FONKSİYONLARI
	// =========================================================================

	function getDataType() {
		return getSetting('abjaddatatype') || 'auto';
	}

	function setDataType(needs) {
		var ChoosenType = getDataType();
		var RegularExpressions = [];
		var ARABIC = '\u0600-\u065F\u066A-\u06EF\u06FA-\u06FFﭖﭺﮊﮒﻻﯓ';
		var hebrew = '\u0590-\u05FF\uFB2A-\uFB4E';
		var turkce = 'a-zA-ZĞÜŞİÖÇığüşöçİı';
		var arnums = '0-9';
		var innums = '\u0660-\u0669';
		RegularExpressions.push(ARABIC, hebrew, turkce, arnums, innums);
		
		if (needs >= 0 && needs < 5) {
			return RegularExpressions[needs];
		} else {
			if (ChoosenType == 'auto') {
				var Quantities = [];
				var EnteredData = document.getElementById(window.widgetId + '-abjadtextentry') ? document.getElementById(window.widgetId + '-abjadtextentry').value : '';
				if (EnteredData.trim() == "") {
					return needs == 5 ? 0 : RegularExpressions[0];
				}
				for (var x = 0; x < RegularExpressions.length; x += 1) {
					var StringIsNow = '[' + RegularExpressions[x] + ']';
					var RegexIsNow = new RegExp(StringIsNow, 'g');
					var MatchIsNow = EnteredData.match(RegexIsNow);
					var LengthSNow = MatchIsNow ? MatchIsNow.length : 0;
					Quantities.push(LengthSNow);
				}
				var LargestData = Math.max.apply(null, Quantities);
				for (var l = 0; l < Quantities.length; l += 1) {
					if (LargestData == Quantities[l]) {
						return needs == 5 ? l : RegularExpressions[l];
					}
				}
			} else {
				if (needs == 5) return parseInt(ChoosenType);
				else return RegularExpressions[parseInt(ChoosenType)] || RegularExpressions[0];
			}
		}
	}

	// =========================================================================
	// ÜST SİMGE DÖNÜŞÜMÜ
	// =========================================================================

	function toSuperscript(num) {
		return num.toString()
			.replace(/0/g, '⁰')
			.replace(/1/g, '¹')
			.replace(/2/g, '²')
			.replace(/3/g, '³')
			.replace(/4/g, '⁴')
			.replace(/5/g, '⁵')
			.replace(/6/g, '⁶')
			.replace(/7/g, '⁷')
			.replace(/8/g, '⁸')
			.replace(/9/g, '⁹');
	}

	// =========================================================================
	// SEPARATOR İŞLEMLERİ
	// =========================================================================

	function unseparator(text, section) {
		if (!text) return '';
		
		switch (section) {
			case 'first':
				return text.replace(/\n$/g, __('newline'))
					.replace(/\t$/g, __('tab'))
					.replace(/\.$/g, __('dot'))
					.replace(/\,$/g, __('comma'))
					.replace(/\($|\)$/g, __('parenthesis'))
					.replace(/\،‎$/g, __('ARABIC_comma'))
					.replace(/\;$/g, __('semicolon'))
					.replace(/\؛‎$/g, __('ARABIC_semicolon'))
					.replace(/\۝$/g, __('ayah_end'))
					.replace(/\﴾$|\﴿$/g, __('ARABIC_parenthesis'))
					.replace(/\"$|\`$/g, __('quotes'))
					.replace(/\s$|\ $/g, __('space'));
				
			case 'firstserie':
				return text.replace(/[^0-9]+/g, ',');
				
			case 'second':
				return text.replace(/\n$/g, '\\n')
					.replace(/\r\n$/g, '\\n')
					.replace(/\t$/g, '\\t')
					.replace(/(\"|\`)/g, '\u0027')
					.replace(/\"/g, '\u0022')
					.replace(/\ $/g, '\\s');
				
			case 'secondserie':
				var separatorregex = '[';
				var separatorCheckboxes = document.querySelectorAll('input[name="' + window.widgetId + '-separator"]:checked');
				separatorCheckboxes.forEach(function(checkbox) {
					separatorregex += checkbox.value + '|';
				});
				if (separatorregex.charAt(separatorregex.length - 1) == '|') {
					separatorregex = separatorregex.slice(0, -1);
				}
				separatorregex += ']';
				
				var sregex = new RegExp(separatorregex, 'g');
				
				if (sregex.toString() == '/[]/g') {
					sregex = new RegExp('(^[' + setDataType(getDataType()) + ']+)$', 'g');
					return text.replace(sregex, '$1');
				} else {
					return text.replace(sregex, ',').replace(/,+/g, ',');
				}
				
			default:
				return text;
		}
	}

	// =========================================================================
	// SEPARATOR TESPİT VE GÖSTERİM
	// =========================================================================

	function valuelength(identity) {
		var eleman = document.getElementById(window.widgetId + '-' + identity);
		if (eleman) {
			var attr = eleman.getAttribute('data-indices');
			if (attr) {
				var miktar = attr.split(',').length;
				return toSuperscript(miktar);
			}
		}
		return '';
	}

	function isChecked(identity) {
		var eleman = document.getElementById(window.widgetId + '-' + identity);
		if (eleman) {
			if (eleman.getAttribute('data-force-checked') === 'true' || eleman.checked) {
				return 'checked';
			}
		}
		return '';
	}

	function prepareMulticlick(attributes) {
		var selectEl = document.getElementById(window.widgetId + '-select' + attributes);
		if (!selectEl) return;
		
		var indices = selectEl.getAttribute('data-indices');
		if (!indices) return;
		
		var checked = selectEl.checked;
		var indexArray = indices.split(',');
		
		indexArray.forEach(function(idx) {
			var cb = document.getElementById(window.widgetId + '-separator' + idx);
			if (cb) {
				if (checked && !cb.checked) {
					cb.click();
				} else if (!checked && cb.checked) {
					cb.click();
				}
			}
		});
	}

	function shapeentry() {
		var ta = document.getElementById(window.widgetId + '-abjadtextentry');
		if (!ta) return;
		
		var separator = ta.value;
		var entrySeparatorsDiv = document.getElementById(window.widgetId + '-entryseparators');
		if (!entrySeparatorsDiv) return;
		
		var ARABIC = [];
		var hebrew = [];
		var turkce = [];
		var arnums = [];
		var innums = [];
		var found = [];
		
		var seperation = `<label class="dataentry">${__('dataEntrySeparators')}</label><span class="entryseparators">`;
		
		var groupLabels = {
			ARABIC: __('ARABICLetters'),
			hebrew: __('hebrewLetters'),
			turkce: __('turkishLetters'),
			arnums: __('ARABICNumbers'),
			innums: __('indianNumbers')
		};
		var langGroups = ['ARABIC', 'hebrew', 'turkce', 'arnums', 'innums'];
		langGroups.forEach(function(group) {
			seperation += `<nowrap class="select${group}" style="display:none;">
				<input type="checkbox" id="${window.widgetId}-select${group}" name="${window.widgetId}-selectall" value="${group}" ${isChecked('select' + group)}>
				<label for="${window.widgetId}-select${group}">${groupLabels[group]} <strong>${valuelength('select' + group)}</strong></label>
			</nowrap>`;
		});
		
		for (var i = 0; i < separator.length; i += 1) {
			var regularexp = new RegExp('[^' + setDataType(getDataType()) + ']', 'g');
			var match = separator[i].match(regularexp);
			
			if (match && found.indexOf(match[0]) == -1) {
				found.push(match[0]);
				var passive = [];
				
				for (var c = 0; c < 5; c += 1) {
					if (c != setDataType(5)) {
						var passiveregex = new RegExp('(^[' + setDataType(c) + ']+)$', 'g');
						var nmatch = separator[i].match(passiveregex);
						if (nmatch && passive.indexOf(nmatch[0]) == -1) {
							passive.push(nmatch[0]);
							if (c == 0) ARABIC.push(i);
							if (c == 1) hebrew.push(i);
							if (c == 2) turkce.push(i);
							if (c == 3) arnums.push(i);
							if (c == 4) innums.push(i);
						}
					}
				}
				
				seperation += `<nowrap>
					<input type="checkbox" id="${window.widgetId}-separator${i}" name="${window.widgetId}-separator" value="${unseparator(separator[i], 'second')}" ${isChecked('separator' + i)}>
					<label for="${window.widgetId}-separator${i}">${unseparator(separator[i], 'first')}</label>
				</nowrap>`;
			}
		}
		
		seperation += `</span>`;
		entrySeparatorsDiv.innerHTML = seperation;
		
		var groups = [
			{ name: 'ARABIC', indices: ARABIC },
			{ name: 'hebrew', indices: hebrew },
			{ name: 'turkce', indices: turkce },
			{ name: 'arnums', indices: arnums },
			{ name: 'innums', indices: innums }
		];
		
		groups.forEach(function(group) {
			var selectEl = document.getElementById(window.widgetId + '-select' + group.name);
			var container = document.querySelector('.select' + group.name);
			
			if (selectEl && container) {
				if (group.indices.length > 1) {
					container.style.display = 'inline-block';
					selectEl.setAttribute('data-indices', group.indices.join(','));
					
					selectEl.addEventListener('change', function() {
						prepareMulticlick(group.name);
					});
				} else {
					container.style.display = 'none';
					if (selectEl.checked) selectEl.click();
				}
			}
		});
		
		var commaCheckboxes = document.querySelectorAll('input[value=","]');
		commaCheckboxes.forEach(function(cb) {
			if (!cb.checked) {
				cb.setAttribute('data-force-checked', 'true');
				cb.click();
			}
			
			cb.addEventListener('click', function(e) {
				if (!this.checked && this.getAttribute('data-force-checked') !== 'true') {
					e.preventDefault();
					alert(__('comaDefaultMessage'));
					this.checked = true;
				}
			});
		});
		
		document.querySelectorAll('input[name="' + window.widgetId + '-separator"]').forEach(function(cb) {
			cb.removeEventListener('change', separatorChangeHandler);
			cb.addEventListener('change', separatorChangeHandler);
		});
		
		function separatorChangeHandler() {
			seconder(ta.value, 'dothat');
			shapeentry();
		}
		
		seconder(ta.value, 'dothat');
		SetForProfile();
		calculations('reload');
	}

	// =========================================================================
	// SECONDER (METNİ AYRIŞTIR)
	// =========================================================================

	function seconder(serie, content) {
		if (!serie || serie.trim() == '') {
			var sourcetoabjad = document.getElementById(window.widgetId + '-sourcetoabjad');
			if (sourcetoabjad) sourcetoabjad.setAttribute('latest', '');
			var phrasesPreview = document.getElementById(window.widgetId + '-phrasespreview');
			if (phrasesPreview) phrasesPreview.innerHTML = '<center>' + __('no_data') + '</center>';
			return content == 'list' ? [] : null;
		}
		
		var series = unseparator(serie, 'secondserie');
		
		var lastchar = series.charAt(series.length - 1);
		var firstchar = series.charAt(0);
		if (lastchar == ',') series = series.slice(0, -1);
		if (firstchar == ',') series = series.slice(1);
		
		var seriestwoleest = series.split(',');
		var sourcetoabjad = document.getElementById(window.widgetId + '-sourcetoabjad');
		
		if (sourcetoabjad) {
			sourcetoabjad.setAttribute('latest', series);
		}
		
		var separatorsEl = document.getElementById(window.widgetId + '-separators');
		var phrasesPreview = document.getElementById(window.widgetId + '-phrasespreview');
		
		if (seriestwoleest.length > 0 && seriestwoleest[0] != "") {
			if (separatorsEl) separatorsEl.value = seriestwoleest.length;
			var phraseshtml = '';
			var numbering = 1;
			for (var phrases = 0; phrases < seriestwoleest.length; phrases += 1) {
				if (seriestwoleest[phrases] && seriestwoleest[phrases].trim() != "") {
					phraseshtml += `<p class="phrase"><span class="metin">${seriestwoleest[phrases]}</span><span class="porder">${numbering}</span></p>`;
					numbering += 1;
				}
			}
			if (phrasesPreview) phrasesPreview.innerHTML = phraseshtml;
		} else {
			if (separatorsEl) separatorsEl.value = 0;
			if (phrasesPreview) phrasesPreview.innerHTML = '<center>' + __('no_data') + '</center>';
		}
		
		if (content == 'list') return seriestwoleest;
	}

	// =========================================================================
	// ENABLE/DISABLE
	// =========================================================================

	function EnableDisable(identity, toenable, todisable, toselect) {
		var selectEl = document.getElementById(window.widgetId + '-' + identity);
		if (!selectEl) return;
		
		var someselected = 0;
		
		for (let e = 0; e < toenable.length; e += 1) {
			var opt = selectEl.querySelector('option[value="' + toenable[e] + '"]');
			if (opt) {
				opt.disabled = false;
				if (opt.selected) someselected = 1;
				else if (opt.hasAttribute('data-selectedbefore')) {
					opt.selected = true;
					opt.removeAttribute('data-selectedbefore');
					someselected = 1;
				}
			}
		}
		
		for (let d = 0; d < todisable.length; d += 1) {
			var opt = selectEl.querySelector('option[value="' + todisable[d] + '"]');
			if (opt) {
				if (opt.selected) {
					opt.selected = false;
					opt.setAttribute('data-selectedbefore', 'true');
				}
				opt.disabled = true;
			}
		}
		
		if (!someselected && toselect != "") {
			var opt = selectEl.querySelector('option[value="' + toselect + '"]');
			if (opt) opt.selected = true;
		}
	}

	// =========================================================================
	// PROFİL AYARLARI
	// =========================================================================

	function SetForProfile() {
		var dataType5 = setDataType(5);
		
		if (dataType5 == 0) {
			EnableDisable('sourcehuddam', [], ['entereddatas'], '');
			EnableDisable('bastetaddquantity', ['0', '1'], [], '0');
			EnableDisable('usebastetelement', ['0', '1'], [], '0');
			EnableDisable('abjadorder', ['0,ARABIC', '6', '11', '16', '21', '26', '31'], ['0,hebrew', '0,turkish'], '0,ARABIC');
			EnableDisable('elementguide', ['ARABI', 'BUNI', 'HUSEYNI', 'REGULAR'], ['TURKCE', 'HEBREW'], 'REGULAR');
		} else if (dataType5 == 1) {
			EnableDisable('sourcehuddam', [], ['entereddatas'], '');
			EnableDisable('bastetaddquantity', ['0', '1'], [], '0');
			EnableDisable('usebastetelement', ['0', '1'], [], '0');
			EnableDisable('abjadorder', ['0,hebrew'], ['0,ARABIC', '6', '11', '16', '21', '26', '31', '0,turkish'], '0,hebrew');
			EnableDisable('elementguide', ['HEBREW'], ['TURKCE', 'ARABI', 'BUNI', 'HUSEYNI', 'REGULAR'], 'HEBREW');
		} else if (dataType5 == 2) {
			EnableDisable('sourcehuddam', [], ['entereddatas'], '');
			EnableDisable('bastetaddquantity', ['0', '1'], [], '0');
			EnableDisable('usebastetelement', ['0', '1'], [], '0');
			EnableDisable('abjadorder', ['0,turkish'], ['0,ARABIC', '6', '11', '16', '21', '26', '31', '0,hebrew'], '0,turkish');
			EnableDisable('elementguide', ['TURKCE'], ['ARABI', 'BUNI', 'HUSEYNI', 'HEBREW', 'REGULAR'], 'TURKCE');
		} else {
			EnableDisable('sourcehuddam', ['entereddatas'], [], '');
			EnableDisable('bastetaddquantity', ['0'], ['1'], '0');
			EnableDisable('usebastetelement', ['0', '1'], [], '0');
			
			var langBastet = getSetting('languagebastet') || 'ARABIC';
			
			if (langBastet == 'ARABIC') {
				EnableDisable('abjadorder', ['0,ARABIC', '6', '11', '16', '21', '26', '31'], ['0,hebrew', '0,turkish'], '0,ARABIC');
				EnableDisable('elementguide', ['ARABI', 'BUNI', 'HUSEYNI', 'REGULAR'], ['TURKCE', 'HEBREW'], 'REGULAR');
			} else if (langBastet == 'hebrew') {
				EnableDisable('abjadorder', ['0,hebrew'], ['0,ARABIC', '6', '11', '16', '21', '26', '31', '0,turkish'], '0,hebrew');
				EnableDisable('elementguide', ['HEBREW'], ['TURKCE', 'ARABI', 'BUNI', 'HUSEYNI', 'REGULAR'], 'HEBREW');
			} else if (langBastet == 'turkce') {
				EnableDisable('abjadorder', ['0,turkish'], ['0,ARABIC', '6', '11', '16', '21', '26', '31', '0,hebrew'], '0,turkish');
				EnableDisable('elementguide', ['TURKCE'], ['ARABI', 'BUNI', 'HUSEYNI', 'HEBREW', 'REGULAR'], 'TURKCE');
			}
		}
		
		var langBastet = getSetting('languagebastet') || 'ARABIC';
		
		if (langBastet == 'ARABIC') {
			EnableDisable('bastetorder', ['0,ARABIC', '6', '11', '16', '21', '26', '31'], ['0,hebrew', '0,turkish'], '0,ARABIC');
			EnableDisable('bastelementguide', ['ARABI', 'BUNI', 'HUSEYNI', 'REGULAR'], ['TURKCE', 'HEBREW'], 'REGULAR');
		} else if (langBastet == 'hebrew') {
			EnableDisable('bastetorder', ['0,hebrew'], ['0,ARABIC', '6', '11', '16', '21', '26', '31', '0,turkish'], '0,hebrew');
			EnableDisable('bastelementguide', ['HEBREW'], ['TURKCE', 'ARABI', 'BUNI', 'HUSEYNI', 'REGULAR'], 'HEBREW');
		} else if (langBastet == 'turkce') {
			EnableDisable('bastetorder', ['0,turkish'], ['0,ARABIC', '6', '11', '16', '21', '26', '31', '0,hebrew'], '0,turkish');
			EnableDisable('bastelementguide', ['TURKCE'], ['ARABI', 'BUNI', 'HUSEYNI', 'HEBREW', 'REGULAR'], 'TURKCE');
		}
	}

	// =========================================================================
	// MULTICLICK SİSTEMİ
	// =========================================================================

	function multiclickelement(header) {
		var all = document.getElementById(window.widgetId + '-' + header + 'all');
		var fire = document.getElementById(window.widgetId + '-' + header + 'fire');
		var air = document.getElementById(window.widgetId + '-' + header + 'air');
		var water = document.getElementById(window.widgetId + '-' + header + 'water');
		var earth = document.getElementById(window.widgetId + '-' + header + 'earth');
		
		if (!all) return;
		
		if (all.checked) {
			if (fire && !fire.checked) fire.click();
			if (air && !air.checked) air.click();
			if (water && !water.checked) water.click();
			if (earth && !earth.checked) earth.click();
		} else {
			if (fire && fire.checked) fire.click();
			if (air && air.checked) air.click();
			if (water && water.checked) water.click();
			if (earth && earth.checked) earth.click();
		}
		
		calculations('reload');
	}

function updateAllCheckboxState(header) {
	var all = document.getElementById(window.widgetId + '-' + header + 'all');
	var fire = document.getElementById(window.widgetId + '-' + header + 'fire');
	var air = document.getElementById(window.widgetId + '-' + header + 'air');
	var water = document.getElementById(window.widgetId + '-' + header + 'water');
	var earth = document.getElementById(window.widgetId + '-' + header + 'earth');
	
	if (!all) return;
	
	var allChecked = true;
	var anyChecked = false;
	
	[fire, air, water, earth].forEach(function(cb) {
		if (cb) {
			if (!cb.checked) allChecked = false;
			if (cb.checked) anyChecked = true;
		}
	});
	
	all.checked = allChecked;
	all.indeterminate = anyChecked && !allChecked;
	
	// Force modda all checkbox'ını da devre dışı bırak
	if (header == 'bastet' && getSetting('forcerules') == 'force') {
		all.disabled = true;
	} else {
		all.disabled = false;
	}
}

	function prepareForMulticlick(header) {
		var all = document.getElementById(window.widgetId + '-' + header + 'all');
		var fire = document.getElementById(window.widgetId + '-' + header + 'fire');
		var air = document.getElementById(window.widgetId + '-' + header + 'air');
		var water = document.getElementById(window.widgetId + '-' + header + 'water');
		var earth = document.getElementById(window.widgetId + '-' + header + 'earth');
		
		if (!all) return;
		
		all.addEventListener('click', function() {
			setTimeout(function() {
				multiclickelement(header);
			}, 10);
		});
		
		[fire, air, water, earth].forEach(function(cb) {
			if (cb) {
				cb.addEventListener('change', function() {
					updateAllCheckboxState(header);
					calculations('reload');
				});
			}
		});
		
		updateAllCheckboxState(header);
	}

	// =========================================================================
	// SEÇİLEN ELEMENTLERİ AL
	// =========================================================================

	function hidekeys() {				
		shapeentry();
		if (typeof VKI_close === 'function') VKI_close();
	}

	function showkeys() {
		shapeentry();
	}
	
	function calchuddam() {
		calculations('huddam');
	}

	function checkAbjadFunctions() {
		if (typeof window.abjad !== 'function') return false;
		if (typeof window.nutket !== 'function') return false;
		if (typeof window.unsur !== 'function') return false;
		if (typeof window.saf !== 'function') return false;
		if (typeof window.huddam !== 'function') return false;
		if (typeof window.numbers2arab !== 'function') return false;
		return true;
	}

	// =========================================================================
	// SHAPE FONKSİYONLARI
	// =========================================================================

	function shapeabjad() {
		var calcAbjad = document.getElementById(window.widgetId + '-calculateabjad');
		if (!calcAbjad) return;
		
		if (calcAbjad.value == "dont") {
			HideAndSeek(
				[".abjadorder", ".abjadtable", ".abjadshadda", ".abjaddetail", ".elementguide", ".abjadelemental"],
				[], 450, 900
			);
			EnableDisable('forcerules', [], ['force'], 'allow');
			EnableDisable('sourcebastet', [], ['abjadresults', 'abjadtotal'], 'entereddatas');
			EnableDisable('sourcehuddam', ['bastetresults'], ['abjadresults'], 'bastetresults');
			
			var res = document.getElementById(window.widgetId + '-abjadresults');
			if (res) res.innerHTML = "<center>" + __('abjad_not_viewed') + "</center>";
		} else if (calcAbjad.value == "calculate") {
			HideAndSeek(
				[], 
				[".abjadorder", ".abjadtable", ".abjadshadda", ".abjaddetail", ".elementguide", ".abjadelemental"],
				450, 900
			);
			EnableDisable('forcerules', ['force'], [], 'force');
			EnableDisable('sourcebastet', ['abjadresults', 'abjadtotal'], [], 'abjadresults');
			EnableDisable('sourcehuddam', ['abjadresults'], [], 'bastetresults');
			
			var res = document.getElementById(window.widgetId + '-abjadresults');
			if (res) res.innerHTML = "<center>" + __('abjad_not_calculated') + "</center>";
			
			var all = document.getElementById(window.widgetId + '-abjadall');
			if (all) {
				all.addEventListener('click', function() { multiclickelement('abjad'); });
			}
		}
	}

function shapebastet() {
	var calcBastet = document.getElementById(window.widgetId + '-calculatebastet');
	var forceRules = getSetting('forcerules');
	if (!calcBastet) return;
	
	// Ana bastet hesaplama kontrolleri
	if (calcBastet.value == 'dont') {
		HideAndSeek(
			[".sourcebastet", ".languagebastet", ".bastetrepetation", ".bastetdetail", 
			 ".usebastetelement", ".bastetaddquantity", ".bastetorder", ".bastettable", 
			 ".bastetshadda", ".bastelementguide", ".bastelemental"],
			[], 450, 900
		);
		EnableDisable('sourcehuddam', [], ['bastetresults'], 'entereddatas');
		
	} else if (calcBastet.value == 'calculate') {
		
		// FORCE RULES KONTROLÜ - ORİJİNAL MANTIK
		if (forceRules == 'force') {
			// Force modda: Tüm bastet ayarları gizlenir
			HideAndSeek(
				[".bastetorder", ".bastettable", ".bastetshadda", ".bastelementguide", ".bastelemental"],
				[], 450, 900
			);
			// Sadece temel ayarlar görünür kalır
			HideAndSeek(
				[], 
				[".sourcebastet", ".languagebastet", ".bastetrepetation", ".bastetdetail", 
				 ".usebastetelement", ".bastetaddquantity"],
				450, 900
			);
		} else {
			// Normal mod: Tüm ayarlar görünür
			HideAndSeek(
				[], 
				[".sourcebastet", ".languagebastet", ".bastetrepetation", ".bastetdetail", 
				 ".usebastetelement", ".bastetaddquantity", ".bastetorder", ".bastettable", 
				 ".bastetshadda", ".bastelementguide", ".bastelemental"],
				450, 900
			);
		}
		
		EnableDisable('sourcehuddam', ['bastetresults'], [], 'bastetresults');
		
		var all = document.getElementById(window.widgetId + '-bastetall');
		if (all) {
			all.addEventListener('click', function() { multiclickelement('bastet'); });
		}
	}
	
	var res = document.getElementById(window.widgetId + '-bastetresults');
	if (res) {
		if (calcBastet.value == 'dont') {
			res.innerHTML = "<center>" + __('bast_not_viewed') + "</center>";
		} else if (calcBastet.value == 'calculate') {
			res.innerHTML = "<center>" + __('bast_not_calculated') + "</center>";
		}
	}
}

function shapehuddam() {
	var forceRules = getSetting('forcerules');
	var calcHuddam = document.getElementById(window.widgetId + '-calculatehuddam');
	var huddamOrder = document.getElementById(window.widgetId + '-huddamorder');
	var huddamOrderClassElements = document.getElementsByClassName('huddamorder');
	
	if (!calcHuddam) return;
	
	if (forceRules == 'force' || calcHuddam.value == 'dont') {
		if (huddamOrder) {
			Array.from(huddamOrderClassElements).forEach(function(element) {
				element.style.display = 'none';
			});
		}
	} else {
		if (huddamOrder) {
			Array.from(huddamOrderClassElements).forEach(function(element) {
				element.style.display = '';
			});
		}
	}
	
	if (calcHuddam.value == 'dont') {
		HideAndSeek([".sourcehuddam", ".dutytype", ".huddammode"], [], 450, 900);
		var res = document.getElementById(window.widgetId + '-huddamresults');
		if (res) res.innerHTML = "<center>" + __('huddam_not_viewed') + "</center>";
	} else if (calcHuddam.value == 'calculate') {
		HideAndSeek([], [".sourcehuddam", ".dutytype", ".huddammode"], 450, 900);
		
		var res = document.getElementById(window.widgetId + '-huddamresults');
		if (res) res.innerHTML = "<center>" + __('huddam_not_calculated') + "</center>";
	}
}
// =========================================================================
// YARDIMCI FONKSİYONLAR
// =========================================================================

function SettingForced(forced, allowed) {
	return getSetting('forcerules') == 'force' ? forced : allowed;
}

function getElements(stringtext, shadda, guide) {
	var fireChecked, airChecked, waterChecked, earthChecked;
	
	// SettingForced ile doğru element ID'lerini kullan
	fireChecked = document.getElementById(window.widgetId + '-' + SettingForced('abjadfire', 'bastetfire'))?.checked || false;
	airChecked = document.getElementById(window.widgetId + '-' + SettingForced('abjadair', 'bastetair'))?.checked || false;
	waterChecked = document.getElementById(window.widgetId + '-' + SettingForced('abjadwater', 'bastetwater'))?.checked || false;
	earthChecked = document.getElementById(window.widgetId + '-' + SettingForced('abjadearth', 'bastetearth'))?.checked || false;
	
	var elementspoint = (fireChecked ? 1 : 0) + (airChecked ? 1 : 0) + (waterChecked ? 1 : 0) + (earthChecked ? 1 : 0);
	
	if (elementspoint == 0) {
		return getSetting('purify') == 'purify' ? 
			window.saf(stringtext.toString(), "", shadda).toString() : 
			stringtext.toString();
	} else if (elementspoint < 4) {
		var elements = "";
		if (fireChecked) elements += window.unsur(stringtext.toString(), 1, 0, shadda, guide) || '';
		if (airChecked) elements += window.unsur(stringtext.toString(), 1, 1, shadda, guide) || '';
		if (waterChecked) elements += window.unsur(stringtext.toString(), 1, 2, shadda, guide) || '';
		if (earthChecked) elements += window.unsur(stringtext.toString(), 1, 3, shadda, guide) || '';
		
		if (guide == 'TURKCE' || guide == 0) {
			elements = elements.toLocaleUpperCase('tr-TR');
		}
		return elements.toString();
	} else {
		return getSetting('purify') == 'purify' ? 
			window.saf(stringtext.toString(), "", shadda).toString() : 
			stringtext.toString();
	}
}

function getCodeFor(funqtion) {
	var forceRules = getSetting('forcerules');
	
	if (funqtion == 'abjad') {
		var order = parseFloat((getSetting('abjadorder') || '0,ARABIC').split(',')[0]);
		var tablo = parseFloat(getSetting('abjadtable') || '1');
		return tablo < 5 ? order + tablo : tablo;
	} else if (funqtion == 'bastet') {
		if (forceRules == 'force') return getCodeFor('abjad');
		var order = parseFloat((getSetting('bastetorder') || '0,ARABIC').split(',')[0]);
		var tablo = parseFloat(getSetting('bastettable') || '1');
		return tablo < 5 ? order + tablo : tablo;
	} else if (funqtion == 'huddam') {
		if (forceRules == 'force') {
			var order = parseFloat((getSetting('abjadorder') || '0,ARABIC').split(',')[0]);
			var tablo = parseFloat(getSetting('huddammode') || '1');
			return order + tablo;
		} else {
			var order = parseFloat(getSetting('huddamorder') || '0');
			var tablo = parseFloat(getSetting('huddammode') || '1');
			return order + tablo;
		}
	}
}

function sumofarray(anarray) {
	var sum = 0;
	for (let a = 0; a < anarray.length; a += 1) {
		var val = parseFloat(anarray[a]);
		if (!isNaN(val)) sum += val;
	}
	return sum;
}

function HintToArab(number) {
	return number.toString().replace(/٠/g, '0').replace(/١/g, '1').replace(/٢/g, '2').replace(/٣/g, '3').replace(/٤/g, '4').replace(/٥/g, '5').replace(/٦/g, '6').replace(/٧/g, '7').replace(/٨/g, '8').replace(/٩/g, '9');
}

function DisplayIfThere(reference, identity) {
	var el = document.getElementById(reference || identity);
	return el && el.style.display != 'none' ? '' : 'style="display: none;"';
}

// =========================================================================
// ANA HESAPLAMA FONKSİYONU
// =========================================================================

function calculations(identity) {
	if (!checkAbjadFunctions()) {
		var errorMsg = "<center style='color:#f00;'>" + __('abjad_not_calculated') + " (Missing core functions)</center>";
		var abjadResDiv = document.getElementById(window.widgetId + '-abjadresults');
		var bastetResDiv = document.getElementById(window.widgetId + '-bastetresults');
		var huddamResDiv = document.getElementById(window.widgetId + '-huddamresults');
		if (abjadResDiv) abjadResDiv.innerHTML = errorMsg;
		if (bastetResDiv) bastetResDiv.innerHTML = errorMsg;
		if (huddamResDiv) huddamResDiv.innerHTML = errorMsg;
		return;
	}

	var languagebastet = getSetting('languagebastet') || 'ARABIC';
	var autoCalc = getSetting('autocalculate');
	var calcAbjad = getSetting('calculateabjad');
	var calcBastet = getSetting('calculatebastet');
	var calcHuddam = getSetting('calculatehuddam');

	// =========================================================================
	// ABJAD HESAPLAMA
	// =========================================================================
	
	if (autoCalc == 'calculate' && calcAbjad == 'calculate') {
		if (identity == 'abjad' || identity == 'reload') {
			var guide = getSetting('elementguide');
			if (languagebastet == 'hebrew') guide = 'HEBREW';
			if (languagebastet == 'turkce') guide = 'TURKCE';
			
			var shadda = parseFloat(getSetting('abjadshadda') || '1');
			var sourcetoabjad = document.getElementById(window.widgetId + '-sourcetoabjad');
			if (!sourcetoabjad) return;
			
			var processdata = (sourcetoabjad.getAttribute('latest') || '').split(',');
			var abjadtotal = 0;
			var entryorder = 1;
			var resultsset = [];
			var resultview = [];
			var detailMode = getSetting('abjaddetail') == '1';
			
			// Element seçimlerini kontrol et
			var elementspoint = 0;
			if (document.getElementById(window.widgetId + '-abjadfire')?.checked) elementspoint += 1;
			if (document.getElementById(window.widgetId + '-abjadair')?.checked) elementspoint += 1;
			if (document.getElementById(window.widgetId + '-abjadwater')?.checked) elementspoint += 1;
			if (document.getElementById(window.widgetId + '-abjadearth')?.checked) elementspoint += 1;

			var tableHtml = `<table class="abjadresults"><tr ${DisplayIfThere("", "resultsheader")} id="resultsheader"><th class="abjadresults">${__('order')}</th><th class="abjadresults">${__('entry')}</th><th class="abjadresults">${detailMode ? __('valueAndDetail') : __('value')}</th></tr>`;
			resultview.push("#resultsheader");

			for (var l = 0; l < processdata.length; l += 1) {
				var item = processdata[l].toString().trim();
				if (item == "") continue;

				// Veri tipine göre işle
				var processed = item;
				var dataType = setDataType(5);
				if (dataType == 3) {
					processed = window.nutket(parseFloat(item), languagebastet);
				} else if (dataType == 4) {
					processed = window.nutket(parseFloat(HintToArab(item)), languagebastet);
				}

				// Elementleri ekle
				var elements = "";
				if (elementspoint < 4) {
					if (document.getElementById(window.widgetId + '-abjadfire')?.checked) 
						elements += window.unsur(processed, 1, 0, shadda, guide) || '';
					if (document.getElementById(window.widgetId + '-abjadair')?.checked) 
						elements += window.unsur(processed, 1, 1, shadda, guide) || '';
					if (document.getElementById(window.widgetId + '-abjadwater')?.checked) 
						elements += window.unsur(processed, 1, 2, shadda, guide) || '';
					if (document.getElementById(window.widgetId + '-abjadearth')?.checked) 
						elements += window.unsur(processed, 1, 3, shadda, guide) || '';
				} else {
					elements = processed;
				}

				if (guide == 'TURKCE' || guide == 0) {
					elements = elements.toLocaleUpperCase('tr-TR');
				}

				// Ebced hesapla
				var sum = 0;
				var detail = "";
				
				if (getSetting('purify') == 'purify') {
					sum = window.abjad(window.saf(elements, "", shadda), getCodeFor('abjad'), shadda);
					if (detailMode) detail = window.abjad(window.saf(elements, "", shadda), getCodeFor('abjad'), shadda, 1);
				} else {
					sum = window.abjad(elements, getCodeFor('abjad'), shadda);
					if (detailMode) detail = window.abjad(elements, getCodeFor('abjad'), shadda, 1);
				}

				resultsset.push(sum);
				abjadtotal += (typeof sum === 'number' && !isNaN(sum)) ? sum : 0;

				var displaySum = getSetting('digits') == 'innums' ? window.numbers2arab(sum) : sum;
				var displayDetail = getSetting('digits') == 'innums' ? window.numbers2arab(detail) : detail;

				if (detailMode) {
					// Detayları formatla
					var detailFormatted = "";
					if (detail) {
						var detailarray = detail.toString().split('/');
						for (let d = 0; d < detailarray.length; d += 1) {
							if (detailarray[d].trim() != "") {
								detailFormatted += "[" + detailarray[d].trim() + "]";
							}
						}
					}
					
					tableHtml += `<tr ${DisplayIfThere("", "satir" + entryorder)} id="satir${entryorder}">`;
					tableHtml += `<th rowspan="2"><span ${DisplayIfThere("", "order" + entryorder)} id="order${entryorder}">${entryorder}</span></th>`;
					tableHtml += `<td rowspan="2"><span style="display:none;" id="elements${entryorder}">${elements}</span></td>`;
					tableHtml += `<td><span style="display:none;" id="sum${entryorder}">${displaySum}</span></td>`;
					tableHtml += `</tr>`;
					tableHtml += `<tr ${DisplayIfThere("", "dsatir" + entryorder)} id="dsatir${entryorder}">`;
					tableHtml += `<td><span style="display:none;" id="detail${entryorder}">${detailFormatted}</span></td>`;
					tableHtml += `</tr>`;
					
					resultview.push("#satir" + entryorder, "#dsatir" + entryorder, "#order" + entryorder, "#elements" + entryorder, "#sum" + entryorder, "#detail" + entryorder);
				} else {
					tableHtml += `<tr ${DisplayIfThere("", "satir" + entryorder)} id="satir${entryorder}">`;
					tableHtml += `<th class="abjadresults"><span ${DisplayIfThere("", "order" + entryorder)} id="order${entryorder}">${entryorder}</span></th>`;
					tableHtml += `<td class="abjadresults"><span style="display:none;" id="elements${entryorder}">${elements}</span></td>`;
					tableHtml += `<td class="abjadresults"><span style="display:none;" id="sum${entryorder}">${displaySum}</span></td>`;
					tableHtml += `</tr>`;
					
					resultview.push("#satir" + entryorder, "#order" + entryorder, "#elements" + entryorder, "#sum" + entryorder);
				}
				entryorder += 1;
			}

			if (entryorder > 2) {
				var displayTotal = getSetting('digits') == 'innums' ? window.numbers2arab(abjadtotal) : abjadtotal;
				tableHtml += `<tr ${DisplayIfThere("", "sumssatir")} id="sumssatir">`;
				tableHtml += `<th colspan="2" class="abjadresults"><span ${DisplayIfThere("", "sumofsums")} id="sumofsums">${__('total')}</span></th>`;
				tableHtml += `<th class="abjadresults"><span style="display:none;" id="sumofsumx">${displayTotal}</span></th>`;
				tableHtml += `</tr>`;
				resultview.push("#sumssatir", "#sumofsums", "#sumofsumx");
			}
			tableHtml += `</table>`;

			var abjadResDiv = document.getElementById(window.widgetId + '-abjadresults');
			if (resultsset.length > 0) {
				if (abjadResDiv) abjadResDiv.innerHTML = tableHtml;
				HideAndSeek([], resultview, 450, 0);
			} else {
				if (abjadResDiv) abjadResDiv.innerHTML = "<center>" + __('abjad_not_calculated') + "</center>";
			}

			// Bastet için kaynak verilerini güncelle
			var sourcetobastet = document.getElementById(window.widgetId + '-sourcetobastet');
			if (sourcetobastet) {
				sourcetobastet.setAttribute('latest', resultsset.join(','));
				sourcetobastet.setAttribute('latesttotal', abjadtotal);
				sourcetobastet.setAttribute('sourcetoabjad', sourcetoabjad.getAttribute('latest') || '');
			}
		}
	}

	// =========================================================================
	// BASTET HESAPLAMA (ORİJİNAL MANTIKLA, KOMPLEKS YAPIDA)
	// =========================================================================
	
	if (autoCalc == 'calculate' && calcBastet == 'calculate') {
		if (identity == 'bastet' || identity == 'reload') {
			// Guide ve shadda ayarları
			var guide = getSetting(SettingForced('elementguide', 'bastelementguide'));
			if (languagebastet == 'hebrew') guide = 'HEBREW';
			if (languagebastet == 'turkce') guide = 'TURKCE';
			
			var bastshadda = parseFloat(getSetting(SettingForced('abjadshadda', 'bastetshadda')) || '1');
			var bastetrepetation = parseInt(getSetting('bastetrepetation')) || 5;
			
			var sourcetobastet = document.getElementById(window.widgetId + '-sourcetobastet');
			var sourcetoabjad = document.getElementById(window.widgetId + '-sourcetoabjad');
			if (!sourcetobastet || !sourcetoabjad) return;

			var bastettotal = 0;
			var entryorder = 1;
			var processset = [];
			var bastetview = [];
			var bastetset = [];
			var detailMode = getSetting('bastetdetail') == '1';

			// Kaynak verilerini al
			var source = getSetting('sourcebastet') || 'abjadresults';
			if (source == 'abjadresults') {
				processset = (sourcetobastet.getAttribute('latest') || '').split(',');
			} else if (source == 'abjadtotal') {
				processset = [sourcetobastet.getAttribute('latesttotal') || 0];
			} else if (source == 'entereddatas') {
				processset = (sourcetoabjad.getAttribute('latest') || '').split(',');
			} else if (source == 'datastotal') {
				var enteredData = (sourcetoabjad.getAttribute('latest') || '').split(',');
				processset = [sumofarray(enteredData)];
			}

			// Tablo başlığı
			var tableHtml = `<table class="abjadresults">`;
			
			if (detailMode) {
				tableHtml += `<center>${__('click_row_for_details')}</center>`;
			}
			
			tableHtml += `<tr ${DisplayIfThere("", "bastresultsheader")} id="bastresultsheader">`;
			tableHtml += `<th class="abjadresults">${__('order')}</th>`;
			tableHtml += `<th class="abjadresults">${__('entry')}</th>`;
			tableHtml += `<th class="abjadresults">${bastetrepetation}. ${__('bast')}</th>`;
			tableHtml += `</tr>`;
			bastetview.push("#bastresultsheader");

			// Her bir girdi için işlem
			for (var l = 0; l < processset.length; l += 1) {
				var item = processset[l].toString().trim();
				if (item == "") continue;

				var elements;
				var dataType = setDataType(5);
				var baster = 0;
				
				// Girdi tipine göre elementi hazırla
				if (source == 'entereddatas' || source == 'datastotal') {
					if (dataType < 3) {
						// Harf tabanlı girdi - elementleri uygula
						var purified = getSetting('purify') == 'purify' ? window.saf(item, "", bastshadda) : item;
						elements = getElements(purified, bastshadda, guide);
						baster = parseFloat(window.abjad(elements, getCodeFor('bastet'), bastshadda));
						if (getSetting('bastetaddquantity') == "1") {
							baster += parseFloat(window.abjad(elements, 5, bastshadda));
						}
					} else if (dataType == 3) {
						elements = parseFloat(item);
						baster = elements;
					} else if (dataType == 4) {
						elements = parseFloat(HintToArab(item));
						baster = elements;
					}
				} else {
					elements = parseFloat(item);
					baster = elements;
				}

				var istintak = window.nutket(baster, languagebastet);
				
				// Detaylar için dizi
				var bastValues = [baster];
				var istintakValues = [istintak];
				var abjadValues = [parseFloat(window.abjad(istintak, getCodeFor('bastet'), bastshadda))];
				var elementLettersArray = [''];
				
				// Bast döngüleri
				for (let rep = 0; rep < bastetrepetation; rep += 1) {
					if (getSetting('usebastetelement') == '1') {
						// Her döngüde elementleri yeniden hesapla
						var elementLetters = getElements(istintak, bastshadda, guide);
						var elementAbjad = parseFloat(window.abjad(elementLetters, getCodeFor('bastet'), bastshadda));
						var elementQuantity = parseFloat(window.abjad(elementLetters, 5, bastshadda));
						
						baster = elementAbjad + elementQuantity;
						elementLettersArray.push(elementLetters);
					} else {
						// Element kullanmadan devam et
						var istintakAbjad = parseFloat(window.abjad(istintak, getCodeFor('bastet'), bastshadda));
						var istintakQuantity = parseFloat(window.abjad(istintak, 5, bastshadda));
						
						baster = istintakAbjad + istintakQuantity;
						elementLettersArray.push('');
					}
					
					istintak = window.nutket(baster, languagebastet);
					
					bastValues.push(baster);
					istintakValues.push(istintak);
					abjadValues.push(parseFloat(window.abjad(istintak, getCodeFor('bastet'), bastshadda)));
				}

				// Son değeri kaydet
				var finalBaster = bastValues[bastValues.length - 1];
				bastetset.push(finalBaster);
				bastettotal += (typeof finalBaster === 'number' && !isNaN(finalBaster)) ? finalBaster : 0;
				
				var displayBaster = getSetting('digits') == 'innums' ? window.numbers2arab(finalBaster) : finalBaster;

				// DETAYLI GÖSTERİM (ORİJİNAL KOMPLEKS YAPI)
				if (detailMode) {
					var bastetDetails = '';
					var bastetDetailView = [];
					
					// Detay başlığı
					bastetDetails += `<tr ${DisplayIfThere("bastdetailsatir" + entryorder, "detailts" + entryorder)} id="detailts${entryorder}"><td colspan="3">`;
					
					// Açıklama metni
					if (source == 'entereddatas' || source == 'datastotal') {
						if (dataType < 3) {
							bastetDetails += `${__('for_phrase')} "${item}" ${__('abjad_calculated')} `;
						} else {
							bastetDetails += `${__('for_number')} ${item} ${__('number_space')}`;
						}
					} else {
						bastetDetails += `${__('for_number')} ${processset[l]} ${__('number_space')}`;
					}
					
					if (getSetting('bastetaddquantity') == "1") {
						bastetDetails += `${__('with_quantity_added')} `;
					}
					
					bastetDetails += `${bastetrepetation} ${__('bast_times')}.`;
					bastetDetails += `</td></tr>`;
					
					// Detay tablosu başlığı
					if (bastetrepetation > 0) {
						bastetDetails += `<tr ${DisplayIfThere("bastdetailsatir" + entryorder, "detailsheader" + entryorder)} id="detailsheader${entryorder}">`;
						bastetDetails += `<th>${__('value')}</th>`;
						bastetDetails += `<th>${__('pronunciation')} (${__('abjad_value')})</th>`;
						
						if (getSetting('usebastetelement') == '1') {
							bastetDetails += `<th>${__('used_letters')} (${__('quantity')}; ${__('element_abjad')})</th>`;
						} else {
							bastetDetails += `<th>${__('used_letters')}</th>`;
						}
						bastetDetails += `</tr>`;
						bastetDetailView.push("detailsheader" + entryorder);
					}
					
					// Her bir bast adımı
					for (let rep = 0; rep < bastetrepetation; rep += 1) {
						var loopId = "bast" + entryorder + "loop" + rep;
						
						bastetDetails += `<tr ${DisplayIfThere("bastdetailsatir" + entryorder, loopId)} id="${loopId}">`;
						bastetDetails += `<td>${bastValues[rep]}</td>`;
						bastetDetails += `<td>${istintakValues[rep]} (${abjadValues[rep]})</td>`;
						
						if (getSetting('usebastetelement') == '1') {
							var elementLetters = elementLettersArray[rep + 1] || '';
							var elementQuantity = elementLetters ? parseFloat(window.abjad(elementLetters, 5, bastshadda)) : 0;
							var elementAbjad = elementLetters ? parseFloat(window.abjad(elementLetters, getCodeFor('bastet'), bastshadda)) : 0;
							
							bastetDetails += `<td>${elementLetters} (${elementQuantity}; ${elementAbjad})</td>`;
						} else {
							bastetDetails += `<td>${__('all')}</td>`;
						}
						
						bastetDetails += `</tr>`;
						bastetDetailView.push(loopId);
					}
					
					// Ana satır (tıklanabilir)
					var detailViewString = "'bastdetailsatir" + entryorder + "','bastdetails" + entryorder + "','detailts" + entryorder + "','detailsheader" + entryorder + "'," + 
										   bastetDetailView.map(id => "'" + id + "'").join(',');
					
					tableHtml += `<tr onclick="HideAndView([${detailViewString}]);" ${DisplayIfThere("", "bastsatir" + entryorder)} id="bastsatir${entryorder}">`;
					tableHtml += `<th class="abjadresults"><span ${DisplayIfThere("", "bastorder" + entryorder)} id="bastorder${entryorder}">${entryorder}</span></th>`;
					tableHtml += `<td class="abjadresults"><span style="display:none;" id="bastelements${entryorder}">${elements}</span></td>`;
					tableHtml += `<td class="abjadresults"><span style="display:none;" id="baster${entryorder}">${displayBaster}</span></td>`;
					tableHtml += `</tr>`;
					
					// Detay satırı (gizli)
					tableHtml += `<tr ${DisplayIfThere("", "bastdetailsatir" + entryorder)} id="bastdetailsatir${entryorder}" style="display:none;">`;
					tableHtml += `<td colspan="3" class="abjadresults">`;
					tableHtml += `<table ${DisplayIfThere("bastdetailsatir" + entryorder, "bastdetails" + entryorder)} class="bastetdetails" id="bastdetails${entryorder}">`;
					tableHtml += bastetDetails;
					tableHtml += `</table>`;
					tableHtml += `</td>`;
					tableHtml += `</tr>`;
					
					bastetview.push("#bastsatir" + entryorder, "#bastorder" + entryorder, "#bastelements" + entryorder, "#baster" + entryorder);
					
				} else {
					// Basit gösterim
					tableHtml += `<tr ${DisplayIfThere("", "bastsatir" + entryorder)} id="bastsatir${entryorder}">`;
					tableHtml += `<th class="abjadresults"><span ${DisplayIfThere("", "bastorder" + entryorder)} id="bastorder${entryorder}">${entryorder}</span></th>`;
					tableHtml += `<td class="abjadresults"><span style="display:none;" id="bastelements${entryorder}">${elements}</span></td>`;
					tableHtml += `<td class="abjadresults"><span style="display:none;" id="baster${entryorder}">${displayBaster}</span></td>`;
					tableHtml += `</tr>`;
					
					bastetview.push("#bastsatir" + entryorder, "#bastorder" + entryorder, "#bastelements" + entryorder, "#baster" + entryorder);
				}
				
				entryorder += 1;
			}

			// Toplam satırı
			if (entryorder > 2) {
				var displayTotal = getSetting('digits') == 'innums' ? window.numbers2arab(bastettotal) : bastettotal;
				tableHtml += `<tr ${DisplayIfThere("", "bastssatir")} id="bastssatir">`;
				tableHtml += `<th colspan="2" class="abjadresults"><span ${DisplayIfThere("", "sumofbasts")} id="sumofbasts">${__('total')}</span></th>`;
				tableHtml += `<th class="abjadresults"><span style="display:none;" id="sumofbastx">${displayTotal}</span></th>`;
				tableHtml += `</tr>`;
				bastetview.push("#bastssatir", "#sumofbasts", "#sumofbastx");
			}
			tableHtml += `</table>`;

			var bastetResDiv = document.getElementById(window.widgetId + '-bastetresults');
			if (bastetset.length > 0) {
				if (bastetResDiv) bastetResDiv.innerHTML = tableHtml;
				HideAndSeek([], bastetview, 450, 0);
			} else {
				if (bastetResDiv) bastetResDiv.innerHTML = "<center>" + __('bast_not_calculated') + "</center>";
			}

			// Huddam için kaynak verilerini güncelle
			var sourcetohuddam = document.getElementById(window.widgetId + '-sourcetohuddam');
			if (sourcetohuddam) {
				sourcetohuddam.setAttribute('entrysource', sourcetoabjad ? sourcetoabjad.getAttribute('latest') : '');
				sourcetohuddam.setAttribute('entrysource', (sourcetohuddam.getAttribute('entrysource') || '') + ',' + sumofarray((sourcetohuddam.getAttribute('entrysource') || '').split(',')));
				sourcetohuddam.setAttribute('abjadsource', (sourcetobastet.getAttribute('latest') || '') + ',' + (sourcetobastet.getAttribute('latesttotal') || 0));
				sourcetohuddam.setAttribute('bastetsource', bastetset.join(',') + ',' + bastettotal);
			}
		}
	}

	// =========================================================================
	// HUDDAM HESAPLAMA (ORİJİNAL MANTIKLA)
	// =========================================================================
	
	if (autoCalc == 'calculate' && calcHuddam == 'calculate') {
		if (identity == 'huddam' || identity == 'reload') {
			var sourcetohuddam = document.getElementById(window.widgetId + '-sourcetohuddam');
			if (!sourcetohuddam) return;

			var procexxet = [];
			var source = getSetting('sourcehuddam') || 'bastetresults';
			
			if (source == 'bastetresults') {
				procexxet = (sourcetohuddam.getAttribute('bastetsource') || '').split(',');
			} else if (source == 'abjadresults') {
				procexxet = (sourcetohuddam.getAttribute('abjadsource') || '').split(',');
			} else if (source == 'entereddatas') {
				procexxet = (sourcetohuddam.getAttribute('entrysource') || '').split(',');
			}

			// Verileri sayısal değerlere çevir
			var numericValues = [];
			for (var i = 0; i < procexxet.length; i++) {
				var val = parseFloat(procexxet[i]);
				if (!isNaN(val)) {
					numericValues.push(val);
				}
			}

			if (numericValues.length > 0) {
				var tableHtml = `<table class="abjadresults">`;
				tableHtml += `<tr ${DisplayIfThere("", "huddamresultsheader")} id="huddamresultsheader">`;
				tableHtml += `<th class="abjadresults">${__('order')}</th>`;
				tableHtml += `<th class="abjadresults">${__('entry')}</th>`;
				
				// Seçili hadim türlerini ekle
				var dutyTypes = [];
				if (document.getElementById(window.widgetId + '-ulvihadim')?.checked) {
					tableHtml += `<th class="abjadresults">${__('ulvi')}</th>`;
					dutyTypes.push('ULVI');
				}
				if (document.getElementById(window.widgetId + '-suflihadim')?.checked) {
					tableHtml += `<th class="abjadresults">${__('sufli')}</th>`;
					dutyTypes.push('SUFLI');
				}
				if (document.getElementById(window.widgetId + '-serhadim')?.checked) {
					tableHtml += `<th class="abjadresults">${__('ser')}</th>`;
					dutyTypes.push('ŞER');
				}
				if (document.getElementById(window.widgetId + '-ownhadim')?.checked) {
					var suffix = getSetting('ownsuffix') || '';
					tableHtml += `<th class="abjadresults">${suffix}</th>`;
					dutyTypes.push(suffix);
				}
				tableHtml += `</tr>`;

				var huddamview = ["#huddamresultsheader"];
				var entryorder = 1;

				// Her bir değer için hadim ismi üret
				for (var l = 0; l < numericValues.length; l += 1) {
					var val = numericValues[l];
					
					tableHtml += `<tr ${DisplayIfThere("", "huddamresults" + entryorder)} id="huddamresults${entryorder}">`;
					
					// Sıra veya toplam
					if (l == numericValues.length - 1 && numericValues.length > 1) {
						tableHtml += `<th class="abjadresults">${__('total')}</th>`;
					} else {
						tableHtml += `<th class="abjadresults">${entryorder}</th>`;
					}
					
					// Girdi değeri
					tableHtml += `<td class="abjadresults">${val}</td>`;

					// Her hadim türü için isim
					dutyTypes.forEach(function(type) {
						tableHtml += `<td class="abjadresults">${window.huddam(val, type, getCodeFor('huddam'))}</td>`;
					});

					tableHtml += `</tr>`;
					
					if (l < numericValues.length - 1) {
						huddamview.push("#huddamresults" + entryorder);
					}
					entryorder += 1;
				}
				
				tableHtml += `</table>`;

				var huddamResDiv = document.getElementById(window.widgetId + '-huddamresults');
				if (huddamResDiv) huddamResDiv.innerHTML = tableHtml;
				HideAndSeek([], huddamview, 450, 0);
				
			} else {
				var huddamResDiv = document.getElementById(window.widgetId + '-huddamresults');
				if (huddamResDiv) huddamResDiv.innerHTML = "<center>" + __('huddam_not_calculated') + "</center>";
			}
		}
	}
}

	// =========================================================================
	// TAB İÇERİKLERİNİ OLUŞTURMA
	// =========================================================================

	function buildAbjadTab(container) {
		var div = document.createElement('div');
		div.className = window.widgetId + '-tab-content';
		div.dataset.tab = 'abjad';
		div.style.display = 'none';
		div.innerHTML = `
			<textarea id="${window.widgetId}-abjadtextentry" placeholder="${__('dataEntryPlaceholder')}" class="keyboardInput"></textarea>
			
			<div id="${window.widgetId}-entryseparators" class="${window.widgetId}-inline" style="flex-wrap:wrap; align-items:flex-start;">
				<!-- Separator checkboxes will be dynamically added here -->
			</div>
			
			<div class="${window.widgetId}-inline">
				<label>${__('dataTypeProfile')}:</label>
				<select id="${window.widgetId}-abjaddatatype" class="abjadselect">
					<option value="auto" selected>${__('autoDetect')}</option>
					<option value="0">${__('ARABIC')}</option>
					<option value="1">${__('hebrew')}</option>
					<option value="2">${__('turkish')}</option>
					<option value="3">${__('ARABICNumbers')}</option>
					<option value="4">${__('indianNumbers')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline">
				<label><strong>${__('possiblePhrases')}:</strong></label>
				<input readonly id="${window.widgetId}-separators" class="abjadselect">
			</div>
			
			<div id="${window.widgetId}-phrasespreview" class="phrasespreview"></div>
			
			<h4>${__('abjadSettings')}</h4>
			
			<div class="${window.widgetId}-inline">
				<label>${__('calculateabjad')}:</label>
				<select id="${window.widgetId}-calculateabjad" class="abjadselect" identity="abjad">
					<option value="calculate" selected>${__('calculate')}</option>
					<option value="dont">${__('dont')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline abjadorder">
				<label>${__('abjadOrder')}:</label>
				<select id="${window.widgetId}-abjadorder" class="abjadselect" identity="abjad">
					<option value="0,ARABIC" selected>${__('hisabElCumel')}</option>
					<option value="0,hebrew">${__('gematria')}</option>
					<option value="0,turkish">${__('turkishAlphabetAbjad')}</option>
					<option value="6">${__('maghribianAbjad')}</option>
					<option value="11">${__('quranFrequency')}</option>
					<option value="16">${__('hijaOrder')}</option>
					<option value="21">${__('maghribianHijaOrder')}</option>
					<option value="26">${__('iklilsOrder')}</option>
					<option value="31">${__('shamseeAbjadOrder')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline abjadtable">
				<label>${__('abjadTable')}:</label>
				<select id="${window.widgetId}-abjadtable" class="abjadselect" identity="abjad">
					<option value="0">${__('asgari')}</option>
					<option value="1" selected>${__('saghir')}</option>
					<option value="2">${__('kabir')}</option>
					<option value="3">${__('akbar')}</option>
					<option value="4">${__('saghirPlusLetterCount')}</option>
					<option value="5">${__('letterCount')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline abjadshadda">
				<label>${__('shadda')}:</label>
				<select id="${window.widgetId}-abjadshadda" class="abjadselect" identity="abjad">
					<option value="1" selected>${__('countOnce')}</option>
					<option value="2">${__('countTwice')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline abjaddetail">
				<label>${__('details')}:</label>
				<select id="${window.widgetId}-abjaddetail" class="abjadselect" identity="abjad">
					<option value="0" selected>${__('dontShow')}</option>
					<option value="1">${__('showDetail')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline elementguide">
				<label>${__('elementMethod')}:</label>
				<select id="${window.widgetId}-elementguide" class="abjadselect" identity="abjad">
					<option value="TURKCE">${__('turkishElements')}</option>
					<option value="ARABI">${__('ibniArabi')}</option>
					<option value="BUNI">${__('ahmadAlBuni')}</option>
					<option value="HUSEYNI">${__('sulaymanAlHuseyni')}</option>
					<option value="HEBREW">${__('hebrewElements')}</option>
					<option value="REGULAR" selected>${__('regularClassification')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline abjadelemental">
				<label>${__('addElements')}:</label>
				<span class="elementcheckbox">
					<label><input type="checkbox" id="${window.widgetId}-abjadall" value="0"> ${__('all')}</label>
					<label><input type="checkbox" id="${window.widgetId}-abjadfire" value="0"> ${__('fire')}</label>
					<label><input type="checkbox" id="${window.widgetId}-abjadair" value="1"> ${__('air')}</label>
					<label><input type="checkbox" id="${window.widgetId}-abjadwater" value="2"> ${__('water')}</label>
					<label><input type="checkbox" id="${window.widgetId}-abjadearth" value="3"> ${__('earth')}</label>
				</span>
			</div>
			
			<div id="${window.widgetId}-abjadresults" class="abjadresults"></div>
		`;
		container.appendChild(div);
	}

	function buildBastetTab(container) {
		var div = document.createElement('div');
		div.className = window.widgetId + '-tab-content';
		div.dataset.tab = 'bastet';
		div.style.display = 'none';
		div.innerHTML = `
			<div class="${window.widgetId}-inline">
				<label>${__('calculatebastet')}:</label>
				<select id="${window.widgetId}-calculatebastet" class="abjadselect" identity="reload">
					<option value="calculate" selected>${__('calculate')}</option>
					<option value="dont">${__('dont')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline sourcebastet">
				<label>${__('bastSource')}:</label>
				<select id="${window.widgetId}-sourcebastet" class="abjadselect" identity="reload">
					<option value="abjadresults" selected>${__('useAbjadResults')}</option>
					<option value="abjadtotal">${__('useAbjadTotal')}</option>
					<option value="entereddatas">${__('useEnteredData')}</option>
					<option value="datastotal">${__('useDataTotal')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline languagebastet">
				<label>${__('bastLanguage')}:</label>
				<select id="${window.widgetId}-languagebastet" class="abjadselect" identity="reload">
					<option value="ARABIC" selected>${__('ARABIC')}</option>
					<option value="hebrew">${__('hebrew')}</option>
					<option value="turkce">${__('turkish')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline bastetrepetation">
				<label>${__('bastRepetition')}:</label>
				<input type="number" id="${window.widgetId}-bastetrepetation" class="abjadselect" identity="reload" value="5" min="0" step="1">
			</div>
			
			<div class="${window.widgetId}-inline bastetorder">
				<label>${__('bastetOrder')}:</label>
				<select id="${window.widgetId}-bastetorder" class="abjadselect" identity="reload">
					<option value="0,ARABIC" selected>${__('hisabElCumel')}</option>
					<option value="0,hebrew">${__('gematria')}</option>
					<option value="0,turkish">${__('turkishAlphabetAbjad')}</option>
					<option value="6">${__('maghribianAbjad')}</option>
					<option value="11">${__('quranFrequency')}</option>
					<option value="16">${__('hijaOrder')}</option>
					<option value="21">${__('maghribianHijaOrder')}</option>
					<option value="26">${__('iklilsOrder')}</option>
					<option value="31">${__('shamseeAbjadOrder')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline bastettable">
				<label>${__('bastetTable')}:</label>
				<select id="${window.widgetId}-bastettable" class="abjadselect" identity="reload">
					<option value="0">${__('asgari')}</option>
					<option value="1" selected>${__('saghir')}</option>
					<option value="2">${__('kabir')}</option>
					<option value="3">${__('akbar')}</option>
					<option value="4">${__('saghirPlusLetterCount')}</option>
					<option value="5">${__('letterCount')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline bastetshadda">
				<label>${__('bastetShadda')}:</label>
				<select id="${window.widgetId}-bastetshadda" class="abjadselect" identity="reload">
					<option value="1" selected>${__('countOnce')}</option>
					<option value="2">${__('countTwice')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline bastetaddquantity">
				<label>${__('bastAddQuantity')}:</label>
				<select id="${window.widgetId}-bastetaddquantity" class="abjadselect" identity="reload">
					<option value="0" selected>${__('no')}</option>
					<option value="1">${__('yes')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline bastetdetail">
				<label>${__('bastDetail')}:</label>
				<select id="${window.widgetId}-bastetdetail" class="abjadselect" identity="reload">
					<option value="0" selected>${__('dontShow')}</option>
					<option value="1">${__('showDetail')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline usebastetelement">
				<label>${__('bastUseElement')}:</label>
				<select id="${window.widgetId}-usebastetelement" class="abjadselect" identity="reload">
					<option value="0" selected>${__('onlyBeginning')}</option>
					<option value="1">${__('allRepetitions')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline bastelementguide">
				<label>${__('bastElementGuide')}:</label>
				<select id="${window.widgetId}-bastelementguide" class="abjadselect" identity="reload">
					<option value="TURKCE">${__('turkishElements')}</option>
					<option value="ARABI">${__('ibniArabi')}</option>
					<option value="BUNI">${__('ahmadAlBuni')}</option>
					<option value="HUSEYNI">${__('sulaymanAlHuseyni')}</option>
					<option value="HEBREW">${__('hebrewElements')}</option>
					<option value="REGULAR" selected>${__('regularClassification')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline bastelemental">
				<label>${__('addElements')}:</label>
				<span class="elementcheckbox">
					<label><input type="checkbox" id="${window.widgetId}-bastetall" value="0"> ${__('all')}</label>
					<label><input type="checkbox" id="${window.widgetId}-bastetfire" value="0"> ${__('fire')}</label>
					<label><input type="checkbox" id="${window.widgetId}-bastetair" value="1"> ${__('air')}</label>
					<label><input type="checkbox" id="${window.widgetId}-bastetwater" value="2"> ${__('water')}</label>
					<label><input type="checkbox" id="${window.widgetId}-bastetearth" value="3"> ${__('earth')}</label>
				</span>
			</div>
			
			<div id="${window.widgetId}-bastetresults" class="bastetresults"></div>
		`;
		container.appendChild(div);
	}

	function buildHuddamTab(container) {
		var div = document.createElement('div');
		div.className = window.widgetId + '-tab-content';
		div.dataset.tab = 'huddam';
		div.style.display = 'none';
		div.innerHTML = `
			<div class="${window.widgetId}-inline">
				<label>${__('calculatehuddam')}:</label>
				<select id="${window.widgetId}-calculatehuddam" class="abjadselect" identity="huddam">
					<option value="calculate" selected>${__('calculate')}</option>
					<option value="dont">${__('dont')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline sourcehuddam">
				<label>${__('huddamSource')}:</label>
				<select id="${window.widgetId}-sourcehuddam" class="abjadselect" identity="huddam">
					<option value="bastetresults" selected>${__('useBastetResults')}</option>
					<option value="abjadresults">${__('useAbjadResults')}</option>
					<option value="entereddatas">${__('useEnteredData')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline huddamorder">
				<label>${__('huddamOrder')}:</label>
				<select id="${window.widgetId}-huddamorder" class="abjadselect" identity="huddam">
					<option value="0" selected>${__('hisabElCumel')}</option>
					<option value="6">${__('maghribianAbjad')}</option>
					<option value="11">${__('quranFrequency')}</option>
					<option value="16">${__('hijaOrder')}</option>
					<option value="21">${__('maghribianHijaOrder')}</option>
					<option value="26">${__('iklilsOrder')}</option>
					<option value="31">${__('shamseeAbjadOrder')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline dutytype">
				<label>${__('dutyEntityType')}:</label>
				<span class="huddamcheckbox">
					<label><input type="checkbox" id="${window.widgetId}-ulvihadim" value="0"> ${__('ulvi')}</label>
					<label><input type="checkbox" id="${window.widgetId}-suflihadim" value="0"> ${__('sufli')}</label>
					<label><input type="checkbox" id="${window.widgetId}-serhadim" value="1"> ${__('ser')}</label>
					<label><input type="checkbox" id="${window.widgetId}-ownhadim" value="2"> ${__('otherSuffix')}</label>
					<input type="text" id="${window.widgetId}-ownsuffix" class="abjadselect keyboardInput" placeholder="${__('suffix')}">
				</span>
			</div>
			
			<div class="${window.widgetId}-inline huddammode">
				<label>${__('huddamMode')}:</label>
				<select id="${window.widgetId}-huddammode" class="abjadselect" identity="huddam">
					<option value="1" selected>${__('groupMultiplier')}</option>
					<option value="2">${__('repeatMultiplier')}</option>
				</select>
			</div>
			
			<div id="${window.widgetId}-huddamresults" class="huddamresults"></div>
		`;
		container.appendChild(div);
	}

	function buildSettingsTab(container) {
		var div = document.createElement('div');
		div.className = window.widgetId + '-tab-content';
		div.dataset.tab = 'settings';
		div.style.display = 'none';
		div.innerHTML = `			
			<div class="${window.widgetId}-inline">
				<label>${__('autoCalculate')}:</label>
				<select id="${window.widgetId}-autocalculate" class="abjadselect" identity="reload">
					<option value="calculate" selected>${__('immediate')}</option>
					<option value="wait">${__('wait')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline">
				<label>${__('forceRules')}:</label>
				<select id="${window.widgetId}-forcerules" class="abjadselect" identity="reload">
					<option value="force" selected>${__('forceToOther')}</option>
					<option value="allow">${__('doNotForce')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline">
				<label>${__('purify')}:</label>
				<select id="${window.widgetId}-purify" class="abjadselect" identity="reload">
					<option value="purify" selected>${__('removeUndefined')}</option>
					<option value="leave">${__('keepUndefined')}</option>
				</select>
			</div>
			
			<div class="${window.widgetId}-inline">
				<label>${__('digitsDisplay')}:</label>
				<select id="${window.widgetId}-digits" class="abjadselect" identity="reload">
					<option value="arnums" selected>${__('ARABICNumbers')}</option>
					<option value="innums">${__('indianNumbers')}</option>
				</select>
			</div>
		`;
		container.appendChild(div);
	}

	function buildSupportTab(container) {
		var div = document.createElement('div');
		div.className = window.widgetId + '-tab-content';
		div.dataset.tab = 'support';
		div.style.display = 'none';
		div.style.margin = '0';
		div.style.padding = '0';
		div.style.overflow = 'hidden';
		div.style.height = '100%';
		
		var iframe = document.createElement('iframe');
		iframe.setAttribute('id', 'bmc-iframe-original');
		iframe.setAttribute('allow', 'publickey-credentials-get *; payment *');
		iframe.title = 'Buy Me a Coffee';
		
		var widgetUrl = 'https://www.buymeacoffee.com/widget/page/' + 
						window.config.id + 
						'?description=' + encodeURIComponent(window.config.description || '') +
						'&color=' + encodeURIComponent(window.config.color || '#FFDD00');
		
		iframe.src = widgetUrl;
		iframe.style.width = '100%';
		iframe.style.height = 'calc(100% - 80px)';
		iframe.style.border = '0';
		iframe.style.borderRadius = '0';
		iframe.style.background = '#fff';
		iframe.style.backgroundImage = 'url(https://cdn.buymeacoffee.com/assets/img/widget/loader.svg)';
		iframe.style.backgroundPosition = 'center';
		iframe.style.backgroundSize = '64px';
		iframe.style.backgroundRepeat = 'no-repeat';
		iframe.style.overflow = 'hidden';
		iframe.style.display = 'block';
		iframe.style.margin = '0';
		iframe.style.padding = '0';
		
		var socialDiv = document.createElement('div');
		socialDiv.className = 'bmc-social-footer';
		socialDiv.style.margin = '0';
		socialDiv.style.padding = '15px 0';
		socialDiv.style.borderTop = '1px solid #e1e1e1';
		socialDiv.style.textAlign = 'center';
		socialDiv.style.backgroundColor = '#fff';
		socialDiv.style.width = '100%';
		socialDiv.style.boxSizing = 'border-box';
		
		socialDiv.innerHTML = `
			<p style="margin: 0 0 10px 0; color: #666; font-size: 14px;">${__('bmcNote') || 'Follow me on social media'}</p>
			<div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin: 0; padding: 0;">
				<a href="https://facebook.com/${window.config.id}" target="_blank" style="text-decoration: none; font-size: 24px; transition: transform 0.25s ease; display: inline-block;">👥</a>
				<a href="https://instagram.com/${window.config.id}" target="_blank" style="text-decoration: none; font-size: 24px; transition: transform 0.25s ease; display: inline-block;">📷</a>
				<a href="https://github.com/${window.config.id}" target="_blank" style="text-decoration: none; font-size: 24px; transition: transform 0.25s ease; display: inline-block;">🐙</a>
				<a href="https://thingiverse.com/${window.config.id}" target="_blank" style="text-decoration: none; font-size: 24px; transition: transform 0.25s ease; display: inline-block;">🤖</a>
				<a href="https://one.fanclub.rocks/" target="_blank" style="text-decoration: none; font-size: 24px; transition: transform 0.25s ease; display: inline-block;">☀️</a>
			</div>
		`;
		
		div.appendChild(iframe);
		div.appendChild(socialDiv);
		container.appendChild(div);
		
		iframe.addEventListener('load', function() {
			this.style.backgroundImage = 'none';
			try {
				var iframeDoc = this.contentDocument || this.contentWindow.document;
				if (iframeDoc) {
					var style = iframeDoc.createElement('style');
					style.textContent = `
						body, html { overflow: hidden !important; margin: 0 !important; padding: 0 !important; height: 100% !important; }
						.bmc-widget-container, .bmc-page { height: 100% !important; overflow-y: auto !important; }
					`;
					iframeDoc.head.appendChild(style);
				}
			} catch(e) {}
		});
		
		iframe.style.opacity = '0';
		iframe.style.transition = 'opacity 0.25s ease';
		setTimeout(() => { iframe.style.opacity = '1'; }, 100);
	}

	// =========================================================================
	// VIRTUAL KEYBOARD INTEGRATION
	// =========================================================================

	function initVirtualKeyboard(ta) {		
		if (ta && !ta.VKI_attached) {
			VKI_attach(ta);	
		}
	}

	// =========================================================================
	// SELECT ELEMENT EVENT
	// =========================================================================

	function selecttheelement() {
		var selectEl = this;
		var options = selectEl.getElementsByTagName('option');
		for (var o = 0; o < options.length; o += 1) {
			options[o].removeAttribute('selected');
			if (selectEl.value == options[o].getAttribute('value')) {
				options[o].setAttribute('selected', 'selected');
			}
		}
	}

	// =========================================================================
	// GLOBAL STATE
	// =========================================================================

	window.widgetId = 'aw-' + Math.random().toString(36).substr(2, 8);
	window.widgetState = { activeTab: 'abjad' };
	
	// =========================================================================
	// CONFIGURATION
	// =========================================================================

	window.scripts = document.getElementsByTagName('script');
	window.currentScript = window.scripts[window.scripts.length - 1];
	
	window.abjadWidgetI18n = typeof global !== 'undefined' && global.abjadWidgetData ? global.abjadWidgetData.i18n || {} : {};

	// =========================================================================
	// CSS STYLES - Özel CSS varsa onu kullan, yoksa varsayılanı kullan
	// =========================================================================
	
	// Özel CSS yoksa varsayılan stilleri ekle
	if (typeof window.abjadWidgetCustomCSS === 'undefined') {
		var style = document.createElement('style');
		style.textContent = `
.${window.widgetId}-container * { 
	box-sizing: border-box; 
	font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
	margin: 0;
	padding: 0;
}

.${window.widgetId}-container {
	position: fixed;
	bottom: 24px;
	${window.config.position}: 24px;
	z-index: 4900;
	font-size: 14px;
}

.${window.widgetId}-button {
	width: 56px;
	height: 56px;
	border-radius: 50%;
	background: ${window.config.color};
	cursor: pointer;
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 24px;
	transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
	color: #ffffff;
	border: none;
}

.${window.widgetId}-button:hover {
	transform: scale(1.05);
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.${window.widgetId}-button:active {
	transform: scale(0.95);
}

.${window.widgetId}-modal {
	position: absolute;
	bottom: 70px;
	${window.config.position}: 0;
	width: 520px;
	height: 600px;
	background: #ffffff;
	border-radius: 16px;
	box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
	display: none;
	flex-direction: column;
	color: #1e293b;
	overflow: hidden;
}

.${window.widgetId}-tabs {
	display: flex;
	background: #f8fafc;
	border-bottom: 1px solid #e2e8f0;
	padding: 0 16px;
	gap: 8px;
	height: 50px;
	flex-shrink: 0;
}

.${window.widgetId}-tab {
	padding: 14px 12px;
	cursor: pointer;
	font-weight: 500;
	color: #64748b;
	font-size: 13px;
	border-bottom: 2px solid transparent;
	transition: all 0.2s;
}

.${window.widgetId}-tab:hover {
	color: #334155;
}

.${window.widgetId}-tab.active {
	color: ${window.config.color};
	border-bottom-color: ${window.config.color};
}

.${window.widgetId}-content {
	padding: 20px;
	overflow-y: auto;
	height: 530px;
	background: #ffffff;
	display: flex;
	flex-direction: column;
}

.${window.widgetId}-content h3 {
	margin: 0 0 16px 0;
	color: #1e293b;
	font-size: 16px;
	font-weight: 600;
}

.${window.widgetId}-content h4 {
	margin: 20px 0 12px 0;
	color: #334155;
	font-size: 14px;
	font-weight: 500;
}

.${window.widgetId}-inline {
	margin: 0 0 12px 0;
	display: flex;
	align-items: center;
	gap: 12px;
}

.${window.widgetId}-inline label {
	min-width: 110px;
	color: #475569;
	font-size: 13px;
	font-weight: 500;
}

.${window.widgetId}-inline select,
.${window.widgetId}-inline input[type="text"],
.${window.widgetId}-inline input[type="number"] {
	flex: 1;
	height: 36px;
	padding: 0 10px;
	background: #f8fafc;
	border: 1px solid #e2e8f0;
	border-radius: 8px;
	color: #1e293b;
	font-size: 13px;
	transition: all 0.2s;
	outline: none;
}

.${window.widgetId}-inline select:hover,
.${window.widgetId}-inline input[type="text"]:hover,
.${window.widgetId}-inline input[type="number"]:hover {
	border-color: #cbd5e1;
	background: #ffffff;
}

.${window.widgetId}-inline select:focus,
.${window.widgetId}-inline input[type="text"]:focus,
.${window.widgetId}-inline input[type="number"]:focus {
	border-color: ${window.config.color};
	box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
	background: #ffffff;
}

.${window.widgetId}-content textarea {
	width: 100%;
	min-height: 80px;
	padding: 12px;
	background: #f8fafc;
	border: 1px solid #e2e8f0;
	border-radius: 10px;
	color: #1e293b;
	font-size: 13px;
	line-height: 1.5;
	resize: vertical;
	transition: all 0.2s;
	outline: none;
	font-family: 'SF Mono', Monaco, Consolas, monospace;
	margin-bottom: 12px;
}

.${window.widgetId}-content textarea:hover {
	border-color: #cbd5e1;
	background: #ffffff;
}

.${window.widgetId}-content textarea:focus {
	border-color: ${window.config.color};
	box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
	background: #ffffff;
}

.${window.widgetId}-content .elementcheckbox,
.${window.widgetId}-content .huddamcheckbox {
	display: flex;
	flex-wrap: wrap;
	gap: 16px;
	align-items: center;
	flex: 1;
}

.${window.widgetId}-content .elementcheckbox label,
.${window.widgetId}-content .huddamcheckbox label {
	min-width: auto;
	display: flex;
	align-items: center;
	gap: 6px;
	color: #475569;
	font-weight: normal;
	cursor: pointer;
}

.${window.widgetId}-content input[type="checkbox"] {
	width: 16px;
	height: 16px;
	margin: 0;
	cursor: pointer;
	accent-color: ${window.config.color};
}

.${window.widgetId}-content .phrasespreview {
	background: #f8fafc;
	border: 1px solid #e2e8f0;
	border-radius: 10px;
	padding: 12px;
	min-height: 60px;
	max-height: 100px;
	overflow-y: auto;
	margin: 8px 0 16px 0;
	display: flex;
	flex-wrap: wrap;
	gap: 6px;
}

.${window.widgetId}-content .phrase {
	background: #e2e8f0;
	color: #334155;
	padding: 4px 12px;
	border-radius: 20px;
	font-size: 12px;
	display: inline-flex;
	align-items: center;
	gap: 6px;
}

.${window.widgetId}-content .phrase .porder {
	background: #ffffff;
	color: #64748b;
	padding: 0 4px;
	border-radius: 12px;
	font-size: 10px;
	font-weight: 600;
}

.${window.widgetId}-content table {
	width: 100%;
	border-collapse: collapse;
	margin-top: 20px;
	border: 1px solid #e2e8f0;
	border-radius: 10px;
	overflow: hidden;
	font-size: 13px;
}

.${window.widgetId}-content th {
	background: #f8fafc;
	color: #475569;
	font-weight: 600;
	padding: 12px 8px;
	text-align: center;
	border-bottom: 1px solid #e2e8f0;
	font-size: 12px;
}

.${window.widgetId}-content td {
	padding: 10px 8px;
	text-align: center;
	border-bottom: 1px solid #f1f5f9;
	color: #334155;
}

.${window.widgetId}-content tr:last-child td {
	border-bottom: none;
}

.${window.widgetId}-content tr:hover td {
	background: #f8fafc;
}

.${window.widgetId}-content .abjadresults,
.${window.widgetId}-content .bastetresults,
.${window.widgetId}-content .huddamresults {
	margin-top: 16px;
	border-radius: 10px;
	background: #f8fafc;
	padding: 4px;
}

.${window.widgetId}-content .bastetdetails {
	width: 100%;
	background: transparent;
	border: none;
}

.${window.widgetId}-content .bastetdetails th,
.${window.widgetId}-content .bastetdetails td {
	background: #f1f5f9;
	padding: 8px;
	font-size: 12px;
}
/* Begining Of Keyboard Styles */
	#keyboardInputMaster {
	position: absolute;
	display: block;
	font-size: 11px;
	font-family: 'ScheherazadeNew';
	border: 0px solid rgba(15, 15, 15, .4);
	-webkit-border-radius: 0.2em;
	-moz-border-radius: 0.2em;
	border-radius: 0.2em;
	-webkit-box-shadow: 0px 2px 10px rgba(15, 15, 15, .0);
	-moz-box-shadow: 0px 2px 10px rgba(15, 15, 15, .0);
	box-shadow: 0px 2px 10px rgba(15, 15, 15, .0);
	background-color: rgba(0, 0, 0, .0);
	text-align: left;
	z-index: 6000;
	width: auto;
	height: auto;
	min-width: 0;
	min-height: 0;
	margin: 0px;
	padding: 0px;
	line-height: normal;
	-moz-user-select: none;
	cursor: url(${window.config.pluginUrl}/cursors/altinimlec.cur), auto;
	}

	#keyboardInputMaster * {
	position: static;
	color: #e2e8f0;
	background: transparent;
	font-size: 11px;
	font-family: 'ScheherazadeNew';
	width: auto;
	height: auto;
	min-width: 0;
	min-height: 0;
	margin: 0px;
	padding: 0px;
	border: 0px none;
	outline: 0px;
	vertical-align: baseline;
	line-height: 1.3em;
	}

	#keyboardInputMaster table {
	table-layout: auto;
	}

	#keyboardInputMaster.keyboardInputSize4,
	#keyboardInputMaster.keyboardInputSize4 * {
	font-size: 1.3em;
	}

	#keyboardInputMaster thead tr th {
	padding: 0.3em 0.3em 0.1em 0.3em;
	background-color: rgba(0, 0, 0, .4);
	white-space: nowrap;
	text-align: right;
	-webkit-border-radius: 0.2em 0.2em 0px 0px;
	-moz-border-radius: 0.2em 0.2em 0px 0px;
	border-radius: 0.2em 0.2em 0px 0px;
	}

	#keyboardInputMaster thead tr th div {
	float: left;
	font-size: 130% !important;
	height: 1.3em;
	font-weight: bold;
	position: relative;
	z-index: 5900;
	margin-right: 0.5em;
	cursor: url(${window.config.pluginUrl}/cursors/infinityeldiveni.cur), auto;
	background-color: transparent;
	}

	#keyboardInputMaster thead tr th div ol {
	-webkit-backdrop-filter: blur(3px);
	backdrop-filter: blur(3px);
	position: absolute;
	left: 0px;
	top: 90%;
	list-style-type: none;
	height: 9.4em;
	overflow-y: auto;
	overflow-x: hidden;
	background-color: rgba(0, 0, 0, .4);
	border: 1px solid rgba(15, 15, 15, .4);
	display: none;
	text-align: left;
	width: 12em;
	}

	#keyboardInputMaster thead tr th div ol li {
	padding: 0.2em 0.4em;
	cursor: url(${window.config.pluginUrl}/cursors/infinityeldiveni.cur), auto;
	white-space: nowrap;
	width: 12em;
	}

	#keyboardInputMaster thead tr th div ol li.selected {
	background-color: rgba(15, 15, 15, .4);
	}

	#keyboardInputMaster thead tr th div ol li:hover,
	#keyboardInputMaster thead tr th div ol li.hover {
	background-color: rgba(25, 25, 25, .4);
	}

	#keyboardInputMaster thead tr th span,
	#keyboardInputMaster thead tr th strong,
	#keyboardInputMaster thead tr th small,
	#keyboardInputMaster thead tr th big {
	display: inline-block;
	padding: 0px 0.4em;
	height: 1.4em;
	line-height: 1.4em;
	border-top: 1px solid rgba(25, 25, 25, .4);
	border-right: 1px solid rgba(35, 35, 35, .4);
	border-bottom: 1px solid rgba(35, 35, 35, .4);
	border-left: 1px solid rgba(25, 25, 25, .4);
	background-color: rgba(15, 15, 15, .4);
	cursor: url(${window.config.pluginUrl}/cursors/infinityeldiveni.cur), auto;
	margin: 0px 0px 0px 0.3em;
	-webkit-border-radius: 0.3em;
	-moz-border-radius: 0.3em;
	border-radius: 0.3em;
	vertical-align: middle;
	-webkit-transition: background-color .15s ease-in-out;
	-o-transition: background-color .15s ease-in-out;
	transition: background-color .15s ease-in-out;
	}

	#keyboardInputMaster thead tr th strong {
	font-weight: bold;
	}

	#keyboardInputMaster thead tr th small {
	-webkit-border-radius: 0.3em 0px 0px 0.3em;
	-moz-border-radius: 0.3em 0px 0px 0.3em;
	border-radius: 0.3em 0px 0px 0.3em;
	border-right: 1px solid rgba(25, 25, 25, .4);
	padding: 0px 0.2em 0px 0.3em;
	}

	#keyboardInputMaster thead tr th big {
	-webkit-border-radius: 0px 0.3em 0.3em 0px;
	-moz-border-radius: 0px 0.3em 0.3em 0px;
	border-radius: 0px 0.3em 0.3em 0px;
	border-left: 0px none;
	margin: 0px;
	padding: 0px 0.3em 0px 0.2em;
	}

	#keyboardInputMaster thead tr th span:hover,
	#keyboardInputMaster thead tr th span.hover,
	#keyboardInputMaster thead tr th strong:hover,
	#keyboardInputMaster thead tr th strong.hover,
	#keyboardInputMaster thead tr th small:hover,
	#keyboardInputMaster thead tr th small.hover,
	#keyboardInputMaster thead tr th big:hover,
	#keyboardInputMaster thead tr th big.hover {
	background-color: rgba(25, 25, 25, .4);
	}

	#keyboardInputMaster tbody tr td {
	text-align: left;
	padding: 0.1em 0;
	vertical-align: top;
	}

	#keyboardInputMaster tbody tr td div {
	text-align: center;
	position: relative;
	zoom: 1;
	}

	#keyboardInputMaster tbody tr td table {
	white-space: nowrap;
	width: 100%;
	border-collapse: separate;
	border-spacing: 0px;
	}

	#keyboardInputMaster tbody tr td#keyboardInputNumpad table {
	margin-left: 0.2em;
	width: auto;
	}

	#keyboardInputMaster tbody tr td table.keyboardInputCenter {
	width: auto;
	margin: 0px auto;
	}

	#keyboardInputMaster tbody tr td table tbody tr td {
	-webkit-backdrop-filter: blur(3px);
	backdrop-filter: blur(3px);
	vertical-align: middle;
	padding: 0px 0.45em;
	white-space: pre;
	height: 1.8em;
	font-family: 'ScheherazadeNew';
	text-shadow: 0 0 5px rgba(15, 15, 15, .5);
	border-top: 1px solid rgba(25, 25, 25, .4);
	border-right: 1px solid rgba(35, 35, 35, .4);
	border-bottom: 1px solid rgba(35, 35, 35, .4);
	border-left: 1px solid rgba(25, 25, 25, .4);
	background-color: rgba(15, 15, 15, .4);
	cursor: url(${window.config.pluginUrl}/cursors/altinimlec.cur), auto;
	min-width: 0.5em;
	-webkit-border-radius: 0.2em;
	-moz-border-radius: 0.2em;
	border-radius: 0.2em;
	-webkit-transition: background-color .15s ease-in-out;
	-o-transition: background-color .15s ease-in-out;
	transition: background-color .15s ease-in-out;
	}

	#keyboardInputMaster tbody tr td table tbody tr td.last {
	width: 99%;
	}

	#keyboardInputMaster tbody tr td table tbody tr td.space {
	padding: 0px 4em;
	}

	#keyboardInputMaster tbody tr td table tbody tr td.deadkey {
	background-color: rgba(15, 15, 15, .4);
	}

	#keyboardInputMaster tbody tr td table tbody tr td.target {
	background-color: rgba(25, 25, 25, .4);
	}

	#keyboardInputMaster tbody tr td table tbody tr td:hover,
	#keyboardInputMaster tbody tr td table tbody tr td.hover {
	border-top: 1px solid rgba(25, 25, 25, .4);
	border-right: 1px solid rgba(15, 15, 15, .4);
	border-bottom: 1px solid rgba(15, 15, 15, .4);
	border-left: 1px solid rgba(25, 25, 25, .4);
	background-color: rgba(15, 15, 15, .4);
	}

	#keyboardInputMaster thead tr th span:active,
	#keyboardInputMaster thead tr th span.pressed,
	#keyboardInputMaster tbody tr td table tbody tr td:active,
	#keyboardInputMaster tbody tr td table tbody tr td.pressed {
	border-top: 1px solid rgba(15, 15, 15, .5) !important;
	border-right: 1px solid rgba(25, 25, 25, .4);
	border-bottom: 1px solid rgba(25, 25, 25, .4);
	border-left: 1px solid rgba(15, 15, 15, .4);
	background-color: rgba(25, 25, 25, .4);
	animation: bounceIn .6s;
	animation-delay: .6s;
	}

	#keyboardInputMaster tbody tr td table tbody tr td small {
	display: block;
	text-align: center;
	font-size: 0.6em !important;
	line-height: 1.1em;
	}

	#keyboardInputMaster tbody tr td div label {
	position: absolute;
	bottom: 0.2em;
	left: 0.3em;
	}

	#keyboardInputMaster tbody tr td div label input {
	background-color: rgba(15, 15, 15, .4);
	vertical-align: middle;
	font-size: inherit;
	width: 1.1em;
	height: 1.1em;
	}

	#keyboardInputMaster tbody tr td div var {
	position: absolute;
	bottom: 0px;
	right: 3px;
	font-weight: bold;
	font-style: italic;
	color: rgba(15, 15, 15, .4);
	}

	.keyboardInputInitiator {
	margin: 0px 3px;
	vertical-align: middle;
	cursor: url(${window.config.pluginUrl}/cursors/infinityeldiveni.cur), auto;
	}

	@media only screen and (min-width: 768px) {
	#keyboardInputMaster.keyboardInputSize4,
	#keyboardInputMaster.keyboardInputSize4 * {
	font-size: 1.5vw;
	}
}
/* End Of Keyboard Styles */

.${window.widgetId}-content .entryseparators {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	flex: 1;
	background: #f8fafc;
	padding: 10px;
	border-radius: 8px;
	border: 1px solid #e2e8f0;
}

.${window.widgetId}-content .entryseparators nowrap {
	display: inline-flex;
	align-items: center;
	gap: 4px;
	white-space: nowrap;
}

.${window.widgetId}-content .entryseparators nowrap input[type="checkbox"] {
	margin: 0;
}

.${window.widgetId}-content .entryseparators nowrap label {
	min-width: auto;
	font-size: 12px;
}

.${window.widgetId}-content .entryseparators nowrap strong {
	font-weight: 600;
	color: ${window.config.color};
	margin-left: 2px;
}

@media (max-width: 600px) {
	.${window.widgetId}-modal {
		width: calc(100vw - 48px);
		right: 0;
		left: 0;
		margin: 0 auto;
	}
	
	.${window.widgetId}-inline {
		flex-direction: column;
		align-items: flex-start;
		gap: 6px;
	}
	
	.${window.widgetId}-inline label {
		min-width: auto;
	}
	
	.${window.widgetId}-inline select,
	.${window.widgetId}-inline input {
		width: 100%;
	}
}

#bmc-iframe-original {
	scrollbar-width: thin;
	scrollbar-color: #c1c1c1 #f1f1f1;
}

#bmc-iframe-original::-webkit-scrollbar {
	width: 6px;
}

#bmc-iframe-original::-webkit-scrollbar-track {
	background: #f1f1f1;
}

#bmc-iframe-original::-webkit-scrollbar-thumb {
	background: #c1c1c1;
	border-radius: 3px;
}

#bmc-iframe-original::-webkit-scrollbar-thumb:hover {
	background: #a1a1a1;
}
	`;
		document.head.appendChild(style);
	}

	// =========================================================================
	// DOM YAPISINI OLUŞTUR
	// =========================================================================

	var container = document.createElement('div');
	container.className = window.widgetId + '-container';
	container.id = window.widgetId + '-container';

	var button = document.createElement('div');
	button.className = window.widgetId + '-button';
	button.innerHTML = window.config.button_content;
	container.appendChild(button);

	var modal = document.createElement('div');
	modal.className = window.widgetId + '-modal';
	modal.id = window.widgetId + '-modal';

	var tabsDiv = document.createElement('div');
	tabsDiv.className = window.widgetId + '-tabs';
	var tabs = ['abjad', 'bastet', 'huddam', 'settings', 'support'];
	var tabLabels = {
		abjad: __('abjadTab'),
		bastet: __('bastetTab'),
		huddam: __('huddamTab'),
		settings: __('settingsTab'),
		support: __('supportTab')
	};
	
	tabs.forEach(function(t) {
		var tab = document.createElement('div');
		tab.className = window.widgetId + '-tab';
		tab.dataset.tab = t;
		tab.textContent = tabLabels[t];
		tab.addEventListener('click', function() { switchTab(t); });
		tabsDiv.appendChild(tab);
	});
	modal.appendChild(tabsDiv);

	var contentDiv = document.createElement('div');
	contentDiv.className = window.widgetId + '-content';
	contentDiv.id = window.widgetId + '-content';
	modal.appendChild(contentDiv);
	container.appendChild(modal);
	document.body.appendChild(container);

	// =========================================================================
	// MODAL TOGGLE
	// =========================================================================

	button.addEventListener('click', function(e) {
		e.stopPropagation();
		var disp = modal.style.display;
		modal.style.display = disp === 'flex' ? 'none' : 'flex';
		if (modal.style.display === 'flex') calculations('reload');
	});

	document.addEventListener('click', function(e) {
		var kb = document.getElementById('keyboardInputMaster');
		if (kb && kb.contains(e.target)) {
			e.stopPropagation();
			return;
		}
		if (!container.contains(e.target)) {
			modal.style.display = 'none';
		}
	});

	// =========================================================================
	// HIDDEN ELEMENTS
	// =========================================================================

	var hiddenStore = document.createElement('div');
	hiddenStore.style.display = 'none';
	hiddenStore.innerHTML = `
		<span id="${window.widgetId}-sourcetoabjad" latest="" latesttotal=""></span>
		<span id="${window.widgetId}-sourcetobastet" latest="" latesttotal="" sourcetoabjad=""></span>
		<span id="${window.widgetId}-sourcetohuddam" entrysource="" abjadsource="" bastetsource=""></span>
	`;
	document.body.appendChild(hiddenStore);

	// =========================================================================
	// TAB İÇERİKLERİNİ OLUŞTUR
	// =========================================================================

	var contentDivEl = document.getElementById(window.widgetId + '-content');
	if (contentDivEl) {
		contentDivEl.innerHTML = '';
		buildAbjadTab(contentDivEl);
		buildBastetTab(contentDivEl);
		buildHuddamTab(contentDivEl);
		buildSettingsTab(contentDivEl);
		buildSupportTab(contentDivEl);
		switchTab('abjad');
		
		initVirtualKeyboard(document.getElementById(window.widgetId + '-abjadtextentry'));
		
		setTimeout(function() {
			prepareForMulticlick('abjad');
			prepareForMulticlick('bastet');
		}, 100);
	}

	// =========================================================================
	// EVENT LISTENERS
	// =========================================================================
	var ta = document.getElementById(window.widgetId + '-abjadtextentry');
	if (ta) {
		ta.addEventListener('input', shapeentry);
		ta.addEventListener('change', shapeentry);
		ta.addEventListener('focus', showkeys);
	}

	var os = document.getElementById(window.widgetId + '-ownsuffix');
	if (os) {
		os.addEventListener('input', function() {
			if (this.value != "") {
				var ownhadimEl = document.getElementById(window.widgetId + '-ownhadim');
				if (ownhadimEl && !ownhadimEl.checked) {
					ownhadimEl.click();
				}
			}
			calchuddam();
		});
		os.addEventListener('change', function() {
			if (this.value != "") {
				var ownhadimEl = document.getElementById(window.widgetId + '-ownhadim');
				if (ownhadimEl && !ownhadimEl.checked) {
					ownhadimEl.click();
				}
			}
			calchuddam();
		});
		os.addEventListener('focus', showkeys);
	}

	var langBastet = document.getElementById(window.widgetId + '-languagebastet');
	if (langBastet) {
		langBastet.addEventListener('input', function() {
			if (setDataType(5) > 2) shapeentry();
			else { calculations('reload'); calculations('huddam'); }
		});
		langBastet.addEventListener('change', function() {
			if (setDataType(5) > 2) shapeentry();
			else { calculations('reload'); calculations('huddam'); }
		});
	}

	var calcBastet = document.getElementById(window.widgetId + '-calculatebastet');
	if (calcBastet) {
		calcBastet.addEventListener('input', shapebastet);
		calcBastet.addEventListener('change', shapebastet);
	}

	var calcHuddam = document.getElementById(window.widgetId + '-calculatehuddam');
	if (calcHuddam) {
		calcHuddam.addEventListener('input', shapehuddam);
		calcHuddam.addEventListener('change', shapehuddam);
	}

	var selectors = [
		'abjaddatatype', 'abjadorder', 'abjadtable', 'abjadshadda', 'abjaddetail', 'elementguide',
		'sourcebastet', 'bastetrepetation', 'bastetdetail', 'bastetaddquantity', 'usebastetelement', 'bastelementguide',
		'sourcehuddam', 'huddamorder', 'huddammode', 'autocalculate', 'forcerules', 'purify', 'digits',
		'calculateabjad', 'calculatebastet', 'calculatehuddam', 'bastetorder', 'bastettable', 'bastetshadda'
	];
	
	selectors.forEach(function(id) {
		var el = document.getElementById(window.widgetId + '-' + id);
		if (el) {
			el.addEventListener('change', function() {
				SetForProfile();
				var ident = this.getAttribute('identity') || 'reload';
				calculations(ident);
			});
			
			el.addEventListener('input', function() {
				SetForProfile();
				var ident = this.getAttribute('identity') || 'reload';
				calculations(ident);
			});
			
			el.addEventListener('click', selecttheelement);
			el.addEventListener('focusout', selecttheelement);
		}
	});

	var abjadAll = document.getElementById(window.widgetId + '-abjadall');
	if (abjadAll) {
		abjadAll.addEventListener('click', function() { multiclickelement('abjad'); });
	}
	
	var abjadIds = ['abjadfire', 'abjadair', 'abjadwater', 'abjadearth'];
	abjadIds.forEach(function(id) {
		var el = document.getElementById(window.widgetId + '-' + id);
		if (el) {
			el.addEventListener('input', function() { calculations('reload'); });
			el.addEventListener('change', function() { calculations('reload'); });
		}
	});

	var bastetAll = document.getElementById(window.widgetId + '-bastetall');
	if (bastetAll) {
		bastetAll.addEventListener('click', function() { multiclickelement('bastet'); });
	}
	
	var bastetIds = ['bastetfire', 'bastetair', 'bastetwater', 'bastetearth'];
	bastetIds.forEach(function(id) {
		var el = document.getElementById(window.widgetId + '-' + id);
		if (el) {
			el.addEventListener('input', function() { calculations('reload'); });
			el.addEventListener('change', function() { calculations('reload'); });
		}
	});

	var huddamIds = ['ulvihadim', 'suflihadim', 'serhadim', 'ownhadim'];
	huddamIds.forEach(function(id) {
		var el = document.getElementById(window.widgetId + '-' + id);
		if (el) {
			el.addEventListener('input', function() { calculations('huddam'); });
			el.addEventListener('change', function() { calculations('huddam'); });
		}
	});
	
	var calcAbjad = document.getElementById(window.widgetId + '-calculateabjad');
	if (calcAbjad) {
		calcAbjad.addEventListener('input', function() {
			shapeabjad();
			shapebastet();
			shapehuddam();
			calculations('reload');
		});
		calcAbjad.addEventListener('change', function() {
			shapeabjad();
			shapebastet();
			shapehuddam();
			calculations('reload');
		});
	}

	var forceRules = document.getElementById(window.widgetId + '-forcerules');
	if (forceRules) {
		forceRules.addEventListener('input', function() {
			shapebastet();
			shapehuddam();
			calculations('reload');
		});
		forceRules.addEventListener('change', function() {
			shapebastet();
			shapehuddam();
			calculations('reload');
		});
	}

	var dataType = document.getElementById(window.widgetId + '-abjaddatatype');
	if (dataType) {
		dataType.addEventListener('input', function() {
			shapebastet();
			shapehuddam();
			shapeentry();
		});
		dataType.addEventListener('change', function() {
			shapebastet();
			shapehuddam();
			shapeentry();
		});
	}

	var ser = document.getElementById(window.widgetId + '-serhadim');
	if (ser) {
		ser.addEventListener('change', function() {
			if (ser.checked) {
				var audio = new Audio(window.config.pluginUrl + 'audio/evillaugh.webm');
				audio.play().catch(function(e) {});
			}
		});
	}
	
	const initiators = document.querySelectorAll('.keyboardInputInitiator');

	initiators.forEach(el => {
		el.addEventListener('click', () => {
			// Get current scrollTop
			const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
			console.log('ScrollTop at click:', currentScroll);

			// Or set scrollTop (e.g., scroll to top)
			window.scrollTo(0, 0);
		});
	});

	document.querySelectorAll('space').forEach(function(el) {
		el.outerHTML = '&nbsp;';
	});

	// =========================================================================
	// İLK HESAPLAMA
	// =========================================================================
	shapeabjad();
	shapebastet();
	shapehuddam();
	calculations('reload');

})(window, jQuery);
EOT;

// =========================================================================
// JAVASCRIPT ÇIKTISINI OLUŞTUR
// =========================================================================

// Başlık yorumu
echo "/*\n";
echo " * Abjad Widget - Dynamic Build\n";
echo " * Version: " . esc_js( ABJAD_WIDGET_VERSION ) . "\n";
echo " * Build Date: " . esc_js( gmdate( 'Y-m-d H:i:s' ) ) . "\n";
echo " * Site: " . esc_js( get_site_url() ) . "\n";
echo " */\n\n";

// Özel CSS varsa ekle
if ( ! empty( $abjad_widget_style_options['custom_css'] ) ) {
	$abjad_widget_custom_css = str_replace( '`', '\\`', $abjad_widget_style_options['custom_css'] );
	$abjad_widget_custom_css = str_replace( '${', '\\${', $abjad_widget_custom_css );
	echo "window.abjadWidgetCustomCSS = " . wp_json_encode( $abjad_widget_custom_css ) . ";\n\n";
}

// Yapılandırmayı ekle
echo "window.widgetId = " . wp_json_encode( $widget_id ) . ";\n";
$abjad_widget_config = array(
	'id'			=> $abjad_widget_options['id'],
	'color'		 => $abjad_widget_options['color'],
	'position'	  => $abjad_widget_options['position'],
	'message'	   => $abjad_widget_options['message'],
	'description'   => $abjad_widget_options['description'],
	'button_content' => $abjad_widget_button_content,
	'pluginUrl'	 => $abjad_widget_plugin_url
);
echo "window.config = " . wp_json_encode( $abjad_widget_config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . ";\n\n";

// ============================================================================
// KULLANICI ÖZEL JAVASCRIPT - SON KISIM
// ============================================================================

if ( ! empty( $abjad_widget_code_options['custom_js'] ) ) {
	echo "\n\n// =============================================\n";
	echo "// KULLANICI ÖZEL KODLARI\n";
	echo "// =============================================\n\n";
	
	// Özel kodu olduğu gibi ekle (zaten güvenli mi diye kontrol etmeye gerek yok,
	// çünkü kullanıcı bilinçli olarak ekliyor)
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $abjad_widget_code_options['custom_js'];
	echo "\n";
}

echo "\n// =============================================\n";
echo "// Widget başlatıldı\n";
echo "console.log('Abjad Widget v" . esc_js( ABJAD_WIDGET_VERSION ) . " yüklendi');\n";

// Varsayılan JS'i ekle
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $abjad_widget_default_js;
