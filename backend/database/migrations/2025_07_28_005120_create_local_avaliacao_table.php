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
        Schema::create('local_avaliacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_local")
                  ->constrained("local")
                  ->onDelete('cascade');
            $table->foreignId("id_usuario")
                  ->constrained("usuario")
                  ->onDelete('cascade');
            $table->integer("avaliacao")->nullable(false); // Pontuação da avaliação
            $table->text("comentario")->nullable(); // Comentário da avaliação
            $table->boolean("ativo")->nullable(false)->default(true);
            $table->timestamps();
            
            // Índice único para evitar múltiplas avaliações do mesmo usuário no mesmo local
            $table->unique(['id_local', 'id_usuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_avaliacao');
    }
};
