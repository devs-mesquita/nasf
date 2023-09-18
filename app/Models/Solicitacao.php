<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    protected $table = "solicitacoes";

    protected $fillable = [
        'unidade',
        'equipe',
        'acs',
        'usuario',
        'prof_sol',
        'dn',
        'endereco',
        'telefone',
        'mv_solicitacao',
        'relacao_caso',
        'solicitacao_data',
        'enviado',
        'data_enviado',
        'usuario_id',
        'comentario',
        'avaliacao',
        'outros',
        'nasf_id',
        'nasf_nome',
        'comentario_enviado',
        'data_coment'
    ];

    public function categorias()
    {
        return $this->belongsToMany('App\Models\Categoria', 'solicitacao_categoria', 'solicitacao_id', 'categoria_id' );
    }
    // public function comentarios()
    // {
    //     return $this->belongsToMany('App\Models\Comentarios', 'comentarios', 'form_id' );
    // }
}
