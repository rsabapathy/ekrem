<?php

add_shortcode( 'invicta_steps', 'invicta_steps_shortcode' );

function invicta_steps_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
	
		'animation'		=> '',

		'name_1'		=> '',
		'icon_1'		=> '',
		'text_1'		=> '',
		
		'name_2'		=> '',
		'icon_2'		=> '',
		'text_2'		=> '',
		
		'name_3'		=> '',
		'icon_3'		=> '',
		'text_3'		=> '',
		
		'name_4'		=> '',
		'icon_4'		=> '',
		'text_4'		=> '',
		
		'name_5'		=> '',
		'icon_5'		=> '',
		'text_5'		=> '',

	), $atts ) );

	
	// partners setup
	
	$steps = array();
	
	if ( $name_1 || $text_1 ) {
		$steps[] = array( 'name' => $name_1, 'icon' => str_replace( ',', ' ', $icon_1 ), 'text' => $text_1 );
	}
	
	if ( $name_2 || $text_2 ) {
		$steps[] = array( 'name' => $name_2, 'icon' => str_replace( ',', ' ', $icon_2 ), 'text' => $text_2 );
	}
	
	if ( $name_3 || $text_3 ) {
		$steps[] = array( 'name' => $name_3, 'icon' => str_replace( ',', ' ', $icon_3 ), 'text' => $text_3 );
	}
	
	if ( $name_4 || $text_4 ) {
		$steps[] = array( 'name' => $name_4, 'icon' => str_replace( ',', ' ', $icon_4 ), 'text' => $text_4 );
	}
	
	if ( $name_5 || $text_5 ) {
		$steps[] = array( 'name' => $name_5, 'icon' => str_replace( ',', ' ', $icon_5 ), 'text' => $text_5 );
	}
	
	$num_steps = sizeof( $steps );
		
	// handler classes
	
	$handler_classes = array();
	
	if ( $animation == 'animated' ) {
		$handler_classes[] = 'wpb_animate_when_almost_visible';
		$handler_classes[] = 'wpb_appear';
	}
	
	if ( $handler_classes ) {
		$handler_classes = ' ' . join( ' ', $handler_classes );
	}
	else {
		$handler_classes = '';
	}
	
	
	
	// output
	
	$output = '';
	
	if ( $num_steps ) {
		
		$step_width = 100 / $num_steps;
	
		$guid = 'invicta_steps_' . uniqid();
		
		$output .= '<div id="' . $guid . '" class="invicta_steps wpb_content_element">';
		
		for ( $i = 0; $i < sizeof( $steps ); $i ++ ) {
		
			$step = $steps[ $i ];
		
			$output .= 		'<div class="step" style="width:' . $step_width . '%">';
			
			if ( $num_steps > 1 ) {
				$output .= 			'<div class="line"></div>';
			}
			
			$output	.=			'<div class="icon' . $handler_classes . '">';
			if ( $step['icon'] ) {
				$output .=				'<i class="' . $step['icon'] . '"></i>';
			}
			else {
				$output .=				'<span class="index">' . ( $i + 1 ) . '</span>';
			}
			$output .= 			'</div>';
			
			$output .=			'<div class="info">';
			
			$output	.=				'<div class="name">';
			$output .=					$step['name'];
			$output .= 				'</div>';
									
			$output	.=				'<div class="text">';
			$output .=					$step['text'];
			$output .= 				'</div>';
			
			$output .= 			'</div>';
			
			$output .= 		'</div>';
			
		}
		
		$output .= '</div>';
		
		// enqueue scripts
		wp_enqueue_script( 'waypoints' );
	
	}
	
	return $output;
	
}	

?>