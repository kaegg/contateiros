<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Atividade;

class AtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $atividades = [
            [
                'nome' => 'Jornada',
                'codigo' => 'JORNADA',
                'descricao' => 'Atividades de jornada e expedições',
                'icone' => 'pi pi-users',
                'ativo' => true,
            ],
            [
                'nome' => 'Acampamento',
                'codigo' => 'ACAMPAMENTO',
                'descricao' => 'Atividades de acampamento e camping',
                'icone' => 'pi pi-home',
                'ativo' => true,
            ],
            [
                'nome' => 'Day Use',
                'codigo' => 'DAY_USE',
                'descricao' => 'Uso diário do local para atividades',
                'icone' => 'pi pi-sun',
                'ativo' => true,
            ],
            [
                'nome' => 'Trilhas',
                'codigo' => 'TRILHAS',
                'descricao' => 'Atividades de trilhas e caminhadas',
                'icone' => 'pi pi-compass',
                'ativo' => true,
            ],
            [
                'nome' => 'Eventos',
                'codigo' => 'EVENTOS',
                'descricao' => 'Organização de eventos e festivais',
                'icone' => 'pi pi-calendar',
                'ativo' => true,
            ],
            [
                'nome' => 'Futebol',
                'codigo' => 'FUTEBOL',
                'descricao' => 'Atividades esportivas de futebol',
                'icone' => 'pi pi-compass',
                'ativo' => true,
            ],
            [
                'nome' => 'Reuniões',
                'codigo' => 'REUNIOES',
                'descricao' => 'Reuniões corporativas e encontros',
                'icone' => 'pi pi-users',
                'ativo' => true,
            ],
            [
                'nome' => 'Treinamentos',
                'codigo' => 'TREINAMENTOS',
                'descricao' => 'Cursos e treinamentos',
                'icone' => 'pi pi-calendar',
                'ativo' => true,
            ],
        ];

        foreach ($atividades as $atividade) {
            Atividade::updateOrCreate(
                ['codigo' => $atividade['codigo']],
                $atividade
            );
        }

        $this->command->info('Atividades criadas com sucesso!');
    }
} 