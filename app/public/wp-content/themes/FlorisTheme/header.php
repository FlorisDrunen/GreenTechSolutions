<?php wp_head() ?>

<header id="header">
    <a href="index.html"><img src="<?php echo get_template_directory_uri() ?>/assets/images/logo.svg" alt="" class="logo" /></a>
    <nav class="links">
        <ul>
            <li><a href="#">Lorem</a></li>
            <li><a href="#">Ipsum</a></li>
            <li><a href="#">Feugiat</a></li>
            <li><a href="#">Tempus</a></li>
            <li><a href="#">Adipiscing</a></li>
        </ul>
    </nav>
    <nav class="main">
        <ul>
            <li class="search">
                <a class="fa-search" href="#search">Search</a>
                <form id="search" method="get" action="#">
                    <input type="text" name="query" placeholder="Search" />
                </form>
            </li>
            <li class="menu">
                <a class="fa-bars" href="#menu">Menu</a>
            </li>
        </ul>
    </nav>
</header>