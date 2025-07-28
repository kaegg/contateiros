<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Local;
use App\Models\Atividade;
use App\Models\Instalacao;
use App\Models\LocalAtividade;
use App\Models\LocalInstalacao;
use App\Models\LocalAvaliacao;
use App\Models\Usuario;

class LocalRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locais = Local::where('ativo', true)->get();
        $atividades = Atividade::where('ativo', true)->get();
        $instalacoes = Instalacao::where('ativo', true)->get();
        $usuarios = Usuario::where('ativo', true)->get();

        if ($locais->isEmpty() || $atividades->isEmpty() || $instalacoes->isEmpty() || $usuarios->isEmpty()) {
            $this->command->info('Dados básicos não encontrados. Execute os seeders anteriores primeiro.');
            return;
        }

        // Associar atividades aos locais
        foreach ($locais as $local) {
            // Associar 2-3 atividades aleatórias a cada local
            $atividadesAleatorias = $atividades->random(rand(2, 3));
            
            foreach ($atividadesAleatorias as $atividade) {
                LocalAtividade::updateOrCreate(
                    [
                        'id_local' => $local->id,
                        'id_atividade' => $atividade->id,
                    ],
                    [
                        'ativo' => true,
                    ]
                );
            }
        }

        // Associar instalações aos locais
        foreach ($locais as $local) {
            // Associar 3-4 instalações aleatórias a cada local
            $instalacoesAleatorias = $instalacoes->random(rand(3, 4));
            
            foreach ($instalacoesAleatorias as $instalacao) {
                LocalInstalacao::updateOrCreate(
                    [
                        'id_local' => $local->id,
                        'id_instalacao' => $instalacao->id,
                    ],
                    [
                        'ativo' => true,
                    ]
                );
            }
        }

        // Criar avaliações para os locais
        foreach ($locais as $local) {
            // Criar 1-3 avaliações por local
            $numAvaliacoes = rand(1, 3);
            $usuariosAleatorios = $usuarios->random($numAvaliacoes);
            
            foreach ($usuariosAleatorios as $usuario) {
                LocalAvaliacao::updateOrCreate(
                    [
                        'id_local' => $local->id,
                        'id_usuario' => $usuario->id,
                    ],
                    [
                        'avaliacao' => rand(3, 5), // Avaliação entre 3 e 5 estrelas
                        'comentario' => $this->getComentarioAleatorio(),
                        'ativo' => true,
                    ]
                );
            }
        }

        $this->command->info('Relacionamentos entre locais, atividades, instalações e avaliações criados com sucesso!');
    }

    private function getComentarioAleatorio(): string
    {
        $comentarios = [
            'Excelente local! Muito bem equipado e organizado.',
            'Local muito bonito e funcional. Recomendo!',
            'Ótima estrutura para eventos e reuniões.',
            'Ambiente agradável e bem localizado.',
            'Instalações de primeira qualidade.',
            'Local perfeito para nossas atividades.',
            'Muito satisfeito com o serviço oferecido.',
            'Estrutura completa e bem mantida.',
            'Local ideal para eventos corporativos.',
            'Excelente atendimento e infraestrutura.',
        ];

        return $comentarios[array_rand($comentarios)];
    }
} 