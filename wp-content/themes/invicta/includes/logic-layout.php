<?php 

/*
== ------------------------------------------------------------------- ==
== @@ Layout Class
== ------------------------------------------------------------------- ==
*/
	
function invicta_layout_class( $key, $context, $echo = true ) {

	global $post;
	global $smof_data;
	$result = '';
	
	if ( $key == 'sidebar_position') {
		
		$post_id = invicta_get_page_id();
		$sidebar_position = '';
		$custom_sidebar_position = get_post_meta( $post_id, '_invicta_layout_layout', true );
		
		if ( ! empty( $custom_sidebar_position ) && $custom_sidebar_position != 'default' ) {
			$sidebar_position = $custom_sidebar_position;
		}
		else {
			if ( isset( $smof_data['sidebars-' . $context] ) ) {
				$sidebar_position = $smof_data['sidebars-' . $context];
			}
			else {
				$sidebar_position = 'no_sidebar';
			}
		}

		switch ( $sidebar_position ) {
		
			case 'left_sidebar' :
				$result = 'left_sidebar';
				break;
				
			case 'no_sidebar' :
				$result = 'no_sidebar';
				break;
				
			case 'right_sidebar' :
				$result = ''; // default
				break;
		
		}
		
	}
	
	else if ( $key == 'blog_layout' ) {
			
		switch ( $smof_data['blog-layout-' . $context] ) {
		
			case 'full_width' :
				$result = ''; // default
				break;
		
			case 'grid' : 
				$result = 'grid invicta_grid';
				break;
				
			case 'left_thumbnail' :
				$result = 'small_thumbnail left_thumbnail';
				break;
				
			case 'right_thumbnail' :
				$result = 'small_thumbnail right_thumbnail';
				break;
				
		}
		
		if ( isset( $smof_data['blog-layout-clean_style'] ) && $smof_data['blog-layout-clean_style'] ) {
			if ( $result ) { $result .= ' '; }
			$result .= 'clean_style';
		}
		
	} 
	
	else if ( $key == 'body_classes' ) {
		
		$classes = array();
		
		if ( $smof_data['general-responsiveness'] ) {
			$classes[] = 'responsive';
		}
		
		if ( $smof_data['styling-boxed_layout'] ) {
			$classes[] = 'invicta_boxed_layout';
		}
		
		if ( isset( $smof_data['header-fixed'] ) && $smof_data['header-fixed'] ) {
			$classes[] = 'invicta_fixed_header';
		}
		
		$visual_composer_custom_design = get_option('wpb_js_use_custom');
		
		if ( ! $visual_composer_custom_design ) {
			$classes[] = 'visual_composer_invicta_styles';
		}
		
		if ( ! empty( $classes ) ) {
			$result = join( $classes, ' ' );
		}
		
	}
	
	else if ( $key == 'portfolio_layout' ) {
		
		$post_id = get_queried_object_id();
		
		if ( $context == 'pages' ) {
		
			$portfolio_layout = get_post_meta( $post_id, '_invicta_portfolio_page_settings_layout', true );
			
			if ( $portfolio_layout ) {
				$result = $portfolio_layout;
			}
			
		}
		
		else if ( $context == 'project' ) {
		
			$portfolio_layout = get_post_meta( $post_id, '_invicta_portfolio_layout_layout', true );
			
			if ( $portfolio_layout ) {
				$result = $portfolio_layout;
			}
			
		}
		
	}
	
	// output setup
	
	if ( $result ) { $result = ' ' . $result; }
	if ( $echo ) { echo $result; } else { return $result; }
	
}
	

/*
== ------------------------------------------------------------------- ==
== @@ Has Sidebar
== ------------------------------------------------------------------- ==
*/	
	
function invicta_has_sidebar( $context ) {
	
	global $post;
	global $smof_data;
	
	$post_id = invicta_get_page_id();
	$sidebar_position = '';
	$custom_sidebar_position = get_post_meta( $post_id, '_invicta_layout_layout', true );
	
	if ( ! empty( $custom_sidebar_position ) && $custom_sidebar_position != 'default' ) {
		$sidebar_position = $custom_sidebar_position;
	}
	else {
		if ( isset( $smof_data['sidebars-' . $context] ) ) {
			$sidebar_position = $smof_data['sidebars-' . $context];
		}
		else {
			$sidebar_position = 'no_sidebar';
		}
	}
	
	return ( $sidebar_position != 'no_sidebar' );
			
}
	

/*
== ------------------------------------------------------------------- ==
== @@ Helper Functions
== ------------------------------------------------------------------- ==
*/

function invicta_get_page_id() {
	
	global $post;	
	
	$post_id = get_queried_object_id();

	if ( $post_id == 0 ) {
		if ( class_exists( 'woocommerce' ) ) { 
			if ( is_woocommerce() && is_shop() ) {
				$post_id = woocommerce_get_page_id( 'shop' );	
			}
		}
	}
	
	return $post_id;
	
}
		
?>