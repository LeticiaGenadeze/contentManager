<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user('id');
        return view('admin.perfil', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if (isset($request->imagem)){

            $file = $request->imagem;
            //dd($file);
            $name = Str::slug($request->name);
            $extension = $file->getClientOriginalExtension();
            $nameImage = "{$name}.$extension";
            $user->imagem = $nameImage;
            //dd( $data['cover']);

            $upload = $file->storeAs('public/usuario', $nameImage);

            if (!$upload)
                return redirect()
                    ->back()
                    ->with('errors', ['Falha no Upload']);
               }

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->back()->with('success','Perfil atualizado com sucesso!');

    }
}
