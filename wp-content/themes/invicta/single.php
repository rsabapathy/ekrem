<?php 
	global $invicta_settings;
	$context = 'blog_post'; 
?>
<?php get_header(); ?>
<div class="invicta_canvas<?php invicta_layout_class( 'sidebar_position', $context ); ?>">
	<div class="main_column">
	
		<?php if ( have_posts() ) : ?>
		<section class="blog_loop">
			<?php 
			while (have_posts()) { 
				the_post();
				locate_template('template-parts/blog-entry.php', true, false);
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