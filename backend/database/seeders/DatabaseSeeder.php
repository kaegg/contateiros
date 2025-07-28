<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            SecaoSeeder::class,
            FuncaoSeeder::class,
            UsuarioSeeder::class,
            AtividadeSeeder::class,
            InstalacaoSeeder::class,
            LocalSeeder::class,
            LocalImagemSeeder::class,
            LocalRelationsSeeder::class,
        ]);
    }
}
