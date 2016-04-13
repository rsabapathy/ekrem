/*
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==

SCRIPTS TITLE: 
	Invicta - Main Scripts
		
SCRIPTS AUTHOR: 
	Oitentaecinco

SCRIPTS INDEX:

	@@ Menu
	@@ Responsive Menu
	@@ Hover Effect
	@@ Set Up Lightbox Items
	@@ Validate Form
	@@ Highlight Text
	@@ Invicta Grid / Isotope
	@@ Default Gallery Setup
	@@ Visual Composer Image Shortcode Lightbox
	@@ Progress Bar Shortcode
	@@ Counters Shortcode
	@@ Tabs / Tours / Accordions
	@@ Page 503
	@@ Photo Categories Widget Toggle
	@@ Videos Player
	@@ Retina Handler
	@@ Scroll to Top
	@@ Testimonial Carousel
	@@ World Map
	@@ Entry Carousel
	@@ Photo Slider
	@@ Fix Logo in IE8
	@@ Fixed Header
	@@ WMPL Language Switcher
	@@ IE8 Adjustments

== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/

jQuery(document).ready(function($){
	
	$('.invicta_fitvids').fitVids();
	$('.text_styles .gallery').invicta_default_gallery_setup();
	$('.wpb_tabs, .wpb_tour').invicta_tabs_icons();
	$('#invicta_top_arrow').invicta_scroll_to_top();
	$('.invicta_fixed_header').invicta_fixed_header();
	
	// fix page bottom margin
	$('.page_loop > .entry').each(function(){
		if ( $(this).find(' > div:nth-last-child(2)').hasClass('wpb_row') === false ) {
			$(this).addClass('extra_margin');
		}
	});
	
	$('.retina').invicta_retina_handler();
	
	$('.invicta_hover_effect').invicta_hover_effect();
	
	$('.page_header .logo img').invicta_fix_logo_ie8();
	
	$('.header_meta .language_switcher #lang_sel').invicta_wpml_language_switcher();
		
});

jQuery(window).load(function(){
	
	if ( jQuery('.image_black_white_effect').size() > 0 ) {
		jQuery('.image_black_white_effect').BlackAndWhite({
			hoverEffect		: true,
			webworkerPath	: false,
			responsive	: true,
			speed: {
				fadeIn		:100,
				fadeOut		:1000
			}
		});
    }

});


/*
== ------------------------------------------------------------------- ==
== @@ Menu
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_menu = function(pluginSettings) {
	
		var defaultSettings = {
			go_to_label: 'Go to...',
			child_prefix: '-',
			home_url: '',
			responsive: true
		};
		var settings = $.extend(defaultSettings, pluginSettings);
		
		return this.each(function(){
		
			var $control = $(this);
			var window_width = $(window).width();
			
			// activate superfish plugin
			$control.superfish({
				delay: settings.delay,
				animation: {opacity:'show', height:'show'},
				speed: 'fast'
			});
			
			// if the child items will open outside of the window
			// they have to be repositioned
			$control.find('ul li').mouseover(function(){
			
				var child_menus = $(this).find('>ul').size();
				if (child_menus > 0) {
					
					var submenu_width = $(this).find('>ul').width();
					var submenu_offset = $(this).find('>ul').parent().offset().left + submenu_width;
					
					if (submenu_offset + submenu_width > window_width) {
						$(this).find('>ul').css({
							left: -submenu_width - 2
						});
					}
					
				}
					
			});
			
			// create the responsive menu
			if (settings.responsive === true) {
				$control.invicta_responsive_menu({
					go_to_label: settings.go_to_label,
					child_prefix: settings.child_prefix,
					home_url: settings.home_url
				});
			}
			
		});
		
	};
})(jQuery);

/*
== ------------------------------------------------------------------- ==
== @@ Responsive Menu
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_responsive_menu = function(pluginSettings) {
	
		var defaultSettings = {
			go_to_label: 'Go to...',
			child_prefix: '-',
			home_url: ''
		};
		var settings = $.extend(defaultSettings, pluginSettings);
		
		function get_prefix(depth) {
			var prefix = '';
			for(var i=0; i<depth; i++) {
				prefix += settings.child_prefix;
			}
			return (prefix + ' ');
		}
		
		return this.each(function(){
		
			var $control = $(this);
			var $menu_container = $control.parent();
			var current_url = $control.find('.current_page_item > a').attr('href');
			
			var $select = $('<select />');
			
			// default option
			var $goto_option = $('<option />', {
				'value': '',
				'text': settings.go_to_label
			});
			$select.append($goto_option);
			
			// populate dropdown with menu items
			$control.find('a').each(function(){
				
				var $link = $(this);
				var url = $link.attr('href');
				
				if (url === undefined) {
					url = '#';
				}
				
				var depth1 = $link.parents('.children').size();
				var depth2 = $link.parents('.sub-menu').size();
				var depth = (depth1 === 0 && depth2 > 0) ? depth2 : depth1;

				var $option = $('<option />', {
					'value': url,
					'text': (get_prefix(depth) + $link.text())
				});
				
				if (current_url === $link.attr('href') && current_url !== settings.home_url) {
					$option.attr('selected', 'selected');
				}
				
				$select.append($option);
				
			});
			
			// select behavior
			$select.change(function(){
				var url = $(this).find('option:selected').val();
				if (url !== '' && url !== '#') {
					window.location = url;
				}
			});
			
			$menu_container.append($select);
			
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Hover Effect
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_hover_effect = function() {
			
		return this.each(function(){
		
			var $control = $(this);
			
			$control.mouseover(function(){

				// adjust mask width
				var child_element_width = $control.find('.element').children().width();
				$control.find('.mask').css('width', child_element_width);
				
				// adjust caption positioning
				var $caption = $(this).find('.caption');
				var caption_height = $caption.height();
				if ( caption_height > 0 ) {
					$caption.css('margin-top', '-' + parseInt(caption_height / 2, 10) + 'px');
				}
				
			});
			
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Set Up Lightbox Items
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_setup_lightbox_items = function() {
			
		return this.each(function(){
		
			var $control = $(this);
			
			function get_linked_elements_for_lightbox() {
				
				var patterns = [];
				patterns.push('a[href$=".jpg"]');
				patterns.push('a[href$=".jpeg"]');
				patterns.push('a[href$=".gif"]');
				patterns.push('a[href$=".png"]');
				
				return $control.find(patterns.join(', '));
				
			}
			
			var $lightbox_items = get_linked_elements_for_lightbox();
			
			// lightbox
							
			if ( $.isFunction($.fancybox) ) {
			
				
				$lightbox_items.each(function(){
					
					$(this).attr('rel', 'gallery-pe');
							
					var title = $(this).parent('.invicta_portfolio.entry').find('.title').text();
					var meta = $(this).parent('.invicta_portfolio.entry').find('.description').text();
					
					title = $.trim(title) + ' | ' + $.trim(meta);
					
					$(this).attr('title', title);
					
				});

				$lightbox_items.fancybox({
					'transitionIn': 'elastic',
					'transitionOut': 'elastic',
					'titlePosition': 'over',
					'padding': 0,
					'titleFormat': function(title, currentArray, currentIndex) {
						
						var output = '';
						
						if (title !== '') {
							output += '<span id="fancybox-title-over">';
								output += title;
								output += '<span style="float:right">' + '<i class="icon-camera"></i> &nbsp;' + (currentIndex + 1) + ' / ' + currentArray.length + '</span>';
							output += '</span>';
						}
						
						return  output;
					}
				});
				
			}
			
		});
		
	};
})(jQuery);



/*
== ------------------------------------------------------------------- ==
== @@ Validate Form
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_validate_form = function() {
	
		function isEmail(email) {
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}
		
		function isUrl(url) {
			var re = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			return re.test(url);
		}
				
		return this.each(function(){

			var $form = $(this);
			var $submit = $form.find('input:submit');
			var $requiredFields = $form.find('.required');
			var $emailFields = $form.find('.email');
			var $urlFields = $form.find('.url');
			var $legendInvalidFields = $form.find('.legend_invalid');
			
			$submit.click(function(){
				
				var isValid = true;
				
				// validate required fields
				$requiredFields.removeClass('invalid').each(function(){
					if ($(this).val() === '') {
						$(this).addClass('invalid');
						isValid = false;
					}
				});
				
				// validate email fields
				$emailFields.each(function(){
					if ($(this).val() !== '') {
						if (!isEmail($(this).val())) {
							$(this).addClass('invalid');
							isValid = false;
						}
					}
				});
				
				// validate url fields
				$urlFields.each(function(){
					if ($(this).val() !== '') {
						if (!isUrl($(this).val())) {
							$(this).addClass('invalid');
							isValid = false;
						}
					}
				});
				
				if (!isValid) {
					$legendInvalidFields.fadeIn('slow');
				}
				
				return isValid;
				
			});
			
		});
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Highlight Text
== ------------------------------------------------------------------- ==
*/

jQuery.fn.invicta_highlight_text = function (str, className) {
    var regex = new RegExp(str, "gi");
    return this.each(function () {
        jQuery(this).contents().filter(function() {
            return this.nodeType === 3 && regex.test(this.nodeValue);
        }).replaceWith(function() {
            return (this.nodeValue || "").replace(regex, function(match) {
                return "<span class=\"" + className + "\">" + match + "</span>";
            });
        });
    });
};


/*
== ------------------------------------------------------------------- ==
== @@ Invicta Grid / Isotope
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_grid_isotope = function(pluginSettings) {
	
		var defaultSettings = {
			gutter: 50,
			item_selector: '.entry',
			filtering: false,
			filters_selector: ''
		};
		var settings = $.extend(defaultSettings, pluginSettings);
			
		return this.each(function() {

			var $control = $(this);
			var $window = $(window);
		
			$.Isotope.prototype._getMasonryGutterColumns = function() {
				var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
				var containerWidth = this.element.width();

				this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth || this.$filteredAtoms.outerWidth(true) || containerWidth;
				this.masonry.columnWidth += gutter;
				this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
				this.masonry.cols = Math.max( this.masonry.cols, 1 );
			};

			$.Isotope.prototype._masonryReset = function() {
				this.masonry = {};
				this._getMasonryGutterColumns();
				var i = this.masonry.cols;
				this.masonry.colYs = [];
				while (i--) {
					this.masonry.colYs.push( 0 );
				}
			};

			$.Isotope.prototype._masonryResizeChanged = function() {
				var prevSegments = this.masonry.cols;
				this._getMasonryGutterColumns();
				return ( this.masonry.cols !== prevSegments );
			};
		
			$control.imagesLoaded(function(){
				reLayout();
				$control.css('opacity', 1);
				$window.smartresize(reLayout);
			});
			
			function reLayout() {
				
				var masonryOpts = {
					columnWidth: $control.find(settings.item_selector).width(),
					gutterWidth: settings.gutter
				};
				
				$control.isotope({
					resizable: false,
					itemSelector: settings.item_selector,
					masonry: masonryOpts,
					onLayout: function() {
						
						// re-trigger waypoints
						if (typeof jQuery.fn.waypoint !== 'undefined') {
							$('.wpb_animate_when_almost_visible').waypoint(function() {
								$(this).addClass('wpb_start_animation');
							}, { offset: '85%' });
						}
						
						
						
					}
				});
				
			}
			
			$control.bind('reset', reLayout);
			
			// filtering 
			if ( settings.filtering ) {
			
				$(settings.filters_selector).find('a').click(function(){
					
					$(settings.filters_selector).find('a').removeClass('active');
					$(settings.filters_selector).find('a').parent('li').removeClass('current-cat');
					
					$(this).addClass('active');
					$(this).parent('li').addClass('current-cat');
					
					$control.isotope({
						filter:$(this).data('filter')
					});
					
					return false;
					
				});
				
			}
			
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Default Gallery Setup
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_default_gallery_setup = function() {
				
		return this.each(function() {
		
			var patterns = [];
			patterns.push('a[href$=".jpg"]');
			patterns.push('a[href$=".jpeg"]');
			patterns.push('a[href$=".gif"]');
			patterns.push('a[href$=".png"]');
		
			var $control = $(this);
			var $gallery_items = $control.find(patterns.join(', '));
			
			var gallery_id = $control.attr('id');
			
			if ($gallery_items.length > 0) {
				
				// group images for gallery
				$gallery_items.attr('rel', gallery_id);
				
				// set up captions
				$gallery_items.each(function(){
					var caption = $(this).parents('dl').find('.gallery-caption').text();
					caption = $.trim(caption);
					$(this).attr('title', caption);
				});
				
				$gallery_items.fancybox({
					'transitionIn': 'elastic',
					'transitionOut': 'elastic',
					'titlePosition': 'over',
					'padding': 0,
					'titleFormat': function(title, currentArray, currentIndex) {
						
						var output = '';
						
						if (title !== '') {
							output += '<span id="fancybox-title-over">';
								output += title;
								output += '<span style="float:right">' + '<i class="icon-camera"></i> &nbsp;' + (currentIndex + 1) + ' / ' + currentArray.length + '</span>';
							output += '</span>';
						}
						
						return  output;
					}
				});
			}
			
			
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Visual Composer Image Shortcode Lightbox
== ------------------------------------------------------------------- ==
*/

(function($){

	$(document).ready(function(){
	
		var patterns = [];
		patterns.push('.wpb_single_image a[href$=".jpg"]');
		patterns.push('.wpb_single_image a[href$=".jpeg"]');
		patterns.push('.wpb_single_image a[href$=".gif"]');
		patterns.push('.wpb_single_image a[href$=".png"]');
		
		var $items = $('body').find(patterns.join(', '));

		if ( $.isFunction($.fancybox) ) {
		
			$items.addClass('invicta_hover_effect').invicta_hover_effect();
			
			$items.each(function(){
				
				var $content = $(this).html();
				
				var $element = $('<span>').addClass('element').html($content);
				
				var $mask = $('<span>').addClass('mask');
				var $caption = $('<span>').addClass('caption');
				var $caption_title = $('<span>').addClass('title').html('<i class="icon-zoom-in"></i>');
				
				$mask.append($caption.append($caption_title));
				
				$(this).html($element).append($mask);
				
				
			});
		
			$items.fancybox({
				'transitionIn': 'elastic',
				'transitionOut': 'elastic',
				'titlePosition': 'over',
				'padding': 0
			});
		
		}
	
	});
				
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Progress Bar Shortcode
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_progressbar = function(pluginSettings) {
	
		var defaultSettings = {
			delay: 200
		};
		var settings = $.extend(defaultSettings, pluginSettings);
			
		return this.each(function(){
			
			if (typeof jQuery.fn.waypoint !== 'undefined') {
			
				$(this).waypoint(function(){
				
					$(this).find('.bar .progress').each(function(index){
					
						var $bar = $(this);
						var value = $(this).data('percentage-value');
						
						setTimeout(function(){
							$bar.css({
								'width': value + '%'
							});
							
						}, index * settings.delay);
						
					});
					
				}, { offset: '85%' });
				
			}
						
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Counters Shortcode
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_counters = function(plugin_parameters) {
	
		var default_parameters = {
			animate: 1
		};
		var parameters = $.extend(default_parameters, plugin_parameters);
	
		return this.each(function(){
		
			var $control = $(this);
			var settings = {
				animated: false,
				animate_gap: 300,
				init_delay: 300,
				css_transforms_available: $('html').hasClass('csstransforms')
			};
					
			if ( parameters.animate === 1 && settings.css_transforms_available === true ) {
			
				$control.find('.counter .counter_elem').each(function(){
					
					var current_value = parseInt( $(this).text() );
					var start_value = current_value - settings.animate_gap;
					if ( start_value < 0 ) {
						start_value = 0;
					}

					$(this).text( start_value );
					
				});

			}
			
			$control.find('.counter .counter_elem').counter();
			$control.find('.counter .counter_elem').counter('stop');

			$control.fadeIn();
			
			if ( parameters.animate === 1 && settings.css_transforms_available === true ) {
				if (typeof jQuery.fn.waypoint !== 'undefined') {
					$(this).waypoint(function(){
					
						$(this).find('.counter .counter_elem').each(function(){
							$(this).counter('play');
						});
						
					}, { offset: '85%' });
				}
			}
		
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Tabs / Tours / Accordions
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_tabs_icons = function() {
				
		return this.each(function(){
			
			var $control = $(this);
			
			$control.find('.wpb_tab').each(function(){
				
				var $tab_id = $(this).attr('id');
				var $tab_icon = $(this).find('.tab_icon');
				
				if ( $tab_icon.size() > 0 ) {
				
					var $tab_index = $control.find('a[href="#' + $tab_id + '"]');
					$tab_index.html( $tab_icon.html() + $tab_index.html() );
					
				}
				
			});
						
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Page 503
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_page503 = function() {
			
		return this.each(function(){
			
			var $control = $(this);
			
			var height = $control.outerHeight(true);
			
			$control.css({
				'position': 'absolute',
				'top':	'50%',
				'margin-top': '-' + ( height / 2 ) + 'px'
			});
			
			$control.fadeIn();
						
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Photo Categories Widget Toggle
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_photo_categories_widget_toggle = function() {
			
		return this.each(function(){
			
			var $control = $(this);
			
			$control.find(' > ul > li:not(.current-cat)').each(function(){
				$(this).find('.children').hide();
			});
			
			$control.find('.cat-item:not(.current-cat) > a').click(function(){
			
				var $children = $(this).siblings('.children');
				
				if ( $children.is(':visible') ) {
					$children.slideUp();
				}
				else {
					$children.slideDown();
				}
				
				return false;
				
			});
			
			$control.find('.current-cat > a').click(function(){
				return false;
			});
						
		});
		
	};
})(jQuery);

/*
== ------------------------------------------------------------------- ==
== @@ Retina Handler
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_retina_handler = function() {

		var preload_image = function( path, callback ) {
			var img = new Image();
			img.onload = function(){
				callback( img );
			};
			img.src = path;
		};
					
		return this.each(function(){
			
			var $image = $(this).find('img');
			var retina_path = $image.data('retina');

			if ( window.devicePixelRatio > 1 ) {
			
				preload_image(retina_path, function(img){
				
					$image.attr('src', img.src);
					
					/*
					var img_html = $('<div>').append($image.clone()).remove().html();
					if ( ! (/(width|height)=["']\d+["']/.test( img_html ) ) ) {
						if ( img.width >= img.height ) {
							$image.attr("width", img.width / 2);
						}
						else {
							$image.attr("height", img.height / 2);
						}
					}
					*/
					
				});

			}
						
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Timespan
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_timespan = function(pluginSettings) {
	
		var defaultSettings = {
			class_prefix: '',
			period: '0',
			begin_at: ''
		};
		var settings = $.extend(defaultSettings, pluginSettings);
			
		return this.each(function(){
		
			var $control = $(this).find('.invicta_timespan_graphic');
			
			if (typeof jQuery.fn.waypoint !== 'undefined') {
			
				$control.removeClass( settings.class_prefix + settings.period );
			
				// check if the period has half hours
				
				var period_hours = 0;
				var half_hour_period = false;
			
				var splitted_period = settings.period.split('_');
				if ( splitted_period.length > 1 ) {
					period_hours = splitted_period[0];
					half_hour_period = true;
				}
				period_hours = splitted_period[0];
				
				
				// setup the array of period css classes
				
				var periods = [];
				
				for ( var i = 0; i <= period_hours; i++ ) {
					
					periods.push(settings.class_prefix + i);
					
					if ( i < period_hours ) {
						periods.push(settings.class_prefix +  i + '_5' );
					}
					else {
						if ( half_hour_period ) {
							periods.push(settings.class_prefix +  i + '_5' );
						}
					}
					
				}
				
				if ( periods ) {
					
					// pre-loading images
					
					var $timespan_preloader = $('<div>').attr('id', 'timsepan_preloader');
					$('body').append($timespan_preloader);
					
					for ( i = 0; i < periods.length; i++ ) {
	
						var $control_clone = $control.clone();
						
						$control_clone.removeClass( settings.class_prefix + settings.period );
						$control_clone.removeClass( settings.begin_at );
						$control_clone.addClass( periods[i] );
						
						$timespan_preloader.append($control_clone);
						
					}
					
					// trigger animation when in viewport

					$(this).waypoint(function(){
						
						var index = 0;
						
						var delay = setInterval(function(){
						
							$control.addClass( periods[index] );
							
							index++;
							
							if ( index === periods.length ) {
								clearInterval(delay);
							}

						}, 30);
						
						$timespan_preloader.remove();
						
					}, { offset: '85%' });

				}
				
			}
						
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Scroll to Top
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_scroll_to_top = function() {
	
		return this.each(function(){

			$(this).click(function(){
				if ($(window).scrollTop() > 0) {
					$('body, html').animate({
						scrollTop:0
					}, 800);
				}
				return false;
			});

		});
		
	};
})(jQuery);

jQuery(function($){

	var scroll_timer,
		displayed = false,
		$links = $('#invicta_top_arrow'),
		$window = $(window),
		top = $(document.body).children(0).position().top;
	
	// hide back to top buttons by default	
	$links.hide();
		
	// react to window scroll event
	$window.scroll(function(){
		
		window.clearTimeout(scroll_timer);
		
		scroll_timer = window.setTimeout(function(){ // use a timer to better the perfomance
		
			if ($window.scrollTop() <= top) { // hide if at the top of the page
				displayed = false;
				$links.fadeOut(500);
			}
			else if (displayed === false) { //show if scrolling down
				displayed = true;
				$links.stop(true, true).fadeIn(500).click(function(){
					$links.fadeOut(500);
				});
			}
			
		}, 300);
		
	});
	
});


/*
== ------------------------------------------------------------------- ==
== @@ Testimonial Carousel
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_testimonial_carousel = function(plugin_parameters) {
	
		var default_parameters = {
			timeout:0,
		};
		var parameters = $.extend(default_parameters, plugin_parameters);
		
		return this.each(function(){
		
			// vars

			var $control = $(this);
			var $groups = $control.find('.group');
			
			var $prev = $control.find('.nav_arrows a.prev');
			var $next = $control.find('.nav_arrows a.next');
			var $bullets_holder = $control.find('.nav_bullets');
			
			var settings = {
				carousel_timer: null,
				carousel_hovering: false,
				resizing: null,
				num_groups: $groups.size(),
				index: 0,
				css_transforms_available: $('html').hasClass('csstransforms')
			};
			

			// functions

			function swap(next_index) {
			
				// 1. setup indexes
				
				if ( next_index > settings.index ) { // next
					if ( next_index >= settings.num_groups ) {
						next_index = 0;
					}
				}
				else { // previous
					if ( next_index < 0 ) {
						next_index = settings.num_groups - 1;
					}
				}
				
				var $current_group = $groups.eq(settings.index);
				var $next_group = $groups.eq(next_index);
				
				// 2. swap items
				
				$current_group.removeClass('active');
				$next_group.addClass('active');
					
				if ( settings.css_transforms_available ) {
					animated_swap($current_group, $next_group);
				}
				else {
					fixed_swap($current_group, $next_group);
				}
				
				// 3. adjust bullet navigation
				
				$bullets_holder.find('a').each(function(){
					if ( $(this).data('index') === settings.index ) {
						$(this).removeClass('current');
					}
					if ( $(this).data('index') === next_index ) {
						$(this).addClass('current');
					}
				});
				
				// 4. adjust current index
				
				settings.index = next_index;
				
			}
			
			function animated_swap( $current_group, $next_group ) {
				
				if ( $current_group.find('.right_aligned').size() > 0 ) {
				
					// hiding old left element
					$current_group.find('.right_aligned .media').transition({y:-400, easing:'easeInQuint'}).transition({opacity:0});
					$current_group.find('.right_aligned .info').transition({y:-400, delay:100, easing:'easeInQuint'}).transition({opacity:0});
					$current_group.find('.right_aligned .text').transition({y:-400, delay:200, easing:'easeInQuint'}).transition({opacity:0});
					
					setTimeout(function(){
					
						// hiding old right element
						$current_group.find('.left_aligned .media').transition({y:400, easing:'easeInQuint'}).transition({opacity:0});
						$current_group.find('.left_aligned .info').transition({y:400, delay:200, easing:'easeInQuint'}).transition({opacity:0});
						$current_group.find('.left_aligned .text').transition({y:400, delay:100, easing:'easeInQuint'}).transition({opacity:0});
						
						setTimeout(function(){
						
							if ( $next_group.find('.right_aligned').size() > 0 ) {
							
								// showing new left element
								$next_group.find('.right_aligned .media').transition({opacity:1}).transition({y:0, easing:'easeOutExpo'});
								$next_group.find('.right_aligned .info').transition({opacity:1}).transition({y:0, delay:100, easing:'easeOutExpo'});
								$next_group.find('.right_aligned .text').transition({opacity:1}).transition({y:0, delay:200, easing:'easeOutExpo'});
								
								setTimeout(function(){
		
									// showing new right element
									$next_group.find('.left_aligned .media').transition({opacity:1}).transition({y:0, easing:'easeOutExpo'});
									$next_group.find('.left_aligned .info').transition({opacity:1}).transition({y:0, delay:100, easing:'easeOutExpo'});
									$next_group.find('.left_aligned .text').transition({opacity:1}).transition({y:0, delay:200, easing:'easeOutExpo'});
									
									$control.height($next_group.height());
									
								}, 200);
								
							}
							else {
								
								// showing new left element
								$next_group.find('.full_aligned .media').transition({opacity:1}).transition({y:0, easing:'easeOutExpo'});
								$next_group.find('.full_aligned .info').transition({opacity:1}).transition({y:0, delay:100, easing:'easeOutExpo'});
								$next_group.find('.full_aligned .text').transition({opacity:1}).transition({y:0, delay:200, easing:'easeOutExpo'});
								
								$control.height($next_group.height());
								
							}
							
						}, 200);
					
					},200);
				
				}
				else {
					
					// hiding old full element
					$current_group.find('.full_aligned .media').transition({y:-400, easing:'easeInQuint'}).transition({opacity:0});
					$current_group.find('.full_aligned .info').transition({y:-400, delay:100, easing:'easeInQuint'}).transition({opacity:0});
					$current_group.find('.full_aligned .text').transition({y:-400, delay:200, easing:'easeInQuint'}).transition({opacity:0});
					
					setTimeout(function(){
						
						if ( $next_group.find('.right_aligned').size() > 0 ) {
						
							// showing new left element
							$next_group.find('.right_aligned .media').transition({opacity:1}).transition({y:0, easing:'easeOutExpo'});
							$next_group.find('.right_aligned .info').transition({opacity:1}).transition({y:0, delay:100, easing:'easeOutExpo'});
							$next_group.find('.right_aligned .text').transition({opacity:1}).transition({y:0, delay:200, easing:'easeOutExpo'});
							
							setTimeout(function(){
	
								// showing new right element
								$next_group.find('.left_aligned .media').transition({opacity:1}).transition({y:0, easing:'easeOutExpo'});
								$next_group.find('.left_aligned .info').transition({opacity:1}).transition({y:0, delay:100, easing:'easeOutExpo'});
								$next_group.find('.left_aligned .text').transition({opacity:1}).transition({y:0, delay:200, easing:'easeOutExpo'});
								
								$control.height($next_group.height());
								
							}, 200);
							
						}
						else {
							
							// showing new left element
							$next_group.find('.full_aligned .media').transition({opacity:1}).transition({y:0, easing:'easeOutExpo'});
							$next_group.find('.full_aligned .info').transition({opacity:1}).transition({y:0, delay:100, easing:'easeOutExpo'});
							$next_group.find('.full_aligned .text').transition({opacity:1}).transition({y:0, delay:200, easing:'easeOutExpo'});
							
							$control.height($next_group.height());
							
						}
						
					}, 200);
					
				}
				
			}
			
			function fixed_swap( $current_group, $next_group ) {
				
				if ( $current_group.find('.left_aligned').size() > 0 ) {
					
					$current_group.find('.left_aligned').fadeOut();
					
					setTimeout(function(){
						
						$current_group.find('.right_aligned').fadeOut();
						
						setTimeout(function(){
						
							if ( $next_group.find('.right_aligned').size() > 0 ) {
							
								$next_group.find('.right_aligned').fadeIn();
								
								setTimeout(function(){
								
									$next_group.find('.left_aligned').fadeIn();
									$control.height($next_group.height());
								
								}, 200);
								
							}
							else {
							
								$next_group.find('.full_aligned').fadeIn();
								$control.height($next_group.height());
								
							}
						

						
						}, 200);
						
					}, 200);
					
				}
				else {
					
					$current_group.find('.full_aligned').fadeOut();
					
					setTimeout(function(){
					
						if ( $next_group.find('.right_aligned').size() > 0 ) {
						
							$next_group.find('.right_aligned').fadeIn();
							
							setTimeout(function(){
							
								$next_group.find('.left_aligned').fadeIn();
								$control.height($next_group.height());
							
							}, 200);
						
						}
						else {
							
							$next_group.find('.full_aligned').fadeIn();
							$control.height($next_group.height());
							
						}
					
					}, 200);
					
				}
				
				
			}
			
			function init() {
			
				if ( settings.css_transforms_available ) {
				
					$groups.find('.media, .info, .text').transition({y:'400px', opacity:0});
					$groups.find('.invicta_testimonial').show();
					$groups.first().addClass('active');
					$control.height($groups.first().height());
					setTimeout(function(){
						$groups.eq(settings.index).find('.media, .info, .text').transition({y:'0px', opacity:1});
					}, 400);
	
				}
				else {
					
					$groups.first().addClass('active').find('.invicta_testimonial').fadeIn();
					$control.height($groups.first().height());
					
				}
				
			}
			
			function setup_bullet_navigation() {
				
				$.each($groups, function(i){
					
					var $bullet = $('<a>', {
						'href': '#'
					}).data('index', i);
					
					$bullet.click(function(){
						setup_carousel_timer();
						swap($(this).data('index'));
						return false;
					});
					
					$bullets_holder.append($bullet);
					
				});
				
				$bullets_holder.find('a:first').addClass('current');
				
			}
			
			function setup_arrow_navigation() {
				
				$prev.click(function(){
					setup_carousel_timer();
					swap(settings.index - 1);
					return false;
				});
				
				$next.click(function(){
					setup_carousel_timer();
					swap(settings.index + 1);
					return false;
				});
				
			}
			
			function setup_hovering() {
				$control.hover(function(){
					settings.carousel_hovering = true;
				}, function(){
					settings.carousel_hovering = false;
				});
			}
			
			function setup_window_resizing() {
				
				$(window).resize(function(){
					clearInterval(settings.resizing);
					settings.resizing = setTimeout(function(){
						$control.height($groups.eq(settings.index).height());
					}, 200);
				});
				
			}
			
			function setup_carousel_timer() {
				
				if ( parameters.timeout > 0 ) {
					
					clearInterval(settings.carousel_timer);
					settings.carousel_timer = setInterval(function(){
						
						if ( ! settings.carousel_hovering ) {
							swap(settings.index + 1);
						}
						
					}, parameters.timeout);
					
				}
				
			}
			
			
			// init
			
			setup_bullet_navigation();
			setup_arrow_navigation();
			setup_window_resizing();
			setup_hovering();
			setup_carousel_timer();
			init();

		});
		
	};
})(jQuery);

/*
== ------------------------------------------------------------------- ==
== @@ World Map
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_world_map = function(plugin_parameters) {
	
		var default_parameters = {
			dataset:null,
			label_offset:10,
			label_visibility:'always', // always, never, hover,
			initial_animation_timeout: 200
		};
		var parameters = $.extend(default_parameters, plugin_parameters);
	
		return this.each(function(){

			var $control = $(this);
			var $map_canvas = $(this).find('.map_canvas');
			var $responsive_labels_holder = $(this).find('.responsive_labels');

			var settings = {
				resize_timer: null,
				already_visible: false
			};
			
			var $locations = [];
			
			function setup() {
			
				if (parameters.dataset !== null) {
				
					$.each(parameters.dataset, function(index, location){
					
						var $marker = $('<span>', {
							'class': 'marker ' + location.location_id
						});
						
						$marker.css('opacity', 0);
						
						var $label = $('<span>', {
							'class': 'label',
							'text': location.location_name
						});
							
						$label.css('opacity', 0);
						
						$map_canvas.append($marker);
						$map_canvas.append($label);
						
						var $location = {
							marker: $marker,
							label: $label,
							label_position: location.label_position
						};

						if ( $location.label_position === null ) {
							$location.label_position = 'bottom_right';
						}
						
						$locations.push($location);
						
						set_label_visibility($marker, $label, parameters.label_visibility);
						
						// responsive labels
						
						var $reponsive_label = $('<span>').addClass('invicta_flag').addClass(location.location_id).text(location.location_name);
						$responsive_labels_holder.append($reponsive_label);
						
					});
					
					reset_labels_positions();
					
					
					if (typeof jQuery.fn.waypoint !== 'undefined') {
						$control.waypoint(function(){
							if ( ! settings.already_visible ) {
								first_display();
							}
						}, { offset: '85%' });
					}
					else {
						first_display();
					}
					
				}
				
			}
			
			function set_label_position($marker, $label, alignment) {
				
				var map_width = $map_canvas.width();
				var map_height = $map_canvas.height();
				
				var marker_width = $marker.outerWidth();
				var marker_height = $marker.outerHeight();
				
				var label_width = $label.outerWidth();
				var label_height = $label.outerHeight();
				
				var marker_position = {
					top: $marker.position().top,
					left: $marker.position().left
				};
				
				if ( alignment === 'bottom_right' ) {
					
					marker_position.top += parameters.label_offset + (marker_width / 2);
					marker_position.left += parameters.label_offset + (marker_height / 2);
					
				}
				else if ( alignment === 'top_right' ) {
					
					marker_position.top -= parameters.label_offset + label_height - (marker_height / 2);
					marker_position.left += parameters.label_offset + (marker_height / 2);
					
				}
				else if ( alignment === 'bottom_left' ) {
					
					marker_position.top += parameters.label_offset + (marker_width / 2);
					marker_position.left -= parameters.label_offset + label_width - (marker_width / 2);
					
				}
				else if ( alignment === 'top_left' ) {
					
					marker_position.top -= parameters.label_offset + label_height - (marker_height / 2);
					marker_position.left -= parameters.label_offset + label_width - (marker_width / 2);
					
				}
				
				// converting px to %
				marker_position.top = ( marker_position.top / map_height * 100);
				marker_position.left = ( marker_position.left / map_width * 100);
				
				$label.css({
					'top': marker_position.top + '%',
					'left': marker_position.left + '%'
				});
				
				if ( alignment === 'top_left' || alignment === 'bottom_left') {
					$label.css('text-align', 'right');
				}
												
			}
			
			function reset_labels_positions() {
			
				for ( var i = 0; i < $locations.length; i ++ ) {
					set_label_position($locations[i].marker, $locations[i].label, $locations[i].label_position);
				}
				
			}
			
			function first_display() {
				
				var index = 0;
				settings.already_visible = true;
				
				var display_delay = setInterval(function(){
					
					$locations[ index ].marker.animate({opacity:1}, 400);
					
					$locations[ index ].label.animate({opacity:1}, 350, function(){
					
						var $marker = $(this);
						$marker.addClass('animated');
						setTimeout(function(){
							$marker.removeClass('animated');
						}, 300);

					});
					
					index++;
					
					if ( index >= $locations.length ) {
						clearInterval(display_delay);
					}
					
				}, parameters.initial_animation_timeout);
								
			}
			
			function set_label_visibility($marker, $label, mode) {
			
				if ( mode === 'always') {
					
				}
				else if ( mode === 'hover' ) {
				
					$label.hide();
					$marker.css('cursor', 'pointer');
					
					$marker.mouseenter(function(){
						$map_canvas.find('.label').hide();
						$label.show();
					}).mouseleave(function(){
						setTimeout(function(){
							$label.fadeOut(700);
						}, 100);
					});
	
				}
				else if ( mode === 'never' ) {
					
					$label.hide();
					
				}
				

				
			}
			
			$(window).resize(function(){

				clearInterval(settings.resize_timer);
								
				settings.resize_timer = setTimeout(function(){
					reset_labels_positions();
				}, 200);
				
			});
			
			setup();
		
		});
		
	};
})(jQuery);

/*
== ------------------------------------------------------------------- ==
== @@ Entry Carousel
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_entry_carousel = function(plugin_parameters) {
	
		var default_parameters = {
			timeout:5000
		};
		var parameters = $.extend(default_parameters, plugin_parameters);
	
		return this.each(function(){

			var $control = $(this);
			var $wrapper = $control.find('.videos_wrapper');
			var carousel_timer = null;
			var carousel_hover = false;
			var delay = null;
						
			function next_entry() {
				
				var entry_width = $control.find('.entry').outerWidth(true);
				var total_width = $control.find('.stage').data('stage_width');
				var scrolled_width = $wrapper.scrollLeft() + $control.width();
				
				if ( scrolled_width + entry_width <= total_width ) {
					$wrapper.filter(':not(:animated)').animate({
						scrollLeft: '+=' + entry_width
					}, 700, 'easeInOutCubic', function(){
						adjust_navigation();
					});
				}
				else {
					return false;
				}
				
				return true;
				
			}
			
			function prev_entry() {
				
				var entry_width = $control.find('.entry').outerWidth(true);
				
				$wrapper.filter(':not(:animated)').animate({
					scrollLeft: '-=' + entry_width
				}, 700, 'easeInOutCubic', function(){
					adjust_navigation();
				});
				
			}
			
			function first_entry() {
			
				var useful_width = 0;
				$control.find('.entry').each(function(){
					useful_width += $(this).outerWidth(true);
				});
				$control.find('.stage').data('stage_width', useful_width);
				$control.find('.stage').width(useful_width + 1000);
			
				$wrapper.filter(':not(:animated)').animate({
					scrollLeft: '-=' + $wrapper.scrollLeft()
				}, 700, 'easeInOutCubic', function(){
					adjust_navigation();
				});
				
			}

			function setup_navigation() {
			
				var $nav = $('<div>').addClass('nav_arrows');
				
				var $next = $('<a href="#">').addClass('next').html('<i class="icon-chevron-right"></i>');
				var $prev = $('<a href="#">').addClass('prev').html('<i class="icon-chevron-left"></i>');
				
				$next.click(function(){
					setup_carousel_timer();
					next_entry();
					return false;
				});
				
				$prev.click(function(){
					setup_carousel_timer();
					prev_entry();
					return false;
				});
				
				$prev.hide();
				$next.hide();
				
				$control.append($nav);
				$nav.append($prev);
				$nav.append($next);
				
			}
			
			function adjust_navigation() {
			
				var entry_width = $control.find('.entry').outerWidth(true);
				var total_width = $control.find('.stage').data('stage_width');
				var scrolled_width = $wrapper.scrollLeft() + $control.width();
				
				if ( $wrapper.scrollLeft() <= 0 ) {
					$control.find('.nav_arrows .prev').hide();
				}
				else {
					$control.find('.nav_arrows .prev').show();
				}
				
				if ( scrolled_width + entry_width <= total_width ) {
					$control.find('.nav_arrows .next').show();
				}
				else {
					$control.find('.nav_arrows .next').hide();
				}
				
			}
			
			function setup_carousel_timer() {
				
				if ( parameters.timeout > 0 ) {
					
					clearInterval(carousel_timer);
					carousel_timer = setInterval(function(){
						
						if ( ! carousel_hover ) {
							if ( ! next_entry() ) {
								first_entry();
							}
						}
						
					}, parameters.timeout);
					
				}
				
			}
			
			setup_navigation();
			first_entry();
			setup_carousel_timer();
			
			$(window).resize(function(){
				
				clearTimeout(delay);
				
				delay = setTimeout(function(){
					setup_carousel_timer();
					first_entry();
				}, 600);
				
			});
			
			$control.hover(function(){
				carousel_hover = true;
			}, function(){
				carousel_hover = false;
			});
		
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Photo Slider
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_photoslider = function(plugin_parameters) {
	
		var default_parameters = {
			timeout:6000
		};
		
		var parameters = $.extend(default_parameters, plugin_parameters);
		
		var preload_image = function( path, callback ) {
			var img = new Image();
			img.onload = function(){
				callback( img );
			};
			img.src = path;
		};
	
		return this.each(function(){

			var $control = $(this);
			
			var $stage = $control.find('.stage');
			var $thumbnails = $control.find('.thumbnails a');

			var $nav_arrows = null;
			var $pane_thumbnails = null;
			var $label_description = null;
			var $label_counter = null;
			var $btn_play = null;
			
			var settings = {
				num_photos: $thumbnails.size(),
				current_photo: 0,
				resizing: null,
				slideshow_playing: false,
				slideshow_timer:null
			};
			
			
			
			function setup_nav_arrows() {
			
				if ( $thumbnails.size() > 0 ) {
					
					$nav_arrows = $('<div>', {
						'class': 'nav_arrows'
					});
					
					var $prev = $('<a>', {
						'href': '#',
						'class': 'prev accentcolor-text-on_hover inherit-color',
						'html': '<i class="icon-chevron-left"></i>'
					}).click(function(){
						change_photo( settings.current_photo - 1 );
						return false;
					});
					
					var $next = $('<a>', {
						'href': '#',
						'class': 'next accentcolor-text-on_hover inherit-color',
						'html': '<i class="icon-chevron-right"></i>'
					}).click(function(){
						change_photo( settings.current_photo + 1 );
						return false;
					});
					
					$stage.append($nav_arrows.append($prev).append($next));
					
				}
				
			}
			
			function setup_controller() {
				
				var $controller = $('<div>', {'class':'controller'});
				
				var $btn_mosaic = $('<a>', {
					'href': '#',
					'class': 'mosaic accentcolor-text-on_hover',
					'html': '<i class="icon-th"></i>'
					}).click(function(){
					
						if ( $pane_thumbnails.hasClass('visible') ) {
							hide_thumnails_pane();
						}
						else {
							show_thumbnails_pane();
						}
						
						return false;
					});
					
				$btn_play = $('<a>', {
					'href': '#',
					'class': 'play accentcolor-text-on_hover',
					'html': '<i class="icon-play"></i>'
				}).click(function(){
					
					if ( settings.slideshow_playing ) {
						stop_slideshow();
						$(this).html('<i class="icon-play"></i>');
					}
					else {
						start_slideshow();
						$(this).html('<i class="icon-pause"></i>');
					}
					
					return false;
					
				});
										
				$label_description = $('<span>', {
					'class': 'description',
					'text': $stage.find('img').attr('alt')
					});
					
				$label_counter = $('<span>', {
					'class': 'counter',
					'text': get_counter_label()
					});
					
				$controller.append($btn_play).append($label_description);
				$controller.append($btn_mosaic).append($label_counter);
				
				$control.append($controller);
				
				// thumbnails pane
				
				$pane_thumbnails = $('<div>', {
					'class': 'thumbnails_pane',
					'html': $control.find('.thumbnails')
				}).css({
					'top': $stage.height(),
					'display': 'none'
				});
								
				$stage.append($pane_thumbnails);
				
				$pane_thumbnails.find('.thumbnails a').click(function(){
					
					if ( ! $(this).hasClass('current') ) {
						
						hide_thumnails_pane();
						change_photo($(this).index());
						
						if (settings.slideshow_playing) {
							stop_slideshow();
							start_slideshow();
						}
						
					}

					return false;
					
				});
				
				$thumbnails.first().addClass('current');

				$stage.click(function(){
					if ( $pane_thumbnails.hasClass('visible') ) {
						hide_thumnails_pane();
					}
				});
				
				$(window).resize(function(){
					clearTimeout(settings.resizing);
					settings.resizing = setTimeout(function(){
						adjust_thumbnails_pane();
					}, 400);
				});
								
			}
			
			
			
			function change_photo( new_photo_index ) {
			
				if ( new_photo_index >= settings.num_photos ) {
					new_photo_index = 0;
				}
				else if ( new_photo_index < 0 ) {
					new_photo_index = settings.num_photos - 1;
				}
				
				var $thumbnail = $thumbnails.eq(new_photo_index);
				
				var photo_url = $thumbnail.attr('href');
				var photo_alt = $thumbnail.find('img').attr('alt');
				
				$thumbnails.removeClass('current');
				$thumbnail.addClass('current');
				
				preload_image( photo_url, function(img) {
							
					$stage.find('#main_image').fadeOut(100, function(){
						
						$(this).attr('src', img.src);
						$(this).fadeIn(600);
						
						settings.current_photo = new_photo_index;
						
						$label_description.text(photo_alt);
						$label_counter.text( get_counter_label() );
						
						if (settings.slideshow_playing) {
							stop_slideshow();
							start_slideshow();
						}
						
					});
					
				});
				
			}
			
			function hide_thumnails_pane() {
				
				$pane_thumbnails.removeClass('visible');
				$nav_arrows.fadeIn();
				
				$pane_thumbnails.filter(':not(:animated)').animate({
					top: $stage.height()
				}, 600, 'easeInOutCubic', function(){
					$pane_thumbnails.hide();
				});
				
			}
			
			function show_thumbnails_pane() {
			
				$pane_thumbnails.addClass('visible');
				$nav_arrows.hide();
				
				$pane_thumbnails.css({
					'top': $stage.height(),
					'display': 'block'
				});
				
				var top_position = $pane_thumbnails.height() - $pane_thumbnails.find('.thumbnails').height();
				
				if (top_position < 0) {
					top_position = 0;
				}

				$pane_thumbnails.filter(':not(:animated)').animate({
					top: top_position
				}, 400, 'easeInOutCubic', function(){
				});
					
			}
			
			function adjust_thumbnails_pane() {
			
				var top_position = $pane_thumbnails.height() - $pane_thumbnails.find('.thumbnails').height();
				
				if (top_position < 0) {
					top_position = 0;
				}
				
				$pane_thumbnails.filter(':not(:animated)').animate({
					top: top_position
				}, 400, 'easeInOutCubic', function(){
				});
				
			}
			
			function get_counter_label() {
				
				var current = settings.current_photo + 1;
				var total = settings.num_photos;
				
				return current + ' / ' + total;
				
			}
			
			function start_slideshow() {
				if ( settings.num_photos > 1 ) {
					settings.slideshow_playing = true;
					settings.slideshow_timer = setInterval(function(){
						change_photo( settings.current_photo + 1 );
					}, parameters.timeout);
				}
			}
			
			function stop_slideshow() {
				settings.slideshow_playing = false;
				clearInterval(settings.slideshow_timer);
			}
			
			setup_nav_arrows();
			setup_controller();
			
			$btn_play.trigger('click'); // auto start slideshow
		
		});
		
	};
})(jQuery);

/*
== ------------------------------------------------------------------- ==
== @@ Fix Logo in IE8
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_fix_logo_ie8 = function() {
		
		var preload_image = function( path, callback ) {
			var img = new Image();
			img.onload = function(){
				callback( img );
			};
			img.src = path;
		};
	
		return this.each(function(){
		
			if ($.support.leadingWhitespace) {
				return false;
			}
		
			var $control = $(this);
			
			var original_image = {
				source: $(this).attr('src'),
				width: 0,
				height: 0
			};
			
			var current_image = {
				source: $(this).attr('src'),
				width: 0,
				height: 0,
				fixed_width: 0
			};
			
			preload_image(original_image.source, function(img){
			
				original_image.width = img.width;
				original_image.height = img.height;
				
				current_image.width = $control.width();
				current_image.height = $control.height();
				current_image.fixed_width = parseInt( current_image.height * original_image.width / original_image.height, 10);
				
				$control.css('max-width', current_image.fixed_width);
				
			});
		
		});
		
	};
})(jQuery);

/*
== ------------------------------------------------------------------- ==
== @@ Fixed Header
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_fixed_header = function(plugin_parameters) {
	
		var default_parameters = {
			min_window_width:1000,
			min_height:80,
			min_logo_padding:10,
			menu_height:19
		};
		var parameters = $.extend(default_parameters, plugin_parameters);
	
		return this.each(function(){
		
			var $control = $(this);
			var $window = $(window);
			var $header = $control.find('.page_header .header_main');
			var $header_wrapper = $control.find('.page_header .header_wrapper');
			var $logo = $control.find('.page_header .logo img');
			var $menu = $control.find('.page_header .header_main nav');
			
			var settings = {
				header_height: $header.outerHeight(true),
				logo_padding: parseInt( $logo.css('padding-top'), 10 ),
				resize_delay: null
			};
			
			$window.scroll(function(){
			
				if ( $window.width() < parameters.min_window_width ) {
					$header.height(settings.header_height);
					$menu.css('margin-top', parseInt( ( ( settings.header_height / 2 ) - parameters.menu_height) , 10));
					$logo.css({
						'padding-top': settings.logo_padding + 'px',
						'padding-bottom': settings.logo_padding + 'px',
					});
					$header_wrapper.removeClass('scrolled');
				}
				else {
					set_header_height();
				}
			
			});
			
			$window.resize(function(){
				clearTimeout(settings.resize_delay);
				settings.resize_delay = setTimeout(function(){
					set_header_height();
				}, 200);
			});
			
			function set_header_height() {
				
				var offset = $window.scrollTop();
				
				// set main area height
				
				var new_height = parseInt( settings.header_height - offset, 10 );
				if ( new_height < parameters.min_height ) {
					new_height = parameters.min_height;
					$header_wrapper.addClass('scrolled');
				}
				else if ( new_height > settings.header_height ) {
					new_height = settings.header_height;
					
				}
				else {
					$header_wrapper.removeClass('scrolled');
				}
				
/*
				if (new_height > 150) {
					new_height = 150;
				}
*/
				$header.height(new_height);

				
				// set menu top margin
				
				var new_menu_margin = parseInt( ( ( new_height / 2 ) - parameters.menu_height) , 10);
				
				$menu.css('margin-top', new_menu_margin);


				// set logo vertical padding

				var new_logo_padding = parseInt( settings.logo_padding - ( offset / 2 ), 10 );
				if ( new_logo_padding < parameters.min_logo_padding ) {
					new_logo_padding = parameters.min_logo_padding;
				}
				else if ( new_logo_padding > settings.logo_padding ) {
					new_logo_padding = settings.logo_padding;
				}
				
				$logo.css({
					'padding-top': new_logo_padding + 'px',
					'padding-bottom': new_logo_padding + 'px',
				});
				
			}
			
			set_header_height();
			
		});
		
	};
})(jQuery);

/*
== ------------------------------------------------------------------- ==
== @@ WMPL Language Switcher
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_wpml_language_switcher = function() {
	
		return this.each(function(){
		
			var $control = $(this);
			
			// avoid clicking on links with href="#"
			
			$control.find('a').click(function(){
				if ( $(this).attr('href') === '#' ) {
					return false;
				}
			});
			
			// animate the dropdown
			
			$control.find('ul ul').hide().addClass('visible_with_js');
			$control.find('> ul').hover(function(){
				$control.find('ul ul').stop(true, true).show();
			}, function(){
				$control.find('ul ul').stop(true, true).fadeOut();
			});
			
		
		});
		
	};
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ IE8 Adjustments
==		"Disabling responsiveness because IE8 doesn't support media queries"
== ------------------------------------------------------------------- ==
*/

(function($){
	$(document).ready(function(){
		if ( ! $('html').hasClass('csstransforms') ) {
			$('body').addClass('vc_non_responsive');
		}
	});
})(jQuery);