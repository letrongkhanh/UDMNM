<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Theme setup
function conifer_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'primary' => __('Primary Menu', 'conifer-theme-2'),
    ]);

    // Load translations
    load_theme_textdomain('conifer-theme-2', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'conifer_theme_setup');

// Enqueue styles and scripts
function conifer_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');

    // Google Fonts & Font Awesome
    wp_enqueue_style(
        'conifer-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'conifer-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
        [],
        '6.0.0'
    );

    // Main site styles from the static project
    wp_enqueue_style(
        'conifer-styles',
        get_stylesheet_directory_uri() . '/assets/css/styles.css',
        ['conifer-google-fonts', 'conifer-fontawesome'],
        filemtime(get_stylesheet_directory() . '/assets/css/styles.css')
    );

    // Main script
    wp_enqueue_script(
        'conifer-script',
        get_stylesheet_directory_uri() . '/assets/js/script.js',
        [],
        filemtime(get_stylesheet_directory() . '/assets/js/script.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'conifer_enqueue_assets');

// Register Custom Post Type and Taxonomy
function conifer_register_cpt_tax() {
    // Custom Post Type: Plant
    $labels = [
        'name' => __('Plants', 'conifer-theme-2'),
        'singular_name' => __('Plant', 'conifer-theme-2'),
        'add_new' => __('Add New', 'conifer-theme-2'),
        'add_new_item' => __('Add New Plant', 'conifer-theme-2'),
        'edit_item' => __('Edit Plant', 'conifer-theme-2'),
        'new_item' => __('New Plant', 'conifer-theme-2'),
        'view_item' => __('View Plant', 'conifer-theme-2'),
        'search_items' => __('Search Plants', 'conifer-theme-2'),
        'not_found' => __('No plants found', 'conifer-theme-2'),
        'not_found_in_trash' => __('No plants found in Trash', 'conifer-theme-2'),
        'all_items' => __('All Plants', 'conifer-theme-2'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'plants'],
        'menu_icon' => 'dashicons-palmtree',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true,
    ];

    register_post_type('plant', $args);

    // Taxonomy: Plant Category
    $tax_labels = [
        'name' => __('Plant Categories', 'conifer-theme-2'),
        'singular_name' => __('Plant Category', 'conifer-theme-2'),
        'search_items' => __('Search Categories', 'conifer-theme-2'),
        'all_items' => __('All Categories', 'conifer-theme-2'),
        'edit_item' => __('Edit Category', 'conifer-theme-2'),
        'update_item' => __('Update Category', 'conifer-theme-2'),
        'add_new_item' => __('Add New Category', 'conifer-theme-2'),
        'new_item_name' => __('New Category Name', 'conifer-theme-2'),
        'menu_name' => __('Categories', 'conifer-theme-2'),
    ];

    $tax_args = [
        'labels' => $tax_labels,
        'hierarchical' => true,
        'public' => true,
        'rewrite' => ['slug' => 'plant-category'],
        'show_in_rest' => true,
    ];

    register_taxonomy('plant_category', ['plant'], $tax_args);
}
add_action('init', 'conifer_register_cpt_tax');

// Custom Fields (Meta Box) for Plant
function conifer_add_plant_metabox() {
    add_meta_box(
        'conifer_plant_details',
        __('Plant Details', 'conifer-theme-2'),
        'conifer_render_plant_metabox',
        'plant',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'conifer_add_plant_metabox');

function conifer_render_plant_metabox($post) {
    wp_nonce_field('conifer_save_plant_meta', 'conifer_plant_meta_nonce');
    $price = get_post_meta($post->ID, '_plant_price', true);
    $light = get_post_meta($post->ID, '_plant_light', true);
    $water = get_post_meta($post->ID, '_plant_water', true);
    ?>
    <p>
        <label for="conifer_plant_price" style="display:block;font-weight:600;"><?php echo esc_html__('Price', 'conifer-theme-2'); ?></label>
        <input type="text" id="conifer_plant_price" name="conifer_plant_price" value="<?php echo esc_attr($price); ?>" style="width:100%;max-width:400px;" />
    </p>
    <p>
        <label for="conifer_plant_light" style="display:block;font-weight:600;"><?php echo esc_html__('Light Requirement', 'conifer-theme-2'); ?></label>
        <select id="conifer_plant_light" name="conifer_plant_light" style="width:100%;max-width:400px;">
            <?php
            $options = ['Low', 'Medium', 'High'];
            foreach ($options as $opt) {
                printf('<option value="%1$s" %2$s>%1$s</option>', esc_attr($opt), selected($light, $opt, false));
            }
            ?>
        </select>
    </p>
    <p>
        <label for="conifer_plant_water" style="display:block;font-weight:600;"><?php echo esc_html__('Water Schedule', 'conifer-theme-2'); ?></label>
        <input type="text" id="conifer_plant_water" name="conifer_plant_water" value="<?php echo esc_attr($water); ?>" placeholder="e.g. Water every 3-4 days" style="width:100%;max-width:400px;" />
    </p>
    <?php
}

function conifer_save_plant_meta($post_id) {
    if (!isset($_POST['conifer_plant_meta_nonce']) || !wp_verify_nonce($_POST['conifer_plant_meta_nonce'], 'conifer_save_plant_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['post_type']) && 'plant' === $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    $price = isset($_POST['conifer_plant_price']) ? sanitize_text_field($_POST['conifer_plant_price']) : '';
    $light = isset($_POST['conifer_plant_light']) ? sanitize_text_field($_POST['conifer_plant_light']) : '';
    $water = isset($_POST['conifer_plant_water']) ? sanitize_text_field($_POST['conifer_plant_water']) : '';

    update_post_meta($post_id, '_plant_price', $price);
    update_post_meta($post_id, '_plant_light', $light);
    update_post_meta($post_id, '_plant_water', $water);
}
add_action('save_post', 'conifer_save_plant_meta');


