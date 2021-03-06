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

    Route::get('lang/{lan}', 'PageController@lang');

    Route::get('faqs', 'PageController@faqs');

    Route::get('trial', 'PageController@trial');

    Route::post('trial', 'PageController@trial');

    Route::get('chinh-sach-quy-dinh-chung', 'PageController@chinhSachQuyDinhChung');

    Route::get('quy-dinh-hinh-thuc-thanh-toan', 'PageController@quyDinhHinhThucThanhToan');

    Route::get('chinh-sach-van-chuyen-giao-hang', 'PageController@chinhSachVanChuyenGiaoHang');

    Route::get('chinh-sach-bao-mat-thong-tin', 'PageController@chinhSachBaoMatThongTin');

    Route::get('product/{slug}', 'PageController@product');

    Route::get('landing', 'PageController@landing');

});