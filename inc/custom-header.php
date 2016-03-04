<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Masonry Brick
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses masonry_brick_header_style()
 */
function masonry_brick_custom_header_setup() {
    add_theme_support('custom-header', apply_filters('masonry_brick_custom_header_args', array(
        'default-image' => '',
        'default-text-color' => 'fff',
        'width' => 1400,
        'height' => 400,
        'flex-height' => false,
        'wp-head-callback' => 'masonry_brick_header_style',
        'admin-preview-callback' => 'masonry_brick_admin_header_image',
    )));
}

add_action('after_setup_theme', 'masonry_brick_custom_header_setup');

if (!function_exists('masonry_brick_header_style')) :

    /**
     * Styles the header image and text displayed on the blog.
     *
     * @see masonry_brick_custom_header_setup().
     */
    function masonry_brick_header_style() {
        $header_text_color = get_header_textcolor();

        /*
         * If no custom options for text are set, let's bail.
         * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
         */
        if (HEADER_TEXTCOLOR === $header_text_color) {
            return;
        }

        // If we get this far, we have custom styles. Let's do this.
        ?>
        <style type="text/css">
        <?php
// Has the text been hidden?
        if (!display_header_text()) :
            ?>
                .site-branding {
                    position: absolute;
                    clip: rect(1px, 1px, 1px, 1px);
                }
            <?php
// If the user has set a custom color for the text use that.
        else :
            ?>
                .site-title a,
                .site-description {
                    color: #<?php echo esc_attr($header_text_color); ?>;
                }
        <?php endif; ?>
        </style>
        <?php
    }

endif;

if (!function_exists('masonry_brick_admin_header_image')) :

    /**
     * Custom header image markup displayed on the Appearance > Header admin panel.
     *
     * @see masonry_brick_custom_header_setup().
     */
    function masonry_brick_admin_header_image() {
        ?>
        <div id="headimg">
            <h1 class="displaying-header-text">
                <a id="name" style="<?php echo esc_attr('color: #' . get_header_textcolor()); ?>" onclick="return false;" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
            </h1>
            <div class="displaying-header-text" id="desc" style="<?php echo esc_attr('color: #' . get_header_textcolor()); ?>"><?php bloginfo('description'); ?></div>
            <?php if (get_header_image() && ('blank' == get_header_textcolor())) : ?>
                <img src="<?php header_image(); ?>" width="<?php echo esc_attr(get_custom_header()->width); ?>" height="<?php echo esc_attr(get_custom_header()->height); ?>" alt="<?php echo get_bloginfo('name', 'display'); ?>" class="header-image">
            <?php endif; ?>

            <?php
            if (get_header_image() && !('blank' == get_header_textcolor())) :
                echo '<div class="site-branding header-background-image" style="background-image: url(' . get_header_image() . ')">';
            else :
                echo '<div class="site-branding">';
            endif;
            ?>

            <?php masonry_brick_header_text_logo(); // displaying the header text and logo as requirement ?>

            <?php echo '</div>'; ?>

        </div>
        <?php
    }

endif; // masonry_brick_admin_header_image
