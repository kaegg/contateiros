<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('local_instalacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_local")
                  ->constrained("local")
                  ->onDelete('cascade');
            $table->foreignId("id_instalacao")
                  ->constrained("instalacao")
                  ->onDelete('cascade');
            $table->boolean("ativo")->nullable(false)->default(true);
            $table->timestamps();
            
            // Índice único para evitar duplicatas
            $table->unique(['id_local', 'id_instalacao']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_instalacao');
    }
};
