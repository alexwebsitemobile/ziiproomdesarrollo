<?php
/**
 * Breadcrumb
 *
 */
if ( is_home() || !function_exists( 'get_breadcrumb' ) ) {
	return;
}

$breadcrumb = get_breadcrumb();

if ( empty( $breadcrumb ) ) {
	return;
}
$count = count( $breadcrumb );
?>
<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
	<?php
	$i = 0;
	foreach ( $breadcrumb as $name => $permalink ) {
		$i++;
		$is_last_item = (bool) ( $i < $count );
		$class = $is_last_item ? 'class="active"' : '';
		?>
		<li <?php echo $class; ?> itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<?php
				if ( $is_last_item ) {
					printf( '<a itemprop="item" href="%s"><span itemprop="name">%s</span></a>', $permalink, $name );
				} else {
					printf( '<span itemprop="item"><span itemprop="name">%s</span></span>', $name );
				}
				?>
		</li>
		<?php
	}
	?>
</ul><!-- .breadcrumb -->
