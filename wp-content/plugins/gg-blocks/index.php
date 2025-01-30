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
        wp_register_script('ournewblocktype', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element'));
        register_block_type('gg-blocks/are-you-paying-attention', array(
            'editor_script' => 'ournewblocktype',
            'render_callback' => array($this, 'theHTML')
        ));
    }
    function theHTML($attributes) {
        ob_start(); ?>
        <p>Today the sky is <?php echo esc_html($attributes['skyColor']) ?> and the grass is <?php echo esc_html($attributes['grassColor']) ?>.</p>
        <?php return ob_get_clean();
    }
}

$ggBlocks = new GgBlocks();