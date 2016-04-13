<?php 
	
add_shortcode( 'invicta_sociallinks', 'invicta_sociallinks_shortcode' );

function invicta_sociallinks_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'title'			=> '',
		'intro'			=> '',
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
		'youtube'		=> ''
	), $atts ) );

		
	$data = array();
	
	if ( $email ) { $data[] = array( 'id' => 'email', 'url' => $email ); }
	if ( $skype ) { $data[] = array( 'id' => 'skype', 'url' => $skype ); }
	if ( $twitter ) { $data[] = array( 'id' => 'twitter', 'url' => $twitter ); }
	if ( $facebook ) { $data[] = array( 'id' => 'facebook', 'url' => $facebook ); }
	if ( $googleplus ) { $data[] = array( 'id' => 'googleplus', 'url' => $googleplus ); }
	if ( $linkedin ) { $data[] = array( 'id' => 'linkedin', 'url' => $linkedin ); }
	if ( $xing ) { $data[] = array( 'id' => 'xing', 'url' => $xing ); }
	if ( $dribbble ) { $data[] = array( 'id' => 'dribbble', 'url' => $dribbble ); }
	if ( $flickr ) { $data[] = array( 'id' => 'flickr', 'url' => $flickr ); }
	if ( $tumblr ) { $data[] = array( 'id' => 'tumblr', 'url' => $tumblr ); }
	if ( $instagram ) { $data[] = array( 'id' => 'instagram', 'url' => $instagram ); }
	if ( $pinterest ) { $data[] = array( 'id' => 'pinterest', 'url' => $pinterest ); }
	if ( $foursquare ) { $data[] = array( 'id' => 'foursquare', 'url' => $foursquare ); }
	if ( $youtube ) { $data[] = array( 'id' => 'youtube', 'url' => $youtube ); }
	
	
	$args = array(
		'target'	=> '_blank',
		'data'		=> $data
	);
	$social_links = new invicta_social_links( $args );
	
	// output
	
	$output = '';
	
	if ( $args['data'] ) {
	
		$output .= '<div class="widget invicta_sociallinks">';
		
		if ( $title ) {
			$output .= 		'<h3 class="widget_title">' . $title . '</h3>';
		}
		
		if ( $intro ) {
			$output .= 		'<div class="intro">';
			$output .= 			$intro;
			$output .=		'</div>';
		}
		
		$output .=			$social_links->get_html();
		
		$output .= '</div>';
	
	}
	
	return $output;
	
}	
	
?>