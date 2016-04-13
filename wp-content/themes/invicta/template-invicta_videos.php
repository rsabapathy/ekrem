<?php 
/**
 * Template Name: Videos
 */	
?>
<?php 
	global $smof_data;
	global $invicta_settings;
	global $invicta_current_post_id;
	$context = 'videos';
?>
<?php 
	
	if ( session_id() ) {
		$_SESSION['invicta_videos_page'] = get_the_ID(); 
	}
	
	$post_id = get_queried_object_id();
	$videos_id = 'videos_' . uniqid();
	
?>
<?php get_header(); ?>
<div class="invicta_canvas video_list_page<?php invicta_layout_class( 'sidebar_position', $context ); ?><?php invicta_layout_class( 'videos_layout', $context ); ?>">
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
		
		<?php locate_template( 'template-parts/videos-featured.php' , true, false ); ?>
		<?php locate_template( 'template-parts/videos-carousels.php' , true, false ); ?>
		
	</div>
	<?php $invicta_settings['context'] = $context; ?>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>