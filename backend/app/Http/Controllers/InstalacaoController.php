<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstalacaoRequest;
use App\Models\Instalacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstalacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instalacoes = Instalacao::get();
        
        // Log para debug
        Log::info('Instalações encontradas: ' . $instalacoes->count());
        
        if ($instalacoes->isEmpty()) {
            Log::warning('Nenhuma instalação ativa encontrada no banco');
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
    public function update(StoreInstalacaoRequest $request, Instalacao $instalacao)
    {
        $validated = $request->validated();
        
        $instalacao->update([
            'codigo' => $validated['codigo'],
            'nome' => $validated['nome'],
            'ativo' => $validated['ativo'] ?? true,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Instalação atualizada com sucesso!',
            'instalacao' => $instalacao
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instalacao $instalacao)
    {
        $instalacao->ativo = false;
        $instalacao->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Instalação inativada com sucesso!'
        ]);
    }

    /**
     * Activate the specified resource from storage.
     */
    public function ativar(Instalacao $instalacao)
    {
        $instalacao->ativo = true;
        $instalacao->save();

        return response()->json([
            'success' => true,
            'message' => 'Instalação ativada com sucesso!'
        ]);
    }
}
