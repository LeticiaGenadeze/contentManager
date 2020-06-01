<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

route::resource('posts', 'Api\Admin\PostsController');
route::resource('paginas', 'Api\Admin\PaginasController');
route::resource('imagens', 'Api\Admin\ImagensController');
route::resource('categorias', 'Api\Admin\CategoriasController');
