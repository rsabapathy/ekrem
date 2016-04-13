<?php 
	
add_shortcode( 'invicta_iconbox', 'invicta_iconbox_shortcode' );

function invicta_iconbox_shortcode( $atts ) {

	extract( shortcode_atts( array(
		'icon'				=> '',
		'title'				=> __( 'Iconbox', 'invicta_dictionary' ),
		'text'				=> '',
		'style'				=> 'default',
		'link_type'			=> 'manually',	// manually, page, post, project, photo_gallery
		'page_id'			=> '', 			// used if link_type == page
		'post_id'			=> '',			// used if link_type == post
		'project_id'		=> '',			// used if link_type == project
		'photogallery_id'	=> '',			// used if link_type == photo_gallery
		'url'				=> '',			// used if link_type == manually
		'css_animation' 	=> ''
	), $atts ) );
	
	// url
	
	$button_href = '';
	
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
	
	// icon
	
	$icon = str_replace( ',', ' ', $icon );
	
	// content 
	
	$text = wpb_js_remove_wpautop( $text );
	
	// handler classes
	
	$handler_classes = array();
		
	if ( $style ) {
		$handler_classes[] = $style;
	}
	
	if ( $css_animation ) {
		$handler_classes[] = 'wpb_animate_when_almost_visible';
		$handler_classes[] = 'wpb_' . $css_animation;
	}
	
	if ( $handler_classes ) {
		$handler_classes = ' ' . join( ' ', $handler_classes );
	}
	else {
		$handler_classes = '';
	}
	
	// output 
	
	$output = '';
	
	$output .= '<div class="invicta_iconbox wpb_content_element'. $handler_classes .'">';
	
	if ( $button_href ) {
	
		$output .=		'<a href="' . $button_href . '" class="icon" title="' . __( 'Learn more about', 'invicta_dictionary' ) . ' ' . $title . '">';
		$output .=			'<i class="' . $icon . '"></i>';
		$output .=		'</a>';
		
		if ( $style != 'clean' ) { 
			$output .= 	'<div class="content">';
		}
		
		$output	.=			'<a href="' . $button_href . '" class="title accentcolor-text-on_hover inherit-color" title="' . __( 'Learn more about', 'invicta_dictionary' ) . ' ' . $title . '">';
		$output .=				$title;
		$output .=			'</a>';
		
		$output	.=			'<div class="text">';
		$output .=				$text;
		$output .=			'</div>';
		
		if ( $style != 'clean' ) { 
			$output .=	'</div>';
		}
		
	}
	
	else {
	
		$output .=		'<div class="icon">';
		$output .=			'<i class="' . $icon . '"></i>';
		$output .=		'</div>';
		
		if ( $style != 'clean' ) { 
			$output .= 	'<div class="content">';
		}
		
		$output	.=			'<div class="title">';
		$output .=				$title;
		$output .=			'</div>';
		
		$output	.=			'<div class="text">';
		$output .=				$text;
		$output .=			'</div>';
		
		if ( $style != 'clean' ) { 
			$output .=	'</div>';
		}
		
	}
	
	$output .= '</div>';
	
	// enqueue scripts
	wp_enqueue_script( 'waypoints' );
	
	
	return $output;
	
}
	
?>