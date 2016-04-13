<?php 
	global $smof_data;
	global $invicta_settings;
	$context = 'pages'; 
?>
<?php get_header(); ?>
<div class="invicta_canvas<?php invicta_layout_class( 'sidebar_position', $context ); ?>">
	<div class="main_column">

		<?php if ( have_posts() && strlen( trim(get_search_query()) ) != 0 ) : ?>
		<section class="search_loop">
			<?php while (have_posts()) : the_post(); ?>
			<article id="entry-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
			
				<h2 class="post_title">
					<a href="<?php the_permalink(); ?>" title="<?php _e("Permalink to", "invicta_dictionary"); ?> <?php the_title_attribute(); ?>" rel="bookmark" class="inherit-color accentcolor-text-on_hover">
						<?php the_title(); ?>
					</a>
				</h2>
				
				<div class="post_meta">
					
					<?php if ( $post->post_type == 'post' ) : ?>
					<span class="meta">
						<i class="icon-user"></i>
						<span class="inherit-color-on_children accentcolor-text-on_children-on_hover">
							<?php the_author_posts_link(); ?>
						</span>
					</span>
					<?php endif; ?>
			
					<?php if ( $post->post_type == 'post' ) : ?>
					<span class="meta">
						<i class="icon-time"></i>
						<?php echo get_the_date(); ?>
					</span>
					<?php endif; ?>
					
					<?php if ( $post->post_type == 'post' ) : ?>
					<span class="meta">
						<i class="icon-tag"></i>
						<span class="inherit-color-on_children accentcolor-text-on_children-on_hover">
							<?php echo get_the_category_list(', '); ?>
						</span>
					</span>
					<?php endif; ?>
					
					<?php if ( $smof_data['general-search_results'] == 'all' ) : ?>
					<span class="meta accentcolor-text-on_children post_type">
						<i class="icon-sitemap"></i>
						<span class="accentcolor-text">
							<?php 
							if ( $post->post_type == 'invicta_photos' ) {
								echo __( 'Photo Gallery', 'invicta_dictionary' );
							}
							elseif ( $post->post_type == 'invicta_videos' ) {
								echo __( 'Video', 'invicta_dictionary' );
							}
							elseif ( $post->post_type == 'invicta_portfolio' ) {
								echo __( 'Portfolio Project', 'invicta_dictionary' );
							}
							else {
								echo $post->post_type; 
							}
							?>
						</span>
					</span>
					<?php endif; ?>
				
				</div>
				
				<div class="post_text text_styles">
					<?php the_excerpt(); ?>
				</div>
				
			</article>
			<?php endwhile; ?>
			
			<div class="blog_loop_pagination">
				<?php echo invicta_pagination(); ?>
			</div>
			
			<?php if ( $smof_data['general-search_results-highlight'] ) : ?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$(".search_loop *").invicta_highlight_text("<?php echo get_search_query(); ?>", "invicta_highlight");	
				});
			</script>
			<?php endif; ?>
			
			<div class="invicta_heading">
				<div class="primary">
					<?php _e("Didn't find what you're <strong>looking for?</strong>", "invicta_dictionary" ); ?>
				</div>
				<div class="secondary">
					<?php _e("Please try again by refining your search!", 'invicta_dictionary'); ?>
				</div>
			</div>
			
			<div class="wpb_content_element">
				<?php get_search_form(); ?>
			</div>
			
		</section>
		<?php else : ?>
		
			<div class="invicta_heading">
				<div class="primary">
					<?php _e("No results <strong>found</strong>", "invicta_dictionary" ); ?>
				</div>
				<div class="secondary">
					<?php _e("Please try again by refining your search!", 'invicta_dictionary'); ?>
				</div>
			</div>
			
			<div class="wpb_content_element">
				<?php get_search_form(); ?>
			</div>
		
		<?php endif; ?>

	</div>
	<?php $invicta_settings['context'] = $context; ?>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>