<?php
$placeholder = !empty( $instance['placeholder'] ) ? $instance['placeholder'] : __( 'Search', TEXT_DOMAIN );
$button_text = !empty( $instance['button_text'] ) ? $instance['button_text'] : __( 'Search', TEXT_DOMAIN );
$form_class = !empty( $instance['form_class'] ) ? $instance['form_class'] : '';
?>
<form class="sidebar-search-form <?php echo $form_class ?>" id="<?php echo $args['widget_id'] ?>" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" itemscope itemtype="http://schema.org/SearchAction">
	<div class="input-group">
		<input type="text" class="form-control" placeholder="<?php echo esc_attr( $placeholder ) ?>" name="s" value="<?php echo get_search_query() ?>">
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit"><?php echo $button_text ?></button>
		</span>
	</div>
</form>