<?php

namespace App\Http\Controllers;

use App\Models\Funcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *     path="/api/funcao",
 *     tags={"Função"},
 *     summary="Lista todas as funções ativas",
 *     description="Retorna todas as funções cadastradas que estão ativas.",
 *     @OA\Response(
 *         response=200,
 *         description="Funções ativas encontradas",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="funcoes",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="nome", type="string", example="Diretor"),
 *                     @OA\Property(property="ativo", type="boolean", example=true),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-01T03:13:59.000000Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-01T03:13:59.000000Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Nenhuma função encontrada",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Nenhuma função encontrada.")
 *         )
 *     )
 * )
 */

class FuncaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Log::info("Entrou na funcao index.");

        $funcoes = Funcao::where('ativo', true)->get();
        
        if ($funcoes->isEmpty()) {
            
            return response()->json([
                "success" => false,
                "message" => "Nenhuma função encontrada."
            ], 404);
        }

        // Log::info("Funções encontradas: " . $funcoes->count());

        return response()->json([
            "success" => true,
            "funcoes" => $funcoes
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Funcao $funcao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Funcao $funcao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Funcao $funcao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Funcao $funcao)
    {
        //
    }
}
