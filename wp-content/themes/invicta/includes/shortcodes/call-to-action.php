<?php 

add_shortcode( 'invicta_calltoaction', 'invicta_calltoaction_shortcode' );

function invicta_calltoaction_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'primary_line' 				=> '',
		'secondary_line' 			=> '',
		'primary_line_keywords' 	=> '',
		'secondary_line_keywords' 	=> '',
		'label'						=> __( 'Click me', 'invicta_dictionary' ),
		'link_type'					=> 'manually',	// manually, page, post, project, photo_gallery
		'page_id'					=> '', 			// used if link_type == page
		'post_id'					=> '',			// used if link_type == post
		'project_id'				=> '',			// used if link_type == project
		'photogallery_id'			=> '',			// used if link_type == photo_gallery
		'url'						=> '',			// used if link_type == manually
		'target'					=> '',			// '', _blank
		'size'						=> '',			// '', medium, large
		'color'						=> '',			// '', silver, gold, red, green, blue
		'icon'						=> '',			
		'icon_position'				=> 'left',		// left, right
		'style'						=> '',			// style_1, style_2, style_3, style_4, style_5
		'css_animation' 			=> ''
	), $atts ) );
	
	// primary line keyword highlight
	
	if ( $primary_line && $primary_line_keywords ) {
	
		$keywords = explode( ',', $primary_line_keywords );
		
		foreach ( $keywords as $keyword ) {
			if ( $keyword ) {
				$primary_line = preg_replace( '/' . $keyword . '/i', '<span class="accentcolor-text">$0</span>', $primary_line );
			}
		}
		
	}
	
	// secondary line keyword highlight
	
	if ( $secondary_line && $secondary_line_keywords ) {
	
		$keywords = explode( ',', $secondary_line_keywords );
		
		foreach ( $keywords as $keyword ) {
			if ( $keyword ) {
				$secondary_line = preg_replace( '!' . $keyword . '!i', '<strong>$0</strong>', $secondary_line );
			}
		}
		
	}	
	
	// button shortcode
	
	$button_shortcode =  invicta_button_shortcode($atts);
	
	// extra css classes
	
	$css_classes = array();
	
	$css_classes[] = 'invicta_calltoaction';
	$css_classes[] = 'wpb_content_element';
	if ( $style ) {
		$css_classes[] = $style;
	}
	if ( $css_animation ) {
		$css_classes[] = 'wpb_animate_when_almost_visible';
		$css_classes[] = 'wpb_' . $css_animation;
	}
	
	if ( $css_classes ) {
		$css_classes = join( ' ', $css_classes );
	}
	else {
		$css_classes = '';
	}
	
	
	$output = '';
	
	$output .= '<div class="' . $css_classes . '">';
	
	$output .= 		'<div class="button">';
	$output .= 			$button_shortcode;
	$output .= 		'</div>';
	
	$output .= 		'<div class="text">';
	
	$output .= 			'<div class="primary">';
	$output .=				$primary_line;
	$output .= 			'</div>';
	
	$output .= 			'<div class="secondary">';
	$output .= 				$secondary_line;
	$output .= 			'</div>';
	
	$output .= 		'</div>';
	
	$output .= '</div>';
	
	// enqueueings
	wp_enqueue_script( 'waypoints' );
		
	return $output;
	
}

?>