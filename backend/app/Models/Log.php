<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'id_usuario',
        'entidade',
        'entidade_id',
        'operacao',
        'campo_alterado',
        'valor_anterior',
        'valor_novo',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
