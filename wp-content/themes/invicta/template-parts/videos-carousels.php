<?php global $smof_data; ?>
<?php 
	$carousel_pagesize = $smof_data['videos-carousel_size'];
	if ( ! is_numeric( $carousel_pagesize ) ) {
		$carousel_pagesize = -1;
	}
?>
<div class="category_videos wpb_content_element">

	<!-- popular videos -->
	<?php if ( $smof_data['videos-popular_videos'] ) : ?>
		<?php 
		
			$guid = 'videos_carousel_' . uniqid();
			
			$args = array(
				'post_type'			=> 'invicta_videos',
				'posts_per_page'	=> $carousel_pagesize,
				'paged'				=> 0,
				'orderby'			=> 'comment_count',
			);
			
			$videos_query = new WP_Query( $args );
			
		?>
		<?php if ( $videos_query->have_posts() ) : ?>
		<div class="widget">
		
			<h3 class="widget_title">
				<i class="icon-thumbs-up"></i> <?php _e( 'Popular Videos', 'invicta_dictionary' ); ?>
			</h3>
			
			<section id="<?php echo $guid; ?>" class="videos_carousel videos_loop_list">
	
				<div class="videos_wrapper">
					<div class="stage">
						<?php
						while ( $videos_query->have_posts() ) { 
							$videos_query->the_post();
							locate_template( 'template-parts/videos-entry.php', true, false );
						}
						?>
					</div>
				</div>
				
				<script type="text/javascript">
					jQuery(document).ready(function($){
						$('#<?php echo $guid ?>').invicta_entry_carousel();
					});
				</script>
				
			</section>
			
		</div>
		<?php endif; ?>
	<?php endif; ?>
	
	
	<!-- videos by category -->
	<?php if ( $smof_data['videos-category_videos'] ) : ?>
		<?php 
		
		$sort_params = invicta_get_sorting_parameters_on_custom_post_types('videos');
		$video_categories = get_terms( 'invicta_videos_category' );
		
		foreach ( $video_categories as $video_category ) {
			
			$guid = 'videos_carousel_' . uniqid();
	
			$args = array(
				'post_type'			=> 'invicta_videos',
				'posts_per_page'	=> $carousel_pagesize,
				'paged'				=> 0,
				'tax_query'			=> array(
					array(
						'taxonomy'	=> 'invicta_videos_category',
						'field'		=> 'id',
						'terms'		=> array( $video_category->term_id )
						)
				),
				'orderby'			=> $sort_params['orderby'],
				'order'				=> $sort_params['order']
			);
			
			$videos_query = new WP_Query( $args );
			
			?>
			<?php if ( $videos_query->have_posts() ) : ?>
			<div class="widget">
			
				<h3 class="widget_title">
					<i class="icon-tag"></i> <?php echo $video_category->name; ?>
				</h3>
				
				<section id="<?php echo $guid; ?>" class="videos_carousel videos_loop_list">
	
					<div class="videos_wrapper">
						<div class="stage">
							<?php
							while ( $videos_query->have_posts() ) { 
								$videos_query->the_post();
								locate_template( 'template-parts/videos-entry.php', true, false );
							}
							?>
						</div>
					</div>
					
					<script type="text/javascript">
						jQuery(document).ready(function($){
							$('#<?php echo $guid ?>').invicta_entry_carousel();
						});
					</script>
					
				</section>
				
			</div>
			<?php endif; ?>
			<?php
			
		}
		?>
	<?php endif; ?>
</div>