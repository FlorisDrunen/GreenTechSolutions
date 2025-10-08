<?php
if ( ! function_exists( 'floris_setup' ) ) {
    function floris_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'custom-logo' );
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
        register_nav_menus( array( 'primary' => __( 'Primary Menu', 'floris' ) ) );
    }
}
add_action( 'after_setup_theme', 'floris_setup' );

function floris_scripts() {
    // Enqueue main stylesheet if exists in assets/style.css
    wp_enqueue_style( 'floris-main', get_stylesheet_directory_uri() . '/assets/style.css', array(), filemtime( get_stylesheet_directory() . '/assets/style.css' ) );
    // Enqueue any found JS (main.js) if present
    if ( file_exists( get_stylesheet_directory() . '/assets/main.js' ) ) {
        wp_enqueue_script( 'floris-main-js', get_stylesheet_directory_uri() . '/assets/main.js', array('jquery'), filemtime( get_stylesheet_directory() . '/assets/main.js' ), true );
    }
}
add_action( 'wp_enqueue_scripts', 'floris_scripts' );
?>