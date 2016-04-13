<?php 
	
if ( class_exists( 'woocommerce' ) ) {

	global $invicta_woocommerce_settings;
	
	$invicta_woocommerce_settings['shop_overview_column_count'] = get_option( 'invicta_woocommerce_column_count' );
	$invicta_woocommerce_settings['shop_overview_product_count'] = get_option( 'invicta_woocommerce_product_count' );
	$invicta_woocommerce_settings['single_product_column_count'] = 4;
	$invicta_woocommerce_settings['single_product_product_count'] = 4;
	
	$invicta_woocommerce_settings['thumbnail_image_size'] 	= array( 'width' => 150, 'height' => 150 );
	$invicta_woocommerce_settings['catalog_image_size'] 	= array( 'width' => 450, 'height' => 450 );
	$invicta_woocommerce_settings['single_image_size'] 		= array( 'width' => 450, 'height' => 450 );
	
	include_once( 'admin-settings.php' );
	include_once( 'assets.php' );	
	include_once( 'frontend.php' );
	
	add_theme_support( 'woocommerce' );
	
}
	
?>