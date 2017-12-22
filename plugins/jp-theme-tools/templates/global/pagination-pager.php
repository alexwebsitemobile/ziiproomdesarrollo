<?php
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

//var_dump( !(is_archive() || is_home() || is_singular()) && is_page() );
// var_dump( $wp_query );

if ( !(is_archive() || is_home() || is_singular() ) || is_page()) {
	return;
}

$nav_class = (string) apply_filters( 'jptt_pagination_pager_nav_class', '' );
$ul_class = (string) apply_filters( 'jptt_pagination_pager_ul_class', 'pager' );
?>
<nav itemscope itemtype="http://schema.org/SiteNavigationElement" class="<?php echo $nav_class ?>">
	<ul class="<?php echo $ul_class ?>">
		<li class="previous"><?php is_singular() ? previous_post_link( '%link', '&laquo; %title' ) : previous_posts_link() ?></li>
		<li class="next"><?php is_singular() ? next_post_link( '%link', '%title &raquo;' ) : next_posts_link() ?></li>
	</ul>
</nav>
