<?php
$args = array(
		'posts_per_page' => -1,
		'post_type' => 'slide'
);
$slides = get_posts( $args );
if (count($slides) == 0) {
	return;
}
?>
<div id="main-carousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
	<ol class="carousel-indicators">
			<?php
			for ( $i = 0; $i < count( $slides ); $i++ ) {
				printf( '<li data-target="#main-carousel" data-slide-to="%d"></li>', $i );
			}
			?>
	</ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
			<?php
			global $post;
			foreach ( $slides as $post ) {
				setup_postdata( $post );
				?>
			<div class="item" role="presentation">
					<?php the_post_thumbnail( 'carousel' ) ?>
				<div class="carousel-caption">
					<div><?php the_content() ?></div>
				</div>
			</div>
			<?php
		}
		?>
	</div>

  <!-- Controls -->
  <a class="left carousel-control" href="#main-carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#main-carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<script>
  jQuery('#main-carousel .carousel-indicators li').first().addClass('active');
  jQuery('#main-carousel .carousel-inner .item').first().addClass('active');
</script>