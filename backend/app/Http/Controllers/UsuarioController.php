<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUsuarioRequest;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *     path="/api/usuario",
 *     tags={"Usuário"},
 *     summary="Lista todos os usuários",
 *     description="Retorna todos os usuários cadastrados no sistema.",
 *     @OA\Response(
 *         response=200,
 *         description="Usuários encontrados",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="usuarios",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="nome", type="string", example="teste"),
 *                     @OA\Property(property="usuario", type="string", example="teste"),
 *                     @OA\Property(property="email", type="string", example="teste@teste.com"),
 *                     @OA\Property(property="telefone", type="string", example="+5544991087686"),
 *                     @OA\Property(property="id_funcao", type="integer", example=1),
 *                     @OA\Property(property="id_secao", type="integer", example=1),
 *                     @OA\Property(property="ativo", type="boolean", example=true),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-01T03:14:07.000000Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-01T03:14:07.000000Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Nenhum usuário encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Nenhum usuário encontrada.")
 *         )
 *     )
 * )
 * @OA\Post(
 *     path="/api/usuario",
 *     tags={"Usuário"},
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
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erros de validação",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="O usuário deve ser informado."),
 *             @OA\Property(property="errors", type="object")
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
        $usuarios = Usuario::with(['funcao', 'secao'])->get();

        if ($usuarios->isEmpty()) {
            
            return response()->json([
                "success" => false,
                "message" => "Nenhum usuário encontrada."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "usuarios"  => $usuarios
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
    public function update(StoreUsuarioRequest $request, Usuario $usuario)
    {
        $validated = $request->validated();

        $usuario->update([
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
            'message' => "Usuário atualizado com sucesso!",
            'usuario' => $usuario
        ], 200);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->ativo = false;
        $usuario->save();

        return response()->json([
            'status'  => true,
            'message' => "Usuário inativado com sucesso!",
            'usuario' => $usuario
        ], 200);
    }

     /**
     * Activate the specified resource from storage.
     */
    public function ativar(Usuario $usuario)
    {
        $usuario->ativo = true;
        $usuario->save();

        return response()->json([
            'status'  => true,
            'message' => "Usuário ativado com sucesso!",
            'usuario' => $usuario
        ], 200);
    }
}
