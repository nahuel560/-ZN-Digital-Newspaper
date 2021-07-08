<?php

add_action('admin_init', 'fifu_column');

function fifu_column() {
    add_filter('manage_posts_columns', 'fifu_column_head');
    add_filter('manage_pages_columns', 'fifu_column_head');
    add_filter('manage_edit-product_cat_columns', 'fifu_column_head');
    fifu_column_custom_post_type();
    add_action('manage_posts_custom_column', 'fifu_column_content', 10, 2);
    add_action('manage_pages_custom_column', 'fifu_column_content', 10, 2);
    add_action('manage_product_cat_custom_column', 'fifu_ctgr_column_content', 10, 3);
}

function fifu_column_head($default) {
    $default['featured_image'] = '<span class="dashicons dashicons-camera" style="font-size:20px" title="Featured Image from URL"></span> FIFU';
    return $default;
}

function fifu_ctgr_column_content($internal_image, $column, $term_id) {
    $border = '';
    $height = get_option('fifu_column_height');
    if ($column == 'featured_image') {
        $url = get_term_meta($term_id, 'fifu_image_url', true);
        if ($url == '') {
            $thumb_id = get_term_meta($term_id, 'thumbnail_id', true);
            $url = wp_get_attachment_url($thumb_id);
            $border = 'border-color: #ca4a1f !important; border: 1px; border-style: solid;';
        }
        echo sprintf('<div style="height:%spx; width:%spx; background:url(\'%s\') no-repeat center center; background-size:cover; %s"/>', $height, $height * 1.5, $url, $border);
    } else
        echo $internal_image;
}

function fifu_column_content($column, $post_id) {
    $border = '';
    $height = get_option('fifu_column_height');
    if ($column == 'featured_image') {
        $url = fifu_main_image_url($post_id);
        if ($url == '') {
            $url = wp_get_attachment_url(get_post_thumbnail_id());
            $border = 'border-color: #ca4a1f !important; border: 1px; border-style: solid;';
        }
        echo sprintf('<div style="height:%spx; width:%spx; background:url(\'%s\') no-repeat center center; background-size:cover; %s"/>', $height, $height * 1.5, $url, $border);
    }
}

function fifu_column_custom_post_type() {
    foreach (fifu_get_post_types() as $post_type)
        add_filter('manage_edit-' . $post_type . '_columns', 'fifu_column_head');
}

