<?php
$placeholder = !empty( $instance['placeholder'] ) ? $instance['placeholder'] : __( 'Your email', TEXT_DOMAIN );
$button_text = !empty( $instance['button_text'] ) ? $instance['button_text'] : __( 'Subscribe', TEXT_DOMAIN );
$form_class = !empty( $instance['form_class'] ) ? $instance['form_class'] : '';
?>
<form class="navbar-form navbar-subscribe-form <?php echo $form_class ?>" id="<?php echo $args['widget_id'] ?>" method="post" action="<?php echo esc_url( home_url( '/' ) ) ?>">
	<?php wp_nonce_field( 'add_subscriber' ); ?> <!-- Requerido -->
	<input type="hidden" name="action" value="add_subscriber"> <!-- Requerido -->
	<div class="input-group">
		<input type="email" class="form-control" placeholder="<?php echo esc_attr( $placeholder ) ?>" name="subscriber_email">
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit"><?php echo $button_text ?></button>
		</span>
	</div>
</form>

<script>

  jQuery(function () {

      jQuery('#<?php echo $args['widget_id'] ?>').ajaxForm({
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: {
          },
          dataType: 'json',
          beforeSubmit: function (formData, jqForm, options) {
              // optionally process data before submitting the form via AJAX
              jqForm.find('button').attr('disabled', '').text('Enviando');
          },
          success: function (response, statusText, xhr, jqForm) {
              // code that's executed when the request is processed successfully
              if (response.success) {
                  jqForm.find('button').removeAttr('disabled').text('Success!');
              } else {
                  jqForm.find('button').removeAttr('disabled').text('Error!');
              }
          }
      });
  });

</script>