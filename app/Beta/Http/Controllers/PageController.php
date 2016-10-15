<?php

namespace App\Beta\Http\Controllers;

use Cookie;
use Log;
use Validator;
use App;
use Mail;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Libraries\Util;
use App\Models\Area;
use App\Models\MealPack;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderDiscount;
use App\Models\OrderItem;
use App\Models\OrderItemMeal;
use App\Models\OrderItemMealDetail;
use App\Models\OrderExtra;
use App\Models\OrderItemProduct;
use App\Models\Menu;
use App\Models\Widget;
use App\Models\BlogCategory;
use App\Models\Article;
use App\Models\Tag;

class PageController extends Controller
{
    const CACHE_INSTAGRAM_PHOTOS = 'CACHE_INSTAGRAM_PHOTOS';

    public function home()
    {
        $widgets = Widget::getModelActiveWidget();
        $categories = BlogCategory::getModelActiveCategory();
        $articles = array();

        foreach($categories as $category)
        {
            $latestArticles = Article::where('category_id', $category->id)
                ->where('status', Util::STATUS_ARTICLE_PUBLISH_VALUE)
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();

            foreach($latestArticles as $latestArticle)
            {
                $articles[strtotime($latestArticle->published_at)] = [
                    'article' => $latestArticle,
                    'category' => $category,
                ];
            }
        }

        krsort($articles);

        return view('beta.pages.home', [
            'widgets' => $widgets,
            'articles' => $articles,
        ]);
    }

    public function menu()
    {
        $currentLastWeekNextWeekMenus = Menu::with('menuRecipes')
            ->where('status', Util::STATUS_MENU_CURRENT_VALUE)
            ->orWhere('status', Util::STATUS_MENU_LAST_WEEK_VALUE)
            ->orWhere('status', Util::STATUS_MENU_NEXT_WEEK_VALUE)
            ->get();

        return view('beta.pages.menu', ['currentLastWeekNextWeekMenus' => $currentLastWeekNextWeekMenus]);
    }

    public function blog(Request $request, $categorySlug = null, $articleSlug = null)
    {
        $categories = BlogCategory::getModelActiveCategory();

        $categoryIds = array();
        foreach($categories as $category)
            $categoryIds[] = $category->id;

        $popularArticles = Article::with('category')
            ->where('status', Util::STATUS_ARTICLE_PUBLISH_VALUE)
            ->whereIn('category_id', $categoryIds)
            ->orderBy('view', 'desc')
            ->limit(3)
            ->get();

        $tags = Tag::orderBy('article', 'desc')
            ->limit(10)
            ->get();

        $instagramPhotos = Redis::command('get', [self::CACHE_INSTAGRAM_PHOTOS]);
        if($instagramPhotos == null)
        {
            $instagramContent = file_get_contents('https://www.instagram.com/fitfoodvn/media');
            $instagramContent = json_decode($instagramContent, true);

            $instagramPhotos = array();
            if(isset($instagramContent['status']) && $instagramContent['status'] == 'ok' && isset($instagramContent['items']) && is_array($instagramContent['items']))
            {
                $i = 1;
                foreach($instagramContent['items'] as $item)
                {
                    if($i == 10)
                        break;

                    $instagramPhotos[] = [
                        'url' => $item['link'],
                        'image_src' => $item['images']['thumbnail']['url'],
                    ];

                    $i ++;
                }
            }

            Redis::command('setex', [self::CACHE_INSTAGRAM_PHOTOS, Util::TIMESTAMP_ONE_DAY, json_encode($instagramPhotos)]);
        }
        else
            $instagramPhotos = json_decode($instagramPhotos, true);

        if($categorySlug == null)
        {
            $searchKey = $request->input('keyword');
            if(!empty($searchKey))
            {
                $searchKey = trim($searchKey);
                $searchKey = preg_replace('/\s+/', ' ', $searchKey);
            }

            $tagName = $request->input('tag');

            if(strlen($searchKey) > 1 || !empty($tagName))
            {
                if(strlen($searchKey) > 1)
                {
                    $keywords = explode(' ', $searchKey);

                    $builder = Article::with('category')
                        ->where('status', Util::STATUS_ARTICLE_PUBLISH_VALUE)
                        ->whereIn('category_id', $categoryIds)
                        ->orderBy('published_at', 'desc');

                    $builder->where(function($query) use($keywords) {

                        $query->where('name_en', 'like', '%' . $keywords[0] . '%')->orWhere('name', 'like', '%' . $keywords[0] . '%')
                            ->orWhere('description_en', 'like', '%' . $keywords[0] . '%')->orWhere('description', 'like', '%' . $keywords[0] . '%')
                            ->orWhere('body_html_en', 'like', '%' . $keywords[0] . '%')->orWhere('body_html', 'like', '%' . $keywords[0] . '%')
                            ->orWhere('tags', 'like', '%' . $keywords[0] . '%');

                        $countKeywords = count($keywords);
                        if($countKeywords > 3)
                            $countKeywords = 3;

                        for($i = 1;$i < $countKeywords;$i ++)
                        {
                            $query->orWhere('name_en', 'like', '%' . $keywords[$i] . '%')->orWhere('name', 'like', '%' . $keywords[$i] . '%')
                                ->orWhere('description_en', 'like', '%' . $keywords[$i] . '%')->orWhere('description', 'like', '%' . $keywords[$i] . '%')
                                ->orWhere('body_html_en', 'like', '%' . $keywords[$i] . '%')->orWhere('body_html', 'like', '%' . $keywords[$i] . '%')
                                ->orWhere('tags', 'like', '%' . $keywords[$i] . '%');
                        }

                    });

                    $articles = $builder->paginate(Util::BLOG_ARTICLE_PER_PAGE);
                }
                else
                {
                    $articles = Article::with('category')
                        ->where('status', Util::STATUS_ARTICLE_PUBLISH_VALUE)
                        ->whereIn('category_id', $categoryIds)
                        ->where('tags', 'like', '%' . $tagName . '%')
                        ->orderBy('published_at', 'desc')
                        ->paginate(Util::BLOG_ARTICLE_PER_PAGE);
                }
            }
            else
            {
                $articles = Article::with('category')
                    ->where('status', Util::STATUS_ARTICLE_PUBLISH_VALUE)
                    ->whereIn('category_id', $categoryIds)
                    ->orderBy('published_at', 'desc')
                    ->paginate(Util::BLOG_ARTICLE_PER_PAGE);
            }

            return view('beta.pages.blog', [
                'categories' => $categories,
                'popularArticles' => $popularArticles,
                'tags' => $tags,
                'instagramPhotos' => $instagramPhotos,
                'articles' => $articles,
            ]);
        }
        else if($articleSlug == null)
        {
            $currentCategory = null;
            foreach($categories as $category)
            {
                if((!empty($category->slug_en) && $category->slug_en == $categorySlug) || (!empty($category->slug) && $category->slug == $categorySlug))
                {
                    $currentCategory = $category;
                    break;
                }
            }
            if(empty($currentCategory))
                return view('beta.errors.404');

            $articles = Article::with('category')
                ->where('status', Util::STATUS_ARTICLE_PUBLISH_VALUE)
                ->where('category_id', $currentCategory->id)
                ->orderBy('published_at', 'desc')
                ->paginate(Util::BLOG_ARTICLE_PER_PAGE);

            return view('beta.pages.blog', [
                'categories' => $categories,
                'popularArticles' => $popularArticles,
                'tags' => $tags,
                'instagramPhotos' => $instagramPhotos,
                'articles' => $articles,
                'currentCategory' => $currentCategory,
            ]);
        }
        else
        {
            $currentCategory = null;
            foreach($categories as $category)
            {
                if((!empty($category->slug_en) && $category->slug_en == $categorySlug) || (!empty($category->slug) && $category->slug == $categorySlug))
                {
                    $currentCategory = $category;
                    break;
                }
            }
            if(empty($currentCategory))
                return view('beta.errors.404');

            $article = Article::where('status', Util::STATUS_ARTICLE_PUBLISH_VALUE)
                ->where('category_id', $currentCategory->id)
                ->where(function($query) use($articleSlug) {

                    $query->where('slug_en', $articleSlug)->orWhere('slug', $articleSlug);

                })
                ->first();

            if(empty($article))
                return view('beta.errors.404');

            if($request->hasCookie(Util::COOKIE_READ_ARTICLE_NAME))
            {
                $readIds = $request->cookie(Util::COOKIE_READ_ARTICLE_NAME);
                $readIds = explode(';', $readIds);

                if(!in_array($article->id, $readIds))
                {
                    $article->increment('view', 1);

                    $readIds[] = $article->id;
                    $readIds = implode(';', $readIds);

                    Cookie::queue(Util::COOKIE_READ_ARTICLE_NAME, $readIds, Util::MINUTE_ONE_MONTH_EXPIRED);
                }
            }
            else
            {
                $article->increment('view', 1);

                Cookie::queue(Util::COOKIE_READ_ARTICLE_NAME, $article->id, Util::MINUTE_ONE_MONTH_EXPIRED);
            }

            return view('beta.pages.detail_blog', [
                'categories' => $categories,
                'popularArticles' => $popularArticles,
                'tags' => $tags,
                'instagramPhotos' => $instagramPhotos,
                'article' => $article,
                'currentCategory' => $currentCategory,
            ]);
        }
    }

    public function order(Request $request)
    {
        $dayOfWeekForOrder = date('N');

        $currentNormalMenu = Menu::with('menuRecipes')->where('status', Util::STATUS_MENU_CURRENT_VALUE)->where('type', Util::TYPE_MENU_NORMAL_VALUE)->first();

        if(!empty($currentNormalMenu))
        {
            $normalMenuDayOfWeek = array();

            foreach($currentNormalMenu->menuRecipes as $menuRecipes)
            {
                if($menuRecipes->status == Util::STATUS_ACTIVE_VALUE)
                    $normalMenuDayOfWeek[$menuRecipes->day_of_week] = $menuRecipes->day_of_week;
            }

            ksort($normalMenuDayOfWeek);
            $normalMenuDays = count($normalMenuDayOfWeek);
        }
        else
        {
            $normalMenuDays = 5;
            $normalMenuDayOfWeek = [1, 2, 3, 4, 5];
        }

        if($dayOfWeekForOrder == 7)
        {
            $key = array_search(1, $normalMenuDayOfWeek);
            if($key !== false)
            {
                unset($normalMenuDayOfWeek[$key]);
                $normalMenuDays -= 1;
            }
        }

        if($request->isMethod('post'))
        {
            $input = $request->all();

            $validator = Validator::make($input, [
                'phone' => 'required|numeric',
                'name' => 'required|string',
                'gender' => 'required|in:' . Util::GENDER_MALE_VALUE . ',' . Util::GENDER_FEMALE_VALUE,
                'email' => 'required|email',
                'address' => 'required|string',
                'district' => 'required|integer|min:1',
                'shipping_time' => 'required|string',
                'payment_gateway' => 'required|in:' . Util::PAYMENT_GATEWAY_CASH_VALUE . ',' . Util::PAYMENT_GATEWAY_BANK_TRANSFER_VCB_VALUE . ',' . Util::PAYMENT_GATEWAY_BANK_TRANSFER_ACB_VALUE . ',' . Util::PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_VALUE,
                'mealPack' => 'required|array'
            ]);

            $hasPack = false;
            $totalMealPack = 0;

            foreach($input['mealPack'] as $mealPackId => $inputMealPack)
            {
                $inputMealPack = trim($inputMealPack);

                if(!empty($inputMealPack) && is_numeric($inputMealPack) && $inputMealPack > 0)
                {
                    $hasPack = true;
                    $totalMealPack += $inputMealPack;
                }
                else
                    unset($input['mealPack'][$mealPackId]);
            }

            if(Util::validatePhone($input['phone']) == false)
                return redirect('order')->with('OrderError', trans('order_form.validate'));

            if($validator->fails() || $hasPack == false || $totalMealPack > 5)
                return redirect('order')->with('OrderError', trans('order_form.validate'));

            $startShippingDate = null;

            $jusMenuDayOfWeek = array();
            if($normalMenuDays == 3)
                $jusMenuDayOfWeek = $normalMenuDayOfWeek;
            else if($normalMenuDays == 4)
            {
                if(!in_array(1, $normalMenuDayOfWeek))
                    $jusMenuDayOfWeek = [2, 3, 5];
                else if(!in_array(3, $normalMenuDayOfWeek))
                    $jusMenuDayOfWeek = [1, 2, 5];
                else if(!in_array(5, $normalMenuDayOfWeek))
                    $jusMenuDayOfWeek = [1, 3, 4];
                else
                    $jusMenuDayOfWeek = [1, 3, 5];
            }
            else if($normalMenuDays == 5)
                $jusMenuDayOfWeek = [1, 3, 5];

            try
            {
                DB::beginTransaction();

                $district = Area::where('status', Util::STATUS_ACTIVE_VALUE)->find(trim($input['district']));
                $customer = Customer::where('phone', trim($input['phone']))->first();

                if(empty($customer))
                {
                    $customer = new Customer();
                    $customer->phone = trim($input['phone']);
                    $customer->orders_count = 0;
                    $customer->total_spent = 0;
                    $customer->created_at = date('Y-m-d H:i:s');
                    $customer->email = trim($input['email']);
                    $customer->name = trim($input['name']);
                    $customer->gender = trim($input['gender']);
                    $customer->address = trim($input['address']);
                    $customer->district = $district->name;
                    $customer->latitude = trim($input['latitude']);
                    $customer->longitude = trim($input['longitude']);
                    $customer->address_google = trim($input['address_google']);
                    $customer->save();
                }

                $order = new Order();
                $order->customer_id = $customer->id;
                $order->created_at = date('Y-m-d H:i:s');
                $order->financial_status = Util::FINANCIAL_STATUS_PENDING_VALUE;
                $order->fulfillment_status = Util::FULFILLMENT_STATUS_PENDING_VALUE;
                $order->customer_note = trim($input['note']);
                $order->shipping_price = $district->shipping_price * $normalMenuDays / 5;
                $order->total_line_items_price = 0;
                $order->total_price = $district->shipping_price * $normalMenuDays / 5;
                $order->total_discounts = 0;
                $order->total_extra_price = 0;
                $order->start_week = date('Y-m-d', strtotime('+ ' . (8 - $dayOfWeekForOrder) . ' days'));
                $order->end_week = date('Y-m-d', strtotime('+ ' . (12 - $dayOfWeekForOrder) . ' days'));
                $order->payment_gateway = trim($input['payment_gateway']);
                $order->shipping_time = trim($input['shipping_time']);
                $order->shipping_priority = 1;
                $order->warning = Util::STATUS_INACTIVE_VALUE;
                $order->save();

                if(empty($customer->first_order))
                    $customer->first_order = $order->id;

                $customer->last_order = $order->id;
                $customer->orders_count += 1;
                $customer->save();

                $orderAddress = new OrderAddress();
                $orderAddress->order_id = $order->id;
                $orderAddress->email = trim($input['email']);
                $orderAddress->name = trim($input['name']);
                $orderAddress->gender = trim($input['gender']);
                $orderAddress->address = trim($input['address']);
                $orderAddress->district = $district->name;
                $orderAddress->latitude = trim($input['latitude']);
                $orderAddress->longitude = trim($input['longitude']);
                $orderAddress->address_google = trim($input['address_google']);
                $orderAddress->save();

                $mealPackIds = array();

                foreach($input['mealPack'] as $mealPackId => $quantity)
                    $mealPackIds[] = $mealPackId;

                $mealPacks = MealPack::where('status', Util::STATUS_ACTIVE_VALUE)->whereIn('id', $mealPackIds)->get();

                $mealValid = false;

                foreach($mealPacks as $mealPack)
                {
                    if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                    {
                        $mealValid = true;
                        break;
                    }
                }

                if($mealValid == false)
                    throw new \Exception();

                $addedExtraBreakfastOrderItemId = null;
                $addedExtraBreakfast = false;

                foreach($mealPacks as $mealPack)
                {
                    $doubles = array();
                    if(!empty($mealPack->double))
                        $doubles = json_decode($mealPack->double, true);

                    for($i = 0;$i < $input['mealPack'][$mealPack->id];$i ++)
                    {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->meal_pack = $mealPack->name;
                        $orderItem->meal_pack_description = $mealPack->description;

                        if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                            $orderItem->price = $mealPack->price * $normalMenuDays / 5;
                        else
                            $orderItem->price = $mealPack->price;

                        $orderItem->type = $mealPack->type;
                        $orderItem->save();

                        $order->total_line_items_price += $orderItem->price;
                        $order->total_price += $orderItem->price;

                        if($mealPack->type == Util::MEAL_PACK_TYPE_PACK_VALUE)
                        {
                            foreach($normalMenuDayOfWeek as $dayOfWeek)
                            {
                                if(in_array($dayOfWeek, $normalMenuDayOfWeek))
                                {
                                    if(empty($mealPack->breakfast) && empty($mealPack->lunch) && empty($mealPack->dinner) && empty($mealPack->fruit) && empty($mealPack->veggies) && empty($mealPack->vegetarian)
                                        && !empty($mealPack->juice) && !in_array($dayOfWeek, $jusMenuDayOfWeek))
                                        continue;

                                    $orderItemMeal = new OrderItemMeal();
                                    $orderItemMeal->order_id = $order->id;
                                    $orderItemMeal->order_item_id = $orderItem->id;
                                    $orderItemMeal->day_of_week = $dayOfWeek;
                                    $orderItemMeal->status = Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE;
                                    $orderItemMeal->shipping_time = $order->shipping_time;
                                    $orderItemMeal->meal_date = date('Y-m-d', strtotime('+ ' . (7 + $dayOfWeek - $dayOfWeekForOrder) . ' days'));

                                    if($order->shipping_time == Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                                        $orderItemMeal->cook_date = date('Y-m-d', strtotime('+ ' . (6 + $dayOfWeek - $dayOfWeekForOrder) . ' days'));
                                    else
                                        $orderItemMeal->cook_date = $orderItemMeal->meal_date;

                                    $orderItemMeal->shipping_date = $orderItemMeal->cook_date;
                                    $orderItemMeal->save();

                                    if(empty($startShippingDate))
                                        $startShippingDate = $orderItemMeal->shipping_date;

                                    if(!empty($mealPack->breakfast) || (!empty($input['extra_breakfast']) && $addedExtraBreakfast == false) && isset($doubles['lunch']) && isset($doubles['dinner']))
                                    {
                                        $orderItemMealDetail = new OrderItemMealDetail();
                                        $orderItemMealDetail->order_id = $order->id;
                                        $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                        $orderItemMealDetail->name = Util::MEAL_BREAKFAST_LABEL;
                                        $orderItemMealDetail->quantity = 1;

                                        if(!empty($mealPack->breakfast) && isset($doubles['breakfast']))
                                            $orderItemMealDetail->double = Util::STATUS_ACTIVE_VALUE;
                                        else
                                            $orderItemMealDetail->double = Util::STATUS_INACTIVE_VALUE;

                                        if(empty($mealPack->breakfast) && isset($doubles['lunch']) && isset($doubles['dinner']) && !empty($input['extra_breakfast']) && $addedExtraBreakfast == false)
                                        {
                                            $addedExtraBreakfastOrderItemId = $orderItem->id;
                                            $orderItemMealDetail->extra = Util::STATUS_ACTIVE_VALUE;
                                        }
                                        else
                                            $orderItemMealDetail->extra = Util::STATUS_INACTIVE_VALUE;

                                        if(!empty($mealPack->vegetarian))
                                            $orderItemMealDetail->vegetarian = Util::STATUS_ACTIVE_VALUE;
                                        else
                                            $orderItemMealDetail->vegetarian = Util::STATUS_INACTIVE_VALUE;

                                        $orderItemMealDetail->save();

                                        if(empty($mealPack->breakfast) && isset($doubles['lunch']) && isset($doubles['dinner']) && !empty($input['extra_breakfast']) && $addedExtraBreakfast == false && $dayOfWeek == max($normalMenuDayOfWeek))
                                            $addedExtraBreakfast = true;
                                    }

                                    if(!empty($mealPack->lunch))
                                    {
                                        $orderItemMealDetail = new OrderItemMealDetail();
                                        $orderItemMealDetail->order_id = $order->id;
                                        $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                        $orderItemMealDetail->name = Util::MEAL_LUNCH_LABEL;
                                        $orderItemMealDetail->quantity = 1;

                                        if(isset($doubles['lunch']))
                                            $orderItemMealDetail->double = Util::STATUS_ACTIVE_VALUE;
                                        else
                                            $orderItemMealDetail->double = Util::STATUS_INACTIVE_VALUE;

                                        if(!empty($mealPack->vegetarian))
                                            $orderItemMealDetail->vegetarian = Util::STATUS_ACTIVE_VALUE;
                                        else
                                            $orderItemMealDetail->vegetarian = Util::STATUS_INACTIVE_VALUE;

                                        $orderItemMealDetail->save();
                                    }

                                    if(!empty($mealPack->dinner))
                                    {
                                        $orderItemMealDetail = new OrderItemMealDetail();
                                        $orderItemMealDetail->order_id = $order->id;
                                        $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                        $orderItemMealDetail->name = Util::MEAL_DINNER_LABEL;
                                        $orderItemMealDetail->quantity = 1;

                                        if(isset($doubles['dinner']))
                                            $orderItemMealDetail->double = Util::STATUS_ACTIVE_VALUE;
                                        else
                                            $orderItemMealDetail->double = Util::STATUS_INACTIVE_VALUE;

                                        if(!empty($mealPack->vegetarian))
                                            $orderItemMealDetail->vegetarian = Util::STATUS_ACTIVE_VALUE;
                                        else
                                            $orderItemMealDetail->vegetarian = Util::STATUS_INACTIVE_VALUE;

                                        $orderItemMealDetail->save();
                                    }

                                    if(!empty($mealPack->fruit))
                                    {
                                        $orderItemMealDetail = new OrderItemMealDetail();
                                        $orderItemMealDetail->order_id = $order->id;
                                        $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                        $orderItemMealDetail->name = Util::MEAL_FRUIT_LABEL;
                                        $orderItemMealDetail->quantity = 1;

                                        $orderItemMealDetail->save();
                                    }

                                    if(!empty($mealPack->veggies))
                                    {
                                        $orderItemMealDetail = new OrderItemMealDetail();
                                        $orderItemMealDetail->order_id = $order->id;
                                        $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                        $orderItemMealDetail->name = Util::MEAL_VEGGIES_LABEL;
                                        $orderItemMealDetail->quantity = 1;

                                        $orderItemMealDetail->save();
                                    }

                                    if(!empty($mealPack->juice) && in_array($dayOfWeek, $jusMenuDayOfWeek))
                                    {
                                        $orderItemMealDetail = new OrderItemMealDetail();
                                        $orderItemMealDetail->order_id = $order->id;
                                        $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                        $orderItemMealDetail->name = Util::MEAL_JUICE_LABEL;
                                        $orderItemMealDetail->quantity = 1;

                                        $orderItemMealDetail->save();
                                    }
                                }
                            }
                        }
                        else
                        {
                            $orderItemProduct = new OrderItemProduct();
                            $orderItemProduct->order_id = $order->id;
                            $orderItemProduct->order_item_id = $orderItem->id;
                            $orderItemProduct->status = Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE;
                            $orderItemProduct->shipping_time = $order->shipping_time;

                            if($order->shipping_time == Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                                $orderItemProduct->cook_date = date('Y-m-d', strtotime('+ ' . (7 - $dayOfWeekForOrder) . ' days'));
                            else
                                $orderItemProduct->cook_date = date('Y-m-d', strtotime('+ ' . (8 - $dayOfWeekForOrder) . ' days'));

                            $orderItemProduct->shipping_date = $orderItemProduct->cook_date;
                            $orderItemProduct->save();
                        }
                    }
                }

                if(!empty($input['change_ingredient']))
                {
                    $orderExtra = new OrderExtra();
                    $orderExtra->order_id = $order->id;
                    $orderExtra->price = Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE;
                    $orderExtra->code = $input['change_ingredient'];
                    $orderExtra->save();

                    $order->total_extra_price += $orderExtra->price;
                    $order->total_price += $orderExtra->price;
                    $order->warning = Util::STATUS_ACTIVE_VALUE;

                    $mailExtraRequests[] = Util::getRequestChangeIngredient($orderExtra->code, App::getLocale());
                }

                if(!empty($input['change_meal_course']))
                {
                    $orderExtra = new OrderExtra();
                    $orderExtra->order_id = $order->id;
                    $orderExtra->price = Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE;
                    $orderExtra->code = $input['change_meal_course'];
                    $orderExtra->save();

                    $order->total_extra_price += $orderExtra->price;
                    $order->total_price += $orderExtra->price;
                    $order->warning = Util::STATUS_ACTIVE_VALUE;

                    if(App::getLocale() == 'en')
                        $mailExtraRequests[] = Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL_EN;
                    else
                        $mailExtraRequests[] = Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL;
                }

                if(!empty($input['extra_breakfast']))
                {
                    $orderExtra = new OrderExtra();
                    $orderExtra->order_id = $order->id;
                    if($addedExtraBreakfastOrderItemId)
                        $orderExtra->order_item_id = $addedExtraBreakfastOrderItemId;
                    $orderExtra->price = Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5;
                    $orderExtra->code = $input['extra_breakfast'];
                    $orderExtra->save();

                    $order->total_extra_price += $orderExtra->price;
                    $order->total_price += $orderExtra->price;
                    $order->warning = Util::STATUS_ACTIVE_VALUE;

                    if(App::getLocale() == 'en')
                        $mailExtraRequests[] = Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL_EN;
                    else
                        $mailExtraRequests[] = Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL;
                }

                if(!empty($input['discount_code']))
                {
                    $discount = Discount::with('customer')->where('code', trim($input['discount_code']))->first();

                    if(!empty($discount) && (empty($discount->customer) || $customer->id == $discount->customer->id))
                    {
                        $time = strtotime('now');

                        if($discount->status == Util::STATUS_ACTIVE_VALUE && (empty($discount->start_time) || $time >= strtotime($discount->start_time)) && (empty($discount->end_time) || $time <= strtotime($discount->end_time))
                            && (empty($discount->times_limit) || $discount->times_used < $discount->times_limit))
                        {
                            if($discount->usage_unique == Util::STATUS_ACTIVE_VALUE)
                            {
                                $usedDiscount = OrderDiscount::select('ff_order_discount.*')
                                    ->join('ff_order', 'ff_order_discount.order_id', '=', 'ff_order.id')
                                    ->where('ff_order.customer_id', $customer->id)
                                    ->where('ff_order_discount.code', $discount->code)
                                    ->first();
                            }
                            else
                                $usedDiscount = null;

                            if(empty($usedDiscount))
                            {
                                $totalMainPackPrice = 0;

                                foreach($mealPacks as $mealPack)
                                {
                                    if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                                        $totalMainPackPrice += $mealPack->price * $input['mealPack'][$mealPack->id] * $normalMenuDays / 5;
                                }

                                if($discount->type == Util::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED)
                                {
                                    if($discount->value < $totalMainPackPrice)
                                        $discountAmount = $discount->value;
                                    else
                                        $discountAmount = $totalMainPackPrice;
                                }
                                else
                                    $discountAmount = round($totalMainPackPrice * $discount->value / 100);

                                if($discountAmount > 0)
                                {
                                    $orderDiscount = new OrderDiscount();
                                    $orderDiscount->order_id = $order->id;
                                    $orderDiscount->code = $discount->code;
                                    $orderDiscount->type = $discount->type;
                                    $orderDiscount->value = $discount->value;
                                    $orderDiscount->amount = $discountAmount;
                                    $orderDiscount->save();

                                    $discount->times_used += 1;
                                    $discount->save();

                                    $order->total_discounts += $discountAmount;
                                    $order->total_price -= $discountAmount;
                                }
                            }
                        }
                    }
                }

                $order->save();

                DB::commit();

                $mailMealPack = '';

                foreach($mealPacks as $mealPack)
                {
                    if($mailMealPack == '')
                        $mailMealPack .= $input['mealPack'][$mealPack->id] . ' x ' . $mealPack->name;
                    else
                        $mailMealPack .= ', ' . $input['mealPack'][$mealPack->id] . ' x ' . $mealPack->name;
                }

                $extraRequest = '';
                if(isset($mailExtraRequests))
                    $extraRequest = implode(', ', $mailExtraRequests);

                if($order->shipping_time != Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                    $deliveryTime = $order->shipping_time;
                else
                {
                    if(App::getLocale() == 'en')
                        $deliveryTime = Util::SHIPPING_TIME_NIGHT_BEFORE_LABEL_EN;
                    else
                        $deliveryTime = Util::SHIPPING_TIME_NIGHT_BEFORE_LABEL;
                }

                $bankNumber = '';
                if($order->payment_gateway != Util::PAYMENT_GATEWAY_CASH_VALUE)
                    $bankNumber = Util::getBankAccountNumber($order->payment_gateway);

                try
                {
                    Mail::send('web.emails.order_confirm', [
                        'name' => $orderAddress->name,
                        'phone' => $customer->phone,
                        'address' => $orderAddress->address,
                        'mealPacks' => $mailMealPack,
                        'paymentGateway' => Util::getPaymentMethod($order->payment_gateway, App::getLocale()),
                        'deliveryTime' => $deliveryTime,
                        'extraRequest' => $extraRequest,
                        'totalPrice' => Util::formatMoney($order->total_price),
                        'note' => $order->customer_note,
                        'email' => $order->orderAddress->email,
                        'bankNumber' => $bankNumber,
                        'startShippingDate' => $startShippingDate,
                    ], function($message) use($orderAddress) {

                        $message->from('order@fitfood.vn', 'Fitfood');
                        $message->to($orderAddress->email, $orderAddress->name);
                        $message->subject('[FITFOOD.VN] Xác nhận order | Order Confirmation');

                    });
                }
                catch(\Exception $e)
                {

                }

                try
                {
                    Mail::send('web.emails.order_confirm', [
                        'name' => $orderAddress->name,
                        'phone' => $customer->phone,
                        'address' => $orderAddress->address,
                        'mealPacks' => $mailMealPack,
                        'paymentGateway' => Util::getPaymentMethod($order->payment_gateway, App::getLocale()),
                        'deliveryTime' => $deliveryTime,
                        'extraRequest' => $extraRequest,
                        'totalPrice' => Util::formatMoney($order->total_price),
                        'note' => $order->customer_note,
                        'email' => $order->orderAddress->email,
                        'bankNumber' => $bankNumber,
                        'startShippingDate' => $startShippingDate,
                    ], function($message) use($orderAddress) {

                        $message->from('order@fitfood.vn', 'Fitfood');
                        $message->to('info@fitfood.vn', 'Fitfood');
                        $message->cc('huong.ueh35@gmail.com', 'Fitfood');
                        $message->subject('[FITFOOD.VN] Xác nhận order | Order Confirmation');

                    });
                }
                catch(\Exception $e)
                {

                }

                return redirect('thankYou')->with('OrderThankYou', json_encode([
                    'name' => $orderAddress->name,
                    'phone' => $customer->phone,
                    'address' => $orderAddress->address,
                    'mealPacks' => $mailMealPack,
                    'paymentGateway' => Util::getPaymentMethod($order->payment_gateway, App::getLocale()),
                    'deliveryTime' => $deliveryTime,
                    'extraRequest' => $extraRequest,
                    'totalPrice' => Util::formatMoney($order->total_price),
                    'note' => $order->customer_note,
                    'email' => $order->orderAddress->email,
                    'bankNumber' => $bankNumber,
                    'startShippingDate' => $startShippingDate,
                ]));
            }
            catch(\Exception $e)
            {
                DB::rollBack();

                Log::info($e->getLine() . ' ' . $e->getMessage());

                return redirect('order')->with('OrderError', trans('order_form.error'));
            }
        }

        $areas = Area::getModelActiveArea();
        $mealPacks = MealPack::getModelActiveMealPack();

        $autoAddMealPackId = $request->input('p');

        return view('beta.pages.order', [
            'areas' => $areas,
            'mealPacks' => $mealPacks,
            'normalMenuDays' => $normalMenuDays,
            'currentNormalMenu' => $currentNormalMenu,
            'autoAddMealPackId' => $autoAddMealPackId,
        ]);
    }

    public function thankYou(Request $request)
    {
        if($request->session()->has('OrderThankYou'))
        {
            $dataThankYou = json_decode($request->session()->pull('OrderThankYou'), true);

            return view('beta.pages.thank_you', $dataThankYou);
        }
        else
            return redirect('order');
    }

    public function checkDiscountCode(Request $request)
    {
        try
        {
            if($request->ajax())
            {
                $input = $request->all();

                $currentNormalMenu = Menu::with('menuRecipes')->where('status', Util::STATUS_MENU_CURRENT_VALUE)->where('type', Util::TYPE_MENU_NORMAL_VALUE)->first();
                if(!empty($currentNormalMenu))
                {
                    $normalMenuDayOfWeek = array();

                    foreach($currentNormalMenu->menuRecipes as $menuRecipes)
                    {
                        if($menuRecipes->status == Util::STATUS_ACTIVE_VALUE)
                            $normalMenuDayOfWeek[$menuRecipes->day_of_week] = $menuRecipes->day_of_week;
                    }

                    $normalMenuDays = count($normalMenuDayOfWeek);
                }
                else
                    $normalMenuDays = 5;

                $discount = Discount::with('customer')->where('code', trim($input['code']))->first();

                $customer = null;
                if(!empty($input['phone']))
                    $customer = Customer::where('phone', trim($input['phone']))->first();

                if(!empty($discount) && (empty($discount->customer) || (!empty($customer) && $customer->id == $discount->customer->id)))
                {
                    $time = strtotime('now');

                    if($discount->status == Util::STATUS_ACTIVE_VALUE && (empty($discount->start_time) || $time >= strtotime($discount->start_time)) && (empty($discount->end_time) || $time <= strtotime($discount->end_time))
                        && (empty($discount->times_limit) || $discount->times_used < $discount->times_limit))
                    {
                        if($discount->usage_unique == Util::STATUS_ACTIVE_VALUE && !empty($customer))
                        {
                            $usedDiscount = OrderDiscount::select('ff_order_discount.*')
                                ->join('ff_order', 'ff_order_discount.order_id', '=', 'ff_order.id')
                                ->where('ff_order.customer_id', $customer->id)
                                ->where('ff_order_discount.code', $discount->code)
                                ->first();

                            if(!empty($usedDiscount))
                                return 'EXPIRED';
                        }

                        $mealPackIds = array();

                        foreach($input['pack'] as $mealPackId => $inputMealPack)
                        {
                            $quantity = trim($inputMealPack);

                            if(!empty($quantity) && is_numeric($quantity) && $quantity > 0)
                                $mealPackIds[] = $mealPackId;
                        }

                        $mealPacks = MealPack::where('status', Util::STATUS_ACTIVE_VALUE)->whereIn('id', $mealPackIds)->get();

                        $totalMainPackPrice = 0;

                        foreach($mealPacks as $mealPack)
                        {
                            if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                                $totalMainPackPrice += $mealPack->price * $input['pack'][$mealPack->id] * $normalMenuDays / 5;
                        }

                        if($discount->type == Util::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED)
                        {
                            if($discount->value < $totalMainPackPrice)
                                echo $discount->value;
                            else
                                echo $totalMainPackPrice;
                        }
                        else
                            echo round($totalMainPackPrice * $discount->value / 100);
                    }
                    else
                        echo 'EXPIRED';
                }
                else
                    echo 'INVALID_CODE';
            }
        }
        catch(\Exception $e)
        {
            echo false;
        }
    }

    public function lang(Request $request, $lan)
    {
        $returnUrl = $request->server('HTTP_REFERER');

        if(empty($returnUrl) || strpos($returnUrl, '/lang'))
            $returnUrl = '/';

        if($lan == 'vi')
            return redirect($returnUrl)->withCookie('lang', 'vi', Util::MINUTE_ONE_MONTH_EXPIRED);
        else
            return redirect($returnUrl)->withCookie('lang', 'en', Util::MINUTE_ONE_MONTH_EXPIRED);
    }

    public function faqs()
    {
        return view('beta.pages.faqs');
    }
}