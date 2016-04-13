<p class="field">
	<input type="checkbox" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" <?php checked($current_value, 'true')?> value="true" />
	<?php if ( isset( $field['description'] ) && ! empty( $field['description'] ) ) : ?>
		<cite><?php echo $field['description']; ?></cite>
	<?php endif; ?>
</p>