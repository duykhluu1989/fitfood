<div id="sidebar">
    <ul>
        <li class="widget widget_search">
            <h3 class="widget-title">@lang('blog_page.search')</h3>
            <form method="get" id="searchform" action="{{ url('blog') }}" onsubmit="if(document.getElementById('s').value.trim().length < 2){ alert('@lang('blog_page.searchHint')');return false; }">
                <input type="text" class="field" name="keyword" id="s" placeholder="@lang('blog_page.searchHint')" />
                <input type="submit" class="submit" id="searchsubmit" value="Search" />
            </form>
        </li>
        <li class="widget widget_categories">
            <h3 class="widget-title">@lang('blog_page.categories')</h3>
            @if(count($categories) > 0)
                <ul>
                    @foreach($categories as $category)
                        <?php
                        if(App::getLocale() == 'en' && !empty($category->slug_en))
                            $categorySlug = $category->slug_en;
                        else
                            $categorySlug = $category->slug;
                        ?>
                        <li>
                            <a href="{{ url('blog', ['categorySlug' => $categorySlug]) }}">
                                <?php
                                if(App::getLocale() == 'en' && !empty($category->name_en))
                                    echo $category->name_en;
                                else
                                    echo $category->name;
                                ?>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
        <li class="widget widget_recent_posts">
            <h3 class="widget-title">@lang('blog_page.popularPost')</h3>
            @if(count($popularArticles) > 0)
                <ul>
                    @foreach($popularArticles as $popularArticle)
                        <?php
                        if(App::getLocale() == 'en' && !empty($popularArticle->category->slug_en))
                            $categorySlug = $popularArticle->category->slug_en;
                        else
                            $categorySlug = $popularArticle->category->slug;
                        if(App::getLocale() == 'en' && !empty($popularArticle->slug_en))
                            $articleSlug = $popularArticle->slug_en;
                        else
                            $articleSlug = $popularArticle->slug;
                        ?>
                        <li>
                            <a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">
                                @if(!empty($popularArticle->thumbnail_src))
                                    <img width="90" height="90" src="{{ $popularArticle->thumbnail_src }}" alt="Fitfood" border="0" />
                                @endif
                            </a>
                            <div class="details">
                                <a href="{{ url('blog', ['categorySlug' => $categorySlug]) }}" class="cat-name">
                                    <?php
                                    if(App::getLocale() == 'en' && !empty($popularArticle->category->name_en))
                                        echo $popularArticle->category->name_en;
                                    else
                                        echo $popularArticle->category->name;
                                    ?>
                                </a>
                                <a href="{{ url('blog', ['categorySlug' => $categorySlug, 'articleSlug' => $articleSlug]) }}">
                                    <?php
                                    if(App::getLocale() == 'en' && !empty($popularArticle->name_en))
                                        echo $popularArticle->name_en;
                                    else
                                        echo $popularArticle->name;
                                    ?>
                                </a>
                                <span class="post-date">{{ date('F d, Y', strtotime($popularArticle->published_at)) }}{{ !empty($popularArticle->author) ? (' By ' . $popularArticle->author) : '' }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
        <li class="widget widget_tag_cloud">
            <h3 class="widget-title">@lang('blog_page.tags')</h3>
            <div class="tagcloud">
                @foreach($tags as $tag)
                    <a href="{{ url('blog?tag=' . $tag->name) }}">{{ $tag->name }}</a>
                @endforeach
            </div>
        </li>
        <li class="widget widget_text widget_instagram">
            <h3 class="widget-title">Instagram</h3>
            <div class="textwidget">
                @foreach($instagramPhotos as $instagramPhoto)
                    <a href="{{ $instagramPhoto['url'] }}">
                        <img src="{{ $instagramPhoto['image_src'] }}" alt="Fitfood" border="0" width="90" height="90" />
                    </a>
                @endforeach
            </div>
        </li>
    </ul>
</div>