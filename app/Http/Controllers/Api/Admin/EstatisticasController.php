<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Categoria;
use App\Models\Admin\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EstatisticasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estatisticas = [];

        $categorias = Categoria::all();
        $categorias = $categorias->count();
        $estatisticas['categorias'] = $categorias;

        $posts = Post::where('tipo', 'post');
        $posts = $posts->count();
        $estatisticas['posts'] = $posts;

        $paginas = Post::where('tipo', 'pagina');
        $paginas = $paginas->count();
        $estatisticas['paginas'] = $paginas;

        $usuarios = User::all();
        $usuarios = $usuarios->count();
        $estatisticas['usuarios'] = $usuarios;

        return $estatisticas;
    }
}
