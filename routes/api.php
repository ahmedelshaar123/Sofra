<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'v1','namespace'=>'Api'],function(){
    Route::get('cities', 'MainController@cities');
    Route::get('filter-cities','MainController@filterCities');
    Route::get('districts','MainController@districts');
    Route::get('settings', 'MainController@settings');

});

Route::group(['prefix'=>'client','namespace'=>'Api\Client'],function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('reset-password', 'AuthController@resetPassword');
    Route::post('new-password', 'AuthController@newPassword');
    Route::post('filter-restaurant', 'MainController@filterRestaurant');
    Route::get('restaurant', 'MainController@restaurant');
    Route::get('product', 'MainController@product');
    Route::get('offer', 'MainController@offer');
    Route::get('review', 'MainController@review');

    Route::group(['middleware'=>'auth:client'],function(){
        Route::post('profile','AuthController@profile');
        Route::post('contacts', 'MainController@contacts');
        Route::post('register-token', 'AuthController@registerToken');
        Route::post('delete-token', 'AuthController@deleteToken');
        Route::post('reviews', 'MainController@reviews');
        Route::post('new-order', 'MainController@newOrder');
        Route::post('deliver-order', 'MainController@deliverOrder');
        Route::post('decline-order', 'MainController@declineOrder');
        Route::post('confirm-order', 'MainController@confirmOrder');
        Route::get('my-notifications', 'MainController@myNotifications');
        Route::get('my-orders', 'MainController@myOrders');
        Route::get('show-order', 'MainController@showOrder');


    });
});

Route::group(['prefix'=>'restaurant','namespace'=>'Api\Restaurant'],function(){
    Route::post('register', 'AuthController@register');
    Route::post('reset-password', 'AuthController@resetPassword');
    Route::post('new-password', 'AuthController@newPassword');
    Route::get('categories', 'MainController@categories');
    Route::get('payment-methods', 'MainController@paymentMethods');
    Route::post('login','AuthController@login');




    Route::group(['middleware'=>'auth:restaurant'],function(){
        Route::post('register-token', 'AuthController@registerToken');
        Route::post('delete-token', 'AuthController@deleteToken');
        Route::post('availability', 'MainController@availability');
        Route::post('contacts', 'MainController@contacts');
        Route::post('new-product', 'MainController@newProduct');
        Route::post('new-offer', 'MainController@newOffer');
        Route::post('profile','AuthController@profile');
        Route::post('update-product','MainController@updateProduct');
        Route::post('delete-product','MainController@deleteProduct');
        Route::post('update-offer','MainController@updateOffer');
        Route::post('delete-offer','MainController@deleteOffer');
        Route::post('accept-order', 'MainController@acceptOrder');
        Route::post('reject-order', 'MainController@rejectOrder');
        Route::post('confirm-order', 'MainController@confirmOrder');
        Route::get('my-offers', 'MainController@myOffers');
        Route::get('my-products', 'MainController@myProducts');
        Route::get('my-notifications', 'MainController@myNotifications');
        Route::get('my-reviews', 'MainController@myReviews');
        Route::get('my-orders', 'MainController@myOrders');
        Route::get('show-order', 'MainController@showOrder');
        Route::get('commissions', 'MainController@commissions');

    });
});





