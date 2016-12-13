<?php
/**
 * Template part for displaying the image post format.
 *
 * @package Masonry Brick
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry-content'); ?>>
	<?php do_action('masonry_brick_before_post_content'); ?>

	<?php if (has_post_thumbnail()) { ?>
		<?php
		$image_popup_id = get_post_thumbnail_id();
		$image_popup_url = wp_get_attachment_url($image_popup_id);
		?>

		<figure class="featured-image">
			<?php if (is_single()) : ?>
				<?php if (get_theme_mod('masonry_brick_featured_image_popup', 0) == 1) { ?>
					<a href="<?php echo $image_popup_url; ?>" class="featured-image-popup" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('masonry-brick-featured-full'); ?></a>
				<?php } else { ?>
					<?php the_post_thumbnail('masonry-brick-featured-full'); ?>
				<?php } ?>
			<?php else : ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('masonry-brick-featured-full'); ?></a>
			<?php endif; ?>
		</figure>
	<?php } ?>

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
				the_excerpt(); // displaying excerpt for the archive pages
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
