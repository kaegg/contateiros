<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Repositories\UsuarioRepository;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'senha' => 'required|string',
        ]);

        // Support different field names from frontend: identifier, usuario or email
        $identifier = $request->input('identifier') ?? $request->input('usuario') ?? $request->input('email');

        if (!$identifier) {
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        $user = $this->authService->validateCredentials($identifier, $data['senha']);

        if (!$user) {
            // Generic message to avoid revealing whether user exists
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        // Regenerate session ID to prevent fixation
        $request->session()->regenerate();

        $request->session()->put('user_id', $user->id);

        // Return user data along with success message
        return response()->json([
            'message' => 'Autenticado com sucesso.',
            'id' => $user->id,
            'nome' => $user->nome,
            'usuario' => $user->usuario,
            'email' => $user->email,
            'telefone' => $user->telefone,
            'ativo' => $user->ativo,
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout efetuado com sucesso.']);
    }

    /**
     * Get the authenticated user info
     * Returns 401 if not authenticated
     */
    public function me(Request $request)
    {
        $userId = $request->session()->get('user_id');

        if (!$userId) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        $repo = new UsuarioRepository();
        $user = $repo->findById($userId);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 401);
        }

        return response()->json($user);
    }
}
