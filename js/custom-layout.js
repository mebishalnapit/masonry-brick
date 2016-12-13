/**
 * setting for the layout option in customizer
 */
jQuery(document).ready(function () {
	jQuery('.controls#masonry-brick-img-container li img').click(function () {
		jQuery('.controls#masonry-brick-img-container li').each(function () {
			jQuery(this).find('img').removeClass('masonry-brick-radio-img-selected');
		});
		jQuery(this).addClass('masonry-brick-radio-img-selected');
	});
});