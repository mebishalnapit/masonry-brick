<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Masonry Brick
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function masonry_brick_body_classes( $classes ) {
// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}

add_filter( 'body_class', 'masonry_brick_body_classes' );

/**
 * function to display the logo and text in header
 */
if ( ! function_exists( 'masonry_brick_header_text_logo' ) ) :

	function masonry_brick_header_text_logo() {
		?>

		<div class="site-title-box">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php endif;
			?>
		</div>
		<?php
	}

endif;

/*
 * Creating Social Menu
 */
if ( ! function_exists( 'masonry_brick_social_menu' ) ) :

	function masonry_brick_social_menu() {
		if ( has_nav_menu( 'social' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'social',
					'container'       => 'div',
					'container_id'    => 'main-menu-social',
					'container_class' => 'masonry-brick-social-menu',
					'depth'           => 1,
					'menu_id'         => 'menu-social',
					'fallback_cb'     => false,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
		}
	}

endif;

/*
 * Random Post in header
 */
if ( ! function_exists( 'masonry_brick_random_post' ) ) :

	function masonry_brick_random_post() {

		$get_random_post = new WP_Query(
			array(
				'posts_per_page'      => 1,
				'post_type'           => 'post',
				'ignore_sticky_posts' => true,
				'orderby'             => 'rand',
			)
		);
		?>
		<?php while ( $get_random_post->have_posts() ):$get_random_post->the_post(); ?>
			<?php return '<a href="' . esc_url( get_the_permalink() ) . '" title="' . esc_html__( 'Random Post', 'masonry-brick' ) . '"><i class="fa fa-random"></i></a>'; ?>
		<?php endwhile; ?>
		<?php
		// Reset Post Data
		wp_reset_postdata();
	}

endif;

add_action( 'masonry_brick_footer_copyright', 'masonry_brick_footer_copyright', 10 );
/**
 * function to show the footer info, copyright information
 */
if ( ! function_exists( 'masonry_brick_footer_copyright' ) ) :

	function masonry_brick_footer_copyright() {
		$site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';

		$wp_link = '<a href="' . esc_url( 'https://wordpress.org' ) . '" target="_blank" title="' . esc_attr__( 'WordPress', 'masonry-brick' ) . '"><span>' . esc_html__( 'WordPress', 'masonry-brick' ) . '</span></a>';

		$my_link_name = '<a href="' . esc_url( 'https://napitwptech.com/themes/masonry-brick/' ) . '" target="_blank" title="' . esc_attr__( 'Bishal Napit', 'masonry-brick' ) . '"><span>' . esc_html__( 'Bishal Napit', 'masonry-brick' ) . '</span></a>';

		$default_footer_value = sprintf( esc_html__( 'Copyright &copy; %1$s %2$s.', 'masonry-brick' ), date( 'Y' ), $site_link ) . ' ' . sprintf( esc_html__( 'Theme: %1$s by %2$s.', 'masonry-brick' ), esc_html__( 'Masonry Brick', 'masonry-brick' ), $my_link_name ) . ' ' . sprintf( esc_html__( 'Powered by %s.', 'masonry-brick' ), $wp_link );

		$masonry_brick_footer_copyright = '<div class="footer-copyright">' . $default_footer_value . '</div>';
		echo $masonry_brick_footer_copyright;
	}

endif;

add_filter( 'body_class', 'masonry_brick_body_class' );

/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function masonry_brick_body_class( $classes ) {

	// custom layout options for posts and pages
	global $post;

	if ( $post ) {
		$masonry_brick_layout_meta = get_post_meta( $post->ID, 'masonry_brick_page_layout', true );
	}

	if ( empty( $masonry_brick_layout_meta ) ) {
		$masonry_brick_layout_meta = 'default_layout';
	}

	$masonry_brick_default_page_layout = get_theme_mod( 'masonry_brick_default_page_layout', 'right_sidebar' );
	$masonry_brick_default_post_layout = get_theme_mod( 'masonry_brick_default_single_posts_layout', 'right_sidebar' );

	if ( $masonry_brick_layout_meta == 'default_layout' ) {
		if ( is_page() ) {
			if ( $masonry_brick_default_page_layout == 'right_sidebar' ) {
				$classes[] = 'right-sidebar';
			} elseif ( $masonry_brick_default_page_layout == 'left_sidebar' ) {
				$classes[] = 'left-sidebar';
			} elseif ( $masonry_brick_default_page_layout == 'no_sidebar_full_width' ) {
				$classes[] = 'no-sidebar-full-width';
			} elseif ( $masonry_brick_default_page_layout == 'no_sidebar_content_centered' ) {
				$classes[] = 'no-sidebar-content-centered';
			}
		} elseif ( is_single() ) {
			if ( $masonry_brick_default_post_layout == 'right_sidebar' ) {
				$classes[] = 'right-sidebar';
			} elseif ( $masonry_brick_default_post_layout == 'left_sidebar' ) {
				$classes[] = 'left-sidebar';
			} elseif ( $masonry_brick_default_post_layout == 'no_sidebar_full_width' ) {
				$classes[] = 'no-sidebar-full-width';
			} elseif ( $masonry_brick_default_post_layout == 'no_sidebar_content_centered' ) {
				$classes[] = 'no-sidebar-content-centered';
			}
		}
	} elseif ( $masonry_brick_layout_meta == 'right_sidebar' ) {
		$classes[] = 'right-sidebar';
	} elseif ( $masonry_brick_layout_meta == 'left_sidebar' ) {
		$classes[] = 'left-sidebar';
	} elseif ( $masonry_brick_layout_meta == 'no_sidebar_full_width' ) {
		$classes[] = 'no-sidebar-full-width';
	} elseif ( $masonry_brick_layout_meta == 'no_sidebar_content_centered' ) {
		$classes[] = 'no-sidebar-content-centered';
	}

	// custom layout option for site
	if ( get_theme_mod( 'masonry_brick_site_layout', 'wide_layout' ) == 'wide_layout' ) {
		$classes[] = 'wide';
	} elseif ( get_theme_mod( 'masonry_brick_site_layout', 'wide_layout' ) == 'boxed_layout' ) {
		$classes[] = 'boxed';
	}

	return $classes;
}

/*
 * function to display the sidebar according to layout choosed
 */
if ( ! function_exists( 'masonry_brick_sidebar_select' ) ) :

	function masonry_brick_sidebar_select() {
		global $post;

		if ( $post ) {
			$masonry_brick_layout_meta = get_post_meta( $post->ID, 'masonry_brick_page_layout', true );
		}

		if ( empty( $masonry_brick_layout_meta ) ) {
			$masonry_brick_layout_meta = 'default_layout';
		}

		$masonry_brick_default_page_layout = get_theme_mod( 'masonry_brick_default_page_layout', 'right_sidebar' );
		$masonry_brick_default_post_layout = get_theme_mod( 'masonry_brick_default_single_posts_layout', 'right_sidebar' );

		if ( $masonry_brick_layout_meta == 'default_layout' ) {
			if ( is_page() ) {
				if ( $masonry_brick_default_page_layout == 'right_sidebar' ) {
					get_sidebar();
				} elseif ( $masonry_brick_default_page_layout == 'left_sidebar' ) {
					get_sidebar( 'left' );
				}
			} elseif ( is_single() ) {
				if ( $masonry_brick_default_post_layout == 'right_sidebar' ) {
					get_sidebar();
				} elseif ( $masonry_brick_default_post_layout == 'left_sidebar' ) {
					get_sidebar( 'left' );
				}
			}
		} elseif ( $masonry_brick_layout_meta == 'right_sidebar' ) {
			get_sidebar();
		} elseif ( $masonry_brick_layout_meta == 'left_sidebar' ) {
			get_sidebar( 'left' );
		}
	}

endif;

add_action( 'wp_head', 'masonry_brick_custom_css', 100 );

/**
 * Hooks the Custom Internal CSS to head section
 */
function masonry_brick_custom_css() {
	// changing color options
	$masonry_brick_custom_options_color = '';
	$primary_color                      = esc_html( get_theme_mod( 'masonry_brick_primary_color', '#4169E1' ) );
	if ( $primary_color != '#4169E1' ) {
		$masonry_brick_custom_options_color .= '.site-title-box{background:rgba(' . masonry_brick_hex2rgb( $primary_color ) . ')}.format-gallery .slide-next,.format-gallery .slide-prev{background-color:rgba(' . masonry_brick_hex2rgb( $primary_color ) . ')}.bypostauthor>.comment-body .fn:after,.comment-awaiting-moderation,.format-chat .chat-details,.format-gallery .slide-next:hover,.format-gallery .slide-prev:hover,.format-link .link-details,.format-status .status-details,.main-navigation .current-menu-ancestor>a,.main-navigation .current-menu-item>a,.main-navigation .current_page_ancestor>a,.main-navigation .current_page_item>a,.main-navigation li.focus>a,.main-navigation li:hover>a,.nav-links .page-numbers.current,.nav-links .page-numbers:hover,.quote-details,.site-branding,.sticky,blockquote{background-color:' . $primary_color . '}#menu-social li a:before,.comment-author .fn a:hover:before,.comments-area .comment-meta .edit-link a:hover:before,.footer-copyright a,.footer-sidebar-areas a:hover,.widget_archive li a:hover:before,.widget_categories li a:hover:before,.widget_nav_menu li a:hover:before,.widget_pages li a:hover:before,.widget_recent_comments li:hover:before,.widget_recent_entries li a:hover:before,.widget_rss li a:hover:before,a#scroll-up i,a:hover{color:' . $primary_color . '}td,th,tr{border:2px solid ' . $primary_color . '}button,input[type=button],input[type=reset],input[type=submit],.wp-custom-header-video-button{border:1px solid ' . $primary_color . ';background:' . $primary_color . '}.navigation.pagination .nav-links{border-top:2px solid ' . $primary_color . '}.footer-widgets,.site-info{border-top:4px solid ' . $primary_color . '}.comment-respond .form-submit input[type=submit]{background:' . $primary_color . '}.wp-caption{border:1px solid ' . $primary_color . '}@media screen and (max-width:768px){.social-menu,ul#footer-menu{border-top:1px solid ' . $primary_color . '}}';
	}

	// color change options code
	if ( ! empty( $masonry_brick_custom_options_color ) ) {
		echo '<!-- ' . get_bloginfo( 'name' ) . ' Internal Styles -->';
		?>
		<style type="text/css"><?php echo strip_tags( $masonry_brick_custom_options_color ); ?></style>
		<?php
	}
}

/**
 * Controlling the excerpt length
 */
function masonry_brick_excerpt_length( $length ) {
	return 24;
}

add_filter( 'excerpt_length', 'masonry_brick_excerpt_length' );

/**
 * Controlling the excerpt string
 */
function masonry_brick_excerpt_string( $more ) {
	return '&hellip;';
}

add_filter( 'excerpt_more', 'masonry_brick_excerpt_string' );

/*
 * Display the related posts
 */
if ( ! function_exists( 'masonry_brick_related_posts_function' ) ) :

	function masonry_brick_related_posts_function() {
		global $post;

		// Define shared post arguments
		$args = array(
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => 1,
			'orderby'                => 'rand',
			'post__not_in'           => array( $post->ID ),
			'posts_per_page'         => 3,
		);

		// Related by categories
		if ( get_theme_mod( 'masonry_brick_related_posts', 'categories' ) == 'categories' ) {
			$cats                 = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
			$args['category__in'] = $cats;
		}

		// Related by tags
		if ( get_theme_mod( 'masonry_brick_related_posts', 'categories' ) == 'tags' ) {
			$tags            = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
			$args['tag__in'] = $tags;

			// If no tags added, return
			if ( ! $tags ) {
				$break = true;
			}
		}

		$query = ! isset( $break ) ? new WP_Query( $args ) : new WP_Query;

		return $query;
	}

endif;

/**
 * function to add the social links in the Author Bio section
 */
if ( ! function_exists( 'masonry_brick_author_bio_links' ) ) :

	function masonry_brick_author_bio_links() {
		$author_name = get_the_author_meta( 'display_name' );

		// pulling the author social links url which are provided through WordPress SEO and All In One SEO Pack plugin
		$author_facebook_link   = get_the_author_meta( 'facebook' );
		$author_twitter_link    = get_the_author_meta( 'twitter' );
		$author_googleplus_link = get_the_author_meta( 'googleplus' );

		if ( $author_twitter_link || $author_googleplus_link || $author_facebook_link ) {
			echo '<div class="author-social-links">';
			printf( esc_html__( 'Follow %s on:', 'masonry-brick' ), $author_name );
			if ( $author_facebook_link ) {
				echo '<a href="' . esc_url( $author_facebook_link ) . '" title="' . esc_html__( 'Facebook', 'masonry-brick' ) . '" target="_blank"><i class="fa fa-facebook"></i><span class="screen-reader-text">' . esc_html__( 'Facebook', 'masonry-brick' ) . '</span></a>';
			}
			if ( $author_twitter_link ) {
				echo '<a href="https://twitter.com/' . esc_attr( $author_twitter_link ) . '" title="' . esc_html__( 'Twitter', 'masonry-brick' ) . '" target="_blank"><i class="fa fa-twitter"></i><span class="screen-reader-text">' . esc_html__( 'Twitter', 'masonry-brick' ) . '</span></a>';
			}
			if ( $author_googleplus_link ) {
				echo '<a href="' . esc_url( $author_googleplus_link ) . '" title="' . esc_html__( 'Google Plus', 'masonry-brick' ) . '" rel="author" target="_blank"><i class="fa fa-google-plus"></i><span class="screen-reader-text">' . esc_html__( 'Google Plus', 'masonry-brick' ) . '</span></a>';
			}
			echo '</div>';
		}
	}

endif;

// link post format support added
if ( ! function_exists( 'masonry_brick_link_post_format' ) ) :

	function masonry_brick_link_post_format() {
		if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) ) {
			return false;
		}

		return esc_url_raw( $matches[1] );
	}

endif;

// audio and video post format support added
if ( ! function_exists( 'masonry_brick_audio_video_post_format' ) ) :

	function masonry_brick_audio_video_post_format() {
		$document = new DOMDocument();
		$content  = apply_filters( 'the_content', get_the_content( '', true ) );
		if ( '' != $content ) {
			libxml_use_internal_errors( true );
			$document->loadHTML( $content );
			libxml_clear_errors();
			$iframes  = $document->getElementsByTagName( 'iframe' );
			$objects  = $document->getElementsByTagName( 'object' );
			$embeds   = $document->getElementsByTagName( 'embed' );
			$document = new DOMDocument();
			if ( $iframes->length ) {
				$iframe = $iframes->item( $iframes->length - 1 );
				$document->appendChild( $document->importNode( $iframe, true ) );
			} elseif ( $objects->length ) {
				$object = $objects->item( $objects->length - 1 );
				$document->appendChild( $document->importNode( $object, true ) );
			} elseif ( $embeds->length ) {
				$embed = $embeds->item( $embeds->length - 1 );
				$document->appendChild( $document->importNode( $embed, true ) );
			}

			return wpautop( $document->saveHTML() );
		}

		return false;
	}

endif;

// status post format support added
if ( ! function_exists( 'masonry_brick_status_post_format_first_paragraph' ) ) :

	function masonry_brick_status_post_format_first_paragraph() {
		$first_paragraph_str = wpautop( get_the_content() );
		$first_paragraph_str = substr( $first_paragraph_str, 0, strpos( $first_paragraph_str, '</p>' ) + 4 );
		$first_paragraph_str = strip_tags( $first_paragraph_str, '<a><strong><em>' );

		return '<p>' . $first_paragraph_str . '</p>';
	}

endif;

if ( ! function_exists( 'masonry_brick_status_post_format_avatar_image' ) ) :

	function masonry_brick_status_post_format_avatar_image() {
		return get_avatar( get_the_author_meta( 'user_email' ), '75' );
	}

endif;

// quote post format support added
if ( ! function_exists( 'masonry_brick_quote_post_format_blockquote' ) ) :

	function masonry_brick_quote_post_format_blockquote() {

		$document = new DOMDocument();
		$content  = apply_filters( 'the_content', get_the_content( '', true ) );
		$output   = '';
		if ( '' != $content ) {
			libxml_use_internal_errors( true );
			$document->loadHTML( mb_convert_encoding( $content, 'html-entities', 'utf-8' ) );
			libxml_clear_errors();
			$blockquotes = $document->getElementsByTagName( 'blockquote' );
			if ( $blockquotes->length ) {
				$blockquote = $blockquotes->item( 0 );
				$document   = new DOMDocument();
				$document->appendChild( $document->importNode( $blockquote, true ) );
				$output .= $document->saveHTML();
			}
		}

		return wpautop( $output );
	}

endif;

// function to display the rgb value of hex color code
if ( ! function_exists( 'masonry_brick_hex2rgb' ) ) :

	function masonry_brick_hex2rgb( $color ) {
		$color = trim( $color, '#' );

		if ( strlen( $color ) === 3 ) {
			$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
			$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
			$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
		} elseif ( strlen( $color ) === 6 ) {
			$r = hexdec( substr( $color, 0, 2 ) );
			$g = hexdec( substr( $color, 2, 2 ) );
			$b = hexdec( substr( $color, 4, 2 ) );
		} else {
			return array();
		}

		$rgb = array( $r, $g, $b, 0.7 );

		return implode( ',', $rgb ); // returns the rgb values separated by commas
	}

endif;

/**
 * Migrate any existing theme CSS codes added in Customize Options to the core option added in WordPress 4.7
 */
function masonry_brick_custom_css_migrate() {
	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		$custom_css = get_theme_mod( 'masonry_brick_custom_css' );
		if ( $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return   = wp_update_custom_css_post( $core_css . $custom_css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'masonry_brick_custom_css' );
			}
		}
	}
}

add_action( 'after_setup_theme', 'masonry_brick_custom_css_migrate' );

/**
 * Make theme WooCommerce plugin compatible
 */
// Remove WooCommerce default wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
// Remove WooCommerce default sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
// Remove WooCommerce Breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

// Add theme wrapper for WooCommerce pages
add_action( 'woocommerce_before_main_content', 'masonry_brick_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'masonry_brick_wrapper_end', 10 );

function masonry_brick_wrapper_start() {
	echo '<div id="primary" class="content-area"><main id="main" class="site-main" role="main">';
}

function masonry_brick_wrapper_end() {
	echo '</main></div><!-- #primary -->';
	masonry_brick_sidebar_select();
}

if ( ! function_exists( 'masonry_brick_pingback_header' ) ) :

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	function masonry_brick_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

endif;

add_action( 'wp_head', 'masonry_brick_pingback_header' );
