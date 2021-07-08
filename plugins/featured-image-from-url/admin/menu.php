<?php

define('FIFU_SETTINGS', serialize(array('fifu_social', 'fifu_social_image_only', 'fifu_lazy', 'fifu_media_library', 'fifu_content', 'fifu_content_page', 'fifu_enable_default_url', 'fifu_spinner_db', 'fifu_spinner_nth', 'fifu_fake', 'fifu_default_url', 'fifu_wc_lbox', 'fifu_wc_zoom', 'fifu_hide_page', 'fifu_hide_post', 'fifu_hide_cpt', 'fifu_get_first', 'fifu_pop_first', 'fifu_ovw_first', 'fifu_query_strings', 'fifu_confirm_delete_all', 'fifu_run_delete_all', 'fifu_column_height', 'fifu_decode', 'fifu_grid_category', 'fifu_auto_alt', 'fifu_dynamic_alt', 'fifu_data_clean')));

define('FIFU_SLUG', 'featured-image-from-url');

add_action('admin_menu', 'fifu_insert_menu');

function fifu_insert_menu() {
    if (strpos($_SERVER['REQUEST_URI'], 'featured-image-from-url') !== false) {
        wp_enqueue_script('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js');
        wp_enqueue_style('jquery-ui-style1', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css');
        wp_enqueue_style('jquery-ui-style2', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.structure.min.css');
        wp_enqueue_style('jquery-ui-style3', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.theme.min.css');

        wp_enqueue_script('jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js');
        wp_enqueue_script('jquery-block-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js');

        wp_enqueue_script('fifu-rest-route-js', plugins_url('/html/js/rest-route.js', __FILE__), array('jquery'), fifu_version_number());
    }

    add_menu_page('Featured Image from URL', 'Featured Image from URL', 'manage_options', 'featured-image-from-url', 'fifu_get_menu_html', 'dashicons-camera', 57);
    add_submenu_page('featured-image-from-url', 'FIFU Settings', __('Settings'), 'manage_options', 'featured-image-from-url');
    add_submenu_page('featured-image-from-url', 'FIFU Status', __('Status'), 'manage_options', 'fifu-support-data', 'fifu_support_data');

    add_action('admin_init', 'fifu_get_menu_settings');
}

function fifu_support_data() {
    // css
    wp_enqueue_style('fifu-base-ui-css', plugins_url('/html/css/base-ui.css', __FILE__), array(), fifu_version_number());
    wp_enqueue_style('fifu-menu-css', plugins_url('/html/css/menu.css', __FILE__), array(), fifu_version_number());
    wp_enqueue_script('fifu-rest-route-js', plugins_url('/html/js/rest-route.js', __FILE__), array('jquery'), fifu_version_number());

    // register custom variables for the AJAX script
    wp_localize_script('fifu-rest-route-js', 'fifuScriptVars', [
        'restUrl' => esc_url_raw(rest_url()),
        'homeUrl' => esc_url_raw(home_url()),
        'nonce' => wp_create_nonce('wp_rest'),
    ]);

    $enable_social = get_option('fifu_social');
    $enable_social_image_only = get_option('fifu_social_image_only');
    $enable_lazy = get_option('fifu_lazy');
    $enable_media_library = get_option('fifu_media_library');
    $enable_content = get_option('fifu_content');
    $enable_content_page = get_option('fifu_content_page');
    $enable_fake = get_option('fifu_fake');
    $default_url = get_option('fifu_default_url');
    $enable_default_url = get_option('fifu_enable_default_url');
    $max_db = get_option('fifu_spinner_db');
    $nth_image = get_option('fifu_spinner_nth');
    $enable_wc_lbox = get_option('fifu_wc_lbox');
    $enable_wc_zoom = get_option('fifu_wc_zoom');
    $enable_hide_page = get_option('fifu_hide_page');
    $enable_hide_post = get_option('fifu_hide_post');
    $enable_hide_cpt = get_option('fifu_hide_cpt');
    $enable_get_first = get_option('fifu_get_first');
    $enable_pop_first = get_option('fifu_pop_first');
    $enable_ovw_first = get_option('fifu_ovw_first');
    $enable_query_strings = get_option('fifu_query_strings');
    $enable_confirm_delete_all = get_option('fifu_confirm_delete_all');
    $enable_confirm_delete_all_time = get_option('fifu_confirm_delete_all_time');
    $enable_run_delete_all = get_option('fifu_run_delete_all');
    $enable_run_delete_all_time = get_option('fifu_run_delete_all_time');
    $column_height = get_option('fifu_column_height');
    $enable_decode = get_option('fifu_decode');
    $enable_grid_category = get_option('fifu_grid_category');
    $enable_auto_alt = get_option('fifu_auto_alt');
    $enable_dynamic_alt = get_option('fifu_dynamic_alt');
    $enable_data_clean = 'toggleoff';

    include 'html/support-data.html';
}

function fifu_get_menu_html() {
    flush();

    $fifu = fifu_get_strings_settings();

    // css and js
    wp_enqueue_style('fifu-base-ui-css', plugins_url('/html/css/base-ui.css', __FILE__), array(), fifu_version_number());
    wp_enqueue_style('fifu-menu-css', plugins_url('/html/css/menu.css', __FILE__), array(), fifu_version_number());
    wp_enqueue_script('fifu-menu-js', plugins_url('/html/js/menu.js', __FILE__), array('jquery'), fifu_version_number());

    // register custom variables for the AJAX script
    wp_localize_script('fifu-menu-js', 'fifuScriptVars', [
        'restUrl' => esc_url_raw(rest_url()),
        'homeUrl' => esc_url_raw(home_url()),
        'nonce' => wp_create_nonce('wp_rest'),
        'wait' => $fifu['php']['message']['wait'](),
    ]);

    $enable_social = get_option('fifu_social');
    $enable_social_image_only = get_option('fifu_social_image_only');
    $enable_lazy = get_option('fifu_lazy');
    $enable_media_library = get_option('fifu_media_library');
    $enable_content = get_option('fifu_content');
    $enable_content_page = get_option('fifu_content_page');
    $enable_fake = get_option('fifu_fake');
    $default_url = get_option('fifu_default_url');
    $enable_default_url = get_option('fifu_enable_default_url');
    $max_db = get_option('fifu_spinner_db');
    $nth_image = get_option('fifu_spinner_nth');
    $enable_wc_lbox = get_option('fifu_wc_lbox');
    $enable_wc_zoom = get_option('fifu_wc_zoom');
    $enable_hide_page = get_option('fifu_hide_page');
    $enable_hide_post = get_option('fifu_hide_post');
    $enable_hide_cpt = get_option('fifu_hide_cpt');
    $enable_get_first = get_option('fifu_get_first');
    $enable_pop_first = get_option('fifu_pop_first');
    $enable_ovw_first = get_option('fifu_ovw_first');
    $enable_query_strings = get_option('fifu_query_strings');
    $enable_confirm_delete_all = get_option('fifu_confirm_delete_all');
    $enable_confirm_delete_all_time = get_option('fifu_confirm_delete_all_time');
    $enable_run_delete_all = get_option('fifu_run_delete_all');
    $enable_run_delete_all_time = get_option('fifu_run_delete_all_time');
    $column_height = get_option('fifu_column_height');
    $enable_decode = get_option('fifu_decode');
    $enable_grid_category = get_option('fifu_grid_category');
    $enable_auto_alt = get_option('fifu_auto_alt');
    $enable_dynamic_alt = get_option('fifu_dynamic_alt');
    $enable_data_clean = 'toggleoff';

    include 'html/menu.html';

    $arr = fifu_update_menu_options();

    // default
    $default_url = $arr['fifu_default_url'];
    if (!empty($default_url) && fifu_is_on('fifu_enable_default_url') && fifu_is_on('fifu_fake')) {
        if (!wp_get_attachment_url(get_option('fifu_default_attach_id'))) {
            $att_id = fifu_db_create_attachment($default_url);
            update_option('fifu_default_attach_id', $att_id);
            fifu_db_set_default_url();
        } else
            fifu_db_update_default_url($default_url);
    }
}

function fifu_get_menu_settings() {
    foreach (unserialize(FIFU_SETTINGS) as $i)
        fifu_get_setting($i);
}

function fifu_get_setting($type) {
    register_setting('settings-group', $type);

    $arr1 = array('fifu_spinner_nth');
    $arrEmpty = array('fifu_default_url');
    $arr64 = array('fifu_column_height');
    $arr1000 = array('fifu_spinner_db');
    $arrOn = array('fifu_auto_alt', 'fifu_wc_zoom', 'fifu_wc_lbox');
    $arrOnNo = array('fifu_fake', 'fifu_social');
    $arrOffNo = array('fifu_data_clean', 'fifu_confirm_delete_all', 'fifu_run_delete_all', 'fifu_social_image_only');

    if (!get_option($type)) {
        if (in_array($type, $arrEmpty))
            update_option($type, '');
        else if (in_array($type, $arr1))
            update_option($type, 1);
        else if (in_array($type, $arr64))
            update_option($type, "64", 'no');
        else if (in_array($type, $arr1000))
            update_option($type, 1000, 'no');
        else if (in_array($type, $arrOn))
            update_option($type, 'toggleon');
        else if (in_array($type, $arrOnNo))
            update_option($type, 'toggleon', 'no');
        else if (in_array($type, $arrOffNo))
            update_option($type, 'toggleoff', 'no');
        else
            update_option($type, 'toggleoff');
    }
}

function fifu_update_menu_options() {
    fifu_update_option('fifu_input_social', 'fifu_social');
    fifu_update_option('fifu_input_social_image_only', 'fifu_social_image_only');
    fifu_update_option('fifu_input_lazy', 'fifu_lazy');
    fifu_update_option('fifu_input_media_library', 'fifu_media_library');
    fifu_update_option('fifu_input_content', 'fifu_content');
    fifu_update_option('fifu_input_content_page', 'fifu_content_page');
    fifu_update_option('fifu_input_fake', 'fifu_fake');
    fifu_update_option('fifu_input_default_url', 'fifu_default_url');
    fifu_update_option('fifu_input_enable_default_url', 'fifu_enable_default_url');
    fifu_update_option('fifu_input_spinner_db', 'fifu_spinner_db');
    fifu_update_option('fifu_input_spinner_nth', 'fifu_spinner_nth');
    fifu_update_option('fifu_input_wc_lbox', 'fifu_wc_lbox');
    fifu_update_option('fifu_input_wc_zoom', 'fifu_wc_zoom');
    fifu_update_option('fifu_input_hide_page', 'fifu_hide_page');
    fifu_update_option('fifu_input_hide_post', 'fifu_hide_post');
    fifu_update_option('fifu_input_hide_cpt', 'fifu_hide_cpt');
    fifu_update_option('fifu_input_get_first', 'fifu_get_first');
    fifu_update_option('fifu_input_pop_first', 'fifu_pop_first');
    fifu_update_option('fifu_input_ovw_first', 'fifu_ovw_first');
    fifu_update_option('fifu_input_query_strings', 'fifu_query_strings');
    fifu_update_option('fifu_input_confirm_delete_all', 'fifu_confirm_delete_all');
    fifu_update_option('fifu_input_run_delete_all', 'fifu_run_delete_all');
    fifu_update_option('fifu_input_column_height', 'fifu_column_height');
    fifu_update_option('fifu_input_decode', 'fifu_decode');
    fifu_update_option('fifu_input_grid_category', 'fifu_grid_category');
    fifu_update_option('fifu_input_auto_alt', 'fifu_auto_alt');
    fifu_update_option('fifu_input_dynamic_alt', 'fifu_dynamic_alt');
    fifu_update_option('fifu_input_data_clean', 'fifu_data_clean');

    // delete all confirm log
    if (fifu_is_on('fifu_confirm_delete_all'))
        update_option('fifu_confirm_delete_all_time', current_time('mysql'), 'no');

    // delete all run log
    if (fifu_is_on('fifu_run_delete_all'))
        update_option('fifu_run_delete_all_time', current_time('mysql'), 'no');

    // urgent updates
    $arr = array();
    $arr['fifu_default_url'] = isset($_POST['fifu_input_default_url']) ? wp_strip_all_tags($_POST['fifu_input_default_url']) : '';

    return $arr;
}

function fifu_update_option($input, $type) {
    if (isset($_POST[$input])) {
        if ($_POST[$input] == 'on')
            update_option($type, 'toggleon');
        else if ($_POST[$input] == 'off')
            update_option($type, 'toggleoff');
        else
            update_option($type, wp_strip_all_tags($_POST[$input]));
    }
}

function fifu_enable_fake() {
    if (get_option('fifu_fake_created') && get_option('fifu_fake_created') != null)
        return;
    update_option('fifu_fake_created', true, 'no');

    fifu_db_change_url_length();
    fifu_db_insert_attachment();
    fifu_db_insert_attachment_category();
}

function fifu_disable_fake() {
    if (!get_option('fifu_fake_created') && get_option('fifu_fake_created') != null)
        return;
    update_option('fifu_fake_created', false, 'no');

    fifu_db_delete_default_url();
    fifu_db_delete_attachment();
    fifu_db_delete_attachment_category();
}

function fifu_version() {
    $plugin_data = get_plugin_data(FIFU_PLUGIN_DIR . 'featured-image-from-url.php');
    return $plugin_data ? $plugin_data['Name'] . ':' . $plugin_data['Version'] : '';
}

function fifu_version_number() {
    return get_plugin_data(FIFU_PLUGIN_DIR . 'featured-image-from-url.php')['Version'];
}

function fifu_get_last($meta_key) {
    $list = '';
    foreach (fifu_db_get_last($meta_key) as $key => $row) {
        $aux = $row->meta_value . ' &#10; |__ ' . $row->guid;
        $list .= '&#10; | ' . $aux;
    }
    return $list;
}

function fifu_get_plugins_list() {
    $list = '';
    foreach (get_plugins() as $key => $domain) {
        $name = $domain['Name'] . ' (' . $domain['TextDomain'] . ')';
        $list .= '&#10; - ' . $name;
    }
    return $list;
}

function fifu_get_active_plugins_list() {
    $list = '';
    foreach (get_option('active_plugins') as $key) {
        $name = explode('/', $key)[0];
        $list .= '&#10; - ' . $name;
    }
    return $list;
}

function fifu_has_curl() {
    return function_exists('curl_version');
}

