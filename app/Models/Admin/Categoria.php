<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Post;

class Categoria extends Model
{
    protected $fillable = [
        'nome', 'slug', 'descricao'
    ];
    public function posts()
    {
        return $this->hasMany(Post::class, 'idCategoria', 'id');
    }
}
