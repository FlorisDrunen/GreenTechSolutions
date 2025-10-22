<?php
?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title><?php bloginfo( 'name' ); ?><?php wp_title( ' - ', true, 'left' ); ?></title>
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
                    echo '<ul>
                        <li><a href="#">Lorem</a></li>
                        <li><a href="#">Ipsum</a></li>
                        <li><a href="#">Feugiat</a></li>
                        <li><a href="#">Tempus</a></li>
                        <li><a href="#">Adipiscing</a></li>
                    </ul>';
                }
                ?>
            </nav>

            <nav class="main">
                <ul></ul>
            </nav>
        </header>

        <!-- Menu (leeg – behoud structuur van HTML) -->
        <section id="menu">
            <section></section>
            <section></section>
            <section></section>
        </section>

        <!-- Main -->
        <div id="main">

            <!-- Hero / Intro (neemt site title & tagline) -->
            <section class="intro">
                <div class="inner">
                    <h2><?php bloginfo( 'name' ); ?></h2>
                    <p><?php bloginfo( 'description' ); ?></p>
                </div>
            </section>

            <!-- Posts list -->
            <section class="posts">
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
                            <a class="image featured" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
                        <?php else : ?>
                            <a class="image featured" href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pic01.jpg' ); ?>" alt="" />
                            </a>
                        <?php endif; ?>

                        <div class="excerpt">
                            <?php the_excerpt(); ?>
                        </div>

                        <footer>
                            <ul class="actions">
                                <li><a href="<?php the_permalink(); ?>" class="button">Read more</a></li>
                            </ul>
                        </footer>
                    </article>
                <?php endwhile; else : ?>

                    <!-- Fallback / voorbeeldblokken -->
                    <div class="no-posts">
                        <article class="post">
                            <header>
                                <div class="title">
                                    <h2>Voorbeeldpost: Welkom</h2>
                                </div>
                                <div class="meta">
                                    <time class="published" datetime="<?php echo date( 'c' ); ?>"><?php echo date_i18n( get_option( 'date_format' ) ); ?></time>
                                    <span class="author"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
                                </div>
                            </header>

                            <a class="image featured" href="#"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pic02.jpg' ); ?>" alt="" /></a>

                            <div class="excerpt">
                                <p>Er zijn nog geen berichten. Dit is voorbeeldcontent om je thema te laten lijken op de originele HTML-website.</p>
                            </div>

                            <footer>
                                <ul class="actions">
                                    <li><a href="#" class="button">Lees meer</a></li>
                                </ul>
                            </footer>
                        </article>
                    </div>

                <?php endif; ?>

                <!-- Pagination -->
                <nav class="pagination"><?php the_posts_pagination(); ?></nav>
            </section>

            <!-- Demo widgets (zoals in originele HTML) -->
            <section class="demo-widgets">
                <div class="inner">
                    <h3>Voorbeeld lijst</h3>
                    <ul class="icons">
                        <li><span class="icon fa-check"> Feature één</span></li>
                        <li><span class="icon fa-check"> Feature twee</span></li>
                        <li><span class="icon fa-check"> Feature drie</span></li>
                    </ul>
                </div>
            </section>

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