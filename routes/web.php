<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

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

    Route::get('/categorias', function () {
        return view('admin.categorias');
    });
});
