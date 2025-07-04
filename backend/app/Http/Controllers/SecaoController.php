<?php

namespace App\Http\Controllers;

use App\Models\Secao;
use Illuminate\Http\Request;

class SecaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $secoes = Secao::all();

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
