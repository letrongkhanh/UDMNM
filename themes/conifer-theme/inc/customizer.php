<?php
/**
 * Customizer additions
 *
 * @package Conifer
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function conifer_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector' => '.site-title',
            'render_callback' => 'conifer_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector' => '.site-description',
            'render_callback' => 'conifer_customize_partial_blogdescription',
        ));
    }

    // Add theme options section
    $wp_customize->add_section('conifer_theme_options', array(
        'title' => __('Theme Options', 'conifer'),
        'priority' => 30,
    ));

    // Hero section settings
    $wp_customize->add_setting('conifer_hero_title', array(
        'default' => __('Welcome to Conifer', 'conifer'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('conifer_hero_title', array(
        'label' => __('Hero Title', 'conifer'),
        'section' => 'conifer_theme_options',
        'type' => 'text',
    ));

    $wp_customize->add_setting('conifer_hero_subtitle', array(
        'default' => __('Your trusted plant store', 'conifer'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('conifer_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'conifer'),
        'section' => 'conifer_theme_options',
        'type' => 'text',
    ));

    // Contact information
    $wp_customize->add_setting('conifer_phone', array(
        'default' => '+84 905 567 890',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('conifer_phone', array(
        'label' => __('Phone Number', 'conifer'),
        'section' => 'conifer_theme_options',
        'type' => 'text',
    ));

    $wp_customize->add_setting('conifer_email', array(
        'default' => 'info@conifer.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('conifer_email', array(
        'label' => __('Email Address', 'conifer'),
        'section' => 'conifer_theme_options',
        'type' => 'email',
    ));

    $wp_customize->add_setting('conifer_address', array(
        'default' => '41 Nguyen Hue, Hue City, Vietnam',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('conifer_address', array(
        'label' => __('Address', 'conifer'),
        'section' => 'conifer_theme_options',
        'type' => 'text',
    ));

    // Social Media Links
    $wp_customize->add_section('conifer_social_media', array(
        'title' => __('Social Media Links', 'conifer'),
        'priority' => 35,
    ));

    $social_networks = array(
        'facebook' => __('Facebook URL', 'conifer'),
        'instagram' => __('Instagram URL', 'conifer'),
        'twitter' => __('Twitter URL', 'conifer'),
        'youtube' => __('YouTube URL', 'conifer'),
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("conifer_{$network}_url", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("conifer_{$network}_url", array(
            'label' => $label,
            'section' => 'conifer_social_media',
            'type' => 'url',
        ));
    }

    // Footer Settings
    $wp_customize->add_section('conifer_footer', array(
        'title' => __('Footer Settings', 'conifer'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('conifer_footer_description', array(
        'default' => __('Your trusted online shopping destination for quality products at great prices. We offer fast shipping, secure payments, and excellent customer service.', 'conifer'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('conifer_footer_description', array(
        'label' => __('Footer Description', 'conifer'),
        'section' => 'conifer_footer',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('conifer_copyright_text', array(
        'default' => __('All rights reserved.', 'conifer'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('conifer_copyright_text', array(
        'label' => __('Copyright Text', 'conifer'),
        'section' => 'conifer_footer',
        'type' => 'text',
    ));
}
add_action('customize_register', 'conifer_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function conifer_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function conifer_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function conifer_customize_preview_js() {
    wp_enqueue_script('conifer-customizer', CONIFER_THEME_URL . '/assets/js/customizer.js', array('customize-preview'), CONIFER_THEME_VERSION, true);
}
add_action('customize_preview_init', 'conifer_customize_preview_js');
