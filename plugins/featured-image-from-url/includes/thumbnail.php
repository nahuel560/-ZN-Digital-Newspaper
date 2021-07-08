<?php

define('FIFU_PLACEHOLDER', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');

add_filter('wp_head', 'fifu_add_js');

if (!function_exists('is_plugin_active'))
    require_once(ABSPATH . '/wp-admin/includes/plugin.php');

global $pagenow;
if (!in_array($pagenow, array('post.php', 'post-new.php', 'admin-ajax.php', 'wp-cron.php'))) {
    if (is_plugin_active('wordpress-seo/wp-seo.php')) {
        add_action('wpseo_opengraph_image', 'fifu_add_social_tag_yoast');
        add_action('wpseo_twitter_image', 'fifu_add_social_tag_yoast');
        add_action('wpseo_add_opengraph_images', 'fifu_add_social_tag_yoast_list');
    } else
        add_filter('wp_head', 'fifu_add_social_tags');
}

add_filter('wp_head', 'fifu_apply_css');

function fifu_add_js() {
    echo '<link rel="preconnect" href="https://cdnjs.cloudflare.com">';

    if (fifu_is_on('fifu_lazy')) {
        wp_enqueue_style('lazyload-spinner', plugins_url('/html/css/lazyload.css', __FILE__), array(), fifu_version_number());
        wp_enqueue_script('lazysizes-config', plugins_url('/html/js/lazySizesConfig.js', __FILE__), array('jquery'), fifu_version_number());
        wp_enqueue_script('unveilhooks', 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/plugins/unveilhooks/ls.unveilhooks.min.js');
        wp_enqueue_script('bgset', 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/plugins/bgset/ls.bgset.min.js');
        wp_enqueue_script('lazysizes', 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/lazysizes.min.js');
    }

    if (class_exists('WooCommerce')) {
        wp_register_style('fifu-woo', plugins_url('/html/css/woo.css', __FILE__), array(), fifu_version_number());
        wp_enqueue_style('fifu-woo');
        wp_add_inline_style('fifu-woo', 'img.zoomImg {display:' . fifu_woo_zoom() . ' !important}');
    }

    // js
    wp_enqueue_script('fifu-image-js', plugins_url('/html/js/image.js', __FILE__), array('jquery'), fifu_version_number());
    wp_localize_script('fifu-image-js', 'fifuImageVars', [
        'fifu_lazy' => fifu_is_on("fifu_lazy"),
        'fifu_woo_lbox_enabled' => fifu_woo_lbox(),
        'fifu_woo_zoom' => fifu_woo_zoom(),
        'fifu_is_product' => class_exists('WooCommerce') && is_product(),
        'fifu_is_flatsome_active' => fifu_is_flatsome_active(),
        'fifu_rest_url' => esc_url_raw(rest_url()),
        'fifu_nonce' => wp_create_nonce('wp_rest'),
    ]);
}

function fifu_add_social_tag_yoast() {
    return fifu_main_image_url(get_the_ID());
}

function fifu_add_social_tag_yoast_list($object) {
    $object->add_image(fifu_main_image_url(get_the_ID()));
}

function fifu_add_social_tags() {
    $post_id = get_the_ID();
    $url = fifu_main_image_url($post_id);
    $url = $url ? $url : get_the_post_thumbnail_url($post_id);
    $title = str_replace("'", "&#39;", get_the_title($post_id));
    $description = str_replace("'", "&#39;", wp_strip_all_tags(get_post_field('post_excerpt', $post_id)));

    if (fifu_is_off('fifu_social'))
        return;

    if ($url)
        include 'html/og-image.html';

    if (fifu_is_off('fifu_social_image_only'))
        include 'html/social.html';

    if ($url)
        include 'html/twitter-image.html';
}

function fifu_apply_css() {
    if (fifu_is_off('fifu_wc_lbox'))
        echo '<style>[class$="woocommerce-product-gallery__trigger"] {display:none !important;}</style>';
}

add_filter('woocommerce_product_get_image', 'fifu_woo_replace', 10, 5);

function fifu_woo_replace($html, $product, $woosize) {
    return fifu_replace($html, $product->get_id(), null, null, null);
}

add_filter('post_thumbnail_html', 'fifu_replace', 10, 5);

function fifu_replace($html, $post_id, $post_thumbnail_id, $size, $attr) {
    if (!$html)
        return $html;

    $datasrc = fifu_get_attribute('data-src', $html);
    $src = $datasrc ? $datasrc : fifu_get_attribute('src', $html);
    if (isset($_POST[$src])) {
        $data = $_POST[$src];
        if (strpos($html, 'fifu-replaced') !== false)
            return $html;
    }

    $url = get_post_meta($post_id, 'fifu_image_url', true);

    $delimiter = fifu_get_delimiter('src', $html);
    if (fifu_is_on('fifu_dynamic_alt')) {
        $alt = get_the_title($post_id);
        $html = preg_replace('/alt=[\'\"][^[\'\"]*[\'\"]/', 'alt=' . $delimiter . $alt . $delimiter, $html);
    } else {
        if ($url) {
            $alt = get_post_meta($post_id, 'fifu_image_alt', true);
            $html = preg_replace('/alt=[\'\"][^[\'\"]*[\'\"]/', 'alt=' . $delimiter . $alt . $delimiter . ' title=' . $delimiter . $alt . $delimiter, $html);
        }
    }

    if (fifu_is_on('fifu_lazy') && !is_admin()) {
        if (fifu_is_avada_active()) {
            if (strpos($html, ' src=') !== false && strpos($html, ' data-srcset=') === false)
                $html = str_replace(" src=", " data-srcset=", $html);
            if (strpos($html, ' srcset=') !== false && strpos($html, ' data-srcset=') !== false)
                $html = preg_replace("/ srcset=[\'\"][^\'\"]+[\'\"]/", ' ', $html);
        } else {
            if (strpos($html, ' src=') !== false && strpos($html, ' data-src=') === false)
                $html = str_replace(" src=", " data-src=", $html);
            if (strpos($html, ' src=') !== false && strpos($html, ' data-src=') !== false)
                $html = preg_replace("/ src=[\'\"][^\'\"]+[\'\"]/", ' ', $html);
        }
    }

    if ($url)
        return $html;

    $width = fifu_get_attribute('width', $html);
    $height = fifu_get_attribute('height', $html);

    return !$url ? $html : fifu_get_html($url, $alt, $width, $height);
}

function fifu_get_html($url, $alt, $width, $height) {
    $css = '';
    if (fifu_should_hide()) {
        $css = 'display:none';
    }

    return sprintf('<!-- Powered by Featured Image from URL plugin --> <img %s alt="%s" title="%s" style="%s" data-large_image="%s" data-large_image_width="%s" data-large_image_height="%s" onerror="%s" width="%s" height="%s">', fifu_lazy_url($url), $alt, $alt, $css, $url, "800", "600", "jQuery(this).hide();", $width, $height);
}

add_filter('the_content', 'fifu_add_to_content');

function fifu_add_to_content($content) {
    return is_singular() && has_post_thumbnail() && ((is_singular('post') && fifu_is_on('fifu_content')) or ( is_singular('page') && fifu_is_on('fifu_content_page'))) ? get_the_post_thumbnail() . $content : $content;
}

function fifu_should_hide() {
    return !is_front_page() && ((is_singular('post') && fifu_is_on('fifu_hide_post')) || (is_singular('page') && fifu_is_on('fifu_hide_page')) || (is_singular(get_post_type(get_the_ID())) && fifu_is_cpt() && fifu_is_on('fifu_hide_cpt')));
}

function fifu_is_cpt() {
    return in_array(get_post_type(get_the_ID()), array_diff(fifu_get_post_types(), array('post', 'page')));
}

function fifu_main_image_url($post_id) {
    $url = get_post_meta($post_id, 'fifu_image_url', true);

    if (!$url && fifu_no_internal_image($post_id) && (get_option('fifu_default_url') && fifu_is_on('fifu_enable_default_url')))
        $url = get_option('fifu_default_url');

    $url = htmlspecialchars_decode($url);

    return str_replace("'", "", $url);
}

function fifu_no_internal_image($post_id) {
    return get_post_meta($post_id, '_thumbnail_id', true) == -1 || get_post_meta($post_id, '_thumbnail_id', true) == null || get_post_meta($post_id, '_thumbnail_id', true) == get_option('fifu_default_attach_id');
}

function fifu_lazy_url($url) {
    if (fifu_is_off('fifu_lazy'))
        return 'src="' . $url . '"';
    return 'data-src="' . $url . '"';
}

function fifu_is_main_page() {
    return is_home() || (class_exists('WooCommerce') && is_shop());
}

function fifu_has_internal_image($post_id) {
    $featured_image = get_post_meta($post_id, '_thumbnail_id', true);
    return $featured_image && $featured_image != -1 && $featured_image != get_option('fifu_fake_attach_id');
}

function fifu_is_in_editor() {
    return !is_admin() || get_current_screen() == null ? false : get_current_screen()->parent_base == 'edit' || get_current_screen()->is_block_editor;
}

function fifu_get_default_url() {
    return wp_get_attachment_url(get_option('fifu_default_attach_id'));
}

