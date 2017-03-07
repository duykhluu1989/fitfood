<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['locale']], function() {

    Route::get('/', 'PageController@home');

    Route::get('menu', 'PageController@menu');

    Route::get('blog', 'PageController@blog');

    Route::get('blog/{categorySlug}', 'PageController@blog');

    Route::get('blog/{categorySlug}/{articleSlug}', 'PageController@blog');

    Route::get('order', 'PageController@order');

    Route::post('order', 'PageController@order');

    Route::get('thankYou', 'PageController@thankYou');

    Route::post('checkDiscountCode', 'PageController@checkDiscountCode');

    //Route::get('order/confirmPayment/{gateway}', 'PageController@confirmPayment');

    Route::get('lang/{lan}', 'PageController@lang');

    Route::get('faqs', 'PageController@faqs');

});