<?php 
	
/*
== ------------------------------------------------------------------- ==
== @@ Post Type
== ------------------------------------------------------------------- ==
*/

add_action( 'init', 'invicta_videos_register' );

function invicta_videos_register() {
	
	global $smof_data;

	$icon = get_template_directory_uri() . '/styles/images/admin/videos.png';
	try {
		global $wp_version;
		if ( version_compare( $wp_version, '3.8') >= 0 ) {
			$icon = 'dashicons-format-video';
		}
	}
	catch( Exception $e ) {	
	}
	
	$register_post_type = true;
	$register_taxonomy = true;
	
	// registering VIDEO post type
	if ($register_post_type ) {
			
		$labels = array(
			'name'					=> __( 'Videos', 'invicta_dictionary' ),
			'singular_name'			=> __( 'Video', 'invicta_dictionary' ),
			'add_new' 				=> __( 'Add New', 'invicta_dictionary' ),
			'add_new_item' 			=> __( 'Add New Video', 'invicta_dictionary' ),
			'edit_item' 			=> __( 'Edit Video', 'invicta_dictionary' ),
			'new_item' 				=> __( 'New Video', 'invicta_dictionary' ),
			'all_items' 			=> __( 'All Videos', 'invicta_dictionary' ),
			'view_item' 			=> __( 'View Video', 'invicta_dictionary' ),
			'search_items' 			=> __( 'Search Videos', 'invicta_dictionary' ),
			'not_found' 			=> __( 'No Videos found', 'invicta_dictionary' ),
			'not_found_in_trash' 	=> __( 'No Videos found in Trash', 'invicta_dictionary' ),
			'parent_item_colon' 	=> '',
			'menu_name' 			=> __( 'Videos', 'invicta_dictionary'),
		);
		
		if ( isset( $smof_data['videos-slug'] ) && ! empty( $smof_data['videos-slug'] ) ) {
			$slug = $smof_data['videos-slug'];
		} 
		else {
			$slug = 'video';
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
			'supports' 				=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'comments' ),
			'rewrite'				=> array(
											'slug'			=> $slug,
											'with_front'	=> true
											)
		);
		
		register_post_type( 'invicta_videos', $args );
	
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
			'rewrite' 			=> true
		);
		
		register_taxonomy( 'invicta_videos_category', array('invicta_videos'), $args );
	
	}
		
}

/*
== ------------------------------------------------------------------- ==
== @@ Update Messages
== ------------------------------------------------------------------- ==
*/

add_filter( 'post_updated_messages', 'invicta_videos_update_messages' );

function invicta_videos_update_messages( $messages ) {
	
	global $post, $post_ID;
	
	$messages['invicta_videos'] = array(
		0 	=> '',
		1 	=> sprintf( __( 'Video updated. <a href="%s">View Video</a>', 'invicta_dictionary' ), esc_url( get_permalink($post_ID))),
		2 	=> __( 'Custom field updated.', 'invicta_dictionary' ),
		3 	=> __( 'Custom field deleted.', 'invicta_dictionary' ),
		4 	=> __( 'Video updated.', 'invicta_dictionary' ),
		5 	=> isset( $_GET['revision'] ) ? sprintf( __('Video restored to revision from %s', 'invicta_dictionary' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 	=> sprintf( __( 'Video published. <a href="%s">View Video</a>', 'invicta_dictionary' ), esc_url( get_permalink( $post_ID ) ) ),
		7 	=> __( 'Video saved.', 'invicta_dictionary' ),
		8 	=> sprintf( __( 'Video submitted. <a target="_blank" href="%s">Preview Video</a>', 'invicta_dictionary' ), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID) ) ) ),
		9 	=> sprintf( __( 'Video scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Video</a>', 'invicta_dictionary' ), date_i18n( __( 'M j, Y @ G:i' , 'invicta_dictionary' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		10 	=> sprintf( __( 'Video draft updated. <a target="_blank" href="%s">Preview Video</a>', 'invicta_dictionary' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	);
	
	return $messages;
}

/*
== ------------------------------------------------------------------- ==
== @@ List Columns
== ------------------------------------------------------------------- ==
*/

add_filter( 'manage_edit-invicta_videos_columns', 'invicta_add_new_videos_columns' );

function invicta_add_new_videos_columns( $columns ) {

	$new_columns['cb'] 							= '<input type="checkbox" />';
	$new_columns['video_thumbnail'] 			= __( 'Image', 'invicta_dictionary' );
	$new_columns['title'] 						= __( 'Title', 'invicta_dictionary' );
	$new_columns['invicta_videos_category'] 	= __( 'Categories', 'invicta_dictionary' );
	$new_columns['menu_order'] 					= __( 'Order', 'invicta_dictionary' );

	$columns = array_merge( $new_columns, $columns );
	
	return $columns;
	
}

add_action( 'manage_invicta_videos_posts_custom_column', 'invicta_handle_new_videos_columns', 10, 2 );

function invicta_handle_new_videos_columns( $column, $post_id ) {

	global $post;
	
	switch ( $column ) {
			
		case 'video_thumbnail':
		
			if ( has_post_thumbnail( $post_id ) ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail' );
			}
			else {
				$external_image = get_post_meta( $post_id, '_invicta_video_video_thumbnail', true );
				if ( $external_image ) {
					echo '<img src="' . get_post_meta( $post_id, '_invicta_video_video_thumbnail', true ) . '" />';
				}
			}
			
			break;
			
		case 'invicta_videos_category':
		
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

add_action( 'restrict_manage_posts', 'invicta_add_new_videos_filters' );

function invicta_add_new_videos_filters() {
	
	global $typenow;
	
	if ($typenow == 'invicta_videos') :
	
		// portfolio categories
		
		$tax_obj = get_taxonomy('invicta_videos_category');	
		$selected_tax = ( isset( $_GET[ $tax_obj->query_var ] ) ) ? $_GET[ $tax_obj->query_var ] : 0;
		
		if ( ! is_numeric ( $selected_tax ) ) {
			$selected_tax_obj = get_term_by( 'slug', $selected_tax, 'invicta_videos_category' );
			$selected_tax = $selected_tax_obj->term_id;
		}
		
		wp_dropdown_categories(array(
			'show_option_all' 	=> __( 'Show All', 'invicta_dictionary' ) . ' ' . $tax_obj->label,
			'taxonomy' 			=> 'invicta_videos_category',
			'name' 				=> $tax_obj->name,
			'orderby' 			=> 'name',
			'selected' 			=> $selected_tax,
			'hierarchical' 		=> $tax_obj->hierarchical,
			'show_count' 		=> true,
			'hide_empty' 		=> false
		));
	
	endif;
	
}

add_filter( 'parse_query','invicta_handle_new_videos_filters' );

function invicta_handle_new_videos_filters($query) {
	
    global $pagenow;
    global $typenow;
    
    if ( $pagenow == 'edit.php' && $typenow == 'invicta_videos' ) {
        
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

add_action( 'manage_edit-invicta_videos_sortable_columns', 'invicta_handle_new_videos_sortable_columns' );

function invicta_handle_new_videos_sortable_columns( $columns ) {

	$columns['menu_order'] = 'menu_order';
	$columns['invicta_videos_category'] = 'invicta_videos_category';
	
	return $columns;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Metaboxes - Portfolio Project
== ------------------------------------------------------------------- ==
*/

add_action( 'admin_init', 'invicta_add_video_metaboxes' );

function invicta_add_video_metaboxes() {

	// Video Details
		
	$args = array(
		'id'			=> '_invicta_video',
		'title' 		=> __( 'Video', 'invicta_dictionary' ),
		'post_types' 	=> array( 'invicta_videos' ),
		'context' 		=> 'normal',
		'priority'		=> 'high',
		'fields'		=> array(
			array(
				'id' 			=> '_invicta_video_video_url',
				'name' 			=> __( 'Video URL', 'invicta_dictionary' ),
				'description'	=> __( "Specify the Vimeo or Youtube video URL", 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'text'
			),
			array(
				'id' 			=> '_invicta_video_video_thumbnail',
				'name' 			=> '',
				'description'	=> '',
				'default'		=> '',
				'type'			=> 'image-preview'
			),
		)
	);
		
	new invicta_metabox( $args );

}


/*
== ------------------------------------------------------------------- ==
== @@ Filter video saving
== ------------------------------------------------------------------- ==
*/	

add_filter( 'wp_insert_post_data', 'invicta_filter_video_saving', '99', 2 );

function invicta_filter_video_saving( $data , $postarr ) {

	try {
	
		if ( isset( $postarr ) && isset( $postarr['ID'] ) && isset( $postarr['_invicta_video_video_url'] ) ) {
	
			$meta_id = '_invicta_video_video_thumbnail';
			$post_id = $postarr['ID'];
			$video_url = $postarr['_invicta_video_video_url'];
			
			if ( $video_url ) {
				$video_thumbnail = invicta_get_thumbnail_from_external_video( $video_url );
				update_post_meta( $post_id, $meta_id, $video_thumbnail );
			}
		
		}
	
	} catch (Exception $e) {}
	
	return $data;

}
	
?>