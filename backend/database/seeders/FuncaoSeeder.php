<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        DB::table('funcao')->insert([
            ['nome' => 'Diretor'          , 'ativo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Chefe de seção'   , 'ativo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Ajudante de seção', 'ativo' => true,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
