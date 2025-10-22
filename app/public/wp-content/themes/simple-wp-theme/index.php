<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title><?php bloginfo( 'name' ); ?><?php wp_title( ' - ', true, 'left' ); ?></title>
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/main.css' ); ?>" />
    <?php wp_head(); ?>
</head>
<body class="is-preload">

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
                } else {
                    echo '<ul><li><a href="#">Lorem</a></li><li><a href="#">Ipsum</a></li><li><a href="#">Feugiat</a></li></ul>';
                }
                ?>
            </nav>
        </header>

        <!-- Main -->
        <div id="main">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="post">
                    <header>
                        <div class="title">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </div>
                        <div class="meta">
                            <time class="published" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
                            <span class="author"><?php the_author(); ?></span>
                        </div>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <span class="image featured"><?php the_post_thumbnail( 'large' ); ?></span>
                    <?php endif; ?>

                    <p><?php the_excerpt(); ?></p>

                    <footer>
                        <ul class="stats">
                            <li><a href="<?php the_permalink(); ?>">Read more</a></li>
                        </ul>
                    </footer>
                </article>
            <?php endwhile; else : ?>
                <p><?php esc_html_e( 'No posts found.', 'simple-wp-theme' ); ?></p>
            <?php endif; ?>

            <!-- Pagination -->
            <nav class="pagination"><?php the_posts_pagination(); ?></nav>
        </div>

        <!-- Footer -->
        <section id="footer">
            <ul class="icons">
                <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="icon solid fa-rss"><span class="label">RSS</span></a></li>
                <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
            </ul>
            <p class="copyright">&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>.</p>
        </section>

    </div>

    <?php wp_footer(); ?>
</body>
</html>