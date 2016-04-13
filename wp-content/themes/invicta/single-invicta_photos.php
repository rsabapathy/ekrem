<?php 
	global $smof_data;
	global $invicta_settings;
	global $post;
	$context = 'photos';	
?>
<?php get_header(); ?>
<div class="invicta_canvas<?php invicta_layout_class( 'sidebar_position', $context ); ?><?php invicta_layout_class( 'photos_layout', $context ); ?>">
	<div class="main_column">

		<?php if ( have_posts() ) : ?>
		<section class="photos_loop text_styles">
			<?php 
			while (have_posts()) { 
				the_post();			
				if ( $smof_data['photos-mosaic'] ) {	
					echo invicta_get_adjusted_photo_gallery_content_mosaic();
				}
				else {
					echo invicta_get_adjusted_photo_gallery_content();
				}
			}
			?>
			<div class="blog_loop_pagination">
				<?php echo invicta_pagination(); ?>
			</div>
		</section>
		<?php endif; ?>

	</div>
	<?php $invicta_settings['context'] = $context; ?>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>