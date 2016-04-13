/*
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==

SCRIPTS TITLE: 
	Invicta - Admin Scripts
		
SCRIPTS AUTHOR: 
	Oitentaecinco

SCRIPTS INDEX:

	@@ Page Template Handling
	@@ Visual Composer Model Box

== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/

/*
== ------------------------------------------------------------------- ==
== @@ Page Template Handling
== ------------------------------------------------------------------- ==
*/

(function($){
	
	var wait_for_visual_composer = setInterval(function(){
		if ( $('.composer-switch').size() > 0 ) {
			
			clearInterval( wait_for_visual_composer );
			
			visual_composer = $('#wpb_visual_composer').is(':visible');
			$('body').data('visual_composer', visual_composer);
			
			$('select#page_template').trigger('change');
			
			$('.composer-switch').click(function(){
				if ( $('#wpb_visual_composer').is(':visible') ) {
					$('body').data('visual_composer', true);
				}
				else {
					$('body').data('visual_composer', false);
				}
			});
			
			
		}
	}, 200);
	
	$('select#page_template').change(function(){
		
		if ( $(this).val() === 'template-invicta_portfolio.php' ) {
		
			var visual_composer = $('#wpb_visual_composer').is(':visible');
			$('body').data('visual_composer', visual_composer);
		
			$('#_invicta_portfolio_page_settings').show();
			$('#postdivrich, .composer-switch, #wpb_visual_composer').hide();
			
		}
		else {

			var visual_composer = $('body').data('visual_composer');
			
			$('#_invicta_portfolio_page_settings').hide();
			$('.composer-switch').show();	
			
			if (visual_composer) {
				$('#wpb_visual_composer').show();	
			}
			else {
				$('#postdivrich').show();
			}
			
		}
		
	});

})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Visual Composer Modal Box
== ------------------------------------------------------------------- ==
*/

(function($){

	$(document).ready(function(){
		
		if ( $('#wpb_visual_composer').size() > 0 ) {
			
			// the current page has visual composer
			
			$(document).on('DOMNodeInserted', function() {
				if ( $('.wpb_edit_form_elements').size() > 0 ) {
					
					// the modal box was opened
					
					var $groups = null;
					
					
					// * ---------------------------- * //
					// * Modal box with invicta icons * //
					// * ---------------------------- * //
					
					var $invicta_icons = $('.wpb_edit_form_elements .invicta_icon');
					
					if ( $invicta_icons.size() > 0) {
					
						$groups = $invicta_icons.parents('.edit_form_line');
						
						$groups.each(function(){
							
							var $group = $(this);
							var $icons_inputs = $group.find('input:checkbox');
							
							if ( $group.data('handled') === true ) {
								return false;
							}
							
							$group.data('handled', true);
							
							$icons_inputs.click(function() {
								$icons_inputs.not(this).attr('checked', false);
								
							});
							
						});
					
					}
					
					
					// * -------------------------------------- * //
					// * Modal box with invicta world locations * //
					// * -------------------------------------- * //
					
					var $invicta_locations = $('.wpb_edit_form_elements .world_location');
					
					if ( $invicta_locations.size() > 0) {
					
						$groups = $invicta_locations.parents('.edit_form_line');
						$('.wpb_edit_form_elements .edit_form_line textarea[name="label_positions"]').hide();
						
						$groups.each(function(){
							
							var $group = $(this);
							var $location_inputs = $group.find('input:checkbox');
							
							if ( $group.data('handled') === true ) {
								return false;
							}
							
							$group.data('handled', true);
							
							$location_inputs.click(function() {
								setup_location_field( $group, $(this), true );
							});
							
							$location_inputs.each(function(){
								setup_location_field( $group, $(this), false );
							});
							
							init_label_positions( $group );
							
						});
						
						function setup_location_field( $group, $location_input, setup_values ) {
						
							var id = $location_input.attr('id');
							var value = $location_input.val();
							var $label = $group.find('label[for="' + id + '"]');
							
							$label.click(function(){
								return false;
							}).css('cursor', 'default');
						
							if ( $location_input.is(':checked') ) {
								
								var $dropdown = $('<select>').addClass('location_label_position').data('location_id', value);
								
								$dropdown.append('<option value="bottom_right">Bottom Right</option>');
								$dropdown.append('<option value="bottom_left">Bottom Left</option>');
								$dropdown.append('<option value="top_right">Top Right</option>');
								$dropdown.append('<option value="top_left">Top Left</option>');
								
								$dropdown.change(function(){
									update_label_positions_controller($group);
								});
							
								$label.append($dropdown);
								
								if ( setup_values ) {
									update_label_positions_controller($group);
								}
								
							}
							else {
								
								$label.find('.location_label_position').remove();
								if ( setup_values ) {
									update_label_positions_controller($group);
								}
								
							}
							
						}
						
						function update_label_positions_controller( $group ) {
						
							var $ctr_label_positions = $('.wpb_edit_form_elements .edit_form_line textarea[name="label_positions"]');
							var label_positions = '';
							
							$group.find('.location_label_position').each(function(){
								label_positions += $(this).data('location_id') + '=' + $(this).val() + ',';
							});
							
							label_positions = label_positions.substring(0, label_positions.length - 1);

							$ctr_label_positions.val(label_positions);
							
						}
						
						function init_label_positions( $group ) {
						
							var label_positions = $('.wpb_edit_form_elements .edit_form_line textarea[name="label_positions"]').val();
							
							label_positions = label_positions.split(',');

							for ( var i = 0; i < label_positions.length; i ++ ) {
								
								var splitted_info = label_positions[i].split('=');
								
								$group.find('.location_label_position').each(function(){
									if ( $(this).data('location_id') === splitted_info[0] ) {
										$(this).val( splitted_info[1] );
									}
								});

							}
														
						}
					
					}
					
					
					// * ---------------------------- * //
					// * Modal box with ............. * //
					// * ---------------------------- * //
					
					

					
				}
			});
			
		}
		
	});
				
})(jQuery);


/*
== ------------------------------------------------------------------- ==
== @@ Visual Composer Frontend Editor
== ------------------------------------------------------------------- ==
*/


(function($){

	jQuery(document).ready(function(){
		
		if ( $('body.vc-editor').size() > 0 ) {
			
			// the current page has visual composer
			
			$('#vc-properties-panel .panel-body').on('DOMNodeInserted', function() {
				if ( $('.wpb_edit_form_elements').size() > 0 ) {

					// the modal box was opened
					
					var $groups = null;
					
					// * ---------------------------- * //
					// * Modal box with invicta icons * //
					// * ---------------------------- * //
					
					var $invicta_icons = $(this).find('.wpb_edit_form_elements .invicta_icon');
					
					if ( $invicta_icons.size() > 0) {
					
						$groups = $invicta_icons.parent();
						
						$groups.each(function(){
							
							var $group = $(this);
							var $icons_inputs = $group.find('input:checkbox');
							
							if ( $group.data('handled') === true ) {
								return false;
							}
							
							$group.data('handled', true);
							
							$icons_inputs.click(function() {
								$icons_inputs.not(this).attr('checked', false);
								
							});
							
						});
					
					}
					
					
					// * -------------------------------------- * //
					// * Modal box with invicta world locations * //
					// * -------------------------------------- * //
					
					var $invicta_locations = $(this).find('.wpb_edit_form_elements .world_location');
					
					if ( $invicta_locations.size() > 0) {
						
						$groups = $invicta_locations.parent();
						$('#vc-properties-panel .edit_form_line textarea[name="label_positions"]').hide();
						
						$groups.each(function(){
							
							var $group = $(this);
							var $location_inputs = $group.find('input:checkbox');
							
							if ( $group.data('handled') === true ) {
								return false;
							}
							
							$group.data('handled', true);
							
							$location_inputs.click(function() {
								setup_location_field( $group, $(this), true );
							});
							
							$location_inputs.each(function(){
								setup_location_field( $group, $(this), false );
							});
							
							init_label_positions( $group );
							
						});
						
						function setup_location_field( $group, $location_input, setup_values ) {
						
							var id = $location_input.attr('id');
							var value = $location_input.val();
							var $label = $group.find('label[for="' + id + '"]');
							
							$label.click(function(){
								return false;
							}).css('cursor', 'default');
						
							if ( $location_input.is(':checked') ) {
								
								var $dropdown = $('<select>').addClass('location_label_position').data('location_id', value);
								
								$dropdown.append('<option value="bottom_right">Bottom Right</option>');
								$dropdown.append('<option value="bottom_left">Bottom Left</option>');
								$dropdown.append('<option value="top_right">Top Right</option>');
								$dropdown.append('<option value="top_left">Top Left</option>');
								
								$dropdown.change(function(){
									update_label_positions_controller($group);
								});
							
								$label.append($dropdown);
								
								if ( setup_values ) {
									update_label_positions_controller($group);
								}
								
							}
							else {
								
								$label.find('.location_label_position').remove();
								if ( setup_values ) {
									update_label_positions_controller($group);
								}
								
							}
							
						}
						
						function update_label_positions_controller( $group ) {
						
							var $ctr_label_positions = $('#vc-properties-panel .edit_form_line textarea[name="label_positions"]');
							var label_positions = '';
							
							$group.find('.location_label_position').each(function(){
								label_positions += $(this).data('location_id') + '=' + $(this).val() + ',';
							});
							
							label_positions = label_positions.substring(0, label_positions.length - 1);

							$ctr_label_positions.val(label_positions);
							
						}
						
						function init_label_positions( $group ) {
						
							var label_positions = $('#vc-properties-panel .edit_form_line textarea[name="label_positions"]').val();
							
							label_positions = label_positions.split(',');

							for ( var i = 0; i < label_positions.length; i ++ ) {
								
								var splitted_info = label_positions[i].split('=');
								
								$group.find('.location_label_position').each(function(){
									if ( $(this).data('location_id') === splitted_info[0] ) {
										$(this).val( splitted_info[1] );
									}
								});

							}
														
						}
					
					}

				}				
			});
			
			
			
		}
		
	});
				
})(jQuery);