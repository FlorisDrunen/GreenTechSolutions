<?php
/*
 * Bestand: functions.php
 * Doel: Registreert theme features, enqueue scripts/styles en registreert widgets.
 * Uitleg: Pas hier thema-functies aan (setup, assets, widgets). Voeg of verwijder functies
 * en houd veranderingen kort en gedocumenteerd zodat beheer via WP makkelijk blijft.
 */

if ( ! function_exists( 'simple_theme_setup' ) ) {
    /*
     * simple_theme_setup()
     * Wat: Initialiseert thema-ondersteuning en registreert menu-locaties.
     * Waarom: Zet standaard features aan zodat WordPress en de customizer
     * correct weten hoe ze dit thema moeten behandelen.
     * Belangrijk:
     *  - 'title-tag' laat WP het <title> element beheren.
     *  - 'post-thumbnails' schakelt uitgelichte afbeeldingen in.
     *  - register_nav_menus() registreert een menu-plek (hier: 'primary').
     */
    function simple_theme_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        register_nav_menus( array( 'primary' => __( 'Primary Menu', 'simple-wp-theme' ) ) );
    }
}
add_action( 'after_setup_theme', 'simple_theme_setup' );

if ( ! function_exists( 'simple_theme_enqueue' ) ) {
    /*
     * simple_theme_enqueue()
     * Wat: Voegt styles en scripts toe aan de frontend via wp_enqueue_* functies.
     * Uitleg:
     *  - get_template_directory_uri() geeft de URL van het thema (voor browser).
     *  - get_template_directory() geeft het pad op de schijf (voor file_exists en filemtime).
     *  - filemtime() gebruiken we als versie (cache-busting) zodat browsers updates ophalen.
     */
    function simple_theme_enqueue() {
        $dir_uri  = get_template_directory_uri();
        $dir_path = get_template_directory();

        /* Laad Font Awesome als het bestand aanwezig is */
        if ( file_exists( $dir_path . '/assets/css/fontawesome-all.min.css' ) ) {
            wp_enqueue_style( 'simple-fontawesome', $dir_uri . '/assets/css/fontawesome-all.min.css', array(), filemtime( $dir_path . '/assets/css/fontawesome-all.min.css' ) );
        }

        /* Laad eerst gecompileerde CSS (assets/css/main.css). Als niet aanwezig, probeer assets/sass/main.css, anders style.css */
        if ( file_exists( $dir_path . '/assets/css/main.css' ) ) {
            wp_enqueue_style( 'simple-main', $dir_uri . '/assets/css/main.css', array( 'simple-fontawesome' ), filemtime( $dir_path . '/assets/css/main.css' ) );
        } elseif ( file_exists( $dir_path . '/assets/sass/main.css' ) ) {
            wp_enqueue_style( 'simple-main', $dir_uri . '/assets/sass/main.css', array( 'simple-fontawesome' ), filemtime( $dir_path . '/assets/sass/main.css' ) );
        } else {
            wp_enqueue_style( 'simple-style', get_stylesheet_uri(), array( 'simple-fontawesome' ), wp_get_theme()->get( 'Version' ) );
        }

        /* JavaScript-bestanden om te enqueuen (worden alleen geladen als ze bestaan)
         * Uitleg:
         *  - We maken een veilige handle van de bestandsnaam (geen rare tekens).
         *  - Als het bestand 'jquery' in de naam heeft, voeg dan geen dependency toe.
         *  - wp_enqueue_script(..., true) laadt het script in de footer (aanbevolen).
         */
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

/* Maak demo-berichten bij theme-activatie (alleen als er nog geen berichten zijn)
 * Uitleg:
 *  - Aangeroepen via 'after_switch_theme' hook (onderaan dit bestand).
 *  - Checkt eerst of er al gepubliceerde berichten zijn; zo voorkomen we duplicates.
 *  - wp_is_json_request() voorkomt dat deze functie wordt uitgevoerd bij REST-requests.
 */
if ( ! function_exists( 'simple_theme_create_demo_posts' ) ) {
    function simple_theme_create_demo_posts() {
        if ( wp_is_json_request() ) {
            return;
        }

        $counts = wp_count_posts( 'post' );
        if ( ! empty( $counts ) && intval( $counts->publish ) > 0 ) {
            /* Er bestaan al posts */
            return;
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

/* Voeg standaard-widgets toe aan 'Primary Sidebar' als deze leeg is (eenmalig, admin)
 * Uitleg en notities:
 *  - WordPress bewaart widgets in opties zoals 'widget_text' en 'widget_recent-posts'.
 *  - 'sidebars_widgets' is een array die per sidebar de lijst met widget-id's bewaart.
 *  - Deze functie maakt twee widget-instanties aan en voegt ze toe aan 'sidebar-1'.
 *  - We zetten een optie 'simple_theme_default_widgets_added' zodat dit maar één keer gebeurt.
 */
if ( ! function_exists( 'simple_theme_add_default_widgets' ) ) {
    function simple_theme_add_default_widgets() {
        /* Alleen uitvoeren in het beheerdersgedeelte en door gebruikers met rechten om widgets te beheren */
        if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        /* Voorkom dat dit meerdere keren wordt uitgevoerd */
        if ( get_option( 'simple_theme_default_widgets_added' ) ) {
            return;
        }

        $sidebars = get_option( 'sidebars_widgets', array() );
        $sidebar_widgets = isset( $sidebars['sidebar-1'] ) ? $sidebars['sidebar-1'] : array();

        if ( empty( $sidebar_widgets ) || ! is_array( $sidebar_widgets ) ) {
            /* Voeg een tekst-widget toe met voorbeeldtekst */
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

            /* Voeg een Recent Posts-widget toe */
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

            /* Wijs de aangemaakte widgets toe aan sidebar-1 */
            $sidebars['sidebar-1'] = array();
            $sidebars['sidebar-1'][] = 'text-' . $text_id;
            $sidebars['sidebar-1'][] = 'recent-posts-' . $recent_id;
            update_option( 'sidebars_widgets', $sidebars );
        }

        update_option( 'simple_theme_default_widgets_added', 1 );
    }
}
add_action( 'admin_init', 'simple_theme_add_default_widgets' );
/* Registreer widgetgebieden (Primary Sidebar) voor het thema
 * Uitleg:
 *  - 'id' is de unieke identifier die we gebruiken in templates (hier: 'sidebar-1').
 *  - 'before_widget' / 'after_widget' en 'before_title' / 'after_title' bepalen de HTML rond widgets.
 *  - Pas deze waarden aan als je andere markup wilt gebruiken of meer CSS-classes wilt toevoegen.
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