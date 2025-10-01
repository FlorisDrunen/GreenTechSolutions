<?php get_header() ?>

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'posts_per_page' => 3, // aantal posts per pagina
    'paged' => $paged,
);
$custom_query = new WP_Query($args);
?>


<?php wp_reset_postdata(); ?>

<div id="main">
    <?php if ($custom_query->have_posts()) : ?>
        <?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
            <article class="post">
                <header>
                    <div class="title">
                        <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                    <div class="meta">
                        <time class="published" datetime="<?php echo get_the_date('c'); ?>"><?php the_date(); ?></time>
                        <a href="#" class="author">
                            <span class="name"><?php the_author(); ?></span>
                            <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="" />
                        </a>
                    </div>
                </header>
                <div class="content">
                    <?php the_content(); ?>
                </div>
                <footer>
                    <ul class="actions">
                        <li><a href="<?php the_permalink() ?>" class="button large">Continue Reading</a></li>
                    </ul>
                    <ul class="stats">
                        <li><a href="#">General</a></li>
                        <li><a href="#" class="icon solid fa-heart">28</a></li>
                        <li><a href="#" class="icon solid fa-comment">128</a></li>
                    </ul>
                </footer>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
    <ul class="actions pagination">
        <li>
            <?php
            $prev_link = get_previous_posts_page_link();
            if ($prev_link) {
                echo '<a href="' . esc_url($prev_link) . '" class="button large previous">Previous Page</a>';
            } else {
                echo '<a class="disabled button large previous">Previous Page</a>';
            }
            ?>
        </li>
        <li>
            <?php
            $next_link = get_next_posts_page_link($custom_query->max_num_pages);
            if ($next_link) {
                echo '<a href="' . esc_url($next_link) . '" class="button large next">Next Page</a>';
            } else {
                echo '<a class="disabled button large next">Next Page</a>';
            }
            ?>
        </li>
    </ul>

</div>
<section id="sidebar">

    <section id="intro">
        <header>
            <h2><?php bloginfo('name'); ?></h2>
            <p><?php bloginfo('description'); ?></p>
        </header>
    </section>


    <section>
        <div class="mini-posts">
            <?php
            $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 4,
                'post_status' => 'publish'
            ));
            foreach ($recent_posts as $post) :
            ?>
                <article class="mini-post">
                    <header>
                        <h3><a href="<?php echo get_permalink($post['ID']); ?>"><?php echo $post['post_title']; ?></a></h3>
                        <time class="published" datetime="<?php echo get_the_date('c', $post['ID']); ?>"><?php echo get_the_date('', $post['ID']); ?></time>
                        <a href="#" class="author"><img src="<?php echo get_avatar_url(get_the_author_meta('ID', $post['ID'])); ?>" alt="" /></a>
                    </header>
                    <a href="<?php echo get_permalink($post['ID']); ?>" class="image"><?php echo get_the_post_thumbnail($post['ID'], 'thumbnail'); ?></a>
                </article>
            <?php endforeach;
            wp_reset_query(); ?>
        </div>
    </section>

    <?php get_footer(); ?>
</section>
</div>

</body>

</html>