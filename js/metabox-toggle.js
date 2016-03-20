/**
 * Metabox toggle in admin area
 */
jQuery(document).ready(function () {
    // hide the div by default
    jQuery("#post-video-url").hide();
    jQuery("#post-audio-url").hide();
    jQuery("#post-status").hide();
    jQuery("#post-chat").hide();
    jQuery("#post-link-text").hide();
    jQuery("#post-link-url").hide();
    jQuery("#post-quote-text").hide();
    jQuery("#post-quote-author").hide();

    // if post format is selected, then, display the respective div
    if (jQuery("#post-format-video").is(":checked"))
        jQuery("#post-video-url").show();
    if (jQuery("#post-format-audio").is(":checked"))
        jQuery("#post-audio-url").show();
    if (jQuery("#post-format-status").is(":checked"))
        jQuery("#post-status").show();
    if (jQuery("#post-format-chat").is(":checked"))
        jQuery("#post-chat").show();
    if (jQuery("#post-format-link").is(":checked")) {
        jQuery("#post-link-text").show();
        jQuery("#post-link-url").show();
    }
    if (jQuery("#post-format-quote").is(":checked")) {
        jQuery("#post-quote-text").show();
        jQuery("#post-quote-author").show();
    }

    // hiding the default post format type input box by default
    jQuery("input[name=\"post_format\"]").change(function () {
        jQuery("#post-video-url").hide();
        jQuery("#post-audio-url").hide();
        jQuery("#post-status").hide();
        jQuery("#post-chat").hide();
        jQuery("#post-link-text").hide();
        jQuery("#post-link-url").hide();
        jQuery("#post-quote-text").hide();
        jQuery("#post-quote-author").hide();
    });

    // if post format is selected, then, display the respective input div
    jQuery("input#post-format-video").change(function () {
        jQuery("#post-video-url").show();
    });
    jQuery("input#post-format-audio").change(function () {
        jQuery("#post-audio-url").show();
    });
    jQuery("input#post-format-status").change(function () {
        jQuery("#post-status").show();
    });
    jQuery("input#post-format-chat").change(function () {
        jQuery("#post-chat").show();
    });
    jQuery("input#post-format-link").change(function () {
        jQuery("#post-link-text").show();
        jQuery("#post-link-url").show();
    });
    jQuery("input#post-format-quote").change(function () {
        jQuery("#post-quote-text").show();
        jQuery("#post-quote-author").show();
    });
});