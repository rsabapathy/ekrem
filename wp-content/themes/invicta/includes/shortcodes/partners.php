<?php 
	
add_shortcode( 'invicta_partners', 'invicta_partners_shortcode' );

function invicta_partners_shortcode( $atts ) {

	extract( shortcode_atts( array(
		
		'name_1'		=> '',
		'logo_1'		=> '',
		'link_1'		=> '',
		
		'name_2'		=> '',
		'logo_2'		=> '',
		'link_2'		=> '',
		
		'name_3'		=> '',
		'logo_3'		=> '',
		'link_3'		=> '',
		
		'name_4'		=> '',
		'logo_4'		=> '',
		'link_4'		=> '',
		
		'name_5'		=> '',
		'logo_5'		=> '',
		'link_5'		=> '',
		
		'name_6'		=> '',
		'logo_6'		=> '',
		'link_6'		=> '',
		
		'name_7'		=> '',
		'logo_7'		=> '',
		'link_7'		=> '',
		
		'name_8'		=> '',
		'logo_8'		=> '',
		'link_8'		=> '',
		
		'css_animation'	=> '',
		'blackandwhite_effect'	=> 'no'
		
	), $atts ) );
	
	
	// partners setup
	
	$partners = array();
	
	if ( $name_1 || $logo_1 || $link_1 ) {
		$partners[] = array( 'name' => $name_1, 'logo' => $logo_1, 'link' => $link_1 );
	}
	
	if ( $name_2 || $logo_2 || $link_2 ) {
		$partners[] = array( 'name' => $name_2, 'logo' => $logo_2, 'link' => $link_2 );
	}
	
	if ( $name_3 || $logo_3 || $link_3 ) {
		$partners[] = array( 'name' => $name_3, 'logo' => $logo_3, 'link' => $link_3 );
	}
	
	if ( $name_4 || $logo_4 || $link_4 ) {
		$partners[] = array( 'name' => $name_4, 'logo' => $logo_4, 'link' => $link_4 );
	}
	
	if ( $name_5 || $logo_5 || $link_5 ) {
		$partners[] = array( 'name' => $name_5, 'logo' => $logo_5, 'link' => $link_5 );
	}
	
	if ( $name_6 || $logo_6 || $link_6 ) {
		$partners[] = array( 'name' => $name_6, 'logo' => $logo_6, 'link' => $link_6 );
	}
	
	if ( $name_7 || $logo_7 || $link_7 ) {
		$partners[] = array( 'name' => $name_7, 'logo' => $logo_7, 'link' => $link_7 );
	}
	
	if ( $name_8 || $logo_8 || $link_8 ) {
		$partners[] = array( 'name' => $name_8, 'logo' => $logo_8, 'link' => $link_8 );
	}
	
	for ( $i = 0; $i < sizeof($partners); $i++ ) {
		
		// logo
		
		if ( $partners[$i]['logo'] ) {
			
			$image_id = $partners[$i]['logo'];
			$image_url = wp_get_attachment_url( $image_id, 'full' );
			
			if ( $image_url ) {
				$partners[$i]['logo'] = $image_url;
			}
			else {
				$partners[$i]['logo'] = '';
			}
			
		}
		
	}
	
	// handler classes
	
	$handler_classes = array();
	
	$handler_classes[] = 'accentcolor-text-on_children-on_hover';
	$handler_classes[] = 'inherit-color-on_children';
	
	if ( $css_animation ) {
		$handler_classes[] = 'wpb_animate_when_almost_visible';
		$handler_classes[] = 'wpb_' . $css_animation;
	}
	
	if ( $blackandwhite_effect == 'yes' ) {
		$handler_classes[] = 'image_black_white_effect';
	}
	
	if ( $handler_classes ) {
		$handler_classes = ' ' . join( ' ', $handler_classes );
	}
	else {
		$handler_classes = '';
	}
	
	// output
	
	$output = '';
	
	if ( sizeof( $partners ) > 0 ) {
		
		$output .= '<div class="invicta_partners">';
		
		foreach ( $partners as $partner ) {
			
			$output .= '<div class="partner' . $handler_classes . '">';
			
			if ( $partner['link'] ) {
			
				if ( $blackandwhite_effect == 'yes' ) {
					$output .=	'<a href="' . esc_url( $partner['link'] ) . '" title="' . $partner['name'] . '" target="_blank" class="image_black_white_effect">';
				}
				else {
					$output .=	'<a href="' . esc_url( $partner['link'] ) . '" title="' . $partner['name'] . '" target="_blank">';	
				}
			}
			
			if ( $partner['logo'] ) {
				$output .=		'<img src="' . $partner['logo'] . '" alt="' . $partner['name'] . '" class="desaturate" />';
			}
			else {
				$output .=		'<span class="default_logo"><i class="icon-thumbs-up"></i>' . $partner['name'] . '</span>';
			}
			
			if ( $partner['link'] ) {
				$output .=	'</a>';
			}
			
			$output .= '</div>';
			
		}
		
		$output .= '</div>';
		
	}
	
	// scripts enqueuing
	wp_enqueue_script( 'invicta_blackandwhite' );
	wp_enqueue_script( 'waypoints' );

	
	// return
	
	return $output;
	
}
	
?>