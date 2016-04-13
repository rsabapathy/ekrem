/*
== ------------------------------------------------------------------- ==
== @@ Track AJAX Add-to-Cart
== ------------------------------------------------------------------- ==
*/

var invicta_woocommerce_added_product = {};
function invicta_woocommerce_track_ajax_add_to_cart() {

	jQuery('.add_to_cart_button').click(function(){

		var product_dom = jQuery(this).parents('.product').eq(0);

		var product = {};
		product.name = product_dom.find('.product_meta h3').text();
		product.image = product_dom.find('.product_thumbnail img').get(0).src;
		product.price = product_dom.find('.price .amount').last().text();

		invicta_woocommerce_added_product = product;

		product_dom.removeClass('added_to_cart_check').addClass('adding_to_cart_loading');

	});

	jQuery('body').bind('added_to_cart', function(){
		jQuery('.adding_to_cart_loading').removeClass('adding_to_cart_loading').addClass('added_to_cart_check');
	});

}

/*
== ------------------------------------------------------------------- ==
== @@ Update Cart Drop-Down
== ------------------------------------------------------------------- ==
*/

function invicta_update_cart_dropdown(event) {

	var cart = jQuery('.woocommerce_header_cart .cart_widget');
	var feedback_message = cart.data('feedback');
	var product = jQuery.extend({
		name:'Product',
		price:'',
		image:''
	}, invicta_woocommerce_added_product);

	if ( typeof event !== 'undefined' ) {

		// update summary amount
		cart.find('.cart_summary .amount').text( cart.find('.widget_shopping_cart_content .total .amount').text() );

		// notification
		var template = jQuery('<div class="added_to_cart_notification"><img src="' + product.image + '" /><div class="product_name"><strong>' + product.name + '</strong> ' + feedback_message + '</div></div>').css('opacity', 0);

		cart.find('.widget_wrapper').after(template.animate({opacity:1}, 500));

		setTimeout(function(){
			template.animate({opacity:0, top:parseInt(template.css('top'),10) - 15 }, function(){
				template.remove();
			});
		}, 3000);

	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Enhance Cart Drop-Down
== ------------------------------------------------------------------- ==
*/

function invicta_woocommerce_enhance_cart_dropdown() {

	var cart = jQuery('.woocommerce_header_cart .cart_widget');
	var widget_wrapper = jQuery('.woocommerce_header_cart .cart_widget .widget_wrapper');

	cart.addClass('visible_with_js');

	widget_wrapper.hide();

	cart.mouseenter(function(){
		widget_wrapper.stop(true, true).show();
	});

	cart.mouseleave(function(){
		widget_wrapper.fadeOut();
	});

}

/*
== ------------------------------------------------------------------- ==
== @@ Enhance Sorting Dropdowns
== ------------------------------------------------------------------- ==
*/

function invicta_woocommerce_enhance_sorting_dropdown() {

	jQuery('.woocommerce .product_sorting .sort_param').each(function(){

		var dropdown = jQuery(this).find('ul');

		jQuery(this).addClass('visible_with_js');

		dropdown.hide();

		jQuery(this).mouseenter(function(){
			dropdown.stop(true, true).show();
		});

		jQuery(this).mouseleave(function(){
			dropdown.fadeOut();
		});

	});



}

/*
== ------------------------------------------------------------------- ==
== @@ Lightbox
== ------------------------------------------------------------------- ==
*/

(function($){
	$.fn.invicta_woocommerce_lightbox = function() {

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
					$(this).attr('rel', 'invicta-gallery');
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
== @@ Enhance Price Filter Widget
== ------------------------------------------------------------------- ==
*/

function invicta_woocommerce_enhance_price_filter_widget() {

	var widget = jQuery('.woocommerce.widget_price_filter');
	var slider = jQuery('.woocommerce.widget_price_filter .price_slider');


	widget.hover(function(){
		slider.addClass('hovered');
	}, function(){
		slider.removeClass('hovered');
	});

}


/*
== ------------------------------------------------------------------- ==
== @@ Trigger
== ------------------------------------------------------------------- ==
*/

jQuery(document).ready(function($){

	// setup lightbox
	$('.woocommerce-page.single').invicta_woocommerce_lightbox();

	invicta_woocommerce_track_ajax_add_to_cart();
	invicta_woocommerce_enhance_cart_dropdown();
	invicta_woocommerce_enhance_sorting_dropdown();
	invicta_woocommerce_enhance_price_filter_widget();

	$('body').bind('added_to_cart', invicta_update_cart_dropdown);

});