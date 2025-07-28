<?php

namespace App\Http\Controllers;

use App\Models\LocalAtividade;
use App\Models\Local;
use App\Models\Atividade;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocalAtividadeRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/local/{local}/atividades",
 *     tags={"Local Atividade"},
 *     summary="Lista todas as atividades ativas de um local",
 *     @OA\Parameter(
 *         name="local",
 *         in="path",
 *         required=true,
 *         description="ID do local",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Atividades encontradas",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="atividades",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="codigo", type="string"),
 *                     @OA\Property(property="nome", type="string"),
 *                     @OA\Property(property="icone", type="string"),
 *                     @OA\Property(property="ativo", type="boolean"),
 *                     @OA\Property(property="pivot", type="object")
 *                 )
 *             )
 *         )
 *     )
 * )
 * @OA\Post(
 *     path="/api/local-atividade",
 *     tags={"Local Atividade"},
 *     summary="Associa uma atividade a um local",
 *     requestBody=@OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id_local", "id_atividade"},
 *             @OA\Property(property="id_local", type="integer"),
 *             @OA\Property(property="id_atividade", type="integer"),
 *             @OA\Property(property="ativo", type="boolean")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Atividade associada com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 * @OA\Delete(
 *     path="/api/local-atividade/{localAtividade}",
 *     tags={"Local Atividade"},
 *     summary="Desativa a associação de uma atividade a um local",
 *     @OA\Response(
 *         response=200,
 *         description="Associação desativada com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

class LocalAtividadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Local $local)
    {
        // Buscar apenas atividades ativas associadas ao local
        $atividades = $local->atividades()->wherePivot('ativo', true)->get();

        if ($atividades->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "Nenhuma atividade encontrada para este local."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "atividades"  => $atividades
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocalAtividadeRequest $request)
    {
        $validated = $request->validated();

        // Verificar se a associação já existe
        $existingAssociation = LocalAtividade::where('id_local', $validated['id_local'])
                                           ->where('id_atividade', $validated['id_atividade'])
                                           ->first();

        if ($existingAssociation) {
            // Se existe, apenas ativar
            $existingAssociation->ativo = true;
            $existingAssociation->save();

            return response()->json([
                'status'  => true,
                'message' => "Associação reativada com sucesso!"
            ], 200);
        }

        // Criar nova associação
        LocalAtividade::create([
            "id_local" => $validated["id_local"],
            "id_atividade" => $validated["id_atividade"],
            "ativo" => $validated["ativo"] ?? true,
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Atividade associada com sucesso!"
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocalAtividade $localAtividade)
    {
        // Exclusão lógica - apenas desativa a associação
        $localAtividade->ativo = false;
        $localAtividade->save();

        return response()->json([
            'status'  => true,
            'message' => "Associação desativada com sucesso!"
        ], 200);
    }
}
