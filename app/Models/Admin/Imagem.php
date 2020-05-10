<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    protected $fillable = [
        'nome', 'idPost'
    ];
}
