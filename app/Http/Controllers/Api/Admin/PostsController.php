<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::where('tipo', 'post')->orderBy('created_at','DESC')->get();
        if(!$post){
            return response()->json([
                'error' => 'Nenhum post encontrada!'], 404);
        }
        return $post;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        $validation = Validator::make($data,[
            'nome' => 'required|unique:posts,nome',
            'descricao' => 'required',
            'capa' => 'required|image|mimes:jpeg,jpg,png,max:2048',
            'idCategoria' => 'required'
        ]);

        if($validation->fails()){
            $errors = $validation->errors();
            return $errors->toJson();
        }
        $data['slug'] = Str::slug($data['nome'], '-');

        if($data['capa'] && $data['capa']!= null){
            $name = $data['slug'].time();
            $extension = $request->capa->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->capa->storeAs('public/posts', $nameFile);
            if ( !$upload ){
                return response()->json([
                    'error' => 'Falha ao fazer upload!'], 404);
            }
            $data['capa'] = $nameFile;
        }
        $data['tipo'] = 'post';
        $post = new Post();

        $post->fill($data);

        if ($post->save()){
            return response()->json([
                'success' => 'Post salvo com Sucesso!'], 201);
        }

        return response()->json([
            'error' => 'Erro ao cadastrar o post!'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('imagens')->where('id', $id)->get();
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data =  $request->all();
        $validation = Validator::make($data,[
            'nome' => 'required',
            'descricao' => 'required',
            'idCategoria' => 'required'
        ]);

        if($validation->fails()){
            $errors = $validation->errors();
            return $errors->toJson();
        }
        $data['slug'] = Str::slug($data['nome'], '-');

        if($data['capa']){
            $validation = Validator::make($data,[
               'capa' => 'image|mimes:jpeg,jpg,png,max:2048'
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return $errors->toJson();
            }

            $name = $data['slug'].time();
            $extension = $request->capa->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->capa->storeAs('public/posts', $nameFile);
            if ( !$upload ){
                return response()->json([
                    'error' => 'Falha ao fazer upload!'], 404);
            }
            if($post->capa){
                $capa = public_path('storage/posts/'.$post->capa);
                if(File::exists($capa)) {
                    unlink($capa);
                }
            }
            $data['capa'] = $nameFile;
        }

        $post->fill($data);
        if ($post->save()){
            return response()->json([
                'success' => 'Post atualizao com Sucesso!'], 201);
        }

        return response()->json([
            'error' => 'Erro ao atualizar o post!'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();
        if($post){
            if ($post->capa){
                $capa = public_path('storage/posts/'.$post->capa);
                if(File::exists($capa)) {
                    unlink($capa);
                }
            }
           if (!$post->delete()){
            return response()->json([
                'error' => 'Não foi possivel deletar o Post!'], 500);
            }
            return response()->json([
                'success' => 'Post deletado com Sucesso!'], 200);
        }
    }
}
