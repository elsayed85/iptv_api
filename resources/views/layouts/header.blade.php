<header id="masthead" class="site-header">
    <div class="king-header header-02 lr-padding">
        <span class="king-head-toggle" data-toggle="dropdown" data-target=".king-leftmenu" aria-expanded="false"
            role="button">
            <i class="fa-solid fa-bars"></i>
        </span>
        <div class="site-branding">
            <a href="/" class="king-logo">
                <img src="https://wordpress.kingthemes.net/designking/wp-content/uploads/2020/05/asdsad.png"
                    alt="" />
            </a>

        </div><!-- .site-branding -->
        <div class="king-head-nav">
            <ul>
                <li>
                    <a class="king-head-nav-a" href="{{ route('live.index') }}"><span style="color:"><i
                                class="fa-solid fa-star-of-life"></i> </span>
                        Live
                    </a>
                </li>
                <li>
                    <a class="king-head-nav-a" href="{{ route('movies.index') }}"><span style="color:"><i
                                class="fa-solid fa-fire-flame-simple"></i> </span>
                        Movies
                    </a>
                </li>
                <li>
                    <a class="king-head-nav-a" href="{{ route('series.index') }}"><span style="color:"><i
                                class="fa-solid fa-child-dress"></i> </span>
                        Series
                    </a>
                </li>
        </div>

        <div class="king-header-right">
            <div id="searchv2-button"><i class="fa fa-search fa-lg" aria-hidden="true"></i></div>
            <div class="king-logged-user">
                <div class="king-username">
                    <div class="header-login" data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-user-circle"></i>
                    </div>
                </div>
            </div><!-- .king-logged-user -->
        </div>
    </div><!-- .king-header -->
    <div class="live-king-search-top" id="live-search">
        <span class="king-close" aria-hidden="true"></span>
        <div class="live-king-search">
            <form role="search" method="get" class="live-header-search-form"
                action="{{ request()->url() }}">
                <input type="search" class="live-header-search-field" placeholder="Search …" value=""
                    name="q" autocomplete="off" title="Search for:" />
                <button type="submit" class="live-header-search-submit" value=""><i class="fa fa-search fa-2x"
                        aria-hidden="true"></i> </button>
            </form>

        </div>
    </div><!-- .king-search-top -->
</header><!-- #masthead -->
<div class="king-leftmenu king-scroll">
    <button class="king-leftmenu-close" type="button" data-toggle="dropdown" data-target=".king-leftmenu"
        aria-expanded="false"><i class="fa-solid fa-angle-left"></i></button>
    <form role="search" method="get" class="king-mobile-search"
        action="https://wordpress.kingthemes.net/designking/">
        <input type="search" class="king-mobile-search-field" placeholder="Search …" value="" name="s"
            autocomplete="off" title="Search" />
    </form>
    <div class="king-leftmenu-nav">

        <li>
            <a class="king-head-nav-a" href="https://wordpress.kingthemes.net/designking/reactions/"><span
                    style="color:"><i class="fa-solid fa-star-of-life"></i> </span>Explore</a>
        </li>
        <li>
            <a class="king-head-nav-a" href="https://wordpress.kingthemes.net/designking/hot/"><span style="color:"><i
                        class="fa-solid fa-fire-flame-simple"></i> </span>Hot</a>
        </li>
        <li>
            <a class="king-head-nav-a" href="https://wordpress.kingthemes.net/designking/users/"><span style="color:"><i
                        class="fa-solid fa-child-dress"></i> </span>Users</a>
        </li>
        <li>
            <a class="king-head-nav-a" href="https://wordpress.kingthemes.net/designking/categories/"><span
                    style="color:"><i class="fa-solid fa-chart-simple"></i> </span>Categories</a>
        </li>
        <div class="king-cat-list-mobile">
            <div class="menu">
                <ul>
                    <li class="page_item page-item-91"><a
                            href="https://wordpress.kingthemes.net/designking/categories/">Categories</a></li>
                    <li class="page_item page-item-89"><a
                            href="https://wordpress.kingthemes.net/designking/hot/">Hot</a></li>
                    <li class="page_item page-item-100"><a
                            href="https://wordpress.kingthemes.net/designking/reactions/">Reactions</a></li>
                    <li class="page_item page-item-95"><a
                            href="https://wordpress.kingthemes.net/designking/users/">Users</a></li>
                </ul>
            </div>
        </div>

    </div>
</div><!-- .king-head-mobile -->
