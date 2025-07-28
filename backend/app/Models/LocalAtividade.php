<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Local;
use App\Models\Atividade;

class LocalAtividade extends Model
{
    protected $table = "local_atividade";

    protected $fillable = [
        "id_local",
        "id_atividade",
        "ativo",
    ];

    public function local()
    {
        return $this->belongsTo(Local::class, 'id_local');
    }

    public function atividade()
    {
        return $this->belongsTo(Atividade::class, 'id_atividade');
    }
}
