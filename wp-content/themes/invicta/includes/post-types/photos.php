<?php 
	
/*
== ------------------------------------------------------------------- ==
== @@ Post Type
== ------------------------------------------------------------------- ==
*/

add_action( 'init', 'invicta_photos_register' );

function invicta_photos_register() {
	
	global $smof_data;

	$icon = get_template_directory_uri() . '/styles/images/admin/photo_galleries.png';
	try {
		global $wp_version;
		if ( version_compare( $wp_version, '3.8') >= 0 ) {
			$icon = 'dashicons-format-gallery';
		}
	}
	catch( Exception $e ) {	
	}
	
	$register_post_type = true;
	$register_taxonomy = true;
	
	// registering PHOTOS post type
	if ( $register_post_type ) {
		
		$labels = array(
			'name'					=> __( 'Photos', 'invicta_dictionary' ),
			'singular_name'			=> __( 'Photo Gallery', 'invicta_dictionary' ),
			'add_new' 				=> __( 'Add New', 'invicta_dictionary' ),
			'add_new_item' 			=> __( 'Add New Photo Gallery', 'invicta_dictionary' ),
			'edit_item' 			=> __( 'Edit Photo Gallery', 'invicta_dictionary' ),
			'new_item' 				=> __( 'New Photo Gallery', 'invicta_dictionary' ),
			'all_items' 			=> __( 'All Photos', 'invicta_dictionary' ),
			'view_item' 			=> __( 'View Photo Gallery', 'invicta_dictionary' ),
			'search_items' 			=> __( 'Search Photo Galleries', 'invicta_dictionary' ),
			'not_found' 			=> __( 'No Photo Galleries found', 'invicta_dictionary' ),
			'not_found_in_trash' 	=> __( 'No Photo Galleries found in Trash', 'invicta_dictionary' ),
			'parent_item_colon' 	=> '',
			'menu_name' 			=> __( 'Photos', 'invicta_dictionary'),
		);
		
		if ( isset( $smof_data['photos-slug'] ) && ! empty( $smof_data['photos-slug'] ) ) {
			$slug = $smof_data['photos-slug'];
		} 
		else {
			$slug = 'photo-gallery';
		}
		
		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'show_ui'				=> true,
			'show_in_menu' 			=> true, 
			'show_in_nav_menus'		=> true,
			'menu_position' 		=> 5,
			'menu_icon' 			=> $icon,
			'query_var' 			=> true,
			'capability_type' 		=> 'post',
			'hierarchical' 			=> false,
			'has_archive'			=> false,
			'supports' 				=> array( 'title', 'thumbnail', 'excerpt', 'editor', 'page-attributes' ),
			'rewrite'				=> array(
											'slug'			=> $slug,
											'with_front'	=> true
											)
		);
		
		register_post_type( 'invicta_photos', $args );
		
	}
	
	// registering CATEGORY taxonomy
	if ( $register_taxonomy ) {
		
		$labels = array(
			'name' 				=> __( 'Categories', 'invicta_dictionary' ),
			'singular_name' 	=> __( 'Category', 'invicta_dictionary' ),
			'search_items' 		=> __( 'Search Categories', 'invicta_dictionary' ),
			'all_items' 		=> __( 'All Categories', 'invicta_dictionary' ),
			'parent_item' 		=> __( 'Parent Category', 'invicta_dictionary' ),
			'parent_item_colon'	=> __( 'Parent Category:', 'invicta_dictionary' ),
			'edit_item' 		=> __( 'Edit Category', 'invicta_dictionary' ),
			'update_item' 		=> __( 'Update Category', 'invicta_dictionary' ),
			'add_new_item' 		=> __( 'Add New Category', 'invicta_dictionary' ),
			'new_item_name' 	=> __( 'New Category Name', 'invicta_dictionary' ),
			'menu_name' 		=> __( 'Categories', 'invicta_dictionary' )
		);
		
		$args = array(
			'labels' 			=> $labels,
			'hierarchical' 		=> true,
			'show_ui' 			=> true,
			'show_in_nav_menus' => false,
			'query_var' 		=> true,
			'rewrite' 			=> array(
										'slug'			=> 'photos-category',
										'with_front'	=> true
									)
		);
		
		register_taxonomy( 'invicta_photos_category', array('invicta_photos'), $args );
		
	}
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Update Messages
== ------------------------------------------------------------------- ==
*/

add_filter( 'post_updated_messages', 'invicta_photos_update_messages' );

function invicta_photos_update_messages( $messages ) {
	
	global $post, $post_ID;
	
	$messages['invicta_photos'] = array(
		0 	=> '',
		1 	=> sprintf( __( 'Photo Gallery updated. <a href="%s">View Gallery</a>', 'invicta_dictionary' ), esc_url( get_permalink($post_ID))),
		2 	=> __( 'Custom field updated.', 'invicta_dictionary' ),
		3 	=> __( 'Custom field deleted.', 'invicta_dictionary' ),
		4 	=> __( 'Photo Gallery updated.', 'invicta_dictionary' ),
		5 	=> isset( $_GET['revision'] ) ? sprintf( __('Photo Gallery restored to revision from %s', 'invicta_dictionary' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 	=> sprintf( __( 'Photo Gallery published. <a href="%s">View Photo Gallery</a>', 'invicta_dictionary' ), esc_url( get_permalink( $post_ID ) ) ),
		7 	=> __( 'Photo Gallery saved.', 'invicta_dictionary' ),
		8 	=> sprintf( __( 'Photo Gallery submitted. <a target="_blank" href="%s">Preview Photo Gallery</a>', 'invicta_dictionary' ), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID) ) ) ),
		9 	=> sprintf( __( 'Photo Gallery scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Photo Gallery</a>', 'invicta_dictionary' ), date_i18n( __( 'M j, Y @ G:i' , 'invicta_dictionary' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		10 	=> sprintf( __( 'Photo Gallery draft updated. <a target="_blank" href="%s">Preview Photo Gallery</a>', 'invicta_dictionary' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	);
	
	return $messages;
}

/*
== ------------------------------------------------------------------- ==
== @@ List Columns
== ------------------------------------------------------------------- ==
*/

add_filter( 'manage_edit-invicta_photos_columns', 'invicta_add_new_photos_columns' );

function invicta_add_new_photos_columns( $columns ) {

	$new_columns['cb'] 							= '<input type="checkbox" />';
	$new_columns['title'] 						= __( 'Title', 'invicta_dictionary' );
	$new_columns['invicta_photos_category'] 	= __( 'Categories', 'invicta_dictionary' );
	$new_columns['menu_order'] 					= __( 'Order', 'invicta_dictionary' );

	$columns = array_merge( $new_columns, $columns );
	
	return $columns;
	
}

add_action( 'manage_invicta_photos_posts_custom_column', 'invicta_handle_new_photos_columns', 10, 2 );

function invicta_handle_new_photos_columns( $column, $post_id ) {

	global $post;
	
	switch ( $column ) {
			
		case 'invicta_photos_category':
		
			$taxonomy = $column;
			$post_type = get_post_type( $post_id );
			$terms = get_the_terms( $post_id, $taxonomy );
			
			if ( $terms ) {
				
				foreach ( $terms as $term ) {
					
					$post_terms[] = '<a href="edit.php?post_type=' . $post_type . '&' . $taxonomy . '=' . $term->slug . '">' . esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $taxonomy, 'edit') ) . '</a>';
					
				}
				
				echo join(', ', $post_terms );
				
			}
			
			break;
			
		case 'menu_order':
			
			$order = $post->menu_order;
			echo $order;
			
			break;
	
	}
	
}

/*
== ------------------------------------------------------------------- ==
== @@ List Filters
== ------------------------------------------------------------------- ==
*/

add_action( 'restrict_manage_posts', 'invicta_add_new_photos_filters' );

function invicta_add_new_photos_filters() {
	
	global $typenow;
	
	if ($typenow == 'invicta_photos') :
	
		// portfolio categories
		
		$tax_obj = get_taxonomy('invicta_photos_category');	
		$selected_tax = ( isset( $_GET[ $tax_obj->query_var ] ) ) ? $_GET[ $tax_obj->query_var ] : 0;
		
		if ( ! is_numeric ( $selected_tax ) ) {
			$selected_tax_obj = get_term_by( 'slug', $selected_tax, 'invicta_photos_category' );
			$selected_tax = $selected_tax_obj->term_id;
		}
		
		wp_dropdown_categories(array(
			'show_option_all' 	=> __( 'Show All', 'invicta_dictionary' ) . ' ' . $tax_obj->label,
			'taxonomy' 			=> 'invicta_photos_category',
			'name' 				=> $tax_obj->name,
			'orderby' 			=> 'name',
			'selected' 			=> $selected_tax,
			'hierarchical' 		=> $tax_obj->hierarchical,
			'show_count' 		=> true,
			'hide_empty' 		=> false
		));
	
	endif;
	
}

add_filter( 'parse_query','invicta_handle_new_photos_filters' );

function invicta_handle_new_photos_filters($query) {
	
    global $pagenow;
    global $typenow;
    
    if ( $pagenow == 'edit.php' && $typenow == 'invicta_photos' ) {
        
        $filters = get_object_taxonomies( $typenow );
        
        foreach ($filters as $tax_slug) {
        	
            $var = &$query->query_vars[$tax_slug];
            
            if ( isset( $var ) && $var != 0 ) {
                $term = get_term_by( 'id', $var, $tax_slug );
                $var = $term->slug;
            }
            
        }
        
    }
	
}

/*
== ------------------------------------------------------------------- ==
== @@ List Sorting
== ------------------------------------------------------------------- ==
*/

add_action( 'manage_edit-invicta_photos_sortable_columns', 'invicta_handle_new_photos_sortable_columns' );

function invicta_handle_new_photos_sortable_columns( $columns ) {

	$columns['menu_order'] = 'menu_order';
	$columns['invicta_photos_category'] = 'invicta_photos_category';
	
	return $columns;
	
}
	
	
?>