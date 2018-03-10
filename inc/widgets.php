<?php

/**
 * Contains all the widgets parts included in the theme
 *
 * @package Maonry Brick
 */
class Masonry_Brick_Random_Posts_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'masonry_brick_random_posts_widget', esc_html__( 'MB: Random Posts Widget', 'masonry-brick' ), // Name of the widget
			array(
				'description'                 => esc_html__( 'Displays the random posts from your site.', 'masonry-brick' ),
				'customize_selective_refresh' => true,
			) // Arguments of the widget, here it is provided with the description
		);
	}

	function form( $instance ) {
		$number = ! empty( $instance['number'] ) ? $instance['number'] : 4;
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'masonry-brick' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_textarea( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of random posts to display:', 'masonry-brick' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo absint( $number ); ?>" size="3">
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance           = array();
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 4;
		$instance['title']  = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function widget( $args, $instance ) {
		$number = ( ! empty( $instance['number'] ) ) ? $instance['number'] : 4;
		$title  = isset( $instance['title'] ) ? $instance['title'] : '';

		echo $args['before_widget'];
		?>
		<div class="random-posts-widget" id="random-posts">
			<?php
			global $post;
			$random_posts = new WP_Query( array(
				'posts_per_page'      => $number,
				'post_type'           => 'post',
				'ignore_sticky_posts' => true,
				'orderby'             => 'rand',
				'no_found_rows'       => true,
			) );
			?>

			<?php
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			}
			?>

			<?php
			while ( $random_posts->have_posts() ) :
				$random_posts->the_post();
				?>
				<div class="single-article-content">
					<?php if ( has_post_thumbnail() ) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'masonry-brick-featured-small-thumbnail' ); ?></a>
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

class Masonry_Brick_Tabbed_Widget extends WP_Widget {

	/**
	 * Register widget in WordPress
	 */
	function __construct() {
		parent::__construct(
			'masonry_brick_tabbed_widget', esc_html__( 'MB: Tabbed Widget', 'masonry-brick' ), // Name of the widget
			array(
				'description'                 => esc_html__( 'Displays the popular posts, recent posts and the recent comments in the tabs.', 'masonry-brick' ),
				'customize_selective_refresh' => true,
			) // Arguments of the widget, here it is provided with the description
		);
	}

	function form( $instance ) {
		$number = ! empty( $instance['number'] ) ? $instance['number'] : 4;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of popular posts, recent posts and comments to display:', 'masonry-brick' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo absint( $number ); ?>" size="3">
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance           = array();
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 4;

		return $instance;
	}

	function widget( $args, $instance ) {
		$number = ( ! empty( $instance['number'] ) ) ? $instance['number'] : 4;
		echo $args['before_widget'];
		?>

		<div class="tab-content masonry-brick-tab-content">

			<ul class="masonry-brick-tabs" role="tablist">
				<li role="presentation" class="popular active">
					<a href="#popular"><i class="fa fa-star"></i><?php esc_html_e( 'Popular', 'masonry-brick' ); ?></a>
				</li>
				<li role="presentation" class="recent">
					<a href="#recent"><i class="fa fa-history"></i><?php esc_html_e( 'Recent', 'masonry-brick' ); ?></a>
				</li>
				<li role="presentation" class="comment">
					<a href="#user-comments"><i class="fa fa-comment"></i><?php esc_html_e( 'Comment', 'masonry-brick' ); ?>
					</a></li>
			</ul>

			<!-- Popular Tab -->
			<div role="tabpanel" class="tabs-panel popular-tab active" id="popular">
				<?php
				global $post;
				$get_popular_posts = new WP_Query( array(
					'posts_per_page'      => $number,
					'post_type'           => 'post',
					'ignore_sticky_posts' => true,
					'orderby'             => 'comment_count',
					'no_found_rows'       => true,
				) );
				?>
				<?php while ( $get_popular_posts->have_posts() ) : $get_popular_posts->the_post(); ?>
					<div class="single-article-content">
						<?php if ( has_post_thumbnail() ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'masonry-brick-featured-small-thumbnail' ); ?></a>
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

			<!-- Recent Tab -->
			<div role="tabpanel" class="tabs-panel recent-tab" id="recent">
				<?php
				global $post;
				$get_recent_posts = new WP_Query( array(
					'posts_per_page'      => $number,
					'post_type'           => 'post',
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
				) );
				?>
				<?php
				$i = 1;
				while ( $get_recent_posts->have_posts() ) : $get_recent_posts->the_post();
					?>
					<div class="single-article-content">
						<?php if ( has_post_thumbnail() ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'masonry-brick-featured-small-thumbnail' ); ?></a>
						<?php } ?>
						<h3 class="entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h3>
						<div class="entry-meta">
							<?php masonry_brick_posted_on(); ?>
						</div>
					</div>
					<?php
					$i ++;
				endwhile;
				// Reset Post Data
				wp_reset_postdata();
				?>
			</div>

			<!-- Comment Tab -->
			<div role="tabpanel" class="tabs-panel comment-tab" id="user-comments">
				<?php
				$comments_query = new WP_Comment_Query();
				$comments       = $comments_query->query( array( 'number' => $number, 'status' => 'approve' ) );
				$commented      = '';
				$commented      .= '<ul class="comments-tab">';
				if ( $comments ) : foreach ( $comments as $comment ) :
					$commented .= '<li class="comments-tab-widget"><a class="author" href="' . esc_url( get_permalink( $comment->comment_post_ID ) ) . '#comment-' . $comment->comment_ID . '">';
					$commented .= get_avatar( $comment->comment_author_email, '60' );
					$commented .= get_comment_author( $comment->comment_ID ) . '</a>' . ' ' . esc_html__( 'says:', 'masonry-brick' );
					$commented .= '<p class="commented-post">' . strip_tags( substr( apply_filters( 'get_comment_text', $comment->comment_content ), 0, '50' ) ) . '&hellip;</p></li>';
				endforeach;
				else :
					$commented .= '<p class="no-comments-commented-post">' . esc_html__( 'No Comments', 'masonry-brick' ) . '</p>';
				endif;
				$commented .= '</ul>';
				echo $commented;
				?>
			</div>

		</div>

		<?php
		echo $args['after_widget'];
	}

}

?>
