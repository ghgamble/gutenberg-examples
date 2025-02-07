<?php

/*
    Plugin Name: GG Blocks
    Description: Give your readers a multiple-choice question.
    Version: 1.0
    Author: Grace Gamble
    Author URI: http://gg-dev.co
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GgBlocks {
    function __construct() {
        add_action('init', array($this, 'register_blocks'));
    }

    function register_blocks() {
        // Register backend editor assets
        wp_register_style(
            'gg-blocks-css',
            plugin_dir_url(__FILE__) . 'build/index.css',
            array(),
            file_exists(plugin_dir_path(__FILE__) . 'build/index.css') ? filemtime(plugin_dir_path(__FILE__) . 'build/index.css') : false
        );

        wp_register_script(
            'gg-blocks-js',
            plugin_dir_url(__FILE__) . 'build/index.js',
            array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-hooks'),
            file_exists(plugin_dir_path(__FILE__) . 'build/index.js') ? filemtime(plugin_dir_path(__FILE__) . 'build/index.js') : false,
            true
        );

        // Register the Test Block with `testBlockOutput()`
        register_block_type('gg-blocks/test-block', array(
            'editor_script'   => 'gg-blocks-js',
            'editor_style'    => 'gg-blocks-css',
            'render_callback' => array($this, 'testBlockOutput')
        ));

        // Register the Multiple Choice Block with `outputFunc()`
        register_block_type('gg-blocks/multiple-choice', array(
            'editor_script'   => 'gg-blocks-js',
            'editor_style'    => 'gg-blocks-css',
            'render_callback' => array($this, 'outputFunc')
        ));
    }

    // ✅ Function to Output `test-block` Content
    function testBlockOutput($attributes) {
        error_log("testBlockOutput() is running...");

        ob_start(); ?>
        <p>Today the sky is <?php echo esc_html($attributes['skyColor'] ?? 'blue'); ?> 
            and the grass is <?php echo esc_html($attributes['grassColor'] ?? 'green'); ?>.</p>
        <?php 
        return ob_get_clean();
    }

    // ✅ Function to Output `multiple-choice` Content and Enqueue Frontend Scripts
    function outputFunc($attributes) {
        error_log("outputFunc() is running...");

        $frontend_js_path = plugin_dir_path(__FILE__) . 'build/frontend.js';
        $frontend_css_path = plugin_dir_path(__FILE__) . 'build/frontend.css';

        if (file_exists($frontend_js_path)) {
            wp_enqueue_script(
                'gg-frontEndJS',
                plugin_dir_url(__FILE__) . 'build/frontend.js',
                array('wp-element', 'wp-blocks'),
                filemtime($frontend_js_path),
                true
            );
        } else {
            error_log("frontend.js is missing!");
        }

        if (file_exists($frontend_css_path)) {
            wp_enqueue_style(
                'gg-frontEndCSS',
                plugin_dir_url(__FILE__) . 'build/frontend.css',
                array(),
                filemtime($frontend_css_path)
            );
        } else {
            error_log("frontend.css is missing!");
        }
        ob_start(); ?>
        <div class="mc-update-me"></div>
        <?php return ob_get_clean();
    }
}

// ✅ Initialize the Plugin
new GgBlocks();
