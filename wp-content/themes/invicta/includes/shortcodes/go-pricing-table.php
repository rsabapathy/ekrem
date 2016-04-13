<?php 

add_shortcode( 'invicta_gopricingtable', 'invicta_gopricingtable_shortcode' );

function invicta_gopricingtable_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'table_id' => '',
	), $atts ) );
	
	
	$output = '';
	
	if ( $table_id ) {
		$output .= '<div class="invicta_pricingtable">';
		$output .= do_shortcode( '[go_pricing id="' . $table_id . '"]' );
		$output .= '</div>';
	}
		
	return $output;
	
}

?>