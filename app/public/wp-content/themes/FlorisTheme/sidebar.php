<aside id="secondary" class="widget-area">
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    <?php else : ?>
        <section class="widget">
            <h2 class="widget-title">About</h2>
            <p>Add widgets in Appearance → Widgets.</p>
        </section>
    <?php endif; ?>
</aside>
