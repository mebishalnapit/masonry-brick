<?php

/**
 * Contains all the widgets parts included in the theme
 *
 * @package Maonry Brick
 */
class Masonry_Brick_Random_Posts_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'masonry_brick_random_posts_widget', esc_html__('MB: Random Posts Widget', 'masonry-brick'), // Name of the widget
                array('description' => esc_html__('Displays the random posts from your site.', 'masonry-brick')) // Arguments of the widget, here it is provided with the description
        );
    }

    function form($instance) {
        $number = !empty($instance['number']) ? $instance['number'] : 4;
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'masonry-brick'); ?></label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_textarea($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number of random posts to display:', 'masonry-brick'); ?></label> 
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo absint($number); ?>" size="3">
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['number'] = (!empty($new_instance['number']) ) ? absint($new_instance['number']) : 4;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    function widget($args, $instance) {
        $number = (!empty($instance['number']) ) ? $instance['number'] : 4;
        $title = isset($instance['title']) ? $instance['title'] : '';

        echo $args['before_widget'];
        ?>
        <div class="random-posts-widget" id="random-posts">
            <?php
            global $post;
            $random_posts = new WP_Query(array(
                'posts_per_page' => $number,
                'post_type' => 'post',
                'ignore_sticky_posts' => true,
                'orderby' => 'rand',
                'no_found_rows' => true
            ));
            ?>

            <?php
            if (!empty($title)) {
                echo $args['before_title'] . esc_html($title) . $args['after_title'];
            }
            ?>

            <?php
            while ($random_posts->have_posts()) :
                $random_posts->the_post();
                ?>
                <div class="single-article-content">
                    <?php if (has_post_thumbnail()) { ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('masonry-brick-featured-small-thumbnail'); ?></a>
                    <?php } ?>
                    <h3 class="entry-title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="entry-meta">
                        <?php masonry_brick_posted_on(); ?>
                    </div>
                </div>
                <?php
            endwhile;
            // Reset Post Data
            wp_reset_postdata();
            ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

}
?>
