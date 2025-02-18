<?php
/**
 * Plugin Name: Responsive Image Slider Block
 * Description: A custom Gutenberg block for creating responsive image sliders
 * Version: 1.0.0
 * Author: Rafiat Daniju
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function register_image_slider_block() {
    // Register JavasScript for block editor
    wp_register_script(
        'image-slider-block-editor',
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n', 'wp-components'),
        filemtime(plugin_dir_path(__FILE__) . 'block.js')
    );

    // Register block editor styles
    wp_register_style(
        'image-slider-block-editor-style',
        plugins_url('editor.css', __FILE__),
        array('wp-edit-blocks'),
        filemtime(plugin_dir_path(__FILE__) . 'editor.css')
    );


    // Register frontend styles
    wp_register_style(
        'image-slider-block-style',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );

    // Register the block
    register_block_type('custom/image-slider', array(
        'editor_script' => 'image-slider-block-editor',
        'editor_style' => 'image-slider-block-editor-style',
        'style' => 'image-slider-block-style',
        'render_callback' => 'render_image_slider_block'
    ));
}
add_action('init', 'register_image_slider_block');

function render_image_slider_block($attributes) {
    if (empty($attributes['images'])) {
        return '';
    }

    $images = $attributes['images'];
    $slider_id = 'slider-' . uniqid();
    
    ob_start(); ?>
    <div class="custom-image-slider" id="<?php echo esc_attr($slider_id); ?>">
        <div class="slider-container">
            <?php foreach ($images as $image): ?>
                <div class="slide">
                    <img src="<?php echo esc_url($image['url']); ?>" 
                         alt="<?php echo esc_attr($image['alt']); ?>"
                         width="<?php echo esc_attr($image['width']); ?>"
                         height="<?php echo esc_attr($image['height']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <button class="slider-prev" aria-label="Previous slide">‹</button>
        <button class="slider-next" aria-label="Next slide">›</button>
    </div>
    <?php
    return ob_get_clean();
}

// Enqueue Scripts for Frontend
function image_slider_enqueue_scripts() {
    wp_enqueue_script('image_slider-frontend', plugins_url('frontend.js', __FILE__), array('jquery'), filemtime(plugin_dir_path(__FILE__) . 'frontend.js'), true);
}
add_action('wp_enqueue_scripts', 'image_slider_enqueue_scripts');
