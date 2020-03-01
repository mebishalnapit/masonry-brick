<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Masonry Brick
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'masonry_brick_before' ); ?>

<?php
/**
 * WordPress function to load custom scripts after body.
 *
 * Introduced in WordPress 5.2.0
 */
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} else {
	do_action( 'wp_body_open' );
}
?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content">
		<?php esc_html_e( 'Skip to content', 'masonry-brick' ); ?>
	</a>

	<header id="masthead" class="site-header" role="banner">
		<?php if ( ( get_theme_mod( 'masonry_brick_header_text' ) != '' ) || ( has_nav_menu( 'social' ) ) ) : ?>
			<div class="header-top-bar clear">
				<div class="inner-wrap">
					<?php if ( get_theme_mod( 'masonry_brick_header_text' ) != '' ) : ?>
						<div class="small-info-text">
							<?php echo do_shortcode( wp_kses_post( get_theme_mod( 'masonry_brick_header_text' ) ) ); ?>
						</div>
					<?php endif; ?>
					<?php if ( has_nav_menu( 'social' ) ) : ?>
						<div class="social-menu">
							<?php masonry_brick_social_menu(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ( get_header_image() || function_exists( 'the_custom_header_markup' ) ) && ( 'blank' == get_header_textcolor() ) ) : ?>
			<div class="masonry-brick-header-image header-image">
				<?php
				// Display the header video and header image
				if ( function_exists( 'the_custom_header_markup' ) ) :
					the_custom_header_markup();
				else :
					the_header_image_tag();
				endif;
				?>
			</div>
		<?php endif; // End header image check. ?>

		<?php
		if ( get_header_image() && ! ( 'blank' == get_header_textcolor() ) ) :
			echo '<div class="site-branding header-background-image" style="background-image: url(' . get_header_image() . ')">';
		else :
			echo '<div class="site-branding">';
		endif;
		?>

		<?php masonry_brick_header_text_logo(); // displaying the header text and logo as requirement ?>

		<?php echo '</div>'; ?>

		<nav id="site-navigation" class="main-navigation clear" role="navigation">
			<?php if ( get_theme_mod( 'masonry_brick_search_icon_in_menu', 0 ) == 1 ) { ?>
				<div class="search-form-top clear">
					<?php get_search_form(); ?>
				</div>
			<?php } ?>

			<div class="inner-wrap">
				<?php if ( get_theme_mod( 'masonry_brick_search_icon_in_menu', 0 ) == 1 ) { ?>
					<a class="search-toggle">
						<i class="fa fa-search search-top"></i>
					</a>
				<?php } ?>

				<?php
				if ( get_theme_mod( 'masonry_brick_random_post_in_menu', 0 ) == 1 ) {
					echo '<div class="random-post">';
					echo masonry_brick_random_post();
					echo '</div>';
				}
				?>

				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<?php esc_html_e( 'Menu', 'masonry-brick' ); ?>
				</button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<?php do_action( 'masonry_brick_after_header' ); ?>
	<?php do_action( 'masonry_brick_before_main' ); ?>

	<div id="content" class="site-content">
		<div class="inner-wrap">
			<?php if ( ! is_front_page() && function_exists( 'bcn_display' ) ) : ?>
				<div class="breadcrumbs-area">
					<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
						<?php bcn_display(); ?>
					</div>
				</div>
			<?php endif; ?>
