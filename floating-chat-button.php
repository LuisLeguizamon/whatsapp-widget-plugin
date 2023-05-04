<?php
/**
 * Plugin Name: Floating Chat Button
 * Plugin URI: http://www.zentcode.com
 * Description: Floating Action Button to open WhatsApp
 * Version: 1.2.0
 * Author: Zentcode
 * Author URI: https://www.zentcode.com
 */

// Define plugin constants
define( 'MY_PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );

// The widget class
require_once( MY_PLUGIN_NAME_DIR . 'includes/Floating_Chat_Button.php' );

// Register the widget
function my_register_custom_widget() {
	register_widget( 'Floating_Chat_Button' );
}
add_action( 'widgets_init', 'my_register_custom_widget' );

add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
function callback_for_setting_up_scripts() {
    wp_register_style( 'custom-whatsapp',
						plugin_dir_url( __FILE__ ).'css/custom.css',
						array(),
						'1.0'
					);
    wp_enqueue_style( 'custom-whatsapp' );
}
