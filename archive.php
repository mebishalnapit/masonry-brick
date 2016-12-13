<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Masonry Brick
 */
get_header();
?>

<?php do_action('masonry_brick_before_body_content'); ?>

<div class="header-title">
	<header class="page-header">
		<?php
		the_archive_title('<h1 class="page-title">', '</h1>');
		the_archive_description('<div class="taxonomy-description">', '</div>');
		?>
	</header><!-- .page-header -->
</div>

<div id="primary" class="content-area main-contents">
	<main id="main" class="site-main" role="main">

		<?php if (have_posts()) : ?>

			<?php
			/* Start the Loop */
			while (have_posts()) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part('template-parts/content', get_post_format());

			endwhile;

		else :

			get_template_part('template-parts/content', 'none');

		endif;
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php the_posts_pagination(array('mid_size' => 5)); ?>

<?php do_action('masonry_brick_after_body_content'); ?>

<?php get_footer(); ?>
