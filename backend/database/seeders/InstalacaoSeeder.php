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
                'codigo' => 'REDE_CELULAR',
                'ativo' => true,
            ],
            [
                'nome' => 'Estacionamento',
                'codigo' => 'ESTACIONAMENTO',
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
                'codigo' => 'CHURRASQUEIRA',
                'ativo' => true,
            ],
            [
                'nome' => 'Piscina',
                'codigo' => 'PISCINA',
                'ativo' => true,
            ],
            [
                'nome' => 'Quadra Esportiva',
                'codigo' => 'QUADRA_ESPORTIVA',
                'ativo' => true,
            ],
            [
                'nome' => 'Campo de Futebol',
                'codigo' => 'CAMPO_FUTEBOL',
                'ativo' => true,
            ],
            [
                'nome' => 'Sala de Reunião',
                'codigo' => 'SALA_REUNIAO',
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
                'codigo' => 'SISTEMA_SOM',
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
                'codigo' => 'PRIMEIROS_SOCORROS',
                'ativo' => true,
            ],
            [
                'nome' => 'Área de Camping',
                'codigo' => 'AREA_CAMPING',
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