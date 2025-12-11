<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['nome' => 'Raphael Ichiro', 'usuario' => 'ichiro', 'email' => 'raphael@contateiros.com.br', 'telefone' => '44999999999', 'id_funcao' => 2, 'id_secao' => 1, 'ativo' => true],
            ['nome' => 'Henrique Maeda', 'usuario' => 'maeda', 'email' => 'henrique@contateiros.com.br', 'telefone' => '44666666666', 'id_funcao' => 2, 'id_secao' => 2, 'ativo' => true],
            ['nome' => 'Leonardo Almenara', 'usuario' => 'leonardo', 'email' => 'leo_pereira@contateiros.com.br', 'telefone' => '44333333333', 'id_funcao' => 2, 'id_secao' => 3, 'ativo' => true],
            ['nome' => 'Kauan Eguchi', 'usuario' => 'kaegg', 'email' => 'kaegg@contateiros.com.br', 'telefone' => '44777777777', 'id_funcao' => 2, 'id_secao' => 4, 'ativo' => true],
            ['nome' => 'Admin', 'usuario' => 'admin', 'email' => 'admin@contateiros.com.br', 'telefone' => '44888888888', 'id_funcao' => 1, 'id_secao' => 1, 'ativo' => true],
            ['nome' => 'Kauan Eguchi teste', 'usuario' => 'kauegg', 'email' => 'kaegueza@contateiros.com.br', 'telefone' => '44999999999', 'id_funcao' => 2, 'id_secao' => 1, 'ativo' => true],
        ];

        $now = now();

        foreach ($users as $u) {
            $u['created_at'] = $now;
            $u['updated_at'] = $now;
            // Default password for seeded users (useful for testing). Admin uses TEST_ADMIN_PASSWORD env.
            $u['password'] = Hash::make('senha-segura');
            DB::table('usuario')->insert($u);
        }
    }
}
