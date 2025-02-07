<?php

/*
    Plugin Name: GG Blocks
    Description: Give your readers a multiple choice question.
    Version: 1.0
    Author: Grace Gamble
    Author URI: http://gg-dev.co
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class GgBlocks {
    function __construct() {
        add_action('init', array($this, 'adminAssets'));
    }
    function adminAssets() {
        wp_register_style('gg-blocks-css', plugin_dir_url(__FILE__) . 'build/index.css');
        wp_register_script('ournewblocktype', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
        register_block_type('gg-blocks/test-block', array(
            'editor_script' => 'ournewblocktype',
            'render_callback' => array($this, 'testBlockOutput')
        ));
        register_block_type('gg-blocks/multiple-choice', array(
            'editor_script' => 'ournewblocktype',
            'editor_style' => 'gg-blocks-css',
            'render_callback' => array($this, 'multipleChoiceOutput')
        ));
    }
    function testBlockOutput($attributes) {
        ob_start(); ?>
        <p>Today the sky is <?php echo esc_html($attributes['skyColor']) ?> and the grass is <?php echo esc_html($attributes['grassColor']) ?>.</p>
        <?php return ob_get_clean();
    }
}

$ggBlocks = new GgBlocks();