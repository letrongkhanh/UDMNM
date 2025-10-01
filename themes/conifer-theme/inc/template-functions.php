<?php
/**
 * Template functions
 *
 * @package Conifer
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fallback menu
 */
function conifer_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . home_url() . '">' . __('Home', 'conifer') . '</a></li>';
    echo '<li><a href="' . get_permalink(get_page_by_path('about')) . '">' . __('About', 'conifer') . '</a></li>';
    echo '<li><a href="' . get_permalink(get_page_by_path('products')) . '">' . __('Products', 'conifer') . '</a></li>';
    echo '<li><a href="' . get_permalink(get_page_by_path('blog')) . '">' . __('Blog', 'conifer') . '</a></li>';
    echo '<li><a href="' . get_permalink(get_page_by_path('contact')) . '">' . __('Contact', 'conifer') . '</a></li>';
    echo '</ul>';
}

/**
 * Get hero slides
 */
function conifer_get_hero_slides() {
    $slides = get_posts(array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'meta_key' => '_conifer_hero_slide',
        'meta_value' => '1',
        'posts_per_page' => -1,
    ));

    if (empty($slides)) {
        // Default slides
        $default_slides = array(
            array('image' => CONIFER_THEME_URL . '/assets/images/sample-1.jpg'),
            array('image' => CONIFER_THEME_URL . '/assets/images/sample-2.jpg'),
        );
        return $default_slides;
    }

    return $slides;
}

/**
 * Get featured products
 */
function conifer_get_featured_products($limit = 6) {
    return get_posts(array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'meta_key' => '_conifer_featured',
        'meta_value' => '1',
    ));
}

/**
 * Get latest posts
 */
function conifer_get_latest_posts($limit = 4) {
    return get_posts(array(
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
    ));
}

/**
 * Get product price
 */
function conifer_get_product_price($product_id) {
    $price = get_post_meta($product_id, '_product_price', true);
    $sale_price = get_post_meta($product_id, '_product_sale_price', true);
    
    if ($sale_price && $sale_price < $price) {
        return array(
            'price' => $price,
            'sale_price' => $sale_price,
            'on_sale' => true
        );
    }
    
    return array(
        'price' => $price ?: 29.99,
        'sale_price' => null,
        'on_sale' => false
    );
}

/**
 * Get product categories
 */
function conifer_get_product_categories($limit = 3) {
    return get_terms(array(
        'taxonomy' => 'product_category',
        'hide_empty' => false,
        'number' => $limit,
    ));
}

/**
 * Get testimonials
 */
function conifer_get_testimonials($limit = 3) {
    return get_posts(array(
        'post_type' => 'testimonial',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
    ));
}

/**
 * Format currency
 */
function conifer_format_currency($amount) {
    return '$' . number_format($amount, 2);
}

/**
 * Get breadcrumbs
 */
function conifer_breadcrumbs() {
    if (is_home() || is_front_page()) {
        return;
    }

    echo '<nav class="breadcrumb">';
    echo '<a href="' . home_url() . '">' . __('Home', 'conifer') . '</a>';

    if (is_category() || is_single()) {
        echo ' / ';
        the_category(' / ');
        if (is_single()) {
            echo ' / ';
            the_title();
        }
    } elseif (is_page()) {
        echo ' / ';
        echo the_title();
    } elseif (is_search()) {
        echo ' / ';
        echo __('Search Results for: ', 'conifer') . get_search_query();
    }

    echo '</nav>';
}

/**
 * Get social media links
 */
function conifer_get_social_links() {
    $social_links = array(
        'facebook' => get_theme_mod('conifer_facebook_url', ''),
        'instagram' => get_theme_mod('conifer_instagram_url', ''),
        'twitter' => get_theme_mod('conifer_twitter_url', ''),
        'youtube' => get_theme_mod('conifer_youtube_url', ''),
    );

    return array_filter($social_links);
}

/**
 * Get contact information
 */
function conifer_get_contact_info() {
    return array(
        'phone' => get_theme_mod('conifer_phone', '+84 905 567 890'),
        'email' => get_theme_mod('conifer_email', 'info@conifer.com'),
        'address' => get_theme_mod('conifer_address', '41 Nguyen Hue, Hue City, Vietnam'),
    );
}

/**
 * Get theme options
 */
function conifer_get_theme_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}

/**
 * Check if ACF is active
 */
function conifer_is_acf_active() {
    return function_exists('get_field');
}

/**
 * Get ACF field with fallback
 */
function conifer_get_field($field_name, $post_id = null, $default = '') {
    if (conifer_is_acf_active()) {
        $value = get_field($field_name, $post_id);
        return $value ?: $default;
    }
    return $default;
}

/**
 * Get product gallery
 */
function conifer_get_product_gallery($product_id) {
    $gallery = get_post_meta($product_id, '_product_gallery', true);
    if (is_string($gallery)) {
        $gallery = explode(',', $gallery);
    }
    return $gallery ?: array();
}

/**
 * Get related products
 */
function conifer_get_related_products($product_id, $limit = 4) {
    $categories = wp_get_post_terms($product_id, 'product_category', array('fields' => 'ids'));
    
    if (empty($categories)) {
        return array();
    }

    return get_posts(array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'post__not_in' => array($product_id),
        'tax_query' => array(
            array(
                'taxonomy' => 'product_category',
                'field' => 'term_id',
                'terms' => $categories,
            ),
        ),
    ));
}

/**
 * Get product attributes
 */
function conifer_get_product_attributes($product_id) {
    $attributes = array();
    
    $meta_keys = array(
        '_product_size' => 'Size',
        '_product_color' => 'Color',
        '_product_care_level' => 'Care Level',
        '_product_light_requirements' => 'Light Requirements',
        '_product_water_frequency' => 'Water Frequency',
    );
    
    foreach ($meta_keys as $meta_key => $label) {
        $value = get_post_meta($product_id, $meta_key, true);
        if ($value) {
            $attributes[$meta_key] = array(
                'label' => $label,
                'value' => $value
            );
        }
    }
    
    return $attributes;
}

/**
 * Get blog post excerpt
 */
function conifer_get_post_excerpt($post_id = null, $length = 20) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post = get_post($post_id);
    if (!$post) {
        return '';
    }
    
    if ($post->post_excerpt) {
        return $post->post_excerpt;
    }
    
    return wp_trim_words($post->post_content, $length);
}

/**
 * Get post reading time
 */
function conifer_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Assuming 200 words per minute
    
    return $reading_time . ' min read';
}

/**
 * Get post author avatar
 */
function conifer_get_author_avatar($author_id, $size = 40) {
    $avatar = get_avatar($author_id, $size, '', '', array('class' => 'author-avatar'));
    return $avatar;
}

/**
 * Get post categories with links
 */
function conifer_get_post_categories($post_id = null, $separator = ', ') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $categories = get_the_category($post_id);
    if (empty($categories)) {
        return '';
    }
    
    $category_links = array();
    foreach ($categories as $category) {
        $category_links[] = '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
    }
    
    return implode($separator, $category_links);
}

/**
 * Get post tags with links
 */
function conifer_get_post_tags($post_id = null, $separator = ', ') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $tags = get_the_tags($post_id);
    if (empty($tags)) {
        return '';
    }
    
    $tag_links = array();
    foreach ($tags as $tag) {
        $tag_links[] = '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>';
    }
    
    return implode($separator, $tag_links);
}
