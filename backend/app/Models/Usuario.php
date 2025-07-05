<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Funcao;
use App\Models\Secao;

class Usuario extends Model
{   
    protected $table = "usuario";

    protected $fillable = [
        "nome",
        "usuario",
        "email",
        "telefone",
        "id_funcao",
        "id_secao",
        "ativo",
    ];

    public function funcao()
    {
        return $this->belongsTo(Funcao::class, 'id_funcao'); // Como não segue o padrao do laravel de nome_da_model, tem que dizer qual a chave estrangeira
    }
    
    public function secao()
    {
        return $this->belongsTo(Secao::class, 'id_secao');
    }
}