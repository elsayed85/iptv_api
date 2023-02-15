@extends('layouts.app')
@section('categories')
    <ul id="primary-menu" class="menu">
        @foreach ($categories as $category)
            <li id="menu-item-33" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-33"><a
                    href="{{ route('category.show', ['type' => 'series', 'category' => $category['category_id']]) }}">
                    {{ $category['category_name'] }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection
@section('main')
    <ul class="king-posts">
        <li class="grid-sizer"></li>
        @foreach ($series as $serie)
            <li class="king-post-item">
                <article id="post-75"
                    class="post-75 post type-post status-publish format-image has-post-thumbnail hentry category-web-design tag-design tag-template tag-theme tag-web post_format-post-format-image">

                    <a href="{{ route('serie.load', $serie['series_id']) }}" class="entry-image-link king-share-link">
                        <div class="entry-image" style="height:480px;">
                            <div class="king-box-bg" data-king-img-src="{{ $serie['cover'] }}">
                            </div>
                        </div>
                        @if ($category = $serie['category'])
                            <div class="editors-badge">{{ $category }}</div>
                        @endif
                    </a>
                    <div class="post-featured-trending">
                        <div class="king-postext king-ext-75">
                            <a href="{{ route('serie.load', $serie['series_id']) }}" class="king-share-link king-readlater"
                                data-toggle="tooltip" data-placement="bottom" title="Share"><i
                                    class="fa-solid fa-arrow-up-from-bracket"></i></a>
                        </div>
                    </div>

                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="{{ route('serie.show', $serie['series_id']) }}" rel="bookmark">
                                {{ $serie['name'] }}
                            </a>
                        </h2>
                    </header><!-- .entry-header -->
                    <div class="article-meta-04">
                        <div class="entry-meta-left">
                            <span class="content-04-avatar">
                                <a class="content-04-user" href="{{ route('serie.show', $serie['series_id']) }}">
                                    {{ $serie['name'] }}
                                </a>
                            </span>
                        </div>
                        <div class="entry-meta-right">
                            <div class="entry-meta">
                                <div class="king-pmeta">
                                    <span class="post-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        {{ $serie['genre'] }}
                                    </span>
                                </div>
                                <span class="post-views"><i class="fa fa-clock" aria-hidden="true"></i>
                                    {{ Carbon\Carbon::createFromTimestamp($serie['last_modified'])->diffForHumans() }}
                                </span>
                            </div><!-- .entry-meta -->

                        </div>
                    </div><!-- .article-meta -->
                </article>
                <!--#post-##-->
            </li>
        @endforeach


        <nav class="navigation posts-navigation" aria-label="Posts">
            <h2 class="screen-reader-text">Posts navigation</h2>
            <div class="nav-links">
                @if (request('page', 1) > 1)
                    <div class="nav-next">
                        <a href="{{ request()->url() }}?page={{ request('page', 2) + -1 }}">Previous</a>
                    </div>
                @endif
                <div class="nav-previous">
                    <a href="{{ request()->url() }}?page={{ request('page', 1) + 1 }}">Next</a>
                </div>
            </div>
        </nav>
    </ul>
@endsection

@section('script')
@endsection
