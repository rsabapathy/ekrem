<?php 
	
add_shortcode( 'invicta_progressbars', 'invicta_progressbars_shortcode' );

function invicta_progressbars_shortcode( $atts ) {

	extract( shortcode_atts( array(
		'title'				=> '',
		'graphic_values'	=> '',
		'units'				=> '',
		'animation'			=> '',
	), $atts ) );
	
	if ( ! $graphic_values ) {
		return '';
	}
	
	// progress bars
	
	$progress_bars = array();
	
	$graphic_values = explode( ',', $graphic_values );
	
	foreach ( $graphic_values as $graphic_value ) {
	
		$graphic_value = explode( '|', $graphic_value );
		
		if ( sizeof( $graphic_value ) == 2 && is_numeric( $graphic_value[0] ) ) {
			
			$value = round( $graphic_value[0] );
			$name = $graphic_value[1];
		
			if ( $value >= 0 && $value <= 100 ) {
			
				$progress_bars[] = array(
					'name' => $name,
					'value' => $value
				);
				
			}
			
		}
		
	}
	
	// animation
	
	if ( $animation == 'animated' ) {
		$animation = true;
	}
	else {
		$animation = false;
	}
	
	// output 
	
	$guid = 'invicta_progress_bar_' . uniqid();
	
	$output = '';
	
	$output .= '<div id="' . $guid . '" class="widget invicta_progressbars wpb_content_element">';
	
	if ( $title ) {
		$output .= 		'<h3 class="widget_title">' . $title . '</h3>';
	}
	
	foreach ( $progress_bars as $progress_bar ) {
		$output .= '<div class="progress_bar">';
		
		$output .= 		'<div class="legend">';
		
		$output .=			'<div class="name">';
		$output .=				$progress_bar['name'];
		$output .= 			'</div>';
		
		$output .=			'<div class="value">';
		$output .=				$progress_bar['value'] . $units;
		$output .= 			'</div>';
		
		$output .= 		'</div>';
		
		$output .=		'<div class="bar">';
		if ( $animation ) {
			$output .=			'<div class="progress" data-percentage-value="' . $progress_bar['value'] . '"></div>';
		}
		else {
			$output .=			'<div class="progress" style="width:' . $progress_bar['value'] . '%;"></div>';
		}
		$output .=		'</div>';
		
		$output .= '</div>';		
	}
	
	$output .= '</div>';	
	
	if ( $animation ) {
	
		wp_enqueue_script( 'waypoints' );
	
		$output .= '<script type="text/javascript">';
		$output .=		'jQuery(document).ready(function($){';
		$output .=			'$("#' . $guid . '").invicta_progressbar();';
		$output .=		'});';
		$output .= '</script>';
	
	}	
	
	return $output;
	
}
	
?>