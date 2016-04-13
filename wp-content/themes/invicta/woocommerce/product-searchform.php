<form role="search" id="searchform" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div>
		<label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'woocommerce' ); ?></label>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ); ?>" />
		<button type="submit" id="searchsubmit" class="accentcolor-text-on_hover inherit-color"><i class="icon-search"></i></button>
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>
