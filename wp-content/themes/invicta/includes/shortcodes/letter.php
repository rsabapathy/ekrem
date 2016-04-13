<?php 
	
add_shortcode( 'invicta_letter', 'invicta_letter_shortcode' );

function invicta_letter_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'title'				=> __( 'Dear Customer...', 'invicta_dictionary' ),
		'author_photo'		=> '',
		'author_signature' 	=> ''
	), $atts ) );
	
	$photo_width = 380;
	$photo_height = 380;
	
	// content 
	
	$content = wpb_js_remove_wpautop( $content );
	
	// author photo
	
	if ( $author_photo ) {
		
		$image_id = $author_photo;
		$image_url = wp_get_attachment_url( $image_id, 'full' );
		
		if ( $resized_image_url = aq_resize( $image_url, $photo_width, $photo_height, true, true, false ) ) {
			$image_url = $resized_image_url;
		}
		
		if ( $image_url ) {
			$author_photo = $image_url;
		}
		else {
			$author_photo = '';
		}
		
	}
	
	// author signature
	
	if ( $author_signature ) {
		
		$image_id = $author_signature;
		$image_url = wp_get_attachment_url( $image_id, 'full' );
		
		if ( $image_url ) {
			$author_signature = $image_url;
		}
		else {
			$author_signature = '';
		}
		
	}
	
	// has media check
	
	$extra_class = '';
	
	if ( ! $author_photo && ! $author_signature ) {
		$extra_class = ' no_media';
	}
	
	// output
	
	$output = '';
	
	$output .= '<div class="invicta_letter wpb_content_element' . $extra_class . '">';
	
	$output .=		'<div class="media">';
	
	if ( $author_photo ) {
		$output .= 		'<div class="photo invicta_avatar">';
		$output .= 			'<img src="' . $author_photo . '" alt="' . __( 'Author Photo', 'invicta_dictionary' ) . '" />';
		$output .= 		'</div>';
	}
	
	if ( $author_signature ) {
		$output .= 		'<div class="signature">';
		$output .= 			'<img src="' . $author_signature . '" alt="' . __( 'Author Signature', 'invicta_dictionary' ) . '" />';
		$output .= 		'</div>';
	}
	
	$output .=		'</div>';
	
	$output .=		'<div class="text">';
	
	if ( $title ) {
		$output .= 		'<h2 class="title">';
		$output .= 			$title;
		$output .= 		'</h2>';
	}
	
	if ( $content ) {
		$output .= 		'<div class="content text_styles">';
		$output .= 			$content;
		$output .= 		'</div>';
	}
	
	$output .=		'</div>';
	
	$output .=		'<div class="alignclear"></div>';
	
	$output .= '</div>';
	
	return $output;
	
}
	
?>