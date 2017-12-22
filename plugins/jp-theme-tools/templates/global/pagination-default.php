<?php
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}

$nav_class = (string) apply_filters( 'jptt_pagination_default_nav_class', 'text-center' );
$ul_class = (string) apply_filters( 'jptt_pagination_default_ul_class', '' );
?>
<nav itemscope itemtype="http://schema.org/SiteNavigationElement" class="<?php echo $nav_class ?>">
		<?php
		$default = array(
				'class' => '',
				'prev_text' => '<span aria-hidden="true">&laquo;</span>',
				'next_text' => '<span aria-hidden="true">&raquo;</span>',
				'type' => 'list',
		);
		$args = (array) apply_filters( 'jptt_pagination_args', $default );
		$paginate = paginate_links( $args );
		$search = array(
				"<ul class='page-numbers'>",
				"<li><span class='page-numbers current'>"
		);
		$replace = array(
				"<ul class='page-numbers pagination {$ul_class}'>",
				"<li class='active'><span class='page-numbers current'>"
		);
		echo str_replace( $search, $replace, $paginate )
		?>
</nav>
