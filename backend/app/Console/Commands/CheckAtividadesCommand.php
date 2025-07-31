<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Atividade;

class CheckAtividadesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:atividades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica as atividades no banco de dados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando atividades no banco de dados...');
        
        $atividades = Atividade::all();
        
        if ($atividades->isEmpty()) {
            $this->warn('Nenhuma atividade encontrada no banco!');
            return;
        }
        
        $this->info('Atividades encontradas:');
        
        foreach ($atividades as $atividade) {
            $this->line("ID: {$atividade->id}");
            $this->line("Nome: {$atividade->nome}");
            $this->line("Código: {$atividade->codigo}");
            $this->line("Ícone: {$atividade->icone}");
            $this->line("Ativo: " . ($atividade->ativo ? 'Sim' : 'Não'));
            $this->line("---");
        }
        
        $this->info('Total de atividades: ' . $atividades->count());
    }
} 