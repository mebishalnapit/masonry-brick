<?php
/**
 * Template part for displaying the status post format.
 *
 * @package Masonry Brick
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('masonry-content'); ?>>
    <?php do_action('masonry_brick_before_post_content'); ?>

    <?php $status_post_text = get_post_meta($post->ID, 'masonry_brick_status_text', true); ?>
    <?php if (!empty($status_post_text)) : ?>
        <div class="status-details">
            <div class="status-user-avatar">
                <?php echo get_avatar(get_the_author_meta('user_email'), '75'); ?>
            </div>
            <div class="status-user-text">
                <?php echo esc_html($status_post_text); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="post-wrapper">
        <header class="entry-header">
            <?php
            if (is_single()) {
                the_title('<h1 class="entry-title">', '</h1>');
            } else {
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            }

            if ('post' === get_post_type()) :
                ?>
                <div class="entry-meta">
                    <?php masonry_brick_posted_on(); ?>
                </div><!-- .entry-meta -->
            <?php endif;
            ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            if (is_single()) :
                the_content();
            else :
                the_excerpt(); // displaying excerpt for the archive pages
            endif;

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'masonry-brick'),
                'after' => '</div>',
            ));
            ?>
        </div><!-- .entry-content -->

        <?php if (is_single()) : ?>
            <footer class="entry-footer">
                <?php masonry_brick_entry_footer(); ?>
            </footer><!-- .entry-footer -->
        <?php endif; ?>

    </div>
    <?php do_action('masonry_brick_after_post_content'); ?>
</article><!-- #post-## -->
