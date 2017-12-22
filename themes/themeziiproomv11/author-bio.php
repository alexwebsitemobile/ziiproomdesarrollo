<div itemscope itemtype="http://schema.org/Person">
	<meta itemprop="url" content="<?php the_author_posts_link() ?>">
	<span itemprop="name"><?php the_author() ?></span>
	<img src="janedoe.jpg" itemprop="image" />
	<div itemprop="description"><?php the_author_meta( 'description' ); ?></div>
</div>