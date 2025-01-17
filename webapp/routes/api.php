<?php

use Illuminate\Http\Request;

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

Route::post('/process_payment', 'PaymentController@handle');
Route::post('/cart/edit', 'CartController@handle');
Route::post('/notifications', 'PaymentController@ipn');
Route::get('/shipment/find', 'ShipmentController@find');

