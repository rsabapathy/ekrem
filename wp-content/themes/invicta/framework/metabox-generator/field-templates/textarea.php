<?php if ( isset( $field['description'] ) && ! empty( $field['description'] ) ) : ?>
	<cite><?php echo $field['description']; ?></cite>
<?php endif; ?>
<p class="field">
	<textarea name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>"><?php echo $current_value?></textarea>
</p>