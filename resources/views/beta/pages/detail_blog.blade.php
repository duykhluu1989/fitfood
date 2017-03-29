@extends('beta.layouts.main')

@section('content')

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    @include('beta.layouts.partials.menu')

    <?php
    if(!empty($article->image_src))
        $blogBanner = $article->image_src;
    else
        $blogBanner = asset('assets/images/page-header/blog.jpg');
    if(App::getLocale() == 'en' && !empty($currentCategory->name_en))
        $categoryTitle = $currentCategory->name_en;
    else
        $categoryTitle = $currentCategory->name;
    if(App::getLocale() == 'en' && !empty($article->name_en))
        $articleTitle = $article->name_en;
    else
        $articleTitle = $article->name;
    if(App::getLocale() == 'en' && !empty($currentCategory->slug_en))
        $categorySlug = $currentCategory->slug_en;
    else
        $categorySlug = $currentCategory->slug;
    if(App::getLocale() == 'en' && !empty($article->slug_en))
        $articleSlug = $article->slug_en;
    else
        $articleSlug = $article->slug;

    $fbCategorySlug = $currentCategory->slug;
    $fbArticleSlug = $article->slug;
    ?>
    @include('beta.layouts.partials.blog_header', ['banner' => $blogBanner, 'category' => $categoryTitle, 'title' => $articleTitle])

    <div class="container">
        <div class="row">
            <div class="box-language">

                @include('beta.layouts.partials.language')

            </div>
            <div id="primary">
                <article class="post single-post box-shadow">
                    <div class="post-content">
                        <div class="header-entry">
                            <a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}" class="cat-name">{{ $categoryTitle }}</a>
                            <h1 class="title">{{ $articleTitle }}</h1>
                            <p class="post-date">{{ date('F d, Y', strtotime($article->published_at)) }}{{ !empty($article->author) ? (' By ' . $article->author) : '' }}</p>
                        </div>
                        <div>
                            <?php
                            if(App::getLocale() == 'en' && !empty($article->body_html_en))
                                echo $article->body_html_en;
                            else
                                echo $article->body_html;
                            ?>
                        </div>
                        <div class="entry-footer">
                            <div class="entry-meta">
                                <span class="post-author"><?php echo (!empty($article->author) ? (' By <a href="javascript:void(0)">' . $article->author . '</a>') : ''); ?></span>
                                <span class="post-date">{{ date('F d, Y', strtotime($article->published_at)) }}</span>
                            </div>
                            <div class="social">
                                <div class="fb-like" data-href="{{ url('blog', ['categorySlug' => $fbCategorySlug, 'articleSlug' => $fbArticleSlug]) }}" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
                                <div class="fb-share-button" data-href="{{ url('blog', ['categorySlug' => $fbCategorySlug, 'articleSlug' => $fbArticleSlug]) }}" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="{{ url('blog', ['categorySlug' => $fbCategorySlug, 'articleSlug' => $fbArticleSlug]) }}"></a></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="fb-comments" data-href="{{ url('blog', ['categorySlug' => $fbCategorySlug, 'articleSlug' => $fbArticleSlug]) }}" data-width="100%" data-numposts="5"></div>
                </article>
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

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1665387320368867', {
            em: 'insert_email_variable,'
        });
        fbq('track', 'ViewContent');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1665387320368867&ev=ViewContent&noscript=1" />
    </noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->

@stop