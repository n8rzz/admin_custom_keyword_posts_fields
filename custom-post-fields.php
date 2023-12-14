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
// Add custom fields to posts
function custom_post_fields() {
    add_meta_box(
        'custom_post_fields',
        'Custom Fields',
        'display_custom_post_fields',
        'post',
        'normal',
        'high'
    );
}

function display_custom_post_fields($post) {
    // Add your custom fields here
    $keywords_value = get_post_meta($post->ID, '_keywords_field', true);
    $long_tail_keywords_value = get_post_meta($post->ID, '_long_tail_keywords_field', true);
    $lsi_keywords_value = get_post_meta($post->ID, '_lsi_keywords_field', true);

    ?>
    <label for="keywords_field"><b>Keywords:</b></label>
    <br>
    <input type="text" id="keywords_field" name="keywords_field" value="<?php echo esc_attr($keywords_value); ?>">
    <br><br>

    <label for="long_tail_keywords_field"><b>Long-Tail Keywords:</b></label>
    <br>
    <input type="text" id="long_tail_keywords_field" name="long_tail_keywords_field" value="<?php echo esc_attr($long_tail_keywords_value); ?>">
    <br><br>

    <label for="lsi_keywords_field"><b>LSI Keywords:</b></label>
    <br>
    <input type="text" id="lsi_keywords_field" name="lsi_keywords_field" value="<?php echo esc_attr($lsi_keywords_value); ?>">
    <br><br>
    <?php
}

function save_custom_post_fields($post_id) {
    // Save custom fields
    update_post_meta($post_id, '_keywords_field', sanitize_text_field($_POST['keywords_field']));
    update_post_meta($post_id, '_long_tail_keywords_field', sanitize_text_field($_POST['long_tail_keywords_field']));
    update_post_meta($post_id, '_lsi_keywords_field', sanitize_text_field($_POST['lsi_keywords_field']));
}

add_action('add_meta_boxes', 'custom_post_fields');
add_action('save_post', 'save_custom_post_fields');

// Display custom fields in the posts table
function custom_columns_head($defaults) {
    $defaults['keywords_field'] = 'Keywords';
    $defaults['long_tail_keywords_field'] = 'Long-Tail Keywords';
    $defaults['lsi_keywords_field'] = 'LSI Keywords';
    return $defaults;
}

function custom_columns_content($column_name, $post_ID) {
    if ($column_name == 'keywords_field') {
        echo get_post_meta($post_ID, '_keywords_field', true);
    }
    if ($column_name == 'long_tail_keywords_field') {
        echo get_post_meta($post_ID, '_long_tail_keywords_field', true);
    }
    if ($column_name == 'lsi_keywords_field') {
        echo get_post_meta($post_ID, '_lsi_keywords_field', true);
    }
}

add_filter('manage_posts_columns', 'custom_columns_head');
add_action('manage_posts_custom_column', 'custom_columns_content', 10, 2);
