<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Masonry Brick
 */
get_header();
?>

<?php do_action('masonry_brick_before_body_content'); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if (is_active_sidebar('masonry-brick-404-sidebar')) { ?>
			<section class="error-404 not-found sidebar-404">
				<header class="page-header">
					<h1 class="page-title"><span><?php esc_html_e('404 Error!', 'masonry-brick'); ?></span></h1>
				</header><!-- .page-header -->
			</section>
		<?php } ?>

		<?php if (!dynamic_sidebar('masonry-brick-404-sidebar')) : ?>
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e('404 Error!', 'masonry-brick'); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search instead?', 'masonry-brick'); ?></p>

					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php do_action('masonry_brick_after_body_content'); ?>

<?php get_footer(); ?>
