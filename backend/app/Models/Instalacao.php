<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Local;

class Instalacao extends Model
{
    protected $table = "instalacao";

    protected $fillable = [
        "codigo",
        "nome",
        "ativo"
    ];

    // Relacionamento com locais (muitos para muitos através da tabela intermediária)
    public function locais()
    {
        return $this->belongsToMany(Local::class, 'local_instalacao', 'id_instalacao', 'id_local')
                    ->withPivot('ativo')
                    ->withTimestamps();
    }
}
