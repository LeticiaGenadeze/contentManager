<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        if(!$categorias){
            return response()->json([
                'error' => 'Nenhuma categoria encontrada!'], 404);
        }
        return $categorias;
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
            'nome' => 'required|unique:categorias,nome'
        ]);

        if($validation->fails()){
            $errors = $validation->errors();
            return $errors->toJson();
        }
        $data['slug'] = Str::slug($data['nome'], '-');

        $categorias = new Categoria();

        $categorias->fill($data);

        if ($categorias->save()){
            return response()->json([
                'success' => 'Categoria salva com Sucesso!'], 201);
        }

        return response()->json([
            'error' => 'Erro ao cadastrar a Categoria!'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categorias = Categoria::with('posts')->where('id', $id)->get();
        return $categorias;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validation = Validator::make($data,[
            'nome' => 'required|unique:categorias,nome'
        ]);

        if($validation->fails()){
            $errors = $validation->errors();
            return $errors->toJson();
        }
        $data['slug'] = Str::slug($data['nome'], '-');
        $categoria = Categoria::query()->where('id', $id)->first();
        if($categoria){
            $categoria->fill($data);
            if ($categoria->save()){
                return response()->json([
                    'success' => 'Categoria atualizada com Sucesso!'], 201);
            }
            return response()->json([
                'error' => 'Não foi possivel atualizar a Categoria!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::where('id', $id)->first();
        if($categoria){
           if (!$categoria->delete()){
            return response()->json([
                'error' => 'Não foi possivel deletar a Categoria!'], 500);
            }
            return response()->json([
                'success' => 'Categoria deletada com Sucesso!'], 200);
        }
    }
}
