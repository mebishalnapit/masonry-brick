<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Masonry Brick
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php do_action('masonry_brick_before'); ?>
        <div id="page" class="site">
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'masonry-brick'); ?></a>

            <header id="masthead" class="site-header" role="banner">
                <?php if ((get_theme_mod('masonry_brick_header_text') != '') || (has_nav_menu('social'))) : ?>
                    <div class="header-top-bar clear">
                        <div class="inner-wrap">
                            <?php if (get_theme_mod('masonry_brick_header_text') != '') : ?>
                                <div class="small-info-text">
                                    <?php echo do_shortcode(wp_kses_post(get_theme_mod('masonry_brick_header_text'))); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (has_nav_menu('social')) : ?>
                                <div class="social-menu">
                                    <?php masonry_brick_social_menu(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (get_header_image() && ('blank' == get_header_textcolor())) : ?>
                    <img src="<?php header_image(); ?>" width="<?php echo esc_attr(get_custom_header()->width); ?>" height="<?php echo esc_attr(get_custom_header()->height); ?>" alt="<?php echo get_bloginfo('name', 'display'); ?>" class="header-image">
                <?php endif; // End header image check. ?>

                <?php
                if (get_header_image() && !('blank' == get_header_textcolor())) :
                    echo '<div class="site-branding header-background-image" style="background-image: url(' . get_header_image() . ')">';
                else :
                    echo '<div class="site-branding">';
                endif;
                ?>

                <?php masonry_brick_header_text_logo(); // displaying the header text and logo as requirement ?>

                <?php echo '</div>'; ?>

                <?php if (get_theme_mod('masonry_brick_search_icon_in_menu', 0) == 1) { ?>
                    <div class="search-form-top clear">
                        <?php get_search_form(); ?>
                    </div>
                <?php } ?>

                <nav id="site-navigation" class="main-navigation clear" role="navigation">
                    <div class="inner-wrap">
                        <?php if (get_theme_mod('masonry_brick_search_icon_in_menu', 0) == 1) { ?>
                            <a class="search-toggle">
                                <i class="fa fa-search search-top"></i>
                            </a>
                        <?php } ?>

                        <?php
                        if (get_theme_mod('masonry_brick_random_post_in_menu', 0) == 1) {
                            echo '<div class="random-post">';
                            masonry_brick_random_post();
                            echo '</div>';
                        }
                        ?>

                        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e('Menu', 'masonry-brick'); ?></button>
                        <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_id' => 'primary-menu')); ?>
                    </div>
                </nav><!-- #site-navigation -->
            </header><!-- #masthead -->

            <?php do_action('masonry_brick_after_header'); ?>
            <?php do_action('masonry_brick_before_main'); ?>

            <div id="content" class="site-content">
                <div class="inner-wrap">
