<?php
	
	$sort_params = invicta_get_sorting_parameters_on_custom_post_types('videos');
	$featured_video_id = 0;
	
	$args = array(
			'post_type'			=> 'invicta_videos',
			'posts_per_page'	=> 1,
			'tax_query'			=> null,
			'orderby'			=> $sort_params['orderby'],
			'order'				=> $sort_params['order']
		);
		
	$videos_query = new WP_Query( $args );

?>
<?php if ( $videos_query->have_posts() ) : while( $videos_query->have_posts() ) : $videos_query->the_post(); ?>
<div class="featured_video wpb_content_element">

	<div class="video">
		<?php echo invicta_get_video_from_post( $post, true ); ?>
	</div>
	
	<div class="info">
	
		<?php 
			
		$categories = array();
		
		foreach ( wp_get_post_terms( $post->ID, 'invicta_videos_category' ) as $category ) {
			$categories[] = $category->name;
		}
		
		if ( isset( $categories ) && ! empty( $categories ) ) {
			$categories = join( ', ' , $categories );
		}
			
		?>
	
		<h2><?php the_title(); ?></h2>
		
		<div class="excerpt"><?php the_excerpt(); ?></div>
		
		<div class="post_meta">
			
			<span class="meta">
				<i class="icon-time"></i>
				<?php echo get_the_date(); ?>
			</span>
			
			<span class="meta">
				<i class="icon-tag"></i>
				<?php echo $categories; ?>
			</span>
			
			<span class="meta">
				<i class="icon-comments"></i>
				<?php printf( _n( '%1$s comment', '%1$s comments', get_comments_number(), 'invicta_dictionary' ), get_comments_number() ); ?>
			</span>
			
		</div>
		
		<div class="button">
			<?php 
				$button_shortcode = '[invicta_button';
				$button_shortcode .= ' label="' . __( 'View Details', 'invicta_dictionary' ) . '"';
				$button_shortcode .= ' url="' . get_permalink($post->ID) . '"';
				$button_shortcode .= ' icon="icon-chevron-sign-right"';
				$button_shortcode .= ' icon_position="right"';
				$button_shortcode .= ']';
				echo do_shortcode( $button_shortcode ); 
			?>		
		</div>
		
	</div>
	
</div>
<?php endwhile; endif; ?>