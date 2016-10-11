@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    @if(isset($currentCategory))
        <?php
        if(!empty($currentCategory->image_src))
            $blogBanner = $currentCategory->image_src;
        else
            $blogBanner = asset('/../assets/images/page-header/blog.jpg');
        if(App::getLocale() == 'en' && !empty($currentCategory->name_en))
            $blogTitle = $currentCategory->name_en;
        else
            $blogTitle = $currentCategory->name;
        ?>
        @include('beta.layouts.partials.header', ['banner' => $blogBanner, 'title' => $blogTitle])
    @else
        @include('beta.layouts.partials.header', ['banner' => asset('/../assets/images/page-header/blog.jpg'), 'title' => 'Blog'])
    @endif

    <div class="container">
        <div class="row">
            <div class="box-language">

                @include('beta.layouts.partials.language')

            </div>
            <div id="primary">
                <div class="blog-posts-list">
                    @foreach($articles as $article)
                        <?php
                        if(App::getLocale() == 'en' && !empty($article->category->slug_en))
                            $categorySlug = $article->category->slug_en;
                        else
                            $categorySlug = $article->category->slug;
                        if(App::getLocale() == 'en' && !empty($article->slug_en))
                            $articleSlug = $article->slug_en;
                        else
                            $articleSlug = $article->slug;
                        ?>
                        <article class="post box-shadow">
                            <div class="post-thumbnail">
                                <a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">
                                    @if(!empty($article->image_src))
                                        <img src="{{ $article->image_src }}" alt="Fitfood" border="0" width="770" height="450" />
                                    @endif
                                </a>
                            </div>
                            <div class="post-content">
                                <div class="header-entry">
                                    <a href="{{ url('blog', ['categorySlug' => $categorySlug]) }}" class="cat-name">
                                        <?php
                                        if(App::getLocale() == 'en' && !empty($article->category->name_en))
                                            echo $article->category->name_en;
                                        else
                                            echo $article->category->name;
                                        ?>
                                    </a>
                                    <h1 class="title"><a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">
                                            <?php
                                            if(App::getLocale() == 'en' && !empty($article->name_en))
                                                echo $article->name_en;
                                            else
                                                echo $article->name;
                                            ?>
                                        </a></h1>
                                    <p class="post-date">{{ date('F d, Y', strtotime($article->published_at)) }}{{ !empty($article->author) ? (' By ' . $article->author) : '' }}</p>
                                </div>
                                <div class="entry-content">
                                    <p>
                                        <?php
                                        if(App::getLocale() == 'en' && !empty($article->description_en))
                                            echo $article->description_en;
                                        else
                                            echo $article->description;
                                        ?>
                                    </p>
                                    <a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">@lang('home_page.viewBlog')</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div id="pagination">
                    <ul class="page-numbers">
                        @if($articles->lastPage() > 1)
                            @if($articles->currentPage() > 1)
                                <li><a class="last page-numbers" href="{{ $articles->previousPageUrl() }}"><span class="fa fa-angle-left"></span></a></li>
                                <li><a class="page-numbers" href="{{ $articles->url(1) }}">1</a></li>
                            @endif

                            @for($i = 2;$i >= 1;$i --)
                                @if($articles->currentPage() - $i > 1)
                                    @if($articles->currentPage() - $i > 2 && $i == 2)
                                        <li>...</li>
                                        <li><a class="page-numbers" href="{{ $articles->url($articles->currentPage() - $i) }}">{{ $articles->currentPage() - $i }}</a></li>
                                    @else
                                        <li><a class="page-numbers" href="{{ $articles->url($articles->currentPage() - $i) }}">{{ $articles->currentPage() - $i }}</a></li>
                                    @endif
                                @endif
                            @endfor

                            <li><span class="page-numbers current">{{ $articles->currentPage() }}</span></li>

                            @for($i = 1;$i <= 2;$i ++)
                                @if($articles->currentPage() + $i < $articles->lastPage())
                                    @if($articles->currentPage() + $i < $articles->lastPage() - 1 && $i == 2)
                                        <li><a class="page-numbers" href="{{ $articles->url($articles->currentPage() + $i) }}">{{ $articles->currentPage() + $i }}</a></li>
                                        <li>...</li>
                                    @else
                                        <li><a class="page-numbers" href="{{ $articles->url($articles->currentPage() + $i) }}">{{ $articles->currentPage() + $i }}</a></li>
                                    @endif
                                @endif
                            @endfor

                            @if($articles->currentPage() < $articles->lastPage())
                                <li><a class="page-numbers" href="{{ $articles->url($articles->lastPage()) }}">{{ $articles->lastPage() }}</a></li>
                                <li><a class="next page-numbers" href="{{ $articles->nextPageUrl() }}"><span class="fa fa-angle-right"></span></a></li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>

            @include('beta.pages.partials.blog_sidebar', [
                'categories' => $categories,
                 'popularArticles' => $popularArticles,
                'tags' => $tags,
                'instagramPhotos' => $instagramPhotos,
            ])

            <div class="clearfix"></div>
        </div>
    </div>

@stop