<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Imagem;

class Post extends Model
{
    protected $fillable = [
        'nome', 'slug', 'descricao', 'conteudo', 'capa',
        'video', 'status', 'tipo', 'idCategoria'
    ];
    public function imagens()
    {
        return $this->hasMany(Imagem::class, 'idPost', 'id');
    }
}
