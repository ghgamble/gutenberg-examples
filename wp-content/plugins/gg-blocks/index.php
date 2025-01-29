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
        add_action('enqueue_block_editor_assets', array($this, 'adminAssets'));
    }
    function adminAssets() {
        wp_enqueue_script('ournewblocktype', plugin_dir_url(__FILE__) . 'test.js', array('wp-blocks', 'wp-element'));
    }
}

$ggBlocks = new GgBlocks();