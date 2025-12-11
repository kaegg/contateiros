<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Funcao;
use App\Models\Secao;

class Usuario extends Model
{   
    protected $table = "usuario";

    protected $fillable = [
        "nome",
        "usuario",
        "email",
        "telefone",
        "password",
        "id_funcao",
        "id_secao",
        "ativo",
    ];

    /**
     * Hide sensitive fields from array / JSON conversion
     */
    protected $hidden = [
        'password',
    ];

    public function funcao()
    {
        return $this->belongsTo(Funcao::class, 'id_funcao'); // Como não segue o padrao do laravel de nome_da_model, tem que dizer qual a chave estrangeira
    }
    
    public function secao()
    {
        return $this->belongsTo(Secao::class, 'id_secao');
    }

    // Relacionamento com locais criados
    public function locaisCriados()
    {
        return $this->hasMany(Local::class, 'id_usuario_criacao');
    }

    // Relacionamento com locais alterados
    public function locaisAlterados()
    {
        return $this->hasMany(Local::class, 'id_usuario_alteracao');
    }

    // Relacionamento com avaliações feitas
    public function avaliacoes()
    {
        return $this->hasMany(LocalAvaliacao::class, 'id_usuario');
    }

    // Relacionamento com locais avaliados (muitos para muitos através da tabela intermediária)
    public function locaisAvaliados()
    {
        return $this->belongsToMany(Local::class, 'local_avaliacao', 'id_usuario', 'id_local')
                    ->withPivot('avaliacao', 'comentario')
                    ->withTimestamps();
    }
}