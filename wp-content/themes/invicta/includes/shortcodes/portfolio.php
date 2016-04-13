<?php 
	
add_shortcode( 'invicta_portfolio', 'invicta_portfolio_shortcode' );	

function invicta_portfolio_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'posts_per_page'		=> 4,
		'page'					=> 1,
		'filtered_categories' 	=> '',
		'excluded_projects'		=> '',
		'metadata'				=> 'date',
		'linking'				=> '1'
	), $atts ) );
	
	$portfolio_id = 'portfolio_' . uniqid();
	
	// filtered categories
	
	if ( $filtered_categories && $filtered_categories != -1 ) {
		$filtered_categories = explode( ',', $filtered_categories );
	}
	else {
		$filtered_categories = '';
	}
	
	// excluded projects
	
	if ( $excluded_projects ) {
		$excluded_projects = explode( ',', $excluded_projects );
	}
	
	// metadata
	
	global $invicta_portfolio_metadata_type;
	$invicta_portfolio_metadata_type = $metadata;
	
	// linking
	
	global $invicta_portfolio_linking_type;
	$invicta_portfolio_linking_type = $linking;
	
	// sorting
	
	$sort_params = invicta_get_sorting_parameters_on_custom_post_types( 'portfolio' );
	
	// args 
	
	$args = array(
		'post_type'			=> 'invicta_portfolio',
		'posts_per_page'	=> $posts_per_page,
		'paged'				=> $page,
		'tax_query'			=> null,
		'orderby'			=> $sort_params['orderby'],
		'order'				=> $sort_params['order']
	);
	
	if ( $filtered_categories ) {
		$args['tax_query'] = array(
			array(
				'taxonomy'	=> 'invicta_portfolio_category',
				'field'		=> 'id',
				'terms'		=> $filtered_categories,
			)
		);
	}
	
	if ( $excluded_projects ) {
		$args['post__not_in'] = $excluded_projects;
	}
	
	$portfolio_query = new WP_Query( $args );

	// output	

	$output = '';
	
	if ( $portfolio_query->have_posts() ) {
	
		$output .= '<div class="grid_shortcode">';
		$output .= '<section id="' . $portfolio_id . '" class="portfolio_loop invicta_grid isotope">';
		
		while ( $portfolio_query->have_posts() ) {
			
			$portfolio_query->the_post();
			
			ob_start();
			locate_template( 'template-parts/portfolio-entry.php', true, false );
			$portfolio_html = ob_get_contents();
			ob_end_clean();
			
			$output .= $portfolio_html;
			
		}
		
		$output .= '</section>';

		
		$output .= '<script type="text/javascript">';
		$output .= '	jQuery(document).ready(function($){';
		$output .= '		$("#' . $portfolio_id . '").invicta_grid_isotope();';
		$output .= '	});';
		$output .= '</script>';
		
		if ( $invicta_portfolio_linking_type == 2 ) { // lightbox 
			wp_enqueue_script('invicta_fancybox');
			$output .= '<script type="text/javascript">';
			$output .= '	jQuery(document).ready(function($){';
			$output .= '		$("#' . $portfolio_id . '").invicta_setup_lightbox_items();';
			$output .= '	});';
			$output .= '</script>';
		}
		
		$output .= '</div>';
		
	}
	
	return $output;
	
}
	
?>