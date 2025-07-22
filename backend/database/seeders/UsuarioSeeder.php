<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuario')->insert([
            ['nome' => 'Raphael Ichiro', 'usuario' => 'ichiro', 'email' => 'raphael@contateiros.com.br', 'telefone' => '44999999999', 'id_funcao' => 2, 'id_secao' => 1, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Henrique Maeda	', 'usuario' => 'maeda', 'email' => 'henrique@contateiros.com.br', 'telefone' => '44666666666', 'id_funcao' => 2, 'id_secao' => 2, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Leonardo Almenara', 'usuario' => 'leonardo', 'email' => 'leo_pereira@contateiros.com.br', 'telefone' => '44333333333', 'id_funcao' => 2, 'id_secao' => 3, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Kauan Eguchi', 'usuario' => 'kaegg', 'email' => 'kaegg@contateiros.com.br', 'telefone' => '44777777777', 'id_funcao' => 2, 'id_secao' => 4, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Admin', 'usuario' => 'admin', 'email' => 'admin@contateiros.com.br', 'telefone' => '44888888888', 'id_funcao' => 1, 'id_secao' => 1, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Kauan Eguchi teste', 'usuario' => 'kauegg', 'email' => 'kaegueza@contateiros.com.br', 'telefone' => '44999999999', 'id_funcao' => 2, 'id_secao' => 1, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
