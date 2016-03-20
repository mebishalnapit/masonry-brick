<?php
/**
 * Masonry Brick Theme Customizer.
 *
 * @package Masonry Brick
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function masonry_brick_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    // extending Customizer Class to add the donation link
    class Masonry_Brick_Donate_Link extends WP_Customize_Control {

        public $type = "masonry-brick-donate-link";

        public function render_content() {
            ?>
            <div style="text-align: center;background-color: #fff;padding: 10px;">
                <strong><?php esc_attr_e('If you like our work. Buy us a beer.', 'masonry-brick'); ?></strong>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="3NT8RH73FFM3L">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div>
            <?php
        }

    }

    // adding section for donation link
    $wp_customize->add_section('masonry_brick_donate_section', array(
        'priority' => 1000,
        'title' => esc_html__('Donate Now', 'masonry-brick'),
    ));

    // adding setting for donation link
    $wp_customize->add_setting('masonry_brick_donate', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_donate_sanitize'
    ));

    // adding control for donation link
    $wp_customize->add_control(new Masonry_Brick_Donate_Link($wp_customize, 'masonry_brick_donate', array(
        'section' => 'masonry_brick_donate_section',
        'setting' => 'masonry_brick_donate'
    )));

    // Start of the Header Options
    $wp_customize->add_panel('masonry_brick_header_options', array(
        'capabitity' => 'edit_theme_options',
        'description' => esc_html__('Change the Header Settings from here as you want to best suit your need.', 'masonry-brick'),
        'priority' => 500,
        'title' => esc_html__('Header Options', 'masonry-brick')
    ));

    $wp_customize->add_section('masonry_brick_header_text_setting', array(
        'priority' => 1,
        'title' => esc_html__('Small Info Text', 'masonry-brick'),
        'panel' => 'masonry_brick_header_options'
    ));

    $wp_customize->add_setting('masonry_brick_header_text', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_kses_post'
    ));

    $wp_customize->add_control('masonry_brick_header_text', array(
        'type' => 'textarea',
        'label' => esc_html__('Write your custom text to display it in the header top bar. It also accepts the shortcodes too.', 'masonry-brick'),
        'section' => 'masonry_brick_header_text_setting',
        'settings' => 'masonry_brick_header_text'
    ));

    $wp_customize->add_section('masonry_brick_header_top_bar_activate_setting', array(
        'priority' => 2,
        'title' => esc_html__('Activate Header Top Bar', 'masonry-brick'),
        'panel' => 'masonry_brick_header_options'
    ));

    $wp_customize->add_setting('masonry_brick_header_top_bar_activate', array(
        'default' => 0,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_checkbox_sanitize'
    ));

    $wp_customize->add_control('masonry_brick_header_top_bar_activate', array(
        'type' => 'checkbox',
        'label' => esc_html__('Check to activate the header top bar area. It includes the small info text area and social menu.', 'masonry-brick'),
        'section' => 'masonry_brick_header_top_bar_activate_setting',
        'settings' => 'masonry_brick_header_top_bar_activate'
    ));

    // random posts in menu enable/disable
    $wp_customize->add_section('masonry_brick_random_post_in_menu_section', array(
        'priority' => 3,
        'title' => esc_html__('Random Post', 'masonry-brick'),
        'panel' => 'masonry_brick_header_options'
    ));

    $wp_customize->add_setting('masonry_brick_random_post_in_menu', array(
        'default' => 0,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_checkbox_sanitize'
    ));

    $wp_customize->add_control('masonry_brick_random_post_in_menu', array(
        'type' => 'checkbox',
        'label' => esc_html__('Check to display the random post icon in the primary menu.', 'masonry-brick'),
        'section' => 'masonry_brick_random_post_in_menu_section',
        'settings' => 'masonry_brick_random_post_in_menu'
    ));

    // search icon in menu enable/disable
    $wp_customize->add_section('masonry_brick_search_icon_in_menu_section', array(
        'priority' => 4,
        'title' => esc_html__('Search Icon', 'masonry-brick'),
        'panel' => 'masonry_brick_header_options'
    ));

    $wp_customize->add_setting('masonry_brick_search_icon_in_menu', array(
        'default' => 0,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_checkbox_sanitize'
    ));

    $wp_customize->add_control('masonry_brick_search_icon_in_menu', array(
        'type' => 'checkbox',
        'label' => esc_html__('Check to display the search icon in the primary menu.', 'masonry-brick'),
        'section' => 'masonry_brick_search_icon_in_menu_section',
        'settings' => 'masonry_brick_search_icon_in_menu'
    ));
    // End of the Header Options

    // Start Of Design Options
    $wp_customize->add_panel('masonry_brick_design_options', array(
        'capabitity' => 'edit_theme_options',
        'description' => esc_html__('Change the Design Settings from here as you want to best suit your need.', 'masonry-brick'),
        'priority' => 505,
        'title' => esc_html__('Design Options', 'masonry-brick')
    ));

    // site layout setting
    $wp_customize->add_section('masonry_brick_site_layout_setting', array(
        'priority' => 1,
        'title' => esc_html__('Site Layout', 'masonry-brick'),
        'panel' => 'masonry_brick_design_options'
    ));

    $wp_customize->add_setting('masonry_brick_site_layout', array(
        'default' => 'wide_layout',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_radio_select_sanitize'
    ));

    $wp_customize->add_control('masonry_brick_site_layout', array(
        'type' => 'radio',
        'label' => esc_html__('Choose your site layout. The change is reflected in the whole site.', 'masonry-brick'),
        'choices' => array(
            'boxed_layout' => esc_html__('Boxed Layout', 'masonry-brick'),
            'wide_layout' => esc_html__('Wide Layout', 'masonry-brick')
        ),
        'section' => 'masonry_brick_site_layout_setting'
    ));

    // layout option
    class Masonry_Brick_Image_Radio_Control extends WP_Customize_Control {

        public function render_content() {

            if (empty($this->choices))
                return;

            $name = '_customize-radio-' . $this->id;
            ?>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <ul class="controls" id='masonry-brick-img-container'>
                <?php
                foreach ($this->choices as $value => $label) :
                    $class = ($this->value() == $value) ? 'masonry-brick-radio-img-selected masonry-brick-radio-img-img' : 'masonry-brick-radio-img-img';
                    ?>
                    <li style="display: inline;">
                        <label>
                            <input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr($value); ?>" name="<?php echo esc_attr($name); ?>" <?php
                                                          $this->link();
                                                          checked($this->value(), $value);
                                                          ?> />
                            <img src='<?php echo esc_html($label); ?>' class='<?php echo esc_html($class); ?>' />
                        </label>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
            <?php
        }

    }

    // default layout for pages
    $wp_customize->add_section('masonry_brick_default_page_layout_setting', array(
        'priority' => 2,
        'title' => esc_html__('Default layout for pages', 'masonry-brick'),
        'panel' => 'masonry_brick_design_options'
    ));

    $wp_customize->add_setting('masonry_brick_default_page_layout', array(
        'default' => 'right_sidebar',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_radio_select_sanitize'
    ));

    $wp_customize->add_control(new Masonry_Brick_Image_Radio_Control($wp_customize, 'masonry_brick_default_page_layout', array(
        'type' => 'radio',
        'label' => esc_html__('Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for the specific page.', 'masonry-brick'),
        'section' => 'masonry_brick_default_page_layout_setting',
        'settings' => 'masonry_brick_default_page_layout',
        'choices' => array(
            'right_sidebar' => get_template_directory_uri() . '/img/right-sidebar.png',
            'left_sidebar' => get_template_directory_uri() . '/img/left-sidebar.png',
            'no_sidebar_full_width' => get_template_directory_uri() . '/img/no-sidebar-full-width-layout.png',
            'no_sidebar_content_centered' => get_template_directory_uri() . '/img/no-sidebar-content-centered-layout.png'
        )
    )));

    // default layout for single posts
    $wp_customize->add_section('masonry_brick_default_single_posts_layout_setting', array(
        'priority' => 3,
        'title' => esc_html__('Default layout for single posts', 'masonry-brick'),
        'panel' => 'masonry_brick_design_options'
    ));

    $wp_customize->add_setting('masonry_brick_default_single_posts_layout', array(
        'default' => 'right_sidebar',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_radio_select_sanitize'
    ));

    $wp_customize->add_control(new Masonry_Brick_Image_Radio_Control($wp_customize, 'masonry_brick_default_single_posts_layout', array(
        'type' => 'radio',
        'label' => esc_html__('Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for the specific post.', 'masonry-brick'),
        'section' => 'masonry_brick_default_single_posts_layout_setting',
        'settings' => 'masonry_brick_default_single_posts_layout',
        'choices' => array(
            'right_sidebar' => get_template_directory_uri() . '/img/right-sidebar.png',
            'left_sidebar' => get_template_directory_uri() . '/img/left-sidebar.png',
            'no_sidebar_full_width' => get_template_directory_uri() . '/img/no-sidebar-full-width-layout.png',
            'no_sidebar_content_centered' => get_template_directory_uri() . '/img/no-sidebar-content-centered-layout.png'
        )
    )));

    // custom CSS setting
    $wp_customize->add_section('masonry_brick_custom_css_setting', array(
        'priority' => 4,
        'title' => esc_html__('Custom CSS', 'masonry-brick'),
        'panel' => 'masonry_brick_design_options'
    ));

    $wp_customize->add_setting('masonry_brick_custom_css', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
        'sanitize_js_callback' => 'wp_filter_nohtml_kses'
    ));

    $wp_customize->add_control('masonry_brick_custom_css', array(
        'type' => 'textarea',
        'label' => esc_html__('Write your custom css and design live.', 'masonry-brick'),
        'section' => 'masonry_brick_custom_css_setting',
        'settings' => 'masonry_brick_custom_css'
    ));
    // End Of Design Options

    // Start of Additional Options
    $wp_customize->add_panel('masonry_brick_additional_options', array(
        'capability' => 'edit_theme_options',
        'description' => esc_html__('Change the Additional Settings from here as you want to best suite your site.', 'masonry-brick'),
        'priority' => 515,
        'title' => esc_html__('Additional Options', 'masonry-brick')
    ));

    // related posts
    $wp_customize->add_section('masonry_brick_related_posts_section', array(
        'priority' => 1,
        'title' => esc_html__('Related Posts', 'masonry-brick'),
        'panel' => 'masonry_brick_additional_options'
    ));

    $wp_customize->add_setting('masonry_brick_related_posts_activate', array(
        'default' => 0,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_checkbox_sanitize'
    ));

    $wp_customize->add_control('masonry_brick_related_posts_activate', array(
        'type' => 'checkbox',
        'label' => esc_html__('Check to activate the related posts.', 'masonry-brick'),
        'section' => 'masonry_brick_related_posts_section',
        'settings' => 'masonry_brick_related_posts_activate'
    ));

    $wp_customize->add_setting('masonry_brick_related_posts', array(
        'default' => 'categories',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_radio_select_sanitize'
    ));

    $wp_customize->add_control('masonry_brick_related_posts', array(
        'type' => 'radio',
        'label' => esc_html__('Related Posts To Be Shown As:', 'masonry-brick'),
        'section' => 'masonry_brick_related_posts_section',
        'settings' => 'masonry_brick_related_posts',
        'choices' => array(
            'categories' => esc_html__('Related Posts By Categories', 'masonry-brick'),
            'tags' => esc_html__('Related Posts By Tags', 'masonry-brick')
        )
    ));

    // featured image popup check
    $wp_customize->add_section('masonry_brick_featured_image_popup_setting', array(
        'priority' => 2,
        'title' => esc_html__('Image Lightbox', 'masonry-brick'),
        'panel' => 'masonry_brick_additional_options'
    ));

    $wp_customize->add_setting('masonry_brick_featured_image_popup', array(
        'default' => 0,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_checkbox_sanitize'
    ));

    $wp_customize->add_control('masonry_brick_featured_image_popup', array(
        'type' => 'checkbox',
        'label' => esc_html__('Check to enable the lightbox feature for the featured images in single post page. Note: the post should be of image post format to support this feature, ie, we have supported the featured image in single post page only when image post format is choosen.', 'masonry-brick'),
        'section' => 'masonry_brick_featured_image_popup_setting',
        'settings' => 'masonry_brick_featured_image_popup'
    ));

    // social icons in author bio
    $wp_customize->add_section('masonry_brick_author_bio_social_links_setting', array(
        'priority' => 3,
        'title' => esc_html__('Social Links In Author Bio', 'masonry-brick'),
        'panel' => 'masonry_brick_additional_options'
    ));

    $wp_customize->add_setting('masonry_brick_author_bio_social_links', array(
        'default' => 0,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'masonry_brick_checkbox_sanitize'
    ));

    $wp_customize->add_control('masonry_brick_author_bio_social_links', array(
        'type' => 'checkbox',
        'label' => esc_html__('Check to enable the social links in the Author Bio section. For this to work, you need to add the URL of your social sites in the profile section. This theme supports WordPress SEO and All In One SEO Pack plugin for this feature.', 'masonry-brick'),
        'section' => 'masonry_brick_author_bio_social_links_setting',
        'settings' => 'masonry_brick_author_bio_social_links'
    ));
    // End of Additional Options

    // sanitization works
    // radio/select buttons sanitization
    function masonry_brick_radio_select_sanitize($input, $setting) {
        // Ensuring that the input is a slug.
        $input = sanitize_key($input);
        // Get the list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control($setting->id)->choices;
        // If the input is a valid key, return it, else, return the default.
        return ( array_key_exists($input, $choices) ? $input : $setting->default );
    }

    // checkbox sanitization
    function masonry_brick_checkbox_sanitize($input) {
        if ($input == 1) {
            return 1;
        } else {
            return '';
        }
    }

    // link sanitization
    function masonry_brick_donate_sanitize() {
        return false;
    }

}

add_action('customize_register', 'masonry_brick_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function masonry_brick_customize_preview_js() {
    $suffix = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min';
    wp_enqueue_script('masonry_brick_customizer', get_template_directory_uri() . '/js/customizer' . $suffix . '.js', array('customize-preview'), '20151215', true);
}

add_action('customize_preview_init', 'masonry_brick_customize_preview_js');
