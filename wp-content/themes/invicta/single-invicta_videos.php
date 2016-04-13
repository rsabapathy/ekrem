<?php 

	global $smof_data;
	global $invicta_settings;
	global $post;
	global $invicta_current_post_id;
	
	$context = 'videos';	
	$videos_id = 'videos_' . uniqid();
	$invicta_current_playing_post_id = 0;
	
	$video_categories = array();
	$video_id = 0;
	 
	$pagesize = $smof_data['videos-list_size'];
	if ( ! is_numeric( $pagesize ) ) {
		$pagesize = -1;
	}
	
?>
<?php get_header(); ?>
<div class="invicta_canvas video_page">
	<div class="main_column columns_3">
	
		<?php if ( have_posts() ) : ?>
		<section class="video_details">
			<?php while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID() ?>" <?php post_class('entry'); ?>>
					
					<?php 
						
						$video_categories = get_the_terms( $post->ID, 'invicta_videos_category' );
						$video_id = $post->ID;
						
						$categories = array();
						
						foreach ( wp_get_post_terms( $post->ID, 'invicta_videos_category' ) as $category ) {
							$categories[] = $category->name;
						}
						
						if ( isset( $categories ) && ! empty( $categories ) ) {
							$categories = join( ', ' , $categories );
						}
						
						$content = get_the_content();
							
					?>
					
					<?php if ( $content ) : ?>
					<div class="condensed">
					<?php endif; ?>
				
					<div class="post_thumbnail">
						<?php
						$invicta_current_playing_post_id = $post->ID;
						echo invicta_get_video_from_post( $post, true );
						?>
					</div>
					
					<div class="post_meta">
						
						<span class="meta">
							<i class="icon-time"></i>
							<?php echo get_the_date(); ?>
						</span>
						
						<?php if ( $categories ) : ?>
						<span class="meta">
							<i class="icon-tag"></i>
							<?php echo $categories; ?>
						</span>
						<?php endif; ?>
						
						<span class="meta">
							<i class="icon-comments"></i>
							<?php printf( _n( '%1$s comment', '%1$s comments', get_comments_number(), 'invicta_dictionary' ), get_comments_number() ); ?>
						</span>
						
					</div>
				
					<div class="post_text text_styles">
						<?php the_content(); ?>
					</div>
					
					<div class="alignclear"></div>
					
					<?php if ( $content ) : ?>
					</div>
					<?php endif; ?>
					
				</article>
			<?php endwhile; ?>
		</section>
		<?php endif; ?>
		
		<?php comments_template(); ?>
	
	</div>
	<div class="side_column">
	
		<!-- Related Videos -->
		<?php if ( $smof_data['videos-related_videos'] ) : ?>
			<?php 
			
				$sort_params = invicta_get_sorting_parameters_on_custom_post_types('videos');
			
				$args = array(
					'post_type'			=> 'invicta_videos',
					'posts_per_page'	=> $pagesize,
					'tax_query'			=> null,
					'orderby'			=> $sort_params['orderby'],
					'order'				=> $sort_params['order'],
					'post__not_in'		=> array( $video_id )
				);
				
				if ( $video_categories ) {
				
					$filtered_categories = array();
					
					foreach ( $video_categories as $category ) {
						$filtered_categories[] = $category->term_id;
					}
					
					$args['tax_query'] = array(
						array(
							'taxonomy'	=> 'invicta_videos_category',
							'field'		=> 'id',
							'terms'		=> $filtered_categories
						)
					);
				}
				
				$videos_query = new WP_Query( $args );
				
			?>
			<?php if ( $videos_query->have_posts() ) : ?>
			<div id="related_videos" class="widget widget_related_videos">
				<h3 class="widget_title"><?php _e( 'Related Videos', 'invicta_dictionary' ); ?></h3>
				<div class="videos_loop_list condensed">
				<?php while ( $videos_query->have_posts() ) : $videos_query->the_post(); ?>
					<?php locate_template( 'template-parts/videos-entry.php', true, false ); ?>
				<?php endwhile; ?>
				</div>
			</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php /* Other Videos */ ?>
		<?php if ( $smof_data['videos-other_videos'] ) : ?>
			<?php 
			
				$sort_params = invicta_get_sorting_parameters_on_custom_post_types('videos');
			
				$args = array(
					'post_type'			=> 'invicta_videos',
					'posts_per_page'	=> $pagesize,
					'tax_query'			=> null,
					'orderby'			=> $sort_params['orderby'],
					'order'				=> $sort_params['order'],
					'post__not_in'		=> array( $video_id )
				);
				
				if ( $video_categories ) {
				
					$filtered_categories = array();
					
					foreach ( $video_categories as $category ) {
						$filtered_categories[] = $category->term_id;
					}
					
					$args['tax_query'] = array(
						array(
							'taxonomy'	=> 'invicta_videos_category',
							'field'		=> 'id',
							'terms'		=> $filtered_categories,
							'operator' => 'NOT IN'
						)
					);
				}
				
				$videos_query = new WP_Query( $args );
				
			?>
			<?php if ( $videos_query->have_posts() ) : ?>
			<div id="related_videos" class="widget widget_related_videos">
				<h3 class="widget_title"><?php _e( 'Other Videos', 'invicta_dictionary' ); ?></h3>
				<div class="videos_loop_list condensed">
				<?php while ( $videos_query->have_posts() ) : $videos_query->the_post(); ?>
					<?php locate_template( 'template-parts/videos-entry.php', true, false ); ?>
				<?php endwhile; ?>
				</div>
			</div>
			<?php endif; ?>
		<?php endif; ?>
	
	</div>
	<div class="alignclear"></div>
</div>
<?php get_footer(); ?>