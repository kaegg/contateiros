<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Atividade;
use App\Models\Instalacao;
use App\Models\Usuario;

class CheckDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica se há dados necessários no banco';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando dados no banco...');

        // Verificar usuários
        $usuarios = Usuario::count();
        $this->info("Usuários encontrados: {$usuarios}");

        // Verificar atividades
        $atividades = Atividade::where('ativo', true)->count();
        $this->info("Atividades ativas encontradas: {$atividades}");

        if ($atividades > 0) {
            $atividadesList = Atividade::where('ativo', true)->get(['id', 'nome']);
            foreach ($atividadesList as $atividade) {
                $this->line("  - ID: {$atividade->id}, Nome: {$atividade->nome}");
            }
        }

        // Verificar instalações
        $instalacoes = Instalacao::where('ativo', true)->count();
        $this->info("Instalações ativas encontradas: {$instalacoes}");

        if ($instalacoes > 0) {
            $instalacoesList = Instalacao::where('ativo', true)->get(['id', 'nome']);
            foreach ($instalacoesList as $instalacao) {
                $this->line("  - ID: {$instalacao->id}, Nome: {$instalacao->nome}");
            }
        }

        if ($usuarios == 0) {
            $this->error('Nenhum usuário encontrado! Execute o seeder de usuários.');
        }

        if ($atividades == 0) {
            $this->error('Nenhuma atividade encontrada! Execute o seeder de atividades.');
        }

        if ($instalacoes == 0) {
            $this->error('Nenhuma instalação encontrada! Execute o seeder de instalações.');
        }

        return 0;
    }
} 