<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUsuarioRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/usuario",
 *     tags={"Usuario"},
 *     summary="Cria um novo usuário",
 *     requestBody=@OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nome", "usuario", "email", "telefone", "id_funcao", "id_secao", "ativo"},
 *             @OA\Property(property="nome", type="string"),
 *             @OA\Property(property="usuario", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="telefone", type="string"),
 *             @OA\Property(property="id_funcao", type="integer"),
 *             @OA\Property(property="id_secao", type="integer"),
 *             @OA\Property(property="ativo", type="boolean")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Usuário criado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(
 *                 property="usuario",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="nome", type="string"),
 *                 @OA\Property(property="usuario", type="string"),
 *                 @OA\Property(property="email", type="string"),
 *                 @OA\Property(property="telefone", type="string"),
 *                 @OA\Property(property="id_funcao", type="integer"),
 *                 @OA\Property(property="id_secao", type="integer"),
 *                 @OA\Property(property="ativo", type="boolean"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     )
 * )
 */

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreUsuarioRequest $request)
    {
        $validated = $request->validated();

        $usuario = Usuario::create([
            "nome"      => $validated["nome"],
            "usuario"   => $validated["usuario"],
            "email"     => $validated["email"],
            "telefone"  => $validated["telefone"],
            "id_funcao" => $validated["id_funcao"],
            "id_secao"  => $validated["id_secao"],
            "ativo"     => $validated["ativo"],
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Usuário criado sucesso!",
            'usuario' => $usuario
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
