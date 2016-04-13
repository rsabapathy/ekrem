<?php 
	global $invicta_settings;
	$context = 'portfolio_project'; 
	$current_post = null;
?>
<?php get_header(); ?>
<div class="invicta_canvas no_sidebar">
	<div class="main_column">
	
		<?php if ( have_posts() ) : ?>
		<section class="portfolio_details">
			<?php 
			while (have_posts()) { 
				the_post();
				$current_post = $post;
				locate_template('template-parts/portfolio-entry-detailed.php', true, false);
			}
			?>
			<div class="alignclear"></div>
		</section>
		<?php endif; ?>
		
		<?php invicta_related_projects( $current_post ); ?>
	
	</div>
</div>
<?php get_footer(); ?>