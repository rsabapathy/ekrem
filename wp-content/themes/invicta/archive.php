<?php 
	global $invicta_settings;
	$context = 'blog_archives'; 
?>
<?php get_header(); ?>
<div class="invicta_canvas<?php invicta_layout_class( 'sidebar_position', $context ); ?>">
	<div class="main_column">
	
		<?php if ( have_posts() ) : ?>
		<section class="blog_loop<?php invicta_layout_class( 'blog_layout', 'archive' ); ?>">
			<?php 
			while (have_posts()) { 
				the_post();
				locate_template('template-parts/blog-entry.php', true, false);
			}
			?>
		</section>
		<div class="blog_loop_pagination">
			<?php echo invicta_pagination(); ?>
		</div>
		<?php endif; ?>
		
		<?php if ( strpos( invicta_layout_class( 'blog_layout', 'archive', false ) , 'invicta_grid') !== false ) : ?>
		<!-- grid/isotop script -->
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('.invicta_grid').invicta_grid_isotope({
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