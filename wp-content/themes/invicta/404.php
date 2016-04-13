<?php get_header(); ?>
<div class="invicta_canvas no_sidebar">

	<!-- Heading -->
	<div class="invicta_heading">
		<div class="primary">
			<?php _e("Error 404 - Page <strong>not Found</strong>", "invicta_dictionary" ); ?>
		</div>
		<div class="secondary">
			<?php _e("Sorry, the page you are looking for is not available right now.<br/>Maybe you want to perform a search?", 'invicta_dictionary'); ?>
		</div>
	</div>
	
	<!-- Search Form -->
	<div class="search_container wpb_content_element">
		<?php get_search_form(); ?>
	</div>
	
	<!-- Buttons -->
	<div class="buttons wpb_content_element">
		<div class="invicta_button_wrapper invicta-alignment-left">
			<a class="invicta_button invicta-icon_position-left" href="<?php echo esc_url( home_url() ) ?>">
				<i class="icon-home"></i>
				<?php _e( 'Homepage', 'invicta_dictionary' ); ?>
			</a>
		</div>
		<div class="invicta_button_wrapper invicta-alignment-left">
			<a class="invicta_button invicta-icon_position-left" href="javascript:history.go(-1)">
				<i class="icon-mail-reply"></i>
				<?php _e( 'Previous Page', 'invicta_dictionary' ); ?>
			</a>
		</div>
	</div>

	<div>&nbsp;</div>

</div>
<?php get_footer(); ?>