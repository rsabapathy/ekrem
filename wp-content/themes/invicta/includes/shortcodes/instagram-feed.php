<?php 
	
add_shortcode( 'invicta_instagramfeed', 'invicta_instagramfeed_shortcode' );

function invicta_instagramfeed_shortcode( $atts ) { 
		
	$args = wp_parse_args( $atts, array(
		'title'					=> '',
		'count'					=> 10,
		'cache_timeout'			=> 0,
		'user_id'				=> '',
		'access_token'			=> '',
	) );
	
	extract( $args );
	
	$instagramfeed_widget = new invicta_instagram_feed_widget();
	
	$output = '';
	
	$output .= '<div class="widget">';
	if ( $title ) {
		$output .= 		'<h3 class="widget_title">' . $title . '</h3>';
	}
	$output .= 			$instagramfeed_widget->get_html( $args );
	$output .= '</div>';
	
	return $output;
	
}
	
?>