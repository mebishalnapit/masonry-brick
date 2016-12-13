<?php
/**
 * This fucntion is used to create custom meta boxes in pages/posts to render the left/right sidebar
 *
 * @package Masonry Brick
 */
add_action('add_meta_boxes', 'masonry_brick_custom_meta_boxes');

/**
 * Adding the Custom Meta Box
 */
function masonry_brick_custom_meta_boxes() {
	// Adding the layout meta box for single page
	add_meta_box('page-layout', esc_html__('Select Layout', 'masonry-brick'), 'masonry_brick_page_layout', 'page', 'side', 'default');
	// Adding the layout meta box for single post page
	add_meta_box('page-layout', esc_html__('Select Layout', 'masonry-brick'), 'masonry_brick_page_layout', 'post', 'side', 'default');
}

/**
 * Adding the sidebar display of the meta option in the editor
 */
global $masonry_brick_page_layout;
$masonry_brick_page_layout = array(
	'default-layout' => array(
		'id' => 'masonry_brick_page_layout',
		'value' => 'default_layout',
		'label' => esc_html__('Default Layout', 'masonry-brick'),
	),
	'right-sidebar' => array(
		'id' => 'masonry_brick_page_layout',
		'value' => 'right_sidebar',
		'label' => esc_html__('Right Sidebar', 'masonry-brick'),
	),
	'left-sidebar' => array(
		'id' => 'masonry_brick_page_layout',
		'value' => 'left_sidebar',
		'label' => esc_html__('Left Sidebar', 'masonry-brick'),
	),
	'no-sidebar-full-width' => array(
		'id' => 'masonry_brick_page_layout',
		'value' => 'no_sidebar_full_width',
		'label' => esc_html__('No Sidebar Full Width', 'masonry-brick'),
	),
	'no-sidebar-content-centered' => array(
		'id' => 'masonry_brick_page_layout',
		'value' => 'no_sidebar_content_centered',
		'label' => esc_html__('No Sidebar Content Centered', 'masonry-brick'),
	),
);

/**
 * Displaying the metabox in the editor section for select layout option of the post/page individually
 */
function masonry_brick_page_layout() {
	global $masonry_brick_page_layout, $post;

	// Use nonce for verification
	wp_nonce_field(basename(__FILE__), 'custom_meta_box_nonce');

	foreach ($masonry_brick_page_layout as $field) {
		$masonry_brick_layout_meta = get_post_meta($post->ID, $field['id'], true);
		if (empty($masonry_brick_layout_meta)) {
			$masonry_brick_layout_meta = 'default_layout';
		}
		?>
		<input class="post-format" id="<?php echo esc_attr($field['value']); ?>" type="radio" name="<?php echo esc_attr($field['id']); ?>" value="<?php echo esc_attr($field['value']); ?>" <?php checked($field['value'], $masonry_brick_layout_meta); ?>/>
		<label for="<?php echo esc_attr($field['value']); ?>" class="post-format-icon"><?php echo esc_html($field['label']); ?></label><br/>
		<?php
	}
}

/**
 * Save the custom metabox data
 */
if (!function_exists('masonry_brick_save_custom_meta_data')) :

	function masonry_brick_save_custom_meta_data($post_id) {
		global $masonry_brick_page_layout, $post;

		// Verify the nonce before proceeding.
		if (!isset($_POST['custom_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
			return;

		// Stop WP from clearing custom fields on autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return;

		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id))
				return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		foreach ($masonry_brick_page_layout as $field) {
			// Execute this saving function
			$old_meta_data = get_post_meta($post_id, $field['id'], true);
			$new_meta_data = sanitize_key($_POST[$field['id']]);
			if ($new_meta_data && $new_meta_data != $old_meta_data) {
				update_post_meta($post_id, $field['id'], $new_meta_data);
			} elseif ('' == $new_meta_data && $old_meta_data) {
				delete_post_meta($post_id, $field['id'], $old_meta_data);
			}
		} // end foreach
	}

endif;

add_action('pre_post_update', 'masonry_brick_save_custom_meta_data');
