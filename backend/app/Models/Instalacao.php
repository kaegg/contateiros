<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instalacao extends Model
{
    protected $table = "instalacao";

    protected $fillable = [
        "codigo",
        "nome",
        "ativo"
    ];
}
