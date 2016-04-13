<?php if ( isset( $field['description'] ) && ! empty( $field['description'] ) ) : ?>
	<cite><?php echo $field['description']; ?></cite>
<?php endif; ?>
<p class="field">
	<input type="text" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" value="<?php echo $current_value; ?>" />
</p>