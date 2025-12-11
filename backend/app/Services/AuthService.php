<?php

namespace App\Services;

use App\Repositories\UsuarioRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected UsuarioRepository $repo;

    public function __construct(UsuarioRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Validate credentials. Returns user on success, null on failure.
     */
    public function validateCredentials(string $identifier, string $password)
    {
        $user = $this->repo->findByEmailOrUsuario($identifier);

        if (!$user) {
            // Do not reveal whether user exists — return null
            return null;
        }

        if (Hash::check($password, $user->password)) {
            return $user;
        }

        return null;
    }
}
