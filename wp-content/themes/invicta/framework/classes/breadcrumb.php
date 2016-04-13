<?php 
	
class invicta_breadcrumb {

	private $settings;
	
	public function __construct( $args ) { 
		
		$this->settings = wp_parse_args($args, array(
			'separator'				=> '/',
			'before'				=> __( 'You are here:', 'invicta_dictionary' ),
			'after'					=> '',
			'front_page_visible'	=> true,
			'home_node'				=> __( 'Home', 'invicta_dictionary'),
			'show_posts_page' 		=> true,
			'truncate'				=> 70,
			'richsnippet'			=> false
		));	
		
	}
	
	public function get_html() {
	
		global $wp_query;
		global $wp_rewrite;
		
		// allow singular post views to have a taxonomy's terms prefixing the trail
		if ( is_singular() ) {
			$this->settings["singular_{$wp_query->post->post_type}_taxonomy"] = false;
		}
		
		extract($this->settings);
		
		$output = '';
		
		$trail = array();
		$path = '';
		
		if ( ! is_front_page() && $home_node ) {
			$trail[] = '<a href="' . home_url() . '" title="' . esc_attr( get_bloginfo('name') ) . '" rel="home" class="begin">' . $home_node . '</a>';
		}

		if ( is_front_page() ) {
			if ( $front_page_visible ) {
				$trail['trail_end'] = "{$home_node}";
			}
			else {
				$trail = false;
			}
		}
		
		elseif ( is_singular() ) { // page, post, attachment, etc.
			
			$post = $wp_query->get_queried_object();
			$post_id = absint( $wp_query->get_queried_object_id() );
			$post_title = get_the_title( $post_id );
			$post_type = $post->post_type;
			$parent = $post->post_parent;
			
			// if a custom post type
			// check if there are any pages in its hierarchy based on the slug
			if ( $post_type !== 'page' && $post_type !== 'post' ) {
				
				$post_type_object = get_post_type_object( $post_type );
				
				// if $front has been set
				// add it to the $path
				if ( $post_type == 'post' || $post_type == 'attachment' || ( $post_type_object->rewrite['with_front'] && $wp_rewrite->front ) ) {
					$path .= trailingslashit( $wp_rewrite->front );
				}
				
				// if there is a slug
				// add it to the $path
				if ( ! empty( $post_type_object->rewrite['slug'] ) ) {
					$path .= $post_type_object->rewrite['slug'];
				}
				
				// if there is a path
				// check for parents
				if ( ! empty( $path ) ) {
					$trail = array_merge( $trail, $this->get_parents( '', $path ) );
				}
				
				// if there is an archive page
				// add it to the trail
				if ( !empty( $post_type_object->has_archive ) && function_exists('get_post_type_archive_link') ) {
					$trail[] = '<a href="' . get_post_type_archive_link( $post_type ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . $post_type_object->labels->name . '</a>';
				}
				
			}
			
			// if the post type path return nothing and there is a parent
			// get its parents
			if ( empty( $path ) && $parent !== 0 || $post_type == 'attachment' ) {
				$trail = array_merge( $trail, $this->get_parents( $parent, '' ) );
			}
			
			// toggle the display of the posts on single blog posts
			if ( $post_type == 'post' && $show_posts_page == true && get_option('show_on_front') == 'page' ) {
				$posts_page = get_option('page_for_posts');
				if ( $posts_page != '' && is_numeric( $posts_page) ) {
					$trail = array_merge( $trail, $this->get_parents( $posts_page, '' ) );
				}
			}
			
			// single post 
			if ( $post_type == 'post' ) {
				
				$category = get_the_category();
				$category_id = $category[0]->cat_ID;
				
				$category_parents = get_category_parents( $category_id, true, '$$$', false );
				$category_parents = explode( '$$$', $category_parents );
				foreach ( $category_parents as $category_parent ) {
					if ( $category_parent ) {
						$trail[] = $category_parent;
					} 
				}
				
			}
			
			// single portfolio 
			if ( $post_type == 'invicta_portfolio' ) {
				
				$category_parents = get_the_term_list( $post_id, 'invicta_portfolio_category', '', '$$$', '' );
				$category_parents = explode( '$$$', $category_parents );
				
				foreach ( $category_parents as $category_parent ) {
					if ( $category_parent ) {
						$trail[] = $category_parent;
					}
				}
				
			}
			
			
			
			// end with post title
			if ( ! empty( $post_title ) ) {
				$trail['trail_end'] = $post_title;
			}
			
		}
		
		elseif ( is_home() ) {
			$home_page = get_page( $wp_query->get_queried_object_id() );
			$trail = array_merge( $trail, $this->get_parents( $home_page->post_parent, '' ) );
			$trail['trail_end'] = get_the_title( $home_page->ID );
 		}
		
		elseif ( is_archive() ) {

			// taxonomy
			if ( is_tax() || is_category() || is_tag() ) {
	
				$term = $wp_query->get_queried_object();
				$taxonomy = get_taxonomy( $term->taxonomy );
	
				// get the path to the term archive
				// use this to determine if a page is present with it.
				if ( is_category() ) {
					$path = get_option( 'category_base' );
				}
				elseif ( is_tag() ) {
					$path = get_option( 'tag_base' );
				}
				else {
					if ( $taxonomy->rewrite['with_front'] && $wp_rewrite->front ) {
						$path = trailingslashit( $wp_rewrite->front );
					}
					$path .= $taxonomy->rewrite['slug'];
				}
	
				// get parent pages by path 
				// if they exist
				if ( $path ) {
					$trail = array_merge( $trail, $this->get_parents( '', $path ) );
				}
	
				// if the taxonomy is hierarchical
				// list its parent terms.
				if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent ) {
					$trail = array_merge( $trail, $this->get_term_parents( $term->parent, $term->taxonomy ) );
				}
	
				// Add the term name to the trail end.
				$trail['trail_end'] = $term->name;
				
			}
	
			// post type archive
			elseif ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {
	
				$post_type_object = get_post_type_object( get_query_var( 'post_type' ) );
	
				// if $front has been set 
				// add it to the $path
				if ( $post_type_object->rewrite['with_front'] && $wp_rewrite->front ) {
					$path .= trailingslashit( $wp_rewrite->front );
				}
	
				// if there's a slug
				// add it to the $path
				if ( !empty( $post_type_object->rewrite['archive'] ) ) {
					$path .= $post_type_object->rewrite['archive'];
				}
				
				// toggle the display of the posts on single blog posts
				/*
				if ( $show_posts_page == true && get_option('show_on_front') == 'page' ) {
					$posts_page = get_option('page_for_posts');
					if ( $posts_page != '' && is_numeric( $posts_page) ) {
						$trail = array_merge( $trail, $this->get_parents( $posts_page, '' ) );
					}
				}
				*/
	
				// if there's a path
				// check for parents
				if ( !empty( $path ) ) {
					$trail = array_merge( $trail, $this->get_parents( '', $path ) );
				}
	
				// add the post type [plural] name to the trail end
				$trail['trail_end'] = $post_type_object->labels->name;
				
			}
	
			// author
			elseif ( is_author() ) {
	
				// if $front has been set
				// add it to $path
				if ( !empty( $wp_rewrite->front ) ) {
					$path .= trailingslashit( $wp_rewrite->front );
				}
	
				// if an $author_base exists
				// add it to $path
				if ( !empty( $wp_rewrite->author_base ) ) {
					$path .= $wp_rewrite->author_base;
				}
				
				// toggle the display of the posts on single blog posts
				if ( $show_posts_page == true && get_option('show_on_front') == 'page' ) {
					$posts_page = get_option('page_for_posts');
					if ( $posts_page != '' && is_numeric( $posts_page) ) {
						$trail = array_merge( $trail, $this->get_parents( $posts_page, '' ) );
					}
				}
	
				// if $path exists
				// check for parent pages
				if ( !empty( $path ) ) {
					$trail = array_merge( $trail, $this->get_parents( '', $path ) );
				}
	
				// add the author's display name to the trail end
				$trail['trail_end'] = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
				
			}
	
			// time
			elseif ( is_time() ) {
			
				// toggle the display of the posts on single blog posts
				if ( $show_posts_page == true && get_option('show_on_front') == 'page' ) {
					$posts_page = get_option('page_for_posts');
					if ( $posts_page != '' && is_numeric( $posts_page) ) {
						$trail = array_merge( $trail, $this->get_parents( $posts_page, '' ) );
					}
				}
	
				if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) ) {
					$trail['trail_end'] = get_the_time('g:i a');
				}
	
				elseif ( get_query_var( 'minute' ) ) {
					$trail['trail_end'] = sprintf('Minute %1$s', get_the_time('i') );
				}
	
				elseif ( get_query_var( 'hour' ) ) {
					$trail['trail_end'] = get_the_time('g a');
				}
			}
	
			/* date */
			elseif ( is_date() ) {
	
				// if $front has been set
				// check for parent pages
				if ( $wp_rewrite->front ) {
					$trail = array_merge( $trail, $this->get_parents( '', $wp_rewrite->front ) );
				}
				
				// toggle the display of the posts on single blog posts
				if ( $show_posts_page == true && get_option('show_on_front') == 'page' ) {
					$posts_page = get_option('page_for_posts');
					if ( $posts_page != '' && is_numeric( $posts_page) ) {
						$trail = array_merge( $trail, $this->get_parents( $posts_page, '' ) );
					}
				}
	
				if ( is_day() ) {
					$trail[] = '<a href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time( esc_attr('Y') ) . '">' . get_the_time('Y') . '</a>';
					$trail[] = '<a href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time( esc_attr('F') ) . '">' . get_the_time('F') . '</a>';
					$trail['trail_end'] = get_the_time('j');
				}
	
				elseif ( get_query_var( 'w' ) ) {
					$trail[] = '<a href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time( esc_attr('Y') ) . '">' . get_the_time('Y') . '</a>';
					$trail['trail_end'] = sprintf( __( 'Week %1$s', 'invicta_dictionary' ), get_the_time( esc_attr('W') ) );
				}
	
				elseif ( is_month() ) {
					$trail[] = '<a href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time( esc_attr('Y') ) . '">' . get_the_time('Y') . '</a>';
					$trail['trail_end'] = get_the_time('F');
				}
	
				elseif ( is_year() ) {
					$trail['trail_end'] = get_the_time('Y');
				}
				
			}
			
		}
		
		elseif ( is_search() ) {
		
			/* $trail['trail_end'] = sprintf( __( 'Search Results for &quot;%1$s&quot;', 'invicta_dictionary' ), esc_attr( get_search_query() ) ); */
			
			$trail['trail_end'] = __( 'Search Results for', 'invicta_dictionary' ) . ': ' . esc_attr( get_search_query() );
			
		}
		
		elseif ( is_404() ) {
			$trail['trail_end'] = __( '404 Not Found', 'invicta_dictionary' );
		}
		
		$trail = apply_filters( 'invicta_breadcrumb_trail', $trail );
		
		if ( is_array( $trail ) ) {
		
			$vocabulary = '';
			
			if ($richsnippet === true) {
				$vocabulary = ' xmlns:v="http://rdf.data-vocabulary.org/#"';
			}
			
			$breadcrumb = '<div class="breadcrumb invicta_breadcrumb"' . $vocabulary . '>';
			
			// text before the trail
			if ( ! empty( $before ) ) {
				$breadcrumb .= '<span class="before"> ' . $before . '</span> ';
			}
			
			// wrap the $tail['trail_end']
			if ( ! empty( $trail['trail_end'] ) ) {
				if( ! is_search() ) { 
					$trail['trail_end'] = invicta_truncate_string( $trail['trail_end'], $truncate, " ", $pad="..." );
				}
				$trail['trail_end'] = '<span class="end">' . $trail['trail_end'] . '</span>';
			}
			
			if($richsnippet === true) {
				foreach($trail as &$link) {
					$link = preg_replace( '!rel=".+?"|rel=\'.+?\'|!', "", $link );
					$link = str_replace( '<a ', '<a rel="v:url" property="v:title" ', $link );
					$link = '<span typeof="v:Breadcrumb">' . $link . '</span>';
				}
			}
			
			// wrap separator
			if ( ! empty( $separator ) ) {
				$separator = '<span class="separator">' . $separator . '</span>';
			}
			
			// append the trail
			$breadcrumb .= join( " {$separator} ", $trail );
			
			// text after the trail
			if ( ! empty( $after ) ) {
				$breadcrumb .= '<span class="after"> ' . $after . '</span>';
			}
			
			$breadcrumb .= '</div>';
			
			$output = $breadcrumb;
			
		}

		return $output;
		
	}
	
	public static function get_parents( $post_id = '', $path = '') {
		
		$trail = array();
		
		if ( empty( $post_id ) && empty( $path ) ) {
			return $trail;
		}
		
		// if post ID is empty
		// use the path to get the ID
		if ( empty( $post_id ) ) {
		
			$parent_page = get_page_by_path( $path );
			
			if ( empty( $parent_page ) ) { $parent_page = get_page_by_title( $path ); }
			if ( empty( $parent_page ) ) { $parent_page = get_page_by_title( str_replace( array('-', '_'), ' ', $path ) ); }
			
			if ( ! empty( $parent_page ) ) {
				$post_id = $parent_page->ID;
			}
			
		}
		
		// if a post ID and path is set
		// search for a post by the given path
		if ( $post_id == 0 && ! empty( $path ) ) {
			
			$path = trim( $path, '/' );
			preg_match_all( "/\/.*?\z/", $path, $matches );
			
			if ( isset( $matches ) ) {
				
				$matches = array_reverse( $matches );
				
				foreach ( $matches as $match ) {
					if ( isset( $match[0] ) ) {
						
						$path = str_replace( $match[0], '', $path);
						$parent_page = get_page_by_path( trim( $path, '/' ) );
						
						if ( ! empty( $parent_page ) && $parent_page->ID > 0 ) {
							$post_id = $parent_page->ID;
							break;
						}
						
					}
				}
				
			}
			
		}
		
		// while there's a post ID
		// add the post link to the $parents array
		while ( $post_id ) {
		
			$page = get_page( $post_id );
			//fb::log($post_id);
			$parents[]  = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';
			$post_id = $page->post_parent;
			
		}
			
		// if we have parent posts
		// reverse the array to put them in the proper order for the trail
		if ( isset( $parents) ) {
			$trail = array_reverse( $parents );
		}
		
		return $trail;
		
	}
	
	static function get_term_parents( $parent_id = '', $taxonomy = '' ) {
		
		$trail = array();
		$parents = array();
	
		if ( empty( $parent_id ) || empty( $taxonomy ) ) {
			return $trail;
		}
	
		// while there is a parent ID
		// add the parent term link to the $parents array
		while ( $parent_id ) {
	
			$parent = get_term( $parent_id, $taxonomy );
			$parents[] = '<a href="' . get_term_link( $parent, $taxonomy ) . '" title="' . esc_attr( $parent->name ) . '">' . $parent->name . '</a>';
			$parent_id = $parent->parent;
			
		}
	
		// if we have parent terms
		// reverse the array to put them in the proper order for the trail
		if ( !empty( $parents ) )
			$trail = array_reverse( $parents );
	
		return $trail;
		
	}
	
}
	
?>