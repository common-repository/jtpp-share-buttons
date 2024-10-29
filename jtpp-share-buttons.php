<?php
/*
Plugin Name: JTPP Share Buttons
Plugin URI:  https://wordpress.org/plugins/jtpp-share-buttons/
Text Domain: jtpp-share-buttons
Domain Path: /languages
Description: You can display share-buttons at all of single posts and single pages very easily.
Version:     0.1.0
Author:      aki-t
Author URI:  https://jtpp.org/
License:     GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit;

require_once( 'includes/plugin-page.php' );
require_once( 'includes/share-buttons.php' );

add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'jtpp-share-buttons', false, plugin_dir_path( __FILE__ ) . 'languages/' );
} );

// Show before single posts
function jtpp_get_show_before_single() {
    $o = get_option( 'jtpp_share_buttons' );
    if( isset( $o['show_before_single'] ) ) return $o['show_before_single'];
}

// Show after single posts
function jtpp_get_show_after_single() {
    $o = get_option( 'jtpp_share_buttons' );
    if( isset( $o['show_after_single'] ) ) return $o['show_after_single'];
}

// Show before single pages
function jtpp_get_show_before_page() {
    $o = get_option( 'jtpp_share_buttons' );
    if( isset( $o['show_before_page'] ) ) return $o['show_before_page'];
}

// Show after single pages
function jtpp_get_show_after_page() {
    $o = get_option( 'jtpp_share_buttons' );
    if( isset( $o['show_after_page'] ) ) return $o['show_after_page'];
}

// Select design
function jtpp_get_buttons_design() {
    $o = get_option( 'jtpp_share_buttons' );
    if( isset( $o['select_design'] ) ) return $o['select_design'];
}

// Add Share Buttons
function jtpp_add_share_buttons( $the_content ) {
    $share_buttons = jtpp_share_buttons_list();
    if( is_single() ) {
        $return = $the_content;
        if( jtpp_get_show_before_single() != "hide" ) {
            $return = $share_buttons . $return;
        }
        if( jtpp_get_show_after_single() != "hide" ) {
            $return = $return . $share_buttons;
        }
        return $return;
    } elseif( is_page() ) {
        $return = $the_content;
        if( jtpp_get_show_before_page() == "show" ) {
            $return = $share_buttons . $return;
        }
        if( jtpp_get_show_after_page() == "show" ) {
            $return = $return . $share_buttons;
        }
        return $return;
    } else {
        return $the_content;
    }
}
add_filter( 'the_content', 'jtpp_add_share_buttons' );

function jtpp_share_buttons_styles() {
    if( jtpp_get_buttons_design() == "01" ) {
        wp_register_style( 'jtpp-share-buttons-style', plugins_url( '/', __FILE__ ) . 'includes/css/style01.css', array(), NULL );
        wp_enqueue_style( 'jtpp-share-buttons-style' );
    } elseif( jtpp_get_buttons_design() == "02" ) {
        wp_register_style( 'jtpp-share-buttons-style', plugins_url( '/', __FILE__ ) . 'includes/css/style02.css', array(), NULL );
        wp_enqueue_style( 'jtpp-share-buttons-style' );
    } else {
        wp_register_style( 'jtpp-share-buttons-style', plugins_url( '/', __FILE__ ) . 'includes/css/style01.css', array(), NULL );
        wp_enqueue_style( 'jtpp-share-buttons-style' );
    }
}
add_action( 'wp_enqueue_scripts', 'jtpp_share_buttons_styles' );

