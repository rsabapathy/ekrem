<?php 
	
add_shortcode( 'invicta_world_map', 'invicta_world_map_shortode' );

function invicta_world_map_shortode( $atts ) {

	extract( shortcode_atts( array(
		'locations'					=> '',
		'label_positions'			=> '',
		'label_offset'				=> 4,
		'label_visibility'			=> 'always',
		'initial_animation_timeout' => 0
	), $atts ) );
	
	if ( ! is_numeric( $label_offset ) ) {
		$label_offset = 0;
	}
	
	// data
	
	$dataset = array();
	
	if ( $locations ) {
	
		$countries = invicta_get_countries();
		$locations = explode( ',', $locations );
		$positions = array();

		$label_positions = explode( ',', $label_positions );		
		foreach ( $label_positions as $label_position ) {
		
			$splitted_data = explode( '=', $label_position );
			$positions[ $splitted_data[0] ] = $splitted_data[1];
				
		}
		
		foreach ( $locations as $location ) {
		
			$location_info = array(
				'location_id'		=> $location,
				'location_name'		=> $countries[ $location ],
				'label_position' 	=> $positions[ $location ]
			);
				
			$dataset[] = $location_info;
			
		}
		
	}
	
	// output

	$output = '';

	if ( $dataset ) {

		wp_enqueue_script( 'waypoints' );
	
		$guid = 'world_map_' . uniqid();
	
		$output .= '<div id="' . $guid . '" class="invicta_world_map wpb_content_element">';
		
		$output .=		'<div class="map_canvas">';
		$output .=			'<img class="map_graphic" src="' . get_template_directory_uri() . '/styles/images/maps/world-map.png' . '" alt="" />';
		$output .= 		'</div>';
		
		$output .=		'<div class="responsive_labels">';
		$output .= 		'</div>';
		
		$output .= 		'<script type="text/javascript">';
		$output .= 				'jQuery(window).load(function(){';
		$output .= 					'jQuery("#' . $guid . '").invicta_world_map({';
		$output .= 						'dataset:' . json_encode( $dataset ) . ',';
		$output .= 						'label_offset:' . $label_offset . ',';
		$output .= 						'label_visibility:"' . $label_visibility . '",';
		$output .= 						'initial_animation_timeout:' . $initial_animation_timeout . ',';
		$output .= 					'});';
		$output .= 				'});';
		$output .= 		'</script>';
		
		$output .= '</div>';
		
	}
	
	return $output;
	
}	
	
?>