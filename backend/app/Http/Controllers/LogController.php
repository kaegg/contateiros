<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the logs.
     */
    public function index()
    {
        try {
            // Buscar logs com relação de usuário, ordenados por data decrescente
            $logs = Log::with('usuario')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'usuario' => $log->usuario->nome,
                        'data' => $log->created_at->format('d/m/Y H:i'),
                        'campo' => $log->campo_alterado,
                        'tipo' => $this->formatarTipo($log),
                        'tipoClass' => $this->getTipoClass($log->operacao),
                    ];
                });

            if ($logs->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhum log encontrado.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'logs' => $logs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar logs: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Formata o tipo de operação em formato legível
     */
    private function formatarTipo(Log $log): string
    {
        $entidade = ucfirst($log->entidade);
        $operacao = match ($log->operacao) {
            'criacao' => 'Criação',
            'edicao' => 'Edição',
            'inativacao' => 'Remoção',
            'ativacao' => 'Ativação',
            default => 'Desconhecida',
        };

        return "{$operacao} de {$entidade}";
    }

    /**
     * Retorna a classe CSS para o tipo de operação
     */
    private function getTipoClass(string $operacao): string
    {
        return match ($operacao) {
            'criacao' => 'tipo-criacao',
            'edicao' => 'tipo-edicao',
            'inativacao' => 'tipo-remocao',
            'ativacao' => 'tipo-ativacao',
            default => '',
        };
    }
}
