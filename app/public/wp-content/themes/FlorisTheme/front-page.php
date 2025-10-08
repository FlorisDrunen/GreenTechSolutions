<?php get_header(); ?>

<div class="container">
    <div class="content-area">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article>
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </article>
        <?php endwhile; endif; ?>
    </div>
    <aside class="sidebar-area">
        <?php get_sidebar(); ?>
    </aside>
</div>
<?php get_footer(); ?>
