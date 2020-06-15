<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\New_;

class ImagensController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        $i = 0;
        foreach ($request->imagens  as $imagem) {
            $i++;
            $name = time().$i;
            $extension = $imagem->extension();
            $nameFile = "{$name}.{$extension}";
            $imagem->storeAs('public/galerias/'.$data['idPost'], $nameFile);
            $data['nome'] =  $nameFile;
            $galeria = new Imagem();
            $galeria->fill($data);
            $galeria->save();
        }
        return response()->json([
            'success' => 'Galeria  criada com Sucesso!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Imagem  $imagem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $imagem = Imagem::where('id', $id)->first();
        if($imagem){
            $img = public_path('storage/galerias/'.$imagem->idPost.'/'.$imagem->nome);
            if(File::exists($img)) {
                unlink($img);
            }
           if (!$imagem->delete()){
            return response()->json([
                'error' => 'Não foi possivel deletar a Imagem!'], 501);
            }
            return response()->json([
                'success' => 'Imagem deletada com Sucesso!'], 201);
        }
    }
}
