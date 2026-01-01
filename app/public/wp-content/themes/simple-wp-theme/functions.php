<?php
/**
 * Simple WP Theme - enqueue HTML Website assets
 */

if ( ! function_exists( 'simple_theme_setup' ) ) {
    function simple_theme_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        register_nav_menus( array( 'primary' => __( 'Primary Menu', 'simple-wp-theme' ) ) );
    }
}
add_action( 'after_setup_theme', 'simple_theme_setup' );

if ( ! function_exists( 'simple_theme_enqueue' ) ) {
    function simple_theme_enqueue() {
        $dir_uri  = get_template_directory_uri();
        $dir_path = get_template_directory();

        // Font Awesome
        if ( file_exists( $dir_path . '/assets/css/fontawesome-all.min.css' ) ) {
            wp_enqueue_style( 'simple-fontawesome', $dir_uri . '/assets/css/fontawesome-all.min.css', array(), filemtime( $dir_path . '/assets/css/fontawesome-all.min.css' ) );
        }

        // Prefer compiled CSS: assets/css/main.css, anders assets/sass/main.css, anders style.css
        if ( file_exists( $dir_path . '/assets/css/main.css' ) ) {
            wp_enqueue_style( 'simple-main', $dir_uri . '/assets/css/main.css', array( 'simple-fontawesome' ), filemtime( $dir_path . '/assets/css/main.css' ) );
        } elseif ( file_exists( $dir_path . '/assets/sass/main.css' ) ) {
            wp_enqueue_style( 'simple-main', $dir_uri . '/assets/sass/main.css', array( 'simple-fontawesome' ), filemtime( $dir_path . '/assets/sass/main.css' ) );
        } else {
            wp_enqueue_style( 'simple-style', get_stylesheet_uri(), array( 'simple-fontawesome' ), wp_get_theme()->get( 'Version' ) );
        }

        // JavaScript
        $js_list = array( '/assets/js/jquery.min.js', '/assets/js/browser.min.js', '/assets/js/breakpoints.min.js', '/assets/js/util.js', '/assets/js/main.js' );
        foreach ( $js_list as $js ) {
            if ( file_exists( $dir_path . $js ) ) {
                $handle = 'simple-' . preg_replace( '/[^a-z0-9]+/i', '-', trim( $js, '/' ) );
                $deps = ( strpos( $js, 'jquery' ) !== false ) ? array() : array( 'jquery' );
                wp_enqueue_script( $handle, $dir_uri . $js, $deps, filemtime( $dir_path . $js ), true );
            }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'simple_theme_enqueue' );

/**
 * Create demo posts when theme is activated (only if no posts exist).
 */
if ( ! function_exists( 'simple_theme_create_demo_posts' ) ) {
    function simple_theme_create_demo_posts() {
        if ( wp_is_json_request() ) {
            return;
        }

        $counts = wp_count_posts( 'post' );
        if ( ! empty( $counts ) && intval( $counts->publish ) > 0 ) {
            return; // posts already exist
        }

        $demo_posts = array(
            array(
                'post_title'   => 'Welkom bij GreenTech Solutions',
                'post_content' => '<p>Dit is een voorbeeldbericht om je thema te vullen. Vervang deze tekst met je eigen inhoud via het WP-dashboard.</p>',
                'post_status'  => 'publish',
                'post_author'  => get_current_user_id() ?: 1,
            ),
            array(
                'post_title'   => 'Duurzame Innovaties 2025',
                'post_content' => '<p>Voorbeeldpost over duurzame technologieën en projecten. Voeg afbeeldingen en langere tekst toe in de editor.</p>',
                'post_status'  => 'publish',
                'post_author'  => get_current_user_id() ?: 1,
            ),
            array(
                'post_title'   => 'Onze Diensten',
                'post_content' => '<p>Uitleg over aangeboden diensten en contactinformatie. Pas dit bericht aan of verwijder het na gebruik.</p>',
                'post_status'  => 'publish',
                'post_author'  => get_current_user_id() ?: 1,
            ),
        );

        foreach ( $demo_posts as $p ) {
            wp_insert_post( $p );
        }
    }
}
add_action( 'after_switch_theme', 'simple_theme_create_demo_posts' );

/**
 * Populate Primary Sidebar with default widgets if it's empty (runs once in admin).
 */
if ( ! function_exists( 'simple_theme_add_default_widgets' ) ) {
    function simple_theme_add_default_widgets() {
        // Only run in the admin and when the current user can manage widgets
        if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Avoid running more than once
        if ( get_option( 'simple_theme_default_widgets_added' ) ) {
            return;
        }

        $sidebars = get_option( 'sidebars_widgets', array() );
        $sidebar_widgets = isset( $sidebars['sidebar-1'] ) ? $sidebars['sidebar-1'] : array();

        if ( empty( $sidebar_widgets ) || ! is_array( $sidebar_widgets ) ) {
            // Text widget
            $text_widgets = get_option( 'widget_text', array() );
            if ( ! is_array( $text_widgets ) ) {
                $text_widgets = array( '_multiwidget' => 1 );
            }
            $text_widgets[] = array(
                'title'  => 'Over ons',
                'text'   => '<p>Welkom bij GreenTech Solutions — pas dit aan via Weergave → Widgets.</p>',
                'filter' => false,
            );
            end( $text_widgets );
            $text_id = key( $text_widgets );
            update_option( 'widget_text', $text_widgets );

            // Recent posts widget
            $recent_widgets = get_option( 'widget_recent-posts', array() );
            if ( ! is_array( $recent_widgets ) ) {
                $recent_widgets = array( '_multiwidget' => 1 );
            }
            $recent_widgets[] = array(
                'title'  => 'Recente berichten',
                'number' => 5,
            );
            end( $recent_widgets );
            $recent_id = key( $recent_widgets );
            update_option( 'widget_recent-posts', $recent_widgets );

            // Assign these widgets to sidebar-1
            $sidebars['sidebar-1'] = array();
            $sidebars['sidebar-1'][] = 'text-' . $text_id;
            $sidebars['sidebar-1'][] = 'recent-posts-' . $recent_id;
            update_option( 'sidebars_widgets', $sidebars );
        }

        update_option( 'simple_theme_default_widgets_added', 1 );
    }
}
add_action( 'admin_init', 'simple_theme_add_default_widgets' );
/**
 * Register widget area(s).
 */
if ( ! function_exists( 'simple_theme_widgets_init' ) ) {
    function simple_theme_widgets_init() {
        register_sidebar( array(
            'name'          => __( 'Primary Sidebar', 'simple-wp-theme' ),
            'id'            => 'sidebar-1',
            'description'   => __( 'Main sidebar that appears on the right on posts and pages.', 'simple-wp-theme' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }
}
add_action( 'widgets_init', 'simple_theme_widgets_init' );