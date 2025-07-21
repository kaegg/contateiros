<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    protected $table = "atividade";

    protected $fillable = [
        "codigo",
        "nome",
        "icone",
        "ativo"
    ];
}
