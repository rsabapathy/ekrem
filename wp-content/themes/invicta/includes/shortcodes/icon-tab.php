<?php 
	
add_shortcode( 'invicta_icontab', 'invicta_icontab_shortcode' );

function invicta_icontab_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'icon'		=> '',
	), $atts ) );
	
	$icon = str_replace( ',', ' ', $icon );
	
	$output = '';
	
	if ( $icon ) {
		$output .= '<div class="tab_icon">';
		$output .=		'<i class="' . $icon . '"></i>';
		$output .= '</div>';
	}
	
	return $output;
	
}
	
?>