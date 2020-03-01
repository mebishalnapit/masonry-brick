<?php

/**
 * Masonry Brick functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Masonry Brick
 */
if ( ! function_exists( 'masonry_brick_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function masonry_brick_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Masonry Brick, use a find and replace
		 * to change 'masonry-brick' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'masonry-brick', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'masonry-brick-featured-thumbnail', 600, 450, true );
		add_image_size( 'masonry-brick-featured-full', 760, 570, true );
		add_image_size( 'masonry-brick-related-posts-thumbnail', 400, 300, true );
		add_image_size( 'masonry-brick-featured-small-thumbnail', 120, 90, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'masonry-brick' ),
			'social'  => esc_html__( 'Social Menu', 'masonry-brick' ),
			'footer'  => esc_html__( 'Footer Menu', 'masonry-brick' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'chat',
			'audio',
			'status',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'masonry_brick_custom_background_args', array(
			'default-color' => 'eaeaea',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add theme support for WooCommerce plugin
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

endif;
add_action( 'after_setup_theme', 'masonry_brick_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function masonry_brick_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'masonry_brick_content_width', 760 );
}

add_action( 'after_setup_theme', 'masonry_brick_content_width', 0 );

/**
 * $content_width global variable adjustment as per layout option.
 */
function masonry_brick_dynamic_content_width() {
	global $post;
	global $content_width;

	$masonry_brick_layout_meta = get_post_meta( $post->ID, 'masonry_brick_page_layout', true );

	if ( empty( $masonry_brick_layout_meta ) ) {
		$masonry_brick_layout_meta = 'default_layout';
	}

	$masonry_brick_default_page_layout = get_theme_mod( 'masonry_brick_default_page_layout', 'right_sidebar' );
	$masonry_brick_default_post_layout = get_theme_mod( 'masonry_brick_default_single_posts_layout', 'right_sidebar' );

	if ( $masonry_brick_layout_meta == 'default_layout' ) {
		if ( is_page() ) {
			if ( $masonry_brick_default_page_layout == 'no_sidebar_full_width' ) {
				$content_width = 1160; /* pixels */
			} else {
				$content_width = 760; /* pixels */
			}
		} elseif ( is_single() ) {
			if ( $masonry_brick_default_post_layout == 'no_sidebar_full_width' ) {
				$content_width = 1160; /* pixels */
			} else {
				$content_width = 760; /* pixels */
			}
		}
	} elseif ( $masonry_brick_layout_meta == 'no_sidebar_full_width' ) {
		$content_width = 1160; /* pixels */
	} else {
		$content_width = 760; /* pixels */
	}
}

add_action( 'template_redirect', 'masonry_brick_dynamic_content_width' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function masonry_brick_widgets_init() {
	// registering the right sidebar area
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'masonry-brick' ),
		'id'            => 'masonry-brick-right-sidebar',
		'description'   => esc_html__( 'Display your widgets in the Right Sidebar Area.', 'masonry-brick' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	// registering the left sidebar area
	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'masonry-brick' ),
		'id'            => 'masonry-brick-left-sidebar',
		'description'   => esc_html__( 'Display your widgets in the Left Sidebar Area.', 'masonry-brick' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	// registering the 404 page sidebar area
	register_sidebar( array(
		'name'          => esc_html__( '404 Sidebar', 'masonry-brick' ),
		'id'            => 'masonry-brick-404-sidebar',
		'description'   => esc_html__( 'Display your widgets in the 404 Error Page Sidebar Area.', 'masonry-brick' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	// registering the contact page sidebar area
	register_sidebar( array(
		'name'          => esc_html__( 'Contact Page Sidebar', 'masonry-brick' ),
		'id'            => 'masonry-brick-contact-page-sidebar',
		'description'   => esc_html__( 'Display your widgets in the Contact Page Sidebar Area.', 'masonry-brick' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	// registering the footer sidebar one area
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar One', 'masonry-brick' ),
		'id'            => 'masonry-brick-footer-sidebar-one',
		'description'   => esc_html__( 'Display your widgets in the Footer Sidebar Area One.', 'masonry-brick' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	// registering the footer sidebar two area
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Two', 'masonry-brick' ),
		'id'            => 'masonry-brick-footer-sidebar-two',
		'description'   => esc_html__( 'Display your widgets in the Footer Sidebar Area Two.', 'masonry-brick' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	// registering the footer sidebar three area
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Three', 'masonry-brick' ),
		'id'            => 'masonry-brick-footer-sidebar-three',
		'description'   => esc_html__( 'Display your widgets in the Footer Sidebar Area Three.', 'masonry-brick' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	register_widget( 'Masonry_Brick_Random_Posts_Widget' );
	register_widget( 'Masonry_Brick_Tabbed_Widget' );
}

add_action( 'widgets_init', 'masonry_brick_widgets_init' );

/* * ************************************************************************************* */

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'masonry_brick_fonts_url' ) ) {

	// Using google font
	// creating the function for adding the google font url
	function masonry_brick_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';
		// applying the translators for the Google Fonts used
		/* Translators: If there are characters in your language that are not
		 * supported by Roboto, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'masonry-brick' ) ) {
			$fonts[] = 'Roboto:400,400italic,700,700italic';
		}

		/* Translators: If there are characters in your language that are not
		 * supported by Lobster, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Lobster font: on or off', 'masonry-brick' ) ) {
			$fonts[] = 'Lobster';
		}

		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'cyrillic'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset ( cyrillic, greek, vietnamese )', 'masonry-brick' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' == $subset ) {
			$subsets .= ',greek-ext,greek';
		} elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		// Ready to enqueue Google Font
		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}

}
// completion of enqueue for the google font

/**
 * Enqueue scripts and styles.
 */
function masonry_brick_scripts() {

	// adding the function to load the minified version if SCRIPT_DEFUG is disable
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// use of enqueued google fonts
	wp_enqueue_style( 'masonry-brick-google-fonts', masonry_brick_fonts_url(), array(), null );

	wp_enqueue_style( 'masonry-brick-style', get_stylesheet_uri() );

	// enqueueing the fontawesome icons
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/fontawesome/css/font-awesome' . $suffix . '.css' );

	// enqueueing the fitvids javascript file
	wp_enqueue_script( 'jquery-fitvids', get_template_directory_uri() . '/js/fitvids/jquery.fitvids' . $suffix . '.js', array( 'jquery' ), false, true );

	wp_enqueue_script( 'masonry-brick-navigation', get_template_directory_uri() . '/js/navigation' . $suffix . '.js', array(), '20151215', true );

	wp_enqueue_script( 'masonry-brick-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . $suffix . '.js', array(), '20151215', true );

	// enqueueing the masonry script
	if ( ( is_home() || is_search() || is_archive() ) && ! ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	// enqueueing the bxslider script
	if ( has_post_format( 'gallery' ) || is_home() || is_search() || is_archive() ) {
		wp_enqueue_script( 'jquery-bxslider', get_template_directory_uri() . '/js/jquery.bxslider/jquery.bxslider' . $suffix . '.js', array( 'jquery' ), null, true );
	}

	// enueueing sticky script
	if ( get_theme_mod( 'masonry_brick_sticky_menu', 0 ) == 1 ) {
		wp_enqueue_script( 'jquery-sticky', get_template_directory_uri() . '/js/sticky/jquery.sticky' . $suffix . '.js', array( 'jquery' ), false, true );
	}

	// enqueueing magnific popup
	if ( ( get_theme_mod( 'masonry_brick_featured_image_popup', 0 ) == 1 ) && has_post_format( 'image' ) && has_post_thumbnail() ) {
		wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/magnific-popup/jquery.magnific-popup' . $suffix . '.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/js/magnific-popup/magnific-popup' . $suffix . '.css' );
	}

	// enqueueing sticky content and sidebar area required js files
	if ( get_theme_mod( 'masonry_brick_sticky_sidebar_content', 0 ) == 1 ) {
		wp_enqueue_script( 'ResizeSensor', get_template_directory_uri() . '/js/theia-sticky-sidebar/ResizeSensor' . $suffix . '.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar/theia-sticky-sidebar' . $suffix . '.js', array( 'jquery' ), false, true );
	}

	// enqueueing the theme's main javascript file
	wp_enqueue_script( 'masonry-brick-main-script', get_template_directory_uri() . '/js/masonry-brick-custom' . $suffix . '.js', array( 'jquery' ), null, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// loading the HTML5Shiv js for IE8 and below
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv/html5shiv' . $suffix . '.js', false );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
}

add_action( 'wp_enqueue_scripts', 'masonry_brick_scripts' );

/**
 * Enqueue scripts and styles in the customizer
 */
function masonry_brick_customizer_scripts() {
	// adding the function to load the minified version if SCRIPT_DEFUG is disable
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'masonry-brick-customizer-layout-option-css', get_template_directory_uri() . '/css/custom-layout' . $suffix . '.css' );
	wp_enqueue_script( 'masonry-brick-customizer-layout-option', get_template_directory_uri() . '/js/custom-layout' . $suffix . '.js', false, false, true );
}

add_action( 'customize_controls_enqueue_scripts', 'masonry_brick_customizer_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add the custom meta box for the single post/page layout option
 */
require get_template_directory() . '/inc/meta-boxes.php';

/**
 * Add the required custom widgets
 */
require get_template_directory() . '/inc/widgets.php';
