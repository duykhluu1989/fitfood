@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.home_menu')

    <?php
    $homeSliders = array();

    if(isset($widgets[App\Libraries\Util::WIDGET_NAME_HOME_SLIDER]))
    {
        if(!empty($widgets[App\Libraries\Util::WIDGET_NAME_HOME_SLIDER]->detail))
        {
            $widgetDetails = json_decode($widgets[App\Libraries\Util::WIDGET_NAME_HOME_SLIDER]->detail, true);
            foreach($widgetDetails as $widgetDetail)
                $homeSliders[$widgetDetail['position'] - 1] = $widgetDetail;
            ksort($homeSliders);
        }
    }

    $countHomeSliders = count($homeSliders);

    if($countHomeSliders == 0)
    {
        $homeSliders[0] = [
            'image_src' => asset('assets/images/slider/slider.jpg'),
            'caption' => 'Weekly meals for a healthy lifestyle',
        ];

        $countHomeSliders = 1;
    }
    ?>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        @if($countHomeSliders > 1)
            <ol class="carousel-indicators">
                @foreach($homeSliders as $keySlider => $homeSlider)
                    <li data-target="#myCarousel" data-slide-to="{{ $keySlider }}"{{ $keySlider == 0 ? ' class="active"' : '' }}></li>
                @endforeach
            </ol>
        @endif
        <div class="carousel-inner" role="listbox">
            @foreach($homeSliders as $keySlider => $homeSlider)
                <div class="item{{ $keySlider == 0 ? ' active' : '' }}">
                    @if(!empty($homeSlider['url']))
                        <a href="{{ $homeSlider['url'] }}">
                    @endif
                    <div class="img" style="background-image:url('{{ $homeSlider['image_src'] }}')"></div>
                    @if(!empty($homeSlider['caption']))
                        <div class="carousel-caption">
                            <h3>{{ $homeSlider['caption'] }}</h3>
                        </div>
                    @endif
                    @if(!empty($homeSlider['url']))
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        @if($countHomeSliders > 1)
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        @endif
    </div>

    <div class="container">
        <div class="row">
            <div class="home-about box-shadow">

                @include('beta.layouts.partials.language')

                <div class="left">
                    <h4>About us</h4>
                    @lang('home_page.aboutUsText')
                    <a href="https://www.facebook.com/fitfoodvietnam" class="link">@lang('home_page.checkFaqs')</a>
                </div>
                <div class="right">
                    <img src="{{ asset('assets/images/about_us.jpg') }}" alt="Fitfood" border="0" />
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="home-offer">
        <div class="info">
            <h3>What we offer</h3>
            <p>@lang('home_page.offerText')</p>
        </div>
        <div class="container">
            <div class="row">
                <div class="block-3 text-center">
                    <img src="{{ asset('assets/images/icon-breakfast.png') }}" alt="Fitfood" border="0" />
                    <p>Breakfast</p>
                </div>
                <div class="block-3 text-center">
                    <img src="{{ asset('assets/images/icon-lunch.png') }}" alt="Fitfood" border="0" />
                    <p>Lunch</p>
                </div>
                <div class="block-3 text-center">
                    <img src="{{ asset('assets/images/icon-dinner.png') }}" alt="Fitfood" border="0" />
                    <p>Dinner</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="home-menu">
        <div class="container">
            <div class="row">
                <div id="menuCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="item active">
                            <!--
                            <div class="carousel-caption">monday menu</div>
                            -->
                            <div class="item-menu">
                                <img class="img-responsive" src="{{ asset('assets/images/menu_breakfast.png') }}" alt="Fitfood" border="0" />
                                <div class="overlay">
                                    <h2>Breakfast</h2>
                                </div>
                            </div>
                            <div class="item-menu">
                                <img class="img-responsive" src="{{ asset('assets/images/menu_lunch.png') }}" alt="Fitfood" border="0" />
                                <div class="overlay">
                                    <h2>Lunch</h2>
                                </div>
                            </div>
                            <div class="item-menu">
                                <img class="img-responsive" src="{{ asset('assets/images/menu_dinner.png') }}" alt="Fitfood" border="0" />
                                <div class="overlay">
                                    <h2>Dinner</h2>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!--
                        <a class="left carousel-control" href="#menuCarousel" data-slide="prev">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </a>
                        <a class="right carousel-control" href="#menuCarousel" data-slide="next">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                        -->
                    </div>
                </div>
                <a href="{{ url('menu') }}" class="view-more">@lang('home_page.menu')</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="home-order box-shadow">
                <div class="box-title">
                    <a href="{{ url('order') }}">
                        <h4><span>ORDER NOW</span></h4>
                    </a>
                </div>

                @include('beta.pages.partials.signature_dish', ['title' => false])

            </div>
        </div>
    </div>

    <div class="home-blog" style="background-image:url('{{ asset('assets/images/bg-blog.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="lasted-new">
                    <h4>Latest news</h4>
                    <h1>Fitfood blog</h1>
                    <p>@lang('home_page.blogDescription')</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="list-new box-shadow">
                <?php
                $i = 0;
                ?>
                @foreach($articles as $article)
                    <?php
                    if(App::getLocale() == 'en' && !empty($article['category']->slug_en))
                        $categorySlug = $article['category']->slug_en;
                    else
                        $categorySlug = $article['category']->slug;
                    if(App::getLocale() == 'en' && !empty($article['article']->slug_en))
                        $articleSlug = $article['article']->slug_en;
                    else
                        $articleSlug = $article['article']->slug;
                    ?>
                    @if($i % 2 == 0)
                        <article class="post">
                            <div class="post-thumbnail">
                                <a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">
                                    @if(!empty($article['article']->image_src))
                                        <img src="{{ $article['article']->image_src }}" alt="Fitfood" border="0" />
                                    @endif
                                </a>
                            </div>
                            <div class="post-content">
                                <div class="header-entry">
                                    <a href="{{ url('blog', ['categorySlug' => $categorySlug]) }}" class="cat-name">
                                        <?php
                                        if(App::getLocale() == 'en' && !empty($article['category']->name_en))
                                            echo $article['category']->name_en;
                                        else
                                            echo $article['category']->name;
                                        ?>
                                    </a>
                                    <h1 class="title"><a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">
                                            <?php
                                            if(App::getLocale() == 'en' && !empty($article['article']->name_en))
                                                echo $article['article']->name_en;
                                            else
                                                echo $article['article']->name;
                                            ?>
                                        </a></h1>
                                    <p class="post-date">{{ date('F d, Y', strtotime($article['article']->published_at)) }}{{ !empty($article['article']->author) ? (' By ' . $article['article']->author) : '' }}</p>
                                </div>
                                <div class="entry-content">
                                    <p>
                                        <?php
                                        if(App::getLocale() == 'en' && !empty($article['article']->description_en))
                                            echo $article['article']->description_en;
                                        else
                                            echo $article['article']->description;
                                        ?>
                                    </p>
                                    <!--<a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">@lang('home_page.viewBlog')</a>-->
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </article>
                    @else
                        <article class="post">
                            <div class="post-content">
                                <div class="header-entry">
                                    <a href="{{ url('blog', ['categorySlug' => $categorySlug]) }}" class="cat-name">
                                        <?php
                                        if(App::getLocale() == 'en' && !empty($article['category']->name_en))
                                            echo $article['category']->name_en;
                                        else
                                            echo $article['category']->name;
                                        ?>
                                    </a>
                                    <h1 class="title"><a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">
                                            <?php
                                            if(App::getLocale() == 'en' && !empty($article['article']->name_en))
                                                echo $article['article']->name_en;
                                            else
                                                echo $article['article']->name;
                                            ?>
                                        </a></h1>
                                    <p class="post-date">{{ date('F d, Y', strtotime($article['article']->published_at)) }}{{ !empty($article['article']->author) ? (' By ' . $article['article']->author) : '' }}</p>
                                </div>
                                <div class="entry-content">
                                    <p>
                                        <?php
                                        if(App::getLocale() == 'en' && !empty($article['article']->description_en))
                                            echo $article['article']->description_en;
                                        else
                                            echo $article['article']->description;
                                        ?>
                                    </p>
                                    <!--<a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">@lang('home_page.viewBlog')</a>-->
                                </div>
                            </div>
                            <div class="post-thumbnail">
                                <?php
                                if(App::getLocale() == 'en' && !empty($article['category']->slug_en))
                                    $categorySlug = $article['category']->slug_en;
                                else
                                    $categorySlug = $article['category']->slug;
                                if(App::getLocale() == 'en' && !empty($article['article']->slug_en))
                                    $articleSlug = $article['article']->slug_en;
                                else
                                    $articleSlug = $article['article']->slug;
                                ?>
                                <a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">
                                    @if(!empty($article['article']->image_src))
                                        <img src="{{ $article['article']->image_src }}" alt="Fitfood" border="0" />
                                    @endif
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </article>
                    @endif
                    <?php
                    $i ++;
                    ?>
                @endforeach
            </div>
            <a href="{{ url('blog') }}" class="view-more">@lang('home_page.blog')</a>
        </div>
    </div>

    <div class="home-talk">
        <div class="info">
            <h3>@lang('home_page.people')</h3>
            <p>@lang('home_page.peopleText')</p>
        </div>
        <div class="container">
            <div class="row">
                <div class="list-thinking">
                    <div class="block-3">
                        <div class="think">
                            <p>Cảm ơn Fitfood luôn là người đồng hành và chăm lo cho khách hàng khó tính như chế mấy tháng qua. Có Fitfood Tú khỏi phải lo nghĩ hôm nay ăn gì...Cứ tập thôi, còn ăn cứ để Fitfood lo hề!</p>
                        </div>
                        <img src="{{ asset('assets/images/avatar/avatar1.jpg') }}" alt="Fitfood" border="0" class="avatar FitfoodPopupImage" data-mfp-src="{{ asset('assets/images/minhtu.png') }}" />
                        <div class="name">
                            <h5><a class="FitfoodPopupImage" href="{{ asset('assets/images/minhtu.png') }}">Nguyễn Minh Tú</a></h5>
                            <span class="post-meta">@lang('home_page.model')</span>
                        </div>
                    </div>
                    <div class="block-3">
                        <div class="think">
                            <p>Để có một thân hình đẹp thì mọi thứ đều phải cố gắng.</p>
                        </div>
                        <img src="{{ asset('assets/images/avatar/avatar2.jpg') }}" alt="Fitfood" border="0" class="avatar FitfoodPopupImage" data-mfp-src="{{ asset('assets/images/iriscao.png') }}" />
                        <div class="name">
                            <h5><a class="FitfoodPopupImage" href="{{ asset('assets/images/iriscao.png') }}">Iris Cao</a></h5>
                            <span class="post-meta">@lang('home_page.writer')</span>
                        </div>
                    </div>
                    <div class="block-3">
                        <div class="think">
                            <p>Bắt đầu với Fitfood.vn, thực đơn giảm cân giao tận nơi hằng ngày với đồ ăn ngon xuất thần mà vẫn tốt cho dáng gầy xương mai.</p>
                        </div>
                        <img src="{{ asset('assets/images/avatar/avatar3.jpg') }}" alt="Fitfood" border="0" class="avatar FitfoodPopupImage" data-mfp-src="{{ asset('assets/images/hamlettruong.png') }}" />
                        <div class="name">
                            <h5><a class="FitfoodPopupImage" href="{{ asset('assets/images/hamlettruong.png') }}">Hamlet Trương</a></h5>
                            <span class="post-meta">@lang('home_page.writer')</span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="list-thinking">
                    <div class="block-3">
                        <div class="think">
                            <p>Sau mấy ngày chiến đấu có Fitfood bên cạnh, mình đã giảm được 2kg.</p>
                        </div>
                        <img src="{{ asset('assets/images/story/sonngocminh.png') }}" alt="Fitfood" border="0" class="avatar FitfoodPopupImage" data-mfp-src="{{ asset('assets/images/story/sonngocminh-story.png') }}" />
                        <div class="name">
                            <h5><a class="FitfoodPopupImage" href="{{ asset('assets/images/story/sonngocminh-story.png') }}">Sơn Ngọc Minh</a></h5>
                            <span class="post-meta">@lang('home_page.singer_actor')</span>
                        </div>
                    </div>
                    <div class="block-3">
                        <div class="think">
                            <p>Simply thank you Fitfood VN for bringing on my doorstep every morning this amazing and delicious food!</p>
                        </div>
                        <img src="{{ asset('assets/images/story/paulorothhaar.png') }}" alt="Fitfood" border="0" class="avatar FitfoodPopupImage" data-mfp-src="{{ asset('assets/images/story/paulorothhaar-story.png') }}" />
                        <div class="name">
                            <h5><a class="FitfoodPopupImage" href="{{ asset('assets/images/story/paulorothhaar-story.png') }}">Paulo Rothhaar</a></h5>
                            <span class="post-meta">@lang('home_page.model')</span>
                        </div>
                    </div>
                    <div class="block-3">
                        <div class="think">
                            <p>Bạn chỉ cần ăn mọi chuyện còn lại để Fitfood lo, rau củ thịt đầy ắp, đủ no vị cũng tuyệt nữa.</p>
                        </div>
                        <img src="{{ asset('assets/images/story/levantien.png') }}" alt="Fitfood" border="0" class="avatar FitfoodPopupImage" data-mfp-src="{{ asset('assets/images/story/levantien-story.png') }}" />
                        <div class="name">
                            <h5><a class="FitfoodPopupImage" href="{{ asset('assets/images/story/levantien-story.png') }}">Lê Văn Tiến</a></h5>
                            <span class="post-meta">@lang('home_page.model')</span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="home-talk">
        <div class="info">
            <h3>@lang('home_page.partner')</h3>
            <p>@lang('home_page.partnerDescription')</p>
        </div>
        <div class="container">
            <div class="row">
                <div class="list-thinking">
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/curves.jpg') }}" alt="Fitfood" border="0" width="120px" style="opacity: 0.8;margin-top: 35px" />
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/jus.png') }}" alt="Fitfood" border="0" width="80px" style="opacity: 0.8;margin-top: 35px" />
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/megamarket.png') }}" alt="Fitfood" border="0" width="100px" style="opacity: 0.8;margin-top: 30px" />
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/nakayama.png') }}" alt="Fitfood" border="0" width="70px" style="opacity: 0.8;margin-top: 25px" />
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/vineco.png') }}" alt="Fitfood" border="0" width="140px" style="opacity: 0.8;margin-top: 20px" />
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/payoo.png') }}" alt="Fitfood" border="0" width="120px" style="opacity: 0.8;margin-top: 30px" />
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="list-thinking">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/chephouse.png') }}" alt="Fitfood" border="0" width="140px" style="opacity: 0.8;margin-top: 30px" />
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/wefit.png') }}" alt="Fitfood" border="0" width="100px" style="opacity: 0.8;margin-top: 20px;background: black;padding: 10px" />
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/vshape.png') }}" alt="Fitfood" border="0" width="140px" style="opacity: 0.8;margin-top: 40px;background: black;padding: 10px" />
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="{{ asset('assets/images/partner/vivayoga.png') }}" alt="Fitfood" border="0" width="120px" style="opacity: 0.8;margin-top: 30px" />
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="home-talk">
        <div class="info">
            <h3>@lang('home_page.client')</h3>
            <p>@lang('home_page.partnerDescription')</p>
        </div>
        <div class="container">
            <div class="row">
                <div class="list-thinking">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-2 text-center">
                        <a href="https://www.facebook.com/fitfoodvietnam/posts/1615840338484167" target="_blank">
                            <img src="{{ asset('assets/images/client/aia.gif') }}" alt="Fitfood" border="0" width="80px" style="opacity: 0.8;margin-top: 25px" />
                        </a>
                    </div>
                    <div class="col-sm-2 text-center">
                        <a href="https://www.facebook.com/fitfoodvietnam/posts/1089813967753476" target="_blank">
                            <img src="{{ asset('assets/images/client/mega.jpg') }}" alt="Fitfood" border="0" width="90px" style="opacity: 0.8;margin-top: 25px" />
                        </a>
                    </div>
                    <div class="col-sm-2 text-center">
                        <a href="https://www.facebook.com/fitfoodvietnam/posts/1497494200318782" target="_blank">
                            <img src="{{ asset('assets/images/client/capitaland.png') }}" alt="Fitfood" border="0" width="120px" style="opacity: 0.8;margin-top: 35px" />
                        </a>
                    </div>
                    <div class="col-sm-2 text-center">
                        <a href="https://www.facebook.com/fitfoodvietnam/posts/1554723061262562" target="_blank">
                            <img src="{{ asset('assets/images/client/calikids.png') }}" alt="Fitfood" border="0" width="80px" style="opacity: 0.8;margin-top: 25px" />
                        </a>
                    </div>
                    <div class="col-sm-2 text-center">
                        <a href="https://www.facebook.com/fitfoodvietnam/posts/1563990160335852" target="_blank">
                            <img src="{{ asset('assets/images/client/yogaplus.png') }}" alt="Fitfood" border="0" width="100px" style="opacity: 0.8;margin-top: 35px" />
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
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

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.FitfoodPopupImage').magnificPopup({

                type: 'image'

            });

        });

    </script>

@stop