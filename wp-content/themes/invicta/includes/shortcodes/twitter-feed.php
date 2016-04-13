<?php 
	
add_shortcode( 'invicta_twitterfeed', 'invicta_twitterfeed_shortcode' );

function invicta_twitterfeed_shortcode( $atts ) { 
		
	$args = wp_parse_args( $atts, array(
		'title'					=> '',
		'username'				=> '',
		'count'					=> 3,
		'cache_timeout'			=> 0,
		'consumer_key'			=> '',
		'consumer_secret'		=> '',
		'access_token'			=> '',
		'access_token_secret'	=> ''
	) );
	
	extract( $args );
	
	$twitterfeed_widget = new invicta_twitter_feed_widget();
	
	$output = '';
	
	if ( $username ) {
	
		$output .= '<div class="widget">';
		if ( $title ) {
			$output .= 		'<h3 class="widget_title">' . $title . '</h3>';
		}
		$output .= 			$twitterfeed_widget->get_html( $args );
		$output .= '</div>';
	
	}
	
	return $output;
	
}
	
?>