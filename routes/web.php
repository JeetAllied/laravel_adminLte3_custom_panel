<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::name('admin.')->prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function(){
   Route::match(['get','post'],'login','AdminController@login')->name('login');
    Route::group(['middleware'=>['admin']],function(){
        Route::get('dashboard','AdminController@dashboard')->name('dashboard');
        Route::get('logout','AdminController@logout')->name('logout');
    });

});
