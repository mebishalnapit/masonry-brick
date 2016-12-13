<?php
/**
 * Template part for displaying the gallery post format.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Masonry Brick
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry-content'); ?>>
	<?php do_action('masonry_brick_before_post_content'); ?>

	<?php if (get_post_gallery()) : ?>
		<ul id="gallery-slider" class="gallery-slider">
			<?php
			$output = '';
			$galleries = get_post_gallery($post, false);
			$attachment_ids = explode(",", $galleries['ids']);
			$i = 1;
			foreach ($attachment_ids as $attachment_id) {
				// displaying the attached image of gallery
				$link = wp_get_attachment_image($attachment_id, 'masonry-brick-featured-full');
				$output .= '<li class="slider-images">' . $link . '</li>';
				$i++;
			}
			echo $output;
			?>
		</ul>
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
