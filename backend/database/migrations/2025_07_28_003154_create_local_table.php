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
        Schema::create('local', function (Blueprint $table) {
            $table->id();
            $table->string("nome")->nullable(false);
            $table->string("cidade")->nullable(false);
            $table->string("estado")->nullable(false);
            $table->string("nome_proprietario")->nullable(false);
            $table->string("telefone_proprietario")->nullable(false);
            $table->text("descricao")->nullable();
            $table->integer("capacidade_pessoas")->nullable(false);
            $table->foreignId("id_usuario_criacao")
                  ->constrained("usuario");
            $table->timestamps();
            $table->foreignId("id_usuario_alteracao")
                  ->nullable()
                  ->constrained("usuario");
            $table->boolean("ativo")->nullable(false)->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local');
    }
};
