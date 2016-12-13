<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Masonry Brick
 */
if (!is_active_sidebar('masonry-brick-footer-sidebar-one') && !is_active_sidebar('masonry-brick-footer-sidebar-two') && !is_active_sidebar('masonry-brick-footer-sidebar-three')) {
	return;
}
?>

<div id="footer-widgets-area" class="footer-widgets clear">
	<div class="inner-wrap">
		<div class="footer-area-one footer-sidebar-areas">
			<?php
			if (is_active_sidebar('masonry-brick-footer-sidebar-one')) {
				dynamic_sidebar('masonry-brick-footer-sidebar-one');
			}
			?>
		</div>
		<div class="footer-area-two footer-sidebar-areas">
			<?php
			if (is_active_sidebar('masonry-brick-footer-sidebar-two')) {
				dynamic_sidebar('masonry-brick-footer-sidebar-two');
			}
			?>
		</div>
		<div class="footer-area-three footer-sidebar-areas">
			<?php
			if (is_active_sidebar('masonry-brick-footer-sidebar-three')) {
				dynamic_sidebar('masonry-brick-footer-sidebar-three');
			}
			?>
		</div>
	</div>
</div>
