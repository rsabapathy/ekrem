<?php 
/**
 * Template Name: Photos
 */	
?>
<?php 
	global $smof_data;
	global $invicta_settings;
	$context = 'photos';
?>
<?php 
	
	if ( session_id() ) {
		$_SESSION['invicta_photos_page'] = get_the_ID(); 
	}
	
	$post_id = get_queried_object_id();
	$galleries_id = 'galleries_' . uniqid();
	
?>
<?php 

	$posts_per_page = -1;
	$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
	$sort_params = invicta_get_sorting_parameters_on_custom_post_types('photos');

	$args = array(
		'post_type'			=> 'invicta_photos',
		'posts_per_page'	=> $posts_per_page,
		'paged'				=> $page,
		'tax_query'			=> null,
		'orderby'			=> $sort_params['orderby'],
		'order'				=> $sort_params['order']
	);
	
	$photos_query = new WP_Query( $args );
	
?>
<?php get_header(); ?>
<div class="invicta_canvas<?php invicta_layout_class( 'sidebar_position', $context ); ?><?php invicta_layout_class( 'photos_layout', $context ); ?>">
	<div class="main_column columns_3">
		
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ( get_the_content() != '' ) : ?>
				<section class="page_loop">
					<article id="page-<?php the_ID(); ?>" <?php post_class('entry text_styles'); ?>>		
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'invicta_dictionary' ), 'after' => '</div>' ) ); ?>
						<div class="alignclear"></div>
					</article>
					<?php 
					if ( $smof_data['general-comments_pages'] ) {
						comments_template( '', true );
					}
				?>
				</section>
			<?php endif; ?>
		<?php endwhile; ?>
		
		<?php if ( $photos_query->have_posts() ) : ?>
		
			<!-- photos loop -->
			<section id="<?php echo $galleries_id ?>" class="photos_loop invicta_grid isotope">
				<?php
				while ( $photos_query->have_posts() ) {
					$photos_query->the_post();
					locate_template( 'template-parts/photos-entry.php', true, false );
				}
				?>
			</section>
		
			<!-- grid/isotop script -->
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('#<?php echo $galleries_id ?>').invicta_grid_isotope({
						filtering: <?php echo ($posts_per_page > 0 ) ? 'false' : 'true'; ?>,
						filters_selector: '#photo_category_filters'
					});
				});
			</script>
			
		<?php endif; ?>
	</div>
	<?php $invicta_settings['context'] = $context; ?>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>