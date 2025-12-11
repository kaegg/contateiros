<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
    /**
     * Registra uma ação no log
     */
    public static function registrar(
        string $entidade,
        int $entidadeId,
        string $operacao,
        ?string $campoAlterado = null,
        ?string $valorAnterior = null,
        ?string $valorNovo = null
    ): Log {
        $userId = session('user_id');

        return Log::create([
            'id_usuario' => $userId,
            'entidade' => $entidade,
            'entidade_id' => $entidadeId,
            'operacao' => $operacao,
            'campo_alterado' => $campoAlterado,
            'valor_anterior' => $valorAnterior,
            'valor_novo' => $valorNovo,
        ]);
    }

    /**
     * Registra uma criação
     */
    public static function criacao(string $entidade, int $entidadeId): void
    {
        self::registrar($entidade, $entidadeId, 'criacao');
    }

    /**
     * Registra uma edição
     */
    public static function edicao(
        string $entidade,
        int $entidadeId,
        string $campoAlterado,
        string $valorAnterior,
        string $valorNovo
    ): void {
        self::registrar($entidade, $entidadeId, 'edicao', $campoAlterado, $valorAnterior, $valorNovo);
    }

    /**
     * Registra uma inativação
     */
    public static function inativacao(string $entidade, int $entidadeId): void
    {
        self::registrar($entidade, $entidadeId, 'inativacao');
    }

    /**
     * Registra uma ativação
     */
    public static function ativacao(string $entidade, int $entidadeId): void
    {
        self::registrar($entidade, $entidadeId, 'ativacao');
    }
}
