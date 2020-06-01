<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function(){
    Route::get('/', function () {
        return view('admin.index');
    });

    Route::get('/posts', function () {
        return view('admin.posts');
    });

    Route::get('/paginas', function () {
        return view('admin.paginas');
    });
});
