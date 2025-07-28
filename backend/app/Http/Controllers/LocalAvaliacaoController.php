<?php

namespace App\Http\Controllers;

use App\Models\LocalAvaliacao;
use App\Models\Local;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocalAvaliacaoRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/local/{local}/avaliacoes",
 *     tags={"Local Avaliação"},
 *     summary="Lista todas as avaliações ativas de um local",
 *     @OA\Parameter(
 *         name="local",
 *         in="path",
 *         required=true,
 *         description="ID do local",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Avaliações encontradas",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="avaliacoes",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="id_local", type="integer"),
 *                     @OA\Property(property="id_usuario", type="integer"),
 *                     @OA\Property(property="avaliacao", type="integer"),
 *                     @OA\Property(property="comentario", type="string"),
 *                     @OA\Property(property="ativo", type="boolean"),
 *                     @OA\Property(property="created_at", type="string", format="date-time"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time"),
 *                     @OA\Property(property="usuario", type="object")
 *                 )
 *             )
 *         )
 *     )
 * )
 * @OA\Post(
 *     path="/api/local-avaliacao",
 *     tags={"Local Avaliação"},
 *     summary="Cria uma avaliação para um local",
 *     requestBody=@OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id_local", "id_usuario", "avaliacao"},
 *             @OA\Property(property="id_local", type="integer"),
 *             @OA\Property(property="id_usuario", type="integer"),
 *             @OA\Property(property="avaliacao", type="integer"),
 *             @OA\Property(property="comentario", type="string"),
 *             @OA\Property(property="ativo", type="boolean")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Avaliação criada com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(
 *                 property="avaliacao",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="id_local", type="integer"),
 *                 @OA\Property(property="id_usuario", type="integer"),
 *                 @OA\Property(property="avaliacao", type="integer"),
 *                 @OA\Property(property="comentario", type="string"),
 *                 @OA\Property(property="ativo", type="boolean"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     )
 * )
 * @OA\Put(
 *     path="/api/local-avaliacao/{localAvaliacao}",
 *     tags={"Local Avaliação"},
 *     summary="Atualiza uma avaliação de um local",
 *     requestBody=@OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"avaliacao"},
 *             @OA\Property(property="avaliacao", type="integer"),
 *             @OA\Property(property="comentario", type="string"),
 *             @OA\Property(property="ativo", type="boolean")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Avaliação atualizada com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 * @OA\Delete(
 *     path="/api/local-avaliacao/{localAvaliacao}",
 *     tags={"Local Avaliação"},
 *     summary="Desativa uma avaliação de um local",
 *     @OA\Response(
 *         response=200,
 *         description="Avaliação desativada com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

class LocalAvaliacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Local $local)
    {
        // Buscar apenas avaliações ativas do local
        $avaliacoes = $local->avaliacoes()->where('ativo', true)->with('usuario')->get();

        if ($avaliacoes->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "Nenhuma avaliação encontrada para este local."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "avaliacoes"  => $avaliacoes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocalAvaliacaoRequest $request)
    {
        $validated = $request->validated();

        // Verificar se o usuário já avaliou este local
        $existingAvaliacao = LocalAvaliacao::where('id_local', $validated['id_local'])
                                           ->where('id_usuario', $validated['id_usuario'])
                                           ->first();

        if ($existingAvaliacao) {
            // Se já existe, atualizar a avaliação
            $existingAvaliacao->update([
                'avaliacao' => $validated['avaliacao'],
                'comentario' => $validated['comentario'] ?? $existingAvaliacao->comentario,
                'ativo' => true,
            ]);

            return response()->json([
                'status'  => true,
                'message' => "Avaliação atualizada com sucesso!",
                'avaliacao' => $existingAvaliacao
            ], 200);
        }

        // Criar nova avaliação
        $avaliacao = LocalAvaliacao::create([
            "id_local" => $validated["id_local"],
            "id_usuario" => $validated["id_usuario"],
            "avaliacao" => $validated["avaliacao"],
            "comentario" => $validated["comentario"] ?? null,
            "ativo" => $validated["ativo"] ?? true,
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Avaliação criada com sucesso!",
            'avaliacao' => $avaliacao
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLocalAvaliacaoRequest $request, LocalAvaliacao $localAvaliacao)
    {
        $validated = $request->validated();

        $localAvaliacao->update([
            'avaliacao' => $validated['avaliacao'],
            'comentario' => $validated['comentario'] ?? $localAvaliacao->comentario,
            'ativo' => $validated['ativo'] ?? $localAvaliacao->ativo,
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Avaliação atualizada com sucesso!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocalAvaliacao $localAvaliacao)
    {
        // Exclusão lógica - apenas desativa a avaliação
        $localAvaliacao->ativo = false;
        $localAvaliacao->save();

        return response()->json([
            'status'  => true,
            'message' => "Avaliação desativada com sucesso!"
        ], 200);
    }
}
