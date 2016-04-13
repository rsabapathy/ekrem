<?php 
	
add_shortcode( 'invicta_testimonial_carousel', 'invicta_testimonial_carousel_shortcode' );

function invicta_testimonial_carousel_shortcode( $atts ) {

	extract( shortcode_atts( array(
	
		'carousel_timeout' => 0,
		'background_label' => '',

		'author_name_1'		=> '',
		'author_country_1'	=> '',
		'author_photo_1'	=> '',
		'source_name_1'		=> '',
		'source_url_1'		=> '',
		'text_1'			=> '',
		
		'author_name_2'		=> '',
		'author_country_2'	=> '',
		'author_photo_2'	=> '',
		'source_name_2'		=> '',
		'source_url_2'		=> '',
		'text_2'			=> '',
		
		'author_name_3'		=> '',
		'author_country_3'	=> '',
		'author_photo_3'	=> '',
		'source_name_3'		=> '',
		'source_url_3'		=> '',
		'text_3'			=> '',
		
		'author_name_4'		=> '',
		'author_country_4'	=> '',
		'author_photo_4'	=> '',
		'source_name_4'		=> '',
		'source_url_4'		=> '',
		'text_4'			=> '',
		
		'author_name_5'		=> '',
		'author_country_5'	=> '',
		'author_photo_5'	=> '',
		'source_name_5'		=> '',
		'source_url_5'		=> '',
		'text_5'			=> '',
		
		'author_name_6'		=> '',
		'author_country_6'	=> '',
		'author_photo_6'	=> '',
		'source_name_6'		=> '',
		'source_url_6'		=> '',
		'text_6'			=> '',
		
	), $atts ) );
	
	$photo_width = 200;
	$photo_height = 200;
	$guid = 'testimonial_carousel_' . uniqid();
	
	// testimonials setup
	
	$testimonials = array();
	
	if ( $author_name_1 && $text_1 ) {
		$testimonials[] = array( 'author_name' => $author_name_1, 'author_country' => $author_country_1, 'author_photo' => $author_photo_1, 'source_name' => $source_name_1, 'source_url' => $source_url_1, 'text' => $text_1 );
	}
	
	if ( $author_name_2 && $text_2 ) {
		$testimonials[] = array( 'author_name' => $author_name_2, 'author_country' => $author_country_2, 'author_photo' => $author_photo_2, 'source_name' => $source_name_2, 'source_url' => $source_url_2, 'text' => $text_2 );
	}
	
	if ( $author_name_3 && $text_3 ) {
		$testimonials[] = array( 'author_name' => $author_name_3, 'author_country' => $author_country_3, 'author_photo' => $author_photo_3, 'source_name' => $source_name_3, 'source_url' => $source_url_3, 'text' => $text_3 );
	}
	
	if ( $author_name_4 && $text_4 ) {
		$testimonials[] = array( 'author_name' => $author_name_4, 'author_country' => $author_country_4, 'author_photo' => $author_photo_4, 'source_name' => $source_name_4, 'source_url' => $source_url_4, 'text' => $text_4 );
	}
	
	if ( $author_name_5 && $text_5 ) {
		$testimonials[] = array( 'author_name' => $author_name_5, 'author_country' => $author_country_5, 'author_photo' => $author_photo_5, 'source_name' => $source_name_5, 'source_url' => $source_url_5, 'text' => $text_5 );
	}
	
	if ( $author_name_6 && $text_6 ) {
		$testimonials[] = array( 'author_name' => $author_name_6, 'author_country' => $author_country_6, 'author_photo' => $author_photo_6, 'source_name' => $source_name_6, 'source_url' => $source_url_6, 'text' => $text_6 );
	}
	
	// setup author photos
	
	if ( $testimonials ) {
	
		for ( $i = 0; $i < count( $testimonials ); $i ++ ) {
			
			$image_id = $testimonials[$i]['author_photo'];
			$image_url = wp_get_attachment_url( $image_id, 'full' );
			
			if ( $resized_image_url = aq_resize( $image_url, $photo_width, $photo_height, true, true, false) ) {
				$image_url = $resized_image_url;
			}
			
			if ( $image_url ) {
				$testimonials[ $i ][ 'author_photo' ] = $image_url;
			}
			else {
				$testimonials[ $i ][ 'author_photo' ] = get_template_directory_uri() . '/styles/images/defaults/unknown_photo.png';
			}
			
		}
		
	}
	
	// setup author countries
	
	if ( $testimonials ) {
	
		$invicta_countries = invicta_get_countries();
	
		for ( $i = 0; $i < count( $testimonials ); $i ++ ) {
		
			$testimonials[ $i ][ 'author_country_id' ] = '';
			$testimonials[ $i ][ 'author_country_name' ] = '';
		
			if ( $testimonials[ $i ][ 'author_country' ] ) {
			
				foreach ( $invicta_countries as $country_id => $country_name ) { 
					if ( $testimonials[ $i ][ 'author_country' ] == $country_id ) { 
						$testimonials[ $i ][ 'author_country_id' ] = $country_id;
						$testimonials[ $i ][ 'author_country_name' ] = $country_name;
					}
				}
				
			}
		
		}
		
	}
	
	// setup source
	
	if ( $testimonials ) {

		for ( $i = 0; $i < count( $testimonials ); $i ++ ) {

			if ( $testimonials[ $i ][ 'source_name' ] || $testimonials[ $i ][ 'source_url' ] ) {
				
				if ( $testimonials[ $i ][ 'source_name' ] && $testimonials[ $i ][ 'source_url' ] ) {
					$testimonials[ $i ][ 'source' ] = '<a href="' . esc_url( $testimonials[ $i ][ 'source_url' ] ) . '" title="' . $testimonials[ $i ][ 'source_name' ] . '" target="_blank">' . $testimonials[ $i ][ 'source_name' ] . '</a>';
				}
				elseif ( $testimonials[ $i ][ 'source_name' ] && ! $testimonials[ $i ][ 'source_url' ] ) {
					$testimonials[ $i ][ 'source' ] = $testimonials[ $i ][ 'source_name' ];
				}
				elseif ( ! $testimonials[ $i ][ 'source_name' ] && $testimonials[ $i ][ 'source_url' ] ) {
					$testimonials[ $i ][ 'source' ] = '<a href="' . esc_url( $testimonials[ $i ][ 'source_url' ] ) . '" target="_blank">' . $testimonials[ $i ][ 'source_url' ] . '</a>';
				}
				
				$testimonials[ $i ][ 'source' ] = ' &mdash; ' . $testimonials[ $i ][ 'source' ];
				
			} else {
				$testimonials[ $i ][ 'source' ] = '';
			}		

		}		
		
	}
	
	
	// output 
	
	$output = '';
	
	if ( $testimonials ) {
		
		$output .= '<div id="' . $guid . '" class="invicta_testimonial_carousel wpb_content_element">';
		
		for ( $i = 0; $i < count( $testimonials ); $i ++ ) {
			
			if ( ( $i % 2 ) == 0 ) { 
				$output .= '<div class="group">';
			}
			
			$output_head = '';
			if ( count( $testimonials ) % 2 == 0 ) { // even num of testimonials
				if ( ( $i % 2 ) == 0 ) { //even
					$output_head = '<div class="invicta_testimonial style_2 right_aligned">';
				}
				else { //odd
					$output_head = '<div class="invicta_testimonial style_2 left_aligned">';
				}
			}
			else { // odd num of testimonials
				if ( $i + 1 == count( $testimonials ) ) { 
					$output_head = '<div class="invicta_testimonial style_2 full_aligned">';
				}
				else {
					if ( ( $i % 2 ) == 0 ) { //even
						$output_head = '<div class="invicta_testimonial style_2 right_aligned">';
					}
					else { //odd
						$output_head = '<div class="invicta_testimonial style_2 left_aligned">';
					}
				}
			}
						
			$output .= $output_head;
	
			$output .=		'<div class="media">';
			if ( $testimonials[ $i ]['author_photo'] ) {
				$output .=			'<div class="invicta_avatar">';
				$output .=				'<img src="' . $testimonials[ $i ]['author_photo'] . '" alt="' . __( 'Author Photo', 'invicta_dictionary' ) . '" />';
				$output .=			'</div>';
			}
			$output .=		'</div>';
				
			$output .= 		'<div class="meta">';
			
			$output .=			'<div class="info">';
			$output .=				'<div class="name">';
			$output .=					$testimonials[ $i ]['author_name'];
			$output .=				'</div>';
			if ( $testimonials[ $i ]['author_country'] ) {
				$output .=			'<span class="country invicta_flag ' . esc_attr( $testimonials[ $i ]['author_country_id'] ) . '">';
				$output .=				$testimonials[ $i ]['author_country_name'];
				$output .=			'</span>';
			}
			if ( $testimonials[ $i ][ 'source' ] ) {
				$output .=			'<span class="source">';
				$output .=				$testimonials[ $i ][ 'source' ];
				$output .=			'</span>';
			}
			$output .=			'</div>';
			
			$output .=			'<div class="text">';
			$output .=				$testimonials[ $i ]['text'];
			$output .=			'</div>';
			
			$output .=		'</div>';
			
			if ( ( $i % 2 ) == 0 ) {
				$output .= '</div>';
				if ( $i + 1 >= count( $testimonials ) ) { 
					$output .= '</div>';
				}
			}
			else {
				$output .= '</div>';
				$output .= '</div>';
			}
			
			
		}
		
		if ( count( $testimonials ) > 2 ) {
		
			$output .= '<div class="nav_arrows inherit-color-on_children">';
			$output	.=		'<a href="#" class="prev"><i class="icon-chevron-left"></i></a>';
			$output	.=		'<a href="#" class="next"><i class="icon-chevron-right"></i></a>';
			$output .= '</div>';
			
			$output .= '<div class="nav_bullets">';
			$output .= '</div>';
						
		}
		
		if ( $background_label ) {
			$output .= '<div class="background">';
				$output .= $background_label;
			$output .= '</div>';	
		}
		
		$output .= '<script type="text/javascript">';
		$output .= 		'jQuery(document).ready(function($){';
		$output .= 			'$("#' . $guid .  '").invicta_testimonial_carousel({timeout:' . $carousel_timeout . '});';
		$output .= 		'});';
		$output .= '</script>';
		
		$output .= '</div>';
		
	}
	
	wp_enqueue_script('invicta_transit');
		
	return $output;
	
}
	
?>