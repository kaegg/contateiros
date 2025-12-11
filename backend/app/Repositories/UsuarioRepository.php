<?php

namespace App\Repositories;

use App\Models\Usuario;

class UsuarioRepository
{
    public function findByEmailOrUsuario(string $identifier): ?Usuario
    {
        return Usuario::where('email', $identifier)
                      ->orWhere('usuario', $identifier)
                      ->first();
    }

    public function findById(int $id): ?Usuario
    {
        return Usuario::find($id);
    }
}
