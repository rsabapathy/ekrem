<?php 

add_shortcode( 'invicta_button', 'invicta_button_shortcode' );

function invicta_button_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'label'				=> __( 'Click me', 'invicta_dictionary' ),
		'link_type'			=> 'manually',	// manually, page, post, project, photo_gallery
		'page_id'			=> '', 			// used if link_type == page
		'post_id'			=> '',			// used if link_type == post
		'project_id'		=> '',			// used if link_type == project
		'photogallery_id'	=> '',		// used if link_type == photo_gallery
		'url'				=> '',			// used if link_type == manually
		'target'			=> '',			// '', _blank
		'size'				=> '',			// '', medium, large
		'color'				=> '',			// '', silver, gold, red, green, blue
		'alignment'			=> 'left',		// left, center, right
		'icon'				=> '',			
		'icon_position'		=> 'left'		// left, right
	), $atts ) );
	
	// url
	
	$button_href = '#';
	
	switch ( $link_type ) {
		
		case 'manually' :
			if ( $url != 'http://' ) {
				$button_href = esc_url( $url );
			}
			break;
			
		case 'page' :
			$button_href = get_permalink( $page_id );
			break;
			
		case 'post' :
			$button_href = get_permalink( $post_id );
			break;
		
		case 'project' :
			$button_href = get_permalink( $project_id );
			break;
			
		case 'photo_gallery' :
			$button_href = get_permalink( $photogallery_id );
			break;
		
	}
	
	// css classes
	
	$css_classes = array();
	
	$css_classes[] = 'invicta_button';
	if ( $size ) { $css_classes[] = 'invicta-size-' . $size; }	
	if ( $color ) { $css_classes[] = 'invicta-color-' . $color; }
	if ( $icon_position ) { $css_classes[] = 'invicta-icon_position-' . $icon_position; }
	
	$css_classes = ( $css_classes ) ? join( ' ', $css_classes ) : '';
	
	
	// output
	
	$output = '';
	
	$output .= '<div class="invicta_button_wrapper invicta-alignment-' . $alignment . '">';
	
	$output .= '<a';
	$output .=		' class="' . $css_classes . '"';
	$output .=		' href="' . $button_href . '"';
	if ( $target ) {
		$output .=	' target="' . $target . '"';
	}
	$output .= '>';
	
	if ( $icon ) {
		if ( $icon_position == 'left' ) {
			$output .= '<i class="' . $icon . '"></i>';
			$output .= $label;
		}
		else {
			$output .= $label;
			$output .= '<i class="' . $icon . '"></i>';
		}
	}
	else {
		$output .= $label;	
	}
	$output .= '</a>';
	
	$output .= '</div>';
	
	return $output;
	
}

?>