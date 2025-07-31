<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\LocalAtividade;
use App\Models\LocalInstalacao;
use App\Models\Atividade;
use App\Models\Instalacao;
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
 *             @OA\Property(property="ativo", type="boolean"),
 *             @OA\Property(property="atividades", type="array", @OA\Items(type="integer"), description="IDs das atividades"),
 *             @OA\Property(property="instalacoes", type="array", @OA\Items(type="integer"), description="IDs das instalações")
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
 *             @OA\Property(property="ativo", type="boolean"),
 *             @OA\Property(property="atividades", type="array", @OA\Items(type="integer"), description="IDs das atividades"),
 *             @OA\Property(property="instalacoes", type="array", @OA\Items(type="integer"), description="IDs das instalações")
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
        
        Log::info('Dados recebidos para criar local:', $validated);

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

        Log::info('Local criado com ID: ' . $local->id);

        // Associar atividades se fornecidas
        if (isset($validated['atividades']) && is_array($validated['atividades'])) {
            Log::info('Associando atividades:', $validated['atividades']);
            foreach ($validated['atividades'] as $atividadeId) {
                // Verificar se a atividade existe
                $atividade = Atividade::find($atividadeId);
                if ($atividade) {
                    $local->atividades()->attach($atividadeId, ['ativo' => true]);
                    Log::info('Atividade ' . $atividadeId . ' associada com sucesso');
                } else {
                    Log::warning('Atividade ' . $atividadeId . ' não encontrada');
                }
            }
        }

        // Associar instalações se fornecidas
        if (isset($validated['instalacoes']) && is_array($validated['instalacoes'])) {
            Log::info('Associando instalações:', $validated['instalacoes']);
            foreach ($validated['instalacoes'] as $instalacaoId) {
                // Verificar se a instalação existe
                $instalacao = Instalacao::find($instalacaoId);
                if ($instalacao) {
                    $local->instalacoes()->attach($instalacaoId, ['ativo' => true]);
                    Log::info('Instalação ' . $instalacaoId . ' associada com sucesso');
                } else {
                    Log::warning('Instalação ' . $instalacaoId . ' não encontrada');
                }
            }
        }

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

        // Atualizar atividades se fornecidas
        if (isset($validated['atividades'])) {
            // Desativar todas as associações existentes
            $local->atividades()->updateExistingPivot($local->atividades->pluck('id')->toArray(), ['ativo' => false]);
            
            // Ativar apenas as atividades fornecidas
            if (is_array($validated['atividades'])) {
                foreach ($validated['atividades'] as $atividadeId) {
                    // Verificar se a associação já existe
                    $existingAssociation = LocalAtividade::where('id_local', $local->id)
                                                         ->where('id_atividade', $atividadeId)
                                                         ->first();
                    if ($existingAssociation) {
                        // Se existe, apenas ativar
                        $existingAssociation->ativo = true;
                        $existingAssociation->save();
                    } else {
                        // Se não existe, criar nova
                        $local->atividades()->attach($atividadeId, ['ativo' => true]);
                    }
                }
            }
        }

        // Atualizar instalações se fornecidas
        if (isset($validated['instalacoes'])) {
            // Desativar todas as associações existentes
            $local->instalacoes()->updateExistingPivot($local->instalacoes->pluck('id')->toArray(), ['ativo' => false]);
            
            // Ativar apenas as instalações fornecidas
            if (is_array($validated['instalacoes'])) {
                foreach ($validated['instalacoes'] as $instalacaoId) {
                    // Verificar se a associação já existe
                    $existingAssociation = LocalInstalacao::where('id_local', $local->id)
                                                          ->where('id_instalacao', $instalacaoId)
                                                          ->first();
                    if ($existingAssociation) {
                        // Se existe, apenas ativar
                        $existingAssociation->ativo = true;
                        $existingAssociation->save();
                    } else {
                        // Se não existe, criar nova
                        $local->instalacoes()->attach($instalacaoId, ['ativo' => true]);
                    }
                }
            }
        }

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
        try {
            Log::info('Tentando inativar local', ['local_id' => $local->id, 'nome' => $local->nome]);
            
            // Exclusão lógica - apenas desativa o local
            $local->ativo = false;
            $local->save();
            
            Log::info('Local inativado com sucesso', ['local_id' => $local->id]);
            
            return response()->json([
                'status'  => true,
                'message' => "Local desativado com sucesso!"
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao inativar local', [
                'local_id' => $local->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => false,
                'message' => 'Erro ao inativar local: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Busca as imagens de um local
     */
    public function getImages(Local $local)
    {
        $imagens = $local->imagens()->where('ativo', true)->get();
        
        return response()->json([
            'success' => true,
            'imagens' => $imagens->map(function($imagem) {
                return [
                    'id' => $imagem->id,
                    'url' => url("/api/local-imagem/{$imagem->id}")
                ];
            })
        ]);
    }

    /**
     * Busca as atividades de um local
     */
    public function getActivities(Local $local)
    {
        $atividades = $local->atividades()->where('ativo', true)->get();
        
        return response()->json([
            'success' => true,
            'atividades' => $atividades
        ]);
    }

    /**
     * Busca as instalações de um local
     */
    public function getFacilities(Local $local)
    {
        $instalacoes = $local->instalacoes()->where('ativo', true)->get();
        
        return response()->json([
            'success' => true,
            'instalacoes' => $instalacoes
        ]);
    }

    /**
     * Busca as avaliações de um local
     */
    public function getRatings(Local $local)
    {
        $avaliacoes = $local->avaliacoes()->where('ativo', true)->with('usuario')->get();
        
        return response()->json([
            'success' => true,
            'avaliacoes' => $avaliacoes
        ]);
    }
}
