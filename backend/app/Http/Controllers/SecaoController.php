<?php

namespace App\Http\Controllers;

use App\Models\Secao;
use Illuminate\Http\Request;

/** @OA\Get(
 *     path="/api/secao",
 *     tags={"Seção"},
 *     summary="Lista todas as seções ativas",
 *     description="Retorna todas as seções cadastradas que estão ativas.",
 *     @OA\Response(
 *         response=200,
 *         description="Seções ativas encontradas",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="secoes",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="nome", type="string", example="Seção 1"),
 *                     @OA\Property(property="ativo", type="boolean", example=true),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-01T03:13:59.000000Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-01T03:13:59.000000Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Nenhuma seção encontrada",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Nenhuma seção encontrada.")
 *         )
 *     )
 * )
 */

class SecaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $secoes = Secao::where('ativo', true)->get();

        if ($secoes->isEmpty()) {
            
            return response()->json([
                "success" => false,
                "message" => "Nenhuma seção encontrada."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "secoes"  => $secoes
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
    public function show(Secao $secao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secao $secao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Secao $secao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secao $secao)
    {
        //
    }
}
