<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'nome', 'slug', 'descricao', 'conteudo', 'capa',
        'video', 'status', 'tipo', 'idCategoria'
    ];
}
