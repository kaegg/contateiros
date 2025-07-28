<?php

namespace App\Http\Controllers;

use App\Models\LocalInstalacao;
use App\Models\Local;
use App\Models\Instalacao;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocalInstalacaoRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/local/{local}/instalacoes",
 *     tags={"Local Instalação"},
 *     summary="Lista todas as instalações ativas de um local",
 *     @OA\Parameter(
 *         name="local",
 *         in="path",
 *         required=true,
 *         description="ID do local",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Instalações encontradas",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="instalacoes",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="codigo", type="string"),
 *                     @OA\Property(property="nome", type="string"),
 *                     @OA\Property(property="ativo", type="boolean"),
 *                     @OA\Property(property="pivot", type="object")
 *                 )
 *             )
 *         )
 *     )
 * )
 * @OA\Post(
 *     path="/api/local-instalacao",
 *     tags={"Local Instalação"},
 *     summary="Associa uma instalação a um local",
 *     requestBody=@OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id_local", "id_instalacao"},
 *             @OA\Property(property="id_local", type="integer"),
 *             @OA\Property(property="id_instalacao", type="integer"),
 *             @OA\Property(property="ativo", type="boolean")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Instalação associada com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 * @OA\Delete(
 *     path="/api/local-instalacao/{localInstalacao}",
 *     tags={"Local Instalação"},
 *     summary="Desativa a associação de uma instalação a um local",
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

class LocalInstalacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Local $local)
    {
        // Buscar apenas instalações ativas associadas ao local
        $instalacoes = $local->instalacoes()->wherePivot('ativo', true)->get();

        if ($instalacoes->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "Nenhuma instalação encontrada para este local."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "instalacoes"  => $instalacoes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocalInstalacaoRequest $request)
    {
        $validated = $request->validated();

        // Verificar se a associação já existe
        $existingAssociation = LocalInstalacao::where('id_local', $validated['id_local'])
                                             ->where('id_instalacao', $validated['id_instalacao'])
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
        LocalInstalacao::create([
            "id_local" => $validated["id_local"],
            "id_instalacao" => $validated["id_instalacao"],
            "ativo" => $validated["ativo"] ?? true,
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Instalação associada com sucesso!"
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocalInstalacao $localInstalacao)
    {
        // Exclusão lógica - apenas desativa a associação
        $localInstalacao->ativo = false;
        $localInstalacao->save();

        return response()->json([
            'status'  => true,
            'message' => "Associação desativada com sucesso!"
        ], 200);
    }
}
