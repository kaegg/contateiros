<?php

namespace App\Http\Controllers;

use App\Models\LocalImagem;
use App\Models\Local;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocalImagemRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/local/{local}/imagens",
 *     tags={"Local Imagem"},
 *     summary="Lista todas as imagens ativas de um local",
 *     @OA\Parameter(
 *         name="local",
 *         in="path",
 *         required=true,
 *         description="ID do local",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Imagens encontradas",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="imagens",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="id_local", type="integer"),
 *                     @OA\Property(property="imagem", type="string"),
 *                     @OA\Property(property="ativo", type="boolean"),
 *                     @OA\Property(property="created_at", type="string", format="date-time"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time")
 *                 )
 *             )
 *         )
 *     )
 * )
 * @OA\Post(
 *     path="/api/local-imagem",
 *     tags={"Local Imagem"},
 *     summary="Adiciona uma imagem a um local",
 *     requestBody=@OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id_local", "imagem"},
 *             @OA\Property(property="id_local", type="integer"),
 *             @OA\Property(property="imagem", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Imagem adicionada com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(
 *                 property="imagem",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="id_local", type="integer"),
 *                 @OA\Property(property="imagem", type="string"),
 *                 @OA\Property(property="ativo", type="boolean"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     )
 * )
 * @OA\Delete(
 *     path="/api/local-imagem/{localImagem}",
 *     tags={"Local Imagem"},
 *     summary="Desativa uma imagem de um local (exclusão lógica)",
 *     @OA\Response(
 *         response=200,
 *         description="Imagem desativada com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

class LocalImagemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Local $local)
    {
        // Buscar apenas imagens ativas
        $imagens = $local->imagens()->where('ativo', true)->get();

        if ($imagens->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "Nenhuma imagem encontrada para este local."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "imagens"  => $imagens
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocalImagemRequest $request)
    {
        $validated = $request->validated();

        $imagem = LocalImagem::create([
            "id_local" => $validated["id_local"],
            "imagem" => $validated["imagem"],
            "ativo" => true,
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Imagem adicionada com sucesso!",
            'imagem' => $imagem
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocalImagem $localImagem)
    {
        // Exclusão lógica - apenas desativa a imagem
        $localImagem->ativo = false;
        $localImagem->save();

        return response()->json([
            'status'  => true,
            'message' => "Imagem desativada com sucesso!"
        ], 200);
    }

    /**
     * Serve uma imagem específica como arquivo de imagem
     */
    public function show(LocalImagem $localImagem)
    {
        if (!$localImagem->ativo) {
            return response()->json([
                'success' => false,
                'message' => 'Imagem não encontrada'
            ], 404);
        }

        // Extrair o tipo MIME e dados da string Base64
        $imageData = $localImagem->imagem;
        
        // Se a imagem já está em formato data:image/..., extrair os dados
        if (strpos($imageData, 'data:') === 0) {
            $parts = explode(',', $imageData);
            $imageData = $parts[1] ?? $imageData;
        }

        // Decodificar Base64
        $decodedImage = base64_decode($imageData);
        
        // Determinar o tipo MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $decodedImage);
        finfo_close($finfo);

        // Se não conseguir determinar o tipo MIME, usar JPEG como padrão
        if (!$mimeType || $mimeType === 'application/octet-stream') {
            $mimeType = 'image/jpeg';
        }

        return response($decodedImage)
            ->header('Content-Type', $mimeType)
            ->header('Cache-Control', 'public, max-age=31536000'); // Cache por 1 ano
    }
}
