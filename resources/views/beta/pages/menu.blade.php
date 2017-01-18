@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    @include('beta.layouts.partials.header', ['banner' => asset('assets/images/page-header/menu.jpg'), 'title' => 'Menu'])

    <div class="container">
        <div class="row">
            <div id="primary" class="full-width">
                <div id="content" class="box-shadow">
                    <div class="wrap-menu">

                        @include('beta.layouts.partials.language')

                        <div class="page-title">
                            <h2>@lang('menu_page.latestMenu')</h2>
                            <h5>@lang('menu_page.menuTitle')</h5>
                            <p>@lang('menu_page.menuDescription')</p>
                        </div>
                        <div class="page-title">
                            <h5>@lang('menu_page.week') {{ date('d/m', strtotime('+ ' . (8 - date('N') + ($offTimeWeeks * 7)) . ' days')) }} - {{ date('d/m', strtotime('+ ' . (12 - date('N') + ($offTimeWeeks * 7)) . ' days')) }}</h5>
                        </div>
                        <?php
                        $dayOfWeek = [
                            1 => trans('menu_page.monday'),
                            2 => trans('menu_page.tuesday'),
                            3 => trans('menu_page.wednesday'),
                            4 => trans('menu_page.thursday'),
                            5 => trans('menu_page.friday'),
                        ];
                        $menus = array();
                        foreach($currentLastWeekNextWeekMenus as $currentLastWeekNextWeekMenu)
                        {
                            if($currentLastWeekNextWeekMenu->type == App\Libraries\Util::TYPE_MENU_NORMAL_VALUE)
                            {
                                if($currentLastWeekNextWeekMenu->status == App\Libraries\Util::STATUS_MENU_CURRENT_VALUE)
                                    $menus['currentNormal'] = $currentLastWeekNextWeekMenu;
                                else if($currentLastWeekNextWeekMenu->status == App\Libraries\Util::STATUS_MENU_LAST_WEEK_VALUE)
                                    $menus['lastWeekNormal'] = $currentLastWeekNextWeekMenu;
                                else
                                    $menus['nextWeekNormal'] = $currentLastWeekNextWeekMenu;
                            }
                            else
                            {
                                if($currentLastWeekNextWeekMenu->status == App\Libraries\Util::STATUS_MENU_CURRENT_VALUE)
                                    $menus['currentVegetarian'] = $currentLastWeekNextWeekMenu;
                                else if($currentLastWeekNextWeekMenu->status == App\Libraries\Util::STATUS_MENU_LAST_WEEK_VALUE)
                                    $menus['lastWeekVegetarian'] = $currentLastWeekNextWeekMenu;
                                else
                                    $menus['nextWeekVegetarian'] = $currentLastWeekNextWeekMenu;
                            }
                        }
                        ?>
                        @if(isset($menus['currentNormal']))
                            <?php
                            $recipes = array();
                            foreach($menus['currentNormal']->menuRecipes as $menuRecipe)
                                $recipes[$menuRecipe->day_of_week] = $menuRecipe;
                            ?>
                                <a class="FitfoodPopupImage" href="{{ $menus['currentNormal']->image_src }}">
                                    <img src="{{ $menus['currentNormal']->image_src }}" width="100%" alt="Fitfood" border="0" />
                                </a>
                                <!--
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>@lang('menu_page.breakfast')</th>
                                        <th>@lang('menu_page.lunch')</th>
                                        <th>@lang('menu_page.dinner')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i = 1;$i <= 5;$i ++)
                                        <tr>
                                            <th>{{ $dayOfWeek[$i] }}</th>
                                            @if(isset($recipes[$i]) && $recipes[$i]->status == App\Libraries\Util::STATUS_ACTIVE_VALUE)
                                                <td>
                                                    @if(!empty($recipes[$i]->breakfastRecipe))
                                                        @if(App::getLocale() == 'en' && !empty($recipes[$i]->breakfastRecipe->name_en))
                                                            {{ $recipes[$i]->breakfastRecipe->name_en }}
                                                        @else
                                                            {{ $recipes[$i]->breakfastRecipe->name }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($recipes[$i]->lunchRecipe))
                                                        @if(App::getLocale() == 'en' && !empty($recipes[$i]->lunchRecipe->name_en))
                                                            {{ $recipes[$i]->lunchRecipe->name_en }}
                                                        @else
                                                            {{ $recipes[$i]->lunchRecipe->name }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($recipes[$i]->dinnerRecipe))
                                                        @if(App::getLocale() == 'en' && !empty($recipes[$i]->dinnerRecipe->name_en))
                                                            {{ $recipes[$i]->dinnerRecipe->name_en }}
                                                        @else
                                                            {{ $recipes[$i]->dinnerRecipe->name }}
                                                        @endif
                                                    @endif
                                                </td>
                                            @else
                                                <td colspan="3"><b>@lang('menu_page.holiday')</b></td>
                                            @endif
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                                -->
                        @endif
                        <div class="last-week-menu">
                            @if(isset($menus['lastWeekNormal']) && !empty($menus['lastWeekNormal']->image_src))
                                <a class="FitfoodPopupImage text-left" href="{{ $menus['lastWeekNormal']->image_src }}"><i class="fa fa-angle-double-left fa-fw"></i>@lang('menu_page.lastWeekMenu')</a>
                            @endif
                            @if(isset($menus['nextWeekNormal']) && !empty($menus['nextWeekNormal']->image_src))
                                <a class="FitfoodPopupImage text-right" href="{{ $menus['nextWeekNormal']->image_src }}">@lang('menu_page.nextWeekMenu')<i class="fa fa-angle-double-right fa-fw"></i></a>
                            @endif
                        </div>
                        @if(isset($menus['currentVegetarian']))
                            <div class="page-title">
                                <h2>@lang('menu_page.vegetarianMenu')</h2>
                            </div>
                            <?php
                            $recipes = array();
                            foreach($menus['currentVegetarian']->menuRecipes as $menuRecipe)
                                $recipes[$menuRecipe->day_of_week] = $menuRecipe;
                            ?>
                            <a class="FitfoodPopupImage" href="{{ $menus['currentVegetarian']->image_src }}">
                                <img src="{{ $menus['currentVegetarian']->image_src }}" width="100%" alt="Fitfood" border="0" />
                            </a>
                            <!--
                            <table class="table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('menu_page.meal') 1</th>
                                    <th>@lang('menu_page.meal') 2</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i = 1;$i <= 5;$i ++)
                                    <tr>
                                        <th>{{ $dayOfWeek[$i] }}</th>
                                        @if(isset($recipes[$i]) && $recipes[$i]->status == App\Libraries\Util::STATUS_ACTIVE_VALUE)
                                            <td>
                                                @if(!empty($recipes[$i]->breakfastRecipe))
                                                    @if(App::getLocale() == 'en' && !empty($recipes[$i]->breakfastRecipe->name_en))
                                                        {{ $recipes[$i]->breakfastRecipe->name_en }}
                                                    @else
                                                        {{ $recipes[$i]->breakfastRecipe->name }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($recipes[$i]->lunchRecipe))
                                                    @if(App::getLocale() == 'en' && !empty($recipes[$i]->lunchRecipe->name_en))
                                                        {{ $recipes[$i]->lunchRecipe->name_en }}
                                                    @else
                                                        {{ $recipes[$i]->lunchRecipe->name }}
                                                    @endif
                                                @endif
                                            </td>
                                        @else
                                            <td colspan="2"><b>@lang('menu_page.holiday')</b></td>
                                        @endif
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                            -->
                        @endif
                        <div class="last-week-menu">
                            @if(isset($menus['lastWeekVegetarian']) && !empty($menus['lastWeekVegetarian']->image_src))
                                <a class="FitfoodPopupImage text-left" href="{{ $menus['lastWeekVegetarian']->image_src }}"><i class="fa fa-angle-double-left fa-fw"></i>@lang('menu_page.lastWeekVegetarian')</a>
                            @endif
                            @if(isset($menus['nextWeekVegetarian']) && !empty($menus['nextWeekVegetarian']->image_src))
                                <a class="FitfoodPopupImage text-right" href="{{ $menus['nextWeekVegetarian']->image_src }}">@lang('menu_page.nextWeekVegetarian')<i class="fa fa-angle-double-right fa-fw"></i></a>
                            @endif
                        </div>

                        @include('beta.pages.partials.signature_dish', ['title' => true])

                    </div>
                </div>
            </div>
        </div>
    </div>

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