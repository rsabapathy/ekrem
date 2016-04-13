<?php

add_shortcode( 'invicta_heading', 'invicta_heading_shortcode' );

function invicta_heading_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'primary_line' 				=> '',
		'secondary_line' 			=> '',
		'primary_line_keywords' 	=> '',
		'secondary_line_keywords' 	=> '',
		'primary_line_html_elem'	=> 'div', 	// '', h1, h2, h3, h4, h5, h6
		'secondary_line_html_elem'	=> 'div',	// '', h1, h2, h3, h4, h5, h6
		'alignment' 				=> '', 	// center, left, right
		'size'						=> ''	// big, small
	), $atts ) );
	
	$output = '';
	
	// primary line keyword highlight
	
	if ( $primary_line && $primary_line_keywords ) {
	
		$keywords = explode( ',', $primary_line_keywords );
		
		foreach ( $keywords as $keyword ) {
			if ( $keyword ) {
				$primary_line = preg_replace( '/' . $keyword . '/i', '<span class="accentcolor-text">$0</span>', $primary_line );
			}
		}
		
	}
	
	// secondary line keyword highlight
	
	if ( $secondary_line && $secondary_line_keywords ) {
	
		$keywords = explode( ',', $secondary_line_keywords );
		
		foreach ( $keywords as $keyword ) {
			if ( $keyword ) {
				$secondary_line = preg_replace( '!' . $keyword . '!i', '<strong>$0</strong>', $secondary_line );
			}
		}
		
	}
	
	// extra css classes
	
	$extra_classes = array();
	
	if ( $alignment ) {
		$extra_classes[] = $alignment;
	}
	
	if ( $size ) {
		$extra_classes[] = $size;
	}
	
	if ( $extra_classes ) {
		$extra_classes = ' ' . join( ' ', $extra_classes );
	}
	else {
		$extra_classes = '';
	}
	
	// output
	
	$output .= '<div class="invicta_heading' . $extra_classes . '">';
	
	if ( $primary_line ) {
		$output	.=		'<' . $primary_line_html_elem . ' class="primary">' . $primary_line . '</' . $primary_line_html_elem . '>';
	}
	
	if ( $secondary_line ) {
		$output	.=		'<' . $secondary_line_html_elem . ' class="secondary">' . $secondary_line . '</' . $secondary_line_html_elem . '>';
	}
	
	$output .= '</div>';
	
	
	return $output;
	
}
	
?>