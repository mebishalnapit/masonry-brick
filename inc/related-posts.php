<?php
/**
 * Template to show the related posts of the single posts
 */
?>

<?php $related_posts = masonry_brick_related_posts_function(); ?>

<?php if ($related_posts->have_posts()): ?>
	<div class="related-posts-main">

		<h4 class="related-posts-main-title"><span><?php esc_html_e('Similar Articles', 'masonry-brick'); ?></span></h4>

		<div class="related-posts-total clear">

			<?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
				<div class="related-posts columns">

					<?php if (has_post_thumbnail()): ?>
						<div class="related-posts-thumbnail">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail('masonry-brick-related-posts-thumbnail'); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="related-post-contents">

						<h3 class="entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h3><!-- .entry-title -->

						<div class="entry-meta">
							<?php masonry_brick_posted_on(); ?>
						</div><!-- .entry-meta -->

					</div>

				</div><!--.related-posts-->
			<?php endwhile; ?>

		</div><!-- .related-posts-total -->
	</div><!-- .related-posts-main -->

	<?php wp_reset_postdata(); ?>

<?php endif; ?>
