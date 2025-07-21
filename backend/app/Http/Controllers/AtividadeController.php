<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAtividadeRequest;
use Illuminate\Support\Facades\Log;

use App\Models\Atividade;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/atividade",
 *     summary="Listar atividades",
 *     description="Retorna a lista de todas as atividades cadastradas.",
 *     operationId="listarAtividades",
 *     tags={"Atividade"},
 *     
 *     @OA\Response(
 *         response=200,
 *         description="Lista de atividades retornada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="atividades",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="nome", type="string", example="Caminhada"),
 *                     @OA\Property(property="descricao", type="string", example="Atividade física ao ar livre"),
 *                     @OA\Property(property="imagem", type="string", example="uploads/atividade1.png"),
 *                     @OA\Property(property="ativo", type="boolean", example=true),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-16T00:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-16T00:00:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     
 *     @OA\Response(
 *         response=404,
 *         description="Nenhuma atividade encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Nenhuma atividade encontrada.")
 *         )
 *     )
 * )
 * @OA\Post(
 *     path="/api/atividade",
 *     tags={"Atividade"},
 *     summary="Cria uma nova Atividade",
 *     description="Endpoint para cadastrar uma nova Atividade com upload de ícone.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"codigo", "nome", "icone", "ativo"},
 *             @OA\Property(property="codigo", type="string", example="ADM", description="Código único da Atividade"),
 *             @OA\Property(property="nome", type="string", example="Administrador", description="Nome da Atividade"),
 *             @OA\Property(property="icone", type="blob", format="binary", description="Arquivo de ícone (jpeg, jpg, png, svg)"),
 *             @OA\Property(property="ativo", type="boolean", example=true, description="Se a Atividade está ativa")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Atividade criada com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Atividade criada sucesso!"),
 *             @OA\Property(
 *                 property="atividade",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="codigo", type="string", example="ADM"),
 *                 @OA\Property(property="nome", type="string", example="Administrador"),
 *                 @OA\Property(property="icone", type="string", example="adm.svg"),
 *                 @OA\Property(property="ativo", type="boolean", example=true),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-16T12:00:00Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-16T12:00:00Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erros de validação",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="O campo nome deve ser informado."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
 */

class AtividadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $atividades = Atividade::get();
        
        if ($atividades->isEmpty()) {
            
            return response()->json([
                "success" => false,
                "message" => "Nenhuma atividade encontrada."
            ], 404);
        }


        return response()->json([
            "success"    => true,
            "atividades" => $atividades
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
    public function store(StoreAtividadeRequest $request)
    {
        // Log::info("teste controller AtividadeController@store");


        // Log::info('Recebendo POST em FuncaoController@store', [
        //     'request' => $request->all(),
        //     'files' => $request->file('icone')
        // ]);

        
        $validated = $request->validated();

        // Log::info("Dados validados: " . json_encode($validated));

        $atividade = Atividade::create([
            "codigo" => $validated["codigo"],
            "nome"   => $validated["nome"],
            "icone"  => $validated["icone"],
            "ativo"  => $validated["ativo"],
        ]);

        // Log::info("Função criada: " . json_encode($atividade));

        return response()->json([
            'status'  => true,
            'message' => "Função criada sucesso!",
            'atividade'  => $atividade
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Atividade $atividade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Atividade $atividade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Atividade $atividade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atividade $atividade)
    {
        //
    }
}
