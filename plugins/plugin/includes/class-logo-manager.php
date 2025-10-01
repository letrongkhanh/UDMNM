<?php
/**
 * Class quản lý logo
 */
class Logo_Manager {
    
    public function __construct() {
        add_action('customize_register', array($this, 'add_logo_customizer'));
        add_action('wp_head', array($this, 'add_logo_styles'));
    }
    
    public function add_logo_customizer($wp_customize) {
        // Thêm section cho logo
        $wp_customize->add_section('conifer_logo_section', array(
            'title' => __('Logo Settings', 'conifer-features'),
            'priority' => 30,
        ));
        
        // Logo chính
        $wp_customize->add_setting('conifer_main_logo', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'conifer_main_logo', array(
            'label' => __('Main Logo', 'conifer-features'),
            'section' => 'conifer_logo_section',
            'settings' => 'conifer_main_logo',
        )));
        
        // Logo footer
        $wp_customize->add_setting('conifer_footer_logo', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'conifer_footer_logo', array(
            'label' => __('Footer Logo', 'conifer-features'),
            'section' => 'conifer_logo_section',
            'settings' => 'conifer_footer_logo',
        )));
        
        // Kích thước logo
        $wp_customize->add_setting('conifer_logo_width', array(
            'default' => '150',
            'sanitize_callback' => 'absint',
        ));
        
        $wp_customize->add_control('conifer_logo_width', array(
            'label' => __('Logo Width (px)', 'conifer-features'),
            'section' => 'conifer_logo_section',
            'type' => 'number',
        ));
        
        $wp_customize->add_setting('conifer_logo_height', array(
            'default' => '50',
            'sanitize_callback' => 'absint',
        ));
        
        $wp_customize->add_control('conifer_logo_height', array(
            'label' => __('Logo Height (px)', 'conifer-features'),
            'section' => 'conifer_logo_section',
            'type' => 'number',
        ));
    }
    
    public function add_logo_styles() {
        $main_logo = get_theme_mod('conifer_main_logo');
        $footer_logo = get_theme_mod('conifer_footer_logo');
        $logo_width = get_theme_mod('conifer_logo_width', 150);
        $logo_height = get_theme_mod('conifer_logo_height', 50);
        
        echo '<style type="text/css">';
        
        if ($main_logo) {
            echo '.site-logo img, .custom-logo { max-width: ' . $logo_width . 'px; max-height: ' . $logo_height . 'px; }';
        }
        
        if ($footer_logo) {
            echo '.footer-logo img { max-width: ' . $logo_width . 'px; max-height: ' . $logo_height . 'px; }';
        }
        
        echo '</style>';
    }
    
    public static function get_main_logo() {
        $logo = get_theme_mod('conifer_main_logo');
        if ($logo) {
            return $logo;
        }
        return get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '';
    }
    
    public static function get_footer_logo() {
        return get_theme_mod('conifer_footer_logo', '');
    }
}
