<?php 
	
	global $smof_data;
	global $post;
	
	$thumbnails_limit = 10;
	$photo_width = PHOTO_GALLERY__PHOTO_WIDTH;
	$photo_height = PHOTO_GALLERY__PHOTO_HEIGHT;
	
	// get photo ids from post embeded galleries
	
	$photo_ids = array();
	
	$featured_image_id = get_post_thumbnail_id();
	if ( $featured_image_id ) {
		$photo_ids[] = $featured_image_id;
	}
	
	if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $post->post_content, $matches ) ) {
		
		$num_shortcodes = count( $matches[3] );
		
		for ( $i = 0; $i < $num_shortcodes; $i++ ) {
		
			if ( $matches[2][$i] == 'gallery' ) {
		
				$atts = shortcode_parse_atts( $matches[3][$i] );
				
				if ( isset( $atts[ 'ids' ] ) ) {
					$attachment_ids = explode( ',', $atts[ 'ids' ] );
					$photo_ids = array_merge( $photo_ids, $attachment_ids );
				}
				
			}
		}
		
	}
	
	$photo_ids = array_values( array_unique( $photo_ids, SORT_REGULAR ) );
	
	// get photo urls
	
	$num_photos = count( $photo_ids );
	
	$main_photo_url = '';
	$thumbnail_urls = array();
	
	if ( $num_photos > 0 ) {
		
		$main_photo_url = wp_get_attachment_url( $photo_ids[0], 'full' );
		
		if ( $num_photos > 1 ) {
			for ( $i = 1; $i < $num_photos; $i++ ) {
				if ( $i <= $thumbnails_limit ) {
					
					$photo_url = wp_get_attachment_url( $photo_ids[ $i ], 'full' );
					
					if ( $resized_photo_url = aq_resize( $photo_url, 100, 80, true, true, false ) ) {
						$photo_url = $resized_photo_url;
					}
					
					$thumbnail_urls[] = $photo_url;
					
				}
				else {
					break;
				}
			}
		}
		
	}
	
	// adjust main photo
	
	if ( $resized_main_photo_url = aq_resize( $main_photo_url, $photo_width, $photo_height, true, true, false ) ) {
		$main_photo_url = $resized_main_photo_url;
	}
	
	// adjust thumbnails set
	// 		if we have less than $thumbnails_limit, we will duplicate some thumbnails
	
	if ( count( $thumbnail_urls ) > 0 ) {
		$counter = 0;
		for ( $i = count( $thumbnail_urls ); $i < $thumbnails_limit; $i++ ) {
			$thumbnail_urls[] = $thumbnail_urls[ $counter++ ];
			
		}
	}
	
	// categories
	
	$categories = '';
	
	foreach ( wp_get_post_terms( $post->ID, 'invicta_photos_category' ) as $category ) {
		$category_slugs[] = esc_attr( $category->slug );
	}
	
	if ( isset( $category_slugs ) && ! empty( $category_slugs ) ) {
		$categories = ' ' . join( ' ' , $category_slugs );
	}
	
?>
<?php if ( $num_photos > 0 ) : ?>
<article id="photo_gallery-<?php the_ID(); ?>" <?php post_class('entry photo_gallery_hover_effect accentcolor-border-on_hover' . $categories ); ?>>

	<a href="<?php the_permalink(); ?>" class="invicta_hover_effect gallery_photos">
		<span class="element">
			<img src="<?php echo $main_photo_url; ?>" alt="<?php echo esc_attr( get_the_title() ) ?>" class="main" />
			<?php foreach ( $thumbnail_urls as $thumbnail_url ) : ?>
				<img src="<?php echo $thumbnail_url; ?>" alt="<?php echo esc_attr( get_the_title() ) ?>" class="thumbnail" />
			<?php endforeach; ?>
		</span>
		<span class="mask">
			<span class="caption">
				<span class="title">
					<i class="icon-link"></i>
				</span>
			</span>
		</span>
	</a>
	
	<div class="meta">
		<div class="title">
			<?php the_title(); ?>
		</div>
		<div class="description">
			<span>
				<?php echo $num_photos; ?>
				<?php echo _n( 'photo', 'photos', $num_photos, 'invicta_dictionary' ); ?>
			</span>
		</div>
	</div>
	
</article>
<?php endif; ?>