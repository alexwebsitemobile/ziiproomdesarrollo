<?php
if ( !is_active_sidebar( 'main-navbar' ) ) {
	return;
}

$position = get_theme_settings( 'main-navbar', 'position' ) ? : '';
$wrapper = (!in_array( $position, array( 'navbar-static-top', 'navbar-fixed-top' ) )) ? 'container' : '';
$container = get_theme_settings( 'main-navbar', 'container' ) ? : 'container';
$container = !empty( $wrapper ) ? '.fluid-container' : $container;
$inverse = (bool) get_theme_settings( 'main-navbar', 'inverse' ) ? 'navbar-inverse' : '';
do_action( 'before_main_navbar' );
?>
<div class="<?php echo $wrapper ?>" id="main-navbar">
	<nav class="navbar navbar-default <?php echo $inverse . ' ' . $position ?>">
		<div class="<?php echo $container ?>">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-main-navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Project name</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-main-navbar">

				<?php
				/** Main Navbar */
				dynamic_sidebar( 'main-navbar' );
				?>

			</div>
		</div>
	</nav>
</div>
<?php
do_action( 'after_main_navbar' );
?>
<script>
  if (jQuery('#main-navbar > nav').hasClass('navbar-fixed-top')) {
      jQuery('body').addClass('fixed-navbar');
  }
</script>
