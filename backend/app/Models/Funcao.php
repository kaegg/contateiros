<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    protected $table = "funcao";

    protected $fillable = [
        "nome",
        "ativo"
    ];
}
