<?php 

/*
== ------------------------------------------------------------------- ==
== @@ Removing options from the admin's settings screen
== ------------------------------------------------------------------- ==
*/
	
add_filter( 'woocommerce_general_settings','invicta_woocommerce_settings_filter');
add_filter( 'woocommerce_page_settings','invicta_woocommerce_settings_filter');
add_filter( 'woocommerce_catalog_settings','invicta_woocommerce_settings_filter');
add_filter( 'woocommerce_inventory_settings','invicta_woocommerce_settings_filter');
add_filter( 'woocommerce_shipping_settings','invicta_woocommerce_settings_filter');
add_filter( 'woocommerce_tax_settings','invicta_woocommerce_settings_filter');
add_filter( 'woocommerce_product_settings','invicta_woocommerce_settings_filter');

function invicta_woocommerce_settings_filter( $options ) {
	
	$to_be_removed[] = 'woocommerce_enable_lightbox';
	$to_be_removed[] = 'woocommerce_frontend_css';
	
	foreach ( $options as $key => $option ) {
		if ( isset( $option['id'] ) && in_array( $option['id'], $to_be_removed ) ) {
			unset( $options[$key] );
		}
	}
	
	return $options;
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Changing Default WooCommerce Settings
== ------------------------------------------------------------------- ==
*/

add_action( 'after_switch_theme', 'invicta_woocommerce_set_default_settings', 10, 2 );
add_action( 'admin_init', 'invicta_woocommerce_first_activation', 45 );

function invicta_woocommerce_set_default_settings() {

	global $invicta_woocommerce_settings;
	
	// set image sizes
	update_option( 'shop_catalog_image_size', $invicta_woocommerce_settings['catalog_image_size'] );
	update_option( 'shop_single_image_size', $invicta_woocommerce_settings['single_image_size'] );
	update_option( 'shop_thumbnail_image_size', $invicta_woocommerce_settings['thumbnail_image_size'] );
	
	// disable woocommerce lightbox
	update_option( 'woocommerce_enable_lightbox', false);
	
	// set num columns
	update_option( 'invicta_woocommerce_column_count', 3 );
	
	// set num products per page
	update_option( 'invicta_woocommerce_product_count', 9 );
	
}

function invicta_woocommerce_first_activation() {

	if ( ! is_admin() ) {
		return;
	}
	
	$option_id = 'invicta_woocommerce_settings_changed';
	
	if ( get_option( $option_id ) ) {
		return;
	}
	else {
		invicta_woocommerce_set_default_settings();
		update_option( $option_id, '1' );
	}
	
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Add New Features
== ------------------------------------------------------------------- ==
*/

add_filter( 'woocommerce_catalog_settings', 'invicta_woocommerce_catalog_settings_filter' );
add_filter( 'woocommerce_product_settings', 'invicta_woocommerce_catalog_settings_filter' );

function invicta_woocommerce_catalog_settings_filter( $options ) {
	
	$options[] = array(
		'name' => __( 'Column and Product Count', 'invicta_dictionary' ),
        'type' => 'title',
        'desc' => __( 'The following settings allow you to choose how many columns and items should appear on your default shop overview page and your product archive pages.<br/><small>Notice: These options are added by the <strong>Invicta Theme</strong> and wont appear on other themes</small>', 'invicta_dictionary' ),
        'id'   => 'column_options'
	);
	
	$options[] = array(
			'name' => __( 'Column Count', 'invicta_dictionary' ),
            'desc' => '',
            'id' => 'invicta_woocommerce_column_count',
            'css' => 'min-width:175px;',
            'std' => '3',
            'desc_tip' => __( "How many columns should appear on overview pages.", 'invicta_dictionary' ) ,
            'type' => 'select',
            'options' => array (
                    '3' => '3',
                    '4' => '4'
					)
	);
	
	$itemcount = array('-1'=>'All');
	for( $i = 3 ; $i < 21; $i++ ) {
		$itemcount[$i] = $i;	
	}
	
	$options[] = array(
		'name' => __( 'Product Count', 'invicta_dictionary' ),
        'desc' => "",
        'id' => 'invicta_woocommerce_product_count',
        'css' => 'min-width:175px;',
        'desc_tip' => __( 'This controls how many products should appear on overview pages.', 'invicta_dictionary' ),
        'std' => '9',
        'type' => 'select',
        'options' => $itemcount
	);
	
	$options[] = array(
        'type' => 'sectionend',
        'id' => 'column_options'
    );
	
	return $options;
	
}
	
?>