<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('secao')->insert([
            ['nome' => 'Seção 1', 'ativo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Seção 2', 'ativo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Seção 3', 'ativo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Seção 4', 'ativo' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
