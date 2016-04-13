<?php 

add_shortcode( 'invicta_contacts', 'invicta_contacts_shortcode' );

function invicta_contacts_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'title' 			=> '',
		'intro' 			=> '',
		'address'			=> '',
		'phone'				=> '',
		'mobile'			=> '',
		'email'				=> '',
		'google_map'		=> '',
		'url'				=> '',
	), $atts ) );
	
	$phone = str_replace( ',', '<br/>', $phone );
	$mobile = str_replace( ',', '<br/>', $mobile );
	
	$emails = explode( ',' , $email );
	$urls = explode( ',' , $url );
	
	$output = '';
	
	if ( $title || $intro || $address || $phone || $mobile || $mobile || $email || $google_map || $url ) {
	
		$output .= '<div class="widget invicta_contacts">';
		if ( $title ) {
			$output .= 		'<h3 class="widget_title">' . $title . '</h3>';
		}
		if ( $intro ) {
			$output .= 		'<div class="intro">';
			$output .= 			$intro;
			$output .=		'</div>';
		}
		$output .= 		'<ul class="contacts">';
		if ( $address ) {
			$output .=			'<li class="address">' . $address . '</li>';
		}
		if ( $phone ) {
			$output .=			'<li class="phone">' . $phone . '</li>';
		}
		if ( $mobile ) {
			$output .=			'<li class="mobile">' . $mobile . '</li>';
		}
		if ( $email ) {
			$output .=			'<li class="email accentcolor-text-on_children-on_hover">';
			foreach ( $emails as $email ) {
				$output .=			'<a href="mailto:' . trim( $email ) . '">' . $email . '</a><br/>';
			}
			$output .= 			'</li>';
		}
		if ( $google_map ) {
			$output .=			'<li class="map accentcolor-text-on_children-on_hover">';
			$output	.=				'<a href="' . esc_url( trim( $google_map ) ) . '" target="_blank">' . __( 'Find us on the map', 'invicta_dictionary' ) . '</a>';
			$output .= 			'</li>';
		}
		if ( $url ) {
			$output .=			'<li class="url accentcolor-text-on_children-on_hover">';
			foreach ( $urls as $url ) {
				$output	.=			'<a href="' . esc_url( trim( $url ) ) . '" target="_blank">' . $url . '</a><br/>';
			}
			$output .= 			'</li>';
		}
		
		$output .= 		'</ul>';
		$output .= '</div>';
	
	}
	
	return $output;
	
}

?>