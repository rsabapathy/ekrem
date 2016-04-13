<?php 
	
	global $smof_data;
	global $invicta_show_photo;
	global $invicta_show_comments;

	// title
	
	$current_post['title'] = get_the_title();
	
	if ( empty( $current_post['title'] ) ) {
		$current_post['title'] = __( 'Untitled Article', 'invicta_dictionary' );
	}
	
	// date
		
	$current_post['date'] = get_the_date( $smof_data['blog-date_format'] );
	
	// thumbnail
	
	if ( $invicta_show_photo ) {
		$current_post['show_photo'] = true;
		$current_post['thumbnail'] 	= invicta_widget_post_featured_image();
	}
	else {
		$current_post['show_photo'] = false;
	}
	
	// comments
	
	if ( $invicta_show_comments ) {
		$current_post['show_comments'] = true;
	}
	else {
		$current_post['show_comments'] = false;
	}
	
	// extra classes
	
	$extra_css_class = '';
	if ( ! $invicta_show_photo ) {
		$extra_css_class = ' no_thumbnail';
	}
	
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' . $extra_css_class ); ?>>
	<?php if ( $current_post['show_photo'] ) : ?>
	<div class="post_thumbnail">
		<?php echo $current_post['thumbnail']; ?>
	</div>
	<?php endif; ?>
	<div class="post_details">
		<div class="post_title">
			<a href="<?php echo get_permalink(); ?>" title="<?php _e( "Permalink to", "invicta_dictionary" ); ?>" rel="bookmark" class="inherit-color accentcolor-text-on_hover">
				<?php echo $current_post['title']; ?>
			</a>
		</div>
		<div class="post_meta">
			<?php echo $current_post['date']; ?>
			<?php if ( $current_post['show_comments'] && ( get_comments_number() != "0" || comments_open() ) ) : ?>
			| 
			<span class="inherit-color-on_children accentcolor-text-on_children-on_hover">
				<?php comments_popup_link(__('Leave a comment', 'invicta_dictionary'), __('1 Comment', 'invicta_dictionary'), __('% Comments', 'invicta_dictionary')); ?>
			</span>
			<?php endif; ?>
		</div>
	</div>
</article>