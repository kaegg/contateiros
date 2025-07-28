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
                'descricao' => 'Banheiros masculino e feminino',
                'ativo' => true,
            ],
            [
                'nome' => 'Energia',
                'codigo' => 'ENERGIA',
                'descricao' => 'Fornecimento de energia elétrica',
                'ativo' => true,
            ],
            [
                'nome' => 'Internet',
                'codigo' => 'INTERNET',
                'descricao' => 'Conexão com internet Wi-Fi',
                'ativo' => true,
            ],
            [
                'nome' => 'Rede Celular',
                'codigo' => 'REDE_CELULAR',
                'descricao' => 'Cobertura de rede celular',
                'ativo' => true,
            ],
            [
                'nome' => 'Estacionamento',
                'codigo' => 'ESTACIONAMENTO',
                'descricao' => 'Área para estacionamento de veículos',
                'ativo' => true,
            ],
            [
                'nome' => 'Cozinha',
                'codigo' => 'COZINHA',
                'descricao' => 'Cozinha equipada para preparo de refeições',
                'ativo' => true,
            ],
            [
                'nome' => 'Refeitório',
                'codigo' => 'REFEITORIO',
                'descricao' => 'Área para refeições',
                'ativo' => true,
            ],
            [
                'nome' => 'Churrasqueira',
                'codigo' => 'CHURRASQUEIRA',
                'descricao' => 'Churrasqueira para preparo de churrasco',
                'ativo' => true,
            ],
            [
                'nome' => 'Piscina',
                'codigo' => 'PISCINA',
                'descricao' => 'Piscina para recreação',
                'ativo' => true,
            ],
            [
                'nome' => 'Quadra Esportiva',
                'codigo' => 'QUADRA_ESPORTIVA',
                'descricao' => 'Quadra para atividades esportivas',
                'ativo' => true,
            ],
            [
                'nome' => 'Campo de Futebol',
                'codigo' => 'CAMPO_FUTEBOL',
                'descricao' => 'Campo de futebol',
                'ativo' => true,
            ],
            [
                'nome' => 'Sala de Reunião',
                'codigo' => 'SALA_REUNIAO',
                'descricao' => 'Sala equipada para reuniões',
                'ativo' => true,
            ],
            [
                'nome' => 'Auditório',
                'codigo' => 'AUDITORIO',
                'descricao' => 'Auditório para eventos e apresentações',
                'ativo' => true,
            ],
            [
                'nome' => 'Projetor',
                'codigo' => 'PROJETOR',
                'descricao' => 'Projetor para apresentações',
                'ativo' => true,
            ],
            [
                'nome' => 'Sistema de Som',
                'codigo' => 'SISTEMA_SOM',
                'descricao' => 'Sistema de som para eventos',
                'ativo' => true,
            ],
            [
                'nome' => 'Iluminação',
                'codigo' => 'ILUMINACAO',
                'descricao' => 'Iluminação adequada para atividades',
                'ativo' => true,
            ],
            [
                'nome' => 'Segurança',
                'codigo' => 'SEGURANCA',
                'descricao' => 'Serviços de segurança',
                'ativo' => true,
            ],
            [
                'nome' => 'Primeiros Socorros',
                'codigo' => 'PRIMEIROS_SOCORROS',
                'descricao' => 'Kit de primeiros socorros',
                'ativo' => true,
            ],
            [
                'nome' => 'Área de Camping',
                'codigo' => 'AREA_CAMPING',
                'descricao' => 'Área específica para camping',
                'ativo' => true,
            ],
            [
                'nome' => 'Trilhas',
                'codigo' => 'TRILHAS',
                'descricao' => 'Trilhas para caminhadas',
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