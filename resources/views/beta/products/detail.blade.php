@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    <?php
    if(!empty($productPage->image_src))
        $blogBanner = $productPage->image_src;
    else
        $blogBanner = asset('assets/images/page-header/blog.jpg');

    if(App::getLocale() == 'en' && !empty($productPage->name_en))
        $articleTitle = $productPage->name_en;
    else
        $articleTitle = $productPage->name;

    if(App::getLocale() == 'en' && !empty($productPage->slug_en))
        $articleSlug = $productPage->slug_en;
    else
        $articleSlug = $productPage->slug;
    ?>

    @include('beta.layouts.partials.header', ['banner' => $blogBanner, 'title' => $articleTitle])

    <div class="container">
        <div class="row">
            <div id="primary" class="full-width row">
                <div id="content" class="box-shadow">
                    <div class="wrap-faq">

                        @include('beta.layouts.partials.language')

                        <div class="page-title">
                            <h2>{{ $articleTitle }}</h2>
                        </div>

                        <?php
                        if(App::getLocale() == 'en' && !empty($productPage->body_html_en))
                            $articleBody = $productPage->body_html_en;
                        else
                            $articleBody = $productPage->body_html;

                        echo $articleBody;
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop