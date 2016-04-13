<?php

	$photo_width = VIDEOS__PHOTO_WIDTH;
	$photo_height = VIDEOS__PHOTO_HEIGHT;
	
	// featured image
	
	$thumbnail = invicta_video_featured_image( $photo_width, $photo_height );

?>
<article id="video-<?php the_ID(); ?>" <?php post_class( 'entry accentcolor-border-on_hover' ); ?>>

	<div class="video_thumbnail">
		<a href="<?php the_permalink() ?>" class="invicta_hover_effect">
			<span class="element">
			<?php echo $thumbnail; ?>
			</span>
			<span class="mask">
				<span class="caption">
					<span class="title">
						<i class="icon-play"></i>
					</span>
				</span>
			</span>
		</a>
	</div>
	
	<div class="meta">
		<div class="title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</div>
		<div class="description">
			<span><?php printf( __( 'Posted %1$s ago', 'invicta_dictionary' ), human_time_diff( get_post_time('U'), current_time('timestamp') ) ); ?></span>
		</div>
	</div>

</article>