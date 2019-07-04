<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('city', 'CityController');
Route::resource('category', 'CategoryController');
Route::resource('payment-method', 'PaymentMethodController');
Route::resource('contact', 'ContactController');
Route::resource('review', 'ReviewController');
Route::resource('offer', 'OfferController');
Route::resource('client', 'ClientController');
Route::resource('product', 'ProductController');
Route::resource('order', 'OrderController');
Route::resource('restaurant', 'RestaurantController');
Route::get('restaurant/{id}/activate', 'RestaurantController@activate');
Route::get('restaurant/{id}/desactivate', 'RestaurantController@desactivate');
