<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::name('admin.')->prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function(){
   Route::match(['get','post'],'login','AdminController@login')->name('login');
    Route::group(['middleware'=>['admin']],function(){
        Route::get('dashboard','AdminController@dashboard')->name('dashboard');
        Route::get('updatePassword','AdminController@viewUpdatePassword')->name('updatePassword');
        Route::post('checkCurrentPassword','AdminController@checkCurrentPassword')->name('checkCurrentPassword');
        Route::post('updatePassword','AdminController@updatePassword')->name('updatePassword');
        Route::get('updateProfile','AdminController@viewUpdateProfile')->name('updateProfile');
        Route::post('updateProfile','AdminController@updateProfile')->name('updateProfile');

        //CMS Pages (CRUD)
        Route::get('cms-pages','CmsController@index')->name('cms-pages');

        Route::get('logout','AdminController@logout')->name('logout');
    });

});
