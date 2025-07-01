<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
