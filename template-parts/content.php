<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Masonry Brick
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry-content'); ?>>
	<?php do_action('masonry_brick_before_post_content'); ?>

	<?php if (has_post_thumbnail()) : ?>
		<?php if (!is_single()) : ?>
			<figure class="featured-image">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('masonry-brick-featured-thumbnail'); ?></a>
			</figure>
		<?php endif; ?>
	<?php endif; ?>

	<div class="post-wrapper">
		<header class="entry-header">
			<?php
			if (is_single()) {
				the_title('<h1 class="entry-title">', '</h1>');
			} else {
				the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
			}

			if ('post' === get_post_type()) :
				?>
				<div class="entry-meta">
					<?php masonry_brick_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif;
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			if (is_single()) :
				the_content();
			else :
				if (is_sticky()) :
					// displaying full content for the sticky post
					the_content(sprintf(
									/* translators: %s: Name of current post. */
									wp_kses('<button type="button" class="btn continue-more-link">' . __('Read More <i class="fa fa-arrow-circle-o-right"></i>', 'masonry-brick') . '</button> %s', array('i' => array('class' => array()), 'button' => array('class' => array(), 'type' => array()))), the_title('<span class="screen-reader-text">"', '"</span>', false)
					));
				else :
					the_excerpt(); // displaying excerpt for the archive pages
				endif;
			endif;

			wp_link_pages(array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'masonry-brick'),
				'after' => '</div>',
			));
			?>
		</div><!-- .entry-content -->

		<?php if (is_single()) : ?>
			<footer class="entry-footer">
				<?php masonry_brick_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>

	</div>
	<?php do_action('masonry_brick_after_post_content'); ?>
</article><!-- #post-## -->
