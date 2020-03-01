<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Masonry Brick
 */
?>

				</div>
			</div><!-- #content -->

			<?php do_action( 'masonry_brick_before_footer' ); ?>
			<footer id="colophon" class="site-footer" role="contentinfo">
				<?php get_sidebar( 'footer' ); ?>

				<div class="site-info clear">
					<div class="inner-wrap">
						<div class="footer-bottom-area">
							<?php masonry_brick_footer_copyright(); ?>

							<div class="footer-menu">
								<?php
								if ( has_nav_menu( 'footer' ) ) {
									wp_nav_menu( array(
										'theme_location' => 'footer',
										'depth'          => '-1',
										'menu_id'        => 'footer-menu',
									) );
								}
								?>
							</div>
						</div>
					</div>
				</div><!-- .site-info -->
			</footer><!-- #colophon -->

			<a href="#masthead" id="scroll-up"><i class="fa fa-arrow-up"></i></a>
			<?php do_action('masonry_brick_after_footer'); ?>
		</div><!-- #page -->

	<?php wp_footer(); ?>

	</body>
</html>
