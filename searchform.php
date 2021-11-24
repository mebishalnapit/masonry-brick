<?php
/**
 * Displays the searchform of the theme.
 *
 * @package Masonry Brick
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'masonry-brick' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search for&hellip;', 'masonry-brick' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php esc_attr_e( 'Search for:', 'masonry-brick' ); ?>" />
	</label>
</form>
