<form class="small-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" itemscope itemtype="http://schema.org/SearchAction">
	<div class="input-group">
		<input type="text" class="form-control" placeholder="<?php _e( 'Search', JPTT_TEXTDOMAIN ) ?>" name="s" value="<?php echo get_search_query() ?>">
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
		</span>
	</div>
</form>