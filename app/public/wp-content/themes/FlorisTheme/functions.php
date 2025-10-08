<?php

function test()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'test');

function loadCss()
{
    wp_enqueue_style('theme_style', get_stylesheet_uri());

    wp_enqueue_script('jquery');
    
    // Vendor scripts
    wp_enqueue_script('browser', get_template_directory_uri() . '/browser.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('breakpoints', get_template_directory_uri() . '/breakpoints.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('util', get_template_directory_uri() . '/util.js', array('jquery', 'breakpoints'), '1.0.0', true);

    // Main script (na util, breakpoints en jquery)
    wp_enqueue_script('main', get_template_directory_uri() . '/main.js', array('jquery', 'util', 'breakpoints'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'loadCss');

// --- FlorisTheme additions ---

// FlorisTheme - functions.php (added menu and sidebar registration)
if ( ! function_exists( 'floris_setup' ) ) {
    function floris_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
    }
}
add_action( 'after_setup_theme', 'floris_setup' );

function floris_scripts() {
    wp_enqueue_style( 'floris-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'floris_scripts' );

// Register navigation menu
function floris_register_menus() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'floristheme-updated' ),
    ) );
}
add_action( 'init', 'floris_register_menus' );

// Register widget area (sidebar)
function floris_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'floristheme-updated' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'floristheme-updated' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'floris_widgets_init' );
