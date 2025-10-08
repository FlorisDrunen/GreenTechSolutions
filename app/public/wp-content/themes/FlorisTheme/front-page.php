<?php get_header(); ?>
<div class="hero">
    <h1><?php bloginfo('name'); ?></h1>
    <p><?php bloginfo('description'); ?></p>
    <a href="<?php echo esc_url( get_permalink( get_option('page_for_posts') ) ); ?>" class="btn">Bekijk ons Blog</a>
</div>
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
