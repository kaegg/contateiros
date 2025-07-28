<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Local;

class Atividade extends Model
{
    protected $table = "atividade";

    protected $fillable = [
        "codigo",
        "nome",
        "icone",
        "ativo"
    ];

    // Relacionamento com locais (muitos para muitos através da tabela intermediária)
    public function locais()
    {
        return $this->belongsToMany(Local::class, 'local_atividade', 'id_atividade', 'id_local')
                    ->withPivot('ativo')
                    ->withTimestamps();
    }
}
