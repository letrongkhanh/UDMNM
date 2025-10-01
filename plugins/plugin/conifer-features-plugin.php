<?php
/**
 * Plugin Name: Conifer Features Plugin
 * Plugin URI: https://yourwebsite.com
 * Description: Plugin tùy chỉnh cho theme Conifer với các tính năng: đổi logo, slider, form liên hệ, gallery, rating
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: conifer-features
 */

// Ngăn chặn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Định nghĩa các hằng số
define('CONIFER_FEATURES_VERSION', '1.0.0');
define('CONIFER_FEATURES_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CONIFER_FEATURES_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Include các file cần thiết
require_once CONIFER_FEATURES_PLUGIN_PATH . 'includes/class-conifer-features.php';
require_once CONIFER_FEATURES_PLUGIN_PATH . 'includes/class-logo-manager.php';
require_once CONIFER_FEATURES_PLUGIN_PATH . 'includes/class-slider-manager.php';
require_once CONIFER_FEATURES_PLUGIN_PATH . 'includes/class-contact-form.php';
require_once CONIFER_FEATURES_PLUGIN_PATH . 'includes/class-gallery-manager.php';
require_once CONIFER_FEATURES_PLUGIN_PATH . 'includes/class-rating-manager.php';
require_once CONIFER_FEATURES_PLUGIN_PATH . 'admin/class-admin.php';

// Khởi tạo plugin
function conifer_features_init() {
    new Conifer_Features();
}
add_action('plugins_loaded', 'conifer_features_init');

// Kích hoạt plugin
register_activation_hook(__FILE__, 'conifer_features_activate');
function conifer_features_activate() {
    // Tạo bảng database nếu cần
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'conifer_ratings';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        post_id bigint(20) NOT NULL,
        user_id bigint(20) NOT NULL,
        rating int(1) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY unique_rating (post_id, user_id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Hủy kích hoạt plugin
register_deactivation_hook(__FILE__, 'conifer_features_deactivate');
function conifer_features_deactivate() {
    // Xóa dữ liệu tạm thời nếu cần
}
