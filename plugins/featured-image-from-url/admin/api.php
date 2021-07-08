<?php

function fifu_is_local() {
    $query = 'http://localhost';
    return substr(get_home_url(), 0, strlen($query)) === $query;
}

function fifu_enable_fake_api(WP_REST_Request $request) {
    update_option('fifu_fake_stop', false, 'no');
    fifu_enable_fake();
    update_option('fifu_image_metadata_counter', fifu_db_count_urls_without_metadata(), 'no');
    return json_encode(array());
}

function fifu_disable_fake_api(WP_REST_Request $request) {
    update_option('fifu_fake_created', false, 'no');
    update_option('fifu_fake_stop', true, 'no');
    update_option('fifu_image_metadata_counter', fifu_db_count_urls_without_metadata(), 'no');
    return json_encode(array());
}

function fifu_data_clean_api(WP_REST_Request $request) {
    fifu_db_enable_clean();
    update_option('fifu_data_clean', 'toggleoff', 'no');
    update_option('fifu_image_metadata_counter', fifu_db_count_urls_without_metadata(), 'no');
    return json_encode(array());
}

function fifu_run_delete_all_api(WP_REST_Request $request) {
    fifu_db_delete_all();
    update_option('fifu_run_delete_all', 'toggleoff', 'no');
    return json_encode(array());
}

function fifu_disable_default_api(WP_REST_Request $request) {
    fifu_db_delete_default_url();
    return json_encode(array());
}

function fifu_none_default_api(WP_REST_Request $request) {
    return json_encode(array());
}

function fifu_rest_url(WP_REST_Request $request) {
    return get_rest_url();
}

function fifu_save_sizes_api(WP_REST_Request $request) {
    $json = json_encode(array());

    $att_id = $request['att_id'];
    if (filter_var($att_id, FILTER_VALIDATE_INT) === false)
        return $json;

    $width = $request['width'];
    if (filter_var($width, FILTER_VALIDATE_INT) === false)
        return $json;

    $height = $request['height'];
    if (filter_var($height, FILTER_VALIDATE_INT) === false)
        return $json;

    $url = $request['url'];
    if (filter_var($url, FILTER_SANITIZE_URL) === false)
        return $json;

    $att_id = filter_var($att_id, FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$att_id || !$width || !$height || !$url)
        return $json;

    $guid = get_the_guid($att_id);

    if ($url != $guid)
        return $json;

    if (get_post_field('post_author', $att_id) != FIFU_AUTHOR)
        return;

    // save
    $metadata = get_post_meta($att_id, '_wp_attachment_metadata', true);
    if (!$metadata || !$metadata['width'] || !$metadata['height']) {
        $metadata = null;
        $metadata['width'] = filter_var($width, FILTER_SANITIZE_SPECIAL_CHARS);
        $metadata['height'] = filter_var($height, FILTER_SANITIZE_SPECIAL_CHARS);
        wp_update_attachment_metadata($att_id, $metadata);
    }

    return $json;
}

function fifu_api_list_all_without_dimensions(WP_REST_Request $request) {
    return fifu_db_get_all_without_dimensions();
}

function fifu_test_execution_time() {
    for ($i = 0; $i <= 120; $i++) {
        error_log($i);
        sleep(1);
    }
    return json_encode(array());
}

add_action('rest_api_init', function () {
    register_rest_route('featured-image-from-url/v2', '/enable_fake_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_enable_fake_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/disable_fake_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_disable_fake_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/data_clean_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_data_clean_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/run_delete_all_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_run_delete_all_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/disable_default_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_disable_default_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/none_default_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_none_default_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/save_sizes_api/', array(
        'methods' => 'POST',
        'callback' => 'fifu_save_sizes_api',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/list_all_without_dimensions/', array(
        'methods' => 'POST',
        'callback' => 'fifu_api_list_all_without_dimensions',
        'permission_callback' => 'fifu_get_private_data_permissions_check',
    ));
    register_rest_route('featured-image-from-url/v2', '/rest_url_api/', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'fifu_rest_url',
        'permission_callback' => 'fifu_public_permission',
    ));
});

function fifu_get_private_data_permissions_check() {
    if (!current_user_can('edit_posts')) {
        return new WP_Error('rest_forbidden', __('Private'), array('status' => 401));
    }
    return true;
}

function fifu_public_permission() {
    return true;
}

