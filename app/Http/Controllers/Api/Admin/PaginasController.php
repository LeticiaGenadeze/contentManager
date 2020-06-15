<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaginasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagina = Post::where('tipo', 'pagina')->orderBy('created_at','DESC')->get();
        if(!$pagina){
            return response()->json([
                'error' => 'Nenhuma pagina encontrada!'], 404);
        }
        return $pagina;
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
           // 'capa' => 'required|image|mimes:jpeg,jpg,png,max:2048'
        ]);

        if($validation->fails()){
            $errors = $validation->errors();
            return $errors->toJson();
        }
        $data['slug'] = Str::slug($data['nome'], '-');

        /*if($data['capa'] && $data['capa']!= null){
            $name = $data['slug'].time();
            $extension = $request->capa->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->capa->storeAs('public/paginas', $nameFile);
            if ( !$upload ){
                return response()->json([
                    'error' => 'Falha ao fazer upload!'], 404);
            }
            $data['capa'] = $nameFile;
        }*/
        $data['tipo'] = 'pagina';
        $pagina = new Post();

        $pagina->fill($data);

        if ($pagina->save()){
            return response()->json([
                'success' => 'Página salva com Sucesso!'], 201);
        }

        return response()->json([
            'error' => 'Erro ao cadastrar a Página!'], 501);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pagina = Post::query()->where('id', $id)->get();
        return $pagina;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $pagina)
    {
        $data =  $request->all();
        $validation = Validator::make($data,[
            'nome' => 'required',
            'descricao' => 'required'
        ]);

        if($validation->fails()){
            $errors = $validation->errors();
            return $errors->toJson();
        }
        $data['slug'] = Str::slug($data['nome'], '-');

        /*if($data['capa']){
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
            $upload = $request->capa->storeAs('public/paginas', $nameFile);
            if ( !$upload ){
                return response()->json([
                    'error' => 'Falha ao fazer upload!'], 404);
            }
            if($pagina->capa){
                $capa = public_path('storage/paginas/'.$pagina->capa);
                if(File::exists($capa)) {
                    unlink($capa);
                }
            }
            $data['capa'] = $nameFile;
        }*/

        $pagina->fill($data);
        if ($pagina->save()){
            return response()->json([
                'success' => 'Pagina atualizada com Sucesso!'], 201);
        }

        return response()->json([
            'error' => 'Erro ao atualizar a Pagina!'], 501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pagina = Post::where('id', $id)->first();
        if($pagina){
          /*  if ($pagina->capa){
                $capa = public_path('storage/paginas/'.$pagina->capa);
                if(File::exists($capa)) {
                    unlink($capa);
                }
            }*/
           if (!$pagina->delete()){
            return response()->json([
                'error' => 'Não foi possivel deletar a Pagina!'], 501);
            }
            return response()->json([
                'success' => 'Pagina deletada com Sucesso!'], 201);
        }
    }
}
