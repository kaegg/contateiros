<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Local;
use App\Models\Usuario;

class LocalAvaliacao extends Model
{
    protected $table = "local_avaliacao";

    protected $fillable = [
        "id_local",
        "id_usuario",
        "avaliacao",
        "comentario",
        "ativo",
    ];

    public function local()
    {
        return $this->belongsTo(Local::class, 'id_local');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
