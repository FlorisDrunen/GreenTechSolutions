<?php
get_header();
?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title><?php single_post_title(); ?> - <?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
</head>
<body class="single is-preload">

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Header -->
        <header id="header">
            <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            <nav class="links">
                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'items_wrap'     => '<ul>%3$s</ul>',
                    ) );
                }
                ?>
            </nav>
        </header>

        <!-- Menu (leeg) -->
        <section id="menu">
            <section></section>
            <section></section>
            <section></section>
        </section>

        <!-- Main -->
        <div id="main">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="post">
                    <header>
                        <div class="title">
                            <h2><?php the_title(); ?></h2>
                        </div>
                        <div class="meta">
                            <time class="published" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
                            <span class="author"><?php the_author(); ?></span>
                        </div>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <span class="image featured"><?php the_post_thumbnail( 'large' ); ?></span>
                    <?php else : ?>
                        <span class="image featured"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pic01.jpg' ); ?>" alt="" /></span>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <footer>
                        <ul class="actions">
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button">Terug naar home</a></li>
                            <li><?php previous_post_link( '%link', '&larr; Vorige' ); ?></li>
                            <li><?php next_post_link( '%link', 'Volgende &rarr;' ); ?></li>
                        </ul>

                        <?php
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                        ?>
                    </footer>
                </article>
            <?php endwhile; endif; ?>
        </div>

        <!-- Footer -->
        <section id="footer">
            <ul class="icons">
                <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
            </ul>
            <p class="copyright">&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>.</p>
        </section>

    </div>

    <?php wp_footer(); ?>
</body>
</html>