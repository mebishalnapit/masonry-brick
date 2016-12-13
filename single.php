<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Masonry Brick
 */
get_header();
?>

<?php do_action('masonry_brick_before_body_content'); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		while (have_posts()) : the_post();

			get_template_part('template-parts/content', get_post_format());

			the_post_navigation();
			?>

			<?php if (get_the_author_meta('description')) : ?>
				<div class="author-box">
					<div class="author-img"><?php echo get_avatar(get_the_author_meta('user_email'), '100'); ?></div>
					<h3 class="author-name"><?php esc_html(the_author_meta('display_name')); ?></h3>
					<p class="author-description"><?php esc_textarea(the_author_meta('description')); ?></p>
					<?php
					if (get_theme_mod('masonry_brick_author_bio_social_links', 0) == 1) {
						masonry_brick_author_bio_links();
					}
					?>
				</div>
			<?php endif; ?>

			<?php
			if (get_theme_mod('masonry_brick_related_posts_activate', 0) == 1) {
				get_template_part('inc/related-posts');
			}
			?>

			<?php
			do_action('masonry_brick_before_comments_template');
			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php masonry_brick_sidebar_select(); ?>

<?php do_action('masonry_brick_after_body_content'); ?>

<?php get_footer(); ?>
