<?php
/**
 * Formulario de inicio de sesion usando la funcionalidad nativa de WordPress
 * Requiere el plugin JP Theme Tools
 */
?>
<form id="signon-form" method="post" action="<?php echo admin_url('admin-ajax.php') ?>">
  <div class="form-group">
    <label for="user_login" class="required"><?php _e('Email address', 'jp-basic') ?></label>
    <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Your email">
  </div>
  <div class="form-group">
    <label for="user_password" class="required"><?php _e('Password', 'jp-basic') ?></label>
    <input type="password" class="form-control" id="user_password" name="user_password" placeholder="<?php _e('Your password', 'jp-basic') ?>">
  </div>
	<div class="checkbox">
    <label>
      <input type="checkbox" name="remember"> <?php _e('Remember', 'jp-basic') ?>
    </label>
  </div>
	<input type="hidden" name="action" value="user_login">
	<?php wp_nonce_field('user_login') ?>
  <button type="submit" id="register-submit" class="btn btn-default" data-loading-text="<?php _e('Sending...', 'jp-basic') ?>" autocomplete="off"><?php _e('LogIn', 'jp-basic') ?></button>
</form>

<script>
  jQuery(function () {

      jQuery('#signon-form').ajaxForm({
          beforeSubmit: function () {
              jQuery('#signon-submit').button('loading');
          },
          success: function (responseText) {
              // code that's executed when the request is processed successfully
              jQuery('#signon-submit').button('reset');
              if (responseText.success) {
                  console.log(responseText.success);
              } else {
                  console.log('error');
              }
          }
      });
  });
</script>