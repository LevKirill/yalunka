<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" value="<?php echo get_search_query(); ?>" placeholder="<?php _e('Search...', 'yalynka'); ?>" name="s" id="s" />
	<input type="hidden" value="product" name="post_type" />
	<button id="searchsubmit"></button>
</form>