<?php
/*
    Plugin Name: Custom Keyword Post Fields
    Plugin URI:
    Description: This plugin adds inputs and columns for Keywords, Long-Tail Keywords, and LSI Keywords for Posts
    Version: 1.0
    Author: Nate Geslin
    Author URI:
    License: MIT
*/

function custom_fields_screen_options() {
    add_screen_option(
        'keywords_field_visible',
        array(
            'label'   => esc_html__('Show Keywords', 'textdomain'),
            'default' => false,
            'option'  => 'keywords_field_visible'
        )
    );

    add_screen_option(
        'long_tail_keywords_field_visible',
        array(
            'label'   => esc_html__('Show Long Tail Keywords', 'textdomain'),
            'default' => false,
            'option'  => 'long_tail_keywords_field_visible'
        )
    );

    add_screen_option(
        'lsi_keywords_field_visible',
        array(
            'label'   => esc_html__('Show LSI Keywords', 'textdomain'),
            'default' => false,
            'option'  => 'lsi_keywords_field_visible'
        )
    );
}

function custom_fields_screen_option_display() {
    $custom_fields_visible = array(
        'keywords_field' => get_user_option('keywords_field_visible'),
        'long_tail_keywords_field' => get_user_option('long_tail_keywords_field_visible'),
        'lsi_keywords_field' => get_user_option('lsi_keywords_field_visible'),
    );

    return $custom_fields_visible;
}

function custom_columns_head($defaults) {
    $custom_fields_visible = custom_fields_screen_option_display();

    if ($custom_fields_visible['keywords_field']) {
        $defaults['keywords_field'] = 'Keywords Field';
    }

    if ($custom_fields_visible['long_tail_keywords_field']) {
        $defaults['long_tail_keywords_field'] = 'Long-Tail Keywords Field';
    }

    if ($custom_fields_visible['lsi_keywords_field']) {
        $defaults['lsi_keywords_field'] = 'LSI Keywords Field';
    }

    return $defaults;
}

function custom_columns_content($column_name, $post_ID) {
    $custom_fields_visible = custom_fields_screen_option_display();

    if ($column_name == 'keywords_field' && $custom_fields_visible['keywords_field']) {
        echo get_post_meta($post_ID, '_keywords_field', false);
    }

    if ($column_name == 'long_tail_keywords_field' && $custom_fields_visible['long_tail_keywords_field']) {
        echo get_post_meta($post_ID, '_long_tail_keywords_field', false);
    }

    if ($column_name == 'lsi_keywords_field' && $custom_fields_visible['lsi_keywords_field']) {
        echo get_post_meta($post_ID, '_lsi_keywords_field', false);
    }
}

add_action('admin_init', 'custom_fields_screen_options');
add_filter('manage_posts_columns', 'custom_columns_head');
add_action('manage_posts_custom_column', 'custom_columns_content', 10, 2);