<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAtividadeRequest;
use App\Services\LogService;

use App\Models\Atividade;

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
        $validated = $request->validated();

        // Processar o arquivo de ícone como base64
        $iconeFile = $request->file('icone');
        $iconeBase64 = null;
        
        if ($iconeFile) {
            $mimeType = $iconeFile->getMimeType(); // image/png
            $iconeContent = file_get_contents($iconeFile->getRealPath());
            $iconeBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($iconeContent);
        }

        $atividade = Atividade::create([
            "codigo" => $validated["codigo"],
            "nome"   => $validated["nome"],
            "icone"  => $iconeBase64,
            "ativo"  => $validated["ativo"],
        ]);

        // Registrar log de criação
        LogService::criacao('atividade', $atividade->id);

        return response()->json([
            'status'  => true,
            'message' => "Atividade criada com sucesso!",
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
    public function update(StoreAtividadeRequest $request, Atividade $atividade)
    {
        $validated = $request->validated();

        // Processar o arquivo de ícone como base64 se fornecido
        $iconeBase64 = $atividade->icone; // Manter o ícone atual por padrão
        
        if ($request->hasFile('icone')) {
            $iconeFile = $request->file('icone');
            $mimeType = $iconeFile->getMimeType();
            $iconeContent = file_get_contents($iconeFile->getRealPath());
            $iconeBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($iconeContent);
        }

        $atividade->update([
            "codigo" => $validated["codigo"],
            "nome"   => $validated["nome"],
            "icone"  => $iconeBase64,
            "ativo"  => $validated["ativo"],
        ]);

        // Registrar log de edição
        LogService::edicao('atividade', $atividade->id, 'dados', 'anterior', 'novo');

        return response()->json([
            'status'  => true,
            'message' => "Atividade atualizada com sucesso!",
            'atividade' => $atividade
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atividade $atividade)
    {
        $atividade->ativo = false;
        $atividade->save();

        // Registrar log de inativação
        LogService::inativacao('atividade', $atividade->id);

        return response()->json([
            'status'  => true,
            'message' => "Atividade inativada com sucesso!",
            'atividade' => $atividade
        ], 200);
    }

    /**
     * Activate the specified resource from storage.
     */
    public function ativar(Atividade $atividade)
    {
        $atividade->ativo = true;
        $atividade->save();

        // Registrar log de ativação
        LogService::ativacao('atividade', $atividade->id);

        return response()->json([
            'status'  => true,
            'message' => "Atividade ativada com sucesso!",
            'atividade' => $atividade
        ], 200);
    }
}
