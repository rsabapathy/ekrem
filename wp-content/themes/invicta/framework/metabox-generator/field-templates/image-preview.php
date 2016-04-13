<?php if ( isset( $field['description'] ) && ! empty( $field['description'] ) ) : ?>
	<cite><?php echo $field['description']; ?></cite>
<?php endif; ?>
<p class="field">
	<img name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>"  src="<?php echo $current_value; ?>" alt="" />
</p>