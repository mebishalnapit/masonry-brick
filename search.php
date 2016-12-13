<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Masonry Brick
 */
get_header();
?>

<?php do_action('masonry_brick_before_body_content'); ?>

<div class="header-title">
	<header class="page-header">
		<h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'masonry-brick'), '<span>' . get_search_query() . '</span>'); ?></h1>
	</header><!-- .page-header -->
</div>

<div id="primary" class="content-area main-contents">
	<main id="main" class="site-main" role="main">

		<?php if (have_posts()) : ?>

			<?php
			/* Start the Loop */
			while (have_posts()) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
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
