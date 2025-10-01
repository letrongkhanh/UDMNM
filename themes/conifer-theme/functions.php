<?php
/**
 * Conifer Theme Functions
 *
 * @package Conifer
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('CONIFER_THEME_VERSION', '1.0.0');
define('CONIFER_THEME_URL', get_template_directory_uri());
define('CONIFER_THEME_PATH', get_template_directory());

/**
 * Theme Setup
 */
function conifer_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'conifer'),
        'footer' => __('Footer Menu', 'conifer'),
    ));
    
    // Add image sizes
    add_image_size('conifer-hero', 1920, 600, true);
    add_image_size('conifer-blog', 400, 300, true);
    add_image_size('conifer-category', 80, 80, true);
    add_image_size('conifer-product', 300, 300, true);
}
add_action('after_setup_theme', 'conifer_setup');

/**
 * Enqueue Scripts and Styles
 */
function conifer_scripts() {
    // Enqueue main stylesheet (WordPress requirement - theme info only)
    wp_enqueue_style('conifer-style', get_stylesheet_uri(), array(), CONIFER_THEME_VERSION);
    
    // Enqueue main theme CSS
    wp_enqueue_style('conifer-theme', CONIFER_THEME_URL . '/assets/css/theme.css', array('conifer-style'), CONIFER_THEME_VERSION);
    
    // Enqueue additional CSS
    wp_enqueue_style('conifer-main', CONIFER_THEME_URL . '/assets/css/main.css', array('conifer-theme'), CONIFER_THEME_VERSION);
    
    // css woocommerce đã tắt - không cần thiết
    
    // Enqueue customizer CSS
    wp_enqueue_style('conifer-customizer', CONIFER_THEME_URL . '/assets/css/customizer.css', array('conifer-main'), CONIFER_THEME_VERSION);
    
    // Enqueue Google Fonts
    wp_enqueue_style('conifer-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Enqueue Font Awesome
    wp_enqueue_style('conifer-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // Enqueue main JavaScript
    wp_enqueue_script('conifer-script', CONIFER_THEME_URL . '/assets/js/main.js', array('jquery'), CONIFER_THEME_VERSION, true);
    
    // Localize script for AJAX
    wp_localize_script('conifer-script', 'conifer_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('conifer_nonce'),
    ));
    
    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'conifer_scripts');

/**
 * Register Widget Areas
 */
function conifer_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'conifer'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'conifer'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer 1', 'conifer'),
        'id' => 'footer-1',
        'description' => __('Add widgets here.', 'conifer'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer 2', 'conifer'),
        'id' => 'footer-2',
        'description' => __('Add widgets here.', 'conifer'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer 3', 'conifer'),
        'id' => 'footer-3',
        'description' => __('Add widgets here.', 'conifer'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer 4', 'conifer'),
        'id' => 'footer-4',
        'description' => __('Add widgets here.', 'conifer'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'conifer_widgets_init');

/**
 * Custom Post Types
 */
function conifer_register_post_types() {
    // Products Post Type
    register_post_type('product', array(
        'labels' => array(
            'name' => __('Products', 'conifer'),
            'singular_name' => __('Product', 'conifer'),
            'add_new' => __('Add New Product', 'conifer'),
            'add_new_item' => __('Add New Product', 'conifer'),
            'edit_item' => __('Edit Product', 'conifer'),
            'new_item' => __('New Product', 'conifer'),
            'view_item' => __('View Product', 'conifer'),
            'search_items' => __('Search Products', 'conifer'),
            'not_found' => __('No products found', 'conifer'),
            'not_found_in_trash' => __('No products found in trash', 'conifer'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'products'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon' => 'dashicons-products',
        'show_in_rest' => true,
    ));
    
    // Testimonials Post Type
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => __('Testimonials', 'conifer'),
            'singular_name' => __('Testimonial', 'conifer'),
            'add_new' => __('Add New Testimonial', 'conifer'),
            'add_new_item' => __('Add New Testimonial', 'conifer'),
            'edit_item' => __('Edit Testimonial', 'conifer'),
            'new_item' => __('New Testimonial', 'conifer'),
            'view_item' => __('View Testimonial', 'conifer'),
            'search_items' => __('Search Testimonials', 'conifer'),
            'not_found' => __('No testimonials found', 'conifer'),
            'not_found_in_trash' => __('No testimonials found in trash', 'conifer'),
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-format-quote',
        'show_in_rest' => true,
    ));
}
add_action('init', 'conifer_register_post_types');

/**
 * Custom Taxonomies
 */
function conifer_register_taxonomies() {
    // Product Categories
    register_taxonomy('product_category', 'product', array(
        'labels' => array(
            'name' => __('Product Categories', 'conifer'),
            'singular_name' => __('Product Category', 'conifer'),
            'search_items' => __('Search Categories', 'conifer'),
            'all_items' => __('All Categories', 'conifer'),
            'parent_item' => __('Parent Category', 'conifer'),
            'parent_item_colon' => __('Parent Category:', 'conifer'),
            'edit_item' => __('Edit Category', 'conifer'),
            'update_item' => __('Update Category', 'conifer'),
            'add_new_item' => __('Add New Category', 'conifer'),
            'new_item_name' => __('New Category Name', 'conifer'),
            'menu_name' => __('Categories', 'conifer'),
        ),
        'hierarchical' => true,
        'public' => true,
        'rewrite' => array('slug' => 'product-category'),
        'show_in_rest' => true,
    ));
    
    // Product Tags
    register_taxonomy('product_tag', 'product', array(
        'labels' => array(
            'name' => __('Product Tags', 'conifer'),
            'singular_name' => __('Product Tag', 'conifer'),
            'search_items' => __('Search Tags', 'conifer'),
            'popular_items' => __('Popular Tags', 'conifer'),
            'all_items' => __('All Tags', 'conifer'),
            'edit_item' => __('Edit Tag', 'conifer'),
            'update_item' => __('Update Tag', 'conifer'),
            'add_new_item' => __('Add New Tag', 'conifer'),
            'new_item_name' => __('New Tag Name', 'conifer'),
            'separate_items_with_commas' => __('Separate tags with commas', 'conifer'),
            'add_or_remove_items' => __('Add or remove tags', 'conifer'),
            'choose_from_most_used' => __('Choose from the most used tags', 'conifer'),
            'menu_name' => __('Tags', 'conifer'),
        ),
        'hierarchical' => false,
        'public' => true,
        'rewrite' => array('slug' => 'product-tag'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'conifer_register_taxonomies');

/**
 * ACF Support
 */
function conifer_acf_support() {
    // Check if ACF is active
    if (function_exists('acf_add_options_page')) {
        // Add theme options page
        acf_add_options_page(array(
            'page_title' => __('Theme Options', 'conifer'),
            'menu_title' => __('Theme Options', 'conifer'),
            'menu_slug' => 'theme-options',
            'capability' => 'edit_posts',
        ));
        
        // Add footer options page
        acf_add_options_sub_page(array(
            'page_title' => __('Footer Options', 'conifer'),
            'menu_title' => __('Footer', 'conifer'),
            'parent_slug' => 'theme-options',
        ));
    }
}
add_action('acf/init', 'conifer_acf_support');


/**
 * AJAX Handlers
 */
function conifer_newsletter_subscribe() {
    check_ajax_referer('conifer_nonce', 'nonce');
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Invalid email address', 'conifer')));
    }
    
    // Here you would typically save to database or send to email service
    // For now, we'll just return success
    wp_send_json_success(array('message' => __('Thank you for subscribing!', 'conifer')));
}
add_action('wp_ajax_conifer_newsletter_subscribe', 'conifer_newsletter_subscribe');
add_action('wp_ajax_nopriv_conifer_newsletter_subscribe', 'conifer_newsletter_subscribe');

/**
 * Helper Functions
 */



/**
 * Include additional files
 */
require_once CONIFER_THEME_PATH . '/inc/customizer.php';
require_once CONIFER_THEME_PATH . '/inc/template-functions.php';
// require_once CONIFER_THEME_PATH . '/inc/woocommerce.php'; // đã tắt - không cần woocommerce
require_once CONIFER_THEME_PATH . '/inc/acf-fields.php';
