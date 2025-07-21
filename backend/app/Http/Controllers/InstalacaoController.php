<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstalacaoRequest;
use App\Models\Instalacao;
use Illuminate\Http\Request;

class InstalacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instalacoes = Instalacao::get();
        
        if ($instalacoes->isEmpty()) {
            
            return response()->json([
                "success" => false,
                "message" => "Nenhuma instalação encontrada."
            ], 404);
        }


        return response()->json([
            "success"    => true,
            "instalacoes" => $instalacoes
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
    public function store(StoreInstalacaoRequest $request)
    {
        $validated = $request->validated();

        $instalacao = Instalacao::create([
            "codigo" => $validated["codigo"],
            "nome"   => $validated["nome"],
            "ativo"  => $validated["ativo"],
        ]);

        return response()->json([
            'status'     => true,
            'message'    => "Função criada sucesso!",
            'instalacao' => $instalacao
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Instalacao $instalacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instalacao $instalacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instalacao $instalacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instalacao $instalacao)
    {
        //
    }
}
