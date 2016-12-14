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

Route::group(['prefix' => 'admin'], function() {

    Route::group(['middleware' => 'auth'], function() {

        Route::get('logout', 'UserController@logout');

        Route::get('/', 'UserController@home');

        Route::get('user/changePassword/{id}', 'UserController@changeUserPassword');

        Route::post('user/changePassword/{id}', 'UserController@changeUserPassword');

    });

    Route::group(['middleware' => ['auth', 'permission']], function() {

        Route::get('phpinfo', 'UserController@phpinfo');

        Route::get('user', 'UserController@listUser');

        Route::get('user/create', 'UserController@createUser');

        Route::post('user/create', 'UserController@createUser');

        Route::get('user/edit/{id}', 'UserController@editUser');

        Route::post('user/edit/{id}', 'UserController@editUser');

        Route::get('role', 'UserController@listRole');

        Route::get('role/create', 'UserController@createRole');

        Route::post('role/create', 'UserController@createRole');

        Route::get('role/edit/{id}', 'UserController@editRole');

        Route::post('role/edit/{id}', 'UserController@editRole');

        Route::get('order/quickSearch', 'OrderController@quickSearchOrder');

        Route::get('order', 'OrderController@listOrder');

        Route::get('order/export', 'OrderController@exportOrder');

        Route::get('order/detail/{id}', 'OrderController@detailOrder');

        Route::post('order/transaction/pay/{id}', 'OrderController@confirmPaymentOrder');

        Route::post('order/cancel/{id}', 'OrderController@cancelOrder');

        Route::post('order/cancelItem/{id}', 'OrderController@cancelOrderItem');

        Route::post('order/itemMeal/change', 'OrderController@changeOrderItemMeal');

        Route::post('order/itemMeal/delete', 'OrderController@deleteOrderItemMeal');

        Route::post('order/note/edit', 'OrderController@editOrderNote');

        Route::get('order/move/currentWeek/{id}', 'OrderController@moveOrderToCurrentWeek');

        Route::post('order/remove/warning/{id}', 'OrderController@removeOrderWarning');

        Route::post('order/set/warning/{id}', 'OrderController@setOrderWarning');

        Route::post('order/itemMeal/edit/shippingTime', 'OrderController@editOrderItemShippingTime');

        Route::get('order/address/edit/{id}', 'OrderController@editOrderAddress');

        Route::post('order/address/edit/{id}', 'OrderController@editOrderAddress');

        Route::post('order/itemMeal/add/customMeal/{id}', 'OrderController@addCustomMealForOrderItem');

        Route::post('order/get/autoComplete/recipe', 'OrderController@getAutoCompleteRecipeData');

        Route::post('order/itemMeal/change/{id}', 'OrderController@changeOrderItem');

        Route::get('order/reorder/{id}', 'OrderController@reOrder');

        Route::post('order/reorder/{id}', 'OrderController@reOrder');

        Route::post('checkDiscountCode', 'OrderController@checkDiscountCode');

        Route::get('cooking', 'OrderController@listCooking');

        Route::get('cooking/export', 'OrderController@exportCooking');

        Route::get('assignShipping', 'OrderController@assignShipping');

        Route::post('assignShipping/order', 'OrderController@assignOrderShipper');

        Route::post('assignShipping/priority', 'OrderController@assignOrderShippingPriority');

        Route::get('shipping', 'OrderController@listShipping');

        Route::post('shipping/finish/{date}', 'OrderController@finishShipping');

        Route::get('shipping/detail/{id}/{date}', 'OrderController@detailShipping');

        Route::get('shipping/detail/export/{id}/{date}', 'OrderController@exportDetailShipping');

        Route::get('mealPack', 'MenuController@listMealPack');

        Route::get('mealPack/create', 'MenuController@createMealPack');

        Route::post('mealPack/create', 'MenuController@createMealPack');

        Route::get('mealPack/edit/{id}', 'MenuController@editMealPack');

        Route::post('mealPack/edit/{id}', 'MenuController@editMealPack');

        Route::get('customer', 'CustomerController@listCustomer');

        Route::get('customer/export', 'CustomerController@exportCustomer');

        Route::get('customer/detail/{id}', 'CustomerController@detailCustomer');

        Route::get('customer/edit/{id}', 'CustomerController@editCustomer');

        Route::post('customer/edit/{id}', 'CustomerController@editCustomer');

        Route::get('shipper', 'ShippingController@listShipper');

        Route::get('shipper/create', 'ShippingController@createShipper');

        Route::post('shipper/create', 'ShippingController@createShipper');

        Route::get('shipper/edit/{id}', 'ShippingController@editShipper');

        Route::post('shipper/edit/{id}', 'ShippingController@editShipper');

        Route::get('area', 'ShippingController@listArea');

        Route::get('area/create', 'ShippingController@createArea');

        Route::post('area/create', 'ShippingController@createArea');

        Route::get('area/edit/{id}', 'ShippingController@editArea');

        Route::post('area/edit/{id}', 'ShippingController@editArea');

        Route::get('discount', 'DiscountController@listDiscount');

        Route::get('discount/create', 'DiscountController@createDiscount');

        Route::post('discount/create', 'DiscountController@createDiscount');

        Route::get('discount/edit/{id}', 'DiscountController@editDiscount');

        Route::post('discount/edit/{id}', 'DiscountController@editDiscount');

        Route::post('discount/generate', 'DiscountController@generateCode');

        Route::post('discount/get/autoComplete/customer', 'DiscountController@getAutoCompleteCustomerData');

        Route::get('discount/create/many', 'DiscountController@createManyDiscount');

        Route::post('discount/create/many', 'DiscountController@createManyDiscount');

        Route::get('discount/delete/{id}', 'DiscountController@deleteDiscount');

        Route::get('discount/export', 'DiscountController@exportDiscount');

        Route::get('category', 'MenuController@listCategory');

        Route::get('category/create', 'MenuController@createCategory');

        Route::post('category/create', 'MenuController@createCategory');

        Route::get('category/edit/{id}', 'MenuController@editCategory');

        Route::post('category/edit/{id}', 'MenuController@editCategory');

        Route::get('category/delete/{id}', 'MenuController@deleteCategory');

        Route::post('category/control', 'MenuController@controlCategory');

        Route::get('unit', 'MenuController@listUnit');

        Route::get('unit/create', 'MenuController@createUnit');

        Route::post('unit/create', 'MenuController@createUnit');

        Route::get('unit/edit/{id}', 'MenuController@editUnit');

        Route::post('unit/edit/{id}', 'MenuController@editUnit');

        Route::get('unit/delete/{id}', 'MenuController@deleteUnit');

        Route::post('unit/control', 'MenuController@controlUnit');

        Route::get('resource', 'MenuController@listResource');

        Route::get('resource/create', 'MenuController@createResource');

        Route::post('resource/create', 'MenuController@createResource');

        Route::get('resource/edit/{id}', 'MenuController@editResource');

        Route::post('resource/edit/{id}', 'MenuController@editResource');

        Route::get('resource/delete/{id}', 'MenuController@deleteResource');

        Route::post('resource/control', 'MenuController@controlResource');

        Route::post('resource/import', 'MenuController@importResource');

        Route::get('recipe', 'MenuController@listRecipe');

        Route::get('recipe/create', 'MenuController@createRecipe');

        Route::post('recipe/create', 'MenuController@createRecipe');

        Route::get('recipe/edit/{id}', 'MenuController@editRecipe');

        Route::post('recipe/edit/{id}', 'MenuController@editRecipe');

        Route::post('recipe/get/autoComplete/resource', 'MenuController@getAutoCompleteResourceData');

        Route::get('recipe/export', 'MenuController@exportRecipe');

        Route::get('recipe/delete/{id}', 'MenuController@deleteRecipe');

        Route::post('recipe/control', 'MenuController@controlRecipe');

        Route::get('menu', 'MenuController@listMenu');

        Route::get('menu/create', 'MenuController@createMenu');

        Route::post('menu/create', 'MenuController@createMenu');

        Route::get('menu/edit/{id}', 'MenuController@editMenu');

        Route::post('menu/edit/{id}', 'MenuController@editMenu');

        Route::post('menu/get/autoComplete/recipe', 'MenuController@getAutoCompleteRecipeData');

        Route::get('menu/delete/{id}', 'MenuController@deleteMenu');

        Route::post('menu/control', 'MenuController@controlMenu');

        Route::get('blogCategory', 'BlogController@listCategory');

        Route::get('blogCategory/create', 'BlogController@createCategory');

        Route::post('blogCategory/create', 'BlogController@createCategory');

        Route::get('blogCategory/edit/{id}', 'BlogController@editCategory');

        Route::post('blogCategory/edit/{id}', 'BlogController@editCategory');

        Route::get('article', 'BlogController@listArticle');

        Route::get('article/create', 'BlogController@createArticle');

        Route::post('article/create', 'BlogController@createArticle');

        Route::get('article/edit/{id}', 'BlogController@editArticle');

        Route::post('article/edit/{id}', 'BlogController@editArticle');

        Route::post('article/get/autoComplete/tag', 'BlogController@getAutoCompleteTagData');

        Route::get('article/open/elFinder', 'BlogController@openElFinder');

        Route::get('article/connector/elFinder', 'BlogController@connectorElFinder');

        Route::post('article/connector/elFinder', 'BlogController@connectorElFinder');

        Route::get('article/delete/{id}', 'BlogController@deleteArticle');

        Route::get('tag', 'BlogController@listTag');

        Route::get('tag/create', 'BlogController@createTag');

        Route::post('tag/create', 'BlogController@createTag');

        Route::get('tag/edit/{id}', 'BlogController@editTag');

        Route::post('tag/edit/{id}', 'BlogController@editTag');

        Route::get('widget', 'BlogController@listWidget');

        Route::get('widget/create', 'BlogController@createWidget');

        Route::post('widget/create', 'BlogController@createWidget');

        Route::get('widget/edit/{id}', 'BlogController@editWidget');

        Route::post('widget/edit/{id}', 'BlogController@editWidget');

        Route::get('banner', 'CustomerController@listBanner');

        Route::get('banner/create', 'CustomerController@createBanner');

        Route::post('banner/create', 'CustomerController@createBanner');

        Route::get('banner/edit/{id}', 'CustomerController@editBanner');

        Route::post('banner/edit/{id}', 'CustomerController@editBanner');

    });

    Route::group(['middleware' => 'guest'], function() {

        Route::get('login', 'UserController@login');

        Route::post('login', ['middleware' => 'throttle:5,30', 'uses' => 'UserController@login']);

    });

});