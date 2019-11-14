<?php
use \Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    Route::resource('call', 'CallController');
    Route::resource('invoice', 'InvoiceController');
    Route::resource('customer', 'CustomerController');
    Route::post('customer/user/', ['as' => 'customer.user.store', 'uses' => 'CustomerController@storeUser']);
    Route::put('customer/{customer}/user/', ['as' => 'customer.user.update', 'uses' => 'CustomerController@updateUser']);

    Route::get('company/{code}/remote', ['as' => 'company.show.remote', function ($code, \App\Services\CompanyService $service) {
        return $service->getRemote($code);
    }]);

    Route::get('call/audio/play', ['as' => 'call.audio', function(Request $request){
//        USAR S3
//        $fileUrl = $request->query('file');
//        return Storage::disk('s3')->download($fileUrl);

        //Fake method
        $urls = [
            'http://www.testsounds.com/track18.mp3',
            'http://www.testsounds.com/track26.mp3',
            'http://www.testsounds.com/track37.mp3',
            'http://www.testsounds.com/track06.mp3',
        ];
        shuffle($urls);
        $info = pathinfo($urls[0]);
        $contents = file_get_contents($urls[0]);
        $file = '/tmp/' . $info['basename'];
        file_put_contents($file, $contents);
        //$uploaded_file = new UploadedFile($file, $info['basename']);
        //dd($uploaded_file);

        return response()->file($file);
    }]);
});

