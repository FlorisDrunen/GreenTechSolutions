<?php
/**
 * Simple WP Theme - minimal functions
 */

if ( ! function_exists( 'simple_theme_setup' ) ) {
    function simple_theme_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'simple-wp-theme' ),
        ) );
    }
}
add_action( 'after_setup_theme', 'simple_theme_setup' );

if ( ! function_exists( 'simple_theme_enqueue' ) ) {
    function simple_theme_enqueue() {
        $dir_uri  = get_template_directory_uri();
        $dir_path = get_template_directory();

        // Prefer assets/css/main.css (from your original HTML). Fallback to style.css.
        $main_css = '/assets/css/main.css';
        if ( file_exists( $dir_path . $main_css ) ) {
            wp_enqueue_style( 'simple-main', $dir_uri . $main_css, array(), filemtime( $dir_path . $main_css ) );
        } else {
            wp_enqueue_style( 'simple-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
        }

        // Enqueue optional JS from the HTML if present
        $main_js = '/assets/js/main.js';
        if ( file_exists( $dir_path . $main_js ) ) {
            wp_enqueue_script( 'simple-main-js', $dir_uri . $main_js, array( 'jquery' ), filemtime( $dir_path . $main_js ), true );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'simple_theme_enqueue' );