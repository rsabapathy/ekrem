<?php 
	
add_shortcode( 'invicta_testimonial', 'invicta_testimonial_shortcode' );

function invicta_testimonial_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'author_name'		=> '',
		'author_country'	=> '',
		'author_photo'		=> '',
		'source_name'		=> '',
		'source_url'		=> '',
		'style'				=> 'style_1',
		'css_animation' 	=> ''
	), $atts ) );
	
	$photo_width = 120;
	$photo_height = 120;
	
	// content
	
	$content = wpb_js_remove_wpautop( $content );
	
	// author photo
	
	if ( $author_photo ) {
		
		$image_id = $author_photo;
		$image_url = wp_get_attachment_url( $image_id, 'full' );
		
		if ( $resized_image_url = aq_resize( $image_url, $photo_width, $photo_height, true, true, false) ) {
			$image_url = $resized_image_url;
		}
		
		if ( $image_url ) {
			$author_photo = $image_url;
		}
		else {
			$author_photo = '';
		}
		
	}
	
	// author country 
	
	$author_country_id = '';
	$author_country_name = '';
	
	if ( $author_country ) {
		
		$invicta_countries = invicta_get_countries();
		
		foreach ( $invicta_countries as $country_id => $country_name ) {
			if ( $author_country == $country_id ) {
				$author_country_id = $country_id;
				$author_country_name = $country_name;
			}
		}
		
	}
	
	// source
	
	if ( $source_name || $source_url ) {
		
		if ( $source_name && $source_url ) {
			$source = '<a href="' . esc_url( $source_url ) . '" title="' . $source_name . '" target="_blank">' . $source_name . '</a>';
		}
		elseif ( $source_name && ! $source_url ) {
			$source = $source_name;
		}
		elseif ( ! $source_name && $source_url ) {
			$source = '<a href="' . esc_url( $source_url ) . '" target="_blank">' . $source_url . '</a>';
		}
		
		$source = ' &mdash; ' . $source;
		
	} else {
		$source = '';
	}
	
	
	// handler classes
	
	$handler_classes = array();
		
	if ( $style ) {
		$handler_classes[] = $style;
	}
	
	if ( ! $author_photo ) {
		$handler_classes[] = 'no_photo';
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
	
	$output .= '<div class="invicta_testimonial wpb_content_element' . $handler_classes . '">';
	
	if ( $style == 'style_1' ) {
	
		$output .=		'<div class="text">';
		$output .=			$content;
		$output .=		'</div>';
		
		$output .= 		'<div class="meta">';
		
		if ( $author_photo ) {
			$output .=			'<div class="invicta_avatar">';
			$output .=				'<img src="' . $author_photo . '" alt="' . __( 'Author Photo', 'invicta_dictionary' ) . '" />';
			$output .=			'</div>';
		}
		
		$output .=			'<div class="info">';
		$output .=				'<div class="name">';
		$output .=					$author_name;
		$output .=				'</div>';
		if ( $author_country ) {
			$output .=			'<span class="country invicta_flag ' . esc_attr( $author_country_id ) . '">';
			$output .=				$author_country_name;
			$output .=			'</span>';
		}
		if ( $source ) {
			$output .=			'<span class="source">';
			$output .=				$source;
			$output .=			'</span>';
		}
		$output .=			'</div>';
		
		$output .=		'</div>';
	
	}
	elseif ( $style == 'style_2' ) {
	
		
		$output .=		'<div class="media">';
		if ( $author_photo ) {
			$output .=			'<div class="invicta_avatar">';
			$output .=				'<img src="' . $author_photo . '" alt="' . __( 'Author Photo', 'invicta_dictionary' ) . '" />';
			$output .=			'</div>';
		}
		$output .=		'</div>';
			
		$output .= 		'<div class="meta">';
		
		$output .=			'<div class="info">';
		$output .=				'<div class="name">';
		$output .=					$author_name;
		$output .=				'</div>';
		if ( $author_country ) {
			$output .=			'<span class="country invicta_flag ' . esc_attr( $author_country_id ) . '">';
			$output .=				$author_country_name;
			$output .=			'</span>';
		}
		if ( $source ) {
			$output .=			'<span class="source">';
			$output .=				$source;
			$output .=			'</span>';
		}
		$output .=			'</div>';
		
		$output .=			'<div class="text">';
		$output .=				$content;
		$output .=			'</div>';
		
		$output .=		'</div>';		
		
	}
	
	$output .= '</div>';
	
	
	// enqueueings
	wp_enqueue_script( 'waypoints' );
	
	
	// return
	
	return $output;
	
}	
	
?>