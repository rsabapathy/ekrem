<?php 
	global $smof_data;
	global $invicta_settings;
	$context = 'pages'; 
?>
<?php get_header(); ?>
<div class="invicta_canvas<?php invicta_layout_class( 'sidebar_position', $context ); ?>">
	<div class="main_column">

		<section class="page_loop">
	
		<?php while ( have_posts() ) : the_post(); ?>
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
		<?php endwhile; ?>
		
		</section>

	</div>
	<?php $invicta_settings['context'] = $context; ?>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>