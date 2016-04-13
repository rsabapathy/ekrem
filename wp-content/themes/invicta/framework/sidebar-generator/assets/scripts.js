(function($) {
	
	var Invicta_Sidebar = function() {
		
		this.form_holder = $('.widget-liquid-right');
		this.sidebars_holder = $('#widgets-right');
		this.add_sidebar_form = $('#invicta_add_sidebar_form');
		
		this.create_form();
		this.add_del_button();
		this.bind_events();
		
	}
	
	$(function()
	{
		new Invicta_Sidebar();
 	});
 	
 	Invicta_Sidebar.prototype = {
	 	
	 	create_form: function() {
		 	this.form_holder.append(this.add_sidebar_form.html());
		 	this.sidebar_name = this.form_holder.find('input[name="invicta_new_sidebar_name"]');
		 	this.nonce = this.form_holder.find('input[name="invicta_del_sidebar_nonce"]').val();
	 	},
	 	
	 	add_del_button: function() {
		 	this.sidebars_holder.find('.sidebar-invicta-custom').append('<span class="invicta_custom_sidebar_delete"></span>');
	 	},
	 	
	 	bind_events: function() {
		 	this.sidebars_holder.on('click', '.invicta_custom_sidebar_delete', $.proxy(this.delete_sidebar, this));		
	 	},
	 	
	 	delete_sidebar: function(e) {
	 	
	 		if (confirm('Are you sure?')) {
	 	
		 		var sidebar = $(e.currentTarget).parents('.widgets-holder-wrap:eq(0)');
		 		var sidebar_spinner = sidebar.find('.sidebar-name h3 .spinner');
		 		var sidebar_name = $.trim(sidebar.find('.sidebar-name h3').text());
		 		var obj = this;
			 	
			 	$.ajax({
				 	type: 'POST',
				 	url: window.ajaxurl,
				 	data: {
					 	action: 'invicta_ajax_delete_custom_sidebar',
					 	sidebar_name: sidebar_name,
					 	_wpnonce: obj.nonce
				 	},
				 	beforeSend: function() {
					 	sidebar_spinner.addClass('activate_spinner');
				 	},
				 	success: function(response) {
					 	
					 	if (response == 'success') {
	
						 	sidebar.slideUp(200, function(){
							 	
							 	$('.widget-control-remove', sidebar).trigger('click');
							 	sidebar.remove();
							 	
							 	obj.form_holder.find('.widgets-holder-wrap .widgets-sortables').each(function(i){
								 	$(this).attr('id', 'sidebar-' + (i + 1));
							 	});
							 	
						 	});
						 	
						 	wpWidgets.saveOrder();
						 	
					 	}
					 	
				 	}
			 	});
		 	
		 	}
		 	
	 	}
	 	
 	}

	
})(jQuery);	 