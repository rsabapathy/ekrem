<?php 

/*
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==

FUNCTIONS TITLE: 
	Invicta - Logic
		
FUNCTIONS AUTHOR: 
	Oitentaecinco

FUNCTIONS INDEX:

	@@ Get Sorting Parameters
	@@ Portfolio Entry Details
	@@ Portfolio - Get Categories on projects
	@@ Photo Galleries - Get Ajusted Gallery Content
	@@ Videos - Extract Video from Post
	
	@@ Get Active Icons
	@@ Truncate String
	@@ Colors
	
	
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/

/*
== ------------------------------------------------------------------- ==
== @@ Get Sorting Parameters (Portfolio, Photos, Videos)
== ------------------------------------------------------------------- ==
*/

function invicta_get_sorting_parameters_on_custom_post_types( $type ) {
	
	global $smof_data;
	
	$sort_params['orderby'] = 'date';
	$sort_params['order'] = 'DESC';
	
	if ( $type == 'portfolio' || $type == 'photos' || $type == 'videos' ) {
	
		if ( isset( $smof_data[ $type . '-sort' ] ) ) {
			
			$sort_splitted = explode( '-', $smof_data[ $type . '-sort' ] );
			
			if ( sizeof( $sort_splitted ) == 2 ) {
				$sort_params['orderby'] = $sort_splitted[0];
				$sort_params['order'] = $sort_splitted[1];
			}
			
		}
	
	}
	
	return $sort_params;
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Portfolio Entry Details
== ------------------------------------------------------------------- ==
*/
	
function invicta_get_portfolio_entry_details( $full_info, $single_page, $linking_type, $metadata_type ) {

	global $smof_data;
	global $post;
	
	$project_info = array();
	
	
	// thumbnail ------------------------------------------
	
	if ( $single_page === true ) {
		$photo_width = PORTFOLIO_DETAILS__PHOTO_WIDTH;
		$photo_height = PORTFOLIO_DETAILS__PHOTO_HEIGHT;
	}
	else {
		$photo_width = PORTFOLIO_LIST__PHOTO_WIDTH;
		$photo_height = PORTFOLIO_LIST__PHOTO_HEIGHT;
	}
	
	$project_info['thumbnail'] = invicta_project_featured_image( $linking_type, $photo_width, $photo_height );
	
	$project_info['link'] = '';
	
	if ( $linking_type == 1 ) { // Open the single project page
		$project_info['link'] = get_permalink( $post->ID );
	}
	elseif ( $linking_type == 2 ) { // Display the featured image in a lightbox
		$project_info['link'] = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
		wp_enqueue_script('invicta_fancybox');
	}
	
	
	// title ------------------------------------------
	
	$project_info['title'] = get_the_title();
	
	
	// date ------------------------------------------
	
	$project_info['date'] = get_the_date( $smof_data['portfolio-date_format'] );
	
	
	// categories ------------------------------------------
	
	$project_info['categories'] = __( 'Uncategorized', 'invicta_dictionary' );
	$project_info['category_slugs'] = '';
	
	foreach ( wp_get_post_terms( $post->ID, 'invicta_portfolio_category' ) as $category ) {
		$categories[] = $category->name;
		$category_slugs[] = esc_attr( $category->slug );
	}
	
	if ( isset( $categories ) && ! empty( $categories ) ) {
		$project_info['categories'] = join( ', ' , $categories );
	}
	
	if ( isset( $category_slugs ) && ! empty( $category_slugs ) ) {
		$project_info['category_slugs'] = ' ' . join( ' ' , $category_slugs );
	}
		
	
	// metadata type ------------------------------------------
	
	if ( $metadata_type == 'date' ) {
		$project_info['metadata'] = $project_info['date'];
	}
	elseif ( $metadata_type == 'categories' ) {
		$project_info['metadata'] = $project_info['categories'];
	}
	else {
		$project_info['metadata'] = '';
	}
	
	
	if ( $full_info ) {
	
		// content ------------------------------------------
		
		$project_info['content']	= ( ( $post->post_excerpt == '' ) || ( is_single() ) ) ? get_the_content( __( "Read more", "invicta_dictionary" ) ) : get_the_excerpt();
		
		
		// skills ------------------------------------------
		
		$project_info['skills'] = wp_get_post_terms( $post->ID, 'invicta_portfolio_skill' );
		
		
		// url ------------------------------------------
		
		$project_info['url'] = get_post_meta( $post->ID, '_invicta_portfolio_details_project_url', true );
		
		
		// price ------------------------------------------
		
		$project_info['price'] = get_post_meta( $post->ID, '_invicta_portfolio_details_project_price', true );
		
		
		// extra values ------------------------------------------
		
		$project_info['extra_field_key'] = get_post_meta( $post->ID, '_invicta_portfolio_details_extra_key', true );
		$project_info['extra_field_value'] = get_post_meta( $post->ID, '_invicta_portfolio_details_extra_value', true );
		
		
		// social sharing ------------------------------------------
		
		if ( $smof_data['portfolio-share-twitter'] || $smof_data['portfolio-share-facebook'] ) {
			$project_info['social'] = true;
		}
		else {
			$project_info['social'] = false;
		}
		
		
		// setup client info ------------------------------------------
		
		$client_name = get_post_meta( $post->ID, '_invicta_portfolio_details_client_name', true );
		$client_url = get_post_meta( $post->ID, '_invicta_portfolio_details_client_url', true );
		
		$project_info['client'] = '';
		
		if ( $client_name ) {
			if ( $client_url ) {
				$project_info['client'] = '<a href="' . esc_url( $client_url ) . '" target="_blank">' . $client_name . '</a>';
			}
			else {
				$project_info['client'] = $client_name;
			}
		}
		else {
			if ( $client_url ) {
				$project_info['client'] = '<a href="' . esc_url( $client_url ) . '" target="_blank">' . $client_url . '</a>';
			}
		}
		
		
		// layout setup ------------------------------------------
		
		$project_info['layout'] = get_post_meta( $post->ID, '_invicta_portfolio_layout_layout', true );
		
		if ( empty( $project_info['layout'] ) || $project_info['layout'] == 'automatic' ) {
		
			$average_line_length = 30;
			$max_length = 350;
			
			if ( ! preg_match('!<img!', $project_info['content']) ) {
			
				$used_length = strlen( $project_info['content'] );
			
				if ( $project_info['date'] ) 		{ $used_length = $used_length + $average_line_length; }
				if ( $project_info['categories'] ) 	{ $used_length = $used_length + $average_line_length; }
				if ( $project_info['url'] ) 		{ $used_length = $used_length + $average_line_length; }
				if ( $project_info['price'] ) 		{ $used_length = $used_length + $average_line_length; }
				if ( $project_info['client'] ) 		{ $used_length = $used_length + $average_line_length; }
				if ( $project_info['skills'] ) 		{ $used_length = $used_length + ( sizeof( $project_info['skills'] ) * $average_line_length ); }
			
				if ( $used_length > $max_length ) {
					$project_info['layout'] = 'extended';
				} 
				else {
					$project_info['layout'] = 'condensed';
				}
			
			}
			else {
				$project_info['layout'] = 'extended';
			}
		}
		
		
		// content filtering ------------------------------------------
		
		$project_info['content'] = str_replace(']]>', ']]&gt;', apply_filters('the_content', $project_info['content'] ));
		
	
	}
	
	return $project_info;
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Portfolio - Get Categories on projects
== ------------------------------------------------------------------- ==
*/

function invicta_get_categories_on_portolio_posts( $posts, $accepted_categories = '' ) {

	// Retrieves an array of terms (portfolio-category) referenced in any of the given portfolio posts
	
	$categories = array();

	foreach ( $posts as $project ) {
		
		$project_categories = wp_get_post_terms( $project->ID, 'invicta_portfolio_category' );
		
		if ( $accepted_categories ) {
					
			foreach ( $project_categories as $category ) {
				if ( in_array( $category->term_id, $accepted_categories ) ) {
					$categories[ $category->slug ] = $category->name;
				}
			}
			
		}
		else {
			
			foreach ( $project_categories as $category ) {
				$categories[ $category->slug ] = $category->name;
			}			
			
		}
		
	}
	
	// lets order the categories alphabetically
	asort($categories);
	
	return $categories;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Photo Galleries - Get Ajusted Gallery Content
== ------------------------------------------------------------------- ==
*/

function invicta_get_adjusted_photo_gallery_content() {

	global $smof_data;
	global $post;
	
	$columns = $smof_data['photos-columns'];
	$behavior = $smof_data['photos-behavior'];
	
	$post_content = get_the_content();
	
	// get photo IDs
	
	$photo_ids = array();
	
	if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $post_content, $matches ) ) {
		
		$gallery_shortcodes = array();
		for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
			if ( $matches[2][$i] == 'gallery' ) {
				$gallery_shortcodes[] = $matches[0][$i];
			}
		}
		
		foreach ( $gallery_shortcodes as $shortcode ) {
			if ( preg_match( '/ids="(.*?)"/s', $shortcode, $matches ) ) { 
				
				$ids = explode( ',' , $matches[1] );
				
				for ( $i = 0; $i < count( $ids ); $i ++ ) {
					$photo_ids[] = $ids[$i];
				}
				
			}
		}
		
	}
	
	$output = '';
	
	if ( $photo_ids ) {
	
		$guid = 'photoslider_' . uniqid();
		
		$output .= '<section id="' . $guid . '" class="invicta_photoslider">';
		
		// first photo
		
		$attachment = get_post($photo_ids[ 0 ]);
		
		$image_url = wp_get_attachment_url( $photo_ids[ 0 ] );
		$image_alt = get_post_meta( $photo_ids[ 0 ], '_wp_attachment_image_alt', true );
		
		if ( empty( $image_alt ) ) { 
			$image_alt = $attachment->post_excerpt; 
		}
		
		$output .= '<div class="stage">';
		$output .=		'<img id="main_image" src="' . $image_url .'" alt="' . esc_attr( $image_alt ) . '" />';
		$output .= '</div>';
		
		if ( count( $photo_ids ) ) {
		
			$output .= '<div class="thumbnails">';
		
			for ( $i = 0; $i < count( $photo_ids ); $i ++ ) {
			
				$image_url = wp_get_attachment_url( $photo_ids[ $i ] );
				if ( $resized_image_url = aq_resize( $image_url, 690, 500, true, true, false ) ) {
					$image_url = $resized_image_url;
				}
						
				$output .= '<a href="' . $image_url . '" class="thumb">';
				$output .= wp_get_attachment_image( $photo_ids[ $i ], 'thumbnail' );
				$output .= '</a>';
				
			}
			
			$output .= '</div>';
		
		}
		
		$output .= '<script type="text/javascript">';
		$output .=		'jQuery(function($){';
		$output .=			'$("#' . $guid . '").invicta_photoslider({';
		$output .= 			'});';
		$output .= 		'});';
		$output .= '</script>';
		
		$output .= '</section>';
		
	}
	
	return $output;
	
}

function invicta_get_adjusted_photo_gallery_content_mosaic() {

	global $smof_data;
	global $post;
	
	$columns = $smof_data['photos-columns'];
	$behavior = $smof_data['photos-behavior'];
	
	$post_content = get_the_content();
	
	// override LinkTo setting in all available galleries
	
	if ( $behavior != 'default' ) {
	
		if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $post_content, $matches ) ) {
	
			$gallery_shortcodes = array();
			
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				if ( $matches[2][$i] == 'gallery' ) {
					$gallery_shortcodes[] = $matches[0][$i];
				}
			}
			
			foreach ( $gallery_shortcodes as $shortcode ) {
				if ( preg_match( '/link="(.*?)"/s', $shortcode, $matches ) ) {
					$post_content = str_replace( $matches[0], 'link="' . $behavior . '"', $post_content);
				}
				else {
					$original_shortcode = $shortcode;
					$modified_shortcode = str_replace( '[gallery', '[gallery link="' . $behavior . '"', $shortcode);
					$post_content = str_replace( $original_shortcode, $modified_shortcode, $post_content );
				}	
			}
			
		}
		
	}
	
	
	// override Columns setting in all available galleries
	
	if ( $columns && is_numeric( $columns ) ) {
	
		if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $post_content, $matches ) ) {
	
			$gallery_shortcodes = array();
			
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				if ( $matches[2][$i] == 'gallery' ) {
					$gallery_shortcodes[] = $matches[0][$i];
				}
			}
			
			foreach ( $gallery_shortcodes as $shortcode ) {
				if ( preg_match( '/columns="(.*?)"/s', $shortcode, $matches ) ) {
					$post_content = str_replace( $matches[0], 'columns="' . $columns . '"', $post_content);
				}
				else {
					$original_shortcode = $shortcode;
					$modified_shortcode = str_replace( '[gallery', '[gallery columns="' . $columns . '"', $shortcode);
					$post_content = str_replace( $original_shortcode, $modified_shortcode, $post_content );
				}	
			}
			
		}
	
	}
	
	$post_content = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $post_content ) );
	
	return $post_content;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Videos - Extract Video from Post
== ------------------------------------------------------------------- ==
*/

function invicta_get_video_from_post( $post, $do_shortcode = false ) {

	$video = '';
	
	$video_url = esc_url( get_post_meta( $post->ID, '_invicta_video_video_url', true ) );
	
	if ( invicta_is_youtube_url( $video_url ) || invicta_is_vimeo_url( $video_url ) ) {
	
		if ( $video_url ) {
			$video = '[embed]' . $video_url . '[/embed]';	
			if ( $do_shortcode ) {
				global $wp_embed;
				$video = do_shortcode( $wp_embed->run_shortcode( $video ) );
			}
		}
	
	}
	
	return $video;
		
}

/*
== ------------------------------------------------------------------- ==
== @@ Get Active Icons
== ------------------------------------------------------------------- ==
*/
	
function invicta_get_active_icons() {
	
	global $smof_data;
	
	$active_icons = array();
	
	foreach ( $smof_data as $key => $value ) {
		
		if ( strpos( $key , 'icons') === 0 && $key != 'icons-info') {
			
			if ( $value ) {
				$icon_name = str_replace( 'icons-', '', $key );
				$icon_name = str_replace( '_', '-', $icon_name );
				$active_icons[] = $icon_name;
			}
			
		}
		
	}
	
	if ( $smof_data['i_icons-extra_icons'] ) {	
		$extra_icons = preg_split("/\\r\\n|\\r|\\n/", $smof_data['i_icons-extra_icons'] );
		$active_icons = array_merge( $active_icons, $extra_icons );
	}
	
	if ( ! $active_icons ) {
		$active_icons[] = 'icon-circle';
	}
	
	$active_icons = apply_filters( 'invicta_active_icons', $active_icons );
	
	return $active_icons;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Truncate String
== ------------------------------------------------------------------- ==
*/

function invicta_truncate_string( $string, $limit, $break = '.', $pad = '...', $strip_clean = false, $excluded_tags = '<strong><em><span>') {
	
	if($strip_clean) {
		$string = strip_shortcodes( strip_tags( $string, $excludetags ) );
	}

	if( strlen( $string ) <= $limit ) {
		return $string;
	}
	
	if ( false !== ( $breakpoint = strpos( $string, $break, $limit ) ) ) { 
		if( $breakpoint < strlen( $string ) - 1) { 
			$string = substr( $string, 0, $breakpoint ) . $pad;
		} 
	} 
	
	if( ! $breakpoint && strlen( strip_tags( $string ) ) == strlen( $string ) ) {
		$string = substr( $string, 0, $limit ) . $pad; 
	}
	
	return $string; 
}

/*
== ------------------------------------------------------------------- ==
== @@ Colors
== ------------------------------------------------------------------- ==
*/

function invicta_get_color_variation( $hex, $steps ) {
	
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max( -255, min( 255, $steps ) );
	
	// Format the hex color string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}
	
	// Get decimal values
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );
	
	// Adjust number of steps and keep it inside 0 to 255
	$r = max( 0, min( 255, $r + $steps ) );
	$g = max( 0, min( 255, $g + $steps ) ); 
	$b = max( 0, min( 255, $b + $steps ) );
	
	$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT);
	$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT);
	$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT);
	
	return '#' . $r_hex . $g_hex . $b_hex;
	
}

function invicta_get_color_rgba( $hex, $alpha = 1 ) {
	
	// Format the hex color string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}
	
	// Get decimal values
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );
	
	return 'rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $alpha . ')';
	
}

function invicta_get_color_rgb( $hex ) {
	
	// Format the hex color string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}
	
	// Get decimal values
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );
	
	return 'rgb(' . $r . ', ' . $g . ', ' . $b . ')';
	
}
	
?>