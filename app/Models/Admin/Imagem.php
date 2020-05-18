<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Post;

class Imagem extends Model
{
    protected $table = 'imagens';
    protected $fillable = [
        'nome', 'idPost'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'id', 'idPost');
    }
}
