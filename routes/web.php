<?php
use \Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::resource('user', 'UserController', ['except' => ['show']])->middleware('can:isAdmin');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    Route::resource('call', 'CallController');
    Route::resource('invoice', 'InvoiceController');
    Route::get('invoice/{invoice}/csv', ['as' => 'invoice.csv', 'uses' => 'InvoiceController@csv']);
    Route::get('invoice/{invoice}/billet', ['as' => 'invoice.billet', 'uses' => 'InvoiceController@billet']);
    Route::resource('customer', 'CustomerController')->middleware('can:isAdmin');
    Route::post('customer/user/', ['as' => 'customer.user.store', 'uses' => 'CustomerController@storeUser']);
    Route::put('customer/{customer}/user/', ['as' => 'customer.user.update', 'uses' => 'CustomerController@updateUser']);

    Route::get('company/{code}/remote', ['as' => 'company.show.remote', function ($code, \App\Services\CompanyService $service) {
        return $service->getRemote($code);
    }]);

    Route::get('call/audio/play', ['as' => 'call.audio', function(Request $request){
        $fileUrl = $request->query('file');
        return Storage::disk('s3')->download($fileUrl);
    }]);
});

