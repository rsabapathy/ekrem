<?php 
	
add_shortcode( 'invicta_blog', 'invicta_blog_shortcode' );
	
function invicta_blog_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'posts_per_page'		=> 4,
		'page'					=> 1,
		'filtered_categories' 	=> '',
		'excluded_posts'		=> ''
	), $atts ) );
	
	$blog_id = 'blog_' . uniqid();
	
	// filtered categories
	
	if ( $filtered_categories && $filtered_categories != -1 ) {
		$filtered_categories = explode( ',', $filtered_categories );
	}
	else {
		$filtered_categories = '';
	}
	
	
	
	// excluded projects
	
	if ( $excluded_posts ) {
		$excluded_posts = explode( ',', $excluded_posts );
	}
	
	$args = array(
		'posts_per_page' 	=> $posts_per_page,
		'category__in'		=> $filtered_categories,
		'post_status'		=> 'publish',
		'ignore_sticky_posts' => 1,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array('post-format-link', 'post-format-quote', 'post-format-aside', 'post-format-status' ),
				'operator' => 'NOT IN'
			)
		)
	);
	
	$posts_query = new WP_Query( $args );
	
	// output	

	$output = '';
	
	if ( $posts_query->have_posts() ) { 
		
		$output .= '<div class="grid_shortcode columns_2">';
		$output .= '<section id="' . $blog_id . '" class="blog_loop_shortcode invicta_grid isotope">';
		
		while ( $posts_query->have_posts() ) {
			
			$posts_query->the_post();
			
			ob_start();
			locate_template( 'template-parts/blog-entry-shortcode.php', true, false );
			$blog_html = ob_get_contents();
			ob_end_clean();
			
			$output .= $blog_html;
			
		}
		
		$output .= '</section>';

		$output .= '<script type="text/javascript">';
		$output .= '	jQuery(document).ready(function($){';
		$output .= '		$("#' . $blog_id . '").invicta_grid_isotope();';
		$output .= '	});';
		$output .= '</script>';
				
		$output .= '</div>';
		
	}
	
	return $output;
	
}
	
?>