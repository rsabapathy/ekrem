<?php 
/*
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==

FUNCTIONS TITLE: 
	Invicta - Sidebars
		
FUNCTIONS AUTHOR: 
	Oitentaecinco

FUNCTIONS INDEX:

	@@ Page Title
	@@ Main Content Wrappers
	@@ Shop Loop Wrappers
	@@ Product Content Layout (Overview Page)
	@@ Product Content Layout (Details Page)
	@@ Related Products & Uppsells
	@@ Cart Page Upsells
	@@ Unnecessary Elements
	@@ Breadcrumb
	@@ Header Meta Cart DropDown 
	@@ Search Widget
	@@ Shop Overview Filters

== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/

global $invicta_woocommerce_settings;

function invicta_woocommerce_close_div() {
	echo '</div>';
}

/*
== ------------------------------------------------------------------- ==
== @@ Page Title
== ------------------------------------------------------------------- ==
*/

add_filter( 'invicta_filter_page_title', 'invicta_woocommerce_shop_page_title' );

function invicta_woocommerce_shop_page_title( $page_title ) {

	if ( is_woocommerce() ) {
	
		$shop_title = '';
		$shop_id = woocommerce_get_page_id( 'shop' );
		
		if ( is_shop() ) {
			$shop_title = ''; // get from theme options
		}
		
		if ( $shop_id && $shop_id != -1 ) {
			if ( empty( $shop_title ) ) {
				$shop_title = get_the_title( $shop_id );
			}
		}
		
		if ( ! $shop_title ) {
			$shop_title = __( 'Shop', 'invicta_dictionary' );
		}
		
		if ( is_product_category() || is_product_tag() ) {
			global $wp_query;
			$tax = $wp_query->get_queried_object();
			$shop_title = $tax->name;
		}
		
		$page_title = $shop_title;
		
	}

	return $page_title;
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Main Content Wrappers
== ------------------------------------------------------------------- ==
*/

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'invicta_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'invicta_woocommerce_wrapper_end', 10 );

function invicta_woocommerce_wrapper_start() {
	
	global $invicta_woocommerce_settings;
	$columns = 3;
	
	$context = 'shop';
	if ( isset( $invicta_woocommerce_settings['shop_overview_column_count'] ) ) {
		$columns = $invicta_woocommerce_settings['shop_overview_column_count'];
	}
	
	if ( is_product() ) {
		$context = 'product';
		if ( isset( $invicta_woocommerce_settings['single_product_column_count'] ) ) {
			$columns = $invicta_woocommerce_settings['single_product_column_count'];
		}
	}
	

	
	echo '<div class="invicta_canvas invicta_shop_template columns_' . $columns . '' . invicta_layout_class( 'sidebar_position', $context, false ) . '">';
	echo 	'<div class="main_column">';
}	

function invicta_woocommerce_wrapper_end() {

	//reset all previous queries
	wp_reset_query();

	global $invicta_settings;
	$invicta_settings['context'] = 'shop';
	
	if ( is_product() ) {
		$invicta_settings['context'] = 'product';
	}

	echo 	'</div>';
	get_sidebar();
	echo '</div>';
}	

/*
== ------------------------------------------------------------------- ==
== @@ Shop Loop Wrappers
== ------------------------------------------------------------------- ==
*/

add_action( 'woocommerce_before_shop_loop', 'invicta_woocommerce_before_shop_loop', 1 );
add_action( 'woocommerce_after_shop_loop', 'invicta_woocommerce_after_shop_loop', 10 );

function invicta_woocommerce_before_shop_loop() {
	echo "<div class='invicta_shop_loop'>";
}

function invicta_woocommerce_after_shop_loop() {
	echo invicta_pagination();
	echo "</div>";
}

/*
== ------------------------------------------------------------------- ==
== @@ Product Content Layout (Overview Page)
== ------------------------------------------------------------------- ==
*/

/* set up the number of columns */

add_filter( 'loop_shop_columns', 'invicta_woocommerce_loop_columns' );

function invicta_woocommerce_loop_columns() {
	
	global $invicta_woocommerce_settings;
	$columns = 3;
	if ( isset( $invicta_woocommerce_settings['shop_overview_column_count'] ) ) {
		$columns = $invicta_woocommerce_settings['shop_overview_column_count'];
	}
	
	return $columns;
	
}

/* set up number of products per page */

add_filter( 'loop_shop_per_page', 'invicta_woocommerce_products_per_page' );

function invicta_woocommerce_products_per_page() {

	global $invicta_woocommerce_settings;
	$page_size = 9;
	if ( isset( $invicta_woocommerce_settings['shop_overview_product_count'] ) ) {
		$page_size = $invicta_woocommerce_settings['shop_overview_product_count'];
	}
	
	return $page_size;
}


/* wrapping the product in an extra div for styling purposes */

add_action( 'woocommerce_before_shop_loop_item', 'invicta_woocommerce_product_extra_div', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'invicta_woocommerce_close_div', 1000 );

function invicta_woocommerce_product_extra_div() {
	echo '<div class="product_entry accentcolor-border-on_hover">';
}

/* wrapping the product thumbnail an extra div for styling purposes */

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'invicta_woocommerce_thumbnail', 10 );

function invicta_woocommerce_thumbnail() {
	echo '<div class="product_thumbnail">';
	echo 	woocommerce_get_product_thumbnail();
	echo 	'<span class="cart_loading"></span>';
	echo '</div>';
}

/* wrapping the product info in an extra div for styling purposes */

add_action( 'woocommerce_before_shop_loop_item_title', 'invicta_woocommerce_product_info_div', 20 );
add_action( 'woocommerce_after_shop_loop_item_title',  'invicta_woocommerce_close_div', 1000);

function invicta_woocommerce_product_info_div() {
	echo '<div class="product_meta">';
}

/* wrapping the product price in an extra div for styling purposes */

add_action( 'woocommerce_after_shop_loop_item', 'invicta_woocommerce_product_buttons_div', 5 );
add_action( 'woocommerce_after_shop_loop_item',  'invicta_woocommerce_close_div', 1000);

function invicta_woocommerce_product_buttons_div() {
	echo '<div class="product_buttons">';
}

/* change the product buttons */

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action( 'woocommerce_after_shop_loop_item', 'invicta_woocommerce_product_buttons', 16 );

function invicta_woocommerce_product_buttons() {
	
	global $product;

	if ( $product->product_type == 'bundle' ){
		$product = new WC_Product_Bundle($product->id);
	}

	$extraClass  = "";

	ob_start();
	woocommerce_template_loop_add_to_cart();
	$output = ob_get_clean();

	if ( ! empty ( $output ) ) {
		
		$pos = strpos( $output, '>' );

		if ( $pos !== false ) {
		    $output = substr_replace( $output, "><i class='icon-shopping-cart'></i> ", $pos , strlen(1) );
		}
		
	}

	if( $product->product_type == 'variable' && empty( $output ) ) {
		
		$output = "<a class='add_to_cart_button button product_type_variable' href='" . get_permalink( $product->id ) . "'><i class='icon-file-text'></i> " . __( 'Select options', 'invicta_dictionary' ) . "</a>";
		
	}

	if($product->product_type == 'simple') {
		
		$output .= "<a class='button show_details_button' href='" . get_permalink( $product->id ) . "'><i class='icon-file-text'></i> " . __( 'Show Details', 'invicta_dictionary' ) . "</a>";
	
	} else {
		$extraClass  = "single_button";
	}

	if ( empty( $extraClass ) ) {
		$output .= " <span class='button-mini-delimiter'></span>";
	}

	if($output && !post_password_required()) {
		echo "<div class='invicta_cart_buttons $extraClass'>$output</div>";
	}
}

/*
== ------------------------------------------------------------------- ==
== @@ Product Content Layout (Details Page)
== ------------------------------------------------------------------- ==
*/

/* wrapping single product image on extra div for styling purposes */

add_action( 'woocommerce_before_single_product_summary', 'invicta_woocommerce_add_image_div', 2);
add_action( 'woocommerce_before_single_product_summary',  'invicta_woocommerce_close_image_div', 20);

function invicta_woocommerce_add_image_div() {
	wp_enqueue_script('invicta_fancybox');	
	echo "<div class='single_product_images'>";
}

function invicta_woocommerce_close_image_div() {
	echo "</div>";
}

/* wrapping single product summary on extra div for styling purposes */

add_action( 'woocommerce_before_single_product_summary', 'invicta_woocommerce_add_summary_div', 25);
add_action( 'woocommerce_after_single_product_summary',  'invicta_woocommerce_close_div', 3);

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 1 );

function invicta_woocommerce_add_summary_div() {
	echo "<div class='single_product_details'>";
}

// remove product rating
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

/*
== ------------------------------------------------------------------- ==
== @@ Related Products & Uppsells
== ------------------------------------------------------------------- ==
*/

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 10 );

add_action( 'woocommerce_after_single_product_summary', 'invicta_woocommerce_single_product_navigation', 20 );
add_action( 'woocommerce_after_single_product_summary', 'invicta_woocommerce_output_upsells', 20);
add_action( 'woocommerce_after_single_product_summary', 'invicta_woocommerce_output_related_products', 20 );

function invicta_woocommerce_single_product_navigation() {
	echo '<div class="product_navigation">';
	invicta_post_pagination();
	echo '</div>';
}

function invicta_woocommerce_output_related_products() {
	
	global $invicta_woocommerce_settings;
	
	$output = '';
	
	ob_start();
	if ( version_compare( WOOCOMMERCE_VERSION, '2.1' ) >= 0 ) {
		woocommerce_related_products( array ( 'posts_per_page' => $invicta_woocommerce_settings['single_product_product_count'], 'columns' => $invicta_woocommerce_settings['single_product_column_count'] ) );
	}
	else {
		woocommerce_related_products( $invicta_woocommerce_settings['single_product_product_count'], $invicta_woocommerce_settings['single_product_column_count'] );	
	}
	$content = ob_get_clean();
	
	if ( $content ) {
		
		$output .= '<div class="related_products">';
		$output .= $content;
		$output .= '</div>';
		
	}
	
	echo $output;
	
}

function invicta_woocommerce_output_upsells() {
	
	global $invicta_woocommerce_settings;
	
	$output = '';
	
	ob_start();
	woocommerce_upsell_display( $invicta_woocommerce_settings['single_product_product_count'], $invicta_woocommerce_settings['single_product_column_count'] );
	$content = ob_get_clean();
	
	if ( $content ) {
		
		$output .= '<div class="upsells">';
		$output .= $content;
		$output .= '</div>';
		
	}
	
	echo $output;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Cart Page Upsells
== ------------------------------------------------------------------- ==
*/

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 10 );


/*
== ------------------------------------------------------------------- ==
== @@ Unnecessary Elements
== ------------------------------------------------------------------- ==
*/

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

/*
== ------------------------------------------------------------------- ==
== @@ Breadcrumb
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_woocommerce_breadcrumb' ) ) {
	
	add_filter( 'invicta_breadcrumb_trail', 'invicta_woocommerce_breadcrumb' );
	
	function invicta_woocommerce_breadcrumb( $trail ) {
	
		if ( is_woocommerce() ) {

			$home = $trail[0];
			$last = array_pop( $trail );
			$shop_id = woocommerce_get_page_id( 'shop' );
			$taxonomy = 'product_cat';
			
			if ( is_shop() ) { // shop overview page 
				
				if ( ! empty( $shop_id) && $shop_id != -1 ) {
					$trail = array_merge( $trail, invicta_breadcrumb::get_parents( $shop_id ) );
				}
				
				$last = '';
				
				if ( is_search() ) {
					$last = __('Search results for','invicta_dictionary') . ': ' . esc_attr($_GET['s']);
				}
				
			}
			
			if ( is_product() ) {
				
				$product_category = array();
				$parent_cat = array();
				
				$temp_cats = get_the_terms( get_the_ID(), $taxonomy );
				
				if ( ! empty( $temp_cats ) ) {
				
					foreach ( $temp_cats as $key => $cat ) {
						if( $cat->parent != 0 && ! in_array( $cat->term_taxonomy_id, $parent_cat ) ) {
							$product_category[] = $cat;
							$parent_cat[] = $cat->parent;
						}
					}
					
					//if no categories with parents use the first one
					if( empty( $product_category ) ) {
						$product_category[] = reset( $temp_cats );
					}
					
				}
				
				unset($trail);
				
				$trail[0] = $home;
				
				if ( ! empty( $shop_id ) && $shop_id != -1 ) { 
					$trail = array_merge( $trail, invicta_breadcrumb::get_parents( $shop_id ) );
				}
				
				if ( ! empty( $parent_cat ) ) {
					$trail = array_merge( $trail, invicta_breadcrumb::get_term_parents( $parent_cat[0] , $taxonomy ) );
				}
				
				if ( ! empty( $product_category ) ) {
					$trail[] = '<a href="' . get_term_link( $product_category[0]->slug, $taxonomy ) . '" title="' . esc_attr( $product_category[0]->name ) . '">' . $product_category[0]->name . '</a>';
				}
				
			}
			
			if ( is_product_category() || is_product_tag() ) {
				if ( ! empty( $shop_id ) && $shop_id != -1 ) {
					$shop_trail = invicta_breadcrumb::get_parents( $shop_id ) ;
					array_splice($trail, 1, 0, $shop_trail);
				}
			}
			
			if( is_product_tag() ) {
				$last = __("Tag",'invicta_dictionary') . ": " . $last;
			}
			
			if ( ! empty( $last ) ) {
				$trail['trail_end'] = $last;
			}
			
		}
		
		return $trail;
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Header Meta Cart
== ------------------------------------------------------------------- ==
*/

add_action( 'invicta_header_meta_right_place_end', 'invicta_add_cart_to_header_meta' );

function invicta_add_cart_to_header_meta() {

	global $woocommerce;
	global $invicta_woocommerce_settings;
	global $smof_data;
	
	if ( isset( $smof_data['header-meta_bar_woocommerce_cart_dropdown'] ) && $smof_data['header-meta_bar_woocommerce_cart_dropdown']  ) {
	
		$cart_subtotal = $woocommerce->cart->get_cart_subtotal();
		$cart_link = $woocommerce->cart->get_cart_url();
	
		$output = '';
		
		$output .= '<div class="woocommerce_header_cart">';
		$output .= 		'<span class="divider">|</span> ';
		$output .=		'<ul class="cart_widget" data-feedback="' . __( 'was added to the cart', 'invicta_dictionary' ) . '">';
		$output .=			'<li>';
		$output .=				'<a href="' . $cart_link . '" class="cart_summary inherit-color">';
		$output .=					'<i class="icon-shopping-cart"></i> ';
		$output .=					$cart_subtotal;
		$output .= 				'</a>';
		$output .= 				'<div class="widget_wrapper">';
		$output .= 					'<div class="widget_shopping_cart_content"></div>';
		$output .=				'</div>';	
	/*
		$output .=				'<div class="added_to_cart_notification">';
		$output .=					'<img src="# />';
		$output .=					'<div class="product_name"><strong>Mind da Gap</strong> was added to the cart</div>';
		$output .=				'</div>';
	*/
		$output .=			'</li>';
		$output .=		'</ul>';
		
		$output .= '</div>';
		
		echo $output;
	
	}
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Search Widget
== ------------------------------------------------------------------- ==
*/

if ( version_compare( WOOCOMMERCE_VERSION, '2.3' ) == 0 ) { 
	
	add_filter( 'get_product_search_form', 'invicta_woocommerce_search_form' );

	function invicta_woocommerce_search_form( $form ) {
		
		preg_match_all( "/<input type=\"submit\"[^']*?[^']*?>/", $form, $matches );
		
		if ( ! empty( $matches[0] ) ) {
			
			$original_button_html = $matches[0];
			$new_button_html = '<button type="submit" id="searchsubmit" class="accentcolor-text-on_hover inherit-color"><i class="icon-search"></i></button>';
			
			$form = str_replace( $original_button_html, $new_button_html, $form );
			
		}
	
		return $form;
		
	}	
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Shop Overview Filters
== ------------------------------------------------------------------- ==
*/

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_shop_loop', 'invicta_woocommerce_shop_page_filters', 20 );
add_action( 'woocommerce_get_catalog_ordering_args', 'invicta_woocommerce_overwrite_catalog_ordering', 20 );

function invicta_woocommerce_shop_page_filters() {
	
	global $invicta_woocommerce_settings;
	
	// product order dataset
	
	$product_order['default'] 		= __( 'Default Order', 'invicta_dictionary' );
	$product_order['title'] 		= __( 'Name', 'invicta_dictionary' );
	$product_order['price'] 		= __( 'Price', 'invicta_dictionary' );
	$product_order['date'] 			= __( 'Date', 'invicta_dictionary' );
	$product_order['popularity'] 	= __( 'Popularity', 'invicta_dictionary' );
	
	// product sort dataset
	
	$product_sort['asc'] 			= __( 'Click to order products ascending', 'invicta_dictionary' );
	$product_sort['desc']			= __( 'Click to order products descending', 'invicta_dictionary' );
	
	// product count dataset
	
	$per_page_string 				= __( 'Products per page', 'invicta_dictionary' );
	$per_page 						= get_option( 'invicta_woocommerce_product_count' );
	if ( ! $per_page ) {
		$per_page					= get_option('posts_per_page');
	}
	if ( ! empty( $invicta_woocommerce_settings['catalog_sort']['default_posts_per_page'] ) ) {
		$per_page 					= $invicta_woocommerce_settings['catalog_sort']['default_posts_per_page'];
	}
	
	$product_count[ $per_page ] = $per_page . ' ' . $per_page_string;
	$product_count[ $per_page * 2 ] = ( $per_page * 2 ) . ' ' . $per_page_string;
	$product_count[ $per_page * 3 ] = ( $per_page * 3 ) . ' ' . $per_page_string;
	
	// get current values
	
	parse_str( $_SERVER['QUERY_STRING'], $params );
	
	$order 	= ( ! empty( $invicta_woocommerce_settings['catalog_sort']['product_order'] ) ) ? $invicta_woocommerce_settings['catalog_sort']['product_order'] : 'default';
	$sort 	= ( ! empty( $invicta_woocommerce_settings['catalog_sort']['product_sort'] ) ) ? $invicta_woocommerce_settings['catalog_sort']['product_sort'] : 'asc';
	$count 	= ( ! empty( $invicta_woocommerce_settings['catalog_sort']['product_count'] ) ) ? $invicta_woocommerce_settings['catalog_sort']['product_count'] : $per_page;
	
	$sort = strtolower($sort);
	
	// generate output
	
	$output  = '';
	$output .= '<div class="product_sorting">';
	
	// order
	
	$output .= '	<ul class="sort_param sort_param_order">';
	$output .= '		<li>';
	$output .= '			<span class="currently_selected">' . __( 'Sort by', 'invicta_dictionary' ) . ' <strong>' . $product_order[ $order ] . '</strong></span>';
	$output .= '			<ul>';
	foreach ( $product_order as $key => $value ) {
		$output .= '				<li' . invicta_woocommerce_active_class( $order, $key ) . '><a href="' .  invicta_woocommerce_build_query_string( $params, 'product_order', $key ) . '">' . $value . '</a></li>';	
	}
	$output .= '			</ul>';
	$output .= '		</li>';
	$output .= '	</ul>';
	
	// sort 
	
	$output .= '	<ul class="sort_param sort_param_sort">';
	$output .= '		<li>';
	if ( $sort == 'asc') {
		$output .= '			<a title="' . $product_sort['desc'] . '" class="desc" href="' . invicta_woocommerce_build_query_string( $params, 'product_sort', 'desc' ) . '">' . $product_sort['asc'] . '</a>';
	}
	if ( $sort == 'desc') {
		$output .= '			<a title="' . $product_sort['asc'] . '" class="asc" href="' . invicta_woocommerce_build_query_string( $params, 'product_sort', 'asc' ) . '">' . $product_sort['desc'] . '</a>';
	}
	$output .= '		</li>';
	$output .= '	</ul>';
	
	// count
	
	$output .= '	<ul class="sort_param sort_param_count">';
	$output .= '		<li>';
	$output .= '			<span class="currently_selected">' . __( 'Display', 'invicta_dictionary' ) . ' <strong>' . $count . ' ' . $per_page_string . '</strong></span>';
	$output .= '			<ul>';
	foreach ( $product_count as $key => $value ) {
		$output .= '				<li' . invicta_woocommerce_active_class( $count, $key ) . '><a href="' .  invicta_woocommerce_build_query_string( $params, 'product_count', $key ) . '">' . $value . '</a></li>';	
	}
	$output .= '			</ul>';
	$output .= '		</li>';

	$output .= '	</ul>';
	
	$output .= '</div>';
	
	echo $output;
	
}

function invicta_woocommerce_overwrite_catalog_ordering( $args ) {

	global $invicta_woocommerce_settings;
	
	// check the querystring parameters and sessions vars
	// if they are set, overwrite the defaults
	
	$check = array( 'product_order', 'product_sort', 'product_count' );
	
	if( empty( $invicta_woocommerce_settings['catalog_sort'] ) ) {
		$invicta_woocommerce_settings['catalog_sort'] = array();
	}
	
	foreach ( $check as $key ) {
		if ( isset( $_GET[$key] ) ) {
			$_SESSION['invicta_woocommerce'][$key] = esc_attr( $_GET[$key] );
		}
		if ( isset( $_SESSION['invicta_woocommerce'][$key] ) ) {
			$invicta_woocommerce_settings['catalog_sort'][$key] = $_SESSION['invicta_woocommerce'][$key];
		}
	}
	
	// if the user wants a new product order
	// the old sorting parameter should be removed
	
	if ( isset( $_GET['product_order'] ) && ! isset( $_GET['product_sort'] ) && isset( $_SESSION['invicta_woocommerce']['product_sort'] ) ) {
		unset( $_SESSION['invicta_woocommerce']['product_sort'], $invicta_woocommerce_settings['catalog_sort']['product_sort'] );
	}
	
	extract( $invicta_woocommerce_settings['catalog_sort'] );
	
	// set the product order
	
	if ( ! empty( $product_order ) ) {
		switch ( $product_order ) {
			case 'date'	: 
				$orderby 	= 'date';
				$order 		= 'desc';
				$meta_key 	= '';
				break;
			case 'price' :
				$orderby	= 'meta_value_num';
				$order 		= 'asc';
				$meta_key	= '_price';
				break;
			case 'popularity' :
				$orderby	= 'meta_value_num';
				$order 		= 'desc';
				$meta_key	= 'total_sales';
				break;
			case 'title' :
				$orderby	= 'title';
				$order		= 'asc';
				$meta_key	= '';
				break;
			case 'default' :
			default :
				$orderby	= 'menu_order title';
				$order		= 'asc';
				$meta_key	= '';
				break;
		}
	}
	
	// set the product sorting
	
	if ( ! empty( $product_sort ) ) {
		switch ( $product_sort ) {
			case 'desc' :
				$order = 'desc';
				break;
			case 'asc' :
				$order = 'asc';
				break;
			default :
				$order = 'asc';
				break;
		}
	}
	
	// set the product count

	if ( ! empty( $product_count ) && is_numeric( $product_count ) ) {
		$invicta_woocommerce_settings['shop_overview_product_count'] = (int) $product_count;
	}
	
	// overwriting $args
	
	if ( isset( $orderby ) ) {
		$args['orderby'] = $orderby;
	}
	
	if ( isset( $order ) ) {
		$args['order'] = $order;
	}
	
	if ( ! empty( $meta_key ) ) {
		$args['meta_key'] = $meta_key;
	}
	
	$invicta_woocommerce_settings['catalog_sort']['product_sort'] = $args['order'];
	
	return $args;
	
}


function invicta_woocommerce_active_class( $key1, $key2 ) {
	if( $key1 == $key2 ) {
		return " class='current_param'";
	}
	else {
		return "";
	}
}

function invicta_woocommerce_build_query_string( $params = array(), $overwrite_key, $overwrite_value ) {
	$params[ $overwrite_key ] = $overwrite_value;
	return '?' . http_build_query($params);
}

/*
== ------------------------------------------------------------------- ==
== @@ Password Protected Products
== ------------------------------------------------------------------- ==
*/

add_action('woocommerce_before_single_product', 'invicta_woocommerce_remove_hooks');

function invicta_woocommerce_remove_hooks() {

	if( post_password_required() ) {
		
		add_action( 'woocommerce_after_single_product_summary', 'invicta_woocommerce_echo_password', 1 );

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 1 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
		remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
		remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
		remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		
	}
}

function invicta_woocommerce_echo_password() {
	if( post_password_required() ) {
		echo get_the_password_form();
	}
}


	
?>