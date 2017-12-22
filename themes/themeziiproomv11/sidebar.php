<aside itemscope itemprop="http://www.schema.org/WPSideBar" role="complementary">
	<?php if ( is_active_sidebar( 'main-sidebar' ) ) { ?>
		<div id="widget-area" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'main-sidebar' ); ?>
		</div><!-- .widget-area -->
	<?php } ?>
</aside>
