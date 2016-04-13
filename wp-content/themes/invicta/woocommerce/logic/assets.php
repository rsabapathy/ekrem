<?php

add_action( 'wp_enqueue_scripts', 'invicta_enqueue_woocommerce_assets' );

function invicta_enqueue_woocommerce_assets() {

	$template_url = get_template_directory_uri();

	// javascript
    wp_register_script( 'invicta_woocommerce', $template_url . '/woocommerce/logic/assets/invicta-woocommerce.js', array('jquery'), '', true );
	wp_enqueue_script( 'invicta_woocommerce' );

	// css styles
	wp_register_style( 'invicta_woocommerce', $template_url . '/woocommerce/logic/assets/invicta-woocommerce.css', false, false, 'screen' );
	wp_enqueue_style( 'invicta_woocommerce' );

}

if ( version_compare( WOOCOMMERCE_VERSION, '2.3' ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
}
else if ( version_compare( WOOCOMMERCE_VERSION, '2.1' ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}
else {
	define( 'WOOCOMMERCE_USE_CSS', false );
}

add_filter( 'body_class', 'invicta_woocommerce_add_version_to_body_class', 9 );

function invicta_woocommerce_add_version_to_body_class( $classes ) {
	
	if ( version_compare( WOOCOMMERCE_VERSION, '2.3' ) >= 0 ) {
		$classes[] = 'woocommerce-new-ui';
	}
	else {
		$classes[] = 'woocommerce-old-ui';
	}
	
	return $classes;
	
}

?>