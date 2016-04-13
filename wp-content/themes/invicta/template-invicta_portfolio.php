<?php 
/**
 * Template Name: Portfolio
 */	
?>
<?php 
	global $smof_data;
	global $invicta_settings;
	$context = 'pages'; 
?>
<?php 
	
	if ( session_id() ) {
		$_SESSION['invicta_portfolio_page'] = get_the_ID(); 
	}
	
	$post_id = get_queried_object_id();
	$portfolio_id = 'portfolio_' . uniqid();
	$filters_id = 'filters_' . uniqid();
	
?>
<?php 

	// current page

	$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
	
	// posts per page
	
	$posts_per_page = get_post_meta( $post_id, '_invicta_portfolio_page_settings_pagesize', true );
	
	// sortable
	
	$sortable = get_post_meta( $post_id, '_invicta_portfolio_page_settings_sortable', true );
	$sortable = filter_var( $sortable, FILTER_VALIDATE_BOOLEAN );
	
	// categories
	$filtered_categories = get_post_meta( $post_id, '_invicta_portfolio_page_settings_categories', true);
		
	if ( $filtered_categories && $filtered_categories != -1 ) {
		$filtered_categories = explode( ',', $filtered_categories );
	}
	else {
		$filtered_categories = '';
	}
	
	// metadata
	
	$metadata = get_post_meta( $post_id, '_invicta_portfolio_page_settings_metadata', true );
	global $invicta_portfolio_metadata_type;
	$invicta_portfolio_metadata_type = $metadata;
	
	// linking
	
	$linking_type = get_post_meta( $post_id, '_invicta_portfolio_page_settings_linking', true );
	global $invicta_portfolio_linking_type;
	$invicta_portfolio_linking_type = $linking_type;
	
	
	// sorting
	
	$sort_params = invicta_get_sorting_parameters_on_custom_post_types('portfolio');

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
	
	$portfolio_query = new WP_Query( $args );
	
	// available categories
	
	if ( $sortable === true ) {
		$portfolio_categories = invicta_get_categories_on_portolio_posts( $portfolio_query->posts, $filtered_categories );
	}
	
?>
<?php get_header(); ?>
<div class="invicta_canvas<?php invicta_layout_class( 'sidebar_position', $context ); ?><?php invicta_layout_class( 'portfolio_layout', $context ); ?>">
	<div class="main_column">

		<?php if ( $excerpt = get_the_excerpt() ) : ?>
		<div class="wpb_content_element">	
			<?php echo $excerpt; ?>
		</div>
		<?php endif; ?>
	
		<!-- filters -->
		<?php if ( ( $sortable === true ) && ( $portfolio_categories ) && ( sizeof( $portfolio_categories ) > 1 ) ) : ?>
		<div id="<?php echo $filters_id; ?>" class="portfolio_filters">
			<ul>
				<li><a href="#" class="active" data-filter="*"><?php _e( 'All', 'invicta_dictionary' ); ?></a></li>
				<?php foreach ( $portfolio_categories as $category_slug => $category_name ) : ?>
				<li><a href="#" data-filter=".<?php echo $category_slug ?>"><?php echo $category_name ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>

		<!-- portfolio loop -->
		<?php if ( $portfolio_query->have_posts() ) : ?>
		
			<section id="<?php echo $portfolio_id ?>" class="portfolio_loop invicta_grid isotope">
				<?php 
				while ( $portfolio_query->have_posts() ) {
					$portfolio_query->the_post();
					locate_template( 'template-parts/portfolio-entry.php', true, false );
				}
				?>
			</section>
			
			<!-- grid/isotop script -->
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('#<?php echo $portfolio_id ?>').invicta_grid_isotope({
						filtering: true,
						filters_selector: '#<?php echo $filters_id; ?>'
					});
				});
			</script>
			
			<?php if ( $invicta_portfolio_linking_type == 2 ) : // lightbox ?> 
				<?php wp_enqueue_script('invicta_fancybox'); ?>
				<script type="text/javascript">
					jQuery(document).ready(function($){
						$('#<?php echo $portfolio_id ?>').invicta_setup_lightbox_items();
					});
				</script>
			<?php endif; ?>
			
			<!-- pagination -->
			<?php if ( $portfolio_query->max_num_pages > 0 ) : ?>
			<div class="blog_loop_pagination">
				<?php 
					global $wp_query; 
					$original_query = $wp_query;
					$wp_query = $portfolio_query;
					echo invicta_pagination();
	
					$wp_query = $original_query;
				?>
			</div>
			<?php endif; ?>
			
		<?php endif; ?>

	</div>
	<?php $invicta_settings['context'] = $context; ?>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>