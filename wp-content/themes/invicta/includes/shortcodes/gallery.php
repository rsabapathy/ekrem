<?php 
	
add_shortcode( 'invicta_gallery' , 'invicta_gallery_shortcode');

function invicta_gallery_shortcode( $args ) {
	
	global $post;
	global $smof_data;
	global $content_width;
	
	$output = '';
	$post_id = $post->ID;
	$gallery_id = 'invicta_gallery_' . uniqid();
	
	extract( shortcode_atts( array(
		'ids' => ''
	), $args) );
	
	$width = $content_width;
	$height = BLOG__PHOTO_HEIGHT;
	
	// if $ids is empty
	// means that we are dealing with the old WP galleries (< 3.5)
	// images are post attachments
	
	if ( ! $ids ) {
		
		$images = get_children( array(
			'post_parent' 		=> $post_id,
			'post_status'		=> 'inherit',
			'post_type' 		=> 'attachment',
			'post_mime_type' 	=> 'image',
			'order' 			=> 'ASC',
			'orderby' 			=> 'menu_order ID'
			));
		
	}
	
	// we are dealing with new WP galleries (>= 3.5)
	// images are post independent
	
	else {
		
		$images = get_posts( array(
			'include' => $ids,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => 'menu_order ID',
			'orderby' => 'post__in'
			));
		
	}
	
	// output markup setup
	
	if ( $images ) {

		$output .= '<div class="invicta_gallery">';	

		// main slider
		
		$output .= 		'<div id="' . $gallery_id . '" class="flexslider slider">';
		$output .=			'<ul class="slides">';
		foreach ( $images as $image ) {
			$output .= 			'<li>';
			$output .=				'<img src="' . invicta_gallery_get_resized_image( $image->guid, $width, $height ) . '" alt="" />';
			$output .= 			'</li>';
		}
		$output .= '		</ul>';
		$output .= '	</div>';
		
		// thumbnails 
		
		if ( sizeof( $images ) > 1 ) {
		
			$output .= '	<div id="' . $gallery_id . '_thumbs" class="flexslider thumbs">';
			$output .=			'<ul class="slides">';
			foreach ( $images as $image ) {
				$output .= 			'<li>';
				$output .=			'<img src="' . invicta_gallery_get_resized_image( $image->guid, 100, 70 ) . '" alt="" />';
				$output .= 			'</li>';
			}
			$output .= '		</ul>';
			$output .= '	</div>';
			
		}
		
		$output .= '</div>';
		
		// script
		
		// javascript & css enqueuing

		wp_enqueue_script('invicta_flexslider');
		
		$output .= '<script type="text/javascript">';
		$output .= 		'jQuery(window).load(function() {';
		
		// script - main slider
		$output	.= 				'var ' . $gallery_id  . '_previous_height = 0;';
		
		$output	.= 				'jQuery("#' . $gallery_id . '").flexslider({';
		$output .= 					'animation: "slide",';
		$output .= 					'controlNav: false,';
		$output .= 					'animationLoop: false,';
		$output .= 					'smoothHeight: true,';
		$output .= 					'slideshow: false,';
		$output .= 					'prevText: "",';
		$output .= 					'nextText: "",';
		$output .= 					'start: function(slider) {';
		$output .= 						'var wait = setTimeout(function(){';
		$output .= 							$gallery_id  . '_previous_height = jQuery("#' . $gallery_id . '").height();';
        $output .= 							'jQuery(".invicta_grid").trigger("reset");';
		$output .= 						'}, 1000)';
		$output .= 					'},';
		$output .= 					'after: function(slider) {';
		$output .= 						'var wait = setTimeout(function(){';
		$output .= 							$gallery_id  . '_new_height = jQuery("#' . $gallery_id . '").height();';
		$output .= 							'if ( ' . $gallery_id  . '_new_height != ' . $gallery_id  . '_previous_height) { ';
        $output .= 								'jQuery(".invicta_grid").trigger("reset");';
		$output .= 							'}';
		$output .= 							$gallery_id  . '_previous_height = ' . $gallery_id  . '_new_height;';
		$output .= 						'}, 1000)';
		$output .= 					'},';
		$output .= 					'sync: "#' . $gallery_id . '_thumbs"';
		$output .= 				'});';
		
		// script - thumbnails
		
		if ( sizeof( $images ) > 1 ) {
		
			$output	.= 				'jQuery("#' . $gallery_id . '_thumbs").flexslider({';
			$output .= 					'animation: "slide",';
			$output .= 					'controlNav: false,';
			$output .= 					'animationLoop: false,';
			$output .= 					'slideshow: false,';
			$output .= 					'prevText: "",';
			$output .= 					'nextText: "",';
			$output .= 					'itemWidth: 100,';
			$output .= 					'itemMargin: 2,';
			$output .= 					'asNavFor: "#' . $gallery_id . '"';
			$output .= 				'});';
		
		}
		
		$output .= 		'});';
		$output .= '</script>';		
			
	}
	
	return $output;
	
}

function invicta_gallery_get_resized_image( $image_url, $width, $height ) {

	$resized_image_url = aq_resize( $image_url, $width, $height, true, true, false);
	
	if ( ! $resized_image_url ) {
		$resized_image_url = $image_url;	
	}
	
	return $resized_image_url;
	
}
	
?>