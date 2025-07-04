<?php

namespace App\Http\Controllers;

use App\Models\Funcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FuncaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Log::info("Entrou na funcao index.");

        $funcoes = Funcao::all();
        
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
