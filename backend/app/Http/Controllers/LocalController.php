<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocalRequest;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *     path="/api/local",
 *     tags={"Local"},
 *     summary="Lista todos os locais",
 *     description="Retorna todos os locais cadastrados no sistema.",
 *     @OA\Response(
 *         response=200,
 *         description="Locais encontrados",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="locais",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="nome", type="string", example="Sala de Reuniões"),
 *                     @OA\Property(property="cidade", type="string", example="Curitiba"),
 *                     @OA\Property(property="estado", type="string", example="PR"),
 *                     @OA\Property(property="nome_proprietario", type="string", example="João Silva"),
 *                     @OA\Property(property="telefone_proprietario", type="string", example="+5541999999999"),
 *                     @OA\Property(property="descricao", type="string", example="Sala equipada para reuniões"),
 *                     @OA\Property(property="capacidade_pessoas", type="integer", example=20),
 *                     @OA\Property(property="id_usuario_criacao", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-28T00:00:00.000000Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-28T00:00:00.000000Z"),
 *                     @OA\Property(property="id_usuario_alteracao", type="integer", example=1),
 *                     @OA\Property(property="ativo", type="boolean", example=true)
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Nenhum local encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Nenhum local encontrado.")
 *         )
 *     )
 * )
 * @OA\Post(
 *     path="/api/local",
 *     tags={"Local"},
 *     summary="Cria um novo local",
 *     requestBody=@OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nome", "cidade", "estado", "nome_proprietario", "telefone_proprietario", "capacidade_pessoas", "id_usuario_criacao", "ativo"},
 *             @OA\Property(property="nome", type="string"),
 *             @OA\Property(property="cidade", type="string"),
 *             @OA\Property(property="estado", type="string"),
 *             @OA\Property(property="nome_proprietario", type="string"),
 *             @OA\Property(property="telefone_proprietario", type="string"),
 *             @OA\Property(property="descricao", type="string"),
 *             @OA\Property(property="capacidade_pessoas", type="integer"),
 *             @OA\Property(property="id_usuario_criacao", type="integer"),
 *             @OA\Property(property="id_usuario_alteracao", type="integer"),
 *             @OA\Property(property="ativo", type="boolean")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Local criado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(
 *                 property="local",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="nome", type="string"),
 *                 @OA\Property(property="cidade", type="string"),
 *                 @OA\Property(property="estado", type="string"),
 *                 @OA\Property(property="nome_proprietario", type="string"),
 *                 @OA\Property(property="telefone_proprietario", type="string"),
 *                 @OA\Property(property="descricao", type="string"),
 *                 @OA\Property(property="capacidade_pessoas", type="integer"),
 *                 @OA\Property(property="id_usuario_criacao", type="integer"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time"),
 *                 @OA\Property(property="id_usuario_alteracao", type="integer"),
 *                 @OA\Property(property="ativo", type="boolean")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erros de validação",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="O nome do local deve ser informado."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
 * @OA\Put(
 *     path="/api/local/{local}",
 *     tags={"Local"},
 *     summary="Atualiza um local existente",
 *     requestBody=@OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nome", "cidade", "estado", "nome_proprietario", "telefone_proprietario", "capacidade_pessoas", "id_usuario_alteracao", "ativo"},
 *             @OA\Property(property="nome", type="string"),
 *             @OA\Property(property="cidade", type="string"),
 *             @OA\Property(property="estado", type="string"),
 *             @OA\Property(property="nome_proprietario", type="string"),
 *             @OA\Property(property="telefone_proprietario", type="string"),
 *             @OA\Property(property="descricao", type="string"),
 *             @OA\Property(property="capacidade_pessoas", type="integer"),
 *             @OA\Property(property="id_usuario_alteracao", type="integer"),
 *             @OA\Property(property="ativo", type="boolean")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Local atualizado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(
 *                 property="local",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="nome", type="string"),
 *                 @OA\Property(property="cidade", type="string"),
 *                 @OA\Property(property="estado", type="string"),
 *                 @OA\Property(property="nome_proprietario", type="string"),
 *                 @OA\Property(property="telefone_proprietario", type="string"),
 *                 @OA\Property(property="descricao", type="string"),
 *                 @OA\Property(property="capacidade_pessoas", type="integer"),
 *                 @OA\Property(property="id_usuario_criacao", type="integer"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time"),
 *                 @OA\Property(property="id_usuario_alteracao", type="integer"),
 *                 @OA\Property(property="ativo", type="boolean")
 *             )
 *         )
 *     )
 * )
 * @OA\Delete(
 *     path="/api/local/{local}",
 *     tags={"Local"},
 *     summary="Desativa um local (exclusão lógica)",
 *     @OA\Response(
 *         response=200,
 *         description="Local desativado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

class LocalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Buscar apenas locais ativos com todos os relacionamentos ativos
        $locais = Local::where('ativo', true)
                      ->with([
                          'usuarioCriacao', 
                          'usuarioAlteracao',
                          'imagens' => function($query) {
                              $query->where('ativo', true);
                          },
                          'atividades' => function($query) {
                              $query->wherePivot('ativo', true);
                          },
                          'instalacoes' => function($query) {
                              $query->wherePivot('ativo', true);
                          },
                          'avaliacoes' => function($query) {
                              $query->where('ativo', true);
                          },
                          'avaliacoes.usuario'
                      ])
                      ->get();

        if ($locais->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "Nenhum local encontrado."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "locais"  => $locais
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocalRequest $request)
    {
        $validated = $request->validated();

        $local = Local::create([
            "nome" => $validated["nome"],
            "cidade" => $validated["cidade"],
            "estado" => $validated["estado"],
            "nome_proprietario" => $validated["nome_proprietario"],
            "telefone_proprietario" => $validated["telefone_proprietario"],
            "descricao" => $validated["descricao"] ?? null,
            "capacidade_pessoas" => $validated["capacidade_pessoas"],
            "id_usuario_criacao" => $validated["id_usuario_criacao"],
            "id_usuario_alteracao" => $validated["id_usuario_alteracao"] ?? null,
            "ativo" => $validated["ativo"],
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Local criado com sucesso!",
            'local' => $local
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Local $local)
    {
        // Carregar todos os relacionamentos ativos
        $local->load([
            'usuarioCriacao', 
            'usuarioAlteracao',
            'imagens' => function($query) {
                $query->where('ativo', true);
            },
            'atividades' => function($query) {
                $query->wherePivot('ativo', true);
            },
            'instalacoes' => function($query) {
                $query->wherePivot('ativo', true);
            },
            'avaliacoes' => function($query) {
                $query->where('ativo', true);
            },
            'avaliacoes.usuario'
        ]);

        return response()->json([
            "success" => true,
            "local"  => $local
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Local $local)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLocalRequest $request, Local $local)
    {
        $validated = $request->validated();

        $local->update([
            "nome" => $validated["nome"],
            "cidade" => $validated["cidade"],
            "estado" => $validated["estado"],
            "nome_proprietario" => $validated["nome_proprietario"],
            "telefone_proprietario" => $validated["telefone_proprietario"],
            "descricao" => $validated["descricao"] ?? null,
            "capacidade_pessoas" => $validated["capacidade_pessoas"],
            "id_usuario_alteracao" => $validated["id_usuario_alteracao"] ?? null,
            "ativo" => $validated["ativo"],
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Local atualizado com sucesso!",
            'local' => $local
        ], 200);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Local $local)
    {
        // Exclusão lógica em cascata - desativa o local e todos os registros relacionados
        $local->desativarComCascata();

        return response()->json([
            'status'  => true,
            'message' => "Local e todos os registros relacionados desativados com sucesso!"
        ], 200);
    }
}
