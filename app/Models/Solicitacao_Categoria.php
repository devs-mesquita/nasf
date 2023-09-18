<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitacao_Categoria extends Model
{
    protected $table = "solicitacao_categoria";
    
    protected $fillable = [
        'solicitacao_id',
        'categoria_id'
    ];
}
