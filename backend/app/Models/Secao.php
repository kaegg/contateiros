<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secao extends Model
{
    protected $table = "secao";

    protected $fillable = [
        "nome",
        "ativo"
    ];
}
