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
        // Criar ícones base64 simples (SVG inline)
        $icones = [
            'users' => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="m22 21-2-2"></path><path d="M16 16.28A13.84 13.84 0 0 1 22 21"></path></svg>'),
            'home' => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9,22 9,12 15,12 15,22"></polyline></svg>'),
            'sun' => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>'),
            'compass' => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>'),
            'calendar' => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>'),
        ];

        $atividades = [
            [
                'nome' => 'Jornada',
                'codigo' => 'JORNADA',
                'icone' => $icones['users'],
                'ativo' => true,
            ],
            [
                'nome' => 'Acampamento',
                'codigo' => 'ACAMPAMENTO',
                'icone' => $icones['home'],
                'ativo' => true,
            ],
            [
                'nome' => 'Day Use',
                'codigo' => 'DAY_USE',
                'icone' => $icones['sun'],
                'ativo' => true,
            ],
            [
                'nome' => 'Trilhas',
                'codigo' => 'TRILHAS',
                'icone' => $icones['compass'],
                'ativo' => true,
            ],
            [
                'nome' => 'Eventos',
                'codigo' => 'EVENTOS',
                'icone' => $icones['calendar'],
                'ativo' => true,
            ],
            [
                'nome' => 'Futebol',
                'codigo' => 'FUTEBOL',
                'icone' => $icones['compass'],
                'ativo' => true,
            ],
            [
                'nome' => 'Reuniões',
                'codigo' => 'REUNIOES',
                'icone' => $icones['users'],
                'ativo' => true,
            ],
            [
                'nome' => 'Treinamentos',
                'codigo' => 'TREINAMENTOS',
                'icone' => $icones['calendar'],
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