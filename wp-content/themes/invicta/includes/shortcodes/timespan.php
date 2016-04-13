<?php 
	
add_shortcode( 'invicta_timespan', 'invicta_timespan_shortcode' );

function invicta_timespan_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'title' 	=> '',
		'begin'		=> 0,
		'end'		=> 0,
		'text'  	=> '',
		'animation'	=> ''
	), $atts ) );
	
	// time validation

	if ( $begin < 0 || $begin > 11.5 ) {
		$begin = 0;
	}
	
	if ( $end < 0 || $end > 11.5 ) {
		$end = 0;
	}	
	
	if ( $begin > $end ) {
		switch ( $end ) {
			case 0:  	$end = 12; break;
			case 0.5:  	$end = 12.5; break;
			case 1:  	$end = 13; break;
			case 1.5:  	$end = 13.5; break;
			case 2:  	$end = 14; break;
			case 2.5:  	$end = 14.5; break;
			case 3:  	$end = 15; break;
			case 3.5:  	$end = 15.5; break;
			case 4:  	$end = 16; break;
			case 4.5:  	$end = 16.5; break;
			case 5:  	$end = 17; break;
			case 5.5:  	$end = 17.5; break;
			case 6:  	$end = 18; break;
			case 6.5:  	$end = 18.5; break;
			case 7:  	$end = 19; break;
			case 7.5:  	$end = 19.5; break;
			case 8:  	$end = 20; break;
			case 8.5:  	$end = 20.5; break;
			case 9:  	$end = 21; break;
			case 9.5:  	$end = 21.5; break;
			case 10: 	$end = 22; break;
			case 10.5: 	$end = 22.5; break;
			case 11: 	$end = 23; break;
			case 11.5: 	$end = 23.5; break;
		}
	}
	
	$period = $end - $begin;
	
	$begin = str_replace( '.', '_', $begin);
	$period = str_replace( '.', '_', $period);
	
	// animation
	
	if ( $animation == 'animated' ) {
		$animation = true;
	}
	else {
		$animation = false;
	}
	
	$images_folder = get_template_directory_uri() . '/styles/images/timespan/';
	$guid = 'invicta_timespan_' . uniqid();
	
	$output = '';
	
	$output .= '<div id="' . $guid . '" class="widget invicta_timespan">';
	
	if ( $title ) {
		$output .= 	'<h3 class="widget_title">' . $title . '</h3>';
	}
	
	$output .= 		'<div class="invicta_timespan_graphic period_' . $period . ' begin_at_' . $begin . '">';
	$output .=			'<div class="span"></div>';
	$output .=			'<div class="frame"></div>';
	$output .= 		'</div>';
	
	$output .=		'<div class="description">';
	$output .=			$text;
	$output .=		'</div>';
	
	$output .= '</div>';
	
	if ( $animation ) {
	
		wp_enqueue_script( 'waypoints' );
	
		$output .= '<script type="text/javascript">';
		$output .=		'jQuery(document).ready(function($){';
		$output .=			'$("#' . $guid . '").invicta_timespan({';
		$output .= 				'class_prefix: "period_",';
		$output .= 				'period: "' . $period . '",';
		$output .= 				'begin_at: "begin_at_' . $begin . '"';
		$output .=			'});';
		$output .=		'});';
		$output .= '</script>';
	
	}	
	
	return $output;
	
}	
	
?>