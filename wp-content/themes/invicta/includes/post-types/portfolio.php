<?php 

/*
== ------------------------------------------------------------------- ==
== @@ Post Type
== ------------------------------------------------------------------- ==
*/

add_action( 'init', 'invicta_portfolio_register' );

function invicta_portfolio_register() {

	global $smof_data;
	
	$icon = get_template_directory_uri() . '/styles/images/admin/portfolio.png';
	try {
		global $wp_version;
		if ( version_compare( $wp_version, '3.8') >= 0 ) {
			$icon = 'dashicons-portfolio';
		}
	}
	catch( Exception $e ) {	
	}
	
	$register_post_type = true;
	$register_taxonomy = true;

	// registering PORTFOLIO post type
	if ($register_post_type ) {
	
		$labels = array(
			'name'					=> __( 'Portfolio', 'invicta_dictionary' ),
			'singular_name'			=> __( 'Project', 'invicta_dictionary' ),
			'add_new' 				=> __( 'Add New', 'invicta_dictionary' ),
			'add_new_item' 			=> __( 'Add New Project', 'invicta_dictionary' ),
			'edit_item' 			=> __( 'Edit Project', 'invicta_dictionary' ),
			'new_item' 				=> __( 'New Project', 'invicta_dictionary' ),
			'all_items' 			=> __( 'All Projects', 'invicta_dictionary' ),
			'view_item' 			=> __( 'View Project', 'invicta_dictionary' ),
			'search_items' 			=> __( 'Search Projects', 'invicta_dictionary' ),
			'not_found' 			=> __( 'No projects found', 'invicta_dictionary' ),
			'not_found_in_trash' 	=> __('No projects found in Trash', 'invicta_dictionary' ),
			'parent_item_colon' 	=> '',
			'menu_name' 			=> __('Portfolio', 'invicta_dictionary'),
		);
		
		if ( isset( $smof_data['portfolio-slug'] ) && ! empty( $smof_data['portfolio-slug'] ) ) {
			$slug = $smof_data['portfolio-slug'];
		} 
		else {
			$slug = 'porfolio-project';
		}
		
		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'show_ui'				=> true,
			'show_in_menu' 			=> true, 
			'show_in_nav_menus'		=> true,
			'menu_position' 		=> 5,
			'menu_icon'				=> $icon,
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
		
		register_post_type( 'invicta_portfolio', $args );
	
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
		
		register_taxonomy( 'invicta_portfolio_category', array('invicta_portfolio'), $args );
	
	}
	
	// registering SKILL taxonomy
	if ( $register_taxonomy ) {
	
		$labels = array(
			'name' 							=> __('Skills', 'invicta_dictionary'),
			'singular_name' 				=> __('Skill', 'invicta_dictionary'),
			'search_items' 					=>  __('Search Skills', 'invicta_dictionary'),
			'popular_items' 				=> __('Popular Skills', 'invicta_dictionary'),
			'all_items' 					=> __('All Skills', 'invicta_dictionary'),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> __('Edit Skill', 'invicta_dictionary'), 
			'update_item' 					=> __('Update Skill', 'invicta_dictionary'),
			'add_new_item' 					=> __('Add New Skill', 'invicta_dictionary'),
			'new_item_name' 				=> __('New Skill Name', 'invicta_dictionary'),
			'separate_items_with_commas' 	=> __('Separate skills with commas', 'invicta_dictionary'),
			'add_or_remove_items' 			=> __('Add or remove skills', 'invicta_dictionary'),
			'choose_from_most_used' 		=> __('Choose from the most used skills', 'invicta_dictionary'),
			'menu_name' 					=> __('Skills', 'invicta_dictionary')
		);
		
		$args = array(
			'labels' 				=> $labels,
			'hierarchical' 			=> false,
			'show_ui' 				=> true,
			'show_in_nav_menus'		=> false,
			'update_count_callback' => '_update_post_term_count',
			'query_var' 			=> true,
			'rewrite' 				=> true
		);
		
		register_taxonomy( 'invicta_portfolio_skill', array('invicta_portfolio'), $args );
	
	}
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Update Messages
== ------------------------------------------------------------------- ==
*/

add_filter( 'post_updated_messages', 'invicta_portfolio_update_messages' );

function invicta_portfolio_update_messages( $messages ) {
	
	global $post, $post_ID;
	
	$messages['invicta_portfolio'] = array(
		0 	=> '',
		1 	=> sprintf( __( 'Project updated. <a href="%s">View Project</a>', 'invicta_dictionary' ), esc_url( get_permalink($post_ID))),
		2 	=> __( 'Custom field updated.', 'invicta_dictionary' ),
		3 	=> __( 'Custom field deleted.', 'invicta_dictionary' ),
		4 	=> __( 'Project updated.', 'invicta_dictionary' ),
		5 	=> isset( $_GET['revision'] ) ? sprintf( __('Project restored to revision from %s', 'invicta_dictionary' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 	=> sprintf( __( 'Project published. <a href="%s">View project</a>', 'invicta_dictionary' ), esc_url( get_permalink( $post_ID ) ) ),
		7 	=> __( 'Project saved.', 'invicta_dictionary' ),
		8 	=> sprintf( __( 'Project submitted. <a target="_blank" href="%s">Preview project</a>', 'invicta_dictionary' ), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID) ) ) ),
		9 	=> sprintf( __( 'Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>', 'invicta_dictionary' ), date_i18n( __( 'M j, Y @ G:i' , 'invicta_dictionary' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		10 	=> sprintf( __( 'Project draft updated. <a target="_blank" href="%s">Preview project</a>', 'invicta_dictionary' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	);
	
	return $messages;
}


/*
== ------------------------------------------------------------------- ==
== @@ List Columns
== ------------------------------------------------------------------- ==
*/

add_filter( 'manage_edit-invicta_portfolio_columns', 'invicta_add_new_portfolio_columns' );

function invicta_add_new_portfolio_columns( $columns ) {

	$new_columns['cb'] 							= '<input type="checkbox" />';
	$new_columns['portfolio_thumbnail'] 		= __( 'Image', 'invicta_dictionary' );
	$new_columns['title'] 						= __( 'Title', 'invicta_dictionary' );
	$new_columns['invicta_portfolio_category'] 	= __( 'Categories', 'invicta_dictionary' );
	$new_columns['invicta_portfolio_skill'] 	= __( 'Skills', 'invicta_dictionary' );
	$new_columns['menu_order'] 					= __( 'Order', 'invicta_dictionary' );

	$columns = array_merge( $new_columns, $columns );
	
	return $columns;
	
}

add_action( 'manage_invicta_portfolio_posts_custom_column', 'invicta_handle_new_portfolio_columns', 10, 2 );

function invicta_handle_new_portfolio_columns( $column, $post_id ) {

	global $post;
	
	switch ( $column ) {
	
		case 'portfolio_thumbnail':
		
			if ( has_post_thumbnail( $post_id ) ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail' );
			}
			
			break;
			
		case 'invicta_portfolio_category':
		
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
			
		case 'invicta_portfolio_skill':
		
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

add_action( 'restrict_manage_posts', 'invicta_add_new_portfolio_filters' );

function invicta_add_new_portfolio_filters() {
	
	global $typenow;
	
	if ($typenow == 'invicta_portfolio') :
	
		// portfolio categories
		
		$tax_obj = get_taxonomy('invicta_portfolio_category');	
		$selected_tax = ( isset( $_GET[ $tax_obj->query_var ] ) ) ? $_GET[ $tax_obj->query_var ] : 0;
		
		if ( ! is_numeric ( $selected_tax ) ) {
			$selected_tax_obj = get_term_by( 'slug', $selected_tax, 'invicta_portfolio_category' );
			$selected_tax = $selected_tax_obj->term_id;
		}
		
		wp_dropdown_categories(array(
			'show_option_all' 	=> __( 'Show All', 'invicta_dictionary' ) . ' ' . $tax_obj->label,
			'taxonomy' 			=> 'invicta_portfolio_category',
			'name' 				=> $tax_obj->name,
			'orderby' 			=> 'name',
			'selected' 			=> $selected_tax,
			'hierarchical' 		=> $tax_obj->hierarchical,
			'show_count' 		=> true,
			'hide_empty' 		=> false
		));

		// portfolio skills
		
		$tax_obj = get_taxonomy('invicta_portfolio_skill');	
		$selected_tax = ( isset( $_GET[ $tax_obj->query_var ] ) ) ? $_GET[ $tax_obj->query_var ] : 0;
		
		if ( ! is_numeric( $selected_tax )) {
			$selected_tax_obj = get_term_by('slug', $selected_tax, 'invicta_portfolio_skill');
			$selected_tax = $selected_tax_obj->term_id;
		}
		
		wp_dropdown_categories(array(
			'show_option_all' 	=> __( 'Show All', 'invicta_dictionary' ) . ' ' . $tax_obj->label,
			'taxonomy' 			=> 'invicta_portfolio_skill',
			'name' 				=> $tax_obj->name,
			'orderby' 			=> 'name',
			'selected' 			=> $selected_tax,
			'hierarchical' 		=> $tax_obj->hierarchical,
			'show_count' 		=> true,
			'hide_empty' 		=> false
		));
	
	endif;
	
}

add_filter( 'parse_query','invicta_handle_new_portfolio_filters' );

function invicta_handle_new_portfolio_filters($query) {
	
    global $pagenow;
    global $typenow;
    
    if ( $pagenow == 'edit.php' && $typenow == 'invicta_portfolio' ) {
        
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

add_action( 'manage_edit-invicta_portfolio_sortable_columns', 'invicta_handle_new_sortable_columns' );

function invicta_handle_new_sortable_columns( $columns ) {

	$columns['menu_order'] = 'menu_order';
	$columns['invicta_portfolio_category'] = 'invicta_portfolio_category';
	$columns['invicta_portfolio_skill'] = 'invicta_portfolio_skill';
	
	return $columns;
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Metaboxes - Portfolio Project
== ------------------------------------------------------------------- ==
*/

add_action( 'admin_init', 'invicta_add_portfolio_metaboxes' );

function invicta_add_portfolio_metaboxes() {

	// Project Details
		
	$args = array(
		'id'			=> '_invicta_portfolio_details',
		'title' 		=> __( 'Project Details', 'invicta_dictionary' ),
		'post_types' 	=> array( 'invicta_portfolio' ),
		'context' 		=> 'normal',
		'priority'		=> 'default',
		'fields'		=> array(
			array(
				'id' 			=> '_invicta_portfolio_details_project_price',
				'name' 			=> __( 'Project Price', 'invicta_dictionary' ),
				'description'	=> __( "The price that this project costed", 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'text'
			),
			array(
				'id' 			=> '_invicta_portfolio_details_project_url',
				'name' 			=> __( 'Project URL', 'invicta_dictionary' ),
				'description'	=> __( "The URL of this project so users can check it directly", 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'text'
			),
			array(
				'id' 			=> '_invicta_portfolio_details_client_name',
				'name' 			=> __( 'Client Name', 'invicta_dictionary' ),
				'description'	=> __( "The name of those who this work was made for", 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'text'
			),
			array(
				'id' 			=> '_invicta_portfolio_details_client_url',
				'name' 			=> __( 'Client Website', 'invicta_dictionary' ),
				'description'	=> __( "The website url of those who this work was made for", 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'text'
			),
			array(
				'id' 			=> '_invicta_portfolio_details_extra_key',
				'name' 			=> __( 'Extra Field (Name)', 'invicta_dictionary' ),
				'description'	=> __( "The name of an extra field you need", 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'text'
			),
			array(
				'id' 			=> '_invicta_portfolio_details_extra_value',
				'name' 			=> __( 'Extra Field (Value)', 'invicta_dictionary' ),
				'description'	=> __( "The value of an extra field you need", 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'text'
			)
		)
	);
	
	new invicta_metabox( $args );
	
	// Project Layout
	
	$project_layouts = array(
		'automatic' => __( 'Automatic', 'invicta_dictionary' ),
		'condensed' => __( 'Condensed', 'invicta_dictionary' ),
		'extended' 	=> __( 'Extended', 'invicta_dictionary' )
	);
	
	$args = array(
		'id'			=> '_invicta_portfolio_layout',
		'title' 		=> __( 'Project Layout', 'invicta_dictionary' ),
		'post_types' 	=> array( 'invicta_portfolio' ),
		'context' 		=> 'side',
		'priority'		=> 'default',
		'fields'		=> array(
			array(
				'id' 			=> '_invicta_portfolio_layout_layout',
				'name' 			=> __( 'Layout', 'invicta_dictionary' ),
				'description'	=> __( 'Select the layout of the project<i>The Condensed layout is recommended for projects with short descriptions (main text)</i><i>If "Automatic" is set, the theme will decide which is the best layout for this project.</i>', 'invicta_dictionary' ),
				'default'		=> 'automatic',
				'type'			=> 'select',
				'options'		=> $project_layouts
			),
		)
	);
	
	new invicta_metabox( $args );

}


/*
== ------------------------------------------------------------------- ==
== @@ Metaboxes - Portfolio Page Template
== ------------------------------------------------------------------- ==
*/

add_action('admin_init', 'invicta_add_portfolio_page_metaboxes' );

function invicta_add_portfolio_page_metaboxes() {
	
	// drop down values
	
	$column_layouts = array(
		'columns_2' => __( '2 Columns', 'invicta_dictionary' ),
		'columns_3' => __( '3 Columns', 'invicta_dictionary' ),
		'columns_4' => __( '4 Columns', 'invicta_dictionary' ),
	);
	
	$boolean_options = array(
		'true' => __( 'Yes', 'invicta_dictionary' ),
		'false' => __( 'No', 'invicta_dictionary' ),
	);
	
	$page_sizes = array();
	$page_size['-1'] = __( 'All', 'invicta_dictionary' );
	for ( $i = 1; $i <= 24; $i ++ ) {
		$page_size[ $i ] = $i;
	}
	
	$categories = array();
	$categories['-1'] = __( 'All', 'invicta_dictionary' );
	foreach ( get_terms( 'invicta_portfolio_category') as $category ) {
		$categories[ $category->term_id ] = $category->name;
	}
	
	$linking = array(
		'1' => __( 'Open the single project page', 'invicta_dictionary' ),
		'2' => __( 'Display the featured image in a lightbox', 'invicta_dictionary' ),
	);
	
	$metadata = array(
		'-1' 			=> __( 'Nothing', 'invicta_dictionary' ),
		'date' 			=> __( 'The project date', 'invicta_dictionary' ),
		'categories' 	=> __( 'The project categories', 'invicta_dictionary' ),
	);
	
	// metabox arguments
	
	$args = array(
		'id'			=> '_invicta_portfolio_page_settings',	// if this ID needs to be changed, invicta.admin.js must be adjusted
		'title' 		=> __( 'Portfolio Settings', 'invicta_dictionary' ),
		'post_types' 	=> array( 'page' ),
		'context' 		=> 'normal',
		'priority'		=> 'high',
		'fields'		=> array(
			array(
				'id' 			=> '_invicta_portfolio_page_settings_layout',
				'name' 			=> __( 'Columns Layout', 'invicta_dictionary' ),
				'description'	=> __( 'Select the desired Columns layout', 'invicta_dictionary' ),
				'default'		=> 'columns_3',
				'type'			=> 'select',
				'options'		=> $column_layouts
			),
			array(
				'id' 			=> '_invicta_portfolio_page_settings_pagesize',
				'name' 			=> __( 'Projects per page', 'invicta_dictionary' ),
				'description'	=> __( 'How many projects should be displayed per page?', 'invicta_dictionary' ),
				'default'		=> '',
				'type'			=> 'select',
				'options'		=> $page_size
			),
			array(
				'id' 			=> '_invicta_portfolio_page_settings_sortable',
				'name' 			=> __( 'Sortable', 'invicta_dictionary' ),
				'description'	=> __( 'Should the sorting options based on categories be displayed?', 'invicta_dictionary' ),
				'default'		=> 'true',
				'type'			=> 'select',
				'options'		=> $boolean_options
			),
			array(
				'id' 			=> '_invicta_portfolio_page_settings_categories',
				'name' 			=> __( 'Categories', 'invicta_dictionary' ),
				'description'	=> __( 'Which categories should be used for the portfolio?', 'invicta_dictionary' ),
				'default'		=> '-1',
				'type'			=> 'select-multiple',
				'options'		=> $categories
			),
			array(
				'id' 			=> '_invicta_portfolio_page_settings_linking',
				'name' 			=> __( 'Link Handling', 'invicta_dictionary' ),
				'description'	=> __( 'What do you want to happen when a portfolio item is clicked?', 'invicta_dictionary' ),
				'default'		=> 1,
				'type'			=> 'select',
				'options'		=> $linking
			),
			array(
				'id' 			=> '_invicta_portfolio_page_settings_metadata',
				'name' 			=> __( 'Metadata', 'invicta_dictionary' ),
				'description'	=> __( 'What extra info do you want to show with the project title?', 'invicta_dictionary' ),
				'default'		=> 'date',
				'type'			=> 'select',
				'options'		=> $metadata
			),
		)
	);
	
	// metabox creation

	new invicta_metabox($args);

}
	
?>