<?php

/*
 * Plugin Name: Featured Image from URL | FIFU
 * Plugin URI: https://fifu.app/
 * Description: Use an external image as featured image of a post or WooCommerce product. Includes Image Search, Video, Social Tags, SEO, Lazy Load, Gallery, Automation etc.
 * Version: 3.3.6
 * Author: fifu.app
 * Author URI: https://fifu.app/
 * WC requires at least: 4.0
 * WC tested up to: 4.4.1
 * Text Domain: featured-image-from-url
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

define('FIFU_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FIFU_INCLUDES_DIR', FIFU_PLUGIN_DIR . 'includes');
define('FIFU_ADMIN_DIR', FIFU_PLUGIN_DIR . 'admin');
define('FIFU_ELEMENTOR_DIR', FIFU_PLUGIN_DIR . 'elementor');
define('FIFU_DELETE_ALL_URLS', false);
define('FIFU_DEV_DEBUG', false);

require_once (FIFU_INCLUDES_DIR . '/attachment.php');
require_once (FIFU_INCLUDES_DIR . '/convert-url.php');
require_once (FIFU_INCLUDES_DIR . '/external-post.php');
require_once (FIFU_INCLUDES_DIR . '/thumbnail.php');
require_once (FIFU_INCLUDES_DIR . '/thumbnail-category.php');
require_once (FIFU_INCLUDES_DIR . '/util.php');
require_once (FIFU_INCLUDES_DIR . '/woo.php');

require_once (FIFU_ADMIN_DIR . '/api.php');
require_once (FIFU_ADMIN_DIR . '/db.php');
require_once (FIFU_ADMIN_DIR . '/category.php');
require_once (FIFU_ADMIN_DIR . '/column.php');
require_once (FIFU_ADMIN_DIR . '/menu.php');
require_once (FIFU_ADMIN_DIR . '/meta-box.php');
require_once (FIFU_ADMIN_DIR . '/strings.php');
require_once (FIFU_ADMIN_DIR . '/wai-addon.php');

require_once (FIFU_ELEMENTOR_DIR . '/elementor-fifu-extension.php');

register_activation_hook(__FILE__, 'fifu_activate');

function fifu_activate($network_wide) {
    if (is_multisite() && $network_wide) {
        global $wpdb;
        foreach ($wpdb->get_col("SELECT blog_id FROM $wpdb->blogs") as $blog_id) {
            switch_to_blog($blog_id);
            fifu_activate_actions();
        }
    } else {
        fifu_activate_actions();
    }
}

function fifu_activate_actions() {
    fifu_db_change_url_length();
}

register_deactivation_hook(__FILE__, 'fifu_deactivation');

function fifu_deactivation() {
    
}

add_action('upgrader_process_complete', 'fifu_upgrade', 10, 2);

function fifu_upgrade($upgrader_object, $options) {
    $current_plugin_path_name = plugin_basename(__FILE__);
    if ($options['action'] == 'update' && $options['type'] == 'plugin') {
        foreach ((array) $options['plugins'] as $each_plugin) {
            if ($each_plugin == $current_plugin_path_name) {
                fifu_activate_actions();
            }
        }
    }
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'fifu_action_links');
add_filter('network_admin_plugin_action_links_' . plugin_basename(__FILE__), 'fifu_action_links');

function fifu_action_links($links) {
    $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=featured-image-from-url')) . '">' . __('Settings') . '</a>';
    $links[] = '<a style="color:black">' . __('Support') . ':</a>';
    $links[] = '<br><center style="width:275px;color:white;background-color:#02a0d2;border-radius:0px 30px">marcel@featuredimagefromurl.com</center>';
    return $links;
}

