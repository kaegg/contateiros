<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Local;
use App\Models\Usuario;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar um usuário existente para usar como criador
        $usuario = Usuario::first();
        
        if (!$usuario) {
            // Se não houver usuário, criar um
            $usuario = Usuario::create([
                'nome' => 'Administrador',
                'usuario' => 'admin',
                'email' => 'admin@example.com',
                'telefone' => '+5541999999999',
                'id_funcao' => 1,
                'id_secao' => 1,
                'ativo' => true,
            ]);
        }

        $locais = [
            [
                'nome' => 'Sala de Reuniões Principal',
                'cidade' => 'Curitiba',
                'estado' => 'PR',
                'nome_proprietario' => 'João Silva',
                'telefone_proprietario' => '+5541999999999',
                'descricao' => 'Sala equipada para reuniões com projetor e sistema de áudio',
                'capacidade_pessoas' => 30,
                'id_usuario_criacao' => $usuario->id,
                'ativo' => true,
            ],
            [
                'nome' => 'Auditório Central',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'nome_proprietario' => 'Maria Santos',
                'telefone_proprietario' => '+5511999999999',
                'descricao' => 'Auditório com capacidade para eventos grandes',
                'capacidade_pessoas' => 150,
                'id_usuario_criacao' => $usuario->id,
                'ativo' => true,
            ],
            [
                'nome' => 'Sala de Treinamento',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
                'nome_proprietario' => 'Pedro Costa',
                'telefone_proprietario' => '+5521999999999',
                'descricao' => 'Sala ideal para treinamentos e workshops',
                'capacidade_pessoas' => 25,
                'id_usuario_criacao' => $usuario->id,
                'ativo' => true,
            ],
            [
                'nome' => 'Espaço de Eventos',
                'cidade' => 'Belo Horizonte',
                'estado' => 'MG',
                'nome_proprietario' => 'Ana Oliveira',
                'telefone_proprietario' => '+5531999999999',
                'descricao' => 'Espaço versátil para diversos tipos de eventos',
                'capacidade_pessoas' => 80,
                'id_usuario_criacao' => $usuario->id,
                'ativo' => true,
            ],
            [
                'nome' => 'Sala de Conferência',
                'cidade' => 'Porto Alegre',
                'estado' => 'RS',
                'nome_proprietario' => 'Carlos Ferreira',
                'telefone_proprietario' => '+5551999999999',
                'descricao' => 'Sala moderna para conferências e apresentações',
                'capacidade_pessoas' => 50,
                'id_usuario_criacao' => $usuario->id,
                'ativo' => true,
            ],
        ];

        foreach ($locais as $local) {
            Local::create($local);
        }
    }
}
