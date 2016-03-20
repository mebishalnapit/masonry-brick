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
 * @return array
 */
function masonry_brick_body_classes($classes) {
// Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

// Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}

add_filter('body_class', 'masonry_brick_body_classes');

/**
 * function to display the logo and text in header
 */
if (!function_exists('masonry_brick_header_text_logo')) :

    function masonry_brick_header_text_logo() {
        ?>

        <div class="site-title-box">
            <?php if (is_front_page() && is_home()) : ?>
                <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
            <?php
            endif;
            $description = get_bloginfo('description', 'display');
            if ($description || is_customize_preview()) :
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
if (!function_exists('masonry_brick_social_menu')) :

    function masonry_brick_social_menu() {
        if (has_nav_menu('social')) {
            wp_nav_menu(
                    array(
                        'theme_location' => 'social',
                        'container' => 'div',
                        'container_id' => 'main-menu-social',
                        'container_class' => 'masonry-brick-social-menu',
                        'depth' => 1,
                        'menu_id' => 'menu-social',
                        'fallback_cb' => false,
                        'link_before' => '<span class="screen-reader-text">',
                        'link_after' => '</span>',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    )
            );
        }
    }

endif;

/*
 * Random Post in header
 */
if (!function_exists('masonry_brick_random_post')) :

    function masonry_brick_random_post() {
        $get_random_post = new WP_Query(array(
            'posts_per_page' => 1,
            'post_type' => 'post',
            'ignore_sticky_posts' => true,
            'orderby' => 'rand'
        ));
        ?>
        <?php while ($get_random_post->have_posts()):$get_random_post->the_post(); ?>
            <a href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Random Post', 'masonry-brick' ); ?>"><i class="fa fa-random"></i></a>
        <?php endwhile; ?>
        <?php
        // Reset Post Data
        wp_reset_postdata();
    }

endif;

add_action('masonry_brick_footer_copyright', 'masonry_brick_footer_copyright', 10);
/**
 * function to show the footer info, copyright information
 */
if (!function_exists('masonry_brick_footer_copyright')) :

    function masonry_brick_footer_copyright() {
        $site_link = '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name', 'display')) . '" ><span>' . get_bloginfo('name', 'display') . '</span></a>';

        $wp_link = '<a href="http://wordpress.org" target="_blank" title="' . esc_attr__('WordPress', 'masonry-brick') . '"><span>' . esc_html__('WordPress', 'masonry-brick') . '</span></a>';

        $my_link_name = '<a href="http://napitwptech.com" target="_blank" title="' . esc_attr__('Bishal Napit', 'masonry-brick') . '"><span>' . esc_html__('Bishal Napit', 'masonry-brick') . '</span></a>';

        $default_footer_value = sprintf(esc_html__('Copyright &copy; %1$s %2$s.', 'masonry-brick'), date('Y'), $site_link) . ' ' . sprintf(esc_html__('Theme: %1$s by %2$s.', 'masonry-brick'), esc_html__('Masonry Brick', 'masonry-brick'), $my_link_name) . ' ' . sprintf(esc_html__('Powered by %s.', 'masonry-brick'), $wp_link);

        $masonry_brick_footer_copyright = '<div class="footer-copyright">' . $default_footer_value . '</div>';
        echo $masonry_brick_footer_copyright;
    }

endif;

add_filter('body_class', 'masonry_brick_body_class');
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function masonry_brick_body_class($classes) {

    // custom layout options for posts and pages
    global $post;

    if ($post) {
        $masonry_brick_layout_meta = get_post_meta($post->ID, 'masonry_brick_page_layout', true);
    }

    if (empty($masonry_brick_layout_meta)) {
        $masonry_brick_layout_meta = 'default_layout';
    }

    $masonry_brick_default_page_layout = get_theme_mod('masonry_brick_default_page_layout', 'right_sidebar');
    $masonry_brick_default_post_layout = get_theme_mod('masonry_brick_default_single_posts_layout', 'right_sidebar');

    if ($masonry_brick_layout_meta == 'default_layout') {
        if (is_page()) {
            if ($masonry_brick_default_page_layout == 'right_sidebar') {
                $classes[] = 'right-sidebar';
            } elseif ($masonry_brick_default_page_layout == 'left_sidebar') {
                $classes[] = 'left-sidebar';
            } elseif ($masonry_brick_default_page_layout == 'no_sidebar_full_width') {
                $classes[] = 'no-sidebar-full-width';
            } elseif ($masonry_brick_default_page_layout == 'no_sidebar_content_centered') {
                $classes[] = 'no-sidebar-content-centered';
            }
        } elseif (is_single()) {
            if ($masonry_brick_default_post_layout == 'right_sidebar') {
                $classes[] = 'right-sidebar';
            } elseif ($masonry_brick_default_post_layout == 'left_sidebar') {
                $classes[] = 'left-sidebar';
            } elseif ($masonry_brick_default_post_layout == 'no_sidebar_full_width') {
                $classes[] = 'no-sidebar-full-width';
            } elseif ($masonry_brick_default_post_layout == 'no_sidebar_content_centered') {
                $classes[] = 'no-sidebar-content-centered';
            }
        }
    } elseif ($masonry_brick_layout_meta == 'right_sidebar') {
        $classes[] = 'right-sidebar';
    } elseif ($masonry_brick_layout_meta == 'left_sidebar') {
        $classes[] = 'left-sidebar';
    } elseif ($masonry_brick_layout_meta == 'no_sidebar_full_width') {
        $classes[] = 'no-sidebar-full-width';
    } elseif ($masonry_brick_layout_meta == 'no_sidebar_content_centered') {
        $classes[] = 'no-sidebar-content-centered';
    }

    // custom layout option for site
    if (get_theme_mod('masonry_brick_site_layout', 'wide_layout') == 'wide_layout') {
        $classes[] = 'wide';
    } elseif (get_theme_mod('masonry_brick_site_layout', 'wide_layout') == 'boxed_layout') {
        $classes[] = 'boxed';
    }

    return $classes;
}

/*
 * function to display the sidebar according to layout choosed
 */
if (!function_exists('masonry_brick_sidebar_select')) :

    function masonry_brick_sidebar_select() {
        global $post;

        if ($post) {
            $masonry_brick_layout_meta = get_post_meta($post->ID, 'masonry_brick_page_layout', true);
        }

        if (empty($masonry_brick_layout_meta)) {
            $masonry_brick_layout_meta = 'default_layout';
        }

        $masonry_brick_default_page_layout = get_theme_mod('masonry_brick_default_page_layout', 'right_sidebar');
        $masonry_brick_default_post_layout = get_theme_mod('masonry_brick_default_single_posts_layout', 'right_sidebar');

        if ($masonry_brick_layout_meta == 'default_layout') {
            if (is_page()) {
                if ($masonry_brick_default_page_layout == 'right_sidebar') {
                    get_sidebar();
                } elseif ($masonry_brick_default_page_layout == 'left_sidebar') {
                    get_sidebar('left');
                }
            } elseif (is_single()) {
                if ($masonry_brick_default_post_layout == 'right_sidebar') {
                    get_sidebar();
                } elseif ($masonry_brick_default_post_layout == 'left_sidebar') {
                    get_sidebar('left');
                }
            }
        } elseif ($masonry_brick_layout_meta == 'right_sidebar') {
            get_sidebar();
        } elseif ($masonry_brick_layout_meta == 'left_sidebar') {
            get_sidebar('left');
        }
    }

endif;

add_action('wp_head', 'masonry_brick_custom_css');

/**
 * Hooks the Custom Internal CSS to head section
 */
function masonry_brick_custom_css() {
    // custom CSS codes goes here
    $masonry_brick_custom_css = get_theme_mod('masonry_brick_custom_css', '');
    if (!empty($masonry_brick_custom_css)) {
        echo '<!-- ' . get_bloginfo('name') . ' Custom Styles -->';
        ?><style type="text/css"><?php echo esc_html($masonry_brick_custom_css); ?></style><?php
    }
}

/**
 * Controlling the excerpt length
 */
function masonry_brick_excerpt_length($length) {
    return 24;
}

add_filter('excerpt_length', 'masonry_brick_excerpt_length');

/**
 * Controlling the excerpt string
 */
function masonry_brick_excerpt_string($more) {
    return '&hellip;';
}

add_filter('excerpt_more', 'masonry_brick_excerpt_string');

/*
 * Display the related posts
 */
if (!function_exists('masonry_brick_related_posts_function')) :

    function masonry_brick_related_posts_function() {
        global $post;

        // Define shared post arguments
        $args = array(
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'ignore_sticky_posts' => 1,
            'orderby' => 'rand',
            'post__not_in' => array($post->ID),
            'posts_per_page' => 3
        );
        // Related by categories
        if (get_theme_mod('masonry_brick_related_posts', 'categories') == 'categories') {

            $cats = get_post_meta($post->ID, 'related-posts', true);

            if (!$cats) {
                $cats = wp_get_post_categories($post->ID, array('fields' => 'ids'));
                $args['category__in'] = $cats;
            } else {
                $args['cat'] = $cats;
            }
        }
        // Related by tags
        if (get_theme_mod('masonry_brick_related_posts', 'categories') == 'tags') {

            $tags = get_post_meta($post->ID, 'related-posts', true);

            if (!$tags) {
                $tags = wp_get_post_tags($post->ID, array('fields' => 'ids'));
                $args['tag__in'] = $tags;
            } else {
                $args['tag_slug__in'] = explode(',', $tags);
            }
            if (!$tags) {
                $break = true;
            }
        }

        $query = !isset($break) ? new WP_Query($args) : new WP_Query;
        return $query;
    }

endif;

/**
 * function to add the social links in the Author Bio section
 */
if (!function_exists('masonry_brick_author_bio_links')) :

    function masonry_brick_author_bio_links() {
        $author_name = get_the_author_meta('display_name');

        // pulling the author social links url which are provided through WordPress SEO and All In One SEO Pack plugin
        $author_facebook_link = get_the_author_meta('facebook');
        $author_twitter_link = get_the_author_meta('twitter');
        $author_googleplus_link = get_the_author_meta('googleplus');

        if ($author_twitter_link || $author_googleplus_link || $author_facebook_link) {
            echo '<div class="author-social-links">';
            printf(esc_html__('Follow %s on:', 'masonry-brick'), $author_name);
            if ($author_facebook_link) {
                echo '<a href="' . esc_url($author_facebook_link) . '" title="' . esc_html__('Facebook', 'masonry-brick') . '" target="_blank"><i class="fa fa-facebook"></i><span class="screen-reader-text">' . esc_html__('Facebook', 'masonry-brick') . '</span></a>';
            }
            if ($author_twitter_link) {
                echo '<a href="https://twitter.com/' . esc_attr($author_twitter_link) . '" title="' . esc_html__('Twitter', 'masonry-brick') . '" target="_blank"><i class="fa fa-twitter"></i><span class="screen-reader-text">' . esc_html__('Twitter', 'masonry-brick') . '</span></a>';
            }
            if ($author_googleplus_link) {
                echo '<a href="' . esc_url($author_googleplus_link) . '" title="' . esc_html__('Google Plus', 'masonry-brick') . '" rel="author" target="_blank"><i class="fa fa-google-plus"></i><span class="screen-reader-text">' . esc_html__('Google Plus', 'masonry-brick') . '</span></a>';
            }
            echo '</div>';
        }
    }

endif;

/*
 * Adding the custom meta box for supporting the post formats in this theme
 */
if (!function_exists('masonry_brick_post_format_meta_box')) :

    function masonry_brick_post_format_meta_box() {
        add_meta_box('post-video-url', esc_html__('Video URL', 'masonry-brick'), 'masonry_brick_post_format_video_url', 'post', 'side', 'high');
        add_meta_box('post-audio-url', esc_html__('Audio URL', 'masonry-brick'), 'masonry_brick_post_format_audio_url', 'post', 'side', 'high');
        add_meta_box('post-status', esc_html__('Status', 'masonry-brick'), 'masonry_brick_post_format_status', 'post', 'side', 'high');
        add_meta_box('post-chat', esc_html__('Chat', 'masonry-brick'), 'masonry_brick_post_format_chat', 'post', 'side', 'high');
        // adding link text boxes
        add_meta_box('post-link-text', esc_html__('Link Text', 'masonry-brick'), 'masonry_brick_post_format_link_text', 'post', 'side', 'high');
        add_meta_box('post-link-url', esc_html__('Link URL', 'masonry-brick'), 'masonry_brick_post_format_link_url', 'post', 'side', 'high');
        // adding quote text boxes
        add_meta_box('post-quote-text', esc_html__('Quote Text', 'masonry-brick'), 'masonry_brick_post_format_quote_text', 'post', 'side', 'high');
        add_meta_box('post-quote-author', esc_html__('Quote Author', 'masonry-brick'), 'masonry_brick_post_format_quote_author', 'post', 'side', 'high');
    }

endif;

add_action('add_meta_boxes', 'masonry_brick_post_format_meta_box');

// creating the required text box for the video url for the video post format
function masonry_brick_post_format_video_url($post) {
    $video_post_id = get_post_custom($post->ID);
    $video_post_url = isset($video_post_id['masonry_brick_video_url']) ? esc_url($video_post_id['masonry_brick_video_url'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="masonry_brick_video_url" id="masonry_brick_video_url" value="<?php echo esc_url($video_post_url); ?>" />
    </p>
    <?php
}

// creating the required text box for the audio url for the audio post format
function masonry_brick_post_format_audio_url($post) {
    $audio_post_id = get_post_custom($post->ID);
    $audio_post_url = isset($audio_post_id['masonry_brick_audio_url']) ? esc_url($audio_post_id['masonry_brick_audio_url'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="masonry_brick_audio_url" id="masonry_brick_audio_url" value="<?php echo esc_url($audio_post_url); ?>" />
    </p>
    <?php
}

// creating the required textarea for the status post format
function masonry_brick_post_format_status($post) {
    $status_post_id = get_post_custom($post->ID);
    $status_post_text = isset($status_post_id['masonry_brick_status_text']) ? esc_attr($status_post_id['masonry_brick_status_text'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <textarea class="widefat" rows="5" cols="20" name="masonry_brick_status_text" id="masonry_brick_status_text"><?php echo esc_html($status_post_text); ?></textarea>
    </p>
    <?php
}

// creating the required textarea for the chat post format
function masonry_brick_post_format_chat($post) {
    $chat_post_id = get_post_custom($post->ID);
    $chat_post_text = isset($chat_post_id['masonry_brick_chat_text']) ? esc_attr($chat_post_id['masonry_brick_chat_text'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <textarea class="widefat" rows="5" cols="20" name="masonry_brick_chat_text" id="masonry_brick_chat_text"><?php echo esc_textarea($chat_post_text); ?></textarea>
    </p>
    <?php
}

// creating the required text box for the link text for the link post format
function masonry_brick_post_format_link_text($post) {
    $link_post_id = get_post_custom($post->ID);
    $link_post_text = isset($link_post_id['masonry_brick_link_text']) ? esc_attr($link_post_id['masonry_brick_link_text'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="masonry_brick_link_text" id="masonry_brick_link_text" value="<?php echo esc_html($link_post_text); ?>" />
    </p>
    <?php
}

// creating the required text box for the link url for the link post format
function masonry_brick_post_format_link_url($post) {
    $link_post_id = get_post_custom($post->ID);
    $link_post_url = isset($link_post_id['masonry_brick_link_url']) ? esc_url($link_post_id['masonry_brick_link_url'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="masonry_brick_link_url" id="masonry_brick_link_url" value="<?php echo esc_url($link_post_url); ?>" />
    </p>
    <?php
}

// creating the required textarea for the text used in the quote post format
function masonry_brick_post_format_quote_text($post) {
    $quote_post_id = get_post_custom($post->ID);
    $quote_post_text = isset($quote_post_id['masonry_brick_quote_text']) ? esc_attr($quote_post_id['masonry_brick_quote_text'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <textarea class="widefat" rows="5" cols="20" name="masonry_brick_quote_text" id="masonry_brick_quote_text"><?php echo esc_textarea($quote_post_text); ?></textarea>
    </p>
    <?php
}

// creating the required text box for the quote author for the quote post format
function masonry_brick_post_format_quote_author($post) {
    $quote_post_id = get_post_custom($post->ID);
    $quote_post_author = isset($quote_post_id['masonry_brick_quote_author']) ? esc_attr($quote_post_id['masonry_brick_quote_author'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="masonry_brick_quote_author" id="masonry_brick_quote_author" value="<?php echo esc_html($quote_post_author); ?>" />
    </p>
    <?php
}

/*
 * Saving the custom meta box data for post format in the post editor
 */
if (!function_exists('masonry_brick_post_meta_save')) :

    function masonry_brick_post_meta_save($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        // checking if the nonce isn't there, or we can't verify it, then we should return
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'my_meta_box_nonce'))
            return;

        // checking if the current user can't edit this post, then we should return
        if (!current_user_can('edit_posts'))
            return;

        // saving the data in meta box
        // saving the video url in the meta box
        if (isset($_POST['masonry_brick_video_url'])) {
            update_post_meta($post_id, 'masonry_brick_video_url', esc_url_raw($_POST['masonry_brick_video_url']));
        }
        // saving the audio url in the meta box
        if (isset($_POST['masonry_brick_audio_url'])) {
            update_post_meta($post_id, 'masonry_brick_audio_url', esc_url_raw($_POST['masonry_brick_audio_url']));
        }
        // saving the status text in the meta box
        if (isset($_POST['masonry_brick_status_text'])) {
            update_post_meta($post_id, 'masonry_brick_status_text', wp_filter_nohtml_kses($_POST['masonry_brick_status_text']));
        }
        // saving the chat text in the meta box
        if (isset($_POST['masonry_brick_chat_text'])) {
            update_post_meta($post_id, 'masonry_brick_chat_text', wp_filter_nohtml_kses($_POST['masonry_brick_chat_text']));
        }
        // saving the link text in the meta box
        if (isset($_POST['masonry_brick_link_text'])) {
            update_post_meta($post_id, 'masonry_brick_link_text', wp_filter_nohtml_kses($_POST['masonry_brick_link_text']));
        }
        // saving the link url in the meta box
        if (isset($_POST['masonry_brick_link_url'])) {
            update_post_meta($post_id, 'masonry_brick_link_url', esc_url_raw($_POST['masonry_brick_link_url']));
        }
        // saving the quote text in the meta box
        if (isset($_POST['masonry_brick_quote_text'])) {
            update_post_meta($post_id, 'masonry_brick_quote_text', wp_filter_nohtml_kses($_POST['masonry_brick_quote_text']));
        }
        // saving the quote author in the meta box
        if (isset($_POST['masonry_brick_quote_author'])) {
            update_post_meta($post_id, 'masonry_brick_quote_author', wp_filter_nohtml_kses($_POST['masonry_brick_quote_author']));
        }
    }

endif;

add_action('save_post', 'masonry_brick_post_meta_save');
