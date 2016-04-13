<?php 
	
	global $smof_data;
	
	// datasources
	
	$patterns_path = 'http://themes.oitentaecinco.com/assets/invicta/patterns/';
	$patterns[] = $patterns_path . '0-none.png';
	$patterns[] = $patterns_path . '5.png';
	$patterns[] = $patterns_path . '7.png';
	$patterns[] = $patterns_path . '8.png';
	$patterns[] = $patterns_path . '12.png';
	$patterns[] = $patterns_path . '16.png';
	$patterns[] = $patterns_path . '17.png';
	$patterns[] = $patterns_path . '19.png';
	
	$images_path = 'http://themes.oitentaecinco.com/assets/invicta/images/';
	$images[] = $images_path . '0-none.png';
	$images[] = $images_path . '1.jpg';
	$images[] = $images_path . '2.jpg';
	$images[] = $images_path . '3.jpg';
	$images_thumbs[] = $images_path . '0-none-thumb.png';
	$images_thumbs[] = $images_path . '1-thumb.jpg';
	$images_thumbs[] = $images_path . '2-thumb.jpg';
	$images_thumbs[] = $images_path . '3-thumb.jpg';
	
	// default values
	
	$defaults['boxed_layout'] = $smof_data['styling-boxed_layout'];
	$defaults['pattern'] = basename( $smof_data['styling-boxed_layout-background_pattern'] );
	$defaults['image'] = basename( $smof_data['styling-boxed_layout-background_image'] );
	$defaults['color'] = $smof_data['colors-accent'];
	
?>
<div class="invicta_style_switcher">
	
	<a href="#" class="toggler">
		<span class="visible">
			<i class="icon-angle-left"></i>
		</span>
		<span class="invisible">
			<i class="icon-cogs"></i>
		</span>
	</a>
	
	<div class="header">Style Switcher</div>
	
	<div class="body">
	
		<!-- Accent Color -->
		<div class="group">
			<label>Accent Color</label>
			<input id="color" type="text" value="<?php echo $defaults['color']; ?>" />
		</div>
	
		<!-- Layout Style -->
		<div class="group">
			<label>Layout Style</label>
			<select id="layout_style">
				<option value="stretched" <?php selected( $defaults['boxed_layout'], false ); ?>>Stretched Layout</option>
				<option value="boxed" <?php selected( $defaults['boxed_layout'], true ); ?>>Boxed Layout</option>
			</select>
		</div>
		
		<!-- Patterns -->
		<div class="group">
			<label>Patterns (Boxed Layout)</label>
			<ul id="pattern" class="patterns">
				<?php foreach ( $patterns as $pattern ) : ?>
				<li>
					<?php if ( basename( $pattern ) == $defaults['pattern'] ) : ?> 
					<a href="#" style="background:url(<?php echo $pattern; ?>)" data-url="<?php echo $pattern; ?>" data-basename="<?php echo basename( $pattern ); ?>" class="active"></a>
					<?php else : ?>
					<a href="#" style="background:url(<?php echo $pattern; ?>)" data-url="<?php echo $pattern; ?>" data-basename="<?php echo basename( $pattern ); ?>"></a>
					<?php endif; ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<!-- Images -->
		<div class="group">
			<label>Images (Boxed Layout)</label>
			<ul id="image" class="patterns">
				<?php for ( $i = 0; $i < sizeof($images); $i++ ) : ?>
				<li>
					<?php if ( basename( $images[$i] ) == $defaults['image'] ) : ?> 
					<a href="#" data-url="<?php echo $images[$i]; ?>" data-basename="<?php echo basename( $images[$i] ); ?>" class="active">
						<img src="<?php echo $images_thumbs[$i]; ?>" alt="" />
					</a>
					<?php else : ?>
					<a href="#" data-url="<?php echo $images[$i]; ?>" data-basename="<?php echo basename( $images[$i] ); ?>">
						<img src="<?php echo $images_thumbs[$i]; ?>" alt="" />
					</a>
					<?php endif; ?>
				</li>	
				<?php endfor; ?>
			</ul>
		</div>
		
		<!-- Notes -->
		<div class="group">
			<cite>This are just some of the many styling options available on the theme</cite>
		</div>
		
		<div class="group action">
			<a id="reset" href="#" class="invicta_button invicta-color-silver invicta-icon_position-left"><i class="icon-remove-sign"></i>Reset Styles</a>
		</div>
	
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('.invicta_style_switcher').invicta_style_switcher();
		});
	</script>
	
</div>