<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Masonry Brick
 */
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php do_action('masonry_brick_before_sidebar'); ?>

	<?php
	if (is_page_template('page-template/contact.php')) {
		$sidebar = 'masonry-brick-contact-page-sidebar';
	} else {
		$sidebar = 'masonry-brick-left-sidebar';
	}
	?>

	<?php
	if (!dynamic_sidebar($sidebar)) :
		if ($sidebar == 'masonry-brick-contact-page-sidebar') {
			$sidebar_display_text = esc_html__('Contact Page', 'masonry-brick');
		} else {
			$sidebar_display_text = esc_html__('Left', 'masonry-brick');
		}

		// displaying the default widget text if no widget is associated with it
		the_widget('WP_Widget_Text', array(
			'title' => esc_html__('Example Widget', 'masonry-brick'),
			'text' => sprintf(esc_html__('This is an example widget to show how the %s Sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin area. If the custom widget is added in this sidebar, then, this will be replaced by those widgets.', 'masonry-brick'), $sidebar_display_text, current_user_can('edit_theme_options') ? '<a href="' . esc_url(admin_url('widgets.php')) . '">' : '', current_user_can('edit_theme_options') ? '</a>' : '' ),
			'filter' => true,
				), array(
			'before_widget' => '<section class="widget widget_text">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>'
				)
		);
	endif;
	?>

	<?php do_action('masonry_brick_after_sidebar'); ?>
</aside><!-- #secondary -->
