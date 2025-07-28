<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Atividade;
use App\Models\Instalacao;

class Local extends Model
{
    protected $table = "local";

    protected $fillable = [
        "nome",
        "cidade",
        "estado",
        "nome_proprietario",
        "telefone_proprietario",
        "descricao",
        "capacidade_pessoas",
        "id_usuario_criacao",
        "id_usuario_alteracao",
        "ativo",
    ];

    public function usuarioCriacao()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_criacao');
    }
    
    public function usuarioAlteracao()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_alteracao');
    }

    // Relacionamento com imagens (1 para muitos)
    public function imagens()
    {
        return $this->hasMany(LocalImagem::class, 'id_local');
    }

    // Relacionamento com atividades (muitos para muitos através da tabela intermediária)
    public function atividades()
    {
        return $this->belongsToMany(Atividade::class, 'local_atividade', 'id_local', 'id_atividade')
                    ->withPivot('ativo')
                    ->withTimestamps();
    }

    // Relacionamento com instalações (muitos para muitos através da tabela intermediária)
    public function instalacoes()
    {
        return $this->belongsToMany(Instalacao::class, 'local_instalacao', 'id_local', 'id_instalacao')
                    ->withPivot('ativo')
                    ->withTimestamps();
    }

    // Relacionamento com avaliações (1 para muitos)
    public function avaliacoes()
    {
        return $this->hasMany(LocalAvaliacao::class, 'id_local');
    }

    // Relacionamento com usuários que avaliaram (muitos para muitos através da tabela intermediária)
    public function usuariosAvaliadores()
    {
        return $this->belongsToMany(Usuario::class, 'local_avaliacao', 'id_local', 'id_usuario')
                    ->withPivot('avaliacao', 'comentario')
                    ->withTimestamps();
    }

    /**
     * Implementa exclusão lógica em cascata
     * Desativa o local e todos os registros relacionados
     */
    public function desativarComCascata()
    {
        // Desativa o local
        $this->ativo = false;
        $this->save();

        // Desativa todas as imagens do local
        $this->imagens()->update(['ativo' => false]);

        // Desativa todas as relações de atividades
        $this->atividades()->updateExistingPivot($this->atividades->pluck('id')->toArray(), ['ativo' => false]);

        // Desativa todas as relações de instalações
        $this->instalacoes()->updateExistingPivot($this->instalacoes->pluck('id')->toArray(), ['ativo' => false]);

        // Desativa todas as avaliações do local
        $this->avaliacoes()->update(['ativo' => false]);

        return true;
    }

    /**
     * Boot do modelo para implementar exclusão em cascata automática
     */
    protected static function boot()
    {
        parent::boot();

        // Quando um local for desativado, desativar todos os registros relacionados
        static::updating(function ($local) {
            if ($local->isDirty('ativo') && $local->ativo === false) {
                $local->desativarComCascata();
            }
        });
    }
}
