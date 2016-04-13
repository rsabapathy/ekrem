/*
== ------------------------------------------------------------------- ==
== @@ Style Switcher
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_style_switcher = function() {
	
		return this.each(function(){

			var $control = $(this);
			var $toggler = $(this).find('.toggler');
			
			var $layout_style = $(this).find('#layout_style');
			var $pattern = $(this).find('#pattern');
			var $image = $(this).find('#image');
			var $color = $(this).find('#color');
			
			var defaults = {
				layout_style: '',
				pattern: '',
				image: ''
			};
			
			var current_layout_style = $layout_style.val();
			
			var visible = false;
			var visible_position = 0;
			var hidden_position = ( $control.width() + 2 ) * -1;
			var initial_position = ( $control.width() + $toggler.width() ) * -1;
						
			// Styles -------------------------------------------------------------
			
			function setup_styler() {
			
				setup_layout_style();
				
				setup_pattern();
				
				setup_image();
				
				setup_color();
				
				setup_reset_button();
				
			}
			
			function setup_layout_style() {
			
				// control behaviour
				
				$layout_style.change(function(){
				
					var style = $(this).val();
					
					if ( style === 'boxed' ) {
						$('body').addClass('invicta_boxed_layout');
					}
					else {
						$('body').removeClass('invicta_boxed_layout');
					}
					
					$.cookie('invicta_styler_layout_mode', style, { expires: 1, path: '/' });
					current_layout_style = style;
					
				});
				
				$layout_style.bind('reset', function(){

					$layout_style.val( defaults.layout_style ).trigger('change');
					$.removeCookie('invicta_styler_layout_mode', { path: '/' });

				});
				
				// init
				
				defaults.layout_style = $layout_style.val();
				
				var cookie_layout_mode = $.cookie('invicta_styler_layout_mode');
				
				if ( cookie_layout_mode !== undefined ) {
					$layout_style.val( cookie_layout_mode ).trigger('change');
				}
				
			}
			
			function setup_pattern() {

				var ready = false;
				
				$pattern.find('a').click(function(){
				
					if ( ready && current_layout_style !== 'boxed' ) {
						window.alert('Patterns are only available for Boxed Layout mode');
						return false;
					}

					if ( ready ) {
						$image.trigger('desactivate');
					}
					
					ready = true;
					
					var pattern_url = $(this).data('url');
					var pattern_basename = $(this).data('basename');
					
					if ( pattern_basename === '0-none.png' ) {
						$('.invicta_boxed_layout .body_background').css({
							'background-image': 'none'
						});
					}
					else {
						$('.invicta_boxed_layout .body_background').css({
							'background-image': 'url(' + pattern_url + ')',
							'background-repeat': 'repeat',
							'background-attachment': 'scroll',
							'background-size': 'auto'
						});
					}
					
					$pattern.find('a').removeClass('active');
					$(this).addClass('active');
					
					$.cookie('invicta_styler_pattern', pattern_url, { expires: 1, path: '/' });
					
					return false;
					
				});
				
				$pattern.bind('reset', function(){

					ready = false;
					$pattern.find('a[data-url="' + defaults.pattern + '"]').trigger('click');
					$.removeCookie('invicta_styler_pattern', { path: '/' });
					
				});

				$pattern.bind('desactivate', function(){

					ready = false;
					$pattern.find('a[data-url$="0-none.png"]').trigger('click');
					$.removeCookie('invicta_styler_pattern', { path: '/' });
					
				});
				
				// init
				
				defaults.pattern = $pattern.find('a.active').data('url');
				
				var cookie_pattern = $.cookie('invicta_styler_pattern');
				
				if ( cookie_pattern !== undefined ) {
					$pattern.find('a[data-url="' + cookie_pattern + '"]').trigger('click');
				}
				
				ready = true;
				
			}
			
			function setup_image() {

				var ready = false;
				
				$image.find('a').click(function(){
				
					if ( ready && current_layout_style !== 'boxed' ) {
						window.alert('Images are only available for Boxed Layout mode');
						return false;
					}
					
					if ( ready ) {
						$pattern.trigger('desactivate');
					}
					
					ready = true;
					
					var image_url = $(this).data('url');
					var image_basename = $(this).data('basename');
					
					if ( image_basename === '0-none.png' ) {
						$('.invicta_boxed_layout .body_background').css({
							'background-image': 'none'
						});
					}
					else {
						$('.invicta_boxed_layout .body_background').css({
							'background-image': 'url(' + image_url + ')',
							'background-repeat': 'repeat',
							'background-attachment': 'fixed',
							'background-size': 'cover'
						});
					}
					
					$image.find('a').removeClass('active');
					$(this).addClass('active');
					
					$.cookie('invicta_styler_image', image_url, { expires: 1, path: '/' });
					
					return false;
					
				});
				
				$image.bind('reset', function(){

					ready = false;
					$image.find('a[data-url="' + defaults.image + '"]').trigger('click');
					$.removeCookie('invicta_styler_image', { path: '/' });
					
				});
				
				$image.bind('desactivate', function(){

					ready = false;
					$image.find('a[data-url$="0-none.png"]').trigger('click');
					$.removeCookie('invicta_styler_image', { path: '/' });
					
				});
				
				// init
				
				defaults.image = $image.find('a.active').data('url');
				
				var cookie_image = $.cookie('invicta_styler_image');
				
				if ( cookie_image !== undefined ) {
					$image.find('a[data-url="' + cookie_image + '"]').trigger('click');
				}
				
				ready = true;
				
			}
			
			function setup_color() {
								
				// init
				
				defaults.color = $color.val();
				
				var cookie_color = $.cookie('invicta_styler_color');
				
				if ( cookie_color !== undefined ) {
					update_accent_color( cookie_color );
					$color.val(cookie_color);
				}
				
				$.minicolors.defaults.changeDelay = 200;
				
				$color.minicolors({
					change: function(hex) {
						update_accent_color( hex );
						$.cookie('invicta_styler_color', hex, { expires: 1, path: '/' });
					}
				});
				
				$color.bind('reset', function(){

					$color.val(defaults.color);
					$color.minicolors('value', defaults.color);
					$.removeCookie('invicta_styler_color', { path: '/' });
					
				});
				
			}
			
			function setup_reset_button() {
				
				$control.find('#reset').click(function(){
					
					$layout_style.trigger('reset');
					$pattern.trigger('reset');
					$image.trigger('reset');
					$color.trigger('reset');

					return false;

				});
				
			}
			
			function update_accent_color( new_color ) {
				
				var dynamic_css = '';
				
				dynamic_css += '::selection {';
				dynamic_css +=		'background:' + hex2rgb(new_color, 1) + ';';
				dynamic_css +=		'color:#FFF;';
				dynamic_css += '}';
				
				dynamic_css += '::-moz-selection {';
				dynamic_css +=		'background:' + hex2rgb(new_color, 1) + ';';
				dynamic_css +=		'color:#FFF;';
				dynamic_css += '}';
				
				dynamic_css += 'a:hover {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';

				dynamic_css += '.text_styles a {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.inherit-color,';
				dynamic_css += '.inherit-color-on_children >* {';
				dynamic_css +=		'color:inherit;';
				dynamic_css += '}';
				
				dynamic_css += '.accentcolor-text, ';
				dynamic_css += '.accentcolor-text-on_children >*,';
				dynamic_css += '.accentcolor-text-on_hover:hover, ';
				dynamic_css += '.accentcolor-text-on_children-on_hover >*:hover {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ' !important;';
				dynamic_css += '}';
				
				dynamic_css += '.accentcolor-border, ';
				dynamic_css += '.accentcolor-border-on_children >*, ';
				dynamic_css += '.accentcolor-border-on_hover:hover, ';
				dynamic_css += '.accentcolor-border-on_children-on_hover >*:hover { ';
				dynamic_css +=		'border-color:' + hex2rgb(new_color, 1) + ' !important; ';
				dynamic_css += '}';
				
				dynamic_css += '.accentcolor-background, ';
				dynamic_css += '.accentcolor-background-on_children >*, ';
				dynamic_css += '.accentcolor-background-on_hover:hover, ';
				dynamic_css += '.accentcolor-background-on_children-on_hover >*:hover {';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ' !important;';
				dynamic_css += '}';
				
				dynamic_css += '.sf-menu > li:hover > a,';
				dynamic_css += '.sf-menu > li.sfHover > a,';
				dynamic_css += '.sf-menu > .current_page_item > a,';
				dynamic_css += '.sf-menu > .current_page_parent > a,';
				dynamic_css += '.sf-menu > .current_page_ancestor > a {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.sf-arrows ul li > .sf-with-ul:focus:after,';
				dynamic_css += '.sf-arrows ul li:hover > .sf-with-ul:after,';
				dynamic_css += '.sf-arrows ul .sfHover > .sf-with-ul:after {';
				dynamic_css +=		'border-left-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.sf-menu ul {';
				dynamic_css +=		'border-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				dynamic_css += '.sf-menu ul .current_page_item > a, ';
				dynamic_css += '.sf-menu ul .current_page_parent > a, ';
				dynamic_css += '.sf-menu ul .current_page_ancestor > a {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += 'input[type="submit"]:hover, ';
				dynamic_css += '#submit:hover, ';
				dynamic_css += '.invicta_button:hover, ';
				dynamic_css += '.blog_loop .entry .more-link:hover {';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.widget ul li:before, ';
				dynamic_css += '.blog_loop_widget .entry.no_thumbnail .post_details:before {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.widget_categories li.current-cat a, ';
				dynamic_css += '.widget_categories ul.children li.current-cat a {';
				dynamic_css +=		'border-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.widget_calendar #calendar_wrap td#today,';
				dynamic_css += '.widget_calendar #calendar_wrap tbody td a {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.widget_pages .current_page_item a,	';
				dynamic_css += '.widget_nav_menu .current_page_item a {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.widget_recent_comments a {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.invicta_canvas .mejs-controls .mejs-time-rail .mejs-time-current {';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.visual_composer_invicta_styles .wpb_toggle.wpb_toggle_title_active {';
				dynamic_css +=		'border-left-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.visual_composer_invicta_styles .wpb_content_element.wpb_tabs .wpb_tabs_nav li.ui-tabs-active {';
				dynamic_css +=		'border-top-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.visual_composer_invicta_styles .wpb_content_element.wpb_tour .wpb_tabs_nav li.ui-tabs-active {';
				dynamic_css +=		'border-left-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.visual_composer_invicta_styles .wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-state-active,';
				dynamic_css += '.visual_composer_invicta_styles .wpb_content_element .wpb_accordion_wrapper .wpb_accordion_content {';
				dynamic_css +=		'border-left-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.portfolio_filters .active {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.text_styles .widget_pages a:hover, ';
				dynamic_css += '.text_styles .widget_nav_menu a:hover {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.text_styles ul > li:before {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.invicta_heading .primary strong { ';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
					
				dynamic_css += '.videos_loop_responsive li.active a, ';
				dynamic_css += '.videos_loop_responsive li.active:before {';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.invicta_hover_effect .mask { ';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 0.7) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.invicta_steps .step:hover .icon { ';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.invicta_world_map .marker { ';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css +=		'-webkit-box-shadow:0px 0px 1px 1px ' + hex2rgb(new_color, 1) + ';';
				dynamic_css +=		'-moz-box-shadow:0px 0px 1px 1px ' + hex2rgb(new_color, 1) + ';';
				dynamic_css +=		'-o-box-shadow:0px 0px 1px 1px ' + hex2rgb(new_color, 1) + ';';
				dynamic_css +=		'box-shadow:0px 0px 1px 1px ' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.invicta_photoslider .thumbnails_pane .thumbnails .thumb.current { ';
				dynamic_css +=		'border-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.portfolio_loop .entry:hover { ';
				dynamic_css +=		'border-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.blog .blog_loop .entry:hover, ';
				dynamic_css += '.archive .blog_loop .entry:hover { ';
				dynamic_css +=		'border-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				// woocommerce
				
				dynamic_css += '.woocommerce .single_product_details p.price, ';
				dynamic_css += '.woocommerce-page .single_product_details p.price, ';
				dynamic_css += '.woocommerce .single_product_details .product_meta a, ';
				dynamic_css += '.woocommerce-page .single_product_details .product_meta a, ';
				dynamic_css += '.woocommerce .single_product_details .variations_form .single_variation, ';
				dynamic_css += '.woocommerce-page .single_product_details .variations_form .single_variation, ';
				dynamic_css += '.woocommerce .side_column .widget_shopping_cart_content .total strong, ';
				dynamic_css += '.woocommerce .form-row label .required, ';
				dynamic_css += '.woocommerce-page .form-row label .required, ';
				dynamic_css += '.woocommerce table.shop_table tr.total th, ';
				dynamic_css += '.woocommerce table.shop_table tr.total, ';
				dynamic_css += '.woocommerce .cart-collaterals h2 a:hover, ';
				dynamic_css += '.woocommerce .cart-collaterals .cart_totals .total th, ';
				dynamic_css += '.woocommerce .cart-collaterals .cart_totals .total td, ';
				dynamic_css += '.woocommerce .product_sorting .sort_param ul li:before, ';
				dynamic_css += '.woocommerce .product_sorting .sort_param ul li.current_param a { ';
				dynamic_css +=		'color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.invicta_canvas .woocommerce-info:before, ';
				dynamic_css += '.woocommerce span.onsale, ';
				dynamic_css += '.woocommerce-page span.onsale {';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.woocommerce.widget_layered_nav li.chosen a {';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css +=		'color:#FFF;';
				dynamic_css += '}';
				
				dynamic_css += '.woocommerce .woocommerce-message, ';
				dynamic_css += '.woocommerce .woocommerce-info {';
				dynamic_css +=		'border-left-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.woocommerce div.product .woocommerce-tabs ul.tabs li.active, ';
				dynamic_css += '.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active {';
				dynamic_css +=		'border-top-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.woocommerce.widget_price_filter .ui-slider.hovered .ui-slider-range {';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				dynamic_css += '.woocommerce.widget_price_filter .ui-slider.hovered .ui-slider-handle {';
				dynamic_css +=		'background-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css +=		'border-color:' + hex2rgb(new_color, 1) + ';';
				dynamic_css += '}';
				
				$('#dynamic_head_style').remove();
				$('head').append('<style id="dynamic_head_style" type="text/css">' + dynamic_css + '</style>');
				
				update_logo( new_color );
				
			}
			
			function hex2rgb( hex, alpha ) {

				var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

				if (result) {
					if ( parseInt(alpha, 10) === 1 ) {
						return 'rgb(' + parseInt(result[1], 16) + ', ' + parseInt(result[2], 16) + ', ' + parseInt(result[3], 16) + ')';
					}
					else {
						return 'rgba(' + parseInt(result[1], 16) + ', ' + parseInt(result[2], 16) + ', ' + parseInt(result[3], 16) + ', ' + alpha + ')';
					}
				}
				else {
					return '';
				}

			}
			
			function update_logo( new_color ) {
			
				var $logo = $('.page_header .logo img');
			
				var logo_path = $logo.attr('src');
				var logo_name = logo_path.substr( logo_path.lastIndexOf("/") + 1 );
				var new_logo_path = '';
				var new_logo_name = '';
			
				if ( new_color === defaults.color ) { // default logo
				
					switch ( logo_name ) {
						case 'logo-gray.png':
							new_logo_name = 'logo.png';
							break;
						case 'logo-gray@2x.png':
							new_logo_name = 'logo@2x.png';
							break;
						default:
							new_logo_name = '';
							break;
					}
					
					if ( new_logo_name !== '' ) {
						new_logo_path = logo_path.replace( logo_name, new_logo_name );
					}
								
				}
				else { // unisex logo
					
					switch ( logo_name ) {
						case 'logo.png':
							new_logo_name = 'logo-gray.png';
							break;
						case 'logo@2x.png':
							new_logo_name = 'logo-gray@2x.png';
							break;
						default:
							new_logo_name = '';
							break;
					}
					
					if ( new_logo_name !== '' ) {
						new_logo_path = logo_path.replace( logo_name, new_logo_name );
					}
					
				}
				
				if ( new_logo_path !== '' ) {
					$('.page_header .logo img').attr('src', new_logo_path);
				}
				
				
			}
			
			// Toggler ------------------------------------------------------------
			
			function setup_toggler() {
			
				var cookie = $.cookie('invicta_styler_visible');
				
				if ( cookie !== undefined ) {
					$control.css('left', initial_position + 'px');
				}
				
				$control.show();
	
				setTimeout(function(){
				
					if ( should_start_collapsed() ) {
						hide_styler();
					}
					else {
						show_styler();
					}
					
					
				}, 1000);
				
				$toggler.click(function(){
					
					if (visible) {
						hide_styler();
					}
					else {
						show_styler();
					}
					
					return false;
					
				});
				
			}
			
			function show_styler() {
				$control.css('left', visible_position + 'px');
				$toggler.addClass('visible');
				$.cookie('invicta_styler_visible', '1', { expires: 1, path: '/' });
				visible = true;
			}
			
			function hide_styler() {
				$control.css('left', hidden_position + 'px');
				$toggler.removeClass('visible');
				$.cookie('invicta_styler_visible', '0', { expires: 1, path: '/' });
				visible = false;
			}
			
			function should_start_collapsed() {
				
				var start_collapsed = true;
				var cookie = $.cookie('invicta_styler_visible');
				
				if ( cookie !== undefined ) {
					if ( cookie === '1' ) {
						start_collapsed = false;
					}
					else {
						start_collapsed = true;
					}
				}
				
				return start_collapsed;
				
			}
			
			// init
			
			setup_toggler();
			setup_styler();

		});
		
	};
})(jQuery);