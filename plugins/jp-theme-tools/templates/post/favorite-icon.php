<?php
if ( !is_user_logged_in() && !function_exists( 'is_favorite' ) ) {
	return;
}

$is_favorite = is_favorite();

$icon_class = $is_favorite ? 'glyphicon-heart' : 'glyphicon-heart-empty';
$block_class = $is_favorite ? 'is-favorite' : '';
?>
<a href="#" class="toggle-favorite <?php echo $block_class ?>" data-post="<?php the_ID() ?>"><span class="glyphicon <?php echo $icon_class ?>"></span></a>
