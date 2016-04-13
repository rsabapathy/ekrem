<?php 

/*
== ------------------------------------------------------------------- ==
== @@ Page/Post Layout Metabox
== ------------------------------------------------------------------- ==
*/

add_action('admin_init', 'invicta_add_page_post_metaboxes' );

function invicta_add_page_post_metaboxes() {

	/*
	== ------------------------------------------------------------------- ==
	== @@ Page Layout Metabox
	== ------------------------------------------------------------------- ==
	*/
	
	// available layouts
	
	$layouts = array(
		'default' => __( 'Default (set in Theme Options)', 'invicta_dictionary' ),
		'no_sidebar' => __( 'No Sidebar', 'invicta_dictionary' ),
		'right_sidebar' => __( 'Right Sidebar', 'invicta_dictionary' ),
		'left_sidebar' => __( 'Left Sidebar', 'invicta_dictionary' )
	);
	
	// available sidebars
	
	$sidebars = array();
	$sidebars['default'] = __( 'Default', 'invicta_dictionary' );
	global $wp_registered_sidebars;
	foreach ( $wp_registered_sidebars as $sidebar ) {
		if ( $sidebar['name'] != 'Global Sidebar') {
			$sidebars[ $sidebar['name'] ] = $sidebar['name'];
		}
	}
	
	// metabox arguments
	
	$args = array(
		'id'			=> '_invicta_layout',
		'title' 		=> __( 'Page Layout', 'invicta_dictionary' ),
		'post_types' 	=> array( 'post', 'page' ),
		'context' 		=> 'side',
		'priority'		=> 'default',
		'fields'		=> array(
			array(
				'id' 			=> '_invicta_layout_layout',
				'name' 			=> __( 'Layout', 'invicta_dictionary' ),
				'description'	=> __( 'Select the desired Page layout', 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'select',
				'options'		=> $layouts
			),
			array(
				'id' 			=> '_invicta_layout_sidebar',
				'name' 			=> __( 'Sidebar', 'invicta_dictionary' ),
				'description'	=> __( 'Select a custom sidebar for this entry', 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'select',
				'options'		=> $sidebars
			)
		)
	);
	
	// metabox creation

	new invicta_metabox($args);
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Page Slider Metabox
	== ------------------------------------------------------------------- ==
	*/
	
	// get sliders from database
	
	$revolution_sliders = array();
	
	if ( function_exists('is_plugin_active') ) {
		if ( is_plugin_active( 'revslider/revslider.php' ) ) {
		
			global $wpdb;
			
			$revsliders_data = $wpdb->get_results( 'SELECT id, title, alias FROM ' . $wpdb->prefix . 'revslider_sliders ORDER BY id ASC LIMIT 100' );

			$revolution_sliders[''] = '';
			
			if ( $revsliders_data ) {
				foreach ( $revsliders_data as $slider ) {
					$revolution_sliders[ $slider->alias ] = $slider->alias;
				}
			}
			
		}
	}
	
	// metabox arguments
	
	$args = array(
		'id'          => '_invicta_page_slider',
		'title'       => __( 'Featured Slider', 'invicta_dictionary' ),
		'post_types'  => array( 'page' ),
		'context'     => 'side',
		'priority'    => 'low',
		'fields'      => array(
			array(
				'id'            => '_invicta_page_slider',
				'name'          => __( 'Revolution Slider', 'invicta_dictionary' ),
				'description'   => __( 'Select a slider for the page', 'oitentaecinco' ),
				'default'       => '',
				'type'          => 'select',
				'options'       => $revolution_sliders
			)
		)
	);
	
	// metabox creation

	new invicta_metabox($args);

}

	
?>