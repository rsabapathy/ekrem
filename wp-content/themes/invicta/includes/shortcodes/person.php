<?php
	
add_shortcode( 'invicta_person', 'invicta_person_shortcode' );

function invicta_person_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'title'			=> '',
		'sub_title'		=> '',
		'excerpt'		=> '',
		'photo'			=> '',
		'css_animation' => '',
		'link_type'		=> 'none',	// none, manually, page
		'page_id'		=> '', 			// used if link_type == page
		'url'			=> '',			// used if link_type == manually
		'name'			=> '',
		'position'		=> '',
		'department'	=> '',
		'country'		=> '',
		'age'			=> '',
		'phone'			=> '',
		'website'		=> '',
		'email'			=> '',
		'skype'			=> '',
		'twitter'		=> '',
		'facebook'		=> '',
		'googleplus'	=> '',
		'linkedin'		=> '',
		'xing'			=> '',
		'dribbble'		=> '',
		'flickr'		=> '',
		'tumblr'		=> '',
		'instagram'		=> '',
		'pinterest'		=> '',
		'foursquare'	=> '',
		'youtube'		=> '',
		'style'			=> 'default'
	), $atts ) );
	
	// default fields forcing
	if ( ! $title && ! $name ) {
		$title = __( 'Person Name', 'invicta_dictionary' );
		if ( ! $sub_title ) {
			$sub_title = __( 'Person Label', 'invicta_dictionary' );
		}
	}
	
	$photo_width = 380;
	$photo_height = 380;
	
	// person photo
	
	if ( $photo ) {
		
		$image_id = $photo;
		$image_url = wp_get_attachment_url( $image_id, 'full' );
		
		if ( $resized_image_url = aq_resize( $image_url, $photo_width, $photo_height, true, true, false ) ) {
			$image_url = $resized_image_url;
		}
		
		if ( $image_url ) {
			$photo = $image_url;
		}
		else {
			$photo = get_template_directory_uri() . '/styles/images/defaults/unknown_photo.png';
		}
		
	}
	else {
		$photo = get_template_directory_uri() . '/styles/images/defaults/unknown_photo.png';
	}
	
	// link 
	
	$link_href = '';
	$link_target = '';
	
	switch ( $link_type ) {
		
		case 'manually' :
			if ( $url != 'http://' ) {
				$link_href = esc_url( $url );
				$link_target = '_blank';
			}
			break;
			
		case 'page' :
			$link_href = get_permalink( $page_id );
			$link_target = '_self';
			break;
		
	}
	
	// social
	
	$social_data = array();
	
	if ( $email ) { $social_data[] = array( 'id' => 'email', 'url' => $email ); }
	if ( $skype ) { $social_data[] = array( 'id' => 'skype', 'url' => $skype ); }
	if ( $twitter ) { $social_data[] = array( 'id' => 'twitter', 'url' => $twitter ); }
	if ( $facebook ) { $social_data[] = array( 'id' => 'facebook', 'url' => $facebook ); }
	if ( $googleplus ) { $social_data[] = array( 'id' => 'googleplus', 'url' => $googleplus ); }
	if ( $linkedin ) { $social_data[] = array( 'id' => 'linkedin', 'url' => $linkedin ); }
	if ( $xing ) { $social_data[] = array( 'id' => 'xing', 'url' => $xing ); }
	if ( $dribbble ) { $social_data[] = array( 'id' => 'dribbble', 'url' => $dribbble ); }
	if ( $flickr ) { $social_data[] = array( 'id' => 'flickr', 'url' => $flickr ); }
	if ( $tumblr ) { $social_data[] = array( 'id' => 'tumblr', 'url' => $tumblr ); }
	if ( $instagram ) { $social_data[] = array( 'id' => 'instagram', 'url' => $instagram ); }
	if ( $pinterest ) { $social_data[] = array( 'id' => 'pinterest', 'url' => $pinterest ); }
	if ( $foursquare ) { $social_data[] = array( 'id' => 'foursquare', 'url' => $foursquare ); }
	if ( $youtube ) { $social_data[] = array( 'id' => 'youtube', 'url' => $youtube ); }
	
	$args = array(
		'target'	=> '_blank',
		'data'		=> $social_data
	);
	$social_links = new invicta_social_links( $args );
	
	
	// image alt
	
	$image_alt = '';
	if ( $title ) {
		$image_alt = $title;
	}
	elseif ( $name ) {
		$image_alt = $name;
	}
	
	
	// handler classes
	
	if ( $css_animation ) {
		$handler_classes[] = 'wpb_animate_when_almost_visible';
		$handler_classes[] = 'wpb_' . $css_animation;
	}
	else {
		$handler_classes[] = null;
	}
	if ( $handler_classes ) {
		$handler_classes = ' ' . join( ' ', $handler_classes );
	}
	else {
		$handler_classes = '';
	}
	
	
	// output 

	$output = '';
	
	$output .= 	'<div class="invicta_person wpb_content_element accentcolor-border-on_hover ' . $style . '">';
	
	$output .= 		'<div class="wrapper">';
	
	if ( $photo ) {
		
		$output .= '<div class="thumbnail">';
		
		if ( $link_href ) {
			$output .= 	'<a href="' . $link_href . '" target="' . $link_target . '">';
			$output .= 		'<span class="photo invicta_avatar' . $handler_classes . '">';
			$output .= 			'<img src="' . $photo . '" alt="' . esc_attr( $image_alt ) . '" />';
			$output .= 		'</span>';
			$output .= 	'</a>';
		}
		else {
			$output .= 	'<span class="photo invicta_avatar' . $handler_classes . '">';
			$output .= 	    '<img src="' . $photo . '" alt="' . esc_attr( $image_alt ) . '" />';
			$output .= 	'</span>';
		}
		
		$output .= '</div>';
		
	}
	
	$output .= 		'<div class="info">';
	
	if ( $title ) {
		$output .= 		'<div class="title">';
		$output .= 			$title;
		$output .= 		'</div>';
	}
	
	if ( $sub_title ) {
		$output .= 		'<div class="sub_title">';
		$output .= 			$sub_title;
		$output .= 		'</div>';
	}
	
	if ( $excerpt ) {
		$output .= 		'<div class="excerpt">';
		$output .=			$excerpt;
		$output .=		'</div>';
	}
	
	if ( count( $social_data ) ) {
		$output .= 		'<div class="social">';
		$output .=			$social_links->get_html();
		$output .= 		'</div>';
	}
	
	if ( $link_href ) { 
	
		$button_shortcode = '[invicta_button label="' . __( ' View More', 'invicta_dictionary' ) . '" url="' . $link_href . '"]';
	
		$output .= 		'<div class="button">';
		$output .=			do_shortcode( $button_shortcode );
		$output .= 		'</div>';	
	}
	
/*
	if ( $name || $position || $department || $country || $age || $phone ) {
		
		$output .=		'<div class="details">';
		
		if ( $name ) {
			$output .=		'<p>';
			$output .=			'<strong>' . __( 'Name', 'invicta_dictionary' ) . ': ' . '</strong>';
			$output .=			$name;
			$output .= 		'</p>';
		}
		
		if ( $position ) {
			$output .=		'<p>';
			$output .=			'<strong>' . __( 'Position', 'invicta_dictionary' ) . ': ' . '</strong>';
			$output .=			$position;
			$output .= 		'</p>';
		}
		
		if ( $department ) {
			$output .=		'<p>';
			$output .=			'<strong>' . __( 'Department', 'invicta_dictionary' ) . ': ' . '</strong>';
			$output .=			$department;
			$output .= 		'</p>';
		}
		
		if ( $country ) {
			$output .=		'<p>';
			$output .=			'<strong>' . __( 'Country', 'invicta_dictionary' ) . ': ' . '</strong>';
			$output .=			$country;
			$output .= 		'</p>';
		}
		
		if ( $age ) {
			$output .=		'<p>';
			$output .=			'<strong>' . __( 'Age', 'invicta_dictionary' ) . ': ' . '</strong>';
			$output .=			$age;
			$output .= 		'</p>';
		}
		
		if ( $website ) {
			$output .=		'<p>';
			$output .=			'<strong>' . __( 'Website', 'invicta_dictionary' ) . ': ' . '</strong>';
			$output .=			'<a href="' . esc_url( $website ) . '" target="_blank">' . $website . '</a>';
			$output .= 		'</p>';
		}
		
		if ( $phone ) {
			$output .=		'<p>';
			$output .=			'<strong>' . __( 'Phone', 'invicta_dictionary' ) . ': ' . '</strong>';
			$output .=			$phone;
			$output .= 		'</p>';
		}
		
		$output .=		'</div>';
		
	}
*/
	
	$output .=			'</div>';
	
	$output .= 		'</div>';
	
	$output .= 	'</div>';
	
	
	// enqueue scripts
	wp_enqueue_script( 'waypoints' );
	
	return $output;

}
	
?>