<?php

add_shortcode( 'invicta_counters', 'invicta_counters_shortcode' );

function invicta_counters_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'counters_values'	=> '',
		'animation'			=> '',
		'timeout'			=> 1, 	// miliseconds
		'init_gap'			=> 0
	), $atts ) );


	// counters
	
	$counters = array();
	
	$counters_values = explode( ',', $counters_values );
	
	foreach ( $counters_values as $counter_info ) {
		
		$counter_info = explode( '|', $counter_info );
		
		if ( sizeof( $counter_info ) == 2 && is_numeric( $counter_info[0] ) ) {
			
			$count = round( $counter_info[0] );
			$name = $counter_info[1];
			
			if ( $count >= 0 ) {
				$counters[] = array(
					'name' => $name,
					'count' => $count
				);
			}
			
		}
		
	}
	
		
	// output
	
	$output = '';
	
	if ( sizeof( $counters ) ) {
	
		$guid = 'invicta_counters_' . uniqid();
		
		$output .= '<div id="' . $guid . '" class="invicta_counters wpb_content_element">';
		
		for ( $i = 0; $i < sizeof( $counters ); $i ++ ) {
		
			$counter = $counters[ $i ];
			
			$data_format = str_repeat( '9', strlen( $counter['count'] ) + 1 );
			$data_start = $counter['count'] - $init_gap; if ( $data_start < 0 ) { $data_start = 0; }
			$data_stop = $counter['count'];
			
			$output .= '<div class="counter">';
			
			$output .= 		'<div class="counter_elem counter-analog"';
			$output .= 				' data-interval="' . $timeout . '"';
			$output .= 				' data-direction="up"';
			$output .= 				' data-format="' . $data_format . '"';
			$output .= 				' data-stop="' . $data_stop . '"';
			$output .= 			'>';
			$output .= 			$data_start;
			$output .= 		'</div>';
			
			$output .= 		'<div class="name">';
			$output .=			$counter['name'];
			$output .=		'</div>';
			
			$output .= '</div>';	
			
		}
		
		$animation_param = ( $animation == 'animated' ) ? 1 : 0;
		
		$output .= 		'<script type="text/javascript">';
		$output .= 				'jQuery(document).ready(function($){';
		$output .= 					'$("#' . $guid . '").invicta_counters({';
		$output .=						'animate:' . $animation_param;
		$output .=					'});';
		$output .= 				'});';		
		$output .= 		'</script>';
		
		$output .= '</div>';
			
		
		// enqueue necessary scripts
		wp_enqueue_script('waypoints');
		wp_enqueue_script('invicta_counters');
	
	}
	
	return $output;
	
}	

?>