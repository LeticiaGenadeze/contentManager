<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

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

    route::get('/perfil', 'PerfilController@index')->name('admin.perfil');
    route::post('/perfil/atualizar/{id}', 'PerfilController@update')->name('admin.perfil.update');

  });
