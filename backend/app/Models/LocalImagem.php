<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Local;

class LocalImagem extends Model
{
    protected $table = "local_imagem";

    protected $fillable = [
        "id_local",
        "imagem",
        "ativo",
    ];

    public function local()
    {
        return $this->belongsTo(Local::class, 'id_local');
    }
}
