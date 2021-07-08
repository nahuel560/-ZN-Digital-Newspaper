jQuery(document).ready(function () {
    jQuery('link[href*="jquery-ui.css"]').attr("disabled", "true");
    jQuery('div.wrap div.header-box div.notice').hide();
    jQuery('div.wrap div.header-box div#message').hide();
    jQuery('div.wrap div.header-box div.updated').remove();
});

var restUrl = fifu_get_rest_url();

function invert(id) {
    if (jQuery("#fifu_toggle_" + id).attr("class") == "toggleon") {
        jQuery("#fifu_toggle_" + id).attr("class", "toggleoff");
        jQuery("#fifu_input_" + id).val('off');
    } else {
        jQuery("#fifu_toggle_" + id).attr("class", "toggleon");
        jQuery("#fifu_input_" + id).val('on');
    }
}

jQuery(function () {
    var url = window.location.href;

    //forms with id started by...
    jQuery("form[id^=fifu_form]").each(function (i, el) {
        //onsubmit
        jQuery(this).submit(function () {
            save(this);
        });
    });

    jQuery("#tabs").tabs();
    jQuery("#tabs-top").tabs();
    jQuery("#fifu_input_spinner_cron_metadata").spinner({min: 1, step: 1});
    jQuery("#fifu_input_spinner_db").spinner({min: 100, step: 100});
    jQuery("#fifu_input_spinner_nth").spinner({min: 1});
    jQuery("#fifu_input_spinner_image").spinner({min: 0});
    jQuery("#fifu_input_spinner_video").spinner({min: 0});
    jQuery("#fifu_input_spinner_slider").spinner({min: 0});
    jQuery("#fifu_input_slider_speed").spinner({min: 0});
    jQuery("#fifu_input_slider_pause").spinner({min: 0});
    jQuery("#fifu_input_auto_set_width").spinner({min: 0});
    jQuery("#fifu_input_auto_set_height").spinner({min: 0});
    jQuery("#fifu_input_crop_delay").spinner({min: 0, step: 50});
    jQuery("#tabsApi").tabs();
    jQuery("#tabsCrop").tabs();
    jQuery("#tabsPremium").tabs();
    jQuery("#tabsWooImport").tabs();
    jQuery("#tabsWpAllImport").tabs();
    jQuery("#tabsShortcode").tabs();
    jQuery("#tabsAutoSet").tabs();
    jQuery("#tabsSlider").tabs();

    // show settings
    window.scrollTo(0, 0);
    jQuery('.wrap').css('opacity', 1);
});

function save(formName, url) {
    var frm = jQuery(formName);
    jQuery.ajax({
        type: frm.attr('method'),
        url: url,
        data: frm.serialize(),
        success: function (data) {
            //alert('saved');
        }
    });
}

function fifu_default_js() {
    jQuery('#tabs-top').block({message: fifuScriptVars.wait, css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    toggle = jQuery("#fifu_toggle_enable_default_url").attr('class');
    switch (toggle) {
        case "toggleoff":
            option = "disable_default_api";
            break;
        default:
            url = jQuery("#fifu_input_default_url").val();
            option = url ? "none_default_api" : "disable_default_api";
    }
    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/' + option + '/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            setTimeout(function () {
                jQuery('#tabs-top').unblock();
            }, 1000);
        },
        timeout: 0
    });
}

function fifu_fake_js() {
    jQuery('#tabs-top').block({message: fifuScriptVars.wait, css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    toggle = jQuery("#fifu_toggle_fake").attr('class');
    switch (toggle) {
        case "toggleon":
            option = "enable_fake_api";
            break;
        case "toggleoff":
            option = "disable_fake_api";
            break;
        default:
            return;
    }

    interval = setInterval(function () {
        jQuery("#image_metadata_counter").load(location.href + " #image_metadata_counter");
    }, 3000);

    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/' + option + '/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
            setTimeout(function () {
                jQuery('#tabs-top').unblock();
            }, 1000);
            jQuery("#countdown").load(location.href + " #countdown");
            jQuery("#image_metadata_counter").load(location.href + " #image_metadata_counter");
            clearInterval(interval);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
        },
        timeout: 0
    });
}

function fifu_clean_js() {
    if (jQuery("#fifu_toggle_data_clean").attr('class') != 'toggleon')
        return;

    fifu_run_clean_js();
}

function fifu_run_clean_js() {
    jQuery('#tabs-top').block({message: fifuScriptVars.wait, css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/data_clean_api/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            setTimeout(function () {
                jQuery("#fifu_toggle_data_clean").attr('class', 'toggleoff');
                jQuery("#fifu_toggle_fake").attr('class', 'toggleoff');
                jQuery("#image_metadata_counter").load(location.href + " #image_metadata_counter");
                jQuery("#countdown").load(location.href + " #countdown");
                jQuery('#tabs-top').unblock();
            }, 1000);
        },
        timeout: 0
    });
}

function fifu_run_delete_all_js() {
    if (jQuery("#fifu_toggle_run_delete_all").attr('class') != 'toggleon' || jQuery("#fifu_toggle_confirm_delete_all").attr('class') != 'toggleon')
        return;

    fifu_run_clean_js();

    jQuery('#tabs-top').block({message: fifuScriptVars.wait, css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/run_delete_all_api/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            setTimeout(function () {
                jQuery("#fifu_toggle_run_delete_all").attr('class', 'toggleoff');
                jQuery('#tabs-top').unblock();
            }, 1000);
        },
        timeout: 0
    });
}

function fifu_save_dimensions_all_js() {
    jQuery('#tabs-top').block({message: 'Please wait. It can take several minutes...', css: {backgroundColor: 'none', border: 'none', color: 'white'}});

    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/list_all_without_dimensions/',
        async: true,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', fifuScriptVars.nonce);
        },
        success: function (data) {
            var i = 0;
            var count = data.length;

            function dimensionsLoop(data, i) {
                var attempts = 0;
                var image = new Image();
                jQuery(image).attr('src', data[i]['guid']);
                is_svg = data[i]['guid'].includes('.svg');

                var poll = setInterval(function () {
                    if (image.naturalWidth || attempts > 100 || is_svg) {
                        attempts = 0;
                        clearInterval(poll);
                        if (!is_svg)
                            fifu_get_sizes(image, data[i]['ID'], data[i]['guid']);
                        image = null;
                        i++;
                        if (i < data.length) {
                            jQuery("#countdown").text(parseInt(jQuery("#countdown").text()) - 1)
                            dimensionsLoop(data, i);
                        } else {
                            jQuery('#tabs-top').unblock();
                            invert('save_dimensions_all');
                            jQuery("#countdown").text('done');
                        }
                    } else {
                        console.log(data[i]['guid']);
                        attempts++;
                    }
                }, 25);
            }

            if (data.length > 0) {
                dimensionsLoop(data, i);
            } else {
                jQuery('#tabs-top').unblock();
                invert('save_dimensions_all');
                jQuery("#countdown").text('done');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            setTimeout(function () {
                fifu_save_dimensions_all_js();
            }, 1000);
        },
        complete: function (data) {
        },
        timeout: 0
    });
}

function fifu_get_sizes($, att_id) {
    width = jQuery($)[0].naturalWidth;
    height = jQuery($)[0].naturalHeight;

    if (width == 1 && height == 1)
        return;

    jQuery.ajax({
        method: "POST",
        url: restUrl + 'featured-image-from-url/v2/save_sizes_api/',
        data: {
            "width": width,
            "height": height,
            "att_id": att_id,
            "url": jQuery($).attr('src'),
        },
        async: false,
        beforeSend: function (xhr) {
            jQuery($).removeAttr('onload');
            jQuery($).removeAttr('fifu-att-id');
            xhr.setRequestHeader("X-WP-Nonce", fifuScriptVars.nonce);
        },
        timeout: 10
    });

    return;
}
