<?php 
	global $smof_data;
	global $invicta_settings;
	$context = 'pages'; 
	$portfolio_id = 'portfolio_' . uniqid();
	
	global $invicta_portfolio_metadata_type;
	$invicta_portfolio_metadata_type = 'date';
	
?>
<?php get_header(); ?>
<div class="invicta_canvas<?php invicta_layout_class( 'sidebar_position', $context ); ?><?php invicta_layout_class( 'portfolio_layout', $context ); ?>">
	<div class="main_column">

		<!-- portfolio loop -->
		<?php if ( have_posts() ) : ?>
		<section id="<?php echo $portfolio_id ?>" class="portfolio_loop invicta_grid isotope">
			<?php 
			while ( have_posts() ) {
				the_post();
				locate_template( 'template-parts/portfolio-entry.php', true, false );
			}
			?>
		</section>
		
		<!-- grid/isotop script -->
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#<?php echo $portfolio_id ?>').invicta_grid_isotope();
			});
		</script>
		
		<!-- pagination -->
		<div class="blog_loop_pagination">
			<?php echo invicta_pagination(); ?>
		</div>
		<?php endif; ?>

	</div>
	<?php $invicta_settings['context'] = $context; ?>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>