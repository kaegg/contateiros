<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Instalacao;

class InstalacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instalacoes = [
            [
                'nome' => 'Banheiro',
                'codigo' => 'BANHEIRO',
                'ativo' => true,
            ],
            [
                'nome' => 'Energia',
                'codigo' => 'ENERGIA',
                'ativo' => true,
            ],
            [
                'nome' => 'Internet',
                'codigo' => 'INTERNET',
                'ativo' => true,
            ],
            [
                'nome' => 'Rede Celular',
                'codigo' => 'REDE_CEL',
                'ativo' => true,
            ],
            [
                'nome' => 'Estacionamento',
                'codigo' => 'ESTACIONA',
                'ativo' => true,
            ],
            [
                'nome' => 'Cozinha',
                'codigo' => 'COZINHA',
                'ativo' => true,
            ],
            [
                'nome' => 'Refeitório',
                'codigo' => 'REFEITORIO',
                'ativo' => true,
            ],
            [
                'nome' => 'Churrasqueira',
                'codigo' => 'CHURRAS',
                'ativo' => true,
            ],
            [
                'nome' => 'Piscina',
                'codigo' => 'PISCINA',
                'ativo' => true,
            ],
            [
                'nome' => 'Quadra Esportiva',
                'codigo' => 'QUADRA',
                'ativo' => true,
            ],
            [
                'nome' => 'Campo de Futebol',
                'codigo' => 'CAMPO_FUT',
                'ativo' => true,
            ],
            [
                'nome' => 'Sala de Reunião',
                'codigo' => 'SALA_REUNI',
                'ativo' => true,
            ],
            [
                'nome' => 'Auditório',
                'codigo' => 'AUDITORIO',
                'ativo' => true,
            ],
            [
                'nome' => 'Projetor',
                'codigo' => 'PROJETOR',
                'ativo' => true,
            ],
            [
                'nome' => 'Sistema de Som',
                'codigo' => 'SIS_SOM',
                'ativo' => true,
            ],
            [
                'nome' => 'Iluminação',
                'codigo' => 'ILUMINACAO',
                'ativo' => true,
            ],
            [
                'nome' => 'Segurança',
                'codigo' => 'SEGURANCA',
                'ativo' => true,
            ],
            [
                'nome' => 'Primeiros Socorros',
                'codigo' => 'SOS',
                'ativo' => true,
            ],
            [
                'nome' => 'Área de Camping',
                'codigo' => 'CAMPING',
                'ativo' => true,
            ],
            [
                'nome' => 'Trilhas',
                'codigo' => 'TRILHAS',
                'ativo' => true,
            ],
        ];

        foreach ($instalacoes as $instalacao) {
            Instalacao::updateOrCreate(
                ['codigo' => $instalacao['codigo']],
                $instalacao
            );
        }

        $this->command->info('Instalações criadas com sucesso!');
    }
} 