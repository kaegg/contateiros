<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Local;
use App\Models\Instalacao;

class LocalInstalacao extends Model
{
    protected $table = "local_instalacao";

    protected $fillable = [
        "id_local",
        "id_instalacao",
        "ativo",
    ];

    public function local()
    {
        return $this->belongsTo(Local::class, 'id_local');
    }

    public function instalacao()
    {
        return $this->belongsTo(Instalacao::class, 'id_instalacao');
    }
}
