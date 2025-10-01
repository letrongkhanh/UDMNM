<?php
/**
 * Class chính của plugin
 */
class Conifer_Features {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    }
    
    public function init() {
        // Khởi tạo các class quản lý
        new Logo_Manager();
        new Slider_Manager();
        new Contact_Form();
        new Gallery_Manager();
        new Rating_Manager();
        
        // Khởi tạo admin interface
        if (is_admin()) {
            new Conifer_Features_Admin();
        }
    }
    
    public function enqueue_scripts() {
        wp_enqueue_style('conifer-features-style', CONIFER_FEATURES_PLUGIN_URL . 'assets/css/style.css', array(), CONIFER_FEATURES_VERSION);
        wp_enqueue_script('conifer-features-script', CONIFER_FEATURES_PLUGIN_URL . 'assets/js/script.js', array('jquery'), CONIFER_FEATURES_VERSION, true);
        
        // Localize script
        wp_localize_script('conifer-features-script', 'conifer_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('conifer_features_nonce')
        ));
    }
    
    public function admin_enqueue_scripts($hook) {
        if (strpos($hook, 'conifer-features') !== false) {
            wp_enqueue_media();
            wp_enqueue_style('conifer-features-admin-style', CONIFER_FEATURES_PLUGIN_URL . 'assets/css/admin.css', array(), CONIFER_FEATURES_VERSION);
            wp_enqueue_script('conifer-features-admin-script', CONIFER_FEATURES_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), CONIFER_FEATURES_VERSION, true);
        }
    }
}
