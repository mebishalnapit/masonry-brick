/**
 * Theme's Custom Javascript Main Files
 */
jQuery( document ).ready( function () {

	// Search toggle
	jQuery( '.search-top' ).click( function () {
		jQuery( '#masthead .search-form-top' ).slideToggle( '500' );
	} );

	// Scroll up function
	jQuery( '#scroll-up' ).hide();
	jQuery( function () {
		jQuery( window ).scroll( function () {
			if ( jQuery( this ).scrollTop() > 1000 ) {
				jQuery( '#scroll-up' ).fadeIn();
			} else {
				jQuery( '#scroll-up' ).fadeOut();
			}
		} );
		jQuery( 'a#scroll-up' ).click( function () {
			jQuery( 'body,html' ).animate( {
				scrollTop : 0
			}, 1000 );
			return false;
		} );
	} );

	// Tabbed widget tabs panel
	jQuery( '.masonry-brick-tabs a' ).click( function ( event ) {
		event.preventDefault();
		jQuery( this ).parent().addClass( 'active' );
		jQuery( this ).parent().siblings().removeClass( 'active' );
		var tab = jQuery( this ).attr( 'href' );
		jQuery( '.tabs-panel' ).not( tab ).css( 'display', 'none' );
		jQuery( tab ).fadeIn();
	} );

	// Gallery post format slider
	if ( typeof jQuery.fn.bxSlider !== 'undefined' ) {
		jQuery( '.gallery-slider' ).bxSlider( {
			mode           : 'horizontal',
			speed          : 2000,
			auto           : true,
			pause          : 6000,
			adaptiveHeight : true,
			pager          : false,
			nextText       : '<span class="slide-next"><i class="fa fa-angle-right"></i></span>',
			prevText       : '<span class="slide-prev"><i class="fa fa-angle-left"></i></span>',
			onSliderLoad   : function () {
				jQuery( '.gallery-slider' ).css( 'visibility', 'visible' );
				jQuery( '.gallery-slider' ).css( 'height', 'auto' );
			}
		} );
	}

	// Setting for the popup featured image
	if ( typeof jQuery.fn.magnificPopup !== 'undefined' ) {
		jQuery( '.featured-image-popup' ).magnificPopup( { type : 'image' } );
	}

	// Setting for the responsive video using fitvids
	if ( typeof jQuery.fn.fitVids !== 'undefined' ) {
		jQuery( '.fitvids-video' ).fitVids();
	}

	// Setting for the sticky menu
	if ( typeof jQuery.fn.sticky !== 'undefined' ) {
		var wpAdminBar = jQuery( '#wpadminbar' );
		if ( wpAdminBar.length ) {
			jQuery( '#site-navigation' ).sticky( {
				topSpacing : wpAdminBar.height(),
				zIndex     : 9999
			} );
		} else {
			jQuery( '#site-navigation' ).sticky( {
				topSpacing : 0,
				zIndex     : 9999
			} );
		}
	}

	// Setting for sticky sidebar and content area
	if ( (typeof jQuery.fn.theiaStickySidebar !== 'undefined') && (typeof ResizeSensor !== 'undefined') ) {
		// Calculate the whole height of sticky menu
		var height = jQuery( '#site-navigation-sticky-wrapper' ).outerHeight();

		// Assign height value to 0 if it returns null
		if ( height === null ) {
			height = 0;
		}

		jQuery( '#primary, #secondary' ).theiaStickySidebar( {
			additionalMarginTop : 40 + height
		} );
	}

} );

// Setting for masonry layout
if ( typeof jQuery.fn.masonry !== 'undefined' ) {
	jQuery( window ).load( function () {
		// Setting for masonry layout
		jQuery( '.site-main' ).masonry( {
			itemSelector : '.masonry-content',
		} );
	} );

	// Handle new items appended by infinite scroll
	jQuery( document ).on( 'post-load', function () {
		setInterval( function () {
			jQuery( '.site-main' ).masonry( 'reload' );
		}, 600 );
	} );
}
