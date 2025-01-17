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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/cart/', 'CartController@index');
Route::get('/checkout/', 'CheckoutController@index');
Route::get('/product/{id}', 'SingleProductController@index');
Route::get('/shipment/{orderId?}', 'ShipmentController@index');
Route::get('/failure', 'PaymentController@failure');
Route::get('/pending', 'PaymentController@pending');
Route::get('/success', 'PaymentController@success');
Route::get('/contact', 'ContactController@index');
Route::get('/tyc', 'ContactController@tyc');
Route::get('/mailable', function () {
    return new App\Mail\SaleEmail('https://outletdecafe.com/shipment/1');
});