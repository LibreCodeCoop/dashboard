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

Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('api_invoice', 'Api\InvoiceController');
    Route::resource('api_call', 'Api\CallController');
    Route::get('customer/', ['as' => 'api_customer.index', 'uses' => 'Api\CustomerController@index'])->middleware('can:isAdmin');
    Route::get('user/{user}/customers/', ['as' => 'api_usercustomers.index', 'uses' => 'Api\UserCustomersController@index']);


});
Route::resource('api_user', 'Api\UserController');
