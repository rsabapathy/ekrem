<?php 
	global $smof_data;
	global $invicta_settings;
	$context = 'photos';
?>
<?php 	
	$post_id = get_queried_object_id();
	$galleries_id = 'galleries_' . uniqid();
?>
<?php get_header(); ?>
<div class="invicta_canvas<?php invicta_layout_class( 'sidebar_position', $context ); ?><?php invicta_layout_class( 'photos_layout', $context ); ?>">
	<div class="main_column columns_3">
		
		<?php if ( have_posts() ) : ?>
		
			<!-- photos loop -->
			<section id="<?php echo $galleries_id ?>" class="photos_loop invicta_grid isotope">
				<?php
				while ( have_posts() ) {
					the_post();
					locate_template( 'template-parts/photos-entry.php', true, false );
				}
				?>
			</section>
		
			<!-- grid/isotop script -->
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('#<?php echo $galleries_id ?>').invicta_grid_isotope({
						filtering: false
					});
				});
			</script>
			
		<?php endif; ?>
	</div>
	<?php $invicta_settings['context'] = $context; ?>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>